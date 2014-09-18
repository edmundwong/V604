<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/


/*
ini_set("display_errors","on");
set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
*/

if(!defined('IN_DISCUZ')) {	exit('Access Denied');}

class block_info  {
	var $setting = array();

	function name() {
		return '分类信息';
	}

	function blockclass() {
		return array('info', '分类信息');
	}
	
	function fields() {
		return array(
			'post_id'=> array('name' => 'id', 'formtype' => 'title', 'datatype' => 'string'),
			'post_img' => array('name' => '图片', 'formtype' => 'title', 'datatype' => 'string'),
			'post_title' => array('name' => '标题', 'formtype' => 'title', 'datatype' => 'string'),
			
				'url' => array('name' => '链接地址', 'formtype' => 'title', 'datatype' => 'string'),
			
			'cat' => array('name' => '类别名', 'formtype' => 'title', 'datatype' => 'string'),
			'area' => array('name' => '区域名', 'formtype' => 'title', 'datatype' => 'string'),
			
			'time' => array('name' => '发布时间', 'formtype' => 'title', 'datatype' => 'string'),
			'view' => array('name' => '查看数', 'formtype' => 'title', 'datatype' => 'string'),
		);
	}
	
	/**
	 * 必须！
	 * 返回使用本数据类调用数据时的设置项
	 * 格式见示例：
	 * title 为显示的名称
	 * type 为表单类型， 有： text, password, number, textarea, radio, select, mselect, mradio, mcheckbox, calendar； 详见 function_block.php 中 block_makeform() 函数
	 * @return 
	 */
	function getsetting() {
		global $_G;
		if($_G['setting']['version'] >='X2.5'){
			$cache_dir = DISCUZ_ROOT.'./data/sysdata/';
		}else{
			$cache_dir = DISCUZ_ROOT.'./data/cache/';
		}
		require_once $cache_dir.'cache_info_cat_array.php';
		require_once $cache_dir.'cache_info_area_array.php';
		
		$_area = array();
		foreach($area_array as $aa){
			if(empty($aa['area_pid'])){
				$_area[] = array($aa['area_id'],$aa['area_title']);
			}
		}
		$return['area'] = array(
			'title' => '区域',
			'type' => 'mselect',
			'value' => $_area,
			'default' => "",
		);
		
		$_cat = array();
		foreach($cat_array as $ca){
			if(!empty($ca['cat_pid'])){
				$_cat[] = array($ca['cat_id'],$ca['cat_title']);
			}
		}
		$return['cat'] = array(
			'title' => '类别',
			'type' => 'mselect',
			'value' =>$_cat,
			'default' => "",
		);
		
		$return['kind'] = array(
			'title' => '信息类型',
			'type' => 'select',
			'value' => array(
					array('all',"不限"),
					array('new',"最新"),
					array('hot',"最热"),
					array('up',"置顶"),
				),
			'default' => "",
		);
		
		$return['pic'] = array(
				'title' => '包含图片',
				'type' => 'radio',
				'value' => array(
					array('0',"不限"),
					array('1',"是"),
				),
				'default' => "",
		);
		
		return $return;
	}
	
	function getdata($style, $parameter) {
		global $_G,$_lang;
		require_once DISCUZ_ROOT.'./source/plugin/info/include/config.inc.php';
		//require_once DISCUZ_ROOT.'./source/plugin/info/include/function.class.php';
		
		$array = $list = array();
		
		$where =" WHERE  1=1 ";
		if($parameter['area']){
			$where .=" AND area_id IN (".dimplode($parameter['area']).")";
		}
		if($parameter['cat']){
			$where .=" AND subcat_id IN (".dimplode($parameter['cat']).")";
		}
		if($parameter['pic']=="1"){
			$where .=" AND post_img_1 IS NOT NULL ";
		}
		if($parameter['kind']=='new'){
			$where .=" ORDER BY post_time DESC ";
		}elseif($parameter['kind']=='hot'){
			$where .=" ORDER BY post_view DESC ";
		}elseif($parameter['kind']=='up'){
			$where .=" ORDER BY post_up DESC ";
		}
		$sql ="SELECT * FROM ".DB::table("info_post").$where." LIMIT ".$parameter['items'];
		$query = DB::query($sql);
		while($tem = DB::fetch($query)){
			$fields['post_id'] = $tem['post_id'];
			$fields['url'] = $info_config['root']."?mod=view&post_id=".$tem['post_id'];
			$fields['post_title'] = $tem['post_title'];
			$fields['post_text'] = $tem['post_text'];
			$fields['post_img'] = $tem['post_img_1'];
					
			$fields['cat'] = $tem['subcat_title'];
			$fields['area'] = $tem['area_title'];
			$fields['time'] = date($parameter['dateformat'],$tem['post_time']);
			$fields['view'] = $tem['post_view'];
			$picflag = !empty($fields['post_img']) ? 1 : 0;
			
			$list[] = array(
				'id' =>$fields['post_id'],
				'idtype' => 'post_id',
				'title' => $fields['title'],
				'url' => $fields['url'],
				'pic' => $fields['post_img'],
				'picflag' => $picflag,
				'summary' => $fields['post_text'],
				'fields' => $fields,
			);
		}
		return array('html' =>'', 'data' => $list);
	}
	
}
?>