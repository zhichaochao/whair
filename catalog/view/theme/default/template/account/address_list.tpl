<?php echo $header; ?>
<!--内容-->
    <div class=" in_content peo_center">
<!--       <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?> -->

      <div class="content clearfix">
        
        <div class="left clearfix">
          <h1>MY ACCOUNT</h1>
          <ol>

            <?php echo $account_left; ?>
          </ol>
        </div>
        <div class="right m_add clearfix">        
          <ul class="clearfix">
          <?php if ($addresses) { ?>
         
           <?php foreach ($addresses as $result) { ?>
          <?php if($result['isshowdelete']==1){ ?>
            <li>           
              <div class="text">
                <p><?php echo $result['address']; ?></p>
                 
                <div class="close" onclick="del_address('<?php echo $result['delete'];?>')" class="btn btn-danger"></div>
                  <span style="display: block;" onclick="javascript:default_address('<?php echo $result['address_id']; ?>');">Set Default Address</span>
                <a class="a_img" href="<?php echo $result['update']; ?>"></a>
              </div>
            </li>
            <?php }else{ ?>
            <li class="active">
              <div class="text">
                <p><?php echo $result['address']; ?></p>
                <span>Default address</span>
                <a class="a_img" href="<?php echo $result['update']; ?>"></a>
              </div>
            </li>

            <?php } }?>
            <?php }?>
          </ul>
          <a class="a_btn clearfix" href="<?php echo $add; ?>">Add New Address</a>
        </div>        
      </div>  
    </div>
<script>
function default_address(address_id){
     $.ajax({
     url: 'index.php?route=account/address/edit_default',
     type: 'post',
     data: {address_id:address_id},
     dataType: 'json',     
     success: function(json) {
       location.reload();
      }
   })
}
function del_address(url){
	if(confirm('Are You Sure?')){
		location.href=url;
	}
}
</script>
<script>
  // $(function(){
  //   $(".m_add>ul>li").click(function(){
  //     $(this).addClass("active").siblings("li").removeClass("active");
  //   })
  // })
</script>
<?php echo $footer; ?>
<?php if ($success) { ?>

    <script type="text/javascript">
alert('<?php echo $success; ?>');
</script>

  <?php } ?>

  <?php if ($error_warning) { ?>

    <script type="text/javascript">
alert('<?php echo $error_warning; ?>');
</script>
  <?php } ?>