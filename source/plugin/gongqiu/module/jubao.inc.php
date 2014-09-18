<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

$goods_id = intval($_GET['goods_id']);

if(submitcheck('submit_jubao')){
	$goods_title = fetch_all('gongqiu_goods'," WHERE goods_id='{$goods_id}'"," goods_title ");
	$goods_title = $goods_title[0]['goods_title'];
	DB::insert('gongqiu_jubao',array('goods_id'=>$goods_id,'goods_title'=>$goods_title,'jubao_time'=>time()));
	$admin_group = unserialize($gongqiu_config['admingroup']);
	$admin_group = dimplode($admin_group);
	$notice_uids = fetch_all('common_member'," WHERE groupid IN ({$admin_group}) OR adminid='1' ",' uid ');
	foreach($notice_uids as $u){
		$notice = array(
				'uid'=>$u['uid'],
				'type'=>'system',
				'new'=>1,
				'note'=>$gongqiu_config['name'].$_lang['note_new_jubao'],
				'dateline'=>time(),
				);
		DB::insert('home_notification',$notice);
		DB::update('common_member',array('newprompt'=>1)," uid='{$u['uid']}'");
	}
	showmessage($_lang['jubao_ok'],$gongqiu_config['root']."?mod=view&goods_id={$goods_id}");
}

$navtitle = $_lang['member']." - ".$gongqiu_config['name'];
include template("gongqiu:{$style}/jubao");
?>