<?php
/*
	[55625.COM!] (C)2001-2009 55625 Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if($_GET['fromversion'] < 3.91) {
$sql = <<<EOF

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

ALTER TABLE `pre_forum_alliance_ar`
ADD COLUMN `isbuffet_click` tinyint(1) NOT NULL default '0' AFTER `pic`;
ALTER TABLE `pre_forum_alliance_ar`
ADD COLUMN `isbuffet_top` tinyint(1) NOT NULL default '0' AFTER `isbuffet_click`;
ALTER TABLE `pre_forum_alliance_ar`
ADD COLUMN `isbuffet_topid` tinyint(1) NOT NULL default '0' AFTER `isbuffet_top`;

EOF;

runquery($sql);
}

$finish = TRUE;
?>