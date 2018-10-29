<!--返回顶部-->
    <div class="xf_right">
      <a href="<?php echo $vip?>"><div class="vip"><span>VIP</span></div></a>
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
                          <p><span><?php echo $yd_Call; ?></span> <?=$telephone;?></a></p>
                          <p><span><?php echo $yd_Whatsapp; ?></span>+<?php echo $whatsapp; ?></p>
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
                      <li><a target="_blank"  href="https://www.facebook.com/<?=$facebook;?>"><img src="/catalog/view/theme/default/img/png/fot_1.png" alt=""></a></li>
                      <li><a target="_blank"  href="https://www.instagram.com/<?=$instagram;?>"><img src="/catalog/view/theme/default/img/png/fot_2.png" alt=""></a></li>
                      <li><a target="_blank"  href="https://api.whatsapp.com/send?phone=<?=$whatsapp;?>"><img src="/catalog/view/theme/default/img/png/fot_3.png" alt=""></a></li>
                    </ol>
                      </li>
              </ul>
        </div>
      </div>
      <div class="bot clearfix">
        
        <p>Copyright Notice &copy; 2009-<?php echo (($Y = intval(date('Y'))) > 2017) ? "$Y" : '';?> <?php echo $_SERVER['SERVER_NAME']; ?>  All rights reserved </p>
      </div>
    </div>
    
    <!--yd底部-->
    <div class="yd_footer clearfix" >
      <div class="top" >
        <ul class="ul_ydfot clearfix">
              <?php foreach($informations as $key => $information) { ?>
           <li>
                  <h4><?php echo $information['title']; ?> <div class="pic_img"><img src="/catalog/view/theme/default/img/png/jiahao_white.png" data-img='/catalog/view/theme/default/img/png/jiahao_white.png' data-imgs='/catalog/view/theme/default/img/png/jianhao_white.png'/></div></h4>
                  <div class="slide_div">
                    <ol>    <?php foreach($information['child'] as $subkey=>$subval) { ?> 
                      <li><a href="<?php echo $subval['url']; ?>"><?php echo $subval['title']; ?></a></li>
                       <?php } ?>
                      
                    </ol>
                  </div>
                    </li>
        <?php } ?>
       
                    <li>
                      <h4>COMPANY INFO<div class="pic_img"><img src="/catalog/view/theme/default/img/png/jiahao_white.png" data-img='/catalog/view/theme/default/img/png/jiahao_white.png' data-imgs='/catalog/view/theme/default/img/png/jianhao_white.png'/></div></h4>
                      <div class="slide_div">
                        <ol>
                      <li><a target="_blank" href="https://tel://<?=$telephone;?>"><span>Call Us:</span><?=$telephone;?></li></a>  
                      <li><a target="_blank" href="https://api.whatsapp.com/send?phone=<?=$whatsapp;?>"><span>Whatsapp:</span> +<?php echo $whatsapp; ?></a></li>
                      <li><a target="_blank" href="https://mailto:<?php echo $email; ?>"><span>Email:</span><?php echo $email; ?></a></li>
                      <li>                       
                          <a ><span><?php echo $yd_Address; ?></span><?php echo $yd_Addcont; ?></a>                  
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
                      <li><a href="https://www.facebook.com/<?=$facebook;?>"><img src="/catalog/view/theme/default/img/png/yd_fot1.png" alt=""></a></li>
                      <li><a href="https://www.instagram.com/<?=$instagram;?>"><img src="/catalog/view/theme/default/img/png/yd_fot2.png" alt=""></a></li>
                      <li><a href="https://api.whatsapp.com/send?phone=<?=$whatsapp;?>"><img src="/catalog/view/theme/default/img/png/yd_fot3.png" alt=""></a></li>
                      <li><a href="skype:<?=$skype;?>?chat" target="blank"><img src="/catalog/view/theme/default/img/png/yd_fot4.png" alt=""></a></li>
                    </ol>
                      </div>
                    </li>
        </ul>
      </div>
      <p class="clearfix">Copyright Notice &copy; 2009-<?php echo (($Y = intval(date('Y'))) > 2017) ? "$Y" : '';?> <?php echo $_SERVER['SERVER_NAME']; ?>  All rights reserved</p>
    </div>
    <div class="yd_footer2" >
      <ol class="ol_ydfot clearfix">
        <?php if($sername =='/'){ ?>   
        <li class="active">
            <a href="<?php echo $home?>">
              <img class="active" src="/catalog/view/theme/default/img/png/home-1.png" alt="" />
              <img src="/catalog/view/theme/default/img/png/home-2.png" alt="" />
              <p>HOME</p>
            </a>
          </li>
       <?php }else{ ?>
          <li class="<?=strpos($thispage,'common' ) !== false ?'active':'';?>">
          <a href="<?php echo $home?>">
            <img class="active" src="/catalog/view/theme/default/img/png/home-1.png" alt="" />
            <img src="/catalog/view/theme/default/img/png/home-2.png" alt="" />
            <p>HOME</p>
          </a>
        </li>
        <?php }?>
        <li class="<?=strpos($thispage,'product') !== false ?'active':'';?>">
          <a href="<?php echo $contac?>">
            <img class="active" src="/catalog/view/theme/default/img/png/fenlei-1.png" alt="" />
            <img src="/catalog/view/theme/default/img/png/fenlei-2.png" alt="" />
            <p>ALL HAIR</p>
          </a>
        </li>
        <li>
          <a class="contact" href="javascript:0;"  onclick="return false">
            <img class="active" src="/catalog/view/theme/default/img/png/contact-1.png" alt="" />
            <img src="/catalog/view/theme/default/img/png/contact-2.png" alt="" />
            <p>CONTACT</p>
          </a>
          <div class="a_text">
            <a href="tel://<?=$telephone;?>"><img src="/catalog/view/theme/default/img/jpg/fot_con1.jpg"/></a>
            <a href="skype:<?=$skype;?>?chat"><img src="/catalog/view/theme/default/img/jpg/fot_con2.jpg"/></a>
            <a href="mailto:<?php echo $email; ?>"><img src="/catalog/view/theme/default/img/jpg/fot_con3.jpg"/></a>
          </div>
        </li>
       <!--  <li>
          <a href="###">
            <img class="active" src="/catalog/view/theme/default/img/png/contact-1.png" alt="" />
            <img src="/catalog/view/theme/default/img/png/contact-2.png" alt="" />
            <p>CONTACT</p>
          </a>
        </li> -->
        <li class="<?=strpos($thispage,'checkout') !== false ?'active':'';?>">
          <a href="<?php echo $cart?>">
            <img class="active" src="/catalog/view/theme/default/img/png/cart-1.png" alt="" />
            <img src="/catalog/view/theme/default/img/png/cart-2.png" alt="" />
            <p><span class='cart_count'><?=$text_cart_items;?></span>CART</p>
          </a>
        </li>
        <li class="<?=strpos($thispage,'account') !== false ?'active':'';?>">
          <a href="<?php echo $account_left?>">
            <img class="active" src="/catalog/view/theme/default/img/png/account-1.png" alt="" />
            <img src="/catalog/view/theme/default/img/png/account-2.png" alt="" />
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
