<?php
class ModelCustomerInquiries extends Model {


	// public function editInquiries($id, $data, $path) {
	// 	$this->db->query("UPDATE " . DB_PREFIX . "feedback SET author = '" . $this->db->escape($data['author']) . "', product_id = '" . (int)$data['product_id'] . "', text = '" . $this->db->escape(strip_tags($data['text'])) . "', rating = '" . (int)$data['rating'] . "', status = '" . (int)$data['status'] . "', date_added = '" . $this->db->escape($data['date_added']) . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");

	// 	if($path){
	// 	   foreach($path as $row){
	// 		 $sql = "INSERT INTO " . DB_PREFIX . "feedback_img SET id = '".$id."',path='".$row."', createTime='".time()."'";
	// 		 $this->db->query($sql);
	// 	  }
	// 	}

	// 	$this->cache->delete('product');
	// }

	public function deleteInquiries($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "feedback WHERE id = '" . (int)$id . "'");

		$this->cache->delete('product');
	}

	public function getInquiries($id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "feedback r  WHERE r.id = '" . (int)$id . "'");

		return $query->row;
	}

	public function getInquiriess($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "feedback r";

		if (!empty($data['filter_name'])) {
			$sql .= " AND r.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$sql .= " AND r.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		// if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
		// 	$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
		// }

		if (!empty($data['submittime'])) {
			$sql .= " AND DATE(r.submittime) = DATE('" . $this->db->escape($data['submittime']) . "')";
		}

		$sort_data = array(
			'r.name',
			'r.email',
			'r.phone',
			'r.comment',
			'r.submitTime'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.submitTime";
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

	// public function getTotalInquiriess($data = array()) {
	// 	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "feedback r LEFT JOIN " . DB_PREFIX . "product_description pd ON (r.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

	// 	if (!empty($data['filter_product'])) {
	// 		$sql .= " AND pd.name LIKE '" . $this->db->escape($data['filter_product']) . "%'";
	// 	}

	// 	if (!empty($data['filter_author'])) {
	// 		$sql .= " AND r.author LIKE '" . $this->db->escape($data['filter_author']) . "%'";
	// 	}

	// 	if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
	// 		$sql .= " AND r.status = '" . (int)$data['filter_status'] . "'";
	// 	}

	// 	if (!empty($data['filter_date_added'])) {
	// 		$sql .= " AND DATE(r.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
	// 	}

	// 	$query = $this->db->query($sql);

	// 	return $query->row['total'];
	// }

	public function getTotalInquiriessAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "feedback");

		return $query->row['total'];
	}


   /**
	* 根据产品评论的id,获取评论图片
	* @author  dyl  783973660@qq.com  2016.9.7
	* @param   Int  $Inquiries_id  产品评论id
	*/
	// public function getInquiriesImg($id){
	// 	$sql = "select * from " . DB_PREFIX . "feedback_img where id = '".$id."' limit 6";

	// 	$query = $this->db->query($sql);

	// 	return $query->rows;
	// }

   /**
	* 根据id,删除数据,并删除图片
	* @author  dyl  783973660@qq.com  2016.9.7
	* @param   Int  $Inquiries_img_id   id
	*/
	// public function deleteInquiriesImg($feedback_img_id){
	// 	$sql = "select * from " . DB_PREFIX . "feedback_img where feedback_img_id = '".$feedback_img_id."'";
	// 	$query = $this->db->query($sql);
	// 	$data = $query->row;
	// 	if($data){
	// 		unlink(DIR_ROOT.$data['path']);
	// 	}

	// 	$sql = "delete from " . DB_PREFIX . "feedback_img where feedback_img_id = '".$feedback_img_id."'";

	// 	return $this->db->query($sql);
	// }
}