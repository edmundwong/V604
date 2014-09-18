<?php
/*
	[55625.COM!] (C)2001-2009 55625 Inc.
	BY QQ:114512039  Lovenr
*/


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF
DROP TABLE IF EXISTS `pre_forum_alliance_ar`;
DROP TABLE IF EXISTS `pre_forum_alliance_pl`;
DROP TABLE IF EXISTS `pre_forum_alliance_wp`;
DROP TABLE IF EXISTS `pre_forum_alliance_img`;
DROP TABLE IF EXISTS `pre_forum_alliance_yh`;
DROP TABLE IF EXISTS `pre_forum_alliance_fl`;
DROP TABLE IF EXISTS `pre_forum_alliance_rl`;
DROP TABLE IF EXISTS `pre_forum_alliance_img_tmp`;
DROP TABLE IF EXISTS `pre_forum_alliance_albums`;
DROP TABLE IF EXISTS `pre_forum_alliance_albums_img`;
EOF;

runquery($sql);

$finish = TRUE;

?>