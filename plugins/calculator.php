<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>智能计算器 - 人在温哥华</title>
<link href='/plugins/css/fck_dialog.css' rel='stylesheet' type='text/css'>
<link href='/plugins/css/fck_dialog_common.css' rel='stylesheet' type='text/css' />

<style>
form {
	margin: 0;
	padding: 0;
	}

input.lb1 {
	COLOR: #1919CD; 
	font-size:12px; 
	line-height:24px;
	width: 50px;
	}

input.lb2 {
	COLOR: #D316D3; 
	font-size:12px; 
	line-height:24px;
	width: 50px;
	}

input.lb3 {
	COLOR: #B50506; 
	line-height:24px;
	font-size:12px; 
	}

input.cb1 {
	COLOR: #1919CD; 
	font-size:16px; 
	line-height:24px;
	width: 60px;
	}

input.cb2 {
	COLOR: #B50506; 
	font-size:14px; 
	line-height:24px;
	width: 60px;
	}

input.cb3 {
	COLOR: #1919CD;
	font-size:14px;
	line-height:24px;
	width: 60px;
	}

</style>

<SCRIPT language=javascript>
<!--
var endNumber=true
var mem=0
var carry=10
var hexnum="0123456789abcdef"
var angle="d"
var stack=""
var level="0"
var layer=0


//数字键

function inputkey(key)
{
	var index=key.charCodeAt(0);
	if ((carry==2 && (index==48 || index==49))
	 || (carry==8 && index>=48 && index<=55)
	 || (carry==10 && (index>=48 && index<=57 || index==46))
	 || (carry==16 && ((index>=48 && index<=57) || (index>=97 && index<=102))))
	if(endNumber)
	{
		endNumber=false
		document.calc.display.value = key
	}
	else if(document.calc.display.value == null || document.calc.display.value == "0")
		document.calc.display.value = key
	else
		document.calc.display.value += key
}

function changeSign()
{
    if (document.calc.display.value!="0")
    	if(document.calc.display.value.substr(0,1) == "-")
        	document.calc.display.value = document.calc.display.value.substr(1)
    	else
        	document.calc.display.value = "-" + document.calc.display.value
}

//函数键

function inputfunction(fun,shiftfun)
{
	endNumber=true
	if (document.calc.shiftf.checked)
		document.calc.display.value=decto(funcalc(shiftfun,(todec(document.calc.display.value,carry))),carry)
	else
		document.calc.display.value=decto(funcalc(fun,(todec(document.calc.display.value,carry))),carry)
	document.calc.shiftf.checked=false
	document.calc.hypf.checked=false	
	inputshift()
}

function inputtrig(trig,arctrig,hyp,archyp)
{
	if (document.calc.hypf.checked)
		inputfunction(hyp,archyp)
	else
		inputfunction(trig,arctrig)
}


//运算符

function operation(join,newlevel)
{
	endNumber=true
	var temp=stack.substr(stack.lastIndexOf("(")+1)+document.calc.display.value
	while (newlevel!=0 && (newlevel<=(level.charAt(level.length-1))))
	{
		temp=parse(temp)
		level=level.slice(0,-1)
	}
	if (temp.match(/^(.*\d[\+\-\*\/\%\^\&\|x])?([+-]?[0-9a-f\.]+)$/))
		document.calc.display.value=RegExp.$2
	stack=stack.substr(0,stack.lastIndexOf("(")+1)+temp+join
	document.calc.operator.value=" "+join+" "
	level=level+newlevel
	
}

//括号

function addbracket()
{
	endNumber=true
	document.calc.display.value=0
	stack=stack+"("
	document.calc.operator.value="   "
	level=level+0
	
	layer+=1
	document.calc.bracket.value="(="+layer
}

function disbracket()
{
	endNumber=true
	var temp=stack.substr(stack.lastIndexOf("(")+1)+document.calc.display.value
	while ((level.charAt(level.length-1))>0)
	{
		temp=parse(temp)
		level=level.slice(0,-1)
	}
	
	document.calc.display.value=temp
	stack=stack.substr(0,stack.lastIndexOf("("))
	document.calc.operator.value="   "
	level=level.slice(0,-1)

	layer-=1
	if (layer>0)
		document.calc.bracket.value="(="+layer
	else
		document.calc.bracket.value=""
}

//等号

function result()
{
	endNumber=true
	while (layer>0)
		disbracket()
	var temp=stack+document.calc.display.value
	while ((level.charAt(level.length-1))>0)
	{
		temp=parse(temp)
		level=level.slice(0,-1)
	}

	document.calc.display.value=temp
	document.calc.bracket.value=""
	document.calc.operator.value=""
	stack=""
	level="0"
}


//修改键

function backspace()
{
	if (!endNumber)
	{
		if(document.calc.display.value.length>1)
			document.calc.display.value=document.calc.display.value.substring(0,document.calc.display.value.length - 1)
		else
			document.calc.display.value=0
	}
}

function clearall()
{
	document.calc.display.value=0
	endNumber=true
	stack=""
	level="0"
	layer=""
	document.calc.operator.value=""
	document.calc.bracket.value=""
}


//转换键

function inputChangCarry(newcarry)
{
	endNumber=true
	document.calc.display.value=(decto(todec(document.calc.display.value,carry),newcarry))
	carry=newcarry

	document.calc.sin.disabled=(carry!=10)
	document.calc.cos.disabled=(carry!=10)
	document.calc.tan.disabled=(carry!=10)
	document.calc.bt.disabled=(carry!=10)
	document.calc.pi.disabled=(carry!=10)
	document.calc.e.disabled=(carry!=10)
	document.calc.kp.disabled=(carry!=10)
				
	document.calc.k2.disabled=(carry<=2)
	document.calc.k3.disabled=(carry<=2)
	document.calc.k4.disabled=(carry<=2)
	document.calc.k5.disabled=(carry<=2)
	document.calc.k6.disabled=(carry<=2)
	document.calc.k7.disabled=(carry<=2)
	document.calc.k8.disabled=(carry<=8)
	document.calc.k9.disabled=(carry<=8)
	document.calc.ka.disabled=(carry<=10)
	document.calc.kb.disabled=(carry<=10)
	document.calc.kc.disabled=(carry<=10)
	document.calc.kd.disabled=(carry<=10)
	document.calc.ke.disabled=(carry<=10)
	document.calc.kf.disabled=(carry<=10)

	
	
}

function inputChangAngle(angletype)
{
	endNumber=true
	angle=angletype
	if (angle=="d")
		document.calc.display.value=radiansToDegress(document.calc.display.value)
	else
		document.calc.display.value=degressToRadians(document.calc.display.value)
	endNumber=true
}

function inputshift()
{
	if (document.calc.shiftf.checked)
	{
		document.calc.bt.value="deg　"
		document.calc.ln.value="exp　"
		document.calc.log.value="expd "
		
		if (document.calc.hypf.checked)
		{
			document.calc.sin.value="ahs　"
			document.calc.cos.value="ahc　"
			document.calc.tan.value="aht　"
		}
		else
		{
			document.calc.sin.value="asin "
			document.calc.cos.value="acos "
			document.calc.tan.value="atan "
		}
		
		document.calc.sqr.value="x^.5 "
		document.calc.cube.value="x^.3 "
		
		document.calc.floor.value=" 小数 "
	}
	else
	{
		document.calc.bt.value="d.ms "
		document.calc.ln.value=" ln　"
		document.calc.log.value=" log "

		if (document.calc.hypf.checked)
		{
			document.calc.sin.value="hsin "
			document.calc.cos.value="hcos "
			document.calc.tan.value="htan "
		}
		else
		{
			document.calc.sin.value="sin　"
			document.calc.cos.value="cos　"
			document.calc.tan.value="tan　"
		}
		
		document.calc.sqr.value="x^2　"
		document.calc.cube.value="x^3　"
		
		document.calc.floor.value=" 取整 "
	}

}
//存储器部分

function clearmemory()
{
	mem=0
	document.calc.memory.value="   "
}

function getmemory()
{
	endNumber=true
	document.calc.display.value=decto(mem,carry)
}

function putmemory()
{
	endNumber=true
	if (document.calc.display.value!=0)
	{
		mem=todec(document.calc.display.value,carry)
		document.calc.memory.value=" M "
	}
	else
		document.calc.memory.value="   "
}

function addmemory()
{
	endNumber=true
	mem=parseFloat(mem)+parseFloat(todec(document.calc.display.value,carry))
	if (mem==0)
		document.calc.memory.value="   "
	else
		document.calc.memory.value=" M "
}

function multimemory()
{
	endNumber=true
	mem=parseFloat(mem)*parseFloat(todec(document.calc.display.value,carry))
	if (mem==0)
		document.calc.memory.value="   "
	else
		document.calc.memory.value=" M "
}

//十进制转换

function todec(num,oldcarry)
{
	if (oldcarry==10 || num==0) return(num)
	var neg=(num.charAt(0)=="-")
	if (neg) num=num.substr(1)
	var newnum=0
	for (var index=1;index<=num.length;index++)
		newnum=newnum*oldcarry+hexnum.indexOf(num.charAt(index-1))
	if (neg)
		newnum=-newnum
	return(newnum)
}

function decto(num,newcarry)
{
	var neg=(num<0)
	if (newcarry==10 || num==0) return(num)
	num=""+Math.abs(num)
	var newnum=""
	while (num!=0)
	{
		newnum=hexnum.charAt(num%newcarry)+newnum
		num=Math.floor(num/newcarry)
	}
	if (neg)
		newnum="-"+newnum
	return(newnum)
}

//表达式解析

function parse(string)
{
	if (string.match(/^(.*\d[\+\-\*\/\%\^\&\|x\<])?([+-]?[0-9a-f\.]+)([\+\-\*\/\%\^\&\|x\<])([+-]?[0-9a-f\.]+)$/))
		return(RegExp.$1+cypher(RegExp.$2,RegExp.$3,RegExp.$4))
	else
		return(string)
}

//数学运算和位运算

function cypher(left,join,right)
{
	left=todec(left,carry)
	right=todec(right,carry)
	if (join=="+")
		return(decto(parseFloat(left)+parseFloat(right),carry))
	if (join=="-")
		return(decto(left-right,carry))
	if (join=="*")
		return(decto(left*right,carry))
	if (join=="/" && right!=0)
		return(decto(left/right,carry))
	if (join=="%")
		return(decto(left%right,carry))
	if (join=="&")
		return(decto(left&right,carry))
	if (join=="|")
		return(decto(left|right,carry))
	if (join=="^")
		return(decto(Math.pow(left,right),carry))

	if (join=="x")
		return(decto(left^right,carry))
	if (join=="<")
		return(decto(left<<right,carry))
	alert("除数不能为零")
	return(left)
}

//函数计算

function funcalc(fun,num)
{
	with(Math)
	{
		if (fun=="pi")
			return(PI)
		if (fun=="e")
			return(E)

		if (fun=="abs")
			return(abs(num))
		if (fun=="ceil")
			return(ceil(num))
		if (fun=="round")
			return(round(num))

		if (fun=="floor")
			return(floor(num))
		if (fun=="deci")
			return(num-floor(num))


		if (fun=="ln" && num>0)
			return(log(num))
		if (fun=="exp")
			return(exp(num))
		if (fun=="log" && num>0)
			return(log(num)*LOG10E)
		if (fun=="expdec")
			return(pow(10,num))

		
		if (fun=="cube")
			return(num*num*num)
		if (fun=="cubt")
			return(pow(num,1/3))
		if (fun=="sqr")
			return(num*num)
		if (fun=="sqrt" && num>=0)
			return(sqrt(num))

		if (fun=="!")
			return(factorial(num))

		if (fun=="recip" && num!=0)
			return(1/num)
		
		if (fun=="dms")
			return(dms(num))
		if (fun=="deg")
			return(deg(num))

		if (fun=="~")
			return(~num)
	
		if (angle=="d")
		{
			if (fun=="sin")
				return(sin(degressToRadians(num)))
			if (fun=="cos")
				return(cos(degressToRadians(num)))
			if (fun=="tan")
				return(tan(degressToRadians(num)))

			if (fun=="arcsin" && abs(num)<=1)
				return(radiansToDegress(asin(num)))
			if (fun=="arccos" && abs(num)<=1)
				return(radiansToDegress(acos(num)))
			if (fun=="arctan")
				return(radiansToDegress(atan(num)))
		}
		else
		{
			if (fun=="sin")
				return(sin(num))
			if (fun=="cos")
				return(cos(num))
			if (fun=="tan")
				return(tan(num))

			if (fun=="arcsin" && abs(num)<=1)
				return(asin(num))
			if (fun=="arccos" && abs(num)<=1)
				return(acos(num))
			if (fun=="arctan")
				return(atan(num))
		}
	
		if (fun=="hypsin")
			return((exp(num)-exp(0-num))*0.5)
		if (fun=="hypcos")
			return((exp(num)+exp(-num))*0.5)
		if (fun=="hyptan")
			return((exp(num)-exp(-num))/(exp(num)+exp(-num)))

		if (fun=="ahypsin" | fun=="hypcos" | fun=="hyptan")
		{
			alert("对不起,公式还没有查到!")
			return(num)
		}
		
		alert("超出函数定义范围")
		return(num)
	}
}

function factorial(n)
{
	n=Math.abs(parseInt(n))
	var fac=1
	for (;n>0;n-=1)
		fac*=n
	return(fac)
}

function dms(n)
{
	var neg=(n<0)
	with(Math)
	{	
		n=abs(n)
		var d=floor(n)
		var m=floor(60*(n-d))
		var s=(n-d)*60-m
	}
	var dms=d+m/100+s*0.006
	if (neg) 
		dms=-dms
	return(dms)
}

function deg(n)
{
	var neg=(n<0)
	with(Math)
	{
		n=abs(n)
		var d=floor(n)
		var m=floor((n-d)*100)
		var s=(n-d)*100-m
	}
	var deg=d+m/60+s/36
	if (neg) 
		deg=-deg
	return(deg)
}

function degressToRadians(degress)
{
	return(degress*Math.PI/180)
}

function radiansToDegress(radians)
{
	return(radians*180/Math.PI)
}

//界面

//-->
</SCRIPT>
<body class="PopupBody PopupTabArea">
<table cellspacing="0" cellpadding="0" width="100%" border="0" id="LoginTable">

<tr>
	<td id="TitleArea" class="PopupTitle PopupTitleBorder">
	<span style="float: right; font-size: 12px; font-weight: normal; padding-top: 5px;">人在温哥华</span>
	<span>智能计算器</span></td>
</tr>
<tr>
	<td align="center" class="PopupTitleBorder BackColor" style="text-align: left; padding: 10px">
	<form name="calc">
	<table width="650" bgcolor="#F1F1F1" style="border-width:1px 1px 1px 1px;border-style:solid;border-color:#DDD;">

	<tr>
	<td height="50" bgcolor="#F1F1F1">
		<table width="100%">
		<tr>
			<td height="35" align="center"><INPUT name="display" readOnly size="50" value="0" style="width: 100%; font-size:18px;"></td>
		</tr>
		</table>
	</td>
	</tr>

	<tr>
    <td bgcolor="#F1F1F1">
	<table width="100%" style="border-width:1px 0px 0px 0px;border-style:solid;border-color:#DDD;">
	<TR>
		<TD style="color:#205001;"><INPUT name=carry onclick=inputChangCarry(16) 
            type=radio> 十六进制 <INPUT CHECKED name=carry 
            onclick=inputChangCarry(10) type=radio> 十进制 <INPUT name=carry 
            onclick=inputChangCarry(8) type=radio> 八进制 <INPUT name=carry 
            onclick=inputChangCarry(2) type=radio> 二进制 </TD>

          <TD width="187" style="color:#205001;"><INPUT CHECKED name=angle 
            onclick="inputChangAngle('d')" type=radio value=d> 
            角度制 
              <INPUT 
            name=angle onClick="inputChangAngle('r')" type=radio value=r> 
              弧度制        </TD>
          </TR></TABLE>
      <TABLE width=100%>
        
        <TR>
          <TD width=170 style="color:#205001;"><INPUT name=shiftf onclick=inputshift() 
            type=checkbox>上档功能 <INPUT name=hypf onclick=inputshift() 
            type=checkbox>双曲函数 </TD>
          <TD width="154" align="center"><INPUT name=bracket readOnly size=3 
            style="BACKGROUND-COLOR: lightgrey; line-height:24px;"> <INPUT name=memory readOnly 
            size=3 style="BACKGROUND-COLOR: lightgrey; line-height:24px;"> <INPUT name=operator 
            readOnly size=3 style="BACKGROUND-COLOR: lightgrey; "> </TD>

          <TD align="right"><INPUT onclick=backspace() class="lb3" type=button value="　退格　"> 
<INPUT onClick="document.calc.display.value = 0 " class="lb3" type=button value="　清屏　"> 
<INPUT onclick=clearall() class="lb3" type=button value="　全清　">          </TD>
        </TR></TABLE>
      <TABLE width=100%>
        <TR>
          <TD>
            <TABLE>
              
              <TR align=middle>

                <TD><INPUT name=pi onClick="inputfunction('pi','pi')" class="lb1" type=button value=" PI　"> 
                </TD>
                <TD><INPUT name=e onClick="inputfunction('e','e')" class="lb1" type=button value="　E　"> 
                </TD>
                <TD><INPUT name=bt onClick="inputfunction('dms','deg')"  class="lb2"type=button value=" d.ms "> 
                </TD></TR>
              <TR align=middle>
                <TD><INPUT onclick=addbracket()  class="lb2"type=button value="　(　"> 
                </TD>
                <TD><INPUT onclick=disbracket()  class="lb2"type=button value="　)　"> 
                </TD>

                <TD><INPUT name=ln onClick="inputfunction('ln','exp')"  class="lb2"type=button value="　ln　"> 
                </TD></TR>
              <TR align=middle>
                <TD><INPUT name=sin onClick="inputtrig('sin','arcsin','hypsin','ahypsin')"  class="lb2"type=button value="sin　"> 
                </TD>
                <TD><INPUT onClick="operation('^',7)"  class="lb2"type=button value="x^y　"> 
                </TD>
                <TD><INPUT name=log onClick="inputfunction('log','expdec')"  class="lb2"type=button value=" log　"> 
                </TD></TR>
              <TR align=middle>
                <TD><INPUT name=cos onClick="inputtrig('cos','arccos','hypcos','ahypcos')"  class="lb2"type=button value="cos　"> 
                </TD>

                <TD><INPUT name=cube onClick="inputfunction('cube','cubt')"  class="lb2"type=button value="x^3　"> 
                </TD>
                <TD><INPUT onClick="inputfunction('!','!')"  class="lb2"type=button value="　n!　"> 
                </TD></TR>
              <TR align=middle>
                <TD><INPUT name=tan onClick="inputtrig('tan','arctan','hyptan','ahyptan')"  class="lb2"type=button value="tan　"> 
                </TD>
                <TD><INPUT name=sqr onClick="inputfunction('sqr','sqrt')"  class="lb2"type=button value="x^2　"> 
                </TD>
                <TD><INPUT onClick="inputfunction('recip','recip')"  class="lb2"type=button value=" 1/x　"> 
                </TD></TR></TABLE></TD>

          <TD width=30></TD>
          <TD>
            <TABLE>
              
              <TR>
                <TD align="center"><INPUT onclick=putmemory() class="lb3" type=button value=" 储存 ">                </TD>
              </TR>
              <TR>
                <TD><INPUT onclick=getmemory() class="lb3" type=button value=" 取存 "> 
                </TD></TR>

              <TR>
                <TD><INPUT onclick=addmemory() class="lb3" type=button value=" 累存 "> 
                </TD></TR>
              <TR>
                <TD><INPUT onclick=multimemory() class="lb3" type=button value=" 积存 "> 
                </TD></TR>
              <TR>
                <TD height=33><INPUT onclick=clearmemory() class="lb3" type=button value=" 清存 "> 
                </TD></TR></TABLE></TD>
          <TD width=30></TD>

          <TD>
            <TABLE>
              
              <TR align=middle>
                <TD><INPUT name=k7 onClick="inputkey('7')" style="COLOR: #1919CD; font-size:16px; line-height:24px; " type=button value="　7　"> 
                </TD>
                <TD><INPUT name=k8 onClick="inputkey('8')" class="cb1" type=button value="　8　"> 
                </TD>
                <TD><INPUT name=k9 onClick="inputkey('9')" class="cb1" type=button value="　9　"> 
                </TD>
                <TD><INPUT onClick="operation('/',6)" class="cb2" type=button value="　/　"> 
                </TD>

                <TD><INPUT onClick="operation('%',6)" class="cb2" type=button value=" 取余 "> 
                </TD>
                <TD><INPUT onClick="operation('&amp;',3)" class="cb2" type=button value="　与　"> 
                </TD></TR>
              <TR align=middle>
                <TD><INPUT name=k4 onClick="inputkey('4')" class="cb1" type=button value="　4　"> 
                </TD>
                <TD><INPUT name=k5 onClick="inputkey('5')" class="cb1" type=button value="　5　"> 
                </TD>
                <TD><INPUT name=k6 onClick="inputkey('6')" class="cb1" type=button value="　6　"> 
                </TD>

                <TD><INPUT onClick="operation('*',6)" class="cb2" type=button value="　*　"> 
                </TD>
                <TD><INPUT name=floor onClick="inputfunction('floor','deci')" class="cb2" type=button value=" 取整 "> 
                </TD>
                <TD><INPUT onClick="operation('|',1)" class="cb2" type=button value="　或　"> 
                </TD></TR>
              <TR align=middle>
                <TD><INPUT onClick="inputkey('1')" class="cb1" type=button value="　1　"> 
                </TD>
                <TD><INPUT name=k2 onClick="inputkey('2')" class="cb1" type=button value="　2　"> 
                </TD>

                <TD><INPUT name=k3 onClick="inputkey('3')" class="cb1" type=button value="　3　"> 
                </TD>
                <TD><INPUT onClick="operation('-',5)" class="cb2" type=button value="　-　"> 
                </TD>
                <TD><INPUT onClick="operation('<',4)" class="cb2" type=button value=" 左移 "> 
                </TD>
                <TD><INPUT onClick="inputfunction('~','~')" class="cb2" type=button value="　非　"> 
                </TD></TR>
              <TR align=middle>
                <TD><INPUT onClick="inputkey('0')" class="cb1" type=button value="　0　"> 
                </TD>

                <TD><INPUT onclick=changeSign() class="cb1" type=button value=" +/- "> 
                </TD>
                <TD><INPUT name=kp onClick="inputkey('.')" class="cb1" type=button value="　.　"> 
                </TD>
                <TD><INPUT onClick="operation('+',5)" class="cb2" type=button value="　+　"> 
                </TD>
                <TD><INPUT onclick=result() class="cb2" type=button value="　＝　"> 
                </TD>
                <TD><INPUT onClick="operation('x',2)" class="cb2" type=button value=" 异或 "> 
                </TD></TR>
              <TR align=middle>

                <TD><INPUT disabled name=ka onClick="inputkey('a')" class="cb3" type=button value="　A 　"> 
                </TD>
                <TD><INPUT disabled name=kb onClick="inputkey('b')" class="cb3" type=button value="　B 　"> 
                </TD>
                <TD><INPUT disabled name=kc onClick="inputkey('c')" class="cb3" type=button value="　C 　"> 
                </TD>
                <TD><INPUT disabled name=kd onClick="inputkey('d')" class="cb3" type=button value="　D　"> 
                </TD>
                <TD align="center"><INPUT disabled name=ke onClick="inputkey('e')" class="cb3" type=button value="　E 　">                </TD>
                <TD align="center"><INPUT disabled name=kf onClick="inputkey('f')" class="cb3" type=button value="　F 　">    </TD>

    </TR></TABLE></TD></TR></TABLE></TD></TR></TABLE></FORM>
	</td>
</tr>
</table>
</body>
</html>