<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
	  <!--
	  <a href="<?php// echo $add; ?>" data-toggle="tooltip" title="<?php //echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>-->
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-inquiry').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
      <h4 style="color: red;">*这里M端的询盘包括M端的产品询盘和M端首页询盘*</h4>
        <div class="well">
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                <input type="text" name="filter_email" value="<?php echo $filter_email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-phone"><?php echo $entry_phone; ?></label>
                <input type="text" name="filter_phone" value="<?php echo $filter_phone; ?>" placeholder="<?php echo $entry_phone; ?>" id="input-phone" class="form-control" />
              </div>  
              <div class="form-group">
                <label class="control-label" for="input-source"><?php echo $entry_source; ?></label>
                <select name="filter_source" id="input-source" class="form-control">
                  <option value="*"></option>
                  <?php if(isset($filter_source) && $filter_source == 0) { ?>
                    <option value="0" selected="selected"><?php echo $text_computer; ?></option>
                  <?php } else { ?>
                    <option value="0"><?php echo $text_computer; ?></option>
                  <?php } ?>
                  <?php if(isset($filter_source) && $filter_source == 1) { ?>
                    <option value="1" selected="selected"><?php echo $text_mobile; ?></option>
                  <?php } else { ?>
                    <option value="1"><?php echo $text_mobile; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_add_time" value="<?php echo $filter_add_time; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-inquiry">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center">
                  <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                  </td>
                  <td class="text-left"><?php echo $column_image; ?></td>
                  <td class="text-left"><?php echo $column_pro_name; ?></td>
                  <td class="text-left"><?php echo $column_coun_name; ?></td>
                  
                  <td class="text-left"><?php echo $column_name; ?></td>                  
                  <td class="text-left"><?php echo $column_email; ?></td>                  
                  <td class="text-left"><?php echo $column_fixed_line; ?></td>
                  <td class="text-left"><?php echo $column_phone; ?></td>
                  <td class="text-left"><?php echo $entry_source; ?></td>
			            <td class="text-left"><?php echo $column_content; ?></td>
                  <td class="text-left"><?php echo $column_date_added; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($inquirys) { ?>
                <?php foreach ($inquirys as $inquiry) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($inquiry['inquiry_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $inquiry['inquiry_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $inquiry['inquiry_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><img src="<?php echo $inquiry['image']; ?>" /></td>
                  <td class="text-left"><?php echo $inquiry['pro_name']; ?></td>
                  <td class="text-left"><?php echo $inquiry['coun_name']; ?></td>
                  
                  <td class="text-left"><?php echo $inquiry['name']; ?></td>
                  <td class="text-left"><?php echo $inquiry['email']; ?></td>
                  <td class="text-left"><?php echo $inquiry['fixed_line']; ?></td>
                  <td class="text-left"><?php echo $inquiry['phone']; ?></td>
                  <?php if ($inquiry['source'] == 0) { ?>
                    <td class="text-left">Computer</td>
                  <?php } else { ?>
                    <td class="text-left">Mobile</td>
                  <?php } ?>
                  <td class="text-left"><?php echo $inquiry['content']; ?></td>
                  <td class="text-left"><?php echo $inquiry['add_time']; ?></td>				
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="10"><?php echo $text_no_results; ?></td>
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
	//url = 'index.php?route=sale/customer&token=<?php echo $token; ?>';
	url = 'index.php?route=sale/product_inquiry&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').val();	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_email = $('input[name=\'filter_email\']').val();	
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}

  var filter_source = $('select[name=\'filter_source\']').val();  
  if (filter_source != '*') {
    url += '&filter_source=' + encodeURIComponent(filter_source);
  }

	var filter_phone = $('input[name=\'filter_phone\']').val();	
	if (filter_phone) {
		url += '&filter_phone=' + encodeURIComponent(filter_phone);
	}
	
	var filter_business = $('input[name=\'filter_business\']').val();	
	if (filter_business) {
		url += '&filter_business=' + encodeURIComponent(filter_business);
	}
	
	var filter_add_time = $('input[name=\'filter_add_time\']').val();	
	if (filter_add_time) {
		url += '&filter_add_time=' + encodeURIComponent(filter_add_time);
	}
	
	
	var filter_customer_group_id = $('select[name=\'filter_customer_group_id\']').val();	
	if (filter_customer_group_id != '*') {
		url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
	}	
	
	var filter_status = $('select[name=\'filter_status\']').val();	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status); 
	}	
	
	var filter_approved = $('select[name=\'filter_approved\']').val();	
	if (filter_approved != '*') {
		url += '&filter_approved=' + encodeURIComponent(filter_approved);
	}	
	
	var filter_ip = $('input[name=\'filter_ip\']').val();
	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}
		
	var filter_date_added = $('input[name=\'filter_date_added\']').val();	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	location = url;
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/product_inquiry/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_name\']').val(item['label']);
	}	
});

$('input[name=\'filter_email\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/product_inquiry/autocomplete&token=<?php echo $token; ?>&filter_email=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['email'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_email\']').val(item['label']);
	}	
});
//--></script> 
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?> 
