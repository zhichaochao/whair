<?php echo $header; ?>
<!--内容-->
    <div class=" in_content peo_center">
      <div class="content clearfix">
        <div class="left clearfix">
          <h1>CATALOGUE</h1>
          <ol>
          <?php if($inforon) { ?>
            <?php foreach($inforon as $key => $value) { ?>
                <li class="<?php echo $value['class']; ?>">
                  <a href="<?php echo $value['url']; ?>"><?php echo $value['title']; ?></a>
                </li>
            <?php } ?>
                <li class="active">
                  <a href="<?php echo $sitemap; ?>">SiteMap</a>
                </li>
          <?php } ?>
          </ol>
        </div>       
        <div class="right fot_text clearfix">
          <h1 class="footer_h1">Site Map</h1>
          <div class="fot_6">
            <dl>
            <?php foreach ($categories as $category_1) { ?>
            <dd><a href="<?php echo $category_1['href']; ?>"><i><?php echo $category_1['name']; ?></i></a>
              <?php if ($category_1['children']) { ?>
                <?php foreach ($category_1['children'] as $category_2) { ?>
              <div class="text">  
                <a href="<?php echo $category_2['href']; ?>"><i>><?php echo $category_2['name']; ?></i></a>
                  <?php if ($category_2['children']) { ?>
                    <?php foreach ($category_2['children'] as $category_3) { ?>
                   <a href="<?php echo $category_3['href']; ?>"><i><?php echo $category_3['name']; ?></i></a>
                    <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>
              <?php } ?>
            </dd>
            <?php } ?>
            </dl>
            <dl>
              <dt>MY ACCOUNT</dt>
              <dd><a href="<?php echo $order; ?>"><i>My Order</i></a></dd>
              <dd><a href="<?php echo $accountinformation; ?>"><i>Account Information</i></a></dd>
              <dd><a href="<?php echo $cart; ?>"><i>Shopping Cart</i></a></dd>
              <dd><a href="<?php echo $address; ?>"><i>Address List</i></a></dd>
              <dd><a href="<?php echo $wishlist; ?>"><i>My Wish List</i></a></dd>
              <dd><a href="<?php echo $vip; ?>"><i>My VIP</i></a></dd>
             <!--  <dd><a href="<?php echo $order; ?>"><i>My Coupon</i></a></dd> --> 
             <dd><a href="<?php echo $help; ?>"><i>Help Center</i></a></dd>
              <dd><a href="<?php echo $login; ?>"><i>Sign In</i></a></dd>
              <dd><a href="<?php echo $login; ?>"><i>Sign Up</i></a></dd>
            </dl>
            <dl>
              <dt>CUSTOMER SERVICE</dt>
              <?php foreach ($informations as $information) { ?>
                <dd><a href="<?php echo $information['href']; ?>"><i><?php echo $information['title']; ?></i></a></dd>
                <?php } ?>
            </dl>
          </div>
        </div>
      </div>
      <?php echo $content_bottom; ?>
      <?php echo $column_right; ?>
    </div>
<?php echo $footer; ?>