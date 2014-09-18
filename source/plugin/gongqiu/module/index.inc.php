<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
loadcache('diytemplatename');

$level = !empty($_GET['level']) ? intval($_GET['level']) : $gongqiu_config['level']  ;
$area_id = $upid = !empty($_GET['upid']) ? intval($_GET['upid']) : $gongqiu_config['upid'] ;
$cat_id = intval($_GET['cat_id']);
$goods_type = intval($_GET['goods_type']);

$pre_area =fetch_all('gongqiu_area'," WHERE id='{$area_id}'");
$pre_area = $pre_area[0];
$pre_area['uname'] = DB::result_first("SELECT name FROM ".DB::table('gongqiu_area')." WHERE id='{$pre_area['upid']}'");

$pre_cat = fetch_all("gongqiu_cat"," WHERE cat_id='{$cat_id}'","*",0);

$empty_area = DB::result_first("SELECT count(id) FROM ".DB::table('gongqiu_area')." WHERE upid='{$area_id}'");
$empty_cat = DB::result_first("SELECT count(cat_id) FROM ".DB::table('gongqiu_cat')." WHERE cat_pid='{$cat_id}'");

$area_array = fetch_all('gongqiu_area'," WHERE upid='{$area_id}'");

$area_name ='';
switch($level){
	case "0": $area_name = 'province'; break;
	case "1": $area_name = 'city'; break;
	case "2": $area_name = 'dist'; break;
	case "3": $area_name = 'community'; break;
	default : $area_name = 'province'; break;
}
/*
foreach($area_array as $key=>$area){
	if($area['upid']==$upid){
		$sql = "SELECT count(goods_id) FROM ".DB::table('gongqiu_goods')." WHERE {$area_name}='{$area['name']}' AND goods_status='1' ";
		$area_array[$key]['sum'] = DB::result_first($sql);
	}
}*/

$area ='';
switch($level){
	case "1": $area = 'province'; break;
	case "2": $area = 'city'; break;
	case "3": $area = 'dist'; break;
	case "4": $area = 'community'; break;
	default : $area = 'province'; break;
}
$where = " WHERE goods_status='1' ";
if(!empty($cat_id)){
	$where .= " AND cat_id='{$cat_id}' ";
}

if(!empty($pre_area['name'])){
	$where .=" AND {$area}='{$pre_area['name']}' ";
}else{
	$where .= ' AND 1=1 ';
}

if(!empty($goods_type)){
	$where .= " AND goods_type='{$goods_type}' ";
}

if(!empty($goods_howtopay)){
	$where .= " AND goods_howtopay='{$goods_howtopay}' ";
}

$where .=" ORDER BY  goods_up DESC,goods_time DESC";

$pagenum = DB::result_first("SELECT count('goods_id') FROM ".DB::table('gongqiu_goods').$where);
$page = intval($_GET['page'])? intval($_GET['page']):1;
$perpage = $gongqiu_config['perpage'];
$urlnow = $gongqiu_config['root']."?mod=index&upid={$upid}&level={$level}&cat_id={$cat['cat_id']}&goods_selltype={$goods_selltype}&goods_howtopay={$goods_howtopay}&goods_newold={$goods_newold}";
$multipage = multi($pagenum, $perpage, $page, $urlnow , 0, 10);
$stat_limit = ($page -1) * $perpage;
$where .= " LIMIT {$stat_limit},{$perpage}";

$goods_list = fetch_all('gongqiu_goods',$where);

$cat_array = fetch_all('gongqiu_cat'," WHERE cat_status='1' ORDER BY cat_sort ASC");
$cat_title = "";
foreach($cat_array as $key=>$cat){
	
	if($cat['cat_id']==$cat_id){
		$cat_title = $cat['cat_title'];
	}
	/*
	if($cat['cat_pid']==$cat_id){
		$where ='';
		$where = " WHERE  goods_status='1' ";
		
		if($pre_cat['cat_pid']){
			$where .=" AND subcat_id='{$cat['cat_id']}' ";
		}else{
			$where .=" AND cat_id='{$cat['cat_id']}' ";
		}

		if(!empty($pre_area['name'])){
			$where .=" AND {$area}='{$pre_area['name']}'";
		}
		$cat_array[$key]['sum'] = DB::result_first('SELECT count(goods_id) FROM '.DB::table('gongqiu_goods').$where); 
	}
	*/
}

/*
$top_goods_list = fetch_all('gongqiu_goods'," WHERE goods_status='1' AND goods_upload_file_1 <>'' ORDER BY goods_time DESC limit 14");
$top_left_goods_list = fetch_all('gongqiu_goods'," WHERE goods_status='1' AND goods_up='1' ORDER BY goods_time DESC limit 10");
$top_hot_goods_list = fetch_all('gongqiu_goods'," WHERE goods_status='1' ORDER BY goods_time DESC limit 5");
$new_hot_goods_list = fetch_all('gongqiu_goods'," WHERE goods_status='1' ORDER BY goods_view DESC, goods_time DESC limit 6");
*/
$other_where = "";
if(!empty($cat_id)){
	$other_where .= " AND cat_id='{$cat_id}' ";
}

if(!empty($pre_area['name'])){
	$other_where .=" AND {$area}='{$pre_area['name']}' ";
}else{
	$other_where .= ' AND 1=1 ';
}

/*
$type_1_list = fetch_all('gongqiu_goods'," WHERE goods_status='1' AND goods_type='1' {$other_where} ORDER BY goods_time DESC limit {$gongqiu_config['top_list_total']}");
$type_2_list = fetch_all('gongqiu_goods'," WHERE goods_status='1' AND goods_type='2' {$other_where} ORDER BY goods_time DESC limit {$gongqiu_config['top_list_total']}");
$type_3_list = fetch_all('gongqiu_goods'," WHERE goods_status='1' AND goods_type='3' {$other_where} ORDER BY goods_time DESC limit {$gongqiu_config['top_list_total']}");
$type_4_list = fetch_all('gongqiu_goods'," WHERE goods_status='1' AND goods_type='4' {$other_where} ORDER BY goods_time DESC limit {$gongqiu_config['top_list_total']}");
*/

if(empty($pre_area['name']) && empty($cat_title)){
	$navtitle = $gongqiu_config['seo_title'];
}else{
	$navtitle = $pre_area['name'].$cat_title;
}

$metakeywords = $gongqiu_config['seo_keywords'];
$metadescription=$gongqiu_config['seo_description']; 
include template('diy:../../source/plugin/gongqiu/template/'.$style.'/index');
?>