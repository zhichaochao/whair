<?php echo $header; ?>
		<!--内容-->
		
			<div class="content in_content hairclub clearfix">
				<h1>HAIR TUTORIAL</h1>
				<p>“Best and easiest hair tutorials start from here!”</p>
				
				<ul class="video_ul clearfix">
					<?php foreach ($profile_video['videos'] as $key => $child) {?>
					<li>
						<video src="<?=$child['video'];?>" class="video_li" poster="<?=$child['image'];?>"></video>
						<img class="bf" src="catalog/view/theme/default/img/png/bf.png"/>
						<div class="bg_div">
							<p><?=$child['gallery_title'];?> </p>
						</div>
						
					</li>
					
				<?php } ?>
				</ul>
				
				<!-- <div class="fy_div clearfix">
					<div class="left"><?php echo $pagination; ?></div>
			          <div class="right">
			            <p><?php echo $results; ?></p>
			          </div>
        		</div> -->
				</div>
			</div>
		<?php echo $footer; ?>

<script>
	$(function(){
		$(".video_ul li img.bf").click(function(){
			$(this).siblings(".bg_div").css("display","none");
			
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
