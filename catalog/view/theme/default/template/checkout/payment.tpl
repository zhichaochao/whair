<html dir="ltr" lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Payment</title>
<script src="/catalog/view/theme/default/js/jquery-1.11.2.min.js" type="text/javascript"></script>

</head>
<body>
 

<div style="width:500px; margin:300px auto; ">
	<p>
		<h4>You are being redirected to the PayPal website with payment</h4>
	</p>
	<p>
		<h2><img src="/catalog/view/theme/default/images/jwx_new/pay_loading.gif" /> Processing, Please wait</h2>
	</p>

</div>


<?php if($express_pay){ ?>
<script>
    location.href='<?php echo $express_url;?>';
</script> 
<?php } ?>

</body></html>