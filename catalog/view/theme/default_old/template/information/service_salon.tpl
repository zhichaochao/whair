<?php echo $header; ?>

<section>
  <div class="container service-container">
  
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
    <?php } ?>
      
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
    <?php } ?>
  
    <div class="sellfrom">
      <p class="teimg"><img src="/catalog/view/theme/default/images/tzx/service/sell_from1.jpg" width="876" height="308"></p>
      <h2>Gain loyalty from your clients by selling Ted Hair's premium hair 
        extensions from your salon or styling chair!
      </h2>
      <p class="pp">Ted Hair is the perfect partner for salon owners and stylists that want to provide their customers 
        with a premium product. You can place an urgent order and we will always deliver the hair to you 
        in time for your clients' installation appointment.</p>
    </div>
    
    <div class="sellform_with">
      <h2>With Ted Hair's solutions you will get:</h2>
      <ul class="sellform_ul sellform_ul2 cf">
        <li>
          <p class="p1"><img src="/catalog/view/theme/default/images/tzx/service/advantage_1_hov.png" width="91" height="91"></p>
          <p class="p2">100% virgin human hair with cuticle intact</p>
        </li>
        <li>
          <p class="p1"><img src="/catalog/view/theme/default/images/tzx/service/advantage_5_hov.png" width="91" height="91"></p>
          <p class="p2">Wholesale prices</p>
        </li>
        <li>
          <p class="p1"><img src="/catalog/view/theme/default/images/tzx/service/advantage_2_hov.png" width="91" height="91"></p>
          <p class="p2">Flexible online ordering and fast shipping </p>
        </li>
        <li>
          <p class="p1"><img src="/catalog/view/theme/default/images/tzx/service/advantage_6_hov.png" width="91" height="91"></p>
          <p class="p2">7-Day return and exchange guarantee</p>
        </li>
          <li>
          <p class="p1"><img src="/catalog/view/theme/default/images/tzx/service/advantage_7_hov.png" width="91" height="91"></p>
          <p class="p2">Educational opportunities</p>
        </li>
      </ul>
    </div>
    
    <div class="sellfrom_how">
    <h2>How to start?</h2>
    <p>
    By filling in the following form and submit your informaiton, 
you will receive the wholesale prices from one of our sales persons shortly!
    </p>
    </div>
    
    <div class="merchant_soyou sellfrom_salon2" id="wholesales-div">
      <h2>You are one step away to access to our wholesale prices</h2>      
      <?php echo $contact_us; ?>      
    </div>    
    
  </div><!--/container-->
</section>

<script type="text/javascript">
//$('#enquiry').focus(function (){
//    if ($(this).val() == 'Briefly explain what type of business you operate and what specific type of products you are interested in.'){
//        $('#enquiry').val('').css("color","");
//        }
//    }).blur(function(){
//        if($(this).val() == ''){
//            $('#enquiry').val('Briefly explain what type of business you operate and what specific type of products you are interested in.').css("color","#aaaaaa");
//        }
//    });
//$('#submint_contact').click(function(){
//    var form = $('#contact_usid');
//    var enquiry = $('#enquiry');
//    var email = $('#email-address');
//    var business = $('#business');
//    var phone = $('#phone');
//    var contactname = $('#contactname');
//    var inquiry_country_id = $('#inquiry_country_id').val();
//    var verification_code = $('#antirobotreg').val();
//    var message = '';
//    if (!email.val() || email.val().search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) == - 1){
//       message += 'Please make sure you entered an Email Address ' + "\n";
//    }
//    if (!contactname.val()){
//        message += 'Please enter your Name ' + "\n";
//    }
////    if (!business.val()){
////        message += 'Please enter your Business Name ' + "\n";
////    }
//    if (!phone.val() && phone.val().length < 5){
//        message += 'Please enter your Phone Number ' + "\n";
//    }
//	if(!inquiry_country_id){
//		message += 'Please select country ' + "\n";
//	}
//    if (enquiry.val().length < 4 && enquiry.val()!='Briefly explain what type of business you operate'){
//        message += 'Please enter Type of Business ' + "\n";
//    }
//    if(!verification_code){
//        message += 'Please enter Validation Code ' + "\n";
//    }
//    
//    if (message.length == 0){
//        form.submit();
//    } else{
//        alert('Notes:' + "\n"+message);
//    }
//    });
</script>

<?php echo $footer; ?>
