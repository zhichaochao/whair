








<div class="content in_content clearfix">
            <div class="banner">
                <div class="swiper-container" id="swiper1">
                    <div class="swiper-wrapper" style="cursor:-webkit-grab;">
                        <?php foreach ($banners as $k=> $banner) { ?>
                        <div class="swiper-slide ban_img">
                           <?php if ($banner['link']) { ?>
                             <a href="<?php echo $banner['link']; ?>"><img class="ban<?=$k+1;?> changeimage" data-image="<?php echo $banner['image']; ?>" data-mimage="<?php echo $banner['mimage']; ?>"  /></a>
                              <?php } else { ?>
                            <img class="ban<?=$k+1;?> changeimage" data-image="<?php echo $banner['image']; ?>" data-mimage="<?php echo $banner['mimage']; ?>"  />
                              <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>



<script type="text/javascript"><!--

    var swiper1 = new Swiper('#swiper1', {
        loop:true,
        autoplay: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
--></script>