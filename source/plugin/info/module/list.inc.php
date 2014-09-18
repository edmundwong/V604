<?php
if(!defined('IN_DISCUZ')) {exit('Access Denied');}
loadcache('diytemplatename');

$keyword =  htmlspecialchars(urldecode($_GET['keyword']));

$subcat_id = intval($_GET['subcat_id']);

if($subcat_id > 0)
{	$cat_one = DB::fetch(DB::query("select * from pre_info_cat where `cat_id` = '{$subcat_id}' "));
	$cat_array_title = fetch_all("info_cat"," where `cat_pid` = {$cat_one['cat_pid']} ");
}

$subcat_title = $cat_array[$subcat_id]['cat_title'];
$my_cat_array = brian_fetch_all("info_cat"," WHERE cat_id='{$subcat_id}'",array('first'=>1));

$profile_type_id = $my_cat_array['cat_mod_id'];
if(!empty($profile_type_id)){
	$profile_type_title = get_profile_type_title($profile_type_id);
	$profile_setting = get_profile_setting($profile_type_id);
}

$subarea_id = intval($_GET['subarea_id']);
$orderby = addslashes($_GET['orderby']);
$orderby = in_array($_GET['orderby'],array('post_time','post_end_time','post_begin_time')) ? addslashes($_GET['orderby']) : 'post_time';
$_GET['search_type'] = !empty($_GET['search_type']) ? intval($_GET['search_type']) : "1";

$urlnow = get_url();
$where = " as ip 
 LEFT JOIN ".DB::table('info_post_profile')." as ipp ON ip.post_id = ipp.post_id 
 LEFT JOIN ".DB::table('common_member_verify')." as cmv ON ip.member_uid=cmv.uid 
 WHERE  1=1 ";

 /*
if($area_id){
	$where .= " AND ip.area_id='{$area_id}' ";
}*/
if($subarea_id){
	$where .= " AND ip.subarea_id='{$subarea_id}' ";
}
if($thrarea_id){
	$where .= " AND ip.thrarea_id='{$thrarea_id}' ";
}

if(!empty($keyword)){
	$where .=" AND post_title LIKE '%{$keyword}%'";
}

if($subcat_id){
	$where .=" AND ip.subcat_id ='{$subcat_id}' ";
}
//echo $where;exit;
$post_ids = array();
$_post_ids = array();
$_post_ids_i = 0;
foreach($profile_setting as $v){
	if(!empty($_GET[$v['profile_setting_name']])){
		$temp = addslashes($_GET[$v['profile_setting_name']]);
		$temp_post_ids = fetch_all('info_post'," as hp LEFT JOIN ".DB::table('info_post_profile')." as hpp ON hpp.post_id = hp.post_id WHERE hp.profile_type_id='{$profile_type_id}' AND hpp.profile_setting_name='{$v['profile_setting_name']}' AND hpp.post_profile_title='{$temp}'","hpp.post_id");
		foreach($temp_post_ids as $value){
			$_post_ids[$_post_ids_i][] = $value['post_id'];
		}
		$eval_string[] ='$_post_ids['.$_post_ids_i.']';
		$_post_ids_i++;
		$profile_setting_done = 1;
	}
}

/*
$qujian = array();
$rent_price_1 = !empty($_GET['rent_price_1']) ? intval($_GET['rent_price_1']) : 0;
$rent_price_2 = !empty($_GET['rent_price_2']) ? intval($_GET['rent_price_2']) : 800;
if(!empty($_GET['rent_price_2'])){
	$qujian['rent_price']['1'] = $rent_price_1; 
	$qujian['rent_price']['2'] = $rent_price_2;
}

$info_area_1 = !empty($_GET['info_area_1']) ? intval($_GET['info_area_1']) : 0;
$info_area_2 = !empty($_GET['info_area_2']) ? intval($_GET['info_area_2']) : 50;
$sell_price_1 = !empty($_GET['sell_price_1']) ? intval($_GET['sell_price_1']) : 0;
$sell_price_2 = !empty($_GET['sell_price_2']) ? intval($_GET['sell_price_2']) : 50;
if(!empty($_GET['info_area_2'])){
	$qujian['info_area']['1'] = $info_area_1; 
	$qujian['info_area']['2'] = $info_area_2;
}
if(!empty($_GET['sell_price_2'])){
	$qujian['sell_price']['1'] = $sell_price_1; 
	$qujian['sell_price']['2'] = $sell_price_2;
}
foreach($qujian as $key=>$value){
	$temp_post_ids = fetch_all('info_post'," as hp LEFT JOIN ".DB::table('info_post_profile')." as hpp ON hpp.post_id = hp.post_id WHERE hp.profile_type_id={$profile_type_id} AND hpp.profile_setting_name = '{$key}' AND hpp.post_profile_title BETWEEN {$value[1]} AND {$value[2]} ","hpp.post_id");
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
*/

if($_GET['op']=='search'){
	$search = gpc('search_');
	if( !empty( $search['search_txt'] ) ){
		$where .=" AND ( ip.post_title LIKE '%{$search['search_txt']}%' OR ip.loupan_title LIKE '%{$search['search_txt']}%') ";
	}
}
$dcj_time = time();
$where .= " and  ip.`post_begin_time` < {$dcj_time}  and ip.`post_end_time` > {$dcj_time} ";
$where .= "  ORDER BY ip.post_up DESC,{$orderby} DESC ";

$page = $_GET['page']? intval($_GET['page']):1;
$perpage = $info_config['perpage'];
$pagenum = DB::num_rows(DB::query("SELECT distinct  ip.post_id FROM ".DB::table('info_post').$where));

$multipage = multi($pagenum, $perpage, $page, $urlnow , 0, 10);
$stat_limit = ($page -1) * $perpage;
$where .= " LIMIT {$stat_limit},{$perpage}";
//echo $where;exit;
$post_list = brian_fetch_all('info_post',$where,array('filter'=>' distinct ip.post_id, ip.*, cmv.*'));
//var_dump($post_list);exit;
/*
foreach($post_list as $k=>$v){
	$_post_profile = array();
	$_post_profile = fetch_all('info_post_profile'," WHERE post_id='{$v['post_id']}'");
	foreach($_post_profile as $_k=>$_v){
		$_post_profile[$_v['profile_setting_name']] = $_v;
		unset($_post_profile[$_k]);
	}
	if(!empty($_post_profile)){
		$post_list[$k] = array_merge($post_list[$k],$_post_profile);
	}
}*/

$navtitle = $subcat_title."_".$area_title." ".$info_config['name'];
if(defined('IN_MOBILE')){
	include template('info:'.$style.'/list');
}else{
	include template('diy:../../source/plugin/info/template/'.$style.'/list');
}
?>