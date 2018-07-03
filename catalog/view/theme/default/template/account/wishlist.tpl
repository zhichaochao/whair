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
            <li >
              <a class="one_a"  href="<?php echo $product['href']; ?>">
                <div class="pic_img">
                  <img src="<?php echo $product['thumb']; ?>"/>
                </div>
                <div class="text clearfix">
                   <?php if($product['special']) { ?>
                     <span><?php echo $product['special']['special']; ?></span>
                 
                  <?php }else{ ?>
                     <span ><?php echo $product['price']; ?></span>
                  <?php } ?>
                  <p class="p1"><?php echo $product['model']; ?></p>
                  <p><?php echo $product['name']; ?> </p>
                </div>
              </a>
              <div class="close" value="<?=$product['product_id']?>"></div>
              <div class="shop_a">
                <a class="two_a" href="<?=$product['href'];?>"><span>Move To Shopping Cart </span></a>
              </div>
            </li>
           
         <?php }?>
          
          </ul>
        </div>


      </div>
    </div>
<script type="text/javascript">
$(function(){
$(".shop_ul .close").click(function(){
   $(this).parents('li').remove();
   var product_id=$(this).attr('value');
   console.log(product_id);
   $.ajax({
    url:'<?php echo $wishlist_delete ;?>',
    type:'post',
    data:{'product_id':product_id},
    dataType: 'json',
    success:function(data){
    console.log(data);
               // location.reload(); 
    }
   })
      //  $.ajax({
      //   url:'<?php echo $wishlist_delete ;?>',
      //   type:'post',
      //   data:{'product_id':product_id},
      //   dataType: 'json',
      //   success:function(data){
      //     console.log(data);
      //   };
      // });
 });
  });
</script>

<?php echo $footer; ?>