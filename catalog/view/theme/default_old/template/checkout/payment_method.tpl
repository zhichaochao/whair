<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
	<table class="new-checkout-ship-method-table" border="0" cellspacing="0" cellpadding="0">
  		<tr class="ship-method-table-tr">
          <th>Payment Method</th>
          <th>Payment Cost</th>
      </tr>
  			
  <?php foreach ($payment_methods as $payment_method) { ?>
  	<tr class="ship-method-table-tr">
  	<td>

  <input type="hidden" name="is_paypal_creditcard" id="is_paypal_creditcard" value="<?php echo $is_paypal_creditcard; ?>"/>
  <div class="radio">
    <label>
      
      <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" <?php if ($payment_method['code'] == $code) { ?>checked="checked"<?php } ?> onclick="changePayment(0, this)" />

      <?php if($payment_method['code'] == 'pp_express'){ ?>
      <img src="/catalog/view/theme/default/image/paypal_img.gif" />

      <?php } else { ?>
        <?php if (isset($payment_method['image']) && !empty($payment_method['image'])) { ?>
          <img src="<?php echo $payment_method['image']; ?>"/>
        <?php } else { ?>
          <?php echo $payment_method['title']; ?>
        <?php } ?>
      <?php } ?>
    </label>
  </div>
  </td>
  
  	<?php if(isset($payment_method['text'])) { ?>
  		<td>
        <?php echo $payment_method['text']; ?>
    	</td>
      <?php } ?>
	
  <?php if($payment_method['code'] == 'pp_express'){ ?>
  </tr>
  <tr class="ship-method-table-tr">
  	<td>
  <div class="radio">
    <label>
       <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" 
       <?php if ($is_paypal_creditcard == 1) { ?>checked="checked"<?php } ?> onclick="changePayment(1, this)" />
       <img src="/catalog/view/theme/default/image/ppguest_1.gif" />
       <span style="color:gray;">Processed by 
          <span style="color:#000;font-weight:700;">PayPal</span>&nbsp;&nbsp;&nbsp;&nbsp;
          
        </span>
    </label>
 </div>
 </td>
    <?php if(isset($payment_method['text'])) { ?>
    	<td>
			 	<?php echo $payment_method['text']; ?>
			 </td>
    <?php } ?>
 
  <?php } ?>
</tr>
  <?php } ?>
  	
  	</table>
<?php } ?>

<script type="text/javascript"><!--

function changePayment(flag, e){
    $('#is_paypal_creditcard').val(flag);
    savePaymentMethod(e);
}

// Save savePayment Method
function savePaymentMethod(e) {
    $.ajax({
        url: 'index.php?route=checkout/payment_method/save',
        type: 'post',
        data: $('#collapse-payment-method input[type=\'radio\']:checked, #collapse-payment-method input[type=\'hidden\']'),
        dataType: 'json',
        beforeSend: function() {
            $(e).button('loading');
        },
        success: function(json) {
            $('#collapse-payment-method .alert, #collapse-payment-method .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#collapse-payment-method .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                // Highlight any found errors
                $('.text-danger').parent().parent().addClass('has-error');
            } else {
              getOrder();
            }
            $(e).button('reset');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

//--></script>