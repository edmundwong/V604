<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

//if(empty($_G['uid']) ) {	showmessage($_lang['login'],'',array(),array('login' => true));}


$op =!empty( $_GET['op']) ? addslashes($_GET['op']) : 'mypost';
if($_REQUEST['step'] == 'check')
{
    if($_G['uid'] > 0)
    {
        header("Location:/sale.php?mod=member");exit;
    }
    else
    {
       include template("sale:{$style}/member_dcj_guanli_check");exit;//到输入电话号码和邮箱的地方
    }
}
if(trim($_REQUEST['tel']) || trim($_REQUEST['email']))
{
    $tel = trim($_REQUEST['tel']);
    $email = trim($_REQUEST['email']);
    
    if(!$tel && !$email)
    {
        showmessage("请重新输入编辑密码或者登陆密码！！","sale.php?mod=member&step=check");
    }
    
    $info_where  = " where 1=1 ";
    $sale_where = "  where 1=1 ";
    if($tel)
    {
        session_start();
        $_SESSION['tel'] = $tel;
        $info_where .= " and tel like '%{$tel}%' ";
        $sale_where .=" and  m.member_phone like '%{$tel}%' ";
    }
    if($email)
    {
        session_start();
        $_SESSION['email'] = $email;
        $info_where .= " and email like '%{$email}%' ";
        $sale_where .=" and  m.member_email like '%{$email}%' ";
    }
    //echo $info_where;echo $sale_where;exit;
    $info_where .= " order by `post_up` desc,`post_id` desc ";
    $sale_where .=" order by s.goods_up DESC,s.goods_id desc  ";
    $now = time();
    $info_list = fetch_all('info_post',$info_where);//服务信息
    foreach($info_list as $k => $v)
    {
        if($v['post_begin_time'] < $now && $v['post_end_time'] > $now)
            $info_list[$k]['status'] = 1;//已发布
        else
            $info_list[$k]['status'] = 0;//未发布
        $info_list[$k]['fabu_time'] = date('Y/m/d',$v['post_begin_time']);
    }
    $goods_tmp_list = DB::query("select s.* from pre_sale_goods s left join pre_sale_member m on s.goods_id = m.sale_goods_id $sale_where ");
    
    while($a = DB::fetch($goods_tmp_list))
    {

        $a['fabu_time'] = date('Y/m/d',$a['goods_time']);
        $goods_list[] = $a;
    }
    //var_dump($info_list);exit;
    include template("sale:{$style}/member");exit;
    //var_dump($info_list);var_dump($sale_list);exit;  
}

if($op =='mypost' || $op=='mypostup'){
    $where = " WHERE member_uid='{$_G['uid']}'";
    if($op=='mypostup'){
        $where .=" AND goods_up='1' ";
    }
    $where .=" ORDER BY goods_up DESC,goods_time DESC ";
    $pagenum = DB::result_first("SELECT count('goods_id') FROM ".DB::table('sale_goods').$where);
    $page = $_GET['page'] ? intval($_GET['page']):1;
    $perpage = $sale_config['perpage'];
    $urlnow = $sale_config['root']."?mod={$mod}&op={$op}";
    $multipage = multi($pagenum, $perpage, $page, $urlnow , 0, 10);
    $stat_limit = ($page -1) * $perpage;
    //$where .= " LIMIT {$stat_limit},{$perpage}";
    
    $goods_list = fetch_all('sale_goods',$where);
    
    $now = time();
     $info_where .= " where member_uid = '{$_G['uid']}'  order by `post_up` desc,`post_id` desc ";
    $info_list = fetch_all('info_post',$info_where);//服务信息
    foreach($info_list as $k => $v)
    {
        if($v['post_begin_time'] < $now && $v['post_end_time'] > $now)
            $info_list[$k]['status'] = 1;//已发布
        else
            $info_list[$k]['status'] = 0;//未发布
        $info_list[$k]['fabu_time'] = date('Y/m/d',$v['post_begin_time']);
    }
}elseif($op =='memberinfo'){
    $uid = $_G['uid'];
    $member = fetch_all('sale_member'," WHERE member_uid='{$uid}'");
    $member = $member[0];
    if(submitcheck('submit_member')){
        if(!empty($member['member_uid'])){
            DB::update('sale_member',gpc('member_')," member_uid='{$member['member_uid']}'");
            showmessage($_lang['edit_ok']);
        }else{
            DB::insert('sale_member',gpc('member_'));
            showmessage($_lang['edit_ok']);
        }
    }
}elseif($op =='mycredit'){
    if(empty($sale_config['extcredits'])){
        showmessage($_lang['no_extcredits']);
    }else{
        $credit = DB::result_first("SELECT extcredits{$sale_config['extcredits']} FROM ".DB::table('common_member_count')." WHERE uid='{$_G['uid']}'");
        $credit_log =fetch_all('sale_up'," as su LEFT JOIN ".DB::table('sale_goods')." as sg ON su.goods_id = sg.goods_id WHERE sg.member_uid='{$_G['uid']}'");
    }
}elseif($op=='quiteup'){
    session_start();
    $goods_id = intval($_GET['goods_id']);
    DB::update('sale_goods',array('goods_up'=>time())," goods_id='{$goods_id}'");
    showmessage("免费刷新成功！",$sale_config['root']."?mod=member&tel=".$_SESSION['tel']."&email=".$_SESSION['email']);//,
}elseif($op == 'postup')
{	
    session_start();
    $post_id = intval($_REQUEST['post_id']);
    DB::update('info_post',array('post_up' => time())," post_id = '{$post_id}' ");
    showmessage("免费刷新服务信息成功！",$sale_config['root']."?mod=member&tel=".$_SESSION['tel']."&email=".$_SESSION['email']);
    
}
elseif($op=='setpostup'){
    $goods_id = intval($_GET['goods_id']);
    $goods = fetch_all('sale_goods'," WHERE goods_id='{$goods_id}'"," goods_title,goods_id,member_uid ");
    $goods = $goods[0];
    include template("sale:{$style}/setpostup");
    exit;
}elseif($op=='jubao'){
    $goods_id = intval($_GET['goods_id']);
    $goods = fetch_all('sale_goods'," WHERE goods_id='{$goods_id}'"," goods_title,goods_id,member_uid ");
    $goods = $goods[0];
    include template("sale:{$style}/jubao");
    exit;
}

$navtitle = $_lang['member']." - ".$sale_config['name'];
//echo $style;exit;
include template("sale:{$style}/member");
?>