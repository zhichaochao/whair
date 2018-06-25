<?php echo $header; ?>

<link href="catalog/view/theme/default/stylesheet/checkout/view_order.css" rel="stylesheet">
<section class="content-wrap">
	<div class="cart-finger">
        <div class="cart-finger-pic">
            <div class="cart-finger-now cart-finger-now-2">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </div>
        </div>
        <div class="cart-finger-dec">
            <ul class="fixclea">
                <li>
					<b>1</b> Shopping Cart
				</li>
				<li class="in-block">
					<b>2</b> Shipping
				</li>
				<li class="in-block act">
					<b>3</b> Place Order
				</li>
				<li class="in-block">
					<b>4</b> Payment
				</li>
            </ul>
        </div>
    </div>
    <div class="payment_mian fixclea">
      <div class="payment_left">
        <p>You order has been placed successfully.</p>
        <p>Please make payment NOW.</p>
        <h4>Order Number: <span class="col_zs"><?php echo $order['order_no']; ?></span></h4>
        <table width="400" cellspacing="0" cellpadding="0" border="0">
            <tbody>
            <?php if(is_array($totals)) foreach ($totals as $total) { ?>
                <tr>
                    <td><?php echo $total['title']; ?></td>
                    <td><?php echo $total['value']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
      </div>
      <?php if ($payment_method_code == 'pp_express') { ?>
        <div class="payment_right"> <img src="/catalog/view/theme/default/images/tzx/view_order/paypal.png">
        <p>If you have PayPal account, please pay your order by PayPal account directly.</p>
        <p>If you don't have a paypal account, you can also pay via paypal with your credit card or bank debit card. Payment can be submitted in any currency!</p>
            
        <form action="<?php echo $payment; ?>" method="post">
          <p class="p3">
            <button type="submit" value="Confirm Order"><i class="fa fa-lock"></i>CHECKOUT</button>
          </p>
        </form>
          
      </div>
      <?php } else { ?>
        <div class="payment_right"> <img src="<?php echo $payment_method_image; ?>">
        
            <table width="475" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <?php foreach($payment_method_attributes as $attribute) { ?>
                    <tr>
                        <td><?php echo $attribute['text']; ?></td>
                        <td><?php echo $attribute['value']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <p><font style="font-weight:bold;color:#000;">Notice:</font> After you completed the payment with bank, please kindly contact your sale and provide the payment receipt.</p>
        </div>
    <?php } ?>
</section>

<?php echo $footer; ?>