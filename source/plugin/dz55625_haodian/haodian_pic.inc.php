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

if(!$_GET['haodian_pic']){
	if(!submitcheck('slidesubmit')){
		$count = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_albums_img'));
		$each = 10;
		$page = intval($_GET['page']);
		$page = max($page, 1);
		$start = ($page - 1) * $each;

		showtableheader($php_lang['photoadmin'], '');
		showformheader('plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pic');

		showtableheader();
		showsubtitle(dz55625_haodian(array('',$php_lang['photopic'],$php_lang['photosuo'],$php_lang['fbshijian'], $php_lang['caozuoss'])));
		$dg_admin_num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_albums_img'));
			if($dg_admin_num) {
			$query = DB::query("SELECT a.title as ar_title,ali.* FROM ".DB::table("forum_alliance_albums_img")." ali inner join ".DB::table("forum_alliance_albums")." al on(ali.albums_id=al.id) inner join ".DB::table('forum_alliance_ar')." a on(al.arid=a.id) ORDER BY ali.createdate DESC LIMIT $start,$each");
			while($result = DB::fetch($query)) {
				$result['message'] = cutstr($result['message'], 60, '...');
			showtablerow(NULL,NULL, array('<input type="checkbox" class="checkbox" name="delete[]" value="'.intval($result['id']).'">','<img src="'.$result['shrink_url'].'" width="120" height="90" />',$result['ar_title'],date('Y-m-d',$result['createdate']),'<a href="admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pic&haodian_pic=del&del_id='.$result['id'].'">'.$php_lang['shanchuss'].'</a>'));
				}
			}
		$multi = multi($count, $each, $page, ADMINSCRIPT.'?action=plugins&operation=config&identifier=dz55625_haodian&pmod=haodian_pic');
		showtablerow();
		showsubmit('slidesubmit', 'del', 'select_all','',$multi);
		
	}else{
		$del_id = implode('|', $_GET['delete']);
		if($del_id){
		cpmsg(dz55625_haodian($php_lang['qrshanchu']), '', '', '', '<input class="btn" type="button" value="'.dz55625_haodian($php_lang['qrshanchus']).'" onclick="location.href=\'admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pic&haodian_pic=del_all&del_id='.$del_id.'\'"/>&nbsp;&nbsp;<input class="btn" type="button" value="'.dz55625_haodian($php_lang['quxiaos']).'" onclick="location.href=\'admin.php?action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pic\'"/>');
		}else{
			cpmsg(dz55625_haodian($php_lang['al_nodelc']),'action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pic');
		}
	}

}elseif($_GET['haodian_pic']=='del'){
	$imgid=intval($_G["gp_del_id"]);
	if($imgid){
		delimg($imgid);
		cpmsg(dz55625_haodian($php_lang['up_delok']),'action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pic');
	}else{
		cpmsg(dz55625_haodian($php_lang['updateiderror']),'action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pic');
	}
}elseif($_G["gp_haodian_pic"]=="del_all"){
	$del_id= $_GET['del_id'];
	$deid = explode('|', $del_id);
	foreach($deid as $ssd){
		delimg($ssd);
	}
	cpmsg(dz55625_haodian($php_lang['up_delok']),'action=plugins&operation=config&do='.$pluginid.'&identifier=dz55625_haodian&pmod=haodian_pic');
}

function delimg($imgid){
	$sql="select * from ".DB::table("forum_alliance_albums_img")." where id=$imgid";
	$img = DB::fetch_first($sql);
	$albums_id=$img[albums_id];
	if($img){
		$sql1="select * from ".DB::table("forum_alliance_albums")." where id=$img[albums_id]";
		$albums = DB::fetch_first($sql1);
		if($albums[img_url]==$img[shrink_url]){
			$img1 = DB::fetch_first("select * from ".DB::table("forum_alliance_albums_img")." where albums_id=$albums[id]");
			if($img1){
				DB::query("update ".DB::table("forum_alliance_albums")." set img_url='$img1[shrink_url]' where id=$albums[id]");
				DB::query("update ".DB::table("forum_alliance_albums_img")." set status=1 where id=$img1[id]");
			}
		}
		@unlink($img[shrink_url]);
		@unlink($img[original_url]);
		DB::query("delete from ".DB::table("forum_alliance_albums_img")." where id=$imgid");
		DB::query("update ".DB::table("forum_alliance_albums")." set imgnum=imgnum-1 where id=$albums[id]");
	}
}
?>
