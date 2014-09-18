<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

loadcache('plugin');
$house_config = $_G['cache']['plugin']['house'];

$house_config['root'] = $house_config['siteurl']."house.php";
$house_config['uc'] = $_G['ucenterurl'];
$house_config['house'] = $house_config['siteurl']."source/plugin/house/";
$shenlan_pindao = $house_config['shenlan_pindao'];
$_G['disabledwidthauto'] = 0;
$house_lang = lang('plugin/house');

$loupan_cat = array();
$loupan_cat[1] = array('loupan_cat_id'=>1,'loupan_cat_title'=>"{$house_lang['config_inc_php_1']}");
$loupan_cat[2] = array('loupan_cat_id'=>2,'loupan_cat_title'=>"{$house_lang['config_inc_php_2']}");
$loupan_cat[3] = array('loupan_cat_id'=>3,'loupan_cat_title'=>"{$house_lang['config_inc_php_3']}");
$loupan_cat[4] = array('loupan_cat_id'=>4,'loupan_cat_title'=>"{$house_lang['loupan_type_6']}");

?>