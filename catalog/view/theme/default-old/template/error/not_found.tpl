<?php echo $header; ?>
	<link rel="stylesheet" type="text/css" href="/catalog/view/theme/default/stylesheet/common/error.css"/>
<div class="container">
  <!--<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>-->
  
  <!--<div class="row">
    <?php echo $column_left; ?>
          
    <?php if ($column_left && $account_left) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $account_left) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    
    <?php //echo $account_left; ?>
    
    <div id="content" class="<?php echo $class; ?>">
      <?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <p><?php echo $text_error; ?></p>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?>
    </div>
  </div>-->
</div>
<section class="content-wrap">
	<div class="er-content-main">
		<img src="/catalog/view/theme/default/images/tzx/common/404.jpg"/>
		<div class="er-content-main-link">
			<a href="" class="er-content-main-home"><i class="fa fa-home" aria-hidden="true"></i>&ensp;Home Page</a>
			<a href="" class="er-content-main-back"><i class="fa fa-arrow-left" aria-hidden="true"></i>&ensp;Previous Page</a>
		</div>
	</div>
</section>
<?php echo $footer; ?>
