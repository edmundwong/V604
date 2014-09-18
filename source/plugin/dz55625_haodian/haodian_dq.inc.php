<?php
/*
	[55625.COM!] (C)2001-2012 55625.COM Inc.
	BY QQ:114512039  Lovenr
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

include_once 'language.'.currentlang().'.php';
$operation = $_GET['operation'];
if($operation == 'del') {
	$lid = intval($_GET['lid']);
	if($lid) {
		$upcid = DB::result_first("SELECT upid FROM ".DB::table('forum_alliance_fl')." WHERE id='$lid'");
		if($upcid) {
			$subid = DB::result_first("SELECT subid FROM ".DB::table('forum_alliance_fl')." WHERE id='$upcid'");
			$subarr = explode(",", $subid);
			foreach($subarr as $key=>$value) {
				if($value == $lid) {
					unset($subarr[$key]);
					break;
				}
			}
			DB::query("UPDATE ".DB::table('forum_alliance_fl')." SET subid='".implode(",", $subarr)."' WHERE id='$upcid'");
		}
		DB::query("DELETE FROM ".DB::table('forum_alliance_fl')." WHERE id='{$lid}'");
	}
	cpmsg($php_lang['lshanchuok'], 'action=plugins&operation=config&identifier=dz55625_haodian&pmod=haodian_dq', 'succeed');	
}

if(!submitcheck('editsubmit')) {	

?>
<script type="text/JavaScript">
var rowtypedata = [
	[[1,'<input type="text" class="txt" name="newlocalorder[]" value="0" />', 'td25'], [2, '<input name="newlocal[]" value="" size="20" type="text" class="txt" />']],
	[[1,'<input type="text" class="txt" name="newsuborder[{1}][]" value="0" />', 'td25'], [2, '<div class="board"><input name="newsublocal[{1}][]" value="" size="20" type="text" class="txt" /></div>']],
	
	];

function del(id) {
	if(confirm('<?php echo $php_lang['delclass'];?>')) {
		window.location = '<?php echo ADMINSCRIPT;?>?action=plugins&operation=config&identifier=dz55625_haodian&pmod=haodian_dq&operation=del&lid='+id;
	} else {
		return false;
	}
}
</script>
<?php
	showformheader('plugins&operation=config&identifier=dz55625_haodian&pmod=haodian_dq');
	showtableheader('');
	showsubtitle(array($php_lang['paixuss'], $php_lang['fenleiname'],  $php_lang['caozuodei']));

	$haodian_dq = array();
	$query = DB::query("SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE upid='0' ORDER BY displayorder ASC");
	while($row = DB::fetch($query)) {
		$haodian_dq[$row['id']] = $row;
		$squery = DB::query("SELECT * FROM ".DB::table('forum_alliance_fl')." WHERE upid='{$row['id']}' ORDER BY displayorder ASC");
		while($srow = DB::fetch($squery)) {
			$haodian_dq[$row['id']]['sublocal'][$srow['id']] = $srow;
		}
	}
	if($haodian_dq) {
		foreach($haodian_dq as $id=>$local) {
			$show = '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$id.']" value="'.$local['displayorder'].'" /></td><td><div class="parentboard"><input type="text" class="txt" name="name['.$id.']" value="'.$local['subject'].'"></div></td>';
			if(!$local['subid']) {
				$show .= '<td><a  onclick="del('.$id.')" href="###">'.$php_lang['shanchuss'].'</td></tr>';
			} else {
				$show .= '<td>&nbsp;</td></tr>';
			}
			echo $show;
			if($local['sublocal']) {
				foreach($local['sublocal'] as $subid=>$slocal) {
					echo '<tr class="hover"><td class="td25"><input type="text" class="txt" name="order['.$subid.']" value="'.$slocal['displayorder'].'" /></td><td><div class="board"><input type="text" class="txt" name="name['.$subid.']" value="'.$slocal['subject'].'"></div></td><td><a  onclick="del('.$subid.')" href="###">'.$php_lang['shanchuss'].'</td></tr>';
				}
				
			}
			echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div class="lastboard"><a href="###" onclick="addrow(this, 1,'.$id.' )" class="addtr">'.$php_lang['addclass'].'</a></div></td></tr>';
		}	
	}
	echo '<tr class="hover"><td class="td25">&nbsp;</td><td colspan="2" ><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.$php_lang['newclass'].'</a></div></td></tr>';
	

	showsubmit('editsubmit');
	showtablefooter();
	showformfooter();

} else {
	$order = $_GET['order'];
	$name = $_GET['name'];
	$newsublocal = $_GET['newsublocal'];
	$newlocal = $_GET['newlocal'];
	$newsuborder = $_GET['newsuborder'];
	$newlocalorder = $_GET['newlocalorder'];
	
	if(is_array($order)) {
		foreach($order as $id=>$value) {
			DB::update('forum_alliance_fl', array('displayorder' => intval($order[$id]), 'subject' => $name[$id]), "id='$id'");
		}
	}

	if(is_array($newlocal)) {
		foreach($newlocal as $key=>$name) {
			if(empty($name)) {
				continue;
			}
			$cid = DB::insert('forum_alliance_fl', array('upid' => '0', 'subject' => $name, 'displayorder' => $newlocalorder[$key]), 1);
		}
	}

	if(is_array($newsublocal)) {
		foreach($newsublocal as $cid=>$sublocal) {
			$subtype = DB::result_first("SELECT subid FROM ".DB::table('forum_alliance_fl')." WHERE id='{$cid}'");
			foreach($sublocal as $key=>$name) {
				$subid = DB::insert('forum_alliance_fl', array('upid' => $cid, 'subject' => $name, 'displayorder' => $newsuborder[$cid][$key]), 1);
				$subtype .= $subtype ? ','.$subid : $subid;
			}
			DB::query("UPDATE ".DB::table('forum_alliance_fl')." SET subid='{$subtype}' WHERE id='{$cid}'");
		}
	}

	//¸üÐÂ»º´æ
	cpmsg($php_lang['gengxinoks'], 'action=plugins&operation=config&identifier=dz55625_haodian&pmod=haodian_dq', 'succeed');	
}

?>



