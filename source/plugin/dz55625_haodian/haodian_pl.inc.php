<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
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
include_once 'language.'.currentlang().'.php';

if(!$_GET['haodian_pl']){
	if(!submitcheck('slidesubmits')){
		$count = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_pl'));
		$each = 15;
		$page = intval($_GET['page']);
		$page = max($page, 1);
		$start = ($page - 1) * $each;

		showtableheader($php_lang['huiyuanpss'], '');
		showformheader('plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pl');

		showtableheader();
		showsubtitle(dz55625_haodian(array('',$php_lang['huiyuanmc'],$php_lang['neirongss'],$php_lang['user_pf'], $php_lang['fbshijian'], $php_lang['caozuoss'], $php_lang['zhuangtaiss'])));
		$dg_admin_num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_pl'));
			if($dg_admin_num) {
			$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_pl')." ORDER BY dateline DESC LIMIT $start,$each");
			while($result = DB::fetch($query)) {
				$result['message'] = cutstr($result['message'], 60, '...');
			if(empty($result['display'])){
					$dzt = "<a href='admin.php?action=plugins&operation=config&do=".$pluginid."&identifier=dz55625_haodian&pmod=haodian_pl&haodian_pl=check&sh=yes&id=".$result[id]."' style='color:#F00'>".$php_lang['ddshenhes']."</a>";
				}else{
					$dzt = "<a href='admin.php?action=plugins&operation=config&do=".$pluginid."&identifier=dz55625_haodian&pmod=haodian_pl&haodian_pl=check&sh=no&id=".$result[id]."' style='color:#090'>".$php_lang['zcxianshis']."</a>";
			}
			showtablerow(NULL,NULL, array('<input type="checkbox" class="checkbox" name="delete[]" value="'.intval($result['id']).'">','<a href="admin.php?action=members&operation=ban&uid='.$result['uid'].'">'.$result['author'].'</a>',$result['message'],$result['total'].$php_lang['user_ff'],date('Y-m-d H:i', dhtmlspecialchars($result['dateline'])),'<a href="admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pl&haodian_pl=del&del_id='.$result['id'].'">'.$php_lang['shanchuss'].'</a>',$dzt));
				}
			}
		$multi = multi($count, $each, $page, ADMINSCRIPT.'?action=plugins&operation=config&identifier=dz55625_haodian&pmod=haodian_pl');
		showtablerow();
		showsubmit('slidesubmits', 'del', 'select_all','',$multi);
		
	}else{
		$del_id = implode('|', $_GET['delete']);
		cpmsg(dz55625_haodian($php_lang['qrshanchu']), '', '', '', '<input class="btn" type="button" value="'.dz55625_haodian($php_lang['qrshanchus']).'" onclick="location.href=\'admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pl&haodian_pl=del&del_id='.$del_id.'\'"/>&nbsp;&nbsp;<input class="btn" type="button" value="'.dz55625_haodian($php_lang['quxiaos']).'" onclick="location.href=\'admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pl\'"/>');
	}

}elseif($_GET['haodian_pl']=='check'){
	
	if($_GET['sh'] == 'yes'){
		$id = intval($_GET['id']);
		DB::query("UPDATE ".DB::table('forum_alliance_pl')." SET display='1' WHERE id='$id'");
		cpmsg($php_lang['lshengheok'],'action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pl');
	}elseif($_GET['sh'] == 'no'){
		$id = intval($_GET['id']);
		DB::query("UPDATE ".DB::table('forum_alliance_pl')." SET display='0' WHERE id='$id'");
		cpmsg($php_lang['lpingbiok'],'action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pl');
	}	
	
}elseif($_GET['haodian_pl']=='del'){
	$del_id = explode('|', $_GET['del_id']);
	$nums = 0;
	foreach($del_id as $aid) {
		$aid = intval($aid);
		//--------------------
		$pl=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_pl')." WHERE id ='$aid'");
		$pid = $pl["sid"];
		$total = $pl["total"];
		$pls=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id ='$pid'");
		if($pls["voter"]!=0){
			DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET total=total-$total,voter=voter-1 WHERE id='$pid'");
		}
		//--------------------
		$deichek = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_pl')." WHERE id='$aid'");
		if(!$deichek) {
			cpmsg_error(dz55625_haodian($php_lang['weixuanzs']));
		} else {
			DB::query("DELETE FROM ".DB::table('forum_alliance_pl')." WHERE id='$aid' LIMIT 1 ");
			$nums++;
		}

	}
	cpmsg(dz55625_haodian($php_lang['lshanchuok']),'action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pl');
}
?>
