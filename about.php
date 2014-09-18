<?php

/*
 * MaoYoo! About
 * http://www.maoyoo.cn
 */

	define('APPTYPEID', 0);
	define('CURSCRIPT', 'about');
	
	/*
	 * 是否开启伪静态?
	 * 如果开启，请添加以下规则 IIS6.0 （其他环境请自行编写）
	 * RewriteRule ^(.*)/about/(\w+)$ $1/about\.php\?mod=$2
	 */
	 
	define('MYREWRITE',0);
	
	require './source/class/class_core.php';
	
	$discuz = & discuz_core::instance();
	
	$modarray = array('weblink', 'regulation',"article","secret","contact","sitemap");
	
	$mod = !in_array($discuz->var['mod'], $modarray) ? 'contact' : $discuz->var['mod'];
	
	define('CURMODULE', $mod);
	
	$discuz->init();
	
	require DISCUZ_ROOT.'./source/module/about/'.$mod.'.php';
	

?>