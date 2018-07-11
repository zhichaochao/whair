<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="catalog/view/theme/default/css/common.css" />
        <link rel="stylesheet" href="catalog/view/theme/default/css/index.css" />
        <link rel="stylesheet" href="catalog/view/theme/default/css/swiper.min.css" />
        <script type="text/javascript" src="catalog/view/theme/default/js/jquery.min.js" ></script>
        <script type="text/javascript" src="catalog/view/theme/default/js/common.js" ></script>
        <script type="text/javascript" src="catalog/view/theme/default/js/swiper.js" ></script>
        <title><?php echo $title; ?></title>
        <base href="<?php echo $base; ?>" />
        <?php if ($description) { ?>
        <meta name="description" content="<?php echo $description; ?>" />
        <?php } ?>
        <?php if ($keywords) { ?>
        <meta name="keywords" content= "<?php echo $keywords; ?>" />
        <?php } ?>
        <?php foreach ($styles as $style) { ?>
    <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
    <?php } ?>


    <?php foreach ($links as $link) { ?>
    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
    <?php } ?>

    <?php foreach ($scripts as $script) { ?>
    <script src="<?php echo $script; ?>" type="text/javascript"></script>
    <?php } ?>

    <?php foreach ($analytics as $analytic) { ?>
    <?php echo $analytic; ?>
    <?php } ?>



    <!-- Google Tag Manager -->
  <!--   <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-5NZ6HB');</script> -->
    <!-- End Google Tag Manager -->
    <!-- Google Tag Manager (noscript) -->
<!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5NZ6HB"
               height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>  -->
<!-- End Google Tag Manager (noscript) -->
<!-- 购物车 AJAX -->
<script type="text/javascript">
    // 购物车开关
 $(function(){
    $(".img_ol .cart_li").click(function(){
        $(".nav_cart").fadeIn();
        $.ajax({
            url: 'index.php?route=common/cart/info',
            dataType: 'html',
            success: function(html) {
                $('.nav_cart').html(html);
                 $(".nav_cart .close").click(function(){
                     $(".nav_cart").fadeOut();
                    });
                 
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });  
    })
});

</script>
    </head>

<body>
<!--头部-->
        <div class="big_nav">
            <div class="nav content clearfix">

                <?php echo $currency; ?>
                
               
                <!--logo-->
                <div class="logo">
                    <a href="<?php echo $root_home; ?>">
                        <img class="changeimage" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" data-image="catalog/view/theme/default/img/png/logo.png" data-mimage="catalog/view/theme/default/img/png/yd_logo.png"  src='catalog/view/theme/default/img/png/logo.png'  />
                    </a>
                </div>  
                
                <!--whatApp-->
                <p class="whatapp"><a  target="_blank"  href="whatsapp://send?phone=<?=$whatappphone;?>"><img src="catalog/view/theme/default/img/png/phone.png"/>WhatApp:<?=$whatappphone;?></a></p>
                
                <!--pc导航-->
                <ul class="nav_ul clearfix">
                    <li  <?php if($is_home=='/index.php?route=common/home'||$is_home=='/'||$is_home=='/index.php'||$is_home=='/common-home'){ ?>class="active"<?php } ?>><a href="<?php echo $home; ?>">Home</a></li>
                       <?php if($navs){ foreach ($navs as $k => $nav) { ?>
                    <li class="<?php if($nav['this_page']){ ?>active<?php } ?>">
                        <a  href="<?php echo $nav['url']; ?>"  <?=$nav['is_target']==1?'target="_blank"':''; ?> ><?=$nav['name'];?></a>
                          <?php if($nav['child']){?>
                        <div class="text clearfix">
                            <ol class="clearfix">
                                 <?php foreach ($nav['child'] as $key => $child) { ?>
                                 <li><a  <?=$child['is_target']==1?'target="_blank"':''; ?> href="<?php echo $child['url']; ?>"><?=$child['name']?></a></li>
                                 <?php } ?>
                            </ol>
                        </div>
                             <?php } ?>
                    </li>
                      <?php } }?>
                </ul>   
                
                <!--导航图标-->
                <div class="right">
                    <ol class="img_ol clearfix fl">
                        <li class="search_li"></li>
                        <li class="login_li"><a href="<?php echo $login_li?>"></a></li>
                        <li><a href="<?=$wishlist;?>"><span id='wishlist_count'><?php echo $text_wishlist; ?></span></a></li>
                        <li class="cart_li"><span  id='cart_count'><?=$text_cart_items;?></span></li>
                    </ol>
                </div>
                
                <!--搜索框-->
           <!--  <form method='post' action='<?php echo $search_url;?>'  class="search fl" >
                    <input class="btn_in" type="submit" value="">
                    <input class="text_in"  type="text" name="new_search" placeholder="Search">
                    <img class="close" src="catalog/view/theme/default/img/png/close2.png"/>
             </form> -->
             <form class="search fl">
              <input id="header-search" value="" type="" name="new_search" placeholder="Search">
                <img class="close" src="catalog/view/theme/default/img/png/close2.png"/>
              </form>
                
                <!--导航购物车-->
                <div class="nav_cart">
               
                    
              
                </div>
                
                <!--导航开关-->
                <div class="nav_off"></div>
                
                <!--移动导航-->
                <div class="yd_nav">
                    <div class="top">
                        <img class="menu" src="catalog/view/theme/default/img/png/menu.png"  />
                        <img class="close" src="catalog/view/theme/default/img/png/close2.png"/>
                    </div>
                    
                    <ul>
                    <?php if($navs){ foreach ($navs as $k => $nav) { ?>
                        <li class="clearfix">
                            <a  href="<?php echo $nav['url']; ?>"  <?=$nav['is_target']==1?'target="_blank"':''; ?> ><?=$nav['name'];?>   <?php if($nav['child']){?><img class="slide_img" src="catalog/view/theme/default/img/png/jiahao.png"/>  <?php } ?></a>
                            <?php if($nav['child']){?>
                            <ol class="yd_nav_ol clearfix">
                    
                              <?php foreach ($nav['child'] as $key => $child) { ?>
                                 <li class="clearfix"><a class="right_img"  <?=$child['is_target']==1?'target="_blank"':''; ?> href="<?php echo $child['url']; ?>"><?=$child['name']?></a></li>
                                 <?php } ?>
                            </ol>
                             <?php } ?>
                        </li>
                       <?php } }?>
                       
                    </ul>
                </div>
                
            </div>
        
        </div>
        <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
 <script>
        $(document).ready(function() {
            /* Search */
            $('.search_li ').click(function() {
               // alert(1111);die;
                url = '<?php echo $search_url; ?>';
                var value = $("input[name='new_search']").val();

                if (value) {
                    url += '?search=' + encodeURIComponent(value);
                }
                location = url;
            });

            $('#header-search').keydown(function(e){
                if(e.keyCode==13){
                    $('.search_li').click();
                }
            })
        });
    </script>