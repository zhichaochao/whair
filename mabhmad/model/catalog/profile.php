<?php
class ModelCatalogProfile extends Model {

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
	
	public function addProfile($data = array()) {

		$this->querysql("INSERT INTO " . DB_PREFIX . "profile SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "' ,parent_id = '" . (int)$data['parent_id'] . "', author = '" . $this->db->escape($data['author']) . "', image = '" . $data['image'] . "', images = '" . $data['images'] . "', add_time = NOW(), update_time = NOW(), view = 0");

		$profile_id = $this->db->getLastId();

		foreach ($data['profile_description'] as $language_id => $value) {
		$this->querysql("INSERT INTO " . DB_PREFIX . "profile_description SET profile_id = '" . (int)$profile_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		// print_r($p);exit();
		}

		if ($data['keyword']) {
		    $this->querysql("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'profile_id=" . (int)$profile_id . "'");
		    $this->querysql("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'profile_id=" . (int)$profile_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['profile_store'])) {
			foreach ($data['profile_store'] as $store_id) {
				$this->querysql("INSERT INTO " . DB_PREFIX . "profile_to_store SET profile_id = '" . (int)$profile_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['profile_layout'])) {
			foreach ($data['profile_layout'] as $store_id => $layout_id) {
				$this->querysql("INSERT INTO " . DB_PREFIX . "profile_to_layout SET profile_id = '" . (int)$profile_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->querysql("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'profile_id=" . (int)$profile_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('profile');

		return $profile_id;
	}

	public function editProfile($profile_id, $data) {
		$this->querysql("UPDATE " . DB_PREFIX . "profile SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "', author = '" . $this->db->escape($data['author']) . "', update_time = NOW(), image = '" . $this->db->escape($data['image']) . "', images = '" . $this->db->escape($data['images']) . "', parent_id = '" . (int)$data['parent_id'] . "' WHERE profile_id = '" . (int)$profile_id . "'");

		$this->querysql("DELETE FROM " . DB_PREFIX . "profile_description WHERE profile_id = '" . (int)$profile_id . "'");

		foreach ($data['profile_description'] as $language_id => $value) {
			$this->querysql("INSERT INTO " . DB_PREFIX . "profile_description SET profile_id = '" . (int)$profile_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "', seo_url = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->querysql("DELETE FROM " . DB_PREFIX . "profile_to_store WHERE profile_id = '" . (int)$profile_id . "'");

		if (isset($data['profile_store'])) {
			foreach ($data['profile_store'] as $store_id) {
				$this->querysql("INSERT INTO " . DB_PREFIX . "profile_to_store SET profile_id = '" . (int)$profile_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->querysql("DELETE FROM " . DB_PREFIX . "profile_to_layout WHERE profile_id = '" . (int)$profile_id . "'");

		if (isset($data['profile_layout'])) {
			foreach ($data['profile_layout'] as $store_id => $layout_id) {
				$this->querysql("INSERT INTO " . DB_PREFIX . "profile_to_layout SET profile_id = '" . (int)$profile_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->querysql("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'profile_id=" . (int)$profile_id . "'");

		if ($data['keyword']) {
			$this->querysql("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'profile_id=" . (int)$profile_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('profile');
	}

	public function deleteProfile($profile_id) {
		$this->querysql("DELETE FROM " . DB_PREFIX . "profile WHERE profile_id = '" . (int)$profile_id . "'");
		$this->querysql("DELETE FROM " . DB_PREFIX . "profile_description WHERE profile_id = '" . (int)$profile_id . "'");
		$this->querysql("DELETE FROM " . DB_PREFIX . "profile_to_store WHERE profile_id = '" . (int)$profile_id . "'");
		$this->querysql("DELETE FROM " . DB_PREFIX . "profile_to_layout WHERE profile_id = '" . (int)$profile_id . "'");
		$this->querysql("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'profile_id=" . (int)$profile_id . "'");

		$this->cache->delete('profile');
	}

	public function getProfile($profile_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'profile_id=" . (int)$profile_id . "') AS keyword FROM " . DB_PREFIX . "profile WHERE profile_id = '" . (int)$profile_id . "'");

		return $query->row;
	}

	public function getProfiles($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "profile i LEFT JOIN " . DB_PREFIX . "profile_description id ON (i.profile_id = id.profile_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";

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

			return $query->rows;
		} else {
			$profile_data = $this->cache->get('profile.' . (int)$this->config->get('config_language_id'));

			if (!$profile_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "profile i LEFT JOIN " . DB_PREFIX . "profile_description id ON (i.profile_id = id.profile_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");

				$profile_data = $query->rows;

				$this->cache->set('profile.' . (int)$this->config->get('config_language_id'), $profile_data);
			}

			return $profile_data;
		}
	}

	public function getProfileDescriptions($profile_id) {
		$profile_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "profile_description WHERE profile_id = '" . (int)$profile_id . "'");

		//add profile_id 用于记录用户操作日志
		foreach ($query->rows as $result) {
			$profile_description_data[$result['language_id']] = array(
				'profile_id'   => $result['profile_id'],
				'title'            => $result['title'],
				//'author'            => $result['author'],
				//'image'            => $result['image'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $profile_description_data;
	}

	public function getProfileStores($profile_id) {
		$profile_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "profile_to_store WHERE profile_id = '" . (int)$profile_id . "'");

		foreach ($query->rows as $result) {
			$profile_store_data[] = $result['store_id'];
		}

		return $profile_store_data;
	}

	public function getProfileLayouts($profile_id) {
		$profile_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "profile_to_layout WHERE profile_id = '" . (int)$profile_id . "'");

		foreach ($query->rows as $result) {
			$profile_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $profile_layout_data;
	}

	public function getTotalProfiles() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "profile");

		return $query->row['total'];
	}

	public function getTotalProfilesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "profile_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
	
	//查询所有顶级分类的Title和profile_id
	public function getParents(){
		$sql = "SELECT id.title, id.profile_id FROM " . DB_PREFIX . "profile_description id
				 LEFT JOIN " . DB_PREFIX . "profile i ON i.profile_id = id.profile_id
				 WHERE i.parent_id = 0 AND i.status = 1";

		$query = $this->db->query($sql);
		return $query->rows;
	}
}