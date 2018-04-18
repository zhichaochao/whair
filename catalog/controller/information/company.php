<?php

/**
 * Company Profile信息页控制器
 * @author  dyl 783973660@qq.com 2016.10.6
 */
class ControllerInformationCompany extends Controller {
	private $error = array();


	public function index()
	{
		if (isset($this->request->get['profile_id'])) {
			$profile_id = (int)$this->request->get['profile_id'];
		} else {
			$profile_id = 25;
		}

		$this->document->setTitle('Company Profile');

		$data['heading_title'] = $this->language->get('Company Profile');

		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/com_ser_common.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/company.css');

        //成功提示
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

        //失败提示
		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		//引入contact_us的form表单
		$data['contact_us'] = $this->load->controller('information/contact_us');

        //Contact Us图标跳转定位url
		$data['action'] = $this->url->link('information/company/overview', '', true);

		$data['information_left'] = $this->load->controller('information/left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
	

		$this->load->language('information/information');

		$this->load->model('catalog/information');
		$profile_info = $this->model_catalog_information->getProfile($profile_id);
			if ($profile_info) {
			$this->document->setTitle($profile_info['meta_title']);
			$this->document->setDescription($profile_info['meta_description']);
			$this->document->setKeywords($profile_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $profile_info['title'],
				'href' => $this->url->link('information/information', 'profile_id=' .  $profile_id)
			);

			$data['profile_id'] = $profile_id;
			$data['heading_title'] = $profile_info['title'];

			$data['button_continue'] = $this->language->get('button_continue');
				$data['meta_description'] =	$profile_info['meta_description'];
			$data['description'] = html_entity_decode($profile_info['description'], ENT_QUOTES, 'UTF-8');
			if($profile_id==25){
				$this->response->setOutput($this->load->view('information/overview', $data));
			}elseif ($profile_id==26) {
				$this->response->setOutput($this->load->view('information/trustpass', $data));
			}elseif ($profile_id==27) {
				$this->response->setOutput($this->load->view('information/faq', $data));
			}elseif ($profile_id==28) {
				$this->response->setOutput($this->load->view('information/capacity', $data));
			}else{
				$this->response->setOutput($this->load->view('information/overview', $data));
			}
		}else{
				$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');
			
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$this->response->setOutput($this->load->view('error/not_found', $data));
		}

	}

    /**
     * Company Profile页面
     */
	public function overview() {

		$this->document->setTitle('Company Profile');

		$data['heading_title'] = $this->language->get('Company Profile');

		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/com_ser_common.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/company.css');

        //成功提示
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

        //失败提示
		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		//引入contact_us的form表单
		$data['contact_us'] = $this->load->controller('information/contact_us');

        //Contact Us图标跳转定位url
		$data['action'] = $this->url->link('information/company/overview', '', true);

		$data['information_left'] = $this->load->controller('information/left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$profile_id=25;

		$this->load->language('information/information');

		$this->load->model('catalog/information');
		$profile_info = $this->model_catalog_information->getProfile($profile_id);
			if ($profile_info) {
			$this->document->setTitle($profile_info['meta_title']);
			$this->document->setDescription($profile_info['meta_description']);
			$this->document->setKeywords($profile_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $profile_info['title'],
				'href' => $this->url->link('information/information', 'profile_id=' .  $profile_id)
			);

			$data['heading_title'] = $profile_info['title'];

			$data['button_continue'] = $this->language->get('button_continue');
				$data['meta_description'] =	$profile_info['meta_description'];
			$data['description'] = html_entity_decode($profile_info['description'], ENT_QUOTES, 'UTF-8');
				$this->response->setOutput($this->load->view('information/overview', $data));
		}else{
				$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');
			
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$this->response->setOutput($this->load->view('error/not_found', $data));
		}

	}

	/**
     * Company Capability页面
     */
	public function capacity() {

		$this->document->setTitle('Company Capability');

		$data['heading_title'] = $this->language->get('Company Capability');

		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/com_ser_common.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/company.css');

		//成功提示
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

        //失败提示
		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		//引入contact_us的form表单
		$data['contact_us'] = $this->load->controller('information/contact_us');

		$data['information_left'] = $this->load->controller('information/left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
			$profile_id=28;

		$this->load->language('information/information');

		$this->load->model('catalog/information');
		$profile_info = $this->model_catalog_information->getProfile($profile_id);
			if ($profile_info) {
			$this->document->setTitle($profile_info['meta_title']);
			$this->document->setDescription($profile_info['meta_description']);
			$this->document->setKeywords($profile_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $profile_info['title'],
				'href' => $this->url->link('information/information', 'profile_id=' .  $profile_id)
			);

			$data['heading_title'] = $profile_info['title'];

			$data['button_continue'] = $this->language->get('button_continue');
				$data['meta_description'] =	$profile_info['meta_description'];
			$data['description'] = html_entity_decode($profile_info['description'], ENT_QUOTES, 'UTF-8');
		$this->response->setOutput($this->load->view('information/capacity', $data));
		}else{
				$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');
			
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$this->response->setOutput($this->load->view('error/not_found', $data));
		}

		
	}

	/**
     * TrustPass Profile页面
     */
	public function trustpass() {

		$this->document->setTitle('TrustPass Profile');

		$data['heading_title'] = $this->language->get('TrustPass Profile');

		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/com_ser_common.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/company.css');

		$data['information_left'] = $this->load->controller('information/left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

	$profile_id=26;

		$this->load->language('information/information');

		$this->load->model('catalog/information');
		$profile_info = $this->model_catalog_information->getProfile($profile_id);
			if ($profile_info) {
			$this->document->setTitle($profile_info['meta_title']);
			$this->document->setDescription($profile_info['meta_description']);
			$this->document->setKeywords($profile_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $profile_info['title'],
				'href' => $this->url->link('information/information', 'profile_id=' .  $profile_id)
			);

			$data['heading_title'] = $profile_info['title'];

			$data['button_continue'] = $this->language->get('button_continue');
				$data['meta_description'] =	$profile_info['meta_description'];
			$data['description'] = html_entity_decode($profile_info['description'], ENT_QUOTES, 'UTF-8');
				$this->response->setOutput($this->load->view('information/trustpass', $data));
		}else{
				$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');
			
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	
	}

	/**
     * FAQ页面
     */
	public function faq() {

		$this->document->setTitle('FAQ');

		$data['heading_title'] = $this->language->get('FAQ');
		
		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/com_ser_common.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/company.css');

		$data['information_left'] = $this->load->controller('information/left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
			
		
		$profile_id=27;

		$this->load->language('information/information');

		$this->load->model('catalog/information');
		$profile_info = $this->model_catalog_information->getProfile($profile_id);
			if ($profile_info) {
			$this->document->setTitle($profile_info['meta_title']);
			$this->document->setDescription($profile_info['meta_description']);
			$this->document->setKeywords($profile_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $profile_info['title'],
				'href' => $this->url->link('information/information', 'profile_id=' .  $profile_id)
			);

			$data['heading_title'] = $profile_info['title'];

			$data['button_continue'] = $this->language->get('button_continue');
				$data['meta_description'] =	$profile_info['meta_description'];
			$data['description'] = html_entity_decode($profile_info['description'], ENT_QUOTES, 'UTF-8');
					$this->response->setOutput($this->load->view('information/faq', $data));
		}else{
				$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');
			
			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$this->response->setOutput($this->load->view('error/not_found', $data));
		}

		
	}
        
        
        /**
     * inquiry success页面
     */
	public function success() {

            $this->document->setTitle("We have received your inquiry, and we'll get back to you within 24hours.");

            $data['heading_title'] = $this->language->get("We have received your inquiry, and we'll get back to you within 24hours.");

            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');
            $data['telephone'] = $this->config->get('config_telephone');
            $data['email'] = $this->config->get('config_email');
            
            unset($this->session->data['success']);
            $this->response->setOutput($this->load->view('information/inquiry_success.tpl', $data));
	}

}