<?php
/**
 * 后台用户登陆模型
 */
class ModelUserUserLogin extends Model{

   /**
    * 查询所有用户的登陆记录
    * @param Array $data            输入的刷选数据数组
    * return Array $results->rows   返回的查询数据数组
    */
   public function getUserLoginList($data=array()){
      $where = "where 1=1";
      //用户名查询
      if(!empty($data['filter_name'])){
        $where.= " and u.username like '%".$data['filter_name']."%'";
      }
      //按时间段查询
      if(!empty($data['filter_starttime']) && !empty($data['filter_endtime'])){
        $data['filter_endtime'] = strtotime('+1 day -1 second',$data['filter_endtime']);//所选当天日期的时间为：23:59:59
        $where.= " and ul.loginTime>=".$data['filter_starttime']." and ul.loginTime<=".$data['filter_endtime'];
      }
      //按开始时间查询，结束时间为空
      if(!empty($data['filter_starttime']) && empty($data['filter_endtime'])){
        $where.=" and ul.loginTime>=".$data['filter_starttime'];
      }
      //按结束时间查询，开始时间为空
      if(!empty($data['filter_endtime']) && empty($data['filter_starttime'])){
        $data['filter_endtime']=strtotime('+1 day -1 second',$data['filter_endtime']); //所选结束日期的24点的前一秒
        $where.=" and ul.loginTime<=".$data['filter_endtime'];
      }
      //按用户状态查询
      if(isset($data['filter_status']) && !is_null($data['filter_status'])){
        $where.= " and ul.loginResult=".(int)$data['filter_status'];
      }

      //设置每页显示的数据条数
      $limit = "";
      if(isset($data['start']) || isset($data['limit'])){
        if($data['start'] < 0){
          $data['start'] = 0;
        }
        if($data['limit'] < 1){
          $data['limit'] = 20;
        }
        $limit.=" LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
      }

      $sql = "SELECT u.username,ul.* FROM ".DB_PREFIX."user as u join ".DB_PREFIX."user_login as ul on u.user_id=ul.user_id ".$where." ORDER BY ul.id desc".$limit;

      $results = $this->db->query($sql);
      return $results->rows;
   }

   /**
    * 添加用户的登陆记录
    * @param Int    $userId       用户ID
    * @param String $password     密码
    * @param Int    $loginResult  登陆结果
    */
   public function addUserLoginList($userId,$password,$loginResult){
      $loginIp = $this->request->server['REMOTE_ADDR'];  //登录的IP地址
      $loginTime = time();  //登录的时间
      $sql = "INSERT INTO ".DB_PREFIX."user_login (user_id,loginPwd,loginIp,loginTime,loginResult) VALUES ($userId,'$password','$loginIp','$loginTime',$loginResult)";
      $this->db->query($sql);
      $this->cache->delete('userlogin');
   }

   /**
    * 数据总数查询
    * @author dyl 783973660@qq.com 2016.1.6
    * @param Array $data                 输入的刷选数据数组
    * return Int   $query->row['total']  返回的数据总数
    */
   public function getTotalUserLoginList($data = array()){
      //首先是查询所有的数据的条数
      $sql = "SELECT COUNT(DISTINCT ul.id) AS total from ". DB_PREFIX . "user u left join ". DB_PREFIX ."user_login ul on (u.user_id=ul.user_id)";

      $sql.= " where 1=1";
      //查询进过筛选后的数据的条数
      if(!empty($data['filter_name'])){
        $sql.= " and u.username LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
      }
      if(!empty($data['filter_starttime']) && !empty($data['filter_endtime'])){
        $data['filter_endtime'] = strtotime('+1 day -1 second',$data['filter_endtime']);//所选结束日期的24点的前一秒
        $sql.= " and ul.loginTime>=" . $data['filter_starttime'] . " and ul.loginTime<=" . $data['filter_endtime'];
      }
      if(!empty($data['filter_starttime']) && empty($data['filter_endtime'])){
        $sql.= " and ul.loginTime>=" . $data['filter_starttime'];
      }
      if(empty($data['filter_starttime']) && !empty($data['filter_endtime'])){
        $data['filter_endtime'] = strtotime('+1 day -1 second',$data['filter_endtime']);//所选结束日期的24点的前一秒
        $sql.= " and ul.loginTime<=" . $data['filter_endtime'];
      }
      if(isset($data['filter_status']) && !is_null($data['filter_status'])){
        $sql.= " and ul.loginResult='" . $data['filter_status'] . "'";
      }
      $query = $this->db->query($sql);
      return $query->row['total'];
   }

   //删除用户的登录记录
   public function delUserLoginList($user_login_id){
      $sql = "delete from " . DB_PREFIX . "user_login where id='" . (int)$user_login_id . "'";
      $this->db->query($sql); 
      //$this->cache->delete('userlogin');
   }

   /**
     * 统计并删除半年前的登陆记录
     * return    $total 满足删除条件的记录总数
     */
   public function totalAndDelSixMonthAgoLoginLogs(){
      //统计满足删除条件的id数量
      //$totalSql = "SELECT count(id) as total FROM " . DB_PREFIX . "user_login WHERE FROM_UNIXTIME(loginTime,'%Y-%m-%d') < '" . date('Y-m-d', strtotime('-6 month')) . "'";
      //$totalResult = $this->db->query($totalSql);

      //删除记录
      $deleteSql = "DELETE FROM " . DB_PREFIX . "user_login WHERE FROM_UNIXTIME(loginTime,'%Y-%m-%d') < '" . date('Y-m-d', strtotime('-6 month')) . "'";
      $this->db->query($deleteSql);

      //统计删除的记录数
      $total = $this->db->countAffected();   //return $totalResult->row['total'];
      return $total;
   }
}
