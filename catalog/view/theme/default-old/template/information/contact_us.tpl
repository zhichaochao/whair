
<form id="contact_usid" method="post" action="" name="contact_us"> 
<div class="merchant_soyouul cf">

<div class="cf">
  <div class="dll">
     <span class="sp1"><i class="col_zs">*</i><?php echo $entry_name; ?>:</span>
     <span class="sp2">
        <input class="cont-uname" type="text" name="name" value="<?php echo $name; ?>">                
     </span>
     <div class="text-danger text-danger-name"></div>
     <?php if ($error_name) { ?>
     <div class="text-danger"><?php echo $error_name; ?></div>
     <?php } ?>
  </div>
  <div class="dll">
     <span class="sp1"><i class="col_zs">*</i>Email Address :</span>
     <span class="sp2">
        <input class="cont-email" type="text" name="email" value="<?php echo $email; ?>">
     </span>
     <div class="text-danger text-danger-email"></div>
     <?php if ($error_email) { ?>
     <div class="text-danger"><?php echo $error_email; ?></div>
     <?php } ?>
  </div>  
  
  <div class="dll">
     <span class="sp1">Tel Number :</span>
     <span class="sp2">
        <input class="cont-fixed" type="text" name="fixed_line" value="<?php echo $fixed_line; ?>">
     </span>
  </div>  
  <div class="dll">
     <span class="sp1">Country :</span>
     <span class="sp2">
       <select name="country_id" id="enquiry-country">
	     <option value="">Please Choose Your Country</option>
	     <?php foreach ($countries as $country) { ?>
		 <option value="<?php echo $country['country_id']; ?>" <?php if($country['name']=='United States'){ ?>selected="selected"<?php } ?>><?php echo $country['name']; ?></option>
	     <?php } ?>
	   </select>
     </span>
  </div>
  <div class="dll">
     <span class="sp1">Factime& iMesssage ID:</span>
     <span class="sp2">
        <input class="cont-phone" type="text" name="phone" value="<?php echo $phone; ?>">
     </span>
  </div>
  <div class="dll">
     <span class="sp1">Whatsapp ID:</span>
     <span class="sp2">
        <input class="cont-whatsapp" type="text" id="whatsapp" name="whatsapp" value="<?php echo $whatsapp; ?>">
     </span>
  </div>
            
</div>                               

<div class="cf">
  <div class="dlb">
     <span class="sp1"><i class="col_zs">*</i><?php echo $entry_enquiry; ?>:</span>
     <span class="sp2">
        <textarea name="enquiry" cols="30" class="cont-textarea"><?php echo $enquiry; ?></textarea>              
        <div class="text-danger text-danger-textarea"></div>
        <?php if ($error_enquiry) { ?>
		<div class="text-danger"><?php echo $error_enquiry; ?></div>
		<?php } ?>
        <p><i class="col_zs">Tips :</i> We will contact you with 24 hours after we receive your request</p>
     </span>
     
  </div>
</div>       
 
<div class="dlbbut">
  <!--<button id="submint_contact" onclick="ga('send', 'pageview', '/enquiry-virtual/online'); return false;">SUBMIT</button>-->
  <?php
   $class = '';
   switch($croute){
    case 'information/company/overview':
        $class = 'inquiry-overview-gtm';
        break;
    case 'information/company/capacity':
        $class = 'inquiry-capacity-gtm';
        break;
    case 'information/service/wholesales':
        $class = 'inquiry-wholesales-gtm';
        break;
    case 'information/service/salon':
        $class = 'inquiry-salon-gtm';
        break;
    case 'information/service/store':
        $class = 'inquiry-store-gtm';
        break;
    case 'information/service/online ':
        $class = 'inquiry-online-gtm';
        break;
   }
  ?>
  <input class="btn btn-primary con-btn-submit <?php echo $class; ?>" type="submit" onclick="return false;" value="<?php echo $button_submit; ?>" />
  <span>* indicated required</span>
</div>

</div><!--/merchant_soyouul-->
</form>
<script>
	jQuery(function($){
		var $btn = $('.con-btn-submit'),
                    $uName = $('.cont-uname'),
                    $uEmail = $('.cont-email'),
                    $uTel = $('.cont-fixed'),
                    $uCountry = $('#enquiry-country'),
                    $uPhone = $('.cont-phone'),
                    $uContent = $('.cont-textarea'),
                    $uNameTip = $('.text-danger-name'),
                    $uEmailTip = $('.text-danger-email'),
                    $uContentTip = $('.text-danger-textarea'),
                    $whatapps = $('#whatsapp');
                
                var clickTf = true;
		$btn.click(function(){
                    if(clickTf){
                        clickTf = false;
                        var uName = $uName.val(),
                            uEmail = $uEmail.val(),
                            uTel = $uTel.val(),
                            uCountry = $uCountry.val(),
                            uPhone = $uPhone.val(),
                            uContent = $uContent.val(),
                            whatapps = $whatapps.val();

                        var url_string = "<?php echo $url_string; ?>";			

                        $.ajax({
                                type:"post",
                                url:"<?php echo $action; ?>",
                                async:true,
                                data:{
                                        'name': uName,
                                        'email': uEmail,
                                        'fixed_line': uTel,
                                        'country_id': uCountry,
                                        'phone': uPhone,
                                        'enquiry': uContent,
                                        'url_string':url_string,
                                        'whatsapp':whatapps
                                },
                                dataType:'json',
                                success:function(res){
                                        $uNameTip.text('');
                                        $uEmailTip.text('');
                                        $uContentTip.text('');
                                        if(res.code == 0) {
                                            clickTf = true;
                                            $uNameTip.text(res.data.error_name);
                                            $uEmailTip.text(res.data.error_email);
                                            $uContentTip.text(res.data.error_enquiry);
                                            alert(res.message)
                                        }else{
                                            location.href = res.url;												
                                        }
                                }
                        });
                        
                    }
                    
		});
	});
</script>  