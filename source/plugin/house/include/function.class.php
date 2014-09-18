<?php

function dump($vars,$level=1,$pre='')  {
	$block = '  ';
	if($level ==1){
		echo "<pre style='font-size:14px;'>\n type:<c style='color:orange'>".gettype($vars)."</c> count:".count($vars)." level:{$level} {\n";
		if(gettype($vars) == 'array'){
			foreach($vars as $k=>$v){
				if(gettype($v)== 'array'){
					echo $block."<b style='color:sienna'>-['{$k}'] array count:".count($v)." Level: {$level}</b>\r\n";
					$_level = $level +1;
					dump($v,$_level,"['{$k}']");
				}else{
					$v = htmlspecialchars($v, ENT_QUOTES);
					echo $block."<span style='color:blue'>-['{$k}']=<span style='color:sienna'>{$v}</span></span>\r\n";
				}
			}
		}else{
			echo "  -".$vars."\r\n";
		}
		echo  "   \n</pre>";
	}
	elseif($level >1){
		$_block="";
		for($i=0;$i<$level;$i++){
			$_block .=$block;
		}
		if(gettype($vars)== 'array'){
			foreach($vars as $_k=>$_v){
				if(gettype($_v)== 'array'){
					echo $_block."<b style='color:sienna'>-{$pre}['{$_k}'] Array count:".count($_v)."Level: {$level}</b>\r\n";
					$_level = $level +1;
					dump($_v,$_level,$pre."['{$_k}']");
				}else{
					$_v = htmlspecialchars($_v, ENT_QUOTES);
					echo $_block."<span style='color:blue'>-{$pre}['{$_k}']=<span style='color:sienna'>{$_v}</span></span>\r\n";
				}
			}
		}else{
			echo $_block."<span style='color:green'> -{$pre}['{$pre}']={$vars}</span>\r\n";
		}
	}
}

function gpc($pre){
	$array = array();
	$pre = str_replace(" ",'',$pre);
	$pre = str_replace("\t",'',$pre);
	if(strpos($pre,'|')!==false)
		$pre_array = explode('|',$pre);
	
	foreach($_GET as $key=>$g){
		if($pre_array){
			foreach($pre_array as $v){
				$substr= '';
				$substr = substr($key,0,strlen($v));
				if(strstr($substr,$v)){
					$array[$key] = daddslashes(htmlspecialchars($g));
				}
			}
		}else{
			$substr= '';
			$substr = substr($key,0,strlen($pre));
			if( strstr($substr,$pre)){
				$array[$key] = daddslashes(htmlspecialchars($g));
			}
		}
	}
	
	return $array;
}

function get_url(){
	global $house_config;
	$url = $_SERVER['QUERY_STRING'];
	$url =  urldecode($url);
	$url_query = explode("&",$url);
	$array = array();
	foreach($url_query as $v){
		if(strstr($v,"=")){
			$v = explode("=",$v);
			$array[$v[0]] = $v[1];
		}
	}
	$url ="";
	foreach($array as $k=>$v){
		if(!empty($v) && $k !='page')
		$url[] =$k."=".$v;
	}
	$url = implode("&",$url);
	$url = $house_config['root'].'?'.$url;
	return $url;
}

function getgpc_in_array($key_array){
	$return = array();
	foreach($key_array as $v){
		$return[] = addslashes($_GET[$v]);
	}
	return $return;
}

function get_profile_type_title($profile_type_id){
	return DB::result_first("SELECT profile_type_title FROM ".DB::table('house_profile_type')." WHERE profile_type_id='{$profile_type_id}'");
}

function get_profile_setting($profile_type_id=""){
	if(!empty($profile_type_id)){
		$profile_type_setting_name = fetch_all("house_profile_type_setting"," WHERE profile_type_id='{$profile_type_id}' ORDER BY profile_type_setting_sort ASC ","profile_setting_name");
	}else{
		$profile_type_setting_name = fetch_all("house_profile_type_setting"," ORDER BY profile_type_setting_sort ASC ","profile_setting_name");
	}
	$profile_type_setting_names = array();
	foreach($profile_type_setting_name as $v){
		$profile_type_setting_names[] = $v['profile_setting_name'];
	}

	$profile_setting = fetch_all("house_profile_setting"," WHERE profile_setting_name in ('".implode("','",$profile_type_setting_names)."')  ORDER BY substring_index('".implode(",",$profile_type_setting_names)."', profile_setting_name,1)");
	foreach($profile_setting as $key=>$value){
		$profile_setting[$value['profile_setting_name']]=$value;
		unset($profile_setting[$key]);
	}
	return $profile_setting;
}

function get_post_profile($post_id){
	$post_profile = array();
	if( is_array($post_id)){
	}else{
		$post_profile = fetch_all('house_post_profile'," WHERE post_id='{$post_id}' ","*");
		foreach($post_profile as $key=>$value){
			$post_profile[$value['profile_setting_name']] = $value;
			unset($post_profile[$key]);
		}
	}
	return $post_profile;
}

function fetch_all($table,$other='',$filter='*',$first="1"){
	$sql = 'SELECT '.$filter.' FROM '.DB::table($table).' '.$other;
	$query =DB::query($sql);
	$array = array();
	while($tem = DB::fetch($query)){
		$array[] = $tem;
	}
	if($first=="0"){
		$array = $array[0];
	}
	return $array;
}

function brian_fetch_all($table,$where='', $other){
	$other['filter'] = empty($other['filter']) ? "*" : $other['filter']; 
	$other['first'] = empty($other['first']) ? "0" : $other['first']; 
	$other['sort'] = empty($other['sort']) ? "" : $other['sort']; 
	
	$sql = 'SELECT '.$other['filter'].' FROM '.DB::table($table).' '.$where;
	$query =DB::query($sql);
	$array = array();
	while($tem = DB::fetch($query)){
		if(!empty($other['sort'])){
			$array[$tem[$other['sort']]] = $tem;
		}else{
			$array[] = $tem;
		}
	}
	if($other['first']==1){
		$array = $array[0];
	}
	return $array;
}

function sortgpc($array,$id){
	$ids= $array[$id];
	$_array = array();
	foreach($array as $key1=>$a){
		foreach($a as $key2=>$v){
			$_array[$ids[$key2]][$key1]  = $v;
		}
	}
	return $_array;
}

function is_house_admin($groupid=''){
	global $house_config,$_G;
	$groupid = !empty($groupid) ? $groupid : $_G['groupid'];
	$admin_group = unserialize($house_config['admingroup']);
	if(count($admin_group)>1 &&  in_array($groupid,$admin_group)){
		return true;
	}elseif(count($admin_group) ==1 && $groupid == $admin_group[0]){
		return true;
	}else{
		return false;
	}
}

function is_house_broker($uid=''){
	global $house_config,$_G;
	$uid = !empty($uid) ? $uid : $_G['uid'];
	$groupid = DB::result_first('SELECT groupid FROM '.DB::table('common_member')." WHERE uid='{$uid}'");
	$admin_group = unserialize($house_config['brokergroup']);
	if(count($admin_group)>1 &&  in_array($groupid,$admin_group)){
		return true;
	}elseif(count($admin_group) ==1 && $groupid == $admin_group[0]){
		return true;
	}else{
		return false;
	}
}

function upload_file($file_name , $up_file_dir,$_w='390',$_h='240',$_cut='0'){
	global $_G,$house_lang,$house_config;
	if($_FILES[$file_name]['size']){
		$attachdir	= $_G['setting']['attachdir'];
		$attachurl	= $_G['setting']['attachurl'];
		
		$fileType=array('jpg','jpeg','gif', 'png');
		$upfileDir = $up_file_dir.'/';
		
		$makdir1 = $attachdir.$upfileDir;
		
		$makdirs = $makdir1.date('Ym').'/';
		if(!is_dir($makdirs)){
			@mkdir($makdirs,0777);
		}
		
		$makdirs .= date('d').'/';
		if($makdirs){
			@mkdir($makdirs,0777);
		}
		
		$sqldirname = $attachurl.$upfileDir.date('Ym').'/'.date('d').'/';
		
		if(!is_dir($makdir1)) {
			@mkdir($makdir1, 0777);
		}
		
		$maxSize=1500; 
		$ftype = strtolower(substr($_FILES[$file_name]['name'],-3,3));
		if(!in_array($ftype, $fileType)){
			$msg =$house_lang['upload_msg_error_1'];
		}
		if($_FILES[$file_name]['size']> $maxSize*1024){
			$msg =$house_lang['upload_msg_error_2'];
		}
		if($_FILES[$file_name]['error'] !=0){
			$msg =$house_lang['upload_msg_error_3'];
		}
		
		if($msg){
			showmessage($msg.$house_lang['upload_msg_error_4']);
		}
		
		$targetDir=$makdir1;
		$targetFile=time()."-".rand(1111,9999).'.'.$ftype;
		
		$realFile=$targetDir.$targetFile;
		$smallFile = $makdirs.$targetFile;
		$sqldirname = $sqldirname.$targetFile;
		
		if(@copy($_FILES[$file_name]['tmp_name'], $realFile) || (function_exists('move_uploaded_file') && @move_uploaded_file($_FILES[$file_name]['tmp_name'], $realFile))) {
			@unlink($_FILES[$file_name]['tmp_name']);
			@unlink($_GET['temp_'.$file_name]);
		}
		
		$fsize = $_FILES[$file_name]['size'];
		$class = new resizeimage($realFile,$smallFile, $_w, $_h, $_cut);
		@unlink($realFile);
		
		return $sqldirname;
		
	}elseif(isset($_GET['temp_'.$file_name])){
		return addslashes($_GET['temp_'.$file_name]);	
	}
}

function upload_image($file_name,$type='space',$_w=200,$_h=200,$cut=1){
	global $_G;
	$attachdir	= $_G['setting']['attachdir'];
	$attachurl	= $_G['setting']['attachurl'];
	
	$file = $_FILES[$file_name];
	if($_FILES[$file_name]['size']){
		$upload = new discuz_upload();
		if(!$upload->init($file,$type)) {
			return false;
		}
		$upload->save();
		
		require_once  libfile('class/image');
		$image = new image();
		$thumbTarget =$type.'/'.date('Ym').'/'.date('d').'/'.$upload->attach['attachment'];
		$image->Thumb($upload->attach['target'],$thumbTarget, $_w, $_h, $cut);
		@unlink($image->source);
		
		if(!empty($_GET['temp_'.$file_name])){
			$_goods_pic = addslashes($_GET['temp_'.$file_name]);
			@unlink($_goods_pic);
		}
		
		return $attachurl.$thumbTarget;
	}elseif(isset($_GET['temp_'.$file_name])){
		return addslashes($_GET['temp_'.$file_name]);	
	}
}

function hidden_ip($ip){
	return str_replace(strrchr($ip,'.'),'.*',$ip);
}

function brian_showdistrict($values, $elems=array(), $container='districtbox', $showlevel=null, $containertype = '') {
	$html = '';
	if(!preg_match("/^[A-Za-z0-9_]+$/", $container)) {
		return $html;
	}
	$showlevel = !empty($showlevel) ? intval($showlevel) : count($values);
	$showlevel = $showlevel <= 4 ? $showlevel : 4;
	$upids = array(0);
	for($i=0;$i<$showlevel;$i++) {
		if(!empty($values[$i])) {
			$upids[] = intval($values[$i]);
		} else {
			for($j=$i; $j<$showlevel; $j++) {
				$values[$j] = '';
			}
			break;
		}
	}
	$options = array(1=>array(), 2=>array(), 3=>array(), 4=>array());
	if($upids && is_array($upids)) {
		foreach(table_brian_district::fetch_all_by_upid($upids, 'displayorder', 'ASC') as $value) {
			$options[$value['level']][] = array($value['id'], $value['name']);
		}
	}
	$names = array('province', 'city', 'district', 'community');
	for($i=0; $i<4;$i++) {
		if(!empty($elems[$i])) {
			$elems[$i] = dhtmlspecialchars(preg_replace("/[^\[A-Za-z0-9_\]]/", '', $elems[$i]));
		} else {
			$elems[$i] = $names[$i];
		}
	}
	
	for($i=0;$i<$showlevel;$i++) {
		$level = $i+1;
		if(!empty($options[$level])) {
			$jscall = "brian_showdistrict('$container', ['$elems[0]', '$elems[1]', '$elems[2]', '$elems[3]'], $showlevel, $level, '')";
			$html .= '<select name="'.$elems[$i].'" id="'.$elems[$i].'" class="ps" onchange="'.$jscall.'" tabindex="1">';
			$html .= '<option value="">'.lang('spacecp', 'district_level_'.$level).'</option>';
			foreach($options[$level] as $option) {
				$selected = $option[0] == $values[$i] ? ' selected="selected"' : '';
				$html .= '<option did="'.$option[0].'" value="'.$option[1].'"'.$selected.'>'.$option[1].'</option>';
			}
			$html .= '</select>';
			$html .= '&nbsp;&nbsp;';
		}
	}
	return $html;
}


function bbs_post($input){
	global $_G;
	require_once libfile('function/post');
	require_once libfile('function/forum');
	
	$subject = $input['title'];
	$message = stripslashes($input['text']);
	
	$auid=$input['uid'];
	$au = $input['username'];
	$fid = $input['fid'];
	$dateline= TIMESTAMP;
	
	$data=array('fid' =>$fid,'subject' => $subject, 'dateline' => $dateline ,'lastpost' => $dateline ,'author' => $au,'authorid' => $auid);
	$tid = DB::insert("forum_thread", $data, $tid = true);
	
	$pid = insertpost(array('tid' =>$tid,	'fid'=>$fid,'first' =>1,'subject' => $subject,'message'=>$message, 'dateline' => $dateline ,'author' => $au,	'authorid' => $auid,	'htmlon'=>"1"));
	
	updatepostcredits('+', $_G['uid'], 'post', $fid);
	
	$synclastpost = "{$tid}\t".addslashes($subject)."\t{$_G[timestamp]}\t{$_G[username]}";
	DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$synclastpost', threads=threads+1, posts=posts+1, todayposts=todayposts+1 WHERE fid='{$fid}'", 'UNBUFFERED');
	
	return $tid;
}

class table_brian_district 
{
	public function fetch_all_by_upid($upid, $order = null, $sort = 'DESC') {
		$upid = is_array($upid) ? implode("','", array_map('intval', (array)$upid)) : dintval($upid);
		if($upid !== null) {
			$ordersql = ' ORDER BY displayorder ASC' ;
			return brian_fetch_all('house_area'," WHERE upid IN ('{$upid}') {$ordersql} ",array('sort'=>'id'));
		}
		return array();
	}
}

function house($addonid='house.plugin'){
	$array = cloudaddons_getmd5($addonid);
	if(cloudaddons_open('&mod=app&ac=validator&ver=2&addonid='.$addonid.($array !== false ? '&rid='.$array['RevisionID'].'&sn='.$array['SN'].'&rd='.$array['RevisionDateline'] : '')) === '0') {
		cpmsg('cloudaddons_genuine_message', '', 'error', array('addonid' => $addonid));
	}
}

function house_check($addonid='house();'){
	$string = file_get_contents(DISCUZ_ROOT.'./source/plugin/house/admin_area.inc.php');
	if(!stripos($string,$addonid)){
		exit;
	}
}

function brian_output(){
	if(!defined('IN_MOBILE')){
		global $_G,$house_config;
		if($house_config['weijingtai']==1){
			$content = ob_get_contents();
			$content = brian_output_replace($content);
			ob_end_clean();
			$_G['gzipcompress'] ? ob_start('ob_gzhandler') : ob_start();
			echo $content;
		}
	}
}

function brian_output_replace($content){
	global $house_config;
	$url = str_replace("/","\/",$house_config['root']);
	$p = '/href="'.$url.'?(.*?)"/e';
	$covre_content = preg_replace($p, 'brian_output_returnstr("\0")',$content);
	return $covre_content;
}

function brian_output_returnstr($str){
	global $house_config;
	if(stripos($str , "house.php") !==false && stripos($str , "php?") == false ){
		$return_str = str_replace("house.php","house",$str);
		return $return_str;
	}elseif(stripos($str,$house_config['root']."?mod=view&post_id=") !== false && stripos($str , "op=") !== false   ){
		$return_str = str_replace($house_config['root']."?mod=view&post_id=",$house_config['siteurl']."house-",$str);
		return $return_str;
	}elseif(stripos($str,$house_config['root']."?mod=loupan&op=view&lid=") !== false && substr_count($str,"&") ==3  ){
		$return_str = str_replace($house_config['root']."?mod=loupan&op=view&lid=",$house_config['siteurl']."house-loupan-",$str);
		$return_str = str_replace("&ac=","-",$return_str);
		return $return_str;
	}elseif(stripos($str,$house_config['root']."?mod=loupan") !== false && substr_count($str,"&") ==0 ){
		$return_str = str_replace($house_config['root']."?mod=loupan",$house_config['siteurl']."house-loupan",$str);
		return $return_str;
	}elseif(stripos($str,$house_config['root']."?mod=loupan&op=view&lid=") !== false && substr_count($str,"&") ==2 ){
		$return_str = str_replace($house_config['root']."?mod=loupan&op=view&lid=",$house_config['siteurl']."house-loupan-",$str);
		return $return_str;
	}elseif(stripos($str,$house_config['root']."?mod=list&profile_type_id=") !== false){
		$__has_id = str_replace($house_config['root']."?mod=list&profile_type_id=","",$str);
		$__has_id = str_replace('href="',"",$__has_id);
		$__has_id = str_replace('"',"",$__has_id);
		if(is_numeric($__has_id)){
			$return_str = str_replace($house_config['root']."?mod=list&profile_type_id=",$house_config['siteurl']."house-list-",$str);
			return $return_str;
		}else{
			return $str;
		}
	}else{
		return $str;
	}
}

function shenlan_runquery($sql){
	require_once libfile('function/plugin');
	if(is_array($sql)){
		$sql_array = $sql;
	}elseif( strpos($sql, ";") !==false){
		$sql_array = explode(";",$sql);
	}else{
		$sql_array = array($sql);
	}
	foreach($sql_array as $sa){
		try{
			if(!empty($sa)){
				runquery($sa);
			}
		} catch(Exception $e) {
			//echo $e;
		}
	}
	return true;
}

function brian_feed($feed_str){
	global $_G;
	$feed_array = array(
			'icon'=>'share',
			'uid'=>$_G['uid'],
			'username'=>$_G['username'],
			'dateline'=>TIMESTAMP,
			'title_template'=>"<b>".$feed_str."</b>",
			);
	DB::insert("home_feed",$feed_array);
}
?>