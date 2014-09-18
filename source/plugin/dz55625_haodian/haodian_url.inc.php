<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$host= 'www.55625.com'; //填写你最终需要的地址
if ($_SERVER['HTTP_HOST'] != $host) {
	$uaurl=$_SERVER['HTTP_HOST']; #取用户输入的地址
	$tdi=substr($uaurl,0,strpos($uaurl,".",0));#取第一个.前的文字
	if($RewriteStart == 1){
		$surl="http://{$host}/plugin.php?id=dz55625_haodian:haodian&mod=view&sid={$tdi}";#设置转向目标
	}else{
		$surl="http://{$host}/haodian_{$tdi}.html";#设置转向目标
	}
	header("location:$surl");#转向
}
unset($host);
?>