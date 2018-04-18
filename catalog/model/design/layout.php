<?php
class ModelDesignLayout extends Model {
	public function getLayout($route) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_route WHERE '" . $this->db->escape($route) . "' LIKE route AND store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY route DESC LIMIT 1");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

    //dyl改  添加sort_order作为读取内容的限定条件
	public function getLayoutModules($layout_id, $position, $sort_order='') {

		if(!empty($sort_order)){
           $sort_order = ' AND sort_order='.(int)$sort_order;
		}

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_module WHERE layout_id = '" . (int)$layout_id . "' AND position = '" . $this->db->escape($position) . "' {$sort_order} ORDER BY sort_order");

		return $query->rows;
	}

}