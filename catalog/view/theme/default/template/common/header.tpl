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
        <script type="text/javascript" src="catalog/view/theme/default/js/index.js" ></script>
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
    </head>

<body>
<!--头部-->
        <div class="big_nav">
            <div class="nav content clearfix">
                
                <!--货币切换-->
                <div class="mn_type">
                    <div class="top clearfix">
                        <p>USD</p>
                        <div class="pic_img">
                            <img src="catalog/view/theme/default/img/png/down.png" alt="" />
                        </div>
                    </div>
                    <div class="bot">
                        <span><em></em></span>
                        <ul class="ul_type">
                            <li><a href="###">EUR</a></li>
                            <li><a href="###">NAN</a></li>
                            <li><a href="###">ZAR</a></li>
                        </ul>
                    </div>
                </div>
                
                <!--logo-->
                <div class="logo">
                    <a href="###">
                        <img src="catalog/view/theme/default/img/png/logo.png"/>
                    </a>
                </div>  
                
                <!--whatApp-->
                <p class="whatapp"><img src="catalog/view/theme/default/img/png/phone.png"/>WhatApp:+8615800028742</p>
                
                <!--pc导航-->
                <ul class="nav_ul clearfix">
                    <li class="active"><a href="###">Home</a></li>
                    <li>
                        <a href="###">All Hair Collections</a>
                        <div class="text clearfix">
                            <ol class="clearfix">
                                <li><a href="#">Double Drawn Funmi Hair</a></li>
                                <li><a href="#">Virgin Brazilian Hair</a></li>
                                <li><a href="#">Virgin Peruvian Hair (Normal Full)</a></li>
                                <li><a href="#">Virgin Peruvian Hair (Very Full)</a></li>
                            </ol>
                        </div>
                    </li>
                    <li>
                        <a href="###">Closure & Frontal & Wig</a>
                        <div class="text clearfix">
                            <ol>
                                <li><a href="#">360 Frontal</a></li>
                                <li><a href="#">Customized Bundles Wig</a></li>
                                <li><a href="#">Lace Closure</a></li>
                                <li><a href="#">Lace Frontal</a></li>
                                <li><a href="#">Stock Lace Wig</a></li>
                            </ol>
                        </div>
                    </li>
                    <li><a href="###">Promotion</a></li>
                    <li><a href="###">Hair Club</a></li>
                    <li><a href="###">Company Profile</a></li>
                </ul>   
                
                <!--导航图标-->
                <div class="right">
                    <ol class="img_ol clearfix fl">
                        <li class="search_li"></li>
                        <li class="login_li"></li>
                        <li><a href="###"><span>0</span></a></li>
                        <li class="cart_li"><span>0</span></li>
                    </ol>
                </div>
                
                <!--搜索框-->
                <from class="search fl">
                    <!--<input class="btn_in" type="submit" value="">-->
                    <input class="text_in" type="text"placeholder="Search">
                    <img class="close" src="catalog/view/theme/default/img/png/close2.png"/>
                </from>
                
                <!--导航购物车-->
                <div class="nav_cart">
                    <h1>MY SHOPPING CART(<span>5</span>) <div class="close"><img src="catalog/view/theme/default/img/png/close2.png"/></div></h1>
                    
                    <div class="has">
                        <ul class="cart_ul">
                            <li class="clearfix">
                                <a href="###">
                                    <div class="pic_img">
                                        <img src="catalog/view/theme/default/img/jpg/index1_1.jpg"/>
                                    </div>
                                    <div class="text">
                                        <h2>Fuller Peruvian Virgin Hair </h2>
                                        <p>Body Wavy</p>
                                        <span>$15.39</span>
                                    </div>
                                </a>
                            </li>
                            <li class="clearfix">
                                <a href="###">
                                    <div class="pic_img">
                                        <img src=""/>
                                    </div>
                                    <div class="text">
                                        <h2>Fuller Peruvian Virgin Hair  </h2>
                                        <p>Body Wavy</p>
                                        <span>$15.39</span>
                                    </div>
                                </a>
                            </li>
                            <li class="clearfix">
                                <a href="###">
                                    <div class="pic_img">
                                        <img src=""/>
                                    </div>
                                    <div class="text">
                                        <h2>Fuller Peruvian Virgin Hair  </h2>
                                        <p>Body Wavy</p>
                                        <span>$15.39</span>
                                    </div>
                                </a>
                            </li>
                            <li class="clearfix">
                                <a href="###">
                                    <div class="pic_img">
                                        <img src=""/>
                                    </div>
                                    <div class="text">
                                        <h2>Fuller Peruvian Virgin Hair  </h2>
                                        <p>Body Wavy</p>
                                        <span>$15.39</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <hr />
                        
                        <div class="bot">
                            <p class="p_top">Subtotal <span>$99.08</span></p>
                            <p class="p_bot">Total <span>$99.08</span></p>
                            <a class="a_btn" href="###">GO TO SHOPPING CART&nbsp;></a>
                        </div>
                    </div>
                    
                    <div class="null">
                        <p>Your shopping cart is empty</p>
                    </div>
                </div>
                
                <!--导航开关-->
                <div class="nav_off"></div>
                
                <!--移动导航-->
                <div class="yd_nav">
                    <div class="top">
                        <img class="menu" src="catalog/view/theme/default/img/png/menu.png" alt="" />
                        <img class="close" src="catalog/view/theme/default/img/png/close2.png"/>
                    </div>
                    
                    <ul>
                        <li class="clearfix">
                            <a href="javascript:0;">All Hair Collections <img class="slide_img" src="catalog/view/theme/default/img/png/jiahao.png"/></a>
                            <ol class="yd_nav_ol clearfix">
                                <li class="clearfix"><a class="right_img" href="###">Double Drawn Funmi Hair </a></li>
                                <li class="clearfix"><a class="right_img" href="###">Virgin Brazilian Hair </a></li>
                                <li class="clearfix"><a class="right_img" href="###">Virgin Peruvian Hair (Normal Full) </a></li>
                                <li class="clearfix"><a class="right_img" href="###">Virgin Peruvian Hair (Very Full) </a></li>
                            </ol>
                        </li>
                        <li class="clearfix">
                            <a href="javascript:0;">Closure & Frontal & Wig <img class="slide_img" src="catalog/view/theme/default/img/png/jiahao.png"/></a>
                            <ol class="yd_nav_ol clearfix">
                                <li class="clearfix"><a class="right_img" href="###">360 Frontal </a></li>
                                <li class="clearfix"><a class="right_img" href="###">Customized Bundles Wig</a></li>
                                <li class="clearfix"><a class="right_img" href="###">Lace Closure </a></li>
                                <li class="clearfix"><a class="right_img" href="###">Lace Frontal </a></li>
                                <li class="clearfix"><a class="right_img" href="###">Stock Lace Wig </a></li>
                            </ol>
                        </li>
                        <li class="clearfix">
                            <a class="right_img" href="###">Promotion</a>
                        </li>
                        <li class="clearfix">
                            <a class="right_img" href="###">Hair Club</a>
                        </li>
                        <li class="clearfix">
                            <a class="right_img" href="###">Company Profile</a>
                        </li>
                    </ul>
                </div>
                
            </div>
        
        </div>
