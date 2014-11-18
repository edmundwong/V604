<?php
/**
 * 数据采集蜘蛛
 * by edmund
 * since 2014-08-26
 */
if(!defined('IN_ADMINCP')){exit('Admin Login');}
if(!defined('IN_DISCUZ')) {exit('Access Denied');}
global $sale_config,$_lang;

require_once DISCUZ_ROOT.'./source/plugin/sale/module/spider/Snoopy.class.php';
require_once DISCUZ_ROOT.'./source/plugin/sale/module/spider/simple_html_dom_1_5.php';
require_once DISCUZ_ROOT.'./source/plugin/sale/module/spider/operation.php';

require_once DISCUZ_ROOT.'./source/plugin/sale/module/spider/config.php';
require_once DISCUZ_ROOT.'./source/plugin/sale/module/spider/index.php';

//set_time_limit(0);
//ini_set('memory_limit', '256M');
//header("Connection:Keep-Alive");
//header("Proxy-Connection:Keep-Alive");
//error_reporting(E_ALL);
//ini_set( 'display_errors', 'On' );

$mod = "admin_spider";
$form_url = 'plugins&operation=config&identifier=sale&pmod='.$mod."&do=".$do;
$cp_url ='action='.$form_url;
$now_url = ADMINSCRIPT."?".$cp_url;
$re_2 = '/viewinfo\.aspx\?id=\d+$/';

$_cur_catid = '';
$_cur_subcatid = '';

//一次批量采集的数据量
$_SPIDER_CONTENT_ONCE = 1;
//每次批量采集的时间间隔(毫秒)
$_SPIDER_CONTENT_WAIT = 3000;

//自动抓取数据
if(isset($_GET['sp_ac']) && $_GET['sp_ac'] == 'auto'){
    require_once DISCUZ_ROOT.'./source/plugin/sale/module/spider/SaleAutoSpider.class.php';
    $o_spider = new SaleAutoSpider();
    $o_spider->doRun();
//删除链接
}else if(isset($_GET['sp_ac']) && $_GET['sp_ac'] == 'delLink'){
    $_cur_catid = $_GET['catid'];
    $_cur_subcatid = $_GET['subcatid'];
    $id = $_GET['id'];
    DB::delete('sale_spider_links',"id=$id ");
    $a_link_list = sale_spider_getlink($_cur_subcatid);
    include template("sale:admin/admin_spider_link");
    
//获得已获取链接列表
}else if(isset($_GET['sp_ac']) && $_GET['sp_ac'] == 'getlink'){
    $_cur_catid = $_GET['catid'];
    $_cur_subcatid = $_GET['subcatid'];
    $a_link_list = sale_spider_getlink($_cur_subcatid);
    include template("sale:admin/admin_spider_link");
    
//扫描目标站链接并入库
}else if(isset($_GET['sp_ac']) && $_GET['sp_ac'] == 'spiderLink'){
    $_cur_catid = $_GET['catid'];
    $_cur_subcatid = $_GET['subcatid'];
    $i_catid = $_cur_catid;
    $i_subcatid = $_cur_subcatid;
    
    //获得子分类
    //意外判断.判空以及判存在 TODO
    $s_cattitle = $__links[$i_catid]['title'];
    $s_subcattitle = $__links[$i_catid]['child'][$i_subcatid]['title'];
    $s_url = $__links[$i_catid]['child'][$i_subcatid]['link'];
    
    //是否已经存在于表中->抓取链接
    $r_result = DB::query("SELECT url FROM pre_sale_spider_links WHERE subcatid=$i_subcatid");
    $a_link_list = array();
    while($tem = DB::fetch($r_result)){
        $a_link_list[] = $tem['url'];
    }
    $o_sale_list = new SaleListData($s_url,$a_link_list);
    $a_link = $o_sale_list->aLink;
    $a_title = $o_sale_list->aTitle;
    $a_area = $o_sale_list->aArea;
    $a_desc = $o_sale_list->aDesc; 
    
    //入库
    $a_values = array();
    for ($i=0; $i<count($a_link); $i++){
        $a_values['catid'] = $i_catid;
        $a_values['cattitle'] = $s_cattitle;
        $a_values['subcatid'] = $i_subcatid;
        $a_values['subcattitle'] = $s_subcattitle;
        $a_values['url'] = $a_link[$i];
        $a_values['title'] = $a_title[$i];
        $a_values['area'] = $a_area[$i];
        $a_values['summary'] = $a_desc[$i];
        $a_values['time'] = time();
        DB::insert('sale_spider_links', $a_values);
    }
    
    $a_link_list = sale_spider_getlink($_cur_subcatid);
    include template("sale:admin/admin_spider_link");
    
//抓取内容
}else if (isset($_GET['sp_ac']) && $_GET['sp_ac'] == 'spiderContent'){
    $_cur_catid = $_GET['catid'];
    $_cur_subcatid = $_GET['subcatid'];
    
    $s_sql_link = "SELECT id,catid,cattitle,subcatid,subcattitle,title,area,summary,url "
            . "FROM pre_sale_spider_links WHERE subcatid=$_cur_subcatid AND state=0 ORDER BY id asc";
    $r_result = DB::query($s_sql_link);
    $a_link_list = array();
    while($tem = DB::fetch($r_result)){
        $a_link_list[] = $tem;
    }
    $i_spider_count = 0;
    $a_config_temp = array();
    $ii = 0;
    foreach ($a_link_list as $a_link){
        if (++$i_spider_count > $_SPIDER_CONTENT_ONCE){break;}
        
        sale_spider_content_debug($a_link, $i_spider_count);
        ob_flush();
        flush();
        
        $a_config_temp['catId'] = $a_link['catid'];
        $a_config_temp['catTitle'] = $a_link['cattitle'];
        $a_config_temp['subCatId'] = $a_link['subcatid'];
        $a_config_temp['subCatTitle'] = $a_link['subcattitle'];
        $a_config_temp['area'] = $a_link['area'];
        $a_config_temp['desc'] = $a_link['summary'];
                
        $o_operation = new SalePageData($a_link['url'],$a_config_temp);
        
        $a_goods_values = $o_operation->getArrayData();
        $s_goods_id = DB::insert('sale_goods', $a_goods_values, $s_goods_id=true);
        
        $a_member_values = $o_operation->getUserDataArr($s_goods_id);
        DB::insert('sale_member', $a_member_values);
        
        DB::update('sale_spider_links', array('state'=>1), "id=$a_link[id]");
        echo '===================================================<br/><br/>';
    }
    
    include template("sale:admin/admin_spider_content");
}else{
    $s_sql_link = 'SELECT subcatid,COUNT(1) linknum FROM pre_sale_spider_links GROUP BY subcatid';
    $r_result_link = DB::query($s_sql_link);
    $a_link_num = array();
    while($tem = DB::fetch($r_result_link)){
        $a_link_num[] = $tem;
    }
    $s_sql_did = 'SELECT subcatid,COUNT(1) didnum FROM pre_sale_spider_links WHERE state=1 GROUP BY subcatid';
    $r_result_did = DB::query($s_sql_did);
    $a_link_did = array();
    while($tem = DB::fetch($r_result_did)){
        $a_link_did[] = $tem;
    }
    $a_subcat_linkinfo = array();
    foreach ($a_link_num as $a_link){
        $i_subcatid = $a_link['subcatid'];
        $i_link_num = $a_link['linknum'];
        $i_did_num = 0;
        foreach($a_link_did as $a_did){
            if ($i_subcatid == $a_did['subcatid']){
                $i_did_num = $a_did['didnum'];
                break;
            }
        }
        $a_subcat_linkinfo[$i_subcatid] = array('didnum'=>$i_did_num,'linknum'=>$i_link_num);
    }
    
    include template("sale:admin/admin_spider");
}

function sale_spider_getlink($cur_subcatid){
//    echo "_cur_catid:$_cur_catid||_cur_subcatid:$_cur_subcatid";
    $s_sql = "SELECT id,catid,cattitle,subcatid,subcattitle,url,title,area,summary,state "
            . "FROM pre_sale_spider_links WHERE subcatid=$cur_subcatid ORDER BY state asc,time desc";
    $r_result = DB::query($s_sql);
    $a_link_list = array();
    while($tem = DB::fetch($r_result)){
        $a_link_list[] = $tem;
    }
    return $a_link_list;
}

function sale_spider_content_debug($a_link,$i){
    echo "开始抓取 第 $i 条 <br/>";
    echo "标题: $a_link[title] <br/>";
    echo "URL: $a_link[url] <br/>";
    echo '-----------------------------------------------------<br/>';
}

?>