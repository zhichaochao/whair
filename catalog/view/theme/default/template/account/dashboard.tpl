<?php echo $header; ?>
<!--内容-->
		<div class=" in_content peo_center">
			<?php if ($success) { ?>
			<div class="alert alert-success"><i class="fa fa-check-circle"></i>
				<?php echo $success; ?>
			</div>
			<?php } ?>

			<?php if ($error_warning) { ?>
			<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
				<?php echo $error_warning; ?>
			</div>
			<?php } ?>
			<div class="content clearfix">
				
				<div class="left clearfix">
					<h1>MY ACCOUNT</h1>
					<ol>
						<?php echo $column_left; ?>
			            <?php if ($column_left && $account_left) { ?>
			            <?php $class = 'col-sm-6'; ?>
			            <?php } elseif ($column_left || $account_left) { ?>
			            <?php $class = 'col-sm-9'; ?>
			            <?php } else { ?>
			            <?php $class = 'col-sm-12'; ?>
			            <?php } ?>
			            <?php echo $account_left; ?>
					</ol>
				</div>
				
				<div class="right m_call clearfix">
					<p><img src="/catalog/view/theme/default/img/png/call1.png" alt="" /> +8613450252494</p>
					<a href="mailto:hellena@hotbeautyhair.com"><p><img src="/catalog/view/theme/default/img/png/call2.png" alt="" /> rebecca@hotbeautyhair.com</p></a>	
					<p><img src="/catalog/view/theme/default/img/png/call3.png" alt="" /> Submit your Feedback</p>
					<form action="<?php echo $action; ?>" method="post" class="dash-help-form">	
					<span>*Comment:</span>
					<textarea name="enquiry"></textarea>
					<?php if ($error_enquiry) { ?>
					<div class="text-danger">
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