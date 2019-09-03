
//账号正则
var accountPreg = /^[a-zA-z]+[0-9]*$/;
//电话号码正则
var phonePreg = /(^1[34578]\d{9}$)|(^0\d{2,3}-\d{7,8}$)|(^400[016789][0-9]{6}$)/;
//手机号码正则
var telPhonePreg = /^1[34578]\d{9}$/;
//int行验证
var intPreg = /^\d+$/;
//qq验证
var qqPregs = /^[1-9]{1}[0-9]{2,11}$/;
//emial 验证
var emailPreg = /^\w+@\w+(\.\w+)+$/;
//身份证号正则
var carNoPreg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
/*密码必须包含数字字母*/
var pwdPreg = /^([a-zA-z]+[0-9]+)|([0-9]+[a-zA-z]+)$/;
//只能输入含0正整数
function inputIntNumber(obj){
    $(obj).keyup(function(){
        if(this.value.length == 1){
        	if(this.value==0){
        		this.value='';
        	}else{
        		 this.value = this.value.replace(/[^0-9]/g,'');
        	}
           
        }else if(this.value.length == 0){
            this.value = 0;
        }else{
        	var end  = this.value.substring(this.value.length-1);
        	console.log(end);
        	console.log(this.value);
        	if(end=='.'){
        		this.value = this.value.substring(0,this.value.length);
        	}else{
        		  this.value= this.value.replace(/\D/g,'');
        	}
          
        }
        this.value = parseInt(this.value==""?0:this.value);
    });
}

//浮点数限制
function inputFloatNumber(obj){
    $(obj).keyup(function(){
        if('' != this.value.replace(/\d{1,}\.{0,1}\d{0,}/,''))
        {
            this.value = this.value.match(/\d{1,}\.{0,1}\d{0,}/) == null ? '' :this.value.match(/\d{1,}\.{0,1}\d{0,}/);
        }
       if(this.value.length<1){
            this.value = 0;
       }else if(parseInt(this.value)+"." !=this.value && parseInt(this.value)>=1){
           if(parseInt(this.value)==0){
               this.value = parseFloat(this.value);
           }
       }
    });
}

//浮点数限制  type 小数点后的位数 type 默认为2
function  FloatNumber(obj,type){
    $(obj).keyup(function(){ 
         if(parseInt(this.value)>9999999999){
                  this.value =9999999999;
        } 
        if('' != this.value.replace(/\d{1,}\.{0,1}\d{0,}/,''))
        {       	 
        	this.value = this.value.match(/\d{1,}\.{0,1}\d{0,}/) == null ? '' :this.value.match(/\d{1,}\.{0,1}\d{0,}/);	
        	if(this.value.indexOf('.')>1){
        		var pt = (this.value).split('.');
        		 if(pt[1].length>type){
                 	var xs = (this.value).substring(0,type); 
                     this.value =z+'.'+xs;
                 }else{
                 	 this.value = this.value.match(/\d{1,}\.{0,1}\d{0,}/) == null ? '' :this.value.match(/\d{1,}\.{0,1}\d{0,}/);
                 }
        	}
        }
       if(this.value.length<1){
            this.value = 0;
       }else if(this.value.length>0){  
    	  	var z= parseInt(this.value);
    	   if(this.value.indexOf('.')>0){
    		   var pt = (this.value).split('.');
    		   var xs = pt[1].substring(0,type); 
    		  
      		   if(pt[1].length>=type){
                   this.value =z+'.'+xs;
                }
      	   }else{
      		   this.value=z;
      	   }   
       }else if(parseInt(this.value)+"." !=this.value && parseInt(this.value)>=1){
               this.value = parseFloat(this.value);
       }
    });
    $(obj).blur(function(){
    	   if(this.value.indexOf('.')>0){
    		   var pt = (this.value).split('.');
    		  
    		   if(pt[1]==0||pt[1]==00){
    			   this.value = parseInt(this.value);
    		   }
    	   }
    	
    })
}

function phonePregNumber(obj){
    $(obj).keyup(function(){
        if('' != this.value.replace(/\d{1,4}-{0,1}\d{0,9}-{0,1}\d{0,4}/,''))
        {
            this.value = this.value.match(/\d{1,4}-{0,1}\d{0,9}-{0,1}\d{0,4}/) == null ? '' :this.value.match(/\d{1,4}-{0,1}\d{0,9}-{0,1}\d{0,4}/);
        }
    });
}

function haltNumber(obj){
    $(obj).keyup(function(){
        if('' != this.value.replace(/\d{1,3}\.{0,1}5{0,1}0{0,2}/,''))
        {
            this.value = this.value.match(/\d{1,3}\.{0,1}5{0,1}0{0,2}/) == null ? '' :this.value.match(/\d{1,3}\.{0,1}5{0,1}0{0,2}/);
        }
    });
}

/**
 * 比较两个时间的大小 时间格式 2014-01-16 10:11:20
 * return
 * 0:开始时间比结束时间小
 * 1:开始时间等于结束时间
 * 2:开始时间大于结束时间
 */
function checkTime(bTime,eTime){
    var back = 0;
    var bDate = Date.parse(bTime.replace(/\-/g,"/"));
    var eData = Date.parse(eTime.replace(/\-/g,"/"));
    if(bDate<eData){
        back = 0;
    }else if(bDate==eData){
        back = 1;
    }else if(bDate>eData){
        back = 2;
    }
    return back;
}

//提示
function toast(text,time){
    $('.tusi').remove();
    var div = $('<div class="mymask" style="background:#5E5E5E;max-width: 85%;padding:20px 50px;min-width: 270px;position: absolute;left: -1000px;top: -1000px;text-align: center;border-radius:3px;">' +
    '<span style="color: #ffffff;line-height: 35px;font-size: 16px;">'+ text +'</span></div>');
    $('body').append(div);
    div.css('zIndex',9999999);
    div.css('left',parseInt(($(window).width()-div.width())/2));
    var top = parseInt($(window).scrollTop()+($(window).height()-div.height())/2);
    div.css('top',top);
    if(time > 0){
        setTimeout(function(){
            div.remove();
        },time);
    }
}

function wap_toast(text,time){
    $('.tusi').remove();
    var div = $('<div class="mymask" style="background:#5E5E5E;max-width: 85%;min-width: 270px;position: absolute;left: -1000px;top: -1000px;text-align: center;border-radius:3px;">' +
    '<span style="color: #ffffff;line-height: 35px;font-size: 16px;">'+ text +'</span></div>');
    $('body').append(div);
    div.css('zIndex',9999999);
    div.css('left',parseInt(($(window).width()-div.width())/2));
    var top = parseInt($(window).scrollTop()+($(window).height()-div.height())/2);
    div.css('top',top);
    if(time > 0){
        setTimeout(function(){
            div.remove();
        },time);
    }
}

function untoast(){
    $(".mymask").remove();
}

var locationUtil = function(){

}

locationUtil.getUrlParam = function(key){
    var params = this.getUrlParamArr();
    return params[key];
}
/*判断地址栏是否出现？*/
function isUrlShowAsk(clickObj){
    var link_url = window.location.href;
    if(link_url.match(/[\#]/g)){
        $(clickObj).click();
    }
}

locationUtil.getUrlParamArr = function(){
    var url = location.href; // 获取url中"?"符后的字串
    var paramArr = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(url.indexOf("?")+1);
        strs = str.split("&");
        for (var i = 0; i < strs.length; i++) {
            var paramKV = strs[i].split("=");
            if(paramKV.length == 2){
                paramArr[paramKV[0]] = paramKV[1];
            }
        }
    }
    return paramArr;
}
/*获取地址栏参数值*/
function getUrlCanShu(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}
/*获取跟目录*/
function getRootPath(){
    //获取当前网址，如： http://localhost:8083/bandou/share/meun.jsp
    var curWwwPath=window.document.location.href;
    //获取主机地址之后的目录，如： bandou/share/meun.jsp
    var pathName=window.document.location.pathname;
    var pos=curWwwPath.indexOf(pathName);
    //获取主机地址，如： http://localhost:8083
    var localhostPaht=curWwwPath.substring(0,pos);
    //获取带"/"的项目名，如：/bandou
    // var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
    //return(localhostPaht+projectName);
    return localhostPaht;
}

/*上传图片*/
function fileUploadImg(eventObj){
    var img=new Image();
    $(eventObj).on('change',function(ev){
        var f=ev.target.files[0];
        if(f.type.match('image.*')){
            var r = new FileReader();
            r.onload = function(e){
                img.setAttribute('src',e.target.result);
            };
            r.readAsDataURL(f);
        }
    });
    img.onload=function(){
        ih=img.height,iw=img.width;
        var cv = document.createElement('div');
        cv.innerHTML="<canvas></canvas>";
        var rc = cv.children[0];
        var ct = rc.getContext('2d');
        rc.width=iw;
        rc.height=ih;
        ct.drawImage(img,0,0,iw,ih);
        var da=rc.toDataURL();
        $('#jcropImgBox').html('<img id="uploadImg" src="'+da+'" alt="" style="margin-top: 5px;">');
        $("#rightShowImgBox").html('<div id="preview-pane" style="margin-top: -12px;margin-left: -5px;" > <div class="preview-container"> <img src="'+da+'" class="jcrop-preview" alt="Preview" id="showUploadImg" /> </div> </div>');
        jcropImg();
    }
    function esc(da){
        da=da.replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\"/g,'&quot;');
        return encodeURIComponent(da);
    }
}
/*jcrop图片裁剪*/
function jcropImg(){
    var jcrop_api,
        boundx,
        boundy,
        $preview = $('#preview-pane'),
        $pcnt = $('#preview-pane .preview-container'),
        $pimg = $('#preview-pane .preview-container img'),
        xsize = $pcnt.width(),
        ysize = $pcnt.height();
    $('#uploadImg').Jcrop({
        onChange: showCoords,
        onSelect: updatePreview,
        onRelease: clearCoords,
        aspectRatio: xsize / ysize,
        keySupport: true,
        allowResize: true,
		boxWidth:312,
		boxHeight:312,
    }, function () {
        var bounds = this.getBounds();
		console.log(bounds);
        boundx = bounds[0];
        boundy = bounds[1];
        jcrop_api = this;
        //$preview.appendTo(jcrop_api.ui.holder);
    });
    $('#coords').on('change', 'input', function (e) {
        var x1 = $('#x1').val(),
            x2 = $('#x2').val(),
            y1 = $('#y1').val(),
            y2 = $('#y2').val();
        jcrop_api.setSelect([x1, y1, x2, y2]);
    });
    function updatePreview(c) {
        if (parseInt(c.w) > 0) {
            var rx = xsize / c.w;
            var ry = ysize / c.h;
            $pimg.css({
                width: Math.round(rx * boundx) + 'px',
                height: Math.round(ry * boundy) + 'px',
                marginLeft: '-' + Math.round(rx * c.x) + 'px',
                marginTop: '-' + Math.round(ry * c.y) + 'px'
            });
        }
    };

    function showCoords(c) {
		/*
		var realWidth = boundx;
		var realHeight = boundy;
		
		var widget = jcrop_api.getWidgetSize();
		var nowWidth = widget[0];
		var nowHeight = widget[1];
		
		var pw = realWidth/nowWidth;
		var ph = realHeight/nowHeight;


		console.log(c.w);
		var x = Math.round(c.x * pw);
		var y = Math.round(c.y * ph);
		var w = Math.round(c.w * pw);
		var h = Math.round(c.h * ph);
		*/
        $('#x1').val(c.x);
        $('#y1').val(c.y);
        $('#x2').val(c.x2);
        $('#y2').val(c.y2);
        $('#w').val(c.w);
        $('#h').val(c.h);
		updatePreview(c);
    };
    function clearCoords() {
        $('#coords input').val('');
    };
}
/*检测商家是否登录*/
function checkIsStoreLogin(){
    var state = ajaxPost(requestPrivateUrl+'/login/checkBusinessLogined',{},'get');
    if(state.code==0){
        if(state.data==0){
            window.location.href = '/index.html#';
        }
    }else{
        toast('检查商家登录失败',2000);return false;
    }
}



/*随机数*/
function createRandomNumber(n){
    var num="";
    for(var i=0;i<n;i++) {
        num+=Math.floor(Math.random()*10);
    }
    return num;
}

/*检测一个值是否出现在数组对象中*/
function isValueOfArray(array,value) {
    if(array.length>0){
        for(var i = 0;i<array.length;i++){
            if(array[i].pid==value){
                return 1;
                break;
            }
        }
    }else{
        return 0;
    }
}
/*获取星期*/
function  getWeek(){
    var str = "";
    var week = new Date().getDay();
    if (week == 0) {
        str = "星期日";
    } else if (week == 1) {
        str = "星期一";
    } else if (week == 2) {
        str = "星期二";
    } else if (week == 3) {
        str = "星期三";
    } else if (week == 4) {
        str = "星期四";
    } else if (week == 5) {
        str = "星期五";
    } else if (week == 6) {
        str = "星期六";
    }
    return str;
}
/*当前时间年月日*/
function getNowTime(){
    var date = new Date();
    var year=date.getFullYear();
    var month=date.getMonth()+1;
    var day = date.getDate();
    month =(month<10 ? '0'+month : month);
    day = (day<10 ? '0'+day : day);
    var myDate = (year.toString()+'-'+month.toString()+'-'+day);
    return myDate
}