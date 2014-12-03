<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

if(!defined('IN_DISCUZ')) {exit('Access Denied');}
//检测用户是否已经登录
//if(empty($_G['uid']) ) {	showmessage($_lang['login'],'',array(),array('login' => true));}
$server_name = $_SERVER['SERVER_NAME'];
$goods_id = intval($_GET['goods_id']);
$ac = !empty($_GET['ac']) ? addslashes($_GET['ac']) : 'post';
$uid = $_G['uid'];

/**
 * 是否为邮箱地址
 * @param type $sValue
 * @return type
 */
function v604_IsEmail($sValue) {
    return strlen($sValue) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $sValue);
}

/**
 * 是否为电话号码
 * @param type $sValue
 * @return type
 */
function v604_IsPhone($sValue) {
    return strlen($sValue) == 12 && preg_match("/^\d{3}\-\d{3}\-\d{4}$/", $sValue);
}

//上传图片
if($_REQUEST['goods_file'] == 'goods_upload_file'){
    header('content-type:text/html charset:utf-8');
    $dir_base = "./data/attachment/sale/";  //文件上传根目录
    $_dir_base = "data/attachment/sale/";
    //没有成功上传文件，报错并退出。
    if(empty($_FILES)) {
        echo "<textarea><img src='{$dir_base}error.jpg'/></textarea>";
        exit;
    }
    
    $output = "";
    $index = 0;     //$_FILES 以文件name为数组下标，不适用foreach($_FILES as $index=>$file)
    
    $upload_file_name = 'goods_upload_file_' . $index;     //对应index.html FomData中的文件命名
    $filename = $_FILES[$upload_file_name]['name'];
    $gb_filename = iconv('utf-8','gb2312',$filename);   //名字转换成gb2312处理
    //文件不存在才上传
    $new_name = time().rand(1,100000);
    if(!file_exists($dir_base.$new_name.$gb_filename)) {
        $isMoved = false;  //默认上传失败
        $MAXIMUM_FILESIZE = 1 * 1024 * 1024;    //文件大小限制    1M = 1 * 1024 * 1024 B;
        $rEFileTypes = "/^\.(jpg|jpeg|gif|png){1}$/i"; 
        
        if ($_FILES[$upload_file_name]['size'] <= $MAXIMUM_FILESIZE && 
            preg_match($rEFileTypes, strrchr($gb_filename, '.'))) { 
            $isMoved = @move_uploaded_file ( $_FILES[$upload_file_name]['tmp_name'], $dir_base.$new_name.$gb_filename);     //上传文件
        }
    }else{
        $isMoved = true;    //已存在文件设置为上传成功
    }
    if($isMoved){
        //输出图片文件<img>标签
        //注：在一些系统src可能需要urlencode处理，发现图片无法显示，
        //    请尝试 urlencode($gb_filename) 或 urlencode($filename)，不行请查看HTML中显示的src并酌情解决。
        $output = $_dir_base.$new_name.$filename;
        //$output .= "<img src='{$dir_base}{$new_name}{$filename}' title='{$filename}' alt='{$filename}'/>";
    }else {
        $output = '';
        //$output .= "<img src='{$dir_base}error.jpg' title='{$filename}' alt='{$filename}'/>";
    }

    $index++;
        
    exit($output);
}

//删除上传图片
if($_REQUEST['goods_file'] == 'del_upfile'){
    $post_id = trim($_REQUEST['post_id']);
    $img = trim($_REQUEST['img']);
    $img = './'.$img;
    @unlink($img);
    exit(json_encode("1"));
}


$goods = fetch_all('sale_goods'," WHERE goods_id='{$goods_id}'");
$goods = $goods[0];

$cat = fetch_all("sale_cat"," WHERE cat_status='1' ORDER BY cat_sort DESC ");

if(isset($_REQUEST['classid']) && trim($_REQUEST['classid'])){
    $cat_id2 = trim($_REQUEST['classid']);
    $dcj_cat2 = DB::fetch(DB::query("select * from pre_sale_cat where `cat_id` = '{$cat_id2}' "));
    if($cat_id2 != '45'){
        $dcj_cat1 = DB::fetch(DB::query("select * from pre_sale_cat where `cat_id` = '{$cat_id2['cat_pid']}' "));    
    }
    $_a_sale_area = array();
    $sale_area_result = DB::query("select id,`name` from pre_sale_area where `level` = 1 order by displayorder asc");
    while($a_r = DB::fetch($sale_area_result)){
            $_a_sale_area[] = $a_r;
    }
}

$member = fetch_all('sale_member'," WHERE member_uid='{$uid}'");
$member = $member[0];

$my_credit = fetch_all("common_member_count"," WHERE uid='{$uid}'"," extcredits{$sale_config['extcredits']} ","0");
$my_credit = $my_credit["extcredits{$sale_config['extcredits']}"];
//var_dump(submitcheck('post_submit'));var_dump(submitcheck('edit_submit'));exit;
if(submitcheck('post_submit') || submitcheck('edit_submit')){
//    error_reporting(E_ALL);
    //所属区域是否为空
    if (empty($_GET['province']) && $ac == 'post') {
        showmessage($_lang['must_province']);
    }
    
    //内容是否为空
    $_GET['goods_text'] = $_GET['editorValue'];
    if (empty($_GET['goods_text'])) {
        showmessage($_lang['must_goods_text']);
    }
    
    //物品价格是否为空
    if (empty($_GET['goods_price'])) {
        $_GET['goods_price'] = 0;
    }
    
    //联系人是否为空
    if (empty($_GET['member_username'])) {
        showmessage($_lang['must_member_username']);
    }
    
    //联系电话是否为空
    if (empty($_GET['member_phone'])) {
        showmessage($_lang['must_member_phone']);
    //联系电话是否有效
    }else if (!v604_IsPhone($_GET['member_phone'])){
        showmessage("联系电话无效，请重新输入！例如：888-888-8888");
    }
    
    //电子邮箱是否为空
    if (empty($_GET['member_email'])) {
        showmessage($_lang['must_member_phone']);
    //电子邮箱是否有效
    }else if (!v604_IsEmail($_GET['member_email'])){
        showmessage('电子邮件无效，请重新输入！邮件格式：test@van604.com');
    }
    
    $goods_array = gpc('goods_');
    $_member = gpc('member_');
    
    
    $_member['member_uid'] = $_G['uid'];
    if($_REQUEST['huodong_star_time']){
            $goods_array['huodong_star_time'] = strtotime($_REQUEST['huodong_star_time'].' '.$_REQUEST['star_hour'].':'.$_REQUEST['star_fen'].':00');
    }
    if($_REQUEST['huodong_end_time']){
            $goods_array['huodong_end_time'] = strtotime($_REQUEST['huodong_end_time'].' '.$_REQUEST['end_hour'].':'.$_REQUEST['end_fen'].':00');
    }
    
    if($goods_array['goods_settime'] != 0){
        if($goods_array['goods_settime'] == 7){
            $goods_array['goods_settime'] = strtotime("+7 days");
        }elseif($goods_array['goods_settime'] == 30){
            $goods_array['goods_settime'] = strtotime("+30 days");
        }elseif($goods_array['goods_settime'] == 90){
            $goods_array['goods_settime'] = strtotime("+90 days");
        }elseif($goods_array['goods_settime'] == 180){
            $goods_array['goods_settime'] = strtotime("+180 days");
        }
    }else{
        $goods_array['goods_settime'] = 0;
    }
    
    if($ac=='post'){
        $goods_array['goods_ip'] = $_SERVER["REMOTE_ADDR"];
        $ip_xml = file_get_contents("http://www.youdao.com/smartresult-xml/search.s?type=ip&q={$goods_array['goods_ip']}");
        preg_match_all("/<location>(.*?)<\/location>/i",$ip_xml,$m);
        $goods_array['goods_ip_adr'] = $m[1][0];
    }

    /* begin:cat+subcat */
    if( !empty($_GET['cat'])){
        list($goods_array['cat_id'],$goods_array['cat_title']) = explode('-', addslashes($_GET['cat']));
         $aa= DB::fetch(DB::query("select * from pre_sale_cat where `cat_id` = '{$_GET['cat']}' "));
         $goods_array['cat_title'] = $aa['cat_title'];
    }
    
    if( !empty($_GET['subcat'])){
        list($goods_array['subcat_id'],$goods_array['subcat_title']) = explode('-',addslashes($_GET['subcat']));
        $bb= DB::fetch(DB::query("select * from pre_sale_cat where `cat_id` = '{$_GET['subcat']}' "));
         $goods_array['subcat_title'] = $bb['cat_title'];        
    }
    /* end:cat+subcat */
    
    if(!empty($_GET['province'])){
        $goods_array['province'] = daddslashes($_GET['province']) ; 
        $goods_array['city'] = daddslashes($_GET['city']) ; 
        $goods_array['dist'] = daddslashes($_GET['dist']) ; 
        $goods_array['community'] = daddslashes($_GET['community']) ; 
    }
    
    if($ac =='post'){
        $goods_array['member_uid'] = $_member['member_uid'];
        $goods_array['member_username'] = $_member['member_username'];
    }
    
    /* require_once DISCUZ_ROOT.'./source/plugin/sale/include/update_class.func.php'; */
    /* $goods_upload_file_array = array('goods_upload_file_1','goods_upload_file_2','goods_upload_file_3','goods_upload_file_4');
    foreach($goods_upload_file_array as $file_name){
        if($_FILES[$file_name]['size']){
            $goods_array[$file_name] = upload_image($file_name,'sale','600','600',0);
            // @$goods_array[$file_name] = upload_file($file_name,'sale'); 
        }
    }*/
    for($i=0;$i<30;$i++)
    {
        $now_name = 'goods_upload_file_'.($i+1);
        $goods_array[$now_name] = $_REQUEST['goods_upload_file_'][$i] ? $_REQUEST['goods_upload_file_'][$i] : '';
    }
    unset($goods_array['goods_upload_file_']);
    //var_dump($goods_array);exit;
    
    if($ac =='post'){
        $goods_array['goods_time'] = time();
    }
    
    if($sale_config['auto_pass']){
        $goods_array['goods_status']='1';
    }

    $goods_array['goods_price'] = $_REQUEST['goods_price'];
    
    $goods_array['goods_selltype_sell'] = !empty($goods_array['goods_selltype_sell']) ? "1" : "0";
    $goods_array['goods_selltype_swap'] = !empty($goods_array['goods_selltype_swap']) ? "1" : "0";
    $goods_array['goods_selltype_give'] = !empty($goods_array['goods_selltype_give']) ? "1" : "0";
    $goods_array['pwd'] = rand(1000,9999);
    
    if($ac =='post'){
        $goods_id = DB::insert('sale_goods',$goods_array,$goods_id = true);

        $add_post = array('sale_goods_id' => $goods_id,'member_username' => trim($_REQUEST['member_username']),'member_qq' => trim($_REQUEST['member_qq']),'member_phone' => trim($_REQUEST['member_phone']),'member_time' => time(),'member_email' => trim($_REQUEST['member_email']));
        DB::insert('sale_member',$add_post);
        //var_dump($add_post);exit;
            /*if($ac =='post'){
                $_member['sale_goods_id'] = $goods_id;
                var_dump($_member);exit;
                if($member['sale_goods_id']){

                    DB::update('sale_member',$_member,"sale_goods_id='{$goods_id}'");
                }else{
                    DB::insert('sale_member',$_member);
                }
            }*/
        //var_dump($sale_config['fid']);exit;
        if($sale_config['fid']){
            $bbs = array();
            $bbs['fid'] = $sale_config['fid'];
            $bbs_goods_price = !empty($goods_array['price']) ? "&yen;".$goods_array['price'] : $_lang['mianyi'];
            $bbs['title'] = "[{$bbs_goods_price}]".$goods_array['goods_title'];
            $bbs['text'] = "
                    [table]
                    [tr]
                    [td]{$_lang['xinxixiangqing']} : [/td]
                    [td][url]{$sale_config['root']}?mod=view&goods_id={$goods_id}[/url]
                    [/td]
                    [/tr]
                    [tr]
                    [td]{$_lang['area']} : [/td]
                    [td]{$goods_array['province']} {$goods_array['city']} {$goods_array['dist']} {$goods_array['community']}
                    [/td]
                    [/tr]
                    [tr]
                    [td=2,0,0]{$goods_array['goods_text']}
                    [/td]
                    [/tr]
                    [/table]";
            $tid = bbs_post($bbs);
            DB::update("sale_goods",array("tid"=>$tid)," goods_id='{$goods_id}'");
        }
        //var_dump($sale_config['root']."?mod=view&goods_id={$goods_id}");exit;
        $new_url = $_SERVER['SERVER_NAME']."?mod=view&goods_id={$goods_id}&pwd=check";
        $new_url1 = $sale_config['root']."?mod=view&goods_id={$goods_id}&pwd=check";
        $edit_url = "sale.php?mod=post&ac=edit&goods_id={$goods_id}&pwd=check";
        include template("sale:{$style}/member_dcj");//显示发布信息之后的提示页面需要审核
        exit;
        //showmessage($_lang['post_ok'],$sale_config['root']."?mod=view&goods_id={$goods_id}");

    }elseif($ac =='edit'){
        unset($goods_array['goods_upload_file']);
        unset($goods_array['pwd']);
        DB::update('sale_goods',$goods_array,"goods_id='{$goods_id}'");
        $add_post = array('member_username' => trim($_REQUEST['member_username']),'member_qq' => trim($_REQUEST['member_qq']),'member_phone' => trim($_REQUEST['member_phone']),'member_time' => time(),'member_email' => trim($_REQUEST['member_email']));
        DB::update('sale_member',$_member,"sale_goods_id='{$goods_id}'");


        $goods_array['tid'] = intval($_GET['tid']);
        if($sale_config['fid'] && $goods_array['tid']){
            $bbs = array();
            $bbs['tid'] = $goods_array['tid'];
            $bbs_goods_price = !empty($goods_array['price']) ? "&yen;".$goods_array['price'] : $_lang['mianyi'];
            $bbs['title'] = "[{$bbs_goods_price}]".$goods_array['goods_title'];
                $bbs['text'] = "
                [table]
                [tr]
                [td]{$_lang['xinxixiangqing']} : [/td]
                [td][url]{$sale_config['root']}?mod=view&goods_id={$goods_id}[/url]
                [/td]
                [/tr]
                [tr]
                [td]{$_lang['area']} : [/td]
                [td]{$goods['province']} {$goods['city']} {$goods['dist']} {$goods['community']}
                [/td]
                [/tr]
                [tr]
                [td=2,0,0]{$goods_array['goods_text']}
                [/td]
                [/tr]
                [/table]";
            bbs_edit($bbs);
        }
        
        showmessage($_lang['edit_ok'],$sale_config['root']."?mod=view&goods_id={$goods_id}");
    }


}else{
    if($ac == 'edit' && $_REQUEST['pwd'] == 'check'){
        include template("sale:{$style}/member_dcj_pwd_check");//显示发布信息之后的提示页面需要审核
        exit;
    }
    
    if($_REQUEST['ac'] == 'check' && $_REQUEST['goods_id'] > 1){
        $post_pwd = trim($_REQUEST['post_pwd']);
        if(!$post_pwd){
            showmessage("密码不能为空！","sale.php?mod=post&ac=edit&goods_id=".$_REQUEST['goods_id']."&pwd=check");
        }
        
        $sale_cat_result = DB::query("select * from pre_sale_goods where `goods_id` = '{$_REQUEST['goods_id']}' ");
        $a_c = DB::fetch($sale_cat_result);
        
        if($a_c['member_uid'] > 0)
        {
            $member_re = DB::fetch(DB::query("select * from pre_ucenter_members where `uid` = '{$a_c['member_uid']}' "));
           if($uid > 0)
            {
                if($a_c['member_uid'] != $uid)
                {
                    showmessage("该信息不是您发布的所以您不能修改！");
                }
               
            }
             if($member_re['password'] != md5(md5($post_pwd).$member_re['salt']))
                {
                    if($post_pwd !=  $a_c['pwd'])
                    {
                        showmessage("您输入的信息密码不对！");
                    }
                }
        }
        else
        {
            //判断信息密码是否正确
            if($post_pwd != $a_c['pwd'])
            {
                showmessage("您输入的信息密码不对！");
            }
        }
        
        header("Location:"."/sale.php?mod=post&ac=edit&goods_id=".$a_c['goods_id']);exit;
    }
}

$navtitle = $_lang['post'].' - '.$sale_config['name'];
$op= 'post';
for($i=0;$i<30;$i++){
    $new_name = 'goods_upload_file_'.($i+1);
    if($goods[$new_name]){
        $sale_goods_img[$i]['img'] = $goods[$new_name];
        $sale_goods_img[$i]['goods_id'] = $goods['goods_id'];
    }
}
$s_time = date('Y-m-d',$goods['huodong_star_time']);
$s_hour = date('H',$goods['huodong_star_time']);
$s_fen = date('i',$goods['huodong_star_time']);
$s_miao = date('s',$goods['huodong_star_time']);

$e_time = date('Y-m-d',$goods['huodong_end_time']);
$e_hour = date('H',$goods['huodong_end_time']);
$e_fen = date('i',$goods['huodong_end_time']);
$e_miao = date('s',$goods['huodong_end_time']);
//echo "sale:{$style}/member";exit;
$cat_id2 = $cat_id2? $cat_id2:$goods['subcat_id'];
include template("sale:{$style}/member");
?>
