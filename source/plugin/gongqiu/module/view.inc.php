<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

$is_gongqiu_admin = is_gongqiu_admin();
$goods_id = daddslashes($_GET['goods_id']);
$goods = fetch_all('gongqiu_goods'," WHERE goods_id='{$goods_id}'");
$goods = $goods[0];
$goods['goods_text'] = stripslashes($goods['goods_text']);

if(empty($goods['goods_status']) ){
	if( $goods['member_uid'] !=$_G['uid'] && $is_gongqiu_admin ){
		showmessage($_lang['no_quanxian']);
	}
}

$op =getgpc('op');
if($op=='del'){
	if($goods['member_uid']==$_G['uid'] || $is_gongqiu_admin){
		DB::delete('gongqiu_goods'," goods_id='{$goods_id}'  ");
		showmessage($_lang['delete_ok'],$gongqiu_config['root']);
	}else{
		showmessage($_lang['no_quanxian']);
	}
}

$member = fetch_all('gongqiu_member'," WHERE member_uid='{$goods['member_uid']}'");
$member = $member[0];

DB::query("UPDATE ".DB::table('gongqiu_goods')." SET goods_view = `goods_view`+1 WHERE goods_id='{$goods_id}'");

$maybelike = fetch_all('gongqiu_goods'," LIMIT 10 ");
$maybelike_cat = fetch_all('gongqiu_cat'," LIMIT 10");

$navtitle = $goods['goods_title']." - ".$gongqiu_config['name'];
include template("gongqiu:{$style}/view");
?>