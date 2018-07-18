<?php
class ControllerAccountOrder extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->language('account/order');

		$this->document->setTitle('My Orders');


		$data['heading_title'] = 'My Orders';

		$data['text_empty'] = $this->language->get('text_empty');

		$data['column_order_image'] = $this->language->get('column_order_image');
                $data['text_order_id'] = $this->language->get('text_order_id');
		$data['column_order_product'] = $this->language->get('column_order_product');
		$data['column_product'] = $this->language->get('column_product');  //产品总数

		$data['column_total'] = $this->language->get('column_total');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_view'] = $this->language->get('button_view');
		$data['button_continue'] = $this->language->get('button_continue');

		$url = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$limit = 10;

		$data['orders'] = array();

		$this->load->model('account/order');
		$this->load->model('tool/image');

		$order_total = $this->model_account_order->getTotalOrders();
		$results = $this->model_account_order->getOrders(($page - 1) * $limit, $limit);
		//print_r($results);exit;
		foreach ($results as $result) {
			//$product_total = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
			//$voucher_total = $this->model_account_order->getTotalOrderVouchersByOrderId($result['order_id']);
			
			$product_num = $this->model_account_order->getOrderProductNumber($result['order_id']);
			
			//根据order_id获取其中一件产品的图片和产品名字
			$order_products = $this->model_account_order->getOrderProducts($result['order_id']);
			// print_r($order_products);exit();
			foreach ($order_products as $key => $value) {
				$order_products[$key]['href']=$this->url->link('product/product', 'product_id=' . $value['product_id'], true);
				$order_products[$key]['image']=$this->model_tool_image->resize($value['image'],100,100);
				$order_products[$key]['price']=$this->currency->format($value['price'], $result['currency_code'], $result['currency_value']);
				$order_products[$key]['options']= $this->model_account_order->getOrderOptions($result['order_id'],$value['order_product_id']);
			}
			// print_r($order_product_array);exit;
			$data['totals'] = array();
			$totals = $this->model_account_order->getOrderTotals($result['order_id']);
			$total=$this->currency->format(0, $result['currency_code'], $result['currency_value']);
			foreach ($totals as $key => $value) {
				if ($value['code']=='shipping') {
					$shipping_total=$this->currency->format($value['value'], $result['currency_code'], $result['currency_value']);
				}
			}
			$data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'products'   => $order_products,
				'order_no'   => $result['order_no'],
			
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
		
				'qty'        => $product_num,
				'payment_code' => $result['payment_code'],
				'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'view'       => $this->url->link('account/order/info', 'order_id=' . $result['order_id'], true),
				'cancel_href' => $this->url->link('account/order/cancel', 'order_id=' . $result['order_id'], true),
				'repay'	      => $this->url->link('account/order/repay', 'order_id=' . $result['order_id'], true),
			
				'shipping_total'  	=> $shipping_total
			);
			
		}
		// print_r(	$data['orders']);exit;
		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('account/order', 'page={page}', true);

		$data['pagination'] = $pagination->render2();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($order_total - $limit)) ? $order_total : ((($page - 1) * $limit) + $limit), $order_total, ceil($order_total / $limit));

		$data['continue'] = $this->url->link('account/account', '', true);
		$data['whatappphone'] =$this->config->get('config_telephone');
		$data['skype'] =$this->config->get('config_skype');
		// $data['column_left'] = $this->load->controller('common/column_left');
		//$data['column_right'] = $this->load->controller('common/column_right');
		$data['account_left'] = $this->load->controller('account/left');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$data['goshopping'] = $this->url->link('common/home', '', true);

		$this->response->setOutput($this->load->view('account/order_list', $data));
	}

	public function info() {
		$this->load->language('account/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order/info', 'order_id=' . $order_id, true);
			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->load->model('account/order');
			$data['address_error']=0;
			if (isset($this->request->post['edit_address'])) {
				$error=$this->validateForm();
				
					$orderaddress=$this->request->post;
					unset($orderaddress['edit_address']);
					$this->session->orderaddress=$orderaddress;
				if (!$error) {
					 $this->model_account_order->saveOrderAddress($order_id,$orderaddress);
				}else{
					$data['address_error']=1;
				}
			

			}else{
				unset($this->session->orderaddress);
			}
	

		$order_info = $this->model_account_order->getOrder($order_id);
		// print_r($order_info);exit();

		if ($order_info) {
			$this->document->setTitle($this->language->get('text_order'));
			

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$data['heading_title'] = $this->language->get('text_order');

			$data['text_order_detail'] = $this->language->get('text_order_detail');
			$data['text_invoice_no'] = $this->language->get('text_invoice_no');
			$data['text_order_id'] = $this->language->get('text_order_id');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_shipping_address'] = $this->language->get('text_shipping_address');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['text_payment_address'] = $this->language->get('text_payment_address');
			$data['text_history'] = $this->language->get('text_history');
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_no_results'] = $this->language->get('text_no_results');

			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');
			$data['column_action'] = $this->language->get('column_action');
			$data['column_date_added'] = $this->language->get('column_date_added');
			$data['column_status'] = $this->language->get('column_status');
			$data['column_comment'] = $this->language->get('column_comment');

			$data['button_reorder'] = $this->language->get('button_reorder');
			$data['button_return'] = $this->language->get('button_return');
			$data['button_continue'] = $this->language->get('button_continue');

			if (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}
			// print_r($data['success']);exit;

			if ($order_info['invoice_no']) {
				$data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}

			//订单号 dyl add
			if ($order_info['order_no']) {
				$data['order_no'] = $order_info['order_no'];
			} else {
				$data['order_no'] = '';
			}
			if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
			$limit=10;
			$results = $this->model_account_order->getOrders(($page - 1) * $limit, $limit);
			//print_r($results);exit;
			$data['payment_code']=$results[0]['payment_code'];
			//print_r($payment_code);exit;
			$data['repay']	      = $this->url->link('account/order/repay', 'order_id=' . $order_id, true);
			$data['repay_receipt']	      = $this->url->link('account/order/repay_receipt', 'order_id=' . $order_id, true);
			$data['cancel_href'] = $this->url->link('account/order/cancel', 'order_id=' . $order_id, true);
			//订单状态 dyl add
			if ($order_info['order_status_id']) {
				$data['order_status'] = $this->checkOrderStatus($order_info['order_status_id']);
			} else {
				$data['order_status'] = '';
			}

			$data['order_id'] = $this->request->get['order_id'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));

// 			if ($order_info['payment_address_format']) {
// 				$format = $order_info['payment_address_format'];
// 			} else {
			$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}' . "\n" . '{payment_telephone}';
//			}
//var_dump($order_info);exit;
			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}',
				'{payment_telephone}'
			);

			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
				'country'   => $order_info['payment_country'],
				'payment_telephone' => $order_info['payment_telephone']
			);

			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['payment_method'] = $order_info['payment_method'];

// 			if ($order_info['shipping_address_format']) {
// 				$format = $order_info['shipping_address_format'];
// 			} else {
			$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}' . "\n" . '{shipping_telephone}';
//			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}',
				'{shipping_telephone}'
			);

			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
				'country'   => $order_info['shipping_country'],
				'shipping_telephone' => $order_info['shipping_telephone']
			);

			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
 			 //var_dump($data['shipping_address']);exit;
 			$data['replace'] = $replace;
 			//var_dump($data['replace']);exit;
			$data['shipping_method'] = $order_info['shipping_method'];

			//物流号 dyl add
			if ($order_info['shippingNumber']) {
				$data['shippingNumber'] = $order_info['shippingNumber'];
			} else {
				$data['shippingNumber'] = '';
			}

			$this->load->model('catalog/product');
			$this->load->model('tool/upload');

			// Products
			$data['products'] = array();
			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);
			//var_dump($products);exit;
			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
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

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$product_info = $this->model_catalog_product->getProduct($product['product_id']);
				if ($product_info) {
					$reorder = $this->url->link('account/order/reorder', 'order_id=' . $order_id . '&order_product_id=' . $product['order_product_id'], true);
				} else {
					$reorder = '';
				}
			//var_dump($product_info);exit;
			$this->load->model('tool/image');
		
		
			
				$data['products'][] = array(
					'order_image' => $this->model_tool_image->resize($product_info['image'],100,100),
					'name'     => $product['name'],
					'model'    => $product['model'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'price'    => $this->currency->format($product['price'] , $order_info['currency_code'], $order_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
		
					'reorder'  => $reorder,
				
					'return'   => $this->url->link('account/return/add', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], true)
				);
			
			}
 //var_dump($data['products']);exit;
			// Voucher
			$data['vouchers'] = array();
			$vouchers = $this->model_account_order->getOrderVouchers($this->request->get['order_id']);
			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}
			//var_dump($vouchers);exit;
			// Totals
			$data['totals'] = array();
			$totals = $this->model_account_order->getOrderTotals($this->request->get['order_id']);
			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
				);
				if ($total['code']=='total') {
					$data['total']= $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']);
				}
				if ($total['code']=='shipping') {
					$data['shipping_total']= $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']);
				}
			}

			$data['comment'] = nl2br($order_info['comment']);

			// History
			$data['histories'] = array();
			$results = $this->model_account_order->getOrderHistories($this->request->get['order_id']);
			foreach ($results as $result) {
				$data['histories'][] = array(
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'status'     => $result['status'],
					'comment'    => $result['notify'] ? nl2br($result['comment']) : ''
				);
			}
			//var_dump($results);exit;
			//开始
			$this->load->language('account/address');
			$data['text_edit_address'] = $this->language->get('text_edit_address');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_default'] = $this->language->get('entry_default');
		$data['entry_telephone'] = $this->language->get('entry_telephone');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_back'] = $this->language->get('button_back');
		$data['button_upload'] = $this->language->get('button_upload');

		if (isset($error['firstname'])) {
			$data['error_firstname'] = $error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($error['lastname'])) {
			$data['error_lastname'] = $error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($error['address_1'])) {
			$data['error_address_1'] = $error['address_1'];
		} else {
			$data['error_address_1'] = '';
		}

		if (isset($error['city'])) {
			$data['error_city'] = $error['city'];
		} else {
			$data['error_city'] = '';
		}

		if (isset($error['postcode'])) {
			$data['error_postcode'] = $error['postcode'];
		} else {
			$data['error_postcode'] = '';
		}

		if (isset($error['country'])) {
			$data['error_country'] = $error['country'];
		} else {
			$data['error_country'] = '';
		}

		if (isset($error['zone'])) {
			$data['error_zone'] = $error['zone'];
		} else {
			$data['error_zone'] = '';
		}
		
		if (isset($error['telephone'])) {
		    $data['error_telephone'] = $error['telephone'];
		} else {
		    $data['error_telephone'] = '';
		}
		

		if (isset($error['custom_field'])) {
			$data['error_custom_field'] = $error['custom_field'];
		} else {
			$data['error_custom_field'] = array();
		}

			//print_r($this->session->orderaddress);exit();

		if (isset($this->session->orderaddress['firstname'])) {
			$data['firstname'] = $this->session->orderaddress['firstname'];
		} elseif (!empty($order_info)) {
			$data['firstname'] = $order_info['shipping_firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->session->orderaddress['lastname'])) {
			$data['lastname'] = $this->session->orderaddress['lastname'];
		} elseif (!empty($order_info)) {
			$data['lastname'] = $order_info['shipping_lastname'];
		} else {
			$data['lastname'] = '';
		}

		// if (isset($this->session->orderaddress['company'])) {
		// 	$data['company'] = $this->session->orderaddress['company'];
		// } elseif (!empty($order_info)) {
		// 	$data['company'] = $order_info['shipping_company'];
		// } else {
		// 	$data['company'] = '';
		// }

		if (isset($this->session->orderaddress['address_1'])) {
			$data['address_1'] = $this->session->orderaddress['address_1'];
		} elseif (!empty($order_info)) {
			$data['address_1'] = $order_info['shipping_address_1'];
		} else {
			$data['address_1'] = '';
		}

		if (isset($this->session->orderaddress['address_2'])) {
			$data['address_2'] = $this->session->orderaddress['address_2'];
		} elseif (!empty($order_info)) {
			$data['address_2'] = $order_info['shipping_address_2'];
		} else {
			$data['address_2'] = '';
		}


		if (isset($this->session->orderaddress['postcode'])) {
			$data['postcode'] = $this->session->orderaddress['postcode'];
		} elseif (!empty($order_info)) {
			$data['postcode'] = $order_info['shipping_postcode'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->session->orderaddress['city'])) {
			$data['city'] = $this->session->orderaddress['city'];
		} elseif (!empty($order_info)) {
			$data['city'] = $order_info['shipping_city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->session->orderaddress['country_id'])) {
			$data['country_id'] = (int)$this->session->orderaddress['country_id'];
		}  elseif (!empty($order_info)) {
			$data['country_id'] = $order_info['shipping_country_id'];
		} else {
			$data['country_id'] = $this->config->get('config_country_id');;
		}
		// print($address_info);exit();

		if (isset($this->session->orderaddress['telephone'])) {
			$data['telephone'] = $this->session->orderaddress['telephone'];
		}  elseif (!empty($order_info)) {
			$data['telephone'] = $order_info['shipping_telephone'];
		} else {
			$data['telephone'] = '';
		}
		
		if (isset($this->session->orderaddress['zone_id'])) {
		    $data['zone_id'] = (int)$this->session->orderaddress['zone_id'];
		}  elseif (!empty($order_info)) {
		    $data['zone_id'] = $order_info['shipping_zone_id'];
		} else {
		    $data['zone_id'] = '';
		}
		$data['edit_address_url']=$this->url->link('account/order/info', 'order_id=' . $order_info['order_id'] , true);

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();
                
                // Custom fields
		$this->load->model('account/custom_field');

		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));
// print_r($data['custom_fields']);exit;
		// if (isset($this->request->post['custom_field'])) {
		// 	$data['address_custom_field'] = $this->request->post['custom_field'];
		// } elseif (isset($replace)) {
		// 	$data['address_custom_field'] = $replace['custom_field'];
		// } else {
		// 	$data['address_custom_field'] = array();
		// }

		if (isset($this->request->post['default'])) {
			$data['default'] = $this->request->post['default'];
		} elseif (isset($this->request->get['address_id'])) {
			$data['default'] = $this->customer->getAddressId() == $this->request->get['address_id'];
		} else {
			$data['default'] = false;
		}
			//结束
		$data['bank_receipt'] =$order_info['bank_receipt'];
			$data['continue'] = $this->url->link('account/order', '', true);

			$data['column_left'] = $this->load->controller('common/column_left');
			//$data['column_right'] = $this->load->controller('common/column_right');
			$data['account_left'] = $this->load->controller('account/left');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('account/order_info', $data));
		} else {
			$this->document->setTitle($this->language->get('text_order'));

			$data['heading_title'] = $this->language->get('text_order');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

		
			$data['continue'] = $this->url->link('account/order', '', true);

			$data['column_left'] = $this->load->controller('common/column_left');
			//$data['column_right'] = $this->load->controller('common/column_right');
			$data['account_left'] = $this->load->controller('account/left');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}

	public function reorder() {
		$this->load->language('account/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$this->load->model('account/order');

		$order_info = $this->model_account_order->getOrder($order_id);

		if ($order_info) {
			if (isset($this->request->get['order_product_id'])) {
				$order_product_id = $this->request->get['order_product_id'];
			} else {
				$order_product_id = 0;
			}

			$order_product_info = $this->model_account_order->getOrderProduct($order_id, $order_product_id);

			if ($order_product_info) {
				$this->load->model('catalog/product');

				$product_info = $this->model_catalog_product->getProduct($order_product_info['product_id']);

				if ($product_info) {
					$option_data = array();

					$order_options = $this->model_account_order->getOrderOptions($order_product_info['order_id'], $order_product_id);

					foreach ($order_options as $order_option) {
						if ($order_option['type'] == 'select' || $order_option['type'] == 'radio' || $order_option['type'] == 'image') {
							$option_data[$order_option['product_option_id']] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'checkbox') {
							$option_data[$order_option['product_option_id']][] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'text' || $order_option['type'] == 'textarea' || $order_option['type'] == 'date' || $order_option['type'] == 'datetime' || $order_option['type'] == 'time') {
							$option_data[$order_option['product_option_id']] = $order_option['value'];
						} elseif ($order_option['type'] == 'file') {
							$option_data[$order_option['product_option_id']] = $this->encryption->encrypt($order_option['value']);
						}
					}

					$this->cart->add($order_product_info['product_id'], $order_product_info['quantity'], $option_data);

					$this->session->data['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $product_info['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);
					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']);
				} else {
					$this->session->data['error'] = sprintf($this->language->get('error_reorder'), $order_product_info['name']);
				}
			}
		}

		$this->response->redirect($this->url->link('account/order/info', 'order_id=' . $order_id));
	}


	/**
	 * 取消订单
	 * @author  dyl  783973660@qq.com  2016.9.26
	 */
	public function cancel() {
		if (! $this->customer->isLogged()) {
			$this->session->data ['redirect'] = $this->url->link ('account/order', '', 'SSL');
			$this->response->redirect ( $this->url->link('account/login', '', 'SSL'));
		}
		if (isset ( $this->request->get['order_id'])) {
			$order_id = $this->request->get ['order_id'];
		} else {
			$order_id = 0;
		}

		$this->load->model('account/order');
		$order_info = $this->model_account_order->getOrder($order_id);
		if ($order_info && $order_info ['order_status_id'] != 1) {
			$this->session->data ['error'] = "Error";
		} else {
			$this->model_account_order->changeStatus($order_id,7);

			$email = $this->customer->getEmail();
			$config_email=$this->config->get('config_email');

			if ($email) {
				$message = "Dear ," . "\n\n";
				$message .= "Thank you for your recent order. Unfortunately, your order has been canceled. Welcome to visit our online shop again. " . "\n\n";
				$message .= "If you have any questions, please don’t hesitate to send emails to ".$config_email."" . "\n\n";
				$message .= "Best Regards. " . "\n\n";
				$message .= "Hot Beauty Hair Team. " . "\n\n";

			    $mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($email);                                                //接收人邮箱
				$mail->setFrom($this->config->get('config_mail_parameter'));         //发送人
				$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));  //发送者名字
				$mail->setSubject("Your order has been Canceled.");                  //邮件标题
				$mail->setText($message);                                            //邮件内容
				$mail->send();

			}
			if(isset($this->request->get['tips'])){
				$this->session->data ['success'] = "The product information has changed, please reorder!";
			}else{
				$this->session->data ['success'] = "The order is canceled!";
			}
			
		}

		$this->response->redirect($this->url->link('account/order/info','order_id='.$order_id));
	}

	/**
	 * 再支付
	 * @author  dyl  783973660@qq.com  2016.9.26
	 */
	public function repay(){
	   if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
	    if (isset($this->request->get['order_id'])) {
	        $order_id = $this->request->get['order_id'];
	    } else {
	        $order_id = 0;
	    }

	    $this->session->data['order_id'] = $order_id;
	    $this->load->model('account/order');
	    $order_info = $this->model_account_order->getOrderProducts($order_id);
		$this->load->model('catalog/product');
		$error=0;
	   foreach ($order_info as $result) {
			$data['order_info'][] = array(
				'quantity' => $result['quantity'],
				'product_id' => $result['product_id'],
				'price'      => $result['price']
				);				
	  
	   // $data['options'] = array();
	   // print_r( $order_info );exit;

	   $options_tem=$this->model_account_order->getOrderOptions($order_id,$result['order_product_id']);
	   $options=array();
	   foreach ($options_tem as $k => $val) {
	   	$options[$val['product_option_id']]=$val['product_option_value_id'];
	   }
 // print_r(	$options);exit;

		$price=  $this->model_catalog_product->getProductPricebyOptions($result['product_id'],$options);
		if ($price['price']!=$result['price']&&$result['price']!=$price['special']) {
			$error=1;
		}
		// print_r($price);exit;
	  
	    }
	    if($error==1){
	    	$this->response->redirect( $this->url->link('account/order/cancel', 'order_id=' . $order_id.'&tips=1', true));
	    	}else{
	    		 $this->response->redirect($this->url->link('checkout/payment'));

	    	}
	
	  
	}
	/**
	 * 再上传凭证
	 * @author  dyl  志超
	 */
	public function repay_receipt(){
	   if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
	    if (isset($this->request->get['order_id'])) {
	        $order_id = $this->request->get['order_id'];
	    } else {
	        $order_id = 0;
	    }

	    $this->session->data['order_id'] = $order_id;
	    //$this->load->model('account/order');
	    //$order_info = $this->model_account_order->getOrder($order_id);

	    $this->response->redirect($this->url->link('checkout/confirm/view_order'));
	}
	public function receipt()
	{
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
	    if (isset($this->request->get['order_id'])) {
	        $order_id = $this->request->get['order_id'];
	    } else {
	        $order_id = 0;
	    }
	   
	    $img = date("YmdHis").substr(md5(mt_rand(0,1000)),0,2).strtolower(strrchr($_FILES['bank_receipt']['name'],"."));
		$souceName = DIR_IMAGE.'/bank_receipt/'.$img;
		$imgk='../image/bank_receipt/'.$img;
		$moveRes=move_uploaded_file($_FILES['bank_receipt']['tmp_name'],$souceName);
		if ($moveRes) {
			$this->load->model('account/order');
			$this->model_account_order->submitOrderBankReceipt($order_id,$imgk);
			
		}
		 $this->response->redirect($this->url->link('account/order/info','order_id='.$order_id));

		
	}


	/**
     * 判断订单的状态
     * @author dyl 783973660@qq.com 2016.10.7
     * @param Int $orderStatusId 订单状态id
     */
	private function checkOrderStatus($orderStatusId){
	   switch($orderStatusId){
	   	  case 1:  $orderStatus='Pending'; break;
	   	  case 2:  $orderStatus='Processing'; break;
	   	  case 3:  $orderStatus='Shipped'; break;
	   	  case 5:  $orderStatus='Completed'; break;
          case 7:  $orderStatus='Canceled'; break;
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
public function delete() {
		//$this->load->language('account/wishlist');
		$order_id=$this->request->post['order_id'];
		//print_r($order_id);exit;
		$json = array();

		// if (isset($this->request->post['order_id'])) {
		// 	$product_id = $this->request->post['order_id'];
		// } else {
		// 	$order_id = 0;
		// }

		$this->load->model('account/order');

		$product_info = $this->model_account_order->getOrder($order_id);
//print_r($product_info);exit;
		if ($product_info) {
			if ($this->customer->isLogged()) {
				// Edit customers cart
				$this->load->model('account/order');

				$this->model_account_order->deleteWishlist($order_id);

				// $json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . (int)$this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));

				//$json['total'] =  $this->model_account_wishlist->getTotalWishlist();
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
  	private	function validateForm()
	{
		$error=array();
		
		 $this->load->language('account/edit');
		// $this->load->language('checkout/checkout');
		// print_r($this->request->post);exit();
		if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
					$error['firstname'] = $this->language->get('error_firstname');
				}

				if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
					$error['lastname'] = $this->language->get('error_lastname');
				}

				if ((utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
					$error['address_1'] = $this->language->get('error_address_1');
				}

				if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
				$error['city'] = $this->language->get('error_city');
				}

				
				if ((utf8_strlen(trim($this->request->post['postcode'])) < 2 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
					$error['postcode'] = $this->language->get('error_postcode');
				}

			
				
				if ((utf8_strlen(trim($this->request->post['telephone'])) < 3) || (utf8_strlen(trim($this->request->post['telephone'])) > 32)) {
				  $error['telephone'] = $this->language->get('error_telephone');
				}
			
		return $error;
	}
}