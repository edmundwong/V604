<?php
/**
 *      ��Ȩ����: �ó���Ϊ [DiscuzCMS!] ������������, ����ӵ�иò�Ʒ֪ʶ��Ȩ,���д����Ȩ��[DiscuzCMS!]����, �����ھ�Ϊ��ҵ����, ��Ϊ�������ṩʹ����Ȩ.
 *		��������: δ���ٷ���Ȩʹ���޸Ļ��ߴ�������������Ȩ��Υ����Ϊ, ������׷��һ����ط�������.
 *		�ٷ���վ: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

if(empty($_G['uid']) ) {	showmessage($_lang['login'],'',array(),array('login' => true));}

$goods_id = intval($_GET['goods_id']);
$up_day = intval($_GET['up_day']);

if(!empty($goods_id) && !empty($up_day) ){
	$mycredit = DB::result_first("SELECT extcredits{$gongqiu_config['extcredits']} FROM ".DB::table('common_member_count')." WHERE uid='{$_G['uid']}' ");
	$total_credit = $up_day * $gongqiu_config['daycredit'];
	$now_credit = $mycredit-$total_credit;
	if($total_credit > 0 && $now_credit>0 ){
		$goods_title = DB::result_first("SELECT goods_title FROM ".DB::table('gongqiu_goods')." WHERE goods_id='{$goods_id}' ");
		$has_goods_id = DB::result_first("SELECT goods_id FROM ".DB::table('gongqiu_up')." WHERE goods_id='{$goods_id}' ");
		
		if($has_goods_id){
			$array = array(
				'goods_id'=>$goods_id,
				'goods_title'=>$goods_title,
				'up_day'=>$up_day,
				'up_time'=>time(),
				'up_endtime'=>strtotime("+ {$up_day} days"),
				);
			DB::update('gongqiu_up',$array," goods_id='{$goods_id}'");
			DB::update('gongqiu_goods',array('goods_up'=>'1','up_endtime'=>strtotime("+ {$up_day} days"))," goods_id='{$goods_id}'");
		}else{
			$array = array(
				'goods_id'=>$goods_id,
				'goods_title'=>$goods_title,
				'up_day'=>$up_day,
				'up_time'=>time(),
				'up_endtime'=>strtotime("+ {$up_day} days"),
			);
			DB::insert('gongqiu_up',$array);
			DB::update('gongqiu_goods',array('goods_up'=>'1','up_endtime'=>strtotime("+ {$up_day} days"))," goods_id='{$goods_id}'");
		}
		
		DB::update('common_member_count',array("extcredits{$gongqiu_config['extcredits']}"=>$now_credit)," uid='{$_G['uid']}' ");
		showmessage($_lang['setpostup_ok'],$gongqiu_config['root']."?mod=member&op=mypostup");
	}elseif(($mycredit-$total_credit)<0){
		showmessage($gongqiu_config['credit_unit'].$_lang['not_credit'],$gongqiu_config['root']."?mod=member");
	}
}else{
	showmessage($_lang['what_error'],$gongqiu_config['root']."?mod=member");
}

$navtitle = $_lang['member']." - ".$gongqiu_config['name'];
include template("gongqiu:{$style}/member");
?>