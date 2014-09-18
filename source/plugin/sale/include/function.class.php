<?php
if(!defined('IN_DISCUZ')) {exit('Access Denied');}

function dump($vars,$level=1,$pre='')  {
	$block = '  ';
	if($level ==1){
		echo "<pre style='font-size:14px;'>\n type:<c style='color:orange'>".gettype($vars)."</c> count:".count($vars)." level:{$level} {\n";
		if(gettype($vars) == 'array'){
			foreach($vars as $k=>$v){
				if(gettype($v)== 'array'){
					echo $block."<b style='color:sienna'>├-['{$k}'] Array Level: {$level}</b>\r\n";
					$_level = $level +1;
					dump($v,$_level,"['{$k}']");
				}else{
					echo $block."<span style='color:blue'>├-['{$k}']={$v}</span>\r\n";
				}
			}
		}else{
			echo "  ├-".$vars."\r\n";
		}
		echo  "  └} \n</pre>";
	}
	elseif($level >1){
		$_block="";
		for($i=0;$i<$level;$i++){
			$_block .=$block;
		}
		if(gettype($vars)== 'array'){
			foreach($vars as $_k=>$_v){
				if(gettype($_v)== 'array'){
					echo $_block."<b style='color:sienna'>├-{$pre}['{$_k}'] Array Level: {$level}</b>\r\n";
					$_level = $level +1;
					dump($_v,$_level,$pre."['{$_k}']");
				}else{
					echo $_block."<span style='color:blue'>├-{$pre}['{$_k}']={$_v}</span>\r\n";
				}
			}
		}else{
			echo $_block."<span style='color:green'> ├-{$pre}['{$pre}']={$vars}</span>\r\n";
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
					$array[$key] = daddslashes($g);
				}
			}
		}else{
			$substr= '';
			$substr = substr($key,0,strlen($pre));
			if( strstr($substr,$pre)){
				$array[$key] = daddslashes($g);
			}
		}
	}

	return $array;
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
	$other['first'] = empty($other['first']) ? "1" : $other['first']; 
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
	if($other['first']=="0"){
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

function is_sale_admin($groupid=''){
	global $sale_config,$_G;
	$groupid = !empty($groupid) ? $groupid : $_G['groupid'];
	$admin_group = unserialize($sale_config['admingroup']);
	if(is_array($admin_group) &&  in_array($groupid,$admin_group)){
		return true;
	}elseif(strstr($groupid,$admin_group)){
		return true;
	}else{
		return false;
	}
}

/**
 * 上传图片
 * @param mixed $file_name $_FILES的name
 * @param mixed $type 例如 space 
 * @param mixed $_w 宽度
 * @param mixed $_h 高度
 * @param mixed $cut 1根据宽来缩放, 2代表居中截取
 * @return mixed 返回已上传图片的URL相对地址
 */
function upload_image($file_name,$type='sale',$_w=200,$_h=200,$cut=1){
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

function upload_file($file_name , $up_file_dir,$_w='500',$_h='500',$_cut='0'){
	global $_G,$_lang,$sale_config;
	if($_FILES[$file_name]['size']){
		$attachdir	= $_G['setting']['attachdir'];
		$attachurl	= $_G['setting']['attachurl'];
		
		$fileType=array('jpg','jpeg','gif', 'png');
		$upfileDir = $up_file_dir.'/';
		
		$makdir1 = $attachdir.$upfileDir;
		if(!is_dir($makdir1)){
			@mkdir($makdir1);
		}
		
		$makdirs = $makdir1.date('Ym').'/';
		if(!is_dir($makdirs)){
			@mkdir($makdirs);
		}
		
		$makdirs .= date('d').'/';
		if($makdirs){
			@mkdir($makdirs);
		}
		
		$sqldirname = $attachurl.$upfileDir.date('Ym').'/'.date('d').'/';
		
		if(!is_dir($makdir1)) {
			@mkdir($makdir1);
		}
		
		$maxSize=2000; 
		$extend =explode("." , $_FILES[$file_name]['name']);
		$va=count($extend)-1;
		$ftype = $extend[$va];
		if(!in_array($ftype, $fileType)){
			$msg =$_lang['upload_msg_error_1'];
		}
		if($_FILES[$file_name]['size']> $maxSize*1024){
			$msg =$_lang['upload_msg_error_2'];
		}
		if($_FILES[$file_name]['error'] !=0){
			$msg =$_lang['upload_msg_error_3'];
		}
		
		if($msg){
			showmessage($msg.$_lang['upload_msg_error_4']);
		}
		
		$targetDir=$makdir1;
		$targetFile=time()."-".rand(1111,9999).'.'.$ftype;
		
		$realFile=$targetDir.$targetFile;
		$smallFile = $makdirs.$targetFile;
		$sqldirname = $sqldirname.$targetFile;

		if(copy($_FILES[$file_name]['tmp_name'], $realFile) || (function_exists('move_uploaded_file') && move_uploaded_file($_FILES[$file_name]['tmp_name'], $realFile))) {
			@unlink($_FILES[$file_name]['tmp_name']);
			@unlink($_GET['temp_'.$file_name]);
		}
		
		$fsize = $_FILES[$file_name]['size'];
		
		$class = new resizeimage($realFile,$smallFile, $_w, $_h, $_cut);
		@unlink($realFile);
		
		if(!empty($_GET['temp_'.$file_name])){
			$_goods_pic = str_replace($sale_config['siteurl'],'',addslashes($_GET['temp_'.$file_name]));
			@unlink($_goods_pic);
		}
		return $sqldirname;
		
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
			/* $elems[$i] = ($containertype == 'birth' ? 'birth' : 'reside').$names[$i]; */
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


class table_brian_district 
{
	public function fetch_all_by_upid($upid, $order = null, $sort = 'DESC') {
		$upid = is_array($upid) ? implode("','", array_map('intval', (array)$upid)) : dintval($upid);
		if($upid !== null) {
			$ordersql = ' ORDER BY displayorder ASC' ;
			return brian_fetch_all('sale_area'," WHERE upid IN ('{$upid}') {$ordersql} ",array('sort'=>'id'));
		}
		return array();
	}
}

function sale($addonid='sale.plugin'){
	$array = cloudaddons_getmd5($addonid);
	if(cloudaddons_open('&mod=app&ac=validator&ver=2&addonid='.$addonid.($array !== false ? '&rid='.$array['RevisionID'].'&sn='.$array['SN'].'&rd='.$array['RevisionDateline'] : '')) === '0') {
/*		cpmsg('cloudaddons_genuine_message', '', 'error', array('addonid' => $addonid));*/
	}
}

function sale_check($addonid='sale();'){
	$string = file_get_contents(DISCUZ_ROOT.'./source/plugin/sale/admin_area.inc.php');
	if(!stripos($string,$addonid)){
		exit;
	}
}


/**
 * *
 * 论坛发帖
 * @param array 5个参数 uid username fid title text
 * @return tid
 *
 */
function bbs_post($input){
	global $_G;
	require_once libfile('function/post');
	require_once libfile('function/forum');
	
	$auid= !empty($input['uid']) ? $input['uid'] : $_G['uid'];
	$au = !empty($input['username']) ? $input['username'] : $_G['username'];
	$fid = $input['fid'];
	$subject = $input['title'];
	$message = stripslashes($input['text']);
	$dateline= TIMESTAMP;
	
	$data=array('fid' =>$fid,'subject' => $subject, 'dateline' => $dateline ,'lastpost' => $dateline ,'author' => $au,'authorid' => $auid);
	$tid = DB::insert("forum_thread", $data, $tid = true);
	
	$pid = insertpost(array('tid' =>$tid,	'fid'=>$fid,'first' =>1,'subject' => $subject,'message'=>$message, 'dateline' => $dateline ,'author' => $au,	'authorid' => $auid,	'htmlon'=>"1"));
	
	updatepostcredits('+', $_G['uid'], 'post', $fid);
	
	$synclastpost = "{$tid}\t".addslashes($subject)."\t{$_G[timestamp]}\t{$_G[username]}";
	DB::query("UPDATE ".DB::table('forum_forum')." SET lastpost='$synclastpost', threads=threads+1, posts=posts+1, todayposts=todayposts+1 WHERE fid='{$fid}'", 'UNBUFFERED');
	
	return $tid;
}

/**
 * 修改主题帖
 * @param array 3个参数 tid  title  text 
 * @return 
 */
function bbs_edit($input){
	/*修改主题列表*/
	DB::update("forum_thread", array('subject'=>$input['title']), " `tid`='{$input['tid']} ' ");
	
	/*修改内容列表*/
	DB::update("forum_post", array('subject'=>$input['title'],'message'=>$input['text']), " `tid`='{$input['tid']} ' and `first`='1'");
}

/**
 * *
 *  帖子回复
 * @param array 5个参数 uid username fid  tid text
 * @return bool
 *
 */
function bbs_reply($input){
	/*获取PID*/
	$pid = DB::insert("forum_post_tableid", array('pid' => '' ),$pid = true);
	
	/*修改内容列表*/
	$return = DB::insert("forum_post", array('pid'=>$pid,'first'=>0,'authorid'=>$input['uid'],'author'=>$input['username'],'fid'=>$input['fid'],'tid'=>$input['tid'],'message'=>$input['text'],'dateline'=>time()));
	return $return;
}
?>