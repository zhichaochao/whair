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



}