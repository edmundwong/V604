	$('#id_begindate').datePicker({clickInput:true,createButton:false,startDate:new Date().asString()});
	$('#id_enddate').datePicker({clickInput:true,createButton:false,startDate:new Date().asString()});

	function compareBeginTime(){
		var edate = $('input[name="enddate"]').val()
		var b_time = $('input[name="begindate"]').val()+" "+$('select[name="s_Hour"]').val()+":"+$('select[name="s_Minute"]').val();
		var e_time = edate+" "+$('select[name="e_Hour"]').val()+":"+$('select[name="e_Minute"]').val();
		if (e_time != ' 00:00' && e_time < b_time) {
			return '开始时间不能大于结束时间，请重新选择';
		}
		else{
			var bDate = new Date();
			bDate2 = new Date(bDate.valueOf() + 30 * 24 * 60 * 60 * 1000);
			bMonth = bDate2.getMonth()+1 ;
			btime = bDate2.getFullYear()+"-"+ bMonth+"-"+bDate2.getDate();
			beginDate = $('input[name="begindate"]').val();
			if (beginDate > btime){
				return '活动开始日期需要在30天内';
			}else{
				if (edate != ''){
					$.validator('enddate').displayValid();
				}			
				return true;
			}
		}
	}
	function compareEndTime(){
		var bdate = $('input[name="begindate"]').val()
		var b_time = bdate+" "+$('select[name="s_Hour"]').val()+":"+$('select[name="s_Minute"]').val();
		var e_time = $('input[name="enddate"]').val()+" "+$('select[name="e_Hour"]').val()+":"+$('select[name="e_Minute"]').val();
		if (e_time < b_time) {
			return '结束时间不能小于开始时间，请重新选择';
		}
		else{
			day = DateCompare(b_time,e_time);
			if(day > 365){
				return '活动时间不能超过1年';
			}else{
				if (bdate != '') {
					$.validator('begindate').displayValid();
				}
				return true;
			}
		}
	}
	function   DateCompare(asStartDate,asEndDate){   
		  var   miStart=Date.parse(asStartDate.replace(/\-/g,'/'));   
		  var   miEnd=Date.parse(asEndDate.replace(/\-/g,'/'));   
		  return   (miEnd-miStart)/(1000*24*3600);   
	}