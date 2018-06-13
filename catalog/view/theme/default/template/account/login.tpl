<?php echo $header; ?>
  <!--<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>-->
  
  <!--错误提示-->
  <div id="checkout-login" class="alert alert-danger" style="display:none;"></div>
  
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger" id="danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  
  
   

<!-- 底部新 -->
    <div class="login in_content clearfix">
      <div class="text clearfix">
        <div class="top">
          <ol class="login_ol clearfix">
            <li class="active">SIGN IN <span></span></li>
            <li>SIGN UP</li>
          </ol>
        </div>
        <div class="bot">
          <ul class="login_ul clearfix">
            <li class="active">
              <p class="bt_p">Returning Customer</p>

              <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="register_tab">
                <label for="">
                  <span>E-Mail Address</span>
                  <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" />
                </label>
                <label for="">
                  <span>Password</span>
                  <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password"/>
                  <a href="<?php echo $forgotten; ?>">Forgotten Password ?</a>
                </label>
                <input class="tj_input" type="submit" value="SIGN IN" />
                <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
              <?php } ?>
              <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
            <?php } ?>
              </form>

            </li>
            <li>
              <p class="bt_p">New Customers</p>
              <div id="register-form-div">
             <form class="res_form"  >
                <label class="clearfix label_name" for="">
                  <span>First Name</span>
                  <input type="text" name="firstname" maxlength="32" value="" placeholder="Firstname" id="input-firstname" class="short_inp1">
                </label>
                <label class="clearfix label_names" for="">
                  <span>Last Name</span>
                  <input type="text" name="lastname" maxlength="32" value="" placeholder="Lastname" id="input-lastname" class="short_inp1">
                </label>
                <label class="clearfix" for="">
                  <span>E-Mail Address</span>
                  <input type="text" name="email" value="" placeholder="E-Mail Address" id="input-email">
                </label>
                <label class="clearfix" for="">
                  <span>Password</span>
                  <input type="password" name="password" value="" placeholder="Password" id="input-password">
                </label>
                <label class="clearfix" for="">
                  <span>Confirm Password</span>
                  <input type="password" name="confirm" value="" placeholder="Confirm Password" id="input-confirm">
                </label>
                <div class="xy_div">
                  <input id="agree" type="checkbox" name="agree" value="1" checked="checked"/>
                  <span class="span1"></span>
                  <span class="span2"></span>
                  <p>I agree to Hot Beauty Hair <a href="<?php echo $agree_url; ?>">Terms and Conditions.</a></p>
                  <div class="erroragree" style="display:none;"></div>
                </div>
                <!-- <input class="tj_input" type="submit" value="SIGN UP" id="button-register" /> -->
                <button type="button" id="button-register" class="tj_input" >SIGN UP</button>
                <!-- <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
            <?php } ?> -->
              </form>
              </div>
            </li>
          </ul>
          
        </div>
      </div>
    </div>
<script>
// Register
	var regTf = true;
$(document).delegate('#button-register', 'click', function() {
		if(regTf){
			regTf = false;
			$.ajax({
        url: '<?php echo $register;?>',
        type: 'post',
        data: $('#register-form-div input'),
        dataType: 'json',
        beforeSend: function() {
        		
            $('#button-register').button('loading');
        },  
        complete: function() {
        		
            $('#button-register').button('reset');
        },          
        success: function(json) {
        		regTf = true;
            $('.info_tips, .text-danger').remove();
            $('.form-group').removeClass('has-error');
			            
            if (json['redirect']) {
                location = json['redirect'];                
            } else if (json['error']) {
                if (json['error']['warning']) {
				    $('#checkout-login').css('display','block').prepend('<div class="info_tips tipssb"><span><img width="21" src="catalog/view/theme/default/image/icon32_warn.png"></span> ' + json['error']['warning'] + '</div>');
					$('#danger').css('display','none');
                }else{
				    $('#checkout-login').css('display','none');
					$('#danger').css('display','none');
				}
				
				if(json['error']['agree']){
				   $('.erroragree').show().html('<div class="text-danger">' + json['error']['agree'] + '</div>');
			    }
                
                for (i in json['error']) {
                    var element = $('#input-' + i.replace('_', '-'));

                    if ($(element).parent().hasClass('input-group')) {
                            $(element).parent().after('<div class="text-danger" style="margin-left:0px;">' + json['error'][i] + '</div>');
                    } else {
                            $(element).after('<div class="text-danger"  style="margin-left:0px;">' + json['error'][i] + '</div>');
                    }					
                }
            }    
        },
        error: function(xhr, ajaxOptions, thrownError) {
           alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
		}
     
});

$('#register-form-div input').keydown(function(e){
		if(e.keyCode==13){
			$('#button-register').click();
		}	
});

$('#agree').click(function(){
     var agree = $('#agree').val();
	 if(agree == 1){
	    $('#agree').val(0);
	 }else{
        $('#agree').val(1);
	 }
});

</script>

<?php echo $footer; ?>