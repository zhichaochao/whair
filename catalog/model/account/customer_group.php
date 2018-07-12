<?php
class ModelAccountCustomerGroup extends Model {
	public function getCustomerGroup($customer_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg 
				LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON 
				(cg.customer_group_id = cgd.customer_group_id) WHERE 
				cg.customer_group_id = '" . (int)$customer_group_id . "' AND 
				cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getCustomerGroups() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_group cg 
				LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON 
				(cg.customer_group_id = cgd.customer_group_id) WHERE 
				cgd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
				ORDER BY cg.sort_order ASC, cgd.name ASC");

		return $query->rows;
	}
	
	/** 
	 * 获取所有用户等级对应的订单金额
	 * @author yufeng
	 * @param  Array  $customer_groups  用户等级对应的订单金额
	 */
	public function getCustomerGroupsTotalOrder() {
		$sql = "SELECT customer_group_id, total_order FROM " . DB_PREFIX . "customer_group ORDER BY total_order DESC";
		$query = $this->db->query($sql)->rows;
		$customer_groups = [];
		foreach($query as $value) {
			$customer_groups[$value['customer_group_id']] =  $value['total_order'];
		}
		return $customer_groups;
	}
	
	/**
	 * 获取当前用户等级的下一个等级
	 */
	public function getNextCustomerGroups(){
		$sql = "SELECT ROUND(total_order,2) AS total_order FROM " . DB_PREFIX . "customer_group WHERE
			    total_order > (SELECT total_order FROM " . DB_PREFIX . "customer_group
			    		 WHERE customer_group_id = '" . $this->customer->getGroupId() . "')
			    ORDER BY total_order ASC LIMIT 1";
	
		$query = $this->db->query($sql);
		return $query->row;
	}
}