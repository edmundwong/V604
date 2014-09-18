<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>货币汇率查询</title>
<link href='base.css' rel='stylesheet' type='text/css'>
<link href='/plugins/css/fck_dialog.css' rel='stylesheet' type='text/css'>
<link href='/plugins/css/fck_dialog_common.css' rel='stylesheet' type='text/css' />

	<style>
	a:link, a:visited { 
		color: #333; 
		text-decoration: none 
		}

	a:hover, a:active {
		color: #F30;
		text-decoration: none 
		}

	ul.list2 {
		display: block;
		margin: 10px;
		padding: 0 0 10px 0;
		list-style: none;
		}

	ul.list2 li{
		float: left;
		display: inline;
		margin: 5px;
		padding: 0;
		list-style: none;
		width: 200px;
		text-align: left;
		border-bottom: 2px solid #DDD;
		padding-bottom: 4px;
		}

	ul.list2 li a {
		font-size: 14px;
		border-left: 5px solid #e3e3c7;
		padding-left: 5px;
		}
	form {
		margin: 0;
		padding: 0;
		}

	form div {
		margin: 5px 0;
		}
	</style>
</head>

<body class="PopupBody PopupTabArea">
<table cellspacing="0" cellpadding="0" width="100%" border="0" id="LoginTable">

<tr>
	<td id="TitleArea" class="PopupTitle PopupTitleBorder">
	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">货币汇率 - 人在温哥华中文网络</span>
	<span>货币汇率换算器</span></td>
</tr>
<tr>
	<td align="center" class="PopupTitleBorder BackColor" style="padding: 15px">
	<form name="currcalc" onSubmit="calculate(); return false;">
	<input type=hidden name="flag" value=0>

	<input type=hidden name="result" value=1>
	<input type=hidden name="d_list" value=1>
	<input type=hidden name="version" value="us">
	<input type=hidden name="exp2" value="us1">
	<input type=hidden name="displayres" value="&nbsp; GBP">
	<input type=hidden name="disptkc" value="British Pound">
	<input type=hidden name=t value="markets_curr99.ht">
	<input type=hidden name=tZ>
	<input type=hidden name="translation" value="">

	<input type=hidden name="translation1" value="您的选择出现了一点问题，请重新选择两种货币再试。">
	<input type=hidden name="translation2" value="请输入一个合法的货币数量。">
	<input type=hidden name="translation3" value="该转换工具只能在 Netscape Navigator 或者 Microsoft Internet Explorer 4.0 以上版本中使用。">
	<div>原始币种：<select  name="from_tkc" size="1" style="width: 150px" >
		<option value="">--------- 选择货币 ---------</option>
		<option value="CAD:CUR" selected="selected">加元(CAD)
		<option value="USD:CUR">美元(USD)</option>
		<option value="CNY:CUR">人民币(CNY)</option>

		<option value="HKD:CUR">港币(HKD)</option>
		<option value="TWD:CUR">台币(TWD)</option>
		<option value="">--------------------</option>
		<option value="AUD:CUR">澳元(AUD)</option>
		<option value="BEF:CUR">比利时法郎(BEF)</option>
		<option value="GBP:CUR">英镑(GBP)</option>

		<option value="DKK:CUR">丹麦克朗(DKK)</option>
		<option value="NLG:CUR">荷兰盾(NLG)</option>
		<option value="EUR:CUR">欧元(EUR)</option>
		<option value="FRF:CUR">法国法郎(FRF)</option>
		<option value="DEM:CUR">德国马克(DEM)</option>
		<option value="ITL:CUR">意大利里拉(ITL)</option>

		<option value="JPY:CUR">日元(JPY)</option>
		<option value="CHF:CUR">瑞士法郎(CHF)</option>
		<option value="SGD:CUR">新加坡元(SGD)</option>
	</select> 换算金额：<input type="textbox" name="amount" value="100" size="10" style="width: 90px" /> </div>
	<div>目标币种：<select name="to_tkc" size="1" style="width: 150px" >

		<option value="">--------- 选择货币 ---------</option>
		<option value="CAD:CUR">加元(CAD)</option>
		<option value="USD:CUR">美元(USD)</option>
		<option value="CNY:CUR" selected="selected">人民币(CNY)</option>
		<option value="HKD:CUR">港币(HKD)</option>
		<option value="TWD:CUR">台币(TWD)</option>

		<option value="">--------------------</option>
		<option value="AUD:CUR">澳元(AUD)</option>
		<option value="BEF:CUR">比利时法郎(BEF)</option>
		<option value="GBP:CUR">英镑(GBP)</option>
		<option value="DKK:CUR">丹麦克朗(DKK)</option>
		<option value="NLG:CUR">荷兰盾(NLG) </option>  
		<option value="EUR:CUR">欧元(EUR)</option>

		<option value="FRF:CUR">法国法郎(FRF)</option>
		<option value="DEM:CUR">德国马克(DEM)</option>
		<option value="ITL:CUR">意大利里拉(ITL)</option>
		<option value="JPY:CUR">日元(JPY)</option>
		<option value="CHF:CUR">瑞士法郎(CHF)</option>
		<option value="SGD:CUR">新加坡元(SGD)</option>

	</select> <input type="button" name="cal" value="选好了，开始兑换" onClick="calculate()" style="width: 150px"  /></div>
	<script src="http://www.bloomberg.com/jscommon/calculators/finance.js" language="javascript"></script><script src="http://www.bloomberg.com/jscommon/calculators/mktscurrcalc.js" language="javascript"></script><script src="http://www.bloomberg.com/jscommon/calculators/currdata.js" language="javascript"></script>
	<div style="height: 25px; line-height: 25px; font-size: 14px; color: #900; font-weight: bold"><script language="javascript">
			loadResults();
	</script></div>
	<div>汇率数据来自 BLOOMBERG.COM， 滞后15分钟</div>
	</form>
	</td>

</tr>
<tr>
	<td id="TitleArea" class="PopupTitle PopupTitleBorder">
	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">货币汇率查询 - 人在温哥华网</span>
	<span>其他货币汇率站点</span></td>
</tr>
<tr>
	<td align="center" class="PopupTitleBorder BackColor" style="padding: 5px">
	<ul class="list2">
	<li><a href="http://www.xe.com/ucc/zh/full.shtml" target="blank">XE.COM 汇率换算</a></li>

	<li><a href="http://www.bloomberg.com/invest/calculators/currency.html" target="blank">BLOOMBERG 汇率换算</a></li>
	<li><a href="http://www.rbcroyalbank.com/RBC:RemyL471A8cAAJ12qBI/cgi-bin/travel/fxconvert.pl" target="blank">Royal Bank 汇率换算</a></li>
	<li><a href="http://www.tdcommercialbanking.com/cgi-bin/exchange_cal/exchangeCal.pl" target="blank">TD Canada Trust 汇率换算</a></li>
	<li><a href="http://www.boc.cn/cn/common/whpj.html" target="blank">中国银行即时外汇牌价</a></li>
	<li><a href="http://finance.yahoo.com/currency" target="blank">Yahoo 即时汇率走势图</a></li>
	</ul>

	</td>
</tr>
</table>
</body>
</html>