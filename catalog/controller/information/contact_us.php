<?php

/**
 * 信息页contact_us控制器
 * @author  dyl 783973660@qq.com 2016.10.6
 */
class ControllerInformationContactus extends Controller {
	private $error = array();

    /**
     * contact_us页面
     */
	public function index() {
            $croute = '';
            if($this->request->get['route']){
                $croute = $this->request->get['route'];
            }
            $data['croute'] = $croute;
            
        //获取url的网址参数
	    $QUERY_STRING = explode('=',$_SERVER['QUERY_STRING']);
		//$URL_STRING = $QUERY_STRING[1];

		/*if($this->config->get('config_seo_url')){             //有开启伪静态
           $URL_STRING = str_replace('-','/',$URL_STRING);    //将url转为/,给提交操作和跳转用
		}*/
		$data['url_string'] = $QUERY_STRING[1];
		$this->session->data['redirect_url'] = $QUERY_STRING[1];
		
		//写入session 确定用户发送邮件具体的联系我们页面
		$this->session->data['email_message']['contact_send_page'] = isset($this->request->get['route']) ? $this->request->get['route'] : "";
		
		//form表单提交
		

		$data['entry_name'] = 'Your Name';
		$data['entry_email'] = 'E-Mail Address';
		$data['entry_enquiry'] = 'Comment';

		//$data['button_map'] = $this->language->get('button_map');

		if (isset($this->error['error_name'])) {
			$data['error_name'] = $this->error['error_name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['error_email'])) {
			$data['error_email'] = $this->error['error_email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['error_enquiry'])) {
			$data['error_enquiry'] = $this->error['error_enquiry'];
		} else {
			$data['error_enquiry'] = '';
		}

        //成功提示
		

		$data['button_submit'] = 'Submit';
		//$data['action'] = $this->url->link($URL_STRING, '', true);
		$data['action'] = $this->url->link('information/contact_us/addContactusenquiry', '', true);

		//地区数据  dyl add
		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();

		

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
		//form表单提交,end

		return $this->load->view('information/contact_us', $data);
	}


	/**
     * 信息页联系我们询盘的提交操作(页面ajax异步提交到这里)
     * @author  dyl  78397360@qq.com  2016.10.19
     */
    public function addContactusenquiry(){
        $json = array(
            'code' => 0,
            'url' => '',
            'message' => '',
            'data' => ''
        );
      if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()){

          if( empty($this->error['error_name']) && empty($this->error['error_email']) && empty($this->error['error_enquiry']) ){

               $this->load->model('setting/feedback');

               $data['name'] = trim($this->request->post['name']);
               $data['email'] = trim($this->request->post['email']);
               $data['fixed_line'] = trim($this->request->post['fixed_line']);
               $data['country_id'] = $this->request->post['country_id'];
               $data['phone'] = trim($this->request->post['phone']);
               
               $factime = trim($this->request->post['phone']);
               $whatsapp = trim($this->request->post['whatsapp']);
               $enquiry = trim($this->request->post['enquiry']);
               $str_enquiry = 'Factime&iMesssage ID:' . $factime . "<br>Whtsapp ID:" . $whatsapp . "<br>Comment:" . $enquiry;
               
               $data['enquiry'] = $str_enquiry;
               $result = $this->model_setting_feedback->addFeedback($data);

                if($result){
                   $this->session->data['success'] = 'We have received your message, thank you for your advice!';
                }else{
                   $this->session->data['error'] = 'Submit your proposal to failure.';
                }
                
                //将表单提交数据写入session
                $this->session->data['email_message']['name'] = isset($this->request->post['name']) ? $this->request->post['name'] : '';
                $this->session->data['email_message']['email'] = isset($this->request->post['email']) ? $this->request->post['email'] : '';
                $this->session->data['email_message']['fixed_line'] = isset($this->request->post['fixed_line']) ? $this->request->post['fixed_line'] : '';
                $this->session->data['email_message']['country_id'] = isset($this->request->post['country_id']) ? $this->request->post['country_id'] : '';
                $this->session->data['email_message']['whatsapp'] = isset($this->request->post['whatsapp']) ? $this->request->post['whatsapp'] : '';
                $this->session->data['email_message']['content'] = isset($this->request->post['enquiry']) ? $this->request->post['enquiry'] : '';
                $this->session->data['email_message']['phone'] = isset($this->request->post['phone']) ? $this->request->post['phone'] : '';
                $this->session->data['email_message']['send_page'] = isset($this->request->get['route']) ? $this->request->get['route'] : "";
                
                //发送询盘
                //$this->sendEmail();

                unset($this->session->data['redirect_url']);
                $redirect_url = '/information-company-success/';
                $json['code'] = 1;
                $json['url'] = $redirect_url;
             }else{
                $data['error_name'] = $this->error['error_name'];
                $data['error_email'] = $this->error['error_email'];
                $data['error_enquiry'] = $this->error['error_enquiry'];
                $json['message'] = 'Submit your proposal to failure.';
                $json['data'] = $data;
             }

             $enquiryinfo = json_encode($json);
	     echo $enquiryinfo;
	   }

	}

    /**
     * 信息页联系我们询盘提交验证
     * @author  dyl  78397360@qq.com  2016.10.19
     */
	public function validate() {

	    $this->error['error_name'] = $this->error['error_email'] = $this->error['error_enquiry'] = '';

	    if ((utf8_strlen(trim($this->request->post['name'])) < 3) || (utf8_strlen(trim($this->request->post['name'])) > 32)) {
			$this->error['error_name'] = 'Name must be between 3 and 32 characters!';
		}

		if (!filter_var(trim($this->request->post['email']), FILTER_VALIDATE_EMAIL)) {
			$this->error['error_email'] = 'E-Mail Address does not appear to be valid!';
		}

		if ((utf8_strlen(trim($this->request->post['enquiry'])) < 10) || (utf8_strlen(trim($this->request->post['enquiry'])) > 3000)) {
			$this->error['error_enquiry'] = 'Comment must be between 10 and 3000 characters!';
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['error_captcha'] = $captcha;
			}
		}

        if( empty($this->error['error_name']) && empty($this->error['error_email']) && empty($this->error['error_enquiry']) ){
           return true;
        }else{
           return $this->error;
        }

	}

	/**
     * 信息页联系我们发送邮件(该方法不在使用)
     * @author  dyl 783973660@qq.com 2016.10.19
     */
	public function sendEmail(){

            if( !empty($this->request->post['name']) && !empty($this->request->post['email']) && !empty($this->request->post['enquiry']) ){

              //发送邮件
              $this->load->language('mail/customer');

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
              $html_data['send_page'] = $this->request->post['url_string'];
              
              $factime = trim($this->request->post['phone']);
              $whatsapp = trim($this->request->post['whatsapp']);
              $enquiry = trim($this->request->post['enquiry']);

              $html_data['factime'] = $factime;
              $html_data['whatsapp'] = $whatsapp;
              $html_data['content'] = $enquiry;
              
              $reply_to = trim($this->request->post['email']);
              
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
              $mail->setSender(html_entity_decode(trim($this->request->post['name']), ENT_QUOTES, 'UTF-8'));    //发送者名字
              //$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
              $mail->setSubject('Hot Beauty Hair Contact Us Inquiry');                                                //邮件标题
              $mail->setReplyTo($reply_to);
              $mail->setHtml($this->load->view('mail/contact_us_email',$html_data));
              //$mail->setText($message);
              $mail->send();
            }

	}

}


