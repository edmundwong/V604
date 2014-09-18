<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

include_once 'source/plugin/dz55625_haodian/haodian_Size.class.php';
include_once 'source/plugin/dz55625_haodian/imageWaterMark.class.php';
include_once 'language.'.currentlang().'.php';

$uid=intval($_G["uid"]);
$g_uid=intval($_G["gp_uid"]);
$uname=addslashes($_G["uid"]);
$g_uname=addslashes($_G["gp_uid"]);
$aid=intval($_G["gp_aid"]);
$title=addslashes($_G["gp_title"]);
$upload_name = "Filedata";
if($uid || $g_uid){
	if($uid){
		$userdir=$uname;
	}elseif($g_uid){
		$uid=$g_uid;
		$userdir=$g_uname;
	}
}else{
	HandleError(iconv($_G['charset'],'utf-8',$php_lang['yyoukewuq']));
	exit(0);
}
if(!$aid){
	HandleError("error!Merchant is not find!");
	exit(0);
}
$title=iconv('utf-8',$_G['charset'],$title);
if(!$title){
	$sql="select * from ".DB::table("forum_alliance_ar")." where id=$aid";
	$ar=DB::fetch_first($sql);
	$title=$ar[title];
}
$sql="select * from ".DB::table("forum_alliance_albums")." where arid=$aid and uid=$uid";
$albums=DB::fetch_first($sql);

$rand=date("YmdHis").random(3, $numeric =1);
$filesize = $_FILES[$upload_name]['size'] > $piczhanshi ;   // อผฦฌด๓ะก
$filetype = array("jpg","JPG", "jpeg","JPEG", "gif","GIF", "png", "PNG");
$arr=explode(".", $_FILES[$upload_name]["name"]);
$hz=$arr[count($arr)-1];
if(!in_array($hz, $filetype)){
	HandleError(iconv($_G['charset'],'utf-8',$php_lang['zhiyunxu']));	
	exit(0);
}
$filepath = "source/plugin/dz55625_haodian/upimg/".$userdir."_img/";

$original_url="original_".date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".".$hz;
$shrink_url = "shrink_".date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".".$hz;

if(!file_exists($filepath)){ mkdir($filepath); }

if($filesize){ 
	if(@copy($_FILES[$upload_name]['tmp_name'], $filepath.$original_url) || (function_exists('move_uploaded_file') && @move_uploaded_file($_FILES[$upload_name]['tmp_name'], $filepath.$original_url)))											
	{			
		 @unlink($_FILES[$upload_name]['tmp_name']);
	}
	@copy($filepath.$original_url, $filepath.$shrink_url);
}else{
	HandleError(iconv($_G['charset'],'utf-8',$php_lang['daxiaoxz']));	
	exit(0);
}
$pic = $filepath.$shrink_url;
new myThumbClass($pic,276,195,$pic,0,0);
$imgwater=$_G["gp_imgwater"];
if($imgwater){
	$imgwater_wz=intval($_G["gp_imgwater_wz"]);
	$wm = new WaterMark();
	$wm->setImSrc($filepath.$original_url); 
	$wm->setImWater($imgwater); 
	$wm->mark(1,$imgwater_wz,0,0); 
}
$curtime=time();

if($albums){
	if(!$albums['img_url'] || !file_exists($albums['img_url'])){
		DB::update('forum_alliance_albums',array('imgnum' => $albums[imgnum]+1,'revisedate' =>$curtime,'img_url' => $pic),"id='$albums[id]'");
		DB::insert('forum_alliance_albums_img',array('id' => '','title' => $title,'shrink_url' => $filepath.$shrink_url,'original_url' => $filepath.$original_url,'albums_id' => $albums[id],'createdate' => $curtime,'status'=>1));
	}else{
		DB::update('forum_alliance_albums',array('imgnum' => $albums[imgnum]+1,'revisedate' =>$curtime),"id='$albums[id]'");
		DB::insert('forum_alliance_albums_img',array('id' => '','title' => $title,'shrink_url' => $filepath.$shrink_url,'original_url' => $filepath.$original_url,'albums_id' => $albums[id],'createdate' => $curtime));
	}
}else{
	DB::insert('forum_alliance_albums',array('id' => '','title' => $title,'img_url' => $pic,'uid' => $uid,'uname' => $uname,'arid' => $aid,'createdate' => $curtime,'revisedate' =>$curtime,'imgnum' => 1));
	$abid = DB::insert_id();
	DB::insert('forum_alliance_albums_img',array('id' => '','title' => $title,'shrink_url' => $filepath.$shrink_url,'original_url' => $filepath.$original_url,'albums_id' => $abid,'createdate' => $curtime,'status'=>1));
}

exit(0);

function getExt($fileName){
	$ext = explode(".", $fileName);
	$ext = $ext[count($ext) - 1];
	return strtolower($ext);
}

function HandleError($message) {
	echo $message;
}



?>