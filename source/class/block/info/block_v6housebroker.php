<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

//debug
//ini_set("display_errors","on");
//set_time_limit(0);
//error_reporting(E_ALL ^ E_NOTICE);
//*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class block_v6housebroker  {
	var $setting = array();
        
	function name() {
		return 'v604_房产经纪人';
	}

	function blockclass() {
		return array('v6housebroker', 'v6房产经纪人');
	}
	
	function fields() {
		return array(
			'uid' => array('name' => 'uid', 'formtype' => 'title', 'datatype' => 'string'),
			'uname' => array('name' => '姓名', 'formtype' => 'title', 'datatype' => 'string'),
                        'url' => array('name' => 'URL', 'formtype' => 'title', 'datatype' => 'string'),
			'img' => array('name' => '发布人头像', 'formtype' => 'title', 'datatype' => 'string'),
                        'email' => array('name' => '工作邮箱', 'formtype' => 'title', 'datatype' => 'string'),
                        'phone' => array('name' => '电话', 'formtype' => 'title', 'datatype' => 'string'),
                        'mobile' => array('name' => '手机', 'formtype' => 'title', 'datatype' => 'string'),
                        'summary' => array('name' => '经纪人简介', 'formtype' => 'title', 'datatype' => 'string'),
			'count' => array('name' => '发布数', 'formtype' => 'title', 'datatype' => 'string')
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
		
		return $return;
	}
        
        function getdata($style, $parameter){
            global $_G,$_lang;
            $array = $list = array();
            
            $s_sql = 'SELECT p.uid,realname,telephone,mobile,site,field1,field2 FROM '
                    .DB::table('common_member_profile').' p INNER JOIN '
                    .DB::table('common_member_verify').' v on p.uid=v.uid WHERE verify5 = 1 LIMIT '.$parameter['items'];
            $query = DB::query($s_sql);
            while($tem = DB::fetch($query)){
                $fields['uid'] = $tem['uid'];
                $fields['uname'] = $tem['realname'];
                $fields['url'] = $tem['site'];
                $fields['img'] = avatar($tem['uid'],'middle');
                $fields['email'] = $tem['field2'];
                $fields['phone'] = str_replace('-', '', $tem['telephone']);
                $fields['mobile'] = $tem['mobile'];
                $fields['summary'] = $tem['field1'];
                
                $list[] = array(
                    'id' =>$fields['uid'],
                    'idtype' => 'uid',
                    'title' => $fields['uname'],
                    'uname' => $fields['uname'],
                    'url' => $fields['url'],
                    'pic' => $fields['img'],
                    'email' => $fields['email'],
                    'phone' => $fields['phone'],
                    'mobile' => $fields['mobile'],
                    'summary' => $fields['summary'],
                    'fields' => $fields,
                );
            }
            
            return array('html' =>'', 'data' => $list);
        }
}
?>