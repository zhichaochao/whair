
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
        
    <section class="content">
        <!-- 错误提示 -->
        <?php if(!empty($msg)){ ?>
        <div class="alert alert-danger alert-dismissable" id="jwx_alert_errer">
            <i class="fa fa-ban"></i> <b>错误提示!</b>
            <div class="conter" style=" width: 80%; margin: 10px 0 0 26px;">
                <?php if (!empty($msg)) foreach($msg as $item) { ?>
                        <p><?php echo $item; ?></p>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
        <!-- 成功提示 -->
        <?php if(!empty($info)){ ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $info; ?>
        </div>
        <?php } ?>
        
        <div style="padding-left:90px;">
            <form action="" method="post" enctype="multipart/form-data" id="form">
                <div class="supplier-order-add">
                    <div class="row" style="margin-bottom: 20px;">
                        <label class="col-md-2 control-label">请上传文件：</label>
                        <div class="col-md-5">
                            <input type="file" name="file" />
                        </div>
                    </div>
                    <div class="footer"><input type="button" value="<?php echo $title; ?>" onclick="$('form#form').submit();" style="margin-left:20%;" class="btn btn-primary" /></div>
                </div>
            </form>
            
            <div style="margin-top:20px;">
              <p><span>提示：</span></p>
              <p><span>1.</span><span> 只能使用模板文件导入，且每次只能上传一个</span><span>文件</span><span>；</span></p>
              <p><span>2. 文件</span><span>内容格式请严格按照文件模板。</span>
                <?php if(isset($tplUrl)){ ?> <a href="<?php echo $tplUrl; ?>">下载模板</a> <?php } ?> </p>
            </div>            
            
        </div>
    </section>
    
  </div>
</div>

<?php echo $footer; ?>

