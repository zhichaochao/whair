<?php echo $header; ?>


<div class="content product_det in_content">

			<div class="pro_det_content clearfix">
				<div class="ts_ps"></div>
				<div class="top clearfix">
					<div class="left clearfix">
						<ol class="pro_img_ol">
						<?php if ($images) { ?>
							<li class="li">
							<div class="more-views">
								<div class="prdimgup"> </div>
								<div class="highslide-gallery" id="prdimglist" page="0">
									<ul class="pra-list-ul">
									
										<?php foreach ($images as $k => $image) {?>
										<li <?php if($k==0 && !$video){ ?>class="on"<?php } ?>>
										<a class="highslide">
											<img onclick="productInfoImg(this)" data-img="<?php echo $image['thumb2']; ?>" style="cursor: pointer !important;" src="<?php echo $image['thumb']; ?>"  title='<?php echo $heading_title; ?>'>
										</a>
										</li>
										<?php } ?>
									</ul>
								</div>
								<div class="prdimgdown"></div>
								<div style="clear:both;"></div>
							</div>
							</li>
							<?php } ?>
						</ol>
						<div class="pro_big_img" style="overflow: hidden;position:relative; ">
							<div class="swiper-container" id="swiper3">
							    <div class="swiper-wrapper">
							    	<?php if ($video) { ?>
							      		<div class="swiper-slide ban_img">						      		
										<!-- 产品后台上传视频 -->
											<video class="pull-left" src='<?=$video?>' id="audio" style="width:100%;height:100%;" autoplay></video>
											<img id="Rerun" src="image/catalog/review.png" style="display:none;width:80px;height:80px;position:relative;z-index:10;top:-288px;" onclick="playVid()"/>
											<img id="jwx_productInfoImg" src="<?php echo $image['thumb']; ?>" title='Fuller Peruvian Virgin Hair Kinky Straight 12inch to 26inch' alt='Fuller Peruvian Virgin Hair Kinky Straight 12inch to 26inch' style="display:none;" />
									 	</div>
										<!-- 产品后台上传视频 -->
										 <?php foreach ($images as $k => $image) {  if($k > 0) {?>
							    		<div class="swiper-slide ban_img">
													<img  src="<?php echo $image['image']; ?>" title='<?php echo $heading_title; ?>'  />
										</div>
								    	<?php } } ?>
											<?php } elseif ($thumb) { ?>
									   	<?php foreach ($images as $k => $image) { ?>
								    		<div class="swiper-slide ban_img">
													<img  src="<?php echo $image['image']; ?>" title='<?php echo $heading_title; ?>'  />
											</div>
								    	<?php } ?>
							    	<?php } ?>

							    </div>	
							    <div class="swiper-pagination"></div>
							    <div class="swiper-button-prev"></div>
								<div class="swiper-button-next"></div>
							</div>
							
						</div>
						
					</div>
				<div class="right" id="product">
					<input type="hidden" name="product_id" value="<?=$product_id?>">
						<div class="top_text">
							<a><?php echo $heading_title;?></a>
							
									<?php if ($price) { ?>
									<p class="price"  id="money" >

										<?php if(isset($special)){ ?>
										<span><?php echo $special; ?></span><i><?php echo $price; ?></i>
										<?php }else{ ?>
										<span><?=$price?> </span>
										<?php } ?>

									</p>
						
								<?php } ?>

								<label class="num_label clearfix"  >
									<span>Quantity:</span>
									<div class="price_input clearfix">
											<span class="sub" ></span>
										<input class="num" name="quantity" type="text" value="1" id="nums"/>
										<span class="add"></span>
									</div>
								</label>
							<div class="label_div clearfix" id="form-product">
								<?php if ($options) { ?>
								<?php foreach ($options as $option) { ?>	
								<?php if ($option['product_option_value']) { ?>
								<?php if ($option['type'] == 'select') { ?> 
								<label class="len_label" for="">
									<span><?php if($option['required']) { ?>*<?php } ?><?=$option['name']?>:</span>
									<div class="select_div" id="input-option<?php echo $option['product_option_id']; ?>">
										<input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php if(isset($shareoption[$option['product_option_id']])){ echo $shareoption[$option['product_option_id']];}else{ echo $option['product_option_value'][0]['product_option_value_id'];} ?>" />
										<button class="select_btn"><span></span></button>
										<div class="select_ul">
											<ul>
												<?php foreach ($option['product_option_value'] as $k=> $option_value) { ?>
												<li class="<?php if(isset($shareoption[$option['product_option_id']])){ if($shareoption[$option['product_option_id']]==$option_value['product_option_value_id']) echo 'active';} else if($k==0) echo 'active'; ?>" value="<?php echo $option_value['product_option_value_id']; ?>"   ><?php echo $option_value['name']; ?></li>
											<?php } ?>
											</ul>
										</div>
									</div>
									<ul style="display: none;" class="clearfix select_ulk">
											<?php foreach ($option['product_option_value'] as $k=> $option_value) { ?>
												<li class="<?php if(isset($shareoption[$option['product_option_id']])){ if($shareoption[$option['product_option_id']]==$option_value['product_option_value_id']) echo 'active';} else if($k==0) echo 'active'; ?>" value="<?php echo $option_value['product_option_value_id']; ?>"   ><?php echo $option_value['name']; ?></li>
											<?php } ?>
									</ul>
									
								</label>
								<?php }} ?><?php }} ?>
							
								<span class="measurement">
									About Measurement
								</span>
								<div class="meas_img">
									<img class=" changeimage" data-image='/catalog/view/theme/default/img/jpg/size_guid.jpg' data-mimage='/catalog/view/theme/default/img/jpg/yd_size_guid.jpg'  />
									<div class="close"></div>
								</div>
							</div>
							<a class="a_btn clearfix" id="button-cart" >ADD TO SHOPPING CART&nbsp;&nbsp;&nbsp;&nbsp;></a>
								<button class="xyd_btn <?=$wishlist==1 ?'off':'';?>"
							 
			              onclick="wishlist('<?php echo $product_id; ?>',this);"><span>WISHLIST</span></button>
						</div>
						<div class="bot_text clear">
							<p class="text_p text_p2"><span>Hair Material:</span> <?=$material;?></p>
							<div class="share_l" style="max-width: 560px;">
									<?=$m_description;?>
								
							</div>
							<div class="share clearfix">
								<span>Share: </span>
								<ul class="share_ul">
									<li><a id="share_button_facebook" ></a></li>
									<li><a id="share_button_twitter"></a></li>
									<li><a id="share_button_linked"></a></li>
									<li><a id="share_button_google"></a></li>
									<li><a id="share_button_pinterest"></a></li>
								</ul>
							</div>
						</div>
					</div>


			
				</div>

			
				<div class="bot clearfix">
					<ol class="text_ol clearfix">
						<li>PRODUCTS DETAILS <hr /></li>
						<li class="active">DELIVERY AND PACKAGE <hr /></li>
						<li>FAQ <hr /></li>
					</ol>
					<ul class="text_ul">
						<li>
							<h1 class="xxk_h1">PRODUCTS DETAILS</h1>
							<div class="xxk_text">
								<?=$description;?>
							</div>
						</li>
						<li class="active">
							<h1 class="xxk_h1">Delivery And Package</h1>
							<div class="xxk_text">
								<div class="ul_top clearfix">
									<div class="left">
										<img src="/catalog/view/theme/default/img/jpg/map.jpg"/>
									</div>
									<div class="right clearfix">
										<ul class="ul_text clearfix">
											<li>
												<span>United States:</span>
												<i>2-3</i>working days
											</li>
											<li>
												<span>African Countries:</span>
												<i>3-5</i>working days
											</li>
											<li>
												<span>Canada:</span>
												<i>2-3</i>working days
											</li>
											<li>
												<span>Australia:</span>
												<i>3-5</i>working days
											</li>
											<li>
												<span>South America:</span>
												<i>4-5</i>working days
											</li>
											<li>
												<span>Middle East:</span>
												<i>4-5</i>working days
											</li>
											<li>
												<span>Europe:</span>
												<i>3-4</i>working days
											</li>
											<li>
												<span>Asia Countries:</span>
												<i>2-3</i>working days
											</li>
										</ul>
									</div>
								</div>
								<div class="ul_bot clearfix">
									<div class="left clearfix">
										<span>Our express</span>
										<ol class="clearfix">
											<li>
												<img src="/catalog/view/theme/default/img/jpg/pro_det2.jpg"/>
												<p>FedEx</p>
											</li>
											<li>
												<img src="/catalog/view/theme/default/img/jpg/pro_det3.jpg"/>
												<p>DHL</p>
											</li>
										</ol>
									</div>
									<div class="right">
										<span>Package</span>
										<ol class="clearfix">
											<li>
												<img src="/catalog/view/theme/default/img/jpg/pro_det2.jpg"/>
												<p>Product Packaging</p>
											</li>
											<li>
												<img src="/catalog/view/theme/default/img/jpg/pro_det3.jpg"/>
												<p>The Outer Packing</p>
											</li>
										</ol>
									</div>
								</div>
							</div>
						</li>
						<li>
							<h1 class="xxk_h1">FAQ</h1>
							<div class="xxk_text">
								<div class="faq_dl">
									<?=$faq;?>
								</div>
							</div>
						</li>
					</ul>
				</div>
				
				<div class="pro_det_bot clearfix">
					<h1 class="clearfix">
						<hr />
						<span>RECOMMENDED FOR YOU</span>
					</h1>

					<ul class="bot_det_ul">
					 <?php foreach ($recommend_products as $product) { ?>
							
						<li>
							<a href="<?php echo $product['product_link']; ?>"> 
								<div class="pic_img" >
									<img src="<?php echo $product['image']; ?>"  />
								</div>
								<div class="text">
								<span class="price">
					                  <?php if($product['special']) { ?>
					                     <span><?php echo $product['special']['special']; ?></span>
					                     <del><?php echo $product['price']; ?></del>
					                  <?php }else{ ?>
					                     <span class="price-single"><?php echo $product['price']; ?></span>
					                  <?php } ?>
					                </span>
									<!-- <span>$37.01</span> -->
									 <p class="p1"><?php echo $product['meta_title']; ?></p>
									<p class="p2"><?php echo $product['name']; ?> </p>
								</div>
							</a>
						</li>
						<?php } ?> 
					</ul>
				</div>
				
			</div>
		
		</div>
<!-- 新 -->
<script>

 function wishlist(product_id,e) {
  if ($(e).hasClass('off')) {
       $.ajax({
    url:'<?php echo $delewishlist ;?>',
    type:'post',
    data:{'product_id':product_id},
    dataType: 'json',
    success:function(data){
      if (data.success) {
        $('#wishlist_count').html(data.total);
      }
               // location.reload(); 
    }
   })

  }else{
  //alert(product_id);die;
   $.ajax({
    url:'<?php echo $wishlist_add ;?>',
    type:'post',
    data:{'product_id':product_id},
    dataType: 'json',
    success:function(data){
      if (data.success) {
        $('#wishlist_count').html(data.total);
      }
               // location.reload(); 
    }
   })
 }
}
var swiper3 = new Swiper('#swiper3', {
	loop:true,
	navigation: {
	    nextEl: '.swiper-button-next',
	    prevEl: '.swiper-button-prev',
	},
	pagination: {
		el: '.swiper-pagination',
		clickable: true,
    },
});
$(function(){
		$(".pro_det_content .measurement").click(function(){
			$(".meas_img").fadeIn();
		})
		
		$(".meas_img .close").click(function(){
			$(".meas_img").fadeOut();
		})
		
		$(".pra-list-ul>li").click(function(){
			
			var this_index = $(this).index();
		
			$(".swiper-pagination-clickable span").eq(this_index).trigger('click');
		})
		
		
		$(".pro_det_content .len_label>ul>li").click(function(){
			$(this).addClass("active").siblings("li").removeClass("active");
		})
		
		
//		数量
		$(".sub").click(function(){
			var num  = $(".num").val();
			if(num>1){
				num--;
				 $(".num").val(num);
			}
		})
		$(".add").click(function(){
			var num  = $(".num").val();
			num++;
			 $(".num").val(num);
		})
		
		//xxk
		$(".pro_det_content .bot .text_ol>li").click(function(){
			$(this).addClass("active").siblings("li").removeClass("active");
			$(".pro_det_content .bot .text_ul>li").eq($(this).index()).addClass("active").siblings("li").removeClass("active");
		})
		$(".xxk_h1").click(function(){
			if($(this).hasClass("off")){
				$(this).removeClass("off");
				$(this).css("background","url(/catalog/view/theme/default/img/png/jiahao.png) no-repeat right center").css("background-size","0.38rem 0.38rem");
				$(this).siblings(".xxk_text").slideUp();
			}else{
				$(".xxk_h1").removeClass("off");
				$(".xxk_h1").css("background","url(/catalog/view/theme/default/img/png/jiahao.png) no-repeat right center").css("background-size","0.38rem 0.38rem");
				$('.xxk_text').slideUp();
				$(this).addClass("off");
				$(this).css("background","url(/catalog/view/theme/default/img/png/jianhao.png) no-repeat right center").css("background-size","0.38rem 0.38rem");
				$(this).siblings(".xxk_text").slideDown();
			}
		})
		
		//下拉选择
	
		$(".select_btn").each(function(){
			var tmp=$(this).parent().find('li.active').text();
			// console.log(tmp);
			$(this).find('span').text(tmp);
		})
		changeprice();
		$(".select_btn").click(function(){
			if($(this).hasClass("off")){
				$(this).removeClass("off");
				$(this).siblings(".select_ul").stop().slideUp();
		
			}else{
				$(this).addClass("off");
				$(this).siblings(".select_ul").stop().slideDown();
			
			}
		
		})
		$(".select_ul li,.select_ulk li").click(function(){
			var val = $(this).text();
			var value = $(this).attr('value');
			$(this).parents(".len_label").find(".select_btn span").text(val);
			$(this).parents(".len_label").find('input').val(value);
			changeprice();
			$(".select_btn").removeClass("off");
			$(".select_ul").stop().slideUp();
		})
	
		var win = $(window).width();
		$(".xyd_btn").click(function(){
			if(win>992){
				if($(this).hasClass("off")){
					$(this).removeClass("off");
					$(this).css("border","1px solid #ccc").css("background","url(/catalog/view/theme/default/img/png/shop_star.png) no-repeat right 0.83vw center").css("background-size","0.83vw");
				}else{
					$(this).addClass("off");
					$(this).css("border","1px solid #d5af74").css("background","url(/catalog/view/theme/default/img/png/shop_star_.png) no-repeat right 0.83vw center").css("background-size","0.83vw");
				}
			}else{
				if($(this).hasClass("off")){
					$(this).removeClass("off");
					$(this).css("border","1px solid #ccc").css("background","url(/catalog/view/theme/default/img/png/shop_star.png) no-repeat center").css("background-size","0.38rem 0.36rem");
				}else{
					$(this).addClass("off");
					$(this).css("border","1px solid #d5af74").css("background","url(/catalog/view/theme/default/img/png/shop_star_.png) no-repeat  center").css("background-size","0.38rem 0.36rem");
				}
			}
		})
	})
function productInfoImg(elm) {
        var ind = $(elm).parents("li").index();
        if(ind == 0){
            if($(".product_image video").length === 0 ){
                $("#jwx_productInfoImg").show();
                $(".pra-list-ul li").removeClass("on");
                $(elm).parents("li").addClass("on");
                $(".product_image").attr("href", jQuery(elm).attr("data-img"));
                $(".product_image").attr("target", "_blank");
            }
            else{
                $(".product_image video").show();
                $("#jwx_productInfoImg").hide();
                $(".pra-list-ul li").removeClass("on");
                $(elm).parents("li").addClass("on");
                $(".product_image").removeAttr("href");
                $(".product_image").attr("target", "_self");
            }
        }
        else{
            $(".product_image video").hide();
            $("#jwx_productInfoImg").show();
            jQuery("#jwx_productInfoImg").attr({
                src: jQuery(elm).attr("data-img"),
                jqimg: jQuery(elm).attr("jqimg")
            });
            $(".pra-list-ul li").removeClass("on");
            $(elm).parents("li").addClass("on");
            $(".product_image").attr("href", jQuery(elm).attr("data-img"));
            $(".product_image").attr("target", "_blank");
        }
    }
    function playVid() {
        Rerun.style.display="none";
        myVideo.play();
    }

</script>
<!-- 加入购物车 -->
<script type="text/javascript">
  
    var product_id = "<?php echo $product_id; ?>";
    $('#button-cart').on('click', function() {

        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
             dataType: 'json',
            data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
           
     
            success: function(json) {
            	if (json.success) {
        			$('#cart_count').html(json.total);
        			  $(".cart_li").click();

                


     			 }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
    //-->
    function changeprice() {
        //console.log('first');
//         alert($("#form-product").serialize());
        $.ajax({
            url: 'index.php?route=product/product/getprice&product_id=<?php echo $product_id; ?>',
            type: 'post',
            dataType: 'json',
            data: $("#form-product input"),

            success: function(json) {
               // console.log(json);
                $('#money').html(json['html']);
            }
        });
    }
</script>

<script type="text/javascript">
	
	    function popupwindow(url, title, w, h) {
            wLeft = window.screenLeft ? window.screenLeft : window.screenX;
            wTop = window.screenTop ? window.screenTop : window.screenY;
 
            var left = wLeft + (window.innerWidth / 2) - (w / 2);
            var top = wTop + (window.innerHeight / 2) - (h / 2);
            return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
        }
   $(function(){
       	  $('#share_button_facebook').click(function(){
                var shareUrl = "http://www.facebook.com/sharer/sharer.php?u="+window.location.href;
                popupwindow(shareUrl, 'Facebook', 600, 400);
            })
             $('#share_button_twitter').click(function(){
                var shareUrl = "http://twitter.com/share?url="+window.location.href;
                popupwindow(shareUrl, 'Twitter', 600, 400);
            })
            $('#share_button_linked').click(function(){
                var shareUrl = "http://www.linkedin.com/shareArticle?url="+window.location.href;
                popupwindow(shareUrl, 'LinkedIN', 600, 400);
            })
             $('#share_button_google').click( function(){
                var shareUrl = "https://plus.google.com/share?url="+window.location.href;
                popupwindow(shareUrl, 'Google', 600, 400);
            })
            $('#share_button_pinterest').click( function(){
                var shareUrl = "https://www.pinterest.com/pin/create/button/?url="+window.location.href;
                popupwindow(shareUrl, 'Pinterest', 600, 400);
            })
       })
</script>

<?php echo $footer; ?>

