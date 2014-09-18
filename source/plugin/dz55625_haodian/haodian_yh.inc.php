<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/discuzcode');
include_once 'language.'.currentlang().'.php';
global $_G;
@extract($_G['cache']['plugin']['dz55625_haodian']);

	$uid = intval($_G['uid']);
	$counts = DB::result_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid = '$uid' AND display!='0' ORDER BY id DESC");
	$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid = '$uid' AND display!='0' ORDER BY dateline DESC";
	$query = DB::query($sql);
	$zuyong = $zuyongs = array();
	while($zuyong = DB::fetch($query)){
		$zuyongs[] = $zuyong;
	}


if($_GET['youhui'] == 'del'){
		$id=intval($_GET['pid']);
		DB::query("DELETE FROM ".DB::table('forum_alliance_yh')." WHERE id ='$id' LIMIT 1 ;");
		showmessage($php_lang['lshanchuok'], "plugin.php?id=dz55625_haodian:haodian_user&p=youhui", array(), array('locationtime'=>2, 'showdialog'=>1, 'showmsg' => true, 'closetime' => 2));
	}
	

if($_GET['action'] == 'yh'){
	if($_GET['youhui'] == 'edit'){
		$id=intval($_GET['pid']);
		$active=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_yh')." WHERE id ='{$id}' LIMIT 0 , 1");
		if(submitcheck('applysubyhs')){
			$id = intval($_GET['newid']);
			$aid = $_GET['dian_id'];
			$title = addslashes($_GET['title']);
			$subject = addslashes($_GET['subject']);
			DB::update('forum_alliance_yh', array('aid' => $aid, 'uid' => $uid, 'title' => $title, 'subject' => $subject), "id='$id'");
			showmessage($php_lang['youhuieditok'], dreferer(), array(), array('locationtime'=>2, 'showdialog'=>1, 'showmsg' => true, 'closetime' => 2));
		}
		include template('dz55625_haodian:yh_edit');
	}
}
if(submitcheck('applysubyh')){

	$timestamp = $_G['timestamp'];
	$aid = $_GET['dian_id'];
	$title = addslashes($_GET['title']);
	$subject = addslashes($_GET['subject']);
	
	DB::query("INSERT INTO ".DB::table('forum_alliance_yh')." ( `id` ,`aid`,`uid`, `title`, `subject`,`dateline` ) VALUES (NULL , '$aid', '$uid', '$title', '$subject','$timestamp');");
	
	showmessage($php_lang['youhuiaddok'], 'plugin.php?id=dz55625_haodian:haodian_user&p=youhui', array(), array('alert' => right));

}

include template('dz55625_haodian:yh');

?>