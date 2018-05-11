<?php
class ControllerCustomerEmail extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('customer/email');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customer/email');

		$this->getList();
	}

	public function add() {
		$this->load->language('customer/email');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customer/email');

		$this->getForm();
	}

	public function edit() {
		$this->load->language('customer/email');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customer/email');

	
			
		$this->getForm();
	}
	public function send_now() {
		if (isset($this->request->get['email_id'])) {

			$this->load->language('customer/email');
			$this->load->model('customer/email');
			$email_info = $this->model_customer_email->getEmail($this->request->get['email_id']);

			if ($email_info) {
				$data['email_id']=$email_info['email_id'];
				$data['customer_id']=$email_info['customer_id'];
				$data['content']=html_entity_decode($email_info['content'], ENT_QUOTES, 'UTF-8');
				$data['breadcrumbs'] = array();

				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('text_home'),
					'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
				);

				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('heading_title'),
					'href' => $this->url->link('customer/email', 'token=' . $this->session->data['token'] , true)
				);

				$data['send_customers'] = $this->model_customer_email->getCustomers($email_info['customer_id']);
				// print_r($data['send_customers']);exit();

				$this->document->setTitle($this->language->get('heading_title'));
				$data['heading_title'] = $this->language->get('heading_title');
				$data['header'] = $this->load->controller('common/header');
				$data['column_left'] = $this->load->controller('common/column_left');
				$data['footer'] = $this->load->controller('common/footer');
				$data['url'] =html_entity_decode($this->url->link('customer/email/ajax_send', 'token=' . $this->session->data['token'], true));


				$this->response->setOutput($this->load->view('customer/email_send', $data));
			}else{
				$this->response->redirect($this->url->link('customer/email', 'token=' . $this->session->data['token'] . $url, true));

			}

			
		}else{
			$this->response->redirect($this->url->link('customer/email', 'token=' . $this->session->data['token'] . $url, true));
		}

	}
	public function send() {
		// print_r($this->validateSend());exit();
			$this->load->language('customer/email');
		if ($this->validateSend()) {
				$this->load->model('customer/email');
			$email_id=$this->model_customer_email->addEmail($this->request->post);
			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$done="addEmail:".$this->request->post['title'];
			//调用父类Controller的方法将操作记录添加入库
            $this->addUserDone($doneUrl,$done);
            	
            $this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			if (isset($this->request->post['append_no_send'])) {
				$this->response->redirect($this->url->link('customer/email', 'token=' . $this->session->data['token'] . $url, true));
			}else{
				$this->response->redirect($this->url->link('customer/email/send_now', 'token=' . $this->session->data['token'] .'&email_id='.$email_id, true));
			}

			

		}else{
		
				$this->document->setTitle($this->language->get('heading_title'));
			$this->load->model('customer/email');
			$this->getForm();
		}

		
	

			
		
	}
	public function ajax_send() {
		$this->load->language('customer/email');

		$json = array();
		$email_id=$this->request->post['email_id'];
		$customer_ids=$this->request->post['customer_id'];
		$customer_ids=explode(',', $customer_ids);
		$customer_id=$customer_ids[0];
		unset($customer_ids[0]);
		$json['email_id']=$email_id;
		$json['customer_id']=implode(',', $customer_ids);

		$this->load->model('customer/email');
	
		$email_info=$this->model_customer_email->getEmail($email_id);
		$send_customer_id=$email_info['send_customer_id'];
		$send_customer_id=explode(',', $send_customer_id);
		$this->load->model('customer/customer');
		$customer_info = $this->model_customer_customer->getCustomer($customer_id);
		if(in_array($customer_id, $send_customer_id)){
			$json['content']=$customer_info['email'].'已经发送过了，如需重新发送请编辑重发';
		}else{
			$p=$this->model_customer_email->sendEmail($customer_id,$email_id);
				if($p){
					$json['content']=$customer_info['email'].'发送成功';
				}else{
					$json['content']=$customer_info['email'].'发送失败';
				}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete() {
		$this->load->language('customer/email');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customer/email');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $email_id) {
				$result['name'][] = $this->model_customer_email->getEmail($email_id);
				$this->model_customer_email->deleteEmail($email_id);
			}

			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$name='';
            foreach($result['name'] as $value){
            	$name.='ID='.$value['email_id'].';';
            }
			$done="deleteEmail:".substr($name, 0, -1);
			//调用父类Controller的方法将操作记录添加入库
            $this->addUserDone($doneUrl,$done);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('customer/email', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	

	protected function getList() {
		

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'time';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

	
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('customer/email', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('customer/email/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('customer/email/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['emails'] = array();

		$filter_data = array(

			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$email_total = $this->model_customer_email->getTotalEmails($filter_data);

		$results = $this->model_customer_email->getEmails($filter_data);
		// print_r($results);exit();

		foreach ($results as $result) {
			$data['emails'][] = array(
				'email_id'    => $result['email_id'],
				'title'           => $result['title'],
				'time'          => $result['time'],
				'content'          => strip_tags(html_entity_decode($result['content'], ENT_QUOTES, 'UTF-8')),
				
				'edit'           => $this->url->link('customer/email/edit', 'token=' . $this->session->data['token'] . '&email_id=' . $result['email_id'] . $url, true),
				
				'send'           => $this->url->link('customer/email/send_now', 'token=' . $this->session->data['token'] . '&email_id=' . $result['email_id'] . $url, true)
			);
		}
		// print_r($data['emails']);exit();

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_time'] = $this->language->get('column_time');
		$data['column_content'] = $this->language->get('column_content');
		$data['column_approved'] = $this->language->get('column_approved');
		$data['column_ip'] = $this->language->get('column_ip');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_approved'] = $this->language->get('entry_approved');
		$data['entry_ip'] = $this->language->get('entry_ip');
		$data['entry_date_added'] = $this->language->get('entry_date_added');

		$data['button_approve'] = $this->language->get('button_approve');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_login'] = $this->language->get('button_login');
		$data['button_unlock'] = $this->language->get('button_unlock');
		$data['button_send'] = $this->language->get('button_send');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

	
		$url = '';

	

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $email_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customer/email', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($email_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($email_total - $this->config->get('config_limit_admin'))) ? $email_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $email_total, ceil($email_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/email_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['customer_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_add_ban_ip'] = $this->language->get('text_add_ban_ip');
		$data['text_remove_ban_ip'] = $this->language->get('text_remove_ban_ip');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_content'] = $this->language->get('entry_content');

		$data['button_save_no_send'] = $this->language->get('button_save_no_send');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['button_transaction_add'] = $this->language->get('button_transaction_add');
		$data['button_reward_add'] = $this->language->get('button_reward_add');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_upload'] = $this->language->get('button_upload');

		$data['entry_customer'] = $this->language->get('entry_customer');

	

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->get['email_id'])) {
			$data['email_id'] = $this->request->get['email_id'];
		} else {
			$data['email_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

	
		$url = '';

		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('customer/email', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['action'] = $this->url->link('customer/email/send', 'token=' . $this->session->data['token'] . $url, true);
	

		$data['cancel'] = $this->url->link('customer/email', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['email_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$email_info = $this->model_customer_email->getEmail($this->request->get['email_id']);
		}

		$this->load->model('customer/customer');
		$data['customers'] = $this->model_customer_customer->getCustomers();
		// print_r($data['customers']);exit();

	
		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (!empty($email_info)) {
			$data['title'] = $email_info['title'];
		} else {
			$data['title'] = '';
		}
		if (isset($this->request->post['content'])) {
			$data['content'] = $this->request->post['content'];
		} elseif (!empty($email_info)) {
			$data['content'] = $email_info['content'];
		} else {
			$data['content'] = '';
		}
		if (isset($this->request->post['customer_id'])) {
			$data['customer_ids'] = $this->request->post['customer_id'];
		} elseif (!empty($email_info)) {
			$data['customer_ids'] =explode(',', $email_info['customer_id']) ;
		} else {
			$data['customer_ids'] = array();
		}
		// print_r($data['customer_ids']);exit();
		// if (!empty($email_info)) {
		// 	$data['send_customers'] = $this->model_customer_email->getCustomers($email_info['send_customer_id']);
		// } else {
		// 	$data['send_customers'] = array();
		// }
		if (isset($this->request->post['content'])) {
			$data['content'] = $this->request->post['content'];
		} elseif (!empty($email_info)) {
			$data['content'] = $email_info['content'];
		} else {
			$data['content'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}
		if (isset($this->error['content'])) {
			$data['error_content'] = $this->error['content'];
		} else {
			$data['error_content'] = '';
		}
		if (isset($this->error['customer'])) {
			$data['error_customer'] = $this->error['customer'];
		} else {
			$data['error_customer'] = '';
		}
		// print_r($this->error);exit();
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/email_form', $data));
	}

	
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'customer/email')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	protected function validateSend() {
		if (!utf8_strlen($this->request->post['content']) > 0) {
			$this->error['content'] = $this->language->get('error_content');
			
		}
		if (!utf8_strlen($this->request->post['title']) > 0) {
			$this->error['title'] = $this->language->get('error_title');
			
		}
		if ((!isset($this->request->post['customer_id']))&&!isset($this->request->post['append_no_send'])) {
			$this->error['customer'] = $this->language->get('error_customer');
		}
		// print_r($this->error);exit();
		

		return !$this->error;
	}



	
	
}
