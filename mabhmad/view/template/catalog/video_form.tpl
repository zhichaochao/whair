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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
           <!--  <li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li> -->
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="video_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($video_description[$language['language_id']]) ? $video_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="video_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($video_description[$language['language_id']]) ? $video_description[$language['language_id']]['description'] : ''; ?></textarea>
                      <?php if (isset($error_description[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_description[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="video_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($video_description[$language['language_id']]) ? $video_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="video_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($video_description[$language['language_id']]) ? $video_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                    <div class="col-sm-10">
                      <textarea name="video_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($video_description[$language['language_id']]) ? $video_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-data">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $video_store)) { ?>
                        <input type="checkbox" name="video_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="video_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $video_store)) { ?>
                        <input type="checkbox" name="video_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="video_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <!-- 父类下拉框 -->
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_parent; ?></label>
                <div class="col-sm-10">
                  <select name="parent_id" id="input-parent" class="form-control">
                    <option value="0">---Top Level---</option>
                    <?php if($parents) { ?>
                      <?php foreach($parents as $parent) { ?>
                        <option 
                          <?php if($parent['video_id'] == $video_id) { ?>
                             style="display:none;"
                          <?php } ?>
                          value="<?php echo $parent['video_id']; ?>" 
                          <?php if($parent['video_id'] == $parent_id) { ?>
                            selected="selected"
                          <?php } ?> >
                          <?php echo $parent['title']; ?>
                        </option>
                      <?php } ?>
                    <?php } ?>
                    
                  </select>
                </div>
              </div>
              <!-- 父类下拉框 -->
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
                  <?php if ($error_keyword) { ?>
                  <div class="text-danger"><?php echo $error_keyword; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-bottom"><span data-toggle="tooltip" title="<?php echo $help_bottom; ?>"><?php echo $entry_bottom; ?></span></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <?php if ($bottom) { ?>
                      <input type="checkbox" name="bottom" value="1" checked="checked" id="input-bottom" />
                      <?php } else { ?>
                      <input type="checkbox" name="bottom" value="1" id="input-bottom" />
                      <?php } ?>
                      &nbsp; </label>
                  </div>
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
              <div class="form-group" >
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>   
               
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_video; ?></label>
                <div class="col-sm-10">
                <input type="text" name="video" value="<?php echo $video; ?>"  id="input-sort-order" class="form-control" />
                  <!-- <ul style="list-style-type: none">
                    <!-- 预览框： -->
                  <!--   <li style="float: left;width: 100px">
                      <div class="preview">
                          <?php if($video){ ?>
                          <video src="<?=$video_url;?>" loop="loop" autoplay="autoplay" width="100px" height="100px"></video><?php } ?>
                      </div>
                    </li>

                    <li style="float: left;width: 100px;margin-left: 10px">
                  <div style="margin-top:10px;">
                    <label for="input-video" class="input-video">请上传</label><br/>
                      <input id="input-video" style="display: none" type="file" name="files" class="upinput"/>
                      <div class="input-video" onclick="deleteVideo();">删除</div>
                  </div></li>
                  <input type="hidden" name="video" value="<?=$video;?>" id='video' />

                  </ul> --> 

                </div>
              </div> 

              <div class="form-group">
                  
                         <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_image; ?></label>
                      
                        <div class="col-sm-10">
                              <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail" >
                                  <img src="<?php echo $club_image; ?>" alt="" title="" data-placeholder="<?php echo $club_image; ?>" />
                              </a>
                              <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                      </div>

              </div>
              
     

            </div>
            <div class="tab-pane" id="tab-design">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_store; ?></td>
                      <td class="text-left"><?php echo $entry_layout; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-left"><?php echo $text_default; ?></td>
                      <td class="text-left"><select name="video_layout[0]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($video_layout[0]) && $video_layout[0] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php foreach ($stores as $store) { ?>
                    <tr>
                      <td class="text-left"><?php echo $store['name']; ?></td>
                      <td class="text-left"><select name="video_layout[<?php echo $store['store_id']; ?>]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($video_layout[$store['store_id']]) && $video_layout[$store['store_id']] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php } ?>
                  </tbody>
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
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>