<?php
if(!defined('IN_DISCUZ')) { exit('Access Denied');}
require_once DISCUZ_ROOT.'./source/plugin/house/include/function.class.php';

if ($_GET['fromversion'] < 2.3) {
$sql =<<<EOF
ALTER TABLE `pre_house_post` ADD `tid`  int(10) default '0';
EOF;
	shenlan_runquery($sql);
}

if ($_GET['fromversion'] < 4.1) {
$sql =<<<EOF
ALTER TABLE `pre_house_post` ADD `post_map`  varchar(60) default NULL;
EOF;
	shenlan_runquery($sql);

$house_lang = lang('plugin/house');
DB::query("TRUNCATE TABLE ".DB::table('house_profile_type'));
DB::query("TRUNCATE TABLE ".DB::table('house_profile_type_setting'));
	shenlan_runquery($house_lang['sql_profile_type']);
	shenlan_runquery($house_lang['sql_profile_type_setting']);
}

if ($_GET['fromversion'] < 4.3) {
	$sql =<<<EOF
ALTER TABLE `pre_house_loupan` ADD `loupan_addr`  varchar(200) default NULL;
ALTER TABLE `pre_house_loupan` ADD `loupan_junjia`  varchar(100) default NULL;
ALTER TABLE `pre_house_loupan` ADD `loupan_zhuli`  varchar(500) default NULL;
ALTER TABLE `pre_house_loupan` ADD `loupan_worktime`  varchar(200) default NULL;
ALTER TABLE `pre_house_loupan` ADD `loupan_tel`  varchar(100) default NULL;
ALTER TABLE `pre_house_loupan` ADD `loupan_zhoubian` varchar(2000)  default NULL;

CREATE TABLE `pre_house_loupan_img` (
  `img_id` int(10) NOT NULL auto_increment,
  `loupan_id` int(10) default NULL,
  `img_cat_title` varchar(100) collate gbk_bin default NULL,
  `img_cat_id` int(10) default NULL,
  `img_pic` varchar(200) collate gbk_bin default NULL,
  `img_title` varchar(100) collate gbk_bin default NULL,
  `img_text` varchar(200) collate gbk_bin default NULL,
  PRIMARY KEY  (`img_id`)
) ENGINE=MyISAM;

CREATE TABLE `pre_house_loupan_kan` (
  `kan_id` int(10) NOT NULL auto_increment,
  `loupan_id` int(10) default NULL,
  `kan_phone` varchar(20) collate gbk_bin default NULL,
  `kan_name` varchar(20) collate gbk_bin default NULL,
  `kan_dateline` varchar(10) collate gbk_bin default NULL,
  PRIMARY KEY  (`kan_id`)
) ENGINE=MyISAM;
EOF;
	shenlan_runquery($sql);
}

$finish = TRUE;
?>