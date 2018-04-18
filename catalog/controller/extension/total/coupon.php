<?php
class ControllerExtensionTotalCoupon extends Controller {
	public function index() {
		if ($this->config->get('coupon_status')) {
			$this->load->language('extension/total/coupon');

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_loading'] = $this->language->get('text_loading');

			$data['entry_coupon'] = $this->language->get('entry_coupon');

			$data['button_coupon'] = $this->language->get('button_coupon');

			if (isset($this->session->data['coupon'])) {
				$data['coupon'] = $this->session->data['coupon'];
			} else {
				$data['coupon'] = '';
			}

			return $this->load->view('extension/total/coupon', $data);
		}
	}

	public function coupon() {
		$this->load->language('extension/total/coupon');

		$json = array();

		$this->load->model('extension/total/coupon');

		if (isset($this->request->post['coupon'])) {
			$coupon = $this->request->post['coupon'];
		} else {
			$coupon = '';
		}
		
		$coupon_info = $this->model_extension_total_coupon->getCoupon($coupon);
		if (empty($this->request->post['coupon'])) {
		    if(!empty($this->session->data['coupon'])){
		        unset($this->session->data['coupon']);
		        $this->session->data['success'] = $this->language->get('text_cancel_success');
		    }else{
		        $this->session->data['error'] = $this->language->get('error_empty');
		    }
		} elseif ($coupon_info) {
		    if(!empty($this->session->data['coupon']) && $this->session->data['coupon']==$coupon){
		        unset($this->session->data['coupon']);
		        $this->session->data['success'] = $this->language->get('text_cancel_success');
		    }else{
    			$this->session->data['coupon'] = $this->request->post['coupon'];
    			$this->session->data['success'] = $this->language->get('text_success');
		    }
		} else {
		    //unset($this->session->data['coupon']);
			$this->session->data['error'] = $this->language->get('error_coupon');
		}
		
		$this->response->redirect($this->url->link('checkout/cart'));                      //dyl add
	}
	
	public function jcoupon() {
	    $this->load->language('extension/total/coupon');
	
	    $json = array();
	
	    $this->load->model('extension/total/coupon');
	
	    if (isset($this->request->post['coupon'])) {
	        $coupon = $this->request->post['coupon'];
	    } else {
	        $coupon = '';
	    }
	    
	    if(isset($this->request->post['comment'])) 
	        $this->session->data['comment'] = strip_tags($this->request->post['comment']);
	
	    $coupon_info = $this->model_extension_total_coupon->getCoupon($coupon);
	    if (empty($this->request->post['coupon'])) {
	        if(!empty($this->session->data['coupon'])){
	            unset($this->session->data['coupon']);
	            $this->session->data['success'] = $this->language->get('text_cancel_success');
	        }else{
    	        $json['error'] = $this->language->get('error_empty');
    	        unset($this->session->data['coupon']);
	        }
	    } elseif ($coupon_info) {
	        if(!empty($this->session->data['coupon']) && $this->session->data['coupon']==$coupon){
	            unset($this->session->data['coupon']);
	            $this->session->data['success'] = $this->language->get('text_cancel_success');
	        }else{
    	        $this->session->data['coupon'] = $this->request->post['coupon'];
    	        $this->session->data['success'] = $this->language->get('text_success');
	        }
	    } else {
	        //unset($this->session->data['coupon']);
	        $json['error'] = $this->language->get('error_coupon');
	    }
	
	    $this->response->addHeader('Content-Type: application/json');
	    $this->response->setOutput(json_encode($json));
	}
}
