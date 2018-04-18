<?php
class ModelCatalogUrlAlias extends Model {
	public function getUrlAlias($keyword) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($keyword) . "'");

		return $query->row;
	}
	
	/**
	 * 根据产品ID获取产品的关键字
	 */
	public function getKeyword($product_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . $this->db->escape($product_id) . "'";
	
		$query = $this->db->query($sql);
			// print_r($query->row);exit();
		if($query->row){
		return $query->row['keyword'];
		}else{
			return '';
		}
	}
}