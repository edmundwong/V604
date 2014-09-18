<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
loadcache('diytemplatename');

$profile_type_id = !empty($_GET['profile_type_id']) ? intval($_GET['profile_type_id']) : 1;
$profile_type_title = get_profile_type_title($profile_type_id);
$profile_setting = get_profile_setting($profile_type_id);

$upid = !empty($_GET['upid']) ? intval($_GET['upid']) : $house_config['upid'] ;
$area_level = !empty($_GET['level']) ? intval($_GET['level']) : $house_config['level'];
$area_array = fetch_all('house_area'," WHERE upid='{$upid}'");
$pre_area = fetch_all('house_area'," WHERE id='{$upid}' ","*",0);
$pre_area['uname'] = DB::result_first("SELECT name FROM ".DB::table('house_area')." WHERE id='{$pre_area['upid']}'");
$profile_setting_done =0;

$orderby = addslashes($_GET['orderby']);
$orderby = in_array($_GET['orderby'],array('post_time','post_end_time','post_begin_time')) ? addslashes($_GET['orderby']) : 'post_time';
$_GET['search_type'] = !empty($_GET['search_type']) ? intval($_GET['search_type']) : "1";

$urlnow = get_url();

$where = ' as jp LEFT JOIN '.DB::table('house_post_profile').' as jpp ON jp.post_id = jpp.post_id WHERE 1=1 ';

if($upid){
	switch($area_level){
		case "1": $area = 'province'; break;
		case "2": $area = 'city'; break;
		case "3": $area = 'dist'; break;
		case "4": $area = 'community'; break;
		default : $area = 'province'; break;
	}
	$where .= " AND $area='{$pre_area['name']}' ";
}

$where .= " AND jp.profile_type_id='{$profile_type_id}' ";
$post_ids = array();
$_post_ids = array();
$_post_ids_i = 0;
foreach($profile_setting as $v){
	if(!empty($_GET[$v['profile_setting_name']])){
		$temp = addslashes($_GET[$v['profile_setting_name']]);
		$temp_post_ids = fetch_all('house_post'," as hp LEFT JOIN ".DB::table('house_post_profile')." as hpp ON hpp.post_id = hp.post_id WHERE hp.profile_type_id='{$profile_type_id}' AND hpp.profile_setting_name='{$v['profile_setting_name']}' AND hpp.post_profile_title='{$temp}'","hpp.post_id");
		foreach($temp_post_ids as $value){
			$_post_ids[$_post_ids_i][] = $value['post_id'];
		}
		$eval_string[] ='$_post_ids['.$_post_ids_i.']';
		$_post_ids_i++;
		$profile_setting_done = 1;
	}
}
$qujian = array();
$rent_price_1 = !empty($_GET['rent_price_1']) ? intval($_GET['rent_price_1']) : 0;
$rent_price_2 = !empty($_GET['rent_price_2']) ? intval($_GET['rent_price_2']) : 800;
if(!empty($_GET['rent_price_2'])){
	$qujian['rent_price']['1'] = $rent_price_1; 
	$qujian['rent_price']['2'] = $rent_price_2;
}

$house_area_1 = !empty($_GET['house_area_1']) ? intval($_GET['house_area_1']) : 0;
$house_area_2 = !empty($_GET['house_area_2']) ? intval($_GET['house_area_2']) : 50;
$sell_price_1 = !empty($_GET['sell_price_1']) ? intval($_GET['sell_price_1']) : 0;
$sell_price_2 = !empty($_GET['sell_price_2']) ? intval($_GET['sell_price_2']) : 50;
if(!empty($_GET['house_area_2'])){
	$qujian['house_area']['1'] = $house_area_1; 
	$qujian['house_area']['2'] = $house_area_2;
}
if(!empty($_GET['sell_price_2'])){
	$qujian['sell_price']['1'] = $sell_price_1; 
	$qujian['sell_price']['2'] = $sell_price_2;
}
foreach($qujian as $key=>$value){
	$temp_post_ids = fetch_all('house_post'," as hp LEFT JOIN ".DB::table('house_post_profile')." as hpp ON hpp.post_id = hp.post_id WHERE hp.profile_type_id={$profile_type_id} AND hpp.profile_setting_name = '{$key}' AND hpp.post_profile_title BETWEEN {$value[1]} AND {$value[2]} ","hpp.post_id");
	foreach($temp_post_ids as $value){
		$_post_ids[$_post_ids_i][] = $value['post_id'];
	}
	$eval_string[] ='$_post_ids['.$_post_ids_i.']';
	$_post_ids_i++;
}

if( count($_post_ids) >1){
	@eval('$post_ids=array_intersect('.implode(',',$eval_string).');');
}elseif(empty($_post_ids) && $_post_ids_i>0){
	$where .=" AND 1=2 ";
}else{
	$post_ids = $_post_ids[0];
}

if(!empty($post_ids)){
	$where .=" AND jpp.post_id IN ( ".implode(',',$post_ids)."  )";
}

if($_GET['op']=='search'){
	$search = gpc('search_');
	if( !empty( $search['search_txt'] ) ){
		$where .=" AND ( jp.post_title LIKE '%{$search['search_txt']}%' OR jp.loupan_title LIKE '%{$search['search_txt']}%') ";
	}
}

$where .= " GROUP BY jp.post_id ORDER BY jp.post_up DESC,{$orderby} DESC ";

$page = $_GET['page']? intval($_GET['page']):1;
$perpage = $house_config['perpage'];
$pagenum = DB::num_rows(DB::query("SELECT jp.post_id FROM ".DB::table('house_post').$where));

$multipage = multi($pagenum, $perpage, $page, $urlnow , 0, 10);
$stat_limit = ($page -1) * $perpage;
$where .= " LIMIT {$stat_limit},{$perpage}";
$post_list = fetch_all('house_post',$where);

foreach($post_list as $k=>$v){
	$_post_profile = array();
	$_post_profile = fetch_all('house_post_profile'," WHERE post_id='{$v['post_id']}'");
	foreach($_post_profile as $_k=>$_v){
		$_post_profile[$_v['profile_setting_name']] = $_v;
		unset($_post_profile[$_k]);
	}
	$post_list[$k] = array_merge($post_list[$k],$_post_profile);
}

$navtitle = $profile_type_title."_".$pre_city['name'] .$house_config['name'];
if($pre_area['uname']){
	//$navtitle = $pre_area['uname']."_".$navtitle;
}
if(defined('IN_MOBILE')){
	include template('house:'.$style.'/list');
}else{
	include template('diy:../../source/plugin/house/template/'.$style.'/list');
}
?>