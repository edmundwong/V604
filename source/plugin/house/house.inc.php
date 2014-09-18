<?php
/*
ini_set("display_errors","on");
set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
*/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

global $house_lang,$house_config;
require_once DISCUZ_ROOT.'./source/plugin/house/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/house/include/function.class.php';

$mod_array = array('index','list','view','admin','search','editor','member','ajax','loupan','tool');
$mod = in_array($_GET['mod'],$mod_array)? addslashes($_GET['mod']):'index';
if(isset($_GET['house_id']) && !isset($_GET['mod'])){
	$mod ='view';
}elseif(!isset($_GET['mod'])){
	$mod = 'index';
}
$now = $mod;

if($_G['setting']['version'] >='X2.5'){
	$cache_dir = DISCUZ_ROOT.'./data/sysdata/';
}else{
	$cache_dir = DISCUZ_ROOT.'./data/cache/';
}

$is_house_admin = is_house_admin();

$style = $house_config['style'];
require_once DISCUZ_ROOT.'./source/plugin/house/module/'.$mod.'.inc.php';
?>