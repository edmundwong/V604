<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
include_once 'language.'.currentlang().'.php';

$key = 'obOB0jpce8Vfg';
$param = array(
	'key' => 'lovenr',
);
ksort($param);
$params = '';
foreach($param as $k => $v) {
	$params .= '&'.$k.'='.rawurlencode($v);
}
$params .= '&md5hash='.md5(substr($params, 1).$key);
$r = @implode('', file('http://open.discuz.net/api/getaddons?'.substr($params, 1)));
$arr = unserialize($r);
foreach ($arr as $key=>$value){
	if(is_array($value)){
		foreach($value as $k=>$var) {}
		include template('dz55625_haodian:haodian_plate');//调用单页模版文件
	}
}


?>