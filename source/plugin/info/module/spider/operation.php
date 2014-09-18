<?php

class YellowListData {

    public $aLink = array();
    public $aTitle = array();
    public $aArea = array();
    public $aDesc = array();
    public $sBaseURL = '';

    public function __construct($s_url, $a_db_urls = null) {
        $html = file_get_html($s_url);
        $a_dom_title = $html->find('a[class=list_title]');
        //URL补全
        $i_pos = strripos($s_url, '/');
        $this->sBaseURL = substr($s_url, 0, $i_pos + 1);
        $s_area = '';
        $s_url = '';
        $i = 0;
        foreach ($a_dom_title as $dom_title) {
            $s_url = $this->sBaseURL . $dom_title->getAttribute('href');
            if (null != $a_db_urls && $this->isSameInArr($s_url, $a_db_urls)) {
                continue;
            }
            $this->aLink[$i] = $s_url;
            $this->aTitle[$i] = $dom_title->first_child()->innertext;
            $s_area = $dom_title->next_sibling()->innertext;
            $this->aArea[$i] = ($s_area == '' ? 'vancouver' : $s_area);
            $this->aDesc[$i] = $dom_title->next_sibling()->next_sibling()->first_child()->innertext;
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
 * 
 */
class YellowPageData {

    //标题
    public $title = '';
    //地址
    public $addr = '';
    //联系人
    public $person = '';
    //电话1
    public $phone1 = '';
    //电话2
    public $phone2 = '';
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

    function __construct($s_url, $a_config = array(), $s_base_url = '') {
        if ($s_base_url == '') {
            $i_pos = strripos($s_url, '/');
            $s_base_url = substr($s_url, 0, $i_pos + 1);
        }
//		$html = new simple_html_dom();
//		$html->load_file($s_url);
        $this->_config = $a_config;
        $html = file_get_html($s_url);
//              $html->str_get_html($s_url);
        $dom_main = $html->find('div[id=content]', 0);

        //标题
        $dom_title = $dom_main->find('div[class=detail_title]', 0);
        $dom_caption = $dom_title->find('h1', 0);
        $this->title = $dom_caption->innertext;

        $dom_info_left = $dom_main->find('div[class^=detal_left border_right]', 0);
        $a_dom_linfos = $dom_info_left->find('dt');

        //地址
        $this->addr = '';
        foreach ($a_dom_linfos as $dom_linfo){
            if (mb_substr($dom_linfo->innertext,0,2,'utf-8') == '地址'){
                $dom_addr = $dom_linfo->next_sibling();
                $this->addr = $dom_addr->innertext;
                break;
            }
        }
        echo "this->addr: $this->addr <br/>";
        
        $dom_info_right = $dom_main->find('div[class=detail_info2]', 0);
        $a_dom_rinfos = $dom_info_right->find('dt');

        //联系人
        $this->person = '';
        foreach ($a_dom_rinfos as $dom_rinfo){
            if (mb_substr($dom_rinfo->innertext,0,3,'utf-8') == '联系人'){
                $dom_person = $dom_rinfo->next_sibling();
                $this->person = $dom_person->innertext;
                break;
            }
        }
        echo "this->person: $this->person <br/>";
        
        $a_dom_phones = $dom_info_right->find('dd[class=phoneNum]');
        //电话1
        $this->phone1 = (isset($a_dom_phones[0])?$a_dom_phones[0]->innertext:'');
        echo "this->phone1: $this->phone1 <br/>";
        //电话2
        $this->phone2 = (isset($a_dom_phones[1])?$a_dom_phones[1]->innertext:'');
        echo "this->phone2: $this->phone2 <br/>";
        
        //电子邮件
        //邮箱地址为图片，需要正则取出
        //<img src="http://www.vanpeople.com/test/emailToImg.php?text=yonghefamily@gmail.com">
        $this->email = '';
        foreach ($a_dom_rinfos as $dom_rinfo){
            if (mb_substr($dom_rinfo->innertext,0,4,'utf-8') == '电子邮件'){
                //图片标签节点
                $dom_email = $dom_rinfo->next_sibling()->first_child()->first_child();
                $this->email = $dom_email->getAttribute('src'); //$dom_email->innertext;
                $re_email = '/(\w)+(\.\w+)*@(\w)+((\.\w+)+)/';
                $result = array();
                preg_match($re_email, $this->email, $result);
                $this->email = (count($result)>=1?$result[0]:'');
                break;
            }
        }
        echo "this->email: $this->email <br/>";
//        
//        if (isset($a_dom_info[3])){
//            $this->email = $a_dom_info[3]->innertext;
//            $re_email = '/(\w)+(\.\w+)*@(\w)+((\.\w+)+)/';
//            preg_match($re_email, $this->email, $result);
//            echo "this->email:$this->email <br/>";
//            print_r("result:$result");
//            $this->email = (count($result)>=1?$result[0]:'');
//        }else{
//            $this->email = '';
//        }
        
        $dom_content = $dom_main->find('div[class=mainBox detailInfo]', 1);

        //摘要
        $this->enterprise = $a_config['desc'];
        
        //下载图片
        $i = 0;
        $a_tag_pic = $dom_content->find('img[src^=uploadpic/hy/]');
        foreach ($a_tag_pic as $key => $value) {
            $s_path = $a_tag_pic[$key]->outertext;
            $re_pic_path = '/uploadpic\/hy\/\d{6}\/+\d+\.[a-zA-Z]{2,5}/';
            preg_match($re_pic_path, $s_path, $a_paths);
            $this->pics[$i] = $s_base_url . $a_paths[0];
            $s_path = $this->_dirBase . basename($a_paths[0]);
            $a_tag_pic[$key]->setAttribute('src', $s_path);
            $this->picsLocal[$i] = $s_path;
            curl_download($this->pics[$i], $s_path);
            $i++;
        }
        
        $dom_desc_title = $dom_content->find('p[class=mainBox_Ct]',0);
        $dom_desc_title->innertext = '';
        $dom_desc_title->outertext = '';
        
        //内容
        $this->content = $dom_content->innertext;
        return;
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
        $aValues['post_time'] = time();
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
        //qq,price,post_up,post_ip,post_ip_adr,member_title,up_endtime,loupan_id,loupan_title,subarea_title,thrarea_title,tid,post_map,subarea_id,thrarea_id,post_price,post_price_unit
        //不知道干什么用的 profile_type_id,profile_type_title
        //$s_sql = 'pwd,pay_way,post_title,lang,';
        $s_sql = "('$this->_pwd','$this->_payWay','$this->title','$this->_lang'"
                //post_text,enterprise,tel,email
                . ",'$this->content','$this->enterprise','$this->phone1','$this->email'"
                //,member_username,address1,post_time,post_begin_time,post_end_time
                . ",'$this->person','$this->addr','" . time() . "','$d_post_begin','$d_post_end'"
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

    function debug() {
        print_r($this);
    }

}

function doStep($CC) {
    print_r("<br/>==$CC==<br/>");
}

//使用 curl下载  使用代理http-equiv="X-UA-Compatible" content="IE=7"
function curl_download($remote, $local = "./download/") {
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
function picture_clean() {
    $image = imagecreatefromgif($image_URL);

    $bg = imagecolorallocate($image, 255, 255, 255);

    $font_color = imagecolorallocate($image, 41, 50, 255);

    imagefilledrectangle($image, 50, 50, 106, 106, $bg);

    imagestring($image, 5, 40, 65, "GooGle", $font_color);

    imagegif($image);
}

?>