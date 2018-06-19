<?php echo $header; ?>
<div class="content product_det in_content">
			<div class="pro_det_content clearfix">
				<div class="top clearfix">
					<div class="left clearfix">
						<ol class="pro_img_ol">
							<li>
							<?php if ($images) { ?>
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
											<img onclick="productInfoImg(this)" data-img="<?php echo $image['thumb2']; ?>" style="cursor: pointer !important;" src="<?php echo $image['thumb']; ?>" alt='<?php echo $heading_title; ?>' title='<?php echo $heading_title; ?>'>
										</a>
										</li>
										<?php } ?>
									</ul>
								</div>
								<div class="prdimgdown"></div>
								<div style="clear:both;"></div>
							</div>
							<?php } ?>
						</li>
							<!-- <li><img src="img/jpg/product1.jpg"/></li>
							<li><img src="img/jpg/pro_det1.jpg"/></li>
							<li><img src="img/jpg/pro_det1.jpg"/></li>
							<li><img src="img/jpg/pro_det1.jpg"/></li> -->
						</ol>
						<div class="pro_big_img">
							<div class="swiper-container" id="swiper3">

							    <div class="swiper-wrapper" id="jwx_productInfo2">
							      	<div class="swiper-slide ban_img">
							      		<?php if ($video) { ?>
										<!-- 产品后台上传视频 -->
										<div class="highslide-gallery">
											<a class="highslide product_image jqzoom" target="_self" title="<?php echo $heading_title; ?>">
												<video class="pull-left" src='<?=$video?>' id="audio" style="width:100%;height:100%;" autoplay></video>
												<img id="Rerun" src="image/catalog/review.png" style="display:none;width:80px;height:80px;position:relative;z-index:10;top:-288px;" onclick= "playVid()"/>
												<img id="jwx_productInfoImg" src="image/pc/kks1-700x700.jpg" title='Fuller Peruvian Virgin Hair Kinky Straight 12inch to 26inch' alt='Fuller Peruvian Virgin Hair Kinky Straight 12inch to 26inch' style="display:none;" />
											</a>
										</div>
										<!-- 产品后台上传视频 -->

										<?php } elseif ($thumb) { ?>
										<div class="highslide-gallery">
											<a class="highslide product_image jqzoom" target="_blank" href="<?php echo $image; ?>" title="<?php echo $heading_title; ?>">
												<img id="jwx_productInfoImg" src="<?php echo $thumb; ?>" title='<?php echo $heading_title; ?>' alt='<?php echo $heading_title; ?>' />
											</a>
										</div>
										<?php } ?>
							      	</div>
								   <!--  <div class="swiper-slide ban_img">
								    	<img src="img/jpg/product1.jpg"/>
								    </div>
								    <div class="swiper-slide ban_img">
								    	<img src="img/jpg/pro_det1.jpg"/>
								    </div>
								    <div class="swiper-slide ban_img">
							      		<img src="img/jpg/pro_det1.jpg"/>
							      	</div>
								    <div class="swiper-slide ban_img">
								    	<img src="img/jpg/product1.jpg"/>
								    </div> -->
							    </div>
							    <div class="swiper-pagination"></div>
							    <div class="swiper-button-prev"></div>
								<div class="swiper-button-next"></div>
							</div>
							
						</div>
					</div>
					<div class="right">
						<div class="top_text">
								<h2><?php echo $heading_title;?></h2>


							<p class="price">
							<!-- $36.59 -->
							<!--产品价格-->
								<?php if ($price) { ?>
								<div class="product_right_dindan">
									<dl class="col_f00 jiage" id="money" style="margin-bottom:10px;">
										<?php if($special){ ?>
										<span>
											<i>Vip Price:&ensp;</i>
											<b><?php echo $special; ?></b>
											<del class="price-old" style="color:#999;font-size: 16px;"><?php echo $price; ?></del>
											<b><?php echo $free_shipping; ?></b>
										</span>
										<?php }else{ ?>
										<span>
											<p style="font-size:20px;">Price:&ensp;
											<?=$price?> </p>
											<!-- <?php if (isset($login)) { ?>
											<a class="price-go-login" href="<?php echo $login; ?>">View Specials</a>
											<?php } ?> -->
											<b><?php echo $free_shipping; ?></b>
										</span>
										<?php } ?>
									</dl>
								</div>
								<?php } ?>
								<!--/产品价格-->
							<i style="font-size:20px; color:gray; text-decoration:line-through;">$136.00</i></p>
							<p class="text_p"><span>Hair Color:</span> Natural Black</p>
							<div class="label_div clearfix">
								<label class="num_label" for="">
									<span>Quantity:</span>

									<div class="price_input clearfix" id="button-cart">
										<span class="sub" ></span>
										<input class="num" type="text" value="1" id="nums"/>
										<span class="add"></span>
									</div>

								</label>
								<label class="len_label" for="">
									<span>Length:</span>
									<div class="select_div">
										<button class="select_btn"><span>12in  100g  1pc</span></button>
										<div class="select_ul">
											<ul>
												<li>12in  100g  1pc</li>
												<li>14in  100g  1pc</li>
												<li>16in  100g  1pc</li>
												<li>18in  100g  1pc</li>
												<li>20in  100g  1pc</li>
												<li>22in  100g  1pc</li>
												<li>24in  100g  1pc</li>
												<li>26in  100g  1pc</li>
												<li>28in  100g  1pc</li>
												<li>30in  100g  1pc</li>
											</ul>
										</div>
									</div>
									<!-- <ul style="display: none;" class="clearfix">
										<li class="active">12in 100g 1pc</li>
										<li>12in 100g 1pc</li>
										<li>12in 100g 1pc</li>
										<li>12in 100g 1pc</li>
										<li>12in 100g 1pc</li>
										<li>12in 100g 1pc</li>
										<li>12in 100g 1pc</li>
										<li>12in 100g 1pc</li>
										<li>12in 100g 1pc</li>
									</ul>
 -->									
								</label>
								<span class="measurement">
									About Measurement
								</span>
								<div class="meas_img">
									<img class=" changeimage" data-image='catalog/view/theme/default/img/jpg/size_guid.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_size_guid.jpg'  />
									<div class="close"></div>
								</div>
							</div>
							<a class="a_btn clearfix" href="">ADD TO SHOPPING CART&nbsp;&nbsp;&nbsp;&nbsp;></a>
							<button class="xyd_btn" href="###"><span>WISHLIST</span></button>
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
									<li><a href="###"></a></li>
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
					<?php foreach ($products as $product) { ?>
							
						<!-- <li>
							<a href="###">
								<div class="pic_img">
									<img src="<?php echo $product['thumb']; ?>"/>
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
									<!-- <p class="p1"><?php echo $product['texture']; ?></p>
									<p class="p2"><?php echo $product['name']; ?> </p>
								</div>
							</a>
						</li>
						<?php } ?> --> 
						<li>
							<a href="###">
								<div class="pic_img">
									<img src="catalog/view/theme/default/img/jpg/pro_det4.jpg"/>
								</div>
								<div class="text">
									<span>$37.01</span>
									<p class="p1">Silky Straight</p>
									<p class="p2">10"-30" Virgin Brazilian Straight Hair </p>
								</div>
							</a>
						</li>
						<li>
							<a href="###">
								<div class="pic_img">
									<img src="catalog/view/theme/default/img/jpg/pro_det4.jpg"/>
								</div>
								<div class="text">
									<span>$37.01</span>
									<p class="p1">Silky Straight</p>
									<p class="p2">10"-30" Virgin Brazilian Straight Hair </p>
								</div>
							</a>
						</li>
						<li>
							<a href="###">
								<div class="pic_img">
									<img src="catalog/view/theme/default/img/jpg/pro_det4.jpg"/>
								</div>
								<div class="text">
									<span>$37.01</span>
									<p class="p1">Silky Straight</p>
									<p class="p2">10"-30" Virgin Brazilian Straight Hair </p>
								</div>
							</a>
						</li>
						<li>
							<a href="###">
								<div class="pic_img">
									<img src="catalog/view/theme/default/img/jpg/pro_det4.jpg"/>
								</div>
								<div class="text">
									<span>$37.01</span>
									<p class="p1">Silky Straight</p>
									<p class="p2">10"-30" Virgin Brazilian Straight Hair </p>
								</div>
							</a>
						</li>
					</ul>
				</div>
				
			</div>
		
		</div>
<!-- 新 -->
<script>
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
		
		$(".pro_img_ol>li").click(function(){
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
		var off = 0;
		$(".select_btn").click(function(){
			if($(this).hasClass("off")){
				$(this).removeClass("off");
				$(this).siblings(".select_ul").stop().slideUp();
				off=0;
			}else{
				$(this).addClass("off");
				$(this).siblings(".select_ul").stop().slideDown();
				off=1;
			}
			 event.stopPropagation();
		})
		$(".select_ul li").click(function(){
			var val = $(this).text();
			$(this).parents(".select_div").find(".select_btn span").text(val);
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

</script>

<?php echo $footer; ?>