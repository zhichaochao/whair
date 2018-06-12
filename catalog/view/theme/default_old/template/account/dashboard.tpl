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
			<section class="dash dash-info">
				<h3></h3>
				<div class="dash-info-cont dash-cont">
					<p class="dash-info-username">
					<?php echo $user_name; ?>
					</p>
					<!--<p class="dash-info-coupon">My Coupons</p>-->
				</div>
			</section>

			<section class="dash dash-help">
				<h3>Help Center</h3>
				<div class="dash-help-cont dash-cont">
					<!--<p class="dash-help-vip">
						<i class="fa fa-user" aria-hidden="true"></i>
						<span>VIP service Representative: Linda</span>
					</p>-->
					<p class="dash-help-vip">
						<i class="fa fa-phone-square" aria-hidden="true"></i>
						<span>8613450252494</span>
					</p>
					<p class="dash-help-email">
						<i class="fa fa-envelope-o" aria-hidden="true"></i>
						<a href="mailto:hellena@hotbeautyhair.com">hellena@hotbeautyhair.com</a>
					</p>
					<p>
						<i class="fa fa-pencil" aria-hidden="true"></i>
						<span>Submit your Feedback</span>
					</p>
					<form action="<?php echo $action; ?>" method="post" class="dash-help-form">
						<div class="dash-help-form-text">
							<span class="req-before">Comment:</span>
							<textarea name="enquiry"></textarea>
						</div>
						<?php if ($error_enquiry) { ?>
						<div class="text-danger">
							<?php echo $error_enquiry; ?>
						</div>
						<?php } ?>
						<div class="dash-help-sub-wrap">
							<input type="submit" value="submit" class="dash-help-form-sub">
							<p class="req-before">indicated required</p>
						</div>
					</form>	
				</div>
				
			</section>

			

		</div>
		
	</div>
	<div class="recent-new">
			<!--Recently Viewed Items-->
			<section class="dash-recent">
				<h3>Recently Viewed Items:</h3>

				<?php if ($viewedproducts) { ?>
				<div class="row fixclea">
					<?php foreach ($viewedproducts as $product) { ?>
					<div class="dash-product-wrap fl-left">
						<div class="dash-product-box">
							<div class="dash-product-image">
								<a href="<?php echo $product['href']; ?>">
							    <img src="<?php echo $product['thumb']; ?>" alt='<?php echo $product["max_name"]; ?>' title='<?php echo $product["max_name"]; ?>' />
								</a>
							</div>
							<div>
								<div class="dash-product-caption">

									<?php if(!empty($product['color_name'])){ ?>
									<!--颜色名-->
									<div class="dash-product-caption-color">
										<?php echo $product['color_name']; ?>
										<b class="sanjiao"></b>
									</div>
									<?php } ?>

									<!--产品名-->
									<h4 class="dash-product-caption-name">
										<a href="<?php echo $product['href']; ?>" title="<?php echo $product['max_name']; ?>"><?php echo $product['name']; ?></a>
									</h4>
								</div>
							</div>
						</div>
					</div>
					<!--<div class="">
						<div class="">
							<div class="image">
								<a href="<?php echo $product['href']; ?>">
									<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['max_name']; ?>" title="<?php echo $product['max_name']; ?>" class="img-responsive" />
								</a>
							</div>
							<div>
								<div class="caption">

									<?php if(!empty($product['color_name'])){ ?>
									<!--颜色名--
									<p>
										<?php echo $product['color_name']; ?>
									</p>
									<?php } ?>

									<!--产品名--
									<h4><a href="<?php echo $product['href']; ?>" title="<?php echo $product['max_name']; ?>"><?php echo $product['name']; ?></a></h4>
								</div>
							</div>
						</div>
					</div>-->
					<?php } ?>
				</div>
				<?php }else{ ?>
                   <div align="center" style="font-size:20px;">No Recently Viewed Items!</div>
                <?php } ?>

			</section>
			<!--/Recently Viewed Items-->
            
            <?php if(false){ ?>
			<!--New Arrival-->
			<section class="dash-new">
				<h3>New Arrivals:</h3>

				<?php if ($products) { ?>
				<div class="row fixclea">
					<?php foreach ($products as $product) { ?>
					<div class="dash-product-wrap fl-left">
						<div class="dash-product-box">
							<div class="dash-product-image">
								<a href="<?php echo $product['href']; ?>">
							    <img src="<?php echo $product['thumb']; ?>" alt='<?php echo $product["max_name"]; ?>' title='<?php echo $product["max_name"]; ?>' />
								</a>
							</div>
							<div>
								<div class="dash-product-caption">

									<?php if(!empty($product['color_name'])){ ?>
									<!--颜色名-->
									<div class="dash-product-caption-color">
										<?php echo $product['color_name']; ?>
										<b class="sanjiao"></b>
									</div>
									<?php } ?>

									<!--产品名-->
									<h4 class="dash-product-caption-name">
										<a href="<?php echo $product['href']; ?>" title="<?php echo $product['max_name']; ?>"><?php echo $product['name']; ?></a>
									</h4>
								</div>
							</div>
						</div>
					</div>
					<!--<div class="product-layout product-list col-xs-12">
						<div class="">
							<div class="image">
								<a href="<?php echo $product['href']; ?>">
									<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['max_name']; ?>" title="<?php echo $product['max_name']; ?>" class="img-responsive" />
								</a>
							</div>
							<div>
								<div class="caption">

									<?php if(!empty($product['color_name'])){ ?>
									<!--颜色名--
									<p>
										<?php echo $product['color_name']; ?>
									</p>
									<?php } ?>

									<!--产品名--
									<h4><a href="<?php echo $product['href']; ?>" title="<?php echo $product['max_name']; ?>"><?php echo $product['name']; ?></a></h4>
								</div>
							</div>
						</div>
					</div>-->
					<?php } ?>
				</div>
				<?php }else{ ?>                
                  <div align="center" style="font-size:20px;">No New Arrivals!</div>
                <?php } ?>

			</section>
			<!--/New Arrival-->
            <?php } ?>
		</div>
</div>
<?php echo $footer; ?>