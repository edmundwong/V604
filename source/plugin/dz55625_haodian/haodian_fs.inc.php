<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

global $_G;
include_once 'language.'.currentlang().'.php';
if(!isset($_G['cache']['plugin'])){ loadcache('plugin'); }
@extract($_G['cache']['plugin']['dz55625_haodian']);
$actionarr = array('mlistinfc','mlistinfa','mlistinfo');
$action = in_array($_GET['action'], $actionarr) ? $_GET['action'] : 'mlistinfc';
$zid = intval($_GET['zid']);
if($RewriteStart == 1){
	$curl = 'haodian';	 
}else{
	$curls = 'plugin.php?id=dz55625_haodian:haodian&mod=view&sid=';
}
if($action == 'mlistinfc'){
	$_GET['ajaxtarget'] = '';
	$zid = intval($_GET['zid']);
	$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid='$zid' ORDER BY dateline DESC LIMIT 0,5";
	$query = DB::query($sql);
	$dzhus = $dzhu = array();
	while($dzhu = DB::fetch($query)){
		$dzhu['title'] = cutstr($dzhu['title'], 35, '.');
		$dzhus[] = $dzhu;
	}
	include template('dz55625_haodian:view_about');
}

if($action == 'mlistinfa'){
	$_GET['ajaxtarget'] = '';
//------------------------------
	if($NewStart==1){
		$yhcount = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_yh')." WHERE aid='$zid'");
		$sql = "SELECT * FROM ".DB::table('forum_alliance_yh')." WHERE aid='$zid' ORDER BY dateline DESC LIMIT 0,8";
		$query = DB::query($sql);
		$new = $news = array();
		while($new = DB::fetch($query)){
			$new['dateline'] = gmdate('m-d', $new['dateline'] + $_G['setting']['timeoffset'] * 3600);
			$new['title'] = cutstr($new['title'], 33, '');
			$news[] = $new;
		}
		include template('dz55625_haodian:view_diaa');
	}
}
//------------------------------
if($action == 'mlistinfo'){
	$_GET['ajaxtarget'] = '';
	if($ShopStart==1){
		$Spcount = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_sp')." WHERE sid='$zid'");
		$sqls = "SELECT * FROM ".DB::table('forum_alliance_sp')." WHERE sid='$zid' ORDER BY id DESC LIMIT 0,4";
		$query = DB::query($sqls);
		$spin = $spins = array();
		while($spin = DB::fetch($query)){
			$spin['title'] = cutstr($spin['title'], 26, '');
			$spins[] = $spin;
		}
		include template('dz55625_haodian:view_dian');
	}
}



?>