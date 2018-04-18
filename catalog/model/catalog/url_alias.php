<?php

/**
 * url别名控制器
 * @author  dyl 783973660@qq.com 2016.10.9
 */
class ModelCatalogUrlAlias extends Model {

	public function getUrlAlias($queryString) {

        $sql = "SELECT keyword FROM " . DB_PREFIX . "url_alias
        		WHERE query = '" . $this->db->escape($queryString) . "'";
		$query = $this->db->query($sql);

		return !empty($query->row['keyword']) ? $query->row['keyword'] : '';
	}
	
}