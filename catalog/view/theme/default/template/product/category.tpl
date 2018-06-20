<?php echo $header; ?>

<div>
  <!-- <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul> -->
  
  <!-- <div class="row" style="width:900px;" style="background:red;"> -->
   <!--  <?php echo $column_left; ?>    
  
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?> -->
    
    <!-- <div id="content" class="<?php echo $class; ?>">
      <?php echo $content_top; ?>
     
      <h2><?php echo $heading_title; ?></h2>     
          
      <?php if ($products) { ?>
 -->    <!--   <div class="row">
        <!--<div class="col-md-2 col-sm-6 hidden-xs">
          <div class="btn-group btn-group-sm">
         <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
         <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
          </div>
        </div>-->
        
        <!-- <div class="col-md-4 col-xs-6" style="background:blue;">
          <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-sort"><?php echo $text_sort; ?></label>
            <select id="input-sort" class="form-control" onchange="location = this.value;">
              <?php foreach ($sorts as $sorts) { ?>
              <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
              <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div> -->
       <!--  </div>
        <div class="col-md-3 col-xs-6" >
          <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-limit"><?php echo $text_limit; ?></label>
            <select id="input-limit" class="form-control" onchange="location = this.value;">
              <?php foreach ($limits as $limits) { ?>
              <?php if ($limits['value'] == $limit) { ?>
              <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div> -->
     <!--  </div> --> 
      <!--内容-->
    <div class="content in_content product">
      <div class="pro_content clearfix">
        <div class="top clearfix">
          <h1>DOUBLE DRAWN FUNMI HAIR [<span>24</span>]</h1>
          <span class="sortby"><span>+</span> SORT BY</span>
          <ol class="sortby_ol">
            <li><a href="<?php echo $sort_sort_rating?>">Best selling</a></li>
            <li><a href="<?php echo $sort_sort_add?>">Newest</a></li>
            <li><a href="<?php echo $sort_sort_order?>">Lowest price</a></li>
            <li><a href="<?php echo $sort_sort_order_d?>">Highest price</a></li>
          </ol>
        </div>
        <div class="pro_text clearfix">
          <ul class="pro_ul">
           <?php foreach ($products as $product) { ?>
            <li>
              <a href="<?php echo $product['href']; ?>">
                <div class="pic_img" >
                  <img src="<?php echo $product['thumb']; ?>"   alt='<?php echo $product["max_name"]; ?>'  style="width: 353px;height: 355px;" />
                </div>
                <div class="text clearfix" >
                <span class="price">
                  <?php if($product['special']) { ?>
                     <span><?php echo $product['special']['special']; ?></span>
                     <del><?php echo $product['price']; ?></del>
                  <?php }else{ ?>
                     <span class="price-single"><?php echo $product['price']; ?></span>
                  <?php } ?>
                </span>
                  <!-- <span>$35.30</span> -->
                  <p class="p1"><?php echo $product['texture']; ?></p>
                  <p><?php echo $product['name']; ?></p>
                </div>
              </a>
              <div class="sc_div" onclick="wishlist('<?php echo $product['product_id']; ?>');" ></div>
            </li>
             <?php } ?>
          </ul>
        </div>
        <!-- 分页 -->
        <div class="bot clearfix">
        <div class="left"><?php echo $pagination; ?></div>
          <div class="right">
            <p><?php echo $results; ?></p>
          </div>
        </div>
      </div>
    </div>
      
      
      <?php }else{ ?>
       <p><?php echo $text_empty; ?></p>
       <div class="buttons">
         <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
       </div>
      <?php } ?>
      
      <?php echo $content_bottom; ?>
    </div>
   <?php echo $column_right; ?>
  </div>
</div>
<script>
 function wishlist(product_id) {
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
  $(function(){
    
    //sortby
    $(".sortby").click(function(){
      if($(this).hasClass("off")){
        $(this).removeClass("off");
        $(this).find("span").text("+");
        $(this).siblings(".sortby_ol").slideUp();
      }else{
        $(this).addClass("off");
        $(this).find("span").text("-");
        $(this).siblings(".sortby_ol").slideDown();
      }
    })
    
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
  })
</script>
<?php echo $footer; ?>
