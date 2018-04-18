<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-cod" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cod" class="form-horizontal">

          <!-- start 自定义图片的展示 -->
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
            <div class="col-sm-10"><a href="" id="money-gram-thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $money_gram_thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="money_gram_image" value="<?php echo $money_gram_image; ?>" id="input-money-gram-image" />
            </div>
          </div>
          <!-- end 自定义图片的展示 -->

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="money_gram_sort_order" value="<?php echo $money_gram_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="money_gram_status" id="input-status" class="form-control">
                <?php if ($money_gram_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="tab-content">
            <?php $row = 0; ?>

              <table id="money-gram" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="text-left"><?php echo $entry_text; ?></td>
                    <td class="text-left"><?php echo $entry_value; ?></td>
                    <td class="text-right"><?php echo $entry_sort_order; ?></td>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($money_gram_attributes as $money_gram_attribute) { ?>
                  <tr id="money-gram-row<?php echo $row; ?>">
                    <td class="text-left"><input type="text" name="money_gram_attributes[<?php echo $row; ?>][text]" value="<?php echo $money_gram_attribute['text']; ?>" placeholder="<?php echo $entry_text; ?>" class="form-control" /></td>

                    <td class="text-left" style="width: 30%;"><input type="text" name="money_gram_attributes[<?php echo $row; ?>][value]" value="<?php echo $money_gram_attribute['value']; ?>" placeholder="<?php echo $entry_value; ?>" class="form-control" /></td>

                    <td class="text-right" style="width: 10%;"><input type="text" name="money_gram_attributes[<?php echo $row; ?>][sort_order]" value="<?php echo $money_gram_attribute['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>

                    <td class="text-left"><button type="button" onclick="$('#money-gram-row<?php echo $row; ?>, .tooltip').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                  </tr>
                  <?php $row++; ?>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3"></td>
                    <td class="text-left"><button type="button" onclick="addAttribute();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                  </tr>
                </tfoot>
              </table>
            
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 

<script type="text/javascript">
var row = <?php echo $row; ?>;

function addAttribute() {
  html  = '<tr id="money-gram-row' + row + '">';
  html += '  <td class="text-left"><input type="text" name="money_gram_attributes[' + row + '][text]" value="" placeholder="<?php echo $entry_text; ?>" class="form-control" /></td>';  
  html += '  <td class="text-left" style="width: 30%;"><input type="text" name="money_gram_attributes[' + row + '][value]" value="" placeholder="<?php echo $entry_value; ?>" class="form-control" /></td>';  
 
  html += '  <td class="text-right" style="width: 10%;"><input type="text" name="money_gram_attributes[' + row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#money-gram-row' + row  + ', .tooltip\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  
  $('#money-gram tbody').append(html);
  
  row++;
}
</script> 