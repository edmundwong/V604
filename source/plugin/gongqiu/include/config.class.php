<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
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