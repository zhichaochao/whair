<?php echo $header; ?>
<div class="content in_content product">
      <div class="pro_content clearfix">
        <div class="top clearfix" >
         <h1>My collection</h1>
           <!-- <span class="sortby"><span>+</span> SORT BY</span>
          <ol class="sortby_ol">
            <li><a href="###">Best selling</a></li>
            <li><a href="###">Newest</a></li>
            <li><a href="###">Lowest price</a></li>
            <li><a href="###">Highest price</a></li>
          </ol> -->
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
                     <span><?php echo $product['special']; ?></span>
                     <del><?php echo $product['price']; ?></del>
                  <?php }else{ ?>
                     <span class="price-single"><?php echo $product['price']; ?></span>
                  <?php } ?>
                </span>
                  <!-- <span>$35.30</span> -->
                  <p class="p1"><?php echo $product['stock']; ?></p>
                  <p><?php echo $product['name']; ?></p>
                </div>
              </a>
              <div class="sc_div" onclick="wishlist('<?php echo $product['product_id']; ?>');" ></div>
            </li>
             <?php } ?>
          </ul>
        </div>
        <!-- 分页 -->
        <!-- <div class="bot clearfix">
        <div class="left"><?php echo $pagination; ?></div>
          <div class="right">
            <p><?php echo $results; ?></p>
          </div>
        </div> -->
      </div>
    </div>

<!--<div class="container">
   <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?> -->
  <!-- <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2><?php echo $heading_title; ?></h2>
      <?php if ($products) { ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-center"><?php echo $column_image; ?></td>
              <td class="text-left"><?php echo $column_name; ?></td>
              <td class="text-left"><?php echo $column_model; ?></td>
              <td class="text-right"><?php echo $column_stock; ?></td>
              <td class="text-right"><?php echo $column_price; ?></td>
              <td class="text-right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td class="text-center"><?php if ($product['thumb']) { ?>
                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                <?php } ?></td>
              <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></td>
              <td class="text-left"><?php echo $product['model']; ?></td>
              <td class="text-right"><?php echo $product['stock']; ?></td>
              <td class="text-right"><?php if ($product['price']) { ?>
                <div class="price">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <b><?php echo $product['special']; ?></b> <s><?php echo $product['price']; ?></s>
                  <?php } ?>
                </div>
                <?php } ?></td>
              <td class="text-right"><button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_cart; ?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i></button>
                <a href="<?php echo $product['remove']; ?>" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-times"></i></a></td>
            </tr>
            <?php } ?>





          </tbody>
        </table>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?>
      </div>
    <?php echo $column_right; ?></div>
</div> -->
<?php echo $footer; ?>