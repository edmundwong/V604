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

$uid = intval($_G['uid']);
$action = intval($_GET['action']);
if($uid){
	$action=$action?$action:"add";
	if($action=="add"){
		$counts = DB::result_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid = '$uid' AND display!='0' ");
		$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid = '$uid' AND display!='0' ";
		$query = DB::query($sql);
		$zuyong = $zuyongs = array();
		while($zuyong = DB::fetch($query)){
			$zuyongs[] = $zuyong;
		}
		$tempt='<script language="javascript">load_img_up("'.time().'");</script>';
		include template('dz55625_haodian:pc');
	}elseif($action="upload"){
		
	}
}else{
	showmessage($php_lang['yyoukewuq'], dreferer(), array(), array('locationtime'=>2, 'showdialog'=>1, 'showmsg' => true, 'closetime' => 2));
}

?>