<?php
class ControllerAccountAccount extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', true);
			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/edit');

		$this->document->setTitle($this->language->get('heading_title'));

		//引入该页面的css样式
		$this->document->addStyle('catalog/view/theme/default/stylesheet/account/account_account.css');

		$this->load->model('account/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			//$this->model_account_customer->editCustomer($this->request->post);
			$this->model_account_customer->editCustomerUK($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			// Add to activity log
			if ($this->config->get('config_customer_activity')) {
				$this->load->model('account/activity');

				$activity_data = array(
					'customer_id' => $this->customer->getId(),
					'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
				);

				$this->model_account_activity->addActivity('edit', $activity_data);
			}
			$this->response->redirect($this->url->link('account/account', '', true));
		}

		$data['heading_title'] = 'UPDATE ACCOUNT INFORMATION';

		//$data['text_your_details'] = $this->language->get('text_your_details');

		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');

        //密码
		$data['entry_oldpassword'] = 'Current Password';
		$data['entry_password'] = 'New Password';
		$data['entry_confirm'] = 'Confirm Password';

		$data['button_continue'] = 'UPDATE';

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

        if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}
		//密码的错误提示
		/*if (isset($this->error['oldpassword'])) {
			$data['error_oldpassword'] = $this->error['oldpassword'];
		} else {
			$data['error_oldpassword'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}*/

		if (isset($this->session->data['oldpassword'])) {
			$data['error_oldpassword'] = $this->session->data['oldpassword'];
			unset($this->session->data['oldpassword']);
		} else {
			$data['error_oldpassword'] = '';
		}

		if (isset($this->session->data['password'])) {
			$data['error_password'] = $this->session->data['password'];
			unset($this->session->data['password']);
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->session->data['confirm'])) {
			$data['error_confirm'] = $this->session->data['confirm'];
			unset($this->session->data['confirm']);
		} else {
			$data['error_confirm'] = '';
		}
		//密码的错误提示,end

		$data['action'] = $this->url->link('account/account', '', true);
		//修改密码的链接  dyl add
		$data['changepwd_action'] = $this->url->link('account/account/changepwd', '', true);

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($customer_info)) {
			$data['firstname'] = $customer_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($customer_info)) {
			$data['lastname'] = $customer_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($customer_info)) {
			$data['email'] = $customer_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($customer_info)) {
			$data['telephone'] = $customer_info['telephone'];
		} else {
			$data['telephone'] = '';
		}
// print_r($this->request->post['email']);exit();
        //旧密码
		if (isset($this->request->post['oldpassword'])) {
			$data['oldpassword'] = $this->request->post['oldpassword'];
		} else {
			$data['oldpassword'] = '';
		}

        //新密码
		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

        //确认的新密码
		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		//$data['column_right'] = $this->load->controller('common/column_right');
		$data['account_left'] = $this->load->controller('account/left');      //新左侧栏
		$data['content_top'] = $this->load->controller('common/content_top');
		//$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
//print_r($data);exit();
		$this->response->setOutput($this->load->view('account/account', $data));
	}

	protected function validate() {

		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_exists');
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

        /*//密码的验证
		if(!empty($this->request->post['oldpassword'])){
			$this->load->model('account/customer');
			if (!$this->model_account_customer->chkOldPassword($this->request->post['oldpassword'])) {
				$this->error['oldpassword'] = 'Current Password is error!';
			}
		}

		if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
			if(!empty($this->request->post['password'])){
				$this->error['password'] = 'Password must be between 4 and 20 characters!';
			}
		}

		if ($this->request->post['confirm'] != $this->request->post['password']) {
			if(!empty($this->request->post['password'])){
				$this->error['confirm'] = 'Password confirmation does not match password!';
			}
		}
		//密码的验证,end */

		return !$this->error;
	}


    /**
     * 用户修改密码
     * @author  dyl 783973660@qq.com 2016.9.28
     */
	public function changepwd(){

        $this->load->language('account/edit');
        $this->load->model('account/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatepwd()) {

		   $this->model_account_customer->editCustomerUK($this->request->post);
		   $this->session->data['success'] = $this->language->get('text_success');

		   // Add to activity log
		   if($this->config->get('config_customer_activity')){
			  $this->load->model('account/activity');

			  $activity_data = array(
				 'customer_id' => $this->customer->getId(),
				 'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			  );

			  $this->model_account_activity->addActivity('edit', $activity_data);
		   }

		}

		$this->response->redirect($this->url->link('account/account', '', true));

	}


    /**
     * 验证用户的密码
     * @author   dyl  783973660@qq.com  2016.9.28
     */
	protected function validatepwd(){

		if(empty($this->request->post['oldpassword'])){
           //$this->error['oldpassword'] = 'The current password cannot be empty!';
           $this->session->data['oldpassword'] = 'The current password cannot be empty!';
           return false;
		}

		if(empty($this->request->post['password'])){
           //$this->error['password'] = 'The new password can not be empty!';
           $this->session->data['password'] = 'The new password can not be empty!';
           return false;
		}

		if(empty($this->request->post['confirm'])){
           //$this->error['confirm'] = 'Confirm password cannot be empty!';
           $this->session->data['confirm'] = 'Confirm password cannot be empty!';
           return false;
		}

		//密码的验证
		if(!empty($this->request->post['oldpassword'])){
			$this->load->model('account/customer');
			if (!$this->model_account_customer->chkOldPassword($this->request->post['oldpassword'])) {
				//$this->error['oldpassword'] = 'Current Password is error!';
				$this->session->data['oldpassword'] = 'Current Password is error!';
				return false;
			}
		}

		if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
			if(!empty($this->request->post['password'])){
				//$this->error['password'] = 'Password must be between 4 and 20 characters!';
				$this->session->data['password'] = 'Password must be between 4 and 20 characters!';
				return false;
			}
		}

		if ($this->request->post['confirm'] != $this->request->post['password']) {
			if(!empty($this->request->post['password'])){
				//$this->error['confirm'] = 'Password confirmation does not match password!';
				$this->session->data['confirm'] = 'The password confirmation must match your password!';
				return false;
			}
		}
		//密码的验证,end

		return true;

	}


	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}
