<?php
class ControllerExtensionPaymentCash extends Controller {
	/*
	 * 现金方式
	 */

	private $error = array();

	public function index() {
		$this->load->language('extension/payment/cash');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('cash', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');

		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_value'] = $this->language->get('entry_value');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/cash', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/payment/cash', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

		if (isset($this->request->post['cash_image'])) {
			$data['cash_image'] = $this->request->post['cash_image'];
		} else {
			$data['cash_image'] = $this->config->get('cash_image');
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['cash_image']) && is_file(DIR_IMAGE . $this->request->post['cash_image'])) {
			$data['cash_thumb'] = $this->model_tool_image->resize($this->request->post['cash_image'], 100, 100);
		} elseif ($this->config->get('cash_image') && is_file(DIR_IMAGE . $this->config->get('cash_image'))) {
			$data['cash_thumb'] = $this->model_tool_image->resize($this->config->get('cash_image'), 100, 100);
		} else {
			$data['cash_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		if (isset($this->request->post['cash_attributes'])) {
			$data['cash_attributes'] = $this->request->post['cash_attributes'];
		} elseif($this->config->get('cash_attributes')) {
			$data['cash_attributes'] = $this->config->get('cash_attributes');
		} else {
			$data['cash_attributes'] = [];
		}

		if (isset($this->request->post['cash_sort_order'])) {
			$data['cash_sort_order'] = $this->request->post['cash_sort_order'];
		} else {
			$data['cash_sort_order'] = $this->config->get('cash_sort_order');
		}

		if (isset($this->request->post['cash_status'])) {
			$data['cash_status'] = $this->request->post['cash_status'];
		} else {
			$data['cash_status'] = $this->config->get('cash_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/cash', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/cash')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}