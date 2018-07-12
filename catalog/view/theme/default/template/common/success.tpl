<?php echo $header; ?>
<div class="forget in_content clearfix">
      <div class="text clearfix">
        <h2><?php echo $heading_title; ?></h2>
        <div class="bot clearfix">
          <?php if(!empty($order_no)){ ?>
        <!--生成的订单号-->
          Your order number is <b><?php echo $order_no; ?>.</b>
        <?php } ?>
            <?php echo $text_message; ?>
          <div class="form_div clearfix">
            <a class="back" href="<?php echo $continue; ?>">CONTINUE</a>
          </div>
          
        </div>
      </div>
    </div>




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