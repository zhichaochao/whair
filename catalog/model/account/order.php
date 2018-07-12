<?php
class ModelAccountOrder extends Model {
	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND order_status_id > '0'");

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
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'email'                   => $order_query->row['email'],
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
				'payment_method'          => $order_query->row['payment_method'],
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
				'shipping_method'         => $order_query->row['shipping_method'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'order_status_id'         => $order_query->row['order_status_id'],
				'language_id'             => $order_query->row['language_id'],
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'date_modified'           => $order_query->row['date_modified'],
				'date_added'              => $order_query->row['date_added'],
				'ip'                      => $order_query->row['ip'],
				'order_no'                => $order_query->row['order_no'],        //dyl add
				'shippingNumber'          => $order_query->row['shippingNumber'],  //dyl add
				'payment_telephone'       => $order_query->row['payment_telephone'],
				'shipping_telephone'      => $order_query->row['shipping_telephone'],
				'bank_receipt'            => $order_query->row['bank_receipt']
			);
		} else {
			return false;
		}
	}
	public function deleteWishlist($order_id) {
		$this->db->query("UPDATE " . DB_PREFIX ."order SET del = '1' WHERE customer_id = '" . (int)$this->customer->getId() . "' AND order_id = '" . (int)$order_id . "'");		
	}

	public function getOrders($start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 1;
		}

		$query = $this->db->query("SELECT o.order_id,o.order_no, o.firstname, o.lastname, o.payment_code, os.name as status, o.date_added, o.total, o.currency_code, o.currency_value FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_status os ON (o.order_status_id = os.order_status_id) WHERE o.customer_id = '" . (int)$this->customer->getId() . "' AND o.order_status_id > '0'  AND o.del = '0' AND o.store_id = '" . (int)$this->config->get('config_store_id') . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.order_id DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getOrderProduct($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->row;
	}

	public function getOrderProductNumber($order_id){
		$query = $this->db->query("SELECT SUM(quantity) qty FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['qty'];
	}
	
	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT op.*,p.image FROM " . DB_PREFIX . "order_product as op LEFT JOIN " . DB_PREFIX . "product as p on p.product_id=op.product_id WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->rows;
	}

	public function getOrderVouchers($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");

		return $query->rows;
	}

	public function getOrderHistories($order_id) {
		//dyl 改,根据date_added倒序排列
		$query = $this->db->query("SELECT date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added DESC");

		return $query->rows;
	}

	public function getTotalOrders() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o WHERE customer_id = '" . (int)$this->customer->getId() . "' AND o.order_status_id > '0' AND o.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		return $query->row['total'];
	}

	public function getTotalOrderProductsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrderVouchersByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	/**
	 * 根据订单ID,获取其中一件产品的图片和产品名字(获取最后添加的那一条记录)
	 * @author  dyl 783973660@qq.com  2016.9.26
	 * @param   Int   $order_id  订单ID
	 */
	public function getOrderProductImgAndNameByOrderId($order_id) {

		$sql = "SELECT op.name,p.image,p.price
				FROM " . DB_PREFIX . "order_product op
				LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = op.product_id
				WHERE op.order_id = " . (int)$order_id. " ORDER BY p.date_added DESC,p.product_id desc LIMIT 1";
		$query = $this->db->query($sql);
//var_dump($query);exit();
		return $query->row;
	}
public function getOrderProductImgAndNameByOrderIds($order_id) {

		$sql = "SELECT op.name,p.image,p.price
				FROM " . DB_PREFIX . "order_product op
				LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = op.product_id
				WHERE op.order_id = " . (int)$order_id. "";
		$query = $this->db->query($sql);
//var_dump($query);exit();
		return $query->row;
	}

	/**
     * 用户中心取消订单,改变订单的状态
     * @author  dyl  783973660@qq.com  2016.9.26
     * @param  Int  $order_id           订单ID
     * @param  Int  $order_status_id    订单状态
     */
	public function changeStatus($order_id,$order_status_id){
	    $sql = "update `".DB_PREFIX."order` set order_status_id = '".$order_status_id."' where order_id = '".$order_id."'";
	    $query = $this->db->query($sql);
	    $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', notify = '0', comment = 'customer cancel', date_added = NOW()");

        //根据订单ID,把
        //该订单对应的产品数量加回去
	    /*$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
		foreach($product_query->rows as $product) {
			$this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_id = '" . (int)$product['product_id'] . "' AND subtract = '1'");

			$option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");
			foreach ($option_query->rows as $option) {
				$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int)$product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
			}
		}*/
	}
	/**
	 * 订单详情页修改收货地址
	 * @author zhichao
	 */

	public function saveOrderAddress($order_id,$data)
	{
		 $sql = "update `".DB_PREFIX."order` set payment_telephone = '". $this->db->escape($data['telephone'])."',shipping_telephone = '". $this->db->escape($data['telephone'])."',payment_city = '". $this->db->escape($data['city'])."',shipping_city = '". $this->db->escape($data['city'])."',payment_postcode = '". $this->db->escape($data['postcode'])."',shipping_postcode = '". $this->db->escape($data['postcode'])."',payment_address_2 = '". $this->db->escape($data['address_2'])."',shipping_address_2 = '". $this->db->escape($data['address_2'])."',payment_address_1 = '". $this->db->escape($data['address_1'])."',shipping_address_1 = '". $this->db->escape($data['address_1'])."',payment_firstname = '". $this->db->escape($data['firstname'])."',shipping_firstname = '". $this->db->escape($data['firstname'])."',payment_lastname = '". $this->db->escape($data['lastname'])."',shipping_lastname = '". $this->db->escape($data['lastname'])."' where order_id = '".$order_id."'";
		 // print_r($sql);exit();
	    $query = $this->db->query($sql);
	}
	
	/**
	 * 获取用户所有支付成功订单的总价
	 * @author yufeng
	 */
	public function getHistoryOrderTotals($customer_id){
		$sql = "SELECT COUNT(DISTINCT o.order_id) as orders, ROUND(SUM(o.total),2) as order_totals FROM " . DB_PREFIX . "order o
			   LEFT JOIN " . DB_PREFIX . "order_status os ON (o.order_status_id = os.order_status_id)
			   	 WHERE (os.name = 'Processing' OR os.name = 'Shipped' OR os.name = 'Complete') AND
			   		 o.customer_id = '" . (int)$customer_id . "'";
	
		$query = $this->db->query($sql);
		return $query->row;
	}
		/**
	 * 上传支付的凭证
	 * @author zhichao
	 */
	public function submitOrderBankReceipt($order_id,$bank_receipt)
	{
		 $sql = "update `".DB_PREFIX."order` set bank_receipt = '". $this->db->escape($bank_receipt)."' where order_id = '".$order_id."'";
		 // print_r($sql);exit();
	    $query = $this->db->query($sql);
	    // print_r(  $query);exit();
	}

}