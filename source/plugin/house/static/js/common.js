function brian_showdistrict(container, elems, totallevel, changelevel, containertype) {
	var getdid = function(elem) {
		var op = elem.options[elem.selectedIndex];
		return op['did'] || op.getAttribute('did') || '0';
	};
	var pid = changelevel >= 1 && elems[0] && $(elems[0]) ? getdid($(elems[0])) : 0;
	var cid = changelevel >= 2 && elems[1] && $(elems[1]) ? getdid($(elems[1])) : 0;
	var did = changelevel >= 3 && elems[2] && $(elems[2]) ? getdid($(elems[2])) : 0;
	var coid = changelevel >= 4 && elems[3] && $(elems[3]) ? getdid($(elems[3])) : 0;
	var url = "house.php?mod=ajax&op=district&container="+container+"&containertype="+containertype
		+"&province="+elems[0]+"&city="+elems[1]+"&district="+elems[2]+"&community="+elems[3]
		+"&pid="+pid + "&cid="+cid+"&did="+did+"&coid="+coid+'&level='+totallevel+'&handlekey='+container+'&inajax=1'+(!changelevel ? '&showdefault=1' : '');
	ajaxget(url, container, '');
}
/***
 onclick =" jq('#search_type').val('1');  mm_cat(0,'search_cat_btns')
***/
function mm_cat(mm_id,mm_classname){
    var TSMenuList = jq("."+mm_classname+" > a");
    var clnIn,i;
    for(i=0; i<=TSMenuList.length; i++ ){
       clnIn = TSMenuList[i].className;
       if(i==mm_id){
            TSMenuList[i].className = 'hover';
       }else{
            TSMenuList[i].className = '';
       }
    }
}
/*
 选项卡切换
 选项卡:
<li id="m1" name="m1" class="hover" onmouseover="mm_all(0,'m1','b1','');">选项1</li>
<li id="m1" name="m1" class="off" onmouseover="mm_all(1,'m1','b1','');">选项2</li>
<li id="m1" name="m1" class="off" onmouseover="mm_all(2,'m1','b1','');">选项3/li>

mm_all(0,'m1','b1',''); 
id 为0 全部显示
其他为从1 开始 
内容区域:
<div id="b1" name="b1" style="display: block;"></div>
<div id="b1" name="b1" style="display: none;"></div>
 */
function mm_all(id,menu,Txt,cln){
    var QuickLinkList = document.getElementsByName(Txt),i=0;
    var TSMenuList = document.getElementsByName(menu),i=0;
        var clnIn;
    if(id == 0){
        for(i=0; i<QuickLinkList.length; i++ ){
            QuickLinkList[i].style.display = 'block';
        }
        for(i=0; i<=TSMenuList.length-1; i++ ){
            clnIn = TSMenuList[i].className;
            TSMenuList[i].className = clnIn.replace(cln+'hover',cln+'off');
        }
        TSMenuList[0].className = clnIn.replace(cln+'off',cln+'hover');
    }else{
        for(i=0; i<=TSMenuList.length-1; i++ ){
            clnIn = TSMenuList[i].className;
            if(i==id) { TSMenuList[i].className = clnIn.replace(cln+'off',cln+'hover'); }
            else { TSMenuList[i].className = clnIn.replace(cln+'hover',cln+'off'); }
        }
        id = id-1;
        for(i=0; i<QuickLinkList.length; i++ ){
        if(i==id) {QuickLinkList[i].style.display = 'block';}
        else { QuickLinkList[i].style.display = 'none'; }
        }
    }
}