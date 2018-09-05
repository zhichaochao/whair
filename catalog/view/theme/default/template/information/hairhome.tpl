<?php echo $header; ?>
		<!--内容-->
		
			<div class="content in_content hairclub clearfix">
			<input type="hidden" name="allpage" value='<?=$allpage;?>' id='allpage'/>
			<input type="hidden" name="page" value='1' id='page'/>
				<h1>HAIR TUTORIAL</h1>
				<p>“Best and easiest hair tutorials start from here!”</p>
				
				<ul class="video_ul clearfix prolist">
					<?php foreach ($profile_video['videos'] as $key => $child) {?>
					<li>
						<video src="<?=$child['video'];?>" class="video_li" poster="<?=$child['image'];?>"></video>
						<img class="bf" src="/catalog/view/theme/default/img/png/bf.png"/>
						<div class="text_vd clearfix">
						<div class="bg_div">
							<p><?=$child['title'];?> </p>
						</div>
						</div>
					</li>
					
				<?php } ?>
				</ul>
				
				<div class="fy_div clearfix">
		           <?php echo $pagination; ?>  
		        </div>
				</div>
			</div>
		<?php echo $footer; ?>
<script>
    function loadmore(obj){
      var allpage=$('#allpage').val();
      var page=$('#page').val();
      var win =$(window).width();
        if(win<920){
             var scrollTop = $(obj).scrollTop();
            var scrollHeight = $(document).height();
            var windowHeight = $(obj).height();
            if (allpage>page) {
             if (scrollHeight-scrollTop - windowHeight<=300 ) {
              page++;
              $('#page').val(page);
               $.ajax({
                          url: 'index.php?route=information/profile/loadpage&page='+page,
                          dataType: 'json',
                          success: function(data) {
                            var result="";
                            // console.log( data.videos );
                            for (var i =0; i < data.profile_video.videos.length ; i++) {
                               result+='<li>'
                               	+'<video src="'+data.profile_video.videos[i].video+'" class="video_li" poster="'+data.profile_video.videos[i].image+'">'
                               	+'</video>'
								+'<img class="bf" src="/catalog/view/theme/default/img/png/bf.png"/>'
								+'<div class="text_vd clearfix">'
								+'<div class="bg_div">'
								+'<p>'+data.profile_video.videos[i].title
								+'</p>'
								+'</div>'
								+'</div>'
                                  +'</li>';
                                   }
                           $('.prolist').append(result);
                          }
                       })
                      } 
                    }
                }
              }
    //页面滚动执行事件
    $(window).scroll(function (){
        loadmore($(this));
    });
</script>
<script>
	$(function(){
		$(".video_ul li img.bf").click(function(){
			$(this).siblings(".text_vd").css("display","none");
			
			$(".video_li").each(function(){
				this.pause();
			})
			
			$(this).siblings("video").attr("controls","controls");
			this.previousElementSibling.play();
			
			$(this).css("display","none");
		})
		
		
//		$(".video_li").each(function(){
//			this.addEventListener('play',function(){ 
//				var this_index = $(this).parents("li").index()
//				console.log(this_index)
//				$(".video_li").each(function(){
//					this.pause();
//				})
//				document.getElementsByClassName("video_li")[this_index].play()
//			});
//		})
//		for(var i=0; i<$(".video_ul li").length;i++){
//			document.getElementsByClassName("video_li")[i].addEventListener('play',function(){  
//				$(".video_li").each(function(){
//					this.pause();
//				})
//					document.getElementsByClassName("video_li")[i].play();
//			});  
//		}
		
		
	})
</script>
