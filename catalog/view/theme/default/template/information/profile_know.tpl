<?php echo $header; ?>
<!--内容-->
    <div class="haircare">
      <div class="content in_content clearfix">
        <div class="hair_text clearfix">
          <img class="changeimage bnr_img" data-image='<?php echo $images ?>' data-mimage='<?php echo $images ?>'  />
          <div class="text2 clearfix">
            <div class="left fl clearfix">
              <p>Author : <span><?php echo $author ?></span> /<?php echo $update_time ?></p>
              <span class="ll_span"><?php echo $view ?></span>
            </div>
            <div class="right fr clearfix">
              <ul>
               <li><a id="share_button_facebook"><img src="/catalog/view/theme/default/img/png/hc_1.png"/></a></li>
                <li><a id="share_button_twitter"><img src="/catalog/view/theme/default/img/png/hc_2.png"/></a></li>
                <li><a id="share_button_google"><img src="/catalog/view/theme/default/img/png/hc_3.png"/></a></li>
                <li><a id="share_button_pinterest"><img src="/catalog/view/theme/default/img/png/hc_4.png"/></a></li>
                <li><a id="share_button_linked"><img src="/catalog/view/theme/default/img/png/hc_5.png"/></a></li>
              </ul>
            </div>
          </div>
          <?=$description;?>
        </div>      
      </div>
    </div>
<?php echo $footer; ?>
<script type="text/javascript">
function popupwindow(url, title, w, h) {
            wLeft = window.screenLeft ? window.screenLeft : window.screenX;
            wTop = window.screenTop ? window.screenTop : window.screenY;
 
            var left = wLeft + (window.innerWidth / 2) - (w / 2);
            var top = wTop + (window.innerHeight / 2) - (h / 2);
            return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
        }
 $(function(){
          $('#share_button_facebook').click(function(){
                var shareUrl = "http://www.facebook.com/sharer/sharer.php?u="+window.location.href;
                popupwindow(shareUrl, 'Facebook', 600, 400);
            })
             $('#share_button_twitter').click(function(){
                var shareUrl = "http://twitter.com/share?url="+window.location.href;
                popupwindow(shareUrl, 'Twitter', 600, 400);
            })
            $('#share_button_linked').click(function(){
                var shareUrl = "http://www.linkedin.com/shareArticle?url="+window.location.href;
                popupwindow(shareUrl, 'LinkedIN', 600, 400);
            })
             $('#share_button_google').click( function(){
                var shareUrl = "https://plus.google.com/share?url="+window.location.href;
                popupwindow(shareUrl, 'Google', 600, 400);
            })
            $('#share_button_pinterest').click( function(){
                var shareUrl = "https://www.pinterest.com/pin/create/button/?url="+window.location.href;
                popupwindow(shareUrl, 'Pinterest', 600, 400);
            })
       })
 </script>