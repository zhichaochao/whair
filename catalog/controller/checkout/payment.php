<?php
class ControllerCheckoutPayment extends Controller {
	public function index() {
        $this->load->language('checkout/checkout');

		if(isset($this->request->get['order_id'])&&!empty($this->request->get['order_id'])){
			$order_id = $this->request->get['order_id'];
            $this->session->data['order_id'] = $order_id;
		}else{
			if(!isset($this->session->data['order_id']) || empty($this->session->data['order_id'])){
				$this->response->redirect($this->url->link('checkout/cart'));
			}
			$order_id = $this->session->data['order_id'];
		}

        $this->load->model('checkout/order_total');
        $order_total = $this->model_checkout_order_total->getOrderTotal($order_id);

        $this->load->model('checkout/order');
        $order = $this->model_checkout_order->getOrder($order_id);
        
        if(isset($order['total'])){
            $order['usd_total'] = $this->currency->convert($order['total'],'GBP','USD');
        }else{
            $order['usd_total'] = 0;
        }
        $data['order'] = $order;
        if(!$order || $order['order_status'] != 'Pending'){
            unset($this->session->data['order_id']);
            $this->response->redirect($this->url->link('account/order'));
        }

        $products = $this->model_checkout_order->getOrderProducts($order_id);
        $this->load->model('catalog/product');

        foreach ($products as $key => $product) {
            $product_catalog = $this->model_catalog_product->getCatalog($product['product_id']);
            if(!empty($product_catalog) && is_array($product_catalog)){
                $gcatalog = array();
                foreach($product_catalog as $c){
                    $gcatalog[] = $c['name'];
                }
            }
            $products[$key]['catalog'] = implode(",", $gcatalog);
            $products[$key]['usd_price'] = $this->currency->convert($product['price'],'GBP','USD');
        }
        $data['products'] = $products;

        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];
            unset($this->session->data['error']);
        } else {
            $data['error_warning'] = '';
        }
        if (isset($this->session->data['account'])) {
                $data['account'] = $this->session->data['account'];
        } else {
                $data['account'] = '';
        }
        $data['totals'] = array();
        foreach ($order_total as $total) {
            $data['totals'][] = array(
                'title' => $total['title'],
                'text'  => $this->currency->format($total['value']),
                'value' => $this->currency->convert($total['value'],'GBP','USD') //dyl
            );
        }

		/*********************快捷支付*********************************/

		$data['express_pay'] = true;

		$this->load->model('extension/payment/pp_express');
		$this->load->model('tool/image');

		$L_PAYMENTREQUEST = array();
		$index = 0;

		foreach ($products as $key => $product) {

			$desc_str = 'L_PAYMENTREQUEST_0_DESC'.$index;
			$name_str = 'L_PAYMENTREQUEST_0_NAME'.$index;
			$qty_str = 'L_PAYMENTREQUEST_0_QTY'.$index;
			$amt_str = 'L_PAYMENTREQUEST_0_AMT'.$index;

			$L_PAYMENTREQUEST[$desc_str] 	= $product['option_name'];
			$L_PAYMENTREQUEST[$name_str] 	= $product['name'];
			$L_PAYMENTREQUEST[$qty_str] 	= $product['quantity'];
			$L_PAYMENTREQUEST[$amt_str] 	= $this->currency->format($product['price'], $this->currency->getCode(), '', false);
			$index++;
		}

		foreach ($order_total as $total) {
			$desc_str = 'L_PAYMENTREQUEST_0_DESC'.$index;
			$name_str = 'L_PAYMENTREQUEST_0_NAME'.$index;
			$qty_str = 'L_PAYMENTREQUEST_0_QTY'.$index;
			$amt_str = 'L_PAYMENTREQUEST_0_AMT'.$index;

			if($total['code']=='shipping'||$total['code']=='coupon'||$total['code']=='poundage'){
				$L_PAYMENTREQUEST[$desc_str] 	= $total['title'];
				$L_PAYMENTREQUEST[$name_str] 	= $total['code'];
				$L_PAYMENTREQUEST[$qty_str] 	= 1;
				$L_PAYMENTREQUEST[$amt_str] 	= $this->currency->format($total['value'],$this->currency->getCode(), '', false);
			}

			$index++;
		}

		$landingpage = 'Login';//普通支付
		if(@$this->session->data['is_paypal_creditcard'] == 1){
		    $landingpage = 'Billing';//信用卡支付
		}
		$order_id = $this->session->data['order_id'];

		$express_data = array(
			'METHOD'             => 'SetExpressCheckout',
			'RETURNURL'          => $this->url->link('checkout/payment/returnpay'),
			'CANCELURL'          => $this->url->link('checkout/payment/cancelpay'),
			'REQCONFIRMSHIPPING' => 0,
			'NOSHIPPING'         => 1,
			'LOCALECODE'         => 'en_US',
			'LANDINGPAGE'        => $landingpage,
			'CHANNELTYPE'        => 'Merchant',
			'ALLOWNOTE'          => 1,
            'ADDROVERRIDE'       => 0,
            'SOLUTIONTYPE'       => 'Sole',
            'PAGESTYLE'          => 'Hot Beauty Hair',
            'PAYMENTREQUEST_0_INVNUM' 				=> $order['order_no'],
			'PAYMENTREQUEST_0_SHIPPINGAMT' 			=> 0,
			'PAYMENTREQUEST_0_CURRENCYCODE' 		=> $order['currency_code'],
			'PAYMENTREQUEST_0_AMT' 					=> $this->currency->format($order['total'],$this->currency->getCode(), '', false),
			'PAYMENTREQUEST_0_ITEMAMT' 				=> $this->currency->format($order['total'],$this->currency->getCode(), '', false),
			'PAYMENTREQUEST_0_PAYMENTACTION' 		=> 'sale',
		);

		if (isset($this->session->data['pp_login']['seamless']['access_token']) && (isset($this->session->data['pp_login']['seamless']['customer_id']) && $this->session->data['pp_login']['seamless']['customer_id'] == $this->customer->getId()) && $this->config->get('pp_login_seamless')) {
			$express_data['IDENTITYACCESSTOKEN'] = $this->session->data['pp_login']['seamless']['access_token'];
		}

		$express_data = array_merge($express_data,$L_PAYMENTREQUEST);
		$result = $this->model_extension_payment_pp_express->call($express_data);

		$log = new Log('ec_paypal_reset.log');
		$log->write($express_data);
		$log->write($result);
		/**
		 * If a failed PayPal setup happens, handle it.
		 */
		if (!isset($result['TOKEN'])) {
			/**
			 * Unable to add error message to user as the session errors/success are not
			 * used on the cart or checkout pages - need to be added?
			 * If PayPal debug log is off then still log error to normal error log.
			 */
			if ($this->config->get('pp_express_debug') == 1) {
				$this->log->write(serialize($result));
			}
			$data['express_pay'] = false;
			$this->response->redirect($this->url->link('account/order'));
		}else{
			$this->session->data['paypal']['token'] = $result['TOKEN'];
			if ($this->config->get('pp_express_test') == 1) {
				$data['express_url'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $result['TOKEN'];
			} else {
				$data['express_url'] = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $result['TOKEN'];
			}
		}
		/*******************end  快捷支付*****************************/

		$this->response->redirect($data['express_url']);
        //$data['payment'] = $this->load->controller('extension/payment/' . $this->session->data['payment_method']['code']);       
        $this->response->setOutput($this->load->view('checkout/payment', $data));
	}
    
    public function returnpay() {
	
        if (isset($this->session->data['order_id'])) {
			$order_id = $this->session->data['order_id'];

			if(isset($this->request->get['token'])){

				$this->load->model('extension/payment/pp_express');

				$data = array(
					'METHOD' => 'GetExpressCheckoutDetails',
					'TOKEN'  => $this->request->get['token']
				);

				$resArray = $this->model_extension_payment_pp_express->call($data);

				$log = new Log('ec_paypal_get.log');
				$log->write($resArray);

				$ack = strtoupper($resArray["ACK"]);

				if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING'){

					$this->load->model('checkout/order_total');
					$order_total = $this->model_checkout_order_total->getOrderTotal($order_id);

					$this->load->model('checkout/order');
					$order = $this->model_checkout_order->getOrder($order_id);

					$products = $this->model_checkout_order->getOrderProducts($order_id);

					$paypal_data = array(
						'TOKEN'                      		=> $this->request->get['token'],
						'PAYERID'                    		=> $this->request->get['PayerID'],
						'METHOD'                     		=> 'DoExpressCheckoutPayment',
						'PAYMENTREQUEST_0_NOTIFYURL' 		=> $this->url->link('extension/payment/pp_express/ipn', '', 'SSL'),
						'RETURNFMFDETAILS'           		=> 1,
						'PAYMENTREQUEST_0_INVNUM' 			=> $order['order_no'],
						'PAYMENTREQUEST_0_SHIPPINGAMT' 		=> '',
						'PAYMENTREQUEST_0_CURRENCYCODE' 	=> $order['currency_code'],
						'PAYMENTREQUEST_0_PAYMENTACTION' 	=> $this->config->get('pp_express_method'),
						'PAYMENTREQUEST_0_ITEMAMT' 			=> $this->currency->format($order['total'],$this->currency->getCode(), '', false),
						'PAYMENTREQUEST_0_AMT' 				=> $this->currency->format($order['total'],$this->currency->getCode(), '', false)
					);

					$L_PAYMENTREQUEST = array();
					$index = 0;

					foreach ($products as $key => $product) {

						$desc_str = 'L_PAYMENTREQUEST_0_DESC'.$index;
						$name_str = 'L_PAYMENTREQUEST_0_NAME'.$index;
						$qty_str = 'L_PAYMENTREQUEST_0_QTY'.$index;
						$amt_str = 'L_PAYMENTREQUEST_0_AMT'.$index;

						$L_PAYMENTREQUEST[$desc_str] 	= $product['option_name'];
						$L_PAYMENTREQUEST[$name_str] 	= $product['name'];
						$L_PAYMENTREQUEST[$qty_str] 	= $product['quantity'];
						$L_PAYMENTREQUEST[$amt_str] 	= $this->currency->format($product['price'],$this->currency->getCode(), '', false);
						$index++;
					}

					foreach ($order_total as $total) {
						$desc_str = 'L_PAYMENTREQUEST_0_DESC'.$index;
						$name_str = 'L_PAYMENTREQUEST_0_NAME'.$index;
						$qty_str = 'L_PAYMENTREQUEST_0_QTY'.$index;
						$amt_str = 'L_PAYMENTREQUEST_0_AMT'.$index;

						if($total['code']=='shipping'||$total['code']=='coupon'||$total['code']=='poundage'){
							$L_PAYMENTREQUEST[$desc_str] 	= $total['title'];
							$L_PAYMENTREQUEST[$name_str] 	= $total['code'];
							$L_PAYMENTREQUEST[$qty_str] 	= 1;
							$L_PAYMENTREQUEST[$amt_str] 	= $this->currency->format($total['value'],$this->currency->getCode(), '', false);
						}

						$index++;
					}

					$paypal_data = array_merge($paypal_data, $L_PAYMENTREQUEST);

					$result_dos = $this->model_extension_payment_pp_express->call($paypal_data);

					if(isset($resArray['INVNUM'])){
						$result_dos['INVNUM'] = $resArray['INVNUM'];
					}else{
						$result_dos['INVNUM'] = '';
					}
                                        
					$log = new Log('ec_paypal_do.log');
					$log->write($result_dos);

					$ack = strtoupper($result_dos["ACK"]);

					if($ack != 'SUCCESS' && $ack != 'SUCCESSWITHWARNING'){
						//失败
						if(isset($result_dos['L_ERRORCODE0']) && $result_dos['L_ERRORCODE0']==10486){  //10486处理

							if ($this->config->get('pp_express_test') == 1) {
								$repaylPayPalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$this->request->get['token'];
							} else {
								$repaylPayPalURL = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$this->request->get['token'];
							}

								$temp_html = '<div class="tz" style="text-align:center;">';
								$temp_html  .='<p style="margin-bottom:70px; padding-left:15px; padding-right:15px; color:#999;">The balance on your card is insufficient . Please back to paypal and repay</p>
											<p></p>
											<p>Processing,Please Wait <span id="point">...</span> </p>';
								$temp_html .= '</div>';
								$temp_html .='<script type="text/javascript">setTimeout(function(){window.location.href ="'.$repaylPayPalURL . '"},2000);</script>';

								echo $temp_html;
								exit;
						}else{
								//失败
								$this->response->redirect($this->url->link('checkout/failure'));
						}

					}else{
						//成功

						//handle order status
						switch($result_dos['PAYMENTINFO_0_PAYMENTSTATUS']) {
							case 'Canceled_Reversal':
								$order_status_id = $this->config->get('pp_express_canceled_reversal_status_id');
								break;
							case 'Completed':
								$order_status_id = $this->config->get('pp_express_completed_status_id');
								break;
							case 'Denied':
								$order_status_id = $this->config->get('pp_express_denied_status_id');
								break;
							case 'Expired':
								$order_status_id = $this->config->get('pp_express_expired_status_id');
								break;
							case 'Failed':
								$order_status_id = $this->config->get('pp_express_failed_status_id');
								break;
							case 'Pending':
								$order_status_id = $this->config->get('pp_express_pending_status_id');
								break;
							case 'Processed':
								$order_status_id = $this->config->get('pp_express_processed_status_id');
								break;
							case 'Refunded':
								$order_status_id = $this->config->get('pp_express_refunded_status_id');
								break;
							case 'Reversed':
								$order_status_id = $this->config->get('pp_express_reversed_status_id');
								break;
							case 'Voided':
								$order_status_id = $this->config->get('pp_express_voided_status_id');
								break;
						}

						$order_id = $this->session->data['order_id'];
                                                
						$this->model_checkout_order->addOrderHistory($order_id, $order_status_id);

						//add order to paypal table
						$paypal_order_data = array(
							'order_id'         => $order_id,
							'capture_status'   => ($this->config->get('pp_express_method') == 'Sale' ? 'Complete' : 'NotComplete'),
							'currency_code'    => $result_dos['PAYMENTINFO_0_CURRENCYCODE'],
							'authorization_id' => $result_dos['PAYMENTINFO_0_TRANSACTIONID'],
							'total'            => $result_dos['PAYMENTINFO_0_AMT']
						);

						$paypal_order_id = $this->model_extension_payment_pp_express->addOrder($paypal_order_data);

						//add transaction to paypal transaction table
						$paypal_transaction_data = array(
							'paypal_order_id'       => $paypal_order_id,
							'transaction_id'        => $result_dos['PAYMENTINFO_0_TRANSACTIONID'],
							'parent_transaction_id' => '',
							'note'                  => '',
							'msgsubid'              => '',
							'receipt_id'            => (isset($result_dos['PAYMENTINFO_0_RECEIPTID']) ? $result_dos['PAYMENTINFO_0_RECEIPTID'] : ''),
							'payment_type'          => $result_dos['PAYMENTINFO_0_PAYMENTTYPE'],
							'payment_status'        => $result_dos['PAYMENTINFO_0_PAYMENTSTATUS'],
							'pending_reason'        => $result_dos['PAYMENTINFO_0_PENDINGREASON'],
							'transaction_entity'    => ($this->config->get('pp_express_method') == 'Sale' ? 'payment' : 'auth'),
							'amount'                => $result_dos['PAYMENTINFO_0_AMT'],
							'debug_data'            => json_encode($result_dos)
						);
						$this->model_extension_payment_pp_express->addTransaction($paypal_transaction_data);

						$recurring_products = $this->cart->getRecurringProducts();

						//loop through any products that are recurring items
						if ($recurring_products) {
							$this->load->model('checkout/recurring');

							$billing_period = array(
								'day'        => 'Day',
								'week'       => 'Week',
								'semi_month' => 'SemiMonth',
								'month'      => 'Month',
								'year'       => 'Year'
							);

							foreach ($recurring_products as $item) {
								$data_p = array(
									'METHOD'             => 'CreateRecurringPaymentsProfile',
									'TOKEN'              => $this->request->get['token'],
									'PROFILESTARTDATE'   => gmdate("Y-m-d\TH:i:s\Z", gmmktime(gmdate('H'), gmdate('i') + 5, gmdate('s'), gmdate('m'), gmdate('d'), gmdate('y'))),
									'BILLINGPERIOD'      => $billing_period[$item['recurring']['frequency']],
									'BILLINGFREQUENCY'   => $item['recurring']['cycle'],
									'TOTALBILLINGCYCLES' => $item['recurring']['duration'],
									'AMT'                => $this->currency->format($this->tax->calculate($item['recurring']['price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false) * $item['quantity'],
									'CURRENCYCODE'       => $this->currency->getCode()
								);

								//trial information
								if ($item['recurring']['trial'] == 1) {
									$data_trial = array(
										'TRIALBILLINGPERIOD'      => $billing_period[$item['recurring']['trial_frequency']],
										'TRIALBILLINGFREQUENCY'   => $item['recurring']['trial_cycle'],
										'TRIALTOTALBILLINGCYCLES' => $item['recurring']['trial_duration'],
										'TRIALAMT'                => $this->currency->format($this->tax->calculate($item['recurring']['trial_price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false) * $item['quantity']
									);

									$trial_amt = $this->currency->format($this->tax->calculate($item['recurring']['trial_price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false) * $item['quantity'] . ' ' . $this->currency->getCode();
									$trial_text =  sprintf($this->language->get('text_trial'), $trial_amt, $item['recurring']['trial_cycle'], $item['recurring']['trial_frequency'], $item['recurring']['trial_duration']);

									$data_p = array_merge($data_p, $data_trial);
								} else {
									$trial_text = '';
								}

								$recurring_amt = $this->currency->format($this->tax->calculate($item['recurring']['price'], $item['tax_class_id'], $this->config->get('config_tax')), false, false, false)  * $item['quantity'] . ' ' . $this->currency->getCode();
								$recurring_description = $trial_text . sprintf($this->language->get('text_recurring'), $recurring_amt, $item['recurring']['cycle'], $item['recurring']['frequency']);

								if ($item['recurring']['duration'] > 0) {
									$recurring_description .= sprintf($this->language->get('text_length'), $item['recurring']['duration']);
								}

								//create new recurring and set to pending status as no payment has been made yet.
								$recurring_id = $this->model_checkout_recurring->create($item, $order_id, $recurring_description);

								$data_p['PROFILEREFERENCE'] = $recurring_id;
								$data_p['DESC'] = $recurring_description;

								$result = $this->model_extension_payment_pp_express->call($data_p);

								if (isset($result['PROFILEID'])) {
									$this->model_checkout_recurring->addReference($recurring_id, $result['PROFILEID']);
								} else {
									// there was an error creating the recurring, need to log and also alert admin / user
								}
							}
						}

						if (isset($result['REDIRECTREQUIRED']) && $result['REDIRECTREQUIRED'] == true) {
							//- handle german redirect here
							$this->response->redirect('https://www.paypal.com/cgi-bin/webscr?cmd=_complete-express-checkout&token=' . $this->request->get['token']);
						} else {
							$this->response->redirect($this->url->link('checkout/success'));
						}

					}   //成功  $ack != 'SUCCESS' && $ack != 'SUCCESSWITHWARNING'  end

				}else{  //失败
                                   $this->response->redirect($this->url->link('checkout/failure'));
				}       //$ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING'  end

			}else{
                $this->response->redirect($this->url->link('checkout/failure'));
            }  
 			
		} 
	}


	/**
	 * 取消订单回调
	 */
	public function cancelpay() {
            $this->response->redirect('account-order/');
	}

}