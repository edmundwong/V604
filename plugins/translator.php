<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>在线翻译</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<link href='/plugins/css/fck_dialog.css' rel='stylesheet' type='text/css'>
<link href='/plugins/css/fck_dialog_common.css' rel='stylesheet' type='text/css' />
	<style>
	table#LoginTable td { 
		padding: 2px 5px 
		color: #333;
		}

	form {
		margin: 10px;
		padding: 0;
		}

	select {
		width: 400px;
		}

	textarea {
		font-family:arial,sans-serif,宋体;
		font-size:14px;
		overflow: auto;
		width: 450px;
		height: 100px;
		}

	.fysub {
		width: 48px;
		}

	ul.list3 {
		display: block;
		margin: 10px;
		padding: 0 0 10px 0;
		list-style: none;
		}

	ul.list3 li{
		float: left;
		display: inline;
		margin: 5px;
		padding: 0;
		list-style: none;
		width: 150px;
		text-align: left;
		border-bottom: 2px solid #DDD;
		padding-bottom: 4px;
		}

	ul.list3 li a {
		font-size: 14px;
		border-left: 5px solid #e3e3c7;
		padding-left: 5px;
		}

	ul.list3 li a:link, ul.list3 li a:visited { 
		color: #039; 
		text-decoration: none 
		}

	ul.list3 li a:hover, ul.list3 li a:active {
		color: #F30;
		text-decoration: none 
		}
	</style>
</head>

<body class="PopupBody PopupTabArea">
<table cellspacing="0" cellpadding="0" width="100%" border="0" id="LoginTable">
<tr>

	<td id="TitleArea" class="PopupTitle PopupTitleBorder">
	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">人在温哥华</span>
	<span>Yahoo 在线翻译</span></td>
</tr>
<tr>
	<td align="center" class="PopupTitleBorder BackColor">
	<form action="http://fanyi.cn.yahoo.com/translate_txt" method="POST">
	<input type="hidden" value="utf-8" name="ei" /> 
	<input type="hidden" value="bf-res" name="fr" />

	<input type="hidden" name="doit" value="done" />
	<input type="hidden" name="intl" value="1"/>
	<input type="hidden" name="tt" value="urltext" />
	<input type="hidden" name="lp" value="en_zh">
	<div><textarea name="trtext" cols="70" rows="4"  style="font-family:arial,sans-serif,宋体;font-size:16px; "></textarea></div>
	<div>
	<select name="lp" >
		<option value="en_zh" selected="selected">英语 → 中文(简体)</option> 
		<option value="zh_en">中文(简体) → 英语</option>

		<option value="zh_zt">中文(简体) → 中文(繁体)</option>
		<option value="">- - - - - - - - - - - - - -</option>
		<option value="en_zt">英语 → 中文(繁体)</option> 
		<option value="zt_en">中文(繁体) → 英语</option>
		<option value="zt_zh">中文(繁体) → 中文(简体)</option>
		<option value="en_ja">英语 → 日语</option> 
		<option value="ja_en">日语 → 英语</option> 
		<option value="en_ko">英语 → 韩国语</option> 
		<option value="ko_en">韩国语 → 英语</option>

		<option value="en_ru">英语 → 俄语</option> 
		<option value="en_nl">英语 → 荷兰语</option>
		<option value="en_fr">英语 → 法语</option> 
		<option value="en_de">英语 → 德语</option>
		<option value="en_el">英语 → 希腊语</option>
		<option value="en_it">英语 → 意大利语</option> 
		<option value="en_pt">英语 → 葡萄牙语</option>

		<option value="en_es">英语 → 西班牙语</option>
		<option value="ru_en">俄语 → 英语</option>
		<option value="fr_nl">法语 → 荷兰语</option>
		<option value="fr_en">法语 → 英语</option>
		<option value="fr_de">法语 → 德语</option>
		<option value="fr_el">法语 → 希腊语</option>

		<option value="fr_it">法语 → 意大利语</option>
		<option value="fr_pt">法语 → 葡萄牙语</option>
		<option value="fr_es">法语 → 西班牙语</option>
		<option value="de_en">德语 → 英语</option> 
		<option value="de_fr">德语 → 法语</option>
		<option value="es_en">西班牙语 → 英语</option>

		<option value="es_fr">西班牙语 → 法语</option> 
		<option value="it_en">意大利语 → 英语</option>
		<option value="it_fr">意大利语 → 法语</option>
		<option value="pt_en">葡萄牙语 → 英语</option> 
		<option value="pt_fr">葡萄牙语 → 法语</option>
		<option value="nl_en">荷兰语 → 英语</option>
		<option value="nl_fr">荷兰语 → 法语</option>

		<option value="el_en">希腊语 → 英语</option> 
		<option value="el_fr">希腊语 → 法语</option>
	</select>
	<input name="btntrtxt" type="submit" class="fysub" value="翻译" />
	</div>
	</form>
	</td>
</tr>
<tr>

	<td id="TitleArea" class="PopupTitle PopupTitleBorder">
	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">人在温哥华</span>
	<span>Google 在线翻译</span></td>
</tr>
<tr>
	<td align="center" class="PopupTitleBorder BackColor">
	<form action="http://translate.google.com/translate_t" method="post" target="_blank">
	<input type="hidden" value="zh-cn" name="hl" />
	<input type="hidden" value="utf8" name="ie" />

	<div><textarea name="text" cols="70" rows="4"></textarea></div>
	<div>
	<select name="langpair">
		<option value="en|zh-CN" selected="selected">英语 → 中文(简体) BETA</option>
		<option value="en|zh-TW">英语 → 中文(繁体) BETA</option>
		<option value="zh|en">中文 → 英语 BETA</option>
		<option value="zh-TW|zh-CN">中文(繁体 → 简体) BETA</option>

		<option value="zh-CN|zh-TW">中文(简体 → 繁体) BETA</option>
		<option value="ar|en">阿拉伯文 → 英语 BETA</option>
		<option value="ko|en">朝鲜语 → 英语 BETA</option>
		<option value="de|fr">德语 → 法语</option>
		<option value="de|en">德语 → 英语</option>
		<option value="ru|en">俄语 → 英语 BETA</option>

		<option value="fr|de">法语 → 德语</option>
		<option value="fr|en">法语 → 英语</option>
		<option value="pt|en">葡萄牙语 → 英语</option>
		<option value="ja|en">日语 → 英语 BETA</option>
		<option value="es|en">西班牙语 → 英语</option>
		<option value="it|en">意大利语 → 英语</option>

		<option value="en|ar">英语 → 阿拉伯文 BETA</option>
		<option value="en|ko">英语 → 朝鲜语 BETA</option>
		<option value="en|de">英语 → 德语</option>
		<option value="en|ru">英语 → 俄语 BETA</option>
		<option value="en|fr">英语 → 法语</option>
		<option value="en|pt">英语 → 葡萄牙语</option>

		<option value="en|ja">英语 → 日语 BETA</option>
		<option value="en|es">英语 → 西班牙语</option>
		<option value="en|it">英语 → 意大利语</option>
	</select>
	<input name="submit" type="submit" class="fysub" value="翻译" />
	</div>
	</form>

	</td>
</tr>
<tr>
	<td id="TitleArea" class="PopupTitle PopupTitleBorder">
	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">人在温哥华</span>
	<span>其他在线翻译</span></td>
</tr>
<tr>
	<td align="center" class="PopupTitleBorder BackColor">
	<ul class="list3">

	<!--<li><a href="http://www.google.cn/language_tools" target="_blank">Google在线翻译</a></li>-->
    <li><a href="http://www.netat.net/" target="_blank">金桥翻译</a></li>
	<li><a href="http://www.onlinetranslation.cn/" target="_blank">免费在线翻译</a></li>
	<li><a href="http://www.worldlingo.com/wl/Translate" target="_blank">worldlingo在线翻译</a></li>
	<!--<li><a href="jianfanzh.html">在线繁体字转换</a></li>-->
	</ul>
	</td>

</tr>
</table>
</body>
</html>