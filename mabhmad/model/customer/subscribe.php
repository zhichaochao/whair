<?php
class ModelCustomerSubscribe extends Model {

	public function deleteSubscribe($news_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "newsletter WHERE news_id = '" . (int)$news_id . "'");

		$this->cache->delete('product');
	}

	public function getSubscribe($news_id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "newsletter r  WHERE r.news_id = '" . (int)$news_id . "'");

		return $query->row;
	}

	public function getSubscribes($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "newsletter r";
		$sort_data = array(
			'r.news_id',
			'r.news_email',
			'r.subtime'
		);
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY r.news_email";
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

	public function getTotalSubscribesAwaitingApproval() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "newsletter");

		return $query->row['total'];
	}
	public function updsubscribes($news_id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "newsletter r  WHERE r.news_id = '" . (int)$news_id . "'");
		if($query->row['status']==1){
			$querys = $this->db->query("UPDATE " . DB_PREFIX . "newsletter SET status = 0 WHERE news_id = '" . (int)$news_id . "'");
		}else{
			$querys = $this->db->query("UPDATE " . DB_PREFIX . "newsletter SET status = 1 WHERE news_id = '" . (int)$news_id . "'");	
		}
		return $querys;
	}



}