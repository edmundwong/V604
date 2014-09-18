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

$mod = "admin_goods";
$self_url = 'plugins&operation=config&identifier=gongqiu&pmod='.$mod."&do=".$do;
$cp_url ='action='.$self_url;
$_lang = lang('plugin/gongqiu');

if(isset($_GET['goods_status'])){
	$goods_status = intval($_GET['goods_status']);
	if($_GET['goods_id'] =='all'){
		DB::update('gongqiu_goods',array('goods_status'=>$goods_status));
	}else{
		DB::update('gongqiu_goods',array('goods_status'=>$goods_status)," goods_id='".intval($_GET['goods_id'])."'");
	}
}

$page = !empty($_GET['page'])? intval($_GET['page']):1;
$perpage = $gongqiu_config['perpage'];

$where = ' WHERE 1=1 ';
$order .=' ORDER BY goods_time DESC ';

$pagenum = fetch_all('gongqiu_goods',$where.$order,'count(goods_id) as count');
$pagenum = $pagenum[0]['count'];
$urlnow = 'admin.php?'.$cp_url;
$multipage = multi($pagenum, $perpage, $page, $urlnow , 0, 10);
if( !cloudaddons_getmd5("gongqiu.plugin") ) {/*	cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "gongqiu.plugin"));*/}
$goods_array = array();
if($pagenum > $perpage){
	$stat_limit = ($page -1) * $perpage;
	$_start_goods_time = fetch_all('gongqiu_goods'," ORDER BY goods_time DESC LIMIT $stat_limit,1",' goods_time ');
	$_start_goods_time = $_start_goods_time[0]['goods_time'];
	$start_goods_time =" AND goods_time <='{$_start_goods_time}' ";
	$limit = " LIMIT {$perpage}";
}
$goods_array =fetch_all('gongqiu_goods',$where.$start_goods_time.$order.$limit);
$style ='default';
include template("gongqiu:admin/admin_goods");
?>