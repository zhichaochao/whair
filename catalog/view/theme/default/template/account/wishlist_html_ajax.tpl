<meta charset="UTF-8">
<div class="bg_fff" id="movetocart_post">

		 <ul class="modal_ul clearfix">
		 	<?php if ($options) { ?>
			<?php foreach ($options as $option) { ?>	
				<?php if ($option['product_option_value']) { ?>
			<?php if ($option['type'] == 'select') { ?> 
          <li>
          	
            <span><?php if($option['required']) { ?>*<?php } ?><?=$option['name']?></span>
            <div class="select_div">
              <button class="select_btn"><span></span></button>
              <div class="select_ul">
              	<input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['product_option_value'][0]['product_option_value_id']; ?>" />
                <ul>
                <?php foreach ($option['product_option_value'] as $k=> $option_value) { ?>
                  <li onclick="selectthis(this);" class="<?php if($k==0) echo 'active'; ?>"   value="<?php echo $option_value['product_option_value_id']; ?>"  ><?php echo $option_value['name']; ?></li>
               <?php } ?>
                 
                </ul>
              </div>
            </div>
          </li>
         <?php }} ?><?php }} ?>
        </ul>
        <a class="a_btn" onclick="movetocart(<?=$product_id;?>);">Move To Shopping Cart</a>
     </div>

     <script type="text/javascript">
     $(function(){
     	$(".select_btn").each(function(){
			var tmp=$(this).parent().find('li.active').text();
		
			$(this).find('span').text(tmp);
		})
     });
     	function selectthis(this) {
     		var tmp=$(this).text();
     		$(this).addclass('active').parents('.select_ul').find('li').removeClass('active');
     		$(this).addclass('active').parents('.select_ul').find('span').text(tmp);
     	}
     	
     </script>