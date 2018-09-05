//rem.js
var fun = function (doc, win) {
    var docEl = doc.documentElement,
        resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
        recalc = function () {
            var clientWidth = docEl.clientWidth;
            if (!clientWidth) return;
            if(clientWidth>750){
            	clientWidth = 750;
            }
            if(clientWidth<=320){
            	clientWidth = 320;
            }
            docEl.style.fontSize =100* (clientWidth / 750) + 'px';
        };
    if (!doc.addEventListener) return;
    win.addEventListener(resizeEvt, recalc, false);
    doc.addEventListener('DOMContentLoaded', recalc, false);
}
fun(document, window);
$(function(){
	 var win = $(window).width();
	//返回顶部
	$(document).scroll(function(){
        var top = $(document).scrollTop();
        if(top>100){
            $(".xf_right .top").css("display","block");    
        }else{
        	$(".xf_right .top").css("display","none");   
        }
    });
	$('.xf_right .top').on('click',function (event) {
		event.preventDefault();
		$('html,body').animate({
		    scrollTop: 0
		}, 500);
	})
	
//	头部导航二级菜单
	$(".nav_ul>li").hover(function(){
//		$(this).find("ol").stop().slideToggle()
		$(this).find("ol").stop().slideDown();
	},function(){
		$(this).find("ol").stop().slideUp();
	})
	
//	头部导航货币切换
	if(win>992){
		$(".nav .mn_type").hover(function(){
			$(".mn_type .bot").stop().slideToggle();
		})
		$(".nav .mn_type .bot").mouseover(function(){
			$(".nav .mn_type .top").addClass("active")
		})
		$(".nav .mn_type .bot").mouseout(function(){
			$(".nav .mn_type .top").removeClass("active")
		})
		
	}else{
		var off = 0;
		$(".nav .mn_type .top").click(function(event){
			
			if(off==0){
				$(".nav .mn_type .bot").fadeIn();
				off=1;
				$(this).find(".pic_img img").css("transform","rotate(180deg)");
			}else{
				$(".nav .mn_type .bot").fadeOut();
				$(this).find(".pic_img img").css("transform","rotate(0deg)");
				off=0;
			}
			event.stopPropagation();
		})
		$("body").click(function(e){
			if(off==1){
				var win = $(window).width();
				var close = $('.nav .mn_type .bot'); 
			   	if(!close.is(e.target) && close.has(e.target).length === 0){
			   		$(".nav .mn_type .bot").fadeOut();
			   		$(".nav .mn_type .top .pic_img img").css("transform","rotate(0deg)");
				}
			   	off=0;
			}
		})
	}

	
//	底部导航二级菜单
	$(".ul_ydfot>li>h4").click(function(){
		if($(this).hasClass("off")){
			$(this).parent().find(".slide_div").stop().slideUp();
			var src = $(this).find(".pic_img img").attr("data-img");
			$(this).find(".pic_img img").attr("src",src);
			$(this).removeClass("off");
		}else{
			var src = $(this).find(".pic_img img").attr("data-img");
			var srcs = $(this).find(".pic_img img").attr("data-imgs");
			$(".slide_div").stop().slideUp();
			$(".ul_ydfot>li>h4").removeClass("off");
			$(".ul_ydfot>li>h4 .pic_img img").attr("src",src);
			$(this).parent().find(".slide_div").stop().slideDown();
			$(this).find(".pic_img img").attr("src",srcs);
			$(this).addClass("off");
		}
	})
	
//		搜索
	$(".img_ol>li.search_li").click(function(){
		if($(this).hasClass("off")){
			
		}else{
			$(".search").css("display","block");
			$(".search").css("animation","myanimate1 1s forwards");
			$(".search .text_in").css("animation","myanimate2 1s forwards");
			$(this).addClass("off");
		}
	})
	
	$("body").click(function(e){
		var win = $(window).width();
		if(win>=993){
			var close = $('.search , li.search_li'); 
		   	if(!close.is(e.target) && close.has(e.target).length === 0){
		      	$(".search").css("animation","myanimate1s 1s forwards");
				$(".search .text_in").css("animation","myanimate2s .8s forwards");
				$("li.search_li").removeClass("off");
			}
	   }
	})
	
	$(".search .close").click(function(){
		$(".search").css("animation","myanimate1s 1s forwards");
		$(".search .text_in").css("animation","myanimate2s .8s forwards");
		$("li.search_li").removeClass("off");
	})
	
//	yd头部导航二级菜单	
	$(".yd_nav .slide_img").click(function(){
		if($(this).hasClass("off")){
			$(this).siblings(".yd_nav_ol").stop().slideUp();
			var src = $(this).attr("data-img");
			$(this).attr("src",src);
			$(this).removeClass("off");
		}else{
			var src = $(this).attr("data-img");
			var srcs = $(this).attr("data-imgs");
			$(this).siblings(".yd_nav_ol").stop().slideDown();
			$(this).attr("src",srcs);
			$(this).addClass("off");
		}
		
	})
//	yd头部导航开关
	$(".nav_off").click(function(){
		$(".yd_nav").css("display","block");
		$(".yd_nav").animate({right:"0%"});
	})

	$(".yd_nav .close").click(function(){
		$(".yd_nav").animate({right:"100%"});
	})

// 购物车开关
//	$(".img_ol .cart_li").click(function(){
//		$(".nav_cart").fadeIn();
//	})
	$(".nav_cart .close").click(function(){
		$(".nav_cart").fadeOut();
	})

// 注册登录开关
	$(".img_ol .login_li").click(function(){
		$(".login_modal").fadeIn();
		$("body").css("overflow","hidden");
	})
	
	$(".login_modal").click(function(e){
		var close = $('.login_modal .text'); 
	   	if(!close.is(e.target) && close.has(e.target).length === 0){
	      	$(".login_modal").fadeOut();
	      	$("body").css("overflow","auto");
		}
	})
	//关闭登陆注册
	$(".close").click(function(){
		$(".login_modal").fadeOut();
		$("body").css("overflow","auto");
	})
	
	
	$(".login_ol>li").click(function(){
		$(this).addClass("active").siblings("li").removeClass("active");
		$(".login_ul li").eq($(this).index()).addClass("active").siblings("li").removeClass("active");
	})
	
	$(".xy_div input").click(function(){
		if($(this).hasClass("off")){
			$(this).removeClass("off");
			$(".xy_div .span1").css("display","block");
			$(".xy_div .span2").css("display","none");
		}else{
			$(this).addClass("off");
			$(".xy_div .span1").css("display","none");
			$(".xy_div .span2").css("display","block");
		}
	})
	
	//替换图片
//	if(win<=750){
//	  $('.changeimage').each(function(){
//	    $(this).attr('src',$(this).attr('data-mimage'));
//	  })
//	}else{
//	  $('.changeimage').each(function(){
//	    $(this).attr('src',$(this).attr('data-image'));
//	  })
//	}
//	$(window).resize(function() {
//		var win = $(window).width();
//		if(win<=750){
//        $('.changeimage').each(function(){
//          $(this).attr('src',$(this).attr('data-mimage'));
//        })
//      }else{
//        $('.changeimage').each(function(){
//          $(this).attr('src',$(this).attr('data-image'));
//        })
//      }
//	})
	if(win<=750){
	  $('.changeimage').each(function(){
	    $(this).attr('srcs',$(this).attr('data-mimage'));
	  })
	}else{
	  $('.changeimage').each(function(){
	    $(this).attr('srcs',$(this).attr('data-image'));
	  })
	}
	$(window).resize(function() {
		var win = $(window).width();
		if(win<=750){
          $('.changeimage').each(function(){
            $(this).attr('srcs',$(this).attr('data-mimage'));
          })
        }else{
          $('.changeimage').each(function(){
            $(this).attr('srcs',$(this).attr('data-image'));
          })
        }
	})
var lazyLoad = (function(){
	var clock;
	function init(){
		$(window).on("scroll", function(){
			if (clock) {
				clearTimeout(clock);
			}
			clock = setTimeout(function(){
				checkShow();
			}, 200);
		})
		checkShow();
	}
	function checkShow(){
		$("img.changeimage ").each(function(){
			var this_img =$(this);
			if(this_img.attr('isLoaded')){
        		return;
      		}
			if(shouldShow(this_img)){
				showImg(this_img);
			}
		})
	}
	function shouldShow(obj){
		var scrollH = $(window).scrollTop(),
			winH = $(window).height(),
			top = obj.offset().top;
		if(top < winH + scrollH){
	  		return true;
	  	}else{
	  		return false;
	  	}
	}
	function showImg(obj){
    	obj.attr('src', obj.attr('srcs'));
    	obj.attr('isLoaded', true);
	}
	return {
		init: init
	}
})()
lazyLoad.init();

	
	//contact
	var kg=0;
	$(".contact").click(function(){
		if(kg==0){
			$(this).siblings(".a_text").slideDown();
			kg=1;
		}else{
			$(".ol_ydfot .a_text").stop().slideUp();
				kg=0;				
		}
		
	})
	$("body").click(function(e){
		if(kg==1){
			var close = $('.ol_ydfot .a_text,.ol_ydfot .contact'); 
		   	if(!close.is(e.target) && close.has(e.target).length === 0){
				$(".ol_ydfot .a_text").stop().slideUp();
				kg=0;
			}
		}
	})
})

