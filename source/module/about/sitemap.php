<?php

/*
 * MaoYoo! About
 * http://www.maoyoo.cn
 */

	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	
	$list  = array();
	
	$query = DB::query("select * from ".DB::table('forum_forum')." where type = 'group' and status = 1 order by displayorder asc");
	
	while($link = DB::fetch($query)) {

		$list[] = $link;
		
	}
	
	include_once template("about/sitemap");

?>
