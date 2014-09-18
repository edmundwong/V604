/*
name:    Map.js
author:  WindDC
date:    2006-10-27
content: 本程序用JS实现类拟JAVA中MAP对像的功能
*/

function Node(key,value){//键值对对象
this.key=key;
this.value=value;
}

function Map(){//Map类
this.nodes=new Array();
}

Map.prototype.put=function(key,value){//往容器中加入一个键值对
for(var i=0;i<this.nodes.length;i++)
if(this.nodes[i].key==key){//如果键值已存在，则put方法为更新已有数据
this.nodes[i].value=value;
return;
}
var node=new Node(key,value);
this.nodes.push(node);
return;
}//put

   
Map.prototype.get=function(key){//获取指定键的值
for(var i=0;i<this.nodes.length;i++)
if(this.nodes[i].key==key)
return this.nodes[i].value;
return null;
}//get

Map.prototype.size=function(){//获取容器中对象的个数
return this.nodes.length;
}//size

         
Map.prototype.clear=function(){//清空容器
while(this.nodes.length>0)
this.nodes.pop();      
}//clear

Map.prototype.remove=function(key){//删除指定值
for(var i=0;i<this.nodes.length;i++)
if(this.nodes[i].key==key){
if(i>0)
var nodes1=this.nodes.concat(this.nodes.slice(0,i-1),this.nodes.slice(i+1));
else//删除的是第一个元素
var nodes1=nodes.slice(1);
this.nodes=nodes1;

        }
}//remove


Map.prototype.isEmpty=function(){//是否为空
if(this.nodes.length==0)
return true;
else
return false;
}//isEmpty

Map.prototype.toString=function(){
var str="";
for(var i=0;i<this.nodes.length;i++){
if(i<this.nodes.length-1)
str=str+this.nodes[i].key+";"+this.nodes[i].value+",";
else
str=str+this.nodes[i].key+";"+this.nodes[i].value;    
}
str=str+"";
return str;
}
