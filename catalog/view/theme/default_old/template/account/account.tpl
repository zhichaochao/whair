<?php echo $header; ?>

<div class="container">

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
			<?php echo $content_top; ?>

			<h2><?php echo $heading_title; ?></h2>

			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
				<fieldset>
					<!--<legend><?php echo $text_your_details; ?></legend>-->

					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
						<div class="col-sm-10">
							<input type="email" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
							<?php if ($error_email) { ?>
							<div class="text-danger">
								<?php echo $error_email; ?>
							</div>
							<?php } ?>
						</div>
					</div>

					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-firstname"><?php echo $entry_firstname; ?> </label>
						<div class="col-sm-10">
							<input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="form-control" />
							<?php if ($error_firstname) { ?>
							<div class="text-danger">
								<?php echo $error_firstname; ?>
							</div>
							<?php } ?>
						</div>
					</div>

					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-lastname"><?php echo $entry_lastname; ?></label>
						<div class="col-sm-10">
							<input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="form-control" />
							<?php if ($error_lastname) { ?>
							<div class="text-danger">
								<?php echo $error_lastname; ?>
							</div>
							<?php } ?>
						</div>
					</div>

					<div class="form-group required">
						<label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
						<div class="col-sm-10">
							<input type="tel" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
							<?php if ($error_telephone) { ?>
							<div class="text-danger">
								<?php echo $error_telephone; ?>
							</div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2"></label>
						<div class="col-sm-10">
							<input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
						</div>
					</div>
				</fieldset>
			</form>
            
			<form action="<?php echo $changepwd_action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
				<div class="account_update">
					<h2>CHANGE PASSWORD</h2>
					<div class="account_updainfo">
						<fieldset>

							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-password">Current Password</label>
								<div class="col-sm-10">
									<input type="password" name="oldpassword" value="<?php echo $oldpassword;?>" placeholder="" id="input-password" class="form-control" />
									<?php if (!empty($error_oldpassword)) { ?>
									<div class="text-danger">
										<?php echo $error_oldpassword; ?>
									</div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-password-1">New Password</label>
								<div class="col-sm-10">
									<input type="password" name="password" value="<?php echo $password;?>" placeholder="" id="input-password-1" class="form-control" />
									<?php if (!empty($error_password)) { ?>
									<div class="text-danger">
										<?php echo $error_password; ?>
									</div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-password">Confirm Password</label>
								<div class="col-sm-10">
									<input type="password" name="confirm" value="<?php echo $confirm;?>" placeholder="" id="input-confirm" class="form-control" />
									<?php if (!empty($error_confirm)) { ?>
									<div class="text-danger">
										<?php echo $error_confirm; ?>
									</div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2"></label>
								<div class="col-sm-10">
									<input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
								</div>
							</div>
						</fieldset>
						<!--<dl>
					<dt><i class="col_zs">*</i>Current Password</dt>
					<dd>
						<input type="password" name="oldpassword" value="<?php echo $oldpassword;?>" placeholder="<?php echo $entry_oldpassword; ?>" id="input-password" class="form-control" />
						<?php if (!empty($error_oldpassword)) { ?>
						  <div class="text-danger"><?php echo $error_oldpassword; ?></div>
						  <?php } ?>
					</dd>
				</dl>
				<dl>
					<dt><i class="col_zs">*</i>New Password</dt>
					<dd>
						<input type="password" name="password" value="<?php echo $password;?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
						<?php if (!empty($error_password)) { ?>
						  <div class="text-danger"><?php echo $error_password; ?></div>
						  <?php } ?>
					</dd>
				</dl>
				<dl>
					<dt><i class="col_zs">*</i>Confirm Password</dt>
					<dd>
					  <input type="password" name="confirm" value="<?php echo $confirm;?>" placeholder="<?php echo $entry_confirm; ?>" id="input-confirm" class="form-control" />
					  <?php if (!empty($error_confirm)) { ?>
					  <div class="text-danger"><?php echo $error_confirm; ?></div>
					  <?php } ?>
					</dd>
				</dl>-->

					</div>
				</div>

			</form>
		</div>

	</div>
</div>
<?php echo $footer; ?>