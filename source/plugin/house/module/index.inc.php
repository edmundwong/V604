<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
loadcache('diytemplatename');

$index_up_post_list =  fetch_all('house_post',"WHERE post_up='1' AND profile_type_id='3' ORDER BY post_time DESC limit 9");
foreach($index_up_post_list as $k=>$v){
	$index_up_post_list[$k]['profile'] = get_post_profile($v['post_id']);
}

$index_new_sell_post_list =  fetch_all('house_post',"WHERE  profile_type_id='3' ORDER BY post_time DESC limit 9");
foreach($index_new_sell_post_list as $k=>$v){
	$index_new_sell_post_list[$k]['profile'] = get_post_profile($v['post_id']);
}

$index_new_rent_post_list =  fetch_all('house_post',"WHERE  profile_type_id='1' ORDER BY post_time DESC limit 9");
foreach($index_new_rent_post_list as $k=>$v){
	$index_new_rent_post_list[$k]['profile'] = get_post_profile($v['post_id']);
}

$index_loupan_list = fetch_all('house_loupan'," ORDER BY loupan_id DESC limit 10");

$navtitle = $pre_city['name'] .$house_config['seo_title']." ".$house_config['name'];
$metakeywords = $house_config['seo_keywords'];
$metadescription=$house_config['seo_description'];
if(defined('IN_MOBILE')){
	include template('house:'.$style.'/index');
}else{
	include template('diy:../../source/plugin/house/template/'.$style.'/index');
}
?>