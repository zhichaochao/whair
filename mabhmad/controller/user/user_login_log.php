<?php
class ControllerUserUserLoginLog extends Controller {
	private $error = array();

	//用户登录记录
	public function loginLog(){
		$this->load->language('user/user');
		$this->document->setTitle($this->language->get('heading_login_title'));

		$url = '';
		//筛选用户名
		if(isset($this->request->get['filter_name'])){
			$url.= '&filter_name=' . urldecode(html_entity_decode($this->request->get['filter_name'],ENT_QUOTES,'UTF-8'));
			$filter_name = $this->request->get['filter_name'];
		}else{
			$filter_name = null;
		}
		//筛选开始时间
		if(isset($this->request->get['filter_starttime'])){
			$url.= '&filter_starttime' . urldecode(html_entity_decode($this->request->get['filter_starttime'],ENT_QUOTES,'UTF-8'));
			$filter_starttime = $this->request->get['filter_starttime'];
		}else{
			$filter_starttime = null;
		}
		//筛选结束时间
		if(isset($this->request->get['filter_endtime'])){
			$url.= '&filter_endtime' . urldecode(html_entity_decode($this->request->get['filter_endtime'],ENT_QUOTES,'UTF-8'));
			$filter_endtime = $this->request->get['filter_endtime'];
		}else{
			$filter_endtime = null;
		}
		//筛选状态
		if(isset($this->request->get['filter_status'])){
			$url.= '&filter_status' . urldecode(html_entity_decode($this->request->get['filter_status'],ENT_QUOTES,'UTF-8'));
			$filter_status = $this->request->get['filter_status'];
		}else{
			$filter_status = null;
		}

		//分页显示中的页码
		if(isset($this->request->get['page'])){
			$url.= '&page=' . $this->request->get['page'];
			$page = $this->request->get['page'];
		}else{
			$page = 1;
		}

		//判断开始时间是否大于结束时间
		if(isset($this->request->get['filter_starttime']) && isset($this->request->get['filter_endtime'])){
           if(strtotime($this->request->get['filter_starttime']) > strtotime($this->request->get['filter_endtime'])){
              $this->error['warning'] = $this->language->get('text_error_time');
           }
		}

		//面包屑导航链接
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/breadcrumbs', 'token=' . $this->session->data['token'],'SSL')
			);
		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_login_title'),
				'href' => $this->url->link('user/user_login_log/loginLog','token=' . $this->session->data['token'],'SSL')
			);

		//筛选数据的输入
		$filter_data = array(
				'filter_name'       => $filter_name,
				'filter_starttime'  => strtotime($filter_starttime),
				'filter_endtime'    => strtotime($filter_endtime),
				'filter_status'     => $filter_status,
				'start'             => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit'             => $this->config->get('config_limit_admin')
			);

		//加载user_login的model
		$this->load->model('user/user_login');
		//查询用户的登录信息，列表数据
		$results = $this->model_user_user_login->getUserLoginList($filter_data);
		//返回查询用户登录信息的条数
		$countResult = $this->model_user_user_login->getTotalUserLoginList($filter_data);

		//定义空数组，存储Model查询数据库返回的结果集
		$data['userloginlist'] = array();
		foreach($results as $result){
			$result['loginResult'] = $result['loginResult'] == 1 ? "login success" : "login fail";
			$data['userloginlist'][] = array(
					'id'           => $result['id'],
					'username'     => $result['username'],
					'loginPwd'     => $result['loginPwd'],
					'loginIp'      => $result['loginIp'],
					'loginTime'    => date("Y-m-d H:i:s",$result['loginTime']),
					'loginResult'  => $result['loginResult']
				);
		}

		$data['heading_login_title'] = $this->language->get('heading_login_title'); //页面头部大标题
		$data['text_user_login_logs_list'] = $this->language->get('text_user_login_logs_list'); //列表标题
		$data['entry_username'] = $this->language->get('entry_username'); 
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_starttime'] = $this->language->get('entry_starttime');
		$data['entry_endtime'] = $this->language->get('entry_endtime');
		//删除按钮
		//$data['button_delete'] = $this->language->get('button_delete');
		//表单action方法提交
		//$data['delete'] = $this->url->link('user/user_login_log/delUserLoginList', 'token=' . $this->session->data['token'] . $url,'SSL');
		//筛选按钮
		$data['button_filter'] = $this->language->get('button_filter');
		//删除按钮的弹窗提示
		$data['text_confirm'] = $this->language->get('text_confirm');
		//传递token值，前台url地址传值使用
		$data['token'] = $this->session->data['token'];

		//用户输入筛选数据
		$data['filter_name'] = $filter_name;
		$data['filter_starttime'] = $filter_starttime;
		$data['filter_endtime'] = $filter_endtime;

		//列表显示字段
		$data['id'] = $this->language->get('text_id');
		$data['user_login_username'] = $this->language->get('text_user_login_username');
		$data['user_login_password'] = $this->language->get('text_user_login_password');
		$data['user_login_ip'] = $this->language->get('text_user_login_ip');
		$data['user_login_time'] = $this->language->get('text_user_login_time');
		$data['user_login_result'] = $this->language->get('text_user_login_result');
		//成功、失败、返回结果信息
		$data['text_success'] = $this->language->get('text_user_login_success');
		$data['text_fail'] = $this->language->get('text_user_login_fail');
		$data['text_no_results'] = $this->language->get('text_no_results');

		//错误提示信息
		if(isset($this->error['warning'])){
			$data['error_warning'] = $this->error['warning'];
		}else{
			$data['error_warning'] = '';
		}

		//成功提示信息
		if(isset($this->session->data['success'])){
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}else{
			$data['success'] = '';
		}

		if(isset($this->request->post['selected'])){
			$data['selected'] = (array)$this->request->post['selected'];
		}else{
			$data['selected'] = array();
		}
		//数据分页显示
		$pagination = new Pagination();
		$pagination->total = $countResult;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('user/user_login_log/loginlog', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($countResult) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($countResult - $this->config->get('config_limit_admin'))) ? $countResult : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $countResult, ceil($countResult / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('user/login_log', $data));
	}

	//删除用户的登录记录
	public function delUserLoginList(){
		$this->load->language('user/user');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('user/user_login');

		if(isset($this->request->post['selected']) && $this->validate()){
			foreach($this->request->post['selected'] as $user_login_id){
				$this->model_user_user_login->delUserLoginList($user_login_id);
			}

		    //获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$done="deleteUserLoginLog";
			//调用父类Controller的方法将操作记录添加入库
            $this->addUserDone($doneUrl,$done);

			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if(isset($this->request->get['filter_name'])){
				$url.= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'],ENT_QUOTES,'UTF-8'));
			}
			if(isset($this->request->get['filter_starttime'])){
				$url.= '&filter_starttime=' . urlencode(html_entity_decode($this->request->get['filter_starttime'],ENT_QUOTES,'UTF-8'));
			}
			if(isset($this->request->get['filter_endtime'])){
				$url.= '&filter_endtime' . urlencode(html_entity_decode($this->request->get['filter_endtime'],ENT_QUOTES,'UTF-8'));
			}
			if(isset($this->request->get['filter_status'])){
				$url.= '&filter_status' . urlencode(html_entity_decode($this->request->get['filter_status'],ENT_QUOTES,'UTF-8'));
			}
			if(isset($this->request->get['page'])){
				$url.= '&page' . urlencode(html_entity_decode($this->request->get['page'],ENT_QUOTES,'UTF-8'));
			}
			$this->response->redirect($this->url->link('user/user_login_log/loginlog','token=' . $this->session->data['token'] . $url,'SSL'));
		}
		$this->loginLog();
	}

   /**
     * 删除半年前的登陆记录
     */
    public function delSixMonthAgoLoginLogs(){

        $this->load->model('user/user_login');
        $total = $this->model_user_user_login->totalAndDelSixMonthAgoLoginLogs();
        //删除的数量大于0,记录删除操作
		if($total > 0){
		   //获取路由参数
		   $doneUrl = isset($this->request->get['route']) ? $this->request->get['route'] : "";
		   $done = "deleteSixMonthAgoLoginLogs";
		   //调用父类Controller的方法将操作记录添加入库
           $this->addUserDone($doneUrl,$done);

           $json = array('code' => 1, 'message' => 'Delete '.$total.' records successfully!');
		}else{
		   $json = array('code' => 0, 'message' => 'Mismatched record available to delete!');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
    }

	//校验用户是否具有删除用户登录记录和操作记录的权限
	public function validate(){
		if(!$this->user->hasPermission('modify','user/user_login_log')){
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}