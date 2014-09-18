<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

$post_id = intval($_GET['post_id']);
$post = fetch_all('house_post'," WHERE post_id='{$post_id}'","*","0");

require_once libfile('function/discuzcode');
$post['post_text'] = @discuzcode($post['post_text'],-1,0,0,1,1,1,1,0,1,1,1);

$member = fetch_all('house_member'," WHERE member_uid='{$post['member_uid']}'",'*',0);
$member_borker = is_house_broker($member['member_uid']);

if($member_borker){
	$_member_profle = fetch_all('house_member_profile'," WHERE member_uid='{$member['member_uid']}'");
	foreach($_member_profle as $key=>$value){
		$_member_profle[$value['profile_setting_name']] = $value['post_profile_title'];
		unset($_member_profle[$key]);
	}
	$member['profile'] =$_member_profle;
	
	$broker_verify = DB::result_first("SELECT verify{$house_config['verify']} FROM ".DB::table('common_member_verify')." WHERE uid='{$member['member_uid']}' ");
}

$profile_type_id = $post['profile_type_id'];
$profile_type_title = get_profile_type_title($profile_type_id);

$op = addslashes($_GET['op']);
if($op=='del'){
	if($post['member_uid']==$_G['uid'] || $is_house_admin){
		DB::delete('house_post'," post_id='{$post_id}'  ");
		showmessage($house_lang['delete_ok'],$house_config['root']);
	}else{
		showmessage($house_lang['no_quanxian']);
	}
}

$profile_setting = get_profile_setting($profile_type_id);
$post_profile_setting = fetch_all("house_post_profile"," WHERE post_id='{$post['post_id']}' ");
foreach($profile_setting as $key=>$ps){
	foreach($post_profile_setting as $pps){
		if($ps['profile_setting_name'] == $pps['profile_setting_name'] ){
			$profile_setting[$key]['post_profile_title'] = $pps['post_profile_title'];
		}
	} 
}

$post_profile = array();
$post_profile = fetch_all("house_post_profile"," WHERE post_id='{$post['post_id']}'");
foreach($post_profile as $key=>$value){
	if($value['profile_setting_name']=='house_allocation'){
		$post_profile[$key]['post_profile_title'] = unserialize( stripslashes($value['post_profile_title']));
	}
	$post_profile[$value['profile_setting_name']] = $post_profile[$key];
	unset($post_profile[$key]);
}
DB::query("UPDATE ".DB::table('house_post')." SET post_view = `post_view`+1 WHERE post_id='{$post_id}'");

$area = '';
$area = !empty($post['province']) ? 'province' : $area;
$area = !empty($post['city']) ? 'city' : $area;
$area = !empty($post['dist']) ? 'dist' : $area;
$area = !empty($post['community']) ? 'community' : $area;

$maybelike_where = " WHERE post_id!='{$post['post_id']}' AND profile_type_id='{$profile_type_id}'  ";
if(!empty($area)){
	$maybelike_where .=" AND $area ='{$post[$area]}' ";
}
$maybelike_where .=" LIMIT 3 ";

$maybelike = fetch_all('house_post',$maybelike_where);
foreach($maybelike as $k=>$v){
	$maybelike[$k]['profile'] = get_post_profile($v['post_id']);
}

$maybelike_where = " WHERE member_uid='{$post['member_uid']}' AND post_id!='{$post['post_id']}' AND profile_type_id='{$profile_type_id}'  ";
$maybelike_where .=" LIMIT 3 ";

$otherpost = fetch_all('house_post',$maybelike_where);
foreach($otherpost as $k=>$v){
	$otherpost[$k]['profile'] = get_post_profile($v['post_id']);
}

$post['post_map'] = !empty($post['post_map']) ? $post['post_map'] : $house_config['google_map'];

$navtitle = "[".$profile_type_title."]".$post['post_title']."_".$house_config['name'];
$metakeywords = $post['post_title'].$house_config['seo_keywords'];
$metadescription= $post['post_title'].$house_config['seo_description'];   
include template("house:{$style}/view");
?>