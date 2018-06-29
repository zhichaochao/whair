<?php echo $header; ?>
<div class="content product_det in_content">
			<div class="pro_det_content clearfix">
				<div class="top clearfix">
					<div class="left clearfix">
						<ol class="pro_img_ol">
						<?php if ($images) { ?>
							<li class="li">
							<div class="more-views">
								<div class="prdimgup"> </div>
								<div class="highslide-gallery" id="prdimglist" page="0">
									<ul class="pra-list-ul">
										<?php if($video) { ?>
										<li class="on"><img onclick="productInfoImg(this)" src="<?=$placeholder_image?>"></li>
										<?php } ?>
										<?php foreach ($images as $k => $image) { ?>
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
						<!-- <a href="###"><?php echo $heading_title;?></a> -->
								<h2 style="font-size: 1.16vw;"><?php echo $heading_title;?></h2>
							<p class="price">
							<!-- $36.59 -->
							<!--产品价格-->
								<?php if ($price) { ?>
								<div class="product_right_dindan">
									<dl class="col_f00 jiage" id="money" style="margin-bottom:10px;">
									
										<?php if(isset($special)&&$special){ ?>
										<span>
											<!-- <i style="color:#999;font-size: 25px;">Vip Price:&ensp;</i> -->
											<b style="font-size: 30px;"><?php echo $special; ?></b>
											<del class="price-old" style="color:#999;font-size: 30px;"><?php echo $price; ?></del>
											<b><?php echo $free_shipping; ?></b>
										</span>
										<?php }else{ ?>
										<span>
											<!-- <i style="font-size: 25px;">Price:&ensp;</i> -->
											<b style="font-size: 30px;"><?=$price?> </b>
											<!-- <?php if (isset($login)) { ?>
											<a class="price-go-login" href="<?php echo $login; ?>"><b style="font-size: 16px;">View Specials</b></a>
											<?php } ?> -->
											<b><?php echo $free_shipping; ?></b>
										</span>
										<?php } ?>
									</dl>
								</div>
								<?php } ?>
								<!--/产品价格-->
							
							<!-- <p class="text_p"><span>Hair Color:</span> Natural Black</p> -->

							<div class="label_div clearfix" id="form-product">
								<label class="num_label" for="">
									<span>Quantity:</span>

									<div class="price_input clearfix" >
										<span class="sub" ></span>
										<input class="num" name="quantity" type="text" value="1" id="nums"/>
										<span class="add"></span>
									</div>

								</label>
									   
									   	<?php if ($options) { ?>
					
										<?php foreach ($options as $option) { ?>	
										<?php if ($option['product_option_value']) { ?>
									<?php if ($option['type'] == 'select') { ?> 
								<label class="len_label" for="" >
								<span ><?php if($option['required']) { ?>*<?php } ?><?=$option['name']?>:</span>
									<div class="select_div" >
								
				
								
							
									
									<div class="select_div" id="input-option<?php echo $option['product_option_id']; ?>">
										<input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php if(isset($shareoption[$option['product_option_id']])){ echo $shareoption[$option['product_option_id']];}else{ echo $option['product_option_value'][0]['product_option_value_id'];} ?>" />
										<button class="select_btn"><span>dfgdfg</span></button>
										<div class="select_ul">
											<ul>
												<?php foreach ($option['product_option_value'] as $k=> $option_value) { ?>
												<li class="<?php if(isset($shareoption[$option['product_option_id']])){ if($shareoption[$option['product_option_id']]==$option_value['product_option_value_id']) echo 'on';} else if($k==0) echo 'on'; ?>" value="<?php echo $option_value['product_option_value_id']; ?>"   ><?php echo $option_value['name']; ?></li>
											<?php } ?>
											</ul>
										</div>
									</div>
								
								
							
								
							
									</div>
								</label><?php }} ?><?php }} ?>
								
								<span class="measurement">
									About Measurement
								</span>
								<div class="meas_img">
									<img class=" changeimage" data-image='catalog/view/theme/default/img/jpg/size_guid.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_size_guid.jpg'  />
									<div class="close"></div>
								</div>
							</div>
							<a class="a_btn clearfix" id="button-cart" >ADD TO SHOPPING CART&nbsp;&nbsp;&nbsp;&nbsp;></a>
							<button class="xyd_btn <?=$wishlist==1 ?'off':'';?>"
							  <?php if($wishlist==1) { ?>
			              style='border: 1px solid rgb(213, 175, 116); background: rgba(0, 0, 0, 0) url("catalog/view/theme/default/img/png/shop_star_.png") no-repeat scroll right 0.83vw center / 0.83vw auto;';
			              <?php }?> 
			              onclick="wishlist('<?php echo $product_id; ?>',this);"><span>WISHLIST</span></button>
						</div>
						<div class="bot_text clear">
							<p class="text_p text_p2"><span>Hair Material:</span> Double Drawn Human Hair</p>
							<dl>
								<dt>Quality Features:</dt>
								<dd>span Young girl’s virgin human hair. One donor from one bundle.</dd>
								<dd>Double drawn and double stitch weft hair.</dd>
								<dd>No any short hair inside, very full hair tips.</dd>								
								<dd>The most silk and soft hair.</dd>
								<dd>Can be dyed or bleached to any color, even lightest 613#.</dd>
								<dd>Can be restyled, flat ironed, straightened.</dd>
								<dd>No shedding, tangle free. Can be last for 3-5 years if under good care.</dd>
							</dl>
							<div class="share clearfix">
								<span>Share: </span>
								<ul class="share_ul">
									<li><a href="sh #"></a></li>
									<li><a href="###"></a></li>
									<li><a href="###"></a></li>
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
								<img src="catalog/view/theme/default/img/jpg/products.jpg"/>
							</div>
						</li>
						<li class="active">
							<h1 class="xxk_h1">Delivery And Package</h1>
							<div class="xxk_text">
								<div class="ul_top clearfix">
									<div class="left">
										<img src="catalog/view/theme/default/img/jpg/map.jpg"/>
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
												<img src="catalog/view/theme/default/img/jpg/pro_det2.jpg"/>
												<p>FedEx</p>
											</li>
											<li>
												<img src="catalog/view/theme/default/img/jpg/pro_det3.jpg"/>
												<p>DHL</p>
											</li>
										</ol>
									</div>
									<div class="right">
										<span>Package</span>
										<ol class="clearfix">
											<li>
												<img src="catalog/view/theme/default/img/jpg/pro_det2.jpg"/>
												<p>Product Packaging</p>
											</li>
											<li>
												<img src="catalog/view/theme/default/img/jpg/pro_det3.jpg"/>
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
									<dl>
										<dt><span>1</span> How Much Hair Do I Need?</dt>
										<dd>
											A: For average head size, here is my suggestion: <br />
											12"-14": 2 bundles <br />
											16"-22": 3 bundles <br />
											24"-28": 3 bundles or more
										</dd>
									</dl>
									<dl>
										<dt><span>2</span> Can the hair be straightened, curled ?</dt>
										<dd>
											A: Yes you could use hair straightener or hair curler to style the virgin hair . However,
											 don't do it too frequently, or the heat will make the hair easily 
											get dry and tangled.
										</dd>
									</dl>
									<dl>
										<dt><span>3</span> Can I dye/color the hair?</dt>
										<dd>
											A:  Yes. The hair can be colored. As a general rule it is easier to darken the
											 hair than to lighten the hair. We recommend to dye darker, since it is 
											difficult for the original colour to fade. Brazilian virgin hair extension in competitive price.<br />
											Improper dying will ruin the hair. We highly recommend having your hairdresser dye the 
											Brazilian virgin hair . Colouring by yourself will take a risk 
											of not coming out the shade you want. If you can't get to a salon, please always use a good
											 quality products and test a small sample first.
										</dd>
									</dl>
									<dl>
										<dt><span>4</span> How long does it last?</dt>
										<dd>
											A:  How long the hair lasts depends on how you maintain it. Treat it like your own hair and take
											 very good care of it, then normally it could last 3-5 
											yeas for our best one donor Brazilian hair and 1-2 years for our silk Peruvian hair.

										</dd>
									</dl>
									<dl>
										<dt><span>5</span> Why are my hair extensions getting tangled?</dt>
										<dd>
											A:  It could be caused by dry hair. Please make sure to wash & condition your hair at least
											 once a week, twice a week is better. brazilian virgin 
											hair Comb the hair from time to time. You could go to your stylist for further suggestions.

										</dd>
									</dl>
									<dl>
										<dt><span>6</span> How do I take care of my hair?</dt>
										<dd>
											A:  Treat this hair just as if it was your own hair. <br />
										   <span>●</span>Prepare the warm water,not too hot and not too cold.<br />
										   <span>●</span>Put some shampoo and hair conditioner inside the water.<br />
										   <span>●</span>Put hair inside the water and wash slowly.<br />
										   <span>●</span>Keep hair insider the warm water 10min around.<br />
										   <span>●</span>Use clean warm water wash it again.<br />
										   <span>●</span>Unstrap the line of the hair slowly.<br />
										   <span>●</span>DO NOT put the hair in the sun or use hair dryer,let it dry naturally.
										</dd>
									</dl>
									<dl>
										<dt><span>7</span> What type of hair care products should I use?</dt>
										<dd>
											A:  Treat this hair extension just as if it was your own hair. <br />
										   <span>●</span>Use good quality shampoo and hair conditioner to care the hair.
										    It's important to keep the hair soft and shiny.<br />
										   <span>●</span>You could use gel or spray styling products to keep the hair style.<br />
										   <span>●</span>Olive oil will be a good choice to keep the hair healthy.<br />
										</dd>
									</dl>
									<dl>
										<dt><span>8</span> Why are my hair extensions getting tangled?</dt>
										<dd>
											A:  Human hair has natural protein . It is easy to tell by burning: human
											 hair will be ash,which will go away after pinching.<br />
											When burning,the human hair will show white smoke. While synthetic hair will be a sticky ball after burning and will show black smoke.
											Moreover, human hair may have very few gray hair and split ends. It is normal and not a quality problem.
										</dd>
									</dl>
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
							<a href="<?php echo $href.$product['product_id']; ?>"> 
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
// function wishlist(product_id) {
//   //alert(product_id);die;
//    $.ajax({
//     url:'<?php echo $wishlist ;?>',
//     type:'post',
//     data:{'product_id':product_id},
//     dataType: 'json',
//     success:function(data){
//       if (data.success) {
//         $('#wishlist_count').html(data.total);
//       }
//                // location.reload(); 
//     }
//    })
//  }
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
				$(this).css("background","url(catalog/view/theme/default/img/png/jiahao.png) no-repeat right center").css("background-size","0.38rem 0.38rem");
				$(this).siblings(".xxk_text").slideUp();
			}else{
				$(".xxk_h1").removeClass("off");
				$(".xxk_h1").css("background","url(catalog/view/theme/default/img/png/jiahao.png) no-repeat right center").css("background-size","0.38rem 0.38rem");
				$('.xxk_text').slideUp();
				$(this).addClass("off");
				$(this).css("background","url(catalog/view/theme/default/img/png/jianhao.png) no-repeat right center").css("background-size","0.38rem 0.38rem");
				$(this).siblings(".xxk_text").slideDown();
			}
		})
		
		//下拉选择
	
		$(".select_btn").each(function(){
			var tmp=$(this).parent().find('li.on').text();
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
		$(".select_ul li").click(function(){
			var val = $(this).text();
			var value = $(this).attr('value');
			$(this).parents(".select_div").find(".select_btn span").text(val);
			$(this).parents(".select_div").find('input').val(value);
			changeprice();
			$(".select_btn").removeClass("off");
			$(".select_ul").stop().slideUp();
		})
		$("body").click(function(e){
			if(off==1){
				var close = $('.select_div .select_ul'); 
			   	if(!close.is(e.target) && close.has(e.target).length === 0){
			      	$(".select_btn").removeClass("off");
					$(".select_ul").stop().slideUp();
					off=0;
				}
			}
		})
		var win = $(window).width();
		$(".xyd_btn").click(function(){
			if(win>992){
				if($(this).hasClass("off")){
					$(this).removeClass("off");
					$(this).css("border","1px solid #ccc").css("background","url(catalog/view/theme/default/img/png/shop_star.png) no-repeat right 0.83vw center").css("background-size","0.83vw");
				}else{
					$(this).addClass("off");
					$(this).css("border","1px solid #d5af74").css("background","url(catalog/view/theme/default/img/png/shop_star_.png) no-repeat right 0.83vw center").css("background-size","0.83vw");
				}
			}else{
				if($(this).hasClass("off")){
					$(this).removeClass("off");
					$(this).css("border","1px solid #ccc").css("background","url(catalog/view/theme/default/img/png/shop_star.png) no-repeat center").css("background-size","0.38rem 0.36rem");
				}else{
					$(this).addClass("off");
					$(this).css("border","1px solid #d5af74").css("background","url(catalog/view/theme/default/img/png/shop_star_.png) no-repeat  center").css("background-size","0.38rem 0.36rem");
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
//		alert('<?php echo $product_id; ?>'+',<?=$read_special?$read_special:0?>'+',<?php echo $read_price;?>');
        $.ajax({
            url: 'index.php?route=product/product/getprice&product_id=<?php echo $product_id; ?>&p=<?php echo $read_price;?>&s=<?=$read_special?$read_special:0?>',
            type: 'post',
            dataType: 'json',
            data: $("#form-product input"),

            success: function(json) {
               console.log(json);
                $('#money').html(json['html']);
            }
        });
    }
</script>

<?php echo $footer; ?>