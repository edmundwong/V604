<?php
/**
 *      版权声明: 该程序为 [DiscuzCMS!] 独立自主开发, 依法拥有该产品知识产权,所有代码版权归[DiscuzCMS!]所有, 程序内均为商业代码, 仅为购买者提供使用授权.
 *		法律声明: 未经官方授权使用修改或者传播都是属于侵权和违法行为, 依法将追究一切相关法律责任.
 *		官方网站: http://www.DiscuzCMS.com 
**/

 
if(!defined('IN_ADMINCP')){	exit('Admin Login');}
if(!defined('IN_DISCUZ')) {	exit('Access Denied');}
require DISCUZ_ROOT.'./source/plugin/sale/include/config.inc.php';
require DISCUZ_ROOT.'./source/plugin/sale/include/function.class.php';

$identifier = "sale";
$mod = "admin_area";
$self_url = 'plugins&operation=config&identifier='.$identifier.'&pmod='.$mod."&do=".$do;
$cp_url ='action='.$self_url;
$now_url = ADMINSCRIPT.'?'.$cp_url;

$values = array(intval($_GET['pid']), intval($_GET['cid']), intval($_GET['did']));
$elems = array(addslashes($_GET['province']), addslashes($_GET['city']), addslashes($_GET['district']));if( !cloudaddons_getmd5("sale.plugin") ) {/* cpmsg(lang('admincp_msg','cloudaddons_genuine_message'),'','error',array('addonid' => "sale.plugin"));*/}

$level = 1;
$upids = array(0);
$theid = 0;
for($i=0;$i<3;$i++) {
	if(!empty($values[$i])) {
		$theid = intval($values[$i]);
		$upids[] = $theid;
		$level++;
	} else {
		for($j=$i; $j<3; $j++) {
			$values[$j] = '';
		}
		break;
	}
}

if(submitcheck('editsubmit')) {
	$delids = array();
	$query = DB::query('SELECT * FROM '.DB::table($identifier.'_area')." WHERE upid ='$theid'");
	while($value = DB::fetch($query)) {
		$usetype = 0;
		if($_POST['birthcity'][$value['id']] && $_POST['city'][$value['id']]) {
			$usetype = 3;
		} elseif($_POST['birthcity'][$value['id']]) {
			$usetype = 1;
		} elseif($_POST['city'][$value['id']]) {
			$usetype = 2;
		}
		if(!isset($_POST['district'][$value['id']])) {
			$delids[] = $value['id'];
		} elseif($_POST['district'][$value['id']] != $value['name'] || $_POST['displayorder'][$value['id']] != $value['displayorder'] || $usetype != $value['usetype']) {
			DB::update($identifier.'_area', array('name'=>$_POST['district'][$value['id']], 'displayorder'=>$_POST['displayorder'][$value['id']], 'usetype'=>$usetype), array('id'=>$value['id']));
		}
	}
	if($delids) {
		$ids = $delids;
		for($i=$level; $i<4; $i++) {
			$query = DB::query('SELECT id FROM '.DB::table($identifier.'_area')." WHERE upid IN (".dimplode($ids).')');
			$ids = array();
			while($value=DB::fetch($query)) {
				$value['id'] = intval($value['id']);
				$delids[] = $value['id'];
				$ids[] = $value['id'];
			}
			if(empty($ids)) {
				break;
			}
		}
		DB::query('DELETE FROM '.DB::table($identifier.'_area')." WHERE id IN (".dimplode($delids).')');
	}
	if(!empty($_POST['districtnew'])) {
		$inserts = array();
		$displayorder = '';
		foreach($_POST['districtnew'] as $key => $value) {
			$displayorder = trim($_POST['districtnew_order'][$key]);
			$value = trim($value);
			if(!empty($value)) {
				$inserts[] = "('$value', '$level',  '$theid', '$displayorder')";
			}
		}
		if($inserts) {
			DB::query('INSERT INTO '.DB::table($identifier.'_area')."(`name`, level, upid, displayorder) VALUES ".implode(',',$inserts));
		}
	}
	cpmsg('setting_district_edit_success', $cp_url.'&pid='.$values[0].'&cid='.$values[1].'&did='.$values[2], 'succeed');
	
} else {
	showsubmenu('district');
	showtips('district_tips');
	
	showformheader($self_url.'&pid='.$values[0].'&cid='.$values[1].'&did='.$values[2]);
	showtableheader();
	
	$options = array(1=>array(), 2=>array(), 3=>array());
	$thevalues = array();
	$query = DB::query('SELECT * FROM '.DB::table($identifier.'_area')." WHERE upid IN (".dimplode($upids).') ORDER BY displayorder');
	while($value = DB::fetch($query)) {
		$options[$value['level']][] = array($value['id'], $value['name']);
		if($value['upid'] == $theid) {
			$thevalues[] = array($value['id'], $value['name'], $value['displayorder'], $value['usetype']);
		}
	}
	
	$names = array('province', 'city', 'district');
	for($i=0; $i<3;$i++) {
		$elems[$i] = !empty($elems[$i]) ? $elems[$i] : $names[$i];
	}
	$html = '';
	for($i=0;$i<3;$i++) {
		$l = $i+1;
		$jscall = ($i == 0 ? 'this.form.city.value=\'\';this.form.district.value=\'\';' : '')."refreshdistrict('$elems[0]', '$elems[1]', '$elems[2]')";
		$html .= '<select name="'.$elems[$i].'" id="'.$elems[$i].'" onchange="'.$jscall.'">';
		$html .= '<option value="">'.lang('spacecp', 'district_level_'.$l).'</option>';
		foreach($options[$l] as $option) {
			$selected = $option[0] == $values[$i] ? ' selected="selected"' : '';
			$html .= '<option value="'.$option[0].'"'.$selected.'>'.$option[1].'</option>';
		}
		$html .= '</select>&nbsp;&nbsp;';
	}
	echo cplang('district_choose').' &nbsp; '.$html;
	showsubtitle(array('', 'display_order', 'name', 'operation'));
	foreach($thevalues as $value) {
		$valarr = array();
		$valarr[] = '';
		$valarr[] = '<input type="text" id="displayorder_'.$value[0].'" class="txt" name="displayorder['.$value[0].']" value="'.$value[2].'"/>';
		$valarr[] = '<p id="p_'.$value[0].'"><input type="text" id="input_'.$value[0].'" class="txt" name="district['.$value[0].']" value="'.$value[1].'"/></p>';
		/*
		if(!$values[0]) {
			$valarr[] = '<input type="checkbox" name="birthcity['.$value[0].']" value="1" class="checkbox"'.($value[3] && in_array($value[3], array(1,3)) ? ' checked="checked" ':'').' />';
			$valarr[] = '<input type="checkbox" name="city['.$value[0].']" value="1" class="checkbox"'.($value[3] && in_array($value[3], array(2,3)) ? ' checked="checked" ':'').' />';
		}*/
		$valarr[] = '<a href="javascript:;" onclick="deletedistrict('.$value[0].');return false;">'.cplang('delete').'</a>';
		showtablerow('id="td_'.$value[0].'"', array('', 'class="td25"','','','',''), $valarr);
	}
	showtablerow('', array('colspan=2'), array(
				'<div><a href="javascript:;" onclick="addrow(this, 0, 1);return false;" class="addtr">'.cplang('add').'</a></div>'
				));
	showsubmit('editsubmit', 'submit');
	$adminurl = $now_url;
	echo "
<script type='text/javascript'>
var rowtypedata = [
[[1,'', ''],[1,'<input type=\'text\' class=\'txt\' name=\'districtnew_order[]\' value=\'0\' />', 'td25'],[2,'<input type=\'text\' class=\'txt\' name=\'districtnew[]\' value=\'\' />', '']],
];

function refreshdistrict(province, city, district) {
location.href = '{$adminurl}'
+ '&province='+province+'&city='+city+'&district='+district
+'&pid='+$(province).value + '&cid='+$(city).value+'&did='+$(district).value;
}

function editdistrict(did) {
$('input_' + did).style.display = 'block';
$('span_' + did).style.display = 'none';
}

function deletedistrict(did) {
var elem = $('p_' + did);
elem.parentNode.removeChild(elem);
var elem = $('td_' + did);
elem.parentNode.removeChild(elem);
}
</script>
";
	showtablefooter();
	showformfooter();
}
?>
