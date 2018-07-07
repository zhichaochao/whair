<?php echo $header; ?>
		
			<div class="content in_content hairclub clearfix">
				<img class="changeimage bnr_img" data-image='catalog/view/theme/default/img/jpg/hairclub1.jpg' data-mimage='catalog/view/theme/default/img/jpg/yd_hairclub1.jpg'  />
				<h1><?=$profile_care['title'];?></h1>
				<p><?=$profile_care['meta_description'];?></p>
				<ul class="hair_ul clearfix">
					<?php foreach ($profile_care['childs'] as $key => $child) {?>
					<li>
						<div class="pic_img">
							<a href="<?=$child['href']?>">
								<img class="changeimage" data-image="<?=$child['image']?>" data-mimage="<?=$child['images']?>"  />
								<div class="div_p">
									<p><?=$child['title'];?></p>
								</div>
							</a>
						</div>
						<div class="text">
							<p>Author : <span><?=$child['author'];?></span> / <?=$child['update_time'];?></p>
							<span class="yj"><?=$child['view'];?></span>
						</div>
						<a class="more_a" href="<?=$child['href'];?>">VIEW MORE&nbsp;&nbsp;></a>
					</li>
				<?php } ?>	
				</ul>		
				<h1><?=$profile_know['title'];?></h1>
				<p><?=$profile_know['meta_description'];?></p>
				
				<ul class="hair_ul clearfix">
					<?php foreach ($profile_know['childs'] as $key => $child) {?>
					<li>
						<div class="pic_img">
							<a href="<?=$child['href']?>">
								<img class="changeimage" data-image="<?=$child['image']?>" data-mimage="<?=$child['images']?>" />
								<div class="div_p">
									<p><?=$child['title'];?></p>
								</div>
							</a>
						</div>
						<div class="text">
							<p>Author : <span><?=$child['author'];?></span> / <?=$child['update_time'];?></p>
							<span class="yj"><?=$child['view'];?></span>
						</div>
						<a class="more_a" href="<?=$child['href'];?>">VIEW MORE&nbsp;&nbsp;></a>
					</li>
					<?php } ?>
					
					
				</ul>
				
				<h1>HAIR TUTORIAL</h1>
				<p>“Best and easiest hair tutorials start from here!”</p>
				
				<ul class="video_ul clearfix">
					<li>
						<video src="img/myvideo.mp4" poster="img/jpg/bf_bg.png"></video>
						<img class="bf" src="img/png/bf.png"/>
					</li>
					<li>
						<video src="img/myvideo.mp4" poster="img/jpg/bf_bg2.png"></video>
						<img class="bf" src="img/png/bf.png"/>
					</li>
					<li>
						<video src="img/myvideo.mp4" poster="img/jpg/bf_bg.png"></video>
						<img class="bf" src="img/png/bf.png"/>
					</li>
					<li>
						<video src="img/myvideo.mp4" poster="img/jpg/bf_bg2.png"></video>
						<img class="bf" src="img/png/bf.png"/>
					</li>
					<li>
						<video src="img/myvideo.mp4" poster="img/jpg/bf_bg.png"></video>
						<img class="bf" src="img/png/bf.png"/>
					</li>
					<li>
						<video src="img/myvideo.mp4" poster="img/jpg/bf_bg2.png"></video>
						<img class="bf" src="img/png/bf.png"/>
					</li>
				</ul>
				
				<a class="view_a" href="###">VIEW MORE&nbsp;&nbsp;&nbsp;></a>
				
			</div>
		</div>
		
		
<?php echo $footer; ?>
		
<script>
	$(function(){
		$(".video_ul li img.bf").click(function(){
			$(this).siblings("video").attr("controls","controls");
			this.previousElementSibling.play();
			$(this).css("display","none");
		})
	})
</script>
