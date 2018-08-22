<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-review').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-gallery-title"><?php echo $entry_gallery_title; ?></label>
                <input type="text" name="filter_gallery_title" value="<?php echo $filter_gallery_title; ?>" placeholder="<?php echo $entry_gallery_title; ?>" id="input-gallery-title" class="form-control" />
              </div>
              
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="control-label" for="input-product-name"><?php echo $entry_product_name ?></label>
                  <input type="text" name="filter_product_name" value="<?php echo $filter_product_name; ?>" placeholder="<?php echo $entry_product_name; ?>" id="input-date-added" class="form-control" />
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-review">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'gallery_title') { ?>
                    <a href="<?php echo $sort_gallery_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_gallery_title; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_gallery_title; ?>"><?php echo $column_gallery_title; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'product_name') { ?>
                    <a href="<?php echo $sort_product_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_product_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_product_name; ?>"><?php echo $column_product_name; ?></a>
                    <?php } ?></td>
                  <!-- <td class="text-left">
                    <?=$column_author?></a>
                  </td> -->
                  <td class="text-left">
                    <?=$column_thumbnail?></a>
                  </td>
                  <td class="text-left">
                    <?=$column_view?></a>
                  </td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($galleries) { ?>
                <?php foreach ($galleries as $gallery) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($gallery['gallery_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $gallery['gallery_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $gallery['gallery_id']; ?>" />
                    <?php } ?>
                  </td>
                  <td class="text-left"><?php echo $gallery['gallery_title']; ?></td>
                  <td class="text-left"><?php echo $gallery['product_name']; ?></td>
                  <!-- <td class="text-left"><?=$gallery['author']?></td> -->
                  <td class="text-left"><img src="<?php echo $gallery['image']; ?>"/></td>
                  <td class="text-left"><?=$gallery['view']?></td>
                  <td class="text-right"><a href="<?php echo $gallery['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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
	url = 'index.php?route=catalog/gallery&token=<?php echo $token; ?>';
	
	var filter_gallery_title = $('input[name=\'filter_gallery_title\']').val();
	
	if (filter_gallery_title) {
		url += '&filter_gallery_title=' + encodeURIComponent(filter_gallery_title);
	}
			
	var filter_product_name = $('input[name=\'filter_product_name\']').val();
	
	if (filter_product_name) {
		url += '&filter_product_name=' + encodeURIComponent(filter_product_name);
	}

    var filter_author = $('input[name=\'filter_author\']').val();

    if (filter_author) {
        url += '&filter_author=' + encodeURIComponent(filter_author);
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