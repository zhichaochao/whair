<?php echo $header; ?>
<div class="container none">
    <div class="row"><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>">
            <?php echo $content_top; ?>

            <?php if(!empty($middle_pics)){ ?>
            <?php foreach ($middle_pics as $pics) { ?>
            <a href="<?php echo $pics['link']; ?>" target="_blank">
                <img src="<?php echo $pics['image']; ?>" alt="<?php echo $pics['title']; ?>" title="<?php echo $pics['title']; ?>" />
            </a>
            <?php } ?>
            <?php }else{ ?>
            <img src="<?php echo $middle_pics_1; ?>">
            <img src="<?php echo $middle_pics_2; ?>">
            <?php } ?>

            <?php echo $content_bottom; ?>

        </div>
        <?php echo $column_right; ?></div>
</div>


<div class="jwx_home j1200">
    <?php echo $slideshow; ?>
    <!--主类目-->
    <section>
        <ul class="idx-catg-box fixclea">
            <?php foreach($categories as $category) { ?>
            <li>
                <a href="<?php echo $category['href']; ?>">
                    <img src="<?php echo $category['pc_image']; ?>"/>
                    <?php echo $category['pc_show_title']; ?>
                </a>
            </li>
            <?php } ?>

        </ul>
    </section>
    <!--主页商品-->
    <section>
        <ul class="idx-prod-box fixclea">
            <?php foreach($recommend_products as $recommend_product) { ?>
            <li>
                <a href="<?php echo $recommend_product['product_link']; ?>">
                    <img src="<?php echo $recommend_product['image']; ?>"/>
                </a>
                <div class="idx-prod-info">
                    <!--商品标签-->
                    <p><i class="category-color-tag-box"><?php echo $recommend_product['texture']; ?></i></p>
                    <!--商品名-->
                    <h4><a class="idx-prod-name" href="<?php echo $recommend_product['product_link']; ?>" title=""><?php echo $recommend_product['name']; ?></a></h4>
                    <!--价格-->
                    <?php if($recommend_product['special']) { ?>
                    <p class="price">
                        <span><?php echo $recommend_product['special']['special']; ?></span>
                        <del><?php echo $recommend_product['price']; ?></del>
                    </p>
                    <?php } else { ?>
                    <p class="price">
                        <span class="price-single"><?php echo $recommend_product['price']; ?></span>
                    </p>
                    <?php } ?>
                </div>

            </li>
            <?php } ?>
        </ul>
    </section>
</div>

<?php echo $footer; ?>