<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-review" class="form-horizontal">

          <div class="form-group required" >
            <label class="col-sm-2 control-label" for="input-author"><?php echo $entry_author; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_author; ?>" id="input-author" class="form-control" />
              
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-product"><span data-toggle="tooltip" title="<?php echo $help_product; ?>"><?php echo $entry_product; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
              <input type="hidden" name="id" value="<?php echo $id; ?>" />
            
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-text"><?php echo $entry_text; ?></label>
            <div class="col-sm-10">
              <textarea name="comment" cols="60" rows="8" placeholder="<?php echo $entry_text; ?>" id="input-text" class="form-control"><?php echo $comment; ?></textarea>
           
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_rating; ?></label>
             <div class="col-sm-10">
              <input type="text" name="phone" value="<?php echo $phone; ?>" placeholder="<?php echo $entry_rating; ?>" id="input-author" class="form-control" />
              
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>