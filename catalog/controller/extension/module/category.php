<?php
class ControllerExtensionModuleCategory extends Controller {
	public function index() {
		$this->load->language('extension/module/category');

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		//子类的子类(第三级)
		if (isset($parts[2])) {
			$data['child_sub_id'] = $parts[2];
		} else {
			$data['child_sub_id'] = 0;
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

        //读取父类
		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			$children_data = array();

			if ($category['category_id'] == $data['category_id']) {    //父类的ID = path的第一个参数
				$children = $this->model_catalog_category->getCategories($category['category_id']); //读取子类

				foreach($children as $child) {

					$children_sub_data = array();   //子类下面的子类(第三级)

                    //读取子类下面的子类(第三级)
				    $children_sub = $this->model_catalog_category->getCategories($child['category_id']);
                    if(!empty($children_sub)){
                       foreach($children_sub as $k => $child_sub){
                       	  $filter_data = array('filter_category_id' => $child_sub['category_id'], 'filter_sub_category' => true);
                          $children_sub_data[] = array(
							 'category_id' => $child_sub['category_id'],
							 'name' => $child_sub['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
							 'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $child_sub['category_id'])
						  );
                       }
                    }
                    //读取子类下面的子类(第三级),end

                    //第二级分类
                    $filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);
					$children_data[] = array(
						'category_id' => $child['category_id'],
						'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id']),

                        'children_sub_data' => $children_sub_data     //子类的子类
					);
					//第二级分类,end

				}
			}

            //父类
			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);

			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}

		return $this->load->view('extension/module/category', $data);
	}
}