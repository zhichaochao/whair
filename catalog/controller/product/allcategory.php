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
					'm_image'       => $this->model_tool_image->resize($value['m_image'],302,170),
					'name'	 		 => $value['name'],
					'href'             => $this->url->link('product/category', 'path=' . $paths)
					
				);
			 
			}
			//print_r($data['rows']);exit;
			$data['continue'] = $this->url->link('common/home');

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
	
}
