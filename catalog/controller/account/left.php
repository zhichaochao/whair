<?php
class ControllerAccountLeft extends Controller {
	public function index() {

        //引入该页面的css样式
		$this->document->addStyle('catalog/view/theme/default/stylesheet/account/account_left.css');

		 $route = array(
            'route' => array(
                //我的订单
                array(
                    'rewrite' => 'account-order',
                    //'iconclass' =>'class="order"',
                    'name' => 'My Orders',
                    'url' => $this->url->link('account/order')
                ),
                //账户信息
                array(
                    'rewrite' => 'account-account',
                    //'iconclass' =>'class="account"',
                    'name' => 'Account Information',
                    'url' => $this->url->link('account/account')
                ),
                //我的地址
                array(
                    'rewrite' => 'account-address',
                    //'iconclass' =>'class="address"',
                    'name' => 'Address List',
                    'url' => $this->url->link('account/address')
                ),
                //我的心愿单
                array(
                    'rewrite' => 'account-wishlist',
                    //'iconclass' =>'class="wishlist"',
                    'name' => 'My Wish List',
                    'url' => $this->url->link('account/wishlist')
                ),
                //会员等级
                array(
                    'rewrite' => 'account-vip',
                    'name' => 'My VIP',
                    'url' => $this->url->link('account/vip')
                ),
                //优惠劵
                array(
                    'rewrite' => 'account-vip',
                    'name' => 'My Coupon',
                    'url' => $this->url->link('account/Coupon')
                ),
                //Hinquiry
                array(
                    'rewrite' => 'account-inquiry',
                    //'iconclass' =>'class="inquiry"',
                    'name' => 'Help Center',
                    // 'url' => $this->url->link('account/inquiry')
                    'url' => $this->url->link('account/dashboard')
                ),

                //控制台
                // array(
                //     'rewrite' => 'account-dashboard',
                //     //'iconclass' =>'class="dashboard"',
                //     'name' => 'Dashboard',
                //     'url' => $this->url->link('account/dashboard')
                //     ),
                //我的心愿单
                /*array(
                    'rewrite' => 'account-wishlist',
                    //'iconclass' =>'class="wishlist"',
                    'name' => 'My Wishlist',
                    'url' => $this->url->link('account/wishlist')
                ),*/
                //购物车
                /*array(
                    'rewrite' => 'checkout-cart',
                    //'iconclass' =>'class="wishlist"',
                    'name' => 'My Shopping Cart',
                    'url' => $this->url->link('checkout/cart')
                ),*/

                //Logout
                array(
                    'rewrite' => 'account-logout',
                    //'iconclass' =>'class="account"',
                    'name' => 'Logout',
                    'url' => $this->url->link('account/logout')
                ),
            )
        );


        foreach ($route['route'] as $k=>$v){
             //$route['route'][$k]['class'] =  (stripos($v['url'] , $this->request->server['QUERY_STRING']) !== false) ? 'class="clk"' : '';

             $getroute = $this->request->get['route'];
             $route['route'][$k]['class'] =  (stripos($v['url'] , $getroute) !== false) ? 'class="active"' : '';

             //没有开启伪静态时,点击样式的定位
             switch($getroute){
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
             }

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

		return $this->load->view('account/left', $route);
	}
}