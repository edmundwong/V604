<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

if(!isset($_G['cache']['plugin'])){ loadcache('plugin'); }
@extract($_G['cache']['plugin']['dz55625_haodian']);
include_once 'language.'.currentlang().'.php';
$modfile1=DISCUZ_ROOT.'./source/plugin/dz55625_haodian/lib/WindFile.php';
@require_once($modfile1);
$file=DISCUZ_ROOT."./source/plugin/dz55625_haodian/config.php";
$action=$_GET['op']?$_GET['op']:"main";
$appurl=$_G['siteurl']."admin.php?action=plugins&operation=config&do=$_G[gp_do]&identifier=$_G[gp_identifier]&pmod=wap_setting";
if($action == 'main'){
	$conf = @include $file;
	$conf || $conf = array();
	include(template("dz55625_haodian:wap_setting"));
}else if($action == 'save'){
	include_once 'source/plugin/dz55625_haodian/haodian_pc.class.php';
	$conf=$_G["gp_conf"];
	$pic_link_ups=addslashes($_GET['pic_link_ups']);
	if($pic_link_ups){
		$pic_ids=explode("|",$pic_link_ups);
		foreach($pic_ids as $k=>$v){
			if($v){
				if($_FILES['up_pic_'.$v]['error']==0){
					$rand=date("YmdHis").random(3, $numeric =1);
					$filetype = array("jpg","JPG", "jpeg","JPEG", "gif","GIF", "png", "PNG");
					$arr=explode(".", $_FILES['up_pic_'.$v]["name"]);
					$hz=$arr[count($arr)-1];
					$filepath = "source/plugin/dz55625_haodian/upimg/".date("Ymd")."/";
					$randname = date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".".$hz;
					if(!file_exists($filepath)){ mkdir($filepath); }
						if(@copy($_FILES['up_pic_'.$v]['tmp_name'], $filepath.$randname) || (function_exists('move_uploaded_file') && @move_uploaded_file($_FILES['up_pic_'.$v]['tmp_name'], $filepath.$randname))) {
							 @unlink($_FILES['up_pic_'.$v]['tmp_name']);
						}
					$pic = "source/plugin/dz55625_haodian/upimg/".date("Ymd")."/".$randname."";
					new myThumbClass($pic,308,180,$pic,0,0);
					$conf['magic_lantern'][$v]['pic']=$pic;
				}else{
					unset($conf['magic_lantern'][$v]['link']);
				}
			}
		}
	}
	WindFile::savePhpData($file, $conf);
	cpmsg($php_lang['lbianjiok'],$appurl);
}else{
	cpmsg($php_lang['czerror'],$appurl);	
}
?>