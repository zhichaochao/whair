<?php
class ControllerUserUserDoneLog extends Controller {
	private $error = array();

    //用户的操作记录
    public function doneLog(){
    	//加载语言库
    	$this->load->language('user/user');
    	$this->document->setTitle($this->language->get('heading_done_title'));

    	$url = '';
        //刷选的用户名
        if (isset($this->request->get['filter_name'])) {
        	$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
        //刷选的开始时间
		if (isset($this->request->get['filter_starttime'])) {
			$url .= '&filter_starttime=' . urlencode(html_entity_decode($this->request->get['filter_starttime'], ENT_QUOTES, 'UTF-8'));
			$filter_starttime = $this->request->get['filter_starttime'];
		} else {
			$filter_starttime = null;
		}
		//刷选的结束时间
		if (isset($this->request->get['filter_endtime'])) {
			$url .= '&filter_endtime=' . urlencode(html_entity_decode($this->request->get['filter_endtime'], ENT_QUOTES, 'UTF-8'));
			$filter_endtime = $this->request->get['filter_endtime'];
		} else {
			$filter_endtime = null;
		}

		//判断开始时间是否大于结束时间
		if(isset($this->request->get['filter_starttime']) && isset($this->request->get['filter_endtime'])){
           if(strtotime($this->request->get['filter_starttime']) > strtotime($this->request->get['filter_endtime'])){
              $this->error['warning'] = $this->language->get('text_error_time');
           }
		}

		//页码
		if(isset($this->request->get['page'])){
			$url.= '&page=' . $this->request->get['page'];
			$page = $this->request->get['page'];
		}else{
			$page = 1;
		}

		//输入筛选数据
		$filter_data = array(
				'filter_name' 		=> $filter_name,
				'filter_starttime'  => strtotime($filter_starttime),
				'filter_endtime'    => strtotime($filter_endtime),
				'start'             => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit'             => $this->config->get('config_limit_admin')
			);

    	//面包屑导航栏
    	$data['breadcrumbs'] = array();
    	$data['breadcrumbs'][] = array(
    			'text' => $this->language->get('text_home'),
    			'href' => $this->url->link('common/dashboard','token=' . $this->session->data['token'],'SSL')
    		);
    	$data['breadcrumbs'][] = array(
    			'text' => $this->language->get($this->language->get('heading_done_title')),
    			'href' => $this->url->link('user/user_done_log/doneLog','token=' . $this->session->data['token'],'SSL')
    		);

    	//加载模型
    	$this->load->model('user/user_done');
    	//查询列表数据
    	$results = $this->model_user_user_done->getUserDoneList($filter_data);
    	//查询数据库总的记录数
    	$countResult = $this->model_user_user_done->getTotalUserDoneList($filter_data);

    	//定义空数组
    	$data['userdonelist'] = array();
    	foreach ($results as $result) {
    		$data['userdonelist'][] = array(
    				'id'        => $result['id'],
    				'username'  => $result['username'],
    				'doneUrl'   => $result['doneUrl'],
    				'done'      => $result['done'],
					'doneIp'    => $result['doneIp'],
					'doneTime'  => date("Y-m-d H:i:s",$result['doneTime'])
    			);
    	}

    	//删除按钮
		//$data['button_delete'] = $this->language->get('button_delete');
		//删除按钮的链接
		//$data['delete'] = $this->url->link('user/user_done_log/delUserdoneList', 'token=' . $this->session->data['token'] . $url, 'SSL');
		//删除时的询问
		$data['text_confirm'] = $this->language->get('text_confirm');

    	//筛选数据显示
    	$data['heading_title'] = $this->language->get('heading_done_title');
    	$data['text_list'] = $this->language->get('text_user_done_logs_list');
    	$data['entry_name'] = $this->language->get('entry_username');
    	$data['entry_starttime'] = $this->language->get('entry_starttime');
    	$data['entry_endtime'] = $this->language->get('entry_endtime');
    	$data['button_filter'] = $this->language->get('button_filter');
    	$data['token'] = $this->session->data['token'];

    	//列表数据显示
    	$data['id'] = $this->language->get('text_id');
    	$data['user_done_username'] = $this->language->get('text_user_done_username');
    	$data['user_done_url'] = $this->language->get('text_user_done_url');
    	$data['user_done'] = $this->language->get('text_user_done');
    	$data['user_done_ip'] = $this->language->get('text_user_done_ip');
    	$data['user_done_time'] = $this->language->get('text_user_done_time');
    	$data['text_no_results'] = $this->language->get('text_no_results');

    	//错误提示
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
        //成功提示
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

    	//分页
        $pagination = new Pagination();
		$pagination->total = $countResult;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('user/user_done_log/doneLog', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($countResult) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($countResult - $this->config->get('config_limit_admin'))) ? $countResult : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $countResult, ceil($countResult / $this->config->get('config_limit_admin')));

    	$data['filter_name'] = $filter_name;
    	$data['filter_starttime'] = $filter_starttime;
    	$data['filter_endtime'] = $filter_endtime;

    	$data['header'] = $this->load->controller('common/header');
    	$data['column_left'] = $this->load->controller('common/column_left');
    	$data['footer'] = $this->load->controller('common/footer');

    	$this->response->setOutput($this->load->view('user/done_log',$data));
    }

	/**
     * 删除用户的操作记录(删除该记录的操作,不需要再记录入库)
     * @author dyl 783973660@qq.com 2016.1.6
     */
    public function delUserDoneList(){
        $this->load->language('user/user');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('user/user_done');

		if (isset($this->request->post['selected']) && $this->validate()) {
			foreach ($this->request->post['selected'] as $user_done_id) {
                $this->model_user_user_done->delUserDoneList($user_done_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			if (isset($this->request->get['filter_starttime'])) {
				$url .= '&filter_starttime=' . urlencode(html_entity_decode($this->request->get['filter_starttime'], ENT_QUOTES, 'UTF-8'));
			}
			if (isset($this->request->get['filter_endtime'])) {
				$url .= '&filter_endtime=' . urlencode(html_entity_decode($this->request->get['filter_endtime'], ENT_QUOTES, 'UTF-8'));
			}
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('user/user_done_log/doneLog', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->doneLog();
    }
	
    /**
     * 删除半年前的操作记录
     */
    public function delSixMonthAgoDoneLogs(){

        $this->load->model('user/user_done');
        $total = $this->model_user_user_done->totalAndDelSixMonthAgoDoneLogs();
        //删除的数量大于0,记录删除操作
		if($total > 0){
		   //获取路由参数
		   $doneUrl = isset($this->request->get['route']) ? $this->request->get['route'] : "";
		   $done = "deleteSixMonthAgoDoneLogs";
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
		if(!$this->user->hasPermission('modify','user/user_done_log')){
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
}