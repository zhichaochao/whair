<?php echo $header; ?>
<!--内容-->
    <div class="content in_content product promotion">
    <input type="hidden" name="allpage" value='<?=$allpage;?>' id='allpage'/>
<input type="hidden" name="page" value='1' id='page'/>
<input type="hidden" name="sort" value='<?=$sort;?>' id='sort'/>
<input type="hidden" name="order" value='<?=$order;?>' id='order'/>
<input type="hidden" name="limit" value='<?=$limit;?>' id='limit'/>
      <img class="changeimage img_bnr" data-image='/catalog/view/theme/default/img/jpg/promotion.jpg' data-mimage='/catalog/view/theme/default/img/jpg/yd_promotion.jpg'  />
      
      <h1>DISCOUNTED GOODS</h1>
      
      <div class="pro_content clearfix">
        <div class="pro_text clearfix">
          <ul class="pro_ul prolist">
            <?php foreach ($products as $product) { ?>
            <li>
              <a href="<?php echo $product['href']; ?>">
                <div class="pic_img">
                  <img src="<?php echo $product['thumb']; ?>" />
                </div>
                <div class="text clearfix">
                  <p><?php echo $product['name']; ?></p>
                  <div class="price">
                  <?php if($product['special']) { ?>
                     <span><?php echo $product['special']; ?></span>
                     <i><?php echo $product['price']; ?></i>
                  <?php }else{ ?>
                     <span ><?php echo $product['price']; ?></span>
                  <?php } ?>
                    <!-- <span>$35.30</span>
                    <i>$78.40</i> -->
                  </div>
                  <div class="fsbg_div">
                    <i>-<?php echo $product['off']; ?>%</i>
                    
                  </div>
                </div>
              </a>
              <div class="sc_div <?=$product['wishlist']==1 ?'off':'';?>"
                     
               onclick="wishlist('<?php echo $product['product_id']; ?>',this);" ></div>
              <!-- <div class="sc_div"></div> -->
            </li>
            <?php } ?>
          </ul>
        </div>
        <div class="bot clearfix">
        <div class="left"><?php echo $pagination; ?></div>
          <div class="right">
            <p><?php echo $results; ?></p>
          </div>
        </div>
      </div>
    </div>    
<div>
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
          $(this).css("background","url(/catalog/view/theme/default/img/png/pro_star.png) no-repeat").css("background-size","1.87vw 1.87vw");
        }else{
          $(this).addClass("off");
          $(this).css("background","url(/catalog/view/theme/default/img/png/pro_star_.png) no-repeat").css("background-size","1.87vw 1.87vw");
        }
      }else{
        if($(this).hasClass("off")){
          $(this).removeClass("off");
          $(this).css("background","url(/catalog/view/theme/default/img/png/pro_star.png) no-repeat").css("background-size","0.5rem 0.5rem");
        }else{
          $(this).addClass("off");
          $(this).css("background","url(/catalog/view/theme/default/img/png/pro_star_.png) no-repeat").css("background-size","0.5rem 0.5rem");
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
      // var category_id=$('#category_id').val();
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
                          url: 'index.php?route=product/promotion/loadpage&page='+page+'&sort='+sort+'&limit='+limit ,
                          dataType: 'json',
                          success: function(data) {
                            var result="";
                            // console.log( data);
                            for (var i =0; i < data.products.length ; i++) {
                            var addwinst="wishlist('"+data.products[i].product_id+"'";
                               result+='<li>'
                                  +'<a href="'+data.products[i].href+'">'
                                    +'<div class="pic_img" >'
                                        +'<img src="'+data.products[i].thumb+'"   />'
                                    + '</div>'
                                      + '<div class="text clearfix" >'
                                      +'<p>'+data.products[i].name
                                        +'</p>'
                                       + '<div class="price">';

                              if (data.products[i].special) {
                                 result += '  <span>'+data.products[i].special
                                            + '</span>'
                                           +' <i>'+data.products[i].price
                                            +'</i>';
                                          
                             }else{
                                      result+= '<span>'+data.products[i].price+'</span>';
                              }

                                    result+=   '</div>'
                                        +' <div class="fsbg_div">'
                                        +'<i>'+'-'+data.products[i].off+'%'    
                                        +'</i>' 
                                        + '</div>'
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
