<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

/*//debug
ini_set("display_errors","on");
set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class block_houseloupan  {
	var $setting = array();

	function name() {
		return '楼盘信息';
	}

	function blockclass() {
		return array('houseloupan', '楼盘信息');
	}
	
	function fields() {
		return array(
			'id'=> array('name' => 'id', 'formtype' => 'title', 'datatype' => 'string'),
			'img' => array('name' => '图片', 'formtype' => 'title', 'datatype' => 'string'),
			'title' => array('name' => '标题', 'formtype' => 'title', 'datatype' => 'string'),
			'text' => array('name' => '内容', 'formtype' => 'title', 'datatype' => 'string'),
			'company' => array('name' => '开发商', 'formtype' => 'title', 'datatype' => 'string'),
		);
	}
	
	function getsetting() {
		$return['area'] = array(
				'title' => '区域ID',
				'type' => 'text',
				'value' =>"",
				'default' => '',
		);
		
		return $return;
	}
	
	function getdata($style, $parameter) {
		global $_G,$_lang;
		require_once DISCUZ_ROOT.'./source/plugin/house/include/config.inc.php';
		
		$array = $list = array();
		$where =" WHERE 1=1 ";
		if($parameter['type']){
			$where .=" AND profile_type_id='{$parameter['type']}' ";
		}
		if($parameter['area']){
			$area_array = DB::fetch_all("SELECT * FROM ".DB::table("house_area")." WHERE id='{$parameter['area']}'");
			switch($area_array[0]['level']){
				case "1": $area = 'province'; break;
				case "2": $area = 'city'; break;
				case "3": $area = 'dist'; break;
				case "4": $area = 'community'; break;
				default : $area = 'province'; break;
			}
			$where .= " AND $area='{$area_array['name']}' ";
		}
		$sql ="SELECT * FROM ".DB::table("house_loupan").$where." LIMIT ".$parameter['items'];
		$query = DB::query($sql);
		while($tem = DB::fetch($query)){
			$fields['id'] = $tem['loupan_id'];
			$fields['url'] = $house_config['root']."?mod=loupan&op=view&lid=".$fields['id'] ;
			$fields['title'] = $tem['loupan_title'];
			$fields['text'] = $tem['loupan_text'];
			$fields['img'] = $tem['loupan_img'];
			
			$fields['company'] = $tem['loupan_company'];
			
			$picflag = !empty($fields['img']) ? 1 : 0;
			$list[] = array(
				'id' =>$fields['id'],
				'idtype' => 'id',
				'title' => $fields['title'],
				'url' => $fields['url'],
				'pic' => $fields['img'],
				'picflag' => $picflag,
				'summary' => $fields['text'],
				'fields' => $fields,
			);
		}
		return array('html' =>'', 'data' => $list);
	}
	
}
?>