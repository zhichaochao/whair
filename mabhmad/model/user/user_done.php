<?php
class ModelUserUserDone extends Model {

	/**
    * 查询所有用户的操作记录
    * @param Array $data     传递的参数
    * return Array $results  返回的结果数据
    */
	public function getUserDoneList($data) {

      $where=" where 1=1 ";
      //用户名
      if(!empty($data['filter_name'])){
      	$where.=" and u.username like '%".$data['filter_name']."%'";
      }
      if(!empty($data['filter_starttime']) && !empty($data['filter_endtime'])){
         $data['filter_endtime']=strtotime('+1 day -1 second',$data['filter_endtime']); //所选结束日期的24点的前一秒
         $where .=" and ud.doneTime>=".$data['filter_starttime'] ." and ud.doneTime<=".$data['filter_endtime'];
      }

      //开始时间
      if(!empty($data['filter_starttime']) && empty($data['filter_endtime'])){
        $where.=" and ud.doneTime>=".$data['filter_starttime'];
      }
      //结束时间
      if(!empty($data['filter_endtime']) && empty($data['filter_starttime'])){
      	$data['filter_endtime']=strtotime('+1 day -1 second',$data['filter_endtime']); //所选结束日期的24点的前一秒
        $where.=" and ud.doneTime<=".$data['filter_endtime'];
      }

      $limit="";
      if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}
			$limit .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
	  }

      $sql="SELECT u.username,ud.* FROM ". DB_PREFIX ."user as u join ". DB_PREFIX ."user_done as ud on u.user_id=ud.user_id ".$where." ORDER BY ud.id desc".$limit;
      $results = $this->db->query($sql);

      return $results->rows;
   }

   	/**
    * 添加用户的操作记录(主要用于记录各个模块的增删改操作)
    * @param Int    $userId       用户ID
    * @param String $doneUrl      操作的url
    * @param String $done         操作的动态(添加、修改、删除)
    */
	public function addUserDoneList($userId,$doneUrl,$done){
		$doneIp = $this->request->server['REMOTE_ADDR']; //操作者的IP
		$doneTime = time();  //操作时间
		$sql = "insert into " . DB_PREFIX . "user_done (user_id,doneUrl,done,doneIp,doneTime) values($userId,'$doneUrl','$done','$doneIp',$doneTime)";
		$this->db->query($sql);
	}

	/**
    * 删除用户的操作记录
    * @param Int $user_done_id  用户的操作ID
    */
   public function delUserDoneList($user_done_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "user_done WHERE id = '" . (int)$user_done_id . "'");
   }

   /**
    * 数据总数查询
    * @param Array $data
    * return Int   $total
    */
   public function getTotalUserDoneList($data = array()) {
		$sql = "SELECT COUNT(DISTINCT ud.id) AS total FROM " . DB_PREFIX . "user u LEFT JOIN " . DB_PREFIX . "user_done ud ON (u.user_id = ud.user_id)";

        $sql .=" WHERE 1=1 ";
		if(!empty($data['filter_name'])) {
		   $sql .= " AND u.username LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		if(!empty($data['filter_starttime']) && !empty($data['filter_endtime'])){
           $data['filter_endtime']=strtotime('+1 day -1 second',$data['filter_endtime']); //所选结束日期的24点的前一秒
           $sql .=" and ud.doneTime>=".$data['filter_starttime'] ." and ud.doneTime<=".$data['filter_endtime'];
        }
		//开始时间
	    if(!empty($data['filter_starttime']) && empty($data['filter_endtime'])){
	       $sql.=" and ud.doneTime>=".$data['filter_starttime'];
	    }
	    //结束时间
	    if(!empty($data['filter_endtime']) && empty($data['filter_starttime'])){
	       $data['filter_endtime']=strtotime('+1 day -1 second',$data['filter_endtime']); //所选结束日期的24点的前一秒
	       $sql.=" and ud.doneTime<=".$data['filter_endtime'];
	    }
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

   /**
    * 统计并删除半年前的操作记录
    * return    $totalResult->row['total']  满足删除条件的记录总数
    */
	public function totalAndDelSixMonthAgoDoneLogs(){
		$deleteSql = "delete from " . DB_PREFIX . "user_done where from_unixtime(doneTime,'%Y-%m-%d') < '" .date('Y-m-d',strtotime('-6 month')) . "'";
		$this->db->query($deleteSql);
		$total = $this->db->countAffected();
		return $total;
	}
}