<?php
/**
 *      ��Ȩ����: �ó���Ϊ [DiscuzCMS!] ������������, ����ӵ�иò�Ʒ֪ʶ��Ȩ,���д����Ȩ��[DiscuzCMS!]����, �����ھ�Ϊ��ҵ����, ��Ϊ�������ṩʹ����Ȩ.
 *		��������: δ���ٷ���Ȩʹ���޸Ļ��ߴ�������������Ȩ��Υ����Ϊ, ������׷��һ����ط�������.
 *		�ٷ���վ: http://www.DiscuzCMS.com 
**/

if(!defined('IN_ADMINCP')){	exit('Admin Login');}
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}
global $gongqiu_config,$_lang;
require_once DISCUZ_ROOT.'./source/plugin/gongqiu/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/gongqiu/include/function.class.php';

$mod = "admin_jubao";
$self_url = 'plugins&operation=config&identifier=gongqiu&pmod='.$mod."&do=".$do;
$cp_url ='action='.$self_url;
if( !cloudaddons_getmd5("gongqiu.plugin") ) {/*	cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "gongqiu.plugin"));*/}
if(isset($_GET['del'])){
	$jubao_id = intval($_GET['del']);
	DB::delete('gongqiu_jubao',array('jubao_id'=>$jubao_id));
}

$jubao_array = fetch_all('gongqiu_jubao'," ORDER BY jubao_time DESC");

$style ='default';
include template("gongqiu:admin/admin_jubao");
?>