<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>生肖查询 - 人在温哥华</title>
<link href='/plugins/css/fck_dialog.css' rel='stylesheet' type='text/css'>
<link href='/plugins/css/fck_dialog_common.css' rel='stylesheet' type='text/css' />
	<style>
	table#LoginTable td { 
		padding: 2px 5px 
		color: #333;
		}

	form {
		margin: 0;
		padding: 0;
		}

	#birth, .inyear {
		display: inline;
		padding: 0 0 5px 0;
		width: 55px;
		font-size: 14px;
		font-weight: bold;
		color: #900;
		border: none;
		border-bottom: 1px solid #000;
		text-align: center;
		background: transparent;
		}

	</style>


<script language="JavaScript">
<!--
function getpet2 () 
{
	var toyear = 1997;
	var birthyear = document.frm.inyear.value;
	var birthpet="Ox"
	x = (toyear - birthyear) % 12
	if ((x == 1) || (x == -11)) 
		return "鼠";
	if (x == 0)
		return "牛";
	if ((x == 11) || (x == -1)) 
		return "虎";
	if ((x == 10) || (x == -2))
		return "兔";
	if ((x == 9) || (x == -3))
		return "龙";
	if ((x == 8) || (x == -4))
		return "蛇";
	if ((x == 7) || (x == -5))
		return "马";
	if ((x == 6) || (x == -6))
		return "羊";
	if ((x == 5) || (x == -7))
		return "猴";
	if ((x == 4) || (x == -8)) 
		return "鸡";
	if ((x == 3) || (x == -9))
		return "狗";
	if ((x == 2) || (x == -10))
		return "猪";
}
function getpet ()
{
	document.getElementById("birth").innerHTML = getpet2();
}
// -->
</script>
</head>

<body class="PopupBody PopupTabArea">
<table cellspacing="0" cellpadding="0" width="100%" border="0" id="LoginTable">
<tr>
	<td id="TitleArea" class="PopupTitle PopupTitleBorder">
	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">人在温哥华</span>
	<span>生肖查询</span></td>
</tr>
<tr>
	<td class="PopupTitleBorder BackColor" style="padding: 15px">
	<div>您当然不会忘记自己属什么，但您可以很轻松地知道任何年份出生的人的属相吗？</div>

	<div style="font-size: 14px; font-weight: bold; margin: 15px 0">填入查询出生在哪一年，例如：“1990”</div>
	<form name="frm">
	生于 <input size="4" value="1990" name="inyear" class="inyear" /> 年的人 <input onClick="getpet()" type="button" value="生肖为：" /> <div id="birth"></div>
	</form>
	</td>
</tr>
</table>

</body>
</html>