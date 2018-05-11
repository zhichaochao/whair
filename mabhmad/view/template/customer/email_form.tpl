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
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
          
           <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo $entry_customer; ?></label>
                
              <div class="col-sm-10">
                <div class="well well-sm" style="height: 150px; overflow: auto;">
                  <?php foreach ($customers as $customer) { ?>
                  <div class="checkbox">
                    <label>
                      <?php if (in_array($customer['customer_id'], $customer_ids)) { ?>
                      <input type="checkbox" name="customer_id[]" value="<?php echo $customer['customer_id']; ?>" checked="checked" />
                      <?php echo $customer['email']; ?>
                      <?php } else { ?>
                      <input type="checkbox" name="customer_id[]" value="<?php echo $customer['customer_id']; ?>" />
                      <?php echo $customer['email']; ?>
                      <?php } ?>
                    </label>
                  </div>
                  <?php } ?>
                </div> <?php if ($error_customer) { ?>
                  <div class="text-danger"><?php echo $error_customer; ?></div>
                  <?php } ?>
                <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a></div>
                
            </div>
        
         
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-title"><?php echo $entry_name; ?></label>

            <div class="col-sm-10">
              <input type="text" name="title" value="<?php echo $title; ?>" placeholder="<?php echo $entry_name; ?>" id="input-title" class="form-control" />
          <?php if ($error_title) { ?>
                  <div class="text-danger"><?php echo $error_title; ?></div>
                  <?php } ?>
            </div>
              
          </div>
             <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-content"><?php echo $entry_content; ?></label>
                  
                    <div class="col-sm-10">
                      <textarea name="content" placeholder="<?php echo $entry_content; ?>" id="input-content" class="form-control summernote"><?php echo $content ?></textarea> <?php if ($error_content) { ?>
                  <div class="text-danger"><?php echo $error_content; ?></div>
                  <?php } ?>
                    </div>
                      
                  </div>
         
          
        </form>
      </div>
    </div>
  </div>
</div>
 <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>  
<script type="text/javascript">
  function append_no_send() {
    $('#form-user').append('<input type="hidden" name="append_no_send" value="1" />');
   
  }
</script>
<?php echo $footer; ?> 