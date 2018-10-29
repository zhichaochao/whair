<?php echo $header; ?>

<div>
<input type="hidden" name="allpage" value='<?=$allpage;?>' id='allpage'/>
<input type="hidden" name="page" value='1' id='page'/>
<input type="hidden" name="category_id" value='<?=$category_id;?>' id='category_id'/>
<input type="hidden" name="sort" value='<?=$sort;?>' id='sort'/>
<input type="hidden" name="order" value='<?=$order;?>' id='order'/>
<input type="hidden" name="limit" value='<?=$limit;?>' id='limit'/>
      <!--内容-->
    <div class="content in_content product">
      <div class="pro_content clearfix">
        <div class="top clearfix">
          <h1><?php echo $heading_title; ?> [<span><?php echo $product_total; ?></span>]</h1>
          <div class="s_page"><?php echo $pagination; ?></div>
          <span class="sortby"><span>+</span> SORT BY</span>
          <ol class="sortby_ol">
            <li><a href="<?php echo $sort_sort_rating?>">Best selling</a></li>
            <li><a href="<?php echo $sort_sort_add?>">Newest</a></li>
            <li><a href="<?php echo $sort_sort_order?>">Lowest price</a></li>
            <li><a href="<?php echo $sort_sort_order_d?>">Highest price</a></li>
          </ol>
        </div>
        <div class="pro_text clearfix">
          <ul class="pro_ul prolist">

           <?php foreach ($products as $product) { ?>
            <li>
              <a href="<?php echo $product['href']; ?>">
                <div class="pic_img" >
                  <img src="<?php echo $product['thumb']; ?>"   />
                </div>
                <div class="text clearfix" >
                <span class="price">
                  <?php if($product['special']) { ?>
                     <span><?php echo $product['special']; ?>
                     <del><?php echo $product['price']; ?></del></span>
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
          // $(this).css("background","url(/catalog/view/theme/default/img/png/pro_star.png) no-repeat").css("background-size","1.87vw 1.87vw");
        }else{
          $(this).addClass("off");
          // $(this).css("background","url(/catalog/view/theme/default/img/png/pro_star_.png) no-repeat").css("background-size","1.87vw 1.87vw");
        }
      }else{
        if($(this).hasClass("off")){
          $(this).removeClass("off");
          // $(this).css("background","url(/catalog/view/theme/default/img/png/pro_star.png) no-repeat").css("background-size","0.5rem 0.5rem");
        }else{
          $(this).addClass("off");
          // $(this).css("background","url(/catalog/view/theme/default/img/png/pro_star_.png) no-repeat").css("background-size","0.5rem 0.5rem");
        }
      }
    })
  })
</script>

<script>
    function loadmore(obj){
      var allpage=$('#allpage').val();
      var page=$('#page').val();
      var sort=$('#sort').val();
      var category_id=$('#category_id').val();
      var limit=$('#limit').val();
      var win =$(window).width();
        if(win<920){
             var scrollTop = $(obj).scrollTop();
            var scrollHeight = $(document).height();
            var windowHeight = $(obj).height();
            if (allpage>page) {
             if (scrollHeight-scrollTop - windowHeight<=250 ) {
              page++;
              $('#page').val(page);
               $.ajax({
                          url: 'index.php?route=product/category/loadpage&page='+page+'&sort='+sort+'&category_id='+category_id+'&limit='+limit ,
                          dataType: 'json',
                          success: function(data) {
                            var result="";
                            console.log( data.products );
                            for (var i =0; i < data.products.length ; i++) {
                            var addwinst="wishlist('"+data.products[i].product_id+"'";
                               result+='<li>'
                                  +'<a href="'+data.products[i].href+'">'
                                    +'<div class="pic_img" >'
                                        +'<img src="'+data.products[i].thumb+'"   />'
                                    + '</div>'
                                      + '<div class="text clearfix" >'
                                       + '<span class="price">';
                              if (data.products[i].special) {
                                 result += '  <span>'+data.products[i].special
                                           +' <del>'+data.products[i].price
                                            +'</del>'
                                          + '</span>';
                             }else{
                                      result+= '<span class="price-single">'+data.products[i].price+'</span>';
                              }
                                    result+=   '</span>'
                                        +' <p class="p1">'+data.products[i].texture
                                        + '</p>'
                                        +'<p>'+data.products[i].name
                                        +'</p>'
                                      +'</div>'
                                   +'</a>';
                                   if (data.products[i].wishlist==1) {
                                    result+='<div class="sc_div off" onclick="'+addwinst+',this);" >';
                                   }else{
                                    result+='<div class="sc_div" onclick="'+addwinst+',this);" >';
                                   }
                                  +'</div>'
                                  +'</li>';
                                   }
                                  // console.log(result);
                           $('.prolist').append(result);
                          }
                       })
                      } 
                    }
                    // else if(!$(".pro_text ").hasClass('over')){
                    //   $(".pro_text ").addClass('over')
                    //    $(".pro_text ").append("<p>加载完成</p>");
                    // }
                }
              }
    //页面滚动执行事件
    $(window).scroll(function (){
        loadmore($(this));
    });
</script>
<?php echo $footer; ?>
