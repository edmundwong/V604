<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>星座运程查询 - 人在温哥华中文网络</title>
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

<script language="JavaScript" src="http://qq.ip138.com/scripts/train_chk.js"></script>
<script  language=JavaScript>
function search4()
{
window.open("http://www.baidu.com/baidu?ie=gb2312&bs=&sr=&z=&ct=1048576&cl=3&f=8&word="+form1.word2.value)
return false;}</script>

<base target="_blank">
</head>
<body class="PopupBody PopupTabArea">
<table cellspacing="0" cellpadding="0" width="100%" border="0" id="LoginTable">
<tr>
	<td id="TitleArea" class="PopupTitle PopupTitleBorder">
	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">星座运程查询 - 人在温哥华</span>
	<span>查询星座</span></td>
</tr>
<tr>
	<td class="PopupTitleBorder BackColor" style="padding: 15px">

	<form name=form1 action="http://astro.lady.tom.com/script/astro.php">
	请选你的阳历生日：<select name="month"  style="width: 50px;">
          <option selected value=01>01</option>
          <option value=02>02</option>
          <option value=03>03</option>
          <option value=04>04</option>

          <option value=05>05</option>
          <option value=06>06</option>
          <option value=07>07</option>
          <option value=08>08</option>
          <option value=09>09</option>
          <option value=10>10</option>

          <option value=11>11</option>
          <option value=12>12</option>
        </select> 月 
        <select name="day"  style="width: 50px;">
          <option selected value=01>01</option>
          <option value=02>02</option>
          <option value=03>03</option>

          <option value=04>04</option>
          <option value=05>05</option>
          <option value=06>06</option>
          <option value=07>07</option>
          <option value=08>08</option>
          <option value=09>09</option>

          <option value=10>10</option>
          <option value=11>11</option>
          <option value=12>12</option>
          <option value=13>13</option>
          <option value=14>14</option>
          <option value=15>15</option>

          <option value=16>16</option>
          <option value=17>17</option>
          <option value=18>18</option>
          <option value=19>19</option>
          <option value=20>20</option>
          <option value=21>21</option>

          <option value=22>22</option>
          <option value=23>23</option>
          <option value=24>24</option>
          <option value=25>25</option>
          <option value=26>26</option>
          <option value=27>27</option>

          <option value=28>28</option>
          <option value=29>29</option>
          <option value=30>30</option>
          <option value=31>31</option>
        </select> 日 <input type=submit value="查 看" name=submit />
		</form>

		<script language=JavaScript src="http://www.tom.com/nnselect.js"></script>

	</td>
</tr>
<tr>
	<td id="TitleArea" class="PopupTitle PopupTitleBorder">
	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">星座运程查询 - 人在温哥华</span>
	<span>星座运程</span></td>
</tr>

<tr>
	<td class="PopupTitleBorder BackColor" style="padding: 15px">
      <SCRIPT>
strArr=new Array()
strArr[0]=new arrItem("双鱼座","http://astro.sina.com.cn/pisces.html")
strArr[1]=new arrItem("水瓶座","http://astro.sina.com.cn/aquarius.html")	
strArr[2]=new arrItem("魔羯座","http://astro.sina.com.cn/capricorn.html")
strArr[3]=new arrItem("天蝎座","http://astro.sina.com.cn/scorpio.html")
strArr[4]=new arrItem("天秤座","http://astro.sina.com.cn/libra.html")
strArr[5]=new arrItem("处女座","http://astro.sina.com.cn/virgo.html")	
strArr[6]=new arrItem("狮子座","http://astro.sina.com.cn/leo.html")
strArr[7]=new arrItem("巨蟹座","http://astro.sina.com.cn/cancer.html")	
strArr[8]=new arrItem("双子座","http://astro.sina.com.cn/gemini.html")	
strArr[9]=new arrItem("金牛座","http://astro.sina.com.cn/taurus.html")	
strArr[10]=new arrItem("白羊座","http://astro.sina.com.cn/aries.html")
strArr[11]=new arrItem("射手座","http://astro.sina.com.cn/sagittarius.html")

function arrItem(text,link){
	this.text=text
	this.link=link
}

function astroWord(fm){
	var cycle_v;
	var cycle=fm.cycle
	var astro=fm.astro.value
	for ( var i=0; i<cycle.length; i++ ){
	 if ( cycle[i].checked == true ){
	      cycle_v = cycle[i].value
	 }
	}

	if(cycle_v == '日'){
		for (i=0;i<strArr.length;i++){
			if (strArr[i].text==astro){
				window.open(strArr[i].link);
				return false
			}
		}
	}
	return true
}
    </SCRIPT>
<!--运程JS结束-->
	<form onSubmit="return astroWord(this)" action="http://mix.sina.com.cn/astro/view.php" method="post" target="_blank">
    <input type=hidden value=1 name=flag />
	<select name="astro">
		<option value="白羊座">白羊座</option>
		<option value="金牛座">金牛座</option>

		<option value="双子座">双子座</option>
		<option value="巨蟹座">巨蟹座</option>
		<option value="狮子座">狮子座</option>
		<option value="处女座">处女座</option>
		<option value="天秤座">天秤座</option>
		<option value="天蝎座">天蝎座</option>

		<option value="射手座">射手座</option>
		<option value="魔羯座">魔羯座</option>
		<option value="水瓶座">水瓶座</option>
		<option value="双鱼座">双鱼座</option>
	</select> 
	<select name="cycle">
		<option value="日">今日运程</option>

		<option value="周">每周运程</option>
		<option value="月">每月运程</option>
		<option value="2009">2009年运势</option>
	</select> <input type="submit" value="查 看" name="Submit" />
	</form>
	</td>
</tr>

<tr>
	<td id="TitleArea" class="PopupTitle PopupTitleBorder">
	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">星座运程查询 - 人在温哥华</span>
	<span>星座速配</span></td>
</tr>
<tr>
	<td class="PopupTitleBorder BackColor" style="padding: 15px">
	<form name=Hor action="http://tom.go108.com.cn/free_startogether.php" method="post" target="_blank" >
	请输入您的性别：<select size=1 name=iSex style="width: 50px;">

		<option value=1 selected>男</option> <option value=0>女</option>
	</select> 
    星座：<select name=Horoscope>
		<option value=null>请选择</option>
		<option value=0>白羊座</option>
		<option value=1>金牛座</option>

		<option value=2>双子座</option>
		<option value=3>巨蟹座</option>
		<option value=4>狮子座</option>
		<option value=5>处女座</option>
		<option value=6>天秤座</option>
		<option value=7>天蝎座</option> 
		<option value=8>射手座</option>

		<option value=9>摩羯座</option>
		<option value=10>水瓶座</option>
		<option value=11>双鱼座</option>
	</select><br />
	请输入对方性别：<SELECT size=1 name=iSex2 style="width: 50px;">
		<option value=1 selected>女</option>

		<option value=0>男</option>
	</select>            
	星座：<select name=Horoscope2>
		<option value=null>请选择</option>
		<option value=0>白羊座</option>
		<option value=1>金牛座</option>
		<option value=2>双子座</option>

		<option value=3>巨蟹座</option>
		<option value=4>狮子座</option>
		<option value=5>处女座</option>
		<option value=6>天秤座</option>
		<option value=7>天蝎座</option> 
		<option value=8>射手座</option>

		<option value=9>摩羯座</option>
		<option value=10>水瓶座</option>
		<option value=11>双鱼座</option>
	</select>
	<input type=submit value="查 看" name=submit />
	</form>
	</td>

</tr>
<tr>
	<td id="TitleArea" class="PopupTitle PopupTitleBorder">
	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">星座运程查询 - 人在温哥华</span>
	<span>十二生肖</span></td>
</tr>
<tr>
	<td class="PopupTitleBorder BackColor" style="padding: 15px">
	<form action="http://mix.sina.com.cn/astro/view.php" method="post" target="_blank">
	<input type=hidden value=6 name=flag />

	<select name="xiao">
		<option >鼠</option>
		<option>牛</option>
		<option>虎</option>
		<option>兔</option>
		<option>龙</option>

		<option>蛇</option>
		<option>马</option>
		<option>羊</option>
		<option>猴</option>
		<option>鸡</option>
		<option>狗</option>

		<option>猪</option>
	</select><select name="cycle">
		<option value="年">2009年运势</option>
		<option value="综合">综合</option>
	</select> <input type=submit value="查 看" name=submit />
	</form>
	</td>

</tr>
<tr>
	<td id="TitleArea" class="PopupTitle PopupTitleBorder">
	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">星座运程查询 - 人在温哥华</span>
	<span>生肖速配</span></td>
</tr>
<tr>
	<td class="PopupTitleBorder BackColor" style="padding: 15px">
	<form action="http://mix.sina.com.cn/astro/view.php" method="post" target="_blank">
	男：<input type=hidden name=flag value=7 /><select name=xiao_m style="width: 50px;">

			    <option>鼠</option>
			    <option>牛</option>
			    <option>虎</option>
                <option>兔</option>
                <option>龙</option>
                <option>蛇</option>

                <option>马</option>
                <option>羊</option>
                <option>猴</option>
                <option>鸡</option>
                <option>狗</option>
                <option value=猪>猪</option>

		    </select>
	女：<select name=xiao_f style="width: 50px;">
			    <option>鼠</option>
			    <option>牛</option>
			    <option>虎</option>
                <option>兔</option>

                <option>龙</option>
                <option>蛇</option>
                <option>马</option>
                <option>羊</option>
                <option>猴</option>
                <option>鸡</option>

                <option>狗</option>
                <option value=猪>猪</option>
		    </select> <input type=submit value="查 看" name=submit />
	</form>
	</td>
</tr>
<tr>
	<td id="TitleArea" class="PopupTitle PopupTitleBorder">

	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">星座运程查询 - 人在温哥华</span>
	<span>运程玄机</span></td>
</tr>
<tr>
	<td class="PopupTitleBorder BackColor" style="padding: 15px">
	<form name=animalform action=http://tom.go108.com.cn/free_partnership.php method=post target=_blank>
	星座： <select id=star4 name=starname>
		<option value=0 selected>白羊座</option> 
		<option value=1>金牛座</option> 
		<option value=2>双子座</option>

		<option value=3>巨蟹座</option>
		<option value=4>狮子座</option> 
		<option value=5>处女座</option>
		<option value=6>天秤座</option>
		<option value=7>天蝎座</option>
		<option value=8>射手座</option>

		<option value=9>摩羯座</option>
		<option value=10>水瓶座</option>
		<option value=11>双鱼座</option>
	</select>
	血型：<select name=blood>
		<option value=0 selected>O 型</option>

		<option value=1>A 型</option>
		<option value=2>B 型</option>
		<option value=3>AB 型</option>
	</select>
	生肖：<select  name=animals>
		<option value=0 selected>鼠</option>

		<option value=1>牛</option> 
		<option value=2>虎</option>
		<option value=3>兔</option> 
		<option value=4>龙</option>
		<option value=5>蛇</option>
		<option value=6>马</option> 
		<option value=7>羊</option>

		<option value=8>猴</option>
		<option value=9>鸡</option> 
		<option value=10>狗</option> 
		<option value=11>猪</option>
		</select> 
		<input type=submit value="查 看" name=submit />
	</form>
	</td>

</tr>
</table>
</body>
</html>