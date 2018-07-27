<?php
class ModelCatalogNav extends Model {
	
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
	public function addNav($data) {

		// print_r($data);exit();
		$this->querysql("INSERT INTO `" . DB_PREFIX . "nav` SET parent_id = '" . (int)$data['parent_id'] . "', url = '" . $this->db->escape($data['url']) . "',type = '" . $this->db->escape($data['type']) . "',seo_url = '" . $this->db->escape($data['seo_url']) . "',inside_id = '" . (int)$data['inside_id'] . "', is_target = '" .(int)$data['is_target'] . "',   sort_order = '" . (int)$data['sort_order'] . "'");

		$nav_id = $this->db->getLastId();

		foreach ($data['nav_description'] as $language_id => $value) {
			$this->querysql("INSERT INTO " . DB_PREFIX . "nav_description SET nav_id = '" . (int)$nav_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		

		return $nav_id;
	}

	public function editNav($nav_id, $data) {
		

		$this->querysql("UPDATE `" . DB_PREFIX . "nav`  SET parent_id = '" . (int)$data['parent_id'] . "', url = '" . $this->db->escape($data['url']) . "',type = '" . $this->db->escape($data['type']) . "',seo_url = '" . $this->db->escape($data['seo_url']) . "',inside_id = '" . (int)$data['inside_id'] . "', is_target = '" .(int)$data['is_target'] . "',   sort_order = '" . (int)$data['sort_order'] . "' WHERE nav_id = '" . (int)$nav_id . "'");

		$this->querysql("DELETE FROM " . DB_PREFIX . "nav_description WHERE nav_id = '" . (int)$nav_id . "'");

		foreach ($data['nav_description'] as $language_id => $value) {
			$this->querysql("INSERT INTO " . DB_PREFIX . "nav_description SET nav_id = '" . (int)$nav_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		
	}

	public function deleteNav($nav_id) {
		$this->querysql("DELETE FROM `" . DB_PREFIX . "nav` WHERE nav_id = '" . (int)$nav_id . "'");
		$this->querysql("DELETE FROM " . DB_PREFIX . "nav_description WHERE nav_id = '" . (int)$nav_id . "'");
	
	}

	public function getNav($nav_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "nav` o LEFT JOIN " . DB_PREFIX . "nav_description od ON (o.nav_id = od.nav_id) WHERE o.nav_id = '" . (int)$nav_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getFiristNavs() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "nav` o LEFT JOIN " . DB_PREFIX . "nav_description od ON (o.nav_id = od.nav_id) WHERE  o.parent_id = 0 ");

		return $query->rows;
	}

	public function getChildNavs($nav_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "nav` o LEFT JOIN " . DB_PREFIX . "nav_description od ON (o.nav_id = od.nav_id) WHERE  o.parent_id =  '".(int)$nav_id."'  ORDER BY sort_order ASC");

		return $query->rows;
	}


	public function getNavs($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "nav` o LEFT JOIN " . DB_PREFIX . "nav_description od ON (o.nav_id = od.nav_id) WHERE od.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND od.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'od.name',
			'o.type',
			'o.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY  o.parent_id," . $data['sort'];
		} else {
			$sql .= " ORDER BY o.parent_id,od.name";
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

	public function getNavDescriptions($nav_id) {
		$nav_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nav_description WHERE nav_id = '" . (int)$nav_id . "'");

		//add nav_id 用于记录后台用户操作日志
		foreach ($query->rows as $result) {
			$nav_data[$result['language_id']] = array(
				'nav_id' => $result['nav_id'],
				'name'      => $result['name']
				);
		}

		return $nav_data;
	}



	public function getTotalNavs() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "nav`");

		return $query->row['total'];
	}
	
	
}