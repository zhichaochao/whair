<?php echo $header; ?>
<div class="forget in_content clearfix">
      <div class="text clearfix"><?php echo $content_top; ?>
        <h1><?php echo $heading_title; ?></h1>
        <div class="bot clearfix">
          <p>
           <?php echo $text_email; ?>
          </p>        
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="form_div clearfix">
              <label for="">
                <span><?php echo $text_your_email; ?>*</span>
               <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                 <?php if ($error_warning) { ?>
                <p class="ts_ps" ></i> <?php echo $error_warning; ?></p>
                <?php } ?>
              </label>
              <a class="back" href="<?php echo $back; ?>">BACK</a>
              <button class="continue" type="submit">CONTINUE</button>
            </div>
          </form>
           <?php echo $content_bottom; ?>
        </div>
      </div>
    </div>
<?php echo $footer; ?>