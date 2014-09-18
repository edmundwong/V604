<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

if(empty($_G['uid']) ) {	showmessage($_lang['login'],'',array(),array('login' => true));}

$goods_id = intval($_GET['goods_id']);
$op = !empty($_GET['op']) ? addslashes($_GET['op']) : 'post';
$uid = $_G['uid'];

$goods = fetch_all('gongqiu_goods'," WHERE goods_id='{$goods_id}'");
$goods = $goods[0];
$goods['goods_text'] =  stripslashes($goods['goods_text']);

$cat = fetch_all("gongqiu_cat"," WHERE cat_status='1' ORDER BY cat_sort DESC ");

if($op =='edit'){
	if($goods['member_uid'] !=$_G['uid'] && !is_gongqiu_admin()){
		showmessage($_lang['no_quanxian']);
	}else{
		$uid = $goods['member_uid'];
	}
}

$member = fetch_all('gongqiu_member'," WHERE member_uid='{$uid}'");
$member = $member[0];

$my_credit = fetch_all("common_member_count"," WHERE uid='{$uid}'"," extcredits{$gongqiu_config['extcredits']} ","0");
$my_credit = $my_credit["extcredits{$gongqiu_config['extcredits']}"];

if(submitcheck('post_submit') || submitcheck('edit_submit')){
	
	if(empty($_GET['province']) && $op=='post'){
		showmessage($_lang['must_province']);
	}
	if(empty($_GET['goods_text'])){
		showmessage($_lang['must_goods_text']);
	}
	if(empty($_GET['member_username'])){
		showmessage($_lang['must_member_username']);
	}
	if(empty($_GET['member_phone'])){
		showmessage($_lang['must_member_phone']);
	}

	/* begin:发布积分消费	*/
	if($op=='post'){
		$new_credit = $my_credit - $gongqiu_config['postcredit'];
		if($new_credit <0){
			showmessage($_lang['post'].$gongqiu_config['credit_unit'].$_lang['not_credit']);
		}else{
			DB::query("UPDATE ".DB::table('common_member_count')." SET extcredits{$gongqiu_config['extcredits']}='{$new_credit}' WHERE uid='{$_G['uid']}'");
		}
	}
	/* end:发布积分消费	*/
	
	$goods = gpc('goods_');
	$_member = gpc('member_');
	if($op=='post'){
		$_member['member_uid'] = $_G['uid'];
	}
	
	if($goods['goods_settime'] != 0){
		if($goods['goods_settime'] == 7){
			$goods['goods_settime'] = strtotime("+7 days");
		}elseif($goods['goods_settime'] == 30){
			$goods['goods_settime'] = strtotime("+30 days");
		}elseif($goods['goods_settime'] == 90){
			$goods['goods_settime'] = strtotime("+90 days");
		}elseif($goods['goods_settime'] == 180){
			$goods['goods_settime'] = strtotime("+180 days");
		}
	}else{
		$goods['goods_settime'] = 0;
	}
	
	if($op=='post'){
		$goods['goods_ip'] = $_G['clientip'];
		$ip_xml = file_get_contents("http://www.youdao.com/smartresult-xml/search.s?type=ip&q={$goods['goods_ip']}");
		preg_match_all("/<location>(.*?)<\/location>/i",$ip_xml,$m);
		$goods['goods_ip_adr'] = $m[1][0];
	}
	
	$goods_array = $goods;
	/* begin:cat+subcat */
	if( !empty($_GET['cat'])){
		list($goods_array['cat_id'],$goods_array['cat_title']) = explode('-', addslashes($_GET['cat']));
	}
	
	if( !empty($_GET['subcat'])){
		list($goods_array['subcat_id'],$goods_array['subcat_title']) = explode('-',addslashes($_GET['subcat']));       
	}
	/* end:cat+subcat */
	
	if(!empty($_GET['province'])){
		$goods_array['province'] = daddslashes($_GET['province']) ; 
		$goods_array['city'] = daddslashes($_GET['city']) ; 
		$goods_array['dist'] = daddslashes($_GET['dist']) ; 
		$goods_array['community'] = daddslashes($_GET['community']) ; 
	}
	
	if($op =='post'){
		$goods_array['member_uid'] = $_member['member_uid'];
		$goods_array['member_username'] = $_member['member_username'];
	}
	
	if($op =='post'){
		if($member['member_uid']){
			DB::update('gongqiu_member',$_member,"member_uid='{$_member['member_uid']}'");
		}else{
			DB::insert('gongqiu_member',$_member);
		}
	}
	
	require_once DISCUZ_ROOT.'./source/plugin/gongqiu/include/update_class.func.php';
	$goods_upload_file_array = array('goods_upload_file_1','goods_upload_file_2','goods_upload_file_3','goods_upload_file_4');
	foreach($goods_upload_file_array as $file_name){
		if($_FILES[$file_name]['size']){
			@$goods_array[$file_name] = upload_file($file_name,'gongqiu');
		}
	}
	$goods_array['goods_time'] = time();
	
	if($gongqiu_config['auto_pass']){
		$goods_array['goods_status']='1';
	}else{
		$goods_array['goods_status']='0';
	}

	if($op =='post'){
		$goods_id = DB::insert('gongqiu_goods',$goods_array,$goods_id = true);
		showmessage($_lang['post_ok'],$gongqiu_config['root']."?mod=view&goods_id={$goods_id}");
	}elseif($op =='edit'){
		DB::update('gongqiu_goods',$goods_array,"goods_id='{$goods_id}'");
		showmessage($_lang['edit_ok'],$gongqiu_config['root']."?mod=view&goods_id={$goods_id}");
	}
}

$navtitle = $_lang['post'].' - '.$gongqiu_config['name'];
include template("gongqiu:{$style}/post");
?>