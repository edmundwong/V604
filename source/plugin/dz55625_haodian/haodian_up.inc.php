<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


include_once 'source/plugin/dz55625_haodian/haodian_Size.class.php';

if (!empty($_FILES)) {
	$filepath = "source/plugin/dz55625_haodian/upimg/".date("Ymd")."/";
	if(!file_exists($filepath)){ mkdir($filepath); }
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . date("Ymd") . '/';
	$name = date('YmdHis')."_".rand(1000,9999).'.'.getExt($_FILES['Filedata']['name']);
	$path = $filepath . $name; //定义原始文件的存储位置
	move_uploaded_file($tempFile,$path);
	//new myThumbClass($path,600,1,$path,-1,0);
	echo $path;
}


// 获取文件扩展名
function getExt($fileName){
	$ext = explode(".", $fileName);
	$ext = $ext[count($ext) - 1];
	return strtolower($ext);
}

?>