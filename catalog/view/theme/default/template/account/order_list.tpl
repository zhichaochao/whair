<?php echo $header; ?>
<!--内容-->
    <div class="orderlist in_content peo_center">
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
        
        <div class="right m_or_det clearfix">
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
                <div class="close"></div>
              </div>
              
              <div class="bot clearfix">
                <div class="left clearfix">
                  <ol class="bot_ol clearfix">

                    <li class="clearfix">
                      <div class="pic_img">
                        <a href="####"><img src="<?php echo $order['order_image']; ?>" alt="" /></a>
                      </div>
                      <p><a href="###"><?php echo $order['order_product_name']; ?></a></p>
                      <div class="type">
                        <p>Quantity:<?php echo $order['qty']; ?></p>
                        <p>Length:<?php echo $order['qty']; ?></p>
                      </div>
                      <p class="price"><?php echo $order['price']; ?></p>
                    </li>

                  <!--   <li class="clearfix">
                      <div class="pic_img">
                        <a href="####"><img src="" alt="" /></a>
                      </div>
                      <p><a href="###">10"-30" Virgin Brazilian</a></p>
                      <div class="type">
                        <p>Quantity:1</p>
                        <p>Length:12inch</p>
                      </div>
                      <p class="price">$35.05</p>
                    </li> -->
                  </ol>
                </div>
                
                <div class="total">
                  <p class="p1">Shipping<span class="fr">$48.98</span></p>
                  <p class="p2">Total <span class="fr"><?php echo $order['total']; ?></span></p>
                </div>
                
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
                    <a class="whatapp fl" href="###">What app</a>
                    <a class="skype fr" href="###">Skype</a>
                    <div class="close"></div>
                  </div>
                </div>
              </div>
            </li>
            <?php } ?>
            <?php } else { ?>
          <div class="right m_account clearfix">
          
          <img src="catalog/view\theme/default/img/png/order.png"/>
          <p> You have placed no orders</p>
          <a class="a_btn" href="<?php echo $goshopping?>">GO SHOPPING &nbsp;&nbsp;&nbsp;></a>
          
        </div>
          <?php } ?>

            
            
          </ul>
        
        </div>
        
      </div>
      
      
    </div>
    <!-- 旧 -->
<!-- <div class="container">
  
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
      
      <h2><?php echo $heading_title; ?></h2>
      
        <table class="table order-list-table"> -->
         <!--  <thead>
            <tr>
              <td><?php echo $text_order_id; ?></td>
              <td><?php echo $column_order_product; ?></td>
              <td><?php echo $column_product; ?></td>     
                                     
              <td><?php echo $column_date_added; ?></td>
              <td><?php echo $column_total; ?></td>
              <td><?php echo $column_status; ?></td>
              <td><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
          <?php if ($orders) { ?>
            <?php foreach ($orders as $order) { ?>
            <tr>
              <td><?php echo $order['order_no']; ?></td>
              <td class="order-product-name"><?php echo $order['order_product_name']; ?></td>
              <td><?php echo $order['qty']; ?></td> 
                                       
              <td><?php echo $order['date_added']; ?></td>
              <td><?php echo $order['total']; ?></td>
              <td><?php echo $order['status']; ?></td>
              <td class="order-product-action">
                <a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-primary btn-view">
                view
                </a>
                
                <?php if($order['status'] == 'Pending'){ ?>
				          &nbsp;&nbsp;<a href="javascript:;" data-toggle="tooltip" onclick="cancel_order('<?php echo $order['cancel_href'];?>')" href="<?php echo $order['cancel_href'];?>" title="Cancel Order"  class="btn btn-cancel">Cancel</a>
                  <?php if($order['payment_code'] == 'pp_standard' || $order['payment_code'] == 'pp_express') { ?>
                    &nbsp;&nbsp;<a data-toggle="tooltip" href="<?php echo $order['repay'];?>" title="Pay"  class="btn btn-success btn-pay">Pay</a>
                  <?php } ?>
			          <?php } ?> -->
            <!--   </td>
            </tr>
            <?php } ?>
          <?php } else { ?>
          <td colspan="7" align="center"><?php echo $text_empty; ?></td>
          <?php } ?>
          </tbody>
        </table>        
      
      <div class="row order-list-tfoot">
        <div class="col-sm-7 text-left order-list-page-left"><?php echo $pagination; ?></div>
        <div class="col-sm-5 text-right order-list-page-right"><?php echo $results; ?></div>
      </div>
      
      <!--<div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>-->
      
    <!--   <?php echo $content_bottom; ?>
    </div>
   </div>
</div> --> 

<script>
function cancel_order(url){
	if(confirm('Are You Sure?')){
		location.href=url;
	}
}
</script>

<?php echo $footer; ?>
