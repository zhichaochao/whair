<?php
class ModelCatalogCustomerShare extends Model {

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

	public function addShareImage($data) {
        if($this->db->query("SELECT product_id FROM ". DB_PREFIX . "customer_share WHERE product_id='".(int)$data['product_id']."'")){
            $sql = "DELETE FROM ". DB_PREFIX . "customer_share WHERE product_id='".(int)$data['product_id']."'";
            $this->querysql($sql);
        }
        $sql = "INSERT INTO " . DB_PREFIX . "customer_share set product_id= '".$data['product_id']."',status=".$data['status'].",is_home=".$data['is_home'];
		$this->querysql($sql);

        if (isset($data['image'])) {
            $this->querysql("UPDATE " . DB_PREFIX . "customer_share SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int)$data['product_id'] . "'");
        }

        if (isset($data['product_image'])) {
            $this->querysql("DELETE FROM " . DB_PREFIX . "customer_share_image WHERE product_id = '" . (int)$data['product_id'] . "'");
            foreach ($data['product_image'] as $product_image) {
                $this->querysql("INSERT INTO " . DB_PREFIX . "customer_share_image SET product_id = '" . (int)$data['product_id'] . "', image = '" . $this->db->escape($product_image['image']) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
            }
        }

	}

	public function getProductShare($product_id){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_share WHERE product_id = '" . (int)$product_id . "'");

        return $query->rows;
    }

	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_share_image WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}
}
