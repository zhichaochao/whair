<?php echo $header; ?>
<!--内容-->
		<div class=" in_content peo_center">
		
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
				
				<div class="right m_order clearfix">
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
					<div class="form_div clearfix">
						<p>* Required fields</p>
						<label for="" class="f_name clearfix">
							<span><?php echo $entry_firstname; ?> *</span>
							<!-- <input type="text"  /> -->
							<input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
							<?php if ($error_firstname) { ?>
							<div class="text-danger">
								<?php echo $error_firstname; ?>
							</div>
							<?php } ?>
						</label>
						<label for="" class="l_name clearfix">
							<span><?php echo $entry_lastname; ?> *</span>
							<!-- <input type="text"  /> -->
							<input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
							<?php if ($error_lastname) { ?>
							<div class="text-danger">
								<?php echo $error_lastname; ?>
							</div>
							<?php } ?>
						</label>
						<label class="clearfix" for="">
							<span><?php echo $entry_email; ?>*</span>
							<!-- <input type="text"  /> -->
							<input type="email" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
							<?php if ($error_email) { ?>
							<div class="text-danger">
								<?php echo $error_email; ?>
							</div>
							<?php } ?>
						</label>
						<label class="clearfix" for="">
							<span><?php echo $entry_telephone; ?>*</span>
							<!-- <input type="text"  /> -->
							<input type="tel" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
							<?php if ($error_telephone) { ?>
							<div class="text-danger">
								<?php echo $error_telephone; ?>
							</div>
							<?php } ?>
						</label>
						<!-- <button type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" /> -->
						<button type="submit">UPDATA</button>
						</div>
					</form>

					<form action="<?php echo $changepwd_action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
					<div class="form_div clearfix">
						<h2>Change Password</h2>
						<label for="">
							<span>Current Password*</span>
							<!-- <input type="password"  /> -->
							<input type="password" name="oldpassword" value="<?php echo $oldpassword;?>" placeholder="" id="input-password" class="form-control" />
									<?php if (!empty($error_oldpassword)) { ?>
									<div class="text-danger">
										<?php echo $error_oldpassword; ?>
									</div>
									<?php } ?>
						</label>
						<label for="">
							<span>New Password*</span>
							<!-- <input type="password"  /> -->
							<input type="password" name="password" value="<?php echo $password;?>" placeholder="" id="input-password-1" class="form-control" />
									<?php if (!empty($error_password)) { ?>
									<div class="text-danger">
										<?php echo $error_password; ?>
									</div>
									<?php } ?>
						</label>
						<label for="">
							<span>Confirm Password*</span>
							<!-- <input type="password"  /> -->
							<input type="password" name="confirm" value="<?php echo $confirm;?>" placeholder="" id="input-confirm" class="form-control" />
									<?php if (!empty($error_confirm)) { ?>
									<div class="text-danger">
										<?php echo $error_confirm; ?>
									</div>
									<?php } ?>
						</label>
						<button type="submit">UPDATA</button>
						</div>
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