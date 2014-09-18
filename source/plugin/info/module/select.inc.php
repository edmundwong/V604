<?php
if(!defined('IN_DISCUZ')) {exit('Access Denied');}
//if(empty($_G['uid']) ) {	showmessage($info_lang['login'],'',array(),array('login' => true));}

$cat_id = intval($_GET['cat_id']);

include template('info:'.$style.'/select');
?>