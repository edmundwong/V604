/*
  var obj = document.getElementById("ymenu-side").getElementsByTagName("li");
    window.document.onmouseover = function() {
        var temp = null;
        if (document.all) {
            temp = window.event.srcElement
        }
        else {
            temp = arguments[0].target;
        }
        while (temp != document) {
            if (temp.className && temp.className == "ym-mainmnu") {
                return;
            }
            temp = temp.parentNode;
        }
        for (var j = 0; j < obj.length; j++) {
            if (obj[j].getElementsByTagName("ul").length > 0) {
                obj[j].className = "ym-tab";
                obj[j].getElementsByTagName("ul")[0].style.display = "none";
            }
        }
    }
    for (var i = 0; i < obj.length; i++) {
        obj[i].onmouseover = function() {
            if (this.getElementsByTagName("ul").length > 0) {
                if (this.className != "current") {
                    for (var j = 0; j < obj.length; j++) {
                        if (obj[j].getElementsByTagName("ul").length > 0 && obj[j] != this) {
                            obj[j].className = "ym-tab";
                            obj[j].getElementsByTagName("ul")[0].style.top = obj[j].style.top;
                            obj[j].getElementsByTagName("ul")[0].style.display = "none";
                        }
                    }
                    this.className = "current";
                    this.getElementsByTagName("ul")[0].style.display = "block";
                }
                topCurrentli = this.style.top;
            }
        }
    }
*/

var Speed = 10; 
var Space = 5; 
var PageWidth = 145; 
var fill = 0;
var MoveLock = false;
var MoveTimeObj;
var Comp = 0;
var AutoPlayObj = null;
GetObj("list_scr2").innerHTML = GetObj("list_scr1").innerHTML;
GetObj('isl_cont').scrollLeft = fill;
GetObj("isl_cont").onmouseover = function(){clearInterval(AutoPlayObj);}
GetObj("isl_cont").onmouseout = function(){AutoPlay();}
AutoPlay();
function GetObj(objName){if(document.getElementById){return eval('document.getElementById("'+objName+'")')}else{return eval('document.all.'+objName)}}
function AutoPlay(){
 clearInterval(AutoPlayObj);
 AutoPlayObj = setInterval('isl_godown();isl_stopdown();',3000); 
}
function ISL_GoUp(){ 
 if(MoveLock) return;
 clearInterval(AutoPlayObj);
 MoveLock = true;
 MoveTimeObj = setInterval('isl_scrup();',Speed);
}
function ISL_StopUp(){ 
 clearInterval(MoveTimeObj);
 if(GetObj('isl_cont').scrollLeft % PageWidth - fill != 0){
  Comp = fill - (GetObj('isl_cont').scrollLeft % PageWidth);
  compscr();
 }else{
  MoveLock = false;
 }
 AutoPlay();
}
function isl_scrup(){ 
 if(GetObj('isl_cont').scrollLeft <= 0){GetObj('isl_cont').scrollLeft = GetObj('isl_cont').scrollLeft + GetObj('list_scr1').offsetWidth}
 GetObj('isl_cont').scrollLeft -= Space ;
}
function isl_godown(){ 
 clearInterval(MoveTimeObj);
 if(MoveLock) return;
 clearInterval(AutoPlayObj);
 MoveLock = true;
 ISL_ScrDown();
 MoveTimeObj = setInterval('ISL_ScrDown()',Speed);
}
function isl_stopdown(){ 
 clearInterval(MoveTimeObj);
 if(GetObj('isl_cont').scrollLeft % PageWidth - fill != 0 ){
  Comp = PageWidth - GetObj('isl_cont').scrollLeft % PageWidth + fill;
  compscr();
 }else{
  MoveLock = false;
 }
 AutoPlay();
}
function ISL_ScrDown(){
 if(GetObj('isl_cont').scrollLeft >= GetObj('list_scr1').scrollWidth){GetObj('isl_cont').scrollLeft = GetObj('isl_cont').scrollLeft - GetObj('list_scr1').scrollWidth;}
 GetObj('isl_cont').scrollLeft += Space ;
}
function compscr(){
 var num;
 if(Comp == 0){MoveLock = false;return;}
 if(Comp < 0){ 
  if(Comp < -Space){
   Comp += Space;
   num = Space;
  }else{
   num = -Comp;
   Comp = 0;
  }
  GetObj('isl_cont').scrollLeft -= num;
  setTimeout('compscr()',Speed);
 }else{
  if(Comp > Space){
   Comp -= Space;
   num = Space;
  }else{
   num = Comp;
   Comp = 0;
  }
  GetObj('isl_cont').scrollLeft += num;
  setTimeout('compscr()',Speed);
 }
}
