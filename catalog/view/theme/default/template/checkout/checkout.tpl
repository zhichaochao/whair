<?php echo $header; ?>


    <!--内容-->
        <div class="address clearfix">
            <div class="content in_content address_content clearfix">
                
                <div class="left clearfix">
                    <ol class="top_ol liucheng clearfix">
                        <li class="active">
                            <img src="img/png/express.png" alt="" />
                            <span></span>
                            <p>1.Shipping</p>
                            <em class="emr"></em>
                        </li>
                        <li>
                            <img src="img/png/express.png" alt="" />
                            <span></span>
                            <p>2.Payment</p>
                            <em class="eml"></em>
                            <em class="emr"></em>
                        </li>
                        <li>
                            <img src="img/png/express.png" alt="" />
                            <span></span>
                            <p>3.Deliver</p>
                            <em class="eml"></em>
                        </li>
                    </ol>
                    
                    <div class="text clearfix" >
                        <input id="same_as_shipping" name="same_as_shipping" value="1"  type="hidden">
                        <div class="payment_next" id="payment_next" >
                        <div class="shipping_address" id="shipping_address">
                     
                        </div>
                        <div class="shipping_method" id="shipping_method">
                       
                        </div>
                        </div>
                    </div>
                    
                </div>
            
                <div class="right clearfix">
                    <div class="collapse-checkout" id='collapse-checkout-confirm'></div>
                  
                </div>
            
            </div>
        </div>


<script type="text/javascript"><!--

var checkPAStatus = 1; // use in confirm.tpl when submit
var checkSAStatus = 1; // use in confirm.tpl when submit

$(document).ready(function() {
    getShippingAddress();
        getShippingMethod();
  
});



// Get Shipping Address
function getShippingAddress(address_id)
{
    $.ajax({
        url: 'index.php?route=checkout/shipping_address&address_id='+address_id,
        dataType: 'html',
        success: function(html) {
            $('#shipping_address').html(html);
    
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
            $('#shipping_method').html(html);
            getOrder();
          
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
            $('#payment_next').html(html);
            getOrder();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

// Get Order Info
function getOrder(){
//    console.log();
    $.ajax({
        url: 'index.php?route=checkout/confirm&cart_ids=' + "<?php echo $cart_ids ?>",
        dataType: 'html',
        success: function(html) {
//            console.log(html);die;
            $('#collapse-checkout-confirm').html(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

//--></script>

<?php echo $footer; ?>