<?php

require_once DISCUZ_ROOT . './source/plugin/sale/module/spider/simple_html_dom_1_5.php';
require_once DISCUZ_ROOT . './source/plugin/sale/module/spider/operation.php';
require_once DISCUZ_ROOT . './source/plugin/sale/module/spider/config.php';

/**
 * 分类信息自动抓取类
 */
class SaleAutoSpider {
    private $_s_log_filename = '_sale_spider.txt';
    private $_s_log_filepath = './data/log/';
    private $_i_wait_second = 1;
    //日志信息
    private $_a_log_msg = array();
    
    public function __construct() {
        $this->_a_log_msg[] = '-------------------------'.date('Y-m-d H:i:s').'-------------------------';
    }
    
    public function doRun() {
        set_time_limit(0);
        global $__links;
        
        $this->_a_log_msg[] = "start spiderLink:";
        //更新所有最新链接
        foreach ($__links as $o_link_key => $o_link_value) {
            foreach ($o_link_value['child'] as $o_sublink_key => $o_sublink_value) {
                $this->doSpiderLink($o_link_key, $o_sublink_key);
            }
        }
        
        $this->_a_log_msg[] = 'start spiderContent:';
        //抓取所有页面数据
        $this->doSpiderContent();
        
        $this->writeLog();
    }
    
    
    /**
     * 抓取页面数据
     */
    private function doSpiderContent() {
        $s_log_msg = '';
        $s_sql_link = 'SELECT id,catid,cattitle,subcatid,subcattitle,title,area,summary,url '
                . 'FROM pre_sale_spider_links WHERE state=0 ORDER BY id asc';
        $r_result = DB::query($s_sql_link);
        $a_link_list = array();
        while ($tem = DB::fetch($r_result)) {
            $a_link_list[] = $tem;
        }
        
        $a_config_temp = array();
        foreach ($a_link_list as $a_link) {
            $a_config_temp['catId'] = $a_link['catid'];
            $a_config_temp['catTitle'] = $a_link['cattitle'];
            $a_config_temp['subCatId'] = $a_link['subcatid'];
            $a_config_temp['subCatTitle'] = $a_link['subcattitle'];
            $a_config_temp['area'] = $a_link['area'];
            $a_config_temp['desc'] = $a_link['summary'];
                        
            $o_operation = new SalePageData($a_link['url'], $a_config_temp);

            $a_goods_values = $o_operation->getArrayData();
            $s_goods_id = DB::insert('sale_goods', $a_goods_values, $s_goods_id = true);

            $a_member_values = $o_operation->getUserDataArr($s_goods_id);
            DB::insert('sale_member', $a_member_values);

            DB::update('sale_spider_links', array('state' => 1), "id=$a_link[id]");
            
            //日志
            $s_log_time = date('H:i:s');
            $s_log_msg = "[$s_log_time] id:$s_goods_id,catid:$a_link[subcatid],title:$a_link[title]";
            $this->_a_log_msg[] = $s_log_msg;
            
            //暂停N秒
            sleep($this->_i_wait_second);
        }
    }
    
    /**
     * 爬取指定分类的链接信息
     * @global type $__links
     * @param type $i_catid
     * @param type $i_subcatid
     */
    private function doSpiderLink($i_catid, $i_subcatid) {
        global $__links;
        //获得子分类
        $s_cattitle = $__links[$i_catid]['title'];
        $s_subcattitle = $__links[$i_catid]['child'][$i_subcatid]['title'];
        $s_url = $__links[$i_catid]['child'][$i_subcatid]['link'];
        
        $s_sql = "SELECT url FROM pre_sale_spider_links WHERE subcatid=$i_subcatid";
        //是否已经存在于表中->抓取链接
        $r_result = DB::query($s_sql);
        $a_link_list = array();
        while ($tem = DB::fetch($r_result)) {
            $a_link_list[] = $tem['url'];
        }
        $o_sale_list = new SaleListData($s_url, $a_link_list);
        $a_link = $o_sale_list->aLink;
        $a_title = $o_sale_list->aTitle;
        $a_area = $o_sale_list->aArea;
        $a_desc = $o_sale_list->aDesc;
        
        //入库
        $a_values = array();
        for ($i = 0; $i < count($a_link); $i++) {
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
        
        //增加日志
        $s_log_time = date('H:i:s');
        $i_log_value1 = count($a_link);
        $this->_a_log_msg[] = "[$s_log_time] $s_cattitle -> $s_subcattitle ($i_log_value1)";
    }

    /**
     * 记录日志
     */
    private function writeLog(){
        $s_log = '';
        foreach ($this->_a_log_msg as $s_log_msg){
            $s_log .= "$s_log_msg \r\n";
        }
        
	$s_pre_filename = date('YmdHi');
        $s_file_path = DISCUZ_ROOT . $this->_s_log_filepath.$s_pre_filename.$this->_s_log_filename;
        
        if($fd = @fopen($s_file_path, "a")) {
            fputs($fd, $s_log);
            fclose($fd);
        }
        
    }
}
?>