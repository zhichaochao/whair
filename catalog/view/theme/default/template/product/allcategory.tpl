<?php echo $header; ?>

<!--内容-->
    <div class="content in_content address_content clearfix">
      <ul class="all_ul">

    <?php foreach ($rows as $vlaue ) { ?>
        <li class="clearfix">
          <a href="<?php echo $vlaue['href'];?>"><div class="pic_img">
            <img src="<?php echo $vlaue['m_image']; ?>"/>
            <div class="zzc_div"></div>
            <div class="text">
              <img src="catalog/view/theme/default/img/png/all_hair.png"/>
              <p><?php echo $vlaue['name']; ?></p>
            </div>
          </div></a>
        </li>
      <?php } ?>
              
      </ul>
    </div>
<?php echo $footer; ?>
