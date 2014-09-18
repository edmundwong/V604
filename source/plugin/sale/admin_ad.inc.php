<?php
if(!defined('IN_ADMINCP')){	exit('Admin Login');}
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}
include ("include/config.class.php");
include ("include/function.class.php");

$mod = "admin_ad";
$self_url = 'plugins&operation=config&identifier=sale&pmod='.$mod;
$cp_url ='action='.$self_url;

if(getgpc('admin_submit')){
	$post = gpc('ad_');
	$ad_count = fetch_all('sale_ad',""," count(ad_id) as a ");
	$ad_count = $ad_count[0]['a'];
	if($ad_count >=7){
		cpmsg($_lang['max7'],$cp_url,'error');
	}else{
		DB::insert('sale_ad',$post);
	}
}

if(isset($_GET['del'])){
	$ad_id = intval($_GET['del']);
	DB::delete('sale_ad',array('ad_id'=>$ad_id));
}

if(getgpc('edit')){
	$edit = getgpc('edit');
	$edit_array= array();
	$edit_array = fetch_all('sale_ad',' WHERE category_id='.$edit.' ORDER BY category_level DESC,category_sort ASC');
	$edit_array = $edit_array[0];
}

$ad_array = fetch_all('sale_ad'," ORDER BY ad_id ASC");
include template("sale:admin/admin_ad");
?>