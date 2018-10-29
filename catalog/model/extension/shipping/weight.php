<?php
class ModelExtensionShippingWeight extends Model {
	public function getQuote($address) {
		$this->load->language('extension/shipping/weight');


		$quote_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");

		foreach ($query->rows as $result) {
			if ($this->config->get('weight_' . $result['geo_zone_id'] . '_status')) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND (country_id = '" . (int)$address['country_id'] . "' OR country_id = '0') AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

				if ($query->num_rows) {
					$status = true;
				} else {
					$status = false;
				}
			} else {
				$status = false;
			}

			if ($status) {
				$cost = '';
				if (isset($address['cart_ids'])) {
					$weight = $this->cart->getWeight($address['cart_ids']);
				}else
				{	$weight = $this->cart->getWeight();}
				

				$rates = explode(',', $this->config->get('weight_' . $result['geo_zone_id'] . '_rate'));
				
				//判断商品重量是否为0，如果为0，则表示全部都是包邮商品
				if($weight == 0){
					$cost = 0;
					$title = $result['name'] . '  (Free Postage)';
				}else{
					foreach ($rates as $rate) {
						$data = explode(':', $rate);
					
						if ($data[0] >= $weight) {
							if (isset($data[1])) {
								$cost = $data[1];
							}
					
							break;
						}
					}
					$title = $result['name'] . '  (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('config_weight_class_id')) . ')';
				}

				if ((string)$cost != '') {
					$quote_data['weight_' . $result['geo_zone_id']] = array(
						'code'         => 'weight.weight_' . $result['geo_zone_id'],
						'title'        => $title,
						'cost'         => $cost,
						'desc'         => $this->config->get('weight_' . $result['geo_zone_id'] . '_shopping_day'),  //物流时间说明属性
						'sort'         => $this->config->get('weight_' . $result['geo_zone_id'] . '_sort'),  //添加排序属性
						'tax_class_id' => $this->config->get('weight_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('weight_tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency'])
					);
				}
			}
		}
				
		$method_data = array();

		if ($quote_data) {

		    //添加对物流方式的排序
		    foreach ($quote_data as $key => $value) {
		        $sort[$key] = $value['sort'];
		    }
		    array_multisort($sort, SORT_ASC, $quote_data);
		    
			$method_data = array(
				'code'       => 'weight',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('weight_sort_order'),
				'error'      => false
			);
		}

		return $method_data;
	}
}