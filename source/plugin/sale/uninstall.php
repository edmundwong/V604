<?php
/**
 *      ��Ȩ����: �ó���Ϊ [DiscuzCMS!] ������������, ����ӵ�иò�Ʒ֪ʶ��Ȩ,���д����Ȩ��[DiscuzCMS!]����, �����ھ�Ϊ��ҵ����, ��Ϊ�������ṩʹ����Ȩ.
 *		��������: δ���ٷ���Ȩʹ���޸Ļ��ߴ�������������Ȩ��Υ����Ϊ, ������׷��һ����ط�������.
 *		�ٷ���վ: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {	exit('Access Denied');}

$sql = <<<EOF
DROP TABLE IF EXISTS `pre_sale_area`;
DROP TABLE IF EXISTS `pre_sale_cat`;
DROP TABLE IF EXISTS `pre_sale_goods`;
DROP TABLE IF EXISTS `pre_sale_jubao`;
DROP TABLE IF EXISTS `pre_sale_member`;
DROP TABLE IF EXISTS `pre_sale_up`;
EOF;

runquery($sql);
$finish = true;
?>