<?php
/**
 *      ��Ȩ����: �ó���Ϊ [DiscuzCMS!] ������������, ����ӵ�иò�Ʒ֪ʶ��Ȩ,���д����Ȩ��[DiscuzCMS!]����, �����ھ�Ϊ��ҵ����, ��Ϊ�������ṩʹ����Ȩ.
 *		��������: δ���ٷ���Ȩʹ���޸Ļ��ߴ�������������Ȩ��Υ����Ϊ, ������׷��һ����ط�������.
 *		�ٷ���վ: http://www.DiscuzCMS.com 
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