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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-page_image" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-image" data-toggle="tab"><?=$tab_image?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">

                <div class="tab-pane">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-gallery-title"><?php echo $entry_gallery_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="gallery_title" value="<?=empty($gallery_title) ? '' : $gallery_title?>" placeholder="<?php echo $entry_gallery_title; ?>" id="input-gallery-title" class="form-control" />
                      <?php if (!empty($error_gallery_title)) { ?>
                      <div class="text-danger"><?php echo $error_gallery_title; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-author"><?php echo $entry_author; ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="author" value="<?=empty($author) ? '' : $author?>" placeholder="<?php echo $entry_author; ?>" id="input-author" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-related"><span data-toggle="tooltip" title="<?php echo $help_related; ?>"><?php echo $entry_related; ?></span></label>
                    <div class="col-sm-10">
                        <input type="text" name="product_name" value="<?=$product_name?>" placeholder="<?php echo $entry_related; ?>" id="input-related" class="form-control set-product-id" />
                        <input type="hidden" name="product_id" value="<?=$product_id?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-is-home"><?php echo $entry_is_home; ?></label>
                    <div class="col-sm-10">
                        <select name="is_home" id="input-is-home" class="form-control">
                           
                            <option value="1"  <?php if ($is_home==1) { ?>selected="selected" <?php } ?>>Yes</option>
                            <option value="0" <?php if ($is_home==0) { ?>selected="selected" <?php }?>>No</option>
                         
                           
                        </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                    <div class="col-sm-10">
                        <select name="status" id="input-status" class="form-control">
                            
                            <option value="1" <?php if ($status==1) { ?>selected="selected" <?php } ?>><?php echo $text_enabled; ?></option>
                            <option value="0" <?php if ($status==0) { ?>selected="selected" <?php } ?>><?php echo $text_disabled; ?></option>
                            
                           
                        </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                    </div>
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
                          <td class="text-left">
                              <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
                                  <img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                              </a>
                              <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                          </td>
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
                      <tbody>
                      <?php $image_row = 0; ?>
                      <?php foreach ($gallery_images as $gallery_image) { ?>
                      <tr id="image-row<?php echo $image_row; ?>">
                          <td class="text-left">
                              <a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail">
                                  <img src="<?php echo $gallery_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                              </a>
                              <input type="hidden" name="gallery_image[<?php echo $image_row; ?>][image]" value="<?php echo $gallery_image['image']; ?>" id="input-image<?php echo $image_row; ?>" />
                          </td>
                          <td class="text-right">
                              <input type="text" name="gallery_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $gallery_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" />
                          </td>
                          <td class="text-left">
                              <button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger">
                                  <i class="fa fa-minus-circle"></i>
                              </button>
                          </td>
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
  <script type="text/javascript"><!--
//      $('#language a:first').tab('show');
      $('.set-product-id').autocomplete({
          'source': function(request, response) {
              $.ajax({
                  url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                  dataType: 'json',
                  success: function(json) {
                      console.log(json);
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
              console.log(item);
              $('.set-product-id').val(item.label);

              $('input[name=\'product_id\']').val(item.value);
          }
      });

      var image_row = <?php echo $image_row; ?>;

      function addImage() {
          html  = '<tr id="image-row' + image_row + '">';
          html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="gallery_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
          html += '  <td class="text-right"><input type="text" name="gallery_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
          html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
          html += '</tr>';

          $('#images tbody').append(html);

          image_row++;
      }

      //--></script></div>
<?php echo $footer; ?>