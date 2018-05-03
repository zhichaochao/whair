<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-information" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
            <li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-data">
              <!--父类select
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
                  <input type="hidden" name="parent_id" value="" />
                </div>
              </div>
              -->

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
                <div class="col-sm-10">
                <input type="text" name="filter_name" value="<?php if(isset($filter_name)) echo $filter_name; ?>" placeholder="请输入商品名称" id="input-name" class="form-control" />
                  <input type="hidden" name="product_id" value="<?php if(isset($product_id)) echo $product_id; ?>" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-is-home"><?php echo $entry_is_home; ?></label>
                <div class="col-sm-10">
                  <select name="is_home" id="input-is-home" class="form-control">
                    <?php if ($is_home) { ?>
                    <option value="1" selected="selected">Yes</option>
                    <option value="0">No</option>
                    <?php } else { ?>
                    <option value="1">Yes</option>
                    <option value="0" selected="selected">No</option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

            </div>
            <div class="tab-pane" id="tab-image">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                    <td class="text-left"><?php echo $entry_image; ?></td>
                  </tr>
                  </thead>

                  <tbody>
                  <tr>
                    <td class="text-left"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img id="thumb-img" src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" /></td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <div class="table-responsive">
                <table id="images" class="table table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                    <td class="text-left"><?php echo $entry_additional_image; ?></td>
                    <td class="text-right"><?php echo $entry_sort_order; ?></td>
                    <td></td>
                  </tr>
                  </thead>
                  <tbody id="product-image">
                  <?php $image_row = 0; ?>
                  <?php foreach ($product_images as $product_image) { ?>
                  <tr id="image-row<?php echo $image_row; ?>">
                    <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $product_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="product_image[<?php echo $image_row; ?>][image]" value="<?php echo $product_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                    <td class="text-right"><input type="text" name="product_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $product_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>
                    <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                  </tr>
                  <?php $image_row++; ?>
                  <?php } ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <td colspan="2"></td>
                    <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                  </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>  
  <script type="text/javascript">
      var image_row = 0;
      $('input[name=\'category\']').autocomplete({
          'source': function(request, response) {
              $.ajax({
                  url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                  dataType: 'json',
                  success: function(json) {
                      response($.map(json, function(item) {
                          return {
                              label: item['name'],
                              value: item['category_id']
                          }
                      }));
                  }
              });
          },
          'select': function(item) {
              $('input[name=\'category\']').val(item['label']);
              $('input[name=\'parent_id\']').val(item['value']);
          }
      });

      $('input[name=\'filter_name\']').autocomplete({
          'source': function(request, response) {
              $.ajax({
                  url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                  dataType: 'json',
                  success: function(json) {
                      response($.map(json, function(item) {
                          return {
                              label: item['name'],
                              value: item['product_id']
                          }
                      }));
                  }
              });
          },
          'select': function(item) {
              $('input[name=\'filter_name\']').val(item['label']);
              $('input[name=\'product_id\']').val(item['value']);
              $('#form-information').attr('action','index.php?route=catalog/customershare/edit&token=<?php echo $token; ?>&product_id='+item['value']+'&filter_name='+encodeURIComponent(item['label']));
              console.log('in');
              $.ajax({
                  url: 'index.php?route=catalog/customershare/getProductImage&token=<?php echo $token; ?>&product_id='+item['value'],
                  dataType: 'json',
                  success: function (json) {
                      console.log(json);
                      $('#thumb-img').attr('src',json.thumb);
                      $("input[name='image']").val(json.image);
                      var str = '';
                      $.each(json.product_images,function (i,item) {
                          str += '<tr id="image-row'+i+'"><td class="text-left">'+
                              '<a href="" id="thumb-image'+i+'" data-toggle="image" class="img-thumbnail">'+
                              '<img src="'+item.thumb+'" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />'+
                              '</a><input type="hidden" name="product_image['+i+'][image]"'+
                              ' value="'+item.image+'" id="input-image'+i+'" /></td><td class="text-right">' +
                              '<input type="text" name="product_image['+i+'][sort_order]" value="'+
                              item.sort_order+'" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" />' +
                              '</td> <td class="text-left"><button type="button"' +
                              ' onclick="$(\'#image-row' + i +'\').remove();" data-toggle="tooltip"' +
                              ' title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i>' +
                              '</button></td> </tr>';
                          image_row = i;
                      });
                      image_row++;
                      $('#product-image').html(str);
                  }
              });

          }
      });
$('#language a:first').tab('show');
</script>
  <script type="text/javascript"><!--
      if(image_row==0) image_row = '<?php echo $image_row; ?>';
      function addImage() {
          html  = '<tr id="image-row' + image_row + '">';
          html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="product_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
          html += '  <td class="text-right"><input type="text" name="product_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
          html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
          html += '</tr>';

          $('#images tbody').append(html);
          image_row++;
      }
      //--></script></div>
<?php echo $footer; ?>