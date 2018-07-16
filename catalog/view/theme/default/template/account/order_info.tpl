<?php echo $header; ?>
<!--内容-->
    <div class="view_order">
      <div class="content in_content clearfix">
        <div class="text_con clearfix">
          <h1>Order Information</h1>
          <div class="top clearfix">
            <div class="hui_div clearfix">
              <p><span>Order Date: </span><?php echo $date_added; ?></p>
              <?php if ($order_no) { ?>
               <p><span>Order Number: </span><?php echo $order_no; ?></p>
              <?php } ?>
              <?php if ($order_status) { ?>
              <p><span>Order Status: </span><?php echo $order_status; ?></p>
              <?php } ?>
            </div>
            <div class="ship active clearfix">
              <div class="left clearfix">
                <span class="h2_span">Shipping Address</span>
                <div class="text clearfix">
                <?php if ($shipping_address) { ?>
                <p><?php echo $shipping_address; ?></p>
                <?php } ?> 

                  <?php if($order_status == 'Pending'){ ?>
                  <button class="editadd">Edit Address</button>
                  <?php } ?>
                </div>
              </div>
              <div class="right clearfix">
                <span class="h2_span">Shipping Method</span>
                <div class="text clearfix">
                <?php if ($payment_method) { ?>
              <p><?php echo $text_payment_method; ?></p> <p><?php echo $payment_method; ?></p><br />
              <?php } ?>

              <?php if ($shipping_method) { ?>
              <p><?php echo $text_shipping_method; ?></p> <p><?php echo $shipping_method; ?></p><br />
              <?php } ?>

              <?php if ($shippingNumber) { ?>
              <p>Shipping Number:</p> <p><?php echo $shippingNumber; ?></p>
              <?php } ?>
                  <!-- <p>Nigeria Local Express <span>$0.00</span></p>
                  <p>（Weight: 200.00g）</p> -->
                <?php if($order_status == 'Pending'){ ?>
                  <!-- <button class="editship">Edit Shipping Method</button> -->
                 <?php } ?> 
                </div>
              </div>
              
            </div>
          </div>
          
          <div class="bot clearfix">
            <div class="hui_div clearfix">
              <p>Product Information</p>
            </div>
            <div class="text clearfix">
              <div class="span_div clearfix">
                <span>Subtotal</span>
                <span>Length</span>
                <span>Quantity</span>
                <span>Unit  Price</span>
              </div>              
              
              <ul class="order_ul clearfix">
              <?php foreach ($products as $product) { ?>
                <li class="clearfix">
                  <div class="pic_img">
                    <img src="<?php echo $product['order_image']; ?>" alt="" />                   
                  </div>
                  <p class="ov_text"><?php echo $product['name']; ?>
                </p>
                  <span class="d_price"><?php echo $product['total']; ?></span>
              <span class="num">&nbsp;
                  <?php foreach ($product['option'] as $option) { ?>
              <i class="yd_i">X</i><?php echo $option['value']; ?>
                <!-- <small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small> -->
                <?php } ?>
              </span>
                 <!--  <span class="num"><i class="yd_i">X</i>1</span> -->
                  <span class="length"><i class="yd_i"></i><?php echo $product['quantity']; ?></span>
                 <!--  <span class="z_price">$35.05</span> -->
              
                    <span class="z_price"><?php echo $product['price']; ?></span>
              
                </li>
               <?php } ?>
              </ul>
              <div class="total clearfix">
                <p class="clearfix"><span class="fl">Shipping </span><span class="fr"><?php echo $shipping_total; ?></span></p>
                <p class="clearfix"><span class="p_span fl">Total </span><span class="fr"><?php echo $total; ?></span></p>
              </div>
            </div>

          </div>
          
          <!-- <a class="a_btn" href="###">Continue to pay</a>
          <a class="qx_btn" href="###">Cancel</a> -->
            <?php if($order_status == 'Pending'){ ?>
                 
                  <?php if($payment_code == 'pp_standard' || $payment_code == 'pp_express') { ?>
                    &nbsp;&nbsp;<a data-toggle="tooltip" href="<?php echo $repay;?>" title="Pay"  class="a_btn">Continue to pay</a>
                  <?php } ?>
                  <?php if($bank_receipt) { ?>
                    &nbsp;&nbsp;<a data-toggle="tooltip" href="<?php echo $repay_receipt;?>" title="Pay"  class="a_btn">Re Submit Receipt</a>
                  <?php }elseif(!($payment_code == 'pp_standard' || $payment_code == 'pp_express')){ ?>
                    &nbsp;&nbsp;<a data-toggle="tooltip" href="<?php echo $repay_receipt;?>" title="Pay"  class="a_btn">Continue to pay</a>
                <?php } ?>

                  &nbsp;&nbsp;<a  title="Cancel Order"  onclick="cancel_order('<?=$cancel_href?>')" class="qx_btn">Cancel</a>
                <?php } ?>

          <?php if ($histories) { ?>
          <div class="order_hty">
            <h1>Order History</h1>
            <ul>
              <li><span>Dateline</span><span>Status</span></li>
          <?php if ($histories) { ?>
          <?php foreach ($histories as $history) { ?>
              <li>
              <span><?php echo $history['date_added']; ?></span>
              <span><?php echo $history['status']; ?></span>
              </li>
              <?php } ?>
          <?php }  ?>
            </ul>
          </div>
          
         <?php } ?>
          <?php if($order_status !== 'Pending'){ ?>
         <a class="a_btn" href="<?php echo $continue?>">GO BACK</a> 
         <?php } ?>
           <?php if($bank_receipt) { ?>
           <div class="bot clearfix" style="margin-top: 70px;">
            <div class="hui_div clearfix">
              <p>Bank Receipt</p>
            </div>
            <div class="text clearfix">
 <div class="bank_receipt" style="text-align: center; background: #fff; margin-top: 20px;">
        <img style="margin:0 auto;max-width: 100%;" src="<?=$bank_receipt;?>" />
      </div>
    </div>
  </div>         <?php } ?>
        </div>
       
      </div>
    </div>
    
    <div class="edit_add_md" <?=!$address_error?"":"style='display:block'";?>>
      <div class="text">
        <form method="post" action="<?=$edit_address_url;?>"  class="clearfix" id="collapse-shipping-address">
          <div class="form_div clearfix">
            <div class="close"></div>
            <h1>Edit the address</h1>
            <p>* Required fields</p>
            <div class="label clearfix">
              <label for="">
                <span>Frist Name *</span>
                <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
              <?php if ($error_firstname) { ?>
              <p class="ts_p" style="color: #fd4f57;font-size: 14px;"><?php echo $error_firstname; ?></p>
              <?php } ?>
               <!--  <p class="ts_ps">This field is required</p> -->
              </label>
              <label class="mr_no" for="">
                <span>Last Name *</span>
                <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
              <?php if ($error_lastname) { ?>
              <p class="ts_p" style="color: #fd4f57;font-size: 14px;"><?php echo $error_lastname; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
              <label class="add" for="">
                <span>Address*</span>
                <input type="text" name="address_1" value="<?php echo $address_1; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-address-1" class="form-control" />
              <?php if ($error_address_1) { ?>
              <p class="ts_ps" style="color: #fd4f57;font-size: 14px;"><?php echo $error_address_1; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
                <input type="text" name="address_2" value="<?php echo $address_2; ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-address-2" class="form-control" />
              </label>
              <label for="">
                <span>Country *</span>
                <select name="country_id" id="input-country" class="form-control" disabled="">
                <option value=""><?php echo $replace['country']; ?></option>
                <?php foreach ($countries as $country) { ?>
                <?php if ($country['country_id'] == $country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_country) { ?>
              <p class="ts_ps" style="color: #fd4f57;font-size: 14px;"><?php echo $error_country; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
              <label class="mr_no" for="">
                <span>Post Code *</span>
                <input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-postcode" class="form-control" />
              <?php if ($error_postcode) { ?>
             <p class="ts_ps" style="color: #fd4f57;font-size: 14px;"><?php echo $error_postcode; ?></p>
              <?php } ?>
               <!--  <p class="ts_ps">This field is required</p> -->
              </label>
              <label for="">
                <span>City *</span>
               <input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city" class="form-control" />
              <?php if ($error_city) { ?>
              <p class="ts_ps" style="color: #fd4f57;font-size: 14px;"><?php echo $error_city; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
              <label class="mr_no" for="">
                <span>State *</span>
                <select  disabled="" name="zone_id" id="input-zone" class="form-control" >
              </select>
              <?php if ($error_zone) { ?>
              <p class="ts_ps" style="color: #fd4f57;font-size: 14px;"><?php echo $error_zone; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
              <label for="">
                <span>Phone *</span>
                <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
              <?php if (!empty($error_telephone)) { ?>
             <p class="ts_ps" style="color: #fd4f57;font-size: 14px;"><?php echo $error_telephone; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
            </div>
            
            <button type="submit" class="bc_btn clearfix" >SAVE ADDRESS&nbsp;&nbsp;&nbsp;></button>
            <button type="button" onclick="cancel_address();" class="qx_btn clearfix">CANCEL&nbsp;&nbsp;&nbsp;></button>
            <input type="hidden" name="edit_address" value="true" />
          </div>
        </form>
      </div>
     
    </div>


    


<?php echo $footer; ?>
<script>
  function cancel_order(url){
  if(confirm('Are You Sure?')){
    location.href=url;
  }
}
  function cancel_address() {
    $('.edit_add_md').fadeOut();
       $("body").css("overflow","");
       return false;
  }
  $(function(){
    $(".editadd").click(function(){
      $(".edit_add_md").fadeIn();
      $("body").css("overflow","hidden");
    })
    $(".edit_add_md .form_div .close").click(function(){
      $(".edit_add_md").fadeOut();
      $("body").css("overflow","");
    })
    
    $(".editship").click(function(){
      $(".edit_method_md").fadeIn();
      $("body").css("overflow","hidden");
    })
    $(".edit_method_md .close").click(function(){
      $(".edit_method_md").fadeOut();
      $("body").css("overflow","");
    })
    
    //单选
    $(".dx_label input").click(function(){
      $(".check_i").removeClass("active");
      $(this).siblings(".check_i").addClass("active");
    })
  })
</script>
<script type="text/javascript"><!--
$('select[name=\'country_id\']').on('change', function() {
  $.ajax({
    url: 'index.php?route=account/account/country&country_id=' + this.value,
    dataType: 'json',
    beforeSend: function() {
      $('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
    },
    complete: function() {
      $('.fa-spin').remove();
    },
    success: function(json) {

      html = '<option value=""><?php echo $text_select; ?></option>';

      if (json['zone'] && json['zone'] != '') {
        for (i = 0; i < json['zone'].length; i++) {
          html += '<option value="' + json['zone'][i]['zone_id'] + '"';

          if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
            html += ' selected="selected"';
            }

            html += '>' + json['zone'][i]['name'] + '</option>';
        }
      } else {
        html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
      }

      $('select[name=\'zone_id\']').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

$('select[name=\'country_id\']').trigger('change');


//--></script>
