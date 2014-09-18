function get_rate(rate){
	rate=rate.toString();
	var s;
	var g;
	jq("#g").show();
	if (rate.length>=3){
		s=10;
		g=0;
		jq("#g").hide();
	}else if(rate=="0"){
		s=0;
		g=0;
	}else{
		s=rate.substr(0,1);
		g=rate.substr(1,1);
	}
	jq("#s").text(s);
	jq("#g").text("."+ g);
	jq(".big_rate_up").animate({width:(parseInt(s)+parseInt(g)/10) * 14,height:26},1000);
	jq(".big_rate span").each(function(){
		jq(this).mouseover(function(){
			
		})
	})
	jq(".big_rate").mouseout(function(){
		jq("#s").text(s);
		jq("#g").text("."+ g);
		jq(".big_rate_up").width((parseInt(s)+parseInt(g)/10) * 14);
	})
}


jq(document).ready(function(){ 
jq(".listSj dl").mouseover(function(){ 
//如果鼠标移到class为stripe_tb的表格的tr上时，执行函数
jq(this).addClass("over");}).mouseout(function(){ 
//给这行添加class值为over，并且当鼠标一出该行时执行函数
jq(this).removeClass("over");}) //移除该行的class
jq(".listSj dl:even").addClass("alt");
//给class为stripe_tb的表格的偶数行添加class值为alt
});


(function (jq) {
            jq.fn.extend({
                Scroll: function (opt, callback) {
                    if (!opt) var opt = {};
                    var _btnUp = jq("#" + opt.up); //Shawphy:向上按钮      
                    var _btnDown = jq("#" + opt.down); //Shawphy:向下按钮
                    var _this = this.eq(0).find("ul:first");
                    var lineH = _this.find("li:first").height(); //获取行高     
                    var line = opt.line ? parseInt(opt.line, 10) : parseInt(this.height() / lineH, 10); //每次滚动的行数，默认为一屏，即父容器高度
                    var speed = opt.speed ? parseInt(opt.speed, 10) : 600; //卷动速度，数值越大，速度越慢（毫秒） 
                    var m = line;  //用于计算的变量
                    var count = _this.find("li").length; //总共的<li>元素的个数
                    var upHeight = line * lineH;
                    function scrollUp() {
                        if (!_this.is(":animated")) {  //判断元素是否正处于动画，如果不处于动画状态，则追加动画。
                            if (m < count) {  //判断 m 是否小于总的个数
                                m += line;
                                _this.animate({ marginTop: "-=" + upHeight + "px" }, speed);
                            }
                        }
                    }
                    function scrollDown() {
                        if (!_this.is(":animated")) {
                            if (m > line) { //判断m 是否大于一屏个数
                                m -= line;
                                _this.animate({ marginTop: "+=" + upHeight + "px" }, speed);
                            }
                        }
                    }
                    _btnUp.bind("click", scrollUp);
                    _btnDown.bind("click", scrollDown);
                }
            });
        })(jQuery);
      jq(function () {
            jq("#scrollDiv").Scroll({ line: 10, speed: 500,up: "btn1", down: "btn2" });
});        

//-----------------------------------------
