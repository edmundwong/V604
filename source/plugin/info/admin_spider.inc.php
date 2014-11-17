<?php
/**
 * 数据采集蜘蛛
 * by edmund
 * since 2014-08-26
 */
if(!defined('IN_ADMINCP')){exit('Admin Login');}
if(!defined('IN_DISCUZ')) {exit('Access Denied');}

global $info_config,$_lang;
//require_once DISCUZ_ROOT.'./source/plugin/info/include/config.inc.php';
//require_once DISCUZ_ROOT.'./source/plugin/info/include/function.class.php';

require_once DISCUZ_ROOT.'./source/plugin/info/module/spider/Snoopy.class.php';
require_once DISCUZ_ROOT.'./source/plugin/info/module/spider/simple_html_dom_1_5.php';
require_once DISCUZ_ROOT.'./source/plugin/info/module/spider/operation.php';

require_once DISCUZ_ROOT.'./source/plugin/info/module/spider/config.php';
require_once DISCUZ_ROOT.'./source/plugin/info/module/spider/index.php';

//set_time_limit(0);
ini_set('memory_limit', '256M'); 
//header("Connection:Keep-Alive");
//header("Proxy-Connection:Keep-Alive");
//error_reporting(E_ALL);
//ini_set( 'display_errors', 'On' );

$mod = "admin_spider";
$url = $_SERVER["REQUEST_URI"];
$self_url = 'plugins&operation=config&identifier=info&pmod='.$mod;
$cp_url ='action='.$self_url;
$now_url = ADMINSCRIPT."?".$cp_url;
$re_2 = '/viewinfo\.aspx\?id=\d+$/';

$_cur_catid = '';
$_cur_subcatid = '';

//一次批量采集的数据量
$_SPIDER_CONTENT_ONCE = 1;
//每次批量采集的时间间隔(毫秒)
$_SPIDER_CONTENT_WAIT = 3000;

//刷新缓存
if(isset($_GET['sp_ac']) && $_GET['sp_ac'] == 'cache'){
    require_once DISCUZ_ROOT.'./source/plugin/info/include/function.class.php';
    brian_cat_cache();
    echo 'refresh cache success!';
//删除链接
}else if(isset($_GET['sp_ac']) && $_GET['sp_ac'] == 'delLink'){
    $_cur_catid = $_GET['catid'];
    $_cur_subcatid = $_GET['subcatid'];
    $id = $_GET['id'];
    DB::delete('info_spider_links',"id=$id ");
    $a_link_list = info_spider_getlink($_cur_subcatid);
    include template("info:admin/admin_spider_link");
    
//获得已获取链接列表
}else if(isset($_GET['sp_ac']) && $_GET['sp_ac'] == 'getlink'){
    $_cur_catid = $_GET['catid'];
    $_cur_subcatid = $_GET['subcatid'];
    $a_link_list = info_spider_getlink($_cur_subcatid);
    include template("info:admin/admin_spider_link");
    
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
    $r_result = DB::query("SELECT url FROM pre_info_spider_links WHERE subcatid=$i_subcatid");
    $a_link_list = array();
    while($tem = DB::fetch($r_result)){
        $a_link_list[] = $tem['url'];
    }
    $o_yellow_list = new YellowListData($s_url,$a_link_list);
    $a_link = $o_yellow_list->aLink;
    $a_title = $o_yellow_list->aTitle;
    $a_area = $o_yellow_list->aArea;
    $a_desc = $o_yellow_list->aDesc; 
    
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
        DB::insert('info_spider_links', $a_values);
    }
    
    $a_link_list = info_spider_getlink($_cur_subcatid);
    include template("info:admin/admin_spider_link");
    
//抓取内容
}else if (isset($_GET['sp_ac']) && $_GET['sp_ac'] == 'spiderContent'){
    $_cur_catid = $_GET['catid'];
    $_cur_subcatid = $_GET['subcatid'];
    
    $s_sql_link = "SELECT id,catid,cattitle,subcatid,subcattitle,title,area,summary,url "
            . "FROM pre_info_spider_links WHERE subcatid=$_cur_subcatid AND state=0 ORDER BY id asc";
    $r_result = DB::query($s_sql_link);
    $a_link_list = array();
    while($tem = DB::fetch($r_result)){
        $a_link_list[] = $tem;
    }
    $i_spider_count = 0;
    $a_config_temp = array();
    
    foreach ($a_link_list as $a_link){
        if (++$i_spider_count > $_SPIDER_CONTENT_ONCE){break;}
        
        info_spider_content_debug($a_link, $i_spider_count);
        ob_flush();
        flush();
        
        $a_config_temp['catId'] = $a_link['catid'];
        $a_config_temp['catTitle'] = $a_link['cattitle'];
        $a_config_temp['subCatId'] = $a_link['subcatid'];
        $a_config_temp['subCatTitle'] = $a_link['subcattitle'];
        $a_config_temp['area'] = $a_link['area'];
        $a_config_temp['desc'] = $a_link['summary'];
                
        $o_ypdata = new YellowPageData($a_link['url'],$a_config_temp);
        $a_values = $o_ypdata->getArrayData();
        
        DB::insert('info_post', $a_values);
        DB::update('info_spider_links', array('state'=>1), "id=$a_link[id]");
        echo '===================================================<br/><br/>';
    }
//    $a_link_list = info_spider_getlink($_cur_subcatid);
    include template("info:admin/admin_spider_content");
    
//}else if(submitcheck("doRun")){
//     
//    set_time_limit(0);
//    ini_set('memory_limit', '256M'); 
//    
//    header("Connection:Keep-Alive");
//    header("Proxy-Connection:Keep-Alive");
//    
//    error_reporting(E_ALL);
//    ini_set( 'display_errors', 'On' );
//    
//    echo "===================in===================</br>";
//    $s_url = $__links[0]['child'][0]['link'];
////    $a_link_L2 = fetchLinks($s_url,$re_2);
//    $o_yellow_list = new YellowListData($s_url);
//    $a_link_L2 = $o_yellow_list->aLink;
//    $a_area_L2 = $o_yellow_list->aArea;
//    $a_desc_L2 = $o_yellow_list->aDesc;
//    
//    $a_config_temp = array();
//    $a_config_temp['catId'] = $__links[0]['catId'];
//    $a_config_temp['catTitle'] = $__links[0]['catTitle'];
//    $a_config_temp['subCatId'] = $__links[0]['child'][0]['catId'];
//    $a_config_temp['subCatTitle'] = $__links[0]['child'][0]['catTitle'];
//    
//    $s_sql_field = 'pwd,pay_way,post_title,lang,post_text,enterprise,tel,email,member_username,address1,post_time'
//            . ',post_begin_time,post_end_time,member_uid,area_title,,cat_id,cat_title,subcat_id,subcat_title';
//    
//    for ($i=1; $i<31; $i++){
//        $s_sql_field .= ",post_img_$i";
//    }
//    
//    //$a_sql_values = array();
//    
//    for ($i=0; $i<count($a_link_L2); $i++){
//        if ($i>=1){break;}
//        print_r("$i : $a_link_L2[$i]</br>");
////        fetchContent($a_link_L2[$i]);
//        $a_config_temp['area'] = $a_area_L2[$i];
//        $a_config_temp['desc'] = $a_desc_L2[$i];
//        $o_ypdata = new YellowPageData($a_link_L2[$i],$a_config_temp,$o_yellow_list->sBaseURL);
//        $a_values = $o_ypdata->getArrayData();
//        DB::insert('info_post', $a_values);
//        //$a_sql_values[$i] = $o_ypdata->getSQL();
//        print_r('-------------------------------------</br>');
//        ob_flush();
//        flush();
//    }
//    
//    echo "</br>===================out===================";
//    include template("info:admin/admin_spider");
}else{
    $s_sql_link = 'SELECT subcatid,COUNT(1) linknum FROM pre_info_spider_links GROUP BY subcatid';
    $r_result_link = DB::query($s_sql_link);
    $a_link_num = array();
    while($tem = DB::fetch($r_result_link)){
        $a_link_num[] = $tem;
    }
    $s_sql_did = 'SELECT subcatid,COUNT(1) didnum FROM pre_info_spider_links WHERE state=1 GROUP BY subcatid';
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
    include template("info:admin/admin_spider");
}

function info_spider_getlink($cur_subcatid){
//    echo "_cur_catid:$_cur_catid||_cur_subcatid:$_cur_subcatid";
    $s_sql = "SELECT id,catid,cattitle,subcatid,subcattitle,url,title,area,summary,state "
            . "FROM pre_info_spider_links WHERE subcatid=$cur_subcatid ORDER BY state asc,time desc";
    $r_result = DB::query($s_sql);
    $a_link_list = array();
    while($tem = DB::fetch($r_result)){
        $a_link_list[] = $tem;
    }
    return $a_link_list;
}

function info_spider_content_debug($a_link,$i){
    echo "开始抓取 第 $i 条 <br/>";
    echo "标题: $a_link[title] <br/>";
    echo "URL: $a_link[url] <br/>";
    echo '-----------------------------------------------------<br/>';
}

?>


