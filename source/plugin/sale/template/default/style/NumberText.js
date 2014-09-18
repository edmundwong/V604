jQuery.fn.numeric = function() {
	    //如果输入的字符是在0-9之间，或者是backspace、DEL键
	    $(this).keydown(function(event){
	        //window.alert(event.keyCode);
			if(event.shiftKey)
			{
				return false;
			}
            if(((event.keyCode>47)&&(event.keyCode<58))||((event.ctrlKey)&&(event.keyCode==86))||((event.keyCode>95)&&(event.keyCode<106))||(event.keyCode==110)||(event.keyCode==8)||(event.keyCode==46)||(event.keyCode==190)||(event.keyCode==189))
                {
                      return true;
                }
                else
                {
                      
                      return false;
                 }
            });
            
           $(this).blur(function(){               
             
                  var   TextBoxValue=$(this).val();  
                  var   orgValue;
                  
				  if($(this).val()=="")
				  {
						$(this).val("0");
						return;
					}
				  
                  //如果数字全部为0，则设置value=0
                  
                  TextBoxValue=TextBoxValue.replace('$','');
                       
                  if (TextBoxValue.indexOf('.')!=-1)   
                  {   
                      orgValue=TextBoxValue.split(".");   
                      //禁止包括2个以上的小数点，只能包括1个小数点
                      if   (orgValue.length >= 3)
                      {   
                            window.alert("Input error!");
                            $(this).val(0); 
                            return false;
                      }                               
                  }  
                   
                  //如果小数点在最后一位，直接去掉小数点
  
                  orgValue=TextBoxValue.indexOf('.');
                     
                  if (orgValue==TextBoxValue.length-1)
                  {   
                       var newValue=TextBoxValue.substring(0,TextBoxValue.length-1);
                        $(this).val(newValue); 
                  } 
                   
                    //如果小数点在第一位，直接加0
  
                  orgValue=TextBoxValue.indexOf('.');
                     
                  if (orgValue==0)
                  {   
                        
                        orgValue=TextBoxValue.indexOf('-');
                        if (orgValue==1) //如果负号在第二位
                        {
                             window.alert("Input error!");
                             $(this).val(0); 
                             return;                       
                        }
                        var newValue="0"+TextBoxValue;
                        $(this).val(newValue);
                  } 
                                   
                     //如果负号在第一位，小数点在第二位也报错
  
                  orgValue=TextBoxValue.indexOf('-');
                     
                  if (orgValue==0)
                  {   
                        
                        orgValue=TextBoxValue.indexOf('.');
                        if (orgValue==1) //如果小数点在第二位
                        {
                             window.alert("Input error!");
                             $(this).val(0); 
                             return;                       
                        }
                  }                  
                  
                   
                   if (TextBoxValue.indexOf('-')!=-1)   
                  {   
                      orgValue=TextBoxValue.split("-");   
                      //禁止包括2个以上的负号，只能包括1个负号
                      if   (orgValue.length >= 3)
                      {   
                        window.alert("Input error!");
                        $(this).val(0); 
                          return;
                      }
                      else if ( TextBoxValue.indexOf('-')!=0)//如果负号不在第一位也报错
                      {
                         window.alert("Input error!");
                         $(this).val(0); 
                          return;
                      }                               
                  }
                  
                  newValue=parseFloat(TextBoxValue);
                  $(this).val(newValue);
                                                                            
                   
           });
 
};
    