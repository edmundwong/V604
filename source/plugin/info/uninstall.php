<?php

if(!defined('IN_DISCUZ')) {	exit('Access Denied');}

$sql = <<<EOF
DROP TABLE IF EXISTS `pre_info_area`;
DROP TABLE IF EXISTS `pre_info_loupan`;

DROP TABLE IF EXISTS `pre_info_member`;
DROP TABLE IF EXISTS `pre_info_member_fav`;
DROP TABLE IF EXISTS `pre_info_member_profile`;

DROP TABLE IF EXISTS `pre_info_post`;
DROP TABLE IF EXISTS `pre_info_post_jubao`;
DROP TABLE IF EXISTS `pre_info_post_profile`;
DROP TABLE IF EXISTS `pre_info_post_up`;

DROP TABLE IF EXISTS `pre_info_profile_setting`;
DROP TABLE IF EXISTS `pre_info_profile_type`;
DROP TABLE IF EXISTS `pre_info_profile_type_setting`;
EOF;
runquery($sql);



$finish = true;
?>