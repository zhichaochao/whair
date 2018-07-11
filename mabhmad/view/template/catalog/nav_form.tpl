<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-nav" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-nav" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <?php foreach ($languages as $language) { ?>
              <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                <input type="text" name="nav_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($nav_description[$language['language_id']]) ? $nav_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
              </div>
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
              <?php } ?>
              <?php } ?>
            </div> 
          </div>
         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-parent"><?php echo $text_classify; ?></label>
            <div class="col-sm-10">
              <select class="form-control" name="parent_id" id="input-parent">
                <option value="0"><?=$text_frist_nav;?></option>
                <?php if($frist_navs){ foreach ($frist_navs as $key => $nav) { if($nav_id!=$nav['nav_id']){?>
                   <option <?=$parent_id==$nav['nav_id']?'selected':'';?> value="<?=$nav['nav_id'];?>"><?=$nav['name'];?><?=$text_drop_down;?></option>
                <?php }}}?>
              </select>
       
            </div>
          </div>
         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
        
      <!--     <div class="form-group url-content">
            <label class="col-sm-2 control-label" for="input-url"><?php echo $entry_url; ?></label>
            <div class="col-sm-10">
              <input type="text" name="url" value="<?php echo $url; ?>" placeholder="<?php echo $entry_url; ?>" id="input-url" class="form-control" />
            </div>
          </div> -->
       <!--    <div class="form-group url-content">
            <label class="col-sm-2 control-label " for="input-seo-url"><?php echo $entry_seo_url; ?></label>
            <div class="col-sm-10">
              <input type="text" name="seo_url" value="<?php echo $seo_url; ?>" placeholder="<?php echo $entry_seo_url; ?>" id="input-seo-url" class="form-control" />
            </div>
          </div> -->
        

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-type"><?php echo $text_choose_url; ?></label>
            <div class="col-sm-10">
              <select class="form-control" style=" width: 30%; float: left; margin-right: 3%;"  name="type" onchange="getnavsbytype(this.value)" id="input-type">
                <option  <?=$type=='especially'?'selected':'';?> value="especially"><?=$text_especially;?></option>
                <option  <?=$type=='category_id'?'selected':'';?> value="category_id"><?=$text_category;?></option>
                <option <?=$type=='profile_id'?'selected':'';?> value="profile_id"><?=$text_profile;?></option>
                <option <?=$type=='information_id'?'selected':'';?> value="information_id"><?=$text_information;?></option>
                <option  <?=$type=='product_id'?'selected':'';?> value="product_id"><?=$text_product;?></option>
              
              </select>
              <select class="form-control" style=" width: 40%;" onchange="changeinsideid(this.value)"  name="inside_id" id="input-inside-id">
          
               <!-- <option value="0"><?=$text_especially;?><?=$text_above;?></option> -->
              </select>
              <input type="hidden" name="tem" id='inside_id_tem' value="<?=$inside_id?>" />
            
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-is-target"><?php echo $entry_is_target; ?></label>
            <div class="col-sm-10">
              <input type="checkbox"   name="is_target"  <?= $is_target==1? 'checked': '' ; ?>  id="input-is-target" class="form-control" />
            </div>
          </div>
         
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
function getnavsbytype(type) {
  if (type!='especially') {$('.url-content').hide();}else{$('.url-content').show();}
   var inside_id=$('#inside_id_tem').val();

    $.ajax({
        url: '<?php echo $getnavsbytype;?>',
        type: 'post',
        data: {type:type,inside_id:inside_id},
        dataType: 'json',
               
        success: function(json) {
    
          $('#input-inside-id').html(json);

        }
      });
}
getnavsbytype($('#input-type').val());
 <?php if($inside_id==0&&$type=='especially'){ ?>
$('.url-content').show();
  <?php }?>

//--></script></div>
<?php echo $footer; ?>