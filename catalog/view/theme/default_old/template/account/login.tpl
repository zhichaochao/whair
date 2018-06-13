<?php echo $header; ?>
<div class="container">
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
  
  
    <?php echo $column_left; ?>
    
    <?php if ($column_left && $account_left) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $account_left) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    
    <?php //echo $account_left; ?>
    
    <div class="account-login-wrap fixclea">
      
        <!--旧注册
        <div class="col-sm-6">
          <div class="well">
            <h2><?php echo $text_new_customer; ?></h2>
            <p><strong><?php echo $text_register; ?></strong></p>
            <p><?php echo $text_register_account; ?></p>
            <a href="<?php echo $register; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
        </div>-->
        
        <!--注册-->
        <div class="register" id="register-form-div">
          <h2>New Customers</h2>
          <div class="register_tab">
            <dl class="fixclea">
              <dt class="req-before">Full Name:</dt>
              <dd class="fixclea">
                <div class="stname" style="margin-right:10px;">
                    <input type="text" name="firstname" maxlength="32" value="" placeholder="Firstname" id="input-firstname" class="short_inp1">
                                        <label class="req-before">First Name</label>
                </div>
                <div class="stname">
                    <input type="text" name="lastname" maxlength="32" value="" placeholder="Lastname" id="input-lastname" class="short_inp1">
                    <!--<input type="text" name="lastname" size="33" maxlength="32" id="lastname" class="short_inp1">-->                    <label class="req-before">Last Name</label>
                </div>
              </dd>
            </dl>
            <!--<dl>
              <dd>
                Full Name:
                <br/>
                Firstname
                <input type="text" name="firstname" value="" placeholder="Firstname" id="input-firstname" class="form-control">
              </dd>
            </dl>
            <dl>
              <dd>
                Lastname
                <input type="text" name="lastname" value="" placeholder="Lastname" id="input-lastname" class="form-control">
              </dd>
            </dl>
            -->
            <dl class="fixclea">
              <dt class="req-before">E-Mail Address:</dt>
              <dd>
                <input type="text" name="email" value="" placeholder="E-Mail Address" id="input-email">
              </dd>
            </dl>
            <dl class="fixclea">
              <dt class="req-before">
                Password:
              </dt>
              <dd>
                <input type="password" name="password" value="" placeholder="Password" id="input-password">
              </dd>
            </dl>
            <dl class="fixclea">
              <dt class="req-before">Confirm Password:</dt>
              <dd>
                <input type="password" name="confirm" value="" placeholder="Confirm Password" id="input-confirm">
              </dd>
            </dl>
            
            <div class="register_terms cf fixclea" style="zoom:1;">
              <span class="f_fl mr_5 sp1">
                <input id="agree" type="checkbox" name="agree" value="1" checked="checked"/>
              </span>
              <span class="f_fl" style="white-space: nowrap;">I agree to Hot Beauty Hair <a class="agree" href="<?php echo $agree_url; ?>">Terms and Conditions.</a></span>
              <div class="erroragree" style="display:none;"></div>
            </div>
            
            <div class="register_tabbuton center_text">
              <button type="button" id="button-register" class="button">Submit</button>
            </div>

            <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
            <?php } ?>

          </div>
        </div>
        <!--/注册-->
        
        <!--登陆-->
        <div class="login">
            <h2><?php echo $text_returning_customer; ?></h2>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="register_tab">
            <!--<p><strong><?php echo $text_i_am_returning_customer; ?></strong></p>-->
              <dl class="fixclea">
              <dt class="req-before"><?php echo $entry_email; ?>:</dt>
              <dd>
                <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" />
              </dd>
            </dl>
            <dl class="fixclea">
              <dt class="req-before"><?php echo $entry_password; ?>:</dt>
              <dd>
                <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password"/>
                <p class="forgot-psw"><a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?> ?</a></p>
              </dd>
            </dl>
              
              <!--<div class="form-group">
                <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
                <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
                <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></div>-->
              <div class="register_tabbuton center_text">
            <input type="submit" value="<?php echo $button_login; ?>" class="button" />
          </div>
              
              <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
              <?php } ?>
            </form>
        </div>
        <!--/登陆-->
        
      <!--</div>
      <?php echo $content_bottom; ?>-->
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