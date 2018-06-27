<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		// Analytics
		$this->load->model('extension/extension');

		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get($analytic['code'] . '_status'));
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] =  $this->model_account_wishlist->getTotalWishlist();
		} else {
			$data['text_wishlist'] =  (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0);
		}

		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/dashboard', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home');
		$data['root_home'] = HTTP_SERVER;               //网站图标的链接
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/dashboard', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');
		$data['login_li'] = $this->url->link('account/account', '', true);
		$data['search_url'] = $this->url->link('product/search');
			// print_r($_SERVER['REQUEST_URI']);exit();
     	$data['navs']=$this->get_navs();
     	$data['is_home']=$_SERVER['REQUEST_URI'];
     	// print_r(	$data['is_home']);exit();
		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['language'] = $this->load->controller('common/language'); //语言
		$data['currency'] = $this->load->controller('common/currency'); //货币
		// print_r($data['currency']);exit();
		$data['search'] = $this->load->controller('common/search'); //搜索
		// print_r($data['search']);exit();
	
//		$data['cart'] = $this->load->controller('common/cart'); //购物车
        $data['cart_product_quantity'] = $this->cart->countProducts(); //购物车商品总数量

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} elseif (isset($this->request->get['information_id'])) {
				$class = '-' . $this->request->get['information_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

        $data['contact_us_url'] = $this->url->link('information/contact');
		//购物车数量
		$data['text_cart_items'] = $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0);
		//dyl,end
		// print_r($this->config);exit();
	$data['whatappphone'] = $this->config->get('config_telephone'); //电话
		$data['email'] = $this->cart->customer->getEmail();
		$data['link_account'] = $this->url->link('account/dashboard');
		$data['link_logout'] = $this->url->link('account/logout');

		return $this->load->view('common/header', $data);
	}

	// $nav['this_page']是便是导航是这一页
	// 获取导航
	protected function get_navs()
	{
		// print_r($_SERVER);exit();
		$res=array();
		$this->load->model('common/nav');
		$navs=$this->model_common_nav->getFiristNavs();
		foreach ($navs as $key => $value) {
			$childs=array();
			$child=$this->model_common_nav->getChildNavs($value['nav_id']);
			foreach ($child as $k => $val) {
				$childs[]=$this->handleNav($val);
			}
			$nav=$this->handleNav($value);
			if ($this->is_thispage($nav)) {
				$nav['this_page']=true;
			}else{$nav['this_page']=false;}
			$res[$key]=$nav;
			$res[$key]['child']=$childs;
		}

		return $res;
	}
	//判断导航是否当前页面
	protected function is_thispage($nav){
	
		if(strstr($nav['url'], 'http')){
			if ($_SERVER['HTTPS']) {
				$this_url='https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				
			}else{
				$this_url='http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
			}
			$this_url= str_replace("&","&amp;",$this_url);
		
			
		}else{
			$this_url= substr($_SERVER['REQUEST_URI'],1);

		}
		// print_r($this_url);exit();
		if ($nav['url']==$this_url) {
				return true;
		}else{
				return false;
		}
		
	}
	//获取导航链接
	protected function handleNav($nav){
		$res=array(
			'name'=>$nav['name'],
			'nav_id'=>$nav['nav_id'],
			'is_target'=>$nav['is_target'],
		);
		if ($nav['type']=='product_id') {
			$res['url']=$this->url->link('product/product', 'product_id=' . $nav['inside_id']);
		}elseif ($nav['type']=='category_id') {
			$category_path=$this->get_category_path($nav['inside_id']);
			$res['url']=$this->url->link('product/category', 'path=' .$category_path);
		}elseif ($nav['type']=='information_id') {
			$res['url']=$this->url->link('information/information', 'information_id=' . $nav['inside_id']);
		}elseif ($nav['type']=='profile_id') {
			$res['url']=$this->url->link('information/company/index', 'profile_id=' . $nav['inside_id']);
		}else{
			if (strstr($nav['url'], 'http')) {
				$res['url']=$nav['url'];
			}elseif ($this->config->get('config_seo_url')) {
				$res['url']=$nav['seo_url'];
			}else{
				$res['url']=$nav['url'];
			}
		}

		return $res;
	}
	//获取分类链接
	protected function get_category_path($category_id)
	{
		$this->load->model('catalog/category');

		$category_info = $this->model_catalog_category->getCategory($category_id);
		if ($category_info['parent_id']==0) {
			return $category_info['category_id'];
		}else{
			$path=$this->get_category_path($category_info['parent_id']);
			return $path."_".$category_id;
		}
	}
}