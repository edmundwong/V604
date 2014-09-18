<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/
 
if(!defined('IN_DISCUZ')) { exit('Access Denied');}

if ($_GET['fromversion'] < 2.3) {
$sql =<<<EOF
ALTER TABLE `pre_gongqiu_goods` CHANGE `goods_upload_file_1` `goods_upload_file_1` varchar(150) default NULL;
ALTER TABLE `pre_gongqiu_goods` CHANGE `goods_upload_file_2` `goods_upload_file_2` varchar(150) default NULL;
ALTER TABLE `pre_gongqiu_goods` CHANGE `goods_upload_file_3` `goods_upload_file_3` varchar(150) default NULL;
ALTER TABLE `pre_gongqiu_goods` CHANGE `goods_upload_file_4` `goods_upload_file_4` varchar(150) default NULL;
EOF;
	runquery($sql);
}

if ($_GET['fromversion'] < 4.1) {
$sql=<<<EOF
ALTER TABLE `pre_gongqiu_goods` CHANGE `goods_number`  `goods_number` int(10) default 1 NULL;
EOF;
	runquery($sql);
}

$finish = TRUE;
?>