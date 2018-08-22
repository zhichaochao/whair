<?php
class ModelCustomerInquiries extends Model {


	

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



	public function getTotalInquiriessAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "feedback");

		return $query->row['total'];
	}


  
}