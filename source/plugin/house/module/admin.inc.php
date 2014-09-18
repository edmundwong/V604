<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

if(empty($_G['uid']) ) {	showmessage($house_lang['login'],'',array(),array('login' => true));}

$op = !empty($_GET['op']) ?  addslashes($_GET['op']) : 'post_loupan';

if($op =='post_loupan'){
	$ac = !empty($_GET['ac']) ?  addslashes($_GET['ac']) : 'post';
	
	if($is_house_admin && !empty($ac)){
		if($ac =='edit'){
			$loupan_id = intval($_GET['lid']);
			$loupan = fetch_all('house_loupan'," WHERE loupan_id='{$loupan_id}'","*",0);
			
			$loupan['loupan_text'] = stripslashes($loupan['loupan_text']);
		}
		
		if($ac =='del'){
			$loupan_id = intval($_GET['lid']);
			DB::delete("house_loupan","loupan_id='{$loupan_id}'");
			showmessage($house_lang['delete_ok'],$house_config['root']."?mod=loupan",'sussce');
		}
	}else{
		showmessage($house_lang['no_quanxian']);
	}
	
	if(submitcheck('submit_loupan_post')){
		if(empty($_GET['province']) && $ac=='post' ){
			showmessage($house_lang['admin_1']);
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
		
		require_once DISCUZ_ROOT.'./source/plugin/house/include/update_class.func.php';
		$post_upload_file_array = array('loupan_img');
		foreach($post_upload_file_array as $file_name){
			if($_FILES[$file_name]['size']){
				@$post_array[$file_name] = upload_file($file_name,'house','320','240');
			}
		}
		
		if($ac =='post'){
			$loupan_id = DB::insert('house_loupan',$post_array,$loupan_id = true);
			showmessage($house_lang['post_ok'],$house_config['root']."?mod=loupan&op=view&lid={$loupan_id}");
		}elseif($ac =='edit'){
			DB::update('house_loupan',$post_array,"loupan_id='{$loupan_id}'");
			showmessage($house_lang['edit_ok'],$house_config['root']."?mod=loupan&op=view&lid={$loupan_id}");
		}
	}
	
}elseif($op =='mypost_loupan'){
	
}

$loupan['loupan_map'] =  !empty($loupan['loupan_map']) ? $loupan['loupan_map'] : $house_config['google_map'];
include template("house:{$style}/{$mod}/{$mod}_main");
?>