<?php
/**
 *      ��Ȩ����: �ó���Ϊ [DiscuzCMS!] ������������, ����ӵ�иò�Ʒ֪ʶ��Ȩ,���д����Ȩ��[DiscuzCMS!]����, �����ھ�Ϊ��ҵ����, ��Ϊ�������ṩʹ����Ȩ.
 *		��������: δ���ٷ���Ȩʹ���޸Ļ��ߴ�������������Ȩ��Υ����Ϊ, ������׷��һ����ط�������.
 *		�ٷ���վ: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

/*
ini_set("display_errors","on");
set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
*/

global $gongqiu_config,$_lang;
require_once DISCUZ_ROOT.'./source/plugin/gongqiu/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/gongqiu/include/function.class.php';

$mod_array = array('post','edit','member','setpostup','jubao','memberinfo','kefu','index','view','admin','orderdetail','search','ajax');
$mod = in_array(getgpc('mod'),$mod_array)?getgpc('mod'):'index';
if(isset($_GET['gongqiu_id']) && !isset($_GET['mod'])){
	$mod ='view';
}elseif(!isset($_GET['mod'])){
	$mod = 'index';
}
$now = $mod;

$_lang = lang('plugin/gongqiu');

$style = $gongqiu_config['style'];
require DISCUZ_ROOT.'./source/plugin/gongqiu/module/'.$mod.'.inc.php';
?>