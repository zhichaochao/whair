<?php

/**
 * Company Profile页面左侧栏
 * @author  dyl 783973660@qq.com 2016.10.6
 */
class ControllerInformationLeft extends Controller {

	public function index() {

            $this->load->model('catalog/information');
            $profiles = $this->model_catalog_information->getProfiles();
            print_r($profiles);exit();
            $r=array();
            foreach ($profiles as $key => $value) {
                $r[]=array(
                  
                      'name' => $value['title'],
                      'profile_id'=>$value['profile_id'],
                    'url' => $this->url->link('information/company/index','profile_id=' .  $value['profile_id']),
                );
            }
         


		return $this->load->view('information/left', $route);
	}

}