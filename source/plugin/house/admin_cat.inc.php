<?php

if(!defined('IN_ADMINCP')){	exit('Admin Login');}
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}
require_once DISCUZ_ROOT.'./source/plugin/house/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/house/include/function.class.php';

$mod = "admin_cat";
$url = $_SERVER["REQUEST_URI"];
$self_url = 'plugins&operation=config&identifier=house&pmod='.$mod."&do=".$do;
$cp_url ='action='.$self_url;
$cat_pid =!empty($_GET['cat_pid']) ? intval($_GET['cat_pid']) : 0;

$house_lang = lang('plugin/house');

if(isset($_GET['submit'])){
	$post = array();
	$post = gpc('cat_');
	DB::insert('house_cat',$post);
}

if(isset($_GET['del'])){
	$del['cat_id'] = intval($_GET['del']);
	DB::delete('house_cat',$del);
}

if(isset($_GET['edit'])){
	$edit =  intval($_GET['edit']);
	$edit_array= array();
	$edit_array = fetch_all('house_cat',' WHERE cat_id='.$edit.' ORDER BY cat_pid DESC,cat_sort ASC','*',0);
}

if(isset($_GET['edit_submit'])){
	$edit_array = array();
	$edit_array = gpc('cat_');
	DB::update('house_cat',$edit_array,array('cat_id'=>$edit_array['cat_id']));
}

$cat_array =array();
$cat_array = fetch_all('house_cat', ' ORDER BY cat_pid ASC,cat_sort ASC');

foreach($cat_array as $k=>$v){
	if($v['cat_pid']=='0'){
		$sum = fetch_all('house_cat'," WHERE cat_pid='{$v['cat_id']}' ",' count(cat_id) as sum ',0);
		$cat_array[$k] = array_merge($cat_array[$k] ,$sum);
	}
}

$cat_array_field .= "\$cat_array = ".arrayeval($cat_array).";\n";
writetocache('house_cat_array', $cat_array_field);if( !cloudaddons_getmd5("house.plugin") ) { cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "house.plugin"));}

$pid_cat_array = array();
$pid_cat_array = fetch_all("house_cat"," WHERE cat_id='{$cat_pid}' ","*",0);

include template("house:admin/admin_cat");
?>
