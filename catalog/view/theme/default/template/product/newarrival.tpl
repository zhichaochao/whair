<?php echo $header; ?>
<div class="container">
  <!--<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>-->
  
  <div class="row">
    
    
    <div id="content" class="col-sm-12" style="margin-top: 50px;"><?php echo $content_top; ?>
     
      <h2><?php echo $heading_title; ?></h2>     
          
      <?php if ($products) { ?>
      <div class="row">
        
        
        <div class="col-md-4 col-xs-6">
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
          </div>
        </div>
        <div class="col-md-3 col-xs-6">
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
        </div>
      </div>
      
      <div class="row">
        <?php foreach ($products as $product) { ?>
        <div class="product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="product-thumb">
            <div class="image">
               <a href="<?php echo $product['href']; ?>">
          <img src="<?php echo $product['thumb']; ?>" alt='<?php echo $product["max_name"]; ?>' title='<?php echo $product["max_name"]; ?>' class="img-responsive" style="width:228px; height:228px;" />
               </a>
            </div>
            <div>
              <div class="caption">
                
                <?php if(!empty($product['color_name'])){ ?>
                <!--颜色名-->
                <p><?php echo $product['color_name']; ?></p>
                <?php } ?>
                
                <!--产品名-->
                <h4><a href="<?php echo $product['href']; ?>" title='<?php echo $product["max_name"]; ?>'><?php echo $product['name']; ?></a></h4>
                                
                <?php if($product['price']) { ?>
                <!--价格-->
                <p class="price">
                  <?php if($product['special']) { ?>
                     <span><?php echo $product['special']; ?></span>
                     <del><?php echo $product['price']; ?></del>
                  <?php }else{ ?>
                     <span class="price-single"><?php echo $product['price']; ?></span>
                  <?php } ?>                                                                      
               
                </p>
                <?php } ?>
                
                <?php if(false){ ?>
                <?php if ($product['rating']) { ?>
                <!--评论等级-->
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($product['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>
                <?php } ?>
              </div>
              
              
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      
      <div class="row ware-list-tfoot">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } ?>
      
      <?php if (!$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      
      <?php echo $content_bottom; ?>
     </div>    
   </div>
</div>
<?php echo $footer; ?>
