<?php
class ModelCommonGallery extends Model {

	
	public function getGallerys($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "gallery WHERE 1";
		$sort_data = array(
			'gallery_title',
			'order'
		);
		if (isset($data['is_home']) ){
			$sql .= " AND is_home=1 " ;
		} 
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}
		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
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