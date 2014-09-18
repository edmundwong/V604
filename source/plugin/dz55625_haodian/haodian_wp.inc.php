<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

loadcache('plugin');
include_once 'language.'.currentlang().'.php';
$adminpagenum = 15;
@extract($_G['cache']['plugin']['dz55625_haodian']);
$listclass = parconfig($listclass);
$p = addslashes($_GET['p']);
$p = $p?$p:'index';
$appurl=$_G['siteurl']."admin.php?action=plugins&operation=config&do=$pluginid&identifier=dz55625_haodian&pmod=haodian_wp";
if($p=='index'){
	$where=$pageadd='';
	$cid = intval($_GET['c']);
	if($cid){
		$where="where cid='$cid'";
		$pageadd="&c=$cid";
	}
	$page = $_G['page'];
	$begin = ($page-1)*$adminpagenum;
	$manylist = array();
	
	$rs=DB::query("SELECT * FROM ".DB::table('forum_alliance_wp')." $where ORDER BY dateline DESC LIMIT $begin , $adminpagenum");
	
	while ($rw=DB::fetch($rs)){
		$manylist[]=$rw;
	}

	$allnum=DB::result_first("SELECT count(*) FROM ".DB::table('forum_alliance_wp')." $where");
	$pagenav=multi($allnum,$adminpagenum,$page,$appurl."&p=$p".$pageadd);
			
}elseif ($p=='del'){
	$id=intval($_GET['id']);
	DB::query("DELETE FROM ".DB::table('forum_alliance_wp')." WHERE id ='$id' LIMIT 1 ;");
	cpmsg($php_lang['lshanchuok'],$appurl);
}
else cpmsg($php_lang['lweidingyi']);

include(template("dz55625_haodian:admin_wp"));

function parconfig($str){
$return = array();
$array = explode("\n",str_replace("\r","",$str));
foreach ($array as $v){
   $t = explode("=",$v);
   $t[0] = trim($t[0]);
   $return[$t[0]] = $t[1];
}
return $return;
} 
?>
