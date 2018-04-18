<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>" />

    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>

    <?php if ($keywords) { ?>
    <meta name="keywords" content= "<?php echo $keywords; ?>" />
    <?php } ?>

    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>

    <script src="catalog/view/theme/default/js/jq.js?v=<?php echo time(); ?>" type="text/javascript"></script>
    <link href="catalog/view/theme/default/stylesheet/style.css?v=<?php echo time(); ?>" rel="stylesheet">

    <link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
    <link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">

    <?php foreach ($styles as $style) { ?>
    <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
    <?php } ?>

    <script src="catalog/view/javascript/common.js?v=<?php echo time(); ?>" type="text/javascript"></script>

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
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-5NZ6HB');</script>
    <!-- End Google Tag Manager -->

    <script>
        $(document).ready(function() {
            /* Search */
            $('.jwx_header .a2').click(function() {
                url = '<?php echo $search_url; ?>';
                var value = $("input[name='new_search']").val();

                if (value) {
                    url += '?search=' + encodeURIComponent(value);
                }
                location = url;
            });

            $('#header-search').keydown(function(e){
                if(e.keyCode==13){
                    $('.jwx_header .a2').click();
                }
            })
        });
    </script>

</head>
<body class="<?php echo $class; ?>">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5NZ6HB"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!--新头部-->
<div class="jwx_header">
    <div class="cont">

        <?php if ($logo) { ?>
        <a href="<?php echo $root_home; ?>"><img src="catalog/view/theme/default/image/j_logo.jpg" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="left" /></a>
        <?php } else { ?>
        <a href="<?php echo $home; ?>"><?php echo $name; ?></a>
        <?php } ?>

      
 <ul id="menu" class="nav navbar-nav left">
      <li <?php if($is_home=='/index.php?route=common/home'||$is_home=='/'||$is_home=='/index.php'||$is_home=='/common-home'){ ?>class="on"<?php } ?>><a href="<?php echo $home; ?>">Home</a></li>
    <?php if($navs){ foreach ($navs as $k => $nav) { ?>

      <li class="dropdown <?php if($nav['this_page']){ ?>on<?php } ?>">
        <a  href="<?php echo $nav['url']; ?>"  <?=$nav['is_target']==1?'target="_blank"':''; ?>  class="dropdown-toggle"><?=$nav['name'];?></a>
         <?php if($nav['child']){?>
        <div class="dropdown-menu dropdown-menu0">
           <div class="dropdown-inner">
             <ul class="list-unstyled">
              <?php foreach ($nav['child'] as $key => $child) { ?>
               <li><a  <?=$child['is_target']==1?'target="_blank"':''; ?> href="<?php echo $child['url']; ?>"><?=$child['name']?></a></li>
              <?php } ?>
             </ul>
           </div>
        </div>
         <?php  }?>
      </li> 
    <?php } }?>

</ul>

        <div class="d1 right">
      <span class="search_pop">
        <input id="header-search" value="" type="" name="new_search" placeholder="Search">
      </span>
            <?php if($logged){ ?>
            <!--<a href="<?php echo $account; ?>" class="a1"></a>-->
            <div class="iaccount-header">
                <a href="<?php echo $account; ?>"><?php echo @$user; ?></a>
                <div class="iaccount-header-hover">
                    <a href="<?php echo @$link_account; ?>" class="btn btn-primary btn-iaccount">My Account</a>
                    <a href="<?php echo @$link_logout; ?>" class="btn btn-cancel btn-logout">Logout</a>
                </div>
            </div>
            <?php }else{ ?>
            <a href="<?php echo $login; ?>" class="a1"></a>
            <?php } ?>
            <a class="a2"></a>
            <a href="<?php echo $shopping_cart; ?>" class="a3"><span id="cart-num"><?php echo $text_cart_items; ?></span></a>
        </div>

    </div>
</div>
