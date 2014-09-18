<?php
//error_reporting(E_ALL);
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

//if(empty($_G['uid']) ) {	showmessage($info_lang['login'],'',array(),array('login' => true));}

$post_id = intval($_GET['post_id']);
$ac = !empty($_GET['ac']) ? addslashes($_GET['ac']) : 'post';

$my_credit = fetch_all("common_member_count", " WHERE uid='{$_G['uid']}'", " extcredits{$info_config['extcredits']} ", "0");
$my_credit = $my_credit["extcredits{$info_config['extcredits']}"];

$info_temp_area = fetch_all('info_area', " where 1=1 ");
foreach ($info_temp_area as $k1 => $v1) {
    $info_temp_area[$k1]['va'] = $v1['area_id'] . '@@' . $v1['area_title'];
}


if (!empty($post_id)) {
    $post = fetch_all('info_post', " WHERE post_id='{$post_id}'", "*", 0);
    $_GET['subcat_id'] = $post['subcat_id'];
}

//实现图片的上传
if ($_REQUEST['file'] == 'upfile') {
    header('content-type:text/html charset:utf-8');
    $dir_base = "./data/attachment/info/";  //文件上传根目录
    $_dir_base = "data/attachment/info/";
    //没有成功上传文件，报错并退出。
    if (empty($_FILES)) {
        //echo "<textarea><img src='{$dir_base}error.jpg'/></textarea>";
        echo '';
        exit;
    }

    $output = "";
    $index = 0;  //$_FILES 以文件name为数组下标，不适用foreach($_FILES as $index=>$file)
    //foreach($_FILES as $file){
    $upload_file_name = 'upload_file' . $index;  //对应index.html FomData中的文件命名
    $filename = $_FILES[$upload_file_name]['name'];
    $gb_filename = iconv('utf-8', 'gb2312', $filename); //名字转换成gb2312处理
    //文件不存在才上传
    $new_name = time() . rand(1, 100000);
    if (!file_exists($dir_base . $new_name . $gb_filename)) {
        $isMoved = false;  //默认上传失败
        $MAXIMUM_FILESIZE = 1 * 1024 * 1024;  //文件大小限制	1M = 1 * 1024 * 1024 B;
        $rEFileTypes = "/^\.(jpg|jpeg|gif|png){1}$/i";
        //$isMoved = @move_uploaded_file ( $_FILES[$upload_file_name]['tmp_name'], $dir_base.$new_name.$gb_filename);	
        if ($_FILES[$upload_file_name]['size'] <= $MAXIMUM_FILESIZE &&
                preg_match($rEFileTypes, strrchr($gb_filename, '.'))) {
            $isMoved = @move_uploaded_file($_FILES[$upload_file_name]['tmp_name'], $dir_base . $new_name . $gb_filename);  //上传文件
        }
    } else {
        $isMoved = true; //已存在文件设置为上传成功
    }
    if ($isMoved) {
        //输出图片文件<img>标签
        //注：在一些系统src可能需要urlencode处理，发现图片无法显示，
        //    请尝试 urlencode($gb_filename) 或 urlencode($filename)，不行请查看HTML中显示的src并酌情解决。
        $output = $_dir_base . $new_name . $filename;
        //$output .= "<img src='{$dir_base}{$new_name}{$filename}' title='{$filename}' alt='{$filename}'/>";
    } else {
        $output = '';
        //$output .= "<img src='{$dir_base}error.jpg' title='{$filename}' alt='{$filename}'/>";
    }

    $index++;
    //}
    exit($output);
    //echo $output."</textarea>";
}

if ($_REQUEST['file'] == 'del_upfile') {
    $post_id = trim($_REQUEST['post_id']);
    $img = trim($_REQUEST['img']);
    $img = './' . $img;
    @unlink($img);
    exit(json_encode("1"));
}

$subcat_id = intval($_GET['subcat_id']);
$subcat_title = $cat_array[$subcat_id]['cat_title'];
if (empty($subcat_id) && $ac != 'edit') {
    //echo $info_config['root']."?mod=select";exit;
    header("location:" . $info_config['root'] . "?mod=select");
    header("location:" . "/info.php?mod=select");
}
//var_dump($ac);exit;
//echo "1111111";exit;
$profile_type_id = $cat_array[$subcat_id]['cat_mod_id'];

if (!empty($profile_type_id)) {
    $profile_setting = get_profile_setting($profile_type_id);
    $profile_type_title = get_profile_type_title($profile_type_id);
    $profile_type_setting = get_profile_type_setting($profile_type_id);
    $profile_type_jiage = get_profile_type_jiage($profile_type_id);
}

$post['post_map'] = !empty($post['post_map']) ? $post['post_map'] : $info_config['google_map'];

if (submitcheck('button_post_submit') || submitcheck('button_edit_submit')) {
//var_dump($_REQUEST);exit;
    //var_dump($_GET['post_text']);var_dump($_GET['post_title']);var_dump();exit;
    if (empty($_GET['post_text']) || empty($_GET['post_title'])) {
       showmessage($info_lang['must_post']);
    }

    //var_dump($post_array['pwd']);exit;
    //$post_array['enterprise']    
    if ($ac == 'post' && $info_config['postcredit'] > 0) {
        $new_credit = $my_credit - $info_config['postcredit'];
        if ($new_credit < 0) {
            showmessage($info_lang['post'] . $info_config['credit_unit'] . $info_lang['not_credit']);
        } else {
            updatemembercount($_G['uid'], array($info_config['extcredits'] => -$info_config['postcredit']), 1, '', '', '', $info_lang['fabu_koufei'], $info_config['name'] . ": <a href='{$info_config['root']}?mod=member' target='_blank'>{$info_lang['about_info']}</a>"
            );
        }
    }

    //var_dump($_REQUEST['enterprise']);exit;
    $post_array = gpc('post_');
    if (!empty($_GET['area'])) {
        list($post_array['area_id'], $post_array['area_title']) = explode('@@', addslashes(htmlspecialchars($_GET['area'])));
    }

    if (!empty($_GET['subarea'])) {
        list($post_array['subarea_id'], $post_array['subarea_title']) = explode('@@', addslashes(htmlspecialchars($_GET['subarea'])));
    }

    if (!empty($_GET['thrarea'])) {
        list($post_array['thrarea_id'], $post_array['thrarea_title']) = explode('@@', addslashes(htmlspecialchars($_GET['thrarea'])));
    }

    if (!empty($_GET['cat'])) {
        list($post_array['cat_id'], $post_array['cat_title']) = explode('@@', addslashes(htmlspecialchars($_GET['cat'])));
    }
    //var_dump($_GET['subcat']);exit;
    if (!empty($_GET['subcat'])) {
        list($post_array['subcat_id'], $post_array['subcat_title']) = explode('@@', addslashes(htmlspecialchars($_GET['subcat'])));
    }

    /* 	$post_array['post_begin_time'] = strtotime($post_array['post_begin_time']);
      $post_array['post_end_time'] = strtotime($post_array['post_end_time']); */

    if ($ac == 'post') {
        $post_array['member_uid'] = $_G['uid'];
    }

    /* foreach($_REQUEST['up_file'] as $k => $v)
      {
      $now_name = 'post_img_'.($k+1);
      $post_array[$now_name] = $v;
      } */
    for ($i = 0; $i < 30; $i++) {
        $now_name = 'post_img_' . ($i + 1);
        $post_array[$now_name] = $_REQUEST['up_file'][$i] ? $_REQUEST['up_file'][$i] : '';
    }
    
    //var_dump($_REQUEST['up_file']);exit;
    /* $post_upload_file_array = array('post_img_1','post_img_2','post_img_3','post_img_4');
      foreach($post_upload_file_array as $file_name){
      if($_FILES[$file_name]['size']){
      @$post_array[$file_name] = upload_image($file_name,'info',"600","400");
      }
      } */
    ////////////var_dump($post_array);exit;
    $post_array['enterprise'] = $_REQUEST['enterprise'];
    //var_dump($post_array);exit;
    $post_array['profile_type_id'] = $profile_type_id;
    $post_array['profile_type_title'] = $profile_type_title;

    if (!empty($_GET['profile_setting_' . $profile_type_jiage])) {
        //$post_array['post_price'] = addslashes($_GET['profile_setting_'.$profile_type_jiage]);
        //$post_array['post_price_unit'] = $profile_setting[$profile_type_jiage]['profile_setting_unit'];
    }
    $post_array['member_username'] = trim($_REQUEST['member_username']);
    $post_array['address1'] = trim($_REQUEST['address1']);
    $post_array['tel'] = trim($_REQUEST['member_phone']);
    $post_array['qq'] = trim($_REQUEST['member_qq']);
    $post_array['email'] = trim($_REQUEST['member_email']);
    if ($ac == 'post') {
        $lang = '';
        if ($_REQUEST['lang']) {
            $post_array['lang'] = implode(' ', $_REQUEST['lang']);
        }

        $dcj_pwd = '';
        for ($i = 0; $i < 6; $i++) {
            $dcj_pwd.=strtolower(chr(mt_rand(65, 90)));
        }
        $post_array['pwd'] = $dcj_pwd;
        $post_array['post_time'] = time();


        $post_id = DB::insert('info_post', $post_array, $post_id = true);
        foreach ($profile_setting as $v) {
            if ($v['profile_setting_formtype'] == 'checkbox') {
                $_GET['profile_setting_' . $v['profile_setting_name']] = serialize($_GET['profile_setting_' . $v['profile_setting_name']]);
            }
            DB::insert("info_post_profile", array('post_id' => $post_id, 'profile_setting_name' => $v['profile_setting_name'], 'profile_setting_title' => $v['profile_setting_title'], 'post_profile_title' => addslashes($_GET['profile_setting_' . $v['profile_setting_name']])));
        }
    } elseif ($ac == 'edit') {
        DB::update('info_post', $post_array, "post_id='{$post_id}'");
        foreach ($profile_setting as $v) {
            if ($v['profile_setting_formtype'] == 'checkbox') {
                $_GET['profile_setting_' . $v['profile_setting_name']] = serialize($_GET['profile_setting_' . $v['profile_setting_name']]);
            }
            DB::update("info_post_profile", array('post_profile_title' => addslashes($_GET['profile_setting_' . $v['profile_setting_name']])), " post_id='{$post_id}' AND  profile_setting_name = '{$v['profile_setting_name']}'");
        }
    }

    $tid_text_post_text = str_replace("\r\n", "<br>", $post_array['post_text']);
    $tid_text = "
[table]
[tr]
[td]{$info_lang['xinxixiangqing']}[/td]
[td][url]{$info_config['root']}?mod=view&post_id={$post_id}[/url][/td]
[/tr]
[tr]
[td]{$info_lang['area']} : [/td]";
    if ($ac == 'post') {
        $tid_text .="[td]{$post_array['province']} {$post_array['city']} {$post_array['dist']} {$post_array['community']}[/td]";
    } elseif ($ac == 'edit') {
        $tid_text .="[td]{$post['province']} {$post['city']} {$post['dist']} {$post['community']}[/td]";
    }
    $tid_text .= "
[/tr]
[tr]
[td=2,0,0]
{$tid_text_post_text}
[/td]
[/tr]
[/table]";
    //echo $ac;exit;
    if ($ac == 'post') {
        $bbs_post_array = array();
        $bbs_post_array['title'] = "[{$post_array['profile_type_title']}]" . $post_array['post_title'];
        $bbs_post_array['text'] = $tid_text;
        $bbs_post_array['uid'] = $_G['uid'];
        $bbs_post_array['username'] = $_G['username'];
        $bbs_post_array['fid'] = $info_config['fid'];
        if (!empty($info_config['fid'])) {
            $post_array['tid'] = bbs_post($bbs_post_array);
        }
        DB::update("info_post", array('tid' => $post_array['tid']), " post_id='{$post_id}'");

        $feed_template = "{actor} {$info_lang['member_post_inc_php_1']} <a href='{$info_config['root']}' target='_blank'>{$info_config['name']}</a> {$info_lang['member_post_inc_php_2']} <a href='{$info_config['root']}?mod=view&post_id={$post_id}' target='_blank'>{$post_array['post_title']}</a>";

        $feed_array = array(
            'icon' => 'share',
            'uid' => $_G['uid'],
            'username' => $_G['username'],
            'dateline' => TIMESTAMP,
            'title_template' => $feed_template,
        );
        DB::insert("home_feed", $feed_array);

        if ($_G['setting']['followforumid']) {
            $fid = $_G['setting']['followforumid'];
            if ($post['post_img_1']) {
                $img = "<img src='{$post['post_img_1']}' />";
            }
            $content = str_replace("{actor}", $_G['username'], $feed_template) . $img;

            $post_array = array(
                'fid' => $fid,
                'uid' => $_G['uid'],
                'username' => $_G['username'],
                'text' => $content,
            );
            $tid = bbs_post($post_array);

            DB::insert("home_follow_feed", array(
                'tid' => $tid,
                'uid' => $_G['uid'],
                'username' => $_G['username'],
                'dateline' => TIMESTAMP,
            ));

            DB::insert("forum_threadpreview", array(
                'tid' => $tid,
                'relay' => 0,
                'content' => $content,
            ));
        }

        //brian_cat_cache();
        $dcj_url = $info_config['root'] . "?mod=view&post_id={$post_id}";
        session_start();
        $biaoti = $post_array['cat_title'] . '/' . $post_array['subcat_title'];
        $zhifu_yanzheng = $_SESSION['zhifu_yanzheng'] = rand(0, 20000) . time() . rand(0, 10000);
        include template("info:{$style}/{$mod}/dcj_main");
        exit;

        //showmessage($info_lang['post_ok'],$info_config['root']."?mod=view&post_id={$post_id}");
    } elseif ($ac == 'edit') {
        DB::update("forum_thread", array("subject" => $post_array['post_title']), " tid='{$post['tid']}'");
        DB::update("forum_post", array("subject" => $post_array['post_title'], "message" => $tid_text), " tid='{$post['tid']}' AND first=1");
        showmessage($info_lang['edit_ok'], $info_config['root'] . "?mod=view&post_id={$post_id}");
    }
}
//echo $ac;exit;
if ($ac == 'edit') {
    /* if($post['member_uid'] !=$_G['uid'] && !$is_info_admin){
      showmessage($info_lang['no_quanxian']);
      } */
    $dcj_pas = trim($_REQUEST['pas']);
    if ($dcj_pas) {
        $ch = 0;
        $post_id = $_REQUEST['post_id'];
        $dcj_shuju = DB::fetch(DB::query("select * from pre_info_post where `post_id` = '{$post_id}' "));
        // var_dump($dcj_shuju);exit;
        $uid = $_G['uid'];
        if ($dcj_shuju['member_uid'] > 0) {
            $member_re = DB::fetch(DB::query("select * from pre_ucenter_members where `uid` = '{$dcj_shuju['member_uid']}' "));
            if ($uid > 0) {
                if ($dcj_shuju['member_uid'] != $uid) {
                    showmessage("该信息不是您发布的所以您不能修改！");
                }
            }
            if ($member_re['password'] != md5(md5($dcj_pas) . $member_re['salt'])) {
                if ($dcj_pas != $dcj_shuju['pwd']) {
                    showmessage("您输入的信息密码不对2！");
                }
            }
        } else {
            //判断信息密码是否正确

            if ($dcj_pas != $dcj_shuju['pwd']) {
                //echo $dcj_pas;var_dump($dcj_shuju['pwd']]);
                showmessage("您输入的信息密码不对1！");
            }
        }

        /* if($dcj_shuju['pwd'] != $dcj_pas)
          {
          showmessage("密码不对！","/info.php?mod=member&op=post&ac=edit&subcat_id={$subcat_id}&post_id={$post_id}");
          } */
    }

    $temp_post_profile = fetch_all('info_post_profile', " as ipp JOIN " . DB::table('info_profile_setting') . " as ips ON ipp.profile_setting_name=ips.profile_setting_name WHERE post_id='{$post_id}'");
    $post_profile = array();
    foreach ($temp_post_profile as $key => $value) {
        $value['post_profile_title'] = stripslashes($value['post_profile_title']);
        if ($value['profile_setting_formtype'] == 'checkbox') {
            $value['post_profile_title'] = unserialize($value['post_profile_title']);
        }
        $post_profile[$value['profile_setting_name']] = $value;
    }
    if (!$_REQUEST['pas']) {
        //显示要编辑的时候输入密码的页面
        include template("info:{$style}/{$mod}/dcj_main_edit_pass");
        exit;
    }
    //var_dump($post);exit;
    for ($i = 0; $i < 30; $i++) {
        $new_name = 'post_img_' . ($i + 1);
        if ($post[$new_name]) {
            $post_img[$i]['img'] = $post[$new_name];
            $post_img[$i]['post_id'] = $post['post_id'];
        }
    }
} elseif ($ac == 'post') {
    if ($info_config['maxpost'] > 0) {
        $member_broker = is_info_broker($_G['uid']);
        /* 		if(!$member_broker){
          $maxpost= DB::result_first("SELECT count(post_id) FROM ".DB::table('info_post')." WHERE profile_type_id!='2' AND member_uid ='{$_G['uid']}' ");
          if($maxpost > $info_config['maxpost']){
          $message = "{$info_lang['member_post_1']} {$info_config['maxpost']} {$info_lang['member_post_2']} . <a href='{$info_config['broker_link']}'>{$info_lang['member_post_3']}</a>";
          showmessage($message);
          }
          } */
    }

    /* 	$has_member = DB::result_first("SELECT member_uid FROM ".DB::table('info_member')." WHERE member_uid='{$_G['uid']}'");
      if(empty($has_member)){
      showmessage($info_lang['member_post_4'],$info_config['root']."?mod=member&op=profile");
      } */

    $post['subcat_id'] = $subcat_id;
    $post['cat_id'] = $cat_array[$subcat_id]['cat_pid'];

    if ($area_id) {
        $post['area_id'] = $area_id;
    }
    session_start();
    $dcj_session = $_SESSION['tmp_yanzheng'] = rand(0, 20000) . time() . rand(0, 10000);
}
?>