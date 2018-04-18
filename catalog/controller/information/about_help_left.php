<?php

/**
 * About Us和Expert Help页面左侧栏
 * @author  dyl 783973660@qq.com 2016.10.6
 */
class ControllerInformationAbouthelpLeft extends Controller {

	public function index() {

        $this->load->model('catalog/information');
        $this->load->model('catalog/url_alias');

        $getroute = $_SERVER["QUERY_STRING"];   //获取当前url的参数
        
        foreach ($this->model_catalog_information->getInformations() as $result) {
        	if ($result['bottom']) {
        		if($result['parent_id'] == 0){
        			$data['parents'][] = array(
        					'title' => $result['title'],
        					'information_id' => $result['information_id'],
        					'seo_url' => $result['seo_url']
        			);
        		}
        	}
        }
        
        foreach ($this->model_catalog_information->getInformations() as $information) {
        	if($result['bottom']){
        		foreach($data['parents'] as $parent){
        			if($parent['information_id'] == $information['parent_id']){
        				$data['informations'][$parent['title']][] = array(
        						'title' => $information['title'],
        						'seo_url' => $information['seo_url']
        				);
        			}
        		}
        	}
        }

		return $this->load->view('information/about_help_left', $data);
	}

}