<?php echo $header; ?>


    <!--内容-->
        <div class="address clearfix">
            <div class="content in_content address_content clearfix">
                
                <div class="left clearfix">
                    <ol class="top_ol liucheng ol_1  clearfix">
                        <li class="active">
                            <img src="/catalog/view/theme/default/img/png/express.png" alt="" />
                            <span></span>
                            <p>1.Shipping</p>
                            <em class="emr"></em>
                        </li>
                        <li>
                            <img src="/catalog/view/theme/default/img/png/express.png" alt="" />
                            <span></span>
                            <p>2.Payment</p>
                            <em class="eml"></em>
                            <em class="emr"></em>
                        </li>
                        <li>
                            <img src="/catalog/view/theme/default/img/png/express.png" alt="" />
                            <span></span>
                            <p>3.Deliver</p>
                            <em class="eml"></em>
                        </li>
                    </ol>
                    
                    <div class="text clearfix" >
                        <input id="same_as_shipping" name="same_as_shipping" value="1"  type="hidden">
                        <div class="payment_next bg_gif" id="payment_next" >
                        <div class="shipping_address bg_fff bg_gif" id="shipping_address">
                            <h2>Select the shipping address</h2>
                     
                        </div>
                        <div class="shipping_method bg_fff bg_gif" id="shipping_method">
                            <h3>Shipping Method</h3>
                        </div>
                        </div>
                    </div>
                    
                </div>
            
                <div class="right clearfix right_shop  bg_gif">
                    <div class="collapse-checkout bg_fff" id='collapse-checkout-confirm'><h2>SUMMARY</h2></div>
                  
                </div>
            
            </div>
        </div>

<script type="text/javascript">
    $(function(){
        //单选
        $(".dx_label input").click(function(){
            if($(this).prop("checked")){
                $(this).siblings(".check_i").addClass("active");
                
            }else{
                $(this).siblings(".check_i").removeClass("active");
            }
        })
        
        $(".address_ul>li").click(function(){
            $(this).addClass("active").siblings("li").removeClass("active");
        })
        
        //搜索
        $(".shop_search input").focus(function(){
            $(".shop_search button").css("display","block");
        })
    })
</script>
        
<script type="text/javascript"><!--


$(document).ready(function() {
    getShippingAddress();
    
  
});



// Get Shipping Address
function getShippingAddress(address_id)
{

    $.ajax({
        url: 'index.php?route=checkout/shipping_address&address_id='+address_id,
        dataType: 'html',
        success: function(html) {
            $('#shipping_address').html(html);
        $('.address_ul li').removeClass('active');
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
        getShippingMethod();
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
     $('#payment_next').html('<h2>3.Select a payment method</h2>');
    $.ajax({
        url: 'index.php?route=checkout/payment_method',
        dataType: 'html',
        success: function(html) {
            $('#payment_next').html(html);
            $('.liucheng').removeClass('ol_2').addClass('ol_2');
            $('.address').addClass('pay');
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