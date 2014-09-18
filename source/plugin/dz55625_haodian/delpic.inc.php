<?php
/*
	(C)2011 - 2013 55625.COM Inc.
	Make BY Lovenr   QQ:114512039  
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/discuzcode');

global $_G;
include_once 'language.'.currentlang().'.php';
if(!isset($_G['cache']['plugin'])){ loadcache('plugin'); }
@extract($_G['cache']['plugin']['dz55625_haodian']);

$imgsrc = $_GET['picsrc'];
$action=$_GET['action'];

if($imgsrc){
	if($action=="deledit"){
		DB::query("delete from ".DB::table("forum_alliance_img_tmp")." where img='".$imgsrc."'");
	}
	unlink($imgsrc);
}
include template("dz55625_haodian:delpic");

?>