<?php
if(!defined('IN_DISCUZ')) {exit('Access Denied');}
session_start();
if($_POST)
{
    if($_POST['dcj_session'] != $_SESSION['tmp_yanzheng'])
    {
        showmessage('表单令牌不对请刷新页面重新提交！');
    }
    
    include template("info:{$style}/{$mod}/{$mod}_main");
}
else
{
	$_SESSION['tmp_yanzheng'] = rand(0,10000).time().rand(0,100000);
	$dcj_session = $_SESSION['tmp_yanzheng'];
}

/*
		DB::update("info_post",array('tid'=>$post_array['tid'])," post_id='{$post_id}'");
		
		
		DB::insert("home_feed",$feed_array);
		

		DB::update("forum_thread",array("subject"=>$post_array['post_title'])," tid='{$post['tid']}'");
		
		showmessage($info_lang['edit_ok'],$info_config['root']."?mod=view&post_id={$post_id}");

			$maxpost= DB::result_first("SELECT count(post_id) FROM ".DB::table('info_post')." WHERE profile_type_id!='2' AND member_uid ='{$_G['uid']}' ");
			
	$has_member = DB::result_first("SELECT member_uid FROM ".DB::table('info_member')." WHERE member_uid='{$_G['uid']}'");
	*/

?>