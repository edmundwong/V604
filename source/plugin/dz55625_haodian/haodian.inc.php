<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr  WWW.55625.COM
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}



global $_G;
require_once libfile('function/discuzcode');
include_once 'language.'.currentlang().'.php';
include_once 'haodian_vik.inc.php';
if(!isset($_G['cache']['plugin'])){ loadcache('plugin'); }
@extract($_G['cache']['plugin']['dz55625_haodian']);
$Clickwindow = $Clickwindow == 1 ? ' target="_blank"' : ''; 
$picdz = str_replace(array("\r\n", "\n"), '|', $pic_dizhi);
$piclj = str_replace('&', '%26',str_replace(array("\r\n", "\n"), '|', $pic_links));
$his = $_G['siteurl'];
$ypic = $ypic_dizhi;
$ylianjie = $ypic_lianjie;
$listclass = parconfig($listclass);
$tadayzj = $zujin;
$extcredit =$extcredit;
$his = parse_url($his);
$haodian_host=$his['host'];
$his = strtolower($his['host']) ;
$domain = array('com','cn','cc','org','net','me','co','tv','la');
$stu = $his;
$dd = implode('|',$domain);
$stu = preg_replace('/(\.('.$dd.'))*\.('.$dd.')$/iU','',$stu);
$stu = explode('.',$stu);
$stu = array_pop($stu); 
$stu = substr($his,strrpos($his,$stu));  
$uc = $_G['setting']['ucenterurl'];
$hurlz = md5(implode('', $haodiank));
$dhname = $ename;
if($RewriteStart == 1){ $curl = 'haodian';}else{
	$curls = 'plugin.php?id=dz55625_haodian:haodian&mod=view&sid=';
}
include("./source/plugin/dz55625_haodian_buffet/buffet_vliad.inc.php");

if(!$_GET['mod']){
	@extract($_G['cache']['plugin']['dz55625_haodian_domain']);
	$where=$pageadd='';
	$cid = $tmpsea_c ? $tmpsea_c : intval($_GET['c']);
	if($cid){
		$wa="a.cid='$cid' AND";
		$pageadd="&c=$cid";
		$av_ds[$cid] = ' class="haodians_hover"'; 
	}else{
		$av_ds[0] = ' class="haodians_hover"';
	}

	$did = $tmpsea_d ? $tmpsea_d : intval($_GET['d']);
	if($did){ 
		$subids = DB::result_first("SELECT subid FROM ".DB::table('forum_alliance_fl')." WHERE id='{$did}' ORDER BY displayorder ASC");
		if($subids){
			$wb="a.did IN ($subids) AND"; 
		}else{
			$wb="a.did=$did AND"; 
		}
		$pageadds="&d=$did";
		$av_d[$did] = ' class="haodian_hover"'; 
	}else{
		$av_d[0] = ' class="haodian_hover"';
	}
	
	$epes = $tmpsea_e ? $tmpsea_e : intval($_GET['e']);
	
	$sd = $tmpsea_sd ? $tmpsea_sd : intval($_GET['sd']);
	if($sd){ 
		$wc="a.did='$sd' AND"; 
		$pageaddx="&sd=$sd";
		$av_d[$sd] = ' class="haodian_hover"'; 
	}else{
		$av_d[0] = ' class="haodian_hover"';
	}
	if($_GET['title']){
		$title=addslashes($_GET['title']);
		if($_POST['type']==0){ 
			$where="a.title like '%$title%' AND";
		}else{
			$where="a.address like '%$title%' AND";
		}
		$titlenc=urlencode($title);
		$pageadd="&title=$titlenc";
	}
	$px='DESC';
	if($_GET['px']){ $px="ASC"; $pageadd="&px=d"; $a_hover[d] = ' class="a_hover"';  }
	if($_GET['ps']){ $ps="(total/voter) DESC,"; $pageadd="&ps=f"; $a_hover[f] = ' class="a_hover"';  }

	$types = trim($_GET['types']);	
	if ($types){
		if ($types==1){
			$sa[] = "a.click = '1'";
			$pageadd="&types=1";
			$a_hover[1] = ' class="a_hover"'; 
		}elseif($types==2){
			$sa[] = "a.topid = '1'";
			$a_hover[2] = ' class="a_hover"'; 
		}elseif($types==3) {
			$sa[] = "a.sad > 0";
			$a_hover[3] = ' class="a_hover"'; 
		}
	}
	if ($sa){ $wheres = "" . implode(" AND ", $sa) . " AND"; }
	
	$condition=$where." ".$wheres." ".$wa." ".$wb." ".$wc;
	$orderby=$ps." a.topid DESC,a.xnum ASC,a.dateline ".$px;
	
	$condition=@str_replace("=","[exp]",$condition);
	$condition=@str_replace(" ","[empty]",$condition);
	$condition=@str_replace("'","[yh]",$condition);

	$counts = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_ar')." a WHERE $where $wheres $wa $wb $wc display!='0'");
	$pages = intval($_GET['page']);
	$pages = max($pages, 1);
	$starts = ($pages - 1) * $eacha;
	
	if($counts) {
		if($hus == $stu){
		if(!empty($fdymsz) && !empty($hd_domain) && !empty($isdomain)){	
		$sql = "SELECT a.*,d.domain FROM ".DB::table('forum_alliance_ar')." a left join ".DB::table('forum_alliance_domain')." d on(a.id=d.aid) WHERE $where $wheres $wa $wb $wc a.display!='0' ORDER BY  $ps a.topid DESC,a.xnum ASC,a.dateline $px LIMIT $starts,$eacha";
		}else{
			$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." a  WHERE $where $wheres $wa $wb $wc a.display!='0' ORDER BY  $ps a.topid DESC,a.xnum ASC,a.dateline $px LIMIT $starts,$eacha";
			}
			}
		$query = DB::query($sql);
		$mythread = $mythreads = array(); 
		while($mythread = DB::fetch($query)){ 
			if($hakign == $hurlz){
				$mythread['dateline'] = gmdate('m-d', $mythread['dateline'] + $_G['setting']['timeoffset'] * 3600);
				$mythread['title'] = cutstr($mythread['title'], 60, '...');
				if(!empty($mythread['domain'])){
					if(empty($domainfw)){
						if(!empty($mythread['click'])){
							$mythread['domain']=str_replace($haodian_host,$mythread['domain'].".".$hd_domain,$_G['siteurl']);
						}else
							$mythread['domain']="";
					}else
						$mythread['domain']=str_replace($haodian_host,$mythread['domain'].".".$hd_domain,$_G['siteurl']);
				}
				if(round($mythread[total]/$mythread[voter],1) != 0){
					$mythread[tvs]="<span>".round($mythread[total]/$mythread[voter]+$mythread[bonus],1)."</span> ".$php_lang['homefen'];
				}else{
					$mythread[tvs]=$php_lang['zanwupfen'];
				}
				$mythreads[] = $mythread; 
			}
		}
	}

	$appurl=$_G['siteurl']."plugin.php?id=dz55625_haodian:haodian";
	$multis = "<div class='pages cl'>".multi($counts, $eacha, $pages, $appurl.$pageadd.$pageadds.$pageaddx)."</div>";
	
	
	$countpl = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_pl')." WHERE display='1'");
	if($countpl) {
		if(!empty($fdymsz) && !empty($hd_domain) && !empty($isdomain)){	
		$sql = "SELECT a.*,d.domain FROM ".DB::table('forum_alliance_pl')."  a left join ".DB::table('forum_alliance_domain')." d on(a.sid=d.aid) WHERE a.display!='0' ORDER BY a.id DESC LIMIT 16";
		}else{
			$sql = "SELECT a.* FROM ".DB::table('forum_alliance_pl')."  a  WHERE a.display!='0' ORDER BY a.id DESC LIMIT 16";
		}
		$query = DB::query($sql);
		$mypl = $mypls = array();
		while($mypl = DB::fetch($query)){
			$mypl['message'] = discuzcode($mypl['message']);
			if(!empty($mypl['domain'])){
					if(empty($domainfw)){
						if(!empty($mypl['click'])){
							$mypl['domain']=str_replace($haodian_host,$mypl['domain'].".".$hd_domain,$_G['siteurl']);
						}else
							$mypl['domain']="";
					}else
						$mypl['domain']=str_replace($haodian_host,$mypl['domain'].".".$hd_domain,$_G['siteurl']);
				}
			$mypls[] = $mypl;
		}
	}
	
if(!empty($fdymsz) && !empty($hd_domain) && !empty($isdomain)){	
	$query = DB::query("SELECT a.*,d.domain FROM ".DB::table('forum_alliance_ar')." a left join ".DB::table('forum_alliance_domain')." d on(a.id=d.aid) WHERE a.top='1' AND a.display!='0' ORDER BY a.id DESC LIMIT 4");
	}else{
		$query = DB::query("SELECT a.* FROM ".DB::table('forum_alliance_ar')." a  WHERE a.top='1' AND a.display!='0' ORDER BY a.id DESC LIMIT 4");
	}
	$tuijian = $tuijians = array();
	while($tuijian = DB::fetch($query)){
		if(!empty($tuijian['domain'])){
			if(empty($domainfw)){
				if(!empty($tuijian['click'])){
					$tuijian['domain']=str_replace($haodian_host,$tuijian['domain'].".".$hd_domain,$_G['siteurl']);
				}else
					$tuijian['domain']="";
			}else
				$tuijian['domain']=str_replace($haodian_host,$tuijian['domain'].".".$hd_domain,$_G['siteurl']);
		}
		$tuijians[] = $tuijian;
	}
	
	
	if($hus == $stu){
	//旺铺
	$wpcount = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_wp')."");
	if(!empty($fdymsz) && !empty($hd_domain) && !empty($isdomain)){	
	$query = DB::query( "SELECT a.*,d.domain FROM ".DB::table('forum_alliance_wp')."  a left join ".DB::table('forum_alliance_domain')." d on(a.sid=d.aid) LIMIT 5");
	}else{
		$query = DB::query( "SELECT * FROM ".DB::table('forum_alliance_wp')."  a  LIMIT 5");
	}
	$wangpu = $wangpus = array();
	while($wangpu = DB::fetch($query)){
		$wangpu['dateline'] = gmdate('Y-m-d', $wangpu['dateline'] + $_G['setting']['timeoffset'] * 3600);
		$wangpu['createtime'] = gmdate('Y-m-d', $wangpu['createtime'] + $_G['setting']['timeoffset'] * 3600);
		if(!empty($wangpu['domain'])){
					if(empty($domainfw)){
						if(!empty($wangpu['click'])){
							$wangpu['domain']=str_replace($haodian_host,$wangpu['domain'].".".$hd_domain,$_G['siteurl']);
						}else
							$wangpu['domain']="";
					}else
						$wangpu['domain']=str_replace($haodian_host,$wangpu['domain'].".".$hd_domain,$_G['siteurl']);
		}
		$wangpus[] = $wangpu;
	}
	
	$shjengyuwp = intval(5- $wpcount);
	
	foreach($_G['setting']['extcredits'] as $key => $value){
		$ext = 'extcredits'.$key;
		getuserprofile($ext);
		$haodian['extcredits'][$key]['title'] = $value['title'];
		$haodian['extcredits'][$key]['value'] = $_G['member'][$ext];
	}
	
	//--------------------
	$xianzai = gmdate(get_time($times) + $_G['setting']['timeoffset'] * 3600); 
	DB::query("DELETE FROM ".DB::table('forum_alliance_wp')." WHERE  createtime <= $xianzai");

	//店面展示
	$sql = "SELECT * FROM ".DB::table('forum_alliance_img')."";
	$query = DB::query($sql);
	$shopim = $shopimg = array();
	while($shopimg = DB::fetch($query)){
		$shopimg[] = $shopim;
	}
	//-----------------------------
	if(!empty($fdymsz) && !empty($hd_domain) && !empty($isdomain)){	
	$ka = DB::query("SELECT a.*,d.domain FROM ".DB::table('forum_alliance_ar')."   a left join ".DB::table('forum_alliance_domain')." d on(a.id=d.aid) WHERE a.lat='1' AND a.display!='0' ORDER BY a.id DESC LIMIT 8");
	}else{
		$ka = DB::query("SELECT a.* FROM ".DB::table('forum_alliance_ar')."   a  WHERE a.lat='1' AND a.display!='0' ORDER BY a.id DESC LIMIT 8");
	}
	$yika = $yikas = array();
	while($yika = DB::fetch($ka)){
		$yika['title'] = cutstr($yika['title'], 35, '');
		if(!empty($yika['domain'])){
			if(empty($domainfw)){
				if(!empty($yika['click'])){
					$yika['domain']=str_replace($haodian_host,$yika['domain'].".".$hd_domain,$_G['siteurl']);
				}else
					$yika['domain']="";
			}else
				$yika['domain']=str_replace($haodian_host,$yika['domain'].".".$hd_domain,$_G['siteurl']);
		}
		$yikas[] = $yika;
	}
	//-----------------------------
	$d = intval($_GET['d']);
	$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE upid='0' ORDER BY displayorder ASC");
	while($row = DB::fetch($query)) {
		$local[$row['id']] = $row;
	}
	
	$subid = DB::result_first("SELECT subid FROM ".DB::table('forum_alliance_fl')." WHERE id='{$d}' ORDER BY displayorder ASC");
	if($subid) {
		$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE id IN ({$subid}) ORDER BY displayorder ASC");
		while($ros = DB::fetch($query)) {
			$locals[$ros['id']] = $ros;
		}
	}
	}
	
	
	
	//手机部份
	$file=DISCUZ_ROOT."./source/plugin/dz55625_haodian/config.php";
	$mobile_conf = @include $file;
	$mobile_conf || $mobile_conf = array();
	if(!$mobile_conf['magic_lantern']){
		$mobile_conf['ishuandeng']=0;
	}
	$pagenum=$mobile_conf['moble_pagenum']?$mobile_conf['moble_pagenum']:5;
	$infos=array();
	$infos=$mythreads;
	$pager=$pages;
	$prepage="";
	$nextpage="";
	if($pager>1){
		$prepage=$pager-1;
	}
	if($pager*$pagenum<$counts){
		$nextpage=$pager+1;
	}
	$mobile_action="mobile_list";
	$appl=$_G['siteurl']."plugin.php?id=dz55625_haodian:mobile_haodian".($_G['mobile']?"&mobile=2":"");
}elseif($_GET['mod']=='view'){
	@extract($_G['cache']['plugin']['dz55625_haodian_domain']);
	@extract($_G['cache']['plugin']['dz55625_haodian_coupon']);
	$p = $_GET['p'];
	$uid = intval($_G['uid']);
	$sid = intval($_GET['sid']);
	$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id='$sid'";
	$query = DB::query($sql);
	$mythread = $mythreads = array();
	while($mythread = DB::fetch($query)){
		if($hus == $stu){ $mythread['dateline'] = gmdate('m-d', $mythread['dateline'] + $_G['setting']['timeoffset'] * 3600);
		$mythread['summary'] = discuzcode($mythread['summary'], 1, 0, 0, 0, 1, 1, 0, 0, 1);//discuzcode($mythread['summary']);
		$mythread['fl']=$listclass[$mythread['cid']];
			
		if($mythread['did']){
			$region_sql_3 = "SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE id = '$mythread[did]'";
			$dfl = DB::fetch_first($region_sql_3);
			if($dfl['upid']){
				$mythread['region']=DB::result_first("SELECT subject FROM ".DB::table('forum_alliance_fl')." WHERE id = '$dfl[upid]'")."-".$dfl['subject'];
			}else{
				$mythread['region']=$dfl['subject'];
			}
		}
		$mythreads[] = $mythread;
		$navtitle = $mythread['title']; }
		if($puseo==1){
				$metakeywords = $mythread['keywords'];
				$metadescription = $mythread['description'];
		}elseif($mythread['click']==1){
				$metakeywords = $mythread['keywords'];
				$metadescription = $mythread['description'];
		}
		if(!empty($hd_domain)){
				$haodiaon_view_back=str_replace($haodian_host,$hd_domain,$_G['siteurl']);
		}
		if(round($mythread[total]/$mythread[voter],1) != 0){
			$mythread[tvs]="<em>".round($mythread[total]/$mythread[voter]+$mythread[bonus],1)."</em> ".$php_lang['homefen'];
		}else{
			$mythread[tvs]=$php_lang['zanwupfen'];
		}
		$info=$mythread;
	}
	$active = DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id ='{$sid}' LIMIT 0 , 1");
	$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE id='$sid' ORDER BY dateline DESC LIMIT 1");
	$query= DB::fetch($query);
	$aver = $query['total']/$query['voter']+$query['bonus'];
	$aver = round($aver,1)*10;
	
	$count = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_pl')." WHERE sid='$sid' AND display!='0'");
	$page = intval($_GET['page']);
	$page = max($page, 1);
	$start = ($page - 1) * $each;
	
	if($count) {
		$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_pl')." WHERE sid='$sid' AND display!='0' ORDER BY dateline DESC LIMIT $start,$each");
		$pl = $pls = array();
		while($pl = DB::fetch($query)) {
			$pl['dateline'] = gmdate('m-d H:i', $pl['dateline'] + $_G['setting']['timeoffset'] * 3600);
			$pls[] = $pl;
		}
	}
	
	$multi = "<div class='pages cl'>".multi($count, $each, $page,'plugin.php?id=dz55625_haodian:haodian&mod=view&sid='.$sid.'')."</div>";
	
	//店面展示
		$sql_ablums="select * from ".DB::table('forum_alliance_albums')." where arid='$sid'";
		$ablums=DB::fetch_first($sql_ablums);
		if($ablums){
			$piccount = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_albums_img')." WHERE albums_id='$ablums[id]'");
			$picage = intval($_GET['page']);
			$picage = max($picage, 1);
			$start = ($picage - 1) * $photos;
			if($piccount) {
				$sql = "SELECT * FROM ".DB::table('forum_alliance_albums_img')." WHERE albums_id='$ablums[id]' ORDER BY issz desc,sztime desc,createdate DESC LIMIT $start,$photos";
				$query = DB::query($sql);
				$shopimg = $shopimgs = array();
				while($shopimg = DB::fetch($query)){
					$shopimg[uid]=$mythread[uid];
					$shopimgs[] = $shopimg;
				}
			}	
			$pmulti = multi($piccount, $photos, $picage,'plugin.php?id=dz55625_haodian:haodian&mod=view&p=listpic&sid='.$sid.'');
		}else{
			$piccount=0;
		}

	//优惠信息
		if(!$_GET['nw']){
			$yhcount = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_yh')." WHERE aid='$sid'");
			$yhage = intval($_GET['page']);
			$yhage = max($yhage, 1);
			$starts = ($yhage - 1) * $yhsum;
			if($yhcount) {	
				$sql = "SELECT * FROM ".DB::table('forum_alliance_yh')." WHERE aid='$sid' ORDER BY dateline DESC LIMIT $starts,$yhsum";
				$query = DB::query($sql);
				$youhui = $youhuis = array();
				while($youhui = DB::fetch($query)){
					$youhui['dateline'] = gmdate('m-d', $youhui['dateline'] + $_G['setting']['timeoffset'] * 3600);
					$youhuis[] = $youhui;
				}
			}
			$ymulti = "<div class='pages cl'>".multi($yhcount, $yhsum, $yhage,'plugin.php?id=dz55625_haodian:haodian&mod=view&p=news&sid='.$sid.'')."</div>";	
		}elseif($_GET['nw']){
			$nw = intval($_GET['nw']);
			$sql = "SELECT * FROM ".DB::table('forum_alliance_yh')." WHERE id='$nw'";
			$query = DB::query($sql);
			$youhui = $youhuis = array();
			while($youhui = DB::fetch($query)){
				$youhui['dateline'] = gmdate('Y-m-d', $youhui['dateline'] + $_G['setting']['timeoffset'] * 3600);
				$youhui['subject'] = discuzcode($youhui['subject']);
				$youhuis[] = $youhui;
			}
		}
		if($Lstart==1){
			include_once 'source/plugin/dz55625_hadone/hadfun.inc.php';
		}
		if($StHop==1){
			include_once 'source/plugin/dz55625_hshop/shopfun.inc.php';
		}
		if($Ystart==1){
			include_once 'source/plugin/dz55625_yuyue/yuyue.inc.php';
		}
		//------------------------------------------------
		if(submitcheck('applysubmit')){	
			if(!$_G['uid']){
				showmessage($php_lang['lykwuquan'], array(), array('alert' => right));
			}else{
				if($Umessage == 1){
					$pljc=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_pl')." WHERE sid='$sid' AND uid='$uid' ");
					if($pljc['uid']){
						showmessage($php_lang['liuyanjc'], dreferer(), array(), array('locationtime'=>2, 'showdialog'=>1, 'showmsg' => true, 'closetime' => 2));
					}
				}
				if(empty($_GET['message'])){
								showmessage($php_lang['lnrweik'], dreferer());
							}else{
							
							$_GET['sid'] = intval($_GET['sid']);
							$_GET['uid'] = intval($_G['uid']);
							$_GET['author'] = addslashes($_G['username']);
							$_GET['message'] = addslashes($_GET['message']);
							$_GET['total'] = intval($_GET['total']*2);
							if($_GET['total']==0){
								$_GET['voter'] = 0;
							}else{
								$_GET['voter'] = 1;
							}
							$_GET['display'] = intval($display) == 1 ? 1 : 0; 
							DB::insert('forum_alliance_pl',array('id' => '','sid' => $_GET['sid'],'uid' => $_GET['uid'],'author' => $_GET['author'],'message' => $_GET['message'],'voter' => $_GET['voter'],'total' => $_GET['total'],'display' => $_GET['display'],'dateline' => time()));
					}
					
					if(!empty($_GET['total'])){
							$_GET['sid'] = intval($_GET['sid']);
							$sql = "SELECT sum(voter) AS 'voters' , sum(total) AS 'totals' FROM ".DB::table('forum_alliance_pl')." WHERE sid='".$_GET['sid']."'";
							$result = DB::query($sql);
							$row = DB::fetch($result);  
							$sid = intval($_GET['sid']);
							$voter = intval($row['voters']);
							$total = intval($row['totals']);
							DB::update('forum_alliance_ar', array('voter' => $voter, 'total' => $total), "id='$sid'");
					}
					
					if(intval($display) == 0){
							showmessage($php_lang['lshenhe'], 'plugin.php?id=dz55625_haodian:haodian&mod=view&sid='.$_GET['sid'].'', array(), array('alert' => right));
						}else{
							showmessage($php_lang['lplok'], 'plugin.php?id=dz55625_haodian:haodian&mod=view&sid='.$_GET['sid'].'', array(), array('alert' => right));
					}
			}
			
		}
		
		
		$mobile_action="mobile_view";
		$appl=$_G['siteurl']."plugin.php?id=dz55625_haodian:mobile_haodian".($_G['mobile']?"&mobile=2":"");
		
}elseif($_GET['mod']=='add'){
	
	//----------------------------------------------------
	$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE upid='0' ORDER BY displayorder ASC");
	while($row = DB::fetch($query)) {
		$local[$row['id']] = $row;
	}
	//----------------------------------------------------	

	if($_G['uid']){
		if($kaiqidj != 1){
			$uid = intval($_G['uid']);
			$ps = DB::fetch(DB::query("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE uid='$uid'"));
			$sid = intval($ps['uid']);
			if($uid == $sid){
				showmessage($php_lang['cfdingji']);
			}
		}
	}
	
	$set = $_G['cache']['plugin']['dz55625_haodian'];
	$addshuliang = $set['addshuliang'];
	$extcredita =$set['extcredita'];
	$addstart =$set['addstart'];
	
	foreach($_G['setting']['extcredits'] as $key => $value){
		$ext = 'extcredits'.$key;
		getuserprofile($ext);
		$haodians['extcredits'][$key]['title'] = $value['title'];
		$haodians['extcredits'][$key]['value'] = $_G['member'][$ext];
	}
	
	$groups = unserialize($groups);
	$admins = explode(",", $groupso);
	
	include_once 'source/plugin/dz55625_haodian/haodian_pc.class.php';
	
	if(!in_array($_G['groupid'], $groups)){
			showmessage($php_lang['wuquant'], '', array(), array('login' => true));
	}else{
			if(submitcheck('applysubmit')){
				if(empty($_GET['title'])){
					showmessage($php_lang['lbiaotinull'], dreferer());
				}else{
				//---------------------------------------------
				$active=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE title like '%{$_GET['title']}%' ");
				if($active['title']){
					showmessage($php_lang['mingcfus'], dreferer(), array(), array('locationtime'=>2, 'showdialog'=>1, 'showmsg' => true, 'closetime' => 2));
				}
				//---------------------------------------------
				$timestamp = $_G['timestamp'];
				$cid = intval($_GET['acid']);
				$did = intval($_GET['local_2']) ? intval($_GET['local_2']) : intval($_GET['local_1']);
				$xnum = intval($_GET['xnum']);
				$uid = intval($_G['uid']);
				$author = addslashes($_G['username']);
				$ztime=addslashes($_GET['yy_ztime']);
				$wtime=addslashes($_GET['yy_wtime']);
				$title=addslashes($_GET['title']);
				$zkoubj = addslashes($_GET['zkoubj']);
				$sad = addslashes($_GET['sad']) == '' ? 0 : addslashes($_GET['sad']); 
				$address=addslashes($_GET['address']);
				$tel = addslashes($_GET['tel']);
				$tese = addslashes($_GET['tese']);
				$tenqq = addslashes($_GET['tenqq']);
				$taobao = addslashes($_GET['taobao']);
				$summary=addslashes($_GET['summary']);
				$display = intval($displays) == 1 ? 1 : 0; 
				$lng = addslashes($_GET['lng']); 
				$lat = addslashes($_GET['lat']) == 1 ? 1 : 0; 
				$jib = intval($_GET['jib']);
				if($_FILES['file']['error']==0){
					$rand=date("YmdHis").random(3, $numeric =1);
					$filesize = $_FILES['file']['size'] <= $picdx ;   // 封面图片大小
					$filetype = array("jpg","JPG", "jpeg","JPEG", "gif","GIF", "png", "PNG");
					$arr=explode(".", $_FILES["file"]["name"]);
					$hz=$arr[count($arr)-1];
					if(!in_array($hz, $filetype)){
						showmessage($php_lang['zhiyunxu']);	
					}
					$filepath = "source/plugin/dz55625_haodian/upimg/".date("Ymd")."/";
					$randname = date("Y").date("m").date("d").date("H").date("i").date("s").rand(100, 999).".".$hz;
					if(!file_exists($filepath)){ mkdir($filepath); }
					if($filesize){ 
						if(@copy($_FILES['file']['tmp_name'], $filepath.$randname) || (function_exists('move_uploaded_file') && @move_uploaded_file($_FILES['file']['tmp_name'], $filepath.$randname))) {
							 @unlink($_FILES['file']['tmp_name']);
						}
					}else{
						showmessage($php_lang['daxiaoxz']);	
					}
					$pic = "source/plugin/dz55625_haodian/upimg/".date("Ymd")."/".$randname."";
					new myThumbClass($pic,170,120,$pic,0,0);
				}
				
				//--------------------------------------			
				if($addstart==1){
					if($ZjenStart==1){
						updatemembercount($_G['uid'], array($extcredita => +$addshuliang));
					}else{
						if($haodians['extcredits'][$extcredita]['value']<$addshuliang){
							$tixing= $haodians['extcredits'][$extcredita]['title'].$php_lang['jinbibz'].$addshuliang."";
							showmessage($tixing);
						}else{
							updatemembercount($_G['uid'], array($extcredita => -$addshuliang));
						}
					}
				}
				//--------------------------------------
				
				
			
					DB::query("INSERT INTO ".DB::table('forum_alliance_ar')." ( `id` , `xnum`, `cid`, `did`, `sad`, `zkoubj`, `uid`, `author` , `pic` ,`yy_ztime`,`yy_wtime`,`title` ,`address`, `tel` , `tese`, `tenqq`, `taobao`, `summary`, `display` , `top`, `jib`, `lng` , `lat` , `map_type` , `dateline` ) VALUES (NULL , '$xnum', '$cid' , '$did', '$sad', '$zkoubj', '$uid', '$author', '$pic','$ztime','$wtime','$title','$address', '$tel', '$tese', '$tenqq', '$taobao', '$summary', '$display', '$top', '$jib', '$lng', '$lat','$mapStart', '$timestamp');");
					
					
				}

				$aid = DB::insert_id();
				$countz = count($_POST['filelist']);
					for($i=0;$i<$countz;$i++){
						$img = addslashes($_POST['filelist'][$i]);
						DB::query("INSERT INTO ".DB::table('forum_alliance_img_tmp')." ( `id` , `aid`, `uid`, `img`,`dateline` ) VALUES (NULL , '$aid', '$uid', '$img','$timestamp');");
					}  
				if($fidstart == 1){
					include_once 'source/plugin/dz55625_plate/plate.inc.php';
				}
				if($displays == 0){
					for($i=0;$i<count($admins);$i++){
						notification_add($admins[$i], 'system',$php_lang['xinxitxing'],  $notevars = array(), $system = 0);
					}
					showmessage($php_lang['lshenhe'], 'plugin.php?id=dz55625_haodian:haodian', array(), array('alert' => right));
					
					}else{
					showmessage($php_lang['tianjiaok'], 'plugin.php?id=dz55625_haodian:haodian', array(), array('alert' => right));
				}
		}
	}
	
}

include template($identifier.':haoindex');

function classnum($cid){
	return DB::result_first("SELECT count(*) FROM ".DB::table('forum_alliance_ar')." WHERE `cid` ='$cid' AND display!=0");
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
function get_time($server){   
	date_default_timezone_set('Asia/Shanghai'); //系统时间差8小时问题
    $data  = "HEAD / HTTP/1.1\r\n";   
    $data .= "Host: $server\r\n";   
    $data .= "Connection: Close\r\n\r\n";   
    $fp = fsockopen($server, 80);   
    fputs($fp, $data);   
    $resp = '';   
    while ($fp && !feof($fp))   
        $resp .= fread($fp, 1024);   
    preg_match('/^Date: (.*)$/mi',$resp,$matches);   
    return strtotime($matches[1]);   
}  

?>
