<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_ADMINCP')){	exit('Admin Login');}
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}
global $gongqiu_config,$_lang;
require_once DISCUZ_ROOT.'./source/plugin/gongqiu/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/gongqiu/include/function.class.php';

$mod = "admin_cat";
$form_url = 'plugins&operation=config&identifier=gongqiu&pmod='.$mod."&do=".$do;
$cp_url ='action='.$form_url;
$now_url = ADMINSCRIPT."?".$cp_url;

$cat_pid =!empty($_GET['cat_pid']) ? intval($_GET['cat_pid']) : 0;

if(isset($_GET['submit'])){
	$post = array();
	$post = gpc('cat_');
	DB::insert('gongqiu_cat',$post);
}

if(isset($_GET['del'])){
	$del['cat_id'] = intval($_GET['del']);
	DB::delete('gongqiu_cat',$del);
}
if(isset($_GET['edit'])){
	$edit =  intval($_GET['edit']);
	$edit_array= array();
	$query =DB::query('SELECT * FROM '.DB::table('gongqiu_cat').' WHERE cat_id='.$edit.' ORDER BY cat_pid DESC,cat_sort ASC');
	while($tem = DB::fetch($query)){
		$edit_array[] = $tem;
	}
	$edit_array = $edit_array[0];
}

if(isset($_GET['edit_submit'])){
	$edit_array = array();
	$edit_array = gpc('cat_');
	DB::update('gongqiu_cat',$edit_array,array('cat_id'=>$edit_array['cat_id']));
}

$cat_array =array();
$sql = 'SELECT * FROM '.DB::table('gongqiu_cat');
$sql .= ' ORDER BY cat_pid ASC,cat_sort ASC';

$query =DB::query($sql);if( !cloudaddons_getmd5("gongqiu.plugin") ) {/*	cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "gongqiu.plugin"));*/}
while($tem = DB::fetch($query)){
	$cat_array[] = $tem;
}

$pid_cat_array = array();
$pid_cat_array = fetch_all("gongqiu_cat"," WHERE cat_id='{$cat_pid}' ","*",0);

$style ='default';
include template("gongqiu:admin/admin_cat");
?>
