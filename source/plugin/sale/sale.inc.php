<?php
/**
´ËÆÆ½â³ÌÐòÓÉÐÇÆÚÁùÔ´Âë¡¾xlqzm.com¡¿Ìá¹©£¬¸ü¶àÉÌÒµÔ´ÂëÇëµÇÂ¼ÐÇÆÚÁùÔ´Âë¹ÙÍø
¹Ù·½ÍøÕ¾:xlqzm.com
¸ü¶àÉÌÒµ²å¼þ£ºhttp://xqlzm.com/forum-113-1.html
¸ü¶àÉÌÒµÄ£°å£ºhttp://xqlzm.com/forum-112-1.html
¸ü¶àÉÌÒµÔ´Âë£ºhttp://xqlzm.com/forum-141-1.html
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

/*
ini_set("display_errors","on");
set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
*/

global $sale_config,$_lang;
include ("include/config.class.php");//var_dump($sale_config);exit;
include ("include/function.class.php");

$mod_array = array('ok','choclass','post','edit','member','setpostup','jubao','memberinfo','kefu','index','view','admin','orderdetail','search','ajax');
$mod = in_array($_GET['mod'],$mod_array) ? addslashes($_GET['mod']) : 'index';
if(isset($_GET['sale_id']) && !isset($_GET['mod'])){
	$mod ='view';
}elseif(!isset($_GET['mod'])){
	$mod = 'index';
}
$now = $mod;

$_lang = lang('plugin/sale');

$style = $sale_config['style'];
//echo DISCUZ_ROOT.'./source/plugin/sale/module/'.$mod.'.inc.php';exit;
require DISCUZ_ROOT.'./source/plugin/sale/module/'.$mod.'.inc.php';
?>
