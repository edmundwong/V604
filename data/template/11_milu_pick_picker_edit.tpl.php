<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('milu_pick:pick_header'); ?><script src="<?php echo PICK_URL;?>static/phprpc_client.js?v=<?php echo PICK_VERSION;?>" type="text/javascript"></script>
<script src="static/js/calendar.js?v=<?php echo PICK_VERSION;?>" type="text/javascript" type="text/javascript" type="text/javascript"></script>
<script>
function check_pick_edit(){
var pick_name = $("pick_name").value;
if(!pick_name) {
showDialog('请至少填写采集器名称!', 'notice');
return false;
}
}
</script>
<div class="itemtitle">
<ul id="tab_menu" class="tab1" style="margin-top:8px;">
<li <?php if($step == 1) { ?>class="current" <?php } ?>><a ><span>基本配置</span></a></li>
<li <?php if($step == 2) { ?>class="current" <?php } ?>><a >网址规则</a></li>
<li <?php if($step == 3) { ?>class="current" <?php } ?>><a ><span>内容规则</span></a></li>
<li <?php if($step == 4) { ?>class="current" <?php } ?>><a ><span>发布设置</span></a></li>
<li <?php if($step == 5) { ?>class="current" <?php } ?>><a ><span>其他设置</span></a></li>
</ul>
</div>
</ul>

<form id="cpform" action="?<?php echo PICK_GO;?>picker_create" autocomplete="off" method="post" name="cpform" onsubmit="return check_pick_edit();">
  <input name="add" type="hidden" value="<?php echo $_GET['add'];?>" />
<input name="pid" type="hidden" value="<?php echo $info['pid'];?>" />
<input name="step" type="hidden" id="step" value="<?php echo $step;?>" />
<table  class="tab_content tb tb2" <?php if($step == 1) { ?>style="display:block"<?php } else { ?>style="display:none"<?php } ?>>
<tbody>
<tr onMouseOver="setfaq(this, 'faq1')">
  <td s="1" class="td27 model-1" colspan="2"><span class="vtop rowform">规则名称:</span></td>
</tr>
<tr  class="model-1"><td width="600" class="vtop rowform"><input name="set[name]" type="text" class="txt" id="pick_name" value="<?php echo $info['name'];?>"></td>
<td class="vtop tips2" s="1">请取个名称，便于区分</td>
</tr>

<tr onMouseOver="setfaq(this, 'faq1')">
  <td s="1" class="td27 model-1" colspan="2"><span class="vtop rowform">规则所属分类:</span></td>
</tr>
<tr class="noborder" >
  <td class="vtop rowform"><?php echo select_output(pick_category_list(TRUE), '', 'set[pick_cid]', $info['pick_cid'], 1);?></td>
  <td class="vtop tips2" s="1">分类，方便自己管理</td>
</tr>

<tr >
  <td colspan="2" class="td27" s="1">采集模式:</td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);">
 
<li <?php if($info['rules_type'] == 3 || !$info['rules_type']) { ?> class="checked" <?php } ?>>
    <label>
    <input onclick="show_hide('system_rules+show_url_var_set+one_pick','system_rules+show_url_var_set+pick_content_type+need_login+show_login',1);rules_show_page_set(3);"  <?php if($info['rules_type'] == 3 || !$info['rules_type']) { ?>checked="checked"<?php } ?> class="rules_type" type="radio" name="set[rules_type]" value="3" />
    </label>
    一键采集</li>
  <li <?php if($info['rules_type'] == 1) { ?> class="checked" <?php } ?>>
    <label>
    <input onclick="show_hide('system_rules+show_url_var_set','one_pick+pick_content_type',1);rules_show_page_set(1);hide_get_page('<?php echo $info['rules_hash'];?>')"  <?php if($info['rules_type'] == 1) { ?>checked="checked"<?php } ?> class="rules_type" type="radio" name="set[rules_type]" value="1" />
    </label>
    内置规则</li>
  <li <?php if($info['rules_type'] == 2) { ?> class="checked" <?php } ?>>
    <input onclick="show_hide('system_rules+show_url_var_set+one_pick','pick_content_type',2);rules_show_page_set(2);"  <?php if($info['rules_type'] == 2) { ?>checked="checked"<?php } ?> class="rules_type" type="radio" name="set[rules_type]" value="2" />
    自定义  </li>
</ul></td>
<td class="vtop tips2" s="1">&nbsp;</td>
</tr>

<tbody id="one_pick" style="display:<?php if($info['rules_type'] != 3 ) { } else { ?>none<?php } ?>">
<tr class="noborder" ><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[manyou_start_url]" id="manyou_start_url" cols="50" class="tarea w_area" ><?php echo $info['manyou_start_url'];?></textarea></td>
<td class="vtop tips2" s="1">输入<font color="red">文章列表地址</font>，无需其他设置，提交就可以采集了。<br></td>
</tr>
</tbody>
 
<tbody id="need_login" <?php if($info['rules_type'] == 3 || !$info['rules_type']) { ?>style="display:none"<?php } ?>>
<tr >
  <td colspan="2" class="td27" s="1">是否需要cookie支持:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['is_login'] == 1) { ?> class="checked" <?php } ?>><input <?php if($info['is_login'] == 1) { ?> checked="checked" <?php } ?> name="set[is_login]" type="radio" onclick="show_hide('show_login','',1);"  class="is_login" value="1">
&nbsp;是</li><li <?php if($info['is_login'] != 1) { ?> class="checked" <?php } ?>><input  type="radio" <?php if($info['is_login'] != 1) { ?> checked="checked" <?php } ?>  value="2" name="set[is_login]" onclick="show_hide('show_login','',2);" class="is_login">
&nbsp;否</li></ul></td>
<td s="1" class="vtop tips2">&nbsp;</td>
</tr>
</tbody>

<tbody id="show_login" <?php if($info['is_login'] != 1) { ?>style="display:none"<?php } ?>>
<tr >
  <td colspan="2" class="td27" s="1">cookie:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>

<tr class="noborder" ><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[login_cookie]" id="login_cookie" cols="50" class="tarea w_area" ><?php echo $info['login_cookie'];?></textarea></td>
<td class="vtop tips2" s="1">&nbsp;</td>
</tr>
<tr onMouseOver="setfaq(this, 'faq1')">
  <td s="1" class="td27" colspan="2"><span class="vtop rowform">测试地址:</span></td>
</tr>
<tr ><td width="600" class="vtop rowform"><input name="set[login_test_url]" type="text" class="txt" id="login_test_url" value="<?php echo $info['login_test_url'];?>"></td>
<td class="vtop tips2" s="1">&nbsp;</td>
</tr>

<tr >
  <td s="1" class="td27" colspan="2"><span class="vtop rowform"><a onclick="login_test()" href="javascript:void(0);">点击查看测试结果</a></span></td>
</tr>
</tbody>

 


<tbody id="system_rules" style="display:<?php if($info['rules_type'] == 1) { } else { ?>none<?php } ?>">


    <tr >
      <td s="1" class="td27 model-1" colspan="2"><span class="vtop rowform">输入任意网址，以便分析其结构:<span style=" font-weight:normal">(输入文章列表页或者文章详细页的地址)</span></span>:</td>
    </tr>
    <tr  class="noborder">
      <td class="vtop rowform"><input name="set[rules_match_url]" type="text" class="longtxt" id="rules_match_url" value="<?php echo $info['rules_match_url'];?>" />
        <span class="td27"></span> </td>
      <td s="1" class="vtop tips2"><a style="color:#0099cc" href="javascript:void(0)" onclick="match_rules()">点击自动匹配规则</a><span style="margin-left:5px;" id="show_match_rules_result"></span></td>
    </tr>

<tr >
  <td colspan="2" class="td27" s="1"><label>内置规则选择:</label>
      <span style="font-weight:normal" id="show_rules_select"><?php show_rules_select(array('no_ajax' => 1, 'select_id' => $info['rules_hash']));?></span>
  
  </td>
</tr>
</tbody>
</tbody>
<tbody id="show_url_var_set" style="display:<?php if($info['rules_type'] != 2) { } else { ?>none<?php } ?>"><?php echo show_rules_set(0, array('rules_hash' => $info['rules_hash'] ,'rules_set' => $info['rules_var']));?></tbody>
</table>
<table class="tab_content tb tb2" <?php if($step == 2) { ?>style="display:block"<?php } else { ?>style="display:none"<?php } ?>>
<tr id="page_url_hide_notice"  style="display:none">
  <th class="partition" colspan="15">采集范围设置:<font style="font-weight:normal; color:red;">此处由采集器自动处理</font></th>
</tr>
<tbody id="model-r" style="display:<?php if($info['pick_type'] ) { ?> none <?php } ?>">
<tr>
  <th colspan="15" class="partition">采集范围设置</th>
</tr>
<tr >
  <td colspan="2" class="td27" s="1">采集范围选择:</span></td>
</tr>
<tr  class="noborder">
<td colspan="2" class="vtop rowform" >
<ul id="ul_url_range_type"  class="myul" onMouseOver="altStyle(this);" ><li id="li_url_range_type_page" <?php if($info['url_range_type'] == 1 || !$info['url_range_type']) { ?> class="checked" <?php } ?>><input id="url_range_type_page" name="set[url_range_type]" type="radio" class="url_range_type" onclick="show_hide('show_get_page+show_page_link+model-url-1','show_manyou+show_rss+many_list_page',1);" value="1"  <?php if($info['url_range_type'] == 1 || !$info['url_range_type']) { ?> checked="checked" <?php } ?>>
&nbsp;从分页列表采集文章</li>
  <li <?php if($info['url_range_type'] == 2) { ?> class="checked" <?php } ?>><input id="article_get_type_detail" <?php if($info['url_range_type'] == 2) { ?> checked="checked" <?php } ?>  onclick="show_hide('model-url-1+','show_manyou+show_rss+show_page_link+many_list_page+show_get_page',1);" name="set[url_range_type]" type="radio" class="url_range_type" value="2">
 从URL范围采集文章  </li>
    <li <?php if($info['url_range_type'] == 4) { ?> class="checked" <?php } ?>><input id="article_get_type_detail" <?php if($info['url_range_type'] == 4) { ?> checked="checked" <?php } ?>  onclick="show_hide('show_rss','show_get_page+show_manyou+show_page_link+model-url-1+many_list_page',1);" name="set[url_range_type]" type="radio" class="url_range_type" value="4">
  从RSS地址采集  </li>
  <li <?php if($info['url_range_type'] == 5) { ?> class="checked" <?php } ?>><input id="article_get_type_detail" <?php if($info['url_range_type'] == 5) { ?> checked="checked" <?php } ?>  onclick="show_hide('many_list_page','show_get_page+show_manyou+show_page_link+model-url-1+show_rss',1);" name="set[url_range_type]" type="radio" class="url_range_type" value="5">
  从多层列表中采集  </li>
</ul></td></tr>
</tbody>
<tbody id="model-url-1" style="display:<?php if($info['url_range_type'] == 2 || $info['url_range_type'] == 1 || !$info['url_range_type']) { } else { ?> none <?php } ?>">
<tr >
  <td s="1" class="td27 model-1" colspan="2"><span class="vtop rowform">网址范围:&nbsp;&nbsp;&nbsp;<a  style="<{ <?php if($info['page_get_type'] != 2) { ?>>display:none<<?php } ?>>" href="javascript:void(0)"  onclick="insertAtCursor('url_page_range','(*)')">插入可变区域(*)</a>&nbsp;&nbsp;&nbsp;</span></td>
</tr>
<tr  class="model"><td class="vtop rowform"><input name="set[url_page_range]" type="text" style="width:550px;" class="longtxt" id="url_page_range" value="<?php echo $info['url_page_range'];?>"></td>
<td s="1" class="vtop tips2">变化的地方请用(*)代替</td>
</tr>

<tr >
  <td colspan="2" class="td27" s="1">网址扩展设置:</td>
</tr>
<tr class="noborder" >
  <td class="vtop rowform"><div style="width:600px;"><label>
    <input name="set[page_url_auto]" type="checkbox" id="page_url_auto" <?php if($info['page_url_auto']) { ?>checked="checked"<?php } ?> value="1" />
    自动补0</label> 
    <span>&nbsp;&nbsp; 从
    <input name="set[page_url_auto_start]" style="width:60px;" type="text" class="txt" id="page_url_auto_start" value="<?php echo $info['page_url_auto_start'];?>" />
    </span>
<span>到
<input name="set[page_url_auto_end]" style="width:60px;" type="text" class="txt" id="page_url_auto_end" value=" <?php echo $info['page_url_auto_end'];?>" />
&nbsp;&nbsp; 每次增长
    <input name="set[page_url_auto_step]" style="width:60px;" type="text" class="txt" id="page_url_auto_step" value=" <?php echo $info['page_url_auto_step'];?>" />
</span>	 </div></td>
  <td class="vtop tips2" s="1"></td>
</tr>
<tr >
  <td s="1" class="td27" colspan="2"><span class="vtop rowform"><a onclick="url_page_range_test()" href="javascript:void(0);">点击查看测试结果</a></span></td>
</tr>
</tbody>

<tbody id="show_manyou" <?php if($info['url_range_type'] != 3) { ?> style="display:none"<?php } ?>>

<tr >
  <td colspan="2" class="td27" s="1">爬行深度:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>

<tr class="noborder" ><td class="vtop rowform">
<input name="set[manyou_max_level]" type="text"  class="txt" id="manyou_max_level" value="<?php echo $info['manyou_max_level'];?>"></td>
<td class="vtop tips2" s="1">算上入口地址，爬虫从A链接爬到B链接再爬到C链接，这样算做三层深度,推荐2。不填默认2</td>
</tr>
<tr >
  <td colspan="2" class="td27" s="1"> 是否只在入口域名范围内 :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>

<tr class="noborder" ><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['only_in_domain'] != 1) { ?> class="checked" <?php } ?>><input <?php if($info['only_in_domain'] != 1) { ?> checked="checked" <?php } ?> name="set[only_in_domain]" type="radio" show="" class="radio" value="0">
&nbsp;是</li>
  <li <?php if($info['only_in_domain'] == 1) { ?> class="checked" <?php } ?>><input  type="radio" <?php if($info['only_in_domain'] == 1) { ?> checked="checked" <?php } ?>  value="1" name="set[only_in_domain]" class="radio">
&nbsp;否</li>
</ul>
</td>
<td class="vtop tips2" s="1">&nbsp;</td>
</tr>
</tbody>
<tbody id="show_rss" <?php if($info['url_range_type'] != 4) { ?> style="display:none"<?php } ?>>
<tr >
  <td colspan="2" class="td27" s="1">rss地址:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>

<tr class="noborder" ><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[rss_url]" id="rss_url" cols="50" class="tarea w_area" ><?php echo $info['rss_url'];?></textarea></td>
<td class="vtop tips2" s="1">每行一个 不填默认忽略</td>
</tr>
<tr >
  <td s="1" class="td27" colspan="2"><span class="vtop rowform"><a onclick="get_rss_link()" href="javascript:void(0);">点击获取链接</a></span></td>
</tr>
</tbody>

<tbody id="many_list_page" style="display:<?php if($info['url_range_type'] != 5 ) { ?> none <?php } ?>">
<tr >
  <td s="1" class="td27 model-1" colspan="2"><span class="vtop rowform">采集入口地址:</span></td>
</tr>
<tr  class="model"><td class="vtop rowform"><input  name="set[many_list_start_url]" type="text" class="longtxt" id="many_list_start_url" value="<?php echo $info['many_list_start_url'];?>"></td>
<td s="1" class="vtop tips2">从这个入口开始采集</td>
</tr>
<tr class="noborder" >
  <td colspan="2" class="vtop rowform">
<table width="500" class="tb tb2 tdtable" >

<tr class="header"><th width="100">规则类型</th>
  <th width="200">规则内容&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
  <th>测试</th>
  <th>操作</th>
</tr>
<tbody id="many_page_list_tbody"><?php echo create_rules_html('many_page_list', $info['many_page_list']);?></tbody>
</tbody>

<tbody><tr class="hover">
  <td><a href="javascript:void(0)"   onclick="add_rules('many_page_list');">增加一组规则</a></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody></table></td>
  </tr>
</tbody>


<tr >
  <td colspan="2" class="td27" s="1">进一步过滤或添加网址:</td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['page_fiter'] == 1) { ?> class="checked" <?php } ?>><input class="page_fiter" name="set[page_fiter]" type="radio" onclick="show_hide('show_page_fiter','',1);" value="1"  <?php if($info['page_fiter'] == 1) { ?> checked="checked" <?php } ?>>
&nbsp;是</li>
  <li <?php if($info['page_fiter'] != 1) { ?> class="checked" <?php } ?>><input class="page_fiter"  <?php if($info['page_fiter'] != 1) { ?> checked="checked" <?php } ?>  onclick="show_hide('show_page_fiter','',2);" name="set[page_fiter]" type="radio" value="2">
    &nbsp;否  </li>
</ul></td><td  s="1" class="vtop tips2"></td></tr>
<tbody id="show_page_fiter" <?php if($info['page_fiter'] != 1) { ?> style="display:none"<?php } ?>>
<tr >
  <td colspan="2" class="td27" s="1">要采集的网址:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>

<tr class="noborder" ><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[page_url_other]" id="page_url_other" cols="50" class="tarea w_area" ><?php echo $info['page_url_other'];?></textarea></td>
<td class="vtop tips2" s="1">手动添加要采集的网址，填完整的网址，不支持正则、模糊。每行一个</td>
</tr>
<tr >
  <td colspan="2" class="td27" s="1">要过滤的网址:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>

<tr class="noborder" ><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[page_url_no_other]" id="page_url_no_other" cols="50" class="tarea w_area" ><?php echo $info['page_url_no_other'];?></textarea></td>
<td class="vtop tips2" s="1">手动添加要过滤的网址，填完整的网址，不支持正则、模糊。每行一个</td>
</tr>
<tr >
  <td colspan="2" class="td27" s="1">网址必须包含下列字符:&nbsp;&nbsp;&nbsp;<a  href="javascript:void(0)"  onclick="insertAtCursor('page_url_contain','(*)')">插入通配符(*)</a>&nbsp;&nbsp;&nbsp;</td>
</tr>

<tr class="noborder" ><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[page_url_contain]" id="page_url_contain" cols="50" class="tarea" ><?php echo $info['page_url_contain'];?></textarea></td>
<td class="vtop tips2" s="1">每行一个，(*)代表任意字符(*)</td>
</tr>

<tr >
  <td colspan="2" class="td27" s="1">网址不包含下列字符:&nbsp;&nbsp;&nbsp;<a   href="javascript:void(0)"  onclick="insertAtCursor('page_url_no_contain','(*)')">插入通配符(*)</a>&nbsp;&nbsp;&nbsp;</td>
</tr>

<tr class="noborder" ><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[page_url_no_contain]" id="page_url_no_contain" cols="50" class="tarea" ><?php echo $info['page_url_no_contain'];?></textarea></td>
<td class="vtop tips2" s="1">每行一个，(*)代表任意字符</td>
</tr>
</tbody><?php include template('milu_pick:common_get_page'); ?></table>
<table id="show_common_get_content" class="tab_content tb tb2" <?php if($step == 3) { ?>style="display:block"<?php } else { ?>style="display:none"<?php } ?>>
<tbody id="page_url_hide_notice2">
<tr >
  <th class="partition" colspan="15">采集内容获取：<font style="font-weight:normal; color:red;">此处由采集器自动处理</font></th>
</tr>
</tbody><?php include template('milu_pick:common_get_content'); ?>  <tbody id="content_pick_filter">
    <tr>
      <th class="partition" colspan="15">采集信息过滤</th>
    </tr>
    
    <tr >
  <td s="1" class="td27" colspan="2">文章最低字数:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<input name="set[article_min_len]" type="text" class="txt" id="article_min_len" value="<?php echo $info['article_min_len'];?>"></td>
<td s="1" class="vtop tips2">自动过滤低于此数字的文章.</td>
</tr>
 
    <tr >
      <td colspan="2" class="td27" s="1">是否根据关键词采集?<span class="vtop rowform"></span></td>
    </tr>
    <tr  class="noborder">
      <td class="vtop rowform"><ul onmouseover="altStyle(this);">
        <li <?php if($info['keyword_flag'] == 1) { ?> class="checked" <?php } ?>>
          <input onclick="show_hide('show_keyword_filter','',1);" name="set[keyword_flag]" type="radio" class="keyword_flag" <?php if($info['keyword_flag'] == 1) { ?> checked="checked" <?php } ?> value="1" />
          &nbsp;是</li>
        <li <?php if($info['keyword_flag'] != 1) { ?> class="checked" <?php } ?>>
          <input type="radio"  onclick="show_hide('show_keyword_filter','',2);" <?php if($info['keyword_flag'] != 1) { ?> checked="checked" <?php } ?>  value="2" name="set[keyword_flag]" class="keyword_flag" />
          &nbsp;否</li>
      </ul></td>
      <td s="1" class="vtop tips2"></td>
    </tr>
  </tbody>
  <tbody id="show_keyword_filter" style="<?php if($info['keyword_flag'] == 1) { } else { ?>display:none<?php } ?>">
    <tr >
      <td s="1" class="td27" colspan="2">标题包含关键词:<a onclick="insertAtCursor('keyword_title','(*)')" href="javascript:void(0)">&nbsp;&nbsp;&nbsp;插入通配符(*)</a></td>
    </tr>
    <tr  class="noborder">
      <td class="vtop rowform"><textarea '..'="" class="tarea" cols="50" id="keyword_title" name="set[keyword_title]" onkeyup="textareasize(this, 0)" ondblclick="textareasize(this, 1)" rows="6" style=""><?php echo $info['keyword_title'];?></textarea></td>
      <td s="1" class="vtop tips2">每行一个 不填默认忽略</td>
    </tr>
    <tr >
      <td s="1" class="td27" colspan="2">标题不包含的关键词:<a onclick="insertAtCursor('keyword_title_exclude','(*)')" href="javascript:void(0)">&nbsp;&nbsp;&nbsp;插入通配符(*)</a></td>
    </tr>
    <tr  class="noborder">
      <td class="vtop rowform"><textarea '..'="" class="tarea" cols="50" id="keyword_title_exclude" name="set[keyword_title_exclude]" onkeyup="textareasize(this, 0)" ondblclick="textareasize(this, 1)" rows="6" style=""><?php echo $info['keyword_title_exclude'];?></textarea></td>
      <td s="1" class="vtop tips2">每行一个 不填默认忽略</td>
    </tr>
    <tr >
      <td s="1" class="td27" colspan="2">内容包含关键词:<a onclick="insertAtCursor('keyword_content','(*)')" href="javascript:void(0)">&nbsp;&nbsp;&nbsp;插入通配符(*)</a></td>
    </tr>
    <tr  class="noborder">
      <td class="vtop rowform"><textarea '..'="" class="tarea" cols="50" id="keyword_content" name="set[keyword_content]" onkeyup="textareasize(this, 0)" ondblclick="textareasize(this, 1)" rows="6" style=""><?php echo $info['keyword_content'];?></textarea></td>
      <td s="1" class="vtop tips2">每行一个 不填默认忽略</td>
    </tr>
    <tr >
      <td s="1" class="td27" colspan="2">内容不包含关键词:<a onclick="insertAtCursor('keyword_content_exclude','(*)')" href="javascript:void(0)">&nbsp;&nbsp;&nbsp;插入通配符(*)</a></td>
    </tr>
    <tr  class="noborder">
      <td class="vtop rowform"><textarea '..'="" class="tarea" cols="50" id="keyword_content_exclude" name="set[keyword_content_exclude]" onkeyup="textareasize(this, 0)" ondblclick="textareasize(this, 1)" rows="6" style=""><?php echo $info['keyword_content_exclude'];?></textarea></td>
      <td s="1" class="vtop tips2">每行一个 不填默认忽略</td>
    </tr>
 
  </tbody>
  
</table>
<table class="tab_content tb tb2" <?php if($step == 4) { ?>style="display:block"<?php } else { ?>style="display:none"<?php } ?>>
<tbody>

<tr >
  <td s="1" class="td27" colspan="2">发布者UID:<span class="vtop rowform"></span></td>
</tr>


<tr  class="noborder"><td class="vtop rowform"><?php echo radio_output(array('name' => 'public_uid_type', 'int_val' => 2, 'js' => array("show_hide('public_uid_group','user_setting_uid', 1)", "show_hide('public_uid_group','user_setting_uid', 2)"), 'lang' => array('user_group', 'user_setting_uid')), $info);; ?></td>
<td s="1" class="vtop tips2"></td>
</tr>

<tr  class="noborder"><td class="vtop rowform">
<span  id="public_uid_group" <?php if($info['public_uid_type'] == 1) { } else { ?>style="display:none" <?php } ?>><?php echo user_group_select('set[public_uid_group]', $info['public_uid_group'])?></span>
<span  id="user_setting_uid" <?php if($info['public_uid_type'] == 1) { ?>style="display:none" <?php } ?>>
<input name="set[public_uid]" type="text" class="txt" id="public_uid" value="<?php echo $info['public_uid'];?>">
</span>
</td>
<td s="1" class="vtop tips2">1、多个UID用|符号隔开，指定范围半角逗号 "," 隔开。如1|24表示在1和24中随机，1,100表示从1到100的用户随机发布。 2、如果要发布视频，请给予用户所在的用户组发布视频的权限。 3、如果按照设置无法取得用户，用当前登录用户顶替 </td>
</tr>

 

<tr >
  <td s="1" class="td27" colspan="2">回帖者UID:<span class="vtop rowform"></span></td>
</tr>



<tr  class="noborder"><td class="vtop rowform"><?php echo radio_output(array('name' => 'reply_uid_type', 'int_val' => 2, 'js' => array("show_hide('reply_uid_group','reply_uid_setting_uid', 1)", "show_hide('reply_uid_group','reply_uid_setting_uid', 2)"), 'lang' => array('user_group', 'user_setting_uid')), $info);; ?></td>
<td s="1" class="vtop tips2"></td>
</tr>



<tr  class="noborder"><td class="vtop rowform">
<span  id="reply_uid_group" <?php if($info['reply_uid_type'] == 1) { } else { ?>style="display:none" <?php } ?>><?php echo user_group_select('set[reply_uid_group]', $info['public_uid_group'])?></span>
<span  id="reply_uid_setting_uid" <?php if($info['reply_uid_type'] == 1) { ?>style="display:none" <?php } ?>>
<input name="set[reply_uid]" type="text" class="txt" id="reply_uid" value="<?php echo $info['reply_uid'];?>">
</span>
</td>
<td s="1" class="vtop tips2">解释同上 </td>
</tr>
 

<tr >
  <td s="1" class="td27" colspan="2">文章（主题）发布时间设置:<span class="vtop rowform"></span></td>
</tr>

  
  <tr  class="noborder"><td class="vtop rowform">
<div style="width:600px;">
<span style="float:left; margin-right:15px;">
   <input id="time_public" <?php if($info['public_time_type']==1 || !$info['public_time_type']) { ?>checked="checked"<?php } ?> name="set[public_time_type]" onclick="show_hide('show_public_time','',2);" type="radio"  class="radio" value="1"><label for="time_public">发布时的时间</label>
   
    <input id="time_pick_time" <?php if($info['public_time_type'] == 2) { ?>checked="checked"<?php } ?> name="set[public_time_type]" onclick="show_hide('show_public_time','',2);" type="radio"  class="radio" value="2"><label for="time_pick_time">采集到的时间</label>

   <input id="time_rand" <?php if($info['public_time_type'] == 3) { ?>checked="checked"<?php } ?>  name="set[public_time_type]" onclick="show_hide('show_public_time','',1);" type="radio"  class="radio" value="3"><label for="time_rand">随机的时间段</label>
   </span>
   <br />
   <p style="display:block; width:400px; margin-top:10px;">
   <span id="show_public_time" <?php if($info['public_time_type'] != 3) { ?>style="display:none"<?php } ?>>
   <input style="float:left; width:140px;" name="set[public_start_time]" type="text" class="txt" onclick="showcalendar(event, this, 1)" id="public_start_time" value="<?php echo $info['public_start_time'];?>">
<span style="float:left; margin-right:10px;">-</span>
<input style="float:left; width:140px;" name="set[public_end_time]" type="text" class="txt" onclick="showcalendar(event, this, 2)" id="public_end_time" value="<?php echo $info['public_end_time'];?>" />
</span>
</p>
</div></td>
<td s="1" class="vtop tips2">1、如采集到的时间不规范，系统用发布时的时间补上。<br />
2、随机时间：‘0到2’代表‘现在-未来2小时’随机，假如填‘-2到2’，代表‘过去2小时-未来2小时’随机</td>
</tr>



 
    
<tr >
  <td s="1" class="td27" colspan="2">回复发布时间设置:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<input name="set[reply_dateline]" type="text" class="txt" id="reply_dateline" value="<?php echo $info['reply_dateline'];?>"></td>
<td s="1" class="vtop tips2">填5表示主题发布时间之后5小时随机。填1,5表示主题发布时间之后1到5小时之间随机。默认值2</td>
</tr>

 
<tr >
  <td s="1" class="td27" colspan="2">文章点击率:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<input name="set[view_num]" type="text" class="txt" id="view_num" value="<?php echo $info['view_num'];?>"></td>
<td s="1" class="vtop tips2">1,100表示点击率（或查看数）从1,100随机设置</td>
</tr>
<tr >
  <td s="1" class="td27" colspan="2">图片水印:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['is_water_img'] == 1 || !$info['is_water_img']) { ?> class="checked" <?php } ?>><input <?php if($info['is_water_img'] == 1 || !$info['is_water_img']) { ?> checked="checked" <?php } ?> name="set[is_water_img]" type="radio" show="" class="radio" value="1">
&nbsp;打水印</li>
  <li <?php if($info['is_water_img'] == 2) { ?> class="checked" <?php } ?>><input  type="radio" <?php if($info['is_water_img'] == 2) { ?> checked="checked" <?php } ?>  value="2" name="set[is_water_img]" class="radio">
&nbsp;不打水印</li>
</ul></td>
<td s="1" class="vtop tips2">&nbsp;</td>
</tr>
<tr >
  <td s="1" class="td27" colspan="2">图片本地化:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['is_download_img'] || !$info['is_download_img']) { ?> class="checked" <?php } ?>><input <?php if($info['is_download_img'] || !$info['is_download_img']) { ?> checked="checked" <?php } ?> name="set[is_download_img]" type="radio" show="" class="radio" value="1">
&nbsp;是</li><li <?php if($info['is_download_img'] == 2) { ?> class="checked" <?php } ?>><input  type="radio" <?php if($info['is_download_img'] == 2) { ?> checked="checked" <?php } ?>  value="2" name="set[is_download_img]" class="radio">
&nbsp;否</li></ul></td>
<td s="1" class="vtop tips2">自动下载图片到本地</td>
</tr>

 

<tr >
  <td s="1" class="td27" colspan="2">附件本地化:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['is_download_file'] == 1) { ?> class="checked" <?php } ?>><input <?php if($info['is_download_file'] == 1) { ?> checked="checked" <?php } ?> name="set[is_download_file]" type="radio" show="" class="radio" value="1">
&nbsp;是</li><li <?php if($info['is_download_file'] != 1) { ?> class="checked" <?php } ?>><input  type="radio" <?php if($info['is_download_file'] != 1) { ?> checked="checked" <?php } ?>  value="2" name="set[is_download_file]" class="radio">
&nbsp;否</li></ul></td>
<td s="1" class="vtop tips2">自动下载文章或者帖子附件到本地</td>
</tr>

 

 
<tr >
  <td s="1" class="td27" colspan="2">是否开启同义词替换:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['is_word_replace'] == 1) { ?> class="checked" <?php } ?>><input <?php if($info['is_word_replace'] == 1) { ?> checked="checked" <?php } ?> name="set[is_word_replace]" type="radio" show="" class="radio" value="1">
&nbsp;是</li><li <?php if($info['is_word_replace'] != 1) { ?> class="checked" <?php } ?>><input  type="radio" <?php if($info['is_word_replace'] != 1) { ?> checked="checked" <?php } ?>  value="2" name="set[is_word_replace]" class="radio">
&nbsp;否</li></ul></td>
<td s="1" class="vtop tips2">有些文章同义词替换之后，可读性较差，请慎重开启</td>
</tr>
 


<tr >
  <td s="1" class="td27" colspan="2">是否发布后就删除文章:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['is_public_del'] == 1) { ?> class="checked" <?php } ?>><input <?php if($info['is_public_del'] == 1) { ?> checked="checked" <?php } ?> name="set[is_public_del]" type="radio" show="" class="radio" value="1">
&nbsp;是</li><li <?php if($info['is_public_del'] != 1) { ?> class="checked" <?php } ?>><input  type="radio" <?php if($info['is_public_del'] != 1) { ?> checked="checked" <?php } ?>  value="2" name="set[is_public_del]" class="radio">
&nbsp;否</li></ul></td>
<td s="1" class="vtop tips2">文章发布后就直接删除.</td>
</tr>

<tr >
  <td s="1" class="td27" colspan="2">分页文章是否合并发布:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['is_page_public'] == 1) { ?> class="checked" <?php } ?>><input <?php if($info['is_page_public'] == 1) { ?> checked="checked" <?php } ?> name="set[is_page_public]" type="radio" show="" class="radio" value="1">
&nbsp;是</li><li <?php if($info['is_page_public'] != 1) { ?> class="checked" <?php } ?>><input  type="radio" <?php if($info['is_page_public'] != 1) { ?> checked="checked" <?php } ?>  value="2" name="set[is_page_public]" class="radio">
&nbsp;否</li></ul></td>
<td s="1" class="vtop tips2">选择否：发到门户分页显示，发布到博客会强制合并，而发布到论坛会从第二页起以回复的形式发布</td>
</tr>

 

<tr >
  <td colspan="2" class="td27" s="1">是否发布回复:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['is_public_reply'] != 2) { ?> class="checked" <?php } ?>><input <?php if($info['is_public_reply'] != 2) { ?> checked="checked" <?php } ?> name="set[is_public_reply]" type="radio" onclick="show_hide('show_public_reply','',1);" show="" class="radio" value="1">
&nbsp;是</li><li <?php if($info['is_public_reply'] == 2) { ?> class="checked" <?php } ?>><input  type="radio" <?php if($info['is_public_reply'] == 2) { ?> checked="checked" <?php } ?>  value="2" name="set[is_public_reply]" onclick="show_hide('show_public_reply','',2);" class="radio">
&nbsp;否</li></ul></td>
<td s="1" class="vtop tips2">&nbsp;</td>
</tr>
<tbody id="show_public_reply"  <?php if($info['is_public_reply'] == 2) { ?>style="display:none"<?php } ?>>
<tr><td colspan="2" class="td27" s="1">是否将回帖打乱:</td></tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['public_reply_seq'] != 2) { ?> class="checked" <?php } ?>><input <?php if($info['public_reply_seq'] !=2) { ?> checked="checked" <?php } ?> name="set[public_reply_seq]" type="radio"  show="" class="radio" value="1">
&nbsp;是</li><li <?php if($info['public_reply_seq'] == 2) { ?> class="checked" <?php } ?>><input  type="radio" <?php if($info['public_reply_seq'] == 2) { ?> checked="checked" <?php } ?>  value="2" name="set[public_reply_seq]" class="radio">
&nbsp;否</li></ul></td>
<td s="1" class="vtop tips2">是否将回帖打乱再发布</td>
</tr>
</tbody>


<tr >
  <td colspan="2" class="td27" s="1">自动发布文章:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['is_auto_public']) { ?> class="checked" <?php } ?>><input <?php if($info['is_auto_public']) { ?> checked="checked" <?php } ?> name="set[is_auto_public]" type="radio" onclick="show_hide('show_auto_public','',1);" show="" class="radio" value="1">
&nbsp;是</li><li <?php if(!$info['is_auto_public']) { ?> class="checked" <?php } ?>><input  type="radio" <?php if(!$info['is_auto_public']) { ?> checked="checked" <?php } ?>  value="0" name="set[is_auto_public]" onclick="show_hide('show_auto_public','',2);" class="radio">
&nbsp;否</li></ul></td>
<td s="1" class="vtop tips2">采集的同时，直接发布文章. 请注意：自动发布的文章定时发布将不起作用。</td>
</tr>

 


<tr >
  <td colspan="2" class="td27" s="1">文章发布顺序:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform"><?php echo radio_output(array('name' => 'article_public_sort', 'int_val' => 1, 'lang' => array('article_public_sort_desc', 'article_public_sort_asc')), $info);; ?></td>
<td s="1" class="vtop tips2">如果是边采边发布，那么将按照先采先发布的原则</td>
</tr>


<tr>
  <td colspan="2" class="td27" s="1">绑定栏目:</td>
</tr>
<tr >
  <td colspan="2" class="td27" s="1">    <label>发布到:</label>
    <select name="set[public_type]" onchange="change_public_type(this.value);">
  <option <?php if(!$info['public_type']) { ?>selected="selected"<?php } ?> value="0">请选择</option>
      <option <?php if($info['public_type'] == 1) { ?>selected="selected"<?php } ?> value="1">门户</option>
      <option <?php if($info['public_type'] == 2) { ?>selected="selected"<?php } ?>  value="2">论坛</option>
      <option <?php if($info['public_type'] == 3) { ?>selected="selected"<?php } ?>  value="3">博客</option>
      </select>
    </label>
    <span id="portal_show" <?php if($info['public_type'] != 1) { ?>style="display:none"<?php } ?>><?php echo $portalselect;?>&nbsp;&nbsp;</span>
    <span id="forums_show"  <?php if($info['public_type'] != 2) { ?>style="display:none"<?php } ?>> <?php echo $forumselect;?>&nbsp;&nbsp;<span id="threadtypes"><?php echo $threadtypes;?></span></span>
    <span id="blog_show" <?php if($info['public_type'] != 3) { ?>style="display:none"<?php } ?> > <?php echo $blogselect;?>&nbsp;&nbsp;</span>&nbsp;&nbsp;<span style="font-weight:normal">绑定栏目，或者自动采集之后自动发布到这个栏目</span></td>
</tr>



</tbody>
</table>
<table class="tab_content tb tb2" <?php if($step == 5) { ?>style="display:block"<?php } else { ?>style="display:none"<?php } ?>>
<tbody>
<tr >
  <td s="1" class="td27" colspan="2">每批采集数:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<input name="set[jump_num]" type="text" class="txt" id="jump_num" value="<?php echo $info['jump_num'];?>"></td>
<td s="1" class="vtop tips2">分批执行任务，每批执行的数量。服务器性能太差的用户，请将数字调小一点</td>
</tr>
<tr >
  <td s="1" class="td27" colspan="2">采集总数:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<input name="set[pick_num]" type="text" class="txt" id="pick_num" value="<?php echo $info['pick_num'];?>"></td>
<td s="1" class="vtop tips2">读取够此数目的链接(不是文章)就停止采集,若计划任务执行，请设置一个数目，以免采集器无限度的执行。</td>
</tr>

<tr >
  <td s="1" class="td27" colspan="2">采集停顿设置:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<input name="set[stop_time]" type="text" class="txt" id="stop_time" value="<?php echo $info['stop_time'];?>"></td>
<td s="1" class="vtop tips2">单位：秒. 填1,5 表示读取一个url停顿1秒，读取完一批停顿5秒;只填 1 表示读取一个url停顿1秒</td>
</tr>
 
<tr>
  <th colspan="15" class="partition">计划任务(商业版功能)</th>
</tr>
<tr >
  <td colspan="2" class="td27" s="1">是否可用:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);"><li <?php if($info['is_auto_pick']) { ?> class="checked" <?php } ?>><input <?php if($info['is_auto_pick']) { ?> checked="checked" <?php } ?> name="set[is_auto_pick]" type="radio" onclick="show_hide('show_task','',1);" show="" class="radio" value="1">
&nbsp;是</li><li <?php if(!$info['is_auto_pick']) { ?> class="checked" <?php } ?>><input  type="radio" <?php if(!$info['is_auto_pick']) { ?> checked="checked" <?php } ?>  value="0" name="set[is_auto_pick]" onclick="show_hide('show_task','',2);" class="radio">
&nbsp;否</li></ul></td>
<td s="1" class="vtop tips2">最好设定好采集总数，防止过多的采集造成服务器负载过高 </td>
</tr>
<tbody id="show_task"  <?php if(!$info['is_auto_pick']) { ?>style="display:none"<?php } ?>><?php show_cron_setting_output($info);?></tbody>
 

</tbody>
</table>
<tr>
<br >
<div class="fixsel"><input style="display:none" type="submit" class="btn" id="submit_addsubmit" name="editsubmit" title="按 Enter 键可随时提交你的修改" value="!save!">
<input type="submit" class="btn" id="submit_addsubmit" name="editsubmit" title="按 Enter 键可随时提交你的修改" value="提交"></div><script type="text/JavaScript">_attachEvent(document.documentElement, 'keydown', function (e) { entersubmit(e, 'addsubmit'); });</script>
</form>
<script>
<?php echo $show_bottom_js;?>
</script>
