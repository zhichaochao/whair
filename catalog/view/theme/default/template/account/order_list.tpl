<?php echo $header; ?>
<!--内容-->
    <div class="orderlist in_content peo_center" >
      <div class="content clearfix">
        
        <div class="left clearfix">
          <h1>MY ACCOUNT</h1>
          <ol>
    
            <?php echo $account_left; ?>
          </ol>
        </div>
        
        <div class="right m_or_det clearfix" >
          <ul class="order_ul clearfix">
          <?php if ($orders) { ?>
          <?php foreach ($orders as $order) { ?>
          

            <li class="clearfix">
              <div class="top clearfix">
                <ol class="top_ol clearfix">
                  <li>
                    <p>Order Date:<?php echo $order['date_added']; ?></p>
                  </li>
                  <li>
                    <p>Order Number: <?php echo $order['order_no']; ?></p>
                  </li>
                  <li>
                    <p>Order Status: <?php echo $order['status']; ?></p>
                  </li>
                </ol>
                <div class="close" onclick="javascript:order_remove('<?php echo $order['order_id']; ?>');"></div>
              </div>
              
              <div class="bot clearfix">
                <div class="left clearfix">
                  <ol class="bot_ol clearfix">
                  <?php if ($order['products']) { ?>
                    <?php foreach ($order['products'] as $product) { ?>
                    <li class="clearfix">
                      <div class="pic_img">
                       <a href="<?=$product['href'];?>"> <img src="<?php echo $product['image']; ?>"  /></a>
                      </div>
                      <p><a href="<?=$product['href'];?>"><?php echo $product['name']; ?></a></p>
                      <div class="type">
                        <p>Quantity:<?php echo $product['quantity']; ?></p>    
                    <?php if ($product['options']) { ?>
                    <?php foreach ($product['options'] as $option) { ?>     
                      <p><?php echo $option['name']; ?>:<?php echo $option['value']; ?></p>    

                    <?php } }?>  
                      </div>
                      <p class="price"><?php echo $product['price']; ?></p>
                    </li>
                        <?php } }?>
                  </ol>
                </div>
                <a href=" <?php echo $order['view']; ?>">
                <div class="total">
                  <p class="p1">Shipping<span class="fr"><?php echo $order['shipping_total']; ?></span></p>
                  <p class="p2">Total <span class="fr"><?php echo $order['total']; ?></span></p>
                </div>
                </a>
                <div class="btn_div">
                  <!-- <a class="return" href="###">Return</a>
                  <a class="" href="###">View</a> -->
                  <a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-primary btn-view">
                view
                </a>
                
                <?php if($order['status'] == 'Pending'){ ?>
                  &nbsp;&nbsp;<a href="javascript:;" data-toggle="tooltip" onclick="cancel_order('<?php echo $order['cancel_href'];?>')" href="<?php echo $order['cancel_href'];?>" title="Cancel Order"  class="btn btn-cancel">Cancel</a>

                  <?php if($order['payment_code'] == 'pp_standard' || $order['payment_code'] == 'pp_express') { ?>
                    &nbsp;&nbsp;<a data-toggle="tooltip" href="<?php echo $order['repay'];?>" title="Pay"  class="red">Pay</a>
                  <?php } ?>
                <?php } ?>
                </div>
                
                <div class="return_modal">
                  <div class="text">
                    <span><em></em></span>
                    <p>Please choose the following ways  to contact us for your return</p>
                    <a class="whatapp fl" target="_blank" href="whatsapp://send?phone=<?=$whatappphone;?>">What app</a>
                    <a class="skype fr" target="_blank"  href="skype:<?=$skype;?>?chat">Skype</a>
                    <div class="close"></div>
                  </div>
                </div>
              </div>
            </li>
             
            <?php } ?>
            <?php } else { ?>
          <div class="m_account clearfix">
          
          <img src="/catalog/view/theme/default/img/png/order.png"/>
          <p> You have placed no orders</p>
          <a class="a_btn" href="<?php echo $goshopping?>">GO SHOPPING &nbsp;&nbsp;&nbsp;></a>
          
        </div>
          <?php } ?>

            
            
          </ul>
        
        </div>
        
      </div>
      
      
    </div>
<script>
function cancel_order(url){
	if(confirm('Are You Sure?')){
		location.href=url;
	}
}
function order_remove(order_id){
//alert(order_id);
if(confirm('Are you sure?')){

           $.ajax({
            url: 'index.php?route=account/order/delete',
            type: 'post',
            data: {order_id:order_id},
            dataType: 'json',
     
            success: function(json) {
              // alert(json);
              // if (json['link']) { }
               location.reload();
            }
        })
      
    }
}
</script>


<?php echo $footer; ?>
