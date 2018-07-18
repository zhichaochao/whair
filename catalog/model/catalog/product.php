<?php
class ModelCatalogProduct extends Model {
	public function updateViewed($product_id) {

		$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = (viewed + 1) WHERE product_id = '" . (int)$product_id . "'");

        //用户浏览产品次数的记录 dyl add
		$customer_id = $this->customer->isLogged() ? $this->customer->getId() : 0;
		$sql1 = "SELECT customer_id FROM " . DB_PREFIX . "customer_view_product
				 WHERE customer_id = ".(int)$customer_id ." AND product_id = ".(int)$product_id;
	    $result = $this->db->query($sql1);
	    if($result->row){
           $sql = "UPDATE " . DB_PREFIX . "customer_view_product SET viewed = (viewed + 1), last_view_time='".time()."' WHERE customer_id = " . (int)$customer_id . " AND product_id = " . (int)$product_id;
	    }else{
           $sql = "INSERT INTO " . DB_PREFIX . "customer_view_product SET customer_id = " .(int)$customer_id. ", product_id = " . (int)$product_id . ", viewed = 1, last_view_time='".time()."'";
	    }
		$this->db->query($sql);
		//用户浏览产品次数的记录 dyl add,end

	}

	public function getProduct($product_id) {


		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer,
				(SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward,
				(SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status,
				(SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class,
				(SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class,
				(SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating,
				(SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		$price=$this->getProductSpecialPrice($product_id);
		// print_r($price);exit();
		if (!$price) {
			$price=array();
			$old_price=$this->getProductMinPrice($product_id);
			$price['special']=0;
			$price['old_price']=$old_price['price'];
			$price['share']=$old_price['share'];
		}

		if ($query->num_rows) {
			return array(
				'product_id'       => $query->row['product_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_title'       => $query->row['meta_title'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['model'],
				'sku'              => $query->row['sku'],
				'upc'              => $query->row['upc'],
				'ean'              => $query->row['ean'],
				'jan'              => $query->row['jan'],
				'isbn'             => $query->row['isbn'],
				'mpn'              => $query->row['mpn'],
				'location'         => $query->row['location'],
				'quantity'         => $query->row['quantity'],
				'stock_status'     => $query->row['stock_status'],
				'image'            => $query->row['image'],
				'manufacturer_id'  => $query->row['manufacturer_id'],
				'manufacturer'     => $query->row['manufacturer'],
				'price'            => $price['old_price'],
				'special'          => $price['special'],
				'share'          => $price['share'],
				'reward'           => $query->row['reward'],
				'points'           => $query->row['points'],
				'tax_class_id'     => $query->row['tax_class_id'],
				'date_available'   => $query->row['date_available'],
				'weight'           => $query->row['weight'],
				'weight_class_id'  => $query->row['weight_class_id'],
				'length'           => $query->row['length'],
				'width'            => $query->row['width'],
				'height'           => $query->row['height'],
				'length_class_id'  => $query->row['length_class_id'],
				'subtract'         => $query->row['subtract'],
				'rating'           => round($query->row['rating']),
				'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
				'minimum'          => $query->row['minimum'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed'],
                'video'            => $query->row['video'],
                'video_link'       => $query->row['video_link'],

                //新增读取的产品属性
				'color_id'         => $query->row['color_id'],
				'length_id'        => $query->row['length_id'],
				'relation_product' => $query->row['relation_product'],
				'discount_percentage' => $query->row['discount_percentage'],
				'free_postage'     => $query->row['free_postage'],
				'material'     => $query->row['material'],
				'm_description'     => $query->row['m_description']
				//新增读取的产品属性,end
			);
		} else {
			return false;
		}
	}

	// 找其中一个活动优惠价
	public function getProductSpecialPrice($product_id) {
		//用户组
		$price_type=$this->customer->isLogged()?(int)$this->config->get('config_customer_group_id'):'';
		if ($this->customer->isLogged()) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id in (0,".$price_type.") ORDER BY priority, price");
		}else{

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");
		}
		$row=array();
		foreach ($query->rows as $key => $value) {
		if (($value['date_start'] == '0000-00-00' || strtotime($value['date_start']) < time()) && ($value['date_end'] == '0000-00-00' || strtotime($value['date_end']) > time())) {
			if ($value['product_option_value_id']==0) {
				$old_price=$this->getProductMinPrice($product_id);
				$value['old_price']=$old_price['price'];
				$value['share']=$old_price['share'];

			}else{
				$queryk = $this->db->query("SELECT price".$price_type." as price,product_option_value_id,product_option_id,option_id FROM " . DB_PREFIX . "product_option_value WHERE product_option_value_id = '" . (int)$value['product_option_value_id'] . "'");
				$tem=$queryk->row;
				$value['old_price']=$tem['price'];
				  $queryp = $this->db->query("SELECT  price".$price_type." as price,product_option_value_id,product_option_id FROM (SELECT * FROM " . DB_PREFIX . "product_option_value WHERE  product_id='".$product_id."' ORDER BY  price".$price_type." ASC) as opv   WHERE product_id='".$product_id."' AND option_id <> '".(int)$tem['option_id'] ."' GROUP BY option_id");
				  $share='{'.$tem['product_option_id'].':'.$tem['product_option_value_id'];
				  // print_r($queryp->rows);exit();
				  if ($queryp->rows) {
				 	foreach ($queryp->rows as $ky => $val) {
				 		$share.=','.$val['product_option_id'].':'.$val['product_option_value_id'];
				 			$tem['price']+=$val['price'];
				 	}
				 }
				 $share.='}';
				 	$value['old_price']=$tem['price'];
				 	$value['share']=$share;

			}
			if ($value['percent'] > 0) {
				$value['special']=$value['old_price']*$value['percent']/100;
			}else{
					$value['special']=$value['old_price']-$value['price'];
			}
			$row=$value;
		}
		break;
		}
		return $row;
	}
	// 找最低的价格
	public function getProductMinPrice($product_id){
			//用户组
		$price_type=$this->customer->isLogged()?(int)$this->config->get('config_customer_group_id'):'';
	       $query = $this->db->query("SELECT  price".$price_type." as price ,product_option_id,product_option_value_id FROM (SELECT * FROM " . DB_PREFIX . "product_option_value WHERE  product_id='".$product_id."' ORDER BY  price".$price_type." ASC) as opv  WHERE product_id='".$product_id."' GROUP BY option_id");
			$price=0;
			$share='{';
			if ($query->rows) {
			 	foreach ($query->rows as $key => $value) {
			 		$price+=$value['price'];
			 		if ($key==0) {
			 			$share.=$value['product_option_id'].':'.$value['product_option_value_id'];
			 		}else{
			 			$share.=','.$value['product_option_id'].':'.$value['product_option_value_id'];
			 		}
			 		
			 	}
			 } 
			 $share.='}';
		
		 return array('price'=>$price,'share'=>$share);
    }
    // 根据属性来获取价格
    public function getProductPricebyOptions($product_id,$options)
    {

    	$price_type=$this->customer->isLogged()?(int)$this->config->get('config_customer_group_id'):'';
    	$share='{';
    	$k=0;
    	$price=0;
    	$ids='0';
    	foreach ($options as $key => $value) {
    		if ($k==0) {
    			$share.=$key.':'.$value;
    		}else{
    			$share.=','.$key.':'.$value;
    		}
    		$k++;
    		$query = $this->db->query("SELECT  price".$price_type." as price,product_option_value_id,product_option_id FROM " . DB_PREFIX . "product_option_value   WHERE product_id='".$product_id."' AND  product_option_id ='".$key."' AND product_option_value_id='".$value."'");
    		// print_r("SELECT  price".$price_type." as price,product_option_value_id,product_option_id FROM " . DB_PREFIX . "product_option_value   WHERE product_id='".$product_id."' AND  product_option_id ='".$key."' AND product_option_value_id='".$value."'");;exit;
    		$tem_price=$query->row;
    		$price+= $tem_price['price'];
			$ids.=','.$value;
    	
    		 // print_r($tem_price);
    	}
    	 $share.='}';
    	 if($this->customer->isLogged()){

    	 	 $queryk= $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND product_option_value_id in(".$ids.") AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW()))ORDER BY priority, price limit 1");
    	 }else{
    			$queryk= $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND product_option_value_id in(".$ids.") AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) AND customer_group_id in (0,".(int)$this->config->get('config_customer_group_id').")  ORDER BY priority, price limit 1");
    	}
    	 $tem_special_price=$queryk->row;
    	 if ($tem_special_price) {
    	 	if ($tem_special_price['percent']>0) {
    	 		$special=$price*$tem_special_price['percent']/100;
    	 	}else{
    	 		$special=$price-$tem_special_price['price'];
    	 	}
    	 }else{
    	 	$special='';
    	 }
    	 	// print_r(1);exit;

    	 return   array('price'=>$price,'share'=>$share,'special'=>$special);

    	
    }

	public function getProducts($data = array()) {
	//	var_dump($data);die;
		$sql = "SELECT p.product_id,
				(SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating
				
			    ";
	
		

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
				$sql .= " LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = p2c.category_id)";  //dyl add
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				//$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";

                //dyl add
				$sql .= " AND ( (c.parent_id=0 AND c.category_id=".(int)$data['filter_category_id'].")
						     OR (c.parent_id!=0 AND (c.category_id=".(int)$data['filter_category_id']." OR c.parent_id=".(int)$data['filter_category_id']."))
						     OR (c.parent_id!=0 AND c.category_id=".(int)$data['filter_category_id'].") ) ";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

				foreach ($words as $word) {
					$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.quantity',
			'p.price',
			'rating',
			'p.sort_order',
			'p.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			// } elseif ($data['sort'] == 'p.price') {
			// 	$sql .= " ORDER BY  p.price END)";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}
		// print_r($data['sort']);exit();

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = array();
		//var_dump($);die
// print_r($sql);exit();
		$query = $this->db->query($sql);
		// print_r($query->rows);exit();

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getProductSpecials($data = array()) {
			$customer_group_sql=$this->customer->isLogged()? " AND ps.customer_group_id in (0," . (int)$this->config->get('config_customer_group_id').")"  :'';

		$sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ".$customer_group_sql." AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'ps.price',
			'rating',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getLatestProducts($limit) {
		$product_data = $this->cache->get('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$product_data) {
			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}


    /**
     * 根据产品id,获取该分类下的其他产品
     * @author  dyl  783973660@qq.com  2016.9.9
     * @param   Int  $product_id  产品ID
     */
	public function getPopularProducts($product_id) {
        /**
         * create by bai_iab
         */
	    $sql = "SELECT related_id FROM ". DB_PREFIX . "product_related WHERE product_id='" . (int)$product_id."'";
        $query = $this->db->query($sql);

		/*$product_data = $this->cache->get('product.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$product_data) {
			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
		}

		return $product_data;*/


		$product_data = array();

        //$sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit;

        //根据当前产品id查询出该产品所属的分类ID
//        $sql1 = "SELECT ptc.category_id FROM " . DB_PREFIX . "product p
//				LEFT JOIN " . DB_PREFIX . "product_to_category ptc
//				ON p.product_id = ptc.product_id
//				WHERE p.product_id = ".(int)$product_id." and p.status = 1";
//		$query1 = $this->db->query($sql1);

        //调用方法,获取属于父类的产品ID
//        $query = $this->getCategoryProduct($query1,$product_id);
        foreach ($query->rows as $result) {
		   $product_data[$result['related_id']] = $this->getProduct($result['related_id']);
//            return $product_data;
		}

		return $product_data;

	}


	/**
	 * 根据当前产品id查询出该产品所属的分类ID,遍历判断,该ID是否属于父类ID,如果是则提取出来,再去查询该父类ID下的其他产品
	 * @author  dyl  783973660@qq.com  2016.9.9
	 * @param  Object  $query1       查询的对象
	 * @param  Int     $product_id   当前传入的产品ID
	 */
	public function getCategoryProduct($query1,$product_id){
		//获取父类ID
		$parent = '';
		foreach($query1->rows as $k=>$v){
		   $sql2 = "select category_id from " . DB_PREFIX . "category where category_id = ".(int)$v['category_id']." and parent_id = 0 and status = 1";
		   $result2 = $this->db->query($sql2);
		   //该分类ID为父类,再获取出来
		   if($result2->num_rows > 0){
		   	  $parent .=$v['category_id'].',';
		   }else{
		      //没有查询出结果,则根据子类id查询出父类id
		   	  $sql3 = "select parent_id from " . DB_PREFIX . "category where category_id = ".(int)$v['category_id']." and status = 1";
		      $result3 = $this->db->query($sql3);
              if($result3->num_rows > 0){
                 $parent .=$result3->row['parent_id'].',';
              }
		   }
		}
		//获得父类ID
		$parent = !empty($parent) ? mb_substr($parent,0,-1,'utf-8') : 0;
        //查询该父类下的其他产品(排除当前传入的产品ID)
        $sql3 = "select distinct p.product_id from " . DB_PREFIX . "product p
			    left join " . DB_PREFIX . "product_to_category ptc on p.product_id = ptc.product_id
			    left join " . DB_PREFIX . "category c on c.category_id = ptc.category_id
			    left join " . DB_PREFIX . "product_to_store p2s on p.product_id = p2s.product_id
			    where p.status = 1 and p.date_available <= NOW() and p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
			    and p.product_id!=" . (int)$product_id . " and c.category_id in (" . $parent . ") and c.status = 1 
			    order by p.viewed desc, p.date_added desc limit 16";
        $query = $this->db->query($sql3);

		return $query;
	}

    public function getProductPriceByOption($product_id,$options) {
        $price=0;
        foreach ($options as $key => $value) {
            if ($key>0) {
                $temp_query=$this->db->query("SELECT price FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "' AND product_option_id = '" . (int)$key . "' AND product_option_value_id = '" . (int)$value . "'");
                $temp=$temp_query->row;
                if(isset($temp['price'])) $price+=$temp['price'];
            }
        }

        return $price;
    }

	public function getBestSellerProducts($limit) {
		$product_data = $this->cache->get('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$product_data) {
			$product_data = array();

			$query = $this->db->query("SELECT op.product_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	public function getProductAttributes($product_id) {
		$product_attribute_group_data = array();

		$product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		foreach ($product_attribute_group_query->rows as $product_attribute_group) {
			$product_attribute_data = array();

			$product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

			foreach ($product_attribute_query->rows as $product_attribute) {
				$product_attribute_data[] = array(
					'attribute_id' => $product_attribute['attribute_id'],
					'name'         => $product_attribute['name'],
					'text'         => $product_attribute['text']
				);
			}

			$product_attribute_group_data[] = array(
				'attribute_group_id' => $product_attribute_group['attribute_group_id'],
				'name'               => $product_attribute_group['name'],
				'attribute'          => $product_attribute_data
			);
		}

		return $product_attribute_group_data;
	}

	public function getProductOptions($product_id) {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();

			$product_option_value_query = $this->db->query("SELECT *   FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");
		
		
				foreach ($product_option_value_query->rows as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'name'                    => $product_option_value['name'],
						'image'                   => $product_option_value['image'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']
					);
				}
				// print_r($product_option);exit();
			$option_value_query= $this->db->query("SELECT *   FROM  " . DB_PREFIX . "option_value ov  WHERE  ov.option_value_id = '" . (int)$product_option['option_value_id'] . "'");
			if($option_value_query->row){$image=$option_value_query->row['image'];	}else{$image='';}


			$product_option_data[] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => $product_option['value'],
				'image'                => $image,
				'required'             => $product_option['required']
			);
		}
		// print_r($product_option_data);exit();

		return $product_option_data;
	}

	public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;
	}

	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getProductRelated($product_id) {
		$product_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product p ON (pr.related_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			$product_data[$result['related_id']] = $this->getProduct($result['related_id']);
		}

		return $product_data;
	}

	public function getProductLayoutId($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getCategories($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}

	public function getTotalProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";

				$sql .= " LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = p2c.category_id)";  //dyl add
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				//$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";

				//dyl add
                $sql .= " AND (
                		     (c.parent_id=0 AND c.category_id=".(int)$data['filter_category_id'].")
						     OR (c.parent_id!=0 AND (c.category_id=".(int)$data['filter_category_id']." OR c.parent_id=".(int)$data['filter_category_id'].") )
						     OR (c.parent_id!=0 AND c.category_id=".(int)$data['filter_category_id'].")
						     ) ";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

				foreach ($words as $word) {
					$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getProfile($product_id, $recurring_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r JOIN " . DB_PREFIX . "product_recurring pr ON (pr.recurring_id = r.recurring_id AND pr.product_id = '" . (int)$product_id . "') WHERE pr.recurring_id = '" . (int)$recurring_id . "' AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

		return $query->row;
	}

	public function getProfiles($product_id) {
		$query = $this->db->query("SELECT rd.* FROM " . DB_PREFIX . "product_recurring pr JOIN " . DB_PREFIX . "recurring_description rd ON (rd.language_id = " . (int)$this->config->get('config_language_id') . " AND rd.recurring_id = pr.recurring_id) JOIN " . DB_PREFIX . "recurring r ON r.recurring_id = rd.recurring_id WHERE pr.product_id = " . (int)$product_id . " AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getTotalProductSpecials() {

		
		$customer_group_sql=$this->customer->isLogged()? " AND ps.customer_group_id in  (0," . (int)$this->config->get('config_customer_group_id').")" :'';
		// print_r($customer_group_sql);exit();


		$query = $this->db->query("SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ".$customer_group_sql);

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}

    /**
     * 根据产品ID获取option属性(后台设置)
     * @author  dyl  783973660@qq.com  2016.9.7
     * @param   Int  $product_id   产品ID
     */
	public function getOptionValue($product_id = 0){
		$data = array();
		if($product_id==0){
			return $data;
		}

		$sql = "select po.value as tvalue,od.name,ovd.name as svalue
				from ".DB_PREFIX."product_option po
			    left join ".DB_PREFIX."option_description od on od.option_id = po.option_id
			    left join ".DB_PREFIX."option o on o.option_id = od.option_id
			    left join ".DB_PREFIX."product_option_value pov on pov.product_option_id = po.product_option_id
			    left join ".DB_PREFIX."option_value_description ovd on ovd.option_value_id =  pov.option_value_id
			    where po.product_id = '".$product_id."' order by o.sort_order asc ";
		$query = $this->db->query($sql);

		foreach($query->rows as $key=>$row){
			$data[$key]['name']		= $row['name'];
			$data[$key]['tvalue']	= $row['tvalue'];
			$data[$key]['svalue']	= $row['svalue'];
		}

		return $data;

	}

	/**
	 * 根据id,获取相应的信息
	 * @author  dyl 783973660@qq.com  2016.9.7
	 * @param   Int  $information_id  信息id
	 */
	public function getInformaintion($information_id){
		$sql = "select * from `".DB_PREFIX."information_description` where information_id = '".$information_id."'";

		$query = $this->db->query($sql);
		return !empty($query->row['description']) ? $query->row['description'] : '';

	}


    /**
     * 获取每种颜色对应长度的数据(现在产品详情页用这个来获取)
     * @author  dyl  783973660@qq.com 2016.4.27
     * @param   String  $relation_product  关联的模型
     * @param   Int     $length_id         长度ID
     */
    public function getRelationColor1($relation_product='',$length_id=0){
		$data = array();
		if(empty($relation_product)){
			return $data;
		}
        $sql = "select p.color_id,ovd.name,ov.image
				from ".DB_PREFIX."product p
				left join ".DB_PREFIX."option_value_description ovd on ovd.option_value_id = p.color_id
				left join ".DB_PREFIX."option_value ov on ov.option_value_id = ovd.option_value_id
				where p.length_id = ". (int)$length_id ." and p.relation_product = '".$relation_product."'
				order by ov.sort_order asc";
		$query = $this->db->query($sql);

		foreach($query->rows as $key=>$row){
			$data[$key]['color_id'] 	= $row['color_id'];
			$data[$key]['color'] 	    = $row['name'];
			$data[$key]['image']        = $row['image'];
		}
		return $data;
	}



	/*
	*	获取产品ID
	*	@author shine <huangshaoyu@dehannet.com>
	*/
	public function getProductId($map = array()){
		if(!$map){
			return false;
		}

		$where = " 1 ";
		if(!empty($map['relation_product'])){
			$where .= " and relation_product = '".$map['relation_product']."' ";
		}

		if(!empty($map['color_id'])){
			$where .= " and color_id = '".$map['color_id']."' ";
		}

        //dyl加 添加length_id的判断,根据length_id获取产品的id
		if(!empty($map['length_id'])){
			$where .= " and length_id = '".$map['length_id']."' ";
		}

		$sql =" select product_id,price,discount_percentage,weight from ".DB_PREFIX."product where ".$where;

		$query = $this->db->query($sql);

		return $query->row;

	}


	/**
     * 获取每个长度对应颜色的数据(现在产品详情页用这个来获取)
     * @author  dyl  783973660@qq.com 2016.4.27
     * @param   String  $relation_product  关联的模型
     * @param   Int     $color_id          颜色ID
     */
	public function getRelationColLengths($relation_product='' ,$color_id=0){
        $data = array();
		if(empty($relation_product)){
			return $data;
		}
		$sql = "select p.length_id,ovd.name
				from ".DB_PREFIX."product p
				left join ".DB_PREFIX."option_value_description ovd on ovd.option_value_id = p.length_id
				left join ".DB_PREFIX."option_value ov on ov.option_value_id = ovd.option_value_id
				where p.color_id = ". (int)$color_id ."  and p.relation_product = '".$relation_product."'
				order by ov.sort_order asc, p.length_id asc";
		$query = $this->db->query($sql);
		foreach($query->rows as $key=>$row){
			$data[$key]['length_id'] 	= $row['length_id'];
			$data[$key]['length'] 	    = $row['name'];
		}
		return $data;
	}


   /**
	* 根据$option_value_id 获取value
	* @author  dyl  783973660@qq.com  2016.9.9
	* @param   Int  $option_value_id  属性id值
	*/
	public function getOptionValueByID($option_value_id = 0){
		if($option_value_id==0){
			return array();
		}
		$sql = "select ovd.name,ov.image from `".DB_PREFIX."option_value_description` ovd left join `".DB_PREFIX."option_value` ov on ov.option_value_id = ovd.option_value_id where ovd.option_value_id = '".$option_value_id."'";

		$query = $this->db->query($sql);

		return $query->row;
	}


   /**
	* 获取产品分类名(产品详情页的面包屑)
	* @author  dyl  783973660@qq.com  2016.9.19
	* @param   Int  $product_id  产品ID
	*/
	public function getCatalogName($product_id){
		/*$sql = "select cd.name,ptc.category_id,c.parent_id
				from `".DB_PREFIX."product_to_category` ptc
				left join `".DB_PREFIX."category_description` cd on cd.category_id = ptc.category_id
				left join `".DB_PREFIX."category` c on c.category_id = ptc.category_id
				where status='1' and product_id = '".$product_id."' order by c.parent_id asc";

		$query = $this->db->query($sql);

		return $query->rows;*/


		$sql = "select cd.name,ptc.category_id,c.parent_id
				from `".DB_PREFIX."product_to_category` ptc
				left join `".DB_PREFIX."category_description` cd on cd.category_id = ptc.category_id
				left join `".DB_PREFIX."category` c on c.category_id = ptc.category_id
				where c.status='1' and ptc.product_id = '".$product_id."' order by c.parent_id asc";

        $query = $this->db->query($sql);

        $CatalogNameArray = array();
        foreach($query->rows as $k => $v){

           $CatalogNameArray[$k]['name'] = $v['name'];
           $CatalogNameArray[$k]['category_id'] = $v['category_id'];
           $CatalogNameArray[$k]['parent_id'] = $v['parent_id'];

           //通过第三级子类,查询出第二级子类,再将二三级分类的顺序进行调换
           if( $v['parent_id']!=0 && ($v['parent_id']!=$query->rows[$k==0?$k:$k-1]['category_id']) ){

              $sql = "select cd.name,c.category_id,c.parent_id
					 from `".DB_PREFIX."category` c
					 left join `".DB_PREFIX."category_description` cd on c.category_id = cd.category_id
					 where c.status=1 and c.category_id = ".(int)$v['parent_id'];
              $query = $this->db->query($sql);

              //子类
              $CatalogNameArray[$k]['name'] = $query->row['name'];
              $CatalogNameArray[$k]['category_id'] = $query->row['category_id'];
              $CatalogNameArray[$k]['parent_id'] = $query->row['parent_id'];

              //子类的子类(第三级分类)
              $CatalogNameArray[$k+1]['name'] = $v['name'];
              $CatalogNameArray[$k+1]['category_id'] = $v['category_id'];
              $CatalogNameArray[$k+1]['parent_id'] = $v['parent_id'];
           }
        }

		return $CatalogNameArray;

	}


	 /**
     * 获取属于新品的主产品的个数
     * @author  dyl 783973660@qq.com  2016.9.26
     * @param   Array   $data   筛选条件
     */
	public function getTotalNewProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total";

	    $sql .= " FROM " . DB_PREFIX . "product p";

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND p.is_new = 1";

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

				foreach ($words as $word) {
					$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}


    /**
     * 获取属于新品的主产品信息
     * @author  dyl 783973660@qq.com   2016.9.26
     * @param   Array   $data   筛选条件
     */
	public function getNewProducts($data = array()) {
		$sql = "SELECT p.product_id,
				(SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating,
				(SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'
			    AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW()))
			    ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount,
			    (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))
			    ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

	    $sql .= " FROM " . DB_PREFIX . "product p";

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND p.is_new = 1";

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

				foreach ($words as $word) {
					$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'p.quantity',
			'p.price',
			'rating',
			'p.sort_order',
			'p.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} elseif ($data['sort'] == 'p.price') {
				$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}


    /**
	 * 用户中心的Dashboard页面获取用户浏览次数最多的产品(分用户统计显示)
	 * @author  dyl 783973660@qq.com  2016.9.29
	 */
	public function getAccountCustomerViewedProducts($limit = 4) {

	    $sql = "SELECT p.product_id,p.image,p.color_id,pd.name
			    FROM " . DB_PREFIX . "product p
			    LEFT JOIN " . DB_PREFIX . "product_description pd ON p.product_id = pd.product_id
			    LEFT JOIN " . DB_PREFIX . "customer_view_product cvp ON p.product_id = cvp.product_id
			    WHERE  cvp.customer_id = ".(int)$this->customer->getId()."
			    ORDER BY cvp.last_view_time DESC, cvp.viewed DESC, p.date_added desc
			    LIMIT ".(int)$limit;

		$query = $this->db->query($sql);

		return !empty($query->rows) ? $query->rows : array();
	}

    /**
	 * 获取product表浏览次数最多的产品
	 * @author  dyl 783973660@qq.com  2016.9.29
	 */
	public function getAccountViewedProducts($product_id_string, $limit) {

		/*$sql = "SELECT p.product_id,p.image,p.color_id,pd.name
			    FROM " . DB_PREFIX . "product p
			    LEFT JOIN " . DB_PREFIX . "product_description pd ON p.product_id = pd.product_id
			    WHERE  1 ORDER BY p.viewed DESC, p.date_added desc
			    LIMIT ".(int)$limit;*/

		$product_id_string = !empty($product_id_string) ? ' AND  p.product_id NOT IN (' . mb_substr($product_id_string,0,-1,'utf-8') . ')' : '';

		$sql = "SELECT p.product_id,p.image,p.color_id,pd.name
			    FROM " . DB_PREFIX . "product p
			    LEFT JOIN " . DB_PREFIX . "product_description pd ON p.product_id = pd.product_id
			    WHERE 1 " . $product_id_string . " ORDER BY p.viewed DESC, p.date_added desc
			    LIMIT ".(int)$limit;

	    $query = $this->db->query($sql);

	    return !empty($query->rows) ? $query->rows : array();
	}


	/**
	 * 用户中心的Dashboard页面获取新品
	 * @author  dyl 783973660@qq.com  2016.9.26
	 */
	public function getAccountNewProducts($limit = 4) {
		$sql = "SELECT p.product_id,p.image,p.color_id,pd.name
			    FROM " . DB_PREFIX . "product p
			    LEFT JOIN " . DB_PREFIX . "product_description pd ON p.product_id = pd.product_id
			    WHERE  p.is_new = 1 ORDER BY p.date_added desc
			    LIMIT ".(int)$limit;

		$query = $this->db->query($sql);

		return !empty($query->rows) ? $query->rows : array();
	}


   /**
	* 获取产品分类
	* @author  dyl  783973660@qq.com 2016.9.26
	* @param   Int  $product_id   产品ID
	*/
	public function getCatalog($product_id){
		$sql = "select cd.name,ptc.category_id,c.parent_id from `".DB_PREFIX."product_to_category` ptc left join `".DB_PREFIX."category_description` cd on cd.category_id = ptc.category_id left join `".DB_PREFIX."category` c on c.category_id = ptc.category_id where status='1' and product_id = '".$product_id."' order by c.parent_id asc";

		$query = $this->db->query($sql);

		return $query->rows;
	}
        
        
	public function getOptionDes($name = '',$product_id){
            $option_name = '';
            if(empty($name) || empty($product_id)){
                return $option_name;
            }

            $sql =" select od.option_id,od.name,o.type from ".DB_PREFIX."option_description od left join ".DB_PREFIX."option o on o.option_id = od.option_id  where od.name = '".$name."'";
            $query = $this->db->query($sql);
            
            if($query->num_rows){
                $option_id = $query->row['option_id'];
                
                $option_sql = "select * from " . DB_PREFIX . "product_option where option_id = '" . $option_id . "' and product_id = '" . $product_id . "'";
                $option_query = $this->db->query($option_sql);
                if($option_query->num_rows){
                    $option_name = $option_query->row['value'];
                }
            }
            
            return $option_name;
	}
	 /**
	* 获取产品分类
	* @author  dyl  783973660@qq.com 2016.9.26
	* @param   Int  $product_id   产品ID
	*/
	// public function getCatalog($product_id){
	// 	$sql = "select cd.name,ptc.category_id,c.parent_id from `".DB_PREFIX."product_to_category` ptc left join `".DB_PREFIX."category_description` cd on cd.category_id = ptc.category_id left join `".DB_PREFIX."category` c on c.category_id = ptc.category_id where status='1' and product_id = '".$product_id."' order by c.parent_id asc";

	// 	$query = $this->db->query($sql);

	// 	return $query->rows;
	// }
        
        
	public function wishlistornot($product_id){
           $customer_id = $this->customer->isLogged() ? $this->customer->getId() : 0;
            if( empty($product_id)|| $customer_id==0){
                return false;
            }
          
          // print_r($product_id);
          // print_r('<br/>');
           
          // print_r($customer_id);


          // print_r('<br/>');
           
            $sql ="select * from ".DB_PREFIX."customer_wishlist   where product_id = '".$product_id."' AND customer_id =". $customer_id;
            $query = $this->db->query($sql);
            // print_r($query->row)
           if (empty($query->row)) {
           	return  false;
           }else {
           		return  true;
           }
          
            
          
	}
	/**
	 * 查询商品列表，筛选出8个最新上架、浏览次数最多的主要商品
	 * @author  wyf
	 * @param
	 */
	public function getRecommendProducts($limit=8){
		$sql = "select distinct p.product_id from " . DB_PREFIX . "product p
			    left join " . DB_PREFIX . "product_to_category ptc on p.product_id = ptc.product_id
			    left join " . DB_PREFIX . "category c on c.category_id = ptc.category_id
			    left join " . DB_PREFIX . "product_to_store p2s on p.product_id = p2s.product_id
			    where p.status = 1 and p.date_available <= NOW() and p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
			    and c.status = 1  order by p.viewed desc, p.date_added desc limit ".$limit;
		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[] = $this->getProduct($result['product_id']);	
		}
		return $product_data;
	}

	/**
	 * 获得产品的特价信息
	 * @author yufeng
	 * @param Int    $prodcut_id 产品的ID
	 * @param String $special    产品特价
	 */
	public function getSpecialPrice ($product_id) {
		$sql = Base::getSpecialPriceSQL($product_id, 2);

		$query = $this->db->query($sql)->row;
		$special = array();
		if (!empty($query)) {
			if ($query['percent'] != 0) {
			    $product_info = Base::getRow('product', $product_id, 'product_id');
			    if(empty($product_info['price'])) return false;
				$special['special'] = $this->currency->format($product_info['price'] * ($query['percent']/100), $this->session->data['currency']);
				$special['read_special'] = $product_info['price'] * ($query['percent']/100);
			} else {
				$special['special'] = $this->currency->format($query['price'], $this->session->data['currency']);
				$special['read_special'] = $query['price'];
			}
			return $special;
		} else {
			return false;
		}
	}
	
	/**
	 *  相同产品模型的商品是否存在特价
	 */
	public function isHasSpecialPrice ($relation_product) {
		$sql = "SELECT count(*) as num FROM " . DB_PREFIX . "product_special WHERE product_id IN (SELECT product_id FROM " . DB_PREFIX . "product WHERE relation_product = '" . $relation_product . "')";
		$query = $this->db->query($sql);
		return $query->row['num'];
	}


	//获取颜色选项的所有id值
	public function getColorsOption (){
	    $sql = "SELECT option_value_id FROM " . DB_PREFIX . "option_value_description WHERE option_id = 13";

	    $query = $this->db->query($sql);

	    return $query->rows;
    }
}
