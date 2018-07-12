<?php
class ControllerCommonUpdateCustomer extends Controller {
	public function index() {
		//更新用户等级和对应订单金额总数
		$this->load->model('account/customer');
		$this->model_account_customer->updateCustomerInfo();
	}
}
