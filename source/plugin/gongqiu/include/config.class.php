<?php
/**
 *      ��Ȩ����: �ó���Ϊ [DiscuzCMS!] ������������, ����ӵ�иò�Ʒ֪ʶ��Ȩ,���д����Ȩ��[DiscuzCMS!]����, �����ھ�Ϊ��ҵ����, ��Ϊ�������ṩʹ����Ȩ.
 *		��������: δ���ٷ���Ȩʹ���޸Ļ��ߴ�������������Ȩ��Υ����Ϊ, ������׷��һ����ط�������.
 *		�ٷ���վ: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

loadcache('plugin');
$gongqiu_config = $_G['cache']['plugin']['gongqiu'];
$gongqiu_config['root'] = $gongqiu_config['siteurl']."gongqiu.php";
$gongqiu_config['uc'] = $_G['ucenterurl'];
$gongqiu_config['gongqiu'] = $gongqiu_config['siteurl']."source/plugin/gongqiu/";
$gongqiu_config['ue'] = $gongqiu_config['gongqiu']."ueditor/";

$_lang = lang('plugin/gongqiu');

$goods_type_array=array(
		"1"=>$_lang['gongyingxinxi'],
		"2"=>$_lang['xuqiuxinxi'],
		"3"=>$_lang['zhaoshangxinxi'],
		"4"=>$_lang['jiamengxinxi'],
	);
?>