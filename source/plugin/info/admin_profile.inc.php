<?php

if(!defined('IN_ADMINCP')){	exit('Admin Login');}
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}
require_once DISCUZ_ROOT.'./source/plugin/info/include/config.inc.php';
require_once DISCUZ_ROOT.'./source/plugin/info/include/function.class.php';

$identifier = "info";
$pmod=$mod='admin_profile';
$self_url = 'plugins&operation=config&identifier='.$identifier.'&pmod='.$mod.'&do='.$do;
$cp_url ='action='.$self_url;
$now_url = ADMINSCRIPT.'?'.$cp_url;
$info_lang = lang('plugin/'.$identifier);

if(submitcheck('add_profile_setting_submit')){
	$profile_setting = gpc('profile_setting_');
	if(empty($profile_setting['profile_setting_title'])){
		cpmsg("{$info_lang['admin_profile_inc_php_1']}");
	}
	DB::insert($identifier.'_profile_setting',$profile_setting);
}

if(submitcheck('edit_profile_setting_submit')){
	$profile_setting = gpc('profile_setting_');
	if(empty($profile_setting['profile_setting_title'])){
		cpmsg("{$info_lang['admin_profile_inc_php_1']}");
	}
	DB::update($identifier.'_profile_setting',$profile_setting," profile_setting_name='{$profile_setting['profile_setting_name']}'");
}

if(submitcheck('add_profile_type_submit')){
	$profile_type = gpc('profile_type_');
	if(empty($profile_type['profile_type_title'])){
		cpmsg("{$info_lang['admin_profile_inc_php_3']}");
	}
	DB::insert($identifier.'_profile_type',$profile_type);
}if( !cloudaddons_getmd5("info.plugin") ) { cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "info.plugin"));}


if(submitcheck('edit_profile_type_submit')){
	$profile_type_setting = gpc('profile_type_setting_');
	DB::update($identifier.'_profile_type_setting',$profile_type_setting," profile_type_setting_id ='{$profile_type_setting['profile_type_setting_id']}' ");
}

if(submitcheck('add_profile_type_setting_submit')){
	$profile_type_id = intval($_GET['profile_type_id']);
	$profile_type_setting = gpc('profile_type_setting');
	$profile_type_setting['profile_type_id'] = $profile_type_id;
	$profile_setting = gpc('profile_setting_');
	list($profile_type_setting['profile_setting_name'],$profile_type_setting['profile_setting_title']) = explode('###',$profile_setting['profile_setting_title']);
	if(empty($profile_type_setting['profile_setting_title'])){
		cpmsg("{$info_lang['admin_profile_inc_php_4']}");
	}
	DB::insert($identifier.'_profile_type_setting',$profile_type_setting);
	$_GET['op']='profile_type_setting';
	$_GET['profile_type_id'] = $profile_type_id;
}

if(isset($_GET['del_profile_setting_name'])){
	$profile_setting_name = addslashes($_GET['del_profile_setting_name']);
	DB::delete($identifier.'_profile_setting'," profile_setting_name ='{$profile_setting_name}'");
	DB::delete($identifier.'_profile_type_setting'," profile_setting_name ='{$profile_setting_name}'");
}

if(isset($_GET['del_profile_type_setting'])){
	$profile_type_setting_id = intval($_GET['del_profile_type_setting']);
	DB::delete($identifier.'_profile_type_setting'," profile_type_setting_id ='{$profile_type_setting_id}'");
}

if(isset($_GET['del_profile_type_id'])){
	$profile_type_id = intval($_GET['del_profile_type_id']);
	DB::delete($identifier.'_profile_type'," profile_type_id ='{$profile_type_id}'");
	DB::delete($identifier.'_profile_type_setting'," profile_type_id ='{$profile_type_id}'");
}

if(submitcheck('op',1)){
	if($_GET['op']=='profile_type_setting'){
		$profile_type_id = intval($_GET['profile_type_id']);
		$profile_type = fetch_all($identifier.'_profile_type'," WHERE profile_type_id='{$profile_type_id}' ",'*','0');
		showtableheader("1. {$info_lang['admin_profile_inc_php_5']} : {$profile_type['profile_type_title']}");
		echo "<tr>";
		echo "<th></th><th>{$info_lang['admin_profile_inc_php_6']}</th><th>{$info_lang['admin_profile_inc_php_7']}</th><th>{$info_lang['sort']}</th>
		<th>{$info_lang['admin_profile_inc_php_1']}<p>({$info_lang['admin_profile_inc_php_2']})</p></th>
		<th></th>";
		echo "</tr>";
		$all_profile_type_settging = fetch_all($identifier.'_profile_type_setting'," WHERE profile_type_id='{$profile_type_id}' ORDER BY profile_type_setting_sort ASC");
		$profile_settging_names = array();
		foreach($all_profile_type_settging as $profile_type_settging){
			showformheader($self_url);
			echo "<tr>";
			echo "<td>{$profile_type_settging['profile_setting_name']}</td>";
			echo "<td>{$profile_type_settging['profile_setting_title']}</td>";
			
			echo "<td><select name='profile_type_setting_status'><option value='1' ";
			if($profile_type_settging['profile_type_setting_status'])	echo " selected='selected' ";
			echo " >{$info_lang['yes']}</option><option value='0'"; 
			if(!$profile_type_settging['profile_type_setting_status'])	echo " selected='selected' ";
			echo  ">{$info_lang['admin_profile_inc_php_10']}</option></select></td>";
			
			echo "<td><input type='text' value='{$profile_type_settging['profile_type_setting_sort']}' name='profile_type_setting_sort' /></td>";
			
			echo "<td><select name='profile_type_setting_jiage'><option value='1' ";
			if($profile_type_settging['profile_type_setting_jiage'])	echo " selected='selected' ";
			echo " >{$info_lang['yes']}</option><option value='0'"; 
			if(!$profile_type_settging['profile_type_setting_jiage'])	echo " selected='selected' ";
			echo  ">{$info_lang['admin_profile_inc_php_10']}</option></select></td>";
			
			echo "<td><input type='hidden' value='{$profile_type_settging['profile_type_setting_id']}' name='profile_type_setting_id' /> <input type='submit' name='edit_profile_type_submit' value='{$info_lang['admin_profile_inc_php_11']}' class='btn' /> | <a href='".ADMINSCRIPT."?{$cp_url}&del_profile_type_setting={$profile_type_settging['profile_type_setting_id']}' onclick=\"return(confirm('{$info_lang['admin_profile_inc_php_12']}?'))\">{$info_lang['del']}</a></td>";
			echo "</tr>";
			showformfooter();
			$profile_settging_names[] =$profile_type_settging['profile_setting_name'];
		}
		echo "<tr><th colspan='15' class='partition'>1.1{$info_lang['admin_profile_inc_php_5']} : {$profile_type['profile_type_title']} - {$info_lang['admin_profile_inc_php_15']}[{$info_lang['admin_profile_inc_php_16']}]</th></tr>";
		if(!empty($profile_settging_names))
			$add_new_profile_settging_where = " WHERE profile_setting_name NOT IN('".implode("','",$profile_settging_names)."')";
		$add_new_profile_settging = fetch_all($identifier.'_profile_setting',$add_new_profile_settging_where);
		showformheader($self_url);
		echo "<tr><td></td>";
		echo "<td><input type='hidden' name='profile_type_id' value='{$profile_type_id}' /><select name='profile_setting_title'>";
		foreach($add_new_profile_settging as $add_new){
			echo "<option value='{$add_new['profile_setting_name']}###{$add_new['profile_setting_title']}'>{$add_new['profile_setting_title']}</option>";
		}
		echo "</select></td>";
		echo "<td><select name='profile_type_setting_status'><option value='1'>{$info_lang['yes']}</option><option value='0'>{$info_lang['admin_profile_inc_php_10']}</option></select></td>";
		echo "<td><input name='profile_type_setting_sort' type='text' size='5'></td>";
		echo "<td><input type='submit' name='add_profile_type_setting_submit' class='btn' value='{$info_lang['admin_profile_inc_php_15']}' /></td>";
		echo "</tr>";
		showformfooter();
		showtablefooter();
	}
	exit;
}

showtableheader("1. {$info_lang['admin_profile_inc_php_20']}");
$all_profile_type = fetch_all("{$identifier}_profile_type"," ORDER BY profile_type_id ASC ");
echo "<tr>";
echo "<th>{$info_lang['admin_profile_inc_php_21']}</th><th>{$info_lang['admin_profile_inc_php_7']}</th><th></th>";
echo "</tr>";
foreach($all_profile_type as $profile_type){
	echo "<tr>";
	echo "<td><a href='".ADMINSCRIPT."?{$cp_url}&op=profile_type_setting&profile_type_id={$profile_type['profile_type_id']}'>{$profile_type['profile_type_title']}</a></td>";
	
	echo "<td><select name='profile_type_status'><option value='1' ";
	if($profile_type['profile_type_status'])	echo " selected='selected' ";
	echo " >{$info_lang['yes']}</option><option value='0'"; 
	if(!$profile_type['profile_type_status'])	echo " selected='selected' ";
	echo  ">{$info_lang['admin_profile_inc_php_10']}</option></select></td>";
	
	echo "<td> <input type='submit' value='{$info_lang['admin_profile_inc_php_11']}' class='btn' /> | <a href='".ADMINSCRIPT."?{$cp_url}&del_profile_type_id={$profile_type['profile_type_id']}'  onclick=\"return(confirm('{$info_lang['admin_profile_inc_php_12']}?'))\">{$info_lang['del']}</a></td>";
	echo "</tr>";
}

echo "<tr><th colspan='15' class='partition'>+ {$info_lang['admin_profile_inc_php_28']}</th></tr>";
showformheader($self_url);
echo "<tr>";
echo "<td><input type='text' name='profile_type_title'></td>
		<td><select name='profile_type_status'><option value='1'>{$info_lang['yes']}</option><option value='0'>{$info_lang['admin_profile_inc_php_10']}</option></select></td>
		<td><input type='submit' name='add_profile_type_submit' class='btn' value='{$info_lang['admin_profile_inc_php_28']}' /></td>";
echo "</tr>";
showformfooter();
showtablefooter();

showtableheader("2. {$info_lang['admin_profile_inc_php_32']}");
$all_profile_setting = fetch_all("{$identifier}_profile_setting");

echo "<tr>";
echo "<th style='width:200px;'>&nbsp;</th><th>{$info_lang['admin_profile_inc_php_6']}</th><th>{$info_lang['admin_profile_inc_php_7']}</th><th>{$info_lang['admin_profile_inc_php_35']}</th><th>{$info_lang['admin_profile_inc_php_36']}</th><th>{$info_lang['admin_profile_inc_php_37']}</th><th>{$info_lang['admin_profile_inc_php_38']}</th><th>{$info_lang['admin_profile_inc_php_39']}</th><th>{$info_lang['admin_profile_inc_php_40']}</th><th></th>";
echo "</tr>";
foreach($all_profile_setting as $profile_setting){
	showformheader($self_url);
	echo "<tr>";
	echo "<td><input type='text' name='profile_setting_title' value='{$profile_setting['profile_setting_title']}' /></td>";
	echo "<td><input type='text' name='profile_setting_name' value='{$profile_setting['profile_setting_name']}' /></td>";
	echo "<td><select name='profile_setting_status'><option value='1' ";
	if($profile_setting['profile_setting_status'])	echo " selected='selected' ";
	echo " >{$info_lang['yes']}</option><option value='0'"; 
	if(!$profile_setting['profile_setting_status'])	echo " selected='selected' ";
	echo  ">{$info_lang['admin_profile_inc_php_10']}</option></select></td>";
	
	echo "<td><select name='profile_setting_required'><option value='1' ";
	if($profile_setting['profile_setting_required'])	echo " selected='selected' ";
	echo " >{$info_lang['yes']}</option><option value='0'"; 
	if(!$profile_setting['profile_setting_required'])	echo " selected='selected' ";
	echo  ">{$info_lang['admin_profile_inc_php_10']}</option></select></td>";
	
	echo "<td><select name='profile_setting_allowsearch'><option value='1' ";
	if($profile_setting['profile_setting_allowsearch'])	echo " selected='selected' ";
	echo " >{$info_lang['yes']}</option><option value='0'"; 
	if(!$profile_setting['profile_setting_allowsearch'])	echo " selected='selected' ";
	echo  ">{$info_lang['admin_profile_inc_php_10']}</option></select></td>";
	
	echo "<td><select name='profile_setting_formtype'>
	<option value='select' ";
	if($profile_setting['profile_setting_formtype']=='select')	echo " selected='selected' ";
	echo ">{$info_lang['admin_profile_inc_php_47']}</option><option value='checkbox'";
	if($profile_setting['profile_setting_formtype']=='checkbox')	echo " selected='selected' ";
	echo ">{$info_lang['admin_profile_inc_php_48']}</option><option value='input'";
	if($profile_setting['profile_setting_formtype']=='input')	echo " selected='selected' ";
	echo ">{$info_lang['admin_profile_inc_php_49']}</option></select></td>";
	
	echo "<td><textarea name='profile_setting_choices'>{$profile_setting['profile_setting_choices']}</textarea></td>";
	
	echo "<td><input name='profile_setting_size' type='text' size='5' value='{$profile_setting['profile_setting_size']}'></td>";
	
	echo "<td><input name='profile_setting_unit' type='text' size='5' value='{$profile_setting['profile_setting_unit']}'></td>";
	
	echo "<td> <input type='submit' name='edit_profile_setting_submit' value='{$info_lang['admin_profile_inc_php_11']}' class='btn' /> | <a href='".ADMINSCRIPT."?{$cp_url}&del_profile_setting_name={$profile_setting['profile_setting_name']}'  onclick=\"return(confirm('{$info_lang['admin_profile_inc_php_12']}?'))\" >{$info_lang['del']}</a></td>";
	echo "</tr>";
	showformfooter();
}

echo "<tr><th colspan='15' class='partition'>+ {$info_lang['admin_profile_inc_php_53']}</th></tr>";
echo "<tr>";
echo "<th style='width:200px;'>&nbsp;</th><th>{$info_lang['admin_profile_inc_php_6']}</th><th>{$info_lang['admin_profile_inc_php_7']}</th><th>{$info_lang['admin_profile_inc_php_35']}</th><th>{$info_lang['admin_profile_inc_php_36']}</th><th>{$info_lang['admin_profile_inc_php_37']}</th><th>{$info_lang['admin_profile_inc_php_38']}</th><th>{$info_lang['admin_profile_inc_php_39']}</th><th>{$info_lang['admin_profile_inc_php_40']}</th><th></th>";
echo "</tr>";
showformheader($self_url);
echo "<tr>";
echo "
<td><input type='text' name='profile_setting_title'><div>{$info_lang['admin_profile_inc_php_56']} : {$info_lang['admin_profile_inc_php_57']}</div></td>
<td><input type='text' name='profile_setting_name'><div>{$info_lang['admin_profile_inc_php_55']} : cardtype</div></td>
		<td><select name='profile_setting_status'><option value='1'>{$info_lang['yes']}</option><option value='0'>{$info_lang['admin_profile_inc_php_10']}</option></select></td>
		<td><select name='profile_setting_required'><option value='1'>{$info_lang['yes']}</option><option value='0'>{$info_lang['admin_profile_inc_php_10']}</option></select></td>
		<td><select name='profile_setting_allowsearch'><option value='1'>{$info_lang['yes']}</option><option value='0'>{$info_lang['admin_profile_inc_php_10']}</option></select><p>{$info_lang['admin_profile_inc_php_3']}</p></td>
		<td><select name='profile_setting_formtype'><option value='select'>{$info_lang['admin_profile_inc_php_47']}</option><option value='checkbox'>{$info_lang['admin_profile_inc_php_48']}</option><option value='input'>{$info_lang['admin_profile_inc_php_49']}</option></select></td>
		<td><textarea name='profile_setting_choices'></textarea><p class='tips'>{$info_lang['admin_profile_inc_php_67']}</p></td>
		<td><input name='profile_setting_size' type='text' size='5'></td>
		<td><input name='profile_setting_unit' type='text' size='5'></td>
		<td><input type='submit' name='add_profile_setting_submit' class='btn' value='{$info_lang['admin_profile_inc_php_68']}' /></td>";
echo "</tr>";
showformfooter();
showtablefooter();
if( !cloudaddons_getmd5("info.plugin") ) { cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "info.plugin"));}

?>