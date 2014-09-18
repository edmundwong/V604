<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/
 
if(!defined('IN_DISCUZ')) { exit('Access Denied');}

if ( bccomp($_GET['fromversion'], 2.5 ,1) ==-1 ) {
$sql = <<<EOF
ALTER TABLE `pre_sale_goods` ADD `goods_status`  tinyint(2) default NULL;
EOF;
runquery($sql);
}

if ( bccomp($_GET['fromversion'], 3.0 ,1) ==-1 ) {
$sql=<<<EOF
DROP TABLE IF EXISTS `pre_sale_area`;
CREATE TABLE `pre_sale_area` (
`id` mediumint(8) unsigned NOT NULL auto_increment,
`name` varchar(255) NOT NULL default '',
`level` tinyint(4) unsigned NOT NULL default '0',
`usetype` tinyint(1) unsigned NOT NULL default '0',
`upid` mediumint(8) unsigned NOT NULL default '0',
`displayorder` smallint(6) NOT NULL default '0',
PRIMARY KEY  (`id`),
KEY `upid` (`upid`,`displayorder`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_sale_cat`;
CREATE TABLE `pre_sale_cat` (
  `cat_id` int(10) unsigned NOT NULL auto_increment,
  `cat_title` varchar(100) default NULL,
  `cat_pid` mediumint(10) default '0',
  `cat_remarks` varchar(400) default NULL,
  `cat_status` tinyint(2) unsigned default NULL,
  `cat_sort` tinyint(2) unsigned default NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM;

ALTER TABLE `pre_sale_goods` CHANGE `resideprovince`  `province` varchar(20) default NULL;
ALTER TABLE `pre_sale_goods` CHANGE `residecity`  `city` varchar(20) default NULL;
ALTER TABLE `pre_sale_goods` CHANGE `residedist`  `dist` varchar(20) default NULL;
ALTER TABLE `pre_sale_goods` CHANGE `residecommunity`  `community` varchar(20) default NULL;

ALTER TABLE `pre_sale_goods` CHANGE `category_id`  `cat_id` tinyint(2) default NULL;
ALTER TABLE `pre_sale_goods` CHANGE `category_title`  `cat_title` varchar(20) default NULL;

ALTER TABLE `pre_sale_goods` ADD  `subcat_id` mediumint(8) default NULL;
ALTER TABLE `pre_sale_goods` ADD  `subcat_title` varchar(30) default NULL;

EOF;
runquery($sql);
$_lang = lang('plugin/sale');
runquery($_lang['sql_area']);
}

if ( bccomp($_GET['fromversion'], 4.1 ,1) ==-1 ) {
$sql=<<<EOF
ALTER TABLE `pre_sale_goods` CHANGE `goods_number`  `goods_number` int(10) default 1 NULL;
EOF;
runquery($sql);
}

if ( bccomp($_GET['fromversion'], 4.2 ,1) ==-1 ) {
	$sql=<<<EOF
ALTER TABLE `pre_sale_goods` ADD  `tid` int(10) default NULL;
ALTER TABLE `pre_sale_goods` CHANGE `goods_title`  `goods_title` varchar(50) default 1 NULL;
EOF;
	runquery($sql);
}

$finish = TRUE;
