<?php
class ControllerExtensionModuleSlideshow extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);
	

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				//dyl add
				$BannerArr = getimagesize(DIR_IMAGE . $result['image']);    //获取图片的尺寸
				if (!isset($setting['width'])) {$setting['width']=$BannerArr[0]; }
				if (!isset($setting['height'])) {$setting['height']=$BannerArr[1]; }
				$image=$this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
			if (is_file(DIR_IMAGE . $result['mimage'])) {
				$BannerArrm = getimagesize(DIR_IMAGE . $result['mimage']);    //获取图片的尺寸
				if (!isset($setting['mwidth'])) {$setting['mwidth']=$BannerArrm[0]; }
				if (!isset($setting['mheight'])) {$setting['mheight']=$BannerArrm[1]; }
				$mimage=$this->model_tool_image->resize($result['mimage'], $setting['mwidth'], $setting['mheight']);
			}else{
				$mimage=$image;
			}
			
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' =>$image,
					'mimage' =>$mimage
				);
			}
		}

		$data['module'] = $module++;
			// print_r($data);exit();

		return $this->load->view('extension/module/slideshow', $data);
	}
}
