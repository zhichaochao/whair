<?php
class ModelCatalogCategory extends Model {
	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row;
	}

	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

		return $query->rows;
	}

	public function getCategoryFilters($category_id) {
		$implode = array();

		$query = $this->db->query("SELECT filter_id FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$implode[] = (int)$result['filter_id'];
		}

		$filter_group_data = array();

		if ($implode) {
			$filter_group_query = $this->db->query("SELECT DISTINCT f.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY f.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)");

			foreach ($filter_group_query->rows as $filter_group) {
				$filter_data = array();

				$filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY f.sort_order, LCASE(fd.name)");

				foreach ($filter_query->rows as $filter) {
					$filter_data[] = array(
						'filter_id' => $filter['filter_id'],
						'name'      => $filter['name']
					);
				}

				if ($filter_data) {
					$filter_group_data[] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'filter'          => $filter_data
					);
				}
			}
		}

		return $filter_group_data;
	}

	public function getCategoryLayoutId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row['total'];
	}


	/**
     * 根据ID获取分类的banner图片(父类和子类分开获取)
     * @author  dyl  783973660@qq.com  2016.9.18
     * @param   Int  $category_id   类别ID
     */
	public function getCategoryImage($category_id) {
		/*$sql = "SELECT category_id,image,parent_id FROM " . DB_PREFIX . "category
				WHERE category_id = '" . (int)$category_id . "' AND status = '1'";
		$query = $this->db->query($sql);

		if($query->row['parent_id'] > 0){       //属于子类,再根据父类ID去查询图片
           $sql = "SELECT image FROM " . DB_PREFIX . "category
				   WHERE category_id = " . (int)$query->row['parent_id'] . " AND status = 1";
		   $query = $this->db->query($sql);
		}*/

		$sql = "SELECT image FROM " . DB_PREFIX . "category
				WHERE category_id = '" . (int)$category_id . "' AND status = '1'";
		$query = $this->db->query($sql);

		return $query->row;
	}


	/**
	 * 根据分类的父类ID,获取父类的名称
	 * @author dyl 783973660@qq.com 2016.9.20
	 * @param  Int   $parent_id  父类的ID
	 */
	public function getCategoryName($parent_id = 0) {
		$sql = "SELECT name FROM " . DB_PREFIX . "category_description
				WHERE category_id = " . (int)$parent_id . " AND language_id = " . (int)$this->config->get('config_language_id');

		$query = $this->db->query($sql);

		return !empty($query->row['name']) ? $query->row['name'] : '';
	}
	
	//PC端首页产品分类显示数据
    //PC端首页产品分类显示数据
    public function getShowCategories() {
        $query = $this->db->query("SELECT * FROM  " . DB_PREFIX . "category c
				LEFT JOIN " . DB_PREFIX . "category_description cd
				ON c.category_id = cd.category_id WHERE c.status = 1 AND c.pc_show = 1
				ORDER BY sort_order ASC LIMIT 8");
        return $query->rows;
    }

	public function getProduct($category_id){
	    $where = '';
	    $condition = '';
	    $field = '';
        if($this->customer->getGroupId()){
            $field = ', ps.price as special ';
            $where = " JOIN " . DB_PREFIX . "product_special AS ps ON ps.product_id = p.product_id ";
            $condition = " AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) AND ps.customer_group_id = " . $this->customer->getGroupId();
        }

	    $sql = 'SELECT p.product_id, pd.name, p.price, p.image ' . $field . ' FROM ' . DB_PREFIX . 'product AS p JOIN ' . DB_PREFIX . 'product_description AS pd ON p.product_id = pd.product_id JOIN ' . DB_PREFIX . 'product_to_category AS ptc ON ptc.product_id = p.product_id ' . $where . ' WHERE  p.status = "1" AND p.is_home = "1" AND ptc.category_id = ' . $category_id . $condition . ' AND pd.language_id = ' . $this->config->get('config_language_id') . " limit 4";

	    $query = $this->db->query($sql);

	    return $query->rows;
    }

}