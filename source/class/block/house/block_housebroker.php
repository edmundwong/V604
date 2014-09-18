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

class block_housebroker  {
	var $setting = array();

	function name() {
		return '房产经纪人';
	}

	function blockclass() {
		return array('housebroker', '房产经纪人');
	}
	
	function fields() {
		return array(
			/*
			'id'=> array('name' => 'id', 'formtype' => 'title', 'datatype' => 'string'),
			'price' => array('name' => '价格', 'formtype' => 'title', 'datatype' => 'string'),
			'area' => array('name' => '面积', 'formtype' => 'title', 'datatype' => 'string'),
			'img' => array('name' => '图片', 'formtype' => 'title', 'datatype' => 'string'),
			'title' => array('name' => '标题', 'formtype' => 'title', 'datatype' => 'string'),
			'cat' => array('name' => '类别名', 'formtype' => 'title', 'datatype' => 'string'),
			'loupan' => array('name' => '楼盘名', 'formtype' => 'title', 'datatype' => 'string'),
			'time' => array('name' => '发布时间', 'formtype' => 'title', 'datatype' => 'string'),
			'view' => array('name' => '查看数', 'formtype' => 'title', 'datatype' => 'string'),
			*/
			
			'uid' => array('name' => 'uid', 'formtype' => 'title', 'datatype' => 'string'),
			'username' => array('name' => '发布人', 'formtype' => 'title', 'datatype' => 'string'),
			'img' => array('name' => '发布人头像', 'formtype' => 'title', 'datatype' => 'string'),

			'count' => array('name' => '发布数', 'formtype' => 'title', 'datatype' => 'string'),
		);
	}
	
	function getsetting() {
		$return['kind'] = array(
				'title' => '类型',
				'type' => 'select',
				'value' => array(
					array('all',"不限"),
					array('new',"最新发布"),
					array('hot',"发布最多"),
					),
				'default' => "",
		);
		return $return;
	}
	
	function getdata($style, $parameter) {
		global $_G,$_lang;
		require_once DISCUZ_ROOT.'./source/plugin/house/include/config.inc.php';
		
		$array = $list = array();
		$where =" GROUP BY member_uid ";
		if($parameter['kind']=='new'){
			$where .=" ORDER BY post_time DESC ";
		}elseif($parameter['kind']=='hot'){
			$where .=" ORDER BY post_view DESC ";
		}
		
		$sql ="SELECT *,count(post_id) as count FROM ".DB::table("house_post").$where." LIMIT ".$parameter['items'];
		$query = DB::query($sql);
		while($tem = DB::fetch($query)){
			$fields['id'] = $tem['post_id'];
			$fields['url'] = $house_config['root']."?mod=view&post_id=".$tem['post_id'];
			$fields['title'] = $tem['post_title'];
			$fields['text'] = $tem['post_text'];
			$fields['img'] = avatar($tem['member_uid'],"big");
			
			$fields['uid'] = $tem['member_uid'];
			$fields['username'] = $tem['member_title'];
			
			$fields['time'] = date($parameter['dateformat'],$tem['post_time']);
			$fields['view'] = $tem['post_view'];
			
			$fields['count'] = $tem['count'];
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