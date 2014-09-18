<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_dz55625_haodian{
	function index_middle(){
		global $_G,$SlideConfig;
		$SlideConfig = $_G['cache']['plugin']['dz55625_haodian'];
		$kaiqi = intval($SlideConfig['start']); 
		if($kaiqi == 1){
			$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE top='1' AND display!='0' ORDER BY id DESC LIMIT 12");
			$tuijian = $tuijians = array();
			while($tuijian = DB::fetch($query)){
				$tuijian['title'] = cutstr($tuijian['title'], 15, '');
				$tuijians[] = $tuijian;
			}
			//-------------------------------------------
			if($SlideConfig['RewriteStart'] == 1){
				$curl = 'haodian_';	
			}else{
				$curl = 'plugin.php?id=dz55625_haodian:haodian&mod=view&sid=';
			}
	
			include template('dz55625_haodian:home');
			return $return;
		}

	}

}

class plugin_dz55625_haodian_forum extends plugin_dz55625_haodian{
		function forumdisplay_top(){
			global $_G,$SlideConfig;
			$SlideConfig = $_G['cache']['plugin']['dz55625_haodian'];
			$huangStart = intval($SlideConfig['huangStart']); 
			if($huangStart == 1){
				
				
			}
		}
}

?>
