<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">

  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-weight" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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

    <?php if ($success && !$error_warning) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i><?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-2">
            <ul class="nav nav-pills nav-stacked">
              <li class="active"><a href="#tab_import" data-toggle="tab"><i class="fa fa-download"></i><?php echo $tab_import; ?></a></li>
              <li><a href="#tab_rules" data-toggle="tab"><i class="fa fa-file-text"></i><?php echo $tab_rules; ?></a></li>
              <li><a href="#tab_help" data-toggle="tab"><i class="fa fa-question-circle"></i><?php echo $tab_help; ?></a></li>
            </ul>
          </div>
          <div class="col-sm-10">
            <div class="tab-content">
            <!-- tab_import -->
              <div class="tab-pane active" id="tab_import">

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><h2 style="margin-bottom:10px; margin-top:15px;"><?php echo $step_1; ?></h2></div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><a href="tplfile/tpl_import_product.xlsx" class="btn btn-primary"><span><?php echo $download; ?></span></a></h2></div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><h2 style="margin-bottom:10px; margin-top:15px;"><?php echo $step_2; ?></h2></div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><?php echo $column_removed; ?></div>
                </div>
                <br>
                
                <!--复选框-->
                <div class="row">
                  <form action="<?php echo $action_save_columns; ?>" method="POST" id="formsave">
                    <?php
                      foreach ($array_columns as $key => $value) {
                        echo '<div class="col-sm-3 col-md-3 col-xs-6">';
                          echo '<label>';
                          echo '<input style="margin-right:3px;" type="checkbox" name="'.$value['input_name'].'" '.($value['config'] == 'on' ? 'checked' : '').' '.($value['required'] ? 'disabled' : '').'>';
                          echo $value['name'];
                          echo '</label>';
                        echo '</div>';
                      }
                    ?>
                  </form>
                </div>
                <!--/复选框-->

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><a style="margin-top:10px;" class="btn btn-primary" href="javascript:{}" onclick="save_columns()"><span><?php echo $remember_columns; ?></span></a></div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><h2 style="margin-bottom:10px; margin-top:15px;"><?php echo $step_3; ?></h2></div>

                  <div class="col-sm-12 col-md-12 col-xs-12">
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                      <input type="file" name="upload"/>
                    </form>
                  </div>

                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><?php echo $not_forget; ?></div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><h2 style="margin-bottom:10px; margin-top:15px;"><?php echo $step_4; ?></h2></div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><?php echo $image_upload_description; ?></div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><a id="thumb-image" data-toggle="image" class="img-thumbnail btn btn-primary"><?php echo $buttom_upload_image; ?></a></div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><h2 style="margin-bottom:10px; margin-top:15px;"><?php echo $step_5; ?></h2></div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><?php echo $important; ?></div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><a onclick="$('#form').submit();ajax_loading_open();" class="btn btn-primary"><span><?php echo $button_import; ?></span></a></div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12 col-xs-12"><h2 style="margin-bottom:10px; margin-top:15px;"><?php echo $step_6; ?></h2></div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <td class="text-center"><?php echo $product_number; ?></td>
                        <td class="text-center"><?php echo $product_product_id; ?></td>
                        <td class="text-center"><?php echo $product_model; ?></td>
                        <td class="text-center"><?php echo $product_name; ?></td>
                        <td class="text-center"><?php echo $product_image; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($images_not_found as $key => $value) { ?>
                        <tr>
                          <td class="left"><?php echo ($key+1); ?></td>
                          <td class="left"><?php echo $value['product_id']; ?></td>
                          <td class="left"><?php echo $value['model']; ?></td>
                          <td class="left"><?php echo $value['name']; ?></td>
                          <td class="left"><?php echo $value['image']; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>

              </div>
            <!-- tab_import -->

            <!-- tab_rules -->
              <div class="tab-pane" id="tab_rules">
                <?php
                  echo '<h2>'.$rule_heading_3.'</h2>';
                      echo $view_table;
                      echo '<br><br><div style="display:none;" class="list_default_values table-responsive">';
                        echo '<table class="table table-bordered table-hover">
                                <thead>
                                  <tr>
                                    <td class="center">*</td>
                                    <td class="center">Name</td>
                                    <td class="center">Default value</td>
                                    <td class="center">Explain</td>
                                  </tr>
                                </thead><tbody>';

                        foreach ($array_default_fields as $key => $value) {
                            echo '<tr>';
                              echo '<td class="center">'.($key+1).'</td>';
                              echo '<td class="center">'.$value['name'].'</td>';
                              echo '<td class="center">'.$value['default'].'</td>';
                              echo '<td class="left">'.$value['explain'].'</td>';
                            echo '</tr>';
                        }

                        echo '</tbody></table>';
                      echo '</div>';
                    
                  echo '<div style="clear:both;"></div>';
         
                  echo '<h2>'.$rule_possible_values.'</h2>';
                    echo $view_table_possible;?>
                      <br><br><div style="display:none;" class="view_table_possible table-responsive">

             
                      <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <td class="center">Field</td>
                            <td class="center">Possible values</td>
                          </tr>
                        </thead><tbody>
                        
                        <tr>
                          <td class="center">Out stock status</td>
                          <td class="left">
                            <ul>
                              <?php foreach ($stock_status as $key => $value) {
                                echo '<li><b>'.$value['stock_status_id'].'</b>: '.$value['name'].'</li>';
                              } ?>
                            </ul>
                          </td>
                        </tr>
						<?php foreach($new_rule as $key=>$row) {?>
                        <tr>
                          <td class="center"><?php echo $key; ?></td>
                          <td class="left">
                            <ul>
							  <?php foreach($row as $row1){ ?>
								<li><b><?php echo $row1['name']; ?></b></li>
							  <?php } ?>
                            </ul>
                          </td>
                        </tr>
						<?php } ?>

                        </tbody></table>
                      </div>
                  

                  <?php echo '<h2>'.$rule_heading_4.'</h2>';
                    echo '<ul>';
                      echo '<li>'.$rule_4_categories_1.'</li>';
                      echo '<li>'.$rule_4_categories_2.'</li>';
                      echo '<ul><li>'.$rule_4_categories_3.'</li></ul>';
                      echo '<br>';
                      echo '<li>'.$rule_4_manufacturers_1.'</li>';
                      echo '<li>'.$rule_4_manufacturers_2.'</li>';
                      echo '<ul><li>'.$rule_4_manufacturers_3.'</li></ul>';
                    echo '</ul>';

                  echo '<h2>'.$rule_heading_5.'</h2>';
                    echo '<ul>';
                      echo '<li>'.$rule_5_options_1.'</li>';
                      echo '<li>'.$rule_5_options_2.'</li>';
                      echo '<li>'.$rule_5_options_3.'</li>';
                    echo '</ul>';

                  echo '<h2>'.$rule_demo.'</h2>';
                    echo '<ul>';
                      echo '<li>'.$rule_demo_1.'</li>';
                      echo '<li>'.$rule_demo_2.'</li>';            
                    echo '</ul>';         

                  echo '<br><br><br>';
                ?>
              </div>
            <!-- END tab_rules -->

            <!-- tab_help -->
              <div class="tab-pane" id="tab_help">
                <iframe src="http://opencartqualityextensions.com/open_ticket" style="height:500px; width: 100%;"></iframe> 
              </div>
            <!-- END tab_help -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function save_columns()
  {
    console.log(jQuery('#formsave').serialize());
    jQuery.ajax( {
      type: 'POST', //data format 
      url: jQuery('#formsave').attr('action'),
      data: jQuery('#formsave').serialize(),
      success: function( data ) {
        alert(data);
      }

    });
  }
  function ajax_loading_open () {
    jQuery('body').prepend('<div class="ajax_loading"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
  }
</script> 

<style type="text/css">
  table.choose_columns tr td
  {
    font-size: 10px;
  }
  div.ajax_loading
  {
    position: fixed;
    left: 0px;
    top: 0px;
    height: 100%;
    width: 100%;
    z-index: 99999;
    background: rgba(0, 0, 0, 0.60)
  }

  div.ajax_loading i
  {
    position: absolute;
    left: 50%;
    top: 50%;
    font-size: 80px;
    margin-left: -40px;
    margin-top: -40px;
    color: #fff;
  }
</style>
<link rel="stylesheet" type="text/css" href="view/stylesheet/OPQualityExtensions/style.css" />
<script type="text/javascript" src="view/javascript/OPQualityExtensions/tools.js"></script>
<?php echo $footer; ?> 