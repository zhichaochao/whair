<?php echo $header; ?>
<!--内容-->
    
    <div class=" in_content peo_center my_vip">
      <div class="content clearfix">
        
        <div class="left clearfix">
          <h1>MY ACCOUNT</h1>
          <ol>
           <?php echo $column_left; ?>

          <li class="active"><?php if ($column_left && $account_left) { ?>
          <?php $class = 'col-sm-6'; ?>
          <?php } elseif ($column_left || $account_left) { ?>
          <?php $class = 'col-sm-9'; ?>
          <?php } else { ?>
          <?php $class = 'col-sm-12'; ?>
          <?php } ?></li>

          <?php echo $account_left; ?>
          </ol>
        </div>
        
        <div class="right m_vip clearfix">
          <div class="bnr_img">
            <img class="changeimage" data-image='/catalog/view/theme/default/img/jpg/pc_vip.jpg'  data-mimage='/catalog/view/theme/default/img/jpg/yd_vip.jpg'  />
            <img class="vip_img" src="/catalog/view/theme/default/img/png/vip1.png"/>
            <p class="p1">Your VIP level:<?php echo $grade; ?></p>
            <p class="p2"><?php echo $user_name; ?></p>
          </div>
          
          <div class="text_1 clearfix">
            <h1 class="vip_h1">VIP SYSTEM</h1>
            <img src="/catalog/view/theme/default/img/jpg/vip1.jpg"/>
          </div>
          
          <div class="text_2 clearfix">
            <h1 class="vip_h1">ORDER RECORD</h1>
            <ul>
              <li>
                <span>Orders</span>
                <span>Accumulated Amount</span>
                <span>Amount Away From Next Level</span>
              </li>
              <li>
                <span><?php echo $orders; ?></span>
                <span><?php echo $order_totals; ?></span>
                <span><?php echo $next_level; ?></span>
              </li>
            </ul>
          </div>
          
          <div class="text_3 clearfix">
            <h1 class="vip_h1">VIP MEMBER BENEFITS</h1>
            <ul>
              <li>
                <span>Your Accumulated Amount</span>
                <span>$0</span>
                <span>$500</span>
                <span>$5000</span>
                <span>$10000</span>
              </li>
              <li>
                <span>VIP Grade Benifits</span>
                <span>VIP</span>
                <span>Silver VIP</span>
                <span>Gold VIP</span>
                <span>Diamond VIP</span>
              </li>
              <li>
                <span>20% Price Off</span>
                <span class="active"></span>
                <span class="active"></span>
                <span class="active"></span>
                <span class="active"></span>
              </li>
              <li>
                <span>Upgrade Discount Price</span>
                <span></span>
                <span class="active"></span>
                <span class="active"></span>
                <span class="active"></span>
              </li>
              <li>
                <span>Free Label Design</span>
                <span></span>
                <span class="active"></span>
                <span class="active"></span>
                <span class="active"></span>
              </li>
              <li>
                <span>1000pcs Free Label</span>
                <span></span>
                <span></span>
                <span class="active"></span>
                <span class="active"></span>
              </li>
              <li>
                <span>3000pcs Free Label</span>
                <span></span>
                <span></span>
                <span></span>
                <span class="active"></span>
              </li>
              <li>
                <span>First Order Coupon $10</span>
                <span class="active"></span>
                <span class="active"></span>
                <span class="active"></span>
                <span class="active"></span>
              </li>
              <li>
                <span>Upgrade Gifts</span>
                <span></span>
                <span class="active"></span>
                <span class="active"></span>
                <span class="active"></span>
              </li>
            </ul>
          </div>
          
          <div class="text_4 clearfix">
            <div class="div_text">
              <p>Notes: </p>
              <p>We will also offer you an upgrade gifts when you reached the certain level.</p>
            
              <ul>
                <li>
                  <span>Silver VIP</span>
                  <span>1 free 4*4 Closure 10”</span>
                </li>
                <li>
                  <span>Gold VIP</span>
                  <span>2 free 4*4 Closure 12” or  1 free ear to ear 4*13 frontal</span>
                </li>
                <li>
                  <span>Diamond VIP</span>
                  <span>3 Bundles of 18” free Hair + 1 Free 4*4 Closure/frontal 14”or 1 free wig</span>
                </li>
              </ul>
            </div>
          </div>
          
          <div class="text_5 clearfix">
            <div class="div_text">
              <h1 class="vip_h1">HOW DOES HOT BEAUTY HAIR'S VIP PROGRAM WORKS?</h1>
            
              <p class="p1_text">
                Hot Beauty Hair's VIP program includes 4 stages and each stage will enjoy different price discount. Our system has 
                the record of purchase history and we can calculate your VIP level according to how much you have spent.
              </p>
              <ul>
                <li><p><span>• VIP:</span> Register to get account.</p></li>
                <li><p><span>• Silver VIP:</span> Accumulative spent over $500.</p></li>
                <li><p><span>• Gold VIP:</span> Accumulative spent among $5,000.</p></li>
                <li><p><span>• Diamond VIP:</span> Accumulative spent over $10,000.</p></li>
              </ul>
              <p class="p2_text">
                <span>Notes:</span>
                <span>if you have any questions,do not hesitate to send us an email to rebecca@hotbeautyhair.com.</span>
              </p>
            </div>
          </div>
          
        </div>
        
      </div>
      
      
    </div>
<!-- <link href="<?php echo HTTP_SKIN?>stylesheet/account/account_vip.css" type="text/css" rel="stylesheet" />
<div class="container">

  <div class="row">
    <?php echo $column_left; ?>
    
    <?php if ($column_left && $account_left) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $account_left) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    
    <?php echo $account_left; ?>
	
    <div id="content" class="<?php echo $class; ?>">
    <h2><?php echo $user_name; ?></h2>
   
    <div class="pager_left">
      	<div class="vip-level">
      		Your Level: <?php echo $grade; ?>
      		<img src="<?php echo HTTP_SKIN;?>images/tzx/account/vip.png" />
      	</div>
      	<div class="vip-level-2">
      		<div class="vip-level-top" data-point="<?php echo $order_total_num; ?>">
      			<img src="<?php echo HTTP_SKIN;?>images/tzx/account/jindu.png" />
      			<img class="vip-level-pg" src="<?php echo HTTP_SKIN;?>images/tzx/account/here.png" />
      		</div>
      		<p class="vip-level-p">
      			<img src="<?php echo HTTP_SKIN;?>images/tzx/account/here.png" />
      			<span>Your Present Status!</span>
      		</p>
      	</div>
      	<div class="vip-main">
      		<h3>Order Record</h3>
      		<table border="0" cellspacing="0" cellpadding="0" class="vip-record">
      			<tr>
      				<th>Orders</th>
      				<th>Accumulated Amount</th>
      				<th>Amount Away From Next Level</th>
      			</tr>
      			<tr>
      				<td><?php echo $orders; ?></td>
      				<td><?php echo $order_totals; ?></td>
      				<td><?php echo $next_level; ?></td>
      			</tr>
      		</table>
      		<h3>What are the benefits you can enjoy after becoming a VIP?</h3>
      		<img src="<?php echo HTTP_SKIN;?>images/tzx/account/benefits.png" />
      		<div class="vip-benefits">
      			Note:The vip program can be available from april,2017
      		</div>
      		<h3>How does Hot Beauty Hair&apos;s VIP program works?</h3>
      		<p style="font-size: 16px;">Hot Beauty Hair&apos;s VIP program includes 4 stages and each stage will enjoy different price discount. Our system has the record of purchase history and we can calculate your VIP level according to how much you have spent.</p>
      		<ul>
      			<li><span>VIP Member: </span>Register to get account.</li>
      			<li><span>Bronze VIP: </span>Accumulative spent over $500</li>
      			<li><span>Silver VIP: </span>Accumulative spent among $8000</li>
      			<li><span>Gold VIP: </span>Accumulative spent over $20000</li>
      		</ul>
      		<div class="vip-note">
      			NOTE
      		</div>
      		<div class="vip-note-tip">
      			if you have any questions,do not hesitate to send us an email to <a style="color: #f60;" href="mailto:hellena@hotbeautyhair.com">hellena@hotbeautyhair.com</a>.
      		</div>
      	</div>
    </div>
    
    </div>

  </div>
</div> -->

<?php echo $footer; ?>
<script>
	//动态显示会员积分情况
	$(function(){
		var vipPoint = Number($('.vip-level-top').data('point'));
		var $vipPg = $('.vip-level-pg');
		if(0 <= vipPoint && vipPoint < 500){
			var vipLeft = vipPoint/500*258;
			$vipPg.css({'left':vipLeft+'px'});
		}else if(500 <= vipPoint && vipPoint < 8000){
			var vipLeft = (vipPoint-500)/7500*279+258;
			$vipPg.css({'left':vipLeft+'px'});
		}else if(8000 <= vipPoint && vipPoint < 20000){
			var vipLeft = (vipPoint-8000)/12000*298+537;
			$vipPg.css({'left':vipLeft+'px'});
		}else{
			$vipPg.css({'left':835+'px'});
		}
		$vipPg.show();
	});
</script>