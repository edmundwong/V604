<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
loadcache('diytemplatename');

$op = !empty($_GET['op']) ?  addslashes($_GET['op']) : 'index';

if($op =='index'){
	$upid = !empty($_GET['upid']) ? intval($_GET['upid']) : $house_config['upid'] ;
	$area_level = !empty($_GET['level']) ? intval($_GET['level']) : $house_config['level'];
	$area_array = fetch_all('house_area'," WHERE upid='{$upid}'");
	$pre_area = fetch_all('house_area'," WHERE id='{$upid}' ","*",0);
	$pre_area['uname'] = DB::result_first("SELECT name FROM ".DB::table('house_area')." WHERE id='{$pre_area['upid']}'");
	$loupan_type = addslashes($_GET['loupan_type']);
	$loupan_junjia_1 = addslashes($_GET['loupan_junjia_1']);
	$loupan_junjia_2 = addslashes($_GET['loupan_junjia_2']);
	$loupan_title = addslashes(htmlspecialchars($_GET['loupan_title']));
	
	if($upid){
		switch($area_level){
			case "1": $area = 'province'; break;
			case "2": $area = 'city'; break;
			case "3": $area = 'dist'; break;
			case "4": $area = 'community'; break;
			default : $area = 'province'; break;
		}
		$where = " WHERE $area='{$pre_area['name']}' ";
	}else{
		$where = " WHERE 1=1 ";
	}
	
	if(!empty($loupan_type)){
		$where .=" AND loupan_type = '{$loupan_type}'";
	}
	
	if(!empty($loupan_junjia_2)){
		$where .=" AND loupan_junjia BETWEEN {$loupan_junjia_1} AND {$loupan_junjia_2}";
	}
	
	if(!empty($loupan_title)){
		$where .=" AND loupan_title LIKE '%{$loupan_title}%'";
	}
	
	$pagenum = DB::result_first("SELECT count('loupan_id') FROM ".DB::table('house_loupan').$where);
	$page = $_GET['page']? intval($_GET['page']):1;
	$perpage = $house_config['perpage'];
	$urlnow = $house_config['root']."?mod=loupan&upid={$upid}&level={$level}";
	if(!empty($loupan_type)){
		$urlnow .="&loupan_type=".$loupan_type;
	}
	if(!empty($loupan_junjia_2)){
		$urlnow .="&loupan_junjia_1=".$loupan_junjia_1."&loupan_junjia_2=".$loupan_junjia_2;
	}
	if(!empty($loupan_title)){
		$urlnow .="&loupan_title={$loupan_title}";
	}
	$multipage = multi($pagenum, $perpage, $page, $urlnow , 0, 10);
	$stat_limit = ($page -1) * $perpage;
	$where .= " ORDER BY loupan_id DESC LIMIT {$stat_limit},{$perpage}";
	$post_array = fetch_all('house_loupan',$where);
	
	if(!empty($pre_area['name'])){
		$navtitle = $pre_area['name']."_".$house_config['name'];
	}
}elseif($op =='view'){
	$loupan_id = intval($_GET['lid']);
	$loupan= fetch_all('house_loupan'," WHERE loupan_id='{$loupan_id}'","*",0);
	
	$ac = !empty($_GET['ac']) ?  addslashes($_GET['ac']) : 'index';
	
	require_once libfile('function/discuzcode');
	$loupan['loupan_text'] = htmlspecialchars_decode($loupan['loupan_text']);
	$loupan['loupan_text'] = stripslashes($loupan['loupan_text']);
	$loupan['loupan_text'] = @ discuzcode($loupan['loupan_text'],-1,0,0,1,1,1,1,0,1,1,1);
	
	$zhoubian_where  = " WHERE 1=1 ";
	if($loupan['province']){
		$zhoubian_where .=" AND province='{$loupan['province']}'";
	}
	if($loupan['city']){
		$zhoubian_where .=" AND city='{$loupan['city']}'";
	}
	if($loupan['dist']){
		$zhoubian_where .=" AND dist='{$loupan['dist']}'";
	}
	if($loupan['community']){
		$zhoubian_where .=" AND community='{$loupan['community']}'";
	}
	$zhoubian_where .=" LIMIT 10";
	
	$zhoubain = fetch_all("house_loupan",$zhoubian_where);
	
	$loupan_img = fetch_all("house_loupan_img","WHERE loupan_id='{$loupan_id}'");
	$loupan_img_0  = DB::result_first("SELECT count(img_id) FROM ".DB::table('house_loupan_img')." WHERE loupan_id='{$loupan_id}'");
	$loupan_img_1  = DB::result_first("SELECT count(img_id) FROM ".DB::table('house_loupan_img')." WHERE img_cat_id='1' AND loupan_id='{$loupan_id}'");
	$loupan_img_2  = DB::result_first("SELECT count(img_id) FROM ".DB::table('house_loupan_img')." WHERE img_cat_id='2' AND loupan_id='{$loupan_id}'");
	$loupan_img_3  = DB::result_first("SELECT count(img_id) FROM ".DB::table('house_loupan_img')." WHERE img_cat_id='3' AND loupan_id='{$loupan_id}'");
	$loupan_img_4  = DB::result_first("SELECT count(img_id) FROM ".DB::table('house_loupan_img')." WHERE img_cat_id='4' AND loupan_id='{$loupan_id}'");
	
	if(submitcheck('upload_pic')){
		$img_array = gpc("img_");
		
		$post_upload_file_array = array('img_pic');
		foreach($post_upload_file_array as $file_name){
			if($_FILES[$file_name]['size']){
				@$img_array[$file_name] = upload_image($file_name,'house',"1280","960");
			}
		}
		
		$img_array['loupan_id'] = $loupan_id;
		$img_array['img_cat_title'] = $loupan_cat[$img_array['img_cat_id']]['loupan_cat_title'];
		
		DB::insert("house_loupan_img",$img_array);
		showmessage($house_lang['post_ok'],$house_config['root']."?mod=loupan&op=view&lid={$loupan_id}&ac=img");
	}
	if($ac=='imgview'){
		$img_id = intval($_GET['img_id']);
		$img = fetch_all("house_loupan_img"," WHERE img_id='{$img_id}'","*","0");
		
		$navtitle = $img['img_title']."_".$loupan['loupan_title']."_".$house_lang['loupan']."_".$pre_city['name'] .$house_config['name'];
	}elseif($ac=='kanfang'){
		if(!empty($_GET['kan_name'])){
			$kan = gpc("kan_");
			$kan['kan_phone'] = trim($kan['kan_phone']);
			//if( strlen($kan['kan_phone']) != 11){
				//showmessage("{$house_lang['loupan_inc_php_1']}!",$house_config['root']."?mod=loupan&op=view&lid={$loupan_id}&ac=kanfang");
			//}
			$kan['loupan_id'] = $loupan_id;
			$kan['kan_dateline'] = TIMESTAMP;
			DB::insert("house_loupan_kan",$kan);
			
			$groupids = unserialize($house_config['admingroup']);
			$admin_member = fetch_all("common_member"," WHERE groupid IN (".dimplode($groupids).")","uid");
			foreach($admin_member as $am){
				$url = "house.php?mod=loupan&op=view&lid={$loupan_id}&ac=kanfang";
				notification_add($am['uid'],'system',"[{$house_config['name']}] {$house_lang['loupan_inc_php_2']} <a href=\"{$url}\">{$house_lang['loupan_inc_php_3']}</a> ");
			}
			
			showmessage("{$house_lang['loupan_inc_php_4']}!",$house_config['root']."?mod=loupan&op=view&lid={$loupan_id}");
		}
		$kan_array = fetch_all("house_loupan_kan"," WHERE loupan_id = '{$loupan_id}' ORDER BY kan_dateline DESC");
		
		$navtitle = $loupan['loupan_title'];
	}elseif($ac=='deleteimg'){
		$imgid = intval($_GET['img_id']);
		$img_url = DB::result_first("SELECT img_pic FROM ".DB::table("house_loupan_img")." WHERE img_id='{$imgid}'");
		@unlink($img_url);
		
		DB::delete("house_loupan_img"," img_id='{$imgid}'");
		showmessage("{$house_lang['loupan_inc_php_5']}!",$house_config['root']."?mod=loupan&op=view&lid={$loupan_id}");
		dexit();
	}else{
		$navtitle = $loupan['loupan_title']."_".$house_lang['loupan']."_".$pre_city['name'] .$house_config['name'];
	}
}

$loupan['loupan_map'] =  !empty($loupan['loupan_map']) ? $loupan['loupan_map'] : $house_config['google_map'];
if(defined('IN_MOBILE')){
	include template('house:'.$style.'/loupan');
}else{
	include template("diy:../../source/plugin/house/template/{$style}/loupan");
}
?>