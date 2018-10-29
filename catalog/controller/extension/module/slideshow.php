<?php
class ControllerExtensionModuleSlideshow extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);
		// print_r($results);
	

		foreach ($results as $result) {
			
				$image=$this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
		
				$mimage=$this->model_tool_image->resize($result['mimage'], $setting['mwidth'], $setting['mheight']);
		
			
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' =>$image,
					'mimage' =>$mimage
				);
			
		}

		$data['module'] = $module++;
			// print_r($data);exit();

		return $this->load->view('extension/module/slideshow', $data);
	}
}
