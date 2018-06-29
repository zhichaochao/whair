<?php echo $header; ?>
<!--内容-->
    <div class=" in_content peo_center">
      <div class="content clearfix"> 
        <div class="left yd_mycenter clearfix">
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
        </div>        
      </div>   
    </div>
<?php echo $footer; ?>