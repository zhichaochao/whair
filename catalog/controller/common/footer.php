<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['scripts'] = $this->document->getScripts('footer');

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		////底部文字
        $data['yd_Call'] = $this->language->get('yd_Call');
        $data['yd_Whatsapp'] = $this->language->get('yd_Whatsapp');
        $data['yd_Email'] = $this->language->get('yd_Email');
        $data['yd_Address'] = $this->language->get('yd_Address');
        $data['yd_Addcont'] = $this->language->get('yd_Addcont');
		// $data['navs']=$this->is_thispage();
	    
		$data['informations'] = array(
			0 =>array(
				'title'=>'INFORMATION',
				'child'=>array(
						0=>array(
							'title'=>'About Us',
							'url'=>$this->url->link('information/company'),
							),
						1=>array(
							'title'=>'After Sale Service',
							'url'=>$this->url->link('information/information','information_id=2'),
							),
						2=>array(
							'title'=>'Terms & Conditions',
							'url'=>$this->url->link('information/information','information_id=5'),

							),
						3=>array(
							'title'=>'Hair Club',
							'url'=>$this->url->link('information/profile'),
							),


					),
				),
			1=>array(
				'title'=>'BUYER INSTRUCTION',
				'child'=>array(
						0=>array(
							'title'=>'How To Order',
						'url'=>$this->url->link('information/information','information_id=1'),
							),
						1=>array(
							'title'=>'FAQ',
							'url'=>$this->url->link('information/information','information_id=9'),
							),
						2=>array(
							'title'=>'Delivery Time&Bank Infor',
							'url'=>$this->url->link('information/information','information_id=3'),

							),
						3=>array(
							'title'=>'Return Policy',
							'url'=>$this->url->link('information/information','information_id=4'),
							),


					),
				),
			2=>array(
				'title'=>'MY ACCOUNT',
				'child'=>array(
						0=>array(
							'title'=>'My Account',
							'url'=>$this->url->link('account/account'),
							),
						1=>array(
							'title'=>'My Order',
							'url'=>$this->url->link('account/order'),
							),
						2=>array(
							'title'=>'My Wish List',
							'url'=>$this->url->link('account/wishlist'),

							),
						3=>array(
							'title'=>'Site Map',
							'url'=>$this->url->link('information/sitemap'),
							),


					),


				),

		 );
		$data['home'] = $this->url->link('common/home', '', true);
		$data['cart'] = $this->url->link('checkout/cart', '', true);
		$data['account_left'] = $this->url->link('account/inquiry', '', true);
		$data['contac'] = $this->url->link('product/allcategory', '', true);

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/account', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['vip'] = $this->url->link('account/vip', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));
		
		//$data['action'] = $this->url->link('account/login', '', true);
		//$data['forgotten'] = $this->url->link('account/forgotten', '', true);
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_password'] = $this->language->get('entry_password');

		// $data['action'] = $this->url->link('account/login', '', true);
		// //$data['register'] = $this->url->link('account/register', '', true);
		// $data['register'] = $this->url->link('account/login/register_save', '', true);
		// $data['forgotten'] = $this->url->link('account/forgotten', '', true);
        //同意条款的内容链接 dyl add
		$data['agree_url'] = $this->url->link('information/information/agree', 'information_id=' . $this->config->get('config_checkout_id'), true);
		//底部wholesales的链接 dyl add
        $data['service_wholesales'] = $this->url->link('information/service/wholesales');

        $data['text_cart_items'] = $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0);

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}
		// print_r($_SERVER);
		$data['thispage']=$_SERVER['QUERY_STRING'].$_SERVER['REQUEST_URI'];
		$data['sername']=$_SERVER['REQUEST_URI'];
		$data['email'] = $this->config->get('config_email');
		$data['telephone'] = $this->config->get('config_telephone');
		$data['whatsapp'] = $this->config->get('config_whatsapp');
		$data['skype'] = $this->config->get('config_skype');
		$data['facebook'] = $this->config->get('config_facebook');
		$data['instagram'] = $this->config->get('config_instagram');

		$data['chat_code'] = $this->config->get('config_code');

		return $this->load->view('common/footer', $data);
	}
}
