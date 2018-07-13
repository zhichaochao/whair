<?php echo $header; ?>

<div>
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
                  <img src="<?php echo $product['thumb']; ?>"   />
                </div>
                <div class="text clearfix" >
                <span class="price">
                  <?php if($product['special']) { ?>
                     <span><?php echo $product['special']; ?></span>
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
              <div class="sc_div <?=$product['wishlist']==1 ?'off':'';?>"
             <?php if($product['wishlist']==1) { ?>
              style='background: rgba(0, 0, 0, 0) url("catalog/view/theme/default/img/png/pro_star_.png") no-repeat scroll 0% 0% / 1.87vw 1.87vw;';
              <?php }?>
                       
               onclick="wishlist('<?php echo $product['product_id']; ?>',this);" ></div>
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
    </div>
  </div>
</div>
<script>
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
