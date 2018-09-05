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
		// if (isset($data['start']) || isset($data['limit'])) {
		// 	if ($data['start'] < 0) {
		// 		$data['start'] = 0;
		// 	}

		// 	if ($data['limit'] < 1) {
		// 		$data['limit'] = 20;
		// 	}

		// 	$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		// }
		// print_r($sql);exit();

		$query = $this->db->query($sql);

		return $query->rows;
	}
public function updateProductView($product_id)
	{
		$query= $this->db->query("SELECT * FROM " . DB_PREFIX . "product where product_id=".(int)$product_id);
		$row=$query->row;
		$query= $this->db->query("SELECT * FROM " . DB_PREFIX . "gallery where product_id=".(int)$product_id);
		$rows=$query->row;

		if (isset($rows['view'])) {
				$query= $this->db->query("UPDATE " . DB_PREFIX . "product set browse=".($row['browse']+1)." where product_id=".(int)$product_id);
				$query= $this->db->query("UPDATE " . DB_PREFIX . "gallery set view=".($rows['view']+1)." where product_id=".(int)$product_id);
		}else{
				$query= $this->db->query("UPDATE " . DB_PREFIX . "product set browse=".($row['browse']+1)." where product_id=".(int)$product_id);
		}
	
		
	}



}