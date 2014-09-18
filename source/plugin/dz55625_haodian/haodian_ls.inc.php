<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

loadcache('plugin');
$adminpagenum = 15;
@extract($_G['cache']['plugin']['dz55625_haodian']);
include_once 'language.'.currentlang().'.php';
$listclass = parconfig($listclass);
$p = addslashes($_GET['p']);
$p = $p?$p:'index';
$appurl=$_G['siteurl']."admin.php?action=plugins&operation=config&do=$_G[gp_do]&identifier=$_G[gp_identifier]&pmod=haodian_ls";
$plate = $_G['cache']['plugin']['dz55625_plate'];
$Platestart = $plate['Platestart'];
if($p=='index'){

	$where=$pageadd='';
	$cid = intval($_GET['c']);
	if($cid){
		$where="WHERE cid='$cid'";
		$pageadd="&c=$cid";
	}
	if($_GET['title']){
		$title=addslashes($_GET['title']);
		$where="WHERE title like '%$title%'";
		$titleenc=urlencode($title);
		$pageadd="&title=$titleenc";
	}
	//-----------------------------------------------------------------------
	$counts = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_ar')." $where");
	$pages = intval($_GET['page']);
	$pages = max($pages, 1);
	$starts = ($pages - 1) * 15;
	if($counts) {
		$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." $where ORDER BY xnum ASC,dateline DESC LIMIT $starts,15";
		$query = DB::query($sql);
		$mythread = $mythreads = array();
		while($mythread = DB::fetch($query)){
			$mythreads[] = $mythread;
		}
	}
	$multis = "<div class='pages cl'>".multi($counts, 15, $pages, $appurl."&p=$p".$pageadd)."</div>";
	//------------------------------------------------------------------------------
	if(submitcheck('applysubmitz')){	
		$id = intval($_GET['newid']);
		$active=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id ='{$id}'");
		if(is_array($_POST['title'])) {
			foreach($_POST['title'] as $id => $val) {
				DB::update('forum_alliance_ar', array('xnum' => intval($_POST['xnum'][$id]),'title' => addslashes($_POST['title'][$id])), "id='$id'");
			}
		}
		cpmsg($php_lang['admingsokok'],$appurl);	
	}
	//------------------------------------------------------------------------------
	if(submitcheck('applysubmvip')){	
		$pl_id = implode('|', $_GET['piliang']);
		$deid = explode('|', $pl_id);
		$nums = 0;
		foreach($deid as $aid) {
			DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET click='1' WHERE id='$aid' LIMIT 1");
			$nums++;
		}
		cpmsg($php_lang['admingsokok'],$appurl);	
		
	}elseif(submitcheck('applysubmzd')){
		$pl_id = implode('|', $_GET['piliang']);
		$deid = explode('|', $pl_id);
		$nums = 0;
		foreach($deid as $aid) {
			DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET topid='1' WHERE id='$aid' LIMIT 1");
			$nums++;
		}
		cpmsg($php_lang['admingsokok'],$appurl);	
		
	}elseif(submitcheck('applysubmtj')){
		$pl_id = implode('|', $_GET['piliang']);
		$deid = explode('|', $pl_id);
		$nums = 0;
		foreach($deid as $aid) {
			DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET top='1' WHERE id='$aid' LIMIT 1");
			$nums++;
		}
		cpmsg($php_lang['admingsokok'],$appurl);	
		
	}elseif(submitcheck('applysubmsh')){
		$pl_id = implode('|', $_GET['piliang']);
		$deid = explode('|', $pl_id);
		$nums = 0;
		foreach($deid as $aid) {
			DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET display='1' WHERE id='$aid' LIMIT 1");
			$nums++;
		}
		cpmsg($php_lang['admingsokok'],$appurl);	
	}elseif(submitcheck('applysubmdel')){
		$pl_id = implode('|', $_GET['piliang']);
		$deid = explode('|', $pl_id);
		$nums = 0;
		foreach($deid as $ssd) {
			$active=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id ='{$ssd}' LIMIT 0 , 1");
			$actives=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_img')." WHERE aid ='{$ssd}' LIMIT 0 , 1");
			DB::query("DELETE a,b,c,d,e FROM ".DB::table('forum_alliance_ar')." AS a LEFT JOIN ".DB::table('forum_alliance_pl')." AS b ON a.id = b.sid LEFT JOIN ".DB::table('forum_alliance_img')." AS c ON a.id = c.aid LEFT JOIN ".DB::table('forum_alliance_wp')." AS d ON a.id = d.sid LEFT JOIN ".DB::table('forum_alliance_yh')." AS e ON a.id = e.aid WHERE a.id = '$ssd' ");
			if ($active["pic"]!=false){
				unlink($active["pic"].$filetype);
			}
			if ($actives["img"]!=false){
				unlink($actives["img"].$filetype);
			}
			$nums++;
		}
		cpmsg($php_lang['admingsokok'],$appurl);	
		
	}
	
	$filename = 'source/plugin/dz55625_haodian/function/block_haodian.php';
	if (file_exists($filename)) {
		$kdiy=1;
	} else {
		$kdiy=0;
	}

include(template("dz55625_haodian:admin_i"));

}elseif ($p=='edit'){
	
	
	//----------------------------------------------------
	$id = intval($_GET['id']);
	$info = DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id='$id'");
	$info['lng']=$info['lng']?$info['lng']:$zuobiao;
	$aver = $info['total']/$info['voter'];
	$aver = round($aver,1)*10;
	
	$localupid = DB::result_first("SELECT upid FROM ".DB::table('forum_alliance_fl')." WHERE id='{$info['did']}' ORDER BY displayorder ASC");
	if($localupid) {
		$localshow = '<select name="local_2" >';
		$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE upid='$localupid' ORDER BY displayorder ASC");
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
	
	//图片信息查询
	//if($hus == $stu){
	$psql = "SELECT * FROM ".DB::table('forum_alliance_img_tmp')." WHERE aid='$id'";
	//}
	$query = DB::query($psql);
	$pser = $psers = array();
	while($pser = DB::fetch($query)){
		$psers[] = $pser;
	}
	
	//----------------------------------------------------	
		
	$id = intval($_GET['id']);
	$uid=$info['uid'];
	$active=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id ='{$id}' LIMIT 0 , 1");
	if(submitcheck('submit')){	
		$timestamp=$_G['timestamp'];
		$cid = intval($_GET['acid']);
		$did = intval($_GET['local_2']) ? intval($_GET['local_2']) : intval($_GET['local_1']);
		$xnum = intval($_GET['xnum']);
		$pic = addslashes($_GET['pic']);
		$title=addslashes($_GET['title']);
		$renling=intval($_GET['renling']);
		$sad=addslashes($_GET['sad']);
		$zkoubj=addslashes($_GET['zkoubj']);
		$address=addslashes($_GET['address']);
		$keywords = addslashes($_GET['keywords']);
		$description = addslashes($_GET['description']);
		$tel=addslashes($_GET['tel']);
		$tese = addslashes($_GET['tese']);
		$taobao = addslashes($_GET['taobao']);
		$tenqq = addslashes($_GET['tenqq']);
		$summary=addslashes($_GET['summary']);
		$ztime=addslashes($_GET['yy_ztime']);
		$wtime=addslashes($_GET['yy_wtime']);
		$bonus=intval($_GET['bonus']);
		$hitsa=intval($_GET['hitsa']);
		$jib=intval($_GET['jib']);
		$lng=addslashes($_GET['lng']);
		$lat = addslashes($_GET['lat']) == 1 ? 1 : 0; 
		
		if($_FILES['file']['error']==0){
			$rand=date("YmdHis").random(3, $numeric =1);
			$filesize = $_FILES['file']['size'] <= $picdx ;   // 封面图片大小
			$filetype = array("jpg","JPG", "jpeg","JPEG", "gif","GIF", "png", "PNG");
			$arr=explode(".", $_FILES["file"]["name"]);
			$hz=$arr[count($arr)-1];
			if(!in_array($hz, $filetype)){
				cpmsg($php_lang['zhiyunxu'],$appurl);		
			}
			$filepath = "source/plugin/dz55625_haodian/upimg/".date("Ymd")."/";
			$randname = date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".".$hz;
			if(!file_exists($filepath)){ mkdir($filepath); }
			if($filesize){ 
				if(@copy($_FILES['file']['tmp_name'], $filepath.$randname) || (function_exists('move_uploaded_file') && @move_uploaded_file($_FILES['file']['tmp_name'], $filepath.$randname))) {
					 @unlink($_FILES['file']['tmp_name']);
				}
			}else{
				cpmsg($php_lang['daxiaoxz'],$appurl);	
			}
			$pic = "source/plugin/dz55625_haodian/upimg/".date("Ymd")."/".$randname."";
		}
			
		DB::update('forum_alliance_ar', array('xnum' => $xnum, 'sad' => $sad,'cid' => $cid, 'did' => $did, 'zkoubj' => $zkoubj, 'pic' => $pic, 'yy_ztime' => $ztime,'yy_wtime' => $wtime, 'title' => $title, 'address' => $address, 'tel' => $tel, 'tese' => $tese, 'tenqq' => $tenqq, 'taobao' => $taobao, 'summary' => $summary,'bonus' => $bonus,'jib' => $jib, 'lng' => $lng, 'lat' => $lat, 'keywords' => $keywords, 'description' => $description, 'renling' => $renling,'hitsa' => $hitsa,'map_type' =>$mapStart), "id='$id'");
		
		DB::query("delete from ".DB::table('forum_alliance_img_tmp')." where aid='$id' and uid='$uid'");
			
		$countz = count($_POST['filelist']);
		for($i=0;$i<$countz;$i++){
			$img = addslashes($_POST['filelist'][$i]);
			DB::query("INSERT INTO ".DB::table('forum_alliance_img_tmp')." ( `id` , `aid`, `uid`, `img`,`dateline` ) VALUES (NULL , '$id', '$uid', '$img','$timestamp');");
		}  
		cpmsg($php_lang['lbianjiok'],$appurl);
	}

include(template("dz55625_haodian:admin_e"));


}elseif($p=='check'){
	
	if($_GET['operation'] == 'yes'){
		$id = intval($_GET['id']);
		DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET display='1' WHERE id='$id'");
		cpmsg($php_lang['lshengheok'],$appurl);
	}elseif($_GET['operation'] == 'no'){
		$id = intval($_GET['id']);
		DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET display='0' WHERE id='$id'");
		cpmsg($php_lang['lpingbiok'],$appurl);
	}
}elseif($p=='topid'){
	
	if($_GET['d'] == 'yes'){
		$id = intval($_GET['id']);
		DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET topid='1' WHERE id='$id'");
		cpmsg($php_lang['topding'],$appurl);
	}elseif($_GET['d'] == 'no'){
		$id = intval($_GET['id']);
		DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET topid='0' WHERE id='$id'");
		cpmsg($php_lang['topquxiao'],$appurl);
	}	
}elseif($p=='vip'){
	
	if($_GET['d'] == 'yes'){
		$id = intval($_GET['id']);
		DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET click='1' WHERE id='$id'");
		cpmsg($php_lang['vipshezhiok'],$appurl);
	}elseif($_GET['d'] == 'no'){
		$id = intval($_GET['id']);
		DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET click='0' WHERE id='$id'");
		cpmsg($php_lang['vipshezhino'],$appurl);
	}	
		
}elseif($p=='top'){
	
	if($_GET['tj'] == 'yes'){
		$id = intval($_GET['id']);
		DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET top='1' WHERE id='$id'");
		cpmsg($php_lang['ltuijianok'],$appurl);
	}elseif($_GET['tj'] == 'no'){
		$id = intval($_GET['id']);
		DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET top='0' WHERE id='$id'");
		cpmsg($php_lang['ltuijianno'],$appurl);
	}
}elseif($p=='tui'){
	
	$id = intval($_GET['id']);
	DB::query("UPDATE ".DB::table('forum_alliance_ar')." SET tuis='1' WHERE id='$id'");
	if($fidstart == 1){
		include_once 'source/plugin/dz55625_plate/plate_get.inc.php';
	}
	cpmsg($php_lang['tuisongok'],$appurl);
}elseif($p=='diy'){
	
	include_once 'source/plugin/dz55625_haodian/haodian_Size.class.php';
	if($_GET['d'] == 'yes'){
		FileUtil::moveDir('source/plugin/dz55625_haodian/function/','source/class/block/haodian'); 
		cpmsg($php_lang['diy_start'],$appurl);
	}
		
}elseif ($p=='del'){
	$id=intval($_GET['id']);
	$active=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id ='{$id}' LIMIT 0 , 1");
	$actives=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_img')." WHERE aid ='{$id}' LIMIT 0 , 1");
	DB::query("DELETE a,b,c,d,e FROM ".DB::table('forum_alliance_ar')." AS a LEFT JOIN ".DB::table('forum_alliance_pl')." AS b ON a.id = b.sid LEFT JOIN ".DB::table('forum_alliance_img')." AS c ON a.id = c.aid LEFT JOIN ".DB::table('forum_alliance_wp')." AS d ON a.id = d.sid LEFT JOIN ".DB::table('forum_alliance_yh')." AS e ON a.id = e.aid WHERE a.id = '$id' ");
	if ($active["pic"]!=false){
		unlink($active["pic"].$filetype);
	}
	if ($actives["img"]!=false){
		unlink($actives["img"].$filetype);
	}
	cpmsg($php_lang['lshanchuok'],$appurl);
}
else cpmsg($php_lang['lweidingyi']);


	
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
?>
