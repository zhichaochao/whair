<?php echo $header; ?>
<!--内容-->
    <div class=" in_content peo_center">
      <div class="content clearfix">
        
        <!-- <div class="left clearfix">
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
        </div> -->
        
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
            
      <?php if(!empty($order_no)){ ?>
        <!--生成的订单号-->
        Your order number is <b><?php echo $order_no; ?>.</b>
      <?php } ?>
      
      <?php echo $text_message; ?>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?>
    </div>
        
      </div>
      
      
    </div>
    header("Location: <?php echo $_SERVER['SERVER_NAME']; ?>"); 
<!-- <div class="container"> -->
  <!--<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>-->
  
  <!-- <div class="row">
    <?php echo $column_left; ?>
    
    <?php if ($column_left && $account_left) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $account_left) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    
    <?php //echo $account_left; ?>
    
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
            
      <?php if(!empty($order_no)){ ?>
        <!--生成的订单号-->
        <!-- Your order number is <b><?php echo $order_no; ?>.</b>
      <?php } ?>
      
      <?php echo $text_message; ?>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?>
    </div>   
  </div>
</div> --> 
<?php if(isset($order) && !empty($order_no)){ ?>
<script>
// 增强电子商务代码
dataLayer.push({
	'event': 'measuringPurchases',
  'ecommerce': {
	'currencyCode':'USD',
        'purchase': {
          'actionField': {
            'id': '<?php echo $order_no;?>', 
            'affiliation': 'Hot Beauty Hair',
            'revenue': '<?php echo $order["total"];?>',
            'tax':'0',
            'shipping': '<?php echo $shipping_fee;?>',
            'coupon': ''
          },
          'products':<?php echo json_encode($gtm_products);?> 
        }
  }
});
</script>
<?php } ?>
<?php echo $footer; ?>