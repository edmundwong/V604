<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('milu_pick:pick_header'); ?><script type="text/javascript" language="javascript">
function pick_log(pid){
showWindow('kk', PICK_URL+'picker_manage&myfunc=ajax_func&inajax=1&af=pick_log_list&tpl=no&pid='+pid);
}
function del_log(pid,filename,k){
ajaxget(PICK_URL+'picker_manage&myfunc=ajax_func&inajax=1&af=del_log&inajax=1&tpl=no&pid='+pid+'&file_name='+filename, 'threadtypes');
$("log_list").removeChild($("log_"+k));
}

function op_change_show(value){
if(value == 'move'){
ajaxget(PICK_URL+'picker_manage&myfunc=ajax_func&inajax=1&af=show_pick_class&inajax=1&tpl=no&xml=1', 'show_op_class');
}else{
$("show_op_class").innerHTML = '';
}
}

var rowtypedata = [

[[1,'', 'td25'],[1,'', 'td25'],[1,'<input type="text" class="txt" name="neworder[{1}][]" value="0" />', 'td25'], [3, '<div class="parentboard"><input type="text" class="txt" value="添加分类" name="newname[{1}][]"/><a onclick="deleterow(this)" class="deleterow" href="javascript:;">删除</a></div>']],
];
function picker_share(pid, pick_name){
if(!is_lan == 'yes') {
showDialog("!share_no_allow!", 'notice');
return;
}	
show_html_window('share_pick', '分享采集器', 410, 287, '<div class="c bart" style=" width:100%; height:210px;"><p style=" height:23px;line-height:23px;margin-top:15px;"><span style=" float:left;width:70px;">采集器名称:</span><input type="text" class="txt" id="pick_name" value="'+pick_name+'" name="pick_name" style="float:left; margin:0 10px; width:175px"></p><p style=" display:block; float:left; margin:10px 0;"><span style=" float:left;margin:0 0 10px 0; ">规则描述:</span><textarea  class="warea" cols="50" id="picker_desc" name="picker_desc" rows="6" ></textarea></p></div><p class="o pns"><button onclick="share_picker_data('+pid+');" class="pn pnc" name="dsf" type="submit"><span>确定</span></button><button onclick="hideWindow(\'share_pick\');" class="pn" name="dsf" type="reset"><em>取消</em></button></p>');
}

function import_article(pid){
var html = '<form action="'+PICK_URL+'picker_manage&myac=import_article&pid='+pid+'" method="post" enctype="multipart/form-data" name="cpform" id="cpform" autocomplete="off"><p align="center" style=" height:30px;">导入zip文件：</p><p style=" height:70px;" align="center"><input  name="file" type="file" id="file"></p><p class="o pns"><button class="pn pnc" name="dsf" type="submit"><span>确定</span></button><button onclick="hideWindow(\'import_article\');" class="pn" name="dsf" type="reset"><em>取消</em></button></p></div></form>';
show_html = '<h3 class="flb">导入文章<span><a href="javascript:;" class="flbc" onclick="hideWindow(\'import_article\');" title="关闭">点击就关闭窗口</a></span></h3><div class="article_detail c" style="width:350px;height:150px;overflow-y:scroll;">'+html+'</div>';
showWindow('import_article', show_html, 'html');
}

</script>
<style>
.td25{ width:20px; overflow:hidden}
.act{ margin:0 3px;}
</style>
<form action="?<?php echo PICK_GO;?>picker_manage" method="post" enctype="multipart/form-data" name="cpform" id="cpform" autocomplete="off">
  <input type="hidden" value="4e816df0" name="formhash"><input type="hidden" value="" name="scrolltop" id="formscrolltop"><input type="hidden" value="" name="anchor">
  

  <div style="height:30px;line-height:30px; width:340px;  float:none; clear:both"><span style="float:left"><a onclick="show_all()" href="javascript:;">全部展开</a> | <a onclick="hide_all()" href="javascript:;">全部折叠</a> <input type="text" class="txt" id="srchforumipt"></span> <input style="float:right" type="submit" onclick="return srchforum()" value="搜索" class="btn"></div>
  
<table class="tb tb2 ">
<tbody id="hidden_system_category_stat" class="sub">

<tr><td colspan="2">
<table class="tb tb2 ">
  <tr class="header">
    <th ></th>
    <th>&nbsp;</th>
    <th>顺序</th>
  <th>名称</th>
     <th>未导文章/总文章</th>
  <th colspan="2">上次执行 / 下次执行</th>
  <th>操作</th>
  </tr>
  <?php if(is_array($cat_arr)) foreach($cat_arr as $key_c => $rs_c) { ?>  
  <tr class="hover">
    <td class="td25" onclick="toggle_group('group_<?php echo $rs_c['cid'];?>')" ><a href="javascript:;" id="a_group_<?php echo $rs_c['cid'];?>">[-]</a></td>
    <td class="td25">&nbsp;</td>
    <td class="td25"><input type="text" value="<?php echo $rs_c['displayorder'];?>" name="cate_setarr[<?php echo $rs_c['cid'];?>][displayorder]" class="txt"></td>
    <td><div class="parentboard"><input type="text" class="txt" value="<?php echo $rs_c['name'];?>" name="cate_setarr[<?php echo $rs_c['cid'];?>][name]"></div></td>
      <td colspan="3">&nbsp;</td>
    <td><a class="act" href="?<?php echo PICK_GO;?>picker_manage&cid=<?php echo $rs_c['cid'];?>&myaction=pick_del_category">删除</a></td>
  </tr>
  <tbody id="group_<?php echo $rs_c['cid'];?>">
   	   <?php if(is_array($data[$rs_c['cid']])) foreach($data[$rs_c['cid']] as $key => $rs) { ?>   
   <tr class="hover">
     <td class="td25">&nbsp;</td>
      <td class="td25">
<input type="checkbox" name="pid[]" value="<?php echo $rs['pid'];?>"  class="checkbox">
        </td>
      <td class="td25"><input type="text" value="<?php echo $rs['displayorder'];?>" name="pick_setarr[<?php echo $rs['pid'];?>][displayorder]" class="txt"></td><td><div class="board"><?php echo $rs['name'];?><input type="hidden" class="txt" value="<?php echo $rs['name'];?>" name="name[<?php echo $rs['pid'];?>]"></div></td>
       <td><?php echo $rs['no_import_count'];?>/<?php echo $rs['article_count'];?></td>
   <td colspan="2"><?php if($rs['is_auto_pick'] > 0) { if($rs['lastrun_show'] || $rs['nextrun_show']) { ?><?php echo $rs['lastrun_show'];?> / <?php echo $rs['nextrun_show'];?><?php } else { ?>等待触发<?php } } ?></td>
    <td>
<a class="act" href="?<?php echo PICK_GO;?>picker_manage&pid=<?php echo $rs['pid'];?>&myaction=get_article">采集</a>
<a class="act" href="?<?php echo PICK_GO;?>picker_create&pid=<?php echo $rs['pid'];?>&add=copy">复制</a>
<a class="act" href="?<?php echo PICK_GO;?>picker_manage&myaction=edit_pick&pid=<?php echo $rs['pid'];?>">编辑</a>
<a class="act" href="?<?php echo PICK_GO;?>picker_manage&pid=<?php echo $rs['pid'];?>&myaction=pick_del">删除</a>
<a class="act" href="?<?php echo PICK_GO;?>picker_manage&pid=<?php echo $rs['pid'];?>&myaction=export&pid=<?php echo $rs['pid'];?>">导出</a>
<a class="act" href="?<?php echo PICK_GO;?>picker_manage&pid=<?php echo $rs['pid'];?>&myaction=pick_empty">清空</a>


<a class="act" href="?<?php echo PICK_GO;?>picker_manage&myac=article_manage&pid=<?php echo $rs['pid'];?>&p=1">查看文章</a>  
<a class="pick_addtr" href="javascript:void(0);" onclick="show_more('more_op_<?php echo $rs['pid'];?>')">更多操作</a>
</br>
<span id="more_op_<?php echo $rs['pid'];?>" style="display:none">
<a class="act" href="javascript:void(0);" onclick="picker_share('<?php echo $rs['pid'];?>', '<?php echo $rs['name'];?>')" >分享</a>
<a class="act" href="javascript:void(0)" onclick="rules_trun('<?php echo $rs['pid'];?>', 'picker')">转换</a>
<?php if(!VIP) { ?>
<a class="act" href="javascript:void(0);" onclick="pick_log('<?php echo $rs['pid'];?>')" >日志</a>
<a class="act" href="javascript:void(0);" onclick="import_article(<?php echo $rs['pid'];?>)">导入文章</a>
<a class="act" href="?<?php echo PICK_GO;?>picker_manage&myac=export_article&pid=<?php echo $rs['pid'];?>&tpl=no">导出文章</a>
<?php } ?>
 
 <!-- <a class="act" title="�鿴ͳ����Ϣ" href="?<?php echo PICK_GO;?>picker_manage&myaction=article_list&pid=<?php echo $rs['pid'];?>">�鿴ͳ��</a>-->   
   </span>	   </td>
     </tr>
   <?php } ?>
    <tr>
     <td class="td25"></td>
      <td class="td25"></td>
      <td class="td25"></td><td colspan="3"><div class="lastboard"><a href="?<?php echo PICK_GO;?>picker_create&pick_cid=<?php echo $rs_c['cid'];?>" class="addtr">添加采集器</a></div></td>
     </tr>
   </tbody> 
   <?php } ?>
  
  
     <tr><td class="td25">&nbsp;</td>
        <td class="td25">&nbsp;</td>
        <td class="td25">&nbsp;</td><td colspan="3"><div><a href="javascript:void(0)" onclick="addrow(this, 0, 0)" class="addtr">添加分类</a></div></td>
     </tr>
   <tr>
     <td colspan="6" class="td25"><div class="fixsel" style="float:left; width:650px; height:35px; line-height:35px;">
 <span style="float:left; margin-left:30px;"><input type="checkbox" name="chkall" onclick="checkAll('prefix', this.form, 'pid')" class="checkbox">
  全选 
  <label>
  <select id="op_change" name="pick_op" style="width:70px;" onchange="op_change_show(this.value);">
  	<option value="0">请选择</option>
    <option value="del">删除</option>
    <option value="move">转移</option>
  </select>
 <span id="show_op_class"></span>
  </label>
  &nbsp;</span>
       <input type="submit" value="提交" title="按 Enter 键可随时提交你的修改" name="submit" id="submit_submit" class="btn">
       </div></td>
      </tr>
</table>
</td></tr>
</tbody></table>

</form>