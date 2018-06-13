<!--返回顶部-->
    <div class="xf_right">
      <div class="vip"><a href="###"><span>VIP</span></a></div>
      <div class="top"><span>TOP</span></div>
    </div>





    
    <!--底部-->
    <div class="footer clearfix" >
      <div class="content clearfix">
        <div class="left clearfix">
          <ul class="clearfix">
          <!-- <?php foreach($informations as $key => $information) { ?>
          <li class="li">
            <h4><?php echo $key; ?></h4>
            <?php foreach($information as $value) { ?>
              <p><a href="<?php echo $value['seo_url']; ?>" target="_blank"><?php echo $value['title']; ?></a></p>
            <?php } ?>
          </li>
        <?php } ?> -->

                      <li>
                    <h4>INFORMATION</h4>
                          <a href="#" target="_blank"><?php echo $yd_About; ?></a>
                          <a href="#" target="_blank"><?php echo $yd_After; ?></a>
                          <a href="#" target="_blank"><?php echo $yd_Privacy; ?></a>
                          <a href="#" target="_blank"><?php echo $yd_Hair; ?></a>
                      </li>
                    <li>
                    <h4>BUYER INSTRUCTION</h4>
                          <a href="#" target="_blank"><?php echo $yd_How; ?></a>
                          <a href="#" target="_blank"><?php echo $yd_FAQ; ?></a>
                          <a href="#" target="_blank"><?php echo $yd_Shipment; ?></a>
                          <a href="#" target="_blank"><?php echo $yd_Return; ?></a>
                      </li>
                      <li>
                    <h4><?php echo $informations[2]['title']; ?></h4>
                          <a href="<?php echo $informations[2]['child'][0]['url']; ?>" target="_blank"><?php echo $informations[2]['child'][0]['title']; ?></a>
                          <a href="<?php echo $informations[2]['child'][1]['url']; ?>" target="_blank"><?php echo $informations[2]['child'][1]['title']; ?></a>
                          <a href="<?php echo $informations[2]['child'][2]['url']; ?>" target="_blank"><?php echo $informations[2]['child'][2]['title']; ?></a>
                          <a href="<?php echo $informations[2]['child'][3]['url']; ?>" target="_blank"><?php echo $informations[2]['child'][3]['title']; ?></a>
                      </li>

                      <!-- <li class="li5">
            <h4>CONTACT</h4>
            <p><i class="ci1"></i><a href="javascript:;"><?php echo $telephone; ?></a></p>
            <?php if($skype) { ?>
              <p><i class="ci2"></i><a href="javascript:;">Skype:<?php echo $skype; ?></a></p>
            <?php } ?>
            <p><i class="ci4"></i><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
          </li> -->
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
                      <li><a href="###"><img src="catalog/view/theme/default/img/png/fot_1.png" alt=""></a></li>
                      <li><a href="###"><img src="catalog/view/theme/default/img/png/fot_2.png" alt=""></a></li>
                      <li><a href="###"><img src="catalog/view/theme/default/img/png/fot_3.png" alt=""></a></li>
                      <li><a href="###"><img src="catalog/view/theme/default/img/png/fot_4.png" alt=""></a></li>
                    </ol>
                      </li>
              </ul>
        </div>
      </div>
      <div class="bot clearfix">
        <p>Copyright Notice &copy; 2016-2018 www.hotbeautyhairmall.com All rights reserved </p>
      </div>
    </div>
    
    <!--yd底部-->
    <div class="yd_footer clearfix" >
      <div class="top" >
        <ul class="ul_ydfot clearfix">
          <li>
                  <h4>INFORMATION <div class="pic_img"><img src="catalog/view/theme/default/img/png/jiahao_white.png"/></div></h4>
                  <div class="slide_div">
                    <ol>
                      <li><a href="###">About Us</a></li>
                      <li><a href="###">After Sale Service</a></li>
                      <li><a href="###">Privacy Policy</a></li>
                      <li><a href="###">Hair Club</a></li>
                    </ol>
                  </div>
                    </li>
                  <li>
                  <h4>BUYER INSTRUCTION<div class="pic_img"><img src="catalog/view/theme/default/img/png/jiahao_white.png"/></div></h4>
                  <div class="slide_div">
                    <ol>
                      <li><a href="###">How To Order</a></li>
                      <li><a href="###">FAQ</a></li>
                      <li><a href="###">Shipment & Pay</a></li>
                      <li><a href="###">Return Policy</a></li>
                    </ol>
                  </div>
                    </li>
                    <li>
                  <h4>MY ACCOUNT<div class="pic_img"><img src="catalog/view/theme/default/img/png/jiahao_white.png"/></div></h4>
                  <div class="slide_div">
                    <ol>
                      <li><a href="###">My Account</a></li>
                      <li><a href="###">My Order</a></li>
                      <li><a href="###">My Wish List</a></li>
                      <li><a href="###">Site Map</a></li>
                    </ol>
                  </div>
                    </li>
                    <li>
                      <h4>COMPANY INFO<div class="pic_img"><img src="catalog/view/theme/default/img/png/jiahao_white.png"/></div></h4>
                      <div class="slide_div">
                        <ol>
                      <li><a href="###"><span>Call Us:</span> U.S No: 6262487420</li>
                      <li><a href="###"><span>Whatsapp:</span> +8615800028742</a></li>
                      <li><a href="###"><span>Email:</span> rebecca@hotbeautyhair.com</a></li>
                      <li>
                        <a href="###">
                          <span>Address:</span>
                              R6403, Jiahe Creative Industry Park, No.63 of North Huangbian Road, 
                    Baiyun District, Guangzhou, China.
                        </a>
                      </li>
                    </ol>
                  </div>
                    </li>
                    <li>
                      <h4>SUBSCRIBE</h4>
                      <div class="slide_div" style="display: block !important;">
                        <p>Be the first to know about our latest products.</p>
                    <input value="" placeholder="Your Email Address">
                    <button type="submit">SUBMIT</button>
                    <ol class="fot_img clearfix">
                      <li><a href="###"><img src="catalog/view/theme/default/img/png/yd_fot1.png" alt=""></a></li>
                      <li><a href="###"><img src="catalog/view/theme/default/img/png/yd_fot2.png" alt=""></a></li>
                      <li><a href="###"><img src="catalog/view/theme/default/img/png/yd_fot3.png" alt=""></a></li>
                      <li><a href="###"><img src="catalog/view/theme/default/img/png/yd_fot4.png" alt=""></a></li>
                    </ol>
                      </div>
                    </li>
        </ul>
      </div>
      <p class="clearfix">Copyright Notice &copy; 2016-2018 www.hotbeautyhairmall.com All rights reserved</p>
    </div>
    <div class="yd_footer2" >
      <ol class="ol_ydfot clearfix">
        <li class="active">
          <a href="###">
            <img class="active" src="catalog/view/theme/default/img/png/home-1.png" alt="" />
            <img src="catalog/view/theme/default/img/png/home-2.png" alt="" />
            <p>HOME</p>
          </a>
        </li>
        <li>
          <a href="###">
            <img class="active" src="catalog/view/theme/default/img/png/fenlei-1.png" alt="" />
            <img src="catalog/view/theme/default/img/png/fenlei-2.png" alt="" />
            <p>ALL HAIR</p>
          </a>
        </li>
        <li>
          <a href="###">
            <img class="active" src="catalog/view/theme/default/img/png/contact-1.png" alt="" />
            <img src="catalog/view/theme/default/img/png/contact-2 .png" alt="" />
            <p>CONTACT</p>
          </a>
        </li>
        <li>
          <a href="###">
            <img class="active" src="catalog/view/theme/default/img/png/cart-1.png" alt="" />
            <img src="catalog/view/theme/default/img/png/cart-2.png" alt="" />
            <p>CART</p>
          </a>
        </li>
        <li>
          <a href="###">
            <img class="active" src="catalog/view/theme/default/img/png/account-1.png" alt="" />
            <img src="catalog/view/theme/default/img/png/account-2.png" alt="" />
            <p>ACCOUNT</p>
          </a>
        </li>
      </ol>
    </div>
   
   <div class="modal img_modal" style="display: none;">
      <div class="text">
        <div class="close"></div>
        <!--<img class="login_img" src="img/jpg/pc_modal.jpg"/>-->
        <a class="login_a" href="###"></a>
      </div>
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
