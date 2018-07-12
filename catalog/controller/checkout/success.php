<?php
class ControllerCheckoutSuccess extends Controller {
	public function index() {
            $this->load->language('checkout/success');

            $data['text_order'] = '';

            if (isset($this->session->data['order_id'])) {

                $this->cart->clear($this->request->get['cart_ids']);

                $order_id = $this->session->data['order_id'];

                $this->load->model('checkout/order');
                //订单商品销售数+1
                $this->model_checkout_order->addProductsSales($order_id);
                $order = $this->model_checkout_order->getOrder($this->session->data['order_id']);
                $shipping_fee_arr = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE `code` = 'shipping' and order_id = '" . (int)$order['order_id'] . "'");
                if ($shipping_fee_arr->num_rows) {
                    $shipping_fee = $shipping_fee_arr->row['value'];
                } else {
                    $shipping_fee = 0;
                }
                
                $order_products = $this->model_checkout_order->getOrderProducts($this->session->data['order_id']);
                
                if($this->customer->isLogged()){
                	//订单金额累加，保存用户订单总金额
                	$this->model_checkout_order->saveTotalOrder();
                	//判断用户购买金额是否达到后台设置金额，提升用户等级
                	$this->load->model('account/customer');
                	$this->model_account_customer->setCustomerGroup();
                }
                
                $gtm_products = array();
                if(!empty($order_products)){
                    foreach($order_products as $product){
                        $gtm_products[] = array(
                                                'name'=>$product['name'],
                                                'id'=>$product['model'],
                                                'price'=>number_format($product['price'],2),
                                                'brand'=>'Hot Beauty Hair',
                                                'category'=>'',
                                                'variant'=>'',
                                                'quantity'=>$product['quantity']				
                        );
                    }
                }
                

                if(!empty($order['order_no'])){
                   $data['text_order'] = sprintf($this->language->get('text_order'), $order['order_no']);
                }
                unset($this->session->data['addresses']);
	            unset($this->session->data['eaddress']);
    			unset($this->session->data['shipping_address']);
    			unset($this->session->data['shipping_method']);
    			unset($this->session->data['shipping_methods']);
    			unset($this->session->data['payment_address']);
    			unset($this->session->data['payment_method']);
    			unset($this->session->data['payment_methods']);
                //unset($this->session->data['guest']);
                unset($this->session->data['comment']);
                //unset($this->session->data['order_id']);   //dyl屏蔽,刷新页面后,仍可以进入到if里面获取相应的值分配给页面使用
                unset($this->session->data['coupon']);
                unset($this->session->data['reward']);
                unset($this->session->data['voucher']);
                unset($this->session->data['vouchers']);
                unset($this->session->data['totals']);
	            unset($this->session->data['is_paypal_creditcard']);
                 
                $data['order'] = $order;
                $data['shipping_fee'] = $shipping_fee;
                $data['gtm_products'] = $gtm_products;

            }
            $this->document->setTitle($this->language->get('heading_title'));
            $data['breadcrumbs'] = array();
            $data['breadcrumbs'][] = array(
                    'text' => $this->language->get('text_home'),
                    'href' => $this->url->link('common/home')
            );
            $data['breadcrumbs'][] = array(
                    'text' => $this->language->get('text_basket'),
                    'href' => $this->url->link('checkout/cart')
            );
            $data['breadcrumbs'][] = array(
                    'text' => $this->language->get('text_checkout'),
                    'href' => $this->url->link('checkout/checkout', '', true)
            );
            $data['breadcrumbs'][] = array(
                    'text' => $this->language->get('text_success'),
                    'href' => $this->url->link('checkout/success')
            );
            $data['heading_title'] = $this->language->get('heading_title');

            if ($this->customer->isLogged()) {
                    $data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', true), $this->url->link('account/order', '', true), $this->url->link('account/download', '', true), $this->url->link('information/contact'));
            } else {
                    $data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
            }
            $data['button_continue'] = $this->language->get('button_continue');


            $data['order_no'] = !empty($order['order_no']) ? $order['order_no'] : '';
            $data['view_order'] = !empty($order_id)?(HTTP_SERVER.'account-order-info?order_id='.$order_id):'';
            $data['order_list'] = $this->url->link('account/order');
            $data['continue'] = $this->url->link('common/home');
            
            $data['column_left'] = $this->load->controller('common/column_left');
            //$data['column_right'] = $this->load->controller('common/column_right');
            $data['account_left'] = $this->load->controller('account/left');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('checkout/success', $data));
	}

	public function sendEmail_1(){
		$this->load->model('checkout/order');
		$order_id = $this->session->data['order_id'];
		$order = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if(!isset($this->session->data['send_order_id']) || $this->session->data['send_order_id'] != $order_id ){
			$this->model_checkout_order->sendEmail($order_id, $order['order_status_id']);
		}
	}
	
	/**
     * 发送邮件
     * @author dyl 783973660@qq.com  2016.9.29
     * @param String $email     接收人的邮箱
     * @param String $Subject   邮件标题
     * @param String $content   邮件内容
     */
        /* 优化 by hwh begin 注释无效方法
	public function sendEmail($firstname,$lastname,$email,$type=2,$order_no=''){
		if($type==1){
		   $content = "Dear"."\n\n";
		   $content.= "Thank you for your recent order #".$order_no.". Unfortunately, the payment of your order has not been received"."\n";
		   $content.= "If you still need your order,please log in your account to repay your order."."\n\n";
		   $content.= HTTP_SERVER."\n\n";  //链接
		   $content.= "Any questions about Hot Beauty Hair or need any further assistance,please feel free to contact us. We are always here to help."."\n";
		   $content.= "Best Regards,"."\n";
	       $content.= "Hot Beauty Hair Team";
	       $Subject = "Payment Reminder For Your Hair Order";
		}
		if($type==2){
		   $content = "Dear ". $firstname ." ". $lastname .","."\n\n";
	       $content.= "Thank you for shopping with Hot Beauty Hair.com. Your order is preparing in Hot Beauty Hair’s warehouse. The tracking number will be emailed after we ship out your order."."\n\n";
	       $content.= "If any other questions,please kindly just email us at rebecca@hotbeautyhair.com."."\n\n";
	       $content.= "Hot Beauty Hair Team";
	       $Subject = "Your hair order is successful - Hot Beauty Hair";
		}

	    $mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

		$mail->setTo($email);                                                //接收人邮箱
		$mail->setFrom($this->config->get('config_email'));                  //发送人
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));  //发送者名字
		$mail->setSubject($Subject);                                         //邮件标题
		$mail->setText($content);                                            //邮件内容
		$mail->send();
	}
         优化 by hwh end */

}