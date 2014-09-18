function PostNew()
{
//	var re='';
//	var urlx="id="+Math.random().toString();
//	$.ajax({
//	type:"get",url:"/islogin.aspx",data:urlx,
//	success:function(msg){
//		if(msg=='a')
//		{
			location.href='/c/post.aspx';	
//		}
//		else
//		{
//			ShineLogin();
//		}
//	}
//	});
}

function report(id,t)
{
	jQuery.get("bad.aspx",{type:t,id:id},function(data){
		if(data=="1")
		{
			alert("举报成功，谢谢！管理员会尽快处理。");
		}
	});
}

function addfavorite(id)
{
	jQuery.get("addfavorite.aspx",{id:id},function(data){
	  if(data=="1")
	  {
		alert("已加入收藏夹");  
	  }
	  if(data=="0")
	  {
		alert("发生错误");  
	  }
	  if(data=="-1")
	  {
		alert("请先登陆再使用此功能");
	  }
	});
}

function ajaxget(file,id,t,hideid)
{
	jQuery.get(file,{type:t,cid:id},function(data){
		if(data=="1")
		{
			if (hideid!="") {
				$("#" + hideid).hide();
			} else {
				alert("done!");				
			}
		} else {
			alert("请先登陆再使用此功能。");	
		}
	});
}

var ShineNum;
var ShineObj;
function ShineLogin()
{	var IsAlter=arguments[0]?arguments[0]:true;
	if(IsAlter==true)
	alert('请您先登陆！');
	if(document.getElementById('formX')!=null)
	{
		var obj=document.getElementById('formX');
		ShineNum=0;
		ShineObj = setInterval('ShineLogin2();',300);
	}
}
function ShineLogin2()
{
	var obj=document.getElementById('formX');
	
	if(obj.style.border=='' || obj.style.border==null)
	{
		obj.style.border='2px #ffff00 solid';
	}
	else
	{
		obj.style.border='';
	}
	if(ShineNum>10){clearInterval(ShineObj);}
	ShineNum++;
}

//viewinfo.aspx
function checkCount()
{
	if ($('#picbox img').length>99)
	{
		$('#picIframe').hide();
	}
	else
	{
		$('#picIframe').show();
	}
}

function picAdd(fliepath, filename, size, isyp){
		$('#loading2').show('slow',function(){
			$('#loading2').show('slow',function(){
				size=(size/1024).toPrecision(4);
				var htmls=$('#picbox').html();
				htmls=htmls+'<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td width="60">';
				htmls=htmls+'<img src="uploadpic/'+fliepath+'/small/'+filename+'" width="60" height="60" /></td>';
				htmls=htmls+'<td width="10"></td>';
				htmls=htmls+'<td style="line-height:20px;"><span style="font-weight: bold;">'+filename+'</span><br><a href="uploadpic/'+fliepath+filename+'" target="_blank">' + filename + '</a> (' + size + ' KB)<br>';
				htmls=htmls+'<a href="javascript:void(0);" class="uPicDel" onclick="picDel(this);">删除</a>';
				if (isyp=="1") {
					var element="CKEDITOR.dom.element.createFromHtml('<img src=uploadpic/"+fliepath+'/'+filename+" border=0>')";
					htmls=htmls+"&nbsp;|&nbsp;<a href=\"javascript:void(0);\" class=\"uPicDel\" onclick=\"javascript:CKEDITOR.instances.c_content.insertElement( " + element + " );\">插入大图</a>";
					var thumb="CKEDITOR.dom.element.createFromHtml('<img src=uploadpic/"+fliepath+'/'+filename+" border=0>')";
					htmls=htmls+"&nbsp;|&nbsp;<a href=\"javascript:void(0);\" onclick=\"javascript:CKEDITOR.instances.c_content.insertElement( " + thumb + " );\">插入缩略图</a>";
				}
				htmls=htmls+'</td></tr></tbody></table>';
				$('#picbox').html(htmls);
				checkCount();
			});
			$('#loading2').hide('slow',function(){
			});
		});
}

function HideLoading()
{
	$('#loading').hide();
}
function ShowLoading()
{
	$('#loading').show();
}
function picDel(x)
{
	$(x).parent().parent().remove();
	checkCount();
}

function getPics()
{
	var pics='';
	$('#picbox img').each(function(i){
		pics=pics+','+this.src.replace(/(.+uploadpic\/)?(.+)/,'$2').replace('/small/','');					   
	});
	if(pics!='')
	{
		pics=pics.replace(/\,(.+)/,'$1')
	}
	$('#pics').val(pics);
}

//post.aspx
function showSmall(obj){
	$('div.typelist').hide('quick');
	$(obj).parent().next().show('slow');
}

//list.aspx
function setArea(id){
	$('#infoareabox').children().attr('class','infoarea_off');
	$('#infoareabox').children('#a'+id.toString()).attr('class','infoarea_on');
}


//用JS给表单的元素赋值，不支持Name相同但Type不同的表单元素
function setFormValue(name,value,formid){
	var FormObj=document.getElementById(formid)?document.getElementById(formid):null;
	if(FormObj==null)
	{
		Obj=document.getElementsByName(name);
		//alert(name+'-'+'1'+Obj);
	}
	else
	{
		Obj=eval('FormObj["'+name+'"]');
		//alert(name+'-'+'0'+Obj);
	}
	Obj=document.getElementsByName(name);
	if(Obj!=undefined){
//		try{
//			if(FormObj!=null){
//				type=Obj.type;
//				Obj=new Array(Obj);
//			}else if(Obj.length!=undefined){
//				type=Obj[0].type;
//			}
//		}catch(e){
//			type=Obj.type;
//			Obj=new Array(Obj);
//		}
		try{
			if(Obj.length==undefined){
				type=Obj.type;
				Obj=new Array(Obj);
			}
			else{
				if(Obj.type=='select-one')
				{
					type='select';
				}
				else
				{
				type=Obj[0].type;
				}
			}
		}
		catch(e){
			type=Obj.type;
			Obj=new Array(Obj);
		}
		//alert(name+'---'+type+'---'+Obj.length);
		if(type=="radio"){
			for(i=0;i<Obj.length;i++){
				if(Obj[i].value==value){
					Obj[i].checked=true;
				}
			}
		}
		else if(type=="text"&&Obj.length>1)
		{
			for(i=0;i<Obj.length;i++){
				if(value.split(',')[i]!=undefined){
				Obj[i].value=value.split(',')[i];
				}
			}
		}
		else if(type=="checkbox"){
			value=","+value+",";
			for(i=0;i<Obj.length;i++){
				if(value.indexOf(","+Obj[i].value+",")>-1){
						Obj[i].checked=true;
				}
			}
		}
		else if(type=="select")
		{
			Obj.value=value;
		}
		else if(type=="textarea"){
			var frameId="";
			for(i=0;i<document.getElementsByTagName("iframe").length;i++){
				if(document.getElementsByTagName("iframe")[i].src.indexOf(name)>=0){
					frameId=document.getElementsByTagName("iframe")[i].id;
				}
			}
			if(frameId==""){
				Obj[0].value=value;
			}else{
				eval(frameId+'.setHTML(value)');
			}
		}else{
			Obj[0].value=value;
		}
	}	
}

/***********************************************
* IFrame SSI script II- © Dynamic Drive DHTML code library (http://www.dynamicdrive.com)
* Visit DynamicDrive.com for hundreds of original DHTML scripts
* This notice must stay intact for legal use
***********************************************/

//Input the IDs of the IFRAMES you wish to dynamically resize to match its content height:
//Separate each ID with a comma. Examples: ["myframe1", "myframe2"] or ["myframe"] or [] for none:
var iframeids=["myframe"]

//Should script hide iframe from browsers that don't support this script (non IE5+/NS6+ browsers. Recommended):
var iframehide="yes"

var getFFVersion=navigator.userAgent.substring(navigator.userAgent.indexOf("Firefox")).split("/")[1]
var FFextraHeight=parseFloat(getFFVersion)>=0.1? 16 : 0 //extra height in px to add to iframe in FireFox 1.0+ browsers

function resizeCaller() {
	var dyniframe=new Array()
	for (i=0; i<iframeids.length; i++){
		if (document.getElementById)
			resizeIframe(iframeids[i])
		//reveal iframe for lower end browsers? (see var above):
		if ((document.all || document.getElementById) && iframehide=="no") {
			var tempobj=document.all? document.all[iframeids[i]] : document.getElementById(iframeids[i])
			tempobj.style.display="block";
		}
	}
}

function resizeIframe(frameid) {
	var currentfr=document.getElementById(frameid)
	if (currentfr && !window.opera) {
		currentfr.style.display="block"
		if (currentfr.contentDocument && currentfr.contentDocument.body.offsetHeight) //ns6 syntax
			currentfr.height = currentfr.contentDocument.body.offsetHeight+FFextraHeight; 
		else if (currentfr.Document && currentfr.Document.body.scrollHeight) //ie5+ syntax
			currentfr.height = currentfr.Document.body.scrollHeight;
		if (currentfr.addEventListener)
			currentfr.addEventListener("load", readjustIframe, false)
		else if (currentfr.attachEvent) {
			currentfr.detachEvent("onload", readjustIframe) // Bug fix line
			currentfr.attachEvent("onload", readjustIframe)
		}
	}
}

function readjustIframe(loadevt) {
	var crossevt=(window.event)? event : loadevt
	var iframeroot=(crossevt.currentTarget)? crossevt.currentTarget : crossevt.srcElement
	if (iframeroot)
		resizeIframe(iframeroot.id);
}

function loadintoIframe(iframeid, url){
	if (document.getElementById)
		document.getElementById(iframeid).src=url
}

function addFavorite(c,a) {
	var e=window.location.href;
	var d=document.title;
	if(window.sidebar) {
		window.sidebar.addPanel(d,e,"")
	} else {
		if(document.all) {
			window.external.AddFavorite(e,d)
		} else { 
			if(window.opera&&window.print) {
				var b=document.createElement("a");
				b.setAttribute("href",e);
				b.setAttribute("title",d);
				b.setAttribute("rel","sidebar");
				b.click();
			}
		}
	}
}

function add_address(id) {
	var addressid="address" + id;
	var addressid=document.getElementById(addressid);
	var idinc = parseInt(id, 10) + 1;
	var add_address_div=document.getElementById("add_address_div");
	var add_address_href=document.getElementById("add_address_href");
	addressid.style.display = 'block';
	add_address_href.href = "javascript:add_address('" + idinc.toString() + "');";
	if (id=="10") {
		add_address_div.style.display= 'none';
	}
}

if (window.addEventListener)
window.addEventListener("load", resizeCaller, false)
else if (window.attachEvent)
window.attachEvent("onload", resizeCaller)
else
window.onload=resizeCaller