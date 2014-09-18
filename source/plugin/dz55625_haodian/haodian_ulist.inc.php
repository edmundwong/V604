<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr  WWW.55625.COM
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

global $_G;

if(!isset($_G['cache']['plugin'])){ loadcache('plugin'); }
@extract($_G['cache']['plugin']['dz55625_haodian']);
include_once 'language.'.currentlang().'.php';

//µêÖ÷Ïà¹Ø

$uc = $_G['setting']['ucenterurl'];
if($RewriteStart == 1){ $curl = 'haodian';}else{
	$curls = 'plugin.php?id=dz55625_haodian:haodian&mod=view&sid=';
}

if($_GET['mod']=='list'){
	
	$uid = intval($_GET['uid']);
	$info = DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid='$uid' LIMIT 1");
	$eacha = 10;
	$counts = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_ar')." WHERE uid='$uid' AND display!='0'");
	$pages = intval($_GET['page']);
	$pages = max($pages, 1);
	$starts = ($pages - 1) * $eacha;
	
	if($counts) {
		$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid='$uid' AND display!='0' ORDER BY dateline DESC LIMIT $starts,$eacha";
		$query = DB::query($sql);
		$userLs = $userList = array();
		while($userLs = DB::fetch($query)){
			$userLs['dateline'] = gmdate('Y-m-d', $userLs['dateline'] + $_G['setting']['timeoffset'] * 3600);
			$userList[] = $userLs;
		}
	}
	
	$appurl=$_G['siteurl']."plugin.php?id=dz55625_haodian:haodian_ulist&mod=list&uid=".$uid;
	$multis = "<div class='pages cl'>".multi($counts, $eacha, $pages, $appurl)."</div>";
	
	include template('dz55625_haodian:user_list');
}
?>