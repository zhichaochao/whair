<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));
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
        $setting_info = array("name"=>"Home Page", "banner_id"=>1, "width"=>1536, "height"=>720, "mwidth"=>710,  "mheight"=>480, "status"=>1 );
        
		$data['slideshow'] = $this->load->controller('extension/module/slideshow',$setting_info);
        

        //读取首页的中间图片
		$this->load->model('design/banner');
		$this->load->model('tool/image');
		 $data['fasts'] = array();
        $results = $this->model_design_banner->getBanner(2);
        foreach ($results as $result) {
            if (is_file(DIR_IMAGE . $result['image'])) {
                $image=$this->model_tool_image->resize($result['image'], 480, 480);
                if (is_file(DIR_IMAGE . $result['mimage'])) {
                   $mimage=  $this->model_tool_image->resize($result['mimage'], 230, 320);
                }else{
                     $mimage=$image;
                }
                $data['fasts'][] = array(
                    'title' => $result['title'],
                    'mtitle' => $result['mtitle'],
                    'link'  => $result['link'],
                    'image' =>   $image,
                    'mimage' => $mimage
                );

            }
        }
        
		//读取首页的中间图片,end

        //首页的产品分类显示
        // Menu
        $this->load->model('catalog/category');
        $this->load->model('tool/image');
   

        //加载model
        $this->load->model('catalog/product');
        //首页推荐商品
        $recommend_products = $this->model_catalog_product->getRecommendProducts();
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
        $this->load->model('common/gallery');
       
        $gallerys=$this->model_common_gallery->getGallerys(array('is_home'=>1,'start'=>0));
        // print_r($gallerys);exit;
        foreach ($gallerys as $key => $value) {
            $gallerys[$key]['url']=$this->url->link('product/product','product_id='.$value['product_id']);
             $gallerys[$key]['image']= $this->model_tool_image->resize($value['image'], 241, 241);
        }
          $data['gallerys'] =$gallerys;

        $this->load->model('common/home');
          $homes=$this->model_common_home->getHomePages();
        if ($homes) {
          foreach ($homes as $key => $value) {
            if($key==3){
                 $homes[$key]['image']= $this->model_tool_image->resize($value['image'], 1537, 600);   
            }else{
                $homes[$key]['image']= $this->model_tool_image->resize($value['image'], 1040, 560);
            }
              
              $homes[$key]['mimage']= $this->model_tool_image->resize($value['mimage'], 710, 400);
              $homes[$key]['title']= $value['title'];
                $homes[$key]['category']= $this->model_catalog_category->getCategory($value['category_id']);
                $category_path=$this->get_category_path($value['category_id']);
              $homes[$key]['category_url']=$this->url->link('product/category', 'path=' .$category_path);
            $filter_data = array(
                'filter_category_id' => $value['category_id'],
                'filter_sub_category' => true,       //dyl add
                // 'filter_filter'      => $filter,
                'sort'               =>'DESC',
                'order'              => 'id',
                'start'              => 0,
                'limit'              => 5
            );

            $product_total = $this->model_catalog_product->getTotalProducts($filter_data);

             $res= $this->model_catalog_product->getProducts($filter_data);
             $childs=array();
             foreach ($res as $k => $val) {

                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($val['price'], $this->session->data['currency']);
                } else {
                    $price = false;
                }
                if ($this->customer->isLogged()) {
                    $special = $this->model_catalog_product->getSpecialPrice($val['product_id']);
                }

                $childs[] = array(
                    'product_id' =>$val['product_id'] , 
                    'image' =>$this->model_tool_image->resize($val['image'],480, 560),
                    'price'       => $price,
                    'name'        => utf8_substr(strip_tags($val['name']),0,40).'...',
                    'special'     => isset($special) ? $special : '',
                    'url'=> $this->url->link('product/product', 'product_id=' . $val['product_id']),
                     );
             }
              $homes[$key]['child'] = $childs;

          }
        }
        $data['homes']=$homes;
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $data['video']=$http_type . $_SERVER['HTTP_HOST']. $homes[0]['video'];
       // print_r($data['video']);exit;
        if(isset($this->session->data['choose'])){ $data['choose']=1; }else { $data['choose']=''; }
        // unset($this->session->data['choose']);

        $data['choose_url']=$this->url->link('common/home/set_session', '', true);
		$this->response->setOutput($this->load->view('common/home', $data));
	}
    protected function get_category_path($category_id)
    {
        $this->load->model('catalog/category');

        $category_info = $this->model_catalog_category->getCategory($category_id);
        if ($category_info['parent_id']==0) {
            return $category_info['category_id'];
        }else{
            $path=$this->get_category_path($category_info['parent_id']);
            return $path."_".$category_id;
        }
    }
  public function set_session() {

        $this->session->data['choose'] =1 ;
        $this->response->redirect($this->url->link('common/home', '', true));

    }
}
