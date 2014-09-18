<?php

if(!defined('IN_DISCUZ')) {	exit('Access Denied');}

$sql = <<<EOF
DROP TABLE IF EXISTS `pre_house_area`;
DROP TABLE IF EXISTS `pre_house_loupan`;

DROP TABLE IF EXISTS `pre_house_member`;
DROP TABLE IF EXISTS `pre_house_member_fav`;
DROP TABLE IF EXISTS `pre_house_member_profile`;

DROP TABLE IF EXISTS `pre_house_post`;
DROP TABLE IF EXISTS `pre_house_post_jubao`;
DROP TABLE IF EXISTS `pre_house_post_profile`;
DROP TABLE IF EXISTS `pre_house_post_up`;

DROP TABLE IF EXISTS `pre_house_profile_setting`;
DROP TABLE IF EXISTS `pre_house_profile_type`;
DROP TABLE IF EXISTS `pre_house_profile_type_setting`;
EOF;
runquery($sql);



$finish = true;
?>