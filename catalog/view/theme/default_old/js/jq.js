;(function($){
    $.extend({
        /*
         * 点击按钮展示loading
         * */
        bottonLoading:function(elm){
            var elm = $(elm);
            elm.attr("data-html",elm.html()).html("<i class='jwx_btnloading'></i>Submitting...");
            setTimeout(function(){
                elm.html(elm.attr("data-html")).removeAttr("data-html");
            },10000);
        },
        /*
         * 批量判断图片是否预加载完毕
         * window.onload = function(){
         *  $.imageLoad({
         *       url:function(v){v= [];return v}//要判断加载的url，包含在一个数组中返回
         *       oncomplete:function(s){} 正在加载中函数  ， s.complete 已加载数量  s.total 总数量;  this.src  当前加载对象
         *       complete:function(imgs,s){} 加载完毕回调 s.total 总数量  s.load 加载成功数   s.error加载错误数   加载成功后的url数组 imgs ，imgs[i].loaded 是否成功 ， imgs[i].src url
         *  })
         *  }
         * */
        imageLoad:function(s){
            var urlset = [], undefined, toString = Object.prototype.toString;
            switch( toString.apply(s.url) ){
                case '[object String]': urlset[urlset.length] = s.url; break;
                case '[object Array]': if(!s.url.length){ return false; } urlset = s.url; break;
                case '[object Function]': s.url = s.url(); return $.imageLoad( s );
                default: return false;
            }
            var imgset =[], r ={ total:urlset.length, load:0, error:0, abort:0, complete:0, currentIndex:0 }, timer,
                _defaults = {
                    url:'',
                    onload: 'function',
                    onerror: 'function',
                    oncomplete: 'function',
                    ready: 'function',
                    complete: 'function',
                    timeout: 15
                };
            for( var v in _defaults){
                s[v] = s[v]===undefined? _defaults[v]: s[v];
            }
            s.timeout = parseInt( s.timeout ) || _defaults.timeout;
            timer = setTimeout( _callback, s.timeout*1000);
            for( var i=0,l=urlset.length,img; i<l; i++){
                img  = new Image();
                img.loaded = false;
                imgset[imgset.length] = img;
            }    for( i=0,l=imgset.length; i<l; i++){
                imgset[i].onload = function(){ _imageHandle.call(this, 'load', i ); };
                imgset[i].onerror = function(){ _imageHandle.call(this, 'error', i ); };
                imgset[i].onabort = function(){ _imageHandle.call(this, 'abort', i ); };
                imgset[i].src = ''+urlset[i];
            }
            if( _isFn(s.ready) ){ s.ready.call({}, imgset, r); }
            function _imageHandle( handle, index ){
                r.currentIndex = index;
                switch( handle ){
                    case 'load':
                        this.onload = null; this.loaded = true; r.load++;
                        if( _isFn(s.onload) ){ s.onload.call(this, r); }
                        break;case 'error': r.error++;
                    if( _isFn(s.onerror) ){ s.onerror.call(this, r); }
                    break;
                    case 'abort': r.abort++; break;
                }
                r.complete++;
                // oncomplete 事件回调
                if( _isFn(s.oncomplete) ){ s.oncomplete.call(this, r); }
                // 判断全局加载
                if( r.complete===imgset.length ){ _callback(); }
            }
            function _callback(){
                clearTimeout( timer );
                if( _isFn(s.complete) ){ s.complete.call({}, imgset, r); }
            }
            function _isFn(fn){ return toString.apply(fn)==='[object Function]'; }
            return true;
        }
    });
    //分页条
    jQuery.fn.pagination = function(maxentries, opts){
        opts = jQuery.extend({
            items_per_page:10,
            num_display_entries:10,
            current_page:0,
            num_edge_entries:0,
            link_to:"javascript:;",
            prev_text:"Prev",
            next_text:"Next",
            ellipse_text:"...",
            prev_show_always:true,
            next_show_always:true,
            callback:function(){return false;}
        },opts||{});

        return this.each(function() {
            /**
             * 计算最大分页显示数目
             */
            function numPages() {
                return Math.ceil(maxentries/opts.items_per_page);
            }
            /**
             * 极端分页的起始和结束点，这取决于current_page 和 num_display_entries.
             * @返回 {数组(Array)}
             */
            function getInterval()  {
                var ne_half = Math.ceil(opts.num_display_entries/2);
                var np = numPages();
                var upper_limit = np-opts.num_display_entries;
                var start = current_page>ne_half?Math.max(Math.min(current_page-ne_half, upper_limit), 0):0;
                var end = current_page>ne_half?Math.min(current_page+ne_half, np):Math.min(opts.num_display_entries, np);
                return [start,end];
            }

            /**
             * 分页链接事件处理函数
             * @参数 {int} page_id 为新页码
             */
            function pageSelected(page_id, evt){
                current_page = page_id;
                drawLinks();
                var continuePropagation = opts.callback(page_id, panel);
                if (!continuePropagation) {
                    if (evt.stopPropagation) {
                        evt.stopPropagation();
                    }
                    else {
                        evt.cancelBubble = true;
                    }
                }
                return continuePropagation;
            }

            /**
             * 此函数将分页链接插入到容器元素中
             */
            function drawLinks() {
                panel.empty();
                var interval = getInterval();
                var np = numPages();
                // 这个辅助函数返回一个处理函数调用有着正确page_id的pageSelected。
                var getClickHandler = function(page_id) {
                    return function(evt){ return pageSelected(page_id,evt); }
                }
                //辅助函数用来产生一个单链接(如果不是当前页则产生span标签)
                var appendItem = function(page_id, appendopts){
                    page_id = page_id<0?0:(page_id<np?page_id:np-1); // 规范page id值
                    appendopts = jQuery.extend({text:page_id+1, classes:""}, appendopts||{});
                    if(page_id == current_page){
                        var lnk = jQuery("<span class='current'>"+(appendopts.text)+"</span>");
                    }else{
                        var lnk = jQuery("<a>"+(appendopts.text)+"</a>")
                            .bind("click", getClickHandler(page_id))
                            .attr('href', opts.link_to.replace(/__id__/,page_id));
                    }
                    if(appendopts.classes){lnk.addClass(appendopts.classes);}
                    panel.append(lnk);
                }
                // 产生"Previous"-链接
                if(opts.prev_text && (current_page > 0 || opts.prev_show_always)){
                    appendItem(current_page-1,{text:opts.prev_text, classes:"prev"});
                }
                // 产生起始点
                if (interval[0] > 0 && opts.num_edge_entries > 0)
                {
                    var end = Math.min(opts.num_edge_entries, interval[0]);
                    for(var i=0; i<end; i++) {
                        appendItem(i);
                    }
                    if(opts.num_edge_entries < interval[0] && opts.ellipse_text)
                    {
                        jQuery("<span>"+opts.ellipse_text+"</span>").appendTo(panel);
                    }
                }
                // 产生内部的些链接
                for(var i=interval[0]; i<interval[1]; i++) {
                    appendItem(i);
                }
                // 产生结束点
                if (interval[1] < np && opts.num_edge_entries > 0)
                {
                    if(np-opts.num_edge_entries > interval[1]&& opts.ellipse_text)
                    {
                        jQuery("<span>"+opts.ellipse_text+"</span>").appendTo(panel);
                    }
                    var begin = Math.max(np-opts.num_edge_entries, interval[1]);
                    for(var i=begin; i<np; i++) {
                        appendItem(i);
                    }

                }
                // 产生 "Next"-链接
                if(opts.next_text && (current_page < np-1 || opts.next_show_always)){
                    appendItem(current_page+1,{text:opts.next_text, classes:"next"});
                }
            }

            //从选项中提取current_page
            var current_page = opts.current_page;
            //创建一个显示条数和每页显示条数值
            maxentries = (!maxentries || maxentries < 0)?1:maxentries;
            opts.items_per_page = (!opts.items_per_page || opts.items_per_page < 0)?1:opts.items_per_page;
            //存储DOM元素，以方便从所有的内部结构中获取
            var panel = jQuery(this);
            // 获得附加功能的元素
            this.selectPage = function(page_id){ pageSelected(page_id);}
            this.prevPage = function(){
                if (current_page > 0) {
                    pageSelected(current_page - 1);
                    return true;
                }
                else {
                    return false;
                }
            }
            this.nextPage = function(){
                if(current_page < numPages()-1) {
                    pageSelected(current_page+1);
                    return true;
                }
                else {
                    return false;
                }
            }
            // 所有初始化完成，绘制链接
            drawLinks();
            // 回调函数
            opts.callback(current_page, this);
        });
    }
})(jQuery);

$(document).ready(function () {
    $(".jwx_header .a2").bind('mouseenter ', function () {
        $(".search_pop").show(300);
    });
    $(".jwx_header .right").mouseleave(function () {
        $(".search_pop").hide(300);
    })

    /*返回顶部*/
    var backtop = 50;
    var jQueryback_top = jQuery('.back_top');
    jQuery(window).scroll(function () {

        ( jQuery(this).scrollTop() > backtop ) ? jQueryback_top.css("display", "block") : jQueryback_top.css("display", "none");
    });
    jQuery('.back_top a').click(function () {
        jQuery('body,html').scrollTop(0);
    });

    //栏目页，出现红条
    $(".jwx_category .product_tabl li,.jwx_psearch .product_tabs_ul li").hover(function(){
        $(this).find(".s1").animate({"width":"100%"},"fast");
    },function(){
        $(this).find(".s1").animate({"width":"0%"},"fast");
    });
    //购物车
    $(".jwx_cart .tijiao,#button-place-order").click(function(){
        $.bottonLoading(this);
    });
    //登录页选中
    var loginput = $(".jwx_login input[type='text'],.jwx_login input[type='password']");
    loginput.focus(function(){
        $(this).addClass("inputOn");
    });
    loginput.blur(function(){
        $(this).removeClass("inputOn");
    });

    if($(".jwx_productInfo").length > 0){
        //详情页 faq点击
        $(".jwx_productInfo .faq dd").bind("click",function(){
            $(this).toggleClass("on");
        });
        //详情页 图片变大
        $(".jwx_productInfo").on("click",".imglist li",function(){
            $("body").append('<div class="imgListBox" id="imgListBox"><table class="loading"><tr><td><span><i class="left"></i><i class="right"></i><img src=""></span></td></tr></table></div>');
            var $this = $(this),
                box = $("#imgListBox"),
                onImgLeft = "",
                onImgRight = "",
                imgLoad = function(img,cbk){
                    $.imageLoad({
                        url: function (v) {
                            v = [img];
                            return v;
                        },
                        complete: function (imgs, s) {
                            (cbk)(imgs[0].src);
                            box.find("table").removeClass("loading").find("b").hide();
                        }
                    });
                };
            $this.siblings().length == 0 ? box.find("i").hide() : "";
            box.show().attr("data-index",$this.index()).find("table").addClass("loading").find("b").show();
            imgLoad($this.find("img").attr("data-img"),function(img){
                box.find("img").attr({"src": img}).show();
            });
            if($this.index() == 0){
                box.find(".left").hide();
            }else if(($this.index() + 1) == $this.parent().find("li").length){
                box.find(".right").hide();
            }
            box.find("i").click(function(){
                box.find("i").show();
                box.find("img").hide();
                if($(this).hasClass("left")){
                    onImgLeft = $this.parent().find("li").eq(parseInt(box.attr("data-index"))-1);
                    if(onImgLeft.index() >= 0){
                        box.attr("data-index",onImgLeft.index()).find("table").addClass("loading");
                        imgLoad(onImgLeft.find("img").attr("data-img"),function(img){
                            box.find("img").show().attr({"src":onImgLeft.find("img").attr("data-img")});
                        });
                    }
                    if(onImgLeft.index() == 0){
                        $(this).hide();
                    };
                }else{
                    onImgRight = $this.parent().find("li").eq(parseInt(box.attr("data-index"))+1);
                    if(onImgRight.index() >= 0){
                        box.attr("data-index",onImgRight.index()).find("table").addClass("loading");
                        imgLoad(onImgRight.find("img").attr("data-img"),function(img){
                            box.find("img").show().attr({"src":onImgRight.find("img").attr("data-img")});
                        });
                    }
                    if((onImgRight.index() + 1) == $this.parent().find("li").length){
                        $(this).hide();
                    };
                }
            });
        });
        $("body").on("click","#imgListBox i,#imgListBox img,.imglist li",function(e){
            e.stopPropagation();
        });
        $("body").click(function(){
            $("#imgListBox").remove();
        });
        //详情页 tab
        $(".product_dessriptionul li").click(function(){
            $(".product_dessriptionul").find(".clr").removeClass('clr');
            $(this).find('a').addClass('clr');
            $(document).scrollTop($("."+$(this).attr("data-value")).offset().top - 90);
        });
        var ul = $(".product_dessription"),
            li = ul.find("li");
        if(ul.length > 0){
            var ultop = ul.offset().top;
            var headerTop = function(){
                var top = $(document).scrollTop();
                if(top >= ultop){
                    $(".jwx_header").removeClass("jwx_header_fixed");
                    ul.addClass("productUlFixed");
                }else{
                    $(".jwx_header").addClass("jwx_header_fixed");
                    ul.removeClass("productUlFixed");
                }
                li.each(function(){
                    if((top + 150) > $("."+$(this).attr("data-value")).offset().top){
                        ul.find(".clr").removeClass("clr");
                        $(this).find("a").addClass("clr");
                    }
                });
            };
            headerTop();
            $(window).scroll(function(){
                headerTop();
            });
        }
        //详情页头部评论跳转
        $(".prodet_right_hd .pingfen span").click(function(){
            $(document).scrollTop($(".pinglun").offset().top - 90);
        });
        //详情页主图切换
        $(".jwx_productInfo .prodet_smalul li").bind("mousedown",function(){
            var $this = $(this);
            $this.addClass("on").siblings().removeClass("on");
            $.imageLoad({
                url:function(v){
                    v = [eval("("+$this.find(".thumb_list").attr("rel")+")").smallimage];
                    $(".infoDatu").addClass("infoDatuOn");
                    return v;
                },
                complete:function(imgs,s){
                    $(".infoDatu").removeClass("infoDatuOn").find("a").attr("href",imgs[0].src).find("img").attr("src",imgs[0].src);
                }
            });
        });
        //详情页长度选择过长时
        if($(".changduList li").length > 18){
            $(".changduList").addClass("changduListHeight");
        };
        $(".changduList .icon").click(function(){
            $(".changduList").removeClass("changduListHeight");
        });

        //详情页 pieces切换
        $(".jwx_productInfo .pieces li").bind("click",function(){
            $(this).addClass("on").siblings().removeClass("on");
        });
        //详情页弹出框
        $(".jwx_productCart .left").click(function(){
            $(".jwx_productCart").hide();
        });
        //详情页，评论分页
        var pinglunData = function(page,one){
            var parameter = {
                page:page,
                pagesize:5,
                product_id:product_id
            },
            div = $("#pinglunList"),
            html = "",
            imglist = "";

            div.html("<span class='loading'>loading...</span>");
            $.get("/index.php?route=product/product/review",parameter,function(data){
                if(data.code == 0){
                    div.html("<p class='null'>"+data.message+"</p>");
                }else{
                    if(data.total > parameter.pagesize && one == 1){
                        $("#fyt_product").pagination(data.total, {
                            num_edge_entries: 2,
                            num_display_entries: 4,
                            prev_text:"&lt;&lt;",
                            next_text:"&gt;&gt;",
                            callback: function(index){
                                pinglunData(index+1);
                            },
                            items_per_page:parameter.pagesize
                        });
                    }
                    data = data.data;
                    for(var i = 0; i < data.length; i++){
                        imglist = "";
                        if(data[i].images.length > 0){
                            for(var b = 0; b < data[i].images.length; b++){
                                imglist += '<li><i></i><img data-img="'+data[i].images[b].img+'" src="'+data[i].images[b].min_img+'"/></li>';
                            }
                        }
                        html += '<div class="dd">'+
                            '<p class="p1"><strong>'+data[i].rating_starts+'</strong>'+data[i].rating+'.0</p>'+
                        '<div class="pingfen">'+
                        '<div class="d3">'+
                        '<div class="d1" style="width:'+(data[i].rating * 20)+'%"></div>'+
                        '<div class="d2"></div>'+
                        '</div>'+
                        '</div>'+
                        '<p class="p2">'+data[i].author+'<span>'+data[i].date_added+'</span></p>'+
                        '<p class="p3">'+data[i].text+'</p>'+
                        '<ul class="imglist">'+imglist+'</ul>'+
                            '</div>';
                    }
                    div.html(html);
                }
            },"json");
        }
        pinglunData(1,1);
    };
    //myoder 评分
    var myoderpfen = $(".jwx_myoderpfen");
    if(myoderpfen.length > 0){
		myoderpfen.each(function(){
			var $this = $(this),
				myoderpfenhid = $this.find(".hid"),
            pingfenFun = function(index){
                $this.find("i").removeClass("on");
                $this.find("i:lt("+ index +")").addClass("on");
            };
			pingfenFun(myoderpfenhid.val());
			if(myoderpfenhid.attr("data-type") != 1){
				$this.find("i").bind({
					click:function(){
						pingfenFun(($(this).index() + 1));
						myoderpfenhid.val($(this).index() + 1);
					},
					mouseover:function(){
						pingfenFun(($(this).index() + 1));
					},
					mouseout:function(){
						pingfenFun(myoderpfenhid.val());
					}
				});
			}
		});
        
    }
});
//------------弹窗

//JavaScript Document
;(function($){
	$.fn.takyPopup = function(options){
		
		//=======初始化插件默认属性====
		
		var defaults = {
			tips:'',
			isDrag:false,
			overlay:.4,
			title:false,
			closeText:'&times;',
			borderRadius:'6px',
			callback:function(){}
		}
		
		//=======设置插件可拓展属性====
		
		var opt = $.extend({},defaults,options);
		
		//=======设置插件遮罩层和弹窗盒子====
		this.each(function(idx,ele){
			$(ele).on('click',function(){
				if(opt.overlay){
					var $wrap = $('<div class="popwrap"></div>').appendTo('body');
					$wrap.css({'opacity':opt.overlay,'top':$(window).scrollTop()}).show();
				}
				var $box = $('<div id="popbox"></div>').appendTo('body');
				
				
				//=======设置插件弹窗标题盒子====
				
				var $title_box = $('<div class="title_box"></div>').appendTo($box);
				
				//=======设置插件弹窗标题====
				
				if(opt.title){
					var $title = $('<h4 class="title"></h4>').appendTo($title_box);
					$title.html(opt.title);
				}
				//=======设置插件弹窗关闭按钮====
				
				var $close = $('<div class="close"></div>').appendTo($title_box);
				
				//=======设置插件弹窗提示内容====
				
				var $text =	$('<div class="tips"></div>').appendTo($box);
				$text.html(opt.tips);
				
				//=======自定义插件弹窗盒子宽高====
				
				$box.css({
					'borderRadius':opt.borderRadius,
					'background':opt.background,
					'width':opt.width,
					'height':opt.height
				});
				//=======初始化插件弹窗盒子居中显示==
				
				$box.css({
					'left':($(window).width()-$box.outerWidth())/2+$(window).scrollLeft(),
					'top':($(window).height()-$box.outerHeight())/2+$(window).scrollTop(),
				});
				
				//=======改变窗口大小或者滚轮变化时插件弹窗盒子居中显示==
				$(window).on('scroll resize',function(){
					$box.stop().animate({
						'left':($(window).width()-$box.outerWidth())/2+$(window).scrollLeft(),
						'top':($(window).height()-$box.outerHeight())/2+$(window).scrollTop(),
					},200);
					if(opt.overlay){
						$wrap.css({'top':$(window).scrollTop()});
					}
				});
				//=======设置关闭按钮和ESC键行为====
				
				$close.css({
					'background':opt.background,
				});
				$close.html(opt.closeText);
				$close.click(function(){
					$wrap.remove()&&$box.remove();
				});
				$close.on('mousedown mouseup',function(){
					return false;
				})
				$(document).on('keyup',function(e){
					if(e.keyCode == 27){
						$wrap.remove()&&$box.remove();
					}
				});
				
				//=======设置弹窗盒子是否拖拽====
		
				if(opt.isDrag){
					$title_box.on('mousedown',function(e){
						var $x = e.offsetX;
						var $y = e.offsetY;
						$title_box.css('cursor','move');
						$(document).on('mousemove.takyPopup',function(evt){
							var x = evt.pageX-$x;
							var y = evt.pageY-$y;
							var maxX = $(window).width()-$box.outerWidth();
							var maxY = $(window).height()-$box.outerHeight();
							if(x < 0){
								x = 0;	
							}else if(x>maxX){
								x = maxX;
							}
							if(y < 0){
								y = 0;
							}else if(y > maxY){
								y = maxY;
							}
							$box.css({
								'left':x,
								'top':y
							});
							evt.preventDefault();
						});
						e.preventDefault();
					})
					$(window).on('mouseup',function(){
							$(document).off('mousemove.takyPopup');
							$title_box.css('cursor','auto');
					});
				}
					
				//=======设置回调函数====
				
				$.type(opt.callback) === 'function' && opt.callback($box);														
			});
		});
		//=======返回this，用于链式调用====
		return this;
	}
})(jQuery);