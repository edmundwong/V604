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
if( !cloudaddons_getmd5("gongqiu.plugin") ) {/*	cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "gongqiu.plugin"));*/}
$style ='default';
include template("gongqiu:admin/admin_help");
?>