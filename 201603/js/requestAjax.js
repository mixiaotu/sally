var ssoid;
var userLoginData;
var SeverUrl  = '/web';

//获取url参数 $.getUrlParam('companyid');
$.getUrlParam = function(name){
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r!=null) return decodeURI(r[2]); return null;
}
var requestAjax = function(params, type, url, callback, async) {
	$.ajax({
		url: url,
		async: !!async,
		type: type,
		data: params,
		dataType: 'json',
		success: function(data){
			callback(data);
		},
        error:function(){
            if(window.console){
                console.error('*******************************************************************');
                console.error('on  '+url+'  error');
            }
        }
	});
}

//setcookie("name", value, 3600000, '/');
var setcookie = function(cookieName, cookieValue, seconds, path, domain, secure) {
	var expires = new Date();
	expires.setTime(expires.getTime() + seconds);
	document.cookie = escape(cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires=' + expires.toGMTString() : '')
		+ (path ? '; path=' + path : '/')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
}

var getcookie = function(name) {
	var cookie_start = document.cookie.indexOf(name);
	var cookie_end = document.cookie.indexOf(";", cookie_start);
	if(cookie_start == -1 || cookie_end == cookie_start + name.length)
	{
		return '';
	}
	else
	{
		return unescape(document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length)));
	}
}

/*
	obj : $('#pageContainer')
	totalCount : 总个数
	pageSize : 每页显示的条数
	pageNo : 当前页面
	callback : 选择其他页面时回调的函数（请求其他页面的数据）
*/
var paging = function(obj, totalCount, pageSize, pageNo, callback) {
	obj.paging(totalCount,{
		format:"[ < nnncnnn > ]",
		perpage:pageSize,
		page:pageNo,
		onSelect:function(page){
			if(obj.data('loadpage') != page) {
				callback(page);
			}
		},
		onFormat:function(type) {
			switch (type) {
				case 'block': // n and c
					if(this.page==this.value) {
						return '<li class="active"><span>' + this.value + '</span></li>';
					}
					return '<li><a href="#">' + this.value + '</a></li>';
				case 'next': // 下一页
					return '<li '+(this.page==this.value?'class="disabled"':'')+'><a href="#">下一页</a></li>';
				case 'prev': // 上一页
					return '<li '+(this.page==this.value?'class="disabled"':'')+'><a href="#">上一页</a></li>';
				case 'first': // 首页
					return '<li '+(this.page==this.value?'class="disabled"':'')+'><a href="#">首页</a></li>';
				case 'last': // 尾页
					return '<li '+(this.page==this.value?'class="disabled"':'')+'><a href="#">尾页</a></li>';
				case 'leap':
					return this.active?"    ":"";
				case 'fill':
					return this.active?"<li>...</li>":"";
			}
		}
	});
}

//从cookie中取得用户信息
ssoid = getcookie('idc_DesktopSSOID');
if(ssoid) {
	var params = {};
	var url = '/web/user/authcookie';
	params.ticket = ssoid;

	var callback = function(data) {
		data = $.parseJSON(data);
		if (data.user_status == 'SUCCESS') {
			userLoginData = data;
			return;
		} else if(data.user_status == 'REPLACE') {
			$.showBox && $.showBox('pop-check-input', '当前账号已在其他地方登录，请重新登录或更改密码。', 'p');
			!$.showBox && alert('当前账号已在其他地方登录，请重新登录或更改密码。');
		} else if(data.user_status == 'ACTIVE') {
			$.showBox && $.showBox('pop-check-input', '当前账号还未激活，请到您注册的邮箱中点击链接激活账号。', 'p');
			!$.showBox && alert('当前账号还未激活，请到您注册的邮箱中点击链接激活账号。');
		} else if(data.user_status == 'FREEZED') {
			$.showBox && $.showBox('pop-check-input', '当前账号已列入黑名单。', 'p');
			!$.showBox && alert('当前账号已列入黑名单。');
		} else if(data.user_status == 'NOMALLOGIN' || data.user_status == 'FAILED') {
            if(window.location.href.indexOf('web/login.html')>0 || window.location.href.indexOf('/index.html')>0 ){
                return;
            }else{
                $.showBox && $.showBox('pop-check-input', '当前账号处于未登录状态，请重新登录', 'p');
                !$.showBox && function(){
                    setcookie("idc_DesktopSSOID", "", -1, '/', '.d7w.net');
                    setcookie("idc_DesktopSSOID_jifen", "", -1, '/', '.d7w.net');
                    ssoid = '';
                }();
            }
		}
		setcookie("idc_DesktopSSOID", '', 3600000, '/', '.d7w.net');
		var targetlocation = '';
		if(!$.getUrlParam('targetlocation')) {
			targetlocation = '?targetlocation=' + window.location.pathname + window.location.search;
		}
		!($('#loginBtn')[0]) && (window.location.href="/web/login.html"+targetlocation);
	}

	requestAjax(params, 'GET', url, callback, true);
}

//根据身份的不同，去显示或隐藏导航
if(userLoginData) {
	if(parseInt(userLoginData.user_type)<3) {
		$('#recuritNav')[0] && $('#recuritNav').hide();
		$('#tenderNav')[0] && $('#tenderNav').hide();
		$('#recuritNav')[0] && $('#recuritNav').prev().show();
		$('#homeApplyBtn')[0] && $('#homeApplyBtn').hide();
	} else {
		$('#recuritNav')[0] && $('#recuritNav').show();
		$('#tenderNav')[0] && $('#tenderNav').show();
		$('#recuritNav')[0] && $('#recuritNav').prev().hide();
		$('#homeApplyBtn')[0] && $('#homeApplyBtn').show();
	}
}

if($(".uploadpic").length > 0) {
	$(".uploadpic").each(function(){
		setUploadPic($(this));
	})
}
function setUploadPic(obj) {
	var that = obj;
	var fileName = 'pic';
	var fileType = 'pic';
	var fileUrl = '/uphead';

	new AjaxUpload(that, {
		action: fileUrl,//上传地址
		name: fileName,
		responseType: "json",
		onComplete: function(file, response) {

			if (response.result == 0) {
				that.parent().prev().attr("src",response.data);
				that.attr("src",response.data);
			} else {
				alert("上传失败！");
			}
		}
	});
}
function setUploadPic2(obj,id) {
	var img = obj.parent().prev();
	$.ajaxFileUpload({
		type : "POST",
		url : "/uphead",
		secureuri : false,
		fileElementId : [id],
		dataType:"json",
		success : function(msg){
			if (msg.result == 0) {
				img.attr("src",msg.data);
			} else {
				alert("上传失败！");
			}
		},
	});
}