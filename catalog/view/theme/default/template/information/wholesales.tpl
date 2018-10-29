<?php echo $header; ?>

<section>
  <div class="container service-container">
  
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
    <?php } ?>
      
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
    <?php } ?>
  
    <div class="sellfrom">
      <p class="teimg"><img src="/catalog/view/theme/default/images/tzx/service/sell_from5.jpg" width="876" height="308"></p>
      
      <h2>Have difficulties finding a reliable hair vendor for wholesale?</h2>
      
      <p class="pp">If you are a professional wholesale distributor, Ted Hair is providing you top quality hair products 
        at most competitive price with extraordinary customer service.</p>
        
      <p class="pp">We will give you the support to create your own brand, convenient payment options, packaging 
        or label customization. Because we have own factory, we have access to raw materials and restrict 
        control of the quality process, so you can be always assured of your profit and clients' positive feedback.</p>
        
      <p class="pp">Our steep discounts on already-low prices will benefit you and your customers so you are saving and 
        making money at the same time! In fact, the more hair extensions you buy, the more money you save!</p>
    </div><!--/sellfrom-->
    
    <div class="sellfrom_how">
      <h2>How to start?</h2>
      <p>
        By filling in the following form and submit your informaiton, 
    you will receive the wholesale prices from one of our sales persons shortly!
      </p>
    </div>
    
    <div class="merchant_soyou sellfrom_salon2" id="wholesales-div">
      <h2>You are one step away to access to our wholesale prices</h2>      
      <?php echo $contact_us; ?>
    </div>
    
    
  </div>
</section>

<script type="text/javascript">

</script>

<?php echo $footer; ?>
