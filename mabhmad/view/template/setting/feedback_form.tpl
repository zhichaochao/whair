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
        <form action="" method="post" enctype="multipart/form-data" id="form-feedback" class="form-horizontal">
			
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <div class="input-group"><span class="input-group-addon"> </span>
                <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" readonly="true" class="form-control" />
              </div>
            </div>
          </div>
		
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <div class="input-group"><span class="input-group-addon"> </span>
              <input type="text" name="email" value="<?php echo isset($email) ? $email : ''; ?>"  readonly="true" class="form-control" />
              </div>
            </div>
          </div>       
          
          <div class="form-group">
            <label class="col-sm-2 control-label">Tel Number</label>
            <div class="col-sm-10">
              <div class="input-group"><span class="input-group-addon"> </span>
              <input type="text" name="fixed_line" value="<?php echo isset($fixed_line) ? $fixed_line : ''; ?>"  readonly="true" class="form-control" />
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Country</label>
            <div class="col-sm-10">
              <div class="input-group"><span class="input-group-addon"> </span>
              <input type="text" name="coun_name" value="<?php echo isset($coun_name) ? $coun_name : ''; ?>"  readonly="true" class="form-control" />
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Whatsapp/FaceTime ID or Mobile Phone No.</label>
            <div class="col-sm-10">
              <div class="input-group"><span class="input-group-addon"> </span>
              <input type="text" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>"  readonly="true" class="form-control" />
              </div>
            </div>
          </div>             	  		  		  
 
		  <div class="form-group">
			<label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
			<div class="col-sm-10">
				<textarea name="comment" placeholder="comment" rows="5" id="input-comment" readonly="true" class="form-control"><?php echo isset($comment) ? $comment : ''; ?></textarea>
			</div>
		  </div>
   
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>