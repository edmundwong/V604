<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

$is_sale_admin = is_sale_admin();
$goods_id = daddslashes($_GET['goods_id']);
$goods = fetch_all('sale_goods'," WHERE goods_id='{$goods_id}'");
$goods = $goods[0];
$goods['goods_text'] = stripslashes($goods['goods_text']);
	if($goods['huodong_star_time'])
	{
		$goods['huodong_star_time'] = date('Y-m-d H:i:s',$goods['huodong_star_time']);
	}
	if($goods['huodong_end_time'])
	{
		$goods['huodong_end_time'] = date('Y-m-d H:i:s',$goods['huodong_end_time']);
	}
/*
if(empty($goods['goods_status']) ){
    if( $goods['member_uid'] !=$_G['uid'] && $is_sale_admin ){
        showmessage($_lang['no_quanxian']);
    }
}*/
//echo 321321;exit;
$op =addslashes($_GET['op']);
$uid = $_G['uid'];
if($op=='del'){
    if($_REQUEST['pwd'])
    {
        
        $post_pwd = trim($_REQUEST['pwd']);
        if($goods['member_uid'] > 0)
        {
            $member_re = DB::fetch(DB::query("select * from pre_ucenter_members where `uid` = '{$goods['member_uid']}' "));
           if($uid > 0)
            {
                if($goods['member_uid'] != $uid)
                {
                    showmessage("该信息不是您发布的所以您不能修改！");
                }
               
            }
             if($member_re['password'] != md5(md5($post_pwd).$member_re['salt']))
                {
                    if($post_pwd !=  $member_re['pwd'])
                    {
                        showmessage("您输入的信息密码不对！");
                    }
                }
        }
        else
        {
            //判断信息密码是否正确
            if($post_pwd != $goods['pwd'])
            {
                showmessage("您输入的信息密码不对！");
            }
        }
        //if($goods['member_uid']==$_G['uid'] || $is_sale_admin){
        $goods_upload_file_array = array('goods_upload_file_1','goods_upload_file_2','goods_upload_file_3','goods_upload_file_4');
        foreach($goods_upload_file_array as $file_name){
            @unlink($goods[$file_name]);
        }
        DB::delete('sale_goods'," goods_id='{$goods_id}'  ");
        showmessage($_lang['delete_ok'],$sale_config['root']);
    }
    else
    {
        include template("sale:{$style}/member_dcj_pwd_check_del");exit;
    }
    
}

$member = fetch_all('sale_member'," WHERE `sale_goods_id`='{$goods_id}'");
$member = $member[0];

DB::query("UPDATE ".DB::table('sale_goods')." SET goods_view = `goods_view`+1 WHERE goods_id='{$goods_id}'");

$maybelike = fetch_all('sale_goods'," LIMIT 10 ");
$maybelike_cat = fetch_all('sale_cat'," LIMIT 10");

$navtitle = $goods['goods_title']." - ".$sale_config['name'];
//echo template("sale:{$style}/view");exit;
include template("sale:{$style}/view");
?>