  <?php if ($products || $vouchers) { ?>
  <h1>MY SHOPPING CART(<span><?=$total_items;?></span>) <div class="close"><img src="/catalog/view/theme/default/img/png/close2.png"></div></h1>
          
          <div class="has">
            <ul class="cart_ul">

                      <?php foreach($products as $product){ ?>
              <li class="clearfix">

                <a href="<?php echo $product['href']; ?>">
                <?php if ($product['thumb']) { ?>
                <div class="pic_img">
                         <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" />
                            </div>
                     <?php } ?>
                  <div class="text">
                    <h2><?php echo $product['name']; ?> </h2>
                    <?php if ($product['option']) { ?>                         
                               <?php foreach ($product['option'] as $option) { ?>             
                                <p>
                                 <?php if( !empty($option['name']) ){ ?>
                                   <?php echo $option['name'].': '; ?><?php echo $option['value']; ?>
                                 <?php } ?> 
                                </p>                        
                               <?php } ?>                         
                              <?php } ?>   
                    <span>  <?php echo $product['price']; ?></span>
                    <p><span>x <?php echo $product['quantity']; ?></span></p>
                    
                  </div>
                </a>
              </li>
               <?php } ?>
            </ul>
            <hr>
            
            <div class="bot">
            
            
            <?php foreach ($totals as $total) { ?>
                   <p class="p_top"><?php echo $total['title']; ?> <span><?php echo $total['text']; ?></span></p>
                    
                      <?php } ?>
      
              <a class="a_btn" href="<?=$checkout;?>">GO TO SHOPPING CART&nbsp;&gt;</a>
            </div>
          </div>

    <?php } else { ?>

<h1>MY SHOPPING CART(<span>0</span>) <div class="close"><img src="/catalog/view/theme/default/img/png/close2.png"></div></h1>
<div class="null">
<p>Your shopping cart is empty</p>
</div>



    <?php } ?>

<script type="text/javascript">
     $('.cart_ul').scrollTop($('.cart_ul').scrollHeight);
</script>


