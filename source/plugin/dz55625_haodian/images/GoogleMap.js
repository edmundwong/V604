
// bdmapname 地图显示位置　isBmaplib　是否有扩展框　bpanel 如果有扩展，扩展搜索内容显示位置
function GoogleMap(bdmapname,title,isBmaplib,bpanel){
	var t=this;
	var _markers=new Map();
	var _map = new BMap.Map(bdmapname);
	var _isBmaplib=isBmaplib;
	var _cityname="";
// 编写自定义函数,创建标  longitude 经度　latitude　纬度　content 弹出内容
	this.addMarker=function (longitude,latitude,content,map_type){
			
	  var marker =null;
	  if(map_type=="baidu"){
	  		marker=new BMap.Marker(new BMap.Point(longitude, latitude));
			marker_s();
	  }else{
		  BMap.Convertor.translate(new BMap.Point(latitude, longitude),2,function(point){
							 marker = new BMap.Marker(point);
							 marker_s();		  
										});
	  }
	  function marker_s(){
		  _map.addOverlay(marker);
		  //创建检索信息窗口对象
			var searchInfoWindow = null;
			if(_isBmaplib){
				searchInfoWindow=new BMapLib.SearchInfoWindow(_map, content, {
					title  : title,      //标题
					width  : 290,             //宽度
					height : 105,              //高度
					panel  : bpanel,         //检索结果面板
					enableAutoPan : true,     //自动平移
					searchTypes   :[
						BMAPLIB_TAB_SEARCH,   //周边检索
						BMAPLIB_TAB_TO_HERE,  //到这里去
						BMAPLIB_TAB_FROM_HERE //从这里出发
					]
											 
				});
			}else{
				searchInfoWindow = new BMapLib.SearchInfoWindow(_map, content, {
					title: title, //标题
					width: 290, //宽度
					height: 105, //高度
					panel : "panel", //检索结果面板
					enableAutoPan : true, //自动平移
					searchTypes :[
					]
				});
			}
			marker.addEventListener("click", function(e){												  
				searchInfoWindow.open(marker);
			})
			var _obj={};
			_obj.longitude=longitude;
			_obj.latitude=latitude;
			_obj.marker=marker;
			_obj.content=content;
			_markers.put(parseFloat(longitude)+","+parseFloat(latitude),_obj);
	  }
	}
	
	this.searchmap=function (longitude,latitude){
		var obj=_markers.get(parseFloat(longitude)+","+parseFloat(latitude));
		var searchInfoWindow = null;
		if(_isBmaplib){
			searchInfoWindow=new BMapLib.SearchInfoWindow(_map, obj.content , {
				title  : title,      //标题
				width  : 290,             //宽度
				height : 105,              //高度
				panel  : bpanel,         //检索结果面板
				enableAutoPan : true,     //自动平移
				searchTypes   :[
					BMAPLIB_TAB_SEARCH,   //周边检索
					BMAPLIB_TAB_TO_HERE,  //到这里去
					BMAPLIB_TAB_FROM_HERE //从这里出发
				]
										 
			});
		}else{
			searchInfoWindow = new BMapLib.SearchInfoWindow(_map, obj.content, {
				title: title, //标题
				width: 290, //宽度
				height: 105, //高度
				panel : "panel", //检索结果面板
				enableAutoPan : true, //自动平移
				searchTypes :[
				]
			});
		}
		
		searchInfoWindow.open(obj.marker);
	}
	
	this.init=function (fun){
		
		
	}
	
	function _init(city){
		
	}
	
	this.centerAndZoom=function(city){
		_map.centerAndZoom(city,12); 
		_cityname=city;
	}
	
	this.getMap=function(){
		return _map;
	}
	this.getCityname=function(){
		return _cityname;
	}
	this.initfun=function(){
	}
}