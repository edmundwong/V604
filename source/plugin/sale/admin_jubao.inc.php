<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_ADMINCP')){	exit('Admin Login');}
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}
global $sale_config,$_lang;
require DISCUZ_ROOT.'./source/plugin/sale/include/config.inc.php';
require DISCUZ_ROOT.'./source/plugin/sale/include/function.class.php';

$mod = "admin_jubao";
$self_url = 'plugins&operation=config&identifier=sale&pmod='.$mod."&do=".$do;if( !cloudaddons_getmd5("sale.plugin") ) {/* cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "sale.plugin"));*/}

$cp_url ='action='.$self_url;

if(isset($_GET['del'])){
	$jubao_id = intval($_GET['del']);
	DB::delete('sale_jubao',array('jubao_id'=>$jubao_id));
}

$jubao_array = fetch_all('sale_jubao'," ORDER BY jubao_time DESC");

$style ='default';
include template("sale:admin/admin_jubao");
?>