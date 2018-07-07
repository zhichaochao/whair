<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-home" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-home" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="floor" value="<?php echo $floor; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
          
            </div>
          </div>
         
               <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_parent; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="path" value="<?php echo $path; ?>" placeholder="<?php echo $entry_parent; ?>" id="input-parent" class="form-control" />
                  <input type="hidden" name="category_id" value="<?php echo $category_id; ?>" />
                 
                </div>
              </div>
                 <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_video; ?></label>
                <div class="col-sm-10">
                  <ul style="list-style-type: none">
                    <!-- 预览框： -->
                    <li style="float: left;width: 100px">
                      <div class="preview">
                          <?php if($video){ ?>
                          <video src="<?php echo $video_url; ?>" loop="loop" autoplay="autoplay" width="100px" height="100px"></video>
                          <?php } ?>
                      </div>
                    </li>

                    <li style="float: left;width: 100px;margin-left: 10px">
                  <div style="margin-top:10px;">
                    <label for="input-video" class="input-video">请上传</label><br/>
                      <input id="input-video" style="display: none" type="file" name="files" class="upinput"/>
                      <div class="input-video" onclick="deleteVideo();">删除</div>
                  </div></li>
                  <input type="hidden" name="video" value="<?=$video;?>" id='video' />

                  </ul>

                </div>
              </div>
          <br />
          <ul class="nav nav-tabs" id="language">
         
          </ul>
          <div class="tab-content">
   
            <div class="tab-pane"  style="display: block;">
              <table id="images" class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <td class="text-left"><?php echo $entry_title; ?></td>
                    <td class="text-left"><?php echo $entry_link; ?></td>
                    <td class="text-center"><?php echo $entry_image; ?></td>
                    <td class="text-center"><?php echo $entry_mimage; ?></td>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                                                                                                                                                                                    
                </tbody>
                <tfoot>
                <tr id="image-row0">
                    <td class="text-left"><input name="title" value="<?=$title;?>" placeholder="标题" class="form-control" type="text">
                      </td>
              
                    <td class="text-left" style="width: 30%;"><input name="link" value="<?=$link;?>" placeholder="链接" class="form-control" type="text"></td>
                    <td class="text-center"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?=$thumb;?>" alt="" title="" data-placeholder="<?=$thumb;?>"></a>
                      <input name="image" value="<?=$image;?>" id="input-image" type="hidden"></td> 
                      <td class="text-center"><a href="" id="thumb-mimage" data-toggle="image" class="img-thumbnail"><img src="<?=$mthumb;?>" alt="" title="" data-placeholder="<?=$mthumb;?>"></a>
                      <input name="mimage" value="<?=$mimage;?>" id="input-mimage" type="hidden"></td>
             
                
                  </tr>
                </tfoot>
              </table>
            </div>
    
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script> 
</div>
  <script type="text/javascript"><!--
$('input[name=\'path\']').autocomplete({
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
    $('input[name=\'path\']').val(item['label']);
    $('input[name=\'category_id\']').val(item['value']);
  }
});
//--></script> 
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
   <script src="view/javascript/fileupload/jquery.ui.widget.js"></script>
  <script src="view/javascript/fileupload/jquery.iframe-transport.js"></script>
  <script src="view/javascript/fileupload/jquery.fileupload.js"></script>
  <script src="view/javascript/fileupload/jquery.xdr-transport.js"></script>
  <script type="text/javascript">
      $(".upinput").fileupload({

          url: "<?php echo $edit_video; ?>",//文件上传地址，当然也可以直接写在input的data-url属性内
          dataType: "json", //如果不指定json类型，则传来的json字符串就需要解析jQuery.parseJSON(data.result);

          done: function (e, data) {
              //done方法就是上传完毕的回调函数，其他回调函数可以自行查看api
              //注意data要和jquery的ajax的data参数区分，这个对象包含了整个请求信息
              //返回的数据在data.result中，这里dataType中设置的返回的数据类型为json
              if (data.result.sta) {
                  // 上传成功：
                  console.log('成功');
                  $(".upstatus").html(data.result.msg);
                  $(".preview").html("<video src="+ data.result.previewSrc +" loop='loop' autoplay='autoplay' width='100px' height='100px'></video>");
                  $('#video').val(data.result.previewSrc );
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
              url: '<?php echo $delete_video; ?>',
              dataType: 'json',
              data:{video:$('#video').val()},
              success: function() {
                $('#video').val('');
                  $(".preview").html("");
              },
              error:function(){
                  alert("删除失败");
              }
          });
      }

  </script>
<?php echo $footer; ?> 