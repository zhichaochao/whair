<?php
class ModelSaleProductInquiry extends Model {


	public function getInquirys($data = array()) {

		$sql = "SELECT pi.*,p.image,pd.name as pro_name,c.name as coun_name FROM " . DB_PREFIX . "product_inquiry pi ";

        $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = pi.product_id ";

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = pi.product_id ";

        $sql .= " LEFT JOIN " . DB_PREFIX . "country c ON c.country_id = pi.country_id ";

		$sql .= " WHERE 1=1 ";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "pi.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "pi.email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['filter_phone'])) {
			$implode[] = "pi.phone LIKE '%" . $this->db->escape($data['filter_phone']) . "%'";
		}

		if (isset($data['filter_source']) && !is_null($data['filter_source'])) {
			$implode[] = "pi.sign ='" . (int)$data['filter_source'] . "'";
		}

		if (!empty($data['filter_add_time'])) {
			$implode[] = "DATE(pi.add_time) = DATE('" . $this->db->escape($data['filter_add_time']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

        $sql .= " ORDER BY pi.add_time desc";

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
	}


	public function getTotalInquiry($data = array()) {

		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_inquiry pi ";

        $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = pi.product_id ";

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = pi.product_id ";

        $sql .= " LEFT JOIN " . DB_PREFIX . "country c ON c.country_id = pi.country_id ";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "pi.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "pi.email LIKE '%" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		if (isset($data['filter_source']) && !is_null($data['filter_source'])) {
			$implode[] = "pi.sign ='" . (int)$data['filter_source'] . "'";
		}

		if (!empty($data['filter_phone'])) {
			$implode[] = "pi.phone LIKE '%" . $this->db->escape($data['filter_phone']) . "%'";
		}

		if (!empty($data['filter_add_time'])) {
			$implode[] = "DATE(pi.add_time) = DATE('" . $this->db->escape($data['filter_add_time']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

    /**
     * 删除询盘数据 dyl add 2016.8.25
     * @author  dyl  783973660@qq.com 2016.8.25
     * @param   Int  $inquiry_id   询盘数据的id
     */
	public function deleteProductInquiry($inquiry_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_inquiry WHERE inquiry_id = " . (int)$inquiry_id);
	}


}