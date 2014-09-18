<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); if($_G['inajax']) { ob_end_clean();
ob_start();
@header("Expires: -1");
@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
@header("Pragma: no-cache");
@header("Content-type: text/xml; charset=".CHARSET);
echo '<?xml version="1.0" encoding="'.CHARSET.'"?>'."\r\n";?><root><![CDATA[
<?php } ?>
<tbody id="show_get_content" style="display:<?php if($info['content_type'] == 2) { ?> none <?php } ?>">
<tr>
  <th colspan="15" class="partition">内容识别设置</th>
</tr>

<?php if($_REQUEST['pmod'] != 'fast_pick') { ?>

<tr >
  <td s="1" class="td27" colspan="2">测试地址:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<input name="set[theme_url_test]" type="text" class="longtxt" id="theme_url_test" value="<?php echo $info['theme_url_test'];?>"></td>
<td s="1" class="vtop tips2">先输入一个你要分析的文章地址,下面要用来测试</td>
</tr>
<?php } ?>

<tr >
  <td colspan="2" class="td27" s="1">标题 获取规则:&nbsp;&nbsp;&nbsp;<a class="insert_a" id="insert_title" style="<{ <?php if($info['theme_get_type'] != 2 || $info['theme_get_type'] == 3) { ?>>display:none<<?php } ?>>" href="javascript:void(0)"  onclick="insertAtCursor('theme_rules','[title]')">插入标题区域[title]</a>&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);">
  <li id="li_theme_get_type_1" <?php if($info['theme_get_type'] == 1) { ?> class="checked" <?php } ?>><input id="theme_get_type_1" name="set[theme_get_type]" type="radio" class="theme_get_type" onclick="show_hide('tr_get_title','insert_title',1);" value="1"  <?php if($info['theme_get_type'] == 1) { ?> checked="checked" <?php } ?>>
  DOM获取  </li>
  <li  id="li_theme_get_type_2"  <?php if($info['theme_get_type'] == 2 || !$info['theme_get_type']) { ?> class="checked" <?php } ?> ><input  name="set[theme_get_type]" type="radio" class="theme_get_type"  value="2"  id="theme_get_type_2" onclick="show_hide('','insert_title+tr_get_title',2);"  <?php if($info['theme_get_type'] == 2 ||!$info['theme_get_type']) { ?>checked="checked" <?php } ?>>
    字符串获取</li>

<li  id="li_theme_get_type_3"  <?php if($info['theme_get_type'] == 3 ) { ?> class="checked" <?php } ?> ><input  name="set[theme_get_type]" type="radio" class="theme_get_type"  value="3"  id="theme_get_type_3" onclick="show_hide('tr_get_title+insert_title','',2);"  <?php if($info['theme_get_type'] == 3 ) { ?>checked="checked" <?php } ?>>
    智能获取</li>
</ul></td>
<td s="1" class="vtop tips2">字符串识别就是根据起止字符串截取内容</td>
</tr>
<tr id="tr_get_title" <?php if($info['theme_get_type'] == 3) { ?>style="display:none"<?php } ?> class="noborder" ><td class="vtop rowform"><textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[theme_rules]" id="theme_rules" cols="50" class="tarea w_area" '..'=""><?php echo $info['theme_rules'];?></textarea>
</td>
  <td class="vtop tips2" s="1"><p id="theme_get_type_1" style="<?php if($info['theme_get_type'] == 2 || !$info['theme_get_type']) { ?>display:none<?php } ?>">一般来说，dom的效率比字符识别慢3-4倍左右</p>
  <p id="theme_get_type_2" style=" <?php if($info['theme_get_type'] != 2) { ?>display:none<?php } ?>">*代替任意字符、回车、换行<br>
  在要获取的地方放入[title]</p></td>
</tr>
<tr >
  <td colspan="2" class="td27" s="1">是否需要进一步处理标题:</td>
</tr>
<tr class="noborder" >
  <td class="vtop rowform">
  <ul onMouseOver="altStyle(this);"><li id="li_is_fiter_title_1" <?php if($info['is_fiter_title'] == 1) { ?> class="checked" <?php } ?>><input name="set[is_fiter_title]" type="radio" class="is_fiter_title" id="is_fiter_title_1" onclick="show_hide('title_fiter_replace','',1);" value="1"  <?php if($info['is_fiter_title'] == 1) { ?> checked="checked" <?php } ?>>
&nbsp;是</li>
    <li id="li_is_fiter_title_2" <?php if($info['is_fiter_title'] != 1) { ?> class="checked" <?php } ?>><input onclick="show_hide('title_fiter_replace','',2);" name="set[is_fiter_title]" type="radio" id="is_fiter_title_2" class="is_fiter_title" value="2" <?php if($info['is_fiter_title'] != 1) { ?> checked="checked" <?php } ?>>
    否    </li>
</ul></td>
  <td class="vtop tips2" s="1"></td>
</tr>
<tbody id="title_fiter_replace" <?php if($info['is_fiter_title'] != 1) { ?> style="display:none" <?php } ?>>
<tr >
  <td colspan="2" class="td27" s="1">标题替换:<a href="javascript:void(0)" onclick="insertAtCursor('title_replace_rules','(*)')">插入可变区域(*)</a></td>
</tr>
<tr class="noborder" ><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[title_replace_rules]" id="title_replace_rules" cols="50" class="tarea w_area" '..'=""><?php echo $info['title_replace_rules'];?></textarea></td>
<td class="vtop tips2" s="1"><p>用@@隔开，每行一组。比如 aa@@bb，表示将aa替换成bb</p>  </td>
</tr>
<tr >
  <td colspan="2" class="td27" s="1">标题剔除规则:</td>
</tr>
<tr class="noborder" >
  <td colspan="2" class="vtop rowform">
<table width="500" class="tb tb2 tdtable">

<tr class="header"><th width="100">规则类型</th>
  <th width="200">规则内容&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
  <th>操作</th>
</tr>
<tbody id="title_filter_rules_tbody"><?php echo create_rules_html('title_filter_rules', $info['title_filter_rules']);?></tbody><tbody style="display: none" id="n_0">
</tbody>

<tbody><tr class="hover">
  <td><a href="javascript:void(0)"   onclick="add_rules('title_filter_rules');">增加一组规则</a></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody><tbody style="display: none" id="n_3">
</tbody></table></td>
  </tr>
</tbody>

<td s="1" class="td27" colspan="2"><a onclick="test_window('theme_get_type', 'is_fiter_title', 'theme_url_test', 'theme_rules', 'title_replace_rules', 'title_filter_rules', 'title')" href="javascript:void(0);">点击查看测试结果</a></td>

<tr >
  <td s="1" class="td27" colspan="2"><span class="vtop rowform">内容 获取规则:&nbsp;&nbsp;&nbsp;<a id="insert_string_link" style="<{ <?php if($info['page_get_type'] != 2) { ?>>display:none<<?php } ?>>" href="javascript:void(0)"  onclick="insertAtCursor('content_rules','[body]')">插入内容区域[body]</a>&nbsp;&nbsp;&nbsp;</span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);">
  <li id="li_content_get_type_1" <?php if($info['content_get_type'] == 1) { ?> class="checked" <?php } ?>><input  id="content_get_type_1" name="set[content_get_type]" type="radio" class="content_get_type"  onclick="show_hide('tr_content_rules','',1);" value="1"  <?php if($info['content_get_type'] == 1) { ?> checked="checked" <?php } ?>>
 DOM获取  </li>
  <li id="li_content_get_type_2"<?php if($info['content_get_type'] == 2 || !$info['content_get_type']) { ?> class="checked" <?php } ?> ><input  onclick="show_hide('tr_content_rules','',1);" name="set[content_get_type]" type="radio" class="content_get_type" id="content_get_type_2"  value="2"  <?php if($info['content_get_type'] != 1 ||!$info['content_get_type']) { ?>checked="CHECKED" <?php } ?>>
    字符串获取</li>
<li id="li_content_get_type_3"<?php if($info['content_get_type'] == 3) { ?> class="checked" <?php } ?> ><input onclick="show_hide('tr_content_rules','',2);"  name="set[content_get_type]" type="radio" class="content_get_type" id="content_get_type_3"  value="3"  <?php if($info['content_get_type'] == 3 ) { ?>checked="CHECKED" <?php } ?>>
    智能获取</li>
</ul></td>
<td s="1" class="vtop tips2">字符串识别就是根据起止字符串截取内容</td>
</tr>

<tr id="tr_content_rules" <?php if($info['content_get_type'] == 3) { ?> style="display:none"<?php } ?> class="noborder" onmouseover="setfaq(this, 'faq44fcd')"><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[content_rules]" id="content_rules" cols="50" class="tarea w_area" '..'=""><?php echo $info['content_rules'];?></textarea></td>
<td class="vtop tips2" s="1">*代替任意字符、回车、换行在要获取的地方放入[body]</td>
</tr>
</tbody>
<tr >
  <td colspan="2" class="td27" s="1">是否需要进一步处理内容:</td>
</tr>
<tr class="noborder" >
  <td class="vtop rowform">
  <ul onMouseOver="altStyle(this);"><li <?php if($info['is_fiter_content'] == 1) { ?> class="checked" <?php } ?>><input onclick="show_hide('content_fiter_replace','',1);" name="set[is_fiter_content]" type="radio" class="is_fiter_content" value="1"  <?php if($info['is_fiter_content'] == 1) { ?> checked="checked" <?php } ?>>
&nbsp;是</li>
    <li <?php if($info['is_fiter_content'] != 1) { ?> class="checked" <?php } ?>><input onclick="show_hide('content_fiter_replace','',2);" name="set[is_fiter_content]" type="radio" class="is_fiter_content" value="2" <?php if($info['is_fiter_content'] != 1) { ?> checked="checked" <?php } ?>>
    否    </li>
</ul></td>
  <td class="vtop tips2" s="1">&nbsp;</td>
</tr>
<tr >
<tbody id="content_fiter_replace" <?php if($info['is_fiter_content'] != 1) { ?> style="display:none" <?php } ?>>
<tr >
  <td colspan="2" class="td27" s="1">内容替换:<a href="javascript:void(0)" onclick="insertAtCursor('content_replace_rules','(*)')">插入可变区域(*)</a></td>
</tr>
<tr class="noborder" ><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[content_replace_rules]" id="content_replace_rules" cols="50" class="tarea w_area" '..'=""><?php echo $info['content_replace_rules'];?></textarea></td>
<td class="vtop tips2" s="1"><p>用@@隔开，每行一组。比如 aa@@bb，表示将aa替换成bb</p>  </td>
</tr>
<?php if($_REQUEST['pmod'] != 'system_rules' || $_G['inajax']) { ?>
 <tr>
  <th  class="td27" colspan="15">格式化内容</th>
</tr>
<tr  class="noborder">
  <td class="vtop rowform"><?php echo show_filter_html($info['content_filter_html']);?></td>
  <td s="1" class="vtop tips2"><p>自动去除选定标签</p></td>
</tr>
<?php } ?>
<tr >
  <td colspan="2" class="td27" s="1">内容剔除规则:</td>
</tr>
<tr class="noborder" >
  <td colspan="2" class="vtop rowform">
<table width="500" class="tb tb2 tdtable" >

<tr class="header"><th width="100">规则类型</th>
  <th width="200">规则内容&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
  <th>操作</th>
</tr>

<tbody id="content_filter_rules_tbody"><?php echo create_rules_html('content_filter_rules', $info['content_filter_rules']);?></tbody>

<tbody><tr class="hover">
  <td><a href="javascript:void(0)"   onclick="add_rules('content_filter_rules');">增加一组规则</a></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody>
<tbody style="display: none" id="n_3">
</tbody></table></td>
  </tr>
</tbody>

<tr >
    <td s="1" class="td27" colspan="2"><a onclick="test_window('content_get_type', 'is_fiter_content', 'theme_url_test', 'content_rules', 'content_replace_rules', 'content_filter_rules', 'body')" href="javascript:void(0);">点击查看测试结果</a></td>
</tr>


<tr >
  <td colspan="2" class="td27" s="1">是否采集文章其他信息:</td>
</tr>
<tr class="noborder" >
  <td class="vtop rowform">
  	 <?php echo radio_output(array('name' => 'is_get_other', 'int_val' => 2, 'js' => array("show_hide('show_get_other','',1)", "show_hide('show_get_other','',2)"), 'lang' => array('yes', 'no')), $info);; ?> </td>
  <td class="vtop tips2" s="1">&nbsp;</td>
</tr>
<tbody id="show_get_other" <?php if($info['is_get_other'] != 1) { ?>style="display:none"<?php } ?>>
<tr >
  <td s="1" class="td27" colspan="2"><span class="vtop rowform">文章来源 获取规则:&nbsp;&nbsp;&nbsp;<a  style="<{ <?php if($info['from_get_type'] != 2) { ?>>display:none<<?php } ?>>" href="javascript:void(0)"  onclick="insertAtCursor('from_get_rules','[data]')">要获取的区域请插入[data]</a>&nbsp;&nbsp;&nbsp;</span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform"><?php echo radio_output(array('name' => 'from_get_type', 'int_val' => 1, 'lang' => array('dom_get', 'str_get')), $info);; ?></td>
<td s="1" class="vtop tips2">字符串识别就是根据起止字符串截取内容</td>
</tr>

<tr class="noborder" onmouseover="setfaq(this, 'faq44fcd')"><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[from_get_rules]" id="from_get_rules" cols="50" class="tarea w_area" '..'=""><?php echo $info['from_get_rules'];?></textarea></td>
<td class="vtop tips2" s="1">*代替任意字符、回车、换行</td>
</tr>


<tr >
  <td s="1" class="td27" colspan="2"><span class="vtop rowform">原作者 获取规则:&nbsp;&nbsp;&nbsp;<a  style="<{ <?php if($info['author_get_type'] != 2) { ?>>display:none<<?php } ?>>" href="javascript:void(0)"  onclick="insertAtCursor('author_get_rules','[data]')">要获取的区域请插入[data]</a>&nbsp;&nbsp;&nbsp;</span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform"><?php echo radio_output(array('name' => 'author_get_type', 'int_val' => 1, 'lang' => array('dom_get', 'str_get')), $info);; ?></td>
<td s="1" class="vtop tips2">字符串识别就是根据起止字符串截取内容</td>
</tr>

<tr class="noborder" ><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[author_get_rules]" id="author_get_rules" cols="50" class="tarea w_area" '..'=""><?php echo $info['author_get_rules'];?></textarea></td>
<td class="vtop tips2" s="1">*代替任意字符、回车、换行</td>
</tr>



<tr >
  <td s="1" class="td27" colspan="2"><span class="vtop rowform">发布时间 获取规则:&nbsp;&nbsp;&nbsp;<a  style="<{ <?php if($info['dateline_get_type'] != 2) { ?>>display:none<<?php } ?>>" href="javascript:void(0)"  onclick="insertAtCursor('dateline_get_rules','[data]')">要获取的区域请插入[data]</a>&nbsp;&nbsp;&nbsp;</span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform"><?php echo radio_output(array('name' => 'dateline_get_type', 'int_val' => 1, 'lang' => array('dom_get', 'str_get')), $info);; ?></td>
<td s="1" class="vtop tips2">字符串识别就是根据起止字符串截取内容</td>
</tr>

<tr class="noborder" ><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[dateline_get_rules]" id="dateline_get_rules" cols="50" class="tarea w_area" '..'=""><?php echo $info['dateline_get_rules'];?></textarea></td>
<td class="vtop tips2" s="1">*代替任意字符、回车、换行</td>
</tr>

<tr >
    <td s="1" class="td27" colspan="2"><a onclick="get_other_test();" href="javascript:void(0);">点击查看测试结果</a></td>
</tr>



</tbody>





<?php if($_REQUEST['pmod'] != 'fast_pick' && !VIP) { ?>

<tr>
  <th colspan="15" class="partition">回复识别设置<font style="font-weight:normal">(如果不采集论坛、问答,这项可不填写)</font></th>
</tr>

<tr >
    <td colspan="2" class="td27" s="1">回复/回帖 获取规则:</td>
</tr>
<tr class="noborder" >
  <td class="vtop rowform"><label>
    <input type="checkbox" onclick="show_reply();" name="set[reply_is_extend]" <?php if($info['reply_is_extend'] == 1) { ?>checked="checked"<?php } ?> class="reply_is_extend" value="1" />
    继承内容规则</label></td>
  <td class="vtop tips2" s="1">有些时候，回复规则和内容规则是一样的，这时候可以用继承</td>
</tr>
<tbody id="reply_show" <?php if($info['reply_is_extend'] == 1) { ?> style="display:none"<?php } ?>>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);">
  <li id="li_reply_get_type_1" <?php if($info['reply_get_type'] == 1) { ?> class="checked" <?php } ?>><input id="reply_get_type_1" name="set[reply_get_type]" type="radio" class="reply_get_type"  value="1"  <?php if($info['reply_get_type'] == 1) { ?> checked="checked" <?php } ?>>
  DOM获取  </li>
  <li id="li_reply_get_type_2"  <?php if($info['reply_get_type'] == 2 || !$info['reply_get_type']) { ?> class="checked" <?php } ?> ><input id="reply_get_type_2"  name="set[reply_get_type]" type="radio" class="reply_get_type"  value="2"    <?php if($info['reply_get_type'] == 2 ||!$info['reply_get_type']) { ?>checked="CHECKED" <?php } ?>>
    字符串获取</li>
</ul></td>
<td s="1" class="vtop tips2">字符串识别就是根据起止字符串截取内容</td>
</tr>


<tr class="noborder" ><td class="vtop rowform">
    <textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[reply_rules]" id="reply_rules" cols="50" class="tarea" '..'=""><?php echo $info['reply_rules'];?></textarea>
    <a href="javascript:void(0)" onclick="insertAtCursor('reply_rules','[reply]')">插入回复区域[reply]</a></td>
  <td class="vtop tips2" s="1">*代替任意字符、回车、换行
        在要获取的地方放入[reply]</td>
</tr>
</tbody>
<tr >
  <td s="1" class="td27" colspan="2">是否需要进一步处理回复:</td>
</tr>
<tr class="noborder" >
  <td class="vtop rowform">
  <ul onMouseOver="altStyle(this);"><li <?php if($info['is_fiter_reply'] == 1) { ?> class="checked" <?php } ?>><input onclick="show_hide('reply_fiter_replace','',1);" name="set[is_fiter_reply]" type="radio" class="is_fiter_reply" value="1"  <?php if($info['is_fiter_reply'] == 1) { ?> checked="checked" <?php } ?>>
&nbsp;是</li>
    <li <?php if($info['is_fiter_reply'] != 1) { ?> class="checked" <?php } ?>><input onclick="show_hide('reply_fiter_replace','',2);" name="set[is_fiter_reply]" type="radio" class="is_fiter_reply" value="2" <?php if($info['is_fiter_reply'] != 1) { ?> checked="checked" <?php } ?>>
    否    </li>
</ul></td>
  <td class="vtop tips2" s="1">&nbsp;</td>
</tr>
<tr >
<tbody id="reply_fiter_replace" <?php if($info['is_fiter_reply'] != 1) { ?> style="display:none" <?php } ?>>
<tr >
  <td colspan="2" class="td27" s="1">回复替换规则:<a href="javascript:void(0)" onclick="insertAtCursor('reply_replace_rules','(*)')">插入可变区域(*)</a></td>
</tr>
<tr class="noborder" ><td class="vtop rowform">
<textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[reply_replace_rules]" id="reply_replace_rules" cols="50" class="tarea w_area" '..'=""><?php echo $info['reply_replace_rules'];?></textarea></td>
<td class="vtop tips2" s="1"><p>用@@隔开，每行一组。比如 aa@@bb，表示将aa替换成bb</p>  </td>
</tr>
<?php if($_REQUEST['pmod'] != 'system_rules' || $_G['inajax']) { ?>
 <tr>
  <th  class="td27" colspan="15">格式化内容</th>
</tr>
<tr  class="noborder">
  <td class="vtop rowform"><?php echo show_filter_html($info['reply_filter_html'], 'reply_filter_html');?></td>
  <td s="1" class="vtop tips2"><p>自动去除选定标签</p></td>
</tr>
<?php } ?>
<tr >
  <td colspan="2" class="td27" s="1">回复剔除规则:</td>
</tr>
<tr class="noborder" >
  <td colspan="2" class="vtop rowform">
<table width="500" class="tb tb2 tdtable" >

<tr class="header"><th width="100">规则类型</th>
  <th width="200">规则内容&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
  <th>操作</th>
</tr>
<tbody id="reply_filter_rules_tbody"><?php echo create_rules_html('reply_filter_rules', $info['reply_filter_rules']);?></tbody>

<tbody><tr class="hover">
  <td><a href="javascript:void(0)"   onclick="add_rules('reply_filter_rules');">增加一组规则</a></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr></tbody>
</table></td>
  </tr>
</tbody>
<?php if($_REQUEST['pmod'] != 'system_rules' || $_G['inajax']) { ?>
<tr >
  <td s="1" class="td27" colspan="2">最大采集回复数:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<input name="set[reply_max_num]" type="text" class="txt" id="reply_max_num" value="<?php echo $info['reply_max_num'];?>"></td>
<td s="1" class="vtop tips2">填20代表采集前20个回复,填10,20表示随机采集此范围数目的回复数。不填写或者填0，表示采集完所有回复，请谨慎填写，如果帖子回复太多，可能很耗时间</td>
</tr>
<?php } ?>

<tr >
    <td s="1" class="td27" colspan="2"><a onclick="test_window('reply_get_type', 'is_fiter_reply', 'theme_url_test', 'reply_rules', 'reply_replace_rules', 'reply_filter_rules', 'reply')" href="javascript:void(0);">点击查看测试结果</a></td>
</tr>
<?php } ?>
<tr>
  <th colspan="15" class="partition">分页获取方式<font style="font-weight:normal">(如果文章获取回帖没有分页,这项可不填写)</font></th>
</tr>


<tr >
    <td colspan="2" class="td27" s="1">分页 获取规则:<a href="javascript:void(0)" onclick="insertAtCursor('content_page_rules','[link]')">&nbsp;&nbsp;&nbsp;插入分页区域[link]</a></td>
</tr>

<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);">
  <li <?php if($info['content_page_get_type'] == 1 ||!$info['content_page_get_type']) { ?> class="checked" <?php } ?>><input name="set[content_page_get_type]" type="radio" class="content_page_get_type"  value="1"  <?php if($info['content_page_get_type'] == 1 ||!$info['content_page_get_type']) { ?> checked="checked" <?php } ?>>
  DOM获取  </li>
  <li  <?php if($info['content_page_get_type'] == 2 ) { ?> class="checked" <?php } ?> ><input  name="set[content_page_get_type]" type="radio" class="content_page_get_type"  value="2"   <?php if($info['content_page_get_type'] == 2 ) { ?>checked="CHECKED" <?php } ?>>
    字符串获取</li>
</ul></td>
<td s="1" class="vtop tips2">字符串识别就是根据起止字符串截取内容</td>
</tr>


<tr class="noborder" ><td class="vtop rowform">
    <textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[content_page_rules]" id="content_page_rules" cols="50" class="tarea" '..'=""><?php echo $info['content_page_rules'];?></textarea>
    </td>
  <td class="vtop tips2" s="1">*代替任意字符、回车、换行
        在要获取的地方放入[link].</br>dom规则示例:div[class=pgs mtm mbm cl] div.pg a</td>
</tr>

<tr >
    <td colspan="2" class="td27" s="1">分页模式:</td>
</tr>

<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);">
  <li <?php if($info['content_page_get_mode'] == 1 ||!$info['content_page_get_mode']) { ?> class="checked" <?php } ?>><input  name="set[content_page_get_mode]" type="radio" class="page_get_mode"  value="1"  <?php if($info['content_page_get_mode'] == 1 || !$info['content_page_get_mode']) { ?> checked="checked" <?php } ?>>
    全部列出模式</li>
  <li  <?php if($info['content_page_get_mode'] == 2 ) { ?> class="checked" <?php } ?> ><input  name="set[content_page_get_mode]" type="radio" class="page_get_mode"  value="2"    <?php if($info['content_page_get_mode'] == 2 ) { ?>checked="CHECKED" <?php } ?>>
    上下页模式 </li>
</ul></td>
<td s="1" class="vtop tips2"></td>
</tr>

<tr ><td s="1" class="td27" colspan="2"><a onclick="get_content_page();" href="javascript:void(0);">点击测试分页</a></td>
</tr>
<?php if($_G['inajax']) { ?>
]]></root><?php define(FOOTERDISABLED, false);?><?php exit();?><?php } ?>