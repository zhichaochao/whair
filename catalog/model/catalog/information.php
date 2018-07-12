<?php
class ModelCatalogInformation extends Model {
	public function getInformation($information_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE i.information_id = '" . (int)$information_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");

		return $query->row;
	}
	
	public function getInformations() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information i LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");

// print_r( $query->rows);exit;
		return $query->rows;
	}

	public function getInformationLayoutId($information_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "information_to_layout WHERE information_id = '" . (int)$information_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}


	/**
	 * 获取左侧栏的链接内容
	 * @author  dyl 783973660@qq.com 2016.10.9
	 */
	public function getLeftInformation() {
		$sql = "SELECT i.information_id, ides.title, i.sort_order FROM " . DB_PREFIX . "information i
				LEFT JOIN " . DB_PREFIX . "information_description ides ON (i.information_id = ides.information_id)
			    WHERE ides.language_id = " . (int)$this->config->get('config_language_id') . "
			    AND i.status = 1 AND (i.information_id >= 8 OR i.sort_order >=5) ORDER BY i.sort_order, LCASE(ides.title) ASC";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getProfile($profile_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "profile i LEFT JOIN " . DB_PREFIX . "profile_description id ON (i.profile_id = id.profile_id) LEFT JOIN " . DB_PREFIX . "profile_to_store i2s ON (i.profile_id = i2s.profile_id) WHERE i.profile_id = '" . (int)$profile_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");

		return $query->row;
	}

	public function getProfiles() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "profile i LEFT JOIN " . DB_PREFIX . "profile_description id ON (i.profile_id = id.profile_id) LEFT JOIN " . DB_PREFIX . "profile_to_store i2s ON (i.profile_id = i2s.profile_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");

		return $query->rows;
	}

}