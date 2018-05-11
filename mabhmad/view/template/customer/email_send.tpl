<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-user" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <button type="submit" onclick="append_no_send();"  data-toggle="tooltip" title="<?php echo $button_save_no_send; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i><?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
          <div class="send_content">
            <h6 class="panel-title">邮件内容:</h6>
            <div class="send_content_s">
            <?=$content;?>
              
            </div>
          </div>
            <div class="text-danger" id="tips" style=" padding-left: 40px;">发送中，不能关闭。。。(如果误关，请在邮件列表页点击继续发送)</div>
          <div class="send">
              <div class="need_to_send">
                <h6 class="panel-title">需要发的客户:</h6>
                 <?php foreach ($send_customers as $customer) { ?>
              <?php echo $customer['email']; ?><br/>
                <?php } ?>
                
              </div>
              <div class="had_send" id='had_send'>
                <h6 class="panel-title">已经发送的客户:</h6>
              </div>
              <input type="hidden" name="ids" id='customer_id' value="<?=$customer_id?>" />
              <input type="hidden" name="id" id='email_id' value="<?=$email_id?>" />

          </div>
       
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  .send{ overflow: hidden; width: 500px; margin: 30px; }
  .need_to_send,.had_send{ float: left; width: 49%; min-height: 100px; border: 1px solid #eee; padding: 20px; line-height: 20px;background:  #fefefe; }
  .send_content_s{ border: 1px solid #eee; margin: 20px;padding: 20px; }

</style>

<script type="text/javascript">
 window.onload = function() {
    sendemail();
 };
function sendemail(){
  var customer_id=$('#customer_id').val();
  if(customer_id){
    $.ajax({url:"<?=$url;?>",type:'POST',data:{email_id:$('#email_id').val(),customer_id:customer_id},success:function(result){
        // result=JSON.parse(result);
        $('#customer_id').val(result.customer_id);
        $('#had_send').append(result.content);
        console.log(result);
        sendemail();
     }});
  }else{
    $('#tips').html('已经全部发送（如果已经发送的客户为空，请联系管理员）');
  }
}

</script>
<?php echo $footer; ?> 