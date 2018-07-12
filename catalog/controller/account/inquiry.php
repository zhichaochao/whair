<?php
class ControllerAccountInquiry extends Controller {
	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/inquiry', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->language('account/inquiry');

		//引入该页面的css样式
		$this->document->addStyle('catalog/view/theme/default/stylesheet/account/account_inquiry.css');

		$this->document->setTitle($this->language->get('heading_title'));

		/*$data['limits'] = array();
		$limits = array_unique(array(10, 25, 50));
		sort($limits);
		foreach($limits as $value) {
			$data['limits'][] = array(
				'text'  => $value,
				'value' => $value,
				'href'  => $this->url->link('account/inquiry', $url . '&limit=' . $value)
			);
		}*/

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_empty'] = $this->language->get('text_empty');

		/*$data['column_inquiry_id'] = $this->language->get('column_inquiry_id');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_product'] = $this->language->get('column_product');
		$data['column_total'] = $this->language->get('column_total');*/

		$data['column_inquiry_id'] = 'Inquiry ID';
		$data['column_image'] = 'Image';
        $data['column_pro_name'] = 'Product Name';
		$data['column_content'] = 'Comment';
		$data['column_action'] = 'Action';

		$data['button_view'] = $this->language->get('button_view');
		$data['button_continue'] = $this->language->get('button_continue');

		$data['text_sort'] = $this->language->get('text_sort');

		$url = '';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		/*if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = 10;
		}*/

		$limit = 10;

		$data['inquirys'] = array();

		$this->load->model('account/inquiry');
        $this->load->model('tool/image');
        $this->load->model('catalog/product');

		$inquiry_total = $this->model_account_inquiry->getTotalInquirys();
		$results = $this->model_account_inquiry->getInquirys(($page - 1) * $limit, $limit);

		foreach ($results as $result) {
		    $inquirys = array(
				'inquiry_id'  => $result['inquiry_id'],
				'image'       => $this->model_tool_image->resize($result['image'], 40, 40),    //产品图片
				'pro_name'    => $result['pro_name'],      //产品名字
				//'coun_name'   => $result['coun_name'],     //国家名字
				//'name'        => $result['name'],          //名字
				//'email'       => $result['email'],
				//'fixed_line'  => $result['fixed_line'],
				//'country_id'  => $result['country_id'],
				//'phone'       => $result['phone'],
				'content'     => $result['content'],
				//'add_time'    => $result['add_time'],
				'remove'	  => $this->url->link('account/inquiry/delinquiry', 'inquiry_id=' . $result['inquiry_id'], true)
			);
			if($result['product_id']){
                $product = $this->model_catalog_product->getProduct($result['product_id']);
                if($product){
                    $inquirys['view'] = $this->url->link('product/product', 'product_id=' . $result['product_id'], true);
                    $inquirys['price'] = $product['price'];
                    $inquirys['special'] = $product['special'];
                }
			}
			$data['inquirys'][] = $inquirys;
		}

		//$this->load->model('module/paginationdh');
		//$pagination = new ModelModulePaginationdh();
		$pagination = new Pagination();
		$pagination->total = $inquiry_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('account/inquiry', 'page={page}', true);

		$data['pagination'] = $pagination->render2();
		//$data['results'] = sprintf($this->language->get('text_pagination'), ($inquiry_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($inquiry_total - $limit)) ? $inquiry_total : ((($page - 1) * $limit) + $limit), $inquiry_total, ceil($inquiry_total / $limit));
		$data['results'] = sprintf($this->language->get('text_pagination'), ($inquiry_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($inquiry_total - $limit)) ? $inquiry_total : ((($page - 1) * $limit) + $limit), $inquiry_total, ceil($inquiry_total / $limit));

		//$data['continue'] 		= $this->url->link('account/account', '', 'SSL');
		//$data['limit']			= $limit;

        //删除成功提示  dyl add
		if (isset($this->session->data['del_success'])) {
		   $data['del_success'] = $this->session->data['del_success'];
		   unset($this->session->data['del_success']);
	    } else {
		   $data['del_success'] = '';
        }

        //删除失败提示  dyl add
		if (isset($this->session->data['del_error'])) {
		   $data['del_error'] = $this->session->data['del_error'];
		   unset($this->session->data['del_error']);
	    } else {
		   $data['del_error'] = '';
        }

		$data['account_left'] 	= $this->load->controller('account/left');
		$data['column_left'] 	= $this->load->controller('common/column_left');
		//$data['column_right'] 	= $this->load->controller('common/column_right');
		$data['account_left'] 	= $this->load->controller('account/left');
		$data['content_top'] 	= $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] 		= $this->load->controller('common/footer');
		$data['header'] 		= $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/inquiry_list', $data));
	}

	public function info() {
		$this->load->language('account/inquiry');

		if (isset($this->request->get['inquiry_id'])) {
			$inquiry_id = $this->request->get['inquiry_id'];
		} else {
			$inquiry_id = 0;
		}

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/inquiry/info', 'inquiry_id=' . $inquiry_id, 'SSL');

			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/inquiry');

		$inquiry_info = $this->model_account_inquiry->getOrder($inquiry_id);

		if ($inquiry_info) {
			$this->document->setTitle($this->language->get('text_inquiry'));

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_account'),
				'href' => $this->url->link('account/account', '', 'SSL')
			);

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('account/inquiry', $url, 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_inquiry'),
				'href' => $this->url->link('account/inquiry/info', 'inquiry_id=' . $this->request->get['inquiry_id'] . $url, 'SSL')
			);

			$this->document->addStyle('catalog/view/theme/desktop/stylesheet/account.css');
			$this->document->addStyle('catalog/view/theme/desktop/stylesheet/search.css');

			$data['heading_title'] = $this->language->get('text_inquiry');

			$data['text_inquiry_detail'] = $this->language->get('text_inquiry_detail');
			$data['text_invoice_no'] = $this->language->get('text_invoice_no');
			$data['text_inquiry_id'] = $this->language->get('text_inquiry_id');
			$data['text_date_added'] = $this->language->get('text_date_added');
			$data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$data['text_shipping_address'] = $this->language->get('text_shipping_address');
			$data['text_payment_method'] = $this->language->get('text_payment_method');
			$data['text_payment_address'] = $this->language->get('text_payment_address');
			$data['text_history'] = $this->language->get('text_history');
			$data['text_comment'] = $this->language->get('text_comment');

			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');
			$data['column_action'] = $this->language->get('column_action');
			$data['column_date_added'] = $this->language->get('column_date_added');
			$data['column_status'] = $this->language->get('column_status');
			$data['column_comment'] = $this->language->get('column_comment');

			$data['button_reinquiry'] = $this->language->get('button_reinquiry');
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

			if ($inquiry_info['invoice_no']) {
				$data['invoice_no'] = $inquiry_info['invoice_prefix'] . $inquiry_info['invoice_no'];
			} else {
				$data['invoice_no'] = '';
			}

			$data['inquiry_id'] = $this->request->get['inquiry_id'];
			$data['inquiry_no'] = $inquiry_info['inquiry_no'];
			$data['date_added'] = date($this->language->get('date_format_short'), strtotime($inquiry_info['date_added']));

			if ($inquiry_info['payment_address_format']) {
				$format = $inquiry_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

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
				'{country}'
			);

			$replace = array(
				'firstname' => $inquiry_info['payment_firstname'],
				'lastname'  => $inquiry_info['payment_lastname'],
				'company'   => $inquiry_info['payment_company'],
				'address_1' => $inquiry_info['payment_address_1'],
				'address_2' => $inquiry_info['payment_address_2'],
				'city'      => $inquiry_info['payment_city'],
				'postcode'  => $inquiry_info['payment_postcode'],
				'zone'      => $inquiry_info['payment_zone'],
				'zone_code' => $inquiry_info['payment_zone_code'],
				'country'   => $inquiry_info['payment_country']
			);

			$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['payment_method'] = $inquiry_info['payment_method'];

			if ($inquiry_info['shipping_address_format']) {
				$format = $inquiry_info['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

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
				'{country}'
			);

			$replace = array(
				'firstname' => $inquiry_info['shipping_firstname'],
				'lastname'  => $inquiry_info['shipping_lastname'],
				'company'   => $inquiry_info['shipping_company'],
				'address_1' => $inquiry_info['shipping_address_1'],
				'address_2' => $inquiry_info['shipping_address_2'],
				'city'      => $inquiry_info['shipping_city'],
				'postcode'  => $inquiry_info['shipping_postcode'],
				'zone'      => $inquiry_info['shipping_zone'],
				'zone_code' => $inquiry_info['shipping_zone_code'],
				'country'   => $inquiry_info['shipping_country']
			);

			$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$data['shipping_method'] = $inquiry_info['shipping_method'];

			$data['telephone'] = $inquiry_info['telephone'];

			$this->load->model('catalog/product');
			$this->load->model('tool/upload');

			// Products
			$data['products'] = array();

			$products = $this->model_account_inquiry->getOrderProducts($this->request->get['inquiry_id']);

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_account_inquiry->getOrderOptions($this->request->get['inquiry_id'], $product['inquiry_product_id']);

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
					$reinquiry = $this->url->link('account/inquiry/reinquiry', 'inquiry_id=' . $inquiry_id . '&inquiry_product_id=' . $product['inquiry_product_id'], 'SSL');
				} else {
					$reinquiry = '';
				}

				$data['products'][] = array(
					'name'     => $product['name'],
					'model'    => $product['model'],
					'option'   => $option_data,
					'quantity' => $product['quantity'],
					'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $inquiry_info['currency_code'], $inquiry_info['currency_value']),
					'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $inquiry_info['currency_code'], $inquiry_info['currency_value']),
					'reinquiry'  => $reinquiry,
					'return'   => $this->url->link('account/return/add', 'inquiry_id=' . $inquiry_info['inquiry_id'] . '&product_id=' . $product['product_id'], 'SSL')
				);
			}

			// Voucher
			$data['vouchers'] = array();

			$vouchers = $this->model_account_inquiry->getOrderVouchers($this->request->get['inquiry_id']);

			foreach ($vouchers as $voucher) {
				$data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $inquiry_info['currency_code'], $inquiry_info['currency_value'])
				);
			}

			// Totals
			$data['totals'] = array();

			$totals = $this->model_account_inquiry->getOrderTotals($this->request->get['inquiry_id']);

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $inquiry_info['currency_code'], $inquiry_info['currency_value']),
				);
			}

			$data['comment'] = nl2br($inquiry_info['comment']);

			// History
			$data['histories'] = array();

			$results = $this->model_account_inquiry->getOrderHistories($this->request->get['inquiry_id']);

			foreach ($results as $result) {
				$data['histories'][] = array(
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'status'     => $result['status'],
					'comment'    => $result['notify'] ? nl2br($result['comment']) : ''
				);
			}

			$data['continue'] = $this->url->link('account/inquiry', '', 'SSL');

			$data['account_left'] 	= $this->load->controller('account/left');
			$data['column_left'] 	= $this->load->controller('common/column_left');
			//$data['column_right'] 	= $this->load->controller('common/column_right');
			$data['account_left'] 	= $this->load->controller('account/left');
			$data['content_top'] 	= $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

		    $this->response->setOutput($this->load->view('account/inquiry_info', $data));
		} else {
			$this->document->setTitle($this->language->get('text_inquiry'));

			$data['heading_title'] = $this->language->get('text_inquiry');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_account'),
				'href' => $this->url->link('account/account', '', 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('account/inquiry', '', 'SSL')
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_inquiry'),
				'href' => $this->url->link('account/inquiry/info', 'inquiry_id=' . $inquiry_id, 'SSL')
			);

			$data['continue'] = $this->url->link('account/inquiry', '', 'SSL');

			$data['column_left'] = $this->load->controller('common/column_left');
			//$data['column_right'] = $this->load->controller('common/column_right');
			$data['account_left'] 	= $this->load->controller('account/left');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}

	public function reinquiry() {
		$this->load->language('account/inquiry');

		if (isset($this->request->get['inquiry_id'])) {
			$inquiry_id = $this->request->get['inquiry_id'];
		} else {
			$inquiry_id = 0;
		}

		$this->load->model('account/inquiry');

		$inquiry_info = $this->model_account_inquiry->getOrder($inquiry_id);

		if ($inquiry_info) {
			if (isset($this->request->get['inquiry_product_id'])) {
				$inquiry_product_id = $this->request->get['inquiry_product_id'];
			} else {
				$inquiry_product_id = 0;
			}

			$productlist = $this->model_account_inquiry->getOrderProducts($inquiry_id);


			foreach($productlist as $productlist){

				$inquiry_product_info = $this->model_account_inquiry->getOrderProduct($inquiry_id, $productlist['inquiry_product_id']);

				if ($inquiry_product_info) {
					$this->load->model('catalog/product');

					$product_info = $this->model_catalog_product->getProduct($inquiry_product_info['product_id']);

					if ($product_info) {
						$option_data = array();

						$inquiry_options = $this->model_account_inquiry->getOrderOptions($inquiry_product_info['inquiry_id'], $inquiry_product_id);

						foreach ($inquiry_options as $inquiry_option) {
							if ($inquiry_option['type'] == 'select' || $inquiry_option['type'] == 'radio' || $inquiry_option['type'] == 'image') {
								$option_data[$inquiry_option['product_option_id']] = $inquiry_option['product_option_value_id'];
							} elseif ($inquiry_option['type'] == 'checkbox') {
								$option_data[$inquiry_option['product_option_id']][] = $inquiry_option['product_option_value_id'];
							} elseif ($inquiry_option['type'] == 'text' || $inquiry_option['type'] == 'textarea' || $inquiry_option['type'] == 'date' || $inquiry_option['type'] == 'datetime' || $inquiry_option['type'] == 'time') {
								$option_data[$inquiry_option['product_option_id']] = $inquiry_option['value'];
							} elseif ($inquiry_option['type'] == 'file') {
								$option_data[$inquiry_option['product_option_id']] = $this->encryption->encrypt($inquiry_option['value']);
							}
						}

						$this->cart->add($inquiry_product_info['product_id'], $inquiry_product_info['quantity'], $option_data);

						$this->session->data['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $product_info['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

						unset($this->session->data['shipping_method']);
						unset($this->session->data['shipping_methods']);
						unset($this->session->data['payment_method']);
						unset($this->session->data['payment_methods']);
					} else {
						$this->session->data['error'] = sprintf($this->language->get('error_reinquiry'), $inquiry_product_info['name']);
					}
				}
			}
		}

		//$this->response->redirect($this->url->link('account/inquiry/info', 'inquiry_id=' . $inquiry_id));
		$this->response->redirect($this->url->link('checkout/cart'));
	}

	public function addCart(){
		$this->load->language('account/inquiry');

		if (isset($this->request->post['inquiry_id'])) {
			$inquiry_id = $this->request->post['inquiry_id'];
		} else {
			$inquiry_id = 0;
		}


		$this->load->model('account/inquiry');

		if (isset($this->request->post['inquiry_product_id'])) {
			$inquiry_product_id = $this->request->post['inquiry_product_id'];
		} else {
			$inquiry_product_id = 0;
		}


		foreach($inquiry_product_id as $inquiry_product_id){

			$inquiry_product_info = $this->model_account_inquiry->getOrderProduct($inquiry_id, $inquiry_product_id);

			if ($inquiry_product_info) {
				$this->load->model('catalog/product');

				$product_info = $this->model_catalog_product->getProduct($inquiry_product_info['product_id']);

				if ($product_info) {
					$option_data = array();

					$inquiry_options = $this->model_account_inquiry->getOrderOptions($inquiry_product_info['inquiry_id'], $inquiry_product_id);

					foreach ($inquiry_options as $inquiry_option) {
						if ($inquiry_option['type'] == 'select' || $inquiry_option['type'] == 'radio' || $inquiry_option['type'] == 'image') {
							$option_data[$inquiry_option['product_option_id']] = $inquiry_option['product_option_value_id'];
						} elseif ($inquiry_option['type'] == 'checkbox') {
							$option_data[$inquiry_option['product_option_id']][] = $inquiry_option['product_option_value_id'];
						} elseif ($inquiry_option['type'] == 'text' || $inquiry_option['type'] == 'textarea' || $inquiry_option['type'] == 'date' || $inquiry_option['type'] == 'datetime' || $inquiry_option['type'] == 'time') {
							$option_data[$inquiry_option['product_option_id']] = $inquiry_option['value'];
						} elseif ($inquiry_option['type'] == 'file') {
							$option_data[$inquiry_option['product_option_id']] = $this->encryption->encrypt($inquiry_option['value']);
						}
					}

					$this->cart->add($inquiry_product_info['product_id'], $inquiry_product_info['quantity'], $option_data);

					$this->session->data['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $product_info['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);
					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']);
				} else {
					$this->session->data['error'] = sprintf($this->language->get('error_reinquiry'), $inquiry_product_info['name']);
				}
			}
		}

		//$this->response->redirect($this->url->link('account/inquiry/info', 'inquiry_id=' . $inquiry_id));
		$this->response->redirect($this->url->link('checkout/cart'));
	}

    /**
     * 用户中心删除询盘
     * @author  dyl  783973660@qq.com  2016.9.27
     */
    public function delinquiry(){

    	if (isset($this->request->get['inquiry_id'])) {
	        $inquiry_id = $this->request->get['inquiry_id'];
	    } else {
	        $inquiry_id = 0;
	    }
	    $this->load->model('account/inquiry');
	    $result = $this->model_account_inquiry->delinquiry($inquiry_id);
	    if($result){
           //$this->error['del_success'] = 'Delete success!';
           $this->session->data['del_success'] = 'Delete success!';
	    }else{
	       //$this->error['del_error'] = 'Delete failed!';
	       $this->session->data['del_error'] = 'Delete failed!';
	    }

	    $this->response->redirect($this->url->link('account/inquiry'));
    }

}