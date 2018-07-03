<?php echo $header; ?>
<!--内容-->
    <div class=" in_content peo_center">
      <div class="content clearfix">
        
        <div class="left clearfix">
          <h1>MY ACCOUNT</h1>
          <ol>
            <?php echo $column_left; ?>
            <?php if ($column_left && $account_left) { ?>
            <?php $class = 'col-sm-6'; ?>
            <?php } elseif ($column_left || $account_left) { ?>
            <?php $class = 'col-sm-9'; ?>
            <?php } else { ?>
            <?php $class = 'col-sm-12'; ?>
            <?php } ?>
            <?php echo $account_left; ?>
          </ol>
        </div>
        
        <div class="right m_address clearfix">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="form_div clearfix">
              <p>* Required fields</p>
              <label for="">
                <span>Frist Name *</span>
                <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
              <?php if ($error_firstname) { ?>
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_firstname; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
              <label class="mr_no" for="">
                <span>Last Name *</span>
                <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
              <?php if ($error_lastname) { ?>
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_lastname; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
              <label class="add" for="">
                <span>Address*</span>
                <!-- <input style="margin-bottom: 16px;" type="text"  /> -->
                <input type="text" name="address_1" value="<?php echo $address_1; ?>" placeholder="<?php echo $entry_address_1; ?>" id="input-address-1" class="form-control" />
              <?php if ($error_address_1) { ?>
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_address_1; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
                <input type="text" name="address_2" value="<?php echo $address_2; ?>" placeholder="<?php echo $entry_address_2; ?>" id="input-address-2" class="form-control" />
              </label>
              <label for="">
                <span>Country *</span>
                <select name="country_id" id="input-country" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
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
                <input type="text" name="postcode" value="<?php echo $postcode; ?>" placeholder="<?php echo $entry_postcode; ?>" id="input-postcode" class="form-control" />
              <?php if ($error_postcode) { ?>
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_postcode; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
              <label for="">
                <span>City *</span>
                <input type="text" name="city" value="<?php echo $city; ?>" placeholder="<?php echo $entry_city; ?>" id="input-city" class="form-control" />
              <?php if ($error_city) { ?>
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_city; ?></p>
              <?php } ?>
                <!-- <p class="ts_ps">This field is required</p> -->
              </label>
              <label class="mr_no" for="">
                <span>State *</span>
                <select name="zone_id" id="input-zone" class="form-control">
              </select>
              <?php if ($error_zone) { ?>
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_zone; ?></p>
              <?php } ?>
               <!--  <p class="ts_ps">This field is required</p> -->
              </label>
              <label for="">
                <span>Phone *</span>
                <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
              <?php if (!empty($error_telephone)) { ?>
              <p class="text-danger" style="color: #fd4f57;font-size: 14px;"><?php echo $error_telephone; ?></p>
              <?php } ?>
               <!--  <p class="ts_ps">This field is required</p> -->
              </label>
              <div class="xy_div">
                <label for="" class="dx_label">
                <?php if ($default) { ?>
              <input class="check_input <?=$default==1 ?'off':'';?>" type="checkbox" name="default" value="1" checked="checked"/>
               <!--  <input type="radio" name="default" value="1" checked="checked" /> -->
              <input class="check_input" type="checkbox" name="default" value="0"/>
               <!--  <input type="radio" name="default" value="0" /> -->
              <i class="check_i" <?=$default==1 ?'active':'';?> ></i>
              <?php } else { ?>
                <input class="check_input" type="checkbox" name="default" value="1" />
                <input class="check_input" type="checkbox" name="default" value="0" checked="checked"/>
                <i class="check_i"  ></i>
              <?php } ?>
                  <!-- <input class="check_input" type="checkbox" />
                  <i class="check_i"></i> -->
                </label>
                <span>Set this address as my default address</span>
                
              </div>

              <button class="qx_btn" type="reset">cancel</button>
            <button type="submit" class="tj_btn">UPDATA</button>
            </div>
          </form>
        </div>
        
      </div>
      
      
    </div>
 <!--内容-->
   <!--
 <div class=" in_content peo_center">
      <div class="content clearfix">
        

        
        <div class="right m_address clearfix">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
      
            <div class="xy_div">
              <label for="" class="dx_label">

              <div>
              <?php if ($default) { ?>
              <label >
                <?php echo $text_yes; ?><input type="radio" name="default" value="1" checked="checked"  style="position: absolute;margin-top: 4px\9;margin-left: -20px;" />
                </label>
              <label >
                <?php echo $text_no; ?><input type="radio" name="default" value="0"  style="position: absolute;margin-top: 4px\9;margin-left: -20px;"/>
                </label>
              <?php } else { ?>
              <label >
                <?php echo $text_yes; ?><input type="radio" name="default" value="1" style="position: absolute;margin-top: 4px\9;margin-left: -20px;" />
                </label>
              <label >
                <?php echo $text_no; ?><input type="radio" name="default" value="0" checked="checked" style="position: absolute;margin-top: 4px\9;margin-left: -20px;"/>
                </label>
              <?php } ?>
            </div>
                <!-- <input class="check_input" type="checkbox"  name="default" value="0"/>
                <i class="check_i"></i> 
              </label>
              <span>Set this address as my default address</span>
            </div>
           <!--  <input  value="<?php echo $button_continue; ?>" class="btn btn-primary" /> -->
         <!--  </form>
        </div>
        
      </div>
      
      
    </div> -->
<div class="container">
  
  <div class="row">
    
    <div id="content" class="<?php echo $class; ?>">
     <!--  <?php echo $content_top; ?> -->
      
      <!-- <h2><?php echo $text_edit_address; ?></h2> -->
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>

          
          
          <div class="form-group" style="background: red;">
            <label class="col-sm-2 control-label"><?php echo $entry_default; ?></label>
            <div class="col-sm-10">
              <?php if ($default) { ?>
              <label class="radio-inline">
                <input type="radio" name="default" value="1" checked="checked" />
                <?php echo $text_yes; ?></label>
              <label class="radio-inline">
                <input type="radio" name="default" value="0" />
                <?php echo $text_no; ?></label>
              <?php } else { ?>
              <label class="radio-inline">
                <input type="radio" name="default" value="1" />
                <?php echo $text_yes; ?></label>
              <label class="radio-inline">
                <input type="radio" name="default" value="0" checked="checked" />
                <?php echo $text_no; ?></label>
              <?php } ?>
            </div>
          </div>

        </fieldset>
        <div class="buttons clearfix" style="background: pink;">
          <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
          <div class="pull-right">
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
          </div>
        </div>
      </form>
      <?php echo $content_bottom; ?>
     </div>
    </div>
</div>

<script type="text/javascript"><!--
// Sort the custom fields
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
  })
$('.form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('.form-group').length-2) {
		$('.form-group').eq(parseInt($(this).attr('data-sort'))+2).before(this);
	}

	if ($(this).attr('data-sort') > $('.form-group').length-2) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') == $('.form-group').length-2) {
		$('.form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('.form-group').length-2) {
		$('.form-group:first').before(this);
	}
});
//--></script>
<script type="text/javascript"><!--
$('button[id^=\'button-custom-field\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$(node).parent().find('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').val(json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});
//--></script>
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
<?php echo $footer; ?>
