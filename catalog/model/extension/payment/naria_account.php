<?php
class ModelExtensionPaymentNariaAccount extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/naria_account');
		$this->load->model('tool/image');

		//$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		$status = true;
		if (!$this->cart->hasShipping()) {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'naria_account',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'image'      => $this->model_tool_image->resize($this->config->get('naria_account_image'), 80, 40),
				'sort_order' => $this->config->get('naria_account_sort_order')
			);
		}

		return $method_data;
	}
}
