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
                
                <?php if(isset($homes[0])){ ?>   
                <div class="top clearfix">
                    <div class="bt2">
                        <h1>One Donor <?=$homes[0]['category']['name'];?></h1>
                        <a href="<?=$homes[0]['category_url'];?>" class="a_btn">VIEW MORE &nbsp;&nbsp;><span class="triangle"><em></em></span></a>
                    </div>
                    <div class="video_div">
                        <video id="video" class="video" poster="<?=$homes[0]['image'];?>" src="<?=$homes[0]['video'];?>" ></video>
                        <div class="bg_div"></div>
                    </div>
                </div>
             <?php if(isset($homes[0]['child'])){ ?>
                <ol class="ol_img2 ol_img clearfix">
                    <?php   foreach ($homes[0]['child'] as $k => $val) { if($k < 3){ ?>
                    <li>
                        <a href="<?=$val['url'];?>">
                            <div class="pic">
                                <img class="changeimage" data-image="<?=$val['image'];?>" src="<?=$val['image'];?>" data-mimage="<?=$val['image'];?>"  />
                                <p><?=$val['name'];?></p>
                            </div>
                            <div class="text">
                                <span><?=$val['special']?$val['special']['special']:$val['price'];?></span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                    <?php } }?>
               
                </ol>
                <?php } }?>
                  <?php if(isset($homes[1])){ ?>   
                <div class="top top2 clearfix">
                    <div class="bt2">
                        <h1><?=$homes[1]['category']['name'];?></h1>
                        <a href="<?=$homes[1]['category_url'];?>" class="a_btn">VIEW MORE &nbsp;&nbsp;><span class="triangle"><em></em></span></a>
                    </div>
                    <img class="top2_img changeimage" data-image="<?=$homes[1]['image'];?>" src="<?=$homes[1]['image'];?>" data-mimage="<?=$homes[1]['mimage'];?>"  />
                    
                </div>
                    <?php if(isset($homes[1]['child'])){ ?>
                <ol class="ol_img3 ol_img clearfix">
                     <?php   foreach ($homes[1]['child'] as $k => $val) { if($k < 4){ ?>
                    <li>
                        <a href="<?=$val['url'];?>">
                            <div class="pic">
                                <img class="changeimage" data-image="<?=$val['image'];?>" src="<?=$val['image'];?>"  data-mimage="<?=$val['image'];?>"  />
                                <p><?=$val['name'];?></p>
                            </div>
                            <div class="text">
                                <span><?=$val['special']?$val['special']['special']:$val['price'];?></span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                          <?php } }?>
                </ol>
                    <?php } }?>
               <?php if(isset($homes[2])){ ?>   
                <div class="top top3 clearfix">
                    <div class="bt2">
                        <h1><?=$homes[2]['category']['name'];?></h1>
                        <a href="<?=$homes[2]['category_url'];?>" class="a_btn">VIEW MORE &nbsp;&nbsp;><span class="triangle"><em></em></span></a>
                    </div>
                    <img class="top3_img changeimage" data-image="<?=$homes[2]['image'];?>" src="<?=$homes[2]['image'];?>" data-mimage="<?=$homes[2]['mimage'];?>"  />
                </div>
                    <?php if(isset($homes[2]['child'])){ ?>
                <ol class="ol_img4 ol_img clearfix">
                      <?php   foreach ($homes[2]['child'] as $k => $val) { if($k < 4){ ?>
                    <li>
                       <a href="<?=$val['url'];?>">
                            <div class="pic">
                                <img class="changeimage" data-image="<?=$val['image'];?>" src="<?=$val['image'];?>"  data-mimage="<?=$val['image'];?>"  />
                                 <p><?=$val['name'];?></p>
                            </div>
                            <div class="text">
                                 <span><?=$val['special']?$val['special']['special']:$val['price'];?></span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                          <?php } }?>
                </ol>
                 <?php } }?>
            </div>
            <?php if(isset($homes[3])){ ?>    
            <div class="index_text index_text2">
                <div class="bt">
                    <img src="catalog/view/theme/default/img/png/bt2.png" alt="" />
                    <h1><?=$homes[3]['category']['name'];?></h1>
                </div>
                
                <div class="top top4">
                    <div class="bt2">
                        <a href="<?=$homes[3]['category_url'];?>" class="a_btn">VIEW MORE &nbsp;&nbsp;><span class="triangle"><em></em></span></a>
                    </div>
                    <img class="top4_img changeimage" data-image="<?=$homes[3]['image'];?>" src="<?=$homes[3]['image'];?>" data-mimage="<?=$homes[3]['mimage'];?>"  />
                </div>
                   <?php if(isset($homes[3]['child'])){ ?>
                <ol class="ol_img5 ol_img clearfix">
                      <?php   foreach ($homes[3]['child'] as $k => $val) { if($k < 5){ ?>
                    <li>
                       <a href="<?=$val['url'];?>">
                            <div class="pic">
                                <img class="changeimage" data-image="<?=$val['image'];?>" src="<?=$val['image'];?>"  data-mimage="<?=$val['image'];?>" />
                              <p><?=$val['name'];?></p>
                            </div>
                            <div class="text">
                              
                                  <span><?=$val['special']?$val['special']['special']:$val['price'];?></span>
                                <p>SHOW NOW  ></p>
                            </div>
                        </a>
                    </li>
                       <?php  }} ?>
                </ol>
                    <?php  }?>
            </div>
              <?php  }?>
            <div class="index_text3">
                <div class="bt">
                    <img src="catalog/view/theme/default/img/png/bt2.png" alt="CUSTOMER SHARE" />
                    <h1># CUSTOMER SHARE</h1>
                    <p>Customers share pictures and immediately buy the same</p>
                </div>
                
                <ol class="ol_img6 clearfix">
                      <?php foreach ($gallerys as $gallery) { ?>
                    <li>
                        <a href="<?=$gallery['url']?>">
                            <img src="<?=$gallery['image']?>" title="<?=$gallery['gallery_title']?>" alt="<?=$gallery['gallery_title']?>" />
                        </a>
                    </li>
                    <?php } ?>
               
                
                </ol>
                
                <div class="product_lb clearfix">
                    <div class="swiper-container" id="swiper2">
                      <div class="swiper-wrapper">
                        <?php foreach ($gallerys as $gallery) { ?>
                            <div class="swiper-slide">
                                <a href="<?=$gallery['url']?>">
                                    <img src="<?=$gallery['image']?>" title="<?=$gallery['gallery_title']?>" alt="<?=$gallery['gallery_title']?>" />
                                </a>
                            </div>
                        <?php } ?>
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
        