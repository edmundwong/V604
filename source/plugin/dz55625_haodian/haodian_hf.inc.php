<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

global $_G;
@extract($_G['cache']['plugin']['dz55625_haodian']);
include_once 'language.'.currentlang().'.php';

if($_GET['op'] == 'hf'){
	$id = intval($_GET['sid']);
	$sql = "SELECT * FROM ".DB::table('forum_alliance_pl')." WHERE id='$id'";
	$query = DB::query($sql);
	$pl = $pls = array();
	while($pl = DB::fetch($query)){
		$pls[] = $pl;
	}
	
	if(submitcheck('applysubhf')){
		$id = intval($_GET['xid']);
		$sid = intval($_GET['sid']);
		$nickback = addslashes($_GET['nickback']);
		DB::update('forum_alliance_pl', array('nickback' => $nickback), "id='$id'");
		showmessage($php_lang['huifuokl'], 'plugin.php?id=dz55625_haodian:haodian&mod=view&sid='.$sid, array(), array('alert' => right));

	}
		include template('dz55625_haodian:hf');
		
}
if($_GET['op'] == 'del'){
	$sid = intval($_GET['sid']);
	$did = intval($_GET['did']);
	DB::query("DELETE FROM ".DB::table('forum_alliance_pl')." WHERE id = '$did' ");
	showmessage($php_lang['lshanchuok'], 'plugin.php?id=dz55625_haodian:haodian&mod=view&sid='.$sid, array(), array('alert' => right));

}

?>