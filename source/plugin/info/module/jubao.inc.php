<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

$goods_id = intval($_GET['goods_id']);




if(submitcheck('submit_jubao')){
	$goods_title = fetch_all('info_goods'," WHERE goods_id='{$goods_id}'"," goods_title ");
	$goods_title = $goods_title[0]['goods_title'];
	DB::insert('info_jubao',array('goods_id'=>$goods_id,'goods_title'=>$goods_title,'jubao_time'=>time()));
	$admin_group = unserialize($info_config['admingroup']);
	$admin_group = dimplode($admin_group);
	$notice_uids = fetch_all('common_member'," WHERE groupid IN ({$admin_group}) OR adminid='1' ",' uid ');
	foreach($notice_uids as $u){
		$notice = $info_config['name']." : ".$info_lang['note_new_jubao'];
		notification_add($u['uid'],'system',$notice);
	}
	showmessage($info_lang['jubao_ok'],$info_config['root']."?mod=view&goods_id={$goods_id}");
}

$navtitle = $info_lang['space']." - ".$info_config['name'];
include template("info:{$style}/jubao");exit;
?>