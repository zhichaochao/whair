<?php echo $header; ?>

<div class="container jwx_productInfo">

	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li>
			<a href="<?php echo $breadcrumb['href']; ?>">
				<?php echo $breadcrumb['text']; ?>
			</a>
		</li>
		<?php } ?>
	</ul>

	<div class="row">
		<div class="prodet_left jwx_productInfo2" id="jwx_productInfo2">

			<div class="product-box-customs">

				<?php if ($video) { ?>
				<!-- 产品后台上传视频 -->
				<div class="highslide-gallery">
					<a class="highslide product_image jqzoom" target="_self" title="<?php echo $heading_title; ?>">
						<video class="pull-left" src='<?=$video?>' id="audio"style="width:100%;height:100%;" autoplay></video>
						<img id="Rerun" src="image/catalog/review.png" style="display:none;width:80px;height:80px;position:relative;z-index:10;top:-288px;" onclick="playVid()"/>
						<img id="jwx_productInfoImg" src="image/pc/kks1-700x700.jpg" title='Fuller Peruvian Virgin Hair Kinky Straight 12inch to 26inch' alt='Fuller Peruvian Virgin Hair Kinky Straight 12inch to 26inch'style="display:none;" />
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
			</div>

			<!-- 产品youtube视频 -->
			<?php if($video_link) { ?>
			<div class="pull-left" style="width:100%;height:300px;margin-top:30px;border:0;">
				<?=$video_link?>
			</div>
			<?php } ?>
			<!-- 产品youtube视频 -->

		</div>
		<!--jwx_productInfo2-->

		<!--右侧数据-->
		<div class="prodet_right">
			<div class="prodet_right_hd">
				<h2><?php echo $heading_title;?></h2>
				<!--<p>Be the first to review this product<a href="javascript:;"><img src="catalog/view/theme/default/image/details_bj.png"></a></p>-->

				<?php if(false){ ?>
				<!--产品的评论次数和平均分-->
				<div class="pingfen">
					<div class="d3">
						<!--平均分*20 值给width-->
						<div class="d1" style="width:<?php echo $reviewsratingStar; ?>%"></div>
						<div class="d2"></div>
					</div>
					<?php echo $reviewstotal;?> Reviews<!--<span> Reviews</span>-->
				</div>
				<!--/产品的评论次数和平均分-->
				<?php } ?>
			</div>

			<!--产品价格-->
			<?php if ($price) { ?>
			<div class="product_right_dindan">
				<dl class="col_f00 jiage" id="money" style="margin-bottom:10px;">
					<?php if($special){ ?>
					<dd>
						<i>Vip Price:&ensp;</i>
						<b><?php echo $special; ?></b>
						<del class="price-old" style="color:#999;font-size: 16px;"><?php echo $price; ?></del>
						<b><?php echo $free_shipping; ?></b>
					</dd>
					<?php }else{ ?>
					<dd>
						<i>Price:&ensp;</i>
						<b><?=$price?> </b>
						<?php if (isset($login)) { ?>
						<a class="price-go-login" href="<?php echo $login; ?>">View Specials</a>
						<?php } ?>
						<b><?php echo $free_shipping; ?></b>
					</dd>
					<?php } ?>
				</dl>
			</div>
			<?php } ?>
			<!--/产品价格-->

			<input type="hidden" value="" id="share-content" />
			<div id="product">
				<form id='form-product'>
					<?php if ($options) { ?>
					<hr>
					<?php foreach ($options as $option) { ?>

					<!-- <h4><?=$option['name'];?></h4> -->

					<?php if ($option['product_option_value']) { ?>
					<?php if ($option['type'] == 'select') { ?>
					<p class="select-box">
						<span><?php if($option['required']) { ?>*<?php } ?><?=$option['name']?>:</span>
						<select onchange="changeprice()" name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>"  style="cursor:pointer;">
							<option value=""><?php echo $text_select; ?></option>
							<?php foreach ($option['product_option_value'] as $k=> $option_value) { ?>
							<option <?php if(isset($shareoption[$option['product_option_id']])){ if($shareoption[$option['product_option_id']]==$option_value['product_option_value_id']) echo 'selected';} else if($k==0) echo 'selected'; ?> value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
							<?php if ($option_value['price']) { ?>
							(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
							<?php } ?>
							</option>
							<?php } ?>
						</select>
					</p>
					<?php } if ($option['type'] == 'radio') { ?>
					<p class="select-box">
						<span><?php if($option['required']) { ?>*<?php } ?><?=$option['name']?>:</span>
					<div class="product_label">
						<?php foreach ($option['product_option_value'] as $k=> $option_value) { ?>
						<label <?=$k==0?'style="border-color: rgb(254, 136, 31);"':''?>>
						<input onclick=" changeprice();" <?=$k==0?'checked':'';?> type="radio" name="option[<?php echo $option['product_option_id']; ?>]" style="display:none" value="<?php echo $option_value['product_option_value_id']; ?>" />
						<?php echo $option_value['name']; ?>
						</label>
						<?php } ?>
					</div>
					</p>
					<?php }} ?>
					<!--
                                        <?php if ($option['type'] == 'text') { ?>
                                        <div style="display: none" class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                            <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                            <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                        </div>
                                        <?php }  if ($option['type'] == 'date') { ?>
                                        <div style="display: none" class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
                                            <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
                                            <div class="input-group date">
                                                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                    </span></div>
                                        </div>
                                        <?php } ?>
                    -->
					<?php }} ?>
				</form>
				<p class="select-box">
					<span>Qty:</span>
					<input value="1" type="text" placeholder="" name="quantity" id="input-quantity">
				</p>

				<!-- 增减商品数量铵钮 -->
				<div class="prodet_num_botom">
					<button class="addnum" style="background-color: #00a8c6;width: 30px" id="button-minus"> - </button>
					<button class="minusnum"  style="background-color: #00a8c6;width: 30px" id="button-add"> + </button>
					<button class="share" style="background-color: #00a8c6;width: 60px" id="button-share"> 分享 </button>
				</div>
				<!-- 增减商品数量 -->

				<input type="hidden" name="product_id" value="<?=$product_id?>">
				<div style="clear: both;"></div>
				<style>
					#product .select-box{
						margin-bottom:19px;
						float:left;
					}
					#product .select-box span{
						display:inline-block;
						width:100px;
					}
					#product .product_label{
						margin-left:104px;
					}
					#product .product_label label{
						font-weight:normal;
						margin-right:10px;
						margin-bottom:10px;
						padding: 5px;
						border:1px solid;
						border-color: #666;
						cursor:pointer;
					}
					#product .select-box select{
						width: 160px;
						height: 35px;
						color: #333;
						background-color: #fff;
						border: 1px solid #b5b5b5;
					}
					#product .select-box input{
						width: 160px;
						height: 35px;
						background-color:#fff;
						border:1px solid #999;
					}
				</style>
				<script type="text/javascript" src="http://www.jq22.com/demo/copy20161120/dist/clipboard.min.js"></script>
				<script>
                    $(function(){
                        $('#product').on('click','label',function(){
                            $(this).css({"border-color":"#fe881f"});
                            $(this).siblings().css({"border-color":"#666"});
                        });
//                        增减事件
                        $('#button-add').click(function () {
                            $('#input-quantity').val(parseInt($('#input-quantity').val())+1);
                            $('#nums').html($('#input-quantity').val());
                            console.log($('#nums').html());
                        });
                        $('#button-minus').click(function () {
                            if($('#input-quantity').val()>1){
                                $('#input-quantity').val(parseInt($('#input-quantity').val())-1);
                                $('#nums').html($('#input-quantity').val());
                            }
                        });

//                        分享事件
                        $('#button-share').click(function () {
                            $.ajax({
                                url: 'index.php?route=checkout/cart/share',
                                type: 'post',
                                async: false,
                                data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
                                dataType: 'json',
                                beforeSend: function() {
                                    $('#button-share').button('loading');
                                },
                                complete: function() {
//                                    $('#share-content').select();
//                                    alert("复制分享链接成功！");
                                    $('#button-share').button('reset');
                                },
                                success: function(json) {
//                                    alert(json);
                                    var clipboard = new Clipboard('.share', {
                                        text: function() {
                                            return json;
                                        }
                                    });
                                    clipboard.on('success', function(e) {
                                        alert("分享链接已经复制到剪贴板，赶快去分享吧~~");
                                    });

                                    clipboard.on('error', function(e) {
                                        console.log(e);
                                    });
//									$('#share-content').val(json);
                                }
                        });
                        });
                    });
				</script>
			</div>
			<!--/新-->


			<!--/长度-->

			<!--数量下拉框-->
			<!--<div class="product_right_size">
                <span class="sp1">Quantity :</span>
              <span class="sp2">
                <a class="jian" href="javascript:void(0);" onclick="javascript:updateQty(this,1);"><i
                        class="fa fa-minus-square"></i></a>
                  <input type="text" name="qty" value="1" size="1" onchange="updateQty(this,0);">
                <a class="jia" href="javascript:void(0);" onclick="javascript:updateQty(this,2);"><i
                        class="fa fa-plus-square"></i></a>
              </span>
            </div>-->
			<!--/数量下拉框-->

			<!--按钮-->
			<div class="prodet_right_botom">
				<button class="btn1 add-to-cart-gtm" id="button-cart" ">CHECK OUT: <span id="nums">1</span> <span class="new-product-num-right">Item</span></button>
				<button class="btn1 btn2 inquiry-gtm" id="product-detail-inquiry">Wholesale Inquiry</button>
			</div>
			<!--/按钮-->

			<!--其它属性-->
			<div class="prodet_right_mian qitasuxing">
				<h3>Remark：</h3>
				<div class="dright">
					For quantity over 5 pieces, please contact <?php echo $email; ?> for wholesale prices.
				</div>
			</div>
			<!--/其它属性-->

		</div>
		<!--/右侧数据-->
	</div>
	<!--/class="row"-->

	<!-----------相关产品------------>
	<!--<?php if ($products) { ?>
      <h3><?php echo $text_related; ?></h3>
       <div class="row">
         <?php $i = 0; ?>
         <?php foreach ($products as $product) { ?>
         <?php if ($column_left && $column_right) { ?>
         <?php $class = 'col-xs-8 col-sm-6'; ?>
         <?php } elseif ($column_left || $column_right) { ?>
         <?php $class = 'col-xs-6 col-md-4'; ?>
         <?php } else { ?>
         <?php $class = 'col-xs-6 col-sm-3'; ?>
         <?php } ?>

         <div class="<?php echo $class; ?>">
            <div class="product-thumb transition">
              <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
              <div class="caption">
              <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
              <p><?php echo $product['description']; ?></p>
              <?php if ($product['rating']) { ?>
              <div class="rating">
                <?php for ($j = 1; $j <= 5; $j++) { ?>
                 <?php if ($product['rating'] < $j) { ?>
                   <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                    <?php } else { ?>
                    <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                    <?php } ?>
                    <?php } ?>
                 </div>
              <?php } ?>
              <?php if ($product['price']) { ?>
              <p class="price">
                <?php if (!$product['special']) { ?>
                <?php echo $product['price']; ?>
                <?php } else { ?>
                <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                <?php } ?>
                <?php if ($product['tax']) { ?>
                <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                <?php } ?>
              </p>
              <?php } ?>
            </div>
            <div class="button-group">
              <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span> <i class="fa fa-shopping-cart"></i></button>
              <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
              <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
     </div>
     </div>
    </div>

      <?php if (($column_left && $column_right) && (($i+1) % 2 == 0)) { ?>
      <div class="clearfix visible-md visible-sm"></div>
      <?php } elseif (($column_left || $column_right) && (($i+1) % 3 == 0)) { ?>
      <div class="clearfix visible-md"></div>
      <?php } elseif (($i+1) % 4 == 0) { ?>
      <div class="clearfix visible-md"></div>
      <?php } ?>
      <?php $i++; ?>
      <?php } ?>

      </div>
    <?php } ?>-->

	<!--推荐产品-->
	<?php if ($popular_products) { ?>
	<dl class="related" id="jwx_imgLb">
		<dt><?php echo $text_related; ?></dt>
		<dd>
			<i class="ileft"></i>
			<i class="iright"></i>
			<div class="conter fixclea">
				<div class="product_tabl_box">
					<?php foreach($popular_products as $key=>$row){ ?>
					<?php if( ($row['key_id'])%4 == 0 ){ ?>
					<ul class="product_tabl cf fl-left">
						<li>
							<span class="s1" style="width: 0%;"></span>
							<a href="<?php echo $row['product_link']; ?>" title="<?php echo $row['name']; ?>" target="_blank">
								<p class="p1"><img src="<?php echo $row['image']; ?>" title='<?php echo $row["name"]; ?>' alt='<?php echo $row["name"]; ?>' /></p>

								<?php if(!empty($row['color_name'])){ ?>
								<p class="pp_sp"><i><?php echo $row['color_name'];?></i></p>
								<?php } ?>

								<p class="p2">
									<?php echo $row['min_name']; ?>
								</p>
							</a>
						</li>
						<?php }else if( ($row['key_id'])%4 == 3 ){ ?>
						<li>
							<span class="s1" style="width: 0%;"></span>
							<a href="<?php echo $row['product_link']; ?>" title="<?php echo $row['name']; ?>" target="_blank">
								<p class="p1"><img src="<?php echo $row['image']; ?>" title='<?php echo $row["name"]; ?>' alt='<?php echo $row["name"]; ?>' /></p>

								<?php if(!empty($row['color_name'])){ ?>
								<p class="pp_sp"><i><?php echo $row['color_name'];?></i></p>
								<?php } ?>

								<p class="p2">
									<?php echo $row['min_name']; ?>
								</p>
							</a>
						</li>
					</ul>
					<?php }else{ ?>
					<li>
						<span class="s1" style="width: 0%;"></span>
						<a href="<?php echo $row['product_link']; ?>" title="<?php echo $row['name']; ?>" target="_blank">
							<p class="p1"><img src="<?php echo $row['image']; ?>" title='<?php echo $row["name"]; ?>' alt='<?php echo $row["name"]; ?>' /></p>

							<?php if(!empty($row['color_name'])){ ?>
							<p class="pp_sp"><i><?php echo $row['color_name'];?></i></p>
							<?php } ?>

							<p class="p2">
								<?php echo $row['min_name']; ?>
							</p>
						</a>
					</li>
					<?php } ?>
					<?php } ?>
					<?php if(count($popular_products)%4!=0) echo '</ul>'; ?>
				</div>
			</div>
		</dd>
	</dl>
	<?php } ?>
	<!----/推荐产品---->

	<!--产品介绍-->
	<dl class="productimg">
		<dt>Product Description<i></i></dt>
		<dd>
			<?php echo $description; ?>
		</dd>
	</dl>
	<!--/产品介绍-->

	<!--产品描述+评论-->
	<!--<ul class="nav nav-tabs">
       <li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a></li>

       <?php if ($attribute_groups) { ?>
       <li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
       <?php } ?>

       <?php if ($review_status) { ?>
       <li><a href="#tab-review" data-toggle="tab"><?php echo $tab_review; ?></a></li>
       <?php } ?>
    </ul>-->

	<!--属性组+FAQ+产品评论-->
	<div class="tab-content">
		<!--产品描述-->
		<!-- <div class="tab-pane active" id="tab-description"><?php echo $description; ?></div>-->

		<!--属性组-->
		<?php if ($attribute_groups) { ?>
		<div class="tab-pane" id="tab-specification">
			<table class="table table-bordered">
				<?php foreach ($attribute_groups as $attribute_group) { ?>
				<thead>
				<tr>
					<td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
				<tr>
					<td>
						<?php echo $attribute['name']; ?>
					</td>
					<td>
						<?php echo $attribute['text']; ?>
					</td>
				</tr>
				<?php } ?>
				</tbody>
				<?php } ?>
			</table>
		</div>
		<?php } ?>
		<!--/属性组-->

		<!--FAQ部分-->
		<dl class="faq">
			<dt class="title">FREQUENTLY ASKED QUESTIONS</dt>
			<?php echo $product_faq;?>
		</dl>
		<!--/FAQ部分-->

		<?php if(false){ ?>
		<!--产品评论-->
		<?php if ($review_status) { ?>
		<dl class="faq">
			<div>
				<!--<form class="form-horizontal" id="form-review">-->
				<form class="form-horizontal" enctype="multipart/form-data" action="<?php echo $reviews_action; ?>" method="post">
					<!--评论成功与失败的提示-->
					<?php if(!empty($error['error'])){ ?>
					<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
						<?php echo $error['error']; ?>
					</div>
					<?php } ?>
					<?php if(!empty($error['success'])){ ?>
					<div class="alert alert-success"><i class="fa fa-check-circle"></i>
						<?php echo $error['success']; ?>
					</div>
					<?php } ?>
					<!--/评论成功与失败的提示-->

					<dt class="title"><?php echo $text_write; ?></dt>

					<?php if ($review_guest) { ?>
					<div class="form-group required">
						<div class="col-sm-12">
							<label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
							<input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-name" class="form-control" />
						</div>
					</div>
					<div class="form-group required">
						<div class="col-sm-12">
							<label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
							<textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
							<div class="help-block">
								<?php echo $text_note; ?>
							</div>
						</div>
					</div>

					<div class="form-group required">
						<div class="col-sm-12">
							<label class="control-label product-rating-rating"><?php echo $entry_rating; ?></label>
							<?php echo $entry_bad; ?>
							<ul class="product-rating-star fixclea" >
								<li><label><input type="radio" name="rating" value="1" id="rating-radio-1"/></label></li>
								<li><label><input type="radio" name="rating" value="2" id="rating-radio-2" /></label></li>
								<li><label><input type="radio" name="rating" value="3" id="rating-radio-3" /></label></li>
								<li><label><input type="radio" name="rating" value="4" id="rating-radio-4" /></label></li>
								<li><label><input type="radio" name="rating" value="5" id="rating-radio-5" /></label></li>
							</ul>
							<?php echo $entry_good; ?>

						</div>
					</div>

					<!--图片上传-->
					<div class="form-group">
						<div class="col-sm-12" id="product-post-img-box">
							<div class="product-post-img-title"><?php echo $entry_image; ?></div>
							<input type="file" name="file[]" accept="image/pjpeg,image/jpeg,image/gif,image/png,image/jpg"/>

						</div>
					</div>
					<!--/图片上传-->
					<script>
                        jQuery(function($){
                            var $proRatStar = $('.product-rating-star'),
                                $proPostImg = $('#product-post-img-box');
                            $proRatStar.on('click','label',function(){
                                $(this).children().prop('checked',true);
                                var starNum = $(this).children().val();
                                $.each($('.product-rating-star label'),function(idx,ele){
                                    if(starNum >= idx+1){
                                        $(ele).css('background','url(/catalog/view/theme/default/images/tzx/product/star.gif) no-repeat 0 -28px');
                                    }else{
                                        $(ele).css('background','url(/catalog/view/theme/default/images/tzx/product/star.gif) no-repeat 0 0');
                                    }
                                });
                                return false;
                            });
                            var isIE = /msie/i.test(navigator.userAgent) && !window.opera;
                            $proPostImg.on('change','input',function(e){
                                var addTf = false;
                                var fileSize = 0;
                                if (isIE && !$(this)[0].files) {
                                    var filePath = $(this)[0].value;
                                    var fileSystem = new ActiveXObject("Scripting.FileSystemObject");
                                    var file = fileSystem.GetFile (filePath);
                                    fileSize = file.Size;
                                } else {
                                    fileSize = $(this)[0].files[0].size;
                                }
                                var size = fileSize/1048576;
                                if(size>4){
                                    alert("The picture must not be greater than 4M");
                                    $(this)[0].value="";
                                    return
                                }
                                var name=$(this)[0].value;
                                var fileName = name.substring(name.lastIndexOf(".")+1).toLowerCase();
                                if(fileName !="jpg" && fileName !="jpeg" && fileName !="png" && fileName !="jfif" && fileName !="gif" ){
                                    alert("Please select the picture format file(jpg,jpeg,png,gif,jfif) upload");
                                    $(this)[0].value="";
                                    return
                                }
                                if($(this).val() != '' && $proPostImg.children(':file').length < 5){
                                    $proPostImg.children(':file').each(function(){
                                        if($(this).val() == ''){
                                            addTf = false;
                                            return false;
                                        }else{
                                            addTf = true;
                                        }
                                    });
                                }
                                if(addTf){
                                    $proPostImg.append('<input type="file" name="file[]" accept="image/pjpeg,image/jpeg,image/gif,image/png,image/jpg"/>');
                                }

                                e.stopPropagation();
                            });
                        });
					</script>
					<?php echo $captcha; ?>

					<div class="buttons clearfix">
						<div class="pull-right">
							<!--<button type="button" id="button-review" data-loading-text="<?php //echo $text_loading; ?>" class="btn btn-primary"><?php //echo $button_continue; ?></button>-->
							<button type="submit" class="btn btn-primary"><?php echo $button_continue; ?></button>
						</div>
					</div>

					<?php } else { ?>
					<?php echo $text_login; ?>
					<?php } ?>
				</form>

			</div>
		</dl>
		<?php } ?>
		<!--/产品评论-->
		<?php } ?>

	</div>
	<!--/属性组+FAQ+产品评论-->

	<?php if(false){ ?>
	<!--评论的内容-->
	<!--<div id="review"></div>-->
	<div class="pinglun">
		<div class="title">
			Reviews
			<div class="pingfen">
				<div class="d3">
					<!--平均分*20 值给width-->
					<div class="d1" style="width:<?php echo $reviewsratingStar; ?>%"></div>
					<div class="d2"></div>
				</div>
			</div>
			<p>
				<?php echo $reviewsratingNum;?>/5</p>
		</div>
		<!--评论，循环dd-->
		<div id="pinglunList">
			<span class="loading">loading...</span>
		</div>
		<div id="fyt_product" class="pagination"></div>
	</div>
	<!--/评论的内容-->
	<?php } ?>

	<?php if ($tags) { ?>
	<p>
		<?php echo $text_tags; ?>
		<?php for ($i = 0; $i < count($tags); $i++) { ?>
		<?php if ($i < (count($tags) - 1)) { ?>
		<a href="<?php echo $tags[$i]['href']; ?>">
			<?php echo $tags[$i]['tag']; ?>
		</a>,
		<?php } else { ?>
		<a href="<?php echo $tags[$i]['href']; ?>">
			<?php echo $tags[$i]['tag']; ?>
		</a>
		<?php } ?>
		<?php } ?>
	</p>
	<?php } ?>

	<?php echo $content_bottom; ?>
	<?php echo $column_right; ?>



</div>
<!--/jwx_productInfo-->

<div class="jwx_productCart" id="jwx_productCart">
	<div class="conter">
		<p class="p1">success</p>
		<p class="p2"><span class="pop-product-item-num"></span> added to your cart.</p>
		<a href="javascript:;" class="left continue-shopping-gtm">Continue Shopping</a>
		<a href="javascript:;" onclick="location='<?php echo $shopping_cart; ?>'" class="right go-to-cart-gtm">Go to Cart</a>
	</div>
</div>

<script type="text/javascript">
    <!--
    $('select[name=\'recurring_id\'], input[name="quantity"]').change(function() {
        $.ajax({
            url: 'index.php?route=product/product/getRecurringDescription',
            type: 'post',
            data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
            dataType: 'json',
            beforeSend: function() {
                $('#recurring-description').html('');
            },
            success: function(json) {
                $('.alert, .text-danger').remove();

                if(json['success']) {
                    $('#recurring-description').html(json['success']);
                }
            }
        });
    });
    //-->
</script>

<script type="text/javascript">
    <!--

    var product_id = "<?php echo $product_id; ?>";

    $('#button-cart').on('click', function() {
        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
            dataType: 'json',
            beforeSend: function() {
                $('#button-cart').button('loading');
            },
            complete: function() {
                $('#input-quantity').val('1');
//                $('#nums').html('1');
//                $('#button-cart').button('reset');
                $('#button-cart').html('CHECK OUT: <span id="nums">1</span> <span class="new-product-num-right">Item</span>');
                $('#button-cart').attr("disabled",false);
            },
            success: function(json) {
//                console.log(json);die;
                $('.alert, .text-danger').remove();
                $('.form-group').removeClass('has-error');

                if(json['error']) {
                    if(json['error']['option']) {
                        for(i in json['error']['option']) {
                            var element = $('#input-option' + i.replace('_', '-'));

                            if(element.parent().hasClass('input-group')) {
                                element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                            } else {
                                element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                            }
                        }
                    }

                    if(json['error']['recurring']) {
                        $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
                    }

                    // Highlight any found errors
                    $('.text-danger').parent().addClass('has-error');
                }

                if(json['success']) {

//                    console.log(json['success']);die;
                    $('#cart-num').html(parseInt($('#cart-num').html())+parseInt($('#input-quantity').val()));

                    $('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                    $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');

                    $('html, body').animate({
                        scrollTop: 0
                    }, 'slow');

                    $('#cart > ul').load('index.php?route=common/cart/info ul li');

                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
    //-->
</script>

<script type="text/javascript">
    <!--
    $('.date').datetimepicker({
        pickTime: false
    });

    $('.datetime').datetimepicker({
        pickDate: true,
        pickTime: true
    });

    $('.time').datetimepicker({
        pickDate: false
    });

    $('button[id^=\'button-upload\']').on('click', function() {
        var node = this;

        $('#form-upload').remove();

        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

        $('#form-upload input[name=\'file\']').trigger('click');

        if(typeof timer != 'undefined') {
            clearInterval(timer);
        }

        timer = setInterval(function() {
            if($('#form-upload input[name=\'file\']').val() != '') {
                clearInterval(timer);

                $.ajax({
                    url: 'index.php?route=tool/upload',
                    type: 'post',
                    dataType: 'json',
                    data: new FormData($('#form-upload')[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(node).button('loading');
                    },
                    complete: function() {
                        $(node).button('reset');
                    },
                    success: function(json) {
                        $('.text-danger').remove();

                        if(json['error']) {
                            $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                        }

                        if(json['success']) {
                            alert(json['success']);

                            $(node).parent().find('input').val(json['code']);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }, 500);
    });
    //-->
</script>

<script type="text/javascript">
    <!--
    $('#review').delegate('.pagination a', 'click', function(e) {
        e.preventDefault();

        $('#review').fadeOut('slow');

        $('#review').load(this.href);

        $('#review').fadeIn('slow');
    });
    function changeprice() {
        console.log('first');
//         alert($("#form-product").serialize());
//		alert('<?php echo $product_id; ?>'+',<?=$read_special?$read_special:0?>'+',<?php echo $read_price;?>');
        $.ajax({
            url: 'index.php?route=product/product/getprice&product_id=<?php echo $product_id; ?>&p=<?php echo $read_price;?>&s=<?=$read_special?$read_special:0?>',
            type: 'post',
            dataType: 'json',
            data: $("#form-product").serialize(),

            success: function(json) {
//                console.log(json);die;
                $('#money').html(json['html']);
            }
        });
    }
    changeprice();

    //$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

    //$('#button-review').on('click', function() {
    //	$.ajax({
    //		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
    //		type: 'post',
    //		dataType: 'json',
    //		data: $("#form-review").serialize(),
    //		beforeSend: function() {
    //			$('#button-review').button('loading');
    //		},
    //		complete: function() {
    //			$('#button-review').button('reset');
    //		},
    //		success: function(json) {
    //			$('.alert-success, .alert-danger').remove();
    //
    //			if (json['error']) {
    //				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
    //			}
    //
    //			if (json['success']) {
    //				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
    //
    //				$('input[name=\'name\']').val('');
    //				$('textarea[name=\'text\']').val('');
    //				$('input[name=\'rating\']:checked').prop('checked', false);
    //			}
    //		}
    //	});
    //});

    $(document).ready(function() {
        //询盘弹窗
        var $inquiry = $('#product-detail-inquiry');
        $inquiry.takyPopup({
            'width': 800,
            'height': 560,
            callback: function(pop) {
                var inquiryCont = '<div class="product-detail-inquiry-wrap">' +
                    '<section>' +
                    '<div class="product-detail-inquiry-title fixclea"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" width="75" height="75"  alt="<?php echo $heading_title; ?>" />' +
                    '<span><?php echo $heading_title;?></span>' +
                    '<input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id; ?>"/>' +
                    '<input type="hidden" id="product_model" name="product_model" value="<?php echo $model; ?>"/>' +
                    '</div>' +
                    '<div class="inquiry-info inquiry-info-username"><p class="req-before">Your Name:<b></b></p><input type="text" name="name" value="<?php echo $name; ?>" id="inquiry-username"/></div>' +
                    '<div class="inquiry-info inquiry-info-email"><p class="req-before">Your Email:<b></b></p><input type="text" name="email" value="<?php echo $email; ?>" id="inquiry-email"/></div>' +
                    '<div class="inquiry-info inquiry-info-tel"><p>Tel Number:</p><input type="text" name="fixed_line" id="inquiry-tel"/></div>' +
                    '<div class="inquiry-info inquiry-info-country"><p>Country:</p>' +
                    '<select name="country_id" id="inquiry-country">' +
                    '<option value="">Please Choose Your Country</option>' +
                    '<?php foreach ($countries as $country) { ?>' +
                    "<option value=\"<?php echo $country['country_id']; ?>\" <?php if($country['name']=='United States'){ ?>selected='selected'<?php } ?>><?php echo $country['name']; ?></option>" +
                    '<?php } ?>' +
                    '</select></div>' +
                    '<div class="inquiry-info"><p>Factime& iMesssage ID:</p><input type="text" name="phone" id="inquiry-phone"/></div>' +
                    '<div class="inquiry-info" style="margin-left:56px;"><p>Whatsapp ID:<b></b></p><input type="text" name="whatsapp" id="inquiry-whatsapp"/></div>' +
                    '<div class="inquiry-info-textarea"><p class="req-before">Content:<b></b></p>' +
                    '<textarea name="content" id="inquiry-content"></textarea></div>' +
                    '<button class="inquiry-info-btn inquiry-product-gtm">submit</button>' +
                    '</section>' +
                    '</div>';
                pop.find('.tips').append(inquiryCont);
                var $infoBtn = $('.inquiry-info-btn'),
                    $productId = $('#product_id'),
                    $uName = $('#inquiry-username'),
                    $uEmail = $('#inquiry-email'),
                    $uTel = $('#inquiry-tel'),
                    $uCountry = $('#inquiry-country'),
                    $uPhone = $('#inquiry-phone'),
                    $uWhatsapp = $('#inquiry-whatsapp'),
                    $uContent = $('#inquiry-content'),
                    $uNameTip = $('.inquiry-info-username b'),
                    $uEmailTip = $('.inquiry-info-email b'),
                    $uContentTip = $('.inquiry-info-textarea b');
                var clickTf = true;
                $infoBtn.on('click', function() {

                    if(clickTf){
                        clickTf = false;
                        var id = $productId.val(),
                            uName = $uName.val(),
                            uEmail = $uEmail.val(),
                            uTel = $uTel.val(),
                            uCountry = $uCountry.val(),
                            uPhone = $uPhone.val(),
                            uWhatsapp = $uWhatsapp.val(),
                            uContent = $uContent.val();

                        var pro_name = $('.product-detail-inquiry-title span').text();
                        var pro_model = $('#product_model').val();

                        $.ajax({
                            type: "post",
                            url: "index.php?route=product/product/addinquiry",
                            async: true,
                            dataType: 'json',
                            data: {
                                product_id: id,
                                name: uName,
                                email: uEmail,
                                fixed_line: uTel,
                                country_id: uCountry,
                                phone: uPhone,
                                whatsapp:uWhatsapp,
                                content: uContent,
                                pro_name:pro_name,
                                pro_model:pro_model
                            },
                            beforeSend: function(){
                                $('.loading').show();
                            },
                            success: function(res) {

                                $uNameTip.text('');
                                $uEmailTip.text('');
                                $uContentTip.text('');
                                if(res.code == 0) {
                                    clickTf = true;
                                    $uNameTip.text(res.data.error_name);
                                    $uEmailTip.text(res.data.error_email);
                                    $uContentTip.text(res.data.error_content);
                                    $('.loading').hide();
                                    alert(res.message);
                                }else{
                                    $('.popwrap,#popbox').remove();
                                    //alert("Submit successfully");
                                    location.href = '/information-company-success/';

                                }
                            }
                        });
                    }

                })
            }
        });

        //获取当前页面的color_id
        var current_color_id = "<?php echo $color_id; ?>";
        var a_color_id = 0;
        //遍历每个color_id
        $(".prodet_rul li").each(function() {
            a_color_id = $(this).find('a').attr('class');
            //相同,则添加clr样式
            if(a_color_id == current_color_id) {

                $(this).find('a').addClass('clr');
                $('.color-selec-txt').html($(this).find('img').attr('title'));
            }
        });
        $(".changduList ul").each(function() {
            var colorid = $(this).children(':first').attr("data-colorid");
            //判断选中的颜色和<li>的颜色值是否相同
            if(current_color_id == colorid) {
                var more = false;
                $(this).children('li').each(function() {
                    if($(this).css('display') == 'none'){
                        return more = true;
                    }
                });
                $(this).css('display', 'block');
                if(more){
                    $(this).next().show();
                }
            } else {
                $(this).css('display', 'none');
                $(this).next().hide();
            }
        });
        $('.thumbnails').magnificPopup({
            type: 'image',
            delegate: 'a',
            gallery: {
                enabled: true
            }
        });
        /*if($(".changdup").eq(0).children('li').length > 3) {
            $(".lengthgengduo").first().show();
            $(".changdup").addClass("changdupheigth");
        }*/

        $(".lengthgengduo").click(function() {
            $(this).prev().children('li').show();
            $(".lengthgengduo").hide();
        });

        var productInfo = jQuery("#jwx_productInfo2");
        if(productInfo.length > 0) {
            var ul = jQuery("#prdimglist");
            if(productInfo.find(".pra-list-ul li").length <= 4) {
                productInfo.find(".prdimgup").hide();
                productInfo.find(".prdimgdown").hide();
                productInfo.find(".highslide-gallery").attr("style", "margin-top:0 !important");
            } else {
                ul.attr("page", productInfo.find(".pra-list-ul li").length);
                var pageNums = productInfo.find(".pra-list-ul li").length;
                var top = 0; //计算ul距离顶部的绝对定位高度
                var t = function(f) {
                    if(f) {
                        if(ul.attr("page") < pageNums) {
                            var nowTop = parseInt(ul.find(".pra-list-ul").css("top"));
                            ul.attr("page", parseInt(ul.attr("page")) + 1);
                            top = nowTop + 118;
                        } else {
                            ul.attr("page", pageNums);
                            top = 0;
                        }
                    } else {
                        var scaleNum = 0;
                        if(parseInt(ul.attr("page")) > 4) {
                            ul.attr("page", parseInt(ul.attr("page")) - 1);
                            scaleNum = pageNums - parseInt(ul.attr("page"));
                            top = -(scaleNum * 118);
                        } else {
                            return false;
                        }
                    }
                    productInfo.find(".pra-list-ul").animate({
                        top: top
                    }, "fast");
                };

                /*修改结束*/
                productInfo.find(".prdimgup").click(function() {
                    t(1);
                });
                productInfo.find(".prdimgdown").click(function() {
                    t(0);
                });
            };
        }


        /*------轮播图-------*/
        if(parseInt('<?php echo count($popular_products); ?>')<=4){
            $('.ileft').hide();
            $('.iright').hide();
        }else{
            var oBox = $('#jwx_imgLb dd')[0];
            var oldUl = $('#jwx_imgLb dd .product_tabl_box');
            var oldaLi = $('#jwx_imgLb dd .product_tabl');
            var oPrev = $('#jwx_imgLb dd .ileft')[0];
            var oNext = $('#jwx_imgLb dd .iright')[0];
            var now = 0;
            oldUl.append([oldaLi.eq(0).clone(),oldaLi.eq(1).clone()]);
            var oUl = $('#jwx_imgLb dd .product_tabl_box')[0],
                aLi = $('#jwx_imgLb dd .product_tabl'),
                nWidth = aLi.innerWidth();
            oBox.timer = setInterval(fnNext, 5000);
            oBox.onmouseover=function(){
                clearInterval(oBox.timer);
            }
            oBox.onmouseout=function(){
                oBox.timer = setInterval(fnNext, 5000);
            }
            oNext.onclick=function(){
                if(!$(oUl).is(':animated')){
                    fnNext();
                }
            }
            oPrev.onclick=function(){
                if(!$(oUl).is(':animated')){
                    fnPrev();
                }

            }
        }


        function fnPrev(){
            now--;
            if(now<0){
                now = aLi.length-3;
                oUl.style.left = -nWidth*(now+1)+"px";
            }
            fnChange(now);
        }
        function fnNext(){
            now++;
            if(now>=aLi.length){
                now=2;
                oUl.style.left = -nWidth*(now-1)+"px";
            }
            fnChange(now);
        }
        function fnChange(now){
            $(oUl).stop().animate({'left':-1060*now+'px'},1200);
            //fnMove(oUl, {"left":-520*now});
        }
        /*var productLb = jQuery("#jwx_imgLb");
        if(productLb.length > 0) {
            if(productLb.find(".product_tabl li").length <= 4) {
                productLb.find(".ileft").hide();
                productLb.find(".iright").hide();
            } else {
                productLb.attr("page", 0);
                var t2 = function(f) {
                    if(f) {
                        if((productLb.find("li").length / 4) - parseInt(productLb.find("li").length / 4) > 0) {
                            productLb.attr("page") > 0 ? productLb.attr("page", parseInt(productLb.attr("page")) - 1) : productLb.attr("page", parseInt(productLb.find("li").length / 4));
                        } else {
                            productLb.attr("page") > 0 ? productLb.attr("page", parseInt(productLb.attr("page")) - 1) : productLb.attr("page", parseInt(productLb.find("li").length / 4) - 1);
                        }
                    } else {
                        if((productLb.find("li").length / 4) - parseInt(productLb.find("li").length / 4) > 0) {
                            productLb.attr("page") < parseInt(productLb.find("li").length / 4) ? productLb.attr("page", parseInt(productLb.attr("page")) + 1) : productLb.attr("page", 0);
                        } else {
                            productLb.attr("page") < (parseInt(productLb.find("li").length / 4) - 1) ? productLb.attr("page", parseInt(productLb.attr("page")) + 1) : productLb.attr("page", 0);
                        }
                    }
                    var left = -(productLb.attr("page") * 1060);
                    productLb.find(".product_tabl").animate({
                        left: left
                    }, "fast");
                }
                productLb.find(".ileft").click(function() {
                    t2(0);
                });
                productLb.find(".iright").click(function() {
                    t2(1);
                });
                setInterval(function() {
                    productLb.find(".ileft").click();
                }, 8000);
            };
        }*/

    });

    function updateQty(elm, type) {

        var $this = $(elm).parent().find("input"),
            div = $this.parents(".changduList"),
            size = 0;
        if(type == 1) {
            $this.val() > 0 ? $this.val($this.val() - 1) : "";
        } else {
            $this.val(parseInt($this.val()) + 1);
        }

        div.find("input").each(function() {
            size += parseInt($(this).val());
            if(size > 1){
                $('.new-product-num-right').text('ITEMS')
            }else{
                $('.new-product-num-right').text('ITEM')
            }
            $('#nums').text(size); //总个数
        });

        var em_size = 0;
        var em = $(".prodet_rig_color .clr").parent().find("em");
        $(elm).closest('.changdup').find('li').each(function() {
            if($(this).css('display') != 'none') {
                em_size += parseInt($(this).find('input').val());
                em.html(em_size);
            }
        });

        em_size == 0 ? em.css("display", "none") : em.css("display", "block");

    }

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


    $(".product_image video").on('ended', function () {
        $("#Rerun").show();
    });
    var myVideo=document.getElementById("audio");
    var Rerun=document.getElementById("Rerun");
    function playVid() {
        Rerun.style.display="none";
        myVideo.play();
    }

    function addToCart() {
        var shuju = [];
        $(".changduList li").each(function() {
            shuju.push($(this).attr("data-productid") + "-" + $(this).find("input").val());
        });

        var nums = $('#nums').text();
        if(nums < 1) {
            alert("Please select the product you want to buy!");
            return false;
        }else if(nums == 1){
            $('.pop-product-item-num').text('1 item');
        }
        if(nums > 1){
            $('.pop-product-item-num').text(nums+' items');
        }
        $("#jwx_productCart").show();

        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: {
                'shuju': shuju
            },
            dataType: 'json',
            beforeSend: function() {
                $('#button-cart').button('loading');
            },
//            complete: function() {
//                $('#button-cart').button('reset');
//            },
            success: function(json) {
                $('.alert, .text-danger').remove();
                $('.form-group').removeClass('has-error');

                if(json['error']) {
                    if(json['error']['option']) {
                        for(i in json['error']['option']) {
                            var element = $('#input-option' + i.replace('_', '-'));

                            if(element.parent().hasClass('input-group')) {
                                element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                            } else {
                                element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                            }
                        }
                    }

                    if(json['error']['recurring']) {
                        $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
                    }

                    // Highlight any found errors
                    $('.text-danger').parent().addClass('has-error');
                }

                if(json['success']) {
                    $('#nums').html('1');
                    $('#input-quantity').val('1');
//                    $('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                    $('#cart-num').html(parseInt($('#cart-num').html())+parseInt($('#input-quantity').val()));

                    $('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                    $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');

                    $('html, body').animate({
                        scrollTop: 0
                    }, 'slow');

                    $('#cart > ul').load('index.php?route=common/cart/info ul li');

//                    $('.a3').html("<span>" + json['total'] + "</span>"); //dyl add

                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });

    }
    $(".changduList ul").each(function() {

    });

    //根据颜色color_id,展示相应的长度
    function getProductAttr(color_id,that) {
        $(".changduList ul").each(function() {
            var colorid = $(this).children(':first').attr("data-colorid");
            //判断选中的颜色和<li>的颜色值是否相同
            if(color_id == colorid) {
                var more = false;
                $(this).children('li').each(function() {
                    if($(this).css('display') == 'none'){
                        return more = true;
                    }
                });
                $(this).css('display', 'block');
                if(more){
                    $(this).next().show();
                }
                $('.color-selec-txt').html($(that).find('img').attr('title'));
            } else {
                $(this).css('display', 'none');
                $(this).next().hide();
            }
        });

        //点击后添加或去除clr样式
        $(".prodet_rul li").click(function() {
            $(this).find('a').addClass('clr').closest('li').siblings().find('a').removeClass('clr');
        });

    }

    //-->
</script>
<?php echo $footer; ?>