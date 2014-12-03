<?php
if(!defined('IN_DISCUZ')) {	exit('Access Denied'); }

require_once DISCUZ_ROOT.'./source/plugin/sale/module/spider/SaleAutoSpider.class.php';
$o_spider = new SaleAutoSpider();
$o_spider->doRun();

?>