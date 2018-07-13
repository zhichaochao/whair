<?php
class ControllerCheckoutConfirm extends Controller {
	public function index() {
		$redirect = '';

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$redirect = $this->url->link('checkout/cart');
		}
		
		if (isset($this->session->data['coupon'])) {
		    $data['coupon'] = $this->session->data['coupon'];
		} else {
		    $data['coupon'] = '';
		}
		if (isset($this->session->data['success'])) {
		    $data['success'] = $this->session->data['success'];
		    unset($this->session->data['success']);
		} else {
		    $data['success'] = '';
		}

		// Validate minimum quantity requirements.
		if (!isset($this->request->get['cart_ids'])){$this->request->get['cart_ids']='';}
		$this->session->data['cart_ids']=$this->request->get['cart_ids'];
		$products = $this->cart->getProducts($this->request->get['cart_ids']);

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$redirect = $this->url->link('checkout/cart');

				break;
			}
		}

		if (!$redirect) {

		    $order_data = array();
		    $totals = array();
		    $taxes = $this->cart->getTaxes();
		    $total = 0;
		    
		    $total_data = array(
		        'totals' => &$totals,
		        'taxes'  => &$taxes,
		        'total'  => &$total
		    );
		    // print_r($total_data);exit();
		    $this->load->model('extension/extension');
		    $sort_order = array();
		    $results = $this->model_extension_extension->getExtensions('total');
		    
		    foreach ($results as $key => $value) {
		        $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
		    }

		    array_multisort($sort_order, SORT_ASC, $results);
		       // print_r($results);exit();
		    foreach ($results as $result) {
		        if ($this->config->get($result['code'] . '_status')) {
		            $this->load->model('extension/total/' . $result['code']);
		            // We have to put the totals in an array so that they pass by reference.

		            $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
		        }
		    }
		    $sort_order = array();
		    foreach ($totals as $key => $value) {
		        $sort_order[$key] = $value['sort_order'];
		    }
		    // print_r($totals);exit();
		    array_multisort($sort_order, SORT_ASC, $totals);
		    $order_data['totals'] = $totals;
		    
			$this->load->language('checkout/cart');
			$this->load->language('checkout/checkout');

			$data['text_recurring_item'] = $this->language->get('text_recurring_item');
			$data['text_payment_recurring'] = $this->language->get('text_payment_recurring');

			$data['column_image'] = $this->language->get('column_image');
			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			//product
			$data['products'] = array();
			$this->load->model('tool/upload');
			$this->load->model('tool/image');

			foreach ($this->cart->getProducts($this->request->get['cart_ids']) as $product) {
				$option_data = array();
                                
				foreach ($product['option'] as $option) {
                                        /* 优化 by hwh begin 注释掉op默认属性file类型判断
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);
						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					} 
                                       优化 by hwh end */
					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($option['value']) > 20 ? utf8_substr($option['value'], 0, 20) . '..' : $option['value'])
					);
				}
                               
                                
				$recurring = '';
                                /* 优化 by hwh begin 注释掉产品recurring处理
				if ($product['recurring']) {
					$frequencies = array(
						'day'        => $this->language->get('text_day'),
						'week'       => $this->language->get('text_week'),
						'semi_month' => $this->language->get('text_semi_month'),
						'month'      => $this->language->get('text_month'),
						'year'       => $this->language->get('text_year'),
					);
					if ($product['recurring']['trial']) {
						$recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
					}
					if ($product['recurring']['duration']) {
						$recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					} else {
						$recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					}
				}
                                优化 by hwh end */

				$data['products'][] = array(
                    'cart_id'    => $product['cart_id'],
					'product_id' => $product['product_id'],
                    'image'      => $this->model_tool_image->resize($product['image'], 100, 100),
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $option_data,
					'recurring'  => $recurring,
					'quantity'   => $product['quantity'],
					'subtract'   => $product['subtract'],
					'price'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']),
					'original_price' => $product['original_price']?($this->currency->format($this->tax->calculate($product['original_price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])):0,//原价
		            'total'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $this->session->data['currency']),
					'href'       => $this->url->link('product/product', 'product_id=' . $product['product_id']),
					'free_postage' => $product['free_postage']   //添加商品包邮属性
						
				);
			}

			// Gift Voucher
			$data['vouchers'] = array();
                        
                        /* 优化 by hwh begin 礼品卡暂时注释
			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$data['vouchers'][] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency'])
					);
				}
			}
                        优化 by hwh end */
                        
			$data['totals'] = array();
			foreach ($order_data['totals'] as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $this->session->data['currency'])
				);
			}
		} else {
			$data['redirect'] = $redirect;
		}
		$data['payment_type'] = isset($this->session->data['payment_type'])?$this->session->data['payment_type']:'';
		$data['comment'] = isset($this->session->data['comment'])?$this->session->data['comment']:'';

        $data['cart_ids'] = $this->request->get['cart_ids'];
        $data['cart'] =isset( $this->request->get['cart'])?1:0;
          $data['checkout_url'] =$this->url->link('checkout/cart');

		$this->response->setOutput($this->load->view('checkout/confirm', $data));
	}
	
	public function savecomment() {
	    $json = array();
	    $this->load->language('checkout/checkout');
	    
	    if(isset($this->request->post['comment'])) 
	        $this->session->data['comment'] = strip_tags($this->request->post['comment']);
	     $json['comment']= $this->session->data['comment'];
	      $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
	}
	
	public function save() {
	    $json = array();
	    $this->load->language('checkout/checkout');
	    
	    if(isset($this->request->post['comment'])) 
	        $this->session->data['comment'] = strip_tags($this->request->post['comment']);
	
	    if ($this->cart->hasShipping()) {
	        // Validate if shipping address has been set.
	        if (empty($this->session->data['shipping_address'])) {
	            $json['error']['warning'] = $this->language->get('error_address');
	        }
	
	        // Validate if shipping method has been set.
	        elseif (empty($this->session->data['shipping_method'])) {
	            $json['error']['warning'] = $this->language->get('error_shipping');
	        }
	    } else {
	        unset($this->session->data['shipping_address']);
	        unset($this->session->data['shipping_method']);
	        unset($this->session->data['shipping_methods']);
	    }
	
	    if(!$json){
    	    // Validate if payment address has been set.
    	    if (empty($this->session->data['payment_address'])) {
                $json['error']['warning'] = $this->language->get('error_address');
    	    }
    	
    	    // Validate if payment method has been set.
    	    elseif (empty($this->session->data['payment_method'])) {
                $json['error']['warning'] = $this->language->get('error_payment');
    	    }
    	
    	    // Validate cart has products and has stock.
    	    elseif ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
    	        $json['redirect'] = $this->url->link('checkout/cart');
    	    }
	    }
	
	    // Validate minimum quantity requirements.
	    $products = $this->cart->getProducts($this->request->get['cart_ids']);
	
	    foreach ($products as $product) {
	        $product_total = 0;
	        foreach ($products as $product_2) {
	            if ($product_2['product_id'] == $product['product_id']) {
	                $product_total += $product_2['quantity'];
	            }
	        }
	        if ($product['minimum'] > $product_total) {
	            $redirect = $this->url->link('checkout/cart');
	            break;
	        }
	    }
	
	    if (!$json) {
	        $order_data = array();
	
	        $totals = array();
	        $taxes = $this->cart->getTaxes();
	        $total = 0;
	
	        // Because __call can not keep var references so we put them into an array.
	        $total_data = array(
	            'totals' => &$totals,
	            'taxes'  => &$taxes,
	            'total'  => &$total
	        );
	
	        $this->load->model('extension/extension');
	
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
	        foreach ($totals as $key => $value) {
	            $sort_order[$key] = $value['sort_order'];
	        }
	        array_multisort($sort_order, SORT_ASC, $totals);
	        $order_data['totals'] = $totals;
	        $this->session->data['totals'] = $totals;
	
	        $order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
	        $order_data['store_id'] = $this->config->get('config_store_id');
	        $order_data['store_name'] = $this->config->get('config_name');
	
	        if ($order_data['store_id']) {
	            $order_data['store_url'] = $this->config->get('config_url');
	        } else {
	            if ($this->request->server['HTTPS']) {
	                $order_data['store_url'] = HTTPS_SERVER;
	            } else {
	                $order_data['store_url'] = HTTP_SERVER;
	            }
	        }
	
	        if ($this->customer->isLogged()) {
	            $this->load->model('account/customer');
	
	            $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

	            $order_data['customer_id'] = $this->customer->getId();
	            $order_data['customer_group_id'] = $customer_info['customer_group_id'];
	            $order_data['firstname'] = $customer_info['firstname'];
	            $order_data['lastname'] = $customer_info['lastname'];
	            $order_data['email'] = $customer_info['email'];
	            
	            //如果用户个人中心电话未填，就用物流电话代替写入
	            if(!empty($customer_info['telephone'])){
	            	$order_data['telephone'] = $customer_info['telephone'];
	            }else{
	            	$order_data['telephone'] = $this->session->data['shipping_address']['telephone'];
	            }	            
	            
	            $order_data['fax'] = $customer_info['fax'];
	            $order_data['custom_field'] = json_decode($customer_info['custom_field'], true);
	        } elseif (isset($this->session->data['guest'])) {
	            $order_data['customer_id'] = 0;
	            $order_data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
	            $order_data['firstname'] = $this->session->data['guest']['firstname'];
	            $order_data['lastname'] = $this->session->data['guest']['lastname'];
	            $order_data['email'] = $this->session->data['guest']['email'];
	            $order_data['telephone'] = $this->session->data['guest']['telephone'];
	            $order_data['fax'] = $this->session->data['guest']['fax'];
	            $order_data['custom_field'] = $this->session->data['guest']['custom_field'];
	        }
	
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
	        $order_data['payment_address_format'] = (isset($this->session->data['payment_address']['address_format']) ? $this->session->data['payment_address']['address_format'] : '');
	        $order_data['payment_custom_field'] = (isset($this->session->data['payment_address']['custom_field']) ? $this->session->data['payment_address']['custom_field'] : array());
	        $order_data['payment_telephone'] = $this->session->data['payment_address']['telephone'];

			if (isset($this->session->data['payment_method']['title'])) {
				if ($this->session->data['payment_type'] == 'Standard' && $this->session->data['payment_code'] == 'pp_express') {
					$order_data['payment_method'] = 'PayPal Payments Standard';
				} elseif ($this->session->data['payment_type'] == 'Express' && $this->session->data['payment_code'] == 'pp_express') {
					$order_data['payment_method'] = 'PayPal Express Checkout';
				} else {
					$order_data['payment_method'] = $this->session->data['payment_method']['title'];
				}
			} else {
				$order_data['payment_method'] = '';
			}

			if (isset($this->session->data['payment_method']['code'])) {
				if ($this->session->data['payment_type'] == 'Standard' && $this->session->data['payment_code'] == 'pp_express') {
					$order_data['payment_code'] = 'pp_standard';
				} elseif ($this->session->data['payment_type'] == 'Express' && $this->session->data['payment_code'] == 'pp_express') {
					$order_data['payment_code'] = 'pp_express';
				} else {
					$order_data['payment_code'] = $this->session->data['payment_method']['code'];
				}
			} else {
				$order_data['payment_code'] = '';
			}

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
	            $order_data['shipping_telephone'] = $this->session->data['shipping_address']['telephone'];
	
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
	
	        $order_data['products'] = array();
	        foreach ($this->cart->getProducts($this->request->get['cart_ids']) as $product) {
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
	                'original_price' => $product['original_price'],
	                'total'      => $product['total'],
	                'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
	                'reward'     => $product['reward']
	            );
	        }
	
	        // Gift Voucher
	        $order_data['vouchers'] = array();
                
                /* 优化 by hwh begin 注释掉GIFT vouchers
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
                优化 by hwh end */
                
	        $order_data['comment'] = $this->session->data['comment'];
	        $order_data['total'] = $total_data['total'];
	
                 /* 优化 by hwh begin 注释affiliate
	        if (isset($this->request->cookie['tracking'])) {
	            $order_data['tracking'] = $this->request->cookie['tracking'];
	            $subtotal = $this->cart->getSubTotal();
	            $this->load->model('affiliate/affiliate');
	            $affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);
	
	            if ($affiliate_info) {
	                $order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
	                $order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
	            } else {
	                $order_data['affiliate_id'] = 0;
	                $order_data['commission'] = 0;
	            }
	
	            // Marketing
	            $this->load->model('checkout/marketing');
	            $marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);
	
	            if ($marketing_info) {
	                $order_data['marketing_id'] = $marketing_info['marketing_id'];
	            } else {
	                $order_data['marketing_id'] = 0;
	            }
	        } else {
	            $order_data['affiliate_id'] = 0;
	            $order_data['commission'] = 0;
	            $order_data['marketing_id'] = 0;
	            $order_data['tracking'] = '';
	        }
                优化 by hwh end */
                
                $order_data['affiliate_id'] = 0;
                $order_data['commission'] = 0;
                $order_data['marketing_id'] = 0;
                $order_data['tracking'] = '';
	
	        $order_data['language_id'] = $this->config->get('config_language_id');
	        $order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
	        $order_data['currency_code'] = $this->session->data['currency'];
	        $order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
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
	        $order_data['payment_type'] = $this->session->data['payment_type'];

	        $this->load->model('checkout/order');
	        $this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);

			//payment code
			$this->session->data['payment_code'] = $this->session->data['payment_method']['code'];

	        //clear cart data
	        $this->cart->clear($this->request->get['cart_ids']);
	        unset($this->session->data['addresses']);
	        unset($this->session->data['eaddress']);
	        unset($this->session->data['shipping_address']);
	        unset($this->session->data['payment_address']);
	        unset($this->session->data['shipping_method']);
	        unset($this->session->data['shipping_methods']);
	        unset($this->session->data['payment_method']);
	        unset($this->session->data['payment_methods']);
	        //unset($this->session->data['guest']);
	        unset($this->session->data['comment']);
	        unset($this->session->data['coupon']);
	        unset($this->session->data['reward']);
	        unset($this->session->data['voucher']);
	        unset($this->session->data['vouchers']);
	        unset($this->session->data['cart_ids']);
	        
	        //$json['redirect'] = $this->url->link('checkout/success', '', true);
	        $json['redirect'] = $this->url->link('checkout/confirm/view_order', '', true);
	    }

	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
	}
	
	function view_order()
	{
		$this->load->model('tool/image');

	    if(empty($this->session->data['order_id']))
	        $this->response->redirect($this->url->link('account/order'));
	        
	    $this->load->language('checkout/checkout');
	    
	    $this->document->setTitle($this->language->get('heading_title'));
            
	    $data = array();
	    $order_id = $this->session->data['order_id'];
	    $this->load->model('checkout/order');
	    $order = $this->model_checkout_order->getOrder($order_id);
	    // print_r($order);exit();
	    $data['order'] = $order;
	    
	    if(!$order || $order['order_status'] != 'Pending') 
	        $this->response->redirect($this->url->link('account/order'));

		$payment_code = $this->session->data['payment_code'];
		$data['payment_method_code'] = $payment_code;

		if(isset($payment_code) && $payment_code != 'pp_express') {
			if ($this->config->get($payment_code . '_attributes') && $this->config->get($payment_code . '_status')) {
				$payment_method_attributes = $this->config->get($payment_code . '_attributes');

				$sort_order = [];
				foreach ($payment_method_attributes as $payment_method_attribute) {
					$sort_order[] = $payment_method_attribute['sort_order'];
				}
				array_multisort($sort_order, SORT_ASC, $payment_method_attributes);
				$data['payment_method_attributes'] = $payment_method_attributes;
				$data['payment_method_image'] = $this->model_tool_image->resize($this->config->get($payment_code . '_image'), 474, 154);
			}
		}
		$data['payment'] = $this->url->link('checkout/payment', '', true);
		$data['submit_bank_receipt'] = $this->url->link('account/order/receipt', 'order_id='.$order_id, true);
        $this->load->model('checkout/order_total');
	    $data['totals'] = $this->model_checkout_order_total->getOrderTotal2($order_id,$payment_code);
	    $data['column_left'] = $this->load->controller('common/column_left');
	    $data['column_right'] = $this->load->controller('common/column_right');
	    $data['content_top'] = $this->load->controller('common/content_top');
	    $data['content_bottom'] = $this->load->controller('common/content_bottom');
	    $data['footer'] = $this->load->controller('common/footer');
	    $data['header'] = $this->load->controller('common/header');
	    $this->response->setOutput($this->load->view('checkout/view_order', $data));
	}
	
	
}
