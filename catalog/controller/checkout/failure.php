<?php
class ControllerCheckoutFailure extends Controller {
	public function index() {
		$this->load->language('checkout/failure');
                
        if (isset($this->session->data['order_id'])) {

            $this->cart->clear();

            $order_id = $this->session->data['order_id'];

            $this->load->model('checkout/order');
            $order = $this->model_checkout_order->getOrder($this->session->data['order_id']);
            if(!empty($order['order_no'])){
               $data['text_order'] = sprintf($this->language->get('text_order'), $order['order_no']);
            }
             unset($this->session->data['shipping_method']);
             unset($this->session->data['shipping_methods']);
             unset($this->session->data['payment_method']);
             unset($this->session->data['payment_methods']);
             //unset($this->session->data['guest']);
             unset($this->session->data['comment']);
             //unset($this->session->data['order_id']);   //dyl屏蔽,刷新页面后,仍可以进入到if里面获取相应的值分配给页面使用
             unset($this->session->data['coupon']);
             unset($this->session->data['reward']);
             unset($this->session->data['voucher']);
             unset($this->session->data['vouchers']);
             unset($this->session->data['totals']);
             unset($this->session->data['is_paypal_creditcard']);

        }

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_basket'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_checkout'),
			'href' => $this->url->link('checkout/checkout', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_failure'),
			'href' => $this->url->link('checkout/failure')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = sprintf($this->language->get('text_message'), $this->url->link('information/contact'));

		$data['button_continue'] = $this->language->get('button_continue');

		$data['order_no'] = !empty($order['order_no']) ? $order['order_no'] : '';
		$data['order_list'] = $this->url->link('account/order');
		$data['continue'] = $this->url->link('common/home');
		$data['contact'] = $this->url->link('information/contact');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
        $data['account_left'] = $this->load->controller('account/left');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('checkout/failure', $data));
	}
}