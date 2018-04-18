<?php
class ControllerToolImportXls extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('tool/import_xls');
		$this->document->setTitle($this->language->get('heading_title_import'));
		$this->load->model('tool/import_xls');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			if ((isset( $this->request->files['upload'] )) && (is_uploaded_file($this->request->files['upload']['tmp_name']))) {
				$file = $this->request->files['upload']['tmp_name'];
				// Import products
				$uploaded = $this->model_tool_import_xls->func_1_upload($file);
				if ($uploaded['error']) {
					$this->error['warning'] = $uploaded['message'];
				} else {
					$this->session->data['success'] = $this->language->get('text_success');
                    $this->response->redirect($this->url->link('tool/import_xls', 'token=' . $this->session->data['token'], 'SSL'));
				}
			}else{
				$this->error['warning'] = $this->language->get('error_file_not_found');
			}
		}
		$data['token'] = $this->session->data['token'];
		$lang_array = array(
			'tab_import',
				'step_1',
					'download',
				'step_2',
					'column_removed',
					'remember_columns',
					'option_boost',
					'option_boost_compatibility',
				'step_3',
				'step_4',
					'image_upload_description',
					'buttom_upload_image',
				'step_5',
					'button_import',
					'important',
				'step_6',
					'product_product_id',
					'product_model',
					'product_name',
					'product_image',
					'product_number',
    		//Footer
    		'tab_help',
			'tab_rules'
		);
		foreach ($lang_array as $key => $value) {
			$data[$value] = $this->language->get($value);
		}

		$data['heading_title'] = $this->language->get('heading_title_import');
		$data['important'] = sprintf($this->language->get('important'), $this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL'));
		$data['not_forget'] = sprintf($this->language->get('not_forget'), $this->url->link('tool/import_xls/rules', 'token=' . $this->session->data['token'], 'SSL'));

		//Search images not found
        	$database =& $this->db;
    		$count_images=0;
    		$images_not_found= array();
    		$contador_imagenes_no_encontradas=0;
    
    		$sql = "SELECT p.product_id, p.model, p.image, pd.name FROM " . DB_PREFIX . "product as p INNER JOIN " . DB_PREFIX . "product_description AS pd ON p.product_id=pd.product_id WHERE p.status=1";
    		$result = $database->query( $sql );
    		$this->load->model('catalog/product');
    		
    		foreach($result->rows as $key => $row)
    	  	{
    			//Main image
    			if(!file_exists(DIR_IMAGE. DIRECTORY_SEPARATOR .$row["image"])){
    				$images_not_found[] = array(
    					'product_id' => $row["product_id"],
    					'model' => $row["model"],
    					'name' => $row["name"],
    					'image' => str_replace('catalog','',$row['image'])
    				);
    
    				$contador_imagenes_no_encontradas++;
    			}
    			$count_images++;
    			//Secondary images
    			$other_images = $this->model_catalog_product->getProductImages($row["product_id"]);
    			foreach ($other_images as $key => $value) {
    
    				if(!file_exists(DIR_IMAGE. DIRECTORY_SEPARATOR .$value['image'])){
    					$images_not_found[] = array(
    						'product_id' => $row["product_id"],
    						'model' => $row["model"],
    						'name' => $row["name"],
    						'image' => str_replace('catalog','',$row['image'])
    					);
    
    					$contador_imagenes_no_encontradas++;
    				}
    				$count_images++;
    			}
    		}
    		$data['count_images'] = sprintf($this->language->get('images_not_found'), $contador_imagenes_no_encontradas, $count_images);
    		$data['images_not_found'] = $images_not_found;
		//END Search images not found

		//Get columns that can be deleted
			$data['array_columns'] = $this->get_columns();
			$data['token'] = $this->session->data['token'];
			$data['action_save_columns'] = $this->url->link('tool/import_xls/save_columns', 'token=' . $this->session->data['token'], 'SSL');

		//Get options boost compatibility
			$data['import_xls_optionboost'] = $this->config->get('import_xls_optionboost');

		//Rules
			$lang_array = array(
				'rule_heading_3',
					'view_table',
				'rule_possible_values',
					'view_table_possible',
				'rule_heading_4',
					'rule_4_categories_1',
					'rule_4_categories_2',
					'rule_4_categories_3',
					'rule_4_manufacturers_1',
					'rule_4_manufacturers_2',
					'rule_4_manufacturers_3',
				'rule_heading_5',
					'rule_5_options_1',
					'rule_5_options_2',
					'rule_5_options_3',
				'rule_demo',
					'rule_demo_1',
					'rule_demo_2',
				'rule_help',
					'rule_help_1',
			);

		    //new field rule
			$this->load->model('tool/import_product');
			$data['new_rule']['Color'] = $this->model_tool_import_product->getOptionValueList('color');
		    //$data['new_rule']['lengthValue'] = $this->model_tool_import_product->getOptionValueList('length');
			$data['new_rule']['Grade'] = $this->model_tool_import_product->getOptionValueList('Grade');
			$data['new_rule']['Material'] = $this->model_tool_import_product->getOptionValueList('Material');
			$data['new_rule']['Texture'] = $this->model_tool_import_product->getOptionValueList('Texture');
			$data['new_rule']['Volume'] = $this->model_tool_import_product->getOptionValueList('Volume');
			$data['new_rule']['Quantity'] = $this->model_tool_import_product->getOptionValueList('Quantity');

			foreach ($lang_array as $key => $value) {
				$data[$value] = $this->language->get($value);
			}
			$array_default_fields = $this->get_default_values();
			$data['array_default_fields'] = $array_default_fields;

		    //Status out stock
			$sql = "SELECT * FROM " . DB_PREFIX . "stock_status WHERE language_id = ".(int)$this->config->get('config_language_id').";";
			$result = $database->query( $sql );
			$data['stock_status'] = $result->rows;

		    //Tax class
			$sql = "SELECT * FROM " . DB_PREFIX . "tax_class;";
			$result = $database->query( $sql );
			$data['tax_class'] = $result->rows;

		    //Stores
			$this->load->model('setting/store');
			$stores = array();
			$stores[0] = array(
				'store_id' => '0',
				'name' => $this->config->get('config_title')
			);
			$stores_temp = $this->model_setting_store->getStores();
			foreach ($stores_temp as $key => $value) {
				$stores[] = $value;
			}
			$data['stores'] = $stores;

		    //Weight class
			$this->load->model('localisation/weight_class');
			$data['weight_class'] = $this->model_localisation_weight_class->getWeightClasses();

		    //Lenght class
			$this->load->model('localisation/length_class');
			$data['length_class'] = $this->model_localisation_length_class->getLengthClasses();

            //Layouts
            $this->load->model('design/layout');
            $data['layouts'] = $this->model_design_layout->getLayouts();

		//END Rules

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => FALSE
		);
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title_import'),
			'href'      => $this->url->link('tool/import_xls', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$data['action'] = $this->url->link('tool/import_xls', 'token=' . $this->session->data['token'], 'SSL');
		$data['export'] = $this->url->link('tool/import_xls/download', 'token=' . $this->session->data['token'], 'SSL');
		$data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('tool/import_xls.tpl', $data));
	}

	public function download() {

		if ($this->validate()) {
			$this->redirect('view/template/tool/xls_import_products.xls');
		} else {
			// return a permission error page
			return $this->forward('error/permission');
		}
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/import_xls')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_default_values()
	{
		$this->load->language('tool/import_xls');
		$this->load->model('tool/import_xls');
		$columns = $this->model_tool_import_xls->get_config_columns();

		foreach ($columns as $k=>$v) {//设置配置值
		    $v['explain'] = $this->language->get('dfe_'.strtolower($v['name']));
		    $v['name'] = $v['title'];
		    $columns[$k] = $v;
		}

		return $columns;
	}

	public function get_columns()
	{
	    $this->load->model('tool/import_xls');
		$columns = $this->model_tool_import_xls->get_config_columns();

		foreach ($columns as $k=>$v) {//设置配置值
		    $v['name'] = $v['title'];
		    $v['input_name'] = $v['config'];
		    $v['config'] = $this->config->get($v['config']);
		    $columns[$k] = $v;
		}

		return $columns;
	}

	public function save_columns()
	{
		$this->load->language('tool/import_xls');
		$this->load->model('setting/setting');

		$this->model_setting_setting->editSetting('import_xls', $this->request->post);
		echo $this->language->get('save_columns_success');
		die();
	}
}
