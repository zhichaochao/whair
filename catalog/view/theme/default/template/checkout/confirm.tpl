<?php if (!isset($redirect)) { ?>
  <h2>SUMMARY</h2>
                    <ul class="cart_ul">
                     <?php foreach ($products as $product) { ?>
                        <li class="clearfix">
                            <a href="<?php echo $product['href']; ?>">
                                <div class="pic_img">
                                    <img src="<?php echo $product['image']; ?>" />
                                </div>
                                <div class="text">
                                    <h2><?php echo $product['name']; ?></h2>
                                    <p>  
                                        <?php foreach ($product['option'] as $option) { ?>
                                            <?php echo $option['value']; ?>
                                        <?php } ?>
                                        <?php if($product['recurring']) { ?>
                                         <?php echo $product['recurring']; ?>
                                        <?php } ?>
                            
                                     </p>
                                     <span>  <?php echo $product['price']; ?></span>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                         <?php foreach ($vouchers as $voucher) { ?>
                         <?php echo $voucher['description']; ?>1<?php echo $voucher['amount']; ?>
                        <?php } ?>
                   
                    </ul>
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
                        <label >
                            <input type="text"  id="coupon_code" name="coupon" value="<?php echo @$coupon; ?>" placeholder="coupon code"/>
                            <button  onclick="coupon_code(this)">CONFIRM</button>
                        </label>
                    </div>
                    <div class="btn">
                        <a class="a_btn" href="<?=$checkout_url;?>">GO TO CHECK OUT&nbsp;&nbsp;&nbsp;&gt;</a>
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
