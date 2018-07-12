<?php
class ControllerCheckoutShippingAddress extends Controller {
	public function index() {

	    $this->load->language('account/edit');
		$this->load->language('checkout/checkout');

		$data['text_address_existing'] = $this->language->get('text_address_existing');
		$data['text_address_new'] = $this->language->get('text_address_new');
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
		$data['entry_telephone'] = $this->language->get('entry_telephone');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_upload'] = $this->language->get('button_upload');
		
		$address_id = isset($this->request->get['address_id'])?(int)$this->request->get['address_id']:0;

		$this->load->model('account/address');
		$data['addresses'] = $this->model_account_address->getAddresses();
		$data['eaddress'] = '';
		if($address_id){
		    $data['eaddress'] = $this->model_account_address->getAddress($address_id);
		}elseif(!$this->customer->isLogged()){
		    if(isset($this->session->data['shipping_address'])){
		        $data['eaddress'] = $this->session->data['shipping_address'];
		    }elseif(isset($this->session->data['payment_address'])){
		        $data['eaddress'] = $this->session->data['payment_address'];
		        $this->session->data['shipping_address'] = $this->session->data['payment_address'];
		    }
		}
		
		if (isset($this->session->data['shipping_address']['address_id'])) {
			$data['address_id'] = $this->session->data['shipping_address']['address_id'];
		} elseif($this->customer->getAddressId() && !empty($data['addresses'])) {
		    $address = $this->model_account_address->getAddress($this->customer->getAddressId());
		    if(empty($address)) $address = current($data['addresses']);
			$data['address_id'] = $address['address_id'];
			$this->session->data['shipping_address'] = $address;
		} elseif (!empty($data['addresses'])){
		    $this->session->data['shipping_address'] = current($data['addresses']);
		    $data['address_id'] = $this->session->data['shipping_address']['address_id'];
	    } else {
		    $data['address_id'] = '';
		}

		if(!empty($this->session->data['shipping_address']) && !empty($this->session->data['same_as_shipping']))
	        $this->session->data['payment_address'] = $this->session->data['shipping_address'];//默认账单地址与发货地址一致

		if (isset($this->session->data['shipping_address']['postcode'])) {
			$data['postcode'] = $this->session->data['shipping_address']['postcode'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->session->data['shipping_address']['country_id'])) {
			$data['country_id'] = $this->session->data['shipping_address']['country_id'];
		} else {
			$data['country_id'] = $this->config->get('config_country_id');
		}

	    if (isset($this->session->data['shipping_address']['zone_id'])) {
			$data['zone_id'] = $this->session->data['shipping_address']['zone_id'];
		} else {
			$data['zone_id'] = '';
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		// Custom Fields
		$this->load->model('account/custom_field');

		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

		if (isset($this->session->data['shipping_address']['custom_field'])) {
			$data['shipping_address_custom_field'] = $this->session->data['shipping_address']['custom_field'];
		} else {
			$data['shipping_address_custom_field'] = array();
		}
		$data['payment_address'] = isset($this->session->data['payment_address'])?$this->session->data['payment_address']:'';
		$data['shipping_address'] = isset($this->session->data['shipping_address'])?$this->session->data['shipping_address']:'';
		$data['payment_type'] = isset($this->session->data['payment_type'])?$this->session->data['payment_type']:'';
		
// print_r($data);exit();
		$this->response->setOutput($this->load->view('checkout/shipping_address', $data));
	}

	public function save() {
	    
	    $this->load->language('account/edit');
		$this->load->language('checkout/checkout');

		$json = array();

		// Validate if shipping is required. If not the customer should not have reached this page.
		if (!$this->cart->hasShipping()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', true);
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
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
				$json['redirect'] = $this->url->link('checkout/cart');

				break;
			}
		}

		if (!$json) {
			if (isset($this->request->post['shipping_address']) && $this->request->post['shipping_address'] == 'existing') {
				$this->load->model('account/address');

				if (empty($this->request->post['address_id'])) {
					$json['error']['warning'] = $this->language->get('error_address');
				} elseif (!in_array($this->request->post['address_id'], array_keys($this->model_account_address->getAddresses()))) {
					$json['error']['warning'] = $this->language->get('error_address');
				}

				if (!$json) {
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->request->post['address_id']);
					if(!empty($this->session->data['same_as_shipping']))
					   $this->session->data['payment_address'] = $this->session->data['shipping_address'];//账单地址与发货地址一致
				}
			} else {
				if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
					$json['error']['firstname'] = $this->language->get('error_firstname');
				}

				if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
					$json['error']['lastname'] = $this->language->get('error_lastname');
				}

				if ((utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
					$json['error']['address_1'] = $this->language->get('error_address_1');
				}

				if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
					$json['error']['city'] = $this->language->get('error_city');
				}

				$this->load->model('localisation/country');

				$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

				if ($country_info && $country_info['postcode_required'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
					$json['error']['postcode'] = $this->language->get('error_postcode');
				}

				if ($this->request->post['country_id'] == '') {
					$json['error']['country'] = $this->language->get('error_country');
				}

				if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '' || !is_numeric($this->request->post['zone_id'])) {
					$json['error']['zone'] = $this->language->get('error_zone');
				}
				
				if ((utf8_strlen(trim($this->request->post['telephone'])) < 3) || (utf8_strlen(trim($this->request->post['telephone'])) > 32)) {
				    $json['error']['telephone'] = $this->language->get('error_telephone');
				}
				

				// Custom field validation
				$this->load->model('account/custom_field');

				$custom_fields = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

				foreach ($custom_fields as $custom_field) {
					if (($custom_field['location'] == 'address') && $custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['custom_field_id']])) {
						$json['error']['custom_field' . $custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
					} elseif (($custom_field['location'] == 'address') && ($custom_field['type'] == 'text') && !empty($custom_field['validation']) && !filter_var($this->request->post['custom_field'][$custom_field['custom_field_id']], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $custom_field['validation'])))) {
                        $json['error']['custom_field' . $custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
                    }
				}

				if (!$json) {
				    if ($this->customer->isLogged()) {
    					$this->load->model('account/address');
    					$address_id = (int)$this->request->get['address_id'];
    					if($address_id){
    					    $this->model_account_address->editAddress($address_id, $this->request->post);
    					}else{
    					   $address_id = $this->model_account_address->addAddress($this->request->post);
    					}
    					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($address_id);
    					if(!empty($this->session->data['same_as_shipping']))
    					   $this->session->data['payment_address'] = $this->session->data['shipping_address'];//默认账单地址与发货地址一致
    					    
    					if ($this->config->get('config_customer_activity')) {
    						$this->load->model('account/activity');
    						$activity_data = array(
    							'customer_id' => $this->customer->getId(),
    							'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
    						);
    						$this->model_account_activity->addActivity('address_add', $activity_data);
    					}
				    }else{
				        $data = $this->request->post;
				        if(empty($data['zone']) && !empty($data['zone_id'])){
				            $this->load->model('localisation/zone');
				            $zone_info = $this->model_localisation_zone->getZone($data['zone_id']);
				            if(!empty($zone_info['name'])) $data['zone'] = $zone_info['name'];
				        }
				        if(empty($data['country']) && !empty($data['country_id'])){
				            $this->load->model('localisation/country');
				            $country_info = $this->model_localisation_country->getCountry($data['country_id']);
				            if(!empty($country_info['name'])) $data['country'] = $country_info['name'];
				        }
				        $this->session->data['shipping_address'] = $data;
				        if(!empty($this->session->data['same_as_shipping']))
				            $this->session->data['payment_address'] = $this->session->data['shipping_address'];//默认账单地址与发货地址一致
				     }
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function changeAddress() {
	    if (!$this->customer->isLogged()) {
	        $this->session->data['redirect'] = $this->url->link('checkout/checkout', '', true);
	        $this->response->redirect($this->url->link('account/login', '', true));
	    }
	
	    $json = array();
	
	    if (isset($this->request->get['address_id'])) {
	        $this->load->model('account/address');
	        $this->session->data['shipping_address'] = $this->model_account_address->getAddress((int)$this->request->get['address_id']);
	        if(!empty($this->session->data['same_as_shipping']))
	            $this->session->data['payment_address'] = $this->session->data['shipping_address'];//默认账单地址与发货地址一致
	    }else{
	        $json['error'] = 'failed';
	    }
	
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
	
	}

	public function setDefault() {
	    if (!$this->customer->isLogged()) {
	        $this->session->data['redirect'] = $this->url->link('checkout/checkout', '', true);
	        $this->response->redirect($this->url->link('account/login', '', true));
	    }
	     
	    $json = array();
	     
	    if (isset($this->request->get['address_id'])) {
	        $this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$this->request->get['address_id'] . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");

	        $this->load->model('account/address');
	        $this->session->data['shipping_address'] = $this->model_account_address->getAddress((int)$this->request->get['address_id']);
	        if(!empty($this->session->data['same_as_shipping']))
	            $this->session->data['payment_address'] = $this->session->data['shipping_address'];//默认账单地址与发货地址一致
	    }else{
	        $json['error'] = 'failed';
	    }
	
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
	
	}
		
	public function delete() {
	    if (!$this->customer->isLogged()) {
	        $this->session->data['redirect'] = $this->url->link('checkout/checkout', '', true);
	        $this->response->redirect($this->url->link('account/login', '', true));
	    }
	
	    $this->load->language('account/address');
	    $this->load->model('account/address');
	    $json = array();
	    
	    if ($this->model_account_address->getTotalAddresses() == 1) {
	        $json['error'] = $this->language->get('error_delete');
	    }
	    
	    if ($this->customer->getAddressId() == $this->request->get['address_id']) {
	        $json['error'] = $this->language->get('error_default');
	    }
	
	    if (isset($this->request->get['address_id']) && !$json) {
	        $this->model_account_address->deleteAddress($this->request->get['address_id']);
	
	        // Default Shipping Address
	        if (isset($this->session->data['shipping_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address']['address_id'])) {
	            unset($this->session->data['shipping_address']);
	            unset($this->session->data['shipping_method']);
	            unset($this->session->data['shipping_methods']);
	        }
	
	        // Default Payment Address
	        if (isset($this->session->data['payment_address']['address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address']['address_id'])) {
	            unset($this->session->data['payment_address']);
	            unset($this->session->data['payment_method']);
	            unset($this->session->data['payment_methods']);
	        }
	
	        $this->session->data['success'] = $this->language->get('text_delete');
	
	        // Add to activity log
	        if ($this->config->get('config_customer_activity')) {
	            $this->load->model('account/activity');
	
	            $activity_data = array(
	                'customer_id' => $this->customer->getId(),
	                'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
	            );
	
	            $this->model_account_activity->addActivity('address_delete', $activity_data);
	        }
	
	    }
	    
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
	    
	}

	
}