<?php echo $header; ?>
    <div class="forget in_content clearfix">
      <div class="text clearfix"><?php echo $content_top; ?>
        <h1><?php echo $heading_title; ?></h1>
        <div class="bot clearfix">
          <p>
           <?php echo $text_password; ?>
          </p>
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="form_div clearfix">
              <label class="clearfix" for="">
                <span><?php echo $entry_password; ?>*</span>
                <input type="password" name="password" value="<?php echo $password; ?>" id="input-password" class="form-control" />
                <?php if ($error_password) { ?>
                <p class="ts_ps"><?php echo $error_password; ?></p>
              <?php } ?>
              </label>
              <label class="clearfix" for="">
                <span><?php echo $entry_confirm; ?>*</span>
                 <input type="password" name="confirm" value="<?php echo $confirm; ?>" id="input-confirm" class="form-control" />
                 <?php if ($error_confirm) { ?>
                 <p class="ts_ps"><?php echo $error_confirm; ?></p>
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