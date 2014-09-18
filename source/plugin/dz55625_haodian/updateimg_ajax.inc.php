<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	loadcache('plugin');
	include_once 'language.'.currentlang().'.php';
	@extract($_G['cache']['plugin']['dz55625_haodian']);
	$uid=intval($_G["uid"]);
	$action=addslashes($_GET['actions']);
	$imgid=intval($_GET['imgid']);
	if($uid){
		if($imgid){
			if($action=="updateimg"){			
				$title=addslashes($_GET['title']);
				$title=iconv('utf-8',$_G['charset'],$title);
				DB::query("update ".DB::table("forum_alliance_albums_img")." set title='$title' where id=$imgid");
				$returns['text']=$php_lang['up_updateok'];
				$returns['status']=1;
				
			}elseif($action=="szfm"){
				$sql="select * from ".DB::table("forum_alliance_albums_img")." where id=$imgid";
				$img = DB::fetch_first($sql);
				if($img){
					DB::query("update ".DB::table("forum_alliance_albums")." set img_url='$img[shrink_url]' where id=$img[albums_id]");
					DB::query("update ".DB::table("forum_alliance_albums_img")." set status=0 ");
					DB::query("update ".DB::table("forum_alliance_albums_img")." set status=1 where id=$img[id]");
					$returns['text']=$php_lang['up_settingok'];
					$returns['status']=1;
				}else{
					$returns['text']=$php_lang['updateiderror'];
					$returns['status']=0;
				}
			}elseif($action=="showar"){
				DB::query("update ".DB::table("forum_alliance_albums_img")." set issz=1,sztime=".time()." where id=$imgid");
				$returns['text']=$php_lang['up_settingok'];
				$returns['status']=1;
			}elseif($action=="hidear"){
				DB::query("update ".DB::table("forum_alliance_albums_img")." set issz=0,sztime=1 where id=$imgid");
				$returns['text']=$php_lang['up_settingok'];
				$returns['status']=1;
			}else{
				$returns['text']="error";
				$returns['status']=0;
			}
		}else{
				$returns['text']=$php_lang['updateiderror'];
				$returns['status']=0;
			}
	}else{
		$returns['text']=$php_lang['wuquanczs'];
		$returns['status']=0;
	}
	$returns['text']=iconv($_G['charset'],'utf-8',$returns['text']);
	echo json_encode($returns);
	
	
?>