<?php
class ModelCatalogVideo extends Model {

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
	
	public function addVideo($data = array()) {

		$this->querysql("INSERT INTO " . DB_PREFIX . "video SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', video = '" . $data['video'] . "', status = '" . (int)$data['status'] . "' ,parent_id = '" . (int)$data['parent_id'] . "', image = '" . $data['image'] . "'");

		$video_id = $this->db->getLastId();
		// print_r($video_id);exit()

		foreach ($data['video_description'] as $language_id => $value) {
			// print_r($value);exit;
		$this->querysql("INSERT INTO " . DB_PREFIX . "video_description SET video_id = '" . (int)$video_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		// print_r("INSERT INTO " . DB_PREFIX . "video_description SET video_id = '" . (int)$video_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");exit();
		}

		if ($data['keyword']) {
		    $this->querysql("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id . "'");
		    $this->querysql("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['video_store'])) {
			foreach ($data['video_store'] as $store_id) {
				$this->querysql("INSERT INTO " . DB_PREFIX . "video_to_store SET video_id = '" . (int)$video_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['video_layout'])) {
			foreach ($data['video_layout'] as $store_id => $layout_id) {
				$this->querysql("INSERT INTO " . DB_PREFIX . "video_to_layout SET video_id = '" . (int)$video_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->querysql("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('video');

		return $video_id;
	}

	public function editVideo($video_id, $data) {
		$this->querysql("UPDATE " . DB_PREFIX . "video SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "', video = '" . $this->db->escape($data['video']) . "', image = '" . $this->db->escape($data['image']) . "', parent_id = '" . (int)$data['parent_id'] . "' WHERE video_id = '" . (int)$video_id . "'");

		$this->querysql("DELETE FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");

		foreach ($data['video_description'] as $language_id => $value) {
			$this->querysql("INSERT INTO " . DB_PREFIX . "video_description SET video_id = '" . (int)$video_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', seo_url = '" . $this->db->escape($data['keyword']) . "'");
		
		}

		$this->querysql("DELETE FROM " . DB_PREFIX . "video_to_store WHERE video_id = '" . (int)$video_id . "'");

		if (isset($data['video_store'])) {
			foreach ($data['video_store'] as $store_id) {
				$this->querysql("INSERT INTO " . DB_PREFIX . "video_to_store SET video_id = '" . (int)$video_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->querysql("DELETE FROM " . DB_PREFIX . "video_to_layout WHERE video_id = '" . (int)$video_id . "'");

		if (isset($data['video_layout'])) {
			foreach ($data['video_layout'] as $store_id => $layout_id) {
				$this->querysql("INSERT INTO " . DB_PREFIX . "video_to_layout SET video_id = '" . (int)$video_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->querysql("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id . "'");

		if ($data['keyword']) {
			$this->querysql("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('video');
	}

	public function deleteVideo($video_id) {
		$this->querysql("DELETE FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "'");
		$this->querysql("DELETE FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");
		$this->querysql("DELETE FROM " . DB_PREFIX . "video_to_store WHERE video_id = '" . (int)$video_id . "'");
		$this->querysql("DELETE FROM " . DB_PREFIX . "video_to_layout WHERE video_id = '" . (int)$video_id . "'");
		$this->querysql("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id . "'");

		$this->cache->delete('video');
	}

	public function getVideo($video_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id . "') AS keyword FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "'");

		return $query->row;
	}

	public function getVideos($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "video i LEFT JOIN " . DB_PREFIX . "video_description id ON (i.video_id = id.video_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			$sort_data = array(
				'id.title',
				'i.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY id.title";
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
	// print_r($sql );exit();
			return $query->rows;
		} else {
			$video_data = $this->cache->get('video.' . (int)$this->config->get('config_language_id'));

			if (!$video_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video i LEFT JOIN " . DB_PREFIX . "video_description id ON (i.video_id = id.video_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");

				$video_data = $query->rows;

				$this->cache->set('video.' . (int)$this->config->get('config_language_id'), $video_data);
			}

			return $video_data;
		}
	}

	public function getVideoDescriptions($video_id) {
		$video_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");

		//add video_id 用于记录用户操作日志
		foreach ($query->rows as $result) {
			$video_description_data[$result['language_id']] = array(
				'video_id'   => $result['video_id'],
				'title'            => $result['title'],
				//'image'            => $result['image'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $video_description_data;
	}

	public function getVideoStores($video_id) {
		$video_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_to_store WHERE video_id = '" . (int)$video_id . "'");

		foreach ($query->rows as $result) {
			$video_store_data[] = $result['store_id'];
		}

		return $video_store_data;
	}

	public function getVideoLayouts($video_id) {
		$video_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_to_layout WHERE video_id = '" . (int)$video_id . "'");

		foreach ($query->rows as $result) {
			$video_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $video_layout_data;
	}

	public function getTotalVideos() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "video");

		return $query->row['total'];
	}

	public function getTotalVideosByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "video_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
	
	//查询所有顶级分类的Title和video_id
	public function getParents(){
		$sql = "SELECT id.title, id.video_id FROM " . DB_PREFIX . "video_description id
				 LEFT JOIN " . DB_PREFIX . "video i ON i.video_id = id.video_id
				 WHERE i.parent_id = 0 AND i.status = 1";

		$query = $this->db->query($sql);
		return $query->rows;
	}
}