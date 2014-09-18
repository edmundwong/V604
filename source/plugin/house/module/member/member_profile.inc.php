<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

if(empty($_G['uid']) ) {	showmessage($house_lang['login'],'',array(),array('login' => true));}
$ac = !empty($_GET['ac']) ? addslashes($_GET['ac']) : 'post';

if($is_house_broker){
	$profile_type_id = 4;
	$profile_setting = get_profile_setting($profile_type_id);
	$profile_type_title = get_profile_type_title($profile_type_id);
}

if(submitcheck('submit_member') || submitcheck('submit_member')){

	if(empty($_GET['member_title']) || empty($_GET['member_phone']) ){
		showmessage($house_lang['must_post']);
	}
	
	$post_array = gpc('member_');
	
	$post_array['member_time'] = time();
	
	$post_array['member_uid'] = $_G['uid'];
	
	$post_array['profile_type_id'] = $profile_type_id;
	$post_array['profile_type_title'] = $profile_type_title;
	
	$has_member = DB::result_first("SELECT member_uid FROM ".DB::table('house_member')." WHERE member_uid='{$post_array['member_uid']}'");
	if($has_member){
		DB::update('house_member',$post_array,"member_uid='{$post_array['member_uid']}'");
	}else{
		DB::insert('house_member',$post_array);
	}
	
	$has_member_profile = DB::result_first("SELECT member_uid FROM ".DB::table('house_member_profile')." WHERE member_uid='{$post_array['member_uid']}'");
	if($has_member_profile){
		foreach($profile_setting as $v){
			DB::update("house_member_profile",array('post_profile_title'=>addslashes($_GET['profile_setting_'.$v['profile_setting_name']]))," member_uid='{$post_array['member_uid']}' AND  profile_setting_name = '{$v['profile_setting_name']}'");
		}
	}else{
		foreach($profile_setting as $v){
			DB::insert("house_member_profile",array('member_uid'=>$post_array['member_uid'],'profile_setting_name'=>$v['profile_setting_name'],'profile_setting_title'=>$v['profile_setting_title'],'post_profile_title'=>addslashes($_GET['profile_setting_'.$v['profile_setting_name']])));
		}
	}
	
	if($ac =='post'){
		showmessage($house_lang['post_ok'],$house_config['root']."?mod={$mod}&op={$op}");
	}elseif($ac =='edit'){
		showmessage($house_lang['edit_ok'],$house_config['root']."?mod={$mod}&op={$op}");
	}
}

$post = fetch_all('house_member'," WHERE member_uid='{$_G['uid']}'","*",0);

$post_profile = fetch_all('house_member_profile'," WHERE member_uid='{$_G['uid']}'");
foreach($post_profile as $key=>$value){
	$post_profile[$value['profile_setting_name']] = $value;
	unset($post_profile[$key]);
}

?>