<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

if(empty($_G['uid']) ) {	showmessage($house_lang['login'],'',array(),array('login' => true));}

$op_array = array('post','postlist','mypostup','profile','setpostup');
$op = in_array($_GET['op'],$op_array) ? addslashes($_GET['op']) : 'mypost';

$is_house_broker = is_house_broker();

if($op=='post'){
	require_once DISCUZ_ROOT."./source/plugin/house/module/{$mod}/{$mod}_{$op}.inc.php";
}elseif($op =='mypost' || $op=='mypostup'){
	$ac = !empty( $_GET['ac']) ? addslashes($_GET['ac']) : '';
	$where = " WHERE member_uid='{$_G['uid']}'";
	if($ac == 'up'){
		$where .=" AND post_up='1' ";
	}
	$where .=" ORDER BY post_up DESC,post_time DESC ";
	$pagenum = DB::result_first("SELECT count('post_id') FROM ".DB::table('house_post').$where);
	$page = $_GET['page']? intval($_GET['page']):1;
	$perpage = $house_config['perpage'];
	$urlnow = $house_config['root']."?mod={$mod}&op={$op}&ac={$action}";
	$multipage = multi($pagenum, $perpage, $page, $urlnow , 0, 10);
	$stat_limit = ($page -1) * $perpage;
	$where .= " LIMIT {$stat_limit},{$perpage}";
	
	$post_list = fetch_all('house_post',$where);
}elseif($op =='user'){
	$uid = $_G['uid'];
	$user = fetch_all('house_user'," WHERE user_uid='{$uid}'");
	$user = $user[0];
	$gpc_user = gpc('user_');
	$gpc_user['user_company_text'] =stripslashes($gpc_user['user_company_text']);
	
	if(submitcheck('submit_user')){
		if(!empty($user['user_uid'])){
			DB::update('house_user',$gpc_user," user_uid='{$user['user_uid']}'");
			showmessage($house_lang['edit_ok']);
		}else{
			DB::insert('house_user',$gpc_user);
			showmessage($house_lang['edit_ok']);
		}
	}
}elseif($op =='resume'){
	$user_id = $_G['uid'];
	
	$resume = fetch_all('house_member_resume'," WHERE user_id='{$user_id}'","*","0");
	require_once libfile('function/discuzcode');
	$resume['resume_work_bbcode'] = discuzcode($resume['resume_work'],0,0);
	$resume['resume_skill_bbcode'] = discuzcode($resume['resume_skill'],0,0);
	$resume['resume_language_bbcode'] = discuzcode($resume['resume_language'],0,0);
	
	$gpc_resume = gpc('resume_');
	$gpc_resume['resume_birthday'] = strtotime($gpc_resume['resume_birthday']);
	if(submitcheck('submit_resume')){
		if(!empty($resume['user_id'])){
			DB::update('house_member_resume',$gpc_resume," user_id='{$user_id}' ");
			showmessage($house_lang['edit_ok'],$house_config['root']."?mod=member&op=resume");
		}else{
			$gpc_resume['user_id'] = $user_id;
			DB::insert('house_member_resume',$gpc_resume);
			showmessage($house_lang['edit_ok'],$house_config['root']."?mod=member&op=resume");
		}
	}
	
	$profile_type_id = "1";
	$profile_setting = get_profile_setting();
	
	$district = fetch_all('common_district'," WHERE level = '1'");
	
}elseif($op =='mycredit'){
	if(empty($house_config['extcredits'])){
		showmessage($house_lang['no_extcredits']);
	}else{
		$credit = DB::result_first("SELECT extcredits{$house_config['extcredits']} FROM ".DB::table('common_member_count')." WHERE uid='{$_G['uid']}'");
		$credit_log =fetch_all('house_up'," as su LEFT JOIN ".DB::table('house_post')." as sg ON su.post_id = sg.post_id WHERE sg.member_uid='{$_G['uid']}'");
	}
}elseif($op=='fav'){
	if($_GET['action']=='del'){
		DB::delete('house_member_fav'," post_id='".intval($_GET['post_id'])."' AND user_id='{$_G['uid']}'");
		showmessage($house_lang['done'],$house_config['root']."?mod=member&op=fav");
	}
	$fav_list = fetch_all("house_post"," as jp LEFT JOIN ".DB::table('house_member_fav')." as jma ON jma.post_id = jp.post_id WHERE jma.user_id='{$_G['uid']}'");
}elseif($op=='apply'){
	$apply_list = fetch_all("house_post"," as jp LEFT JOIN ".DB::table('house_member_apply')." as jma ON jma.post_id = jp.post_id WHERE jma.user_id='{$_G['uid']}'");
}elseif($op=='profile'){
	require_once DISCUZ_ROOT.'./source/plugin/house/module/'.$mod.'/'.$mod.'_profile.inc.php';
}elseif($op=='setpostup'){
	require_once DISCUZ_ROOT.'./source/plugin/house/module/'.$mod.'/'.$mod.'_setpostup.inc.php';
}elseif($op=='view'){
	$uid =!empty($_GET['uid']) ? intval($_GET['uid']) : $_G['uid'];
	$resume = fetch_all('house_member_resume'," WHERE user_id='{$uid}'","*","0");
	require_once libfile('function/discuzcode');
	$resume['resume_work'] = discuzcode($resume['resume_work'],0,0);
	$resume['resume_skill'] = discuzcode($resume['resume_skill'],0,0);
	$resume['resume_language'] = discuzcode($resume['resume_language'],0,0);
	
	$verify = DB::result_first("SELECT verify{$house_config['verify']} FROM ".DB::table('common_member_verify')." WHERE uid='{$uid}' ");
	
}

$navtitle = $house_lang['space']." - ".$house_config['name'];
include template("house:{$style}/{$mod}/{$mod}_main");
?>