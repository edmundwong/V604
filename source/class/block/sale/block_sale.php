<?php
/**
 *      [DMEMBER] (C)2011-2012 BRIAN.HTML
 *      This is NOT a freeware, use is subject to license terms
 *		QQ：232040337
 *      EMAIL：232040337@qq.com
 */
 /*
ini_set("display_errors","on");
set_time_limit(0);
error_reporting(E_ALL ^ E_NOTICE);
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class block_sale  {
	var $setting = array();

	function name() {
		return '二手插件DIY';
	}

	function blockclass() {
		return array('sale', '二手插件DIY');
	}
	
	function fields() {
		return array(
                    'goods_id' => array('name' => '信息ID', 'formtype' => 'title', 'datatype' => 'string'),
                    'member_username' => array('name' => '发布人', 'formtype' => 'text', 'datatype' => 'string'),
                    'url' => array('name' => '链接地址', 'formtype' => 'text', 'datatype' => 'string'),
                    'goods_title' => array('name' => '信息标题', 'formtype' => 'title', 'datatype' => 'string'),
                    'category_title' => array('name' => '类别名', 'formtype' => 'title', 'datatype' => 'string'),
                    'resideprovince' => array('name' => '省份', 'formtype' => 'title', 'datatype' => 'string'),
                    'residecity' => array('name' => '城市', 'formtype' => 'title', 'datatype' => 'string'),
                    'residedist' => array('name' => '地区', 'formtype' => 'title', 'datatype' => 'string'),
                    'residecommunity' => array('name' => '街道', 'formtype' => 'title', 'datatype' => 'string'),
                    'goods_text' => array('name' => '内容', 'formtype' => 'title', 'datatype' => 'string'),
                    'goods_time' => array('name' => '发布时间', 'formtype' => 'text', 'datatype' => 'string'),
                    'goods_price' => array('name' => '价格', 'formtype' => 'text', 'datatype' => 'string'),
                    'goods_number' => array('name' => '数量', 'formtype' => 'text', 'datatype' => 'string'),
                    'goods_view' => array('name' => '浏览量', 'formtype' => 'text', 'datatype' => 'string'),
                    'goods_upload_file_1' => array('name' => '图片', 'formtype' => 'text', 'datatype' => 'string'),
		);
	}
	
	function getsetting() {
		return array();
	}
	
	function getdata($style, $parameter) {
		global $_G;
		$array = $list = array();

		$array = self::fetch_all('sale_goods',' order by goods_id desc ');
		foreach($array as $a){
			$a['goods_time'] = date('Y-m-d',$a['goods_time'] );
			$a['goods_upload_file_1'] = empty($a['goods_upload_file_1']) ? $_G['siteurl']."static/image/common/nophotosmall.gif" : $a['goods_upload_file_1'];
                        $a['goods_text'] = mb_substr(strip_tags($a['goods_text']),0,30,'UTF-8');
                        $a['url'] =  'sale.php?mod=view&goods_id='.$a['goods_id'];
			$list[] = array(
					'id' =>$a['id'],
					'idtype' => 'uid',
					'title' => $a['yzname'],
					'url' => 'sale.php?mod=view&goods_id='.$a['goods_id'],
					'pic' => '',
					'picflag' => 0,
					'summary' => '',
					'fields' => $a,
					);
		}
		return array('html' =>'', 'data' => $list);
	}
	
	function fetch_all($table,$other='',$filter='*',$first="1"){
		$sql = 'SELECT '.$filter.' FROM '.DB::table($table).' '.$other;
		$query =DB::query($sql);
		$array = array();
		while($tem = DB::fetch($query)){
			$array[] = $tem;
		}
		if($first=="0"){
			$array = $array[0];
		}
		return $array;
	}

	
}
?>

