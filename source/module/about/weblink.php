<?php

/*
 * MaoYoo! About
 * http://www.maoyoo.cn
 */
 
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	
	$list = array();
	
	$query = DB::query("SELECT * FROM ".DB::table('common_friendlink')." ORDER BY displayorder ASC");
	
	while($link = DB::fetch($query)) {

		$list[] = $link;
		
	}
	
	include_once template("about/weblink");

?>
