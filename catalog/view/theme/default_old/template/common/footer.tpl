<div class="footer jwx_footer">
    <div class="footer_cont">
      <div class="container" style="width:1200px;padding: 0;">
        <ul class="footer_contul cf">
        <?php foreach($informations as $key => $information) { ?>
          <li class="li">
            <h4><?php echo $key; ?></h4>
            <?php foreach($information as $value) { ?>
              <p><a href="<?php echo $value['seo_url']; ?>" target="_blank"><?php echo $value['title']; ?></a></p>
            <?php } ?>
          </li>
        <?php } ?>
          
          <li class="li">
            <h4>Subscribe</h4>
            <p style="font-size:13px;">Be the first to know about our latest products.</p>
            <p><input type="email" name="txtemail" id="txtemail" value="" placeholder="Your Email Address" class="text1"></p>
            <p>
               <button type="submit" class="btn1" onClick="return subscribe();">SUBMIT</button>
            </p>
          </li>
          
          <li class="li5">
            <h4>CONTACT</h4>
            <p><i class="ci1"></i><a href="javascript:;"><?php echo $telephone; ?></a></p>
            <?php if($skype) { ?>
              <p><i class="ci2"></i><a href="javascript:;">Skype:<?php echo $skype; ?></a></p>
            <?php } ?>
            <p><i class="ci4"></i><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
          </li>
        </ul>
      </div>
    </div>
    <div class="footer_link">
      <div class="container">
        <!--<div class="footer_two_img"> <img src="catalog/view/theme/default/image/payment1.gif"><img src="catalog/view/theme/default/image/PositiveSSL_tl_trans2.png"><img src="catalog/view/theme/default/image/payment2.gif"> </div>-->
        <div class="copyright"> Copyright Notice &copy; 2016-<?php echo date('Y'); ?> <?php echo $_SERVER['SERVER_NAME']; ?> All rights reserved </div>
      </div>
    </div>
    
    <div class="loading" style="display: none;">
      <div class="overlay"></div>
      <div class="loading-img"></div>
    </div>
  </div>
  
  
    
<script>
function subscribe()
{
    var emailpattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var email = $('#txtemail').val();
    if(email != "")
    {
        if(!emailpattern.test(email))
        {
            alert("Invalid Email");
            return false;
        }
        else
        {
            $.ajax({
                url: 'index.php?route=module/newsletters/news',
                type: 'post',
                data: 'email=' + $('#txtemail').val(),
                dataType: 'json',

                success: function(json) {
                    alert(json.message);
                }
            });
            return false;
        }
    }
    else
    {
        alert("Email Is Require");
        $(email).focus();
        return false;
    }
}
</script>


<!-------------------------------------------------------------------->
<!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
  <?php echo html_entity_decode($chat_code); ?>
</script>

<!--End of Zopim Live Chat Script-->
<!-------------------------------------------------------------------->

<div class="jwx_back_top">
    <div class="back_top"><a href="javascript:void(0);"></a></div>
  </div>
</body>
</html>