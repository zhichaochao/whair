<?php echo $header; ?>
<div class="container">
  
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
      
        <table class="table order-list-table">
          <thead>
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
			          <?php } ?>
              </td>
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
      
      <?php echo $content_bottom; ?>
    </div>
   </div>
</div>

<script>
function cancel_order(url){
	if(confirm('Are You Sure?')){
		location.href=url;
	}
}
</script>

<?php echo $footer; ?>
