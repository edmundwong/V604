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
	include_once 'language.'.currentlang().'.php';
	@extract($_G['cache']['plugin']['dz55625_haodian']);
	@extract($_G['cache']['plugin']['dz55625_haodian_domain']);
	$curls = 'plugin.php?id=dz55625_haodian:haodian&mod=view&sid=';
	if($RewriteStart == 1){ $curl = 'haodian';}else{
		$curl = 'plugin.php?id=dz55625_haodian:haodian&mod=view&sid=';
	}
	$his = $_G['siteurl'];
	$his = parse_url($his);
	$haodian_host=$his['host'];
	$pages=intval($_G["gp_page"]);
	$action=$_G["gp_action"];
	$ajax_fun=addslashes($_GET['fun'])?addslashes($_GET['fun']):"ajax_haodian";
	$condition="";
	$orderby="";
	if($action=="index_list"){
		$condition=addslashes($_GET['condition'])?addslashes($_GET['condition']):"";
		$condition=iconv('utf-8',$_G['charset'],$condition);
		$orderby=addslashes($_GET['orderby'])?addslashes($_GET['orderby']):"";
		if(!empty($eacha))
			$pagesnum=intval($eacha);
		else
			$pagesnum = intval($_GET['pagenum']);
		if($orderby)
			$orderby="order by ".$orderby;
		if($condition){
			$condition=@str_replace("[exp]","=",$condition);
			$condition=@str_replace("[empty]"," ",$condition);
			$condition=@str_replace("[yh]","'",$condition);
		}
	}else{
		if(!empty($moble_pagenum))
			$pagesnum=intval($moble_pagenum);
		else
			$pagesnum = intval($_GET['pagenum']);
		$orderby="order by a.topid desc,a.id desc";
	}
	if(empty($pagesnum))
		$pagesnum=10;
		
		
	$counts = DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_alliance_ar')." a where ".$condition." a.display!='0'");
	$pages = max($pages, 1);
	$starts = ($pages - 1) * $pagesnum;
	
	$mythread = $mythreads = $return = array();
	if($counts) {
		if(!empty($fdymsz) && !empty($hd_domain) && !empty($isdomain) && $action=="index_list"){	
			$sql = "SELECT a.*,d.domain FROM ".DB::table('forum_alliance_ar')." a left join ".DB::table('forum_alliance_domain')." d on(a.id=d.aid) where ".$condition." a.display!='0' ".$orderby." LIMIT $starts,$pagesnum";
		}else{
			$sql="select *  from ".DB::table("forum_alliance_ar")." a where ".$condition." a.display!='0' ".$orderby." LIMIT $starts,$pagesnum";
		}
		$query = DB::query($sql);
		while($mythread = DB::fetch($query)){
			$t=$mythread['title'];
			$mythread['title']=iconv($_G['charset'],'utf-8',$mythread['title']);
			$mythread['s_title']=iconv($_G['charset'],'utf-8',cutstr($t, 18, '.'));
			$mythread['address']=iconv($_G['charset'],'utf-8',$action=="index_list"?$mythread['address']:cutstr($mythread['address'], 40, '.'));
			if($action=="index_list"){
				$isvip=0;
				if(empty($domainfw)){
					if(!empty($mythread['click'])){$isvip=1;}
				}else{
					$isvip=1;
				}
				if(!empty($mythread[domain]) && $isvip==1){
					$fdhref=str_replace($haodian_host,$mythread['domain'].".".$hd_domain,$_G['siteurl']);
				}elseif($RewriteStart){
					$fdhref=$curl."_".$mythread['id'].".html";
				}else{
					$fdhref=$curl.$mythread['id'];
				}
				$mythread['haodian_url']=$fdhref;
			}else{
				$mythread['haodian_url']=$curls.$mythread[id];
			}
			if(round($mythread[total]/$mythread[voter],1) != 0){
				$mythread[tvs]="<span>".round($mythread[total]/$mythread[voter]+$mythread[bonus],1)."</span> ".$php_lang['homefen'];
			}else{
				$mythread[tvs]=$php_lang['zanwupfen'];
			}
			$mythread['tvs']=iconv($_G['charset'],'utf-8',$mythread['tvs']);
			if(empty($mythread[pic])){
				$mythread[pic]="source/plugin/dz55625_haodian/images/over.jpg";
			}
			$mythreads[] = $mythread;
		}
	}
	if($action=="index_list"){
	   $multis = multi($counts, $pagesnum,intval($pages),$ajax_fun."(",0,10,FALSE,FALSE,")");
	   $multis=str_replace("?","",$multis);
	}
	$return["page"]=$pages;
	$return["pagenum"]=$pagesnum;
	$return["counts"]=$counts;
	$return["data"]=$mythreads;
	$return["curcount"]=count($mythreads);
	
	if($action=="index_list")
		$return["multis"]=iconv($_G['charset'],'utf-8',$multis);
	echo json_encode($return);

?>