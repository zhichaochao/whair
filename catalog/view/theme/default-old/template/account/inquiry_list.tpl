<?php echo $header; ?>
<div class="container">

  <?php if ($del_success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $del_success; ?></div>
  <?php } ?>
  
  <?php if ($del_error) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $del_error; ?></div>
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
    <h2><?php echo $heading_title; ?></h2>
    
     <table class="table inqry-list-table">
     	<thead>
     		<tr>
	        <td><?php echo $column_inquiry_id; ?></td>
	        <td><?php echo $column_image; ?></td>
	        <td><?php echo $column_pro_name; ?></td>      
	        <td><?php echo $column_content; ?></td>
	        <td><?php echo $column_action; ?></td>
	      </tr>
     	</thead>
      <tbody>
     <?php if ($inquirys) { ?>
      <?php foreach ($inquirys as $inquiry) { ?>
      <tr>        
        <td><?php echo $inquiry['inquiry_id']; ?></td>
        <td><?php if(!empty($inquiry['image'])) { ?><img src="<?php echo $inquiry['image']; ?>" /><?php } ?></td>
        <td class="inqry-product-name">
          <?php echo $inquiry['pro_name']; ?>
          <?php if(!empty($inquiry['special'])) { ?>
              <p class="price">
                  <span><?php echo $inquiry['special']; ?></span>
                  <del><?php echo $inquiry['price']; ?></del>
              </p>
          <?php } elseif(!empty($inquiry['price'])) { ?>
              <p class="price">
                  <span class="price-single"><?php echo $inquiry['price']; ?></span>
              </p>
          <?php } ?>
        </td>
        <td><?php echo $inquiry['content']; ?></td>
        <td class="inqry-product-action">
          <?php if(!empty($inquiry['view'])) { ?><a data-toggle="tooltip" href="<?php echo $inquiry['view']; ?>" title="View Details" class="btn btn-primary btn-view">View Details</a><?php } ?>
          <div style="text-align: center;">
          	<a data-toggle="tooltip" href="javascript:;" onclick="remove_inquiry('<?php echo $inquiry['remove'];?>')" href="<?php echo $inquiry['remove'];?>" class="btn btn-cancel" title="Remove">Remove</a>
          </div>
          
        </td>	
      </tr>
      <?php } ?>
     <?php }else{ ?>
      <tr>
        <td colspan="5" align="center"><?php echo $text_empty; ?></td>
      </tr>
     <?php } ?>
     	</tbody>
    </table>
    
    <div class="row inqry-list-tfoot">
      <div class="col-sm-7 text-left inqry-list-page-left"><?php echo $pagination; ?></div>
      <div class="col-sm-5 text-right inqry-list-page-right"><?php echo $results; ?></div>
    </div> 

    <!--<div class="column_selpro selpro_bot cf">
     <div class="pager cf">
        <div class="pager_left">
            <?php echo $pagination; ?>
            <?php //echo $results; ?>
        </div>
        <div class="pager_right">
            <span>Show</span>
            <select id="input-limit" onchange="location = this.value;">
                <?php foreach ($limits as $limitval) { ?>
                    <?php if ($limitval['value'] == $limit) { ?>
                    <option value="<?php echo $limitval['href']; ?>" selected="selected"><?php echo $limitval['text']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $limitval['href']; ?>"><?php echo $limitval['text']; ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
     </div>
    </div>-->
    
    </div>

  </div>
</div>

<script>
function remove_inquiry(url){
	if(confirm('Are You Sure?')){
		location.href=url;
	}
}
</script>

<?php echo $footer; ?>