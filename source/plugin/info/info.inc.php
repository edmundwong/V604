<?php
/*
ini_set("display_errors","on");
set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
*/
//error_reporting(E_ALL);
if(!defined('IN_DISCUZ')) {exit('Access Denied');}

global $info_lang,$info_config;
require_once DISCUZ_ROOT.'./source/plugin/info/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/info/include/function.class.php';

$mod_array = array('index','list','view','admin','search','editor','member','ajax','loupan','tool','select');
$mod = in_array($_GET['mod'],$mod_array)? addslashes($_GET['mod']):'index';
if(isset($_GET['info_id']) && !isset($_GET['mod'])){
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

if(!file_exists($cache_dir.'cache_info_cat_array.php') || !file_exists($cache_dir.'cache_info_area_array.php') ){
	showmessage($_lang['no_cat']);
	exit;
}else{
	require_once $cache_dir.'cache_info_cat_array.php';
	require_once $cache_dir.'cache_info_area_array.php';
}

$is_info_admin = is_info_admin();
list($area_id,$area_title) = brian_changecity($mod);

if(defined('IN_MOBILE')){
	$_GET['mobile'] = "2";
	$style = "default";
}else{
	$style = $info_config['style'];
}
//echo DISCUZ_ROOT.'./source/plugin/info/module/'.$mod.'.inc.php';exit;
require_once DISCUZ_ROOT.'./source/plugin/info/module/'.$mod.'.inc.php';
?>