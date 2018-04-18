<?php
class ModelCheckoutOrder extends Model {
	public function addOrder($data) {
		//$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_company = '" . $this->db->escape($data['payment_company']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_country_id = '" . (int)$data['payment_country_id'] . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', payment_zone_id = '" . (int)$data['payment_zone_id'] . "', payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', payment_custom_field = '" . $this->db->escape(isset($data['payment_custom_field']) ? json_encode($data['payment_custom_field']) : '') . "', payment_method = '" . $this->db->escape($data['payment_method']) . "', payment_code = '" . $this->db->escape($data['payment_code']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', shipping_custom_field = '" . $this->db->escape(isset($data['shipping_custom_field']) ? json_encode($data['shipping_custom_field']) : '') . "', shipping_method = '" . $this->db->escape($data['shipping_method']) . "', shipping_code = '" . $this->db->escape($data['shipping_code']) . "', comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', marketing_id = '" . (int)$data['marketing_id'] . "', tracking = '" . $this->db->escape($data['tracking']) . "', language_id = '" . (int)$data['language_id'] . "', currency_id = '" . (int)$data['currency_id'] . "', currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float)$data['currency_value'] . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW()");

		$order_status_id = $this->config->get('config_order_status_id');
		$sql = "INSERT INTO `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "',
				store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "',
			    store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "',
			    customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "',
			    lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "',
			    telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "',
			    custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "',
			    payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "',
			    payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "',
			    payment_company = '" . $this->db->escape($data['payment_company']) . "',
			    payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "',
			    payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "',
			    payment_city = '" . $this->db->escape($data['payment_city']) . "',
			    payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "',
			    payment_country = '" . $this->db->escape($data['payment_country']) . "',
			    payment_country_id = '" . (int)$data['payment_country_id'] . "',
			    payment_zone = '" . $this->db->escape($data['payment_zone']) . "',
			    payment_zone_id = '" . (int)$data['payment_zone_id'] . "',
			    payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "',
			    payment_custom_field = '" . $this->db->escape(isset($data['payment_custom_field']) ? json_encode($data['payment_custom_field']) : '') . "',
			    payment_method = '" . $this->db->escape($data['payment_method']) . "',
			    payment_code = '" . $this->db->escape($data['payment_code']) . "',
			    payment_telephone = '" . $this->db->escape($data['payment_telephone']) . "',
			    shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "',
			    shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "',
			    shipping_company = '" . $this->db->escape($data['shipping_company']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "',
			    shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "',
			    shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "',
			    shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_country_id = '" . (int)$data['shipping_country_id'] . "',
			    shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "',
			    shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', 
		        shipping_custom_field = '" . $this->db->escape(isset($data['shipping_custom_field']) ? json_encode($data['shipping_custom_field']) : '') . "',
			    shipping_method = '" . $this->db->escape($data['shipping_method']) . "',
			    shipping_code = '" . $this->db->escape($data['shipping_code']) . "', 
			    shipping_telephone = '" . $this->db->escape($data['shipping_telephone']) . "', 
		        comment = '" . $this->db->escape($data['comment']) . "', payment_type = '" . $this->db->escape($data['payment_type']) . "', total = '" . (float)$data['total'] . "',
			    affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', marketing_id = '" . (int)$data['marketing_id'] . "',
			    tracking = '" . $this->db->escape($data['tracking']) . "',
			    language_id = '" . (int)$data['language_id'] . "', currency_id = '" . (int)$data['currency_id'] . "',
			    currency_code = '" . $this->db->escape($data['currency_code']) . "', currency_value = '" . (float)$data['currency_value'] . "', ip = '" . $this->db->escape($data['ip']) . "',
			    forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "',
			    accept_language = '" . $this->db->escape($data['accept_language']) . "', order_status_id = '" . $order_status_id . "', date_added = NOW(), date_modified = NOW()";
        $this->db->query($sql);

		$order_id = $this->db->getLastId();

		//订单号 dyl加
		if($order_id){
           //$order_no = $data['invoice_prefix'] . $order_id;
           //$order_no = $data['invoice_prefix'] .substr(str_replace('.','',microtime(true)),0,13).rand(10,99);
           $order_no = $data['invoice_prefix'] . time(). rand(10,99);
           $this->db->query("UPDATE " . DB_PREFIX . "order SET order_no = '" . $order_no . "' WHERE order_id = '" . (int)$order_id . "'");
        }
        //订单号,end

		// Products
		if (isset($data['products'])) {
			foreach ($data['products'] as $product) {
			    $sql = "INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id']
				    . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity']
				    . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'";
			    if(isset($product['original_price'])) $sql .= ", original_price = '" . (float)$product['original_price'] . "'";
				$this->db->query($sql);
				$order_product_id = $this->db->getLastId();

				foreach ($product['option'] as $option) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
				}
			}
		}

		// Gift Voucher
                /* 优化 by hwh begin 注释掉暂时没用的功能(Gift Voucher)
		$this->load->model('extension/total/voucher');

		// Vouchers
               
		if (isset($data['vouchers'])) {
			foreach ($data['vouchers'] as $voucher) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($voucher['description']) . "', code = '" . $this->db->escape($voucher['code']) . "', from_name = '" . $this->db->escape($voucher['from_name']) . "', from_email = '" . $this->db->escape($voucher['from_email']) . "', to_name = '" . $this->db->escape($voucher['to_name']) . "', to_email = '" . $this->db->escape($voucher['to_email']) . "', voucher_theme_id = '" . (int)$voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($voucher['message']) . "', amount = '" . (float)$voucher['amount'] . "'");

				$order_voucher_id = $this->db->getLastId();

				$voucher_id = $this->model_extension_total_voucher->addVoucher($order_id, $voucher);

				$this->db->query("UPDATE " . DB_PREFIX . "order_voucher SET voucher_id = '" . (int)$voucher_id . "' WHERE order_voucher_id = '" . (int)$order_voucher_id . "'");
			}
		}
                优化 by hwh end */

		// Totals
		if (isset($data['totals'])) {
			foreach ($data['totals'] as $total) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
			}
		}

		return $order_id;
	}

	public function editOrder($order_id, $data) {
		// Void the order first
		//$this->addOrderHistory($order_id, 0);

		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', 
		    store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', 
		    store_url = '" . $this->db->escape($data['store_url']) . "', customer_id = '" . (int)$data['customer_id'] . "', 
		    customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', 
		    lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', 
		    telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', 
		    custom_field = '" . $this->db->escape(json_encode($data['custom_field'])) . "', 
		    payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', 
		    payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', 
		    payment_company = '" . $this->db->escape($data['payment_company']) . "', 
		    payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', 
		    payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', 
		    payment_city = '" . $this->db->escape($data['payment_city']) . "', 
		    payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', 
		    payment_country = '" . $this->db->escape($data['payment_country']) . "', 
		    payment_country_id = '" . (int)$data['payment_country_id'] . "', 
		    payment_zone = '" . $this->db->escape($data['payment_zone']) . "', 
		    payment_zone_id = '" . (int)$data['payment_zone_id'] . "', 
		    payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', 
		    payment_custom_field = '" . $this->db->escape(json_encode($data['payment_custom_field'])) . "', 
		    payment_method = '" . $this->db->escape($data['payment_method']) . "', 
		    payment_code = '" . $this->db->escape($data['payment_code']) . "', 
		    shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', 
		    shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', 
		    shipping_company = '" . $this->db->escape($data['shipping_company']) . "', 
		    shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', 
		    shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', 
		    shipping_city = '" . $this->db->escape($data['shipping_city']) . "', 
		    shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', 
		    shipping_country = '" . $this->db->escape($data['shipping_country']) . "', 
		    shipping_country_id = '" . (int)$data['shipping_country_id'] . "', 
		    shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', 
		    shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', 
		    shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', 
		    shipping_custom_field = '" . $this->db->escape(json_encode($data['shipping_custom_field'])) . "', 
		    shipping_method = '" . $this->db->escape($data['shipping_method']) . "', 
		    shipping_code = '" . $this->db->escape($data['shipping_code']) . "', 
		    comment = '" . $this->db->escape($data['comment']) . "', total = '" . (float)$data['total'] . "', 
		    affiliate_id = '" . (int)$data['affiliate_id'] . "', commission = '" . (float)$data['commission'] . "', 
		    date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "'");

		// Products
		if (isset($data['products'])) {
			foreach ($data['products'] as $product) {
				 $sql = "INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id']
				    . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity']
				    . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'";
			    if(isset($product['original_price'])) $sql .= ", original_price = '" . (float)$product['original_price'] . "'";
				$this->db->query($sql);
				$order_product_id = $this->db->getLastId();

				foreach ($product['option'] as $option) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
				}
			}
		}

		// Gift Voucher
                /* 优化 by hwh begin 注释掉暂时没用的功能(Gift Voucher)
		$this->load->model('extension/total/voucher');

		$this->model_extension_total_voucher->disableVoucher($order_id);

		// Vouchers
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

		if (isset($data['vouchers'])) {
			foreach ($data['vouchers'] as $voucher) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($voucher['description']) . "', code = '" . $this->db->escape($voucher['code']) . "', from_name = '" . $this->db->escape($voucher['from_name']) . "', from_email = '" . $this->db->escape($voucher['from_email']) . "', to_name = '" . $this->db->escape($voucher['to_name']) . "', to_email = '" . $this->db->escape($voucher['to_email']) . "', voucher_theme_id = '" . (int)$voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($voucher['message']) . "', amount = '" . (float)$voucher['amount'] . "'");

				$order_voucher_id = $this->db->getLastId();

				$voucher_id = $this->model_extension_total_voucher->addVoucher($order_id, $voucher);

				$this->db->query("UPDATE " . DB_PREFIX . "order_voucher SET voucher_id = '" . (int)$voucher_id . "' WHERE order_voucher_id = '" . (int)$order_voucher_id . "'");
			}
		}
                优化 by hwh end */
                
		// Totals
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "'");

		if (isset($data['totals'])) {
			foreach ($data['totals'] as $total) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
			}
		}
	}

	public function deleteOrder($order_id) {
		// Void the order first
		//$this->addOrderHistory($order_id, 0);

		$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_product` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_option` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "order_history` WHERE order_id = '" . (int)$order_id . "'");
		$this->db->query("DELETE `or`, ort FROM `" . DB_PREFIX . "order_recurring` `or`, `" . DB_PREFIX . "order_recurring_transaction` `ort` WHERE order_id = '" . (int)$order_id . "' AND ort.order_recurring_id = `or`.order_recurring_id");
		$this->db->query("DELETE FROM `" . DB_PREFIX . "affiliate_transaction` WHERE order_id = '" . (int)$order_id . "'");

		// Gift Voucher
		$this->load->model('extension/total/voucher');

		$this->model_extension_total_voucher->disableVoucher($order_id);
	}

	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = o.language_id) AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}

			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];
			} else {
				$language_code = $this->config->get('config_language');
			}

			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'email'                   => $order_query->row['email'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'custom_field'            => json_decode($order_query->row['custom_field'], true),
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_custom_field'    => json_decode($order_query->row['payment_custom_field'], true),
				'payment_method'          => $order_query->row['payment_method'],
				'payment_code'            => $order_query->row['payment_code'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_custom_field'   => json_decode($order_query->row['shipping_custom_field'], true),
				'shipping_method'         => $order_query->row['shipping_method'],
				'shipping_code'           => $order_query->row['shipping_code'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'order_status_id'         => $order_query->row['order_status_id'],
				'order_status'            => $order_query->row['order_status'],
				'affiliate_id'            => $order_query->row['affiliate_id'],
				'commission'              => $order_query->row['commission'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $language_code,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'ip'                      => $order_query->row['ip'],
				'forwarded_ip'            => $order_query->row['forwarded_ip'],
				'user_agent'              => $order_query->row['user_agent'],
				'accept_language'         => $order_query->row['accept_language'],
				'date_added'              => $order_query->row['date_added'],
				'date_modified'           => $order_query->row['date_modified'],
				'order_no'                => $order_query->row['order_no'],      //订单号
				'payment_telephone'       => $order_query->row['payment_telephone'],   //账单电话号码
				'shipping_telephone'      => $order_query->row['shipping_telephone'],   //物流电话号码
				'payment_type'            => $order_query->row['payment_type']    //订单的支付方式
			);
		} else {
			return false;
		}
	}

	//public function sendEmail($order_id, $order_status_id, $comment = '', $notify = false){
        /*下单成功发送邮件*/
	public function sendEmail($order_id, $order_status_id){
		$order_info = $this->getOrder($order_id);
		
		// If order status is 0 then becomes greater than 0 send main html email
		if ($order_info['order_status_id'] == 2 && $order_status_id) {
			// Check for any downloadable products
			$download_status = false;
		
			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
		
			foreach ($order_product_query->rows as $order_product) {
				// Check if there are any linked downloads
				$product_download_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_to_download` WHERE product_id = '" . (int)$order_product['product_id'] . "'");
		
				if ($product_download_query->row['total']) {
					$download_status = true;
				}
			}
		
			// Load the language for any mails that might be required to be sent out
			$language = new Language($order_info['language_code']);
			$language->load($order_info['language_code']);
			$language->load('mail/order');
		
			$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");
		
			if ($order_status_query->num_rows) {
				$order_status = $order_status_query->row['name'];
			} else {
				$order_status = '';
			}
		
			$subject = sprintf($language->get('text_new_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_info['order_no']);
		
			// HTML Mail
			$data = array();
		
			$data['title'] = sprintf($language->get('text_new_subject'), $order_info['store_name'], $order_info['order_no']);
		
			$data['text_greeting'] = sprintf($language->get('text_new_greeting'), $order_info['store_name']);
			$data['text_link'] = $language->get('text_new_link');
			$data['text_download'] = $language->get('text_new_download');
			$data['text_order_detail'] = $language->get('text_new_order_detail');
			$data['text_instruction'] = $language->get('text_new_instruction');
			$data['text_order_id'] = $language->get('text_new_order_id');
			$data['text_date_added'] = $language->get('text_new_date_added');
			$data['text_payment_method'] = $language->get('text_new_payment_method');
			$data['text_shipping_method'] = $language->get('text_new_shipping_method');
			$data['text_email'] = $language->get('text_new_email');
			$data['text_telephone'] = $language->get('text_new_telephone');
			$data['text_ip'] = $language->get('text_new_ip');
			$data['text_order_status'] = $language->get('text_new_order_status');
			$data['text_payment_address'] = $language->get('text_new_payment_address');
			$data['text_shipping_address'] = $language->get('text_new_shipping_address');
			$data['text_product'] = $language->get('text_new_product');
			$data['text_model'] = $language->get('text_new_model');
			$data['text_quantity'] = $language->get('text_new_quantity');
			$data['text_price'] = $language->get('text_new_price');
			$data['text_total'] = $language->get('text_new_total');
			$data['text_footer'] = $language->get('text_new_footer');
		
			$data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
			$data['store_name'] = $order_info['store_name'];
			$data['store_url'] = $order_info['store_url'];
			$data['customer_id'] = $order_info['customer_id'];
			$data['link'] = $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id;
		
			if ($download_status) {
				$data['download'] = $order_info['store_url'] . 'index.php?route=account/download';
			} else {
				$data['download'] = '';
			}
		
			$data['order_id'] = $order_id;
			$data['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));
			
			if($order_info['payment_type'] == 'Standard'){
				$data['payment_method'] = 'PayPal Payments Standard';
			}else if($order_info['payment_type'] == 'Express'){
				$data['payment_method'] ='PayPal Express Checkout';
			}
			
			$data['shipping_method'] = $order_info['shipping_method'];
			$data['email'] = $order_info['email'];
			$data['telephone'] = $order_info['telephone'];
			$data['ip'] = $order_info['ip'];
			$data['order_status'] = $order_status;
			$data['order_no'] = $order_info['order_no'];
		
			//if ($comment && $notify) {
			if ($order_info['comment']) {
				$data['comment'] = nl2br($order_info['comment']);
			} else {
				$data['comment'] = '';
			}
		
			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}' . "\n". '{payment_telephone}';
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
		
			// 				if ($order_info['shipping_address_format']) {
			// 					$format = $order_info['shipping_address_format'];
			// 				} else {
			$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}' . "\n" . '{shipping_telephone}';
			//				}
		
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
		
			$this->load->model('tool/upload');
		
			// Products
			$data['products'] = array();
		
			foreach ($order_product_query->rows as $product) {
				$option_data = array();
		
				$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");
		
				foreach ($order_option_query->rows as $option) {
                                        /* 优化 by hwh begin 注释掉暂时没用的功能
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
                                    
                                        $value = $option['value'];
					$option_data[] = array(
							'name'  => $option['name'],
							'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}
		
				if($product['original_price'] == 0){
					$original_price = false;
				}else{
					$original_price = $this->currency->format($product['original_price'], $this->session->data['currency']);
				}
				
				$data['products'][] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'original_price'   => $original_price,
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
				);
			}
		
			// Vouchers
			$data['vouchers'] = array();
                        /* 优化 by hwh begin 注释掉暂时没用的功能
			$order_voucher_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");
		
			foreach ($order_voucher_query->rows as $voucher) {
				$data['vouchers'][] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
				);
			}
                        优化 by hwh end */
                        
			// Order Totals
			$data['totals'] = array();
		
			$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");
		
			foreach ($order_total_query->rows as $total) {
				$data['totals'][] = array(
						'title' => $total['title'],
						'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']),
				);
			}
		
			// Text Mail
			$text  = sprintf($language->get('text_new_greeting'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8')) . "\n\n";
			$text .= $language->get('text_new_order_id') . ' ' . $order_info['order_no'] . "\n";
			$text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
			$text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";
		
			if ($order_info['comment']) {
				$text .= $language->get('text_new_instruction') . "\n\n";
				$text .= $order_info['comment'] . "\n\n";
			}
		
			// Products
			$text .= $language->get('text_new_products') . "\n";
		
			foreach ($order_product_query->rows as $product) {
				$text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
		
				$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");
		
				foreach ($order_option_query->rows as $option) {
                                        /* 优化 by hwh begin 注释掉暂时没用的功能
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
                                        $value = $option['value'];
					$text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value) . "\n";
				}
			}
		
			foreach ($order_voucher_query->rows as $voucher) {
				$text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
			}
		
			$text .= "\n";
		
			$text .= $language->get('text_new_order_total') . "\n";
		
			foreach ($order_total_query->rows as $total) {
				$text .= $total['title'] . ': ' . html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
			}
		
			$text .= "\n";
		
			if ($order_info['customer_id']) {
				$text .= $language->get('text_new_link') . "\n";
				$text .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
			}
		
			if ($download_status) {
				$text .= $language->get('text_new_download') . "\n";
				$text .= $order_info['store_url'] . 'index.php?route=account/download' . "\n\n";
			}
		
			// Comment
			if ($order_info['comment']) {
				$text .= $language->get('text_new_comment') . "\n\n";
				$text .= $order_info['comment'] . "\n\n";
			}
		
			$text .= $language->get('text_new_footer') . "\n\n";
		
			//logo  dyl add
			if ($this->request->server['HTTPS']) {
				$server = $this->config->get('config_ssl');
			} else {
				$server = $this->config->get('config_url');
			}
			if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
				$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
			} else {
				$data['logo'] = '';
			}
		
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
		
			$mail->setTo($order_info['email']);
			$mail->setFrom($this->config->get('config_mail_parameter'));
			$mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setHtml($this->load->view('mail/order', $data));
			$mail->setText($text);
			$mail->send();
			
			// Admin Alert Mail
			if (in_array('order', (array)$this->config->get('config_mail_alert'))) {
				$subject = sprintf($language->get('text_new_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'), $order_info['order_no']);
		
				// HTML Mail
				$data['text_greeting'] = $language->get('text_new_received');
		
				/*if ($comment) {
					if ($order_info['comment']) {
						$data['comment'] = nl2br($comment) . '<br/><br/>' . $order_info['comment'];
					} else {
						$data['comment'] = nl2br($comment);
					}
				} else {
					if ($order_info['comment']) {
						$data['comment'] = $order_info['comment'];
					} else {
						$data['comment'] = '';
					}
				}*/
				if($order_info['comment']){
					$data['comment'] = nl2br($order_info['comment']);
				}else{
					$data['comment'] = '';
				}
		
				$data['text_download'] = '';
		
				$data['text_footer'] = '';
		
				$data['text_link'] = '';
				$data['link'] = '';
				$data['download'] = '';
		
				// Text
				$text  = $language->get('text_new_received') . "\n\n";
				$text .= $language->get('text_new_order_id') . ' ' . $order_info['order_no'] . "\n";
				$text .= $language->get('text_new_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n";
				$text .= $language->get('text_new_order_status') . ' ' . $order_status . "\n\n";
				$text .= $language->get('text_new_products') . "\n";
		
				foreach ($order_product_query->rows as $product) {
					$text .= $product['quantity'] . 'x ' . $product['name'] . ' (' . $product['model'] . ') ' . html_entity_decode($this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
		
					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . $product['order_product_id'] . "'");
		
					foreach ($order_option_query->rows as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
						}
		
						$text .= chr(9) . '-' . $option['name'] . ' ' . (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value) . "\n";
					}
				}
		
				foreach ($order_voucher_query->rows as $voucher) {
					$text .= '1x ' . $voucher['description'] . ' ' . $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']);
				}
		
				$text .= "\n";
		
				$text .= $language->get('text_new_order_total') . "\n";
		
				foreach ($order_total_query->rows as $total) {
					$text .= $total['title'] . ': ' . html_entity_decode($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8') . "\n";
				}
		
				$text .= "\n";
		
				if ($order_info['comment']) {
					$text .= $language->get('text_new_comment') . "\n\n";
					$text .= $order_info['comment'] . "\n\n";
				}
		
				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
		
				$mail->setTo($this->config->get('config_email'));
				$mail->setFrom($this->config->get('config_mail_parameter'));
				$mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setHtml($this->load->view('mail/order', $data));
				$mail->setText($text);
				$mail->send();
		
				// Send to additional alert emails
				$emails = explode(',', $this->config->get('config_alert_email'));
		
				foreach ($emails as $email) {
					if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$mail->setTo($email);
						$mail->send();
					}
				}
			}
			//把已发送邮件的订单ID写入session
			$this->session->data['send_order_id'] = $this->session->data['order_id'];
		}
	}
	
	//public function addOrderHistory($order_id, $order_status_id, $comment = '', $notify = false, $override = false) {
      public function addOrderHistory($order_id, $order_status_id, $comment = '', $notify = false, $shippingNumber = '') {
		$order_info = $this->getOrder($order_id);

		if ($order_info) {
			// Fraud Detection
			$this->load->model('account/customer');

			$customer_info = $this->model_account_customer->getCustomer($order_info['customer_id']);

			if ($customer_info && $customer_info['safe']) {
				$safe = true;
			} else {
				$safe = false;
			}

			// Only do the fraud check if the customer is not on the safe list and the order status is changing into the complete or process order status
			//if (!$safe && !$override && in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
			if (!$safe && in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
				// Anti-Fraud
				$this->load->model('extension/extension');

				$extensions = $this->model_extension_extension->getExtensions('fraud');

				foreach ($extensions as $extension) {
					if ($this->config->get($extension['code'] . '_status')) {
						$this->load->model('extension/fraud/' . $extension['code']);

						$fraud_status_id = $this->{'model_fraud_' . $extension['code']}->check($order_info);

						if ($fraud_status_id) {
							$order_status_id = $fraud_status_id;
						}
					}
				}
			}

			// If current order status is not processing or complete but new status is processing or complete then commence completing the order
			//if (!in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
			//dyl 改
			if (in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {

				// Stock subtraction
				$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				foreach ($order_product_query->rows as $order_product) {
					$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");

					$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");

					foreach ($order_option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
					}
				}

				// Redeem coupon, vouchers and reward points
				$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

				foreach ($order_total_query->rows as $order_total) {
					$this->load->model('extension/total/' . $order_total['code']);

					if (property_exists($this->{'model_extension_total_' . $order_total['code']}, 'confirm')) {
						// Confirm coupon, vouchers and reward points
						$fraud_status_id = $this->{'model_extension_total_' . $order_total['code']}->confirm($order_info, $order_total);

						// If the balance on the coupon, vouchers and reward points is not enough to cover the transaction or has already been used then the fraud order status is returned.
						if ($fraud_status_id) {
							$order_status_id = $fraud_status_id;
						}
					}
				}

				// Add commission if sale is linked to affiliate referral.
                                /* 优化 by hwh begin 注释掉暂时没用的功能
				if ($order_info['affiliate_id'] && $this->config->get('config_affiliate_auto')) {
					$this->load->model('affiliate/affiliate');

					$this->model_affiliate_affiliate->addTransaction($order_info['affiliate_id'], $order_info['commission'], $order_id);
				}
                                优化 by hwh end */
                                
			}

			// Update the DB with the new statuses
			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', shippingNumber = '" . $shippingNumber . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

			$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '" . (int)$notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

			// If old order status is the processing or complete status but new status is not then commence restock, and remove coupon, voucher and reward history
			//if (in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
			//dyl 改
			if (!in_array($order_info['order_status_id'], array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status'))) && in_array($order_status_id, array_merge($this->config->get('config_processing_status'), $this->config->get('config_complete_status')))) {
				// Restock
				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				foreach($product_query->rows as $product) {
					$this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");

					$option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

					foreach ($option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
					}
				}

				// Remove coupon, vouchers and reward points history
				$this->load->model('account/order');

				$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order ASC");

				foreach ($order_total_query->rows as $order_total) {
					$this->load->model('extension/total/' . $order_total['code']);

					if (property_exists($this->{'model_extension_total_' . $order_total['code']}, 'unconfirm')) {
						$this->{'model_extension_total_' . $order_total['code']}->unconfirm($order_id);
					}
				}

				// Remove commission if sale is linked to affiliate referral.
				if ($order_info['affiliate_id']) {
                                    $this->load->model('affiliate/affiliate');
                                    $this->model_affiliate_affiliate->deleteTransaction($order_id);
				}
			}

			$this->cache->delete('product');

			// If order status is not 0 then send update text email
			//if ($order_info['order_status_id'] && $order_status_id && $notify) {
                        /* 优化 by hwh begin 注释掉无效代码
            if(false){
				$language = new Language($order_info['language_code']);
				$language->load($order_info['language_code']);
				$language->load('mail/order');

				$subject = sprintf($language->get('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_info['order_no']);

				$message  = $language->get('text_update_order') . ' ' . $order_info['order_no'] . "\n";
				$message .= $language->get('text_update_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";

				$order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$order_status_id . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

				if ($order_status_query->num_rows) {
					$message .= $language->get('text_update_order_status') . "\n\n";
					$message .= $order_status_query->row['name'] . "\n\n";
				}

				if ($order_info['customer_id']) {
					$message .= $language->get('text_update_link') . "\n";
					$message .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
				}

				if ($comment) {
					$message .= $language->get('text_update_comment') . "\n\n";
					$message .= strip_tags($comment) . "\n\n";
				}

				$message .= $language->get('text_update_footer');

				$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
				$mail->smtp_username = $this->config->get('config_mail_smtp_username');
				$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
				$mail->smtp_port = $this->config->get('config_mail_smtp_port');
				$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

				$mail->setTo($order_info['email']);
				$mail->setFrom($this->config->get('config_mail_parameter'));
				$mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText($message);
				//$mail->send();
			}
                        优化 by hwh end */
		}
	}



	/**
	 * 根据订单ID获取订单的产品
	 * @author  dyl 783973660@qq.com  2016.9.27
	 * @param   Int   $order_id   订单ID
	 */
	public function getOrderProducts($order_id){
        $sql = "SELECT op.product_id,op.name,op.model,op.quantity,op.price,op.total,
                    GROUP_CONCAT(CONCAT(oo.name,':',oo.value)) option_name
                    FROM " . DB_PREFIX . "order_product op
                    LEFT JOIN " . DB_PREFIX . "order_option oo ON oo.order_id = op.order_id
                    AND oo.order_product_id = op.order_product_id
                    WHERE op.order_id = '" . (int)$order_id . "' GROUP BY op.product_id ORDER BY oo.order_product_id  ";

        $order_query = $this->db->query($sql);

        $order_products = array();
	    if ($order_query->num_rows) {
            $order_products = $order_query->rows;
        }

        return $order_products;
    }


    /**
     * 根据订单id,查询用户的email
     * @author dyl 783973660@qq.com 2016.9.29
     * @param Int $orderId 订单id
     */
	public function getEmailByOrderId($orderId){
	   $sql="SELECT email FROM " . DB_PREFIX . "order where order_id=".(int)$orderId;
	   $sqlquery = $this->db->query($sql);
	   return !empty($sqlquery->row['email']) ? $sqlquery->row['email'] : '';
	}

    /**
     * 根据订单id,查询用户的订单信息(用于后台添加订单)
     * @author dyl 783973660@qq.com 2016.9.29
     * @param Int $orderId 订单id
     */
	public function getOrderDataByOrderId($orderId){
       $sql="SELECT order_no,firstname,lastname,email FROM " . DB_PREFIX . "order where order_id=".(int)$orderId;
	   $sqlquery = $this->db->query($sql);
	   return !empty($sqlquery->row) ? $sqlquery->row : '';
	}
	
    /**
     * 根据订单id和物流号,查询是否有重复的物流号
     * @author dyl 783973660@qq.com 2016.9.29
     * @param Int    $order_id       订单id
     * @param String $shippingNumber 物流号
     */
	public function checkOrderShippingNumber($order_id,$shippingNumber){
		$sql = "select order_id from " . DB_PREFIX . "order where order_id!=".(int)$order_id." and shippingNumber='".$shippingNumber."'";
		$query=$this->db->query($sql);
		return $query->rows;
	}
        
    /**
     * 支付成功后更改帐单地址
     */
    public function updateBillingAdress($order_id,$address){
        if(empty($order_id)|| empty($address)){
            return false;
        }
        
        $shipping_name = explode(' ', trim($address['PAYMENTREQUEST_0_SHIPTONAME']));
        $first_name = trim($shipping_name[0]);
        $last_name = isset($shipping_name[1]) ? trim($shipping_name[1]) : '';
        $street1 = !empty($address['PAYMENTREQUEST_0_SHIPTOSTREET']) ? trim($address['PAYMENTREQUEST_0_SHIPTOSTREET']) : '';
        $street2 = !empty($address['PAYMENTREQUEST_0_SHIPTOSTREET2']) ? trim($address['PAYMENTREQUEST_0_SHIPTOSTREET2']) : '';
        $city = !empty($address['PAYMENTREQUEST_0_SHIPTOCITY']) ? trim($address['PAYMENTREQUEST_0_SHIPTOCITY']) : '';
        $state = !empty($address['PAYMENTREQUEST_0_SHIPTOSTATE']) ? trim($address['PAYMENTREQUEST_0_SHIPTOSTATE']) : '';
        $zipcode = !empty($address['PAYMENTREQUEST_0_SHIPTOZIP']) ? trim($address['PAYMENTREQUEST_0_SHIPTOZIP']) : '';
        $country = !empty($address['PAYMENTREQUEST_0_SHIPTOCOUNTRYNAME']) ? trim($address['PAYMENTREQUEST_0_SHIPTOCOUNTRYNAME']) : '';
        $country_code = !empty($address['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE']) ? trim($address['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE']) : ''; 
        

        $country_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE (`name` = '" . $this->db->escape($country) . "' OR `iso_code_2` = '" . $this->db->escape($country_code) . "') AND `status` = '1' LIMIT 1")->row;
        $zone_info = array();
        if(!empty($country_info['country_id'])){
            $zone_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE (`name` = '" . $this->db->escape($state) . "' OR `code` = '" . $this->db->escape($state) . "') AND `status` = '1' AND `country_id` = '" . (int)$country_info['country_id'] . "'")->row;
        }
        
        $country_name = !empty($country_info['name']) ? $country_info['name'] : 0;
        $country_id = !empty($country_info['country_id']) ? $country_info['country_id'] : 0;
        $zone_id = !empty($zone_info['zone_id']) ? $zone_info['zone_id'] : 0;
        $zone_name = !empty($zone_info['name']) ? $zone_info['name'] : 0;
        
        if(!empty($first_name) && !empty($street1) && !empty($city)){
            $sql = "update " . DB_PREFIX . "order set payment_firstname='" . $first_name . "',payment_lastname='" . $last_name . "',payment_address_1='" . $street1 
                . "',payment_address_2='" . $street2 . "',payment_city='" . $city . "',payment_postcode='" . $zipcode . "',payment_country='" . $country_name 
                . "',payment_country_id='" . $country_id . "',payment_zone='" . $zone_name . "',payment_zone_id='" . $zone_id . "' where order_id = '" . $order_id . "'";
        
            $this->db->query($sql);
        }
        
    }

	/**
	 * 用户下单成功后将该用户订单状态为Processing、Complete、Shipped的订单中的产品价格进行累加
	 */
	public function saveTotalOrder() {
		$sql = "UPDATE " . DB_PREFIX . "customer c SET
				c.total_order = (SELECT SUM(o.total) FROM " . DB_PREFIX . "order o
						LEFT JOIN " . DB_PREFIX . "order_status os ON
						o.order_status_id = os.order_status_id WHERE
						o.customer_id = '" . $this->customer->getId() . "' AND
						(os.name = 'Processing' OR os.name = 'Shipped' OR os.name = 'Complete')) WHERE c.customer_id = '" . $this->customer->getId() . "'";
		$query = $this->db->query($sql);
	}
	
	//支付成功，订单商品销售数+1
	public function addProductsSales($order_id){
		if(isset($this->session->data['isOrderProductsSalesAdd']) && $this->session->data['isOrderProductsSalesAdd']==$order_id) return false;
		$this->session->data['isOrderProductsSalesAdd'] = $order_id;
		$products = $this->getOrderProducts($order_id);
		if(empty($products)) return false;
		foreach ($products as $v) {
			$sql = "UPDATE " . DB_PREFIX . "product SET sales = (sales + 1) WHERE product_id = '" . (int)$v['product_id'] . "'";
			$this->db->query($sql);
		}
		return true;
	}
}