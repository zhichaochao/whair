<?php
class ControllerProductProduct extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('product/product');

       
          
    

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => 'Home',
            'href' => $this->url->link('common/home')
        );

        $this->load->model('catalog/category');
        //引入样式

        //分类面包屑
        $this->load->model('catalog/product');
        $category_list = $this->model_catalog_product->getCatalogName($this->request->get['product_id']);

  

        //新
        foreach($category_list as $k => $row){
            if( $k==0 && !empty($category_list[$k]) ){       //父类
                $data['breadcrumbs'][] = array(
                    'text' => $row['name'],
                    'href' => $this->url->link('product/category', 'path='.$row['category_id'])
                );
            }
            if( $k==1 && !empty($category_list[$k]) ){       //子类
                $data['breadcrumbs'][] = array(
                    'text' => $row['name'],
                    'href' => $this->url->link('product/category', 'path='.$row['parent_id'].'_'.$row['category_id'])
                );
            }
            if( $k==2 && !empty($category_list[$k]) ){       //子类的子类(第三级分类)
                $data['breadcrumbs'][] = array(
                    'text' => $row['name'],
                    'href' => $this->url->link('product/category', 'path='.$category_list[$k-2]['category_id'].'_'.$row['parent_id'].'_'.$row['category_id'])
                );
            }
        }


     

        $this->load->model('catalog/manufacturer');

        if (isset($this->request->get['manufacturer_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_brand'),
                'href' => $this->url->link('product/manufacturer')
            );

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);

            if ($manufacturer_info) {
                $data['breadcrumbs'][] = array(
                    'text' => $manufacturer_info['name'],
                    'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
                );
            }
        }

        if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
            $url = '';

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_search'),
                'href' => $this->url->link('product/search', $url)
            );
        }

        if (isset($this->request->get['product_id'])) {
            $product_id = (int)$this->request->get['product_id'];
        } else {
            $product_id = 0;
        }

        $this->load->model('catalog/product');

        $product_info = $this->model_catalog_product->getProduct($product_id);
        $sp= $this->model_catalog_product->getProductSpecialPrice($product_id);
        // print_r($sp);exit();
        if (!$sp) {
            $sp= $this->model_catalog_product->getProductMinPrice($product_id);
        }
         if(isset($this->request->get['share'])&&$this->request->get['share']!='{}'){
            $share = trim($this->request->get['share'],'{}');
        }else{
            $share=trim($sp['share'],'{}');
        }
            $shareoption = [];
            foreach (explode(',',$share) as $item){
                $temp = explode(':',$item);
                $shareoption[preg_replace('/\D/s', '', $temp[0])] = preg_replace('/\D/s', '', $temp[1]);
            }
            $data['shareoption'] = $shareoption;
        

     
      // print_r($shareoption);exit();


		// print_r($product_info);die;
        if ($product_info) {
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

           

            $this->document->setTitle($product_info['meta_title']);
            $this->document->setDescription($product_info['meta_description']);
            $this->document->setKeywords($product_info['meta_keyword']);
            $this->document->addLink($this->url->link('product/product', 'product_id=' . $this->request->get['product_id']), 'canonical');
          

            $data['heading_title'] = $product_info['name'];
            $data['wishlist']= $this->model_catalog_product->wishlistornot($product_info['product_id']);

            $data['text_select'] = $this->language->get('text_select');
            $data['text_manufacturer'] = $this->language->get('text_manufacturer');
            $data['text_model'] = $this->language->get('text_model');
            $data['text_reward'] = $this->language->get('text_reward');
            $data['text_points'] = $this->language->get('text_points');
            $data['text_stock'] = $this->language->get('text_stock');
            $data['text_discount'] = $this->language->get('text_discount');
            $data['text_tax'] = $this->language->get('text_tax');
            $data['text_option'] = $this->language->get('text_option');
            $data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
            $data['text_write'] = 'Write A Review';
            $data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));
            $data['text_note'] = $this->language->get('text_note');
            $data['text_tags'] = $this->language->get('text_tags');
            $data['text_quick_overview'] = 'Quick Overview';
            $data['text_related'] = 'Customers Who Bought This Item Also Bought';
            $data['text_payment_recurring'] = $this->language->get('text_payment_recurring');
            $data['text_loading'] = $this->language->get('text_loading');

            $data['entry_qty'] = $this->language->get('entry_qty');
            $data['entry_name'] = $this->language->get('entry_name');
            $data['entry_review'] = $this->language->get('entry_review');
            $data['entry_image'] = 'Image';
            $data['entry_rating'] = $this->language->get('entry_rating');
            $data['entry_good'] = $this->language->get('entry_good');
            $data['entry_bad'] = $this->language->get('entry_bad');

            $data['button_cart'] = $this->language->get('button_cart');
            //$data['button_wishlist'] = $this->language->get('button_wishlist');
            //$data['button_compare'] = $this->language->get('button_compare');
            $data['button_upload'] = $this->language->get('button_upload');
            $data['button_continue'] = $this->language->get('button_continue');

            $data['wishlist_add'] = $this->url->link('account/wishlist/add', '', true);
            $data['delewishlist'] = $this->url->link('account/wishlist/delete', '', true);

            $this->load->model('catalog/review');

            $data['tab_description'] = $this->language->get('tab_description');
            $data['tab_attribute'] = $this->language->get('tab_attribute');
            $data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);

            $data['product_id'] = (int)$this->request->get['product_id'];

            $data['points'] = $product_info['points'];
            $data['material'] = $product_info['material'];
            $data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
            $data['m_description'] = html_entity_decode($product_info['m_description'], ENT_QUOTES, 'UTF-8');

            //产品属性
            $data['manufacturer'] = $product_info['manufacturer'];
            $data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
            $data['model'] = $product_info['model'];
            $data['reward'] = $product_info['reward'];
            $data['image'] = 'image/'.$product_info['image'];

            if ($product_info['quantity'] <= 0) {
                $data['stock'] = $product_info['stock_status'];
            } elseif ($this->config->get('config_stock_display')) {
                $data['stock'] = $product_info['quantity'];
            } else {
                $data['stock'] = $this->language->get('text_instock');
            }
            //产品属性,end

            $this->load->model('tool/image');

            $data['placeholder_image'] = $this->model_tool_image->resize('placeholder.png',98,98);

            if ($product_info['image']) {
                $data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height'));
            } else {
                $data['popup'] = '';
            }

            if ($product_info['image']) {
                //$data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));
                $data['thumb'] = $this->model_tool_image->resize($product_info['image'], 800, 800);
            } else {
                $data['thumb'] = '';
            }

            //如果用户已登录，自动填充询盘用户信息（用户名、邮箱）
            if($this->customer->isLogged()){
                $data['name'] = $this->customer->getFirstName().' '.$this->customer->getLastName();
            }else{
                $data['name'] = '';
            }

           
            //print_r($_SERVER["REQUEST_URI"]);exit();
            $this->session->data['userurl'] = $_SERVER["REQUEST_URI"];
            if(!$this->customer->isLogged()){
             $this->session->data['redirect'] = $this->url->link($this->session->data['userurl']);
             unset($this->session->data['userurl']);
         }else{
        

                $data['logins']=1;               
            }
             $data['login'] = $this->url->link('account/login');
            if (isset($this->request->post['email'])) {
                $data['email'] = $this->request->post['email'];
            } else {
                $data['email'] = $this->customer->getEmail();
            }

            $data['images'] = array();
             $data['images'][] = array(
                
                    'thumb' => $this->model_tool_image->resize($product_info['image'], 200, 200),  //小图
                  
                    'image'=> $this->model_tool_image->resize($product_info['image'], 800, 800),  //小图
                  
                    'thumb2'=> $this->model_tool_image->resize($product_info['image'], 800, 800)
                );
            // print_r($product_info);exit();
            $results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
            foreach ($results as $result) {
                $data['images'][] = array(
                
                    'thumb' => $this->model_tool_image->resize($result['image'], 200, 200),  //小图
                  
                    'image'=> $this->model_tool_image->resize($result['image'], 800, 800),  //小图
                  
                    'thumb2'=> $this->model_tool_image->resize($result['image'], 800, 800)
                );
            }

            
            //包邮
            if($product_info['free_postage']){
                $data['free_shipping'] = $this->language->get('text_free_shipping');
            }else{
                $data['free_shipping'] = '';
            }
            // print_r($product_info);exit();

        
            $data['price']=$this->currency->format($product_info['price'], $this->session->data['currency']);
            if ($product_info['special']>0) {
                 $data['special']=$this->currency->format($product_info['special'], $this->session->data['currency']);
            }
           
        

      
           

            $data['isLogged'] = $this->customer->isLogged();

            if ($this->config->get('config_tax')) {
                $data['tax'] = $this->currency->format((float)$product_info['special']>0 ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
            } else {
                $data['tax'] = false;
            }

            $discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
            $data['discounts'] = array();
            foreach ($discounts as $discount) {
                $data['discounts'][] = array(
                    'quantity' => $discount['quantity'],
                    'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
                );
            }


            $data['options'] = array();
            $options=$this->model_catalog_product->getProductOptions($this->request->get['product_id']);
           // var_dump($options);exit;
            foreach ( $options as $option) {
                $product_option_value_data = array();
                foreach ($option['product_option_value'] as $option_value) {
                    if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                        if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
                            $price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
                        } else {
                            $price = false;
                        }

                        $product_option_value_data[] = array(
                            'product_option_value_id' => $option_value['product_option_value_id'],
                            'option_value_id'         => $option_value['option_value_id'],
                            'name'                    => $option_value['name'],
                            'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
                            'price'                   => $price,
                            'price_prefix'            => $option_value['price_prefix']
                        );
                    }
                }

                $data['options'][] = array(
                    'product_option_id'    => $option['product_option_id'],
                    'product_option_value' => $product_option_value_data,
                    'option_id'            => $option['option_id'],
                    'name'                 => $option['name'],
                    'type'                 => $option['type'],
                    'image'                 =>$this->model_tool_image->resize($option['image'], 50, 50),
                    'value'                => $option['value'],
                    'required'             => $option['required']
                );
            }
//var_dump($data['options']);exit;

            if ($product_info['minimum']) {
                $data['minimum'] = $product_info['minimum'];
            } else {
                $data['minimum'] = 1;
            }

            if ($this->request->server['HTTPS']) {
                $server = $this->config->get('config_ssl');
            } else {
                $server = $this->config->get('config_url');
            }

            if ($product_info['video']) {
                $data['video'] = $server . 'image/' . $product_info['video'];
            } else {
                $data['video'] = '';
            }

            if ($product_info['video_link']) {
                $data['video_link'] = $product_info['video_link'];
            } else {
                $data['video_link'] = '';
            }


            $data['review_status'] = $this->config->get('config_review_status');

            if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
                $data['review_guest'] = true;
            } else {
                $data['review_guest'] = false;
            }

            if ($this->customer->isLogged()) {
                $data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
            } else {
                $data['customer_name'] = '';
            }

            //评论提交的地址
            $data['reviews_action'] = $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id']);

            $data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
            $data['rating'] = (int)$product_info['rating'];

            // Captcha
            if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
                $data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
            } else {
                $data['captcha'] = '';
            }

            $data['share'] = $this->url->link('product/product', 'product_id=' . (int)$this->request->get['product_id']);

            $data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);

           

            $data['tags'] = array();
            if ($product_info['tag']) {
                $tags = explode(',', $product_info['tag']);
                foreach ($tags as $tag) {
                    $data['tags'][] = array(
                        'tag'  => trim($tag),
                        'href' => $this->url->link('product/search', 'tag=' . trim($tag))
                    );
                }
            }


         $this->load->model('catalog/information');

            $faq = $this->model_catalog_information->getInformation(9);
            // print_r($faq);exit();
            $data['faq']= html_entity_decode($faq['description'], ENT_QUOTES, 'UTF-8');

            //首页推荐商品
            $recommend_products = $this->model_catalog_product->getRecommendProducts(4);
             //print_r($recommend_products);exit();
            $i = 0;
            foreach($recommend_products as $key=>$row){
                $recommend_products[$key]['key_id'] = $i;   //作为索引值 dyl add
            
                $recommend_products[$key]['description'] = utf8_substr(strip_tags(html_entity_decode($row['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..';
            
                if($recommend_products[$key]['image']){
                    $recommend_products[$key]['image'] = $this->model_tool_image->resize($row['image'], 360, 360);
                }else{
                    $recommend_products[$key]['image'] = $this->model_tool_image->resize('placeholder.png', 360, 360);
                }
            
                $recommend_products[$key]['product_link'] = $this->url->link('product/product','product_id='.$row['product_id']);
                $recommend_products[$key]['texture'] = $this->model_catalog_product->getOptionDes('Texture',$row['product_id']);
                $recommend_products[$key]['price'] = $this->currency->format($row['price'], $this->session->data['currency']);
                $recommend_products[$key]['min_name'] = utf8_substr(strip_tags($row['name']),0,40).'...';
                $i++;
            }
            
            $data['recommend_products'] = $recommend_products;


            $data['recurrings'] = $this->model_catalog_product->getProfiles($this->request->get['product_id']);

            $this->model_catalog_product->updateViewed($this->request->get['product_id']);


            //产品详情页的FAQ
            $data['product_faq'] = html_entity_decode($this->model_catalog_product->getInformaintion(7),ENT_QUOTES,'UTF-8');

            //产品的评论Reviews
            $this->load->model('catalog/review');

            //该产品的评论总次数
            $productIdArray = $this->model_catalog_review->getTotalReviewsByRelatePro($product_info['relation_product']);
            $productIdString = '';
            foreach($productIdArray as $k => $v){
                $productIdString .= $v['product_id'].',';
            }
            $productIdString = mb_substr($productIdString,0,-1,'utf-8');
            //评论总个数
            $data['reviewstotal'] = $this->model_catalog_review->getTotalReviewsByProductId($productIdString);

            //该产品的评论总分数
            $data['reviewsrating'] = $this->model_catalog_review->getRatingByProductId($productIdString);

            //该产品的评论平均分(四舍五入,保留一位小数)
            //星星
            $data['reviewsratingStar'] = $data['reviewstotal'] > 0 ? round(($data['reviewsrating'] / $data['reviewstotal'])*20, 1) : 0;
            //数字
            $data['reviewsratingNum'] = $data['reviewstotal'] > 0 ? round($data['reviewsrating'] / $data['reviewstotal'], 1) : 0;
            //产品的评论Reviews,end

            //产品评论的提交
            if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->write()){
                $data['error'] = $this->error;
            }

            //询盘请求的url   dyl add
            $data['inquiry_url'] = $this->url->link('product/product/addinquiry');
            $this->load->model('localisation/country');
            $data['countries'] = $this->model_localisation_country->getCountries();
            //询盘请求的url  end

            $data['email'] = $this->config->get('config_email');
       // print_r($this->customer);exit();
            //购物车链接
            $data['shopping_cart'] = $this->url->link('checkout/cart');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');
//            var_dump($data['options']);die;
            $this->response->setOutput($this->load->view('product/product', $data));

        } else {
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
            );

            $this->document->setTitle($this->language->get('text_error'));

            $data['heading_title'] = $this->language->get('text_error');

            $data['text_error'] = $this->language->get('text_error');

            $data['button_continue'] = $this->language->get('button_continue');

            $data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

            $data['column_left'] = $this->load->controller('common/column_left');
            //$data['column_right'] = $this->load->controller('common/column_right');
            $data['account_left'] = $this->load->controller('account/left');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('error/not_found', $data));
        }
    }

    public function review() {
       

        $this->load->language('product/product');

        $this->load->model('catalog/review');

        $data['text_no_reviews'] = $this->language->get('text_no_reviews');

        $page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;   //当前页页码

        //$limit = 5;
        $limit = $this->request->get['pagesize'];   //一页显示多少条
        $data['reviews'] = array();
        //$review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);
        //$results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * $limit, $limit);

        $product_id = $this->request->get['product_id'];   //产品id
        $this->load->model('catalog/product');
        $product_info = $this->model_catalog_product->getProduct($product_id);
        
        if(!empty($product_info)){

            $this->load->model('catalog/review');
            $productIdArray = $this->model_catalog_review->getTotalReviewsByRelatePro($product_info['relation_product']);
            $productIdString = '';
            foreach($productIdArray as $k => $v){
                $productIdString .= $v['product_id'].',';
            }
            $productIdString = mb_substr($productIdString,0,-1,'utf-8');

            $review_total = $this->model_catalog_review->getTotalReviewsByProductId($productIdString);
            $results = $this->model_catalog_review->getReviewsByProductId($productIdString, ($page - 1) * $limit, $limit);

            $this->load->model('tool/image');
            foreach ($results as $result) {
                $review_img = $this->model_catalog_review->getReviewImg($result['review_id']);

                foreach($review_img as $key=>$row){
                    //$review_img[$key]['img'] = HTTP_SERVER.$row['path'];
                    $review_img[$key]['img'] = $this->model_tool_image->resize(str_replace('image/', '', $row['path']), 450, 450);
                    $review_img[$key]['min_img'] = $this->model_tool_image->resize(str_replace('image/', '', $row['path']), 200, 200);
                }

                $data['reviews'][] = array(
                    //'author'     => $result['author'],
                    'author'        => substr($result['author'],0,-2).'***',
                    'text'          => nl2br($result['text']),
                    'rating'        => (int)$result['rating'],
                    //'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                    'date_added'    => date('m/d/Y', strtotime($result['date_added'])),
                    'rating_starts' => $this->ratingStarts($result['rating']),
                    'images'        => $review_img
                );
            }
        }

        if(!empty($data['reviews'])){
            $info = array('code'=>1, 'message'=>'Comment Information', 'data'=>$data['reviews'], 'total'=>$review_total);
        }else{
            $info = array('code'=>0, 'message'=>'No Comment Information');
        }
        $reviewsinfo = json_encode($info);
        echo $reviewsinfo;

    }

    public function write() {
        $this->load->language('product/product');


        if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
            //$json['error'] = $this->language->get('error_rating');
            $this->error['error'] = $this->language->get('error_rating');
        }

        if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
            //$json['error'] = $this->language->get('error_text');
            $this->error['error'] = $this->language->get('error_text');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
            //$json['error'] = $this->language->get('error_name');
            $this->error['error'] = $this->language->get('error_name');
        }

        //图片上传
        if($_FILES){
            foreach($_FILES['file']['name'] as $key=>$row){
                if($_FILES['file']['error'][$key]==4){
                    continue;
                }
                if($_FILES['file']['error'][$key]!=0){
                    $this->error['error'] = 'Picture format wrong!';
                }else if(!($_FILES['file']['type'][$key]=='image/gif' || $_FILES['file']['type'][$key]=='image/jpeg' || $_FILES['file']['type'][$key]=='image/pjpeg' || $_FILES['file']['type'][$key]=='image/png')){
                    $this->error['error'] = 'Picture format wrong!';
                }else if($_FILES['file']['size'][$key] > 4194304){   //限制图片大小为4M
                    $this->error['error'] = 'Picture size can not exceed 4M!';
                }
            }
        }
        //图片上传,end

        // Captcha
        if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
            $captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

            if ($captcha) {
                //$json['error'] = $captcha;
                $this->error['error'] = $captcha;
            }
        }

        //if (!isset($json['error'])) {
        if (empty($this->error['error'])) {

            //没错后,将图片进行迁移,并记录路径入库
            if($_FILES){
                $path = array();
                foreach($_FILES['file']['name'] as $key=>$row){
                    if($_FILES['file']['error'][$key]==4){
                        continue;
                    }

                    if($_FILES['file']['error'][$key]==0){
                        if(($_FILES['file']['type'][$key]=='image/gif' || $_FILES['file']['type'][$key]=='image/jpeg' || $_FILES['file']['type'][$key]=='image/pjpeg' || $_FILES['file']['type'][$key]=='image/png')){
                            $extend = pathinfo($row); //获取文件名数组
                            $extend = strtolower($extend["extension"]);                //获取文件的扩展名
                            $filename = time().rand(100,999).".".$extend;              //文件的新名称
                            $directory = DIR_IMAGE . 'catalog/thimg/review';
                            $path[] = 'image/catalog/thimg/review/' . $filename;
                            move_uploaded_file($_FILES['file']['tmp_name'][$key],$directory . '/' . $filename);
                        }
                    }
                }
            }

            $this->load->model('catalog/review');
            $this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post ,$path);

            //$json['success'] = $this->language->get('text_success');
            $this->error['success'] = $this->language->get('text_success');
        }

        return $this->error;
        //}

        //$this->response->addHeader('Content-Type: application/json');
        //$this->response->setOutput(json_encode($json));
    }

    public function getRecurringDescription() {
        $this->load->language('product/product');
        $this->load->model('catalog/product');

        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }

        if (isset($this->request->post['recurring_id'])) {
            $recurring_id = $this->request->post['recurring_id'];
        } else {
            $recurring_id = 0;
        }

        if (isset($this->request->post['quantity'])) {
            $quantity = $this->request->post['quantity'];
        } else {
            $quantity = 1;
        }

        $product_info = $this->model_catalog_product->getProduct($product_id);
        $recurring_info = $this->model_catalog_product->getProfile($product_id, $recurring_id);

        $json = array();

        if ($product_info && $recurring_info) {
            if (!$json) {
                $frequencies = array(
                    'day'        => $this->language->get('text_day'),
                    'week'       => $this->language->get('text_week'),
                    'semi_month' => $this->language->get('text_semi_month'),
                    'month'      => $this->language->get('text_month'),
                    'year'       => $this->language->get('text_year'),
                );

                if ($recurring_info['trial_status'] == 1) {
                    $price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    $trial_text = sprintf($this->language->get('text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
                } else {
                    $trial_text = '';
                }

                $price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

                if ($recurring_info['duration']) {
                    $text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
                } else {
                    $text = $trial_text . sprintf($this->language->get('text_payment_cancel'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
                }

                $json['success'] = $text;
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }


    /**
     * 等级Star
     * @author  dyl  783973660@qq.com  2016.9.7
     * @param   Int     $rating        等级数字
     * return   String  $retingStarts  返回等级描述
     */
    protected function ratingStarts($rating){
        $retingStarts = '';
        $starts = ' Star';

        switch($rating){
            case 1: $retingStarts = 'One'.$starts; break;
            case 2: $retingStarts = 'Two'.$starts; break;
            case 3: $retingStarts = 'Three'.$starts; break;
            case 4: $retingStarts = 'Four'.$starts; break;
            case 5: $retingStarts = 'Five'.$starts; break;
        }

        return $retingStarts;
    }


    /**
     * 产品详情页询盘的提交操作(页面ajax异步提交到这里)
     * @author  dyl  78397360@qq.com  2016.9.27
     */
    public function addinquiry(){

        if($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate()){

            if( empty($this->error['error_name']) && empty($this->error['error_email']) && empty($this->error['error_content']) ){

                $data['product_id'] = $this->request->post['product_id'];
                $data['customer_id'] = ( $this->customer->isLogged() ) ? $this->customer->getId() : 0;
                $data['name'] = $this->request->post['name'];
                $data['email'] = $this->request->post['email'];

                $data['fixed_line'] = $this->request->post['fixed_line'];
                $data['country_id'] = $this->request->post['country_id'];
                $data['phone'] = $this->request->post['phone'];

                $factime = trim($this->request->post['phone']);
                $whatsapp = trim($this->request->post['whatsapp']);
                $enquiry = trim($this->request->post['content']);
                $str_enquiry = 'Factime&iMesssage ID:' . $factime . "<br>Whtsapp ID:" . $whatsapp . "<br>Comment:" . $enquiry;

                $data['content'] = $str_enquiry;

                $this->load->model('account/inquiry');
                $this->model_account_inquiry->addinquiry($data);

                //将前台传过来的信息写入session，发邮件使用
                $this->session->data['email_message']['product_id'] = isset($this->request->post['product_id']) ? $this->request->post['product_id'] : '';
                $this->session->data['email_message']['name'] = isset($this->request->post['name']) ? $this->request->post['name'] : '';
                $this->session->data['email_message']['email'] = isset($this->request->post['email']) ? $this->request->post['email'] : '';
                $this->session->data['email_message']['fixed_line'] = isset($this->request->post['fixed_line']) ? $this->request->post['fixed_line'] : '';
                $this->session->data['email_message']['country_id'] = isset($this->request->post['country_id']) ? $this->request->post['country_id'] : '';
                $this->session->data['email_message']['phone'] = isset($this->request->post['phone']) ? $this->request->post['phone'] : '';
                $this->session->data['email_message']['whatsapp'] = isset($this->request->post['whatsapp']) ? $this->request->post['whatsapp'] : '';
                $this->session->data['email_message']['content'] = isset($this->request->post['content']) ? $this->request->post['content'] : '';
                $this->session->data['email_message']['pro_name'] = isset($this->request->post['pro_name']) ? $this->request->post['pro_name'] : '';
                $this->session->data['email_message']['pro_model'] = isset($this->request->post['pro_model']) ? $this->request->post['pro_model'] : '';
                $this->session->data['email_message']['send_page'] = isset($this->request->get['route']) ? $this->request->get['route'] : "";

                //$this->sendEmail(); //发送询盘

                $info = array('code'=>1, 'message'=>'Submit successfully');
            }else{
                $data['error_name'] = $this->error['error_name'];
                $data['error_email'] = $this->error['error_email'];
                $data['error_content'] = $this->error['error_content'];
                $info = array('code'=>0, 'message'=>'Submit failed','data'=>$data);
            }

            $inquiryinfo = json_encode($info);
            echo $inquiryinfo;
        }

    }

    /**
     * 验证产品详情页询盘的提交操作
     * @author  dyl 783973660@qq.com  2016.9.27
     */
    public function validate() {

        //$json = array();

        //if ($this->request->server['REQUEST_METHOD'] == 'POST') {

        $this->error['error_name'] =  $this->error['error_email'] = $this->error['error_content'] = '';

        if ( empty(trim($this->request->post['name'])) ){
            //$json['error'] = $this->language->get('error_name');
            $this->error['error_name'] = 'Name cannot be empty!';
        }

        if ( empty(trim($this->request->post['email'])) ) {
            //$json['error'] = $this->language->get('error_text');
            $this->error['error_email'] = 'Email cannot be empty!';
        }

        if( !empty(trim($this->request->post['email'])) && !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', trim($this->request->post['email'])) ){
            $this->error['error_email'] = 'Mailbox format error!';
        }

        if ( empty(trim($this->request->post['content'])) ) {
            //$json['error'] = $this->language->get('error_rating');
            $this->error['error_content'] = 'Content cannot be empty!';
        }

        if ( !empty(trim($this->request->post['content'])) && utf8_strlen(trim($this->request->post['content'])) < 4 ) {
            //$json['error'] = $this->language->get('error_rating');
            $this->error['error_content'] = 'Your message must be over 4 characters!';
        }

        if( empty($this->error['error_name']) && empty($this->error['error_email']) && empty($this->error['error_content']) ){
            return true;
        }else{
            return $this->error;
        }

        //}

        //$this->response->addHeader('Content-Type: application/json');
        //$this->response->setOutput(json_encode($json));
    }

    /**
     * 产品询盘、Contant页面、Merchant Service页面邮件发送信息提交到这里统一发送
     * @author  dyl 783973660@qq.com 2016.10.13
     */
    public function sendEmail(){

        if(isset($this->session->data['email_message'])){
            $pruduct_id = isset($this->session->data['email_message']['product_id']) ? $this->session->data['email_message']['product_id'] : '';
            $name = isset($this->session->data['email_message']['name']) ? $this->session->data['email_message']['name'] : '';
            $email = isset($this->session->data['email_message']['email']) ? $this->session->data['email_message']['email'] : '';
            $fixed_line = isset($this->session->data['email_message']['fixed_line']) ? $this->session->data['email_message']['fixed_line'] : '';
            $country_id = isset($this->session->data['email_message']['country_id']) ? $this->session->data['email_message']['country_id'] : '';
            $phone = isset($this->session->data['email_message']['phone']) ? $this->session->data['email_message']['phone'] : '';
            $whatsapp = isset($this->session->data['email_message']['whatsapp']) ? $this->session->data['email_message']['whatsapp'] : '';
            $content = isset($this->session->data['email_message']['content']) ? $this->session->data['email_message']['content'] : '';
            $pro_name = isset($this->session->data['email_message']['pro_name']) ? $this->session->data['email_message']['pro_name'] : '';
            $pro_model = isset($this->session->data['email_message']['pro_model']) ? $this->session->data['email_message']['pro_model'] : '';
            $contact_send_page = isset($this->session->data['email_message']['contact_send_page']) ? str_replace('/', '-', $this->session->data['email_message']['contact_send_page']) : '';   //信息联系页面发送邮件的页面
            $send_page = isset($this->session->data['email_message']['send_page']) ? str_replace('/', '-', $this->session->data['email_message']['send_page']) : '';   //发送邮件的页面

            $this->load->model('localisation/country');
            $country_result = $this->model_localisation_country->getCountry($country_id);

            //发送邮件
            $this->load->language('mail/customer');

            //logo
            if ($this->request->server['HTTPS']) {
                $server = $this->config->get('config_ssl');
            } else {
                $server = $this->config->get('config_url');
            }
            if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
                $html_data['logo'] = $server . 'image/' . $this->config->get('config_logo');
            } else {
                $html_data['logo'] = '';
            }

            //获取url的网址参数
            //$QUERY_STRING = explode('=',$_SERVER['QUERY_STRING']);

            $html_data['from_name'] = trim($name);
            $html_data['email'] = trim($email);
            $html_data['tel_number'] = trim($fixed_line);
            $html_data['country_name'] = $country_result['name'];
            $html_data['ip_address'] = $this->request->server['REMOTE_ADDR'];
            $html_data['business_name'] = trim($name);

            $factime = trim($phone);
            $whatsapp = trim($whatsapp);
            $html_data['factime'] = $factime;
            $html_data['whatsapp'] = $whatsapp;
            $html_data['content'] = trim($content);
            $reply_to = trim($email);

            //产品询盘发送邮件
            if(trim($send_page) == 'product-product-addinquiry'){
                $html_data['whatsapp_facetime_mphone'] = trim($phone);
                $html_data['pro_name'] = trim($pro_name);
                $html_data['sku'] = trim($pro_model);
                $html_data['send_page'] = 'product-wholesale-inquiry';
                $view = 'mail/product_email';
                $title = 'Hot Beauty Hair Product Inquiry';
                $this->send($name, $reply_to, $html_data, $view, $title);
            }

            //Contant页面发送邮件
            if(trim($send_page) == 'information-contact'){
                $html_data['send_page'] = $send_page;
                $view = 'mail/contact_us_email';
                $title = 'Hot Beauty Hair Contact Us Inquiry';
                $this->send($name, $reply_to, $html_data, $view, $title);

            }

            //信息页联系我们发送邮件
            if(trim($send_page) == 'information-contact_us-addContactusenquiry'){
                $html_data['send_page'] = $contact_send_page;
                $view = 'mail/contact_us_email';
                $title = 'Hot Beauty Hair Contact Us Inquiry';
                $this->send($name, $reply_to, $html_data, $view, $title);
            }
        }
    }

    /**
     * 封装发送方法
     * @param   String     $name       发件人名字
     * @param   String     $reply_to   发件人邮箱
     * @param   Array      $html_data  邮件信息
     * @param   String     $view       显示模板
     * @param   String     $title      邮件标题
     */
    public function send($name, $reply_to, $html_data, $view, $title){
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

        $mail->setTo($this->config->get('config_email'));                     //发给系统管理员的邮箱(接收人邮箱)
        $mail->setFrom($this->config->get('config_mail_parameter'));      //发送人
        $mail->setSender(html_entity_decode(trim($name), ENT_QUOTES, 'UTF-8'));    //发送者名字
        //$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
        $mail->setSubject($title);     //邮件标题
        $mail->setReplyTo($reply_to);
        $mail->setHtml($this->load->view($view,$html_data));
        //$mail->setText($message);
        $mail->send();
        unset($this->session->data['email_message']);
    }


    /**
     * 产品价格
     */
    public function getprice() {

        $json = array();

        if (isset($this->request->get['product_id'])) {
            $product_id = (int)$this->request->get['product_id'];
        } else {
            $product_id = 0;
        }
        $options=$this->request->post['option'];

        $this->load->model('catalog/product');

        $price=  $this->model_catalog_product->getProductPricebyOptions($product_id,$options);
        $price_c= $this->currency->format($price['price'], $this->session->data['currency']);
      $json=$price;
     if ($price['special']>0) {
          $price_s= $this->currency->format($price['special'], $this->session->data['currency']);
           $json['html']= '<span>'.$price_s.'</span><i>'. $price_c.'</i>';
      }else{
            $json['html']= '<span>'. $price_c.'</span>';  
        }

     $this->response->addHeader('Content-Type: application/json');
     $this->response->setOutput(json_encode($json));
        
    }
}
