<?php

if(!defined('IN_DISCUZ')) {	exit('Access Denied');}

$sql =<<<EOF
DROP TABLE IF EXISTS `pre_house_area`;
CREATE TABLE `pre_house_area` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `level` tinyint(4) unsigned NOT NULL default '0',
  `usetype` tinyint(1) unsigned NOT NULL default '0',
  `upid` mediumint(8) unsigned NOT NULL default '0',
  `displayorder` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `upid` (`upid`,`displayorder`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_loupan`;
CREATE TABLE `pre_house_loupan` (
  `loupan_id` int(10) NOT NULL auto_increment,
  `loupan_title` varchar(30)  default NULL,
  `loupan_company` varchar(50)  default NULL,
  `loupan_wuye` varchar(50)  default NULL,
  `loupan_type` varchar(30)  default NULL,
  `loupan_park` varchar(50)  default NULL,
  `loupan_traffic` varchar(50)  default NULL,
  `loupan_date` varchar(30)  default NULL,
  `province` varchar(60)  default NULL,
  `city` varchar(60)  default NULL,
  `dist` varchar(60)  default NULL,
  `community` varchar(60)  default NULL,
  `loupan_img` varchar(200)  default NULL,
  `loupan_text` text ,
  `loupan_map` varchar(50)  default NULL,
  `loupan_addr` varchar(200)  default NULL,
  `loupan_junjia` varchar(100)  default NULL,
  `loupan_zhuli` varchar(500)  default NULL,
  `loupan_worktime` varchar(200)  default NULL,
  `loupan_tel` varchar(100)  default NULL,
  `loupan_zhoubian` varchar(2000)  default NULL,
  PRIMARY KEY  (`loupan_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_loupan_kan`;
CREATE TABLE `pre_house_loupan_kan` (
  `kan_id` int(10) NOT NULL auto_increment,
  `loupan_id` int(10) default NULL,
  `kan_phone` varchar(20)  default NULL,
  `kan_name` varchar(20)  default NULL,
  `kan_dateline` varchar(10)  default NULL,
  PRIMARY KEY  (`kan_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_loupan_img`;
CREATE TABLE `pre_house_loupan_img` (
  `img_id` int(10) NOT NULL auto_increment,
  `loupan_id` int(10) default NULL,
  `img_cat_title` varchar(100)  default NULL,
  `img_cat_id` int(10) default NULL,
  `img_pic` varchar(200)  default NULL,
  `img_title` varchar(100)  default NULL,
  `img_text` varchar(200)  default NULL,
  PRIMARY KEY  (`img_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_member`;
CREATE TABLE `pre_house_member` (
  `member_uid` mediumint(10) default NULL,
  `member_title` varchar(20)  default NULL,
  `member_qq` varchar(15)  default NULL,
  `member_phone` varchar(20)  default NULL,
  `member_email` varchar(20)  default NULL,
  `member_address` varchar(50)  default NULL,
  `member_time` varchar(10)  default NULL,
  `profile_type_id` int(10) default NULL,
  `profile_type_title` varchar(20)  default NULL
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_member_fav`;
CREATE TABLE `pre_house_member_fav` (
  `user_id` int(10) NOT NULL,
  `post_id` int(10) NOT NULL default '0',
  `post_title` varchar(40) default NULL,
  `fav_time` varchar(10) default NULL,
  PRIMARY KEY  (`user_id`,`post_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_member_profile`;
CREATE TABLE `pre_house_member_profile` (
  `member_uid` int(10) NOT NULL default '0',
  `profile_setting_name` varchar(20) NOT NULL default '0',
  `profile_setting_title` varchar(40) NOT NULL,
  `post_profile_title` varchar(200) NOT NULL,
  PRIMARY KEY  (`member_uid`,`profile_setting_name`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_post`;
CREATE TABLE `pre_house_post` (
  `post_id` int(10) NOT NULL auto_increment,
  `post_title` varchar(40) default NULL,
  `post_text` text,
  `post_up` tinyint(2) default '0',
  `post_time` varchar(10) default NULL,
  `post_view` mediumint(10) default '0',
  `post_ip` varchar(20) default NULL,
  `post_ip_adr` varchar(20) default NULL,
  `post_img_1` varchar(150) default NULL,
  `post_img_2` varchar(150) default NULL,
  `post_img_3` varchar(150) default NULL,
  `post_img_4` varchar(150) default NULL,
  `post_begin_time` varchar(10) default NULL,
  `post_end_time` varchar(10) default NULL,
  `member_uid` mediumint(10) default NULL,
  `member_title` varchar(60) default NULL,
  `profile_type_id` int(10) default '1',
  `profile_type_title` varchar(40) default NULL,
  `up_endtime` varchar(10) default NULL,
  `loupan_id` int(10) default NULL,
  `loupan_title` varchar(60) default NULL,
  `province` varchar(60) default NULL,
  `city` varchar(60) default NULL,
  `dist` varchar(60) default NULL,
  `community` varchar(60) default NULL,
  `tid` int(10) default NULL,
  `post_map` varchar(60) default NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_post_jubao`;
CREATE TABLE `pre_house_post_jubao` (
  `jubao_id` int(10) NOT NULL auto_increment,
  `post_id` int(10) default NULL,
  `post_title` varchar(40) default NULL,
  `jubao_time` varchar(10) default NULL,
  PRIMARY KEY  (`jubao_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_post_profile`;
CREATE TABLE `pre_house_post_profile` (
  `post_id` int(10) NOT NULL default '0',
  `profile_setting_name` varchar(20) NOT NULL default '0',
  `profile_setting_title` varchar(40) NOT NULL,
  `post_profile_title` varchar(2000) NOT NULL,
  PRIMARY KEY  (`post_id`,`profile_setting_name`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_post_up`;
CREATE TABLE `pre_house_post_up` (
  `post_id` int(10) NOT NULL default '0',
  `post_title` varchar(40) default NULL,
  `up_day` smallint(3) default NULL,
  `up_endtime` varchar(10) default NULL,
  `up_time` varchar(10) default NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_profile_setting`;
CREATE TABLE `pre_house_profile_setting` (
  `profile_setting_name` varchar(20) NOT NULL,
  `profile_setting_title` varchar(40) default NULL,
  `profile_setting_status` tinyint(1) default '0',
  `profile_setting_required` tinyint(1) default '0',
  `profile_setting_allowsearch` tinyint(1) default '0',
  `profile_setting_formtype` varchar(10) default 'select',
  `profile_setting_choices` varchar(200) default NULL,
  `profile_setting_size` smallint(2) default '0',
  `profile_setting_unit` varchar(20) default NULL,
  PRIMARY KEY  (`profile_setting_name`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_profile_type`;
CREATE TABLE `pre_house_profile_type` (
  `profile_type_id` int(10) NOT NULL auto_increment,
  `profile_type_title` varchar(40) default NULL,
  `profile_type_status` tinyint(2) default NULL,
  PRIMARY KEY  (`profile_type_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_house_profile_type_setting`;
CREATE TABLE `pre_house_profile_type_setting` (
  `profile_type_setting_id` int(10) NOT NULL auto_increment,
  `profile_setting_name` varchar(20) NOT NULL,
  `profile_setting_title` varchar(40) default NULL,
  `profile_type_id` int(10) default NULL,
  `profile_type_setting_sort` tinyint(2) default '0',
  `profile_type_setting_status` tinyint(2) default '1',
  PRIMARY KEY  (`profile_type_setting_id`)
) ENGINE=MyISAM;

INSERT INTO `pre_common_cron` (available,type,name,filename,lastrun,nextrun,weekday,day,hour,minute) VALUES ('1', 'user', 'cms_house', 'cms_house.php', '1353571728', '1353600060', '-1', '-1', '0', '1');
EOF;
runquery($sql);

$house_lang = lang('plugin/house');

runquery($house_lang['sql_area']);
runquery($house_lang['sql_profile_setting']);
runquery($house_lang['sql_profile_type']);
runquery($house_lang['sql_profile_type_setting']);

$finish = true;
?>