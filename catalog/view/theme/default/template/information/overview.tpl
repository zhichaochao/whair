<?php echo $header; ?>

<section class="company">
  <div class="container">
  
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
    <?php } ?>
      
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
    <?php } ?>
  
    <?php echo $information_left; ?>
      
    <div class="company_right">
      <div class="company_right_mian cf">
        <h2 class="company_right_h2">Company Introduction</h2>
        <dl class="company_right_dl">
          <dt><img width="300" src="/catalog/view/theme/default/images/tzx/company/company_img.jpg"></dt>
          <dd>
              <p> <?=$meta_description?></p>
              <p>
                <button name="submit1" id="submit1" onclick="location.href='<?php echo $action; ?>#conus'">
                <img src="/catalog/view/theme/default/images/tzx/company/icon_4_w.png">Contact Us
                </button>
              </p>
          </dd>
        </dl>
      </div>
        
      <div class="company_right_mian cf">
        <h2 class="company_right_h2">Company Basic Information</h2>
       <?=$description?>
      </div>
        
      <div class="company_right_mian cf">
        <h2 class="company_right_h2"><a name="conus" id="conus">Contact Us</a></h2>        
        <?php echo $contact_us; ?>           
      </div><!--/company_right_mian-->
      
    </div><!--/company_right-->
  </div><!--/container-->
</section>

<?php echo $footer; ?>
