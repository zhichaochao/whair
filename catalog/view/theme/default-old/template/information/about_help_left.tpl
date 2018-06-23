<div class="company_left" class="col-sm-3 hidden-xs">
  <ul>
    <?php if($informations) { ?>
      <?php foreach($informations as $key => $information) { ?>
        <li><?php echo $key; ?></li>
        <?php foreach($information as $value) { ?>
          <li>
            <a href="<?php echo $value['seo_url']; ?>"><?php echo $value['title']; ?></a>
          </li>
        <?php } ?>
      <?php } ?>
    <?php } ?>
  </ul>
</div>
