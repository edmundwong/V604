<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
$_GET['inajax']=1;
$return = '';
$op = addslashes($_GET['op']);

if($op =='cat' ){
	$catbox= addslashes($_GET['catbox']);
	$cat_pid = explode("@@",addslashes($_GET['cat_pid']));
	$cat_pid= $cat_pid[0];
	$subcat_pid = explode("@@",addslashes($_GET['subcat_pid']));
	$subcat_pid= $subcat_pid[0];
	
	$auto = intval($_GET['auto']);
	
	$return .="<select id='cat' name='cat' onchange=\"brian_showcat('{$catbox}',['1','0','0'],'{$info_config['root']}')\" >";
	$return .="<option>-{$info_lang['xuanze']}-</oprion>";
	foreach($cat_array as $v){
		if($v['cat_pid'] == '0'){
			$return .="<option value='{$v['cat_id']}@@{$v['cat_title']}' ";
			if($v['cat_id'] ==$cat_pid){
				$return.=" selected='selected' ";
			}
			$return .=">{$v['cat_title']}</option>";
		}
	}
	$return .="</select>";
	
	$return .="<select id='subcat' name='subcat' #subcat_style#>";
	$subcat_style_switch = 0;
	foreach($cat_array as $v){
		if($v['cat_pid'] == $cat_pid && $v['cat_pid'] !='0'){
			$return .="<option value='{$v['cat_id']}@@{$v['cat_title']}' ";
			if($v['cat_id'] ==$subcat_pid){
				$return.=" selected='selected' ";
			}
			$return .=">{$v['cat_title']}</option>";
			$subcat_style_switch = 1;
		}
	}
	$return .="</select>";
	
	$subcat_style = "";
	if(!$subcat_style_switch){
		$subcat_style = "style='display:none;'";
	}
	$return = str_replace("#subcat_style#",$subcat_style,$return);
	
}elseif($op =='area' ){
	$areabox= addslashes($_GET['areabox']);
	list($area_id,$area_title) = explode("@@",addslashes($_GET['area']));
	list($subarea_id,$subarea_title) = explode("@@",addslashes($_GET['subarea']));
	list($thrarea_id,$thrarea_title) = explode("@@",addslashes($_GET['thrarea']));
	
	$auto = intval($_GET['auto']);
	
	$return .="<select id='area' name='area' onchange=\"brian_showarea('{$areabox}',['1','{$area_id}','{$subarea_id}','{$thrarea_id}'],'{$info_config['root']}')\" >";
	$return .="<option>-{$info_lang['xuanze']}-</oprion>";
	foreach($area_array as $v){
		if($v['area_pid'] == '0'){
			$return .="<option value='{$v['area_id']}@@{$v['area_title']}' ";
			if($v['area_id'] ==$area_id){
				$return.=" selected='selected' ";
			}
			$return .=">{$v['area_title']}</option>";
		}
	}
	$return .="</select>";
	
	$return .="<select id='subarea' name='subarea' #subarea_style#  onchange=\"brian_showarea('{$areabox}',['1','{$area_id}','{$subarea_id}','{$thrarea_id}'],'{$info_config['root']}')\">";
	$subarea_style_switch = 0;
	foreach($area_array as $v){
		if($v['area_pid'] == $area_id && $v['area_pid'] !='0'){
			$return .="<option value='{$v['area_id']}@@{$v['area_title']}' ";
			if($v['area_id'] ==$subarea_id){
				$return.=" selected='selected' ";
			}
			$return .=">{$v['area_title']}</option>";
			$subarea_style_switch = 1;
		}
	}
	$return .="</select>";
	
	$subarea_style = "";
	if(!$subarea_style_switch){
		$subarea_style = "style='display:none;'";
	}
	$return = str_replace("#subarea_style#",$subarea_style,$return);
	
	$return .="<select id='thrarea' name='thrarea' #thrarea_style#>";
	$thrarea_style_switch = 0;
	foreach($area_array as $v){
		if($v['area_pid'] == $subarea_id && $v['area_pid'] !='0'){
			$return .="<option value='{$v['area_id']}@@{$v['area_title']}' ";
			if($v['area_id'] ==$thrarea_id){
				$return.=" selected='selected' ";
			}
			$return .=">{$v['area_title']}</option>";
			$thrarea_style_switch = 1;
		}
	}
	$return .="</select>";
	
	$thrarea_style = "";
	if(!$thrarea_style_switch){
		$thrarea_style = "style='display:none;'";
	}
	$return = str_replace("#thrarea_style#",$thrarea_style,$return);
	
}elseif($op =='fav'){
	$action = addslashes($_GET['action']);
	if(!$_G['uid']){
		showmessage($info_lang['login'],'',array(),array('login' => true));
	}
	
	if($action =='company'){
		$user_id = intval($_GET['user_id']);
		$has_fav = fetch_all('info_company_fav'," WHERE member_uid='{$_G['uid']}' AND user_id='$user_id'",'member_uid',0);
		$has_fav = $has_fav['member_uid'];
		
		if(empty($has_fav)){
			DB::insert("info_company_fav",array('member_uid'=>$_G['uid'],'user_id'=>$user_id,'fav_time'=>time()));
		}
	}else{
		$post_id = intval($_GET['post_id']);
		$has_fav = fetch_all('info_member_fav'," WHERE user_id='{$_G['uid']}' AND post_id='{$post_id}'",'user_id',0);
		
		$has_fav = $has_fav['user_id'];
		
		$post = fetch_all('info_post'," WHERE post_id='{$post_id}'","post_id,post_title",0);
		if(empty($has_fav)){
			DB::insert("info_member_fav",array('user_id'=>$_G['uid'],'post_id'=>$post['post_id'],'post_title'=>$post['post_title'],'fav_time'=>time()));
		}
	}
	include template("info:{$style}/done");
	exit;
}elseif($op =='apply'){
	if(!$_G['uid']){
		showmessage($info_lang['login'],'',array(),array('login' => true));
	}
	
	$post_id = intval($_GET['post_id']);
	$has_apply = fetch_all('info_member_apply'," WHERE user_id='{$_G['uid']}' AND post_id='{$post_id}'",'user_id',0);
	$has_apply = $has_apply['user_id'];
	
	$post = fetch_all('info_post'," WHERE post_id='{$post_id}'","post_id,post_title",0);
	
	$resume = fetch_all('info_member_resume'," WHERE user_id='{$_G['uid']}'","*",0);
	
	if(empty($has_apply) && !empty($resume['user_id'])){
		DB::insert("info_member_apply",array('user_id'=>$_G['uid'],'post_id'=>$post['post_id'],'post_title'=>$post['post_title'],'apply_time'=>time()));
	}elseif(!empty($has_apply)){
		$tips = $info_lang['ajax_inc_php_1'];
	}else{
		$tips = $info_lang['ajax_inc_php_2'];
	}
	
	include template("info:{$style}/done");
	exit;
}elseif($op =='jubao'){
	if(!$_G['uid']){
		showmessage($info_lang['login'],'',array(),array('login' => true));
	}
	
	$post_id = intval($_GET['post_id']);
	$has_jubao = fetch_all('info_post_jubao'," WHERE post_id='{$post_id}'",'jubao_id',0);
	$has_jubao = $has_jubao['jubao_id'];
	
	if(empty($has_jubao)){
		$post = fetch_all('info_post'," WHERE post_id='{$post_id}'","post_id,post_title",0);
		DB::insert("info_post_jubao",array('post_id'=>$post['post_id'],'post_title'=>$post['post_title'],'jubao_time'=>time()));
	}
	
	$tips = $info_lang['ajax_inc_php_3'];
	
	include template("info:{$style}/done");
	exit;
}elseif($op =='changecity' ){
	$area_keys = array();
	foreach($area_array  as $a){
		$area_keys[$a['area_key']] = $a['area_key'];
	}
	array_multisort($area_keys);
	include template("info:changecity");
	dexit();
}

include template("info:ajax");
?>