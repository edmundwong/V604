<?php
/*
	(C)2011 - 2013 55625.COM Inc.
	Make BY Lovenr   QQ:114512039  
*/
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	include_once 'language.'.currentlang().'.php';
	$pp=addslashes($_G["gp_pp"]);
	$pp=$pp?$pp:"list";
	if($_G['groupid']==7){
		showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}
	
	$uid = intval($_G['uid']);
	if($uid){
		if($pp=="list"){			
					$sql="select albums.*,ar.title as ar_title from ".DB::table("forum_alliance_albums")." albums inner join ".DB::table("forum_alliance_ar")." ar on(albums.arid=ar.id) where ar.uid=$uid";
					$albumslist=$albums=array();
					$querys = DB::query($sql);
					while ($albums=DB::fetch($querys)){
						if(!$albums['img_url'] || !file_exists($albums['img_url'])){
							$albums['img_url']="source/plugin/dz55625_haodian/images/zwzp.gif";
						}
						$albumslist[]=$albums;
					}
					$albums_counts=count($albumslist);
					$ar_counts=DB::result_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid = '$uid' AND display!='0' ");
					$a_counts = DB::result_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid = '$uid' AND display!='0' ");
						$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid = '$uid' AND display!='0' ";
						$query = DB::query($sql);
					$zuyong = $zuyongs = array();
					while($zuyong = DB::fetch($query)){
						$zuyongs[] = $zuyong;
					}
		}elseif($pp=="imglist"){
			$ablumsid=intval($_G["gp_ablumsid"]);
			
			$imgpagenum=12;
			if($ablumsid){
				$ablums = DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_albums')." where id=$ablumsid and uid=$uid");
				if($ablums){
					$counts = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_albums_img')." where albums_id=$ablumsid");
					$pages = intval($_GET['page']);
					$pages = max($pages, 1);
					$starts = ($pages - 1) * $imgpagenum;
					$sql="select * from ".DB::table("forum_alliance_albums_img")." where albums_id=$ablumsid limit $starts,$imgpagenum";
					$imgs=$img=array();
					$querys = DB::query($sql);
					while ($img=DB::fetch($querys)){
						$imgs[]=$img;
					}
					$multis = "<div class='pages cl'>".multi($counts, $imgpagenum, $pages, $appurls."&p=listpic&pp=imglist&ablumsid=".$ablumsid)."</div>";
					$ar_counts=DB::result_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid = '$uid' AND display!='0' ");
					$a_counts = DB::result_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid = '$uid' AND display!='0' ");
					$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid = '$uid' AND display!='0' and id=$ablums[arid]";
					$ar_sj = DB::fetch_first($sql);
				}else{
					showmessage($php_lang['updateiderror'],$appurls."&p=listpic");
				}
			}else{
				showmessage($php_lang['updateiderror'],$appurls."&p=listpic");
			}
		}elseif($pp=="del_ablums"){
			$aid=intval($_G["gp_ablumsid"]);
			if($aid){
				$sql="select * from ".DB::table("forum_alliance_albums_img")." where albums_id=$aid";
				$querys = DB::query($sql);
				while ($img=DB::fetch($querys)){
					@unlink($img[shrink_url]);
					@unlink($img[original_url]);
				}
				DB::query("delete from ".DB::table("forum_alliance_albums_img")." where albums_id=$aid");
				DB::query("delete from ".DB::table("forum_alliance_albums")." where id=$aid");
				showmessage($php_lang['up_delok'],$appurls."&p=listpic");
			}else{
				showmessage($php_lang['updateiderror'],$appurls."&p=listpic");
			}
		}elseif($pp=="del_img"){
			$imgid=intval($_G["gp_imgid"]);
			if($imgid){
				$sql="select * from ".DB::table("forum_alliance_albums_img")." where id=$imgid";
				$img = DB::fetch_first($sql);
				$albums_id=$img[albums_id];
				if($img){
					$sql1="select * from ".DB::table("forum_alliance_albums")." where id=$img[albums_id]";
					$albums = DB::fetch_first($sql1);
					if($albums[img_url]==$img[shrink_url]){
						$img1 = DB::fetch_first("select * from ".DB::table("forum_alliance_albums_img")." where albums_id=$albums[id]");
						if($img1){
							DB::query("update ".DB::table("forum_alliance_albums")." set img_url='$img1[shrink_url]' where id=$albums[id]");
							DB::query("update ".DB::table("forum_alliance_albums_img")." set status=1 where id=$img1[id]");
						}
					}
					@unlink($img[shrink_url]);
					@unlink($img[original_url]);				
					DB::query("delete from ".DB::table("forum_alliance_albums_img")." where id=$imgid");
					DB::query("update ".DB::table("forum_alliance_albums")." set imgnum=imgnum-1 where id=$albums[id]");
				}
				showmessage($php_lang['up_delok'],$appurls."&p=listpic&pp=imglist&ablumsid=".$albums_id);
			}else{
				showmessage($php_lang['updateiderror'],$appurls."&p=listpic&pp=imglist");
			}
		}elseif($pp=="updateimg"){
			
			
		}
	}else{
			showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}
?>