function brian_showcat(catbox,valuearray,root){
    var x = new Ajax();
	if(valuearray[0]==1){
	    valuearray[1]=$('cat').value;
	    valuearray[2]=$('subcat').value;
	}
	
	x.get(root+"?mod=ajax&op=cat&inajax=1&catbox="+catbox+"&auto="+valuearray[0]+"&cat_pid="+valuearray[1]+"&subcat_pid="+valuearray[2], function(str, x) {
		$(catbox).innerHTML=str;
	});
}

function brian_showarea(areabox,valuearray,root){
    var x = new Ajax();
	if(valuearray[0]==1){
	    valuearray[1]=$('area').value;
	    valuearray[2]=$('subarea').value;
	    valuearray[3]=$('thrarea').value;
	}
	
	x.get(root+"?mod=ajax&op=area&inajax=1&areabox="+areabox+"&auto="+valuearray[0]+"&area="+valuearray[1]+"&subarea="+valuearray[2]+"&thrarea="+valuearray[3], function(str, x) {
		$(areabox).innerHTML=str;
	});
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
 ѡ��л�
 ѡ�:
<li id="m1" name="m1" class="hover" onmouseover="mm_all(0,'m1','b1','');">ѡ��1</li>
<li id="m1" name="m1" class="off" onmouseover="mm_all(1,'m1','b1','');">ѡ��2</li>
<li id="m1" name="m1" class="off" onmouseover="mm_all(2,'m1','b1','');">ѡ��3/li>

mm_all(0,'m1','b1',''); 
id Ϊ0 ȫ����ʾ
����Ϊ��1 ��ʼ 
��������:
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