<?php
class ControllerCatalogNav extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/nav');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/nav');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/nav');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/nav');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			if(isset($this->request->post['is_target'])){$this->request->post['is_target']=1;}else{$this->request->post['is_target']=0;}
			if ($this->request->post['type']=='especially'&&$this->request->post['inside_id']!='0') {
				$tem=$this->get_especially_nav($this->request->post['inside_id']);
				$this->request->post['seo_url']=$tem['seo_url'];
				$this->request->post['url']=$tem['url'];
			}
			// print_r($this->request->post);exit();
			$this->model_catalog_nav->addNav($this->request->post);

			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$done="addNav:".$this->request->post['nav_description'][1]['name'];
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

			$this->response->redirect($this->url->link('catalog/nav', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/nav');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/nav');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			// print_r($this->request->post);exit();
			if(isset($this->request->post['is_target'])){$this->request->post['is_target']=1;}else{$this->request->post['is_target']=0;}
			if ($this->request->post['type']=='especially'&&$this->request->post['inside_id']!='0') {
				// $tem=$this->get_especially_nav($this->request->post['inside_id']);
				// print_r($this->request->post['inside_id']);exit();
				$this->request->post['url']=$this->request->post['inside_id'];
			}
			$this->model_catalog_nav->editNav($this->request->get['nav_id'], $this->request->post);

			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$done="editNav:ID=".$this->request->get['nav_id']; 
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

			$this->response->redirect($this->url->link('catalog/nav', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/nav');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/nav');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $nav_id) {
				$result['name'][]=$this->model_catalog_nav->getNavDescriptions($nav_id);
				$this->model_catalog_nav->deleteNav($nav_id);
			}

			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$name='';
            foreach($result['name'] as $value){
            	$name.='ID='.$value[1]['nav_id'].',name='.$value[1]['name'].';';
            }
			$done="deleteNav:".substr($name, 0, -1);
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

			$this->response->redirect($this->url->link('catalog/nav', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'od.name';
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
			'href' => $this->url->link('catalog/nav', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/nav/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/nav/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['navs'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$nav_total = $this->model_catalog_nav->getTotalNavs();

		$results = $this->model_catalog_nav->getNavs($filter_data);
		// print_r($results);exit();

		foreach ($results as $result) {
			$data['navs'][] = array(
				'nav_id'  => $result['nav_id'],
				'name'       => $result['name'],
				'parent'	=>$this->getparentnav($result['parent_id']),
				'sort_order' => $result['sort_order'],
				'edit'       => $this->url->link('catalog/nav/edit', 'token=' . $this->session->data['token'] . '&nav_id=' . $result['nav_id'] . $url, true)
			);
		}
		// print_r($data['navs']);exit();

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
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

		$data['sort_name'] = $this->url->link('catalog/nav', 'token=' . $this->session->data['token'] . '&sort=od.name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/nav', 'token=' . $this->session->data['token'] . '&sort=o.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $nav_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/nav', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($nav_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($nav_total - $this->config->get('config_limit_admin'))) ? $nav_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $nav_total, ceil($nav_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/nav_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['nav_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_choose'] = $this->language->get('text_choose');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_radio'] = $this->language->get('text_radio');
		$data['text_checkbox'] = $this->language->get('text_checkbox');
		$data['text_input'] = $this->language->get('text_input');
		$data['text_text'] = $this->language->get('text_text');
		$data['text_textarea'] = $this->language->get('text_textarea');
		$data['text_file'] = $this->language->get('text_file');
		$data['text_date'] = $this->language->get('text_date');
		$data['text_datetime'] = $this->language->get('text_datetime');
		$data['text_time'] = $this->language->get('text_time');
		$data['text_choose_url'] = $this->language->get('text_choose_url');
		$data['text_frist_nav'] = $this->language->get('text_frist_nav');
		$data['text_classify'] = $this->language->get('text_classify');
		$data['text_especially'] = $this->language->get('text_especially');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_profile'] = $this->language->get('text_profile');
		$data['text_information'] = $this->language->get('text_information');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_above'] = $this->language->get('text_above');
		$data['text_drop_down'] = $this->language->get('text_drop_down');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_type'] = $this->language->get('entry_type');
		$data['entry_nav_value'] = $this->language->get('entry_nav_value');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_url'] = $this->language->get('entry_url');
		$data['entry_seo_url'] = $this->language->get('entry_seo_url');
		$data['entry_is_target'] = $this->language->get('entry_is_target');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_nav_value_add'] = $this->language->get('button_nav_value_add');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
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
			'href' => $this->url->link('catalog/nav', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['nav_id'])) {
			$data['action'] = $this->url->link('catalog/nav/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/nav/edit', 'token=' . $this->session->data['token'] . '&nav_id=' . $this->request->get['nav_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/nav', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['nav_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$nav_info = $this->model_catalog_nav->getNav($this->request->get['nav_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['nav_description'])) {
			$data['nav_description'] = $this->request->post['nav_description'];
		} elseif (isset($this->request->get['nav_id'])) {
			$data['nav_description'] = $this->model_catalog_nav->getNavDescriptions($this->request->get['nav_id']);
		} else {
			$data['nav_description'] = array();
		}

		if (isset($this->request->post['url'])) {
			$data['url'] = $this->request->post['url'];
		} elseif (!empty($nav_info)) {
			$data['url'] = $nav_info['url'];
		} else {
			$data['url'] = '';
		}
		if (isset($this->request->get['nav_id'])) {
			$data['nav_id'] = $this->request->get['nav_id'];
		} elseif (!empty($nav_info)) {
			$data['nav_id'] = $nav_info['nav_id'];
		} else {
			$data['nav_id'] = 0;
		}
		if (isset($this->request->post['seo_url'])) {
			$data['seo_url'] = $this->request->post['seo_url'];
		} elseif (!empty($nav_info)) {
			$data['seo_url'] = $nav_info['seo_url'];
		} else {
			$data['seo_url'] = '';
		}
		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($nav_info)) {
			$data['type'] = $nav_info['type'];
		} else {
			$data['type'] = '';
		}
		if (isset($this->request->post['is_target'])) {
			$data['is_target'] = $this->request->post['is_target'];
		} elseif (!empty($nav_info)) {
			$data['is_target'] = $nav_info['is_target'];
		} else {
			$data['is_target'] = 0;
		}
		if (isset($this->request->post['inside_id'])) {
			$data['inside_id'] = $this->request->post['inside_id'];
		} elseif (!empty($nav_info)) {
			if ($data['type']=='especially') {
				$data['inside_id']=$nav_info['url'];
			}else{
			$data['inside_id'] = $nav_info['inside_id'];
			}
		} else {
			$data['inside_id'] = 0;
		}
		// print_r($data);exit();
		if (isset($this->request->post['parent_id'])) {
			$data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($nav_info)) {
			$data['parent_id'] = $nav_info['parent_id'];
		} else {
			$data['parent_id'] = 0;
		}
	

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($nav_info)) {
			$data['sort_order'] = $nav_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

	

		$data['frist_navs']=$this->model_catalog_nav->getFiristNavs();
		// print_r(	$data['frist_navs']);exit();
		$data['getnavsbytype']= 'index.php?route=catalog/nav/getnavsbytype&'.'token=' . $this->session->data['token'] ;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/nav_form', $data));
	}


	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/nav')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['nav_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 128)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

	

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/nav')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('catalog/nav');

		foreach ($this->request->post['selected'] as $nav_id) {
			$product_total = $this->model_catalog_nav->getChildNavs($nav_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_nav'), $product_total);
			}
		}

		return !$this->error;
	}
	protected function getparentnav($parent_id)
	{
		$this->load->model('catalog/nav');
		if ($parent_id==0) {
			$result= '';
		}else{
			$parent_nav=$this->model_catalog_nav->getNav($parent_id);
			$result=$parent_nav['name'];
		}
		return $result;
	}

	public function getnavsbytype() {
		$json ='';
		$this->load->language('catalog/nav');

		$type=$this->request->post['type'];
		$inside_id=$this->request->post['inside_id'];
		if ($type=='especially'||$type=='category_id'||$type=='category_id'||$type=='profile_id'||$type=='information_id'||$type=='product_id') {
		
			$funtion_name="get_".$type."_navs";
			$json=$this->$funtion_name($inside_id);

		}else{
			$json="<option value='0'>". $this->language->get('text_especially').$this->language->get('text_above')."</option>";
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	protected function especiallynavs(){
		$res=array();
		$res[]= array('name' =>'All Hair Collections' ,'url'=>'product/category');
		$res[]= array('name' =>'Promotion' ,'url'=>'information/promotion');
		$res[]= array('name' =>'Hair Club' ,'url'=>'information/profile');
		$res[]= array('name' =>'Company Profile' ,'url'=>'information/company');
		return $res;

	}
	protected function get_especially_nav($seo_url){
		// print_r($seo_url);exit();
		$res=array();
			$navs=$this->especiallynavs();
			foreach ($navs as $key => $value) {
				if($value['url']==$seo_url){
					$res=$value;
				}
			}
			return $value;

	}

	protected function get_especially_navs($inside_id)
	{
		$res='';
		// $res.="<option value='0'>". $this->language->get('text_especially').$this->language->get('text_above')."</option>";
		$navs=$this->especiallynavs();
		foreach ($navs as $key => $value) {
			if($inside_id==$value['url']){
				$res.="<option selected value='".$value['url']."'>".$value['name']."</option>";
			}else{
			$res.="<option value='".$value['url']."'>".$value['name']."</option>";
			}
		}
		return $res;
		
	}
	protected function get_category_id_navs($inside_id)
	{
		$res='';
		$this->load->model('catalog/category');
		$navs=$this->model_catalog_category->getCategories();
		foreach ($navs as $key => $value) {
			if($value['category_id']>0){
				if($inside_id==$value['category_id']){
					$res.="<option selected value='".$value['category_id']."'>".$value['name']."</option>";
				}else{
					$res.="<option value='".$value['category_id']."'>".$value['name']."</option>";
				}
			}
		}
		return $res;
		
	}
	protected function get_profile_id_navs($inside_id)
	{
		$res='';
		$this->load->model('catalog/profile');
		$navs=$this->model_catalog_profile->getProfiles();
		foreach ($navs as $key => $value) {
				if($inside_id==$value['profile_id']){
					$res.="<option selected value='".$value['profile_id']."'>".$value['title']."</option>";
				}else{

					$res.="<option value='".$value['profile_id']."'>".$value['title']."</option>";
				}
		}
		return $res;
		
	}
	protected function get_information_id_navs($inside_id)
	{
		$res='';
		$this->load->model('catalog/information');
		$navs=$this->model_catalog_information->getInformations();
		foreach ($navs as $key => $value) {
			if($inside_id==$value['information_id']){
				$res.="<option selected value='".$value['information_id']."'>".$value['title']."</option>";
			}else{
			$res.="<option value='".$value['information_id']."'>".$value['title']."</option>";
			}
		}
		return $res;
		
	}
	protected function get_product_id_navs($inside_id)
	{
		$res='';
		$this->load->model('catalog/product');
		$navs=$this->model_catalog_product->getProducts();
		foreach ($navs as $key => $value) {
			if($inside_id==$value['product_id']){
				$res.="<option selected value='".$value['product_id']."'>".$value['name']."</option>";
			}else{
			$res.="<option value='".$value['product_id']."'>".$value['name']."</option>";
			}
		}
		return $res;
		
	}
}