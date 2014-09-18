<?php
/**
dcj
**/
 
if(!defined('IN_ADMINCP')){    exit('Admin Login');}
if(!defined('IN_DISCUZ')) {    exit('Access Denied');}
global $info_config,$_lang;
require_once DISCUZ_ROOT.'./source/plugin/info/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/info/include/function.class.php';

$mod = "admin_neirong";

$urlnow = "/admin.php?action=plugins&operation=config&do=21&identifier=info&pmod=admin_neirong&dcj_action=list"; 

if($_REQUEST['dcj_action'] == 'list')
{   
    $where  = " where 1 =1 ";
    if(isset($_REQUEST['post_title']) && trim($_POST['post_title']))
    {
        $where  .= " and `post_title` = '{$_REQUEST['post_title']}' ";
    }


    $perpage = $info_config['perpage'];
    $page = $_REQUEST['page'] ? intval($_REQUEST['page']) : 1;
    $count = mysql_fetch_assoc(DB::query("select count(*) as c from pre_info_post {$where} "));
    $multipage = multi($count['c'],$perpage,$page,$urlnow,0,10);
    $stat_limit = ($page-1)*$perpage;
    $where .="  order by `post_id` desc  limit {$stat_limit},{$perpage}";
    $post_list = fetch_all('info_post',$where);
    $style="default";
    //var_dump($post_list);exit;
    foreach($post_list as $k => $v)
    {
    	$post_list[$k]['post_time'] = date('Y-m-d',$v['post_time']);
    	if($v['post_begin_time'] > 0)
    	{
    		$post_list[$k]['b_e'] = date('Y-m-d',$v['post_begin_time']).'--'.date('Y-m-d',$v['post_end_time']);
    	}
    	
    }
    //var_dump($po);exit;
    include template("info:admin/admin_dcj_list");exit;
    //var_dump($multipage);exit;   
    //$multipage = multi($pagenum, $perpage, $page, $urlnow , 0, 10);
}
if($_REQUEST['dcj_action'] == 'edit')
{
	$post_id = (int)$_GET['post_id'];
	if($post_id < 1)
		cpmsg("数据错误");
	$sql = "select * from pre_info_post where `post_id` = '{$post_id}' ";
	$s = mysql_fetch_assoc(DB::query($sql));
	$style = "default";
	$s['post_begin_time'] = date('Y-m-d',$s['post_begin_time']);
	$s['post_end_time'] = date('Y-m-d',$s['post_end_time']);
	include template("info:admin/admin_dcj_edit");exit;
}

if($_REQUEST['dcj_action'] == 'doedit')
{
	$post_id = (int)$_REQUEST['post_id'];
	if(!$post_id)
		cpmsg("数据错误");
	$stime = $_REQUEST['post_begin_time'] ? strtotime($_REQUEST['post_begin_time']) : 0;
	$etime = $_REQUEST['post_end_time'] ? strtotime($_REQUEST['post_end_time']) : 0;
	$array = array(
			'post_begin_time'	=>$stime,
			'post_end_time'		=> $etime,
			'price'				=> trim($_REQUEST['price'])
			);
	DB::update('info_post', $array, "`post_id` = '{$post_id}' ");
	brian_cat_cache();
	cpmsg("编辑成功");
	
	
}


   // DB::insert('info_cat',$post);



	// DB::delete('info_cat',$del);



	//DB::update('info_cat',$edit_array,array('cat_id'=>$edit_array['cat_id']));


//brian_cat_cache();

//$profile_type_array = fetch_all("info_profile_type"," ORDER BY profile_type_id ASC");if( !cloudaddons_getmd5("info.plugin") ) { cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "info.plugin"));}

include template("info:admin/admin_cat");
?>


