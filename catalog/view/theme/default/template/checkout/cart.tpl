<?php echo $header; ?>
<!--内容-->
		<div class="shopcart2 clearfix">
			<div class="content in_content shop2_content clearfix">
				<div class="top clearfix">
					<h1>SHOPPING CART</h1>
					<a href="<?php echo $url?>">Continue Shopping</a>
				</div>
				<form id="cart-form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
				<div class="shop2_text clearfix">
					<div class="left">
						<label for="" class="qx_label">
							<span>ALL</span>
							<input class="check_input" autocomplete="off" id="lang-checkbox-select-all" type="checkbox">
							<i class="check_i"></i>
							<!-- <input autocomplete="off" id="tfoot-checkbox-select-all" type="checkbox" class="check_i" > -->
						</label>
						<ul class="shop2_ul">
							 <?php foreach($products as $product){ ?>
							<li class="clearfix">
								<label for="" class="dx_label">
									 <input class="check_input" autocomplete="off" name="product" type="checkbox" value="<?php echo $product['cart_id']; ?>">
									 <i class="check_i"></i>
									<!-- <input autocomplete="off" name="product" type="checkbox" value="<?php echo $product['cart_id']; ?>" class="check_i" > -->
								</label>	
								<?php if ($product['thumb']) { ?>
									<div>
			                        <a href="<?php echo $product['href']; ?>">
			                   <img src="<?php echo $product['thumb']; ?>"  title="<?php echo $product['name']; ?>" class="pic_img" />
			                        </a>
			                        </div>
			                      <?php } ?>
								<!-- <div class="pic_img">
									<a href="###"><img src="img/jpg/pro_det1.jpg" alt="" /></a>
								</div> -->
								<div class="text">
									<a class="a_bt" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
									<p><span>Color:</span> Natural Black</p>
									<p>
									<?php if ($product['option']) { ?>                         
			                         <?php foreach ($product['option'] as $option) { ?>						  
			                          <p>
			                           <?php if( !empty($option['name']) ){ ?>
			                             <?php echo $option['name'].': '; ?><?php echo $option['value']; ?>
			                           <?php } ?> 
			                          </p>                        
			                         <?php } ?>                         
			                        <?php } ?>
			                        </p>
									<p><span>Commodity code:</span> xhs00245</p>
								</div>
								<div class="price clearfix">
									<!-- <p>$35.65<span>$35.65</span></p> -->
									<?php if($product['original_price']) { ?>
					                    <p class="price-new"><?php echo $product['price']; ?>
					                    <span><?php echo $product['original_price']; ?></span></p>
				                    <?php }else{ ?>
				                    	<p class="price-new"><?php echo $product['price']; ?></p>
				                    <?php } ?>
								</div>

								<!-- 商品总价 -->
								<td class="td-total"><?php echo $product['total']; ?></td>

								<div class="pre_div">
									<div class="num_div">
										<span class="sub" onclick="javascript:updateQty(this,1);"></span>
										<!-- <input class="num" type="text" value="1" /> -->
										<input type="text" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" onchange="updateQty(this,0);" />
										<span class="add" onclick="javascript:updateQty(this,2);"></span>
									</div>
								</div>
					<!-- <td class="td-qty fixclea">
						<!--<b>-</b><span>1</span><i>+</i>-->
                        
                      <!--   <a href="javascript:void(0);" class="icon_cart icon1" onclick="javascript:updateQty(this,1);">-</a>
                    <input type="text" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" onchange="updateQty(this,0);" />
                        <a href="javascript:void(0);" class="icon_cart icon2" onclick="javascript:updateQty(this,2);">+</a>
					</td> --> 
								<div class="close" onclick="javascript:cart_remove('<?php echo $product['cart_id']; ?>');"></div>
								<span class="wishlist">Move to Wishlist</span>
							</li>
							<?php } ?>
						</ul>
					</div>			
					<div class="right">
						<h2>SUMMARY</h2>			
						<?php foreach ($totals as $k => $total) {  if($total['title']!='Poundage'){?>
                       <?php if($total['title']=='Total') { ?>
                        <p class="p2"><?php echo $total['title']; ?> <span class="fr"><?php echo $total['text']; ?></span></p>
                        <?php }else{ ?>
                            <p class="p1"><?php echo $total['title']; ?> <span class="fr"><?php echo $total['text']; ?></span></p>
                        <?php } ?>
                    <?php } } ?>
						<div class="shop_search">
							<p>
								If you have coupons, please fill them out. If not, 
								please pay.
							</p>
							<label for="">
							<form id="discount-coupon-form" action="<?php echo $coupon_url; ?>" method="post">
								<!-- <input type="text" placeholder="coupon code"/> -->
								<!-- <button>CONFIRM</button> -->
								<input class="input-text form-control" id="coupon_code" name="coupon"  placeholder="coupon code">
								<button type="submit"   value="CONFIRM">CONFIRM</button>

							</form>
							</label>
						</div>
						<div class="btn">
							<a class="a_btn"  onclick="submitCart();">GO TO CHECK OUT&nbsp;&nbsp;&nbsp;></a>
							<!-- <button type="button" title="Proceed to Checkout" class="a_btn" >
				    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
				   PROCEED TO CHECKOUT</button> -->
						</div>
					</div>
				</div>
				</form>
				<div class="bot clearfix">
					<dl>
						<dt>Delivery dates</dt>
						<dd class="pc_dd">
							We ship by FedEx, DHL express and local express.<br />
							You can expect to get these items within <br />
							5-7 days. <a href="###">More information&nbsp;&nbsp;>></a>
						</dd>
						<dd class="yd_dd">
							Shopping on Hot Beauty Hair.com is safe and secure 
							- guaranteed!
						</dd>
						
					</dl>
					<dl>
						<dt>Satisfaction Guaranteed </dt>
						<dd>
							Hot Beauty Hair.com cares about your complete 
							satisfaction. We offer a comprehensive return policy 
							on all items, allowing you to shop with confidence.
						</dd>
					</dl>
					<dl>
						<dt>Privacy Policy</dt>
						<dd class="pc_dd">
							Hot Beauty Hair.com respects your privacy.<br />
							We do NOT share or in any way distribute 
							any personal, business or contact information 
							you may provide. <a href="###">See Our Return Policy&nbsp;&nbsp;>></a>
						</dd>
						<dd class="yd_dd">
							Hot Beauty Hair.com respects your privacy.We do NOT share 
							or in any way distribute any personal, business or contact 
							information you may provide.
						</dd>
					</dl>
				</div>	
			</div>
		</div>
<script>

	function submitCart() {
	    console.log('in');
        var chk_value = '';
        $("input:checkbox[name='product']:checked").each(function() { // 遍历name=test的多选框
            chk_value += $(this).val() + ',';  // 每一个被选中项的值
        });
        chk_value = chk_value.substring(0,chk_value.length-1);
//        alert(chk_value);die;
        window.location='index.php?route=checkout/checkout&cart_ids=' + chk_value;
    }
	function updateQty(obj,type){
	    var qty = 1;
	    switch(type){
	        case 0:
	            document.getElementById('cart-form').submit();
	            break;
	        case 1:
	            qty = $(obj).next('input[type="text"]').val() - 1;
	            if(qty == 0) return false;
	            $(obj).next('input[type="text"]').val(qty);
	            document.getElementById('cart-form').submit();
	            break;
	        case 2:
	            qty = parseInt($(obj).prev('input[type="text"]').val()) + 1;
	            $(obj).prev('input[type="text"]').val(qty);
	            document.getElementById('cart-form').submit();
	            break;
	    }
	    
	}
	function cart_remove(product_key){
	   if(confirm('Are you sure?')){
		  cart.remove(product_key);
	   }     
	}
	jQuery(function($){
		//var $btnJian = $('.cart-table .td-qty b'),
//			$btnAdd = $('.cart-table .td-qty i');
            //$btnRemove = $('.cart-table .td-del>div'),
			
		var	$seleAllTop = $('#lang-checkbox-select-all'),
			$seleAllBot = $('#tfoot-checkbox-select-all'),
			$checkbox = $('#cart_table :checkbox'),
			$btndel = $('.cart-tfoot .col-goods');
			
		//$btnJian.on('click',function(){
//			if($(this).next().text() > 1){
//				var newQty = $(this).next().text($(this).next().text()-1),
//					newTotal = newQty.text() * $(this).parent().next('.td-unit').text();
//				$(this).parent().nextAll('.td-total').text(newTotal.toFixed(2));
//			}
//		});
		//$btnAdd.on('click',function(){
//			//100000 -》应后台返回库存量
//			if($(this).prev().text() < 100000){
//				var newQty = $(this).prev().text(Number($(this).prev().text())+1),
//					newTotal = newQty.text() * $(this).parent().next('.td-unit').text();
//				$(this).parent().nextAll('.td-total').text(newTotal.toFixed(2));
//			}
//		});
		//$btnRemove.on('click',function(){
//			$(this).closest('tr').remove();
//		});

		$seleAllTop.click(function(){
			$checkbox.prop('checked',this.checked);
			$seleAllBot.prop('checked',this.checked);
		});
		$seleAllBot.click(function(){
			$checkbox.prop('checked',this.checked);
			$seleAllTop.prop('checked',this.checked);
		});
		$checkbox.click(function(){
			$seleAllTop.prop('checked',$checkbox.filter(':checked').length == $checkbox.length);
			$seleAllBot.prop('checked',$checkbox.filter(':checked').length == $checkbox.length);
		});
		$btndel.takyPopup({'width':390,'height':192,callback:function(pop){
			if($checkbox.filter(':checked').length != 0){
				var $title = $('<div/>').addClass('pop-content').html('Delect selected items'),
					$popYes = $('<button/>').addClass('pop-yes').text('YES'),
					$popNo = $('<button/>').addClass('pop-no').text('NO');
				pop.find('.tips').append([$title,$popYes,$popNo]);
				$popYes.click(function(e){
					var str = '';
					$('.popwrap,#popbox').remove();
					$seleAllTop.prop('checked',false);
					$seleAllBot.prop('checked',false);
					//$checkbox.filter(':checked').prop('checked',false).closest('tr').remove();
					$.each($checkbox.filter(':checked'),function(idx,ele){
						str += $(ele).val()+';';
					});
					str = str.replace(/;$/g, "");				
					cart.remove(str);
					$checkbox.filter(':checked').prop('checked',false);
					e.stopPropagation();
				});
				$popNo.click(function(e){
					$('.popwrap,#popbox').remove();
					e.stopPropagation();
				});
			}else{
				var $title = $('<div/>').addClass('pop-content').html('Please select the items and click  delete button'),
					$popYes = $('<button/>').addClass('pop-yes').text('YES');
				pop.find('.tips').append([$title,$popYes,$popNo]);
				$popYes.click(function(e){
					$('.popwrap,#popbox').remove();
					e.stopPropagation();
				});
			}
			
		}});
		
	});
	//搜索
	//收藏
		$(".wishlist").click(function(){
			var win = $(window).width();
			if(win>992){
				if($(this).hasClass("off")){
					$(this).removeClass("off");
					$(this).css("background","url(catalog/view/theme/default/img/png/shop_star.png) no-repeat left center").css("background-size","0.83vw 0.83vw").css("color","#666");
				}else{
					$(this).addClass("off");
					$(this).css("background","url(catalog/view/theme/default/img/png/shop_star_.png) no-repeat left center").css("background-size","0.83vw 0.83vw").css("color","#d5af74");
				}
			}else{
				if($(this).hasClass("off")){
					$(this).removeClass("off");
					$(this).css("background","url(catalog/view/theme/default/img/png/shop_star.png) no-repeat left center").css("background-size","0.16rem 0.16rem").css("color","#666");
				}else{
					$(this).addClass("off");
					$(this).css("background","url(catalog/view/theme/default/img/png/shop_star_.png) no-repeat left center").css("background-size","0.16rem 0.16rem").css("color","#d5af74");
				}
			}
			
		})
		$(".shop_search input").focus(function(){
			$(".shop_search button").css("display","block");
		})
		//全选
		$(".qx_label input").click(function(cart_id){
			if($(this).prop("checked")){
				$(this).siblings(".check_i").addClass("active");
				$(".dx_label input").each(function(){
					$(this).prop("checked",true);
					$(this).siblings(".check_i").addClass("active");
				})
			}else{
				$(this).siblings(".check_i").removeClass("active");
				$(".dx_label input").each(function(){
					$(this).prop("checked","");
					$(this).siblings(".check_i").removeClass("active");
				})
			}
		})
		//单选
		$(".dx_label input").click(function(cart_id){
			//alert($cart_id);
			if($(this).prop("checked")){
				$(this).siblings(".check_i").addClass("active");
				var len = $(".dx_label .check_i").length;
				var i=0;
				$(".dx_label .check_i").each(function(){
					if($(this).hasClass("active")){
						i++
					}
					return i;
				})
				if(i>=len){
					$(".qx_label input").prop("checked",true);
					$(".qx_label .check_i").addClass("active");
				}
				
			}else{
				$(this).siblings(".check_i").removeClass("active");
				$(".qx_label .check_i").removeClass("active");
				$(".qx_label input").prop("checked","");
			}
		})


</script>
<?php echo $footer; ?>