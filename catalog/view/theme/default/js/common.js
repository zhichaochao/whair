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
		$(this).find("ol").stop().slideToggle()
	})
	
//	头部导航货币切换
	$(".nav .mn_type").hover(function(){
		$(".mn_type .bot").stop().slideToggle();
	})
	$(".nav .mn_type .bot").mouseover(function(){
		$(".nav .mn_type .top").addClass("active")
	})
	$(".nav .mn_type .bot").mouseout(function(){
		$(".nav .mn_type .top").removeClass("active")
	})
	
//	底部导航二级菜单
	$(".ul_ydfot>li>h4").click(function(){
		if($(this).hasClass("off")){
			$(this).parent().find(".slide_div").stop().slideUp();
			$(this).find(".pic_img img").attr("src","catalog/view/theme/default/img/png/jiahao_white.png");
			$(this).removeClass("off");
		}else{
			$(".slide_div").stop().slideUp();
			$(".ul_ydfot>li>h4").removeClass("off");
			$(".ul_ydfot>li>h4 .pic_img img").attr("src","catalog/view/theme/default/img/png/jiahao_white.png");
			$(this).parent().find(".slide_div").stop().slideDown();
			$(this).find(".pic_img img").attr("src","catalog/view/theme/default/img/png/jianhao_white.png");
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
	$(".yd_nav ul>li>a").click(function(){
		if($(this).hasClass("off")){
			$(this).parent().find(".yd_nav_ol").stop().slideUp()
			$(this).find(".slide_img").attr("src","catalog/view/theme/default/img/png/jiahao.png");
			$(this).removeClass("off");
		}else{
			$(this).parent().find(".yd_nav_ol").stop().slideDown()
			$(this).find(".slide_img").attr("src","catalog/view/theme/default/img/png/jianhao.png");
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
    var win = $(window).width();
		if(win<=750){
		  $('.changeimage').each(function(){
		    $(this).attr('src',$(this).attr('data-mimage'));
		  })
		}else{
		  $('.changeimage').each(function(){
		    $(this).attr('src',$(this).attr('data-image'));
		  })
		}
	$(window).resize(function() {
		var win = $(window).width();
		if(win<=750){
          $('.changeimage').each(function(){
            $(this).attr('src',$(this).attr('data-mimage'));
          })
        }else{
          $('.changeimage').each(function(){
            $(this).attr('src',$(this).attr('data-image'));
          })
        }
	})
	
})