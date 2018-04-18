<?php
class ControllerAccountDashboard extends Controller {

	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/dashboard', '', true);
			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->document->setTitle('Dashboard');

		//引入该页面的css样式
		$this->document->addStyle('catalog/view/theme/default/stylesheet/account/account_dashboard.css');

		$data['heading_title'] = 'Dashboard';

        //用户名
        $data['user_name'] = $this->customer->getFirstName().' '.$this->customer->getLastName();
        if($data['user_name'] == ' ') $data['user_name'] = $this->customer->getEmail();
		//feedback提交
		$data['action'] = $this->url->link('account/dashboard');

		$data['email'] = $this->config->get('config_email');
		$data['telephone'] = $this->config->get('config_telephone');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->load->model('setting/feedback');

            $customerResult = $this->model_setting_feedback->getCustomerData($this->customer->getId());

            $data['name'] = $data['user_name'];
            $data['email'] = $this->customer->getEmail();
            $data['fixed_line'] = $this->customer->getTelephone();
            $data['country_id'] = (!empty($customerResult['country_id'])) ? $customerResult['country_id'] : 0;
            $data['phone'] = $this->customer->getTelephone();
            $data['enquiry'] = $this->request->post['enquiry'];

            $result = $this->model_setting_feedback->addFeedback($data);
            if($result){
               $this->session->data['success'] = 'We have received your message, thank you for your advice';

               //发送邮件
               $this->load->language('mail/customer');

               //获取url的网址参数
	           $QUERY_STRING = explode('=',$_SERVER['QUERY_STRING']);

               //logo
               if ($this->request->server['HTTPS']) {
				   $server = $this->config->get('config_ssl');
			   } else {
				   $server = $this->config->get('config_url');
			   }
               if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			       $html_data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		       } else {
			       $html_data['logo'] = '';
		       }

		       $this->load->model('localisation/country');
		       $country_result = $this->model_localisation_country->getCountry($customerResult['country_id']);

               $html_data['from_name'] = $data['user_name'];
               $html_data['email'] = $this->customer->getEmail();
               $html_data['tel_number'] = $this->customer->getTelephone();
               $html_data['country_name'] = !empty($country_result['name']) ? $country_result['name'] : 'United States';
               $html_data['business_name'] = $data['user_name'];
               $html_data['ip_address'] = $this->request->server['REMOTE_ADDR'];
               $html_data['send_page'] = $QUERY_STRING[1];
               $html_data['content'] = trim($this->request->post['enquiry']);
               $html_data['factime'] = '';
               $html_data['whatsapp'] = '';

               /*$message  = $this->language->get('text_website') . ' ' . html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8') . "\n\n";
		       $message .= 'Full Name: ' . $data['user_name'] . "\n\n";
		       $message .= $this->language->get('text_email') . ' '  .  $this->customer->getEmail() . "\n\n";
		       $message .= 'Inquiry Content: '  .  $this->request->post['enquiry'] . "\n\n";*/

               $mail = new Mail();
               $mail->protocol = $this->config->get('config_mail_protocol');
               $mail->parameter = $this->config->get('config_mail_parameter');
               $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
               $mail->smtp_username = $this->config->get('config_mail_smtp_username');
               $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
               $mail->smtp_port = $this->config->get('config_mail_smtp_port');
               $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

               $mail->setTo($this->config->get('config_email'));                     //发给系统管理员的邮箱(接收人邮箱)
               $mail->setFrom($this->config->get('config_mail_parameter'));      //发送人
               $mail->setSender(html_entity_decode($data['user_name'], ENT_QUOTES, 'UTF-8'));    //发送者名字
               //$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
               $mail->setSubject('Hot Beauty Hair Contact Us Inquiry');                                                //邮件标题
               $mail->setHtml($this->load->view('mail/contact_us_email',$html_data));
               //$mail->setText($message);
               $mail->send();

            }else{
               $this->session->data['error'] = 'Submit your proposal to failure.';
            }
		}

		//feedback内容的错误提示
		if (isset($this->error['enquiry'])) {
			$data['error_enquiry'] = $this->error['enquiry'];
		} else {
			$data['error_enquiry'] = '';
		}

        //成功提示
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		//失败提示
		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}


        $this->load->model('catalog/product');
        $this->load->model('tool/image');

        //获取用户浏览次数最多的产品数据
        $cus_view_pro_res = $this->model_catalog_product->getAccountCustomerViewedProducts();
        $product_id_string = '';
        foreach ($cus_view_pro_res as $v) {
           $product_id_string .= $v['product_id'].',';
        }

        //如果用户浏览的产品,不足4个,则获取product表浏览次数最多的产品
        $proviewedresults = array();
		if(count($cus_view_pro_res) < 4){
           $product_id_string = mb_substr($product_id_string,0,-1,'utf-8');   //用户浏览过的产品ID
           $limit = 4 - count($cus_view_pro_res);
           $proviewedresults = $this->model_catalog_product->getAccountViewedProducts($product_id_string,$limit);
		}

        //合并两个数组
		$viewedresults = array_merge($cus_view_pro_res,$proviewedresults);
		$data['viewedproducts'] = array();
        foreach ($viewedresults as $viewedresult) {
			if ($viewedresult['image']) {
				$image = $this->model_tool_image->resize($viewedresult['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			}

			//颜色名称
			$color_name = '';
			if($viewedresult['color_id']!=0){
			   $color_data = $this->model_catalog_product->getOptionValueByID($viewedresult['color_id']);
			   if($color_data){
				  $color_arr = explode(':',$color_data['name']);
				  $color_name = $color_arr[0];
			   }
		    }

			$data['viewedproducts'][] = array(
				'product_id'  => $viewedresult['product_id'],
				'thumb'       => $image,
				'name'        => $viewedresult['name'],
				'max_name'	  => $viewedresult['name'],
				'name'        => utf8_substr(strip_tags($viewedresult['name']),0,40).'...',
				'color_name'  => $color_name,
				'href'        => $this->url->link('product/product', 'product_id=' . $viewedresult['product_id'])
			);
		}

        //获取产品的新品数据
        $results = $this->model_catalog_product->getAccountNewProducts();
        $data['products'] = array();
        foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
			}

			//颜色名称
			$color_name = '';
			if($result['color_id']!=0){
			   $color_data = $this->model_catalog_product->getOptionValueByID($result['color_id']);
			   if($color_data){
				  $color_arr = explode(':',$color_data['name']);
				  $color_name = $color_arr[0];
			   }
		    }

			$data['products'][] = array(
				'product_id'  => $result['product_id'],
				'thumb'       => $image,
				'name'        => $result['name'],
				'max_name'	  => $result['name'],
				'name'        => utf8_substr(strip_tags($result['name']),0,40).'...',
				'color_name'  => $color_name,
				'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
			);
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		//$data['column_right'] = $this->load->controller('common/column_right');
		$data['account_left'] = $this->load->controller('account/left');      //新左侧栏
		$data['content_top'] = $this->load->controller('common/content_top');
		//$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/dashboard', $data));
	}


	/**
	 * 验证form表单
	 * @author  dyl 783973660@qq.com 2016.9.26
	 */
	protected function validate() {

		if ((utf8_strlen(trim($this->request->post['enquiry'])) < 10) || (utf8_strlen(trim($this->request->post['enquiry'])) > 3000)) {
			//$this->error['enquiry'] = $this->language->get('error_enquiry');
			$this->error['enquiry'] = 'Comment must be between 10 and 3000 characters!';
		}

		return !$this->error;
	}

}