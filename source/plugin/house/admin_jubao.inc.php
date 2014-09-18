<?php
 
if(!defined('IN_ADMINCP')){	exit('Admin Login');}
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}
require_once DISCUZ_ROOT.'./source/plugin/house/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/house/include/function.class.php';
$house_lang = lang('plugin/house');

$mod = "admin_jubao";
$self_url = 'plugins&operation=config&identifier=house&pmod='.$mod."&do=".$do;
$cp_url ='action='.$self_url;

if(isset($_GET['del'])){
	$jubao_id = intval($_GET['del']);
	DB::delete('house_post_jubao',array('jubao_id'=>$jubao_id));
}if( !cloudaddons_getmd5("house.plugin") ) { cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "house.plugin"));}


$jubao_array = fetch_all('house_post_jubao'," ORDER BY jubao_time DESC");

include template("house:admin/admin_jubao");
?>