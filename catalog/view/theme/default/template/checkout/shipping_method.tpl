

<?php if ($shipping_methods) { ?>

<div class="bg_fff">
 <h3>Shipping Method</h3>
                        <ul class="express_ul" id='collapse-shipping-method'>
                             <?php foreach ($shipping_methods as $quote) { ?>
                            <li class="clearfix">
                                <dl>
                                    <dt>Shipping Method</dt>
                                    <dd>
                                        <label  class="dx_label">
                                            <input class="check_input"  name="shipping_method" type="radio" value="<?php echo $quote['code']; ?>" <?php if ($quote['code'] == $code) { ?>checked="checked"<?php } ?> class="s_method_expedited" onclick="saveMethod(this)" />
                                            <i class="check_i"></i>
                                        </label>
                                        <span>   <?php if($quote['code'] == 'DHL'){ ?>
              <img src="https://devb.besthairbuy.com/skin/frontend/default/theme560-desktop-new/images/dh/sfr_method.jpg">
              <?php } ?>
              <?php echo $quote['title']; ?> </span>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Expected delivery time</dt>
                                    <dd>
                                        <span>   <?php echo @$quote['desc']; ?></span>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Shipping Cost</dt>
                                    <dd>
                                        <span><?php echo $quote['text']; ?></span>
                                    </dd>
                                </dl>
                            </li>
                             <?php } ?>
                        </ul>

<a class="btn240" href="###">SAVW AND CONTINUE &nbsp;&nbsp;&nbsp;&gt;</a>
   </div>

<?php } ?>

<script type="text/javascript"><!--

// Save Shipping Method
function saveMethod(e) {
    $.ajax({
        url: 'index.php?route=checkout/shipping_method/save',
        type: 'post',
        data: $('#collapse-shipping-method input[type=\'radio\']:checked'),
        dataType: 'json',
      
        success: function(json) {
        
                getPaymentMethod();
                getOrder();
         
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

//--></script>