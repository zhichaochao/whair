<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-inquiries').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
    
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-inquiries">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'r.name') { ?>
                    <a href="<?php echo $sort_product; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_product; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_product; ?>"><?php echo $column_product; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'r.author') { ?>
                    <a href="<?php echo $sort_author; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_author; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_author; ?>"><?php echo $column_author; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'r.phone') { ?>
                    <a href="<?php echo $sort_rating; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_rating; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_rating; ?>"><?php echo $column_rating; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'r.comment') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'r.submitTime') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($inquiriess) { ?>
                <?php foreach ($inquiriess as $inquiries) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($inquiries['id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $inquiries['id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $inquiries['id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $inquiries['name']; ?></td>
                  <td class="text-left"><?php echo $inquiries['email']; ?></td>
                  <td class="text-right"><?php echo $inquiries['phone']; ?></td>
                  <td class="text-left"><?php echo $inquiries['comment']; ?></td>
                  <td class="text-left"><?php echo $inquiries['submitTime']; ?></td>
                  <td class="text-right"><a href="<?php echo $inquiries['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=catalog/inquiries&token=<?php echo $token; ?>';
	
	var filter_product = $('input[name=\'filter_name\']').val();
	
	if (filter_product) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_author = $('input[name=\'filter_email\']').val();
	
	if (filter_author) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	
	// var filter_status = $('select[name=\'filter_status\']').val();
	
	// if (filter_status != '*') {
	// 	url += '&filter_status=' + encodeURIComponent(filter_status); 
	// }		
			
	// var submitTime = $('input[name=\'filter_date_added\']').val();
	
	// if (filter_date_added) {
	// 	url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	// }
var submittime = $('input[name=\'submittime\']').val();
  
  if (submittime) {
    url += '&submittime=' + encodeURIComponent(submittime);
  }
	location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?>