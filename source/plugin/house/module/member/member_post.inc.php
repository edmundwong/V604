<?php

 
if(!defined('IN_DISCUZ')) {exit('Access Denied');}

if(empty($_G['uid']) ) {	showmessage($house_lang['login'],'',array(),array('login' => true));}

$post_id = intval($_GET['post_id']);
$ac = !empty($_GET['ac']) ? addslashes($_GET['ac']) : 'post';

$my_credit = fetch_all("common_member_count"," WHERE uid='{$_G['uid']}'"," extcredits{$house_config['extcredits']} ","0");
$my_credit = $my_credit["extcredits{$house_config['extcredits']}"];

$profile_type_id = !empty($_GET['profile_type_id']) ? intval($_GET['profile_type_id']) : 1;
$profile_setting = get_profile_setting($profile_type_id);
$profile_type_title = get_profile_type_title($profile_type_id);

if(!empty($post_id)){
	$post = fetch_all('house_post'," WHERE post_id='{$post_id}'","*",0);
}

$post['post_map'] = !empty($post['post_map']) ? $post['post_map'] : $house_config['google_map'];

if(submitcheck('button_post_submit') || submitcheck('button_edit_submit')){

	if(empty($_GET['post_text']) || empty($_GET['post_title']) || empty($_GET['post_begin_time'])  || empty($_GET['post_end_time']) ){
		showmessage($house_lang['must_post']);
	}
	
	if($ac=='post' && $house_config['postcredit'] >0 ){
		$new_credit = $my_credit - $house_config['postcredit'];
		if($new_credit <0){
			showmessage($house_lang['post'].$house_config['credit_unit'].$house_lang['not_credit']);
		}else{
			updatemembercount($_G['uid'], array( $house_config['extcredits'] => -$house_config['postcredit']),1,'','','',
			$house_lang['fabu_koufei'],
			$house_config['name'].": <a href='{$house_config['root']}?mod=member' target='_blank'>{$house_lang['about_info']}</a>"
			);
		}
	}
	
	$post_array = gpc('post_');
	
	if(!empty($_GET['province'])){
		$post_array['province'] = addslashes($_GET['province']);
		$post_array['city'] =  addslashes($_GET['city']);
		$post_array['dist'] =  addslashes($_GET['dist']);
		$post_array['community'] =  addslashes($_GET['community']);
	}
	
	if(!empty($_GET['loupan'])){
		$loupan = addslashes($_GET['loupan']);
		if(strstr($loupan,"@@")){
			list($post_array['loupan_id'],$post_array['loupan_title']) = explode("@@",$loupan);
		}elseif(!empty($_GET['loupan_id']) && !empty($_GET['loupan_title'])){
			list($post_array['loupan_id'],$post_array['loupan_title']) =array(intval($_GET['loupan_id']),addslashes($_GET['loupan_title']));
		}else{
			$post_array['loupan_id'] = '';
			$post_array['loupan_title'] = $loupan;
		}
	}
	
	$post_array['post_time'] = time();
	
	$post_array['post_begin_time'] = strtotime($post_array['post_begin_time']);
	$post_array['post_end_time'] = strtotime($post_array['post_end_time']);
	
	if($ac =='post'){
		$post_array['member_uid'] = $_G['uid'];
	}
	
	require_once DISCUZ_ROOT.'./source/plugin/house/include/update_class.func.php';
	$post_upload_file_array = array('post_img_1','post_img_2','post_img_3','post_img_4');
	foreach($post_upload_file_array as $file_name){
		if($_FILES[$file_name]['size']){
			@$post_array[$file_name] = upload_file($file_name,'house',"600","400");
		}
	}
	
	$post_array['profile_type_id'] = $profile_type_id;
	$post_array['profile_type_title'] = $profile_type_title;
	
	if($ac =='post'){
		$post_id = DB::insert('house_post',$post_array,$post_id = true);
		foreach($profile_setting as $v){
			if($v['profile_setting_name'] == 'house_allocation'){
				$_GET['profile_setting_'.$v['profile_setting_name']] = serialize($_GET['profile_setting_'.$v['profile_setting_name']]);
			}
			DB::insert("house_post_profile",array('post_id'=>$post_id,'profile_setting_name'=>$v['profile_setting_name'],'profile_setting_title'=>$v['profile_setting_title'],'post_profile_title'=>addslashes($_GET['profile_setting_'.$v['profile_setting_name']])));
		}
	}elseif($ac =='edit'){
		DB::update('house_post',$post_array,"post_id='{$post_id}'");
		foreach($profile_setting as $v){
			if($v['profile_setting_name'] == 'house_allocation'){
				$_GET['profile_setting_'.$v['profile_setting_name']] = serialize($_GET['profile_setting_'.$v['profile_setting_name']]);
			}
			DB::update("house_post_profile",array('post_profile_title'=>addslashes($_GET['profile_setting_'.$v['profile_setting_name']]))," post_id='{$post_id}' AND  profile_setting_name = '{$v['profile_setting_name']}'");
		}
	}
	
	$tid_text_post_text = str_replace("\r\n","<br>", $post_array['post_text']);
	$tid_text = "
[table]
[tr]
[td]{$house_lang['xinxixiangqing']}[/td]
[td][url]{$house_config['root']}?mod=view&post_id={$post_id}[/url][/td]
[/tr]
[tr]
[td]{$house_lang['area']} : [/td]";
if($ac=='post'){
	$tid_text .="[td]{$post_array['province']} {$post_array['city']} {$post_array['dist']} {$post_array['community']}[/td]";
}elseif($ac=='edit'){
	$tid_text .="[td]{$post['province']} {$post['city']} {$post['dist']} {$post['community']}[/td]";
}
$tid_text .= "
[/tr]
[tr]
[td=2,0,0]
{$tid_text_post_text}
[/td]
[/tr]
[/table]";
	
	if($ac =='post'){
		$bbs_post_array = array();
		$bbs_post_array['title'] = "[{$post_array['profile_type_title']}]".$post_array['post_title'];
		$bbs_post_array['text'] = $tid_text;
		$bbs_post_array['uid'] = $_G['uid'];
		$bbs_post_array['username'] = $_G['username'];
		$bbs_post_array['fid'] = $house_config['fid'];
		$post_array['tid'] = bbs_post($bbs_post_array);
		
		DB::update("house_post",array('tid'=>$post_array['tid'])," post_id='{$post_id}'");
		showmessage($house_lang['post_ok'],$house_config['root']."?mod=view&post_id={$post_id}");
	}elseif($ac =='edit'){
		DB::update("forum_thread",array("subject"=>$post_array['post_title'])," tid='{$post['tid']}'");
		DB::update("forum_post",array("subject"=>$post_array['post_title'],"message"=>$tid_text)," tid='{$post['tid']}' AND first=1");
		showmessage($house_lang['edit_ok'],$house_config['root']."?mod=view&post_id={$post_id}");
	}
}

if($ac =='edit'){
	
	$post_profile = fetch_all('house_post_profile'," WHERE post_id='{$post_id}'");
	foreach($post_profile as $key=>$value){
		$value['post_profile_title'] = stripslashes($value['post_profile_title']);
		if($value['profile_setting_name']=='house_allocation'){
			$value['post_profile_title']  = unserialize($value['post_profile_title']);
		}
		
		$post_profile[$value['profile_setting_name']] = $value;
		unset($post_profile[$key]);
	}

	if($post['member_uid'] !=$_G['uid'] && !$is_house_admin){
		showmessage($house_lang['no_quanxian']);
	}
}elseif ($ac =='post'){
	if($house_config['maxpost']>0){
		$member_broker = is_house_broker($_G['uid']);
		if(!$member_broker){
			$maxpost= DB::result_first("SELECT count(post_id) FROM ".DB::table('house_post')." WHERE profile_type_id!='2' AND member_uid ='{$_G['uid']}' ");
			if($maxpost > $house_config['maxpost']){
				$message = "{$house_lang['member_post_1']} {$house_config['maxpost']} {$house_lang['member_post_2']} . <a href='{$house_config['broker_link']}'>{$house_lang['member_post_3']}</a>";
				showmessage($message);
			}
		}
	}
	
	$has_member = DB::result_first("SELECT member_uid FROM ".DB::table('house_member')." WHERE member_uid='{$_G['uid']}'");
	if(empty($has_member)){
		showmessage($house_lang['member_post_4'],$house_config['root']."?mod=member&op=profile");
	}
}

?>