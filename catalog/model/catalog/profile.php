<?php
class ModelCatalogProfile extends Model {
	public function getProfile($profile_id) {
			$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "profile i LEFT JOIN " . DB_PREFIX . "profile_description id ON (i.profile_id = id.profile_id) LEFT JOIN " . DB_PREFIX . "profile_to_store i2s ON (i.profile_id = i2s.profile_id) WHERE i.profile_id = '" . (int)$profile_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");

		return $query->row;
	}
	
	public function getProfiles($parent_id='',$limit_num='') {
		$where=' ';
		if ($parent_id>0) {
			$where.=' AND parent_id ='.$parent_id;
		}else{
			$where.=' AND parent_id =0';
		}
		$limit='';
		if ($limit_num>0) {
			$limit.=' limit 0,'.$limit_num;
		}
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "profile i LEFT JOIN " . DB_PREFIX . "profile_description id ON (i.profile_id = id.profile_id) LEFT JOIN " . DB_PREFIX . "profile_to_store i2s ON (i.profile_id = i2s.profile_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'  ".$where."  ORDER BY i.sort_order, LCASE(id.title) ASC ".$limit);

	
		return $query->rows;
	}
	public function updateProfileView($profile_id)
	{
		$query= $this->db->query("SELECT * FROM " . DB_PREFIX . "profile where profile_id=".(int)$profile_id);
		$row=$query->row;
		if (isset($row['view'])) {
				$query= $this->db->query("UPDATE " . DB_PREFIX . "profile set view=".($row['view']+1)." where profile_id=".(int)$profile_id);
		}
	
		
	}
public function getVideo($limit_num='') {
		// $where=' ';
		// if ($parent_id>0) {
		// 	$where.=' AND parent_id ='.$parent_id;
		// }else{
		// 	$where.=' AND parent_id =0';
		// }
		$limit='';
		if ($limit_num>0) {
			$limit.=' limit 0,'.$limit_num;
		}
			$query = $this->db->query("SELECT video,gallery_title,image FROM " . DB_PREFIX . "gallery id " .$limit);

	//var_dump($query);exit;
		return $query->rows;
	}
	public function getVideos() {

			$query = $this->db->query("SELECT video,gallery_title,image FROM " . DB_PREFIX . "gallery id ");

	//var_dump($query);exit;
		return $query->rows;
	}


}