<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

if(empty($_G['uid']) ) {	showmessage($info_lang['login'],'',array(),array('login' => true));}

$op = !empty($_GET['op']) ?  addslashes($_GET['op']) : 'post_loupan';

if($op =='post_loupan'){
	$ac = !empty($_GET['ac']) ?  addslashes($_GET['ac']) : 'post';
	
	if($is_info_admin && !empty($ac)){
		if($ac =='edit'){
			$loupan_id = intval($_GET['lid']);
			$loupan = fetch_all('info_loupan'," WHERE loupan_id='{$loupan_id}'","*",0);
			
			$loupan['loupan_text'] = stripslashes($loupan['loupan_text']);
		}
		
		if($ac =='del'){
			$loupan_id = intval($_GET['lid']);
			DB::delete("info_loupan","loupan_id='{$loupan_id}'");
			showmessage($info_lang['delete_ok'],$info_config['root']."?mod=loupan",'sussce');
		}
	}else{
		showmessage($info_lang['no_quanxian']);
	}
	
	if(submitcheck('submit_loupan_post')){
		if(empty($_GET['province']) && $ac=='post' ){
			showmessage($info_lang['admin_1']);
		}elseif($ac =='edit'){
			$loupan_id = intval($_GET['loupan_id']);
		}
		
		$post_array = gpc('loupan_');
		if(!empty($_GET['province'])){
			$post_array['province'] = addslashes($_GET['province']);
			$post_array['city'] =  addslashes($_GET['city']);
			$post_array['dist'] =  addslashes($_GET['dist']);
			$post_array['community'] =  addslashes($_GET['community']);
		}
		
		require_once DISCUZ_ROOT.'./source/plugin/info/include/update_class.func.php';
		$post_upload_file_array = array('loupan_img');
		foreach($post_upload_file_array as $file_name){
			if($_FILES[$file_name]['size']){
				@$post_array[$file_name] = upload_file($file_name,'info','320','240');
			}
		}
		
		if($ac =='post'){
			$loupan_id = DB::insert('info_loupan',$post_array,$loupan_id = true);
			showmessage($info_lang['post_ok'],$info_config['root']."?mod=loupan&op=view&lid={$loupan_id}");
		}elseif($ac =='edit'){
			DB::update('info_loupan',$post_array,"loupan_id='{$loupan_id}'");
			showmessage($info_lang['edit_ok'],$info_config['root']."?mod=loupan&op=view&lid={$loupan_id}");
		}
	}
	
}elseif($op =='mypost_loupan'){
	
}

$loupan['loupan_map'] =  !empty($loupan['loupan_map']) ? $loupan['loupan_map'] : $info_config['google_map'];
include template("info:{$style}/{$mod}/{$mod}_main");
?>