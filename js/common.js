//读取URL参数
function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,''])[1].replace(/\+/g, '%20'))||null;
}
//分页
function mkPageStr(data){
		//分页数据
		var _cur = data.currentPage;
		var _num = data.pageCount;
		return mkPageStrByArgs(_cur,_num);
}
//分页
function mkPageStrByArgs(_cur,_num){
	_cur = parseInt(_cur);
	_num = parseInt(_num);
	//分页数据
	//上一页
	var _prev = 1;
	if(_cur != 1){
		_prev = _cur - 1;
	}
	//下一页
	var _next = _num;
	if(_cur != _num){
		_next = _cur + 1;
	}
	var _html = "";
	 if(_cur>5){
	        if(_num-_cur<5){
	            if(_cur>9){
	                for(var i=1;i<9+_cur-_num;i++){
	                    _html = '<span class="page" data-val="'+(_cur-i)+'">'+(_cur-i)+'</span>'+_html;
	                }
	            }else{
	                for(var i=1;i<_cur;i++){
	                    _html = '<span class="page" data-val="'+(_cur-i)+'">'+(_cur-i)+'</span>'+_html;
	                }
	            }
	        }else{
	            for(var i=1;i<5;i++){
	                _html = '<span class="page" data-val="'+(_cur-i)+'">'+(_cur-i)+'</span>'+_html;
	            }
	        }
	    }else{
	        for(var i=1;i<_cur;i++){
	            _html = '<span class="page" data-val="'+(_cur-i)+'">'+(_cur-i)+'</span>'+_html;
	        }
	    }
	    _html += '<span class="page on-page" data-val="'+_cur+'">'+_cur+'</span>';

	    if(_cur<5){
	        if(_num>9){
	            for(var i=1;i<(11-_cur);i++){
	                _html += '<span class="page" data-val="'+(_cur+i)+'">'+(_cur+i)+'</span>';
	            }
	        }else{
	            for(var i=1;i<=(_num-_cur);i++){
	                _html += '<span class="page" data-val="'+(_cur+i)+'">'+(_cur+i)+'</span>';
	            }
	        }
	    }else{
	        if(_num>(_cur+4)){
	            for(var i=1;i<5;i++){
	                _html += '<span class="page" data-val="'+(_cur+i)+'">'+(_cur+i)+'</span>';
	            }
	        }else{
	            for(var i=1;i<=(_num-_cur);i++){
	                _html += '<span class="page" data-val="'+(_cur+i)+'">'+(_cur+i)+'</span>';
	            }
	        }
	    }
	    console.log(_html);
	    _html = '<span class="p-page page" data-val="'+_prev+'">&lt;</span>'+_html;
	        _html = '<span class="f-page page" data-val="1">&lt;&lt; First</span>'+_html;
	        _html += '<span class="n-page page" data-val="'+_next+'">&gt;</span>';
	        _html += '<span class="l-page page" data-val="'+_num+'">Last&gt;&gt;</span>';
	        
//	var _pagestr = '<span class="f-page page" data-val="1"><i class="fl"></i>&lt;&lt; First</span><span class="p-page page" data-val="'+_prev+'">&lt;</span>';
//	for(var i=1 ;i<=_num;i++){
//		if(i == _cur){
//			_pagestr += ['<span class="page on-page" data-val="'+i+'">'+i+'</span>'].join('');
//		}else{
//			_pagestr += ['<span class="page" data-val="'+i+'">'+i+'</span>'].join('');
//		}
//	}
//	_pagestr += ['<span class="n-page page"data-val="'+_next+'">&gt;</span>',
//	             '<span class="l-page page" data-val="'+_num+'">Last&gt;&gt; <i class="fr"></i></span>'].join('');
	return _html;
}
//表单序列化
(function($){  
    $.fn.serializeJson=function(){  
        var serializeObj={};  
        var array=this.serializeArray();  
        var str=this.serialize();  
        $(array).each(function(){  
            if(serializeObj[this.name]){  
                if($.isArray(serializeObj[this.name])){  
                    serializeObj[this.name].push(this.value);  
                }else{  
                    serializeObj[this.name]=[serializeObj[this.name],this.value];  
                }  
            }else{  
                serializeObj[this.name]=this.value;   
            }  
        });  
        return serializeObj;  
    };  
})(jQuery);  