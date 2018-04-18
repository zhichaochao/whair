<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

        // print_r($this->config);exit();

        //引入样式
		$this->document->addStyle('catalog/view/theme/default/stylesheet/common/home.css');

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

        //banner轮播图
        $setting_info = array("name"=>"Home Page",
							  "banner_id"=>7,
							  "width"=>1200,
							  //"height"=>380,
							  "status"=>1
							  );
		$data['slideshow'] = $this->load->controller('extension/module/slideshow',$setting_info);

        //读取首页的中间图片
		$this->load->model('design/banner');
		$this->load->model('tool/image');
		$data['middle_pics'] = $this->model_design_banner->getBanner(9);

		if(!empty($data['middle_pics'])){
           foreach($data['middle_pics'] as $k => $v){
               $data['middle_pics'][$k]['image'] = $this->model_tool_image->resize($v['image'], 595 , 329);
           }
		}else{
		  $data['middle_pics_1'] = $data['middle_pics_2'] = $this->model_tool_image->resize('no_image.png', 595 , 329);
		}
		//读取首页的中间图片,end

		//首页Business Solutions模块的链接
		//wholesales链接
        $data['service_wholesales'] = $this->url->link('information/service/wholesales');
        //sell from salon链接
        $data['service_salon'] = $this->url->link('information/service/salon');
        //sell online链接
        $data['service_online'] = $this->url->link('information/service/online');
        
        //首页的产品分类显示
        // Menu
        $this->load->model('catalog/category');
        $this->load->model('tool/image');
        //分类
        $categories = $this->model_catalog_category->getShowCategories();
        if(!empty($categories)){
        	foreach ($categories as $category) {
        	    /**
        	    //获取该分类下的产品
                $child_product = $this->model_catalog_category->getProduct($category['category_id']);
                $category_product = array();
                foreach ($child_product as $product){
                    if(isset($product['special'])){
                        $special = $this->currency->format($product['special'], $this->session->data['currency']);
                    }
                    else{
                        $special = '';
                    }

                    $category_product[] = array(
                        'product_href'      => $this->url->link('product/product', 'product_id=' . $product['product_id']),
                        'product_img'       => $this->model_tool_image->resize($product['image'],258,258),
                        'product_name'      => $product['name'],
                        'product_price'     => $this->currency->format($product['price'], $this->session->data['currency']),
                        'product_special'   => $special
                    );
                }
                */
        		$data['categories'][] = array(
        				'pc_image'      => $this->model_tool_image->resize($category['pc_image'], 272, 285),
        				'pc_show_title' => $category['pc_show_title'],
        				'href'          => $this->url->link('product/category', 'path=' . $category['category_id']),
//                        'product'       => $category_product
        		);
        	}
        }else{
        	$data['categories'] = [];
        }

        //加载model
        $this->load->model('catalog/product');
        //首页推荐商品
        $recommend_products = $this->model_catalog_product->getRecommendProducts();
        // print_r($recommend_products);exit();
        $i = 0;
        foreach($recommend_products as $key=>$row){
        	$recommend_products[$key]['key_id'] = $i;   //作为索引值 dyl add
        
        	$recommend_products[$key]['description'] = utf8_substr(strip_tags(html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..';
        
        	if($recommend_products[$key]['image']){
        		$recommend_products[$key]['image'] = $this->model_tool_image->resize($row['image'], 228, 228);
        	}else{
        		$recommend_products[$key]['image'] = $this->model_tool_image->resize('placeholder.png', 228, 228);
        	}
        
        	$recommend_products[$key]['product_link'] = $this->url->link('product/product','product_id='.$row['product_id']);
        	
        	$recommend_products[$key]['texture'] = $this->model_catalog_product->getOptionDes('Texture',$row['product_id']);
        	
        	$recommend_products[$key]['price'] = $this->currency->format($row['price'], $this->session->data['currency']);
        	
        	$recommend_products[$key]['min_name'] = utf8_substr(strip_tags($row['name']),0,40).'...';

        	$i++;
        }
        
        $data['recommend_products'] = $recommend_products;
		$this->response->setOutput($this->load->view('common/home', $data));
	}
}
