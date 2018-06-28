<?php echo $header; ?>
<div class="container">

  <!--<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>-->
  
  <div class="row">
    
    <?php if ($column_left && $about_help_left) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $about_help_left) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    
    <?php echo $about_help_left; ?>    
  
    <div id="content" class="<?php echo $class; ?>">      
      <div class="panel-group" id="accordion">
         <?php echo $description; ?>
      </div>          
    </div>
  
  </div>
  
</div>
<?php echo $footer; ?>