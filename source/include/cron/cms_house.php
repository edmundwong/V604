<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$post_up = array();
$query = DB::query('SELECT * FROM '.DB::table('house_post_up'));
while($tem = DB::fetch($query)){
	$post_up[] = $tem;
}

if(!empty($post_up)){
	$time = time();
	foreach($post_up as $up){
		if($time > $up['up_endtime']){
			DB::delete('house_post_up',array('post_id'=>$up['post_id']));
			DB::update('house_post',array('post_up'=>0)," post_id='{$up['post_id']}'");
		}
	}
}
?>