<?php

/**
 * Merchant Service信息页控制器
 * @author  dyl 783973660@qq.com 2016.10.6
 */
class ControllerInformationService extends Controller {
	private $error = array();

    /**
     * wholesales页面
     */
	public function wholesales() {

		$this->document->setTitle('Wholesales');

		$data['heading_title'] = $this->language->get('Wholesales');

		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/com_ser_common.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/service.css');

		//$data['information_left'] = $this->load->controller('information/left');

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

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/wholesales', $data));
	}

	/**
     * sell from salon页面
     */
	public function salon() {

		$this->document->setTitle('Sell from salon');

		$data['heading_title'] = $this->language->get('Sell from salon');

		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/com_ser_common.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/service.css');

		//$data['information_left'] = $this->load->controller('information/left');

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

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/service_salon', $data));
	}

	/**
     * sell from store页面
     */
	public function store() {

		$this->document->setTitle('Sell from store');

		$data['heading_title'] = $this->language->get('Sell from store');

		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/com_ser_common.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/service.css');

		//$data['information_left'] = $this->load->controller('information/left');

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

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/service_store', $data));
	}

	/**
     * sell online页面
     */
	public function online() {

		$this->document->setTitle('Sell online');

		$data['heading_title'] = $this->language->get('Sell online');

		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/com_ser_common.css');
		$this->document->addStyle('catalog/view/theme/default/stylesheet/information/service.css');

		//$data['information_left'] = $this->load->controller('information/left');

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

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/service_online', $data));
	}

}


