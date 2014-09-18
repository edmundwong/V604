<?php
/*
	[55625.COM!] (C)2001-2009 55625 Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF

CREATE TABLE IF NOT EXISTS `pre_forum_alliance_ar` (
  `id` int(11) NOT NULL auto_increment,
  `xnum` int(11) NOT NULL default '50',
  `topid` int(10) NOT NULL,
  `cid` smallint(4) NOT NULL,
  `did` smallint(4) NOT NULL,
  `sad` varchar(4) NOT NULL,
  `uid` int(11) NOT NULL,
  `author` varchar(50) NOT NULL,
  `pic` text NOT NULL,
  `yy_ztime` varchar(255) NOT NULL,
  `yy_wtime` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `address` text NOT NULL,
  `tel` text NOT NULL,
  `tese` varchar(100) NOT NULL,
  `tenqq` varchar(50) NOT NULL,
  `taobao` varchar(200) NOT NULL,
  `summary` text NOT NULL,
  `discount` text NOT NULL,
  `voter` int(15) NOT NULL,
  `total` int(15) NOT NULL,
  `bonus` varchar(20) NOT NULL,
  `display` tinyint(4) NOT NULL,
  `top` tinyint(4) NOT NULL,
  `jib` varchar(10) NOT NULL,
  `lng` varchar(100) NOT NULL,
  `lat` varchar(100) NOT NULL,
  `click` int(10) NOT NULL,
  `dianzhao` text NOT NULL,
  `dheight` int(100) NOT NULL default '120',
  `background` text NOT NULL,
  `repeat` text NOT NULL,
  `displaytop` int(4) NOT NULL,
  `renling` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `zkoubj` varchar(255) NOT NULL,
  `tid` int(10) NOT NULL,
  `tuis` tinyint(4) NOT NULL,
  `hits` int(255) NOT NULL,
  `hitsa` int(11) NOT NULL,
  `map_type` int(11) NOT NULL default '2',
  `dateline` int(10) NOT NULL,
  `isbuffet_click` tinyint(1) NOT NULL default '0',
  `isbuffet_top` tinyint(1) NOT NULL default '0',
  `isbuffet_topid` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_forum_alliance_pl` (
  `id` int(11) NOT NULL auto_increment,
  `sid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `author` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `nickback` varchar(255) NOT NULL,
  `voter` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `display` tinyint(4) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_forum_alliance_wp` (
  `id` int(11) NOT NULL auto_increment,
  `sid` int(11) NOT NULL,
  `pic` text NOT NULL,
  `uid` int(11) NOT NULL,
  `author` varchar(50) NOT NULL,
  `title` text NOT NULL,
  `dateline` int(10) NOT NULL,
  `createtime` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_forum_alliance_img`(
  `id` int(11) NOT NULL auto_increment,
  `aid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `img` varchar(255) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_forum_alliance_yh`(
  `id` int(11) NOT NULL auto_increment,
  `aid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subject` text NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_forum_alliance_fl` (
  `id` int(11) NOT NULL auto_increment,
  `upid` int(11) NOT NULL,
  `subid` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `displayorder` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_forum_alliance_rl` (
  `id` int(11) NOT NULL auto_increment,
  `sid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `author` varchar(50) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `display` tinyint(4) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_forum_alliance_img_tmp` (
  `id` int(11) NOT NULL auto_increment,
  `aid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_forum_alliance_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `img_url` varchar(255) NOT NULL DEFAULT '' ,
  `createdate` int(11) NOT NULL DEFAULT '1' ,
  `revisedate` int(11) NOT NULL DEFAULT '1' ,
  `img_folders` varchar(255) NOT NULL DEFAULT '' ,
  `arid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `uname` varchar(255) NOT NULL DEFAULT '',
  `imgnum` int(11) NOT NULL DEFAULT '0' ,
  `remark` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_forum_alliance_albums_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `shrink_url` varchar(255) NOT NULL,
  `original_url` varchar(255) NOT NULL DEFAULT '',
  `albums_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' ,
  `createdate` int(11) NOT NULL DEFAULT '1',
  `remark` varchar(255) NOT NULL DEFAULT '',
  `issz` tinyint(1) NOT NULL DEFAULT '0' ,
  `sztime` int(11) NOT NULL DEFAULT '1' ,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

EOF;

runquery($sql);

$finish = true;

?>