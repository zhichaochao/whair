<?php
class ModelCommonNav extends Model {
	public function getNav($nav_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "nav` o LEFT JOIN " . DB_PREFIX . "nav_description od ON (o.nav_id = od.nav_id) WHERE o.nav_id = '" . (int)$nav_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getChildNavs($nav_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "nav` o LEFT JOIN " . DB_PREFIX . "nav_description od ON (o.nav_id = od.nav_id) WHERE  o.parent_id =  '".(int)$nav_id."'  ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getFiristNavs() {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "nav` o LEFT JOIN " . DB_PREFIX . "nav_description od ON (o.nav_id = od.nav_id) WHERE  o.parent_id = 0 AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'  ORDER BY sort_order ASC");

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
			$sql .= " ORDER BY  " . $data['sort'];
		} else {
			$sql .= " ORDER BY od.name";
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