<?php
class ModelCommonHome extends Model {

	
	public function getHomePages($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "home_page WHERE 1";
		$sort_data = array(
			'title',
			'floor'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY floor";
		}
		if (isset($data['order']) && ($data['order'] == 'ADEC')) {
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
		// print_r($sql);exit();

		$query = $this->db->query($sql);

		return $query->rows;
	}




}