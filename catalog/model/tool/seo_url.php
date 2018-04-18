<?php

/**
 * seo url的模型,对个别链接进行添加或者读取操作
 * @author  dyl 783973660@qq.com 2016.10.16
 */
class ModelToolSeourl extends Model {

	public function getSeourl($route) {

		$sql = "SELECT keyword FROM " . DB_PREFIX . "url_alias
				WHERE query = '" . $this->db->escape($route) . "'";

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function addSeourl($route) {

        $seo_url = str_replace('/','-',$route);

		$sql = "INSERT INTO " . DB_PREFIX . "url_alias
				SET query = '" . $this->db->escape($route) . "', keyword = '" . $this->db->escape($seo_url)."'";

		$result = $this->db->query($sql);

		return $result;
	}



}