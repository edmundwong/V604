<?php
 
if(!defined('IN_ADMINCP')){	exit('Admin Login');}
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}
require_once DISCUZ_ROOT.'./source/plugin/info/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/info/include/function.class.php';
$info_lang = lang('plugin/info');

$mod = "admin_jubao";
$self_url = 'plugins&operation=config&identifier=info&pmod='.$mod."&do=".$do;
$cp_url ='action='.$self_url;

if(isset($_GET['del'])){
	$jubao_id = intval($_GET['del']);
	DB::delete('info_post_jubao',array('jubao_id'=>$jubao_id));
}if( !cloudaddons_getmd5("info.plugin") ) { cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "info.plugin"));}

$jubao_array = fetch_all('info_post_jubao'," ORDER BY jubao_time DESC");

include template("info:admin/admin_jubao");
?>