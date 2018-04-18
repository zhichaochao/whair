<?php
class ModelAccountInquiry extends Model {
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
				'order_no'                => $order_query->row['order_no'],
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
				'ip'                      => $order_query->row['ip']
			);
		} else {
			return false;
		}
	}

	public function getInquirys($start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 1;
		}

		//$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_inquiry` WHERE customer_id = '" . (int)$this->customer->getId() . "' ORDER BY inquiry_id DESC LIMIT " . (int)$start . "," . (int)$limit);

        //dyl改
		$sql = "SELECT pi.*,p.image,pd.name as pro_name,c.name as coun_name FROM " . DB_PREFIX . "product_inquiry pi ";
        $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = pi.product_id ";
        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = pi.product_id ";
        $sql .= " LEFT JOIN " . DB_PREFIX . "country c ON c.country_id = pi.country_id ";
        $sql .= " WHERE pi.customer_id = ".(int)$this->customer->getId()." ORDER BY pi.add_time DESC";
        $sql .= " LIMIT " . (int)$start . "," . (int)$limit;

        $query = $this->db->query($sql);

		return $query->rows;
	}

	public function getOrderProduct($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->row;
	}


	public function getTotalInquirys() {
		//$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_inquiry`  WHERE customer_id = '" . (int)$this->customer->getId() . "'");

        //dyl改
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_inquiry pi ";
        $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = pi.product_id ";
        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = pi.product_id ";
        $sql .= " LEFT JOIN " . DB_PREFIX . "country c ON c.country_id = pi.country_id ";
        $sql .= " WHERE pi.customer_id = ".(int)$this->customer->getId();

        $query = $this->db->query($sql);

		return $query->row['total'];
	}


   /**
    * 产品详情页的询盘信息提交
    * @author  dyl 783973660@qq.com  2016.9.27
    * @param   Array   $data   传递过来的数据
    */
	public function addinquiry($data=array()){
		$sql = "INSERT INTO " . DB_PREFIX . "product_inquiry SET product_id = ".(int)$data['product_id'].",
				customer_id = ".(int)$data['customer_id'].", name = '".$this->db->escape($data['name'])."', email = '".$this->db->escape($data['email'])."',
			    fixed_line = '".$this->db->escape($data['fixed_line'])."', country_id = ".(int)$data['country_id'].", phone = '".$this->db->escape($data['phone'])."',
			    content = '".$this->db->escape($data['content'])."', add_time = NOW()";
        $result = $this->db->query($sql);

		return $result;
	}


   /**
    * 用户询盘页面的删除
    * @author  dyl 783973660@qq.com  2016.9.27
    * @param   Int  $inquiry_id   询盘的ID
    */
	public function delinquiry($inquiry_id){
		$sql = "DELETE FROM " . DB_PREFIX . "product_inquiry WHERE inquiry_id = ".(int)$inquiry_id;
        $result = $this->db->query($sql);
		return $result;
	}

}