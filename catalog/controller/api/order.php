<?php
class ControllerApiOrder extends Controller {
	public function add() {
		$this->load->language('api/order');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			// Customer
			if (!isset($this->session->data['customer'])) {
				$json['error'] = $this->language->get('error_customer');
			}

			// Payment Address
			if (!isset($this->session->data['payment_address'])) {
				$json['error'] = $this->language->get('error_payment_address');
			}

			// Payment Method
			if (!$json && !empty($this->request->post['payment_method'])) {
				if (empty($this->session->data['payment_methods'])) {
					$json['error'] = $this->language->get('error_no_payment');
				} elseif (!isset($this->session->data['payment_methods'][$this->request->post['payment_method']])) {
					$json['error'] = $this->language->get('error_payment_method');
				}

				if (!$json) {
					$this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];
				}
			}

			if (!isset($this->session->data['payment_method'])) {
				$json['error'] = $this->language->get('error_payment_method');
			}

			// Shipping
			if ($this->cart->hasShipping()) {
				// Shipping Address
				if (!isset($this->session->data['shipping_address'])) {
					$json['error'] = $this->language->get('error_shipping_address');
				}

				// Shipping Method
				if (!$json && !empty($this->request->post['shipping_method'])) {
					if (empty($this->session->data['shipping_methods'])) {
						$json['error'] = $this->language->get('error_no_shipping');
					} else {
						$shipping = explode('.', $this->request->post['shipping_method']);

						if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
							$json['error'] = $this->language->get('error_shipping_method');
						}
					}

					if (!$json) {
						$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
					}
				}

				// Shipping Method
				if (!isset($this->session->data['shipping_method'])) {
					$json['error'] = $this->language->get('error_shipping_method');
				}
			} else {
				unset($this->session->data['shipping_address']);
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
			}

			// Cart
			if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
				$json['error'] = $this->language->get('error_stock');
			}

			// Validate minimum quantity requirements.
			$products = $this->cart->getProducts();

			foreach ($products as $product) {
				$product_total = 0;

				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}

				if ($product['minimum'] > $product_total) {
					$json['error'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);

					break;
				}
			}


			//dyl加  添加订单时,先获取订单的状态,判断是否有错误
			if (isset($this->request->post['order_status_id'])) {
				$order_status_id = $this->request->post['order_status_id'];
			} else {
				$order_status_id = $this->config->get('config_order_status_id');
			}

			if( !empty($order_status_id) ){
				if($order_status_id==3){    //Processing状态
				   if(empty($this->request->post['shippingNumber'])){
	                  $json['error'] = 'Please fill in the shipping number!';
	               }
		           //检测物流号是否有重复
		           if(!empty($this->request->post['shippingNumber'])){
		              $order_id = !empty($json['order_id']) ? $json['order_id'] : 0;
		              $shippingNumber=$this->request->post['shippingNumber'];
		              $this->load->model('checkout/order');
		              $result= $this->model_checkout_order->checkOrderShippingNumber($order_id,$shippingNumber);
		              if($result){
		                 $json['error'] = 'The shipping number has been used!';
		              }
		           }
				}
				if($order_status_id==7 || $order_status_id==11){    //Canceled/Refunded状态
				   if(empty($this->request->post['comment'])){
				      $json['error'] = 'Comment must fill in!';
				   }
				}
		    }
			//dyl end


			if (!$json) {
				$json['success'] = $this->language->get('text_success');

				$order_data = array();

				// Store Details
				$order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
				$order_data['store_id'] = $this->config->get('config_store_id');
				$order_data['store_name'] = $this->config->get('config_name');
				$order_data['store_url'] = $this->config->get('config_url');

				// Customer Details
				$order_data['customer_id'] = $this->session->data['customer']['customer_id'];
				$order_data['customer_group_id'] = $this->session->data['customer']['customer_group_id'];
				$order_data['firstname'] = $this->session->data['customer']['firstname'];
				$order_data['lastname'] = $this->session->data['customer']['lastname'];
				$order_data['email'] = $this->session->data['customer']['email'];
				$order_data['telephone'] = $this->session->data['customer']['telephone'];
				$order_data['fax'] = $this->session->data['customer']['fax'];
				$order_data['custom_field'] = $this->session->data['customer']['custom_field'];

				// Payment Details
				$order_data['payment_firstname'] = $this->session->data['payment_address']['firstname'];
				$order_data['payment_lastname'] = $this->session->data['payment_address']['lastname'];
				$order_data['payment_company'] = $this->session->data['payment_address']['company'];
				$order_data['payment_address_1'] = $this->session->data['payment_address']['address_1'];
				$order_data['payment_address_2'] = $this->session->data['payment_address']['address_2'];
				$order_data['payment_city'] = $this->session->data['payment_address']['city'];
				$order_data['payment_postcode'] = $this->session->data['payment_address']['postcode'];
				$order_data['payment_zone'] = $this->session->data['payment_address']['zone'];
				$order_data['payment_zone_id'] = $this->session->data['payment_address']['zone_id'];
				$order_data['payment_country'] = $this->session->data['payment_address']['country'];
				$order_data['payment_country_id'] = $this->session->data['payment_address']['country_id'];
				$order_data['payment_address_format'] = $this->session->data['payment_address']['address_format'];
				$order_data['payment_custom_field'] = (isset($this->session->data['payment_address']['custom_field']) ? $this->session->data['payment_address']['custom_field'] : array());

				if (isset($this->session->data['payment_method']['title'])) {
					$order_data['payment_method'] = $this->session->data['payment_method']['title'];
				} else {
					$order_data['payment_method'] = '';
				}

				if (isset($this->session->data['payment_method']['code'])) {
					$order_data['payment_code'] = $this->session->data['payment_method']['code'];
				} else {
					$order_data['payment_code'] = '';
				}

				// Shipping Details
				if ($this->cart->hasShipping()) {
					$order_data['shipping_firstname'] = $this->session->data['shipping_address']['firstname'];
					$order_data['shipping_lastname'] = $this->session->data['shipping_address']['lastname'];
					$order_data['shipping_company'] = $this->session->data['shipping_address']['company'];
					$order_data['shipping_address_1'] = $this->session->data['shipping_address']['address_1'];
					$order_data['shipping_address_2'] = $this->session->data['shipping_address']['address_2'];
					$order_data['shipping_city'] = $this->session->data['shipping_address']['city'];
					$order_data['shipping_postcode'] = $this->session->data['shipping_address']['postcode'];
					$order_data['shipping_zone'] = $this->session->data['shipping_address']['zone'];
					$order_data['shipping_zone_id'] = $this->session->data['shipping_address']['zone_id'];
					$order_data['shipping_country'] = $this->session->data['shipping_address']['country'];
					$order_data['shipping_country_id'] = $this->session->data['shipping_address']['country_id'];
					$order_data['shipping_address_format'] = $this->session->data['shipping_address']['address_format'];
					$order_data['shipping_custom_field'] = (isset($this->session->data['shipping_address']['custom_field']) ? $this->session->data['shipping_address']['custom_field'] : array());

					if (isset($this->session->data['shipping_method']['title'])) {
						$order_data['shipping_method'] = $this->session->data['shipping_method']['title'];
					} else {
						$order_data['shipping_method'] = '';
					}

					if (isset($this->session->data['shipping_method']['code'])) {
						$order_data['shipping_code'] = $this->session->data['shipping_method']['code'];
					} else {
						$order_data['shipping_code'] = '';
					}
				} else {
					$order_data['shipping_firstname'] = '';
					$order_data['shipping_lastname'] = '';
					$order_data['shipping_company'] = '';
					$order_data['shipping_address_1'] = '';
					$order_data['shipping_address_2'] = '';
					$order_data['shipping_city'] = '';
					$order_data['shipping_postcode'] = '';
					$order_data['shipping_zone'] = '';
					$order_data['shipping_zone_id'] = '';
					$order_data['shipping_country'] = '';
					$order_data['shipping_country_id'] = '';
					$order_data['shipping_address_format'] = '';
					$order_data['shipping_custom_field'] = array();
					$order_data['shipping_method'] = '';
					$order_data['shipping_code'] = '';
				}

				// Products
				$order_data['products'] = array();

				foreach ($this->cart->getProducts() as $product) {
					$option_data = array();

					foreach ($product['option'] as $option) {
						$option_data[] = array(
							'product_option_id'       => $option['product_option_id'],
							'product_option_value_id' => $option['product_option_value_id'],
							'option_id'               => $option['option_id'],
							'option_value_id'         => $option['option_value_id'],
							'name'                    => $option['name'],
							'value'                   => $option['value'],
							'type'                    => $option['type']
						);
					}

					$order_data['products'][] = array(
						'product_id' => $product['product_id'],
						'name'       => $product['name'],
						'model'      => $product['model'],
						'option'     => $option_data,
						'download'   => $product['download'],
						'quantity'   => $product['quantity'],
						'subtract'   => $product['subtract'],
						'price'      => $product['price'],
						'total'      => $product['total'],
						'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
						'reward'     => $product['reward']
					);
				}

				// Gift Voucher
				$order_data['vouchers'] = array();

				if (!empty($this->session->data['vouchers'])) {
					foreach ($this->session->data['vouchers'] as $voucher) {
						$order_data['vouchers'][] = array(
							'description'      => $voucher['description'],
							//'code'             => token(10),
							'code'             => substr(md5(mt_rand()), 0, 10),
							'to_name'          => $voucher['to_name'],
							'to_email'         => $voucher['to_email'],
							'from_name'        => $voucher['from_name'],
							'from_email'       => $voucher['from_email'],
							'voucher_theme_id' => $voucher['voucher_theme_id'],
							'message'          => $voucher['message'],
							'amount'           => $voucher['amount']
						);
					}
				}

				// Order Totals
				$this->load->model('extension/extension');

				$totals = array();
				$taxes = $this->cart->getTaxes();
				$total = 0;

				// Because __call can not keep var references so we put them into an array.
				$total_data = array(
					'totals' => &$totals,
					'taxes'  => &$taxes,
					'total'  => &$total
				);

				$sort_order = array();

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('extension/total/' . $result['code']);

						// We have to put the totals in an array so that they pass by reference.
						$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
					}
				}

				$sort_order = array();

				foreach ($total_data['totals'] as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data['totals']);

				$order_data = array_merge($order_data, $total_data);

				if (isset($this->request->post['comment'])) {
					$order_data['comment'] = $this->request->post['comment'];
				} else {
					$order_data['comment'] = '';
				}

				if (isset($this->request->post['affiliate_id'])) {
					$subtotal = $this->cart->getSubTotal();

					// Affiliate
					$this->load->model('affiliate/affiliate');

					$affiliate_info = $this->model_affiliate_affiliate->getAffiliate($this->request->post['affiliate_id']);

					if ($affiliate_info) {
						$order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
						$order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
					} else {
						$order_data['affiliate_id'] = 0;
						$order_data['commission'] = 0;
					}

					// Marketing
					$order_data['marketing_id'] = 0;
					$order_data['tracking'] = '';
				} else {
					$order_data['affiliate_id'] = 0;
					$order_data['commission'] = 0;
					$order_data['marketing_id'] = 0;
					$order_data['tracking'] = '';
				}

				$order_data['language_id'] = $this->config->get('config_language_id');
				/*$order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
				$order_data['currency_code'] = $this->session->data['currency'];
				$order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);*/
				$order_data['currency_id'] = $this->currency->getId();
				$order_data['currency_code'] = $this->currency->getCode();
				$order_data['currency_value'] = $this->currency->getValue($this->currency->getCode());
				$order_data['ip'] = $this->request->server['REMOTE_ADDR'];

				if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
					$order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
				} elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
					$order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
				} else {
					$order_data['forwarded_ip'] = '';
				}

				if (isset($this->request->server['HTTP_USER_AGENT'])) {
					$order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
				} else {
					$order_data['user_agent'] = '';
				}

				if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
					$order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
				} else {
					$order_data['accept_language'] = '';
				}

				$this->load->model('checkout/order');

				$json['order_id'] = $this->model_checkout_order->addOrder($order_data);

				// Set the order history
				/*if (isset($this->request->post['order_status_id'])) {
					$order_status_id = $this->request->post['order_status_id'];
				} else {
					$order_status_id = $this->config->get('config_order_status_id');
				}*/

                //$this->model_checkout_order->addOrderHistory($json['order_id'], $order_status_id);

				// clear cart since the order has already been successfully stored.
				//$this->cart->clear();

				if( ($order_status_id!=3 && $order_status_id!=5) || $this->request->post['shippingNumber']=='undefined' ){
	                   $this->request->post['shippingNumber']='';
					}
					if($order_status_id!=7 && $order_status_id!=11){
	                   $order_data['comment']='';
					}
				    $this->model_checkout_order->addOrderHistory($json['order_id'], $order_status_id, $order_data['comment'], $this->request->post['notify'],$this->request->post['shippingNumber']);

				    //dyl改
				    $order_info=$this->model_checkout_order->getOrderDataByOrderId($json['order_id']);
	                $orderStatus=$this->checkOrderStatus($order_status_id);                                        //订单状态描述
	                $shippingNumberContent=!empty($this->request->post['shippingNumber']) ? $this->request->post['shippingNumber'] : '';  //物流号

	                if($order_status_id==1){  //订单刚创建,待处理
	                   $content = "Dear"."\n\n";
	                   $content.= "Thank you for your recent order #".$order_info['order_no'].". Unfortunately, the payment of your order has not been received"."\n";
	                   $content.= "If you still need your order,please log in your account to repay your order."."\n\n";
	                   $content.= HTTP_SERVER."\n\n";  //链接
	                   $content.= "Any questions about Hot Beauty Hair or need any further assistance,please feel free to contact us. We are always here to help."."\n\n";
	                   $content.= "Best Regards,"."\n";
	                   $content.= "Hot Beauty Hair Team";
	                   $Subject = "Payment Reminder For Your Hair Order";
	                }
	                if($order_status_id==2){  //处理中
	                   $content = "Dear {$order_info['firstname']} {$order_info['lastname']},"."\n\n";
	                   $content.= "Thank you for shopping with Hot Beauty Hair.com. Your order is preparing in Hot Beauty Hair’s warehouse. The tracking number will be emailed after we ship out your order."."\n\n";
	                   $content.= "If any other questions,please kindly just email us at hellena@hotbeautyhair.com."."\n\n";
	                   $content.= "Hot Beauty Hair Team";
	                   $Subject = "Your hair order is successful - Hot Beauty Hair";
	                }
	                if($order_status_id==3){  //订单发货后
	                   $content = "Dear {$order_info['firstname']} {$order_info['lastname']},". "\n\n";
	                   $content.= "Thank you shopping with Hot Beauty Hair. Your order #".$order_info['order_no']." has been ".$orderStatus.", the tracking number is ".$shippingNumberContent.", please track it on www.dhl.com."."\n\n";
	                   $content.= "If you have any questions, please don’t hesitate to send emails to hellena@hotbeautyhair.com."."\n";
	                   $content.= "Best Regards,"."\n";
	                   $content.= "Hot Beauty Hair Team";
	                   $Subject = "Your order #".$order_info['order_no']." has been ".$orderStatus;
	                }
	                if($order_status_id==5){  //订单完成
	                   $content = "Dear"."\n";
	                   $content.= "Thank you shopping with Hot Beauty Hair. Your order #".$order_info['order_no']." has been ".$orderStatus."."."\n";
	                   $content.= "Any feedback of our hair would be a great appreciated."."\n\n";
	                   $content.= "If you have any questions, please don’t hesitate to send emails to hellena@hotbeautyhair.com."."\n";
	                   $content.= "Have a fantastic day!"."\n";
	                   $content.= "Best Regards,"."\n";
	                   $content.= "Hot Beauty Hair Team";
	                   $Subject = "Your order #".$order_info['order_no']." has been ".$orderStatus;
	                }
	                if($order_status_id==7 || $order_status_id==11){              //订单取消/退货
	                   $since = !empty($order_data['comment']) ? $order_data['comment'] : "fail payment";
	                   $content = "Dear"."\n\n";
	                   $content.= "Thank you for your recent order #".$order_info['order_no']." Unfortunately, your order has been ".$orderStatus." since the ".$since."."."\n";
	                   $content.= "Welcome to visit our online shop again."."\n\n";
	                   $content.= "If you have any questions, please don’t hesitate to send emails to hellena@hotbeautyhair.com."."\n";
	                   $content.= "Best Regards,"."\n";
	                   $content.= "Hot Beauty Hair Team";
	                   $Subject = "Your order #".$order_info['order_no']." has been ".$orderStatus;
	                }

					//不管有没有选择notify,都发送邮件给买家
	                if(!empty($order_info['email'])){
					   $this->sendEmail($order_info['email'],$Subject,$content);
	                }

                    //选择了notify后,发送邮件给卖家(确定邮件内容后再弄)
				    /*if(!empty($this->request->post['notify']) && $this->request->post['notify']==1){
                       $affiliateEmail = $this->model_checkout_order->getAffiliateEmailByOrderId($json['order_id']);
					   if(!empty($affiliateEmail)){
					      $this->sendEmail($affiliateEmail,$Subject,$content);
					   }
				    }*/

				    //$this->model_checkout_order->addOrderHistory($json['order_id'], $order_status_id);
				    $json['success'] = $this->language->get('text_success');
				//}
				//dyl end

			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function edit() {
		$this->load->language('api/order');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$this->load->model('checkout/order');

			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

		  //dyl add
	      $json['error']='';
		  if( !empty($this->request->post['order_status_id']) ){
		      if($this->request->post['order_status_id']==3){    //Processing状态
			   	  if(empty($this->request->post['shippingNumber'])){
                     $json['error'] = 'Please fill in the shipping number!';
                  }
	              //检测物流号是否有重复
	              if(!empty($this->request->post['shippingNumber'])){
	               	 $order_id = isset($this->request->get['order_id']) ? $this->request->get['order_id'] : 0;
	               	 $shippingNumber=$this->request->post['shippingNumber'];
	               	 $this->load->model('checkout/order');
	               	 $result= $this->model_checkout_order->checkOrderShippingNumber($order_id,$shippingNumber);
	               	 if($result){
	                    $json['error'] = 'The shipping number has been used!';
	               	 }
	              }
			   }
			   if($this->request->post['order_status_id']==7 || $this->request->post['order_status_id']==11){    //Canceled/Refunded状态
			      if(empty($this->request->post['comment'])){
			      	 $json['error'] = 'Comment must fill in!';
			      }
			   }
		  }

          if($json['error']==''){  //有填写shippingNumber则继续执行
            $json=array();         //重新定义一下$json

			$order_info = $this->model_checkout_order->getOrder($order_id);

			if ($order_info) {

				//dyl add
				if( ($this->request->post['order_status_id']!=3 && $this->request->post['order_status_id']!=5) || $this->request->post['shippingNumber']=='undefined' ){
                   $this->request->post['shippingNumber']='';
				}
				if( $this->request->post['order_status_id']!=7 && $this->request->post['order_status_id']!=11){
                   $this->request->post['comment']='';
				}

				// Customer
				if (!isset($this->session->data['customer'])) {
					$json['error'] = $this->language->get('error_customer');
				}

				// Payment Address
				if (!isset($this->session->data['payment_address'])) {
					$json['error'] = $this->language->get('error_payment_address');
				}

				// Payment Method
				if (!$json && !empty($this->request->post['payment_method'])) {
					if (empty($this->session->data['payment_methods'])) {
						$json['error'] = $this->language->get('error_no_payment');
					} elseif (!isset($this->session->data['payment_methods'][$this->request->post['payment_method']])) {
						$json['error'] = $this->language->get('error_payment_method');
					}

					if (!$json) {
						$this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];
					}
				}

				if (!isset($this->session->data['payment_method'])) {
					$json['error'] = $this->language->get('error_payment_method');
				}

				// Shipping
				if ($this->cart->hasShipping()) {
					// Shipping Address
					if (!isset($this->session->data['shipping_address'])) {
						$json['error'] = $this->language->get('error_shipping_address');
					}

					// Shipping Method
					if (!$json && !empty($this->request->post['shipping_method'])) {
						if (empty($this->session->data['shipping_methods'])) {
							$json['error'] = $this->language->get('error_no_shipping');
						} else {
							$shipping = explode('.', $this->request->post['shipping_method']);

							if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
								$json['error'] = $this->language->get('error_shipping_method');
							}
						}

						if (!$json) {
							$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
						}
					}

					if (!isset($this->session->data['shipping_method'])) {
						$json['error'] = $this->language->get('error_shipping_method');
					}
				} else {
					unset($this->session->data['shipping_address']);
					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);
				}

				// Cart
				if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
					$json['error'] = $this->language->get('error_stock');
				}

				// Validate minimum quantity requirements.
				$products = $this->cart->getProducts();

				foreach ($products as $product) {
					$product_total = 0;

					foreach ($products as $product_2) {
						if ($product_2['product_id'] == $product['product_id']) {
							$product_total += $product_2['quantity'];
						}
					}

					if ($product['minimum'] > $product_total) {
						$json['error'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);

						break;
					}
				}

				if (!$json) {
					$json['success'] = $this->language->get('text_success');

					$order_data = array();

					// Store Details
					$order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
					$order_data['store_id'] = $this->config->get('config_store_id');
					$order_data['store_name'] = $this->config->get('config_name');
					$order_data['store_url'] = $this->config->get('config_url');

					// Customer Details
					$order_data['customer_id'] = $this->session->data['customer']['customer_id'];
					$order_data['customer_group_id'] = $this->session->data['customer']['customer_group_id'];
					$order_data['firstname'] = $this->session->data['customer']['firstname'];
					$order_data['lastname'] = $this->session->data['customer']['lastname'];
					$order_data['email'] = $this->session->data['customer']['email'];
					$order_data['telephone'] = $this->session->data['customer']['telephone'];
					$order_data['fax'] = $this->session->data['customer']['fax'];
					$order_data['custom_field'] = $this->session->data['customer']['custom_field'];

					// Payment Details
					$order_data['payment_firstname'] = $this->session->data['payment_address']['firstname'];
					$order_data['payment_lastname'] = $this->session->data['payment_address']['lastname'];
					$order_data['payment_company'] = $this->session->data['payment_address']['company'];
					$order_data['payment_address_1'] = $this->session->data['payment_address']['address_1'];
					$order_data['payment_address_2'] = $this->session->data['payment_address']['address_2'];
					$order_data['payment_city'] = $this->session->data['payment_address']['city'];
					$order_data['payment_postcode'] = $this->session->data['payment_address']['postcode'];
					$order_data['payment_zone'] = $this->session->data['payment_address']['zone'];
					$order_data['payment_zone_id'] = $this->session->data['payment_address']['zone_id'];
					$order_data['payment_country'] = $this->session->data['payment_address']['country'];
					$order_data['payment_country_id'] = $this->session->data['payment_address']['country_id'];
					$order_data['payment_address_format'] = $this->session->data['payment_address']['address_format'];
					$order_data['payment_custom_field'] = $this->session->data['payment_address']['custom_field'];

					if (isset($this->session->data['payment_method']['title'])) {
						$order_data['payment_method'] = $this->session->data['payment_method']['title'];
					} else {
						$order_data['payment_method'] = '';
					}

					if (isset($this->session->data['payment_method']['code'])) {
						$order_data['payment_code'] = $this->session->data['payment_method']['code'];
					} else {
						$order_data['payment_code'] = '';
					}

					// Shipping Details
					if ($this->cart->hasShipping()) {
						$order_data['shipping_firstname'] = $this->session->data['shipping_address']['firstname'];
						$order_data['shipping_lastname'] = $this->session->data['shipping_address']['lastname'];
						$order_data['shipping_company'] = $this->session->data['shipping_address']['company'];
						$order_data['shipping_address_1'] = $this->session->data['shipping_address']['address_1'];
						$order_data['shipping_address_2'] = $this->session->data['shipping_address']['address_2'];
						$order_data['shipping_city'] = $this->session->data['shipping_address']['city'];
						$order_data['shipping_postcode'] = $this->session->data['shipping_address']['postcode'];
						$order_data['shipping_zone'] = $this->session->data['shipping_address']['zone'];
						$order_data['shipping_zone_id'] = $this->session->data['shipping_address']['zone_id'];
						$order_data['shipping_country'] = $this->session->data['shipping_address']['country'];
						$order_data['shipping_country_id'] = $this->session->data['shipping_address']['country_id'];
						$order_data['shipping_address_format'] = $this->session->data['shipping_address']['address_format'];
						$order_data['shipping_custom_field'] = $this->session->data['shipping_address']['custom_field'];

						if (isset($this->session->data['shipping_method']['title'])) {
							$order_data['shipping_method'] = $this->session->data['shipping_method']['title'];
						} else {
							$order_data['shipping_method'] = '';
						}

						if (isset($this->session->data['shipping_method']['code'])) {
							$order_data['shipping_code'] = $this->session->data['shipping_method']['code'];
						} else {
							$order_data['shipping_code'] = '';
						}
					} else {
						$order_data['shipping_firstname'] = '';
						$order_data['shipping_lastname'] = '';
						$order_data['shipping_company'] = '';
						$order_data['shipping_address_1'] = '';
						$order_data['shipping_address_2'] = '';
						$order_data['shipping_city'] = '';
						$order_data['shipping_postcode'] = '';
						$order_data['shipping_zone'] = '';
						$order_data['shipping_zone_id'] = '';
						$order_data['shipping_country'] = '';
						$order_data['shipping_country_id'] = '';
						$order_data['shipping_address_format'] = '';
						$order_data['shipping_custom_field'] = array();
						$order_data['shipping_method'] = '';
						$order_data['shipping_code'] = '';
					}

					// Products
					$order_data['products'] = array();

					foreach ($this->cart->getProducts() as $product) {
						$option_data = array();

						foreach ($product['option'] as $option) {
							$option_data[] = array(
								'product_option_id'       => $option['product_option_id'],
								'product_option_value_id' => $option['product_option_value_id'],
								'option_id'               => $option['option_id'],
								'option_value_id'         => $option['option_value_id'],
								'name'                    => $option['name'],
								'value'                   => $option['value'],
								'type'                    => $option['type']
							);
						}

						$order_data['products'][] = array(
							'product_id' => $product['product_id'],
							'name'       => $product['name'],
							'model'      => $product['model'],
							'option'     => $option_data,
							'download'   => $product['download'],
							'quantity'   => $product['quantity'],
							'subtract'   => $product['subtract'],
							'price'      => $product['price'],
							'total'      => $product['total'],
							'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
							'reward'     => $product['reward']
						);
					}

					// Gift Voucher
					$order_data['vouchers'] = array();

					if (!empty($this->session->data['vouchers'])) {
						foreach ($this->session->data['vouchers'] as $voucher) {
							$order_data['vouchers'][] = array(
								'description'      => $voucher['description'],
								'code'             => token(10),
								'to_name'          => $voucher['to_name'],
								'to_email'         => $voucher['to_email'],
								'from_name'        => $voucher['from_name'],
								'from_email'       => $voucher['from_email'],
								'voucher_theme_id' => $voucher['voucher_theme_id'],
								'message'          => $voucher['message'],
								'amount'           => $voucher['amount']
							);
						}
					}

					// Order Totals
					$this->load->model('extension/extension');

					$totals = array();
					$taxes = $this->cart->getTaxes();
					$total = 0;

					// Because __call can not keep var references so we put them into an array.
					$total_data = array(
						'totals' => &$totals,
						'taxes'  => &$taxes,
						'total'  => &$total
					);

					$sort_order = array();

					$results = $this->model_extension_extension->getExtensions('total');

					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}

					array_multisort($sort_order, SORT_ASC, $results);

					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('extension/total/' . $result['code']);

							// We have to put the totals in an array so that they pass by reference.
							$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
						}
					}

					$sort_order = array();

					foreach ($total_data['totals'] as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $total_data['totals']);

					$order_data = array_merge($order_data, $total_data);

					if (isset($this->request->post['comment'])) {
						$order_data['comment'] = $this->request->post['comment'];
					} else {
						$order_data['comment'] = '';
					}

					if (isset($this->request->post['affiliate_id'])) {
						$subtotal = $this->cart->getSubTotal();

						// Affiliate
						$this->load->model('affiliate/affiliate');

						$affiliate_info = $this->model_affiliate_affiliate->getAffiliate($this->request->post['affiliate_id']);

						if ($affiliate_info) {
							$order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
							$order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
						} else {
							$order_data['affiliate_id'] = 0;
							$order_data['commission'] = 0;
						}
					} else {
						$order_data['affiliate_id'] = 0;
						$order_data['commission'] = 0;
					}

                    $order_data['shippingNumber']=$this->request->post['shippingNumber'];  //dyl add
					$this->model_checkout_order->editOrder($order_id, $order_data);

					// Set the order history
					if (isset($this->request->post['order_status_id'])) {
						$order_status_id = $this->request->post['order_status_id'];
					} else {
						$order_status_id = $this->config->get('config_order_status_id');
					}

                    //dyl改
                    if(!empty($this->request->post['notify']) && $this->request->post['notify']==1){
                       $notify=true;
                    }else{
                       $notify=false;
                    }

					//$this->model_checkout_order->addOrderHistory($order_id, $order_status_id);
					$this->model_checkout_order->addOrderHistory($order_id, $order_status_id, $this->request->post['comment'], $notify, $this->request->post['shippingNumber']);

					//dyl改  783973660@qq.com
	                $orderStatus=$this->checkOrderStatus($this->request->post['order_status_id']);
	                $shippingNumberContent=!empty($this->request->post['shippingNumber']) ? $this->request->post['shippingNumber'] : '';

                    if($this->request->post['order_status_id']==1){  //订单刚创建,待处理
	                   $content = "Dear"."\n\n";
	                   $content.= "Thank you for your recent order #".$order_info['order_no'].". Unfortunately, the payment of your order has not been received"."\n";
	                   $content.= "If you still need your order,please log in your account to repay your order."."\n\n";
	                   $content.= HTTP_SERVER."\n\n";  //链接
	                   $content.= "Any questions about Hot Beauty Hair or need any further assistance,please feel free to contact us. We are always here to help."."\n\n";
	                   $content.= "Best Regards,"."\n";
	                   $content.= "Hot Beauty Hair Team";
	                   $Subject = "Payment Reminder For Your Hair Order";
	                }
	                if($this->request->post['order_status_id']==2){  //处理中
	                   $content = "Dear {$order_info['firstname']} {$order_info['lastname']},"."\n\n";
	                   $content.= "Thank you for shopping with Hot Beauty Hair.com. Your order is preparing in Hot Beauty Hair’s warehouse. The tracking number will be emailed after we ship out your order."."\n\n";
	                   $content.= "If any other questions,please kindly just email us at hellena@hotbeautyhair.com."."\n\n";
	                   $content.= "Hot Beauty Hair Team";
	                   $Subject = "Your hair order is successful - Hot Beauty Hair";
	                }
	                if($this->request->post['order_status_id']==3){  //订单发货后
	                   $content = "Dear {$order_info['firstname']} {$order_info['lastname']},". "\n\n";
	                   $content.= "Thank you shopping with Hot Beauty Hair. Your order #".$order_info['order_no']." has been ".$orderStatus.", the tracking number is ".$shippingNumberContent.", please track it on www.dhl.com."."\n\n";
	                   $content.= "If you have any questions, please don’t hesitate to send emails to hellena@hotbeautyhair.com."."\n";
	                   $content.= "Best Regards,"."\n";
	                   $content.= "Hot Beauty Hair Team";
	                   $Subject = "Your order #".$order_info['order_no']." has been ".$orderStatus;
	                }
	                if($this->request->post['order_status_id']==5){  //订单完成
	                   $content = "Dear"."\n";
	                   $content.= "Thank you shopping with Hot Beauty Hair. Your order #".$order_info['order_no']." has been ".$orderStatus."."."\n";
	                   $content.= "Any feedback of our hair would be a great appreciated."."\n\n";
	                   $content.= "If you have any questions, please don’t hesitate to send emails to hellena@hotbeautyhair.com."."\n";
	                   $content.= "Have a fantastic day!"."\n";
	                   $content.= "Best Regards,"."\n";
	                   $content.= "Hot Beauty Hair Team";
	                   $Subject = "Your order #".$order_info['order_no']." has been ".$orderStatus;
	                }
	                if($this->request->post['order_status_id']==7 || $this->request->post['order_status_id']==11){   //订单取消/退货
	                   $since = !empty($this->request->post['comment']) ? $this->request->post['comment'] : "fail payment";
	                   $content = "Dear"."\n\n";
	                   $content.= "Thank you for your recent order #".$order_info['order_no']." Unfortunately, your order has been ".$orderStatus." since the ".$since."."."\n";
	                   $content.= "Welcome to visit our online shop again."."\n\n";
	                   $content.= "If you have any questions, please don’t hesitate to send emails to hellena@hotbeautyhair.com."."\n";
	                   $content.= "Best Regards,"."\n";
	                   $content.= "Hot Beauty Hair Team";
	                   $Subject = "Your order #".$order_info['order_no']." has been ".$orderStatus;
	                }

                    //不管有没有选择notify,都发送邮件给买家
                    $email=$this->model_checkout_order->getEmailByOrderId($order_id);
	                if(!empty($email)){
					   $this->sendEmail($email,$Subject,$content);
	                }

	                //选择了notify后,发送邮件给卖家(确定邮件内容后再弄)
				    /*if($notify){
                       $affiliateEmail = $this->model_checkout_order->getAffiliateEmailByOrderId($order_id);
					   if(!empty($affiliateEmail)){
					      $this->sendEmail($affiliateEmail,$Subject,$content);
					   }
				    }*/
					//dyl end

					$json['success'] = $this->language->get('text_success');
				}
			} else {
				$json['error'] = $this->language->get('error_not_found');
			}
		  }
         }

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete() {
		$this->load->language('api/order');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$this->load->model('checkout/order');

			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$order_info = $this->model_checkout_order->getOrder($order_id);

			if ($order_info) {
				$this->model_checkout_order->deleteOrder($order_id);

				$json['success'] = $this->language->get('text_success');
			} else {
				$json['error'] = $this->language->get('error_not_found');
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function info() {
		$this->load->language('api/order');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$this->load->model('checkout/order');

			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$order_info = $this->model_checkout_order->getOrder($order_id);

			if ($order_info) {
				$json['order'] = $order_info;

				$json['success'] = $this->language->get('text_success');
			} else {
				$json['error'] = $this->language->get('error_not_found');
			}
		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function history() {
		$this->load->language('api/order');

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			// Add keys for missing post vars
			$keys = array(
				'order_status_id',
				'notify',
				//'override',
				'comment',
				'shippingNumber'
			);

			foreach ($keys as $key) {
				if (!isset($this->request->post[$key])) {
					$this->request->post[$key] = '';
				}
			}

			//dyl add
			$json['error']='';
			if( !empty($this->request->post['order_status_id'])){
			   if($this->request->post['order_status_id']==3){    //Processing状态
			   	  if(empty($this->request->post['shippingNumber'])){
                     $json['error'] = 'Please fill in the shipping number!';
                  }
	              //检测物流号是否有重复
	              if(!empty($this->request->post['shippingNumber'])){
	               	 $order_id = isset($this->request->get['order_id']) ? $this->request->get['order_id'] : 0;
	               	 $shippingNumber=$this->request->post['shippingNumber'];
	               	 $this->load->model('checkout/order');
	               	 $result= $this->model_checkout_order->checkOrderShippingNumber($order_id,$shippingNumber);
	               	 if($result){
	                    $json['error'] = 'The shipping number has been used!';
	               	 }
	              }
			   }
			   if($this->request->post['order_status_id']==7 || $this->request->post['order_status_id']==11){    //Canceled/Refunded状态
			      if(empty($this->request->post['comment'])){
			      	 $json['error'] = 'Comment must fill in!';
			      }
			   }
			}

		  if($json['error']==''){  //有填写shippingNumber则继续执行   dyl add end

			$this->load->model('checkout/order');

			if (isset($this->request->get['order_id'])) {
				$order_id = $this->request->get['order_id'];
			} else {
				$order_id = 0;
			}

			$order_info = $this->model_checkout_order->getOrder($order_id);

			/*if ($order_info) {
				$this->model_checkout_order->addOrderHistory($order_id, $this->request->post['order_status_id'], $this->request->post['comment'], $this->request->post['notify'], $this->request->post['override']);

				$json['success'] = $this->language->get('text_success');
			} else {
				$json['error'] = $this->language->get('error_not_found');
			}*/

			if ($order_info) {
				if( ($this->request->post['order_status_id']!=3 && $this->request->post['order_status_id']!=5) || $this->request->post['shippingNumber']=='undefined' ){
                   $this->request->post['shippingNumber']='';
				}
// 				if($this->request->post['order_status_id']!=7 && $this->request->post['order_status_id']!=11){
//                    $this->request->post['comment']='';
// 				}
				$this->model_checkout_order->addOrderHistory($order_id, $this->request->post['order_status_id'], $this->request->post['comment'], $this->request->post['notify'],$this->request->post['shippingNumber']);
				$config_email=$this->config->get('config_email');

                //dyl改  783973660@qq.com  2016.3.8
                $orderStatus=$this->checkOrderStatus($this->request->post['order_status_id']);                                        //订单状态描述
                $shippingNumberContent=!empty($this->request->post['shippingNumber']) ? $this->request->post['shippingNumber'] : '';  //物流号

	            if($this->request->post['order_status_id']==1){  //订单刚创建,待处理
		           $content = "Dear"."\n\n";
		           $content.= "Thank you for your recent order #".$order_info['order_no'].". Unfortunately, the payment of your order has not been received"."\n";
		           $content.= "If you still need your order,please log in your account to repay your order."."\n\n";
		           $content.= HTTP_SERVER."\n\n";  //链接
		           $content.= "Any questions about Hot Beauty Hair or need any further assistance,please feel free to contact us. We are always here to help."."\n\n";
		           $content.= "Best Regards,"."\n";
	               $content.= "Hot Beauty Hair Team";
	               $Subject = "Payment Reminder For Your Hair Order";
	            }
	            if($this->request->post['order_status_id']==2){  //处理中
                   $content = "Dear {$order_info['firstname']} {$order_info['lastname']},"."\n\n";
                   $content.= "Thank you for shopping with Hot Beauty Hair.com. Your order is preparing in Hot Beauty Hair’s warehouse. The tracking number will be emailed after we ship out your order."."\n\n";
                   $content.= "If any other questions,please kindly just email us at ".$config_email."."."\n\n";
                   $content.= "Hot Beauty Hair Team";
                   $Subject = "Your hair order is successful - Hot Beauty Hair";
                }
                if($this->request->post['order_status_id']==3){  //订单发货后
                   $content = "Dear {$order_info['firstname']} {$order_info['lastname']},". "\n\n";
                   $content.= "Thank you shopping with Hot Beauty Hair. Your order #".$order_info['order_no']." has been ".$orderStatus.", the tracking number is ".$shippingNumberContent.", please track it on www.dhl.com."."\n\n";
                   $content.= "If you have any questions, please don’t hesitate to send emails to ".$config_email."."."\n";
                   $content.= "Best Regards,"."\n";
                   $content.= "Hot Beauty Hair Team";
                   $Subject = "Your order #".$order_info['order_no']." has been ".$orderStatus;
                }
                if($this->request->post['order_status_id']==5){  //订单完成
                   $content = "Dear"."\n";
                   $content.= "Thank you shopping with Hot Beauty Hair. Your order #".$order_info['order_no']." has been ".$orderStatus."."."\n";
                   $content.= "Any feedback of our hair would be a great appreciated."."\n\n";
                   $content.= "If you have any questions, please don’t hesitate to send emails to ".$config_email."."."\n";
                   $content.= "Have a fantastic day!"."\n";
                   $content.= "Best Regards,"."\n";
                   $content.= "Hot Beauty Hair Team";
                   $Subject = "Your order #".$order_info['order_no']." has been ".$orderStatus;
                }
                if($this->request->post['order_status_id']==7 || $this->request->post['order_status_id']==11){   //订单取消/退货
                   $since = !empty($this->request->post['comment']) ? $this->request->post['comment'] : "fail payment";
                   $content = "Dear"."\n\n";
                   $content.= "Thank you for your recent order #".$order_info['order_no']." Unfortunately, your order has been ".$orderStatus." since the ".$since."."."\n";
                   $content.= "Welcome to visit our online shop again."."\n\n";
                   $content.= "If you have any questions, please don’t hesitate to send emails to ".$config_email."."."\n";
                   $content.= "Best Regards,"."\n";
                   $content.= "Hot Beauty Hair Team";
                   $Subject = "Your order #".$order_info['order_no']." has been ".$orderStatus;
                }

                $email = $this->model_checkout_order->getEmailByOrderId($this->request->get['order_id']);
			    if(!empty($email) && $this->request->post['notify']){
				   $this->sendEmail($email,$Subject,$content);
				}

                //选择了notify后,发送邮件给卖家(确定邮件内容后再弄)
				/*if(!empty($this->request->post['notify']) && $this->request->post['notify']==1){
                   $affiliateEmail = $this->model_checkout_order->getAffiliateEmailByOrderId($this->request->get['order_id']);
				   if(!empty($affiliateEmail)){
					  $this->sendEmail($affiliateEmail,$Subject,$content);
				   }
				}*/
				//dyl end

				$json['success'] = $this->language->get('text_success');
			} else {
				$json['error'] = $this->language->get('error_not_found');
			}

		  }

		}

		if (isset($this->request->server['HTTP_ORIGIN'])) {
			$this->response->addHeader('Access-Control-Allow-Origin: ' . $this->request->server['HTTP_ORIGIN']);
			$this->response->addHeader('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
			$this->response->addHeader('Access-Control-Max-Age: 1000');
			$this->response->addHeader('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}





	 /**
     * 判断订单的状态
     * @author dyl 783973660@qq.com 2016.9.29
     * @param Int $orderStatusId 订单状态id
     */
	public function checkOrderStatus($orderStatusId){
	   switch($orderStatusId){
	   	  case 1:  $orderStatus='Pending'; break;
	   	  case 2:  $orderStatus='Processing'; break;
	   	  case 3:  $orderStatus='shipped out'; break;
	   	  case 5:  $orderStatus='completed'; break;
          case 7:  $orderStatus='canceled'; break;
	   	  case 8:  $orderStatus='Denied'; break;
          case 9:  $orderStatus='Canceled Reversal'; break;
          case 10: $orderStatus='Failed'; break;
          case 11: $orderStatus='refunded'; break;
		  case 12: $orderStatus='Reversed'; break;
		  case 13: $orderStatus='Chargeback'; break;
          case 14: $orderStatus='Expired'; break;
          case 15: $orderStatus='Processed'; break;
          case 16: $orderStatus='Voided'; break;
	   }
       return $orderStatus;
	}

    /**
     * 发送邮件 
     * @author dyl 783973660@qq.com  2016.9.29
     * @param String $email     接收人的邮箱
     * @param String $Subject   邮件标题
     * @param String $content   邮件内容
     */
	public function sendEmail($email,$Subject,$content){
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

		$mail->setTo($email);                                                //接收人邮箱
		$mail->setFrom($this->config->get('config_mail_parameter'));     //发送人
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));  //发送者名字
		$mail->setSubject($Subject);                                         //邮件标题
		$mail->setText($content);                                            //邮件内容
		$mail->send();
	}



}