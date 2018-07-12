<?php

/**
 * About Us和Expert Help页面左侧栏
 * @author  dyl 783973660@qq.com 2016.10.6
 */
class ControllerInformationAbouthelpLeft extends Controller {

	public function index() {

        $this->load->model('catalog/information');
        $informations=$this->model_catalog_information->getInformations() ;
        // print_r($informations);exit;
       
        
          foreach ($informations as $information) {
        
                $data['informations'][] = array(
                	'title' => $information['title'],
                	'url' => $this->url->link('information/information','information_id=' .  $information['information_id']),
                );
                	
        	
        	}
                      return $this->load->view('information/about_help_left', $data);
        }

}