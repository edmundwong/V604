<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
include_once 'language.'.currentlang().'.php';

if(!isset($_G['cache']['plugin'])){ loadcache('plugin'); }
@extract($_G['cache']['plugin']['dz55625_haodian']);

if(!$_GET['haodian_rl']){
	if(!submitcheck('slidesubmit')){
		$count = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_rl'));
		$each = 10;
		$page = intval($_GET['page']);
		$page = max($page, 1);
		$start = ($page - 1) * $each;

		showtableheader($php_lang['adminrlgl'], '');
		showformheader('plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_rl');

		showtableheader();
		showsubtitle(dz55625_haodian(array($php_lang['adminxzhe'],$php_lang['photosuo'],$php_lang['renlinguser'],$php_lang['renlingliy'],$php_lang['renlingtime'],$php_lang['renlzhuangt'], $php_lang['caozuoss'])));
		$dg_admin_num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_rl'));
		
			if($dg_admin_num) {
			$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_rl')." ORDER BY dateline DESC LIMIT $start,$each");
			while($result = DB::fetch($query)) {
				$result['message'] = cutstr($result['subject'], 60, '...');
				if($result['display']==0){
						$tongguo = "<font color=#FF0000>".$php_lang['renlshenghno']."</font>";
					}else{
						$tongguo = "<font color=#009900>".$php_lang['renlsheok']."</font>";
				}
			showtablerow(NULL,NULL, array('<input type="checkbox" class="checkbox" name="delete[]" value="'.intval($result['id']).'">',$result['sid'].$php_lang['renlinghao'].' - <a href="plugin.php?id=dz55625_haodian:haodian&mod=view&sid='.$result['sid'].'" target="_blank">'.$php_lang['chakandpu'].'</a>',$result['author'],$result['subject'],date('Y-m-d',$result['dateline']),$tongguo,'<a href="admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_rl&haodian_rl=rok&rl_id='.$result['id'].'">'.$php_lang['shenghedp'].'</a> | <a href="admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_rl&haodian_rl=del&del_id='.$result['id'].'">'.$php_lang['shanchuss'].'</a>'));
				}
			}
			
		$multi = multi($count, $each, $page, ADMINSCRIPT.'?action=plugins&operation=config&identifier=dz55625_haodian&pmod=haodian_rl');
		showtablerow();
		showsubmit('slidesubmit', 'del', 'select_all','',$multi);
		
	}else{
		$del_id = implode('|', $_GET['delete']);
		cpmsg(dz55625_haodian($php_lang['qrshanchu']), '', '', '', '<input class="btn" type="button" value="'.dz55625_haodian($php_lang['qrshanchus']).'" onclick="location.href=\'admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_rl&haodian_rl=del&del_id='.$del_id.'\'"/>&nbsp;&nbsp;<input class="btn" type="button" value="'.dz55625_haodian($php_lang['quxiaos']).'" onclick="location.href=\'admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_rl\'"/>');
	}

}elseif($_GET['haodian_rl']=='del'){
	$del_id = explode('|', $_GET['del_id']);
	$nums = 0;
	foreach($del_id as $aid) {
		$aid = intval($aid);
		$deichek = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_rl')." WHERE id='$aid'");
		if(!$deichek) {
			cpmsg_error(dz55625_haodian($php_lang['weixuanzs']));
		} else {
			DB::query("DELETE FROM ".DB::table('forum_alliance_rl')." WHERE id='$aid' LIMIT 1 ");
			$nums++;
		}

	}
	cpmsg(dz55625_haodian($php_lang['lshanchuok']),'action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_rl');
}elseif($_GET['haodian_rl']=='rok'){
	
	$rl_id = explode('|', $_GET['rl_id']);
	$nums = 0;
	foreach($rl_id as $sid) {
		$sid = intval($sid);
		$deichek = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_rl')." WHERE id='$sid'");
		if(!$deichek) {
			cpmsg_error(dz55625_haodian($php_lang['weixuanzs']));
		} else {
			//--------------------------------------------------------------
			DB::query("UPDATE ".DB::table('forum_alliance_rl')." SET display='1' WHERE id='$sid'");
			//--------------------------------------------------------------
			$sqls = "SELECT * FROM ".DB::table('forum_alliance_rl')." WHERE id = '$sid'";
			$px = DB::fetch(DB::query($sqls));
			$sd = intval($px['sid']);
			$uid = intval($px['uid']);
			$author = $px['author'];
			DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET uid='$uid',author='$author',renling='1' WHERE id='$sd'");
			DB::query("UPDATE ".DB::table('forum_alliance_img')." SET uid='$uid' WHERE aid='$sd'");
			DB::query("UPDATE ".DB::table('forum_alliance_wp')." SET uid='$uid',author='$author' WHERE sid='$sd'");
			DB::query("UPDATE ".DB::table('forum_alliance_yh')." SET uid='$uid' WHERE aid='$sd'");
			if($Lstart==1){
				DB::query("UPDATE ".DB::table('forum_alliance_ad')." SET uid='$uid' WHERE sid='$sd'");
			}
			if($StHop==1){
				DB::query("UPDATE ".DB::table('forum_alliance_sp')." SET uid='$uid' WHERE sid='$sd'");
			}
			if($Ystart==1){
				DB::query("UPDATE ".DB::table('forum_alliance_yy')." SET uid='$uid',author='$author' WHERE sid='$sd'");
			}
			//--------------------------------------------------------------
			$nums++;
		}
	}
	cpmsg(dz55625_haodian($php_lang['czchenggong']),'action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_rl');
}

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

?>
