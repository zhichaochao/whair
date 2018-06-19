<?php
class ModelDesignHome extends Model {
	public function addHome($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "home_page SET  vedio= '" . $this->db->escape($data['vedio']) . "',mimage= '" . $this->db->escape($data['mimage']) . "',image= '" . $this->db->escape($data['image']) . "',  category_id = '" . (int)$data['category_id'] . "',  floor = '" . (int)$data['floor'] . "'");

		$home_id = $this->db->getLastId();

		

		return $home_id;
	}

	public function editHome($home_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "home_page SET  vedio= '" . $this->db->escape($data['vedio']) . "',mimage= '" . $this->db->escape($data['mimage']) . "',image= '" . $this->db->escape($data['image']) . "',  category_id = '" . (int)$data['category_id'] . "',  floor = '" . (int)$data['floor'] . "' WHERE home_id = '" . (int)$home_id . "'");


		
	}

	public function deleteHome($home_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "home_page WHERE home_id = '" . (int)$home_id . "'");
	}

	public function getHome($home_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "home_page WHERE home_id = '" . (int)$home_id . "'");

		return $query->row;
	}


	public function getHomes($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "home_page";

		$sort_data = array(
			'name',
		
			'status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY home_id";
		}

	
			$sql .= " DESC";
		
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



	public function getTotalHomes() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "home_page");

		return $query->row['total'];
	}
}
