<?php echo $header; ?>
<!--内容-->
    <div class="content in_content shopcart">
      <div class="shop_content clearfix">
        <div class="top clearfix">
          <h1>MY WISHLIST</h1>
          <p>Here you can see the hair in your Wishlist, make edits to your selection and add to your shopping cart.</p>
        </div>
        <div class="shop_text clearfix">
          <ul class="shop_ul">
    <?php foreach ($products as $product) { ?>
            <li id="product">
              <a class="one_a" href="<?php echo $product['href']; ?>">
                <div class="pic_img">
                  <img src="<?php echo $product['thumb']; ?>"  style="width:353px;height: 335px;" />
                </div>
                <div class="text clearfix">
                 <!--  <span>$35.30</span> -->
                 <span class="price">
                  <?php if($product['special']) { ?>
                     <span><?php echo $product['special']['special']; ?></span>
                     <del><?php echo $product['price']; ?></del>
                  <?php }else{ ?>
                     <span class="price-single"><?php echo $product['price']; ?></span>
                  <?php } ?>
                </span>

                  <p class="p1"><?php echo $product['stock']; ?></p>
                  <p><?php echo $product['name']; ?> </p>
                  <!-- <input type="hidden" name="product_id" value="<?php echo $product['product_id'];?>">   -->
                  <input class="hidden" type="hidden" value="1" id="nums"/>            
                  </div>
              </a>
              <a href="<?php echo $product['remove']; ?>"><div class="close"></div></a>
              <div class="select_div">
              
                <button class="select_btn"><span>12in  100g  1pc</span></button>
                <div class="select_ul">
                  <ul>
                    <li>12in  100g  1pc</li>
                    <li>14in  100g  1pc</li>
                    <li>16in  100g  1pc</li>
                    <li>18in  100g  1pc</li>
                    <li>20in  100g  1pc</li>
                    <li>22in  100g  1pc</li>
                    <li>24in  100g  1pc</li>
                    <li>26in  100g  1pc</li>
                    <li>28in  100g  1pc</li>
                    <li>30in  100g  1pc</li>
                  </ul>
                </div>
              </div>
              <div class="shop_a">
                <a class="two_a" id="button-cart"><span>Move To Shopping Cart </span></a>
              </div>
            </li>

           <?php } ?>
          </ul>
        </div>
      </div>
    </div>
   <script>
   //var product_id = "<?php echo $product_id; ?>";
    $('#button-cart').on('click', function() {

        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
             dataType: 'json',
            data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
           
     
            success: function(json) {
              if (json.success) {
              $('#cart_count').html(json.total);

           }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
  $(function(){
    //下拉选择
    var off = 0;
    $(".select_btn").on("click",function(event){
      if($(this).hasClass("off")){
        $(this).removeClass("off");
        $(this).siblings(".select_ul").stop().slideUp();
        off = 0;
      }else{
        $(".select_btn").removeClass("off");
        $(".select_ul").stop().slideUp();
        
        $(this).addClass("off");
        $(this).siblings(".select_ul").stop().slideDown();
        off = 1;
      }
       event.stopPropagation();
    })
    $(".shop_content .select_ul li").click(function(){
      var val = $(this).text();
      $(this).parents(".select_div").find(".select_btn span").text(val);
      $(".select_btn").removeClass("off");
      $(".select_ul").stop().slideUp();
    })
    $("body").click(function(e){
      if(off==1){
        var close = $('.select_div .select_ul'); 
          if(!close.is(e.target) && close.has(e.target).length === 0){
              $(".select_btn").removeClass("off");
          $(".select_ul").stop().slideUp();
          off=0;
        }
      }
      console.log(off)
    })
    
  })
</script> 
<?php echo $footer; ?>