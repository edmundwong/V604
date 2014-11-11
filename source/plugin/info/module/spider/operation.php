<?php

/**
 * 黄页列表信息解析类
 */
class YellowListData {

    public $aLink = array();
    public $aTitle = array();
    public $aArea = array();
    public $aDesc = array();
    public $aInfo = array();

    public function __construct($s_url, $a_db_urls = null) {
        $html = file_get_html($s_url);
        $a_dom_title = $html->find('a[class=title]');
        $s_area = '';
        $s_url = '';

        $i = 0;
        foreach ($a_dom_title as $dom_title) {
            $s_url = $dom_title->getAttribute('href');
            if (null != $a_db_urls && $this->isSameInArr($s_url, $a_db_urls)) {
                continue;
            }
            $this->aLink[$i] = $s_url;
            $this->aTitle[$i] = $dom_title->first_child()->innertext;
            $this->aArea[$i] = ($dom_title->next_sibling() ? $dom_title->next_sibling()->innertext : 'vancouver');
            $dom_parent_node = $dom_title->parentNode()->parentNode();
            $a_dom_info = $dom_parent_node->find('li[class=word]');
            $this->aDesc[$i] = (isset($a_dom_info[0]) ? $a_dom_info[0]->innertext : '');
            $this->aInfo[$i] = (isset($a_dom_info[1]) ? $a_dom_info[1]->innertext : '');
            $i++;
        }
    }

    /**
     * 数组中是否存在相同的地址
     * @param type $s_url
     * @param type $a_urls
     */
    public function isSameInArr($s_url, $a_urls) {
        foreach ($a_urls as $s_url_temp) {
            if ($s_url == $s_url_temp) {
                return true;
            }
        }
        return false;
    }

}

/**
 * 黄页页面信息解析类
 */
class YellowPageData {

    //原黄页信息编号
    public $vanpeople_id = '';
    //原黄页信息发布时间
    public $vanpeople_time = 0;
    //标题
    public $title = '';
    //区域
    public $area = '';
    //价格 0为面议
    public $price = 0;
    //地址
    public $addr = '';
    //联系人
    public $person = '';
    //电话1
    public $phone1 = '';
    //电话2
    public $phone2 = '';
    //QQ
    public $qq = '';
    //微信
    public $weixin = '';
    //邮箱地址
    public $email = "";
    //摘要
    public $enterprise = '';
    //内容正文
    public $content = '';
    //图片原始地址
    public $pics = array();
    //图片本地地址
    public $picsLocal = array();
    public $_config = array();
    public $_dirBase = "./data/attachment/info/spider/";
    //默认密码(后期使用UPDATE方法统一更新为此密码+postid)
    public $_pwd = '_auto';
    public $_payWay = '现金';
    public $_lang = '国语';
    public $aValues = array();

    public function __construct($s_url, $a_config = array()) {

        //保存页面号
        $this->vanpeople_id = str_replace('.html', '', basename($s_url));

        $this->_config = $a_config;
        $html = file_get_html($s_url);
        $dom_main = $html->find('div[class=side]', 0);

        //标题
        $dom_title = $dom_main->find('h1', 0);
        $this->title = $dom_title->innertext;
        echo "this->title: $this->title <br/>";

        //原黄页信息发布时间
        $dom_ep_info = $dom_main->find('div[class=ep_info]', 0);
        $s_dateinfo = $dom_ep_info->first_child()->innertext;
        $s_date = $this->getDateStrByStr($s_dateinfo);
        $this->vanpeople_time = ($s_date == 0 ? 0 : strtotime($s_date));
        echo "this->vanpeople_time:$this->vanpeople_time<br/>";

        $dom_info = $dom_main->find('div[class=ep_news]', 0);

        $dom_info_left = $dom_info->find('div[class=l]', 0);
        $a_dom_linfos = $dom_info_left->find('dt');

        //地址
        $this->addr = '';
        foreach ($a_dom_linfos as $dom_linfo) {
            if (mb_substr($dom_linfo->innertext, 0, 2, 'utf-8') == '价格') {
                $dom_price = $dom_linfo->next_sibling();
                $this->price = $this->getNum4Text($dom_price->innertext);
                continue;
            }
            if (mb_substr($dom_linfo->innertext, 0, 2, 'utf-8') == '地区') {
                $dom_area = $dom_linfo->next_sibling();
                $this->area = $dom_area->innertext;
                continue;
            }
            if (mb_substr($dom_linfo->innertext, 0, 2, 'utf-8') == '地址') {
                $dom_addr = $dom_linfo->next_sibling();
                $this->addr = $dom_addr->innertext;
                continue;
            }
        }
        echo "this->price: $this->price <br/>";
        echo "this->area: $this->area <br/>";
        echo "this->addr: $this->addr <br/>";

        $dom_info_right = $dom_info->find('div[class=r]', 0);
        $a_dom_rinfos = $dom_info_right->find('dt');

        //联系人
        $this->person = '';
        foreach ($a_dom_rinfos as $dom_rinfo) {
            if (mb_substr($dom_rinfo->innertext, 0, 3, 'utf-8') == '联系人') {
                $dom_person = $dom_rinfo->next_sibling();
                $this->person = $dom_person->innertext;
                continue;
            }
            if (mb_substr($dom_rinfo->innertext, 0, 2, 'utf-8') == '电话') {
                $dom_phone = $dom_rinfo->next_sibling();
                $this->phone1 = $dom_phone->innertext;
                continue;
            }
            if (mb_substr($dom_rinfo->innertext, 0, 2, 'utf-8') == 'QQ') {
                $dom_phone = $dom_rinfo->next_sibling();
                $this->qq = $dom_phone->innertext;
                continue;
            }
            if (mb_substr($dom_rinfo->innertext, 0, 2, 'utf-8') == '微信') {
                $dom_phone = $dom_rinfo->next_sibling();
                $this->weixin = $dom_phone->innertext;
                continue;
            }
            if (mb_substr($dom_rinfo->innertext, 0, 4, 'utf-8') == '电子邮件') {
                $dom_phone = $dom_rinfo->next_sibling();
                $this->email = $dom_phone->innertext;
                continue;
            }
        }
        echo "this->person: $this->person <br/>";
        echo "this->phone1: $this->phone1 <br/>";
        echo "this->qq: $this->qq <br/>";
        echo "this->weixin: $this->weixin <br/>";

        //电子邮件
        if ((null != $this->email) && ($this->email != '')){
            $this->email = $this->getEMailByAJAX($this->vanpeople_id, $s_url);
            echo "this->email: $this->email <br/>";
        }

        $dom_content = $dom_main->find('div[class=desc]', 0);

        //摘要
        $this->enterprise = $a_config['desc'];
        //清理无用HTML
        $this->clearHTML($dom_content);

        //保存图片路径并下载图片
        $dom_content_pics = $dom_content->find('img[src^=http://vanpeople.com/c/uploadpic]');
        $s_tmp_picpath = '';
        foreach ($dom_content_pics as $dom_pic) {
            $s_src_picpath = $dom_pic->getAttribute('src');
            $s_tmp_picpath = str_replace('vanpeople', 'www.vanpeople', $s_src_picpath);
            array_push($this->pics, $s_tmp_picpath);
            $dom_pic->parent()->outertext = '';
            $s_path = $this->_dirBase . basename($s_tmp_picpath);
            array_push($this->picsLocal, $s_path);
            echo "$s_tmp_picpath -> $s_path <br/>";
            $this->curl_download($s_tmp_picpath, $s_path);
        }

        //内容
        $this->content = trim($dom_content->innertext);
        $html->clear();
        return;
    }

    /**
     * 清理无用HTML
     * @param type $domContent
     */
    private function clearHTML($domContent) {
        //清理隐藏的HTML
        $dom_hiddens = $domContent->find('[style^=display]');
        foreach ($dom_hiddens as $dom_hidden) {
            $dom_hidden->outertext = '';
        }
        //清理内容部分图片以防重复
        $dom_imgs = $domContent->find('img[src^=uploadpic]');
        foreach ($dom_imgs as $dom_img) {
            $dom_img->outertext = '';
        }
        //描述标记
        $dom_h3s = $domContent->find('h3');
        foreach ($dom_h3s as $dom_h3) {
            if (mb_substr($dom_h3->innertext, 0, 2, 'utf-8') == '描述') {
                $dom_h3->outertext = '';
                continue;
            }
            if (mb_substr($dom_h3->innertext, 0, 2, 'utf-8') == '地图') {
                $dom_h3->next_sibling()->outertext = '';
                $dom_h3->outertext = '';
                continue;
            }
            if (mb_substr($dom_h3->innertext, 0, 2, 'utf-8') == '图片') {
                $dom_h3->outertext = '';
                continue;
            }
        }
        //附加信息
        $dom_mt = $domContent->find('p.mt', 0);
        $dom_mt->outertext = '';
    }

    private function getDateStrByStr($sStr) {
        $a_result = array();
        preg_match_all('/[0-9]{4}\/[0-9]{2}\/[0-9]{2}.[0-9]{2}:[0-9]{2}:[0-9]{2}/', $sStr, $a_result);
        if (count($a_result[0]) == 0) {
            return 0;
        } else {
            return $a_result[0][0];
        }
    }

    /**
     * 从字符串中取出数字
     * @param type $sText
     * @return int
     */
    public function getNum4Text($sText) {
        $a_result = array();
        preg_match_all('/[0-9\.]+/', $sText, $a_result);
        if (count($a_result[0]) == 0) {
            return 0;
        } else {
            return $a_result[0][0];
        }
    }

    /**
     * 从目标站获得邮件地址
     * @param type $iID     分类信息ID
     * @param type $sRefURL 伪造来源URL
     * @return type         EMAIL地址
     */
    public function getEMailByAJAX($iID, $sRefURL) {
        //http://www.vanpeople.com/c/home/ajax.html
        //param:control=show&action=email&data=1005812
        //return:{"status":true,"info":"antoine_sung@hotmail.com"}
        $url = "http://www.vanpeople.com/c/home/ajax.html";
        $data = array('control' => 'show', 'action' => 'email', 'data' => $iID);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $sRefURL);       //伪装REFERER
        curl_setopt($ch, CURLOPT_POST, 1);   //post方式提交数据
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   //返回数据，而不是直接输出
        curl_setopt($ch, CURLOPT_HEADER, 0);   // 设置是否显示header信息 0是不显示，1是显示  默认为0
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);   //发送POST数据
        $result = curl_exec($ch);    //发送HTTP请求        
        curl_close($ch);

        $a_result = array();
        preg_match_all("/[\w\-\.]+@[\w\-\.]+(\.\w+)+/", $result, $a_result);

        //这个返回值是用作判断的依据
        return $a_result[0][0];
    }

    function getArrayData() {
        $d_post_begin = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
        $d_post_end = mktime(0, 0, 0, date("m"), date("d"), date("Y") + 2);
        $i_member_uid = 0;
        $a_config = $this->_config;
        $aValues['pwd'] = $this->_pwd;
        $aValues['pay_way'] = $this->_payWay;
        $aValues['post_title'] = $this->title;
        $aValues['lang'] = $this->_lang;
        $aValues['post_text'] = $this->content;
        $aValues['enterprise'] = $this->enterprise;
        $aValues['tel'] = $this->phone1;
        $aValues['email'] = $this->email;
        $aValues['member_username'] = $this->person;
        $aValues['address1'] = $this->addr;
        $aValues['post_time'] = ($this->vanpeople_time == 0 ? time() : $this->vanpeople_time);
        $aValues['post_begin_time'] = $d_post_begin;
        $aValues['post_end_time'] = $d_post_end;
        $aValues['member_uid'] = $i_member_uid;
        $aValues['area_title'] = $a_config['area'];
        $aValues['cat_id'] = $a_config['catId'];
        $aValues['cat_title'] = $a_config['catTitle'];
        $aValues['subcat_id'] = $a_config['subCatId'];
        $aValues['subcat_title'] = $a_config['subCatTitle'];

        for ($i = 1; $i < 31; $i++) {
            $s_field_name = "post_img_$i";
            $aValues[$s_field_name] = (isset($this->picsLocal[$i - 1]) ? $this->picsLocal[$i - 1] : '');
        }

        return $aValues;
    }

    function getSQL() {
        $d_post_begin = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
        $d_post_end = mktime(0, 0, 0, date("m"), date("d"), date("Y") + 2);
        $i_member_uid = 0;
        $a_config = $this->_config;
        $i_post_time = ($this->vanpeople_time == 0 ? time() : $this->vanpeople_time);
        //qq,price,post_up,post_ip,post_ip_adr,member_title,up_endtime,loupan_id,loupan_title,subarea_title,thrarea_title,tid,post_map,subarea_id,thrarea_id,post_price,post_price_unit
        //不知道干什么用的 profile_type_id,profile_type_title
        //$s_sql = 'pwd,pay_way,post_title,lang,';
        $s_sql = "('$this->_pwd','$this->_payWay','$this->title','$this->_lang'"
                //post_text,enterprise,tel,email
                . ",'$this->content','$this->enterprise','$this->phone1','$this->email'"
                //,member_username,address1,post_time,post_begin_time,post_end_time
                . ",'$this->person','$this->addr',$i_post_time,'$d_post_begin','$d_post_end'"
                //,member_uid,,,,area_title,,cat_id,cat_title,subcat_id,subcat_title,';
                . ",$i_member_uid,'$a_config[area]',$a_config[catId],'$a_config[catTitle]',$a_config[subCatId],'$a_config[subCatTitle]'";
        for ($i = 0; $i < 30; $i++) {
            $s_pic_local = (isset($this->picsLocal[$i]) ? $this->picsLocal[$i] : '');
            $s_sql .= ",'$s_pic_local'";
        }
        $s_sql .= ')';
        //后期更新 area_id
        return $s_sql;
    }

    private function debug() {
        print_r($this);
    }

    private function doStep($CC) {
        print_r("<br/>==$CC==<br/>");
    }

    //使用 curl下载  使用代理http-equiv="X-UA-Compatible" content="IE=7"
    private function curl_download($remote, $local = "./download/") {
        if (strpos(basename($local), '.') === false)
            return false;
        if (file_exists($local)) {
            $local = trim(dirname($local), "/,\\") . '/' . rand(100000, 999999) . basename($local);
        }
        $cp = curl_init($remote);
        if (!$cp)
            return false;
        $fp = fopen($local, "w+");
        curl_setopt($cp, CURLOPT_FILE, $fp);
        curl_setopt($cp, CURLOPT_HEADER, 0);
        curl_exec($cp);
        curl_close($cp);
        fclose($fp);
        return $local;
    }

    //图片去水印 TODO
    private function picture_clean() {
        $image = imagecreatefromgif($image_URL);

        $bg = imagecolorallocate($image, 255, 255, 255);

        $font_color = imagecolorallocate($image, 41, 50, 255);

        imagefilledrectangle($image, 50, 50, 106, 106, $bg);

        imagestring($image, 5, 40, 65, "GooGle", $font_color);

        imagegif($image);
    }

}

?>