<?php if (!isset($redirect)) { ?>

<div>
    <table class="new-checkout-rew-order-table" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Free Shipping</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product) { ?>
            <tr>
                <td><a href="<?php echo $product['href']; ?>"><image height=90 src="<?php echo $product['image']; ?>" /></a></td>
                <td class="new-checkout-rew-order-name">
                    <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                    <div class="rew-order-name-bot">
                    <?php foreach ($product['option'] as $option) { ?>
                        <p><?php echo $option['name']; ?>: <span><?php echo $option['value']; ?></span></p>
                    <?php } ?>
                    <?php if($product['recurring']) { ?>
                        <p><?php echo $text_recurring_item; ?>: <span><?php echo $product['recurring']; ?></span></p>
                    <?php } ?>
                    </div>
                </td>
                <td>
                    <?php if($product['free_postage']) { ?>
                        YES
                    <?php } else { ?>
                        NO
                    <?php } ?>
                </td>
                <td><?php echo $product['quantity']; ?></td>
                <td class="new-checkout-rew-order-price">
                    <?php echo $product['price']; ?>
                    <?php if(!empty($product['original_price'])){ ?>
                    <del><?php echo $product['original_price']; ?></del>
                    <?php } ?>
                </td>
                <td class="new-checkout-rew-order-total"><?php echo $product['total']; ?></td>
            </tr>
        <?php } ?>
        <?php foreach ($vouchers as $voucher) { ?>
            <tr>
                <td class="text-left"><?php echo $voucher['description']; ?></td>
                <td class="text-left"></td>
                <td class="text-right">1</td>
                <td class="text-right"><?php echo $voucher['amount']; ?></td>
                <td class="text-right"><?php echo $voucher['amount']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<div class="new-checkout-bot fixclea">
	<div class="new-checkout-bot-left">
	    <div class="new-checkout-extra-info">
	        <h4>Any Extra Info</h4>
	        <textarea id="comment" name="comment" placeholder="Optional: Tell the seller your special requirements..."><?php echo $comment; ?></textarea>
	    </div>
	    <div class="new-checkout-bot-code" id="new-checkout-bot-code">

			<?php if (!empty($success)) { ?>
			<div class="alert alert-success" style="width:650px;display:inline-block;"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
			<?php } ?>
			
	        <label>Coupon Code:&ensp;&ensp;<input type="text" id="coupon_code" name="coupon" value="<?php echo @$coupon; ?>" /></label>
	        <button onclick="coupon_code(this)"><?php echo empty($coupon)?'APPLY':'CANCEL'; ?></button>
	        <p>Enter your coupon code if you have one.</p>
	    </div>
	</div>
	
	
	<div class="new-checkout-bot-right">
	    <ul>
	    <?php foreach ($totals as $total) { ?>
	        <li class="fixclea">
	            <span><?php echo $total['title']; ?></span>
	            <span><?php echo $total['text']; ?></span>
	        </li>
	    <?php } ?>
	    </ul>
	    <button class="new-continue-checkout" onclick="checkout(this)">CONTINUE CHECKOUT</button>
	</div>
</div>

<?php } else { ?>
<script type="text/javascript"><!--
location = '<?php echo $redirect; ?>';
//--></script>
<?php } ?>

<script type="text/javascript"><!--

// coupon code
function coupon_code(e) {
    $.ajax({
        url: 'index.php?route=extension/total/coupon/jcoupon',
        type: 'post',
        data: $('input#coupon_code, #comment'),
        dataType: 'json',
        beforeSend: function() {
            $(e).button('loading');
        },
        success: function(json) {
            $('#collapse-checkout-confirm .alert, #collapse-checkout-confirm .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']) {
                    $('#new-checkout-bot-code').prepend('<div class="alert alert-danger" style="width:650px;display:inline-block;"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                // Highlight any found errors
                $('.text-danger').parent().parent().addClass('has-error');
                $(e).button('reset');
            } else {
                getOrder();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

// checkout order
function checkout(e) {
    if(!checkPAStatus || !checkSAStatus){
        if(typeof($('.alert, .text-danger').offset())=="object"){
            $(window).scrollTop($('.alert, .text-danger').offset().top-50);
        }else{
            $(window).scrollTop(0);
        }
        return false;
    }
    $.ajax({
        url: 'index.php?route=<?php echo $payment_type=="Express" ? "extension/payment/pp_express/expressComplete" : "checkout/confirm/save"; ?>&cart_ids=<?php echo $cart_ids ?>',
        type: 'post',
        data: $('#collapse-checkout-confirm textarea'),
        dataType: 'json',
        beforeSend: function() {
            $(e).button('loading');$('.loading').show();
        },
        success: function(json) {
            $('#collapse-checkout-confirm .alert, #collapse-checkout-confirm .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#error-confirm').html('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                // Highlight any found errors
                $('.text-danger').parent().parent().addClass('has-error');
                $(e).button('reset');$('.loading').hide();
                $(window).scrollTop(0);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

//--></script>
