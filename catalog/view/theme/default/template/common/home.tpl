<?php echo $header; ?>
   <!--banner-->
        <?=$slideshow;?>
        
        <!--内容-->
        <div class="content">
            <div class="index_text index_text1">
                <div class="bt">
                    <img src="catalog/view/theme/default/img/png/bt1.png"  />
                    <h1>THE SELECTION OF GOOD</h1>
                </div>
                
                <ul class="ul_in1 clearfix">
                    <?php foreach ($fasts as $fast) { ?>
                    <li>
                        <?php if($fast['link']){?>
                        <a href="<?=$fast['link'];?>">
                            <div class="pic clearfix">
                                <img class="changeimage" title="<?=$fast['title'];?>" alt="<?=$fast['title'];?>" data-image="<?=$fast['image'];?>" data-mimage="<?=$fast['mimage'];?>" src="<?=$fast['image'];?>" />
                            </div>
                            <div class="text">
                                <h2><?=$fast['title'];?></h2>
                                <p><?=$fast['mtitle'];?></p>
                            </div>
                        </a>
                        <?php }else{?>
                        <div class="pic clearfix">
                                <img class="changeimage" title="<?=$fast['title'];?>" alt="<?=$fast['title'];?>" data-image="<?=$fast['image'];?>" data-mimage="<?=$fast['mimage'];?>" src="<?=$fast['image'];?>"  />
                            </div>
                            <div class="text">
                                <h2><?=$fast['title'];?></h2>
                                <p><?=$fast['mtitle'];?></p>
                            </div>

                        <?php }?>
                        </li>
                    <?php } ?>
                    
                </ul>
                
                <div class="top clearfix">
                    <div class="bt2">
                        <h1>One Donor Raw Brazilian Hair</h1>
                        <a href="###" class="a_btn">VIEW MORE &nbsp;&nbsp;><span class="triangle"><em></em></span></a>
                    </div>
                    <div class="video_div">
                        <video id="video" class="video" poster="catalog/view/theme/default/img/jpg/video_bg.jpg" src="catalog/view/theme/default/img/myvideo.mp4" ></video>
                        <div class="bg_div"></div>
                    </div>
                </div>
                
                <ol class="ol_img2 ol_img clearfix">
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index2_1.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index2_1.jpg'  />
                                <p>Brazilian Virgin Hair (One Donor Virgin Hair)</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index2_2.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index2_2.jpg'  />
                                <p>Brazilian Virgin Hair (One Donor Virgin Hair)</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img src="catalog/view/theme/default/img/jpg/pc_index2_3.jpg" />
                                <p>Brazilian Virgin Hair (One Donor Virgin Hair)</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                </ol>
                
                <div class="top top2 clearfix">
                    <div class="bt2">
                        <h1>Fuller Virgin  Peruvian Hair</h1>
                        <a href="###" class="a_btn">VIEW MORE &nbsp;&nbsp;><span class="triangle"><em></em></span></a>
                    </div>
                    <img class="top2_img changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index3.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index3.jpg'  />
                    
                </div>
                
                <ol class="ol_img3 ol_img clearfix">
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index3_1.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index3_1.jpg'  />
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index3_2.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index3_2.jpg'  />
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index3_3.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index3_3.jpg'  />
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index3_4.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index3_4.jpg'  />
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                </ol>
                
                <div class="top top3 clearfix">
                    <div class="bt2">
                        <h1>Regular Virgin Peruvian Hair</h1>
                        <a href="###" class="a_btn">VIEW MORE &nbsp;&nbsp;><span class="triangle"><em></em></span></a>
                    </div>
                    <img class="top3_img changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index4.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index4.jpg'  />
                </div>
                
                <ol class="ol_img4 ol_img clearfix">
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index4_1.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index4_1.jpg'  />
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index4_2.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index4_2.jpg'  />
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index4_3.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index4_3.jpg'  />
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index4_4.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index4_4.jpg'  />
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                </ol>
                
            </div>
            
            <div class="index_text index_text2">
                <div class="bt">
                    <img src="catalog/view/theme/default/img/png/bt2.png" alt="" />
                    <h1>LACE CLOSURE & LACE FRONTAL</h1>
                </div>
                
                <div class="top top4">
                    <div class="bt2">
                        <a href="###" class="a_btn">VIEW MORE &nbsp;&nbsp;><span class="triangle"><em></em></span></a>
                    </div>
                    <img class="top4_img changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index5.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index5.jpg'  />
                </div>
                
                <ol class="ol_img5 ol_img clearfix">
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index5_1.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index5_1.jpg'  />
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index5_2.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index5_2.jpg'  />
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index5_3.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index5_3.jpg'  />
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img class="changeimage" data-image='catalog/view/theme/default/img/jpg/pc_index5_4.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_index5_4.jpg'  />
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <div class="pic">
                                <img src="catalog/view/theme/default/img/jpg/pc_index5_5.jpg"/>
                                <p>Bundle 3 Tone Peruvian Virgin Hair Body Wave</p>
                            </div>
                            <div class="text">
                                <span>$35.30</span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                </ol>
            </div>
            
            <div class="index_text3">
                <div class="bt">
                    <img src="catalog/view/theme/default/img/png/bt2.png" alt="" />
                    <h1># CUSTOMER SHARE</h1>
                    <p>Customers share pictures and immediately buy the same</p>
                </div>
                
                <ol class="ol_img6 clearfix">
                    <li>
                        <a href="###">
                            <img src="catalog/view/theme/default/img/jpg/pc_index6_1.jpg"/>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <img src="catalog/view/theme/default/img/jpg/pc_index6_2.jpg"/>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <img src="catalog/view/theme/default/img/jpg/pc_index6_3.jpg"/>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <img src="catalog/view/theme/default/img/jpg/pc_index6_4.jpg"/>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <img src="catalog/view/theme/default/img/jpg/pc_index6_5.jpg"/>
                        </a>
                    </li>
                    <li>
                        <a href="###">
                            <img src="catalog/view/theme/default/img/jpg/pc_index6_6.jpg"/>
                        </a>
                    </li>
                </ol>
                
                <div class="product_lb clearfix">
                    <div class="swiper-container" id="swiper2">
                      <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="###">
                                <img src="catalog/view/theme/default/img/jpg/yd_index6_1.jpg"/>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="###">
                                <img src="catalog/view/theme/default/img/jpg/yd_index6_2.jpg"/>
                            </a>    
                        </div>
                        <div class="swiper-slide">
                            <a href="###">
                                <img src="catalog/view/theme/default/img/jpg/yd_index6_3.jpg"/>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="###">
                                <img src="catalog/view/theme/default/img/jpg/yd_index6_4.jpg"/>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="###">
                                <img src="catalog/view/theme/default/img/jpg/yd_index6_5.jpg"/>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="###">
                                <img src="catalog/view/theme/default/img/jpg/yd_index6_6.jpg"/>
                            </a>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
            
        </div>
        
<?php echo $footer; ?>

<script>
 
    var mySwiper = new Swiper('#swiper2', {
        autoplay: true,
        slidesPerView : 3,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
    })


    $(function(){
        $('.fh_top').on('click',function (event) {
            event.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 500);
        })
        
        var myvideo = document.getElementById("video");
        $(".video_div .bg_div").click(function(){
            myvideo.play();
            $(".video_div .bg_div").css("display","none")
        })
        
     
        //替换手机端图片
        var win = $(window).width();
            if(win<=750){
              $(".video_div .video").attr("poster","catalog/view/theme/default/img/jpg/yd_video_bg.jpg");
            }else{
              $(".video_div .video").attr("poster","catalog/view/theme/default/img/jpg/video_bg.jpg");
            }
            if(win<=992){
                $(".img_modal .text").css("background"," url(catalog/view/theme/default/img/jpg/yd_modal.jpg) no-repeat ").css("background-size","4rem 4.5rem");
            }else{
                    $(".img_modal .text").css("background"," url(catalog/view/theme/default/img/jpg/pc_modal.jpg) no-repeat ");
            }
        $(window).resize(function() {
            var win = $(window).width();
            if(win<=750){
              $(".video_div .video").attr("poster","catalog/view/theme/default/img/jpg/yd_video_bg.jpg");
            }else{
              $(".video_div .video").attr("poster","catalog/view/theme/default/img/jpg/video_bg.jpg");
            }
            if(win<=992){
                $(".img_modal .text").css("background"," url(catalog/view/theme/default/img/jpg/yd_modal.jpg) no-repeat ").css("background-size","4rem 4.5rem");
            }else{
                    $(".img_modal .text").css("background"," url(catalog/view/theme/default/img/jpg/pc_modal.jpg) no-repeat ");
            }
        })
        
    })
    
    
</script>
        