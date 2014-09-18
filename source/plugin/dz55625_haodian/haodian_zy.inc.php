<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
include_once 'language.'.currentlang().'.php';
$set = $_G['cache']['plugin']['dz55625_haodian'];
$tadayzj = $set['zujin'];
$extcredit =$set['extcredit'];
$appurls=$_G['siteurl']."plugin.php?id=dz55625_haodian:haodian";
$uid=intval($_G['uid']);
if($_GET['mod']=='wp'){
	$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid = '$uid' AND display!='0' ORDER BY id DESC LIMIT 10";
			$query = DB::query($sql);
			$zuyong = $zuyongs = array();
			while($zuyong = DB::fetch($query)){
				$zuyong['dateline'] = gmdate('Y-m-d', $zuyong['dateline'] + $_G['setting']['timeoffset'] * 3600);
				$zuyongs[] = $zuyong;
			}
			
	foreach($_G['setting']['extcredits'] as $key => $value){
		$ext = 'extcredits'.$key;
		getuserprofile($ext);
		$haodian['extcredits'][$key]['title'] = $value['title'];
		$haodian['extcredits'][$key]['value'] = $_G['member'][$ext];
	}

	if(!submitcheck('applysubmit')){
		if($_G['groupid']==7){
			showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));
		}
	}else{
		$uid = intval($_G['uid']);
		$title = addslashes($_GET['title']);
		$author = addslashes($_G['username']);
		$createtime = strtotime('+31 day');
		//--------------------------------------
		$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE title = '$title' AND display!='0' ORDER BY id DESC LIMIT 10";
		$ps = DB::fetch(DB::query($sql));
		$sid = intval($ps['id']);
		$pic = addslashes($ps['pic']);
		//--------------------------------------
		$rows = DB::fetch(DB::query( "SELECT * FROM ".DB::table('forum_alliance_wp')." WHERE title = '$title'"));
		//--------------------------------------
		if($rows){
			showmessage($php_lang['dianpuxz']);
		}else{
			
			if(empty($_GET['title'])){
				showmessage($php_lang['dianpumc'], dreferer());
			}else{
				//--------------------------------------				
				if($haodian['extcredits'][$extcredit]['value']<$tadayzj){
					$tixing= $haodian['extcredits'][$extcredit]['title'].$php_lang['jinbibz'].$tadayzj."";
					showmessage(lang('plugin/dz55625_haodian', $tixing));
				}else{
					updatemembercount($_G['uid'], array($extcredit => -$tadayzj));
				}
				//--------------------------------------
				DB::insert('forum_alliance_wp',array('id' => '','sid' => $sid, 'pic' => $pic, 'uid' => $uid, 'author' => $author, 'title' => $title, 'dateline' => time(), 'createtime' => $createtime));
			}
			showmessage($php_lang['tianjiaok'], $appurls, array(), array('alert' => right));
		}
	}	
	include template('dz55625_haodian:haozy');
}




?>