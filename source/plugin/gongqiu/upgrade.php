<?php
/**
 *      ��Ȩ����: �ó���Ϊ [DiscuzCMS!] ������������, ����ӵ�иò�Ʒ֪ʶ��Ȩ,���д����Ȩ��[DiscuzCMS!]����, �����ھ�Ϊ��ҵ����, ��Ϊ�������ṩʹ����Ȩ.
 *		��������: δ���ٷ���Ȩʹ���޸Ļ��ߴ�������������Ȩ��Υ����Ϊ, ������׷��һ����ط�������.
 *		�ٷ���վ: http://www.DiscuzCMS.com 
**/
 
if(!defined('IN_DISCUZ')) { exit('Access Denied');}

if ($_GET['fromversion'] < 2.3) {
$sql =<<<EOF
ALTER TABLE `pre_gongqiu_goods` CHANGE `goods_upload_file_1` `goods_upload_file_1` varchar(150) default NULL;
ALTER TABLE `pre_gongqiu_goods` CHANGE `goods_upload_file_2` `goods_upload_file_2` varchar(150) default NULL;
ALTER TABLE `pre_gongqiu_goods` CHANGE `goods_upload_file_3` `goods_upload_file_3` varchar(150) default NULL;
ALTER TABLE `pre_gongqiu_goods` CHANGE `goods_upload_file_4` `goods_upload_file_4` varchar(150) default NULL;
EOF;
	runquery($sql);
}

if ($_GET['fromversion'] < 4.1) {
$sql=<<<EOF
ALTER TABLE `pre_gongqiu_goods` CHANGE `goods_number`  `goods_number` int(10) default 1 NULL;
EOF;
	runquery($sql);
}

$finish = TRUE;
?>