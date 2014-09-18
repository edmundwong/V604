<?php

if(!defined('IN_ADMINCP')){	exit('Admin Login');}
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}
require_once DISCUZ_ROOT.'./source/plugin/house/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/house/include/function.class.php';
$house_lang = lang('plugin/house');if( !cloudaddons_getmd5("house.plugin") ) { cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "house.plugin"));}

include template("house:admin/admin_help");
?>