<?php
class ModelDesignHome extends Model {
	private function querysql($sql)
	{
		$dbs= unserialize($this->config->get('db_database_data'));
		foreach ($dbs as $key => $value) {
			if($key==0){
				$this->db->query($sql);
			}else{
				$d='db'.$key;
				$this->$d->query($sql);
			}
		}
		
	}
	public function addHome($data) {
		$this->querysql("INSERT INTO " . DB_PREFIX . "home_page SET  video= '" . $this->db->escape($data['video']) . "',mimage= '" . $this->db->escape($data['mimage']) . "',title= '" . $this->db->escape($data['title']) . "',link= '" . $this->db->escape($data['link']) . "',image= '" . $this->db->escape($data['image']) . "', path= '" . $this->db->escape($data['path']) . "',  category_id = '" . (int)$data['category_id'] . "',  floor = '" . (int)$data['floor'] . "'");

		$home_id = $this->db->getLastId();

		

		return $home_id;
	}

	public function editHome($home_id, $data) {
		// print_r($data);exit();
		$this->querysql("UPDATE " . DB_PREFIX . "home_page SET  video= '" . $this->db->escape($data['video']) . "',title= '" . $this->db->escape($data['title']) . "',link= '" . $this->db->escape($data['link']) . "',mimage= '" . $this->db->escape($data['mimage']) . "',image= '" . $this->db->escape($data['image']) . "',path= '" . $this->db->escape($data['path']) . "',  category_id = '" . (int)$data['category_id'] . "',  floor = '" . (int)$data['floor'] . "' WHERE home_id = '" . (int)$home_id . "'");


		
	}

	public function deleteHome($home_id) {
		$this->querysql("DELETE FROM " . DB_PREFIX . "home_page WHERE home_id = '" . (int)$home_id . "'");
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
			$sql .= " ORDER BY floor";
		}

	
			$sql .= " ASC";
		
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
