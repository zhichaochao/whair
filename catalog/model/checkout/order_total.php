<?php
class ModelCheckoutOrderTotal extends Model {

	public function getOrderTotal($order_id) {
        $order_total = array();
		$order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` o WHERE o.order_id = '" . (int)$order_id . "'order by sort_order asc");

		if ($order_total_query->num_rows) {
          foreach ($order_total_query->rows as $result) {

			$order_total[] = array(
                'order_total_id' => $result['order_total_id'],
                'order_id'       => $result['order_id'],
                'code'           => $result['code'],
				'title'          => $result['title'],
				'value'          => $result['value'],
                'sort_order'     => $result['sort_order'],
			);
          }
		}

       return $order_total;
	}
	
	public function getOrderTotal2($order_id) {
	    $order_total = array();
	    $order_total_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` o WHERE o.order_id = '" . (int)$order_id . "'order by sort_order asc");

	  
	
	    if ($order_total_query->num_rows) {
	   

	        foreach ($order_total_query->rows as $result) {
	            $order_total[] = array(
	                'order_total_id' => $result['order_total_id'],
	                'order_id'       => $result['order_id'],
	                'code'           => $result['code'],
	                'title'          => $result['title'],
	                'value'          => $this->currency->format($result['value'], $this->session->data['currency']),
	                'sort_order'     => $result['sort_order'],
	            );
	            if ($result['code']=='total') {
	            	  $currency=$this->currency->getValue($this->session->data['currency']);
	            	  if ($this->session->data['currency']!='USD') {
						 $order_total[] = array(
				                'order_total_id' => $result['order_total_id'],
				                'order_id'       => $result['order_id'],
				                'code'           => 'rate',
				                'title'          =>'Exchange Rate (USD:'.$this->session->data['currency'].')',
				                'value'          => '1:'. $currency,
				                'sort_order'     => $result['sort_order'],
				            );
						 $order_total[] = array(
			                'order_total_id' => $result['order_total_id'],
			                'order_id'       => $result['order_id'],
			                'code'           => $result['code'],
			                'title'          => $result['title'].'(USD)',
			                'value'          => $this->currency->format($result['value'], 'USD'),
			                'sort_order'     => $result['sort_order'],
			            );
			            }
	        	}
	        }
	    }
	
	    return $order_total;
	}

}