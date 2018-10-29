<?php
class ModelExtensionPaymentTtBank extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/tt_bank');
		$this->load->model('tool/image');

		//$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		$status = true;
		if (!$this->cart->hasShipping()) {
			$status = false;
		}

			$poundage = '';
		if ($this->config->get('tt_bank_is_poundage')) {
			if ($this->config->get('tt_bank_poundage')) {
				$poundage =$this->config->get('tt_bank_poundage'); //保留两位小数
			}
		}



		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'tt_bank',
				'title'      =>'T/T Bank Transfer',
				'terms'      => '',
				'poundage'   => $poundage,
				'image'      =>HTTPS_SERVERS.'/image/catalog/banner/hangsengbank.jpg',
				'sort_order' => $this->config->get('tt_bank_sort_order')
			);
		}

		return $method_data;
	}
}
