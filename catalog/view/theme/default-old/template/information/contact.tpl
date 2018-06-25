<style>
	.contact-title{
		text-align: center;
		font-size: 26px;
		color: #000000;
		font-weight: bold;
		line-height: 42px;
	}
	.contact-cont{
		font-size: 14px;
		margin-bottom:10px;
		color: #000;
	}
	.contact-find{
		font-size: 14px;
		color: #000000;
		font-weight: bold;
	}
	.contact-find span{
		font-weight: normal;
	}
</style>
<?php echo $header; ?>
<div class="container">

  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  
  <div class="row">
    <?php echo $column_left; ?>
    
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    
    <div id="content" class="<?php echo $class; ?>">
      <?php echo $content_top; ?>                 
      
      <div class="panel-group" id="accordion">
        <?php foreach ($locations as $location) { ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><a href="#collapse-location<?php echo $location['location_id']; ?>" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><?php echo $location['name']; ?> <i class="fa fa-caret-down"></i></a></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-location<?php echo $location['location_id']; ?>">
            <div class="panel-body">
              <div class="row">
                <?php if ($location['image']) { ?>
                <div class="col-sm-3"><img src="<?php echo $location['image']; ?>" alt="<?php echo $location['name']; ?>" title="<?php echo $location['name']; ?>" class="img-thumbnail" /></div>
                <?php } ?>
                <div class="col-sm-3"><strong><?php echo $location['name']; ?></strong><br />
                  <address>
                  <?php echo $location['address']; ?>
                  </address>
                  <?php if ($location['geocode']) { ?>
                  <a href="https://maps.google.com/maps?q=<?php echo urlencode($location['geocode']); ?>&hl=<?php echo $geocode_hl; ?>&t=m&z=15" target="_blank" class="btn btn-info"><i class="fa fa-map-marker"></i> <?php echo $button_map; ?></a>
                  <?php } ?>
                </div>
                <div class="col-sm-3"> <strong><?php echo $text_telephone; ?></strong><br>
                  <?php echo $location['telephone']; ?><br />
                  <br />
                  <?php if ($location['fax']) { ?>
                  <strong><?php echo $text_fax; ?></strong><br>
                  <?php echo $location['fax']; ?>
                  <?php } ?>
                </div>
                <div class="col-sm-3">
                  <?php if ($location['open']) { ?>
                  <strong><?php echo $text_open; ?></strong><br />
                  <?php echo $location['open']; ?><br />
                  <br />
                  <?php } ?>
                  <?php if ($location['comment']) { ?>
                  <strong><?php echo $text_comment; ?></strong><br />
                  <?php echo $location['comment']; ?>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <h2 class="contact-title">Contact Ted Hair</h2>
      <p class="contact-cont">We love hearing from our customers and new visitors.If you have any questions,concerns or quotation,just complete the details on this form and one of our sales representatives will be in contact with you within 24 hours!</p>
      <h4 class="contact-find">Find Us Quickly</h4>
      <h4 class="contact-find">Phone:&ensp;&ensp;<span>0086-13143343262</span></h4>
      <h4 class="contact-find">Whatsapp:&ensp;&ensp;<span>0086-13143343262</span></h4>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <legend></legend>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?>：</label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?>：</label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>

          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-fixed-line"><?php echo $entry_fixed_line; ?>：</label>
            <div class="col-sm-10">
              <input type="text" name="fixed_line" value="<?php echo $fixed_line; ?>" id="input-fixed-line" class="form-control" />
            </div>
          </div>          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-country"><?php echo $entry_country; ?>：</label>
            <div class="col-sm-10">
              <select name="country_id" id="inquiry-country" style="padding: 7px;width: 100%;">
				 <option value="">Please Choose Your Country</option>
			     <?php foreach ($countries as $country) { ?>
				 <option value="<?php echo $country['country_id']; ?>" <?php if($country['name']=='United States'){ ?>selected="selected"<?php } ?>><?php echo $country['name']; ?></option>
			     <?php } ?>
		      </select>
            </div>
          </div>          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-phone">Factime&amp; iMesssage ID：</label>
            <div class="col-sm-10">
              <input type="text" name="phone" value="<?php echo $phone; ?>" id="input-phone" class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-phone">Whatsapp ID：</label>
            <div class="col-sm-10">
              <input type="text" name="whatsapp" value="<?php echo $whatsapp; ?>" id="input-whatsapp" class="form-control" />
            </div>
          </div>
          
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?>：</label>
            <div class="col-sm-10">
              <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"><?php echo $enquiry; ?></textarea>
              <?php if ($error_enquiry) { ?>
              <div class="text-danger"><?php echo $error_enquiry; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php echo $captcha; ?>
        </fieldset>
        <div class="buttons">
          <div style="text-align: center;">
            <input style="font-size: 16px;" class="btn btn-primary inquiry-contact-gtm" type="submit" value="<?php echo $button_submit; ?>" />
          </div>
        </div>
      </form>
      <?php echo $content_bottom; ?>
    </div>
   <?php echo $column_right; ?>
  </div>
</div>
<?php echo $footer; ?>
