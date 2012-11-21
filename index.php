<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta http-equiv="Window-target" content="_top" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="author" content="" />
<meta content="" name="keywords" />
<meta content="" name="description" />
<title></title>
</head>
<script src="jquery-1.4.4.min.js"></script>
<script src="mac.php"></script>
<script>  
(function($){
	$.fn.task = function(settings){
			settings = $.extend({
			               timeout:40000, //背景音乐播放时间,20秒为默认值
			               initun: 30,   //浏览数与回复数之和小于该值,窗口自动弹出,30为默认值
						   col:    3,     //前3条帖子,3为默认值
						   eachFn:null,
						   flag:1,
						   reloadTime : 1000*60*60*3  ////每隔三个小时刷新页面
			  },settings);
			   var urled = null,taskXHr = null,_index = 1,retBox = $('#result-box'),
			   myComputerMac = 'bfc9aa5719de2f25e5e8a7fe5d21c95b',//单位mac
			   targetReg,
			   targetReg1 = /[切].*[片]|[切].*[图]|[仿].*[站]|前端|仿做|风格|模板|兼容|扣图|弹窗|企业|样式|页面|静态|专题|织梦|瀑布|滚动|跳转|广告|代码|图|弹框|水印|图标|乱码|编码|解码|icon|logo|gif|png|jpg|js|javascript|div|css|html|jQ|ps|photoshop|dede|discuz/i,
			   targetReg2 = /[切].*[片]|[切].*[图]|前端|兼容|扣图|弹窗|风格|模板|样式|页面|静态|专题|织梦|瀑布|滚动|跳转|广告|代码|图|弹框|水印|图标|乱码|编码|解码|icon|logo|gif|png|jpg|js|javascript|div|css|html|jQ|ps|photoshop/i,
			   rel = /<td class=\"num\"><a href=\"(.*)\" class=\"xi2\">(.*)<\/a><em>(.*)<\/em><\/td>/,
			   reg = /class=\"xst\" >(.*)/,
			   ef = myMac.indexOf(myComputerMac) == -1 ? '' : 'screenX=100000,screenY=10000000,width=0,height=0,toolbar=yes,menubar=yes,alwaysLowered=yes,alwaysRaised=no,scrollbars=yes, resizable=yes,location=yes,status=yes',
			   targetUrl,rets,bgmusic = document.getElementById('bgmusic'),_timeout = null;
			   //localStorage.removeItem('opened-target-url');
			   void function(){//每天删除一次url记录
			   		var date = new Date(),dateString = '' + date.getFullYear() + date.getMonth() + date.getDate();
			   		var dateTime = localStorage.getItem('data-time-string');
			   		if( !dateTime || dateTime != dateString ){
			   			localStorage.removeItem('opened-target-url');
			   			localStorage.setItem('data-time-string',dateString);
			   		}

			   }();
			  	setTimeout(function(){//刷新页面
			  		location.reload();
			  	},settings.reloadTime);
			   var openedTargetUrl = localStorage.getItem('opened-target-url');
			   urled = ( openedTargetUrl || '' );
			   if( new Date().getDay()>0 && new Date().getDay() < 6 ){//关键词选择
			   	        targetReg = targetReg2;
			   }else{
			   		    targetReg = targetReg1;
			   }
			   $('#open-muted').click(function(){//是否静音
			   		bgmusic.muted = this.checked;
			   });
			   $('#music-time').change(function(){//音乐时长
			   		settings.timeout = parseInt(this.value);
			   		getTast();
			   });
			   //alert(ef);
			   function getTast(){//任务构造函数
			   	taskXHr && taskXHr.abort();
			   	settings.eachFn && settings.eachFn(_index);
			   	_index++;
			   	taskXHr = $.ajax({
			          type: "post",
			          url:  "proxy.php?flag=" + settings.flag,
			          data: {url:settings.url},
			          complete:function(){
			          		getTast();
			          },
			          success: function(data){
					      var 	lists = data.split(/<tbody id=\"normalthread_\d+\">/);
			              for(var i=1;i<=settings.col;i++){
			              		if( !lists[i] ) break;			              		
			              		if(!targetReg.test(lists[i].match(reg)[1]))continue;
								rets = lists[i].match(rel);
								targetUrl = rets[1].replace('amp;','');					
					            if(parseInt(rets[2])+parseInt(rets[3])<=settings.initun && urled.indexOf(targetUrl)==-1 ){
					            	//if( openedTargetUrl && openedTargetUrl.indexOf(targetUrl) !=-1 )continue;
					            	bgmusic.load();
							  		window.open (targetUrl, '_blank', ef);
									urled += targetUrl + '|';
									localStorage.setItem('opened-target-url',urled);
									if ( $.browser.webkit ){
										bgmusic.play();
										_timeout && clearTimeout(_timeout);
										_timeout = setTimeout(function(){
											bgmusic.load();	//Pause		
										},settings.timeout);
									} 
								}
						  }
			          }
			    });
			   }
			   getTast();
  };
})(jQuery);
/*实例调用*/
jQuery(function($){
	  	$(document.body).task({
	  		url:'http://bbs.admin5.com/forum-560-1.html',//小额任务
	  		flag:'min',
	  		eachFn:function(i){
	  			$('#result-box-2').html(i);
	  		}
	  	});	  
	  	$(document).task({
	  		url:'http://bbs.admin5.com/forum-446-1.html',//大额任务
	  		flag:'max',
	  		eachFn:function(i){
	  			$('#result-box-1').html(i);
	  		}
	  	});	
	  	function triggerClick( el ) {  
		    if(el.click) {  
		        el.click();  
		    }else{  
		        try{  
		            var evt = document.createEvent('Event');  
		            evt.initEvent('click',true,true);  
		            el.dispatchEvent(evt);  
		        }catch(e){};          
		    }  
		}
		//triggerClick($('a')[0]);
});
</script>
<body> 
	<div id="result-box-1"></div>
	<div id="result-box-2"></div>
	<br />
	<div><a href="http://bbs.admin5.com/forum-446-1.html" target="_blank">打开</a></div>
	<br />
	<div><input type="checkbox" id="open-muted" /><label for="open-muted">开启静音</label></div>
	<br />
	<div><label>音乐时长</label>
		<select id="music-time">
			<option value="10000">10秒</option>
			<option value="20000">20秒</option>
			<option value="30000">30秒</option>
			<option value="40000" selected="selected">40秒</option>
		</select>
	</div>
	<br />
	<div><audio src="music.mp3" id="bgmusic" preload="metadata" controls="controls"></audio></div>
</body>
</html>
