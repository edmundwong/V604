<?php
if(!defined('IN_ADMINCP')){	exit('Admin Login');}
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}
include ("include/config.class.php");
include ("include/function.class.php");

$mod = "admin_category";
$self_url = 'plugins&operation=config&identifier=sale&pmod='.$mod;
$cp_url ='action='.$self_url;
$_lang = lang('plugin/sale');
if(getgpc('admin_submit')){
	DB::insert('sale_category',gpc('category_'));
}

if(isset($_GET['del'])){
	$category_id = intval($_GET['del']);
	DB::delete('sale_category',array('category_id'=>$category_id));
}

if(getgpc('edit')){
	$edit = intval($_GET['edit']);
	$edit_array= array();
	$edit_array = fetch_all('sale_category'," WHERE category_id='{$edit}' ORDER BY category_level DESC,category_sort ASC");
	$edit_array = $edit_array[0];
}

if(getgpc('edit_submit')){
	$edit_array = gpc('category_');
	DB::update('sale_category',$edit_array,array('category_id'=>$edit_array['category_id']));
}

$category_array =array();
$category_array =fetch_all('sale_category'," ORDER BY category_level DESC,category_sort ASC");

include template("sale:admin/admin_category");
?>