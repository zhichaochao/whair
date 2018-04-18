<?php
class ControllerInformationContact extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('information/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

           $this->load->model('setting/feedback');
                        
           $contact_data['name'] = trim($this->request->post['name']);
           $contact_data['email'] = trim($this->request->post['email']);
           $contact_data['fixed_line'] = trim($this->request->post['fixed_line']);
           $contact_data['country_id'] = $this->request->post['country_id'];
           $contact_data['phone'] = trim($this->request->post['phone']);

           $factime = trim($this->request->post['phone']);
           $whatsapp = trim($this->request->post['whatsapp']);
           $enquiry = trim($this->request->post['enquiry']);
           $str_enquiry = 'Factime&iMesssage ID:' . $factime . "<br>Whtsapp ID:" . $whatsapp . "<br>Comment:" . $enquiry;

           $contact_data['enquiry'] = $str_enquiry;
               
           $result = $this->model_setting_feedback->addFeedback($contact_data);
           if($result){
              $this->session->data['success'] = 'We have received your message, thank you for your advice';

              /* //发送邮件
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
              $country_result = $this->model_localisation_country->getCountry($this->request->post['country_id']);

              $html_data['from_name'] = trim($this->request->post['name']);
              $html_data['email'] = trim($this->request->post['email']);
              $html_data['tel_number'] = trim($this->request->post['fixed_line']);
              $html_data['country_name'] = $country_result['name'];
              $html_data['business_name'] = trim($this->request->post['name']);
              $html_data['ip_address'] = $this->request->server['REMOTE_ADDR'];
              $html_data['send_page'] = $QUERY_STRING[1];
                           
              $factime = trim($this->request->post['phone']);
              $whatsapp = trim($this->request->post['whatsapp']);

              $html_data['factime'] = $factime;
              $html_data['whatsapp'] = $whatsapp;
              
              $html_data['content'] = trim($this->request->post['enquiry']); */
              
              //将邮件发送信息写入session
              $this->session->data['email_message']['name'] = isset($this->request->post['name']) ? $this->request->post['name'] : '';
              $this->session->data['email_message']['email'] = isset($this->request->post['email']) ? $this->request->post['email'] : '';
              $this->session->data['email_message']['fixed_line'] = isset($this->request->post['fixed_line']) ? $this->request->post['fixed_line'] : '';
              $this->session->data['email_message']['country_id'] = isset($this->request->post['country_id']) ? $this->request->post['country_id'] : '';
              $this->session->data['email_message']['whatsapp'] = isset($this->request->post['whatsapp']) ? $this->request->post['whatsapp'] : '';
              $this->session->data['email_message']['content'] = isset($this->request->post['enquiry']) ? $this->request->post['enquiry'] : '';
              $this->session->data['email_message']['phone'] = isset($this->request->post['phone']) ? $this->request->post['phone'] : '';
              $this->session->data['email_message']['send_page'] = isset($this->request->get['route']) ? $this->request->get['route'] : "";
              
              /* $reply_to = trim($this->request->post['email']);

              $mail = new Mail();
              $mail->protocol = $this->config->get('config_mail_protocol');
              $mail->parameter = $this->config->get('config_mail_parameter');
              $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
              $mail->smtp_username = $this->config->get('config_mail_smtp_username');
              $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
              $mail->smtp_port = $this->config->get('config_mail_smtp_port');
              $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

              $mail->setTo($this->config->get('config_email'));   //发给系统管理员的邮箱(接收人邮箱)
              $mail->setFrom($this->config->get('config_mail_parameter'));      //发送人
              $mail->setSender(html_entity_decode(trim($this->request->post['name']), ENT_QUOTES, 'UTF-8'));    //发送者名字
              //$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
              $mail->setSubject('Hot Beauty Hair Contact Us Inquiry');
              $mail->setReplyTo($reply_to);
              $mail->setHtml($this->load->view('mail/contact_us_email',$html_data));  //邮件标题
              //$mail->setText($message);
              $mail->send(); */
                           
              $this->response->redirect('/information-company-success/');
                           

            }else{
              $this->session->data['error'] = 'Submit your proposal to failure.';
            }

		    //$this->response->redirect($this->url->link('information/contact/success'));

			//跳转回本页
			$this->response->redirect($this->url->link('information/contact'));
		}

		/*$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);*/

		//$data['heading_title'] = $this->language->get('heading_title');

		//$data['text_location'] = $this->language->get('text_location');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_open'] = $this->language->get('text_open');
		$data['text_comment'] = $this->language->get('text_comment');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_fixed_line'] = 'Tel Number';
		$data['entry_country'] = 'Country';
		$data['entry_phone'] = 'Whatsapp/FaceTime ID or Mobile Phone No.';
		$data['entry_enquiry'] = 'Comment';

		$data['button_map'] = $this->language->get('button_map');

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

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

		$data['button_submit'] = $this->language->get('button_submit');

		$data['action'] = $this->url->link('information/contact', '', true);

		$this->load->model('tool/image');
		if ($this->config->get('config_image')) {
			$data['image'] = $this->model_tool_image->resize($this->config->get('config_image'), $this->config->get($this->config->get('config_theme') . '_image_location_width'), $this->config->get($this->config->get('config_theme') . '_image_location_height'));
		} else {
			$data['image'] = false;
		}

		$data['store'] = $this->config->get('config_name');
		$data['address'] = nl2br($this->config->get('config_address'));
		$data['geocode'] = $this->config->get('config_geocode');
		$data['geocode_hl'] = $this->config->get('config_language');
		$data['telephone'] = $this->config->get('config_telephone');
		$data['fax'] = $this->config->get('config_fax');
		$data['open'] = nl2br($this->config->get('config_open'));
		$data['comment'] = $this->config->get('config_comment');

		//地区数据  dyl add
		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();

		$data['locations'] = array();
		$this->load->model('localisation/location');
		foreach((array)$this->config->get('config_location') as $location_id) {
			$location_info = $this->model_localisation_location->getLocation($location_id);

			if ($location_info) {
				if ($location_info['image']) {
					$image = $this->model_tool_image->resize($location_info['image'], $this->config->get($this->config->get('config_theme') . '_image_location_width'), $this->config->get($this->config->get('config_theme') . '_image_location_height'));
				} else {
					$image = false;
				}

				$data['locations'][] = array(
					'location_id' => $location_info['location_id'],
					'name'        => $location_info['name'],
					'address'     => nl2br($location_info['address']),
					'geocode'     => $location_info['geocode'],
					'telephone'   => $location_info['telephone'],
					'fax'         => $location_info['fax'],
					'image'       => $image,
					'open'        => nl2br($location_info['open']),
					'comment'     => $location_info['comment']
				);
			}
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} else {
			$data['name'] = $this->customer->getFirstName().' '.$this->customer->getLastName();
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = $this->customer->getEmail();
		}

		if (isset($this->request->post['fixed_line'])) {
			$data['fixed_line'] = $this->request->post['fixed_line'];
		} else {
			$data['fixed_line'] = '';
		}

		if (isset($this->request->post['phone'])) {
			$data['phone'] = $this->request->post['phone'];
		} else {
			$data['phone'] = '';
		}
                
                if (isset($this->request->post['whatsapp'])) {
			$data['whatsapp'] = $this->request->post['whatsapp'];
		} else {
			$data['whatsapp'] = '';
		}

		if (isset($this->request->post['enquiry'])) {
			$data['enquiry'] = $this->request->post['enquiry'];
		} else {
			$data['enquiry'] = '';
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
			$data['captcha'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('information/contact', $data));
	}

	protected function validate() {
		if ((utf8_strlen(trim($this->request->post['name'])) < 3) || (utf8_strlen(trim($this->request->post['name'])) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!filter_var(trim($this->request->post['email']), FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen(trim($this->request->post['enquiry'])) < 10) || (utf8_strlen(trim($this->request->post['enquiry'])) > 3000)) {
			//$this->error['enquiry'] = $this->language->get('error_enquiry');
			$this->error['enquiry'] = 'Comment must be between 10 and 3000 characters!';
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['captcha'] = $captcha;
			}
		}

		return !$this->error;
	}


    //提交成功后的跳转页面(暂时不用)
	public function success() {
		$this->load->language('information/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_success');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/success', $data));
	}
}
