<?php
//error_reporting(E_ALL);
if(!defined('IN_DISCUZ')) {exit('Access Denied');}
//echo $_SERVER['SERVER_NAME'];exit;
$post_id = intval($_GET['post_id']);
/*
if(empty($post_id)){
    showmessage("{$info_lang['view_inc_php_1']}!",$info_config['root']);
}*/
$post = fetch_all('info_post'," WHERE post_id='{$post_id}'","*","0");
$now_time = time();
if($now_time > $post['post_begin_time'] && $now_time < $post['post_end_time'])
{
	$post['goods_status'] = 1;
}
else
{
	$post['goods_status'] = 0;
}

//蜘蛛采集的数据不需要调用discuzcode函数转码，通过密码前5位判断
if (substr($post['pwd'],0,5) != '_auto'){
    //以下代码会将HTML作为文本输出
    require_once libfile('function/discuzcode');
    $post['post_text'] = @discuzcode($post['post_text'],-1,0,0,1,1,1,1,0,1,1,1);
}


$member = fetch_all('info_member'," as im LEFT JOIN ".DB::table("common_member_verify")." as cmv ON im.member_uid = cmv.uid WHERE im.member_uid='{$post['member_uid']}'",'*',0);
$member_borker = is_info_broker($member['member_uid']);

if($member_borker){
    $_member_profle = fetch_all('info_member_profile'," WHERE member_uid='{$member['member_uid']}'");
    foreach($_member_profle as $key=>$value){
        $_member_profle[$value['profile_setting_name']] = $value['post_profile_title'];
        unset($_member_profle[$key]);
    }
    $member['profile'] =$_member_profle;
    
    $broker_verify = DB::result_first("SELECT verify{$info_config['verify']} FROM ".DB::table('common_member_verify')." WHERE uid='{$member['member_uid']}' ");
}

$profile_type_id = $post['profile_type_id'];
$profile_type_title = get_profile_type_title($profile_type_id);

$op = addslashes($_GET['op']);

if($op == 'send_email')
{
    $to_email = trim($_REQUEST['to_email']);
    $obj = trim($_REQUEST['obj']);
	if(!$to_email)
		showmessage("邮箱地址不能为空！");
	if(!$obj)
		showmessage("邮件内容不能为空！");
    require_once 'bak/sendmail.php';
    $da = DB::fetch(DB::query("select * from pre_email_setting where id = 1"));
    $smtpserver = $da['smtpserver'];
     $smtpserverport =	$da['smtpserverport'];//SMTP服务器端口
     $smtpusermail = $da['smtpusermail'];
     $smtpuser = $da['smtpuser'];
     $smtppass = $da['smtppass'];
     $smtpemailto = $to_email;
     $mailsubject = '人在温哥华：';
    /*$smtpserver 	= 	"smtp.163.com";//SMTP服务器
    $smtpserverport =	25;//SMTP服务器端口
    $smtpusermail 	= 	"zhangjianwenbo@163.com";//"test@126.com";//SMTP服务器的用户邮箱
    $smtpuser 		= 	"zhangjianwenbo@163.com";//SMTP服务器的用户帐号
    $smtppass 		= 	"c123456";//SMTP服务器的用户密码

    $smtpemailto 	= 	"931283138@qq.com";//发送给谁
    $mailsubject 	= 	$username.'报名!';//邮件主题
    $mailtime		=	date("Y-m-d H:i:s");
    $mailbody 		= 	'大大撒大苏打实打实的撒';//$content;//邮件内容
    */ 
	$mailbody = $obj;
    $mailtime		=	date("Y-m-d H:i:s");
    $utfmailbody	=	iconv("UTF-8","GB2312",$mailbody);//转换邮件编码 
    $mailtype 		= 	"HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
     
    
    $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
    $smtp->debug = false;//是否显示发送的调试信息 FALSE or TRUE
	//echo $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $utfmailbody, $mailtype);exit;
    if($smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $utfmailbody, $mailtype))
    {
        showmessage("邮件发送成功！","info.php?mod=view&post_id={$post_id} ");exit;
    }else
    {
        showmessage("邮件发送失败！");exit;
    } 
}

if($op=='del'){
    
    if($_REQUEST['check'] == 'pwd')
    {
        $post_id = $_REQUEST['post_id'];
        $mod = $_REQUEST['mod'];
        $op = $_REQUEST['op'];
        include include template("info:{$style}/del_pwd_check");exit;
    }
    if($_REQUEST['pwd'])
    {
        $pwd = trim($_REQUEST['pwd']);
        $post_id = trim($_REQUEST['post_id']);
        if(!$pwd || !$post_id)
            showmessage("请填写密码！");
         $uid = $_G['uid'];
        if($post['member_uid'] > 0)
        {
            $member_re = DB::fetch(DB::query("select * from pre_ucenter_members where `uid` = '{$post['member_uid']}' "));
           if($uid > 0)
            {
                if($post['member_uid'] != $uid)
                {
                    showmessage("该信息不是您发布的所以您不能修改！");
                }
               
            }
             if($member_re['password'] != md5(md5($post).$member_re['salt']))
                {
                    if($pwd !=  $post['pwd'])
                    {
                        showmessage("您输入的信息密码不对！");
                    }
                }
        }
        else
        {
            //判断信息密码是否正确
            if($pwd != $post['pwd'])
            {
                showmessage("您输入的信息密码不对！");
            }
        }
		for($i =0;$i<30;$i++)
		{
			$nw = 'post_img_'.($i+1);
			@unlink($post[$nw]);
		}
        /*@unlink($post['post_img1']);
        @unlink($post['post_img2']);
        @unlink($post['post_img3']);
        @unlink($post['post_img4']);*/
        DB::delete('info_post'," post_id='{$post_id}'  ");
        DB::delete('info_post_profile'," post_id='{$post_id}'  ");
        
        brian_cat_cache();
        showmessage($info_lang['delete_ok'],"info.php");//sale.php?mod=member&step=check
        
    }
    
    /*if($post['member_uid']==$_G['uid'] || $is_info_admin){
        @unlink($post['post_img1']);
        @unlink($post['post_img2']);
        @unlink($post['post_img3']);
        @unlink($post['post_img4']);
        DB::delete('info_post'," post_id='{$post_id}'  ");
        DB::delete('info_post_profile'," post_id='{$post_id}'  ");
        
        brian_cat_cache();
        showmessage($info_lang['delete_ok'],$info_config['root']."?mod=member&op=mypost");
    }else{
        showmessage($info_lang['no_quanxian']);
    }
    */
}

$profile_setting = get_profile_setting($profile_type_id);
$post_profile_setting = fetch_all("info_post_profile"," WHERE post_id='{$post['post_id']}' ");
foreach($profile_setting as $key=>$ps){
    foreach($post_profile_setting as $pps){
        if($ps['profile_setting_name'] == $pps['profile_setting_name'] ){
            $profile_setting[$key]['post_profile_title'] = $pps['post_profile_title'];
        }
    } 
}

$post_profile = array();
$post_profile = fetch_all("info_post_profile"," as ipp JOIN ".DB::table("info_profile_setting")." as ips ON ipp.profile_setting_name = ips.profile_setting_name WHERE post_id='{$post['post_id']}'");
foreach($post_profile as $key=>$value){
    if($value['profile_setting_formtype']=='checkbox'){
        $post_profile[$key]['post_profile_title'] = unserialize( stripslashes($value['post_profile_title']));
    }
    $post_profile[$value['profile_setting_name']] = $post_profile[$key];
    unset($post_profile[$key]);
}
DB::query("UPDATE ".DB::table('info_post')." SET post_view = `post_view`+1 WHERE post_id='{$post_id}'");

$maybelike_where = " WHERE post_id!='{$post['post_id']}' AND profile_type_id='{$profile_type_id}'  ";
if(!empty($subcat_id)){
    $maybelike_where .=" AND subcat_id ='{$subcat_id}' ";
}
$maybelike_where .=" ORDER BY post_img_1 DESC  LIMIT 5 ";

$maybelike = fetch_all('info_post',$maybelike_where);
foreach($maybelike as $k=>$v){
    $maybelike[$k]['profile'] = get_post_profile($v['post_id']);
}

$maybelike_where = " WHERE member_uid='{$post['member_uid']}' AND post_id!='{$post['post_id']}' AND profile_type_id='{$profile_type_id}'  ";
$maybelike_where .=" ORDER BY post_img_1 DESC LIMIT 5 ";

$otherpost = fetch_all('info_post',$maybelike_where);
foreach($otherpost as $k=>$v){
    $otherpost[$k]['profile'] = get_post_profile($v['post_id']);
}
$post['post_map'] = !empty($post['post_map']) ? $post['post_map'] : $info_config['google_map'];

$subcat_id = intval($post['subcat_id']);
$subcat_title = $cat_array[$subcat_id]['cat_title'];

$navtitle = $post['post_title']." ".$subcat_title." ".$area_title." ".$info_config['name'];
$metakeywords = $post['post_title'].$info_config['seo_keywords'];
$metadescription= $post['post_title'].$info_config['seo_description'];   
//echo "info:{$style}/view";exit;
for($i=0;$i<30;$i++)
{
	$nw = 'post_img_'.($i+1);
	if($post[$nw])
		$info_img[$i]['img'] = $post[$nw];
}
//var_dump($info_img);exit;
include template("info:{$style}/view");
?>