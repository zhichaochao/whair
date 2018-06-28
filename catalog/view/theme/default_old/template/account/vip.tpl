<?php echo $header; ?>
<link href="<?php echo HTTP_SKIN?>stylesheet/account/account_vip.css" type="text/css" rel="stylesheet" />
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
</div>

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