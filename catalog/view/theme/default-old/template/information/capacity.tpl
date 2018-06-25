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
        <h2 class="company_right_h2">Trade Capacity</h2>
        <div> <img src="/catalog/view/theme/default/images/tzx/company/company_1.png"> </div>
      </div>
      <div class="company_right_mian cf">
        <h2 class="company_right_h2">Trade Markets Distribution</h2>
        <div> <img src="/catalog/view/theme/default/images/tzx/company/company_2.jpg"> </div>
      </div>
      
      <div class="company_right_mian cf">
        <h2 class="company_right_h2">Contact Us</h2>        
        <?php echo $contact_us; ?>       
      </div>
    </div>
  </div>
</section>

<?php echo $footer; ?>
