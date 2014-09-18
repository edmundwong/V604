<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *        法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *        官方网站: http://www.DiscuzCMS.com
**/
 
if(!defined('IN_ADMINCP')){    exit('Admin Login');}
if(!defined('IN_DISCUZ')) {    exit('Access Denied');}

global $info_config,$_lang;
require_once DISCUZ_ROOT.'./source/plugin/info/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/info/include/function.class.php';

$mod = "admin_cat";
$url = $_SERVER["REQUEST_URI"];
$self_url = 'plugins&operation=config&identifier=info&pmod='.$mod;
$cp_url ='action='.$self_url;
$cat_pid =!empty($_GET['cat_pid']) ? intval($_GET['cat_pid']) : 0;
$now_url = ADMINSCRIPT."?".$cp_url;

if(submitcheck("editsubmit")){
    $cat_array = gpc("cat_");
    $cat_array = sortgpc($cat_array,'cat_id');
    foreach($cat_array as $ck=>$ca){
        foreach($ca as $_k=>$_c){
			DB::update("info_cat",array($_k =>$_c),"cat_id='{$ck}'");
        }
    }
   
    if(is_array($_GET['newcat'])) {
        $newcat = addgpc($_GET['newcat']);
        foreach($newcat as $name) {
            if(empty($name)) {continue;}
            $insert_array = array();
            foreach($name as $k=>$n){
                $insert_array[$k] = $n;
            }
            if(!empty($insert_array['cat_pid'])){
                $level = DB::result_first("SELECT cat_level FROM ".DB::table("info_cat")." WHERE cat_id='{$insert_array['cat_pid']}'");
                $insert_array['cat_level'] = $level['cat_level'] + 1;
            }else{
                $insert_array['cat_level']  = 0;
            }
            DB::insert("info_cat",$insert_array);
        }
    }
}

if(isset($_GET['submit'])){
    $post = array();
    $post = gpc('cat_',1);
    DB::insert('info_cat',$post);
}

if(isset($_GET['del'])){
	$del['cat_id'] = intval($_GET['del']);
	DB::delete('info_cat',$del);
}

if(isset($_GET['edit'])){
	$edit =  intval($_GET['edit']);
	$edit_array= array();
	$edit_array = fetch_all('info_cat',' WHERE cat_id='.$edit.' ORDER BY cat_pid DESC,cat_sort ASC','*',0);
}

if(isset($_GET['edit_submit'])){
	$edit_array = array();
	$edit_array = gpc('cat_');
	DB::update('info_cat',$edit_array,array('cat_id'=>$edit_array['cat_id']));
}

$cat_array =array();
$cat_array = brian_fetch_all('info_cat', ' ORDER BY cat_sort ASC',array('sort'=>'cat_id'));

brian_cat_cache();

$profile_type_array = fetch_all("info_profile_type"," ORDER BY profile_type_id ASC");if( !cloudaddons_getmd5("info.plugin") ) { cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "info.plugin"));}

$pid_cat_array = array();
$pid_cat_array = fetch_all("info_cat"," WHERE cat_id='{$cat_pid}' ","*",0);
$style ='default';
include template("info:admin/admin_cat");
?>


