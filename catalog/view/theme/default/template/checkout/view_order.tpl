<?php echo $header; ?>


<!--内容-->
        
        <div class="pay">
            <div class="content in_content clearfix">
                <div class="pay_text clearfix">
                    <h1>your order has been placed successfully, please make payment now.</h1>
                    <p class="lv_p">Order Number:<?php echo $order['order_no']; ?></p>
                    <table class="pay_tb1">
                         <?php if(is_array($totals)) foreach ($totals as $total) { ?>
                            <tr>
                                <td><span><?php echo $total['title']; ?></span></td>
                                <td><span><?php echo $total['value']; ?></span></td>
                            </tr>
                        <?php } ?>
                   
                       
                    </table>
                    
                 
                     <?php if ($payment_method_code == 'pp_express') { ?>

     <!--    <form action="<?php echo $payment; ?>" method="post">
          <p class="p3">
            <button type="submit" value="Confirm Order"><i class="fa fa-lock"></i>CHECKOUT</button>
          </p>
        </form> -->
                <div class="pay_4">
                        <img class="xs_pay" src="img/jpg/pay_xs.png" alt="" />
                        <p>
                            If you have PayPal account, please pay your order by PayPal account directly.<br />
                            If you don't have a paypal account, you can also pay via paypal with your credit 
                            card or bank debit card. Payment can be submitted in any currency!
                        </p>
                        <a class="check_a" href="<?php echo $payment; ?>">CHECK OUT &nbsp;&nbsp;></a>
                    </div>
                    
                        <?php } else { ?>
               <div class="text2 clearfix">
                      
                  
                        <h2>Please transfer to the following    <?php  if($order['payment_code']=='naria_account'){?>NAIRA<?php } ?> bank account <span></span></h2>

                        <table class="pay_tb1 pay_tb2">
                             <?php foreach($payment_method_attributes as $attribute) { ?>
                                  
                              <tr>
                                <td><span><?php echo $attribute['text']; ?>:</span></td>
                                <td><span> <?php echo $attribute['value']; ?></span></td>
                            </tr>
                                <?php } ?>
                          
                           
                        </table>
                        <p>
                            Notice: After you completed the payment with bank, please kindly 
                            upload the bank receipt to our website and notify your salesman 
                        </p>
                    
                    </div>
                    <div class="text3 clearfix">
                        <h2>Upload your bank receipt here <span></span></h2>
                        <div class="pd_div clearfix">
                            <p class="tsp_1">
                                Thanks for your payment, once we receive your money,<br /> 
                                your order will be arranged to ship in 48 working hours.
                            </p>
                            <form action="<?=$submit_bank_receipt;?>" method="post" enctype="multipart/form-data">
                            <div class="file_div">
                                <input type="file" name="bank_receipt" id="file" value="" title="上传照片" onchange="getphoto(this)" class="flie_in"/>
                                <img class="file_img" src="catalog/view/theme/default/img/png/file.png"/>
                            </div>
                            <div class="text_div">
                                <img src="" alt="" />
                                <div class="close" onclick="del_img($(this))"></div>
                                <button type="submit" class="tj_btn">SUBMIT</button>
                            </div>
                            </form>
                            <p class="tsp_2">
                                If upload error, please click the button to upload it again.
                            </p>
                        </div>
                        
                    </div>
                        <?php } ?>
                </div>
            </div>
        </div>
<?php echo $footer; ?>
<script>
        //调取上传框
        function getphoto(node) {
            var imgURL = "";
            try{
                var file = null;
                if(node.files && node.files[0] ){
                    file = node.files[0];
                }else if(node.files && node.files.item(0)) {
                    file = node.files.item(0);
                }
                try{
                    imgURL =  file.getAsDataURL();
                }catch(e){
                    imgRUL = window.URL.createObjectURL(file);
                }
            }catch(e){
                if (node.files && node.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        imgURL = e.target.result;
                    };
                    reader.readAsDataURL(node.files[0]);
                }
            }
            creatImg(imgRUL);
            $(".text_div").css("display","inline-block");
            $(".file_div").css("display","none");
            return imgURL;
        }
     
        //上传选中的图片 显示页面
        function creatImg(imgRUL){
            $(".text_div img").attr("src",imgRUL);
        }
        
        //删除选中的图片
        function del_img(obj){
            obj.siblings("img").attr("src","");
            obj.parent().css("display","none");
            $(".file_div").css("display","block");
        }
</script>
