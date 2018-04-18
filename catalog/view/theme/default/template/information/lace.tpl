<?php echo $header; ?>
<style type="text/css">
	.lace-main{
		width: 1200px;
		margin: 0 auto;
		padding: 10px 0;
		background: #f2f2f2;
	}
	
	.lace-cont-08>p{
		text-align: center;
		font-size: 36px;
		color: #000;
		margin-top: 60px;
		margin-bottom: 30px;
	}
	#video-box{
		width: 560px;
		margin: 0 auto 60px;
	}
	.lace-cont-09,.lace-cont-10,.lace-cont-11{
		text-align: center;
	}
	.lace-cont-10{
		margin: 60px 0 70px;
	}
	
	#pop-video-wrap{
		display: none;
		position: fixed;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		background: rgba(0,0,0,0.8);
	}
	#pop-video-box{
		position: fixed;
		width: 560px;
		height: 316px;
		left: 50%;
		top: 50%;
		margin-left: -280px;
		margin-top: -158px;
	}
	#lace-video-close{
		position: absolute;
		top: -13px;
		right: -13px;
	}
	.lace-inquiry-title{
		margin-top: 50px;
		margin-bottom: 40px;
		font-size: 24px;
		font-weight: bold;
		text-align: center;
	}
	.lace-inquiry-form{
		width: 680px;
		margin: 0 auto;
		color: #000;
	}
	.lace-inquiry-form>div>span{
		vertical-align: middle;
		width: 160px;
		text-align: right;
		font-size: 18px;
		display: inline-block;
		margin-right: 12px;
	}
	.text-danger{
		margin-left: 180px;
		color: #f00;
	}
	.lace-inquiry-form>div>input,.lace-inquiry-form>div>select,.lace-inquiry-form>div>textarea{
		color: #666;
		text-indent: 12px;
		vertical-align: middle;
		height: 39px;
		width: 500px;
		font-size: 18px;
		line-height: 37px;
		border: 1px solid #e6e6e6;
		background: #f9f9f9;
	}
	.lace-inquiry-form-row{
		margin-bottom: 20px;
	}
	.lace-inquiry-btn{
		font-size: 18px;
		line-height: 50px;
		height: 50px;
		width: 174px;
		color: #fff;
		background: #f15c09;
		border: none;
		outline: none;
	}
	.lace-inquiry-btn:hover{
		background: #f60;
	}
	.lace-inquiry-form>div>.ucontent{
		height: 200px;
	}
</style>
<article class="lace-main">
   <section class="lace-banner">
		<a href="/360-lace-frontal/"><img src="/catalog/view/theme/default/images/tzx/lace/pin_01.jpg" alt=""/></a>
	</section>
	<div class="lace-cont-01">
		<img src="/catalog/view/theme/default/images/tzx/lace/pin_02.jpg" alt=""/>
	</div>
	<div class="lace-cont-02">
		<img src="/catalog/view/theme/default/images/tzx/lace/pin_03.jpg" alt=""/>
	</div>
	<div class="lace-cont-03">
		<img src="/catalog/view/theme/default/images/tzx/lace/pin_04.jpg" alt="" usemap="#Maplow50"/>
		<map name="Maplow50" id="Maplow50">
		    <area shape="rect" coords="521,171,681,261" href="javascript:;" class="lace-video-area"/>
		</map>
	</div>
	<div class="lace-cont-04">
		<img src="/catalog/view/theme/default/images/tzx/lace/pin_05.jpg" alt="" usemap="#Maplow51"/>
		<map name="Maplow51" id="Maplow51">
		    <area shape="rect" coords="654,276,812,366" href="javascript:;" class="lace-video-area"/>
		</map>
	</div>
	<div class="lace-cont-05">
		<img src="/catalog/view/theme/default/images/tzx/lace/pin_06.jpg" alt=""/>
		
	</div>
	<div class="lace-cont-06">
		<img src="/catalog/view/theme/default/images/tzx/lace/pin_07.jpg" alt="" usemap="#Maplow52"/>
		<map name="Maplow52" id="Maplow52">
		    <area shape="rect" coords="357,42,518,130" href="javascript:;" class="lace-video-area"/>
		</map>
	</div>
	<div class="lace-cont-07">
		<img src="/catalog/view/theme/default/images/tzx/lace/pin_08.jpg" alt="" usemap="#Maplow53"/>
		<map name="Maplow53" id="Maplow53">
		    <area shape="rect" coords="357,190,517,280" href="javascript:;" class="lace-video-area"/>
		</map>
	</div>
	<div class="lace-cont-08">
		<p>Find More Information On Our Video</p>
		<div id="video-box">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/HWYr39XgL5U" frameborder="0" allowfullscreen></iframe>
        </div>
	</div>
	<div class="lace-cont-09">
		<img src="/catalog/view/theme/default/images/tzx/lace/pin_11.jpg" alt=""/>
	</div>
	
	<div class="lace-cont-10">
		<img src="/catalog/view/theme/default/images/tzx/lace/pin_15.jpg" alt=""/>
	</div>
	<div class="lace-cont-11">
		<img src="/catalog/view/theme/default/images/tzx/lace/pin_19.jpg" alt=""/>
	</div>
	<section class="lace-inquiry">
		<h4 class="lace-inquiry-title">Send your inquiry to Hot Beauty Hair(We will reply you in 24 hours):</h4>
		<div class="lace-inquiry-form">
			<div class="lace-inquiry-form-row">
				<span class="req-before">Your E-mail:</span>
				<input type="text" id="uemail" value="" class="lace-email"/>
				<div class="text-danger text-danger-email"></div>
			</div>
			<div class="lace-inquiry-form-row">
				<span class="req-before">Your Name:</span>
				<input type="text" id="uname" value="" class="lace-name"/>
				<div class="text-danger text-danger-name"></div>
			</div>
			<div class="lace-inquiry-form-row">
				<span class="req-before-1">Tel Number:</span>
				<input type="text" id="utel" value="" class="lace-tel"/>
			</div>
			<div class="lace-inquiry-form-row">
				<span class="req-before-1">Country:</span>
				<select name="country_id" id="ucountry" class="lace-country">
				     <option value="">Please Choose Your Country</option>
				     <?php foreach ($countries as $country) { ?>
                                        <?php if ($country['country_id'] == $country_id) { ?>
                                        <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                        <?php } ?>
                                     <?php } ?>
				   </select>
			</div>
			<div class="lace-inquiry-form-row">
				<span class="req-before-1">Facetime &amp; Message ID:</span>
				<input type="text" id="uface" value="" class="lace-face"/>
			</div>
			<div class="lace-inquiry-form-row">
				<span class="req-before-1">What App:</span>
				<input type="text" id="uwhat" value="" class="lace-what"/>
			</div>
			<div class="lace-inquiry-form-row">
				<span class="req-before">Content:</span>
				<textarea id="ucontent" class="ucontent"></textarea>
				<div class="text-danger text-danger-cont"></div>
			</div>
			<div>
				<span class="req-before-2"></span>
				<button class="lace-inquiry-btn">SUBMIT</button>
			</div>
		</div>
		
	</section>
</article>
<div id="pop-video-wrap">
	<div id="pop-video-box">
		<img src="/catalog/view/theme/default/images/tzx/close.png" id="lace-video-close"/>
		<iframe id="lace-iframe" width="560" height="315" src="" frameborder="0" allowfullscreen></iframe>
	</div>
</div>
<?php echo $footer; ?>
<script>
	jQuery(function($){
		var $videoBox = $('#pop-video-wrap'),
			$videoClose = $('#lace-video-close'),
			$iframe = $('#lace-iframe'),
			$videoArea = $('.lace-video-area'),
			video = ['https://www.youtube.com/embed/H-8QXIhDjJs',
			'https://www.youtube.com/embed/kMbX_FcoBIg',
			'https://www.youtube.com/embed/Sf4_fpe1JdI',
			'https://www.youtube.com/embed/UKEpXPT9fTU'
		];
		$videoClose.click(function(e){
			$videoBox.hide();
			e.stopPropagation();
		});
		$videoArea.each(function(idx,ele){
			$(this).click(function(e){
				$videoBox.show();
				$iframe.attr('src',video[idx]);
				e.stopPropagation();
			})
		});
		//-------------询盘提交
		var $infoBtn = $('.lace-inquiry-btn'),
			/*$productId = $('#product_id'),*/
			$uName = $('#uname'),
			$uEmail = $('#uemail'),
			$uTel = $('#utel'),
			$uCountry = $('#ucountry'),
			$uPhone = $('#uface'),
            $uWhatsapp = $('#uwhat'),
			$uContent = $('#ucontent'),
			$uNameTip = $('.text-danger-name'),
			$uEmailTip = $('.text-danger-email'),
			$uContentTip = $('.text-danger-cont');
        var clickTf = true;
        var reg = /^([a-z0-9,!\#\$%&'\*\+\/=\?\^_`\{\|\}~-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z0-9,!\#\$%&'\*\+\/=\?\^_`\{\|\}~-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*@([a-z0-9-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z0-9-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*\.(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]){2,})$/;
		$infoBtn.on('click', function(e) {
			$uNameTip.text('');
			$uEmailTip.text('');
			$uContentTip.text('');
            if(clickTf){
                var uName = $uName.val().replace(/^\s+|\s+$/g,""),
				uEmail = $uEmail.val().replace(/^\s+|\s+$/g,""),
				uTel = $uTel.val(),
				uCountry = $uCountry.val(),
				uPhone = $uPhone.val(),
                uWhatsapp = $uWhatsapp.val(),
				uContent = $uContent.val().replace(/^\s+|\s+$/g,"");
				
			    /*var pro_name = $('.product-detail-inquiry-title span').text();
				var pro_model = $('#product_model').val();*/
				//前端验证邮箱，用户名，文本
				if(uName.length<3 || uName.length>32){
					$uNameTip.text('Name must be between 3 and 32 characters!');
				}
				if(uContent.length<10 || uContent.length>3000){
					$uContentTip.text('Comment must be between 10 and 3000 characters!');
				}
				if(!reg.test(uEmail)){
					$uEmailTip.text('E-Mail Address does not appear to be valid!');
				}
				if(uName.length>2 && uName.length<33 && uContent.length > 9 && uContent.length<3001 && reg.test(uEmail)){
					clickTf = false;
					$.ajax({
						type: "post",
						url: "index.php?route=product/product/addinquiry",
						async: true,
						dataType: 'json',
						data: {
							product_id: '',
							name: uName,
							email: uEmail,
							fixed_line: uTel,
							country_id: uCountry,
							send_page:'360-lace-closure',
							phone: uPhone,
		                    whatsapp:uWhatsapp,
							content: uContent,
		                    pro_name:'',
		                    pro_model:'',
						},
						success: function(res) {
							console.log(res);
							if(res.code == 0) {
		                        clickTf = true;
								$uNameTip.text(res.data.error_name);
								$uEmailTip.text(res.data.error_email);
								$uContentTip.text(res.data.error_content);
		                        alert(res.message);            
							}else{
								//alert("Submit successfully");
								location.href = '/information-company-success/';
							}
						}
					});
				}
			
            }
            e.stopPropagation();
			
		});
		
		
	});
</script>
