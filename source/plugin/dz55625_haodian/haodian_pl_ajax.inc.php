<?php
/*
	(C)2011 - 2013 55625.COM Inc.
	Make BY Lovenr   QQ:114512039  
*/
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	header('Content-Type:text/html; charset=gb2312');
	loadcache('plugin');
	@extract($_G['cache']['plugin']['dz55625_haodian']);
	$pages=intval($_G["gp_page"]);
	if(!empty($each))
		$pagesnum=intval($each);
	else
		$pagesnum = intval($_GET['pagenum']);
	if(empty($pagesnum))
		$pagesnum=10;
	$sid = intval($_GET['sid']);
	$counts = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_pl')." WHERE sid='$sid' AND display!='0'");
	$pages = max($pages, 1);
	$starts = ($pages - 1) * $pagesnum;
	
	$mythread = $mythreads = $return = array();
	if($counts) {
		$sql="select *  from ".DB::table("forum_alliance_pl")." WHERE sid='$sid' AND display!='0' ORDER BY dateline LIMIT $starts,$pagesnum";
		$query = DB::query($sql);
		while($mythread = DB::fetch($query)){
			$mythread['dateline'] = gmdate('m-d H:i', $mythread['dateline'] + $_G['setting']['timeoffset'] * 3600);
			$mythread['author']=iconv($_G['charset'],'utf-8',$mythread['author']);
			$mythread['message']=iconv($_G['charset'],'utf-8',$mythread['message']);
			$mythread['nickback']=iconv($_G['charset'],'utf-8',$mythread['nickback']);
			$mythreads[] = $mythread;
		}
	}
	$return["page"]=$pages;
	$return["pagenum"]=$pagesnum;
	$return["counts"]=$counts;
	$return["data"]=$mythreads;
	$return["curcount"]=count($mythreads);
	echo json_encode($return);

?>