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
           <!--  <li><a href="#tab-image" data-toggle="tab"><?=$tab_image?></a></li> -->
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
                <div class="form-group">
                  
                         <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_image; ?></label>
                      
                        <div class="col-sm-10">
                              <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail">
                                  <img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" />
                              </a>
                              <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />

                      </div>

              </div>
                </div>

            </div>
            <div class="tab-pane" id="tab-image">
           
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
  <script src="view/javascript/fileupload/jquery.ui.widget.js"></script>
  <script src="view/javascript/fileupload/jquery.iframe-transport.js"></script>
  <script src="view/javascript/fileupload/jquery.fileupload.js"></script>
  <script src="view/javascript/fileupload/jquery.xdr-transport.js"></script>
    <style type="text/css">
    .input-video {
      width: 100px;
      height: 30px;
      font-size: 12px;
      letter-spacing: 8px;
      padding-left: 12px;
      border-radius: 5px;
      line-height: 30px;
      cursor: pointer;
      text-align: center;
      background: -webkit-linear-gradient(top, #66B5E6, #2e88c0);
      background: -moz-linear-gradient(top, #66B5E6, #2e88c0);
      background: linear-gradient(top, #66B5E6, #2e88c0);
      background: -ms-linear-gradient(top, #66B5E6, #2e88c0);
      border: 1px solid #2576A8;
      color: #fff;
      text-shadow: 1px 1px 0.5px #22629B;
    }
  </style>
  <script type="text/javascript">
      $(".upinput").fileupload({

          url: "<?php echo $edit_video; ?>"+"<?php echo $edit_video_url; ?>",//文件上传地址，当然也可以直接写在input的data-url属性内
          dataType: "json", //如果不指定json类型，则传来的json字符串就需要解析jQuery.parseJSON(data.result);

          done: function (e, data) {
              //done方法就是上传完毕的回调函数，其他回调函数可以自行查看api
              //注意data要和jquery的ajax的data参数区分，这个对象包含了整个请求信息
              //返回的数据在data.result中，这里dataType中设置的返回的数据类型为json
              if (data.result.sta) {
                  // 上传成功：
                  console.log('成功');
                  $('#video').val(data.result.previewSrc );
                  $(".upstatus").html(data.result.msg);
                  $(".preview").html("<video src="+ data.result.previewSrc +" loop='loop' autoplay='autoplay' width='100px' height='100px'></video>");
              } else {
                  // 上传失败：
                  alert(data.result.msg);
                  $(".progress .bar").css("width", "0%");
                  $(".upstatus").html("<span style='color:red;'>" + data.result.msg + "</span>");
              }

          },
          progress: function (e, data) { //上传进度
              console.log('正在上传');
              var progress = parseInt(data.loaded / data.total * 100, 10);
              $(".progress .bar").css("width", progress + "%");
              $(".upstatus").html("正在上传...");
          }
      });
      function deleteVideo(){
          $.ajax({
              url: 'index.php?route=catalog/gallery/deleteVideo'+"<?php echo $edit_video_url; ?>",
              dataType: 'json',
              data:{video:'<?php echo $video; ?>'},
              success: function() {
                  $(".preview").html("");
              },
              error:function(){
                  alert("删除失败");
              }
          });
      }

  </script>
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

      // var image_row = <?php echo $image_row; ?>;

      // function addImage() {
      //     html  = '<tr id="image-row' + image_row + '">';
      //     html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="gallery_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
      //     html += '  <td class="text-right"><input type="text" name="gallery_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
      //     html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
      //     html += '</tr>';

      //     $('#images tbody').append(html);

      //     image_row++;
      // }

      //--></script></div>
<?php echo $footer; ?>