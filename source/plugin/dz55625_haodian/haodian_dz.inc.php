<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

global $_G;
include_once 'language.'.currentlang().'.php';
if(!isset($_G['cache']['plugin'])){ loadcache('plugin'); }
@extract($_G['cache']['plugin']['dz55625_haodian']);
	
if($_GET['action'] == 'dz'){	
	$id=intval($_GET['sid']);
	$active=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id ='{$id}' LIMIT 0 , 1");
	if(submitcheck('applysubdz')){
		$id = intval($_GET['newid']);
		$pic = addslashes($_GET['pic']);
		$dheight = intval($_GET['dheight']);
		if($_FILES['upload']['error']==0){
			$rand=date("YmdHis").random(3, $numeric =1);
			$filesize = $_FILES['upload']['size'] <= $dzsize ;   // 封面图片大小
			$filetype = array("jpg","JPG", "jpeg","JPEG", "gif","GIF", "png", "PNG");
			$arr=explode(".", $_FILES["upload"]["name"]);
			$hz=$arr[count($arr)-1];
			if(!in_array($hz, $filetype)){
				showmessage($php_lang['zhiyunxu']);	
			}
			$filepath = "source/plugin/dz55625_haodian/upimg/".date("Ymd")."/";
			$randname = "dz".$id.".".$hz;
			if(!file_exists($filepath)){ mkdir($filepath); }
			if($filesize){ 
				if(@copy($_FILES['upload']['tmp_name'], $filepath.$randname) || (function_exists('move_uploaded_file') && @move_uploaded_file($_FILES['upload']['tmp_name'], $filepath.$randname))) {
					 @unlink($_FILES['upload']['tmp_name']);
				}
			}else{
				showmessage($php_lang['daxiaoxz']);	
			}
			$pic = "source/plugin/dz55625_haodian/upimg/".date("Ymd")."/".$randname."";
		}
		DB::update('forum_alliance_ar', array('dianzhao' => $pic,'dheight' => $dheight), "id='$id'");
		showmessage($php_lang['dianzhaoedit'], dreferer(), array(), array('locationtime'=>2, 'showdialog'=>1, 'showmsg' => true, 'closetime' => 2));
	}
	include template('dz55625_haodian:dz');
}

if($_GET['action'] == 'bg'){
	$id=intval($_GET['sid']);
	$active=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id ='{$id}' LIMIT 0 , 1");
	if(submitcheck('applysubbg')){
		$id = intval($_GET['newid']);
		$pic = addslashes($_GET['pic']);
		$repeat = addslashes($_GET['repeat'])== 1 ? "no-repeat center top" : "" ;
		
		if($_FILES['uploads']['error']==0){
			$rand=date("YmdHis").random(3, $numeric =1);
			$filesize = $_FILES['uploads']['size'] <= $bgsize ;   // 封面图片大小
			$filetype = array("jpg","JPG", "jpeg","JPEG", "gif","GIF", "png", "PNG");
			$arr=explode(".", $_FILES["uploads"]["name"]);
			$hz=$arr[count($arr)-1];
			if(!in_array($hz, $filetype)){
				showmessage($php_lang['zhiyunxu']);	
			}
			$filepath = "source/plugin/dz55625_haodian/upimg/".date("Ymd")."/";
			$randname = "bg".$id.".".$hz;
			if(!file_exists($filepath)){ mkdir($filepath); }
			if($filesize){ 
				if(@copy($_FILES['uploads']['tmp_name'], $filepath.$randname) || (function_exists('move_uploaded_file') && @move_uploaded_file($_FILES['uploads']['tmp_name'], $filepath.$randname))) {
					 @unlink($_FILES['uploads']['tmp_name']);
				}
			}else{
				showmessage($php_lang['daxiaoxz']);	
			}
			$pic = "source/plugin/dz55625_haodian/upimg/".date("Ymd")."/".$randname."";
		}
		DB::update('forum_alliance_ar', array('background' => $pic ,'repeat' => $repeat), "id='$id'");
		showmessage($php_lang['dianpubacks'], dreferer(), array(), array('locationtime'=>2, 'showdialog'=>1, 'showmsg' => true, 'closetime' => 2));
	}
	include template('dz55625_haodian:bg');
}

if($_GET['action'] == 'yc'){
	$id=intval($_GET['sid']);
	$active=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id ='{$id}' LIMIT 0 , 1");
	if(submitcheck('applysubyc')){
		$id = intval($_GET['newid']);
		$displaytop = addslashes($_GET['displaytop'])== 1 ? 1 : 0;
		DB::update('forum_alliance_ar', array('displaytop' => $displaytop), "id='$id'");
		showmessage($php_lang['yingcokno'], dreferer(), array(), array('locationtime'=>2, 'showdialog'=>1, 'showmsg' => true, 'closetime' => 2));
	}
	include template('dz55625_haodian:yc');
}


?>