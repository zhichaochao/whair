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
	var DivScroll = function( layerNode ){
		//如果没有这个元素的话，那么将不再执行下去
		if ( !document.querySelector( layerNode ) ) return ;
		this.popupLayer = document.querySelector( layerNode ) ;
		this.startX = 0 ;
		this.startY = 0 ;
		this.popupLayer.addEventListener('touchstart', function (e) {
		this.startX = e.changedTouches[0].pageX;
		this.startY = e.changedTouches[0].pageY;
		}, false);
		// 仿innerScroll方法
		this.popupLayer.addEventListener('touchmove', function (e) {
		e.stopPropagation();
		var deltaX = e.changedTouches[0].pageX - this.startX;
		var deltaY = e.changedTouches[0].pageY - this.startY;
		// 只能纵向滚
		if(Math.abs(deltaY) < Math.abs(deltaX)){
		e.preventDefault();
		return false;
		}
		if( this.offsetHeight + this.scrollTop >= this.scrollHeight){
		if(deltaY < 0) {
		e.preventDefault();
		return false;
		}
		}
		if(this.scrollTop === 0){
		if(deltaY > 0) {
		e.preventDefault();
		return false;
		}
		}
		// return false;
		},false);
		}
		//调用
		var divScroll = new DivScroll('.cart_tc .text');
		var divScroll = new DivScroll('.new_lxwm_tc .text');
	
	//获取焦点隐藏textarea的提示文本
	$("textarea").focus(function(){
		$(this).attr("placeholder","");
	})
	
	//select颜色
	$("select").each(function(){
		let a = $(this).find("option:selected").text();
		let b = $(this).find("option").eq(0).text();
		if(a==b){
			$(this).css("color","#999");
		}else{
			$(this).css("color","#333");
		}
	})
	
	
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
	
//		搜索弹窗
	$(".img_ol>li.search_li").click(function(){
		$(".ss_modal").fadeIn();
		$(".ss_modal .bg_f").animate({top:"0%"});
		$("body").css("overflow","hidden");
	})
	$(".ss_modal .close").click(function(){
		$(this).parents(".ss_modal").fadeOut();
		$("body").css("overflow","");
		$(".ss_modal .bg_f").animate({top:"100%"});
	})
	$(".ss_modal i.del").click(function(){
		$(this).parents("h1").siblings(".ls_ul").remove();
	})
	$(".ss_modal .text label img.in_close").click(function(){
		$(this).siblings("input").val("");
	})

// 退出登录
	$(".login_li,.lg_hover").hover(function(){
		$(".lg_hover").show();
	},function(){
		$(".lg_hover").hide();
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
/**弹窗提示**/
function tips(tips_text,img){
	if(img==""){
		img='mr'
	}
	var text =
			'<div class="popup_tips clearfix">'
				+'<div class="text clearfix">'
					+'<div class="top '+img+' clearfix">'
						+'<span></span>'
					+'</div>'
					+'<p>'+tips_text+'</p>'
				+'</div>'
			+'</div>'
	$("body").append(text);
	setTimeout(function(){
		$(".popup_tips").fadeOut();
	},2000);
}