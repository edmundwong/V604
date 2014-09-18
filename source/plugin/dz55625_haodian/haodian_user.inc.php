<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
loadcache('plugin');
include_once 'language.'.currentlang().'.php';
include_once 'haodian_vik.inc.php';
@extract($_G['cache']['plugin']['dz55625_haodian']);
$listclass=parconfig($listclass);
$diquclass = parconfig($diquclass);
$his = $_G['siteurl'];
$p = $_GET['p'];
$p = $p?$p:'index';
$dhname = $ename;
$uid = intval($_G['uid']);
$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid='$uid' AND click='1'";
$query = DB::query($sql);
$uservip = mysql_num_rows($query); 
$his = parse_url($his);
$his = strtolower($his['host']) ;
$domain = array('com','cn','cc','org','net','me','co');
$stu = $his;
$dd = implode('|',$domain);
$stu = preg_replace('/(\.('.$dd.'))*\.('.$dd.')$/iU','',$stu);
$stu = explode('.',$stu);
$stu = array_pop($stu); 
$stu = substr($his,strrpos($his,$stu)); 
$appurls=$_G['siteurl']."plugin.php?id=dz55625_haodian:haodian_user";
$hurlz = md5(implode('', $haodiank));	
	
if($p=='index'){
	
	if($_G['groupid']==7){
		showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}
	
	$uid = intval($_G['uid']);
	if($hakign == $hurlz){
	$counts = DB::result_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid = '$uid' AND display!='0' ORDER BY id DESC");
	$countr = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_ar')." WHERE uid='$uid'");
	$pager = intval($_GET['page']);
	$pager = max($pager, 1);
	$starts = ($pager - 1) * 8;
	
	if($countr) {
		$rs=DB::query("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid='$uid' ORDER BY dateline DESC LIMIT $starts,8");
		while ($rw=DB::fetch($rs)){
			$manylist[]=$rw;
		}
	}
	
	$appurl=$_G['siteurl']."plugin.php?id=dz55625_haodian:haodian_user&p=index";
	$multir = "<div class='pages cl' style='margin-top:10px;'>".multi($countr, 8, $pager, $appurl.$pageadd)."</div>";
	}
	
}elseif($p=='edit'){
	
	if($_G['groupid']==7){
		showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}
	$uid = intval($_G['uid']);
	$id = intval($_GET['sid']);
	$info = DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid='$uid' AND id='$id'");
	$localupid = DB::result_first("SELECT upid FROM ".DB::table('forum_alliance_fl')." WHERE id='{$info['did']}'  ORDER BY displayorder ASC");
	if($localupid) {
		$localshow = '<select name="local_2" >';
		$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE upid='$localupid'  ORDER BY displayorder ASC");
		while($row = DB::fetch($query)) {
			if($row['id'] == $info['did']) {
				$localshow .= '<option value="'.$row['id'].'" selected >'.$row['subject'].'</option>';
			} else {
				$localshow .= '<option value="'.$row['id'].'">'.$row['subject'].'</option>';
			}
		}
		$localshow .= '</select>';
	} else {
		$localupid = $info['did'];
	}
		
	$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE upid='0' ORDER BY displayorder ASC");
	while($row = DB::fetch($query)) {
		$local[$row['id']] = $row;
	}
//----------------------------------------------------	
	$active = DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid='$uid' AND id ='{$id}' LIMIT 0 , 1");
	if($active['uid']!=$uid){
		showmessage($php_lang['lweidingyi'], '', array(), array('login' => true));	
	}
	
	//图片信息查询
	if($hus == $stu){
	$psql = "SELECT * FROM ".DB::table('forum_alliance_img_tmp')." WHERE aid='$id'";
	}
	$query = DB::query($psql);
	$pser = $psers = array();
	while($pser = DB::fetch($query)){
		$psers[] = $pser;
	}

	if(submitcheck('submit')){	
		if($hakign == $hurlz){
		$timestamp=$_G['timestamp'];
		$cid = intval($_GET['acid']);
		$did = intval($_GET['local_2']) ? intval($_GET['local_2']) : intval($_GET['local_1']);
		$title=addslashes($_GET['title']);
		$pic = addslashes($_GET['pic']);
		$address=addslashes($_GET['address']);
		$zkoubj=addslashes($_GET['zkoubj']);
		$sad=addslashes($_GET['sad']);
		$tel=addslashes($_GET['tel']);
		$tese = addslashes($_GET['tese']);
		$taobao = addslashes($_GET['taobao']);
		$tenqq = addslashes($_GET['tenqq']);
		$keywords = addslashes($_GET['keywords']);
		$description = addslashes($_GET['description']);
		$ztime=addslashes($_GET['yy_ztime']);
		$wtime=addslashes($_GET['yy_wtime']);
		$summary=addslashes($_GET['summary']);
		$jib=intval($_GET['jib']);
		$lng=addslashes($_GET['lng']);
		$lat = addslashes($_GET['lat']) == 1 ? 1 : 0; 
		}
		if($_FILES['file']['error']==0){
			$rand=date("YmdHis").random(3, $numeric =1);
			$filesize = $_FILES['file']['size'] <= $picdx ;   // 封面图片大小
			$filetype = array("jpg","JPG", "jpeg","JPEG", "gif","GIF", "png", "PNG");
			$arr=explode(".", $_FILES["file"]["name"]);
			$hz=$arr[count($arr)-1];
			if(!in_array($hz, $filetype)){
				showmessage($php_lang['zhiyunxu']);	
			}
			$filepath = "source/plugin/dz55625_haodian/upimg/";
			$randname = date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".".$hz;
		
			if($filesize){ 
				if(@copy($_FILES['file']['tmp_name'], $filepath.$randname) || (function_exists('move_uploaded_file') && @move_uploaded_file($_FILES['file']['tmp_name'], $filepath.$randname))) {
					 @unlink($_FILES['file']['tmp_name']);
				}
			}else{
				showmessage($php_lang['daxiaoxz']);	
			}
			$pic = "source/plugin/dz55625_haodian/upimg/".$randname."";
		}
						
		DB::update('forum_alliance_ar', array('cid' => $cid, 'sad' => $sad ,'did' => $did, 'zkoubj' => $zkoubj, 'pic' => $pic, 'yy_ztime' => $ztime,'yy_wtime' => $wtime,'title' => $title, 'address' => $address, 'tel' => $tel, 'tese' => $tese, 'tenqq' => $tenqq, 'taobao' => $taobao, 'summary' => $summary, 'jib' => $jib, 'lng' => $lng, 'lat' => $lat, 'keywords' => $keywords, 'description' => $description,'map_type' =>$mapStart), "id='$id'");
		
		DB::query("delete from ".DB::table('forum_alliance_img_tmp')." where aid='$id' and uid='$uid'");
			
		$countz = count($_POST['filelist']);
		for($i=0;$i<$countz;$i++){
			$img = addslashes($_POST['filelist'][$i]);
			DB::query("INSERT INTO ".DB::table('forum_alliance_img_tmp')." ( `id` , `aid`, `uid`, `img`,`dateline` ) VALUES (NULL , '$id', '$uid', '$img','$timestamp');");
		}  
		showmessage($php_lang['lbianjiok'], $appurls, array(), array('alert' => right));
	}
		
}elseif ($p=='del'){
	
	if($_G['groupid']==7){
		showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}
	$uid = intval($_G['uid']);
	$id=intval($_GET['sid']);
	$active=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id ='{$id}' AND uid='$uid' LIMIT 0 , 1");
	if($active['uid']!=$uid){
		showmessage($php_lang['lweidingyi'], '', array(), array('login' => true));	
	}
	$actives=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_img')." WHERE aid ='{$id}' LIMIT 0 , 1");
	DB::query("DELETE a,b,c,d,e FROM ".DB::table('forum_alliance_ar')." AS a LEFT JOIN ".DB::table('forum_alliance_pl')." AS b ON a.id = b.sid LEFT JOIN ".DB::table('forum_alliance_img')." AS c ON a.id = c.aid LEFT JOIN ".DB::table('forum_alliance_wp')." AS d ON a.id = d.sid LEFT JOIN ".DB::table('forum_alliance_yh')." AS e ON a.id = e.aid WHERE a.id = '$id' AND a.uid = '$uid' ");
	
	$sql = "SELECT * FROM ".DB::table('forum_alliance_img_tmp')." WHERE aid = '$id'";
	$query = DB::query($sql);
	$delz = $delzs = array();
	while($delz = DB::fetch($query)){
		if ($delz["img"]!=false){
			unlink($delz["img"].$filetype);
		}
		$delzs[] = $delz;
	}
	
	DB::query("delete from ".DB::table('forum_alliance_img_tmp')." where aid='$id' and uid='$uid'");
	if ($active["pic"]!=false){
		unlink($active["pic"].$filetype);
	}
	if ($actives["img"]!=false){
		unlink($actives["img"].$filetype);
	}
	showmessage($php_lang['lshanchuok'], $appurls, array(), array('alert' => right));
	
}elseif($p=='listpic'){
	//include_once("haodian_albums_manager.inc.php");
	
	include_once 'haodian_albums_manager.inc.php';
	
}elseif($p=='youhui'){
	if($_G['groupid']==7){
		showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}
	$appurlx=$_G['siteurl']."plugin.php?id=dz55625_haodian:haodian_user&p=youhui";

	
	//-------------------------------------------------------
	$rs=DB::query("SELECT * FROM ".DB::table('forum_alliance_yh')." WHERE uid='$uid' ORDER BY dateline DESC "); 
	while ($rw=DB::fetch($rs)){
		$manyhs[]=$rw;
	}

}elseif($p=='adone'){
	if($_G['groupid']==7){
		showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}
	if($Lstart==1){
		include_once 'source/plugin/dz55625_hadone/hadfun_uid.inc.php';
	}
		
}elseif($p=='shops'){
	if($_G['groupid']==7){
		showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}	
	if($StHop==1){
		include_once 'source/plugin/dz55625_hshop/shopfun_uid.inc.php';
	}
}elseif($p=='yyue'){
	if($_G['groupid']==7){
		showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}	
	if($Ystart==1){
		include_once 'source/plugin/dz55625_yuyue/yyue_uid.inc.php';
	}	
}elseif($p=='domain'){
	if($_G['groupid']==7){
		showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}
	if($isdomain==1){
		include_once 'source/plugin/dz55625_haodian_domain/domain_setting.inc.php';
	}else{
		@extract($_G['cache']['plugin']['dz55625_haodian_domain']);
	}
}elseif($p=="coupon"){
	if($_G['groupid']==7){
		showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}
	if($iscoupon==1){
		include_once 'source/plugin/dz55625_haodian_coupon/coupon_setting.inc.php';
	}else{
		@extract($_G['cache']['plugin']['dz55625_haodian_coupon']);
	}
	
}elseif($p=="zizhu"){	
	if($_G['groupid']==7){
		showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}			
	if($zhu_Start==1){
		include_once 'source/plugin/dz55625_haodian_buffet/buffet_user.inc.php';
	}
		
}elseif($p=='delete'){
	
	if($_G['groupid']==7){
		showmessage($php_lang['yyoukewuq'], '', array(), array('login' => true));	
	}
	
	$id=intval($_GET['pid']);
	$appurlv=$_G['siteurl']."plugin.php?id=dz55625_haodian:haodian_user&p=listpic";
	$actives=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_img')." WHERE id ='{$id}' LIMIT 0 , 1");
	DB::query("DELETE FROM ".DB::table('forum_alliance_img')." WHERE id ='$id' LIMIT 1 ;");
	if ($actives["img"]!=false){
		unlink($actives["img"].$filetype);
	}
	showmessage($php_lang['lshanchuok'], $appurlv, array(), array('alert' => right));
}



function parconfig($str){
	$return = array();
	$array = explode("\n",str_replace("\r","",$str));
	foreach ($array as $v){
	   $t = explode("=",$v);
	   $t[0] = trim($t[0]);
	   $return[$t[0]] = $t[1];
	}
	return $return;
} 

include(template("dz55625_haodian:user_index"));

?>