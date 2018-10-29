<?php
class ModelExtensionTotalPoundage extends Model {

	public function getTotal($total) {
		//如果是paypal快捷支付方式，则进行手续费计算，否则直接返回false
		//common::pre($this->session->data['payment_method']);
		if (isset($this->session->data['payment_method']['code']) && $this->session->data['payment_method']['code'] == 'pp_express') {

			$this->load->language('extension/total/poundage');
			//手续费收取
			$poundage = '';
			if ($this->config->get('pp_express_is_poundage')) {
				if ($this->config->get('pp_express_poundage')) {

					$cost = $this->cart->getSubTotal();

					//是否包含邮费
					if ($this->config->get('pp_express_including_postage')) {
						if (isset($this->session->data['shipping_method'])) {
							$cost = $cost + $this->session->data['shipping_method']['cost'];
						}
					}
					$poundage = round($cost * ($this->config->get('pp_express_poundage')/100), 2); //保留两位小数
				}
			}

			$total['totals'][] = array(
				'code'        => 'poundage',
				'title'       => $this->language->get('text_poundage'),
				'value'       => $poundage,
				'sort_order'  => $this->config->get('poundage_sort_order')
			);

			$total['total'] += $poundage;

		}elseif (isset($this->session->data['payment_method']['code']) && ($this->session->data['payment_method']['code'] == 'tt_bank_transfer'||$this->session->data['payment_method']['code'] == 'tt_bank')) {
		
			$this->load->language('extension/total/poundage');
			//手续费收取
			$poundage = '';
			if ($this->config->get($this->session->data['payment_method']['code'].'_is_poundage')) {
				if ($this->config->get($this->session->data['payment_method']['code'].'_poundage')) {

				
					$poundage =$this->config->get($this->session->data['payment_method']['code'].'_poundage'); //保留两位小数
				}
			}

			$total['totals'][] = array(
				'code'        => 'poundage',
				'title'       => $this->language->get('text_poundage'),
				'value'       => $poundage,
				'sort_order'  => $this->config->get('poundage_sort_order')
			);

			$total['total'] += $poundage;

		}
	}
}
