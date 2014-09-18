
// bdmapname 地图显示位置　isBmaplib　是否有扩展框　bpanel 如果有扩展，扩展搜索内容显示位置
function BaiduMap(bdmapname,title,isBmaplib,bpanel,t_width,t_height){
	var t=this;
	var _markers=new Map();
	var _map = new BMap.Map(bdmapname);
	var _isBmaplib=isBmaplib;
	var _cityname="";
	var _t_width=290;
	var _t_height=105;
	try{
		_t_width=parseInt(t_width);
	}catch(e){}
	try{_t_height=parseInt(t_height);}catch(e){}
// 编写自定义函数,创建标  longitude 经度　latitude　纬度　content 弹出内容
	this.addMarker=function (mark_id,longitude,latitude,content,map_type){
		var _mark_id="mark";
		if(mark_id==null || mark_id==""){
			
		}else{_mark_id=mark_id;}
	  var marker =null;
	  if(map_type=="baidu"){
	  		marker=new BMap.Marker(new BMap.Point(longitude, latitude));
			marker_s(_mark_id);
	  }else{
		  BMap.Convertor.translate(new BMap.Point(latitude, longitude),2,function(point){
							 marker = new BMap.Marker(point);
							 marker_s(_mark_id);		  
										});
	  }
	  function marker_s(){
		  _map.addOverlay(marker);
		  //创建检索信息窗口对象
			var searchInfoWindow = null;
			if(_isBmaplib){
				searchInfoWindow=new BMapLib.SearchInfoWindow(_map, content, {
					title  : title,      //标题
					width  : _t_width,             //宽度
					height : _t_height,              //高度
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
					width: _t_width, //宽度
					height: _t_height, //高度
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
			_markers.put(_mark_id+","+parseFloat(longitude)+","+parseFloat(latitude),_obj);
	  }
	}
	
	this.searchmap=function (mark_id,longitude,latitude){
		var obj=_markers.get(mark_id+","+parseFloat(longitude)+","+parseFloat(latitude));
		var searchInfoWindow = null;
		if(_isBmaplib){
			searchInfoWindow=new BMapLib.SearchInfoWindow(_map, obj.content , {
				title  : title,      //标题
				width  : _t_width,             //宽度
				height : _t_height,              //高度
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
				width: _t_width, //宽度
				height: _t_height, //高度
				panel : "panel", //检索结果面板
				enableAutoPan : true, //自动平移
				searchTypes :[
				]
			});
		}
		
		searchInfoWindow.open(obj.marker);
	}
	
	this.init=function (map_z,longitude,latitude){
		if(map_z==0){
			var point=new BMap.Point(longitude,latitude);
			_initx(point);
			t.initfun();
		}else{
			var native = new BMap.LocalCity();
			native.get(function(r){  
				_cityname=r.name;
				_init(r.name);
				t.initfun();
				
			});
		}
		
	}
	
	function _initx(point){
		_map.centerAndZoom(point,12);   // 初始化地图,设置城市和地图级别。
		 var opts = {type: BMAP_NAVIGATION_CONTROL_SMALL}    
		 _map.addControl(new BMap.NavigationControl(opts));  
		_map.addControl(new BMap.MapTypeControl()); 
		_map.enableScrollWheelZoom(); 
	}
	
	function _init(city){
		_map.centerAndZoom(city,12);   // 初始化地图,设置城市和地图级别。
		 var opts = {type: BMAP_NAVIGATION_CONTROL_SMALL}    
		 _map.addControl(new BMap.NavigationControl(opts));  
		_map.addControl(new BMap.MapTypeControl()); 
		_map.enableScrollWheelZoom(); 
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