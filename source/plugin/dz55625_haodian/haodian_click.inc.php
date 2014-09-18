<?php
/*
	[Discuz!] (C)2001-2009 Comsenz Inc.
	Make:55625.COM  Name:Lovenr
*/
if(!defined('IN_DISCUZ')) {
       exit('Access Denied'); 
}	
if(!isset($_G['cache']['plugin'])){ loadcache('plugin'); }
@extract($_G['cache']['plugin']['dz55625_haodian']);
$sid = intval($_GET['sid']);
if(!isset($_COOKIE["fwCookie".$sid])){   
	setcookie('fwCookie'.$sid,'fwIos'.$sid,time()+ $allowTime);    
	DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET hits= hits+1 WHERE id='$sid'");
}

?>
	
	
	