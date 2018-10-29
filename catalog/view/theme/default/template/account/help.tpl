<?php echo $header; ?>
<!--内容-->
		<div class=" in_content peo_center">
		
			<div class="content clearfix">
				
				<div class="left clearfix">
					<h1>MY ACCOUNT</h1>
					<ol>
					
			            <?php echo $account_left; ?>
					</ol>
				</div>
				
				<div class="right m_call clearfix">
					<p><img src="/catalog/view/theme/default/img/png/call1.png" alt="" /> <?php echo $telephone; ?></p>
					<a href="mailto:hellena@hotbeautyhair.com"><p><img src="/catalog/view/theme/default/img/png/call2.png" alt="" /> <?php echo $email; ?></p></a>	
					<p><img src="/catalog/view/theme/default/img/png/call3.png" alt="" /> Submit your Feedback</p>
					<form action="<?php echo $action; ?>" method="post" class="dash-help-form">	
					<span>*Comment:</span>
					<textarea name="enquiry"></textarea>
					</br>
					<?php if ($error_enquiry) { ?>
					<div class="text-danger" >
					<?php echo $error_enquiry; ?>
					</div>
					<?php } ?>
					<!-- <a class="a_btn" type="submit" >SUBMIT&nbsp;&nbsp;&nbsp;></a> -->
					<input type="submit" value="SUBMIT&nbsp;&nbsp;&nbsp;>" class="a_btn" style="width: 240px;height: 40px;line-height: 40px;text-align: center;border-radius: 4px;color: #fff;background: #333;font-size: 16px;display: block;float: right;margin: 15px 10% 25px 0;">
					</form>
				</div>
				
			</div>
			
			
		</div>

<?php echo $footer; ?>

	<?php if ($success) { ?>
	<script type="text/javascript">
		alert('<?php echo $success; ?>');
	</script>
	<?php } ?>
	<?php if ($error_warning) { ?>
	<script type="text/javascript">
		alert('<?php echo $error_warning; ?>');
	</script>
	<?php } ?>
			