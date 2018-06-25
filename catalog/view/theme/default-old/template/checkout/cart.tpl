<?php echo $header; ?>
<section class="content-wrap">
	<div class="cart-finger">
		<div class="cart-finger-pic">
			<div class="cart-finger-now">
				<i class="fa fa-shopping-cart" aria-hidden="true"></i>
			</div>
		</div>
		<div class="cart-finger-dec">
			<ul class="fixclea">
				<li class="act">
					<b>1</b> Shopping Cart
				</li>
				<li class="in-block">
					<b>2</b> Shipping
				</li>
				<li class="in-block">
					<b>3</b> Place Order
				</li>
				<li class="in-block">
					<b>4</b> Payment
				</li>
			</ul>
		</div>
	</div>
</section>

<?php if ($attention) { ?>
<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $attention; ?>
<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php } ?>

<?php if ($success && !$error_warning) { ?>
<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php } ?>

<?php if ($error_warning) { ?>
<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php } ?>

<article class="content-wrap fixclea">
	<section class="cart-table fl-left">
		<div id="active-cart-thead" class="mod mod-thead">
			<div class="content">
				<ul class="list-inline">
					<li class="col-opt">
						<span class="lang-checkbox">
                          <input autocomplete="off" id="lang-checkbox-select-all" type="checkbox">
                          <label for="lang-checkbox-select-all"></label>
                        </span>
						<label for="lang-checkbox-select-all">all</label>
					</li>
					<li class="col-goods">Image</li>
					<li class="col-quantity">Product Name</li>
					<li class="col-unitprice">Qty</li>
					<li class="col-rebate">Unit Price</li>
					<li class="col-amount">Subtotal</li>
				</ul>
			</div>
		</div>
        
        <form id="cart-form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
		<table id="cart_table">
			<tbody>
                <?php foreach($products as $product){ ?>
				<tr>
					<td class="td-checkbox">
						<span class="lang-checkbox">
                            <input autocomplete="off" name="product" type="checkbox" value="<?php echo $product['cart_id']; ?>">
                        </span>
					</td>
					<td class="td-goods">
                      <?php if ($product['thumb']) { ?>
						<div>
                        <a href="<?php echo $product['href']; ?>">
                   <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" />
                        </a>
                        </div>
                      <?php } ?>
					</td>
					<td class="td-quantity">
						<h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                        
                        <?php if ($product['option']) { ?>                         
                         <?php foreach ($product['option'] as $option) { ?>						  
                          <p>
                           <?php if( !empty($option['name']) ){ ?>
                             <?php echo $option['name'].': '; ?><?php echo $option['value']; ?>
                           <?php } ?> 
                          </p>                        
                         <?php } ?>                         
                        <?php } ?>                        
					</td>
					<td class="td-qty fixclea">
						<!--<b>-</b><span>1</span><i>+</i>-->
                        
                        <a href="javascript:void(0);" class="icon_cart icon1" onclick="javascript:updateQty(this,1);">-</a>
                    <input type="text" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" onchange="updateQty(this,0);" />
                        <a href="javascript:void(0);" class="icon_cart icon2" onclick="javascript:updateQty(this,2);">+</a>
					</td>
					<td class="td-unit">
						<?php if($product['original_price']) { ?>
		                    <span class="price-new"><?php echo $product['price']; ?></span>
		                    <del class="price-old"><?php echo $product['original_price']; ?></del>
	                    <?php }else{ ?>
	                    	<span class="price-new"><?php echo $product['price']; ?></span>
	                    <?php } ?>
					</td>
					<td class="td-total"><?php echo $product['total']; ?></td>
					<!--<td class="td-del" onclick="cart.remove('');">-->
                    <td class="td-del" onclick="javascript:cart_remove('<?php echo $product['cart_id']; ?>');">
						<div></div>
					</td>
				</tr>
                <?php } ?>
			</tbody>
		</table>
        </form>
        
		<div id="active-cart-tfoot" class="cart-tfoot">
			<div class="content">
				<ul class="list-inline">
					<li class="col-opt">
						<span class="lang-checkbox">
                           <input autocomplete="off" id="tfoot-checkbox-select-all" type="checkbox">
                           <label for="tfoot-checkbox-select-all"></label>
                        </span>
						<label for="tfoot-checkbox-select-all">all</label>
					</li>
					<li class="delete">delete</li>
				</ul>
			</div>
		</div>
		<div class="coupon-check fixclea">
		<div class="fl-left">
			<div id="check_coupon">
				<form id="discount-coupon-form" action="<?php echo $coupon_url; ?>" method="post">
					<div class="discount">
						<div class="discount-form">
							<div class="input-box">
							 <label for="coupon_code">
                                <h4>Coupon Code</h4>
                                <span>Enter your coupon code if you have one.</span>
                             </label> 
                             <input class="input-text form-control" id="coupon_code" name="coupon" value="<?php echo @$coupon; ?>">
						     <button type="submit" title="Apply Coupon" class="button-coupon-gtm" value="Apply Coupon"><?php echo empty($coupon)?'APPLY COUPON':'CANCEL COUPON'; ?></button>
                             <div>
                             	<a href="<?php echo $continue; ?>" class="continueshopping continue-shopping-gtm">&lt; &lt; <span>Continue Shopping</span></a>
                             </div>
                             
                            </div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="fl-right coupon-check-right">
			<ul class="coupon-check-price">
                <?php foreach ($totals as $total) { ?>
                <li class="<?php if($total['title']=='Total'){ ?>grand<?php }else{ ?>subtotal<?php } ?> fixclea">
		            <span><?php echo $total['title']; ?></span>
		            <i><?php echo $total['text']; ?></i>
		        </li>
                <?php } ?>
			</ul>
			<ul class="checkout-types">
				<li class="cart-checkout-metdod"> <button type="button" title="Proceed to Checkout" class="cart-to-checkout-gtm btn-checkout checkout-gtm" onclick="submitCart();">
				    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
				    &ensp;&ensp;&ensp;PROCEED TO CHECKOUT</button>
				</li>
				<li class="cart-checkout-metdod1">
                    <a class="paypal-gtm" id="ec_shortcut_e323c519df578caa83f14382f362301b" href="<?php echo $paypal_checkout; ?>"><img class="right checkout-paypalexpress-gtm" alt="Checkout with PayPal" src="/catalog/view/theme/default/images/tzx/cart/check_out.png"></a>
				</li>
			</ul>
		</div>
	</div>
	</section>
	<aside class="cart-table-aside fl-right">
		<dl>
			<dt>SHOP WITH CONFIDENCE</dt>
			<dd>Shopping on Hot Beauty Hair.com is safe and secure - guaranteed!</dd>
			<dd style="text-align: center;margin-top: 10px;">
				<img src="/catalog/view/theme/default/images/tzx/cart/paypal.png">
				
			</dd>
			<dd style="text-align: center;margin: 20px 0 30px;">
				<img src="/catalog/view/theme/default/images/tzx/cart/comodo_secure.png">
			</dd>
		</dl>
		<dl>
			<dt>SATISFACTION GUARANTEED</dt>
			<dd>Hot Beauty Hair.com cares about your complete satisfaction. We offer a comprehensive return policy on all items, allowing you to shop with confidence.</dd>
			<dd>
				<a href="javascript:;">See Our Return Policy &gt;&gt;</a>
			</dd>
		</dl>
		<dl>
			<dt>PRIVACY POLICY</dt>
			<dd>Hot Beauty Hair.com respects your privacy.We do NOT share or in any way distribute any personal, business or contact information you may provide.</dd>
			<dd>
				<a href="javascript:;">See Our Privacy Policy &gt;&gt;</a>
			</dd>
		</dl>
	</aside>
</article>
<article class="content-wrap">
	
	
</article>
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
</script>
<?php echo $footer; ?>