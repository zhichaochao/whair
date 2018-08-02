<?php
class ModelAccountCustomer extends Model {
	// private function querysql($sql)
	// {
	// 	$dbs= unserialize($this->config->get('db_database_data'));

	// 	foreach ($dbs as $key => $value) {
	// 		if($key==0){
	// 			$this->db->query($sql);
	// 		}else{
	// 			$d='db'.$key;
	// 			$this->$d->query($sql);
	// 		}
	// 	}

		
	// }
	public function addCustomer($data) {
		if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $data['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$this->load->model('account/customer_group');

		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

		//$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$customer_group_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "', language_id = '" . (int)$this->config->get('config_language_id') . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? json_encode($data['custom_field']['account']) : '') . "', salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '1', approved = '" . (int)!$customer_group_info['approval'] . "', date_added = NOW()");
		//dyl改
		$sql1 = "INSERT INTO " . DB_PREFIX . "customer
				SET customer_group_id = '" . (int)$customer_group_id . "',
				store_id = '" . (int)$this->config->get('config_store_id') . "',
				language_id = '" . (int)$this->config->get('config_language_id') . "',
				firstname = '" . $this->db->escape($data['firstname']) . "',
			    lastname = '" . $this->db->escape($data['lastname']) . "',
			    email = '" . $this->db->escape($data['email']) . "',
			    custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? json_encode($data['custom_field']['account']) : '') . "',
			    salt = '" . $this->db->escape($salt = token(9)) . "',
			    password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "',
			    newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "',
			    ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "',
			    status = '1',
			    approved = '" . (int)!$customer_group_info['approval'] . "', date_added = NOW()";
		$this->db->query($sql1);

		$customer_id = $this->db->getLastId();

		//$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($data['company']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['address']) ? json_encode($data['custom_field']['address']) : '') . "'");

		//$address_id = $this->db->getLastId();

		//$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");

        //发送邮件
		$this->load->language('mail/customer');

		$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

		$message = sprintf($this->language->get('text_welcome'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";

		if (!$customer_group_info['approval']) {
			//$message .= $this->language->get('text_login') . "\n";
			$message .= "Your account has now been created and you can log in by using your email address and password by visiting our website or at the following link: \n";
		} else {
			$message .= $this->language->get('text_approval') . "\n";
		}

		$message .= $this->url->link('account/login', '', true) . "\n\n";
		//$message .= $this->language->get('text_services') . "\n\n";
		$message .= "Upon logging in, you will be able to have access other services including reviewing past orders, printing invoices and editing your account information. \n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');

        //发给注册的用户
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

		$mail->setTo($data['email']);
		$mail->setFrom($this->config->get('config_mail_parameter'));
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$mail->setSubject($subject);
		$mail->setText($message);
		$mail->send();

		// Send to main admin email if new account email is enabled
		//发给网站管理员邮箱
		if (in_array('account', (array)$this->config->get('config_mail_alert'))) {
			$message  = $this->language->get('text_signup') . "\n\n";
			$message .= $this->language->get('text_website') . ' ' . html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8') . "\n";
			$message .= $this->language->get('text_firstname') . ' ' . $data['firstname'] . "\n";
			$message .= $this->language->get('text_lastname') . ' ' . $data['lastname'] . "\n";
			$message .= $this->language->get('text_customer_group') . ' ' . $customer_group_info['name'] . "\n";
			$message .= $this->language->get('text_email') . ' '  .  $data['email'] . "\n";
			//$message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n";

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
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'));
			$mail->setText($message);
			$mail->send();

			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('config_alert_email'));

			foreach ($emails as $email) {
				if (utf8_strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}

		return $customer_id;
	}

	public function editCustomer($data) {
		$customer_id = $this->customer->getId();

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "' WHERE customer_id = '" . (int)$customer_id . "'");
	}

	public function editPassword($email, $password) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', code = '' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}

	public function editCode($email, $code) {
		$this->db->query("UPDATE `" . DB_PREFIX . "customer` SET code = '" . $this->db->escape($code) . "' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}

	public function editNewsletter($newsletter) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}

	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row;
	}

	public function getCustomerByEmail($email) {
		$sql="SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'";
		$query = $this->db->query($sql);

			if (!isset($query->row['email'])) {
				$dbs= unserialize($this->config->get('db_database_data'));
				unset($dbs[0]);
				foreach ($dbs as $key => $value) {
					$d='db'.$key;
					$p=$this->$d->query($sql);
					if (isset($p->row['email'])) {
						return $value['url'];
					}

				}
			}else{

		return $query->row;
		}
	}

	public function getCustomerByCode($code) {
		$query = $this->db->query("SELECT customer_id, firstname, lastname, email FROM `" . DB_PREFIX . "customer` WHERE code = '" . $this->db->escape($code) . "' AND code != ''");

		return $query->row;
	}

	public function getCustomerByToken($token) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");

		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");

		return $query->row;
	}

	public function getTotalCustomersByEmail($email) {
		$sql="SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'";
		$query = $this->db->query($sql);
		$count=$query->row['total'];
		if($count<1){
			$dbs= unserialize($this->config->get('db_database_data'));
				unset($dbs[0]);
			foreach ($dbs as $key => $value) {
				$d='db'.$key;
				$p=$this->$d->query($sql);
				$count+=$p->row['total'];

			}
		}

		return $count;
	}

	public function getRewardTotal($customer_id) {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row['total'];
	}

	public function getIps($customer_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->rows;
	}

	public function addLoginAttempt($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_login WHERE email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

		if (!$query->num_rows) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_login SET email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', total = 1, date_added = '" . $this->db->escape(date('Y-m-d H:i:s')) . "', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");
		} else {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_login SET total = (total + 1), date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE customer_login_id = '" . (int)$query->row['customer_login_id'] . "'");
		}
	}

	public function getLoginAttempts($email) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	
	
		return $query->row; 

	}

	public function deleteLoginAttempts($email) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}


   /**
	* 检查旧密码
	* @author  dyl  783973660@qq.com 2106.9.26
	*/
	public function chkOldPassword($oldpassword){
		$customer_id = $this->customer->getId();

		$sql  	= "select password,salt from ".DB_PREFIX."customer where customer_id = '" . (int)$customer_id . "'";
		$query 	= $this->db->query($sql);
		$data 	= $query->row;
		$password 	= $data['password'];
		$salt		= $data['salt'];

		if(sha1($salt . sha1($salt . sha1($oldpassword)))==$password){
			return true;
		}else{
			return false;
		}

	}


   /**
	* 用户中心account模块,修改用户的信息
	* @author  dyl 783973660@qq.com 2016.9.26
	*/
	public function editCustomerUK($data) {

		$customer_id = $this->customer->getId();

		/*$sql = "UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) ."'";

		if(!empty($data['confirm'])){
			$sql .= ",salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['confirm'])))) . "'";
		}*/

		$sql = "UPDATE " . DB_PREFIX . "customer ";

		if(!empty($data['confirm'])){        //修改用户密码
			$sql .= " SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['confirm'])))) . "'";
		}else{                               //修改用户其他信息
            $sql .= " SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) ."'";
		}

		$sql .= " WHERE customer_id = " . (int)$customer_id;

		$this->db->query($sql);

	}
	
	/**
	 * 获取用户的默认地址ID
	 */
	public function getDefaultAddress($customer_id){
		$query = $this->db->query("SELECT address_id FROM `" . DB_PREFIX . "customer` WHERE customer_id = '" . $customer_id . "'");
		return $query->row['address_id'];
	}

	/**
	 * 根据用户所有订单的总金额设置用户所属分组（等级）
	 * @author yufeng
	 */
	public function setCustomerGroup() {
		$this->load->model('account/customer_group');
		$customer_groups = $this->model_account_customer_group->getCustomerGroupsTotalOrder();
	
		$sql = "SELECT total_order FROM " . DB_PREFIX . "customer WHERE
				customer_id = '" . (int)$this->customer->getId() . "'";
		$total_order = $this->db->query($sql)->row['total_order'];
	
		//判断用户订单金额是否大于后台设置用户分组的金额
		foreach ($customer_groups as $customer_group_id => $customer_groups_total_order) {
			if ($total_order >= $customer_groups_total_order) {
				$query = $this->db->query("UPDATE " . DB_PREFIX . "customer SET
						customer_group_id = '" . (int)$customer_group_id . "' WHERE
						customer_id = '" . (int)$this->customer->getId() . "'");
				break;
			}
		}
	}
	
	/**
	 * 更新所有用户对应等级和订单金额总数
	 */
	public function updateCustomerInfo(){
		//所有用户信息
		$sql1 = "SELECT * FROM ".DB_PREFIX."customer";
		$customers = $this->db->query($sql1)->rows;
	
		foreach ($customers as $customer) {
			//获取所有用户所有支付完成订单的金额总和，并更新customer表中的total_order字段
			$sql2 = "UPDATE " . DB_PREFIX . "customer c SET
				c.total_order = (SELECT SUM(o.total) FROM " . DB_PREFIX . "order o
						LEFT JOIN " . DB_PREFIX . "order_status os ON
						o.order_status_id = os.order_status_id WHERE
						o.customer_id = '" . (int)$customer['customer_id'] . "' AND
						(os.name = 'Processing' OR os.name = 'Shipped' OR os.name = 'Complete')) WHERE c.customer_id = '" . (int)$customer['customer_id'] . "'";
				
			$query2 = $this->db->query($sql2);
		}
	
		//所有等级信息
		$this->load->model('account/customer_group');
		$customer_groups = $this->model_account_customer_group->getCustomerGroupsTotalOrder();
	
		foreach($customers as $customer) {
			foreach ($customer_groups as $customer_group_id => $customer_groups_total_order) {
	
				if ($customer['total_order'] >= $customer_groups_total_order) {
					$this->db->query("UPDATE " . DB_PREFIX . "customer SET
						customer_group_id = '" . (int)$customer_group_id . "' WHERE
						customer_id = '" . (int)$customer['customer_id'] . "'");
					break;
				}
			}
		}
	}
	
}
