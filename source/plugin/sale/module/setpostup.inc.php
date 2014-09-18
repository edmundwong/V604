<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}

if(empty($_G['uid']) ) {	showmessage($_lang['login'],'',array(),array('login' => true));}

$goods_id = intval($_GET['goods_id']);
$up_day = intval($_GET['up_day']);

if( !empty($goods_id) ){
	$mycredit = DB::result_first("SELECT extcredits{$sale_config['extcredits']} FROM ".DB::table('common_member_count')." WHERE uid='{$_G['uid']}' ");
	$total_credit = $up_day * $sale_config['daycredit'];
	$now_credit = $mycredit-$total_credit;
	if($total_credit > 0 && $now_credit>0 ){
		$goods_title = DB::result_first("SELECT goods_title FROM ".DB::table('sale_goods')." WHERE goods_id='{$goods_id}' ");
		$has_goods_id = DB::result_first("SELECT goods_id FROM ".DB::table('sale_up')." WHERE goods_id='{$goods_id}' ");
		
		if($has_goods_id){
			$array = array(
				'goods_id'=>$goods_id,
				'goods_title'=>$goods_title,
				'up_day'=>$up_day,
				'up_time'=>time(),
				'up_endtime'=>strtotime("+ {$up_day} days"),
				);
			DB::update('sale_up',$array," goods_id='{$goods_id}'");
			DB::update('sale_goods',array('goods_up'=>'1','up_endtime'=>strtotime("+ {$up_day} days"))," goods_id='{$goods_id}'");
		}else{
			$array = array(
				'goods_id'=>$goods_id,
				'goods_title'=>$goods_title,
				'up_day'=>$up_day,
				'up_time'=>time(),
				'up_endtime'=>strtotime("+ {$up_day} days"),
			);
			DB::insert('sale_up',$array);
			DB::update('sale_goods',array('goods_up'=>'1','up_endtime'=>strtotime("+ {$up_day} days"))," goods_id='{$goods_id}'");
		}
		
		DB::update('common_member_count',array("extcredits{$sale_config['extcredits']}"=>$now_credit)," uid='{$_G['uid']}' ");
		showmessage($_lang['setpostup_ok'],$sale_config['root']."?mod=member&op=mypostup");
	}elseif(($mycredit-$total_credit)<0){
		showmessage($sale_config['credit_unit'].$_lang['not_credit'],$sale_config['root']."?mod=member");
	}
}else{
	showmessage($_lang['what_error'],$sale_config['root']."?mod=member");
}

$navtitle = $_lang['member']." - ".$sale_config['name'];
include template("sale:{$style}/member");
?>