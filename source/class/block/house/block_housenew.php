<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

/*debug
ini_set("display_errors","on");
set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class block_housenew  {
	var $setting = array();

	function name() {
		return '房产信息';
	}

	function blockclass() {
		return array('housenew', '房产信息');
	}
	
	function fields() {
		return array(
				'id'=> array('name' => 'id', 'formtype' => 'title', 'datatype' => 'string'),
				'img' => array('name' => '图片', 'formtype' => 'title', 'datatype' => 'string'),
				'title' => array('name' => '标题', 'formtype' => 'title', 'datatype' => 'string'),
				'price' => array('name' => '月租', 'formtype' => 'title', 'datatype' => 'string'),
				'url' => array('name' => '链接地址', 'formtype' => 'title', 'datatype' => 'string'),
				//'cat' => array('name' => '类别名', 'formtype' => 'title', 'datatype' => 'string'),
				//'area' => array('name' => '区域名', 'formtype' => 'title', 'datatype' => 'string'),
				
				'uid' => array('name' => 'uid', 'formtype' => 'title', 'datatype' => 'string'),
				'username' => array('name' => '发布人', 'formtype' => 'title', 'datatype' => 'string'),
				
				'time' => array('name' => '发布时间', 'formtype' => 'title', 'datatype' => 'string'),
				'view' => array('name' => '查看数', 'formtype' => 'title', 'datatype' => 'string'),
		);
	}
	
	function getsetting() {
		$return['area'] = array(
			'title' => '区域ID',
			'type' => 'text',
			'value' =>"",
			'default' => '',
		);
		
		$return['type']=array(
			'title' => '类别',
			'type' => 'select',
			'value' => array(
					array('0', '不限'),
					array('1', '出租'),
					array('2', '求租'),
					array('3', '出售'),
					array('5', '求购'),
				),
			'default' => '0',
		);
		
		$return['kind'] = array(
		'title' => '类型',
		'type' => 'select',
		'value' => array(
			array('all',"不限"),
			array('new',"最新"),
			array('hot',"最热"),
			array('up',"置顶"),
			),
		'default' => "",
		);
		
		/*
		$return['from'] = array(
		'title' => '来源',
		'type' => 'select',
		'value' => array(
			array('all',"不限"),
			array('1',"经纪人"),
			array('2',"个人"),
			),
		'default' => "",
		);*/
		
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
		global $_G;
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
		$sql ="SELECT * FROM ".DB::table("house_post").$where." LIMIT ".$parameter['items'];
		$query = DB::query($sql);
		while($tem = DB::fetch($query)){
			$fields['id'] = $tem['post_id'];
			$fields['url'] = $house_config['root']."?mod=view&post_id=".$tem['post_id'];
			$fields['title'] = $tem['post_title'];
			$fields['text'] = $tem['post_text'];
                        $fields['img'] = $tem['post_img_1'];
			
			$fields['uid'] = $tem['member_uid'];
			$fields['username'] = $tem['member_title'];
			
			$fields['time'] = date($parameter['dateformat'],$tem['post_time']);
			$fields['view'] = $tem['post_view'];
			$picflag = !empty($fields['post_img']) ? 1 : 0;
			
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