<?php echo $header;?>

<!--内容-->
    <div class="content in_content address_content clearfix">
      <ul class="all_ul">
      <?php if($navs){ foreach ($navs as $k => $nav) { ?>
      <?php if($nav['child']){?>
      <?php foreach($nav['child'] as $child => $childs) {?>
        <li class="clearfix">
          <a href="<?php echo $childs['url']; ?>"><div class="pic_img">
            <img src="<?php echo $childs['m_image']; ?>"/><p>
            <div class="zzc_div"></div></p>
          </div></a>
        </li>
        <?php } ?>
        <?php } ?>
       <?php } } ?>
      </ul>
    </div>
<?php echo $footer; ?>
