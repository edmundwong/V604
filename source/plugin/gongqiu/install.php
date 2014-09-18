<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql =<<<EOF
DROP TABLE IF EXISTS `pre_gongqiu_area`;
CREATE TABLE `pre_gongqiu_area` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `level` tinyint(4) unsigned NOT NULL default '0',
  `usetype` tinyint(1) unsigned NOT NULL default '0',
  `upid` mediumint(8) unsigned NOT NULL default '0',
  `displayorder` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `upid` (`upid`,`displayorder`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_gongqiu_cat`;
CREATE TABLE `pre_gongqiu_cat` (
  `cat_id` int(10) unsigned NOT NULL auto_increment,
  `cat_title` varchar(100) default NULL,
  `cat_pid` mediumint(10) default '0',
  `cat_remarks` varchar(400) default NULL,
  `cat_status` tinyint(2) unsigned default NULL,
  `cat_sort` tinyint(2) unsigned default NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_gongqiu_goods`;
CREATE TABLE `pre_gongqiu_goods` (
  `goods_id` int(10) NOT NULL auto_increment,
  `goods_title` varchar(20)  default NULL,
  `goods_status`		tinyint(2) default NULL,
  `cat_id` tinyint(2) default NULL,
  `cat_title` varchar(20)  default NULL,
  `subcat_id` tinyint(2) default NULL,
  `subcat_title` varchar(20)  default NULL,
  
  `province` varchar(20)  default NULL,
  `city` varchar(20)  default NULL,
  `dist` varchar(20)  default NULL,
  `community` varchar(20)  default NULL,
  
  `goods_text` text ,
  `goods_up` tinyint(2) default '0',
  `goods_time` varchar(10)  default NULL,

  `goods_price` int(10) default '1',
  `goods_number` int(10) default '1',
  `goods_view` int(10) default '0',
  
  `member_uid` mediumint(10) default NULL,
  `member_username` varchar(20)  default NULL,
  
  `goods_ip` varchar(20)  default NULL,
  `goods_ip_adr` varchar(20)  default NULL,
  
  `goods_settime` varchar(10)  default NULL,
  `goods_upload_file_1` varchar(150)  default NULL,
  `goods_upload_file_2` varchar(150)  default NULL,
  `goods_upload_file_3` varchar(150)  default NULL,
  `goods_upload_file_4` varchar(150)  default NULL,
  
  `goods_type`  tinyint(2)  default NULL,
  `goods_howtopay` tinyint(2) default '1',
    
  `up_endtime` varchar(10)  default NULL,
  PRIMARY KEY  (`goods_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_gongqiu_jubao`;
CREATE TABLE `pre_gongqiu_jubao` (
  `jubao_id` int(10) NOT NULL auto_increment,
  `goods_id` int(10) default NULL,
  `goods_title` varchar(40)  default NULL,
  `jubao_time` varchar(10)  default NULL,
  PRIMARY KEY  (`jubao_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_gongqiu_member`;
CREATE TABLE `pre_gongqiu_member` (
  `member_uid` mediumint(10) default NULL,
  `member_username` varchar(20)  default NULL,
  `member_qq` varchar(15)  default NULL,
  `member_phone` varchar(20)  default NULL,
  `member_time` varchar(10)  default NULL,
  `member_email` varchar(20)  default NULL
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_gongqiu_up`;
CREATE TABLE `pre_gongqiu_up` (
  `goods_id` int(10) NOT NULL default '0',
  `goods_title` varchar(40)  default NULL,
  `up_day` smallint(3) default NULL,
  `up_endtime` varchar(10)  default NULL,
  `up_time` varchar(10)  default NULL,
  PRIMARY KEY  (`goods_id`)
) ENGINE=MyISAM;
EOF;

runquery($sql);

$_lang = lang('plugin/gongqiu');
runquery($_lang['sql_area']);
$finish = true;
?>