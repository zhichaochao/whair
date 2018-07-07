<?php echo $header; ?>
<div class="haircare">
      <div class="content in_content clearfix">
        <div class="hair_text clearfix">
          <img class="changeimage bnr_img" data-image='<?php echo $images ?>' data-mimage='<?php echo $images ?>'  />
          <div class="text2 clearfix">
            <div class="left fl clearfix">
              <p>Author : <span><?php echo $author ?></span> / <?php echo $update_time ?></p>
              <span class="ll_span"><?php echo $view ?></span>
            </div>
            <div class="right fr clearfix">
              <ul>
                <li><a href="###"><img src="catalog/view/theme/default/img/png/hc_1.png"/></a></li>
                <li><a href="###"><img src="catalog/view/theme/default/img/png/hc_2.png"/></a></li>
                <li><a href="###"><img src="catalog/view/theme/default/img/png/hc_3.png"/></a></li>
                <li><a href="###"><img src="catalog/view/theme/default/img/png/hc_4.png"/></a></li>
                <li><a href="###"><img src="catalog/view/theme/default/img/png/hc_5.png"/></a></li>
              </ul>
            </div>
          </div>
          <?=$description;?>
        </div>      
      </div>
    </div>
<?php echo $footer; ?>