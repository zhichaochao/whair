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
                  <button class="editship">Edit Shipping Method</button>
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
                    <img src="" alt="" />                   
                  </div>
                  <p class="ov_text"><?php echo $product['name']; ?>
                </p>
                  <span class="d_price"><?php echo $product['total']; ?></span>

                  <?php foreach ($product['option'] as $option) { ?>
                <span class="num"><i class="yd_i">X</i><?php echo $option['value']; ?></span>
                <!-- <small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small> -->
                <?php } ?>

                 <!--  <span class="num"><i class="yd_i">X</i>1</span> -->
                  <span class="length"><i class="yd_i"></i><?php echo $product['quantity']; ?></span>
                 <!--  <span class="z_price">$35.05</span> -->
                  <?php if ($product['price'] == $product['original_price'] ) { ?>
                  <!-- <?php echo $product['price']; ?> -->
                  <span class="z_price"><?php echo $product['price']; ?></span>
                <?php } else { ?>
                  <?php if(empty($product['original_price'])) { ?>                    
                    <span class="z_price"><?php echo $product['price']; ?></span>                    
                  <?php } else { ?>
                    <span class="z_price"><?php echo $product['price']; ?></span>
                  <?php } ?>
                <?php } ?>
                </li>
               <?php } ?>
              </ul>
              <div class="total clearfix">
                <p class="clearfix"><span class="fl">Shipping </span><span class="fr"><?php echo $totals[1]['text']; ?></span></p>
                <p class="clearfix"><span class="p_span fl">Total </span><span class="fr"><?php echo $totals[3]['text']; ?></span></p>
              </div>
            </div>
          </div>
          
          <!-- <a class="a_btn" href="###">Continue to pay</a>
          <a class="qx_btn" href="###">Cancel</a> -->
            <?php if($order_status == 'Pending'){ ?>
                 
                  <?php if($payment_code == 'pp_standard' || $payment_code == 'pp_express') { ?>
                    &nbsp;&nbsp;<a data-toggle="tooltip" href="<?php echo $repay;?>" title="Pay"  class="a_btn">Continue to pay</a>
                  <?php } ?>
                  &nbsp;&nbsp;<a href="javascript:;" data-toggle="tooltip" onclick="cancel_order('<?php echo $ocancel_href;?>')" href="<?php echo $cancel_href;?>" title="Cancel Order"  class="qx_btn">Cancel</a>
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
          <a class="a_btn" href="<?php echo $continue?>">GO BACK</a>
         <?php } ?>  
        </div>
      </div>
    </div>
    
    <div class="edit_add_md">
      <div class="text">
        <form action="" class="clearfix">
          <div class="form_div clearfix">
            <div class="close"></div>
            <h1>Edit the address</h1>
            <p>* Required fields</p>
            <div class="label clearfix">
              <label for="">
                <span>Frist Name *</span>
                <input type="text" name="firstname" value="<?php echo $replace['firstname']; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
              <?php if ($error_firstname) { ?>
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_firstname; ?></p>
              <?php } ?>
               <!--  <p class="ts_ps">This field is required</p> -->
              </label>
              <label class="mr_no" for="">
                <span>Last Name *</span>
                <input type="text" name="lastname" value="<?php echo $replace['lastname']; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
              <?php if ($error_lastname) { ?>
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_lastname; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
              <label class="add" for="">
                <span>Address*</span>
                <input type="text" name="address_1" value="<?php echo $replace['address_1']; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-address-1" class="form-control" />
              <?php if ($error_address_1) { ?>
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_address_1; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
                <input type="text" name="address_2" value="<?php echo $replace['address_2']; ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-address-2" class="form-control" />
              </label>
              <label for="">
                <span>Country *</span>
                <select name="country_id" id="input-country" class="form-control">
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
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_country; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
              <label class="mr_no" for="">
                <span>Post Code *</span>
                <input type="text" name="postcode" value="<?php echo $replace['postcode']; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-postcode" class="form-control" />
              <?php if ($error_postcode) { ?>
             <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_postcode; ?></p>
              <?php } ?>
               <!--  <p class="ts_ps">This field is required</p> -->
              </label>
              <label for="">
                <span>City *</span>
               <input type="text" name="city" value="<?php echo $replace['city']; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city" class="form-control" />
              <?php if ($error_city) { ?>
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_city; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
              <label class="mr_no" for="">
                <span>State *</span>
                <select name="zone_id" id="input-zone" class="form-control" >
              </select>
              <?php if ($error_zone) { ?>
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_zone; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
              <label for="">
                <span>Phone *</span>
                <input type="text" name="telephone" value="<?php echo $replace['shipping_telephone']; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
              <?php if (!empty($error_telephone)) { ?>
             <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_telephone; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
            </div>
            
            <button class="bc_btn clearfix">SAVE ADDRESS&nbsp;&nbsp;&nbsp;></button>
            <button class="qx_btn clearfix">CANCEL&nbsp;&nbsp;&nbsp;></button>
          </div>
        </form>
      </div>
    </div>
    
    <div class="edit_method_md">
      <div class="text clearfix">
        <div class="close"></div>
        <h2>Select the Shipping Method</h2>
        <ul class="express_ul">
          <li class="clearfix">
            <dl>
              <dt>Shipping Method</dt>
              <dd class="kd">
                <label for="" class="dx_label">
                  <input class="check_input" type="checkbox" />
                  <i class="check_i"></i>
                </label>
                <img src="catalog/view/theme/default/img/jpg/kd_1.jpg"/>
              </dd>
              <dd class="kd yd_kd">
                <label for="" class="dx_label">
                  <input class="check_input" type="checkbox" />
                  <i class="check_i"></i>
                </label>
                <img src="catalog/view/theme/default/img/jpg/kd_2.jpg"/>
              </dd>
            </dl>
            <dl>
              <dt>Expected delivery time</dt>
              <dd>
                <span>2-3 Working Days</span>
              </dd>
            </dl>
            <dl>
              <dt>Shipping Cost</dt>
              <dd>
                <span>$0.00</span>
              </dd>
            </dl>
          </li>
          <li class="clearfix yd_li">
            <dl>
              <dd class="kd">
                <label for="" class="dx_label">
                  <input class="check_input" type="checkbox" />
                  <i class="check_i"></i>
                </label>
                <img src="catalog/view/theme/default/img/jpg/kd_2.jpg"/>
              </dd>
            </dl>
            <dl>
              <dd>
                <span>2-3 Working Days</span>
              </dd>
            </dl>
            <dl>
              <dd>
                <span>$0.00</span>
              </dd>
            </dl>
          </li>
        </ul>
        <a class="btn240 a_btn" href="###">CONFIRM &nbsp;&nbsp;&nbsp;></a>
      </div>
    </div>
<div class="container">
  
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row">
    <?php echo $column_left; ?>
    
    <?php if ($column_left && $account_left) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $account_left) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    
    <?php echo $account_left; ?>
    
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2><?php echo $heading_title; ?></h2>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left" colspan="2"><?php echo $text_order_detail; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left" style="width: 50%;">
              <!--<?php if ($invoice_no) { ?>
              <b><?php //echo $text_invoice_no; ?></b> <?php //echo $invoice_no; ?><br />
              <?php } ?>
              <b><?php //echo $text_order_id; ?></b> #<?php //echo $order_id; ?><br />-->
              <?php if ($order_no) { ?>
              <b>Order No:</b> <?php echo $order_no; ?><br />
              <?php } ?>
              <?php if ($order_status) { ?>
              <b>Order Status:</b> <?php echo $order_status; ?><br />
              <?php } ?>
              <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?>
            </td>
            <td class="text-left" style="width: 50%;">
              <?php if ($payment_method) { ?>
              <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
              <?php } ?>
              <?php if ($shipping_method) { ?>
              <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?><br />
              <?php } ?>
              <?php if ($shippingNumber) { ?>
              <b>Shipping Number:</b> <?php echo $shippingNumber; ?>
              <?php } ?>
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left" style="width: 50%; vertical-align: top;"><?php echo $text_payment_address; ?></td>
            <?php if ($shipping_address) { ?>
            <td class="text-left" style="width: 50%; vertical-align: top;"><?php echo $text_shipping_address; ?></td>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left"><?php echo $payment_address; ?></td>
            <?php if ($shipping_address) { ?>
            <td class="text-left"><?php echo $shipping_address; ?></td>
            <?php } ?>
          </tr>
        </tbody>
      </table>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left"><?php echo $column_name; ?></td>
              <td class="text-left"><?php echo $column_model; ?></td>
              <td class="text-right"><?php echo $column_quantity; ?></td>
              <td class="text-right"><?php echo $column_price; ?></td>
              <td class="text-right"><?php echo $column_total; ?></td>
              <?php if ($products) { ?>
              <td style="width: 20px;"></td>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td class="text-left"><?php echo $product['name']; ?>
                <?php foreach ($product['option'] as $option) { ?>
                <br />
                &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                <?php } ?>
                </td>
              <td class="text-left"><?php echo $product['model']; ?></td>
              <td class="text-right"><?php echo $product['quantity']; ?></td>
              <td class="text-right">
                <?php if ($product['price'] == $product['original_price'] ) { ?>
                  <?php echo $product['price']; ?>
                <?php } else { ?>
                  <?php if(empty($product['original_price'])) { ?>
                    <?php echo $product['price']; ?><br>
                  <?php } else { ?>
                    <?php echo $product['price']; ?><br>
                    <del><?php echo $product['original_price']; ?></del>
                  <?php } ?>
                <?php } ?>
              </td>
              <td class="text-right"><?php echo $product['total']; ?></td>
              <td class="text-right" style="white-space: nowrap;"><?php if ($product['reorder']) { ?>
                <a href="<?php echo $product['reorder']; ?>" data-toggle="tooltip" title="<?php echo $button_reorder; ?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i></a>
                <?php } ?>
                <a href="<?php echo $product['return']; ?>" data-toggle="tooltip" title="<?php echo $button_return; ?>" class="btn btn-danger"><i class="fa fa-reply"></i></a></td>
            </tr>
            <?php } ?>
            <?php foreach ($vouchers as $voucher) { ?>
            <tr>
              <td class="text-left"><?php echo $voucher['description']; ?></td>
              <td class="text-left"></td>
              <td class="text-right">1</td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <?php if ($products) { ?>
              <td></td>
              <?php } ?>
            </tr>
            <?php } ?>
          </tbody>
          <tfoot>
            <?php foreach ($totals as $total) { ?>
            <!-- <?php echo print_r($total)?> -->
            <tr>
              <td colspan="3"></td>
              <td class="text-right"><b><?php echo $total['title']; ?></b></td>
              <td class="text-right"><?php echo $total['text']; ?></td>
              <?php if ($products) { ?>
              <td></td>
              <?php } ?>
            </tr>
            <?php } ?>
          </tfoot>
        </table>
      </div>
      <?php if ($comment) { ?>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left"><?php echo $text_comment; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left"><?php echo $comment; ?></td>
          </tr>
        </tbody>
      </table>
      <?php } ?>
      <?php if ($histories) { ?>
      <h3><?php echo $text_history; ?></h3>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left"><?php echo $column_date_added; ?></td>
            <td class="text-left"><?php echo $column_status; ?></td>
            <td class="text-left"><?php echo $column_comment; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($histories) { ?>
          <?php foreach ($histories as $history) { ?>
          <tr>
            <td class="text-left"><?php echo $history['date_added']; ?></td>
            <td class="text-left"><?php echo $history['status']; ?></td>
            <td class="text-left"><?php echo $history['comment']; ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td colspan="3" class="text-center"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?>
     </div>
   </div>
</div>
<?php echo $footer; ?>
<script>
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
