$(function(){
	var win = $(window).width();
	if(win<=750){
		$(".banner .ban1").attr("src","img/jpg/yd_banner1.jpg");
		$(".banner .ban2").attr("src","img/jpg/yd_banner2.jpg");
		$(".banner .ban3").attr("src","img/jpg/yd_banner3.jpg");
		
		$(".ul_in1 li").eq(0).find(".pic img").attr("src","img/jpg/yd_index1_1.jpg");
		$(".ul_in1 li").eq(1).find(".pic img").attr("src","img/jpg/yd_index1_2.jpg");
		$(".ul_in1 li").eq(2).find(".pic img").attr("src","img/jpg/yd_index1_3.jpg");
		$(".video_div .video").attr("poster","img/jpg/yd_video_bg.jpg")
		
		$(".ol_img2 li").eq(0).find(".pic img").attr("src","img/jpg/yd_index2_1.jpg");
		$(".ol_img2 li").eq(1).find(".pic img").attr("src","img/jpg/yd_index2_2.jpg");
		
		$(".ol_img3 li").eq(0).find(".pic img").attr("src","img/jpg/yd_index3_1.jpg");
		$(".ol_img3 li").eq(1).find(".pic img").attr("src","img/jpg/yd_index3_2.jpg");
		$(".ol_img3 li").eq(2).find(".pic img").attr("src","img/jpg/yd_index3_3.jpg");
		$(".ol_img3 li").eq(3).find(".pic img").attr("src","img/jpg/yd_index3_4.jpg");
		
		$(".ol_img4 li").eq(0).find(".pic img").attr("src","img/jpg/yd_index4_1.jpg");
		$(".ol_img4 li").eq(1).find(".pic img").attr("src","img/jpg/yd_index4_2.jpg");
		$(".ol_img4 li").eq(2).find(".pic img").attr("src","img/jpg/yd_index4_3.jpg");
		$(".ol_img4 li").eq(3).find(".pic img").attr("src","img/jpg/yd_index4_4.jpg");
		
		$(".ol_img5 li").eq(0).find(".pic img").attr("src","img/jpg/yd_index5_1.jpg");
		$(".ol_img5 li").eq(1).find(".pic img").attr("src","img/jpg/yd_index5_2.jpg");
		$(".ol_img5 li").eq(2).find(".pic img").attr("src","img/jpg/yd_index5_3.jpg");
		$(".ol_img5 li").eq(3).find(".pic img").attr("src","img/jpg/yd_index5_4.jpg");
		
		$(".top2 .top2_img").attr("src","img/jpg/yd_index3.jpg");
		$(".top3 .top3_img").attr("src","img/jpg/yd_index4.jpg");
		$(".top4 .top4_img").attr("src","img/jpg/yd_index5.jpg");
		
		$(".logo img").attr("src","img/png/yd_logo.png");
	}
	
	
	
})
