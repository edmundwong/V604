<?php
if(!defined('IN_DISCUZ')) {	exit('Access Denied'); }

$goods_ids=array();

$query = DB::query('SELECT goods_id FROM '.DB::table('sale_up')." WHERE up_endtime<'".TIMESTAMP."' ");
while($tem = DB::fetch($query)){
	$goods_ids[] = $tem['goods_id'];
}

DB::query(" DELETE FROM ".DB::table('sale_up')." WHERE goods_id IN (".dimplode($goods_ids).")");
DB::query(" UPDATE ".DB::table('sale_goods')." SET goods_up='0' WHERE goods_id IN (".dimplode($goods_ids).")");
?>