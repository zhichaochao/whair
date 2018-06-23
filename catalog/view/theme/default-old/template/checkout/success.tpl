<?php echo $header; ?>
	<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/common/success.css"/>

<section class="content-wrap">
	<div class="cgConter">

		<img class="img1" alt="" src="/catalog/view/theme/default/images/tzx/common/cg.jpg">
		<div class="conterRight">
			<div class="page-title">

				<h1 style="margin-top:15px;">Success!</h1>

			</div>

			<h2 class="sub-title">Thank you for your purchase!</h2>
			<p>Your order # is:
				<a href="<?php echo $view_order; ?>"><?php echo $order_no; ?></a>.</p>

			<p>You will receive an order confirmation email with details of your order and a link to track its progress.</p>

			<p><a href="<?php echo $continue; ?>">Continue Shopping</a></p>

			<a href="<?php echo $order_list; ?>" class="done">Review the order</a>

		</div>
	</div>
</section>

<?php if(isset($order) && !empty($order_no)){ ?>
<script>
	// 增强电子商务代码
	dataLayer.push({
		'event': 'measuringPurchases',
		'ecommerce': {
			'currencyCode': 'USD',
			'purchase': {
				'actionField': {
					'id': '<?php echo $order_no;?>',
					'affiliation': 'Hot Beauty Hair',
					'revenue': '<?php echo $order["total"];?>',
					'tax': '0',
					'shipping': '<?php echo $shipping_fee;?>',
					'coupon': ''
				},
				'products': <?php echo json_encode($gtm_products);?>
			}
		}
	});

	//触发发邮件动作
	$(document).ready(function() {
    	sendEmail();
	});

	//发邮件的方法
	function sendEmail(){
		$.ajax({
	        url: 'index.php?route=checkout/success/sendEmail_1',
	        type: 'post',
	    });
	}

</script>
<?php } ?>

<?php echo $footer; ?>