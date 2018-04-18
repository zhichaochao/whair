<?php
class ControllerSettingFeedback extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('setting/feedback');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/feedback');
		$this->getList();
	}


	public function edit() {

		$this->load->language('setting/feedback');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/feedback');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			//只有申请状态pending才能修改数据表
			$this->model_setting_feedback->editFeedback($this->request->get['id'], $this->request->post);

            //dyl add 2016.1.6
			//获取路由参数
			//$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			//$done="editFeedback:ID=".$this->request->get['id']; //$this->request->post['domain'];
			//调用父类Controller的方法将操作记录添加入库
            //$this->addUserDone($doneUrl,$done);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			if (isset($this->request->get['filter_submitTime'])) {
				$url .= '&filter_submitTime=' . $this->request->get['filter_submitTime'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('setting/feedback', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('setting/feedback');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/feedback');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			$ids = '';
			foreach ($this->request->post['selected'] as $id) {
				$result['name'][]=$this->model_setting_feedback->getFeedbackById($id);
				//$this->model_setting_feedback->deleteFeedback($id);
				$ids .= $id . ',';
			}
			$ids = mb_substr($ids, 0, -1, 'utf-8');
			$this->model_setting_feedback->deleteFeedback($ids);

			//dyl add 2016.1.6
			//获取路由参数
			//$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			//$name='';
            //foreach($result['name'] as $value){
            //	$name.='ID='.$value['id'].',name='.$value['name'].';';
            //}
			//$done="deleteFeedback:".substr($name, 0, -1);
			//调用父类Controller的方法将操作记录添加入库
            //$this->addUserDone($doneUrl,$done);

			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			if (isset($this->request->get['filter_submitTime'])) {
				$url .= '&filter_submitTime=' . $this->request->get['filter_submitTime'];
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('setting/feedback', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}


	protected function getList() {

		$url = '';
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		} else {
			$filter_name = null;
		}
		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}
		if (isset($this->request->get['filter_submitTime'])) {
			$filter_submitTime = $this->request->get['filter_submitTime'];
			$url .= '&filter_submitTime=' . $this->request->get['filter_submitTime'];
		} else {
			$filter_submitTime = null;
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
			$url .= '&page=' . $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('setting/feedback', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

        //添加和删除的链接
		//$data['add'] = $this->url->link('setting/feedback/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('setting/feedback/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['feedbacks'] = array();
		$filter_data = array(
			'filter_name'       => $filter_name,
			'filter_email'     => $filter_email,
			'filter_submitTime'  => $filter_submitTime,
			'start'             => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'             => $this->config->get('config_limit_admin')
		);

		$feedback_total = $this->model_setting_feedback->getTotalFeedbackData($filter_data);
		$results = $this->model_setting_feedback->getFeedbackData($filter_data);
		foreach ($results as $result) {
			$data['feedbacks'][] = array(
			    'id'           => $result['id'],
				'name'         => $result['name'],
				'email'        => $result['email'],
				'fixed_line'   => $result['fixed_line'],
				'coun_name'    => $result['coun_name'],     //国家名字
				'phone'        => $result['phone'],
				'comment'      => $result['comment'],
				'submitTime'   => date($this->language->get('date_format_short'), strtotime($result['submitTime'])),         //反馈时间
				'edit'         => $this->url->link('setting/feedback/edit', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
        $data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');

        //列表名称
		$data['column_name'] = $this->language->get('column_name');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_comment'] = $this->language->get('column_comment');
		$data['column_submitTime'] = $this->language->get('column_submitTime');
		$data['column_action'] = $this->language->get('column_action');

        //刷选条件
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_submitTime'] = $this->language->get('entry_submitTime');

        //操作按钮
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
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

		$pagination = new Pagination();
		$pagination->total = $feedback_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('setting/feedback', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($feedback_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($feedback_total - $this->config->get('config_limit_admin'))) ? $feedback_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $feedback_total, ceil($feedback_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_email'] = $filter_email;
		$data['filter_submitTime'] = $filter_submitTime;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('setting/feedback_list.tpl', $data));
	}

    protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_form'] = $this->language->get('text_edit');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_comment'] = $this->language->get('entry_comment');

		$data['button_cancel'] = $this->language->get('button_cancel');
        //错误提示
        $data['error_warning']=isset($this->error['warning']) ? $this->error['warning'] : '';

		$url = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('setting/feedback', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

        //取消按钮
		$data['cancel'] = $this->url->link('setting/feedback', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$feedback_info = $this->model_setting_feedback->getFeedbackById($this->request->get['id']);
		}

        //将数据返回给页面
		if (isset($this->request->post['id'])) {
			$data['id'] = $this->request->post['id'];
		} elseif ( !empty($feedback_info) ) {
			$data['id'] = $feedback_info['id'];
		} else {
			$data['id'] = null;
		}

		if (isset($this->request->post['name'])) {
		    $data['name'] = $this->request->post['name'];
		}  elseif ( !empty($feedback_info) ) {
		    $data['name'] = $feedback_info['name'];
		} else {
		    $data['name'] = null;
		}

		if (isset($this->request->post['email'])) {
		    $data['email'] = $this->request->post['email'];
		}  elseif ( !empty($feedback_info) ) {
		    $data['email'] = $feedback_info['email'];
		} else {
		    $data['email'] = null;
		}

		if (isset($this->request->post['fixed_line'])) {
		    $data['fixed_line'] = $this->request->post['fixed_line'];
		}  elseif ( !empty($feedback_info) ) {
		    $data['fixed_line'] = $feedback_info['fixed_line'];
		} else {
		    $data['fixed_line'] = null;
		}

		if (isset($this->request->post['coun_name'])) {
		    $data['coun_name'] = $this->request->post['coun_name'];
		}  elseif ( !empty($feedback_info) ) {
		    $data['coun_name'] = $feedback_info['coun_name'];
		} else {
		    $data['coun_name'] = null;
		}

		if (isset($this->request->post['phone'])) {
		    $data['phone'] = $this->request->post['phone'];
		}  elseif ( !empty($feedback_info) ) {
		    $data['phone'] = $feedback_info['phone'];
		} else {
		    $data['phone'] = null;
		}

		if (isset($this->request->post['comment'])) {
		    $data['comment'] = $this->request->post['comment'];
		}  elseif ( !empty($feedback_info) ) {
		    $data['comment'] = $feedback_info['comment'];
		} else {
		    $data['comment'] = null;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('setting/feedback_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'setting/feedback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'setting/feedback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}


	/*public function autocomplete() {
		$affiliate_data = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_email'])) {
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_email'])) {
				$filter_email = $this->request->get['filter_email'];
			} else {
				$filter_email = '';
			}

			$this->load->model('marketing/affiliate_withdraw');

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_email' => $filter_email,
				'start'        => 0,
				'limit'        => 5
			);

			$results = $this->model_marketing_affiliate_withdraw->getAffiliateDomains($filter_data);

			foreach ($results as $result) {
				$affiliate_data[] = array(
					'affiliate_id' => $result['affiliate_id'],
					'name'         => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'email'        => $result['email']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($affiliate_data));
	}*/
}