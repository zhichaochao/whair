<?php
class ControllerCatalogProvideo extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/provideo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/profile_video');

		$this->load->model('tool/image');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/provideo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/profile_video');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		//print_r($this->request->post);exit();
			$this->model_catalog_profile_video->addProfile($this->request->post);

			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$done="addProfile:".$this->request->post['profile_description'][1]['title'];
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

			$this->response->redirect($this->url->link('catalog/provideo', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/provideo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/profile_video');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			// print_r( $this->request->post);exit;
			$this->model_catalog_profile_video->editProfile($this->request->get['profile_id'], $this->request->post);
			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$done="editProfile:ID=".$this->request->get['profile_id']; //$this->request->post['profile_description'][1]['title'];
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

			$this->response->redirect($this->url->link('catalog/provideo', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/provideo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/profile_video');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $profile_id) {
				$result['name'][]=$this->model_catalog_profile_video->getProfileDescriptions($profile_id);
				$this->model_catalog_profile_video->deleteProfile($profile_id);
			}

			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$name='';
            foreach($result['name'] as $value){
            	$name.='ID='.$value[1]['profile_id'].',title='.$value[1]['title'].';';
            }
			$done="deleteProfile:".substr($name, 0, -1);
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

			$this->response->redirect($this->url->link('catalog/provideo', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'id.title';
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
			'href' => $this->url->link('catalog/provideo', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/provideo/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/provideo/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['profiles'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$profile_total = $this->model_catalog_profile_video->getTotalProfiles();

		$results = $this->model_catalog_profile_video->getProfiles($filter_data);
//var_dump($results);exit;
		foreach ($results as $result) {
			$data['profiles'][] = array(
				'profile_id' => $result['profile_id'],
				'title'          => $result['title'],
				'sort_order'     => $result['sort_order'],
				'edit'           => $this->url->link('catalog/provideo/edit', 'token=' . $this->session->data['token'] . '&profile_id=' . $result['profile_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_title'] = $this->url->link('catalog/provideo', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/provideo', 'token=' . $this->session->data['token'] . '&sort=i.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $profile_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/provideo', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($profile_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($profile_total - $this->config->get('config_limit_admin'))) ? $profile_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $profile_total, ceil($profile_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/provideo_list', $data));
	}

	protected function getForm() {
		$this->load->model('tool/image');
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['profile_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_bottom'] = $this->language->get('entry_bottom');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_author'] = $this->language->get('entry_author');
		$data['entry_video'] = $this->language->get('entry_video');

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_bottom'] = $this->language->get('help_bottom');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_design'] = $this->language->get('tab_design');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}
		// 视频
		if(isset($this->request->post['product_id']) && !empty($this->request->post['product_id'])){
            $data['product_name'] = $this->request->post['product_name'];
            $data['product_id'] = $this->request->post['product_id'];
        }
        elseif(isset($this->request->get['gallery_id'])){

            $data['product_name'] = $gallery_info['product_name'];
            $data['product_id'] = $gallery_info['product_id'];
        }
        else{
            $data['product_name'] = '';
            $data['product_id'] = '';
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
			'href' => $this->url->link('catalog/provideo', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['profile_id'])) {
			$data['action'] = $this->url->link('catalog/provideo/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/provideo/edit', 'token=' . $this->session->data['token'] . '&profile_id=' . $this->request->get['profile_id'] . $url, true);
		}
		
		if (isset($this->request->get['profile_id'])) {
			$data['profile_id'] = $this->request->get['profile_id'];
		} else {
			$data['profile_id'] = '';
		}

		$data['cancel'] = $this->url->link('catalog/provideo', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['profile_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$profile_info = $this->model_catalog_profile_video->getProfile($this->request->get['profile_id']);
		}
		// var_dump($profile_info);exit();
		
		$data['parents'] = $this->model_catalog_profile_video->getParents();

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['profile_description'])) {
			$data['profile_description'] = $this->request->post['profile_description'];
		} elseif (isset($this->request->get['profile_id'])) {
			$data['profile_description'] = $this->model_catalog_profile_video->getProfileDescriptions($this->request->get['profile_id']);
		} else {
			$data['profile_description'] = array();
		}
   //print_r($data['profile_description']);exit();
		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['profile_store'])) {
			$data['profile_store'] = $this->request->post['profile_store'];
		} elseif (isset($this->request->get['profile_id'])) {
			$data['profile_store'] = $this->model_catalog_profile_video->getProfileStores($this->request->get['profile_id']);
		} else {
			$data['profile_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($profile_info)) {
			$data['keyword'] = $profile_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if(isset($this->request->post['parent_id'])){
			$data['parent_id'] = $this->request->post['parent_id'];
		}elseif (!empty($profile_info)){
			$data['parent_id'] = $profile_info['parent_id'];
		}else{
			$data['parent_id'] = '';
		}

		if (isset($this->request->post['bottom'])) {
			$data['bottom'] = $this->request->post['bottom'];
		} elseif (!empty($profile_info)) {
			$data['bottom'] = $profile_info['bottom'];
		} else {
			$data['bottom'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($profile_info)) {
			$data['status'] = $profile_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($profile_info)) {
			$data['sort_order'] = $profile_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		// 视频
		$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
		if(isset($this->request->post['video'])){
            $data['video'] =$http_type . $_SERVER['HTTP_HOST'].'/image/'. $this->request->post['video'];
        }
        elseif(isset($this->request->get['gallery_id'])){
            $data['video'] =$http_type . $_SERVER['HTTP_HOST'].'/image/'. $gallery_info['video'];
        }
        else{
            $data['video'] = '';
        }
// 结束
		if (isset($this->request->post['profile_layout'])) {
			$data['profile_layout'] = $this->request->post['profile_layout'];
		} elseif (isset($this->request->get['profile_id'])) {
			$data['profile_layout'] = $this->model_catalog_profile_video->getProfileLayouts($this->request->get['profile_id']);
		} else {
			$data['profile_layout'] = array();
		}

		$this->load->model('design/layout');
		//image
        if(isset($this->request->post['image'])){
            $data['image'] = $this->request->post['image'];
        }
        elseif(isset($this->request->get['profile_id'])&&$profile_info['image']){
            $data['image'] = $profile_info['image'];
        }
        else{
            $data['image'] = 'no_image.png';
        }
 // var_dump( $profile_info );exit();
        $data['club_image'] = $this->model_tool_image->resize($data['image'], 100, 100);
//images
        if(isset($this->request->post['images'])){
            $data['images'] = $this->request->post['images'];
        }
        elseif(isset($this->request->get['profile_id'])&&$profile_info['images']){
            $data['images'] = $profile_info['images'];
        }
        else{
            $data['images'] = 'no_image.png';
        }
 // var_dump( $profile_info );exit();
        $data['club_images'] = $this->model_tool_image->resize($data['images'], 100, 100);
        if (isset($this->request->post['author'])) {
			$data['author'] = $this->request->post['author'];
		} elseif (!empty($profile_info)) {
			$data['author'] = $profile_info['author'];
		} else {
			$data['author'] = '';
		}
		//var_dump( $data['author']);exit();
        //$data['author']=$data['author'];
        //$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/provideo_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/provideo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['profile_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}

		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['profile_id']) && $url_alias_info['query'] != 'profile_id=' . $this->request->get['profile_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['profile_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/provideo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('setting/store');

		foreach ($this->request->post['selected'] as $profile_id) {
			if ($this->config->get('config_account_id') == $profile_id) {
				$this->error['warning'] = $this->language->get('error_account');
			}

			if ($this->config->get('config_checkout_id') == $profile_id) {
				$this->error['warning'] = $this->language->get('error_checkout');
			}

			if ($this->config->get('config_affiliate_id') == $profile_id) {
				$this->error['warning'] = $this->language->get('error_affiliate');
			}

			if ($this->config->get('config_return_id') == $profile_id) {
				$this->error['warning'] = $this->language->get('error_return');
			}

			$store_total =$this->model_catalog_profile_video->deleteProfile($profile_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
			}
		}

		return !$this->error;
	}
	// 新增
    //  视频开始
    public function deleteVideo(){
        $this->load->language('catalog/product');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/product');
       // var_dump($this->request->get['product_id']);
      
        if(isset($this->request->get['product_id'])){
              unlink('/image/'.$this->request->get['video']); 
        $this->model_catalog_product->deleteVideo($this->request->get['product_id']);
        }else{
              unlink($this->request->get['video']);
        }
        $this->response->setOutput(json_encode('1'));
    }

    public function editVideo(){
//        $files = [];
//        $files = $this->request->post;
//        $file = $files['files'];
//        $this->response->setOutput(json_encode([1,2]));die;


        $this->load->language('catalog/product');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product');

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
//            var_dump($_FILES['files']);

            $file = $_FILES['files'];
//            move_uploaded_file($file['tmp_name'],'upload/preview/'.$file['name']);
//formData传过来的参数param1和param2
//            $param1 = $files['param1'];
//            $param2 = $files['param2'];
//ajax返回数组
            $data = array('sta'=>TRUE,'msg'=>'上传成功！');
//检查是否为图片
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

            $arrExt = array('3gp','rmvb','flv','wmv','avi','mkv','mp4','mp3','wav');
            if(!in_array($ext,$arrExt)) {
                $data['sta'] = FALSE;
                $data['msg'] = '不支持此类型文件的上传！';
            }else{
                $previewPath = DIR_IMAGE.'video/';
                $arr = explode('/',$previewPath);
                $dirAll = '';
                $result = FALSE;
                if(count($arr) > 0) {
                    foreach($arr as $key=>$value) {
                        $tmp = trim($value);
                        if($tmp != '') {
                            $dirAll .= $tmp.'/';
                            if(!file_exists($dirAll)) {
                                mkdir($dirAll,0777,true);
                            }
                        }
                    }
                }

                if($file['error'] == 0) {
//                if(isset($param1) && isset($param2)) {
                    //需要用到$param1和$param2的一些其他操作...

                    //文件上传到预览目录
                    if(isset($this->request->get['product_id'])){
                    $previewName = 'pre_'.$this->request->get['product_id'].'.'.$ext;
                    }elseif(isset($this->request->get['hairclub'])){
                         $previewName = 'hairclub/pre_'.rand(1000,9000).'.'.$ext;
                    }else{
                         $previewName = 'home/pre_'.rand(1000,9000).'.'.$ext;
                    }
                    $previewSrc = 'video/'.$previewName;
                    if(!move_uploaded_file($file['tmp_name'],DIR_IMAGE.$previewSrc)) {
                        $data['sta'] = FALSE;
                        $data['msg'] = '上传失败！';
                    } else {
                        if(isset($this->request->get['product_id'])){
                        $this->model_catalog_product->editVideo($this->request->get['product_id'],$previewSrc);
                        }
                        $data['previewSrc'] = '/image/'.$previewSrc;
                    }

//                }
                }
            }
            $this->response->setOutput(json_encode($data));
        }
    }
    // 新增 视频end
}