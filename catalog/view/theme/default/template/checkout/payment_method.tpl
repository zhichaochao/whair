<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>

  <div class="bg_fff" id='collapse-payment-method'>
              <h2>3.Select a payment method</h2>
                <input type="hidden" name="is_paypal_creditcard" id="is_paypal_creditcard" value="<?php echo $is_paypal_creditcard; ?>"/>
                <p class="ts" style="display: block;">Click “save and continue” to make paypal payments</p>
                <p class="jg" id="ts_jg"><span>i</span>Please choose the payment method</p>
              <ol class="pay_ol">

                 <?php foreach ($payment_methods as $payment_method) { ?>
       
                <li class="clearfix">
                  <input class="pay_dx"   type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" onclick="changePayment(0, this)" />

              <?php if($payment_method['code'] == 'pp_express'){ ?>
                <img src="/catalog/view/theme/default/image/paypal_img.gif" />

                <?php } else { ?>
                  <?php if (isset($payment_method['image']) && !empty($payment_method['image'])) { ?>
                    <img src="<?php echo $payment_method['image']; ?>"/>     <span>   <?php echo $payment_method['title']; ?></span>
                  <?php } else { ?>
                 <i>   <?php echo $payment_method['title']; ?></i>
                  <?php } ?>
                <?php } ?>
           
                </li>
                  <?php if($payment_method['code'] == 'pp_express'){ ?>
                  <li class="clearfix">
                  <input class="pay_dx"    type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" 
 onclick="changePayment(1, this)" />
                 <img src="/catalog/view/theme/default/image/ppguest_1.gif" />
                  <span>Processed by 
          <span style="color:#000;font-weight:700;">PayPal</span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </li>
                    <?php } ?>
              <?php } ?>
              </ol>
            </div>
            
            <a class="btn240" onclick="checkout()" >SAVW AND CONTINUE &nbsp;&nbsp;&nbsp;></a>



 
<?php } ?>
 <a  href="<?=$checkout;?>">Previous Step&nbsp;&nbsp;&nbsp;></a>

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
 
        success: function(json) {
            $('#collapse-payment-method .alert, #collapse-payment-method .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#ts_jg').html(json['error']['warning'] );
                }
                // Highlight any found errors
             
            } else {
              getOrder();
            }
      
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

//--></script>