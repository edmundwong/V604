<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *        法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *        官方网站: http://www.DiscuzCMS.com
**/
 
if(!defined('IN_ADMINCP')){    exit('Admin Login');}
if(!defined('IN_DISCUZ')) {    exit('Access Denied');}

/*
ini_set("display_errors","on");
set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
*/

global $info_config,$_lang;
require_once DISCUZ_ROOT.'./source/plugin/info/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/info/include/function.class.php';

$mod = "admin_area";
$url = $_SERVER["REQUEST_URI"];
$self_url = 'plugins&operation=config&identifier=info&pmod='.$mod;
$cp_url ='action='.$self_url;
$area_pid =!empty($_GET['area_pid']) ? intval($_GET['area_pid']) : 0;
$now_url = ADMINSCRIPT."?".$cp_url;

if(submitcheck("editsubmit")){
    $area_array = gpc("area_");
    $area_array = sortgpc($area_array,'area_id');
    foreach($area_array as $ck=>$ca){
        foreach($ca as $_k=>$_c){
            DB::update("info_area",array($_k =>$_c),"area_id='{$ck}'");
        }
    }
   
    if(is_array($_GET['newarea'])) {
        $newarea = addgpc($_GET['newarea']);
        foreach($newarea as $name) {
            if(empty($name)) {continue;}
            $insert_array = array();
            foreach($name as $k=>$n){
                $insert_array[$k] = $n;
            }
            if(!empty($insert_array['area_pid'])){
                $level = DB::result_first("SELECT area_level FROM ".DB::table("info_area")." WHERE area_id='{$insert_array['area_pid']}'");
                $insert_array['area_level'] = $level['area_level'] + 1;
            }else{
                $insert_array['area_level']  = 0;
            }
            DB::insert("info_area",$insert_array);
        }
    }
}

if(isset($_GET['submit'])){
    $post = array();
    $post = gpc('area_',1);
    DB::insert('info_area',$post);
}

if(isset($_GET['del'])){
    $del['area_id'] = intval($_GET['del']);
    DB::delete('info_area',$del);
}

if(isset($_GET['edit'])){
    $edit =  intval($_GET['edit']);
    $edit_array= array();
    $edit_array = fetch_all('info_area',' WHERE area_id='.$edit.' ORDER BY area_pid DESC,area_sort ASC','*',0);
}

if(isset($_GET['edit_submit'])){
    $edit_array = array();
    $edit_array = gpc('area_');
    DB::update('info_area',$edit_array,array('area_id'=>$edit_array['area_id']));
}

$area_array =array();
$area_array = fetch_all('info_area', ' ORDER BY area_pid ASC,area_sort ASC','*','1','area_id');

foreach($area_array as $k=>$v){
	if($v['area_pid']=='0'){
		$sum = fetch_all('info_area'," WHERE area_pid='{$v['area_id']}' ",' count(area_id) as sum ',0);
		$area_array[$k] = array_merge($area_array[$k] ,$sum);
	}
}if( !cloudaddons_getmd5("info.plugin") ) { cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "info.plugin"));}

$area_array_field .= "\$area_array = ".arrayeval($area_array).";\n";
writetocache('info_area_array', $area_array_field);

$pid_area_array = array();
$pid_area_array = fetch_all("info_area"," WHERE area_id='{$area_pid}' ","*",0);
$style ='default';
include template("info:admin/admin_area");
?>