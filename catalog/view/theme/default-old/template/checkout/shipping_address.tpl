<form class="form-horizontal">

  <div id="shipping-existing" style="display: <?php echo ($eaddress||empty($addresses) ? 'none' : 'block'); ?>;">

      <input type="hidden" id="address_id" name="address_id" value="<?php echo $address_id; ?>">
      <table border="0" cellspacing="0" cellpadding="0" class="new-checkout-ship-address-table">
          <?php foreach ($addresses as $address) { ?>
          <?php 
              $custom_field = '';
              if(!empty($address['custom_field']) && is_array($address['custom_field'])){
                  foreach($address['custom_field'] as $c_val){
                      $custom_field .= $custom_field ? ',' . $c_val : $c_val;
                  }
              }
          ?>
          <tr>
              <td class="new-checkout-address-name <?php if ($address['address_id'] == $address_id) echo 'selected'; ?>">
                  <p aid="<?php echo $address['address_id']; ?>"> <?php echo $address['firstname'] .' '. $address['lastname']; ?> </p>
              </td>
              <td class="new-checkout-address-two"><p><?php echo $address['firstname'] .' '. $address['lastname']; ?></p></td>
              <td class="new-checkout-address-phone"><?php echo @$address['telephone']; ?></td>
              <td class="new-checkout-address-dizhi">
              	<p>
              		<?php 
	              		if(mb_strlen($address['address_1'],'UTF8')>15){ 
	              			echo mb_substr($address['address_1'],0,15).'...';
	              		}else{ 
	              			echo $address['address_1'];
	              		}; 
	              	?>,
	              	<?php echo $address['city']; ?>, <?php echo $address['zone']; ?>, <?php echo $address['country']; ?><?php echo $custom_field ? ',' . $custom_field : ''; ?>
              	</p>
              </td>

              <td class="new-checkout-pace"></td>
              <td class="new-checkout-address-rig">
                  <?php if ($address['isDefault'] == 0) { ?> <span class="new-checkout-address-def" onclick="setDefault('<?php echo $address['address_id']; ?>', this)" >Set As Default</span>| <?php }else{?>
                  	<span class="new-checkout-address-def new-checkout-address-def-n">Default Address</span>| 
                  <?php } ?>
                  <span class="new-checkout-address-edit" onclick="getShippingAddress('<?php echo $address['address_id']; ?>')">Edit</span>|
                  <span class="new-checkout-address-dele" onclick="delAddress('<?php echo $address['address_id']; ?>', this)" >Delete</span>
              </td>
          </tr>
          <?php } ?>
      </table>

      <div class="new-checkout-add">
          <i class="fa fa-plus" aria-hidden="true"></i>
          <span id='show-shipping-new'>Add New Address</span>
      </div>

  </div>


  <div id="shipping-new" style="display: <?php echo ($eaddress||empty($addresses) ? 'block' : 'none'); ?>;">
    <?php if(!empty($addresses)){ ?>
    <div class="new-checkout-existing">
        <span id='show-shipping-existing'>Use Existing Address</span>
    </div>
    <?php } ?>

    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-firstname"><?php echo $entry_firstname; ?></label>
      <div class="col-sm-10">
        <input type="text" name="firstname" value="<?php echo ($eaddress ? $eaddress['firstname'] : ''); ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-shipping-firstname" class="form-control clear" />
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-lastname"><?php echo $entry_lastname; ?></label>
      <div class="col-sm-10">
        <input type="text" name="lastname" value="<?php echo ($eaddress ? $eaddress['lastname'] : ''); ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-shipping-lastname" class="form-control clear" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-shipping-company"><?php echo $entry_company; ?></label>
      <div class="col-sm-10">
        <input type="text" name="company" value="<?php echo ($eaddress ? $eaddress['company'] : ''); ?>" placeholder="<?php echo $entry_company; ?>" id="input-shipping-company" class="form-control clear" />
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-address-1"><?php echo $entry_address_1; ?></label>
      <div class="col-sm-10">
        <input type="text" name="address_1" value="<?php echo ($eaddress ? $eaddress['address_1'] : ''); ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-shipping-address-1" class="form-control clear" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label" for="input-shipping-address-2"><?php echo $entry_address_2; ?></label>
      <div class="col-sm-10">
        <input type="text" name="address_2" value="<?php echo ($eaddress ? $eaddress['address_2'] : ''); ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-shipping-address-2" class="form-control clear" />
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-city"><?php echo $entry_city; ?></label>
      <div class="col-sm-10">
        <input type="text" name="city" value="<?php echo ($eaddress ? $eaddress['city'] : ''); ?>" placeholder="<?php echo $entry_city; ?>" id="input-shipping-city" class="form-control clear" />
      </div>
    </div>
    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-postcode"><?php echo $entry_postcode; ?></label>
      <div class="col-sm-10">
        <input type="text" name="postcode" value="<?php echo $eaddress ? $eaddress['postcode'] : $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-shipping-postcode" class="form-control" />
      </div>
    </div>

    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-country"><?php echo $entry_country; ?></label>
      <div class="col-sm-10">
        <select name="country_id" id="input-shipping-country" class="form-control">
          <option value=""><?php echo $text_select; ?></option>
          <?php foreach ($countries as $country) { ?>
          <?php if ($country['country_id'] == ($eaddress ? $eaddress['country_id'] : $country_id)) { ?>
          <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </div>
    </div>

    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-zone"><?php echo $entry_zone; ?></label>
      <div class="col-sm-10">
        <select name="zone_id" id="input-shipping-zone" class="form-control">
        </select>
      </div>
    </div>

    <div class="form-group required">
      <label class="col-sm-2 control-label" for="input-shipping-telephone"><?php echo $entry_telephone; ?></label>
      <div class="col-sm-10">
        <input type="text" name="telephone" value="<?php echo (isset($eaddress['telephone']) ? $eaddress['telephone'] : ''); ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-shipping-telephone" class="form-control clear" />
      </div>
    </div>
    <?php foreach ($custom_fields as $custom_field) { ?>
    <?php if ($custom_field['location'] == 'address') { ?>
    <?php if ($custom_field['type'] == 'select') { ?>
    <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
      <label class="col-sm-2 control-label" for="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
      <div class="col-sm-10">
        <select name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control">
          <option value=""><?php echo $text_select; ?></option>
          <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
          <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
          <?php } ?>
        </select>
      </div>
    </div>
    <?php } ?>
    <?php if ($custom_field['type'] == 'radio') { ?>
    <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
      <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
      <div class="col-sm-10">
        <div id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>">
          <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
          <div class="radio">
            <label>
              <input type="radio" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
              <?php echo $custom_field_value['name']; ?></label>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php } ?>
    <?php if ($custom_field['type'] == 'checkbox') { ?>
    <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
      <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
      <div class="col-sm-10">
        <div id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>">
          <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>][]" value="<?php echo $custom_field_value['custom_field_value_id']; ?>" />
              <?php echo $custom_field_value['name']; ?></label>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php } ?>
    <?php if ($custom_field['type'] == 'text') { ?>
    <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
      <label class="col-sm-2 control-label" for="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
      <div class="col-sm-10">
        <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field['value']; ?>" placeholder="<?php echo $custom_field['name']; ?>" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
      </div>
    </div>
    <?php } ?>
    <?php if ($custom_field['type'] == 'textarea') { ?>
    <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
      <label class="col-sm-2 control-label" for="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
      <div class="col-sm-10">
        <textarea name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" rows="5" placeholder="<?php echo $custom_field['name']; ?>" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control"><?php echo $custom_field['value']; ?></textarea>
      </div>
    </div>
    <?php } ?>
    <?php if ($custom_field['type'] == 'file') { ?>
    <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
      <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>
      <div class="col-sm-10">
        <button type="button" id="button-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
        <input type="hidden" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" />
      </div>
    </div>
    <?php } ?>
    <?php if ($custom_field['type'] == 'date') { ?>
    <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
      <label class="col-sm-2 control-label" for="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
      <div class="col-sm-10">
        <div class="input-group date">
          <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field['value']; ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
          <span class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          </span></div>
      </div>
    </div>
    <?php } ?>
    <?php if ($custom_field['type'] == 'time') { ?>
    <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
      <label class="col-sm-2 control-label" for="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
      <div class="col-sm-10">
        <div class="input-group time">
          <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field['value']; ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="HH:mm" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
          <span class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          </span></div>
      </div>
    </div>
    <?php } ?>
    <?php if ($custom_field['type'] == 'datetime') { ?>
    <div class="form-group<?php echo ($custom_field['required'] ? ' required' : ''); ?> custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
      <label class="col-sm-2 control-label" for="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>
      <div class="col-sm-10">
        <div class="input-group datetime">
          <input type="text" name="custom_field[<?php echo $custom_field['custom_field_id']; ?>]" value="<?php echo $custom_field['value']; ?>" placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-shipping-custom-field<?php echo $custom_field['custom_field_id']; ?>" class="form-control" />
          <span class="input-group-btn">
          <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
          </span></div>
      </div>
    </div>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    <div class="buttons clearfix">
      <center><button type="button" class="use-the-address" id="btnSaveAddress" aid="<?php echo ($eaddress ? $eaddress['address_id'] : 0); ?>" onclick="saveAddress(this);">Use This Shipping Address</button></center>
    </div>
  </div>
  
</form>

<script type="text/javascript"><!--

<?php if(!empty($payment_address)){ ?>
    $('.new-checkout-pay-method').show();
<?php } ?>
<?php if(!empty($shipping_address)){ ?>
    $('.new-checkout-ship-method').show();
<?php } ?>
$('#show-shipping-new').on('click', function() {
    $('#btnSaveAddress').attr('aid', 0);
		$('#shipping-existing').hide();
		$('#shipping-new').show();
});
$('#show-shipping-existing').on('click', function() {
    $('input.clear').val('');
    $('#shipping-existing').show();
    $('#shipping-new').hide();
});
$('#shipping-existing').on('mouseenter','td',function(){
	$(this).parent().siblings().children('.new-checkout-address-rig').css('visibility','hidden');
	$(this).siblings('.new-checkout-address-rig').css('visibility','visible');
});
$('#shipping-existing').on('mouseleave','tr',function(){
	$(this).children('.new-checkout-address-rig').css('visibility','hidden');
});
$('.new-checkout-address-name p').on('click', function() {
    e = $(this);
    $.ajax({
        url: 'index.php?route=checkout/shipping_address/changeAddress&address_id='+e.attr('aid'),
        dataType: 'json',
        beforeSend: function() {
            e.button('loading');
        },
        success: function(json) {
            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                e.button('reset');
                alert(json['error']);
            } else {
                getShippingAddress();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

});

// Set Default Address
function setDefault(address_id, e){
    if(!confirm('Are You Sure ?')) return false;
    $.ajax({
        url: 'index.php?route=checkout/shipping_address/setDefault&address_id='+address_id,
        dataType: 'json',
        beforeSend: function() {
            $(e).button('loading');
        },
        success: function(json) {
            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                $(e).button('reset');
                alert(json['error']);
            } else {
                getShippingAddress();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

// Delete Address
function delAddress(address_id, e){
    if(!confirm('Are You Sure ?')) return false;
    $.ajax({
        url: 'index.php?route=checkout/shipping_address/delete&address_id='+address_id,
        dataType: 'json',
        beforeSend: function() {
            $(e).button('loading');
        },
        success: function(json) {
            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                $(e).button('reset');
                alert(json['error']);
            } else {
                getShippingAddress();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

// Save Shipping Address
function saveAddress(e) {
    var address_id = $(e).attr('aid');
    $.ajax({
        url: 'index.php?route=checkout/shipping_address/save&address_id='+address_id,
        type: 'post',
        data: $('#collapse-shipping-address input[type=\'text\'], #collapse-shipping-address input[type=\'date\'], #collapse-shipping-address input[type=\'datetime-local\'], #collapse-shipping-address input[type=\'time\'], #collapse-shipping-address input[type=\'password\'], #collapse-shipping-address input[type=\'checkbox\']:checked, #collapse-shipping-address input[type=\'radio\']:checked, #collapse-shipping-address textarea, #collapse-shipping-address select'),
        dataType: 'json',
        beforeSend: function() {
            $('#button-shipping-address').button('loading');
        },
        success: function(json) {
            $('#collapse-shipping-address .alert, #collapse-shipping-address .text-danger').remove();
            checkSAStatus = 1;
            if (json['redirect']) {
                location = json['redirect'];
            } else if (json['error']) {
                checkSAStatus = 0;
                $('#button-shipping-address').button('reset');

                if (json['error']['warning']) {
                    $('#collapse-shipping-address .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }

                for (i in json['error']) {
                    var element = $('#input-shipping-' + i.replace('_', '-'));

                    if ($(element).parent().hasClass('input-group')) {
                        $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                    } else {
                        $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                    }
                }

                // Highlight any found errors
                $('.text-danger').parent().parent().addClass('has-error');
            } else {
                getShippingAddress();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

// Edit Country
$('#collapse-shipping-address select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#collapse-shipping-address select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#collapse-shipping-address input[name=\'postcode\']').parent().parent().addClass('required');
			} else {
				$('#collapse-shipping-address input[name=\'postcode\']').parent().parent().removeClass('required');
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '<?php echo ($eaddress?$eaddress['zone_id']:$zone_id); ?>') {
						html += ' selected="selected"';
					}

					html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('#collapse-shipping-address select[name=\'zone_id\']').html(html).trigger('change');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
$('#collapse-shipping-address select[name=\'country_id\']').trigger('change');

$(document).ready(function() {

<?php if($payment_type=="Express" && empty($addresses)) { ?>
    setTimeout(function(){
        $.ajax({
            url: 'index.php?route=checkout/shipping_address/save',
            type: 'post',
            data: $('#collapse-shipping-address input[type=\'text\'], #collapse-shipping-address input[type=\'date\'], #collapse-shipping-address input[type=\'datetime-local\'], #collapse-shipping-address input[type=\'time\'], #collapse-shipping-address input[type=\'password\'], #collapse-shipping-address input[type=\'checkbox\']:checked, #collapse-shipping-address input[type=\'radio\']:checked, #collapse-shipping-address textarea, #collapse-shipping-address select'),
            dataType: 'json',
            success: function(json) {
                $('#collapse-shipping-address .alert, #collapse-shipping-address .text-danger').remove();
                checkSAStatus = 1;
                if (json['error']) {
                    checkSAStatus = 0;
                    if (json['error']['warning']) {
                        $('#collapse-shipping-address .panel-body').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    }
                    for (i in json['error']) {
                        var element = $('#input-shipping-' + i.replace('_', '-'));
                        if ($(element).parent().hasClass('input-group')) {
                            $(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
                        } else {
                            $(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
                        }
                    }
                    // Highlight any found errors
                    $('.text-danger').parent().parent().addClass('has-error');
                }
            }
        });
    }, 1000);
<?php } ?>

//为国家地区下拉列表添加二级搜索框
$(document).ready(function(){
  $("#input-shipping-country").select2();
  $("#input-shipping-zone").select2();
});

});

//--></script>
