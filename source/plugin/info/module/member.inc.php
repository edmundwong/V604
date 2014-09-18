<?php

$yuming = "http://112.225.163.46/";
//$yuming = $_SERVER['SERVER_NAME'] . "/";
//error_reporting(E_ALL);
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

//if(empty($_G['uid']) ) {	showmessage($info_lang['login'],'',array(),array('login' => true));}
$biaozhun_arr = array(1, 2, 3);
$biaozhun_time = array(1 => 3, 2 => 6, 3 => 12);
$biaozhun_money = array(1 => 240, 2 => 360, 3 => 600);
$zhifu_arr = array(1, 2, 3);
$op_array = array('post', 'postlist', 'mypostup', 'profile', 'setpostup', 'dcj_zhifu','dcj_return','dcj_success_return');
$op = in_array($_GET['op'], $op_array) ? addslashes($_GET['op']) : 'mypost';
//var_dump($_REQUEST);exit;
$is_info_broker = is_info_broker();
//echo $op;exit;
if ($op == 'post') {
    //echo DISCUZ_ROOT."./source/plugin/info/module/{$mod}/{$mod}_{$op}.inc.php";exit;
    require_once DISCUZ_ROOT . "./source/plugin/info/module/{$mod}/{$mod}_{$op}.inc.php";
}
if ($_REQUEST['op'] == 'jubao') {
    $goods_id = $_REQUEST['post_id'];
    $goods_title = fetch_all('info_post', " WHERE post_id='{$goods_id}'", " post_title ");
    $goods_title = $goods_title[0]['post_title'];
    DB::insert('info_post_jubao', array('post_id' => $goods_id, 'reason' => $_REQUEST['reason'], 'post_title' => $goods_title, 'jubao_time' => time()));
    /* $admin_group = unserialize($info_config['admingroup']);
      $admin_group = dimplode($admin_group);
      $notice_uids = fetch_all('common_member'," WHERE groupid IN ({$admin_group}) OR adminid='1' ",' uid ');
      foreach($notice_uids as $u){
      $notice = $info_config['name']." : ".$info_lang['note_new_jubao'];
      notification_add($u['uid'],'system',$notice);
      } */
    exit(json_encode(array('status' => 1)));
//require_once DISCUZ_ROOT."./source/plugin/info/module/jubao.inc.php"; 
} elseif ($op == 'dcj_zhifu') {
    /* if($_SESSION['zhifu_yanzheng'] != $_POST['zhifu_yanzheng'])
      showmessage('表单令牌不对！'); */
    $post_id = (int) $_POST['post_id'];
    if ($post_id < 1)
        showmessage("缺少关键数据！");
    $biaozhun = (int) $_POST['biaozhun'];
    if (!in_array($biaozhun, $biaozhun_arr))
        showmessage("请选择收费标准！");
    $pay_way = (int) $_POST['pay_way'];
    if (!in_array($pay_way, $zhifu_arr))
        showmessage("请选择支付方式！");
    if ($pay_way == 1)
        $pay_way_name = 'paypal';
    if ($pay_way == 2)
        $pay_way_name = '现金';
    if ($pay_way == 3)
        $pay_way_name = '支票';
    DB::query("update pre_info_post set `pay_way` = '{$pay_way_name}' where `post_id` = '{$post_id}' ");
    
    $a_infos = array(
        'info_username'=>$_POST['info_username'],
        'info_tel'=>$_POST['info_tel'],
        'info_mail'=>$_POST['info_mail'],
        'info_pwd'=>$_POST['info_pwd']
    );
    
    if ($pay_way == 1) {
        $invoice = $post_id . '|' . $biaozhun_time[$biaozhun];
        $biaoti = trim($_POST['biaoti']);
        //TODO 此处paypal沙箱始终不返回通知，需要上线后进行正式域名的测试
        $notify_url = $yuming . 'info.php?mod=member&op=dcj_success_return&post_id=' . $post_id . '&time=' . $biaozhun_time[$biaozhun] . '&dcj_price=' . $biaozhun_money[$biaozhun];
//        $notify_url = urlencode($notify_url);
//echo "info:{$style}/{$mod}/{$mod}_main_dcj";exit;
        $return_url = $yuming . "info.php?mod=member&op=dcj_return&post_id={$post_id}&time={$biaozhun_time[$biaozhun]}";
        include template("info:{$style}/{$mod}/{$mod}_main_dcj");
        exit;
    }
    if ($pay_way == 2) {
        $dcj_url = $info_config['root'] . "?mod=view&post_id={$post_id}";
        include template("info:{$style}/{$mod}/dcj_main_zhifu1");
        exit;
    }
    if ($pay_way == 3) {
        $dcj_url = $info_config['root'] . "?mod=view&post_id={$post_id}";
        include template("info:{$style}/{$mod}/dcj_main_zhifu3");
        exit;
    }
} elseif ($op == 'dcj_return') {
    $post_id = (int) $_REQUEST['post_id'];
    showmessage("恭喜您支付成功！", $info_config['root'] . "?mod=view&post_id={$post_id}");
} elseif ($op == 'dcj_success_return') {
    $data_id = trim($_REQUEST['post_id']);
    $data_time = trim($_REQUEST['time']);
    $req = 'cmd=_notify-validate';
    DB::insert('info_order', array('post_id' => $data_id, 'time' => $data_time));
    foreach ($_POST as $k => $v) {
        $v = urlencode(stripslashes($v));
        $req .= "&{$k}={$v}";
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://www.sandbox.paypal.com/cgi-bin/webscr');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    $res = curl_exec($ch);
    curl_close($ch);
    if ($res && strcmp($res, 'VERIFIED') == 0) {
        $t = time();
        $arr = array(
            'post_begin_time' => $t,
            'post_end_time' => strtotime("$t + $data_time months"),
            'price' => trim($_REQUEST['dcj_price'])
        );
        DB::update('info_post', $arr, " post_id='{$user['user_uid']}'");
        brian_cat_cache();
        exit("成功！");
    } else {
        exit("失败！");
    }
} elseif ($op == 'mypost' || $op == 'mypostup') {
    $ac = !empty($_GET['ac']) ? addslashes($_GET['ac']) : '';
    $where = " WHERE member_uid='{$_G['uid']}'";
    if ($ac == 'up') {
        $where .=" AND post_up='1' ";
    }
    $where .=" ORDER BY post_up DESC,post_time DESC ";
    $pagenum = DB::result_first("SELECT count('post_id') FROM " . DB::table('info_post') . $where);
    $page = $_GET['page'] ? intval($_GET['page']) : 1;
    $perpage = $info_config['perpage'];
    $urlnow = $info_config['root'] . "?mod={$mod}&op={$op}&ac={$action}";
    $multipage = multi($pagenum, $perpage, $page, $urlnow, 0, 10);
    $stat_limit = ($page - 1) * $perpage;
    $where .= " LIMIT {$stat_limit},{$perpage}";

    $post_list = fetch_all('info_post', $where);
} elseif ($op == 'user') {
    $uid = $_G['uid'];
    $user = fetch_all('info_user', " WHERE user_uid='{$uid}'");
    $user = $user[0];
    $gpc_user = gpc('user_');
    $gpc_user['user_company_text'] = stripslashes($gpc_user['user_company_text']);

    if (submitcheck('submit_user')) {
        if (!empty($user['user_uid'])) {
            DB::update('info_user', $gpc_user, " user_uid='{$user['user_uid']}'");
            showmessage($info_lang['edit_ok']);
        } else {
            DB::insert('info_user', $gpc_user);
            showmessage($info_lang['edit_ok']);
        }
    }
} elseif ($op == 'resume') {
    $user_id = $_G['uid'];

    $resume = fetch_all('info_member_resume', " WHERE user_id='{$user_id}'", "*", "0");
    require_once libfile('function/discuzcode');
    $resume['resume_work_bbcode'] = discuzcode($resume['resume_work'], 0, 0);
    $resume['resume_skill_bbcode'] = discuzcode($resume['resume_skill'], 0, 0);
    $resume['resume_language_bbcode'] = discuzcode($resume['resume_language'], 0, 0);

    $gpc_resume = gpc('resume_');
    $gpc_resume['resume_birthday'] = strtotime($gpc_resume['resume_birthday']);
    if (submitcheck('submit_resume')) {
        if (!empty($resume['user_id'])) {
            DB::update('info_member_resume', $gpc_resume, " user_id='{$user_id}' ");
            showmessage($info_lang['edit_ok'], $info_config['root'] . "?mod=member&op=resume");
        } else {
            $gpc_resume['user_id'] = $user_id;
            DB::insert('info_member_resume', $gpc_resume);
            showmessage($info_lang['edit_ok'], $info_config['root'] . "?mod=member&op=resume");
        }
    }

    $profile_type_id = "1";
    $profile_setting = get_profile_setting();

    //$district = fetch_all('common_district'," WHERE level = '1'");
} elseif ($op == 'mycredit') {
    if (empty($info_config['extcredits'])) {
        showmessage($info_lang['no_extcredits']);
    } else {
        $credit = DB::result_first("SELECT extcredits{$info_config['extcredits']} FROM " . DB::table('common_member_count') . " WHERE uid='{$_G['uid']}'");
        $credit_log = fetch_all('info_up', " as su LEFT JOIN " . DB::table('info_post') . " as sg ON su.post_id = sg.post_id WHERE sg.member_uid='{$_G['uid']}'");
    }
} elseif ($op == 'fav') {
    if ($_GET['action'] == 'del') {
        DB::delete('info_member_fav', " post_id='" . intval($_GET['post_id']) . "' AND user_id='{$_G['uid']}'");
        showmessage($info_lang['done'], $info_config['root'] . "?mod=member&op=fav");
    }
    $fav_list = fetch_all("info_post", " as jp LEFT JOIN " . DB::table('info_member_fav') . " as jma ON jma.post_id = jp.post_id WHERE jma.user_id='{$_G['uid']}'");
} elseif ($op == 'apply') {
    $apply_list = fetch_all("info_post", " as jp LEFT JOIN " . DB::table('info_member_apply') . " as jma ON jma.post_id = jp.post_id WHERE jma.user_id='{$_G['uid']}'");
} elseif ($op == 'profile') {
    require_once DISCUZ_ROOT . './source/plugin/info/module/' . $mod . '/' . $mod . '_profile.inc.php';
} elseif ($op == 'setpostup') {
    require_once DISCUZ_ROOT . './source/plugin/info/module/' . $mod . '/' . $mod . '_setpostup.inc.php';
} elseif ($op == 'view') {
    $uid = !empty($_GET['uid']) ? intval($_GET['uid']) : $_G['uid'];
    $resume = fetch_all('info_member_resume', " WHERE user_id='{$uid}'", "*", "0");
    require_once libfile('function/discuzcode');
    $resume['resume_work'] = discuzcode($resume['resume_work'], 0, 0);
    $resume['resume_skill'] = discuzcode($resume['resume_skill'], 0, 0);
    $resume['resume_language'] = discuzcode($resume['resume_language'], 0, 0);
}

$navtitle = $info_lang['space'] . " - " . $info_config['name'];
//echo "info:{$style}/{$mod}/{$mod}_main";exit;
include template("info:{$style}/{$mod}/{$mod}_main");
?>