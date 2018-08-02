<?php echo $header; ?>

  
  <!--错误提示-->
  <div id="checkout-login" class="alert alert-danger" style="display:none;" ></div>
  
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
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
              <!-- 新登录 -->
              <!-- <form class="login_form lr_form"> -->
              <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="login_form lr_form">
                <label for="">
                  <span>E-Mail Address <i class="red_i">*</i></span>
                  <!-- <input class="email email1" type="text" /> -->
                  <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" />
                 <p class="ts_p"    <?php if ($error_warning) { ?>  style='display:block;' <?php } ?>><?php if ($error_warning) { ?><?php echo $error_warning; ?><?php }else{ ?>The email address you entered is incorrect<?php } ?></p>
                </label>
                <label for="">
                  <span>Password <i class="red_i">*</i></span>
                  <!-- <input class="pass pass1" type="password"/> -->
                  <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password"/>
                  <p class="ts_p" >The password you entered is incorrect</p>
                  <a href="<?php echo $forgotten?>">Forgotten Password ?</a>
                </label>
                <input class="tj_input" type="submit" value="SIGN IN" />
                <input type="hidden" name="redirect" value='<?=$redirect;?>'/>
              </form>
            </li>
            <li>
           <!-- 新 注册 -->
            <div class="register" id="register-form-div" >
              <p class="bt_p">New Customers</p>
              <!-- <div class="res_form lr_form"> -->
              <form class="res_form lr_form"  > 
                <label class="clearfix label_name" for="">
                  <span>First Name <i class="red_i">*</i></span>
                 <!--  <input class="name name1" type="text" value="" /> -->
                  <input type="text" name="firstname" maxlength="32" value="" placeholder="Firstname" id="input-firstname" class="name name1">
                  <p class="ts_p" id="errorfirstname">Please enter your first name</p>
                </label>
                <label class="clearfix label_names" for="">
                  <span>Last Name <i class="red_i">*</i></span>
                 <!--  <input class="name name2" type="text" value="" /> -->
                  <input type="text" name="lastname" maxlength="32" value="" placeholder="Lastname" id="input-lastname" class="name name2">
                  <p class="ts_p" id="errorlastname">Please enter your last name</p>
                </label>
                <label class="clearfix" for="">
                  <span>E-Mail Address <i class="red_i">*</i></span>
                 <!--  <input class="email email2"  type="text"/> -->
                  <input type="text" name="email" value="" placeholder="E-Mail Address" id="input-email" class="email email2">
                  <p class="ts_p" id="erroremail">Please enter your email address</p>
                </label>
                <label class="clearfix" for="">
                  <span>Password <i class="red_i">*</i></span>
                  <!-- <input class="pass pass2" type="password"/> -->
                  <input type="password" name="password" value="" placeholder="Password" id="input-password" class="pass pass2">
                  <p class="ts_p" id="errorpassword">Please enter your password</p>
                </label>
                <label class="clearfix" for="">
                  <span>Confirm Password <i class="red_i">*</i></span>
                  <input class="pass pass3" type="password" name="confirm" id="input-confirm" placeholder="Confirm Password"/>
                  <!-- <input type="password" name="confirm" value="" placeholder="Confirm Password" id="input-confirm" class="pass pass3"> -->
                  <p class="ts_p" id="errorconfirm">Please confirm the password</p>
                </label>
                <div class="xy_div">
                  <!-- <input type="checkbox"/> -->
                  <input id="agree" type="checkbox" name="agree" value="1" checked="checked"/>
                  <span class="span1"></span>
                  <span class="span2"></span>
                  <p>I agree to Hot Beauty Hair <a target="_blank" href="<?=$agree_url;?>">Terms and Conditions.</a><i class="red_i">*</i></p>
                  <div class="erroragree" style="display:none;"></div>
                </div>
                <p class="xy_p">*required field</p>
                
                <input class="tj_input" type="button" value="SIGN UP" id="button-register"/>
                <!-- <button type="button" id="button-register" class="tj_input">SIGN UP</button> -->
              </form>

                <div  class="zzc_li  hidden">
                <img src="/catalog/view/theme/default/img/loading.gif"/>
                <p>Sending an email, it may take a few seconds, please wait</p>
              </div>
              <!-- </div> -->
              </div>
            </li>
          </ul>
          
        </div>
      </div>
    </div>
<script>
// Register
$(document).delegate('#button-register', 'click', function() {
  // console.log($('#register-form-div input'));
    $(".zzc_li").css("display","block");
     $("div").addClass("hidden");
      $.ajax({
        url: '<?php echo $register;?>',
        type: 'post',
        data: $('#register-form-div input'),
        dataType: 'json',
      
        success: function(json) {
          if (json['redirect']) {

            // $(".zzc_li").css("display","block");
            // $("div").addClass("hidden");
            location = json['redirect']; 
            
            } else if (json['error']) {
          
         if (json['redirect']) {
            if(json['error']['agree']){
               $('.erroragree').show().html( json['error']['agree'] );
              }
                
            if(json['error']['firstname']){
               $('#errorfirstname').show().html( json['error']['firstname'] );
              }
            if(json['error']['lastname']){
               $('#errorlastname').show().html( json['error']['lastname'] );
              }
              if(json['error']['email']){
               $('#erroremail').show().html( json['error']['email'] );
              } 
              if(json['error']['password']){
               $('#errorpassword').show().html( json['error']['password'] );
              }
              if(json['error']['confirm']){
               $('#errorconfirm').show().html( json['error']['confirm'] );
              }
            } else{
               if(json['error']['warning']){
               $('#erroremail').show().html( json['error']['warning'] );
              }
               $(".zzc_li").css("display","none");
              $("div").removeClass("hidden");
            }   
                
            } 
        },
        error: function(xhr, ajaxOptions, thrownError) {
           alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});

  $(function(){
    $(".email").focus(function(){
      $(this).attr("placeholder","Enter email address");
    })
    $(".email").blur(function(){
      $(this).attr("placeholder","");
    })
    $(".pass").focus(function(){
      $(this).attr("placeholder","Please enter the password");
    })
    $(".pass").blur(function(){
      $(this).attr("placeholder","");
    })
    
    $(".name").change(function(){
      var text=$(this).val();
      var re=/^[a-zA-Z]+$/;
      if(!re.test(text) && text !=""){
        $(this).siblings(".ts_p").addClass("off");
        $(this).siblings(".ts_p").text("Please fill in in English");
      }else{
        $(this).siblings(".ts_p").removeClass("off");
      }
    })
    $(".email").change(function(){
      var text=$(this).val();
      var re=/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;
      if(!re.test(text) && text !=""){
        $(this).siblings(".ts_p").addClass("off");
        $(this).siblings(".ts_p").text("The email address you entered is incorrect");
      }else{
        $(this).siblings(".ts_p").removeClass("off");
      }
    })
    $(".pass").change(function(){
      var text=$(this).val();
      if(text.length<6 && text !=""){
        $(this).siblings(".ts_p").addClass("off");
        $(this).siblings(".ts_p").text("The password must be longer than 6 letters");
      }else{
        $(this).siblings(".ts_p").removeClass("off");
      }
    })
    $(".pass3").change(function(){
      var text=$(this).val();
      var pass_val = $(".pass2").val();
      // console.log( $(".pass2").val());
      // console.log( $(".pass3").val());
      if(text.length<6 && text !=""){
        $(this).siblings(".ts_p").addClass("off");
        $(this).siblings(".ts_p").text("The password must be longer than 6 letters");
      }else if(text!=pass_val){
        $(this).siblings(".ts_p").addClass("off");
        $(this).siblings(".ts_p").text("The passwords you entered are not consistent. Please re-enter them");
      }else{
        $(this).siblings(".ts_p").removeClass("off");
      }
    })
    
    //注册提交
    $(".res_form .tj_input").click(function(){
      var name1 = $(".name1").val();
      var name2 = $(".name2").val();
      var email2 = $(".email2").val();
      var pass2 = $(".pass2").val();
      var pass3 = $(".pass3").val();
      var bool = 0;
      
      $(".res_form .ts_p").each(function(){
        if($(this).hasClass("off")){
          bool=1;
          return bool;
        }
      })
      if(bool == 1){
        return false;
      }else{
        if((name1 !="")&&(name2 !="")&&(email2 !="")&&(pass2 !="")&&(pass3 !="")&&($(".xy_div input").hasClass("off"))){
          //正确
        }else{
          alert("* required field")
          return false;
        }
      }
    })
    
    //登陆提交
    $(".login_form .tj_input").click(function(){
      var email1 = $(".email1").val();
      var pass1 = $(".pass1").val();
      var bool = 0;
      
      $(".login_form .ts_p").each(function(){
        if($(this).hasClass("off")){
          bool=1;
          return bool;
        }
      })
      
      if(bool == 1){
        return false;
      }else{
        if((email1 !="")&&(pass1 !="")){
          //正确
        }else{
          alert("* required field")
          return false;
        }
      }
    })
    
  })
</script>
<?php echo $footer; ?>