<?php
class ControllerProductAllcategory extends Controller {
	public function index() {
		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');
		

			$category_image = $this->model_catalog_category->getCategoryImage();
			//print_r($category_image);
			$rows=$category_image->rows;
			//print_r($rows);exit;
			//$category_path=$this->get_category_path($nav['inside_id']);
			foreach ($rows as $key=>$value ){

			$category_info = $this->model_catalog_category->getCategory($value['category_id']);
			//print_r($category_info);exit;
			if ($category_info['parent_id']==0) {
				$path= $category_info['category_id'];
			}else{
				$path=$this->get_category_path($category_info['parent_id']);
				$paths= $path."_".$category_info['category_id'];
			}
			//print_r($paths);exit;
			$data['rows'][$key] = array(
					'm_image'       => $this->model_tool_image->resize($value['m_image'],710,320),
					'name'	 		 => $value['name'],
					'href'             => $this->url->link('product/category', 'path=' . $paths)
					
				);
			 
			}
			//print_r($data['rows']);exit;
			$data['continue'] = $this->url->link('common/home');
			$data['navs']=$this->get_navs();

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('product/allcategory', $data));
		} 
		//获取分类链接
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
	//获取导航链接
	protected function handleNav($nav){
		$this->load->model('tool/image');
		//print_r($nav);exit;
		$res=array(
			'name'=>$nav['name'],
			'nav_id'=>$nav['nav_id'],
			'is_target'=>$nav['is_target'],
			'm_image'=>$this->model_tool_image->resize($nav['m_image'],710,320),
		);
		if ($nav['type']=='product_id') {
			$res['url']=$this->url->link('product/product', 'product_id=' . $nav['inside_id']);
		}elseif ($nav['type']=='category_id') {
			$category_path=$this->get_category_path($nav['inside_id']);
			$res['url']=$this->url->link('product/category', 'path=' .$category_path);
		}elseif ($nav['type']=='information_id') {
			$res['url']=$this->url->link('information/information', 'information_id=' . $nav['inside_id']);
		}elseif ($nav['type']=='profile_id') {
			$res['url']=$this->url->link('information/company/index', 'profile_id=' . $nav['inside_id']);
		}else{
			$res['url']=$this->url->link($nav['url']);
			// if (strstr($nav['url'], 'http')) {
			// 	$res['url']=$nav['url'];
			// }elseif ($this->config->get('config_seo_url')) {
			// 	$res['url']=$nav['seo_url'];
			// }else{
			// 	$res['url']=$nav['url'];
			// }
		}

		return $res;
	}
	protected function get_navs()
	{
		// print_r($_SERVER);exit();
		$res=array();
		$this->load->model('common/nav');
		$navs=$this->model_common_nav->getFiristNavs();
		//print_r($navs);exit();
		foreach ($navs as $key => $value) {
			$childs=array();
			$child=$this->model_common_nav->getChildNavs($value['nav_id']);
			// print_r($child);exit();
			foreach ($child as $k => $val) {
				$childs[]=$this->handleNav($val);
			}
			//print_r($childs);exit();
			$nav=$this->handleNav($value);
			// if ($this->is_thispage($nav)) {
			// 	$nav['this_page']=true;
			// }else{$nav['this_page']=false;}
			$res[$key]=$nav;
			$res[$key]['child']=$childs;
		}
// print_r($res);exit;
		return $res;
	}
	
}
