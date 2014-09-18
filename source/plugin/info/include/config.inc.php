<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

loadcache('plugin');
$info_config = $_G['cache']['plugin']['info'];

//$info_config['root'] = $info_config['siteurl']."info.php";
$info_config['root'] = "/info.php";
$info_config['uc'] = $_G['ucenterurl'];
//$info_config['info'] = $info_config['siteurl']."source/plugin/info/";
$info_config['info'] = "/source/plugin/info/";
$shenlan_pindao = $info_config['shenlan_pindao'];
$_G['disabledwidthauto'] = 0;
$_lang = lang('plugin/info');
$info_lang = lang('plugin/info');
$info_config['siteurl'] = '/';

?>