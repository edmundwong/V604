<?php

if(!defined('IN_DISCUZ')) {
   exit('Access Deined');
}

$sjxj_bbx_plugin = $_G['cache']['plugin']['sjxj_bbx'];

if(!$discuz_user && !$sjxj_bbx_plugin['guest'])showmessage('group_nopermission', NULL, 'NOPERM');
if($sjxj_bbx_plugin['close'] && $adminid != 1)showmessage($sjxj_bbx_plugin[message]);

include template('sjxj_bbx:index');
?>