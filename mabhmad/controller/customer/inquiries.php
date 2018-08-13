<?php
class ControllerCustomerInquiries extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('customer/inquiries');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customer/inquiries');

		$this->getList();
	}

	

	public function edit() {
		$this->load->language('customer/inquiries');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customer/inquiries');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			//图片迁移和入库
			// if($_FILES){
			// 	$path = array();
			// 	foreach($_FILES['file']['name'] as $key=>$row){

			// 		if($_FILES['file']['error'][$key]==4){
			// 			continue;
			// 		}

			// 		if($_FILES['file']['error'][$key]==0){
			// 			if(($_FILES['file']['type'][$key]=='image/gif' || $_FILES['file']['type'][$key]=='image/jpeg' || $_FILES['file']['type'][$key]=='image/pjpeg' || $_FILES['file']['type'][$key]=='image/png')){
			// 				$extend = pathinfo($row); //获取文件名数组
			// 				$extend = strtolower($extend["extension"]);                //获取文件的扩展名
			// 				$filename = time().rand(100,999).".".$extend;              //文件的新名称
			// 				$directory = DIR_IMAGE . "customer/thimg/inquiries";
			// 				$path[] = 'image/customer/thimg/inquiries/' . $filename;
			// 				move_uploaded_file($_FILES['file']['tmp_name'][$key],$directory . '/' . $filename);
			// 			}
			// 		}
			// 	}
			// }
		    //图片迁移和入库,end

			//$this->model_customer_inquiries->editInquiries($this->request->get['id'], $this->request->post, $path);

			//获取路由参数
			// $doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			// $done="editInquiries:ID=".$this->request->get['id']; 
			// //调用父类Controller的方法将操作记录添加入库
   //          $this->addUserDone($doneUrl,$done);

			// $this->session->data['success'] = $this->language->get('text_success');

			// $url = '';

			// if (isset($this->request->get['filter_product'])) {
			// 	$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
			// }

			// if (isset($this->request->get['filter_author'])) {
			// 	$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
			// }

			// if (isset($this->request->get['filter_status'])) {
			// 	$url .= '&filter_status=' . $this->request->get['filter_status'];
			// }

			// if (isset($this->request->get['filter_date_added'])) {
			// 	$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			// }

			// if (isset($this->request->get['sort'])) {
			// 	$url .= '&sort=' . $this->request->get['sort'];
			// }

			// if (isset($this->request->get['order'])) {
			// 	$url .= '&order=' . $this->request->get['order'];
			// }

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('customer/inquiries', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('customer/inquiries');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('customer/inquiries');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $id) {
				$result['name'][]=$this->model_customer_inquiries->getInquiries($id);
				$this->model_customer_inquiries->deleteInquiries($id);
			}

			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$name='';
            foreach($result['name'] as $value){
            	$name.='ID='.$value['id'].',author='.$value['author'].';';
            }
			$done="deleteInquiries:".substr($name, 0, -1);
			//调用父类Controller的方法将操作记录添加入库
            $this->addUserDone($doneUrl,$done);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_product'])) {
				$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_author'])) {
				$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('customer/inquiries', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_product'])) {
			$filter_product = $this->request->get['filter_product'];
		} else {
			$filter_product = null;
		}

		if (isset($this->request->get['filter_author'])) {
			$filter_author = $this->request->get['filter_author'];
		} else {
			$filter_author = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'r.date_added';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

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
			'href' => $this->url->link('customer/inquiries', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('customer/inquiries/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('customer/inquiries/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['inquiriess'] = array();

		$filter_data = array(
			'filter_product'    => $filter_product,
			'filter_author'     => $filter_author,
			'filter_status'     => $filter_status,
			'filter_date_added' => $filter_date_added,
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'             => $this->config->get('config_limit_admin')
		);

		$inquiries_total = $this->model_customer_inquiries->getTotalInquiriessAwaitingApproval($filter_data);

		$results = $this->model_customer_inquiries->getInquiriess($filter_data);
		//print_r($results);exit();

		foreach ($results as $result) {
			$data['inquiriess'][] = array(
				'id'  => $result['id'],
				'name'       => $result['name'],
				'email'     => $result['email'],
				'phone'     => $result['phone'],
				'comment'     =>utf8_substr(strip_tags($result['comment']),0,50).'...',
				'submitTime' => date($this->language->get('date_format_short'), strtotime($result['submitTime'])),
				'edit'       => $this->url->link('customer/inquiries/edit', 'token=' . $this->session->data['token'] . '&id=' . $result['id'], true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['column_product'] = $this->language->get('column_product');
		$data['column_author'] = $this->language->get('column_author');
		$data['column_rating'] = $this->language->get('column_rating');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_author'] = $this->language->get('entry_author');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_date_added'] = $this->language->get('entry_date_added');

		$data['button_add'] = $this->language->get('button_add');
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

		$url = '';

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_product'] = $this->url->link('customer/inquiries', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
		$data['sort_author'] = $this->url->link('customer/inquiries', 'token=' . $this->session->data['token'] . '&sort=r.author' . $url, true);
		$data['sort_rating'] = $this->url->link('customer/inquiries', 'token=' . $this->session->data['token'] . '&sort=r.rating' . $url, true);
		$data['sort_status'] = $this->url->link('customer/inquiries', 'token=' . $this->session->data['token'] . '&sort=r.status' . $url, true);
		$data['sort_date_added'] = $this->url->link('customer/inquiries', 'token=' . $this->session->data['token'] . '&sort=r.date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $inquiries_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('customer/inquiries', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($inquiries_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($inquiries_total - $this->config->get('config_limit_admin'))) ? $inquiries_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $inquiries_total, ceil($inquiries_total / $this->config->get('config_limit_admin')));

		$data['filter_product'] = $filter_product;
		$data['filter_author'] = $filter_author;
		$data['filter_status'] = $filter_status;
		$data['filter_date_added'] = $filter_date_added;

		//dyl加 导入产品评论的链接
		//$data['importComment'] = $this->url->link('customer/inquiries/importComment', 'token=' . $this->session->data['token'] , 'SSL');

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/inquiries_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_author'] = $this->language->get('entry_author');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_text'] = $this->language->get('entry_text');

		$data['help_product'] = $this->language->get('help_product');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		// if (isset($this->error['warning'])) {
		// 	$data['error_warning'] = $this->error['warning'];
		// } else {
		// 	$data['error_warning'] = '';
		// }

		// if (isset($this->error['product'])) {
		// 	$data['error_product'] = $this->error['product'];
		// } else {
		// 	$data['error_product'] = '';
		// }

		// if (isset($this->error['author'])) {
		// 	$data['error_author'] = $this->error['author'];
		// } else {
		// 	$data['error_author'] = '';
		// }

		// if (isset($this->error['text'])) {
		// 	$data['error_text'] = $this->error['text'];
		// } else {
		// 	$data['error_text'] = '';
		// }

		// if (isset($this->error['rating'])) {
		// 	$data['error_rating'] = $this->error['rating'];
		// } else {
		// 	$data['error_rating'] = '';
		// }

		//dyl加 添加时间的错误提示
		// if (isset($this->error['date_added'])) {
		// 	$data['error_date_added'] = $this->error['date_added'];
		// } else {
		// 	$data['error_date_added'] = '';
		// }

		//dyl加 图片的错误提示
		// if (isset($this->error['pic_format_wrong'])) {
		// 	$data['error_image'] = $this->error['pic_format_wrong'];
		// } else {
		// 	$data['error_image'] = '';
		// }

		$url = '';

		// if (isset($this->request->get['filter_product'])) {
		// 	$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		// }

		// if (isset($this->request->get['filter_author'])) {
		// 	$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		// }

		// if (isset($this->request->get['filter_status'])) {
		// 	$url .= '&filter_status=' . $this->request->get['filter_status'];
		// }

		// if (isset($this->request->get['filter_date_added'])) {
		// 	$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		// }

		// if (isset($this->request->get['sort'])) {
		// 	$url .= '&sort=' . $this->request->get['sort'];
		// }

		// if (isset($this->request->get['order'])) {
		// 	$url .= '&order=' . $this->request->get['order'];
		// }

		// if (isset($this->request->get['page'])) {
		// 	$url .= '&page=' . $this->request->get['page'];
		// }

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('customer/inquiries', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['id'])) {
			$data['action'] = $this->url->link('customer/inquiries/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('customer/inquiries/edit', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('customer/inquiries', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$inquiries_info = $this->model_customer_inquiries->getInquiries($this->request->get['id']);
			//print_r($inquiries_info);exit;
		    //$data['inquiries_img'] = $this->model_customer_inquiries->getInquiriesImg($this->request->get['id']);
		}
		// else{
		// 	$data['inquiries_img'] = array();
		// }

		$data['token'] = $this->session->data['token'];

		//$this->load->model('customer/product');

		if (isset($this->request->post['id'])) {
			$data['id'] = $this->request->post['id'];
		} elseif (!empty($inquiries_info)) {
			$data['id'] = $inquiries_info['id'];
		} else {
			$data['id'] = '';
		}

		if (isset($this->request->post['name'])) {
			$data['product'] = $this->request->post['name'];
		} elseif (!empty($inquiries_info)) {
			$data['name'] = $inquiries_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($inquiries_info)) {
			$data['email'] = $inquiries_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['phone'])) {
			$data['phone'] = $this->request->post['phone'];
		} elseif (!empty($inquiries_info)) {
			$data['phone'] = $inquiries_info['phone'];
		} else {
			$data['phone'] = '';
		}

		if (isset($this->request->post['comment'])) {
			$data['comment'] = $this->request->post['comment'];
		} elseif (!empty($inquiries_info)) {
			$data['comment'] = $inquiries_info['comment'];
		} else {
			$data['comment'] = '';
		}

		// if (isset($this->request->post['date_added'])) {
		// 	$data['date_added'] = $this->request->post['date_added'];
		// } elseif (!empty($inquiries_info)) {
		// 	$data['date_added'] = ($inquiries_info['date_added'] != '0000-00-00 00:00' ? $inquiries_info['date_added'] : '');
		// } else {
		// 	$data['date_added'] = '';
		// }

		// if (isset($this->request->post['status'])) {
		// 	$data['status'] = $this->request->post['status'];
		// } elseif (!empty($inquiries_info)) {
		// 	$data['status'] = $inquiries_info['status'];
		// } else {
		// 	$data['status'] = '';
		// }

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('customer/inquiries_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'customer/inquiries')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// if (!$this->request->post['product_id']) {
		// 	$this->error['product'] = $this->language->get('error_product');
		// }

		// if ((utf8_strlen($this->request->post['author']) < 3) || (utf8_strlen($this->request->post['author']) > 64)) {
		// 	$this->error['author'] = $this->language->get('error_author');
		// }

		// if (utf8_strlen($this->request->post['text']) < 1) {
		// 	$this->error['text'] = $this->language->get('error_text');
		// }

		// if (!isset($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
		// 	$this->error['rating'] = $this->language->get('error_rating');
		// }

  //      // 添加时间必填(前台产品详情页需要显示)   dyl  add
		// if (empty($this->request->post['date_added'])) {
		// 	$this->error['date_added'] = 'Add date cannot be empty!';
		// }

		// if($_FILES){
		// 	foreach($_FILES['file']['name'] as $key=>$row){

		// 		if($_FILES['file']['error'][$key]==4){
		// 			continue;
		// 		}
		// 		if($_FILES['file']['error'][$key]!=0){
		// 			$this->error['pic_format_wrong'] = 'Picture format wrong!';
		// 		}else if(!($_FILES['file']['type'][$key]=='image/gif' || $_FILES['file']['type'][$key]=='image/jpeg' || $_FILES['file']['type'][$key]=='image/pjpeg' || $_FILES['file']['type'][$key]=='image/png')){
		// 			$this->error['pic_format_wrong'] = 'Picture format wrong!';
		// 		}else if($_FILES['file']['size'][$key] > 4194304){   //限制图片大小为4M
  //                   $this->error['pic_format_wrong'] = 'Picture size can not exceed 4M!';
		// 		}
		// 	}
		// }

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'customer/inquiries')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}


   /**
	* 删除产品评论图片
	* @author  dyl 783973660@qq.com  2016.9.7
	*/
	// public function comment_delete_img(){
	// 	$id 		= $this->request->get['id'];
	// 	$inquiries_img_id 	= $this->request->get['inquiries_img_id'];
	// 	$token 	= $this->request->get['token'];

	// 	$this->load->model('customer/inquiries');

	// 	$this->model_customer_inquiries->deleteInquiriesImg($inquiries_img_id);

	// 	//获取路由参数
	// 	$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
	// 	$done="delInquiriesImg:Id=" . $id . "," . "imgId=" . $inquiries_img_id;
	// 	//调用父类Controller的方法将操作记录添加入库
	//     $this->addUserDone($doneUrl,$done);

	// 	$this->response->redirect($this->url->link('customer/inquiries/edit', 'id='.$id.'&token='.$token, 'SSL'));
	// }


	/**
	 * 导入产品评论功能
	 * @author dyl 783973660@qq.com 2016.9.20
	 */
	// public function importComment(){
	// 	$this->load->language('customer/inquiries');

	// 	$this->document->setTitle($this->language->get('heading_title'));
	// 	$data['heading_title'] = 'Inquiries Import';
	// 	$data['breadcrumbs'] = array();

	// 	$data['breadcrumbs'][] = array(
	// 		'text' => $this->language->get('text_home'),
	// 		'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
	// 	);

	// 	$data['breadcrumbs'][] = array(
	// 		'text' => $this->language->get('heading_title'),
	// 		'href' => $this->url->link('customer/inquiries', 'token=' . $this->session->data['token'], 'SSL')
	// 	);
	// 	$data['text_form'] = !isset($this->request->get['id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
	// 	$data['entry_import'] = 'import';
	// 	$data['button_save'] = $this->language->get('button_save');
	// 	$data['button_cancel'] = $this->language->get('button_cancel');

	// 	$data['error_upload_warning'] = '';

	// 	if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

	// 		if ((isset( $this->request->files['upload'] )) && (is_uploaded_file($this->request->files['upload']['tmp_name']))) {
	// 			$file = $this->request->files['upload']['tmp_name'];

	// 			$this->load->model('customer/inquiries_image');
	// 			$uploaded = $this->model_customer_inquiries_image->upload($file);

	// 			//获取路由参数
	// 			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
	// 			$done="addInquiriesImport:file=".$this->request->files['upload']['name'];
	// 			//调用父类Controller的方法将操作记录添加入库
	//             $this->addUserDone($doneUrl,$done);

	// 			$this->session->data['success'] = 'the inquiries import is success!'.var_dump($this->request->files['upload']);
	// 			$this->response->redirect($this->url->link('customer/inquiries/importComment', 'token=' . $this->session->data['token'], 'SSL'));
	// 		}
	// 		else
	// 		{
	// 		    $data['error_upload_warning'] = 'Please upload the file!';
	// 		}
	// 	}

	// 	if (isset($this->session->data['error'])) {
	// 		$data['error_warning'] = $this->session->data['error'];
	// 		unset($this->session->data['error']);
	// 	} else {
	// 		$data['error_warning'] = '';
	// 	}

	// 	if (isset($this->session->data['success'])) {
	// 		$data['success'] = $this->session->data['success'];
	// 		unset($this->session->data['success']);
	// 	} else {
	// 		$data['success'] = '';
	// 	}

	// 	$data['cancel'] = $this->url->link('customer/inquiries', 'token=' . $this->session->data['token'], 'SSL');
	// 	$data['action'] = $this->url->link('customer/inquiries/importComment', 'token=' . $this->session->data['token'], 'SSL');

	// 	$data['header'] = $this->load->controller('common/header');
	// 	$data['column_left'] = $this->load->controller('common/column_left');
	// 	$data['footer'] = $this->load->controller('common/footer');

	// 	$this->response->setOutput($this->load->view('customer/inquiries_import.tpl', $data));
 //    }


}