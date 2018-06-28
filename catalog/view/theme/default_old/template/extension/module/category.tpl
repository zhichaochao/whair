<div class="list-group">
  <?php foreach ($categories as $category) { ?>
   
   <?php if ($category['category_id'] == $category_id) { ?>    
    <a href="<?php echo $category['href']; ?>" class="list-group-item active"><?php echo $category['name']; ?></a>
    
    <?php if ($category['children']) { ?>    
      <?php foreach ($category['children'] as $child) { ?>
      
        <?php if ($child['category_id'] == $child_id) { ?>
          <a href="<?php echo $child['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
        <?php } else { ?>
          <a href="<?php echo $child['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
        <?php } ?>
        
        <!--子类的子类(第三级)-->
        <?php foreach ($child['children_sub_data'] as $child_sub) { ?>
      
         <?php if ($child_sub['category_id'] == $child_sub_id) { ?>
           <a href="<?php echo $child_sub['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?php echo $child_sub['name']; ?></a>
         <?php } else { ?>
           <a href="<?php echo $child_sub['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?php echo $child_sub['name']; ?></a>
         <?php } ?>
        
        <?php } ?> 
        <!--/子类的子类(第三级)-->
        
      <?php } ?>    
    <?php } ?>
  
   <?php } else { ?>
    <a href="<?php echo $category['href']; ?>" class="list-group-item"><?php echo $category['name']; ?></a>
   <?php } ?>
  
  <?php } ?>
</div>
