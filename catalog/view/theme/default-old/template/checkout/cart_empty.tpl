<?php echo $header; ?>
	<style>
		.btn.btn-primary:hover{
			background: #f61666;
		}
	</style>
<div class="container">
  <!--<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>-->
  
  <div class="row" style="margin: 0;">

    
    <div id="content" class="<?php echo $class; ?>" style="min-height: auto;margin: 150px auto;text-align: center;">
      <?php echo $content_top; ?>
      <h1><?php echo $text_error; ?></h1><!--<?php echo $heading_title; ?>-->
      <p></p>
      <div class="buttons clearfix" style="padding-right: 235px;margin-top: 30px;">
        <div class="pull-right" style="padding-left: 90px;height: 55px;background: url(/catalog/view/theme/default/images/tzx/common/empty_cart.png) no-repeat;"><a href="<?php echo $continue; ?>" class="btn btn-primary" style="font-size: 14px;margin-top: 5px;box-shadow: 10px 10px 5px #888888;"><?php echo $button_continue; ?> Shopping &gt; &gt;</a></div>
      </div>
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>
