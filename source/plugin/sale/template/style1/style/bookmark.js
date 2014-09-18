var agt=navigator.userAgent.toLowerCase();
var is_ie=(agt.indexOf("msie")!=-1);
function $(a) { 
	return document.getElementById(a);
}
update=function(b,a){$(b).innerHTML=a;};

function getElementsByClassName(k,g) {
	var c=$(g)||document;var d=c.getElementsByTagName("*");
	var h=new Array();
	for(var f=0;f<d.length;f++) {
		var b=d[f];
		var a=b.className.split(" ");
		for(var e=0;e<a.length;e++) {
			if(a[e]==k){h.push(b);break;}
		}
	}
	return h;
}

function objGetClass(b) {
	var a=b.getAttribute("className");
	if(!a){a=b.getAttribute("class");}
	return a;
}

function addLoadEvent(a) {
	var b=window.onload;
	if(typeof window.onload!="function") {
		window.onload=a;
	} else {
		window.onload=function(){b();a();};
	}
}

function bookmarkit(a,b) {
	if(a.lastIndexOf("?")>0){
		a=a+"&src=fav";
	} else {
		a=a+"?src=fav";
	}
	
	if(arguments[2]) {
		a=a+"_"+arguments[2];
	}
	
	if(is_ie) {
		window.external.addFavorite(a,b);
	}
	
	window.sidebar.addPanel(b,a,"");
	
}