<?php
class ModelSettingFeedback extends Model {

	public function editFeedback($id, $data) {
        $sql = "UPDATE " . DB_PREFIX . "feedback SET name = '" . $this->db->escape($data['name']) . "', email = '{$this->db->escape($data['email'])}', comment = '{$this->db->escape($data['comment'])}', submitTime = NOW() where id = {$id}";
        $this->db->query( $sql );
	}

	public function deleteFeedback($ids) {
		//$this->db->query("DELETE FROM " . DB_PREFIX . "feedback WHERE id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "feedback WHERE id in (" . $ids . ")");
	}

	public function getFeedbackById($id) {
	    $sql = "SELECT f.*,c.name as coun_name FROM " . DB_PREFIX . "feedback f";

	    $sql .= " LEFT JOIN " . DB_PREFIX . "country c ON c.country_id = f.country_id ";

	    $sql .= " where f.id = ".$id ." order by f.id desc";

		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getFeedbackData($data = array()) {
        $sql="select f.*,c.name as coun_name from " . DB_PREFIX . "feedback f";

        $sql .= " LEFT JOIN " . DB_PREFIX . "country c ON c.country_id = f.country_id ";

		$implode = array();
		if (!empty($data['filter_name'])) {
			$implode[] = "f.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "f.email like '%" . $data['filter_email'] . "%'";
		}

		if (!empty($data['filter_submitTime'])) {
			$implode[] = "DATE(f.submitTime) = DATE('" . $this->db->escape($data['filter_submitTime']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$sql.=" order by id desc";

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


	public function getTotalFeedbackData($data = array()) {
        $sql="select count(*) as total from " . DB_PREFIX . "feedback f";

        $sql .= " LEFT JOIN " . DB_PREFIX . "country c ON c.country_id = f.country_id ";

		$implode = array();
		if (!empty($data['filter_name'])) {
			$implode[] = "f.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "f.email like '%" . $data['filter_email'] . "%'";
		}

		if (!empty($data['filter_submitTime'])) {
			$implode[] = "DATE(f.submitTime) = DATE('" . $this->db->escape($data['filter_submitTime']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	/**
	 * 根据affiliate_id修改域名信息
	 * @author dyl 783973660@qq.com 2016.1.18
	 * @param Int    $affiliateid 分销商用户id
	 * @param Array  $data        传入的要修改的数据
	 */
	/*public function editAffiliateDomainByAffiliateId($affiliateid, $data) {
        $sql = "UPDATE " . DB_PREFIX . "affiliate_domain SET domain = '" . $this->db->escape($data['domain']) . "', status = '" . $this->db->escape($data['domainstatus']) . "', remarks = '{$this->db->escape($data['remarks'])}', user_id = '{$this->user->getId()}', checkTime = NOW() where affiliate_id = {$affiliateid}";
        $this->db->query( $sql );
	}*/


}