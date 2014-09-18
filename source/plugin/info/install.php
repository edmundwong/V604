<?php
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}

$sql =<<<EOF
DROP TABLE IF EXISTS `pre_info_area`;
CREATE TABLE `pre_info_area` (
  `area_id` int(10) NOT NULL auto_increment,
  `area_title` varchar(40) default NULL,
  `area_pid` mediumint(9) default NULL,
  `area_sort` tinyint(2) default NULL,
  `area_hot` tinyint(2) default NULL,
  `area_key` varchar(10) default NULL,
  `area_level` varchar(10) default NULL,
  PRIMARY KEY  (`area_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_info_cat`;
CREATE TABLE `pre_info_cat` (
  `cat_id` int(10) unsigned NOT NULL auto_increment,
  `cat_title` varchar(100) default NULL,
  `cat_pid` mediumint(10) default '0',
  `cat_sort` tinyint(2) unsigned default NULL,
  `cat_level` tinyint(2) default NULL,
  `cat_color` varchar(20) default NULL,
  `cat_mod` varchar(100) default NULL,
  `cat_mod_id` int(10) default NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_info_member`;
CREATE TABLE `pre_info_member` (
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

DROP TABLE IF EXISTS `pre_info_member_fav`;
CREATE TABLE `pre_info_member_fav` (
  `user_id` int(10) NOT NULL,
  `post_id` int(10) NOT NULL default '0',
  `post_title` varchar(40) default NULL,
  `fav_time` varchar(10) default NULL,
  PRIMARY KEY  (`user_id`,`post_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_info_member_profile`;
CREATE TABLE `pre_info_member_profile` (
  `member_uid` int(10) NOT NULL default '0',
  `profile_setting_name` varchar(20) NOT NULL default '0',
  `profile_setting_title` varchar(40) NOT NULL,
  `post_profile_title` varchar(200) NOT NULL,
  PRIMARY KEY  (`member_uid`,`profile_setting_name`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_info_post`;
CREATE TABLE `pre_info_post` (
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
  `area_title` varchar(60) default NULL,
  `subarea_title` varchar(60) default NULL,
  `thrarea_title` varchar(60) default NULL,
  `tid` int(10) default NULL,
  `post_map` varchar(60) default NULL,
  `area_id` int(10) default NULL,
  `subarea_id` int(10) default NULL,
  `thrarea_id` int(10) default NULL,
  `cat_id` int(10) default NULL,
  `cat_title` varchar(100) default NULL,
  `subcat_id` int(10) default NULL,
  `subcat_title` varchar(100) default NULL,
  `post_price` int(10) default NULL,
  `post_price_unit` varchar(100) default NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_info_post_jubao`;
CREATE TABLE `pre_info_post_jubao` (
  `jubao_id` int(10) NOT NULL auto_increment,
  `post_id` int(10) default NULL,
  `post_title` varchar(40) default NULL,
  `jubao_time` varchar(10) default NULL,
  PRIMARY KEY  (`jubao_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_info_post_profile`;
CREATE TABLE `pre_info_post_profile` (
  `post_id` int(10) NOT NULL default '0',
  `profile_setting_name` varchar(20) NOT NULL default '0',
  `profile_setting_title` varchar(40) NOT NULL,
  `post_profile_title` varchar(2000) NOT NULL,
  PRIMARY KEY  (`post_id`,`profile_setting_name`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_info_post_up`;
CREATE TABLE `pre_info_post_up` (
  `post_id` int(10) NOT NULL default '0',
  `post_title` varchar(40) default NULL,
  `up_day` smallint(3) default NULL,
  `up_endtime` varchar(10) default NULL,
  `up_time` varchar(10) default NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_info_profile_setting`;
CREATE TABLE `pre_info_profile_setting` (
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

DROP TABLE IF EXISTS `pre_info_profile_type`;
CREATE TABLE `pre_info_profile_type` (
  `profile_type_id` int(10) NOT NULL auto_increment,
  `profile_type_title` varchar(40) default NULL,
  `profile_type_status` tinyint(2) default NULL,
  PRIMARY KEY  (`profile_type_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `pre_info_profile_type_setting`;
CREATE TABLE `pre_info_profile_type_setting` (
  `profile_type_setting_id` int(10) NOT NULL auto_increment,
  `profile_setting_name` varchar(20) NOT NULL,
  `profile_setting_title` varchar(40) default NULL,
  `profile_type_id` int(10) default NULL,
  `profile_type_setting_sort` tinyint(2) default '0',
  `profile_type_setting_status` tinyint(2) default '1',
  `profile_type_setting_jiage` tinyint(2) default NULL,
  PRIMARY KEY  (`profile_type_setting_id`)
) ENGINE=MyISAM;

EOF;
//INSERT INTO `pre_common_cron` (available,type,name,filename,lastrun,nextrun,weekday,day,hour,minute) VALUES ('1', 'user', 'cms_info', 'cms_info.php', '1353571728', '1353600060', '-1', '-1', '0', '1');
runquery($sql);

$info_lang = lang('plugin/info');
runquery($info_lang['sql_area']);
runquery($info_lang['sql_cat']);
runquery($info_lang['sql_profile_setting']);
runquery($info_lang['sql_profile_type']);
runquery($info_lang['sql_profile_type_setting']);
$finish = true;
?>