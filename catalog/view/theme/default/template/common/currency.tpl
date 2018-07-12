<?php if (count($currencies) > 1) { ?>
 <!--货币切换-->

                <div class="mn_type">
                  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-currency">
                    <div class="top clearfix">
                        <p class="currency_<?=$code;?>"><?=$code;?></p>
                        <div class="pic_img">
                            <img src="catalog/view/theme/default/img/png/down.png" alt="" />
                        </div>
                    </div>
                    <div class="bot">
                        <span><em></em></span>
                        <ul class="ul_type">
                              <?php foreach ($currencies as $currency) { ?>
                            <li class="currency_select_<?=$currency['code'];?>"><a onclick="submit_currency(this.name);"  name="<?php echo $currency['code']; ?>"><?=$currency['code'];?></a></li>
                               <?php } ?>
                        </ul>
                    </div>
                      <input type="hidden" id="currency_code" name="code" value="" />
                      <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                  </form>
                </div>
                
<script type="text/javascript">
  function submit_currency(name) {
    $('#currency_code').val(name);
    $('#form-currency').submit();
  }
</script>


<?php } ?>
