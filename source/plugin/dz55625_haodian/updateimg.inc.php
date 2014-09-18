<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	include_once 'language.'.currentlang().'.php';
	$img_id=intval($_G["gp_xxx"]);
	if($img_id){
		$sql="select * from ".DB::table("forum_alliance_albums_img")." where id=$img_id";
		$img = DB::fetch_first($sql);
	}else{
		showmessage(lang('plugin/dz55625_haodian', $img_id));
	}
	include(template("dz55625_haodian:updateimg"));
?>