<?php
/*
	[55625.COM!] (C)2001-2013 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/discuzcode');
global $_G;
include_once 'language.'.currentlang().'.php';
if(!isset($_G['cache']['plugin'])){ loadcache('plugin'); }
@extract($_G['cache']['plugin']['dz55625_haodian']);
$appl=$_G['siteurl']."plugin.php?id=dz55625_haodian:mobile_haodian".($_G['mobile']?"&mobile=2":"");
$uc = $_G['setting']['ucenterurl'];
$listclass = parconfig($listclass);
$mobile_action=addslashes($_G['gp_mod'])?addslashes($_G['gp_mod']):"mobile_list";

if($mobile_action=="mobile_list"){
	$mobile_list_status=addslashes($_G['gp_mobile_list_status'])?addslashes($_G['gp_mobile_list_status']):0;
	$sql_temp="";
	if($mobile_list_status==1){
		$sql_temp=" and click='1'";
	}elseif($mobile_list_status==2){
		$sql_temp=" and top='1'";
	}elseif($mobile_list_status==3){
		$sql_temp=" and sad > 0";
	}
	$file=DISCUZ_ROOT."./source/plugin/dz55625_haodian/config.php";
	$mobile_conf = @include $file;
	$mobile_conf || $mobile_conf = array();
	if(!$mobile_conf['magic_lantern']){
		$mobile_conf['ishuandeng']=0;
	}
	$pagenum=$mobile_conf['moble_pagenum']?$mobile_conf['moble_pagenum']:5;
	$counts = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_ar')." WHERE display!='0' ".$sql_temp);
	$pages = intval($_GET['page']);
	$pages = max($pages, 1);
	$starts = ($pages - 1) * $pagenum;
	
	if($counts) {
		$sql = "SELECT * FROM ".DB::table('forum_alliance_ar')." WHERE display!='0' ".$sql_temp." order by topid DESC,xnum ASC,dateline desc LIMIT $starts,$pagenum";
		$query = DB::query($sql);
		$mythread = $mythreads = array();
		while($mythread = DB::fetch($query)){
			$mythread['dateline'] = gmdate('Y-m-d', $mythread['dateline'] + $_G['setting']['timeoffset'] * 3600);
			$xianzai = gmdate('Y-m-d', $_G['timestamp'] + $_G['setting']['timeoffset'] * 3600); 
			if($mythread['dateline']==$xianzai){
				$mythread['dateline']= $php_lang['jintian'];
			}
			if(round($mythread[total]/$mythread[voter],1) != 0){
					$mythread[tvs]="<span>".round($mythread[total]/$mythread[voter]+$mythread[bonus],1)."</span> ".$php_lang['homefen'];
			}else{
				$mythread[tvs]=$php_lang['zanwupfen'];
			}
			$mythreads[] = $mythread; 
		}
	}
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
	
	
	
}elseif($mobile_action=="mobile_sousu"){
	$quers = DB::query("SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE upid = 0 order by displayorder");
	while($rows = DB::fetch($quers)) {
		$citys[]=$rows;
	}
	
}elseif($mobile_action=="select_fl"){
	$cityoneid = intval($_G['gp_oneid']);
	$quers = DB::query("SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE upid = $cityoneid order by displayorder ");
	$citys=array();
	while($rows = DB::fetch($quers)) {
		$rows['subject']=iconv($_G['charset'],'utf-8',$rows['subject']);
		$citys[]=$rows;
	}
	echo json_encode($citys);
	exit();
}elseif($mobile_action=="mobile_sousu_view"){
	$cityoneid=intval($_G['gp_cityoneid']);
	$citytwoid=intval($_G['gp_citytwoid']);
	$title=iconv('utf-8',$_G['charset'],addslashes($_G['gp_title']));
	if(!$title){$title=addslashes($_G['gp_title']);}
	$fl=intval($_G['gp_fl']);
	
	$city_text=$title_text=$fl_text=$php_lang['c_buxian'];
	$pagenum=$moble_pagenum?$moble_pagenum:5;
	$pager = intval($_GET['page']);
	$pager = max($pager, 1);
	$starts = ($pager - 1) * $pagenum;
	$where=" where display=1";
	
	if($cityoneid){ 
		$cityone=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE id='$cityoneid'");
		$city_text=$cityone['subject'];
		if($citytwoid){
			$city_text.="-".DB::result_first("select subject from ".DB::table("forum_alliance_fl")." where id='".$citytwoid."'");
			$where.=" and did=".$citytwoid;
		}else{
			if($cityone['subid']){
				$where.=" and did in(".$cityone['id'].",".$cityone['subid'].")";
			}else{
				$where.=" and did=".$cityone['id'];
			}
		}
	}
	
	if($fl){
		$fl_text=$listclass[$fl];
		$where.=" and cid=".$fl;
	}
	if($title){
		$title_text=$title;
		$where.=" and title like '%".$title."%'";
	}
	
	$counts = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_ar').$where);
	
	if($counts) {
		$sql = "SELECT * FROM ".DB::table('forum_alliance_ar').$where." order by topid DESC,xnum ASC,dateline DESC  LIMIT $starts,$pagenum";
		$query = DB::query($sql);
		$mythread = $mythreads = array();
		while($mythread = DB::fetch($query)){
			$mythread['dateline'] = gmdate('Y-m-d', $mythread['dateline'] + $_G['setting']['timeoffset'] * 3600);
			$xianzai = gmdate('Y-m-d', $_G['timestamp'] + $_G['setting']['timeoffset'] * 3600); 
			if($mythread['dateline']==$xianzai){
				$mythread['dateline']= $php_lang['jintian'];
			}
			if(round($mythread[total]/$mythread[voter],1) != 0){
					$mythread[tvs]="<span>".round($mythread[total]/$mythread[voter]+$mythread[bonus],1)."</span> ".$php_lang['homefen'];
			}else{
				$mythread[tvs]=$php_lang['zanwupfen'];
			}
			$mythreads[] = $mythread; 
		}
	}
	$infos=array();
	$infos=$mythreads;
	$prepage="";
	$nextpage="";
	if($pager>1){
		$prepage=$pager-1;
	}
	if($pager*$pagenum<$counts){
		$nextpage=$pager+1;
	}
}elseif($mobile_action=="mobile_view"){
	$info_id=intval($_G['gp_info_id']);
	if($info_id){
		$info=DB::fetch_first("SELECT * FROM ".DB::table('forum_alliance_ar')." where id=$info_id");
		if($info){
			$xianzai = gmdate('Y-m-d', $_G['timestamp'] + $_G['setting']['timeoffset'] * 3600);
			$info['dateline'] = gmdate('Y-m-d', $info['dateline'] + $_G['setting']['timeoffset'] * 3600);
			if($info['dateline']==$xianzai){
				$info['dateline']= $php_lang['jintian'];
			}
			$info['summary'] = discuzcode($info['summary'], 1, 0, 0, 0, 1, 1, 0, 0, 1);//discuzcode($mythread['summary']);
			
			$navtitle = $info['title'];
			if($puseo==1){
					$metakeywords = $info['keywords'];
					$metadescription = $info['description'];
			}elseif($info['click']==1){
					$metakeywords = $info['keywords'];
					$metadescription = $info['description'];
			}
			
			$info['fl']=$listclass[$info['cid']];
			if(round($info[total]/$info[voter],1) != 0){
					$info[tvs]="<em>".round($info[total]/$info[voter]+$info[bonus],1)."</em> ".$php_lang['homefen'];
			}else{
				$info[tvs]=$php_lang['zanwupfen'];
			}
			if($info['did']){
				$region_sql_3 = "SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE id = '$info[did]'";
				$dfl = DB::fetch_first($region_sql_3);
				if($dfl['upid']){
					$info['region']=DB::result_first("SELECT subject FROM ".DB::table('forum_alliance_fl')." WHERE id = '$dfl[upid]'")."-".$dfl['subject'];
				}else{
					$info['region']=$dfl['subject'];
				}
			}
			
			$pls = $pl = array();
			$sql="select *  from ".DB::table("forum_alliance_pl")." WHERE sid='$info[id]' AND display!='0' ORDER BY dateline LIMIT 0,5";
			$query = DB::query($sql);
			while($pl = DB::fetch($query)){
				$pl['dateline'] = gmdate('m-d H:i', $pl['dateline'] + $_G['setting']['timeoffset'] * 3600);
				$pls[] = $pl;
			}
			
		}else{
			$action="mobile_error";
			$error=$php_lang['mobile_error'];
			$back_url=$appl;
		}
	}else{
		$action="mobile_error";
		$error=$php_lang['mobile_error'];
		$back_url=$appl;
	}
}elseif($mobile_action=="mobile_wp"){
	$pagenum=5;
	$info = $infos = array();
	$sql = "SELECT * FROM ".DB::table('forum_alliance_wp')." LIMIT 0,$pagenum";
	$query = DB::query($sql);
	while($info = DB::fetch($query)){
		$info['dateline'] = gmdate('Y-m-d', $info['dateline'] + $_G['setting']['timeoffset'] * 3600);
		$info['createtime'] = gmdate('Y-m-d', $info['createtime'] + $_G['setting']['timeoffset'] * 3600);
		$infos[] = $info;
	}
}

include template('dz55625_haodian:touch/haoindex');

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