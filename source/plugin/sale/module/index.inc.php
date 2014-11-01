<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
loadcache('diytemplatename');

$city_where ='';
$city_name = !empty($_GET['city']) ? daddslashes($_GET['city']) : 0 ;
$level = !empty($_GET['level']) ? intval($_GET['level']) : $sale_config['level']  ;
$upid = !empty($_GET['upid']) ? intval($_GET['upid']) : $sale_config['upid'] ;
$cat_id = intval($_GET['cat_id']);
$subcat_id = intval($_GET['subcat_id']);
$keyword = trim(addslashes( urldecode($_GET['keyword']) ) );

$goods_selltype = !empty($_GET['goods_selltype']) ? addslashes($_GET['goods_selltype']) : '';
$goods_howtopay = !empty($_GET['goods_howtopay']) ? intval($_GET['goods_howtopay']) : '';
$goods_newold = !empty($_GET['goods_newold']) ? intval($_GET['goods_newold']) : '';

$pre_city =fetch_all('sale_area'," WHERE id='{$upid}'");
$pre_city = $pre_city[0];
$pre_city['uname'] = DB::result_first("SELECT name FROM ".DB::table('sale_area')." WHERE id='{$pre_city['upid']}'");

$city_array = fetch_all('sale_area'," WHERE upid='{$upid}'");

$area ='';
switch($level){
	case "0": $area = 'province'; break;
	case "1": $area = 'city'; break;
	case "2": $area = 'dist'; break;
	case "3": $area = 'community'; break;
	default : $area = 'province'; break;
}

foreach($city_array as $key=>$city){
	$sql = "SELECT count(goods_id) FROM ".DB::table('sale_goods')." WHERE {$area}='{$city['name']}' AND goods_status='1' ";
	$city_array[$key]['sum'] = DB::result_first($sql);
}

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
if(!empty($subcat_id)){
	$where .= " AND subcat_id='{$subcat_id}' ";
}

if(!empty($pre_city['name'])){
	$where .=" AND {$area}='{$pre_city['name']}' ";
}else{
	$where .= ' AND 1=1 ';
}

if(!empty($keyword)){
	$where .=" AND goods_title LIKE '%{$keyword}%'";
}

if(!empty($goods_selltype)){
	$where .= " AND goods_selltype_{$goods_selltype}='1' ";
}

if(!empty($goods_howtopay)){
	$where .= " AND goods_howtopay='{$goods_howtopay}' ";
}

if(!empty($goods_newold)){
	$where .= " AND goods_newold ='{$goods_newold}' ";
}

if(!empty($_POST['title'])){
	$sale_title = trim($_POST['title']) ;
	$where .=" AND `goods_title` like '%{$sale_title}%' ";
}
if(!empty($_POST['sale_cat_id'])){
	$sale_cat_id = trim($_POST['sale_cat_id']);
	$where .=" AND `subcat_id` = '{$sale_cat_id}' ";
}
if(!empty($_POST['sale_area'])){
	$dcj_sale_area = trim($_POST['sale_area']);
	$where .=" AND `province` = '{$dcj_sale_area}' ";
}
if(isset($_POST['sale_img'])){
	$sale_img = trim($_POST['sale_img']);
	$where .= " and ( `goods_upload_file_1` is not null or `goods_upload_file_2` is not null or `goods_upload_file_3` is not null or `goods_upload_file_4` is not null)  ";
}

$where .=" ORDER BY  goods_up DESC,goods_time DESC";

$pagenum = DB::result_first("SELECT count('goods_id') FROM ".DB::table('sale_goods').$where);
$page = intval($_GET['page'])? intval($_GET['page']):1;
$perpage = $sale_config['perpage'];
$urlnow = $sale_config['root']."?mod=index&upid={$upid}&level={$level}&cat_id={$cat['cat_id']}&goods_selltype={$goods_selltype}&goods_howtopay={$goods_howtopay}&goods_newold={$goods_newold}";
$multipage = multi($pagenum, $perpage, $page, $urlnow , 0, 10);
if(!empty($keyword)){
	$urlnow .="&keyword=".urlencode($keyword);
}
$stat_limit = ($page -1) * $perpage;
$where .= " LIMIT {$stat_limit},{$perpage}";

$goods_list = fetch_all('sale_goods',$where);

foreach($goods_list as $k => $v){
	$goods_list[$k]['member_phone'] = DB::result_first("select member_phone from ".DB::table('sale_member')." where sale_goods_id = '{$v['goods_id']}' ");
	$goods_list[$k]['goods_time'] = date('Y/m/d');
}
//var_dump($goods_list);exit;

//获得基础数据数组-类别
$cat_array = fetch_all('sale_cat'," WHERE cat_status='1' ORDER BY cat_sort ASC");
foreach($cat_array as $key=>$cat){
	$where ='';
	$where = " WHERE  goods_status='1' ";
	if(empty($cat['cat_pid'])){
		$where .=" AND cat_id='{$cat['cat_id']}' ";
	}
	if(!empty($cat['cat_pid'])){
		$where .=" AND subcat_id='{$cat['cat_id']}' ";
	}
	if(!empty($pre_city['name'])){
		$where .=" AND {$area}='{$pre_city['name']}'";
	}
	$cat_array[$key]['sum'] = DB::result_first('SELECT count(goods_id) FROM '.DB::table('sale_goods').$where); 
}

//获得基础数据数组-区域
$_a_area = fetch_all('sale_area',' WHERE level=1 ORDER BY displayorder ASC');

$top_goods_list = fetch_all('sale_goods'," WHERE goods_status='1' AND goods_upload_file_1 <>'' ORDER BY goods_time DESC limit 14");
$top_left_goods_list = fetch_all('sale_goods'," WHERE goods_status='1' AND goods_up='1' ORDER BY goods_time DESC limit 10");
$top_hot_goods_list = fetch_all('sale_goods'," WHERE goods_status='1' ORDER BY goods_time DESC limit 5");
$new_hot_goods_list = fetch_all('sale_goods'," WHERE goods_status='1' ORDER BY goods_view DESC, goods_time DESC limit 6");
//error_reporting(E_ALL);
$sale_area_result = DB::query("select * from pre_sale_area where `level` = 1 ");
while($a_r = DB::fetch($sale_area_result)){
	$sale_area[] = $a_r;
}
$sale_cat_result = DB::query("select * from pre_sale_cat");
while($a_c = DB::fetch($sale_cat_result))
{
	$sale_cat[] = $a_c;
}

$navtitle = $pre_city['name'] .$sale_config['seo_title'];
$metakeywords = $sale_config['seo_keywords'];
$metadescription=$sale_config['seo_description']; 
//echo 'diy:../../source/plugin/sale/template/'.$style.'/index';exit;
include template('diy:../../source/plugin/sale/template/'.$style.'/index');
?>
