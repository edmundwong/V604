<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

//ini_set("display_errors","on");
//set_time_limit(0);
//error_reporting(E_ALL ^ E_NOTICE);

global $sale_config,$_lang;
include ("include/config.class.php");
include ("include/function.class.php");

$mod_array = array('ok','choclass','post','edit','member','setpostup','jubao','memberinfo','kefu','index','view','admin','orderdetail','search','ajax','autospider');
$mod = in_array($_GET['mod'],$mod_array) ? addslashes($_GET['mod']) : 'index';

if(isset($_GET['sale_id']) && !isset($_GET['mod'])){
	$mod ='view';
}elseif(!isset($_GET['mod'])){
	$mod = 'index';
}

$now = $mod;
$_lang = lang('plugin/sale');
$style = $sale_config['style'];

require DISCUZ_ROOT.'./source/plugin/sale/module/'.$mod.'.inc.php';
?>
