<?php

define('APPTYPEID', 568);
define('CURSCRIPT', 'service');


require './source/class/class_core.php';
$discuz = C::app();
$cachelist = array();
$discuz->cachelist = $cachelist;
$discuz->init();

runhooks();

$metakeywords = '页面关键词(SEO)';
$metadescription = '页面介绍（SE0）';


include template('diy:toollink/index');

?>