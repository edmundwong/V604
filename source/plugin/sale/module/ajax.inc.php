<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

 
if(!defined('IN_DISCUZ')) {exit('Access Denied');}
$_GET['inajax']=1;
$return = '';
$op = addslashes($_GET['op']);

if($op =='cat' ){
	$catbox= addslashes($_GET['catbox']);
	$cat_pid = addslashes($_GET['cat_pid']);
	$cat_pid = explode("-",$cat_pid);
	$cat_pid= $cat_pid[0];
	$subcat_pid = addslashes($_GET['subcat_pid']);
	$subcat_pid = explode("-",$subcat_pid);
	$subcat_pid= $subcat_pid[0];
	
	$cat_array = fetch_all('sale_cat'," WHERE cat_status='1' ");
	$auto = intval($_GET['auto']);
	
	$return .="<select id='cat' name='cat' onchange=\"brian_showcat('{$catbox}',['1','0','0'],'{$sale_config['root']}')\" >";
	$return .="<option>-{$_lang['xuanze']}-</oprion>";
	foreach($cat_array as $v){
		if($v['cat_pid'] == '0'){
			$return .="<option value='{$v['cat_id']}-{$v['cat_title']}' ";
			if($v['cat_id'] ==$cat_pid){
				$return.=" selected='selected' ";
			}
			$return .=">{$v['cat_title']}</option>";
		}
	}
	$return .="</select>";
	
	$return .="<select id='subcat' name='subcat' #subcat_style#>";
	$subcat_style_switch = 0;
	foreach($cat_array as $v){
		if($v['cat_pid'] == $cat_pid && $v['cat_pid'] !='0'){
			$return .="<option value='{$v['cat_id']}-{$v['cat_title']}' ";
			if($v['cat_id'] ==$subcat_pid){
				$return.=" selected='selected' ";
			}
			$return .=">{$v['cat_title']}</option>";
			$subcat_style_switch = 1;
		}
	}
	$return .="</select>";
	
	$subcat_style = "";
	if(!$subcat_style_switch){
		$subcat_style = "style='display:none;'";
	}
	$return = str_replace("#subcat_style#",$subcat_style,$return);
	
}elseif($op =='jubao'){
	
	if(!$_G['uid']){
		showmessage($_lang['login'],'',array(),array('login' => true));
	}
	
	$post_id = intval($_GET['post_id']);
	$has_jubao = fetch_all('sale_post_jubao'," WHERE post_id='{$post_id}'",'jubao_id',0);
	$has_jubao = $has_jubao['jubao_id'];
	
	if(empty($has_jubao)){
		$post = fetch_all('sale_post'," WHERE post_id='{$post_id}'","post_id,post_title",0);
		DB::insert("sale_post_jubao",array('post_id'=>$post['post_id'],'post_title'=>$post['post_title'],'jubao_time'=>time()));
	}
	
	$tips = $_lang['ajax_inc_php_3'];
	
	include template("sale:{$style}/done");
	exit;
}elseif($op == 'district') {
	$container = addslashes($_GET['container']);
	$_GET['pid'] = !empty($_GET['pid']) ? intval($_GET['pid']) : $sale_config['upid'];
	$_GET['level'] = !empty($_GET['level']) ? intval($_GET['level']) : $sale_config['level'];
	$showlevel = intval($_GET['level']);

	$showlevel = $showlevel >= 1 && $showlevel <= 4 ? $showlevel : 4;
	$values = array(intval($_GET['pid']), intval($_GET['cid']), intval($_GET['did']), intval($_GET['coid']));
	$level = 1;
	if($values[0]) {
		$level++;
	} else if($_G['uid'] && !empty($_GET['showdefault'])) {
			
			space_merge($_G['member'], 'profile');
			$district = array();
			if(!empty($district)) {
				foreach(table_brian_district::fetch_all_by_name($district) as $value) {
					$key = $value['level'] - 1;
					$values[$key] = $value['id'];
				}
				$level++;
			}
		}
	if($values[1]) {
		$level++;
	}
	if($values[2]) {
		$level++;
	}
	if($values[3]) {
		$level++;
	}
	$showlevel = $level;
	$elems = array();
	if($_GET['province']) {
		$elems = array(addslashes($_GET['province']), addslashes($_GET['city']), addslashes($_GET['district']), addslashes($_GET['community']));
	}
	$return = brian_showdistrict($values, $elems, $container, $showlevel, $containertype);
}

include template("sale:ajax");
?>