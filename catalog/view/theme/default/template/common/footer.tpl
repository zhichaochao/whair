<!--返回顶部-->
    <div class="xf_right">
      <div class="vip"><a href="<?php echo $order?>"><span>VIP</span></a></div>
      <div class="top"><span>TOP</span></div>
    </div>





    
    <!--底部-->
    <div class="footer clearfix" >
      <div class="content clearfix">
        <div class="left clearfix">
          <ul class="clearfix">
          <?php foreach($informations as $key => $information) { ?>
          <li class="li">
            <h4><?php echo $information['title']; ?></h4>
            <?php foreach($information['child'] as $subkey=>$subval) { ?> 
              <p><a href="<?php echo $subval['url']; ?>"><?php echo $subval['title']; ?></a></p>
            <?php } ?>
          </li>
        <?php } ?>
                      <li>
                    <h4>COMPANY INFO</h4>
                          <p><span><?php echo $yd_Call; ?></span> U.S No: 6262487420</p>
                          <p><span><?php echo $yd_Whatsapp; ?></span><?php echo $telephone; ?></p>
                          <p><span><?php echo $yd_Email; ?></span><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
                        <p style="max-width:260px;line-height: 18px;margin-top: 3px;margin-bottom: 0;">
                          <span><?php echo $yd_Address; ?></span><?php echo $yd_Addcont; ?>
                          </p>
                      </li>
                      <li>
                        <h4>SUBSCRIBE</h4>

                    <p>Be the first to know about our latest products.</p>
                    <!-- <input value="" placeholder="Your Email Address"> -->
                    <input type="email" name="txtemail" id="txtemail" value="" placeholder="Your Email Address" class="text1">
                    <button type="submit" class="btn1" onClick="return subscribe();">SUBMIT</button>

                    <ol class="clearfix">
                      <li><a href="hotbeautymelisha"><img src="catalog/view/theme/default/img/png/fot_1.png" alt=""></a></li>
                      <li><a href="hotbeautyhairofficia"><img src="catalog/view/theme/default/img/png/fot_2.png" alt=""></a></li>
                      <li><a href="###"><img src="catalog/view/theme/default/img/png/fot_3.png" alt=""></a></li>
                      <li><a href="hotbeautymelisha"><img src="catalog/view/theme/default/img/png/fot_4.png" alt=""></a></li>
                    </ol>
                      </li>
              </ul>
        </div>
      </div>
      <div class="bot clearfix">
        
        <p>Copyright Notice &copy; 2016-<?php echo (($Y = intval(date('Y'))) > 2017) ? "$Y" : '';?> <?php echo $_SERVER['SERVER_NAME']; ?>  All rights reserved </p>
      </div>
    </div>
    
    <!--yd底部-->
    <div class="yd_footer clearfix" >
      <div class="top" >
        <ul class="ul_ydfot clearfix">
              <?php foreach($informations as $key => $information) { ?>
           <li>
                  <h4><?php echo $information['title']; ?> <div class="pic_img"><img src="catalog/view/theme/default/img/png/jiahao_white.png"/></div></h4>
                  <div class="slide_div">
                    <ol>    <?php foreach($information['child'] as $subkey=>$subval) { ?> 
                      <li><a href="<?php echo $subval['url']; ?>"><?php echo $subval['title']; ?></a></li>
                       <?php } ?>
                      
                    </ol>
                  </div>
                    </li>
        <?php } ?>
       
                    <li>
                      <h4>COMPANY INFO<div class="pic_img"><img src="catalog/view/theme/default/img/png/jiahao_white.png"/></div></h4>
                      <div class="slide_div">
                        <ol>
                      <li><a href=""><span>Call Us:</span> U.S No: 6262487420</li></a>  
                      <li><a href="###"><span>Whatsapp:</span> <?php echo $telephone; ?></a></li>
                      <li><a href="mailto:<?php echo $email; ?>"><span>Email:</span><?php echo $email; ?></a></li>
                      <li>                       
                          <a href=""><span><?php echo $yd_Address; ?></span><?php echo $yd_Addcont; ?></a>                  
                      </li>
                    </ol>
                  </div>
                    </li>
                    <li>
                      <h4>SUBSCRIBE</h4>
                      <div class="slide_div" style="display: block !important;">
                        <p>Be the first to know about our latest products.</p>
                    <input type="email" name="txtemail" id="txtemail" value="" placeholder="Your Email Address" class="text1">
                    <button type="submit" class="btn1" onClick="return subscribe();">SUBMIT</button>
                    <ol class="fot_img clearfix">
                      <li><a href="hotbeautymelisha"><img src="catalog/view/theme/default/img/png/yd_fot1.png" alt=""></a></li>
                      <li><a href="hotbeautyhairofficia"><img src="catalog/view/theme/default/img/png/yd_fot2.png" alt=""></a></li>
                      <li><a href="###"><img src="catalog/view/theme/default/img/png/yd_fot3.png" alt=""></a></li>
                      <li><a href="hotbeautymelisha"><img src="catalog/view/theme/default/img/png/yd_fot4.png" alt=""></a></li>
                    </ol>
                      </div>
                    </li>
        </ul>
      </div>
      <p class="clearfix">Copyright Notice &copy; 2016-<?php echo (($Y = intval(date('Y'))) > 2017) ? "$Y" : '';?> <?php echo $_SERVER['SERVER_NAME']; ?>  All rights reserved</p>
    </div>
    <div class="yd_footer2" >
      <ol class="ol_ydfot clearfix">
        <li class="active">
          <a href="<?php echo $home?>">
            <img class="active" src="catalog/view/theme/default/img/png/home-1.png" alt="" />
            <img src="catalog/view/theme/default/img/png/home-2.png" alt="" />
            <p>HOME</p>
          </a>
        </li>
        <li>
          <a href="<?php echo $contac?>">
            <img class="active" src="catalog/view/theme/default/img/png/fenlei-1.png" alt="" />
            <img src="catalog/view/theme/default/img/png/fenlei-2.png" alt="" />
            <p>ALL HAIR</p>
          </a>
        </li>
        <li>
          <a href="">
            <img class="active" src="catalog/view/theme/default/img/png/contact-1.png" alt="" />
            <img src="catalog/view/theme/default/img/png/contact-2 .png" alt="" />
            <p>CONTACT</p>
          </a>
        </li>
        <li>
          <a href="<?php echo $cart?>">
            <img class="active" src="catalog/view/theme/default/img/png/cart-1.png" alt="" />
            <img src="catalog/view/theme/default/img/png/cart-2.png" alt="" />
            <p>CART</p>
          </a>
        </li>
        <li>
          <a href="<?php echo $dashboard?>">
            <img class="active" src="catalog/view/theme/default/img/png/account-1.png" alt="" />
            <img src="catalog/view/theme/default/img/png/account-2.png" alt="" />
            <p>ACCOUNT</p>
          </a>
        </li>
      </ol>
    </div>


  </body>
</html>
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
