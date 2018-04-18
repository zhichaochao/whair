<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <!--<button type="button" data-toggle="tooltip" title="<?php //echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-userlist').submit() : false;"><i class="fa fa-trash-o"></i></button>-->
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
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              </div>                            
            </div>
            
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-time"><?php echo $entry_starttime; ?></label> 
                <div class="input-group date">              
                <input type="text" name="filter_starttime" value="<?php echo $filter_starttime; ?>" placeholder="<?php echo $entry_starttime; ?>" data-date-format="YYYY-MM-DD" id="input-time" class="form-control" readonly="readonly"/>                
                <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span>   
                </div>             
              </div>
            </div>                                                
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-time"><?php echo $entry_endtime; ?></label>    
                <div class="input-group date">                 
                <input type="text" name="filter_endtime" value="<?php echo $filter_endtime; ?>" placeholder="<?php echo $entry_endtime; ?>" data-date-format="YYYY-MM-DD" id="input-time" class="form-control" readonly="readonly"/>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span>              
                </div>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
            </div>                                         
          </div>
        </div>
        
        <!--删除半年前的记录,start-->
        <div class="form-group">
            <label class="control-label" style="float:left; margin-right:10px; line-height:35px;">Delete the operation record more than 6 months:</label>
            <div class="input-group">
              <div style="float:left;">                                
                <button type="button" style="margin-left:10px;" data-toggle="tooltip" title="Delete the operation record more than 6 months" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? delSixMonthAgoDoneLogs() : false;"> <i class="fa fa-trash-o"></i> </button>
              </div>              
              <div style="float:left; margin-left:10px; margin-top:8px; color:#F00;" id="deltip"></div>
            </div>                       
        </div>                                       
        <!--删除半年前的记录,end-->
        
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-userlist">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                 <!-- <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td> -->
                  <td class="text-center"><?php echo $id; ?></td>
                  <td class="text-center"><?php echo $user_done_username; ?></td>
                  <td class="text-center"><?php echo $user_done_url; ?></td>
                  <td class="text-center"><?php echo $user_done; ?></td>
                  <td class="text-center"><?php echo $user_done_ip; ?></td>
                  <td class="text-center"><?php echo $user_done_time; ?></td>                                  
                </tr>
              </thead>
              <tbody>
                <?php if ($userdonelist) { ?>
                <?php foreach ($userdonelist as $donelist) { ?>
                <tr>
                  <!--<td class="text-center">
                    <?php if (in_array($donelist['id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $donelist['id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $donelist['id']; ?>" />
                    <?php } ?>
                  </td>-->
                  <td class="text-center"><?php echo $donelist['id']?></td>
                  <td class="text-center"><?php echo $donelist['username']?></td>
                  <td class="text-center"><?php echo $donelist['doneUrl']; ?></td>
                  <td class="text-center"><?php echo $donelist['done']; ?></td>
                  <td class="text-center"><?php echo $donelist['doneIp']; ?></td>
                  <td class="text-center"><?php echo $donelist['doneTime']; ?></td>
                </tr>
                <?php }} else { ?>
                <tr>
                  <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
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
	var url = 'index.php?route=user/user_done_log/doneLog&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').val();
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_starttime = $('input[name=\'filter_starttime\']').val();
	if (filter_starttime) {
		url += '&filter_starttime=' + encodeURIComponent(filter_starttime);
	}
	
	var filter_endtime = $('input[name=\'filter_endtime\']').val();
	if (filter_endtime) {
		url += '&filter_endtime=' + encodeURIComponent(filter_endtime);
	}

	location = url;
});

//删除半年前的记录
function delSixMonthAgoDoneLogs(){
   var url = 'index.php?route=user/user_done_log/doneLog&token=<?php echo $token; ?>';
   
   $.ajax({
       url: 'index.php?route=user/user_done_log/delSixMonthAgoDoneLogs&token=<?php echo $token; ?>',
	   dataType: 'json',
	   success: function(json) {
		   if(json['code'] == 1){
			  alert(json['message']);
			  location = url;
		   }else{
		      $('#deltip').text(json['message']);
		   }
	   }
   });
}

//--></script>

<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script>

</div>
<?php echo $footer; ?>