<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
$_GET['inajax']=1;
$return = '';
$op = addslashes($_GET['op']);

if($op =='cat' ){
	$sub_cat = addslashes($_GET['sub_cat']);
	$classname = addslashes($_GET['classname']);
	$cat_title = urldecode(addslashes($_GET['cat_title']));
	if(strstr($cat_title,"@@")){
		list($cat_id,$cat_title) = explode("@@",$cat_title);
	}else{
		$cat_id = $cat_title;
	}
	foreach($cat_array as $k=>$v){
		if($v['cat_id']==$cat_id){
			$cat_now = $v;
		}
	}
	$return .="<select name='{$sub_cat}' class='{$classname}' >";
	$empty_sub_cat_array = 1;
	foreach($cat_array as $v){
		if($v['cat_pid']==$cat_now['cat_id']){
			$return .="<option value='{$v['cat_id']}'>{$v['cat_title']}</option>";
			$empty_sub_cat_array = 0;
		}
	}
	if($empty_sub_cat_array)
		$return .="<option value=''>{$house_lang['buxian']}</option>";
	$return .="</select>";
}elseif($op =='fav'){
	$action = addslashes($_GET['action']);
	if(!$_G['uid']){
		showmessage($house_lang['login'],'',array(),array('login' => true));
	}
	
	if($action =='company'){
		$user_id = intval($_GET['user_id']);
		$has_fav = fetch_all('house_company_fav'," WHERE member_uid='{$_G['uid']}' AND user_id='$user_id'",'member_uid',0);
		$has_fav = $has_fav['member_uid'];
		
		if(empty($has_fav)){
			DB::insert("house_company_fav",array('member_uid'=>$_G['uid'],'user_id'=>$user_id,'fav_time'=>time()));
		}
	}else{
		$post_id = intval($_GET['post_id']);
		$has_fav = fetch_all('house_member_fav'," WHERE user_id='{$_G['uid']}' AND post_id='{$post_id}'",'user_id',0);
		
		$has_fav = $has_fav['user_id'];
		
		$post = fetch_all('house_post'," WHERE post_id='{$post_id}'","post_id,post_title",0);
		if(empty($has_fav)){
			DB::insert("house_member_fav",array('user_id'=>$_G['uid'],'post_id'=>$post['post_id'],'post_title'=>$post['post_title'],'fav_time'=>time()));
		}
	}
	include template("house:{$style}/done");
	exit;
}elseif($op =='apply'){
	if(!$_G['uid']){
		showmessage($house_lang['login'],'',array(),array('login' => true));
	}
	
	$post_id = intval($_GET['post_id']);
	$has_apply = fetch_all('house_member_apply'," WHERE user_id='{$_G['uid']}' AND post_id='{$post_id}'",'user_id',0);
	$has_apply = $has_apply['user_id'];
	
	$post = fetch_all('house_post'," WHERE post_id='{$post_id}'","post_id,post_title",0);
	
	$resume = fetch_all('house_member_resume'," WHERE user_id='{$_G['uid']}'","*",0);
	
	if(empty($has_apply) && !empty($resume['user_id'])){
		DB::insert("house_member_apply",array('user_id'=>$_G['uid'],'post_id'=>$post['post_id'],'post_title'=>$post['post_title'],'apply_time'=>time()));
	}elseif(!empty($has_apply)){
		$tips = $house_lang['ajax_inc_php_1'];
	}else{
		$tips = $house_lang['ajax_inc_php_2'];
	}
	
	include template("house:{$style}/done");
	exit;
}elseif($op =='jubao'){
	if(!$_G['uid']){
		showmessage($house_lang['login'],'',array(),array('login' => true));
	}
	
	$post_id = intval($_GET['post_id']);
	$has_jubao = fetch_all('house_post_jubao'," WHERE post_id='{$post_id}'",'jubao_id',0);
	$has_jubao = $has_jubao['jubao_id'];
	
	if(empty($has_jubao)){
		$post = fetch_all('house_post'," WHERE post_id='{$post_id}'","post_id,post_title",0);
		DB::insert("house_post_jubao",array('post_id'=>$post['post_id'],'post_title'=>$post['post_title'],'jubao_time'=>time()));
	}
	
	$tips = $house_lang['ajax_inc_php_3'];
	
	include template("house:{$style}/done");
	exit;
}elseif($op == 'district') {
	$container = addslashes($_GET['container']);
	$_GET['pid'] = !empty($_GET['pid']) ? intval($_GET['pid']) : $house_config['upid'];
	$_GET['level'] = !empty($_GET['level']) ? intval($_GET['level']) : $house_config['level'];
	$showlevel = intval($_GET['level']);

	$showlevel = $showlevel >= 1 && $showlevel <= 4 ? $showlevel : 4;
	$values = array(intval($_GET['pid']), intval($_GET['cid']), intval($_GET['did']), intval($_GET['coid']));
	$level = 1;
	if($values[0]) {
		$level++;
	}
	if($values[1]) {
		$level++;
	}
	if($values[2]) {
		$level++;
	}
	if($values[3]) {
		$level++;
	}
	$showlevel = $level;
	$elems = array();
	if($_GET['province']) {
		$elems = array(addslashes($_GET['province']), addslashes($_GET['city']), addslashes($_GET['district']), addslashes($_GET['community']));
	}
	$return = brian_showdistrict($values, $elems, $container, $showlevel, $containertype);
}elseif($op =='area_loupan'){
	
	$province = urldecode(addslashes($_GET['province']));
	$city = urldecode(addslashes($_GET['city']));
	$dist = urldecode(addslashes($_GET['dist']));
	$community = urldecode(addslashes($_GET['community']));
	
	$where = ' WHERE 1=1 ';
	if(!empty($community)){
		$where .= " AND community ='{$community}' ";
	}elseif(!empty($dist)){
		$where .= " AND dist ='{$dist}' ";
	}elseif(!empty($city)){
		$where .= " AND city ='{$city}' ";
	}elseif(!empty($province)){
		$where .= " AND province ='{$province}' ";
	}else{
		$where .=" AND 1=2 ";
	}
	
	$area_array = fetch_all('house_loupan',$where);

	$return ='';
	if(!empty($area_array)){
		$return = "<select name='loupan' >";
		foreach($area_array as $key=>$value){
			$return .="<option value='{$value['loupan_id']}@@{$value['loupan_title']}'>{$value['loupan_title']} - {$value['loupan_company']}</option>";
		}
		$return .="</select>";
	}
}

include template("house:ajax");
?>