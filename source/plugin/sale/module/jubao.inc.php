<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

$goods_id = intval($_GET['goods_id']);

//if(submitcheck('submit_jubao')){
    
    $goods_title = fetch_all('sale_goods'," WHERE goods_id='{$goods_id}'"," goods_title ");
    $goods_title = $goods_title[0]['goods_title'];
    DB::insert('sale_jubao',array('goods_id'=>$goods_id,'goods_title'=>$goods_title,'jubao_time'=>time(),'reason' => $_REQUEST['reason']));
    $admin_group = unserialize($sale_config['admingroup']);
    $admin_group = dimplode($admin_group);
    $notice_uids = fetch_all('common_member'," WHERE groupid IN ({$admin_group}) OR adminid='1' ",' uid ');
    foreach($notice_uids as $u){
        notification_add($u['uid'],'system',"[".$sale_config['name']."] ".$_lang['note_new_jubao']);
    }
     header('Content-Type:text/html; charset=utf-8');
    //exit('1');
    exit(json_encode(array('data' => 0,'info' => '举报成功','status' => 1)));
    //showmessage($_lang['jubao_ok'],$sale_config['root']."?mod=view&goods_id={$goods_id}");
//}

$navtitle = $_lang['member']." - ".$sale_config['name'];
include template("sale:{$style}/jubao");
?>