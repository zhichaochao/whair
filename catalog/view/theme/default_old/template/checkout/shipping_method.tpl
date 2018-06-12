<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>

<?php if ($shipping_methods) { ?>

  <table class="new-checkout-ship-method-table" border="0" cellspacing="0" cellpadding="0">
      <tr class="ship-method-table-tr">
          <th>Shipping Method</th>
          <th>Estimated Shipping Time
              <?php /*<span class="shipping_info">
                  <img src="https://devb.besthairbuy.com/skin/frontend/default/theme560-desktop-new/images/what.png" style="margin-top:-2px;">
                  <table class="tipscon_table">
                      <tr>
                          <th scope="col">Shopping Method</th>
                          <th scope="col">Shopping Cost</th>
                          <th scope="col">Processing Time</th>
                          <th scope="col">Carrier Transit Time</th>
                          <th scope="col">Total Delivery Time</th>
                      </tr>
                      <tr>
                          <td>Expedited shipping</td>
                          <td>$19.99</td>
                          <td>1 to 2 business days</td>
                          <td>1 to 2 business days</td>
                          <td>2 to 4 business days</td>
                      </tr>
                  </table>
              </span>*/ ?>
          </th>
          <th>Shipping Cost</th>
      </tr>

      <?php foreach ($shipping_methods as $quote) { ?>
      <tr class="ship-method-table-tr">
          <td class="nowrap">
            <label>
              <input name="shipping_method" type="radio" value="<?php echo $quote['code']; ?>" <?php if ($quote['code'] == $code) { ?>checked="checked"<?php } ?> class="s_method_expedited" onclick="saveMethod(this)">
              <?php if($quote['code'] == 'DHL'){ ?>
              <img src="https://devb.besthairbuy.com/skin/frontend/default/theme560-desktop-new/images/dh/sfr_method.jpg">
              <?php } ?>
              <?php echo $quote['title']; ?>
            </label>
          </td>
          <td>
              <?php echo @$quote['desc']; ?>
          </td>
          <td class="nowrap">
              <span class="price"><?php echo $quote['text']; ?></span>
          </td>
      </tr>
      <?php } ?>

  </table>

<?php } ?>

<script type="text/javascript"><!--

// Save Shipping Method
function saveMethod(e) {
    $.ajax({
        url: 'index.php?route=checkout/shipping_method/save',
        type: 'post',
        data: $('#collapse-shipping-method input[type=\'radio\']:checked'),
        dataType: 'json',
        beforeSend: function() {
            $(e).button('loading');
        },
        success: function(json) {
            $('#collapse-shipping-method .alert, #collapse-shipping-method .text-danger').remove();

            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                if (json['error']['warning']) {
                    $('#collapse-shipping-method .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                // Highlight any found errors
                $('.text-danger').parent().parent().addClass('has-error');
            } else {
                getPaymentMethod();
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