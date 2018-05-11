<?php
class ModelCustomerEmail extends Model {
	public function addEmail($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "email SET title = '" .$this->db->escape($data['title']) . "', content = '" . $this->db->escape($data['content']) . "', customer_id = '" . $this->db->escape(implode(',', $data['customer_id'])) . "',time='".date('Y-m-d H:i:s',time())."'");
		$email_id = $this->db->getLastId();
		// print_r("INSERT INTO " . DB_PREFIX . "email SET title = '" . (int)$data['title'] . "', content = '" . $this->db->escape($data['content']) . "', customer_id = '" . $this->db->escape(implode(',', $data['customer_id'])) . "',time=".date('Y-m-d H:i:s',time()));exit();
		return $email_id;
	}




	public function deleteEmail($email_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "email WHERE email_id = '" . (int)$email_id . "'");
	
	}

	public function getEmail($email_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "email WHERE email_id = '" . (int)$email_id . "'");

		return $query->row;
	}

	public function getEmails($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "email  WHERE 1 ";


		$sort_data = array(
			'title',
			'time',
			'email_id'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY time";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}




	public function getTotalEmails($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "email";


		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getCustomers($ids) {
		// print_r($ids);exit();
		$query = $this->db->query("SELECT firstname,email,customer_id,lastname FROM " . DB_PREFIX . "customer WHERE customer_id in(" . $ids . ") ");




		return $query->rows;
	}


	public function sendEmail($customer_id,$email_id) {
			$this->load->model('customer/customer');
			$this->load->language('mail/customer');
			$this->load->model('setting/store');
			$customer_info = $this->model_customer_customer->getCustomer($customer_id);
			$store_info = $this->model_setting_store->getStore($customer_info['store_id']);

			if ($store_info) {
				$store_name = $store_info['name'];
				$store_url = $store_info['url'] . 'index.php?route=account/login';
			} else {
				$store_name = $this->config->get('config_name');
				$store_url = HTTP_CATALOG . 'index.php?route=account/login';
			}
			$email_info=$this->getEmail($email_id);
	
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			// $mail->setTo($customer_info['email']);
			$mail->setTo('928583371@qq.com');
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($store_name, ENT_QUOTES, 'UTF-8'));
			$mail->setSubject($email_info['title']);
			$mail->setText($email_info['content']);
			$p=$mail->send();
			$send_customer_id=$email_info['send_customer_id'];
			if($send_customer_id){$send_customer_id.=','.$email_id;}else{$send_customer_id=$email_id;}
			if($p){
				$this->db->query("UPDATE " . DB_PREFIX . "email SET send_customer_id = '" . $send_customer_id . "'");
			}
			return $p;
		}
	
}
