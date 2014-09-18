<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
loadcache('diytemplatename');

$op_array= array('fdjsq','gfpg','zsht');
$op = in_array($_GET['op'],$op_array) ?  addslashes($_GET['op']) : 'fdjsq';

include template("diy:../../source/plugin/info/template/{$style}/{$mod}/{$mod}_{$op}");
?>