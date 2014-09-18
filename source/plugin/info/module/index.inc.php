<?php
if(!defined('IN_DISCUZ')) {exit('Access Denied');}
loadcache('diytemplatename');

$index_up_array = fetch_all("info_post","WHERE post_up='1' LIMIT 10");
$index_hot_array = fetch_all("info_post"," ORDER BY post_view DESC LIMIT 5");
$index_rand_array = fetch_all("info_post"," ORDER BY rand() LIMIT 5");

$navtitle = $area_title." " .$info_config['seo_title']." ".$info_config['name'];
$metakeywords = $info_config['seo_keywords'];
$metadescription=$info_config['seo_description'];

if(defined('IN_MOBILE')){
	include template('info:'.$style.'/index');
}else{
	include template('diy:../../source/plugin/info/template/'.$style.'/index');
}
?>