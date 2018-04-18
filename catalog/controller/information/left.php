<?php

/**
 * Company Profile页面左侧栏
 * @author  dyl 783973660@qq.com 2016.10.6
 */
class ControllerInformationLeft extends Controller {

	public function index() {

            $this->load->model('catalog/information');
            $profiles = $this->model_catalog_information->getProfiles();
            // print_r($profiles);exit();
            $r=array();
            foreach ($profiles as $key => $value) {
                $r[]=array(
                    'rewrite' =>  $value['seo_url'],
                      'name' => $value['title'],
                      'profile_id'=>$value['profile_id'],
                    'url' => $this->url->link('information/company/index','profile_id=' .  $value['profile_id']),
                );
            }
             $route = array(
                'route' => $r
                );

		 // $route = array(
   //          'route' => array(
   //              //Company Profile
   //              array(
   //                  'rewrite' => 'information-company-overview',
   //                  //'iconclass' =>'class="dashboard"',
   //                  'name' => 'Company Profile',
   //                  'url' => $this->url->link('information/company/overview')
   //                  ),
   //              //Company Capacity
   //              array(
   //                  'rewrite' => 'information-company-capacity',
   //                  //'iconclass' =>'class="account"',
   //                  'name' => 'Company Capacity',
   //                  'url' => $this->url->link('information/company/capacity')
   //              ),
   //              //Company Trustpass
   //              array(
   //                  'rewrite' => 'information-company-trustpass',
   //                  //'iconclass' =>'class="address"',
   //                  'name' => 'Company Trustpass',
   //                  'url' => $this->url->link('information/company/trustpass')
   //              ),
   //              //Company faq
   //              array(
   //                  'rewrite' => 'information-company-faq',
   //                  //'iconclass' =>'class="inquiry"',
   //                  'name' => 'Company FAQ',
   //                  'url' => $this->url->link('information/company/faq')
   //              ),

   //          )
   //      );

  if(isset($this->request->get['profile_id'])){
             $getroute = $this->request->get['profile_id'];
           }else{
            $getroute='25';
           }
        foreach ($route['route'] as $k=>$v){
             //$route['route'][$k]['class'] =  (stripos($v['url'] , $this->request->server['QUERY_STRING']) !== false) ? 'class="clk"' : '';
          
           // print_r($getroute);exit();
             $route['route'][$k]['class'] =  (stripos($v['profile_id'] , $getroute) !== false) ? 'class="on"' : '';

             //没有开启伪静态时,点击样式的定位
             /*switch($getroute){
             	case 'account/order/info':
                     if( $v['name'] == 'My Orders' )
                     $route['route'][$k]['class'] = 'class="on"';
                     break;

                case 'account/address/edit':
             	case 'account/address/add':
             	     if( $v['name'] == 'Address List' )
                     $route['route'][$k]['class'] = 'class="on"';
                     break;

                case 'account/order/comment':
             	     if( $v['name'] == 'My Orders' )
                     $route['route'][$k]['class'] = 'class="on"';
                     break;
             }*/

             //有开启伪静态时,点击样式的定位
             if( $this->config->get('config_seo_url') ){

               /*if( strpos($this->request->server['QUERY_STRING'],'filter') ){  //有filter
                  if( $v['rewrite'] == strtr($getroute,"/","-") ){
        	 	     $route['route'][$k]['class'] = 'style="color:#fd0a6b;"';
                  }
        	   }else{*/                                                         //没有filter
                  if( stripos($this->request->server['QUERY_STRING'] , $v['rewrite']) !== false ){
                     $route['route'][$k]['class'] = 'class="on"';
        	      }
        	   //}
        	 }

        }


		/*$data['route'] = $this->request->get['route'];
		$this->load->model('account/order');
		$order = $this->model_account_order->getOrders(0,1);
		if($order){
			$data['order_id'] = $order[0]['order_id'];
		}else{
			$data['order_id'] = 0;
		}
		$productItem = array();
		if($order){
			$productItem = $this->model_account_order->getOrderProducts($order[0]['order_id']);
		}
		foreach($productItem as $key=>$row){
			$productItem[$key]['href'] = $this->url->link('product/product','product_id='.$row['product_id']);
		}

		$data['productItem'] = $productItem;

		//$data['action'] 		= $this->url->link('account/order/addCart');
		$data['account'] 		= $this->url->link('account/dashboard');
		$data['accountInfo'] 	= $this->url->link('account/account');
		$data['accountOrder']   = $this->url->link('account/order');  //dyl
		$data['accountAddress'] = $this->url->link('account/address');
		$data['accountWishlist'] = $this->url->link('account/wishlist');  //dyl
		$data['inquiry'] 		= $this->url->link('account/inquiry');
		$data['review'] 		= $this->url->link('account/review');
		$data['logout'] 		= $this->url->link('account/logout');*/

		return $this->load->view('information/left', $route);
	}

}