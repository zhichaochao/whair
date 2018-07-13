<?php echo $header; ?>
  <!--内容-->
  <?php echo $column_left; ?>
    <div class="content in_content pro_content  search_div" id="content"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
        <div class="form_sr clearfix">
          <p class="p_sr"><?php echo $entry_search; ?></p>
          <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="input_sr" />
           <select name="category_id" class="form-control">
            <option value="0"><?php echo $text_category; ?></option>
            <?php foreach ($categories as $category_1) { ?>
            <?php if ($category_1['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
            <?php } ?>
            <?php foreach ($category_1['children'] as $category_2) { ?>
            <?php if ($category_2['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php } ?>
            <?php foreach ($category_2['children'] as $category_3) { ?>
            <?php if ($category_3['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php } ?>
          </select>

           <div class="sr_div sr_div1">
            <?php if ($sub_category) { ?>
            <input type="checkbox" name="sub_category" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="sub_category" value="1" />
            <?php } ?>
           <p> <?php echo $text_sub_category; ?></p>
          </div>


          <div class="sr_div sr_div2">
          <?php if ($description) { ?>
          <input type="checkbox" name="description" value="1" id="description" checked="checked" />
          <?php } else { ?>
          <input type="checkbox" name="description" value="1" id="description" />
          <?php } ?>
          <p><?php echo $entry_description; ?></p>
       </div>
       
          <button class="clearfix" value="<?php echo $button_search; ?>" id="button-search">Search</button>
        </div>
      <div class="ser_bot clearfix">
        <h1><?php echo $text_search; ?></h1>
        <?php if ($products) { ?>
        <label for="">
          <span>Sort By:</span>
           <select id="input-sort" class="form-control" onchange="location = this.value;">
              <?php foreach ($sorts as $sorts) { ?>
              <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
              <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
        </label>
        
        <ul class="pro_ul clearfix">
        <?php foreach ($products as $product) { ?>
            <li>
              <a href="<?php echo $product['href']; ?>">
                <div class="pic_img">
                  <img src="<?php echo $product['thumb']; ?>" style="width: 367px;height: 367px;"/>
                </div>
                <div class="text clearfix">
                <?php if($product['special']) { ?>
                     <span><?php echo $product['special']['special']; ?></span>
                     <del style="font-size:1.25vw;"><?php echo $product['price']; ?></del>
                  <?php }else{ ?>
                     <span class="price-single"><?php echo $product['price']; ?></span>
                  <?php } ?>
                  <p class="p1"><?php echo $product['color_name']; ?></p>
                  <p><?php echo $product['name']; ?></p>
                </div>
              </a>
              <div class="sc_div <?=$product['wishlist']==1 ?'off':'';?>"
            
                       
               onclick="wishlist('<?php echo $product['product_id']; ?>',this);" ></div>
            </li>
          <?php } ?>
          <?php echo $content_bottom; ?>
          </ul>
          <div class="fy_div clearfix">
           <?php echo $pagination; ?>  
        </div>
      <?php } else { ?>
      <p style="font-size: 18px;"><?php echo $text_empty; ?></p>
      <?php } ?>
      </div>
      <?php echo $column_right; ?>
    </div>


<script type="text/javascript"><!--
$('#button-search').bind('click', function() {
	//url = 'index.php?route=product/search';
	url = "<?php echo $search_url; ?>";

	var search = $('#content input[name=\'search\']').prop('value');

	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').prop('value');

	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}

	var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');

	if (sub_category) {
		url += '&sub_category=true';
	}

	var filter_description = $('#content input[name=\'description\']:checked').prop('value');

	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#content input[name=\'search\']').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').on('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').prop('disabled', true);
	} else {
		$('input[name=\'sub_category\']').prop('disabled', false);
	}
});

$('select[name=\'category_id\']').trigger('change');
//收藏
    $(".pro_content .pro_ul .sc_div").click(function(){
      var win = $(window).width()
      
      if(win>750){
        if($(this).hasClass("off")){
          $(this).removeClass("off");
          $(this).css("background","url(catalog/view/theme/default/img/png/pro_star.png) no-repeat").css("background-size","1.87vw 1.87vw");
        }else{
          $(this).addClass("off");
          $(this).css("background","url(catalog/view/theme/default/img/png/pro_star_.png) no-repeat").css("background-size","1.87vw 1.87vw");
        }
      }else{
        if($(this).hasClass("off")){
          $(this).removeClass("off");
          $(this).css("background","url(catalog/view/theme/default/img/png/pro_star.png) no-repeat").css("background-size","0.5rem 0.5rem");
        }else{
          $(this).addClass("off");
          $(this).css("background","url(catalog/view/theme/default/img/png/pro_star_.png) no-repeat").css("background-size","0.5rem 0.5rem");
        }
      }
    })
    function wishlist(product_id,e) {
  if ($(e).hasClass('off')) {
       $.ajax({
    url:'<?php echo $delewishlist ;?>',
    type:'post',
    data:{'product_id':product_id},
    dataType: 'json',
    success:function(data){
      if (data.success) {
        $('#wishlist_count').html(data.total);
      }
               // location.reload(); 
    }
   })

  }else{
  //alert(product_id);die;
   $.ajax({
    url:'<?php echo $wishlist ;?>',
    type:'post',
    data:{'product_id':product_id},
    dataType: 'json',
    success:function(data){
      if (data.success) {
        $('#wishlist_count').html(data.total);
      }
               // location.reload(); 
    }
   })
 }
}
--></script>
<?php echo $footer; ?>