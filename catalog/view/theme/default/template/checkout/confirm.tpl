<?php if (!isset($redirect)) { ?>
  <h2>SUMMARY</h2>
  <i id="error-confirm" style="color: #f00;"></i>
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
                       <?php foreach ($totals as $k => $total) { ?>
                       <?php if($total['title']=='Total') { ?>
                        <p class="p2"><?php echo $total['title']; ?> <span class="fr"><?php echo $total['text']; ?></span></p>
                        <?php }else{ ?>
                            <p class="p1"><?php echo $total['title']; ?> <span class="fr"><?php echo $total['text']; ?></span></p>
                        <?php } ?>
                    <?php }  ?>
                   
                    <div class="shop_search">
                        <p>
                            If you have coupons, please fill them out. If not, 
                            please pay.
                        </p>
                        <i id="new-checkout-bot-code" style="color: #f00;"></i>
                        <label >
                            <input type="text"  id="coupon_code" name="coupon" value="<?php echo @$coupon; ?>" placeholder="coupon code"/>
                            <button  onclick="coupon_code(this)">CONFIRM</button>
                        </label>
                    </div>
                    <div class="btn">
                        <span>Buyer Message:</span>
                        <i id="comment_success"></i>
                        <label for="comment">
                            <input  id="comment" value="<?php echo @$comment; ?>" name="comment" placeholder="Please leave a message if necessary" type="text">
                            <button onclick="savecomment();" >CONFIRM</button>
                        </label>
                    </div>
                
                   

<?php } else { ?>
<script type="text/javascript"><!--
location = '<?php echo $redirect; ?>';
//--></script>
<?php } ?>

<script type="text/javascript"><!--
$(function(){
 $(".shop_search input").focus(function(){
            $(".shop_search button").css("display","block");
        })
 $(".btn input").focus(function(){
            $(".btn button").css("display","block");
        })
 })
// coupon code
function savecomment() {
    $.ajax({
        url: 'index.php?route=checkout/confirm/savecomment',
        type: 'post',
        data: $('input#comment'),
        dataType: 'json',

        success: function(json) {
            $('#comment').val(json['comment']);
            $('#comment_success').html('Comment Success!');

        }
    })
}
function coupon_code(e) {
    $.ajax({
        url: 'index.php?route=extension/total/coupon/jcoupon',
        type: 'post',
        data: $('input#coupon_code'),
        dataType: 'json',
      
        success: function(json) {
       

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']) {
                    $('#new-checkout-bot-code').html( json['error']);
                }
               
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
function checkout() {
   
    $.ajax({
        url: 'index.php?route=<?php echo $payment_type=="Express" ? "extension/payment/pp_express/expressComplete" : "checkout/confirm/save"; ?>&cart_ids=<?php echo $cart_ids ?>',
        type: 'post',
        data: $('#comment'),
        dataType: 'json',
       
        success: function(json) {
       

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#error-confirm').html(json['error']['warning']);
                }
            
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

//--></script>
