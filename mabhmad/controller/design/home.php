<?php
class ControllerDesignHome extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('design/home');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/home');

		$this->getList();
	}

	public function add() {
		$this->load->language('design/home');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/home');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_home->addHome($this->request->post);

			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$done="addHome:".$this->request->post['name'];
			//调用父类Controller的方法将操作记录添加入库
            $this->addUserDone($doneUrl,$done);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

	
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('design/home', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('design/home');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/home');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_home->editHome($this->request->get['home_id'], $this->request->post);

			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$done="editHome:ID=".$this->request->get['home_id']; //$this->request->post['name'];
			//调用父类Controller的方法将操作记录添加入库
            $this->addUserDone($doneUrl,$done);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';


			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('design/home', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('design/home');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/home');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $home_id) {
				$result['name'][]=$this->model_design_home->getHome($home_id);
				$this->model_design_home->deleteHome($home_id);
			}

			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$name='';
            foreach($result['name'] as $value){
            	$name.='ID='.$value['home_id'].',name='.$value['name'].';';
            }
			$done="deletehome:".substr($name, 0, -1);
			//调用父类Controller的方法将操作记录添加入库
            $this->addUserDone($doneUrl,$done);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

		

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('design/home', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
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
			'href' => $this->url->link('design/home', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('design/home/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('design/home/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['homes'] = array();

		$filter_data = array(
		
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$home_total = $this->model_design_home->getTotalHomes();

		$results = $this->model_design_home->getHomes($filter_data);
		$this->load->model('catalog/category');


		foreach ($results as $result) {

		// $category=$this->model_catalog_category->getCategory($result['category_id']);
			$data['homes'][] = array(
				'home_id' => $result['home_id'],
				'floor'      => $result['floor'],
				'path'      => $result['path'],
				// 'category_name'      => $category['name'],
				'category_id'      => $result['category_id'],
				'image'      => $result['image'],
				'edit'      => $this->url->link('design/home/edit', 'token=' . $this->session->data['token'] . '&home_id=' . $result['home_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_category'] = $this->language->get('column_category');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

	
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

	
		$pagination = new Pagination();
		$pagination->total = $home_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('design/home', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($home_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($home_total - $this->config->get('config_limit_admin'))) ? $home_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $home_total, ceil($home_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('design/home_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['home_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');

		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_title_small'] = $this->language->get('entry_title_small');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_mimage'] = $this->language->get('entry_mimage');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['entry_video'] = $this->language->get('entry_video');
		 $data['edit_video'] = $this->url->link('catalog/product/editVideo').'&token=' . $this->session->data['token'];
		 $data['delete_video'] = $this->url->link('catalog/product/deleteVideo').'&token=' . $this->session->data['token'];
		 	// $data['edit_video_url'] = '&token=' . $this->session->data['token'] ;
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
			'href' => $this->url->link('design/home', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['home_id'])) {
			$data['action'] = $this->url->link('design/home/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('design/home/edit', 'token=' . $this->session->data['token'] . '&home_id=' . $this->request->get['home_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('design/home', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['home_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$home_info = $this->model_design_home->getHome($this->request->get['home_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['title'])) {
			$data['title'] = $this->request->post['title'];
		} elseif (!empty($home_info)) {
			$data['title'] = $home_info['title'];
		} else {
			$data['title'] = '';
		}
		if (isset($this->request->post['link'])) {
			$data['link'] = $this->request->post['link'];
		} elseif (!empty($home_info)) {
			$data['link'] = $home_info['link'];
		} else {
			$data['link'] = '';
		}
		if (isset($this->request->post['floor'])) {
			$data['floor'] = $this->request->post['floor'];
		} elseif (!empty($home_info)) {
			$data['floor'] = $home_info['floor'];
		} else {
			$data['floor'] = '';
		}
		if (isset($this->request->post['category_id'])) {
			$data['category_id'] = $this->request->post['category_id'];
		} elseif (!empty($home_info)) {
			$data['category_id'] = $home_info['category_id'];
		} else {
			$data['category_id'] = 0;
		}
		if (isset($this->request->post['path'])) {
			$data['path'] = $this->request->post['path'];
		} elseif (!empty($home_info)) {
			$data['path'] = $home_info['path'];
		} else {
			$data['path'] = '';
		}
		if (isset($this->error['parent'])) {
			$data['error_parent'] = $this->error['parent'];
		} else {
			$data['error_parent'] = '';
		}
		  $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
		   if (isset($this->request->post['video'])) {
            $data['video'] = $this->request->post['video'];
                 $data['video_url'] = $http_type . $_SERVER['HTTP_HOST'] . '/image/' . $this->request->post['video'];
        } elseif (!empty($home_info)) {
            $data['video'] = $home_info['video'];
               $data['video_url'] = $http_type . $_SERVER['HTTP_HOST'].'/mabhmad/'. $home_info['video'];
        } else {
            $data['video'] = '';
            $data['video_url'] ='';
        }

		$url = '';
		$this->load->model('tool/image');
		if (!empty($home_info)) {
		if (is_file(DIR_IMAGE . $home_info['mimage'])) {
					$data['mimage'] = $home_info['mimage'];
					$data['mthumb'] = $this->model_tool_image->resize($home_info['mimage'],100,100);
				} else {
					$data['mimage'] = '';
					$data['mthumb'] = $this->model_tool_image->resize('no_image.png',100,100);
				}
		if (is_file(DIR_IMAGE . $home_info['image'])) {
					$data['image'] = $home_info['image'];
					$data['thumb'] = $this->model_tool_image->resize($home_info['image'],100,100);
				} else {
					$data['image'] = '';
					$data['thumb'] = $this->model_tool_image->resize('no_image.png',100,100);
				}
			}else{
				$data['mimage'] = '';
					$data['mthumb'] = $this->model_tool_image->resize('no_image.png',100,100);
					$data['image'] = '';
					$data['thumb'] = $this->model_tool_image->resize('no_image.png',100,100);
			}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();




		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('design/home_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/home')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		

	

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/home')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}