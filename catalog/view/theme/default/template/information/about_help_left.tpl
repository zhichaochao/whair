<div class="company_left" class="col-sm-3 hidden-xs">
  <ul>
    <?php if($informations) { ?>
      <?php foreach($informations as $key => $value) { ?>

    
          <li>
            <a href="<?php echo $value['url']; ?>"><?php echo $value['title']; ?></a>
          </li>

      <?php } ?>
    <?php } ?>
  </ul>
</div>
