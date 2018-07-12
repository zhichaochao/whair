<?php echo $header; ?>

<link href="catalog/view/theme/default/stylesheet/checkout/checkout.css" rel="stylesheet">
<script type="text/javascript" src="catalog/view/theme/default/js/select2/js/select2.min.js"></script>
<link href="catalog/view/theme/default/js/select2/css/select2.min.css" rel="stylesheet"/>
<div class="pt10">

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

</div>

<section class="content-wrap">
    <div class="new-checkout-main-wrap">
        <div id="error-confirm"></div>
        <section class="new-checkout-pay-address">
            <h4 class="new-checkout-s-title">Billing Address</h4>
            <div id="collapse-payment-address">
                <div class="panel-body"></div>
            </div>
      
        </section>
        <section class="new-checkout-ship-address">
            <h4 class="new-checkout-s-title">Shipping Address</h4>
            <div id="collapse-shipping-address">
                <div class="panel-body"></div>
            </div>
      
        </section>
        <section class="new-checkout-ship-method" style="display:none;">
            <h4 class="new-checkout-s-title">Shipping Method</h4>

            <div id="collapse-shipping-method">
                <div class="panel-body"></div>
            </div>

        </section>
        <section class="new-checkout-pay-method" style="display:none;">
            <h4 class="new-checkout-s-title">Payment Method</h4>

            <div id="collapse-payment-method">
                <div class="panel-body"></div>
            </div>
            
        </section>
        
        <section class="new-checkout-rew-order fixclea">
            <h4 class="new-checkout-s-title">Review Your Order</h4>
            <div id="collapse-checkout-confirm"></div>
        </section>
        
    </div>
</section>

<script type="text/javascript"><!--

var checkPAStatus = 1; // use in confirm.tpl when submit
var checkSAStatus = 1; // use in confirm.tpl when submit

$(document).ready(function() {
    getPaymentAddress();
});

// Get Payment Address
function getPaymentAddress()
{
    $.ajax({
        url: 'index.php?route=checkout/payment_address',
        dataType: 'html',
        success: function(html) {
            $('#collapse-payment-address .panel-body').html(html);
            getShippingAddress();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

// Get Shipping Address
function getShippingAddress(address_id)
{
    $.ajax({
        url: 'index.php?route=checkout/shipping_address&address_id='+address_id,
        dataType: 'html',
        success: function(html) {
            $('#collapse-shipping-address .panel-body').html(html);
            getShippingMethod();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

// Get Shipping Method
function getShippingMethod()
{
    $.ajax({
        url: 'index.php?route=checkout/shipping_method',
        dataType: 'html',
        success: function(html) {
            $('#collapse-shipping-method .panel-body').html(html);
            getPaymentMethod();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

// Get Payment Method
function getPaymentMethod()
{
    $.ajax({
        url: 'index.php?route=checkout/payment_method',
        dataType: 'html',
        success: function(html) {
            $('#collapse-payment-method .panel-body').html(html);
            getOrder();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

// Get Order Info
function getOrder(){
    $.ajax({
        url: 'index.php?route=checkout/confirm',
        dataType: 'html',
        success: function(html) {
            $('#collapse-checkout-confirm').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

//--></script>

<?php echo $footer; ?>