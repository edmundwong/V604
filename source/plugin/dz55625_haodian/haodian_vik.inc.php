<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$haodiank = array(
'www.cnzz8.net',
'1378982607',
'www.cnzz8.net',
$_G['siteurl'],
);
$hzs = $haodiank[3];
$hzs = parse_url($hzs);
$hzs = strtolower($hzs['host']) ;
$domain = array('com','cn','cc','org','net','me','co','tv','la');
$hus = $hzs;
$dds = implode('|',$domain);
$hus = preg_replace('/(\.('.$dds.'))*\.('.$dds.')$/iU','',$hus);
$hus = explode('.',$hus);
$hus = array_pop($hus); 
$hus = substr($hzs,strrpos($hzs,$hus)); 
$hakign = md5(implode('', $haodiank));


?>

