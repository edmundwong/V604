<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
include_once 'language.'.currentlang().'.php';

function dz55625_haodian($str) {
	if(is_array($str)) {
		$return = array();
		foreach($str as $value) {
			$return[] = dz55625_haodian($value);
		}
		return $return;
	} else {
		return lang('plugin/dz55625_haodian', $str);
	}
}

if(!$_GET['haodian_yx']){
	if(!submitcheck('slidesubmit')){
		$count = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_yh'));
		$each = 15;
		$page = intval($_GET['page']);
		$page = max($page, 1);
		$start = ($page - 1) * $each;

		showtableheader($php_lang['yhadminxx'], '');
		showformheader('plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_yx');

		showtableheader();
		showsubtitle(dz55625_haodian(array('',$php_lang['photosuo'],$php_lang['xinxititle'], $php_lang['fbshijian'], $php_lang['caozuoss'])));
		$dg_admin_num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_yh'));
			if($dg_admin_num) {
			$query = DB::query("SELECT a.title as spname,b.id,b.aid,b.title,b.dateline FROM ".DB::table('forum_alliance_ar')." a, ".DB::table('forum_alliance_yh')." b WHERE a.id = b.aid ORDER BY b.dateline DESC LIMIT $start,$each");
			while($result = DB::fetch($query)) {
				$result['message'] = cutstr($result['message'], 60, '...');
			showtablerow(NULL,NULL, array('<input type="checkbox" class="checkbox" name="delete[]" value="'.intval($result['id']).'">','<a href="plugin.php?id=dz55625_haodian:haodian&mod=view&sid='.$result['aid'].'" target="_blank">'.$result['spname'].'</a>',$result['title'],date('Y-m-d H:i', dhtmlspecialchars($result['dateline'])),'<a href="admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_yx&haodian_yx=del&del_id='.$result['id'].'">'.$php_lang['shanchuss'].'</a>'));
				}
			}
		$multi = multi($count, $each, $page, ADMINSCRIPT.'?action=plugins&operation=config&identifier=dz55625_haodian&pmod=haodian_yx');
		showtablerow();
		showsubmit('slidesubmit', 'del', 'select_all','',$multi);
		
	}else{
		$del_id = implode('|', $_GET['delete']);
		cpmsg(dz55625_haodian($php_lang['qrshanchu']), '', '', '', '<input class="btn" type="button" value="'.dz55625_haodian($php_lang['qrshanchus']).'" onclick="location.href=\'admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_yx&haodian_yx=del&del_id='.$del_id.'\'"/>&nbsp;&nbsp;<input class="btn" type="button" value="'.dz55625_haodian($php_lang['quxiaos']).'" onclick="location.href=\'admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_yx\'"/>');
	}

}elseif($_GET['haodian_yx']=='check'){
	
	if($_GET['sh'] == 'yes'){
		$id = intval($_GET['id']);
		DB::query("UPDATE ".DB::table('forum_alliance_yh')." SET display='1' WHERE id='$id'");
		cpmsg($php_lang['lshengheok'],'action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_yx');
	}elseif($_GET['sh'] == 'no'){
		$id = intval($_GET['id']);
		DB::query("UPDATE ".DB::table('forum_alliance_yh')." SET display='0' WHERE id='$id'");
		cpmsg($php_lang['lpingbiok'],'action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_yx');
	}	
	
}elseif($_GET['haodian_yx']=='del'){
	$del_id = explode('|', $_GET['del_id']);
	$nums = 0;
	foreach($del_id as $aid) {
		$aid = intval($aid);
		$deichek = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_yh')." WHERE id='$aid'");
		if(!$deichek) {
			cpmsg_error(dz55625_haodian($php_lang['weixuanzs']));
		} else {
			DB::query("DELETE FROM ".DB::table('forum_alliance_yh')." WHERE id='$aid'");
			$nums++;
		}

	}
	cpmsg(dz55625_haodian($php_lang['lshanchuok']),'action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_yx');
}
?>
