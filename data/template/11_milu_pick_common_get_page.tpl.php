<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<tbody id="show_get_page" <?php if($info['url_range_type'] == 1 || !$info['url_range_type']) { ?> <?php } else { ?>style="display:none"<?php } ?>>
<tr>
  <th colspan="15" class="partition">列表区域识别设置</th>
</tr>

<tr >
  <td colspan="2" class="td27" s="1">列表获取规则:&nbsp;&nbsp;&nbsp;<a id="insert_string_link" style="<{ <?php if($info['page_get_type'] != 2) { ?>>display:none<<?php } ?>>" href="javascript:void(0)"  onclick="insertAtCursor('page_link_rules','[link]')">插入链接区域[link]</a>&nbsp;&nbsp;&nbsp; </td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<ul onMouseOver="altStyle(this);">
  <li id="li_page_get_type_1" <?php if($info['page_get_type'] == 1) { ?> class="checked" <?php } ?>><input  id="page_get_type_1" name="set[page_get_type]" type="radio" class="page_get_type_dom" onclick="show_hide('page_link_rules_1+page_link_dom','page_link_rules_2+insert_string_link',1);" value="1"  <?php if($info['page_get_type'] == 1) { ?> checked="checked" <?php } ?>>
  DOM获取  </li>
  <li  id="li_page_get_type_2" <?php if($info['page_get_type'] == 2 || !$info['page_get_type']) { ?> class="checked" <?php } ?> ><input id="page_get_type_2"  name="set[page_get_type]" type="radio" class="page_get_type_dom"  value="2"  onclick="show_hide('page_link_rules_1','page_link_rules_2+insert_string_link+page_link_dom',2);"  <?php if($info['page_get_type'] == 2 ||!$info['page_get_type']) { ?>checked="CHECKED" <?php } ?>>
    字符串获取</li>

 <li  id="li_page_get_type_3" <?php if($info['page_get_type'] == 3 ) { ?> class="checked" <?php } ?> ><input id="page_get_type_3"  name="set[page_get_type]" type="radio" class="page_get_type_dom"  value="3"  onclick="show_hide('page_link_rules_1+page_link_rules_2+page_link_dom','page_link_rules_2+insert_string_link+',2);"  <?php if($info['page_get_type'] == 3) { ?>checked="CHECKED" <?php } ?>>
    智能获取</li>


</ul></td>
<td s="1" class="vtop tips2">字符串识别就是根据起止字符串截取内容</td>
</tr>
<tr id="page_link_dom"  <?php if($info['page_get_type'] == 3) { ?>style="display:none"<?php } ?> class="noborder"  ><td class="vtop rowform"><textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="set[page_link_rules]" id="page_link_rules" cols="50" class="tarea w_area"><?php echo $info['page_link_rules'];?></textarea></td>
<td class="vtop tips2" s="1"><p id="page_link_rules_1" style="<?php if($info['page_get_type'] == 2 || !$info['page_get_type']) { ?>display:none<?php } ?>">规则分为两行，第一行是列表的获取规则，第二行设置a标签的属性.写法如：<br />ul.list01 li<br />a<br />详细教程请<a href="http://www.56php.com/guide/rules.htm" target="_brank">点击访问</a></p>
  <p id="page_link_rules_2" style=" <?php if($info['page_get_type'] != 2) { ?>display:none<?php } ?>">*代替任意字符、回车、换行<br>在要获取的地方放入[link]</p></td>
</tr>



<tr >
  <td s="1" class="td27" colspan="2">测试列表地址:<span class="vtop rowform"></span></td>
</tr>
<tr  class="noborder"><td class="vtop rowform">
<input name="set[page_url_test]" type="text" class="longtxt" id="page_url_test" value="<?php echo $info['page_url_test'];?>"></td>
<td s="1" class="vtop tips2">&nbsp;</td>
</tr>
<tr >
  <td colspan="2" class="td27" s="1"><a onclick="get_page_link();" href="javascript:void(0);">点击查看测试结果</a></td>
</tr>


</tbody>