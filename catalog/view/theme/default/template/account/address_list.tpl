<?php echo $header; ?>
<!--内容-->
    <div class=" in_content peo_center">
      <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>

      <div class="content clearfix">
        
        <div class="left clearfix">
          <h1>MY ACCOUNT</h1>
          <ol>
            <?php echo $column_left; ?>

            <li><?php if ($column_left && $account_left) { ?>
            <?php $class = 'col-sm-6'; ?>
            <?php } elseif ($column_left || $account_left) { ?>
            <?php $class = 'col-sm-9'; ?>
            <?php } else { ?>
            <?php $class = 'col-sm-12'; ?>
            <?php } ?></li>

            <?php echo $account_left; ?>
          </ol>
        </div>
        
        <div class="right m_add clearfix">
        
          <ul class="clearfix">
          <?php if ($addresses) { ?>
          <?php foreach ($addresses as $result) { ?>
          <?php if($result['isshowdelete']==0){ ?>
            <li class="active">
                     
              <div class="text">
                <p><?php echo $result['address']; ?></p>
                <span>Default address</span>
                <div class="close" onclick="del_address('<?php echo $result['delete'];?>')" class="btn btn-danger"></div>
                <a class="a_img" href="<?php echo $result['update']; ?>"></a>
              </div>
              
              
            </li>
            <?php } ?>
            <?php } ?>

           <?php foreach ($addresses as $result) { ?>
          <?php if($result['isshowdelete']==1){ ?>
            <li class="active">
                     
              <div class="text">
                <p><?php echo $result['address']; ?></p>
                <span>Default address</span>
                <div class="close" onclick="del_address('<?php echo $result['delete'];?>')" class="btn btn-danger"></div>
                <a class="a_img" href="<?php echo $result['update']; ?>"></a>
              </div>
              
              
            </li>
            <?php } ?>
            <?php } ?>
            <?php }?>
          </ul>
          
          <a class="a_btn clearfix" href="<?php echo $add; ?>">Add New Address</a>
        </div>
        
      </div>
      
      
    </div>
<div class="container">
  
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  
  <div class="row">

    
    <div id="content" class="<?php echo $class; ?>">
      <?php echo $content_top; ?>
      
      <h2><?php echo $text_address_book; ?></h2>
      
      <?php if ($addresses) { ?>
      
      <div class="table-responsive">
        
          <?php foreach ($addresses as $result) { ?>
           <?php if($result['isshowdelete']==0){ ?> 
           <table>         	      	          
           <div class="add-list-default">Default Shipping Address</div> 
           <tr>               
            <td class="add-list-info"><?php echo $result['address']; ?></td>
           </tr>
           <tr>
            <td>
               <a href="<?php echo $result['update']; ?>" class="btn btn-info">&lt;&ensp;<?php echo $button_edit; ?></a> &nbsp; 
            </td>
           </tr>
           </table>
           <?php } ?>
          <?php } ?>
                    
         <!--  <div class="add-list-other">Other Address</div> 
          <div class="add-list-new">
             <a href="<?php echo $add; ?>" class="btn btn-primary"><?php echo $button_new_address; ?></a>
          </div> -->
            
          <?php foreach ($addresses as $result) { ?>
           <?php if($result['isshowdelete']==1){ ?>            
           <table>           
            <tr>           
             <td class="add-list-info"><?php echo $result['address']; ?></td>
            </tr>           
            <tr>
             <td>
               <a href="<?php echo $result['update']; ?>" class="btn btn-info">&lt;&ensp;<?php echo $button_edit; ?></a> &nbsp;
               <a href="javascript:;" onclick="del_address('<?php echo $result['delete'];?>')" class="btn btn-danger">&lt;&ensp;<?php echo $button_delete; ?></a>             
             </td>
            </tr>                      
           </table>
           <?php } ?>
          <?php } ?>
        
      </div>
      
      <?php } else { ?>
      
      <p><?php echo $text_empty; ?></p>      
      <div class="add-list-new">
         <a href="<?php echo $add; ?>" class="btn btn-primary"><?php echo $button_new_address; ?></a>
      </div>
      
      <?php } ?>                        
      
      <?php echo $content_bottom; ?>
    </div>
  </div>
</div>

<script>
function del_address(url){
	if(confirm('Are You Sure?')){
		location.href=url;
	}
}
</script>
<script>
  $(function(){
    $(".m_add>ul>li").click(function(){
      $(this).addClass("active").siblings("li").removeClass("active");
    })
  })
</script>
<?php echo $footer; ?>