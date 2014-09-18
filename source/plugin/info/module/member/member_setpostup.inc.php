<?php

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

if(empty($_G['uid']) ) {	showmessage($info_lang['login'],'',array(),array('login' => true));}

$post_id = intval($_GET['post_id']);
$up_day = intval($_GET['up_day']);

if( submitcheck('submit_setpostup') ){
	$mycredit = DB::result_first("SELECT extcredits{$info_config['extcredits']} FROM ".DB::table('common_member_count')." WHERE uid='{$_G['uid']}' ");
	$total_credit = $up_day * $info_config['daycredit'];
	$now_credit = $mycredit-$total_credit;
	if($total_credit >= 0 && $now_credit>=0 ){
		$post_title = DB::result_first("SELECT post_title FROM ".DB::table('info_post')." WHERE post_id='{$post_id}' ");
		$has_post_id = DB::result_first("SELECT post_id FROM ".DB::table('info_post_up')." WHERE post_id='{$post_id}' ");
		
		$array = array(
			'post_id'=>$post_id,
			'post_title'=>$post_title,
			'up_day'=>$up_day,
			'up_time'=>time(),
			'up_endtime'=>strtotime("+ {$up_day} days"),
			);
		
		if($has_post_id){
			DB::update('info_post_up',$array," post_id='{$post_id}'");
		}else{
			DB::insert('info_post_up',$array);
		}
		
		DB::update('info_post',array('post_up'=>'1','up_endtime'=>strtotime("+ {$up_day} days"))," post_id='{$post_id}'");
		
		updatemembercount($_G['uid'], array( $info_config['extcredits'] => -$total_credit),1,'','','',
			$info_lang['xinxi_zhiding'],
				$info_config['name'].": <a href='{$info_config['root']}?mod=member&op=mypost&ac=up' target='_blank'>{$info_lang['about_info']}</a>"
		);
		
		showmessage($info_lang['setpostup_ok'],$info_config['root']."?mod=member&op=mypost&ac=up");
		
	}elseif(($mycredit-$total_credit)<0){
		showmessage($info_config['credit_unit'].$info_lang['not_credit'],$info_config['root']."?mod=member");
	}
}

$post_id = intval($_GET['post_id']);
$post = fetch_all('info_post'," WHERE post_id='{$post_id}'"," post_title,post_id,member_uid ");
$post = $post[0];
include template("info:{$style}/member/member_setpostup");
?>