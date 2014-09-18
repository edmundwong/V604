<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
include_once 'language.'.currentlang().'.php';
$action = $_GET['action'];
if($action == 'getlocal') {
	$lid = intval($_GET['lid']);
	$show = '';
	if($lid) {
		$subid = DB::result_first("SELECT subid FROM ".DB::table('forum_alliance_fl')." WHERE id='{$lid}' ORDER BY displayorder ASC");
		if($subid) {
			$show = '<select class="ps" name="local_2">';
			$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE id IN ({$subid}) ORDER BY displayorder ASC");
			while($row = DB::fetch($query)) {
				$show .= '<option value="'.$row['id'].'">'.$row['subject'].'</option>';
			}
			$show .= '</select>';
		} else {
			$show = '';
		}
		include template("dz55625_haodian:select");
	}
}

if($action == 'getrling') {
	
	$uid = intval($_G['uid']);
	$sid = intval($_GET['sid']);
	$sql = "SELECT * FROM ".DB::table('forum_alliance_rl')." WHERE sid='$sid' AND uid='$uid'";
	$ps = DB::fetch(DB::query($sql));
	if(!submitcheck('applysubrl')){
		if($_G['groupid']==7){
			showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));
		}
	}else{
		if(empty($ps['uid'])){
			$author = addslashes($_G['username']);
			$subject = addslashes($_GET['subject']);
			$display = intval($displays) == 1 ? 1 : 0; 
			$timestamp = $_G['timestamp'];
			DB::insert('forum_alliance_rl',array('id' => '', 'sid' => $sid, 'uid' => $uid, 'author' => $author, 'subject' => $subject, 'display' => $display, 'dateline' => $timestamp));
			showmessage($php_lang['tijiaosher'], dreferer(), array(), array('locationtime'=>2, 'showdialog'=>1, 'showmsg' => true, 'closetime' => 2));
		}else{
			showmessage($php_lang['qwuchongfu'], dreferer(), array(), array('locationtime'=>2, 'showdialog'=>1, 'showmsg' => true, 'closetime' => 2));
		}
	}
	
	include template('dz55625_haodian:renling');
}

if($action == 'ercode') {
	include_once 'haodian_code.php';
	if(!isset($_G['cache']['plugin'])){ loadcache('plugin'); }
	@extract($_G['cache']['plugin']['dz55625_haodian']);
	$curls = '?id=dz55625_haodian:haodian&mod=view&sid=';
	
	$sid = intval($_GET['sid']);
	if($RewriteStart == 1){
		$value = 'http://'.$_SERVER['HTTP_HOST'].'/haodian_'.$sid.'.html';
	}else{
		$value = 'http://'.$_SERVER['HTTP_HOST'].'/plugin.php?id=dz55625_haodian:haodian&mod=view&sid='.$sid;
	}
	$errorCorrectionLevel = "L";
	$matrixPointSize = "6";
	QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize);
}


?>