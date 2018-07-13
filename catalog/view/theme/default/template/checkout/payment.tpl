<html dir="ltr" lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Payment</title>
<script src="/catalog/view/theme/default/js/jquery-1.11.2.min.js" type="text/javascript"></script>

</head>
<body>
 
<!--
<div class="wrapper">
  <div class="total_main" style="margin-top: 90px;">
	<div class="f_tac cart_flow"> <img src="catalog/view/theme/desktop/image/flow_3.jpg"> </div>
    <div class="payment_mian cf">
      <div class="payment_left">
        <p>You order has been placed successfully.</p>
        <p>Please make payment now.</p>
        <h4>Order Number: <span class="col_zs"><\?php echo $order['orderNo'];?></span></h4>
        <table width="400" cellspacing="0" cellpadding="0" border="0">
          <tbody>
           <\?php foreach ($totals as $total) { ?>
            <tr>
              <td><\?php echo $total['title']; ?></td>
              <td><\?php echo $total['text']; ?></td>
            </tr>
          <\?php } ?>
          </tbody>
        </table>
      </div>
      <div class="payment_right"> <img src="catalog/view/theme/desktop/image/paypal.png">
        <p>If you have PayPal account, please pay your order by PayPal account directly.</p>
        <p>If you don't have a paypal account, you can also pay via paypal with your credit card or bank debit card. Payment can be submitted in any currency!</p>
            
        <\?php echo $payment; ?>
          
      </div>
    </div>
  </div>
</div>
-->
<div style="width:500px; margin:300px auto; ">
	<p>
		<h4>You are being redirected to the PayPal website with payment</h4>
	</p>
	<p>
		<h2><img src="/catalog/view/theme/default/images/jwx_new/pay_loading.gif" /> Processing, Please wait</h2>
	</p>

</div>


<?php if($express_pay){ ?>
<script>
    location.href='<?php echo $express_url;?>';
</script> 
<?php } ?>

</body></html>