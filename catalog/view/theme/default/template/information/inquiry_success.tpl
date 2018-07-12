<?php echo $header; ?>
<style>  
.service-container {
    padding: 60px 0;
    min-height: 450px;
}
.inquiry_title {
    font-size: 26px;
    line-height: 50px;
}
.container.service-container > p {
    line-height: 35px;
}
.return{
    margin-top:15px;
}
.contact-find{
	font-size: 12px;
	color: #000000;
	font-weight: bold;
}
.contact-find span{
	font-weight: normal;
}
</style>
<section>
  <div class="container service-container">    
      <div class="inquiry_title">We have received your inquiry, and we'll get back to you within 24hours.</div> 
      <p>Also you can click the HELP DESK  at the bottom right of the page to contact us between 8pm and 5am Washington Time.</p>
      <h4 class="contact-find">Find Us Quickly</h4>
      <h4 class="contact-find">Phone:&ensp;&ensp;<span><?php echo $telephone; ?></span></h4>
      <h4 class="contact-find">Whatsapp:&ensp;&ensp;<span><?php echo $telephone; ?></span></h4>
      <h4 class="contact-find">Email:&ensp;&ensp;<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></h4>
      <p>Thank you! </p>  
      <p class="return"><a href="javascript:history.go(-1);"><< return</a></p>       
  </div>
</section>

<?php echo $footer; ?>

<script type="text/javascript">
  $(document).ready(function(){
    sendEmail();
  });

  function sendEmail(){
    $.ajax({
      url: 'index.php?route=product/product/sendEmail',
      type: 'post',
    });
  }
</script>
