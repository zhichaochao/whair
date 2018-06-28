<?php echo $header; ?>
<link rel="stylesheet" type="text/css" href="/catalog/view/theme/default/stylesheet/common/failure.css"/>
<section class="content-wrap">
	<div class="fa-content-main fixclea">
		<div class="fa-content-main-left">
			<img src="/catalog/view/theme/default/images/tzx/common/sb.png"/>
		</div>
		<div class="fa-content-main-right">
			<h3>An Error Occured In The Process Of Payment</h3>
			<p class="ord-num-box">
				<span class="ord-num-name">Order number&emsp;&emsp;</span>
				<span class="ord-num"><?php echo $order_no; ?></span>
			</p>
			<h3>You may:</h3>
			<ul>
        <li>1.Clice <a href="<?php echo $order_list; ?>">here</a> to see and re-pay the order.</li>
        <li>2.pls <a href="<?php echo $contact; ?>">contact us</a> for help enclosed your order number.</li>
				<li>3.Clice <a href="<?php echo $continue; ?>">here</a> to continue shopping.</li>
			</ul>
		</div>
	</div>
</section>

<?php if(isset($order) && !empty($order_no)){ ?>
<script>
// 增强电子商务代码
dataLayer.push({
	'event': 'measuringPurchases',
  'ecommerce': {
	'currencyCode':'USD',
        'purchase': {
          'actionField': {
            'id': '<?php echo $order_no;?>', 
            'affiliation': 'Hot Beauty Hair',
            'revenue': '<?php echo $order["total"];?>',
            'tax':'0',
            'shipping': '<?php echo $shipping_fee;?>',
            'coupon': ''
          },
          'products':<?php echo json_encode($gtm_products);?> 
        }
  }
});
</script>
<?php } ?>
<?php echo $footer; ?>