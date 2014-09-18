<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

if(empty($_G['uid']) ) {	showmessage($_lang['login'],'',array(),array('login' => true));}

$goods_id = intval($_GET['goods_id']);
$cat = fetch_all("sale_cat"," WHERE cat_status='1' ORDER BY cat_sort DESC ");

$member = fetch_all('sale_member'," WHERE member_uid='{$_G['uid']}'");
$member = $member[0];

if(submitcheck('edit_submit')){

    if(empty($_GET['goods_title'])){
        showmessage($_lang['must_goods_title']);
    }
    if(empty($_GET['goods_text'])){
        showmessage($_lang['must_goods_text']);
    }
    if(empty($_GET['goods_price'])){
        showmessage($_lang['must_goods_price']);
    }
    if(empty($_GET['member_username'])){
        showmessage($_lang['must_member_username']);
    }
    if(empty($_GET['member_qq'])){
        showmessage($_lang['must_member_qq']);
    }
    if(empty($_GET['member_phone'])){
        showmessage($_lang['must_member_phone']);
    }
    if(!isset($_GET['goods_selltype_sell']) && !isset($_GET['goods_selltype_swap']) && !isset($_GET['goods_selltype_give']) ){
        showmessage($_lang['must_goods_selltype']);
    }
    $goods = gpc('goods_');

    $_member = gpc('member_');
    $_member['member_uid'] = $_G['uid'];
    $_cat = gpc('cat_');
    $_cat = explode("##",$_cat['cat_id']) ;

    if($goods['goods_settime'] != 0){
        if($goods['goods_settime'] == 7){
            $goods['goods_settime'] = strtotime("+7 days");
        }elseif($goods['goods_settime'] == 30){
            $goods['goods_settime'] = strtotime("+30 days");
        }elseif($goods['goods_settime'] == 90){
            $goods['goods_settime'] = strtotime("+90 days");
        }elseif($goods['goods_settime'] == 180){
            $goods['goods_settime'] = strtotime("+180 days");
        }
    }else{
        $goods['goods_settime'] = 0;
    }
    $goods['goods_ip'] = $_SERVER["REMOTE_ADDR"];
    
    $goods_array = $goods;
    if(isset($_GET['province'])){
        $goods_array['province'] = daddslashes($_GET['province']) ; 
        $goods_array['city'] = daddslashes($_GET['city']) ; 
        $goods_array['dist'] = daddslashes($_GET['dist']) ; 
        $goods_array['community'] = daddslashes($_GET['community']) ; 
    }

    $goods_array['member_uid'] = $_member['member_uid'];
    $goods_array['member_username'] = $_member['member_username'];
    $goods_array['cat_id'] = $_cat[0];
    $goods_array['cat_title'] = $_cat[1];
    
    require_once DISCUZ_ROOT.'./source/plugin/sale/include/update_class.func.php';
    $goods_upload_file_array = array('goods_upload_file_1','goods_upload_file_2','goods_upload_file_3','goods_upload_file_4');
    foreach($goods_upload_file_array as $file_name){
        $goods_array[$file_name] = upload_file($file_name,'sale');
    }
    
    $goods_array['goods_time'] = time();
    DB::update('sale_goods',$goods_array,"goods_id='{$goods_id}'");
    showmessage($_lang['edit_ok'],$sale_config['root']."?mod=view&goods_id={$goods_id}");
}

$goods = fetch_all('sale_goods'," WHERE goods_id='{$goods_id}'");
$goods = $goods[0];

if($goods['member_uid'] !=$_G['uid'] && !is_sale_admin()){
    showmessage($_lang['no_quanxian']);
}

$navtitle = $_lang['edit_title'].' - '.$sale_config['name'];
//echo template("sale:{$style}/post");exit;
include template("sale:{$style}/post");
?>