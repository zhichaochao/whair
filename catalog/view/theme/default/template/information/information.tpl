<?php echo $header; ?>
<!--内容-->
    <div class=" in_content peo_center">
      <div class="content clearfix">
        
        <div class="left clearfix">
          <h1>CATALOGUE</h1>
          <ol>

    <?php if($informations) { ?>
      <?php foreach($informations as $key => $value) { ?>

    
          <li class="<?php echo $value['class']; ?>">
            <a href="<?php echo $value['url']; ?>"><?php echo $value['title']; ?></a>
          </li>

      <?php } ?>
    <?php } ?>


          </ol>
        </div>
        
        <div class="right fot_text clearfix">
          <h1 class="footer_h1"><?=$heading_title;?></h1>
         <?=$description;?>
        
        </div>
        
      </div>
      
      
    </div>

<?php echo $footer; ?>