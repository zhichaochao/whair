<?php
class ControllerAccountLeft extends Controller {
	public function index() {

        //引入该页面的css样式
		$this->document->addStyle('catalog/view/theme/default/stylesheet/account/account_left.css');

		 $route = array(
            'route' => array(
                //我的订单
                array(
               
                    'name' => 'My Orders',
                    'url' => $this->url->link('account/order')
                ),
                //账户信息
                array(
                
                 
                    'name' => 'Account Information',
                    'url' => $this->url->link('account/account')
                ),
                //我的地址
                array(
                 
                 
                    'name' => 'Address List',
                    'url' => $this->url->link('account/address')
                ),
                //我的心愿单
                array(
                 
                
                    'name' => 'My Wish List',
                    'url' => $this->url->link('account/wishlist')
                ),
                //会员等级
                array(
                 
                    'name' => 'My VIP',
                    'url' => $this->url->link('account/vip')
                ),
                //优惠劵
                // array(
            
                //     'name' => 'My Coupon',
                //     'url' => $this->url->link('account/coupon')
                // ),
                //Hinquiry
                array(
             
              
                    'name' => 'Help Center',
           
                    'url' => $this->url->link('account/help')
                ),

              //logout
                array(
                    'name' => 'Logout',
                    'url' => $this->url->link('account/logout')
                ),
            )
        );


        foreach ($route['route'] as $k=>$v){
       
             $getroute = $this->request->get['route'];
             $route['route'][$k]['class'] =  (stripos($v['url'] , $getroute) !== false) ? 'class="active"' : '';

         
             //有开启伪静态时,点击样式的定位
             if( $this->config->get('config_seo_url') ){

                                                               //没有filter
                  if( stripos($this->request->server['QUERY_STRING'] , $v['rewrite']) !== false ){
                     $route['route'][$k]['class'] = 'class="active"';
        	      }
        	  
        	 }

        }



		return $this->load->view('account/left', $route);
	}
}