<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		<div style="text-align:center;"><img src="<?php echo $logo; ?>"/></div>
		<p style="text-align:center;">
			Boost your business, power your life.
		</p>
		<p>From : <?php echo $from_name; ?></p>
		<p>Email: <?php echo $email; ?></p>
		<p>Tel Number: <?php echo $tel_number; ?></p>
                <p>Factime& iMesssage ID: <?php echo $factime; ?></p>
                <p>Whatsapp ID: <?php echo $whatsapp; ?></p>
		<p>Country: <?php echo $country_name; ?></p>
		<p>ip address: <?php echo $ip_address; ?></p>
		<p>Send page : <?php echo $send_page; ?></p>
		<div>The Inquiry Product：</div>
		<table border="1" cellspacing="0" cellpadding="0">
			<tr>
              <th>Product</th>
              <th>SKU</th>
            </tr>
			<tr>
              <td><?php echo $pro_name; ?></td>
              <td><?php echo $sku; ?></td>
            </tr>
		</table>
        <br/>
		<h4>Content:</h4>
		<p><?php echo $content; ?></p>
	</body>
</html>
