<?php
/**
 * 导入商品数据处理核心类
 * @author Poly
 */
static $config = NULL;
static $log = NULL;

class ModelToolImportXls extends Model
{
    /**
     * 获取商品导入配置信息
     */
    public function get_config_columns()
    {        
        $columns = array();
        $columns[] = array(
            'title' => '*Model',//显示名
            'name' => 'model',//表属性名
            'config' => 'import_xls_column_model',//配置名
            'required' => true,//是否必填
            'default' => '<b>Required</b>',//默认值
        );
        $columns[] = array(
            'title' => '*Name',
            'name' => 'name',
            'config' => 'import_xls_column_name',
            'required' => true,
            'default' => '<b>Required</b>',
        );
        $columns[] = array(
            'title' => '*Description',
            'name' => 'description',
            'config' => 'import_xls_column_description',
            'required' => true,
            'default' => '<b>Required</b>',
        );
        $columns[] = array(
            'title' => '*M_Description',
            'name' => 'm_description',
            'config' => 'import_xls_column_m_description',
            'required' => true,
            'default' => '<b>Required</b>',
        );
        $columns[] = array(
            'title' => 'Meta title',
            'name' => 'meta_title',
            'config' => 'import_xls_column_meta_title',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Meta keywords',
            'name' => 'meta_keywords',
            'config' => 'import_xls_column_meta_keywords',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Meta description',
            'name' => 'meta_description',
            'config' => 'import_xls_column_meta_description',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Tags',
            'name' => 'tag',
            'config' => 'import_xls_column_tags',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Price',
            'name' => 'price',
            'config' => 'import_xls_column_price',
            'required' => false,
            'default' => '0',
        );
        $columns[] = array(
            'title' => 'Quantity',//商品数量
            'name' => 'quantity',
            'config' => 'import_xls_column_quantity',
            'required' => false,
            'default' => '1000',
        );
        $columns[] = array(
            'title' => 'Relation product',//关联商品
            'name' => 'relation_product',
            'config' => 'import_xls_column_relation_product',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Is Main',//主商品
            'name' => 'is_main',
            'config' => 'import_xls_column_is_main',
            'required' => false,
            'default' => '0',
        );
        $columns[] = array(
            'title' => 'Is New',//新品
            'name' => 'is_new',
            'config' => 'import_xls_column_is_new',
            'required' => false,
            'default' => '0',
        );
        $columns[] = array(
            'title' => 'Free Postage',//免邮
            'name' => 'free_postage',
            'config' => 'import_xls_column_free_postage',
            'required' => false,
            'default' => '0',
        );
        $columns[] = array(
            'title' => 'Color',
            'name' => 'color',
            'config' => 'import_xls_column_color',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Length',
            'name' => 'length',
            'config' => 'import_xls_column_length',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Weight',
            'name' => 'weight',
            'config' => 'import_xls_column_weight',
            'required' => false,
            'default' => '0.000000',
        );
        $columns[] = array(
            'title' => 'Category',
            'name' => 'category',
            'config' => 'import_xls_column_category',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Main image',//主图
            'name' => 'image',
            'config' => 'import_xls_column_main_image',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Images',
            'name' => 'images',
            'config' => 'import_xls_column_images',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Application',
            'name' => 'Application',
            'config' => 'import_xls_column_application',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Feature',
            'name' => 'Feature',
            'config' => 'import_xls_column_feature',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Grade',
            'name' => 'Grade',
            'config' => 'import_xls_column_grade',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Material',
            'name' => 'Material',
            'config' => 'import_xls_column_material',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Volume',
            'name' => 'Volume',
            'config' => 'import_xls_column_volume',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Texture',
            'name' => 'Texture',
            'config' => 'import_xls_column_texture',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'SEO url',
            'name' => 'seo_url',
            'config' => 'import_xls_column_seo_url',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Date available',//商品上架时间
            'name' => 'date_available',
            'config' => 'import_xls_column_date_available',
            'required' => false,
            'default' => 'Empty',
        );
        $columns[] = array(
            'title' => 'Points',//积分
            'name' => 'points',
            'config' => 'import_xls_column_points',
            'required' => false,
            'default' => '0',
        );
        $columns[] = array(
            'title' => 'Sort order',//排序
            'name' => 'sort_order',
            'config' => 'import_xls_column_sort_order',
            'required' => false,
            'default' => '1000',
        );
        $columns[] = array(
            'title' => 'Status',
            'name' => 'status',
            'config' => 'import_xls_column_status',
            'required' => false,
            'default' => '1',
        );
        $columns[] = array(
            'title' => 'Store',//店铺
            'name' => 'store_id',
            'config' => 'import_xls_column_store',
            'required' => false,
            'default' => '0',
        );
        
        return $columns;
    }

    /**
     * 导入商品入口
     * @param file $filename
     */
    public function func_1_upload($filename)
    {
        global $config;
        global $log;
        $config = $this->config;
        $log = $this->log;
        set_error_handler('error_handler_for_export', E_ALL);
        register_shutdown_function('fatal_error_shutdown_handler_for_export');
        $database = & $this->db;
        ini_set("memory_limit", "512M");
        ini_set("max_execution_time", 180);
        // set_time_limit( 60 );
        chdir('../system/PHPExcel');
        require_once ('Classes/PHPExcel.php');
        chdir('../../admin');
        $inputFileType = PHPExcel_IOFactory::identify($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $reader = $objReader->load($filename);
        
        // Validate numbers columns, columns name.
        $array_return = $this->func_2_configColumns($reader);
        if ($array_return['error']) {
            return $array_return;
        }
        // END Validate numbers columns, columns name.
        
        $ok = $this->func_4_begin_upload($reader, $database);
        if ($ok['error']) {
            return $ok;
        }
        
        chdir('../../..');
        return true;
    }

    /**
     * 忽略行判断过滤，数据格式验证
     * @param reader $reader
     * @return array
     */
    public function func_2_configColumns(&$reader)
    {
        $columns = $this->get_config_columns();
        $columns_name = array();
        
        foreach ($columns as $key => $value) {
            if ($this->config->get($value['config']) != 'on')
                array_push($columns_name, $value['title']);
        }
        
        $data = & $reader->getSheet(0);
        
        return $this->func_3_validateColumns($data, $columns_name);
    }

    /**
     * 数据格式验证
     * @param array $data
     * @param array $expected
     * @return array
     */
    public function func_3_validateColumns(&$data, &$expected)
    {
        $array_return = array(
            'error' => 0,
            'message' => ''
        );
        $heading = array();
        $k = PHPExcel_Cell::columnIndexFromString($data->getHighestColumn());
        
        // The name of column in excel file not equal from config
        if ($k != count($expected)) {
            $array_return['error'] = true;
            $array_return['message'] = sprintf($this->language->get('error_columns_number'), $k, count($expected));
        }
        
        if (! $array_return['error']) {
            $i = 0;
            for ($j = 1; $j <= $k; $j += 1) {
                $heading[] = $this->getCell($data, $i, $j);
            }
            
            for ($i = 0; $i < count($expected); $i += 1) {
                if (strtolower($heading[$i]) != strtolower($expected[$i])) {
                    $array_return['error'] = true;
                    $array_return['message'] = sprintf($this->language->get('error_column_name'), $heading[$i], $expected[$i]);
                    break;
                }
            }
        }
        
        return $array_return;
    }

    /**
     * 数据格式无误，格式化数据结构，导入数据
     * @param reader $reader
     * @param db $database
     * @return boolean
     */
    public function func_4_begin_upload(&$reader, &$database)
    {
        $products = $categories = array();        
        $worksheet = $reader->getSheet(0);
        
        foreach ($worksheet->getRowIterator() as $row) {
            // Blink title
            if ($row->getRowIndex() == 1) continue;//跳过标题行
            
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
            
            $product = $option = $category = array();
            $positions = array(
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
                'K',  'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
                'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD',
                'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN',
                /* 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX',
                'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH',
                'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR',
                'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ', 'CA', 'CB',
                'CC', 'CD','CE' */
            );
            
            $columns = $this->get_config_columns();
            $pos = 0;
            foreach ($columns as $key => $value) {
                if ($this->config->get($value['config']) != 'on') {
                    $product[$value['name']] = str_replace("'", '"', trim($worksheet->getCell($positions[$pos] . $row->getRowIndex())
                        ->getCalculatedValue()));
                    $pos ++;
                } else
                    $product[$value['name']] = "";
            }
            
            // product color、length
            $this->load->model('tool/import_product');
            $product['length_id'] = $product['color_id'] = 0;
            if (! empty($product['color'])) {
                $colorData = $this->model_tool_import_product->getOptionValueId('color', $product['color']);
                if ($colorData) {
                    $product['color_id'] = $colorData['option_value_id'];
                    // Add option
                    $optionData = $this->model_tool_import_product->getOptionDes('Color');
                    if ($optionData) {
                        $option[] = array(
                            'option' => 'Color',
                            'option_id' => $optionData['option_id'],
                            'option_type' => $optionData["type"],
                            'option_value' => $colorData['option_value_id'],
                            'option_value_id' => 0,
                            'option_subtract' => 1
                        );
                    }
                }
            }
            if (! empty($product['length'])) {
                $lengthData = $this->model_tool_import_product->getOptionValueId('length', $product['length']);
                if ($lengthData) {
                    $product['length_id'] = $lengthData['option_value_id'];
                    // Add option
                    $optionData = $this->model_tool_import_product->getOptionDes('Length');
                    if ($optionData) {
                        $option[] = array(
                            'option' => 'Length',
                            'option_id' => $optionData['option_id'],
                            'option_type' => $optionData["type"],
                            'option_value' => $lengthData['option_value_id'],
                            'option_value_id' => 0,
                            'option_subtract' => 1
                        );
                    }
                }
            }
            $product['length'] = 0;
            
            // Add option
            if (! empty($product['Application'])) {
                $optionData = $this->model_tool_import_product->getOptionDes('Application');
                if ($optionData) {
                    $option[] = array(
                        'option' => 'Application',
                        'option_id' => $optionData['option_id'],
                        'option_type' => $optionData["type"],
                        'option_value' => $product["Application"],
                        'option_value_id' => 0,
                        'option_subtract' => 1
                    );
                }
            }
            if (! empty($product['Feature'])) {
                $optionData = $this->model_tool_import_product->getOptionDes('Feature');
                if ($optionData) {
                    $option[] = array(
                        'option' => 'Feature',
                        'option_id' => $optionData['option_id'],
                        'option_type' => $optionData["type"],
                        'option_value' => $product["Feature"],
                        'option_value_id' => 0,
                        'option_subtract' => 1
                    );
                }
            }
            if (! empty($product['Grade'])) {
                $optionData = $this->model_tool_import_product->getOptionDes('Grade');
                if ($optionData) {
                    $option[] = array(
                        'option' => 'Grade',
                        'option_id' => $optionData['option_id'],
                        'option_type' => $optionData["type"],
                        'option_value' => $product["Grade"],
                        'option_value_id' => 0,
                        'option_subtract' => 1
                    );
                }
            }
            if (! empty($product['Material'])) {
                $optionData = $this->model_tool_import_product->getOptionDes('Material');
                if ($optionData) {
                    $option[] = array(
                        'option' => 'Material',
                        'option_id' => $optionData['option_id'],
                        'option_type' => $optionData["type"],
                        'option_value' => $product["Material"],
                        'option_value_id' => 0,
                        'option_subtract' => 1
                    );
                }
            }
            if (! empty($product['Texture'])) {
                $optionData = $this->model_tool_import_product->getOptionDes('Texture');
                if ($optionData) {
                    $option[] = array(
                        'option' => 'Texture',
                        'option_id' => $optionData['option_id'],
                        'option_type' => $optionData["type"],
                        'option_value' => $product["Texture"],
                        'option_value_id' => 0,
                        'option_subtract' => 1
                    );
                }
            }
            if (! empty($product['Volume'])) {
                $optionData = $this->model_tool_import_product->getOptionDes('Volume');
                if ($optionData) {
                    $option[] = array(
                        'option' => 'Volume',
                        'option_id' => $optionData['option_id'],
                        'option_type' => $optionData["type"],
                        'option_value' => $product["Volume"],
                        'option_value_id' => 0,
                        'option_subtract' => 1
                    );
                }
            }
            $product['options'] = $option;
            
            // Add categories
            if (! empty($product['category'])) {
                $category = $product['category'];
                $categories[$category] = $category;
            }
            
            $product['category'] = $category;
            $products[] = $product;
        }
        
        // Validate products in excel file
        $validate_products = $this->func_5_validateProductsData($products);
        if ($validate_products['error'])
            return $validate_products;
        
        // create not exist categories
        if(!empty($categories)) $this->create_categories($categories, $database);
        
        // Format products
        $final_products = $this->format_products($products);
        
        return $this->func_11_import_products($database, $final_products);
    }

    /**
     * 产品数据结构验证
     * @param array $products
     * @return array
     */
    public function func_5_validateProductsData($products)
    {
        $array_return = array(
            'error' => 0,
            'message' => ''
        );
        
        foreach ($products as $key => $value) {
            // Test repeat categories
            if (empty($value['name'])) {
                $array_return['error'] = 1;
                $array_return['message'] = sprintf($this->language->get('error_name'), ($key + 2));
                return $array_return;
            }
            
            if ($value['description'] == "") {
                $array_return['error'] = 1;
                $array_return['message'] = sprintf($this->language->get('error_description'), ($key + 2));
                return $array_return;
            }
            
            if ($value['m_description'] == "") {
                $array_return['error'] = 1;
                $array_return['message'] = sprintf($this->language->get('error_description'), ($key + 2));
                return $array_return;
            }
            
            if (empty($value['model'])) {
                $array_return['error'] = 1;
                $array_return['message'] = sprintf($this->language->get('error_model'), ($key + 2));
                return $array_return;
            }
            
            // Test options
            if (! empty($value['option']) || ! empty($value['option_type']) || ! empty($value['option_value'])) {
                if (empty($value['option']) || empty($value['option_type']) || empty($value['option_value'])) {
                    $array_return['error'] = 1;
                    $array_return['message'] = sprintf($this->language->get('error_options'), ($key + 2));
                    return $array_return;
                } else {
                    if (($value['option_type'] == "select") || ($value['option_type'] == "radio") || ($value['option_type'] == "checkbox") || ($value['option_type'] == "image")) {
                        // Option type correct
                    } else {
                        $array_return['error'] = 1;
                        $array_return['message'] = sprintf($this->language->get('error_options_type'), ($key + 2));
                        return $array_return;
                    }
                }
            }
        }
        return $array_return;
    }

    /**
     * 执行商品导入
     * @param DB $database
     * @param array $products
     * @return boolean
     */
    public function func_11_import_products($database, $products)
    {
        $products = $this->clean($products);
        $this->load->model('catalog/product');
        $this->load->model('tool/import_product');
        set_time_limit(300);
        
        foreach ($products as $product) {
            // Option value id have to consecutive 0 - 1 - 2
            $count_ov = 0;
            foreach ($product['product_option'] as $key => $product_option) {
                $temp = array();
                foreach ($product_option['product_option_value'] as $key2 => $value) {
                    $temp[$count_ov] = $value;
                    $count_ov ++;
                }
                $product['product_option'][$key]['product_option_value'] = $temp;
            }
            // END Option value id have to consecutive 0 - 1 - 2
            
            // 检查产品是否存在
            $productData = $this->model_tool_import_product->getProductID($product['model']);
            
            if ($productData) {
                $this->model_catalog_product->editProduct($productData['product_id'], $product);
            } else {
                $this->model_catalog_product->addProduct($product);
            }
        }
        return TRUE;
    }

    public function getCell(&$worksheet, $row, $col, $default_val = '')
    {
        $col -= 1; // we use 1-based, PHPExcel uses 0-based column index
        $row += 1; // we use 0-based, PHPExcel used 1-based row index
        return ($worksheet->cellExistsByColumnAndRow($col, $row)) ? $worksheet->getCellByColumnAndRow($col, $row)->getValue() : $default_val;
    }

    /**
     * 格式化商品信息
     * @param array $products
     */
    public function format_products($products)
    {
        // The idea in this function is create a product array EXACTLY with we send to model product to create a product.
        
        // Get all options
        $this->load->model('catalog/option');
        $all_options = $this->model_catalog_option->getOptions();

        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();
        
        $this->load->model('tool/import_product');
        
        // Get all options values
        foreach ($all_options as $key => $opt) {
            $all_options[$key]['values'] = $this->model_catalog_option->getOptionValues($opt['option_id']);
        }
        
        $final_products = array();
        
        // Group by name
        $products_group_by_name = array();
        foreach ($products as $key => &$entry) {
            $products_group_by_name[$entry['name']][$key] = $entry;
        }
        
        foreach ($products_group_by_name as $key => $gruop_products) {
            $count_products = 0;
            
            foreach ($gruop_products as $key_2 => $pro) {
                if ($count_products == 0) {
                    $pro_first = $pro;
                    // Put all simple data: Model, upc, ean image etc... and description, attributes... Less options
                    if (empty($pro['meta_title']))
                        $pro['meta_title'] = $pro['name'];
                    
                    $final_products[$key]['product_description'] = array();
                    if(empty($pro['tags'])) $pro['tags'] = '';
                    foreach ($languages as $key_lang => $lng) {
                        $final_products[$key]['product_description'][$lng['language_id']] = array(
                            'name' => $pro['name'],
                            'meta_description' => $pro['meta_description'],
                            'meta_keyword' => $pro['meta_keywords'],
                            'meta_title' => $pro['meta_title'],
                            'description' => str_replace("_x000D_", "", $pro['description']), // dyl 将excel里description的_x000D_替换掉
                            'm_description' => str_replace("_x000D_", "", $pro['m_description']),
                            'tag' => $pro['tags'],
                        );
                    }
                    $final_products[$key]['name'] = $pro['name'];
                    $final_products[$key]['model'] = $pro['model'];
                    $final_products[$key]['price'] = $pro['price'];
                    $final_products[$key]['is_main'] = $pro['is_main'];
                    $final_products[$key]['is_new'] = $pro['is_new'];
                    $final_products[$key]['free_postage'] = $pro['free_postage'];
                    $final_products[$key]['product_tag'] = $pro['tags'];
                    
                    //无用属性 startTODO
                    $final_products[$key]['sku'] = '';
                    $final_products[$key]['discount_percentage'] = '';
                    $final_products[$key]['upc'] = '';
                    $final_products[$key]['ean'] = '';
                    $final_products[$key]['jan'] = '';
                    $final_products[$key]['isbn'] = '';
                    $final_products[$key]['mpn'] = '';
                    $final_products[$key]['location'] = '';
                    //无用属性 end
                    
                    if (empty($pro['tax_class_id']))
                        $final_products[$key]['tax_class_id'] = 0;
                    else
                        $final_products[$key]['tax_class_id'] = $pro['tax_class_id'];
                    
                    if (empty($pro['minimum']))
                        $final_products[$key]['minimum'] = 1;
                    else
                        $final_products[$key]['minimum'] = $pro['minimum'];
                    
                    if (empty($pro['stock_status_id']))
                        $final_products[$key]['stock_status_id'] = 7;
                    else
                        $final_products[$key]['stock_status_id'] = $pro['stock_status_id'];
                    
                    if (empty($pro['shipping']) || $pro['shipping'] != 0)
                        $final_products[$key]['shipping'] = 1;
                    else
                        $final_products[$key]['shipping'] = 0;
                    
                    if (empty($pro['seo_url']))
                        $final_products[$key]['keyword'] = Common::formatSeoUrl($pro['name']);
                    else
                        $final_products[$key]['keyword'] = $pro['seo_url'];
                        
                    // 上传主图
                    if (!empty($pro['image'])) {
                        $final_products[$key]['image'] = 'catalog' . $pro['image'];
                        if (file_exists(DIR_IMAGE . 'original' . $pro['image'])) {
                            $image_dir = explode('/', $pro['image']);
                            
                            unset($image_dir[0]);
                            array_pop($image_dir);
                            
                            $des = DIR_IMAGE . 'catalog';
                            foreach ($image_dir as $row_des) {
                                $des .= '/' . $row_des;
                                @mkdir($des, 0777);
                            }
                            copy(DIR_IMAGE . 'original' . $pro['image'], DIR_IMAGE . 'catalog' . $pro['image']);
                        }
                    }
                    if (empty($pro['date_available']))
                        $final_products[$key]['date_available'] = '';
                    else 
                        $final_products[$key]['date_available'] = $pro['date_available'];
                    
                    // add color_id and length_id
                    /* if (empty($pro['color_id']))
                        $final_products[$key]['color_id'] = 0;
                    else
                        $final_products[$key]['color_id'] = $pro['color_id'];
                    
                    if (empty($pro['length_id']))
                        $final_products[$key]['length_id'] = 0;
                    else
                        $final_products[$key]['length_id'] = $pro['length_id']; */
                    
                    if (empty($pro['quantity_id']))
                        $final_products[$key]['quantity_id'] = 0;
                    else
                        $final_products[$key]['quantity_id'] = $pro['quantity_id'];
                        
                    // add relation product
                    $final_products[$key]['relation_product'] = $pro['relation_product'];
                    
                    if (empty($pro['length']))
                        $final_products[$key]['length'] = 0.00000000;
                    else
                        $final_products[$key]['length'] = $pro['length'];
                    
                    if (empty($pro['width']))
                        $final_products[$key]['width'] = 0.00000000;
                    else
                        $final_products[$key]['width'] = $pro['width'];
                    
                    if (empty($pro['height']))
                        $final_products[$key]['height'] = 0.00000000;
                    else
                        $final_products[$key]['height'] = $pro['height'];
                    
                    if (! empty($pro['length_class_id']))
                        $final_products[$key]['length_class_id'] = $pro['length_class_id'];
                    else
                        $final_products[$key]['length_class_id'] = 1;
                    
                    if (! empty($pro['weight_class_id']))
                        $final_products[$key]['weight_class_id'] = $pro['weight_class_id'];
                    else if (! empty($this->config->get('config_weight_class_id')))
                        $final_products[$key]['weight_class_id'] = $this->config->get('config_weight_class_id');
                    else
                        $final_products[$key]['weight_class_id'] = 2; // g
                    
                    if (empty($pro['status']) || $pro['status'] != 0)
                        $final_products[$key]['status'] = 1;
                    else
                        $final_products[$key]['status'] = 0;
                    
                    if (empty($pro['sort_order']))
                        $final_products[$key]['sort_order'] = 1000;
                    else
                        $final_products[$key]['sort_order'] = $pro['sort_order'];
                    
                    $final_products[$key]['manufacturer'] = '';
                    $final_products[$key]['manufacturer_id'] = 0;
                    
                    $final_products[$key]['category'] = '';
                    
                    $array_categories = array();
                    $array_categories = $this->get_category_id($pro['category']);
                    $final_products[$key]['product_category'] = $array_categories;
                    
                    $final_products[$key]['filter'] = '';
                    
                    if (empty($pro['store_id']))
                        $pro['store_id'] = 0;
                    $final_products[$key]['product_store'] = array(
                        0 => $pro['store_id']
                    );
                    if (empty($pro['layout'])) $pro['layout'] = 0;
                    $final_products[$key]['product_layout'][$pro['store_id']] = $pro['layout'];
                    
                    $final_products[$key]['download'] = '';
                    $final_products[$key]['related'] = '';
                    
                    if (! empty($pro['weight']))
                        $final_products[$key]['weight'] = $pro['weight'];
                    else
                        $final_products[$key]['weight'] = '0.00000000';
                        
                    // 修改quantity默认为1000
                    if (! empty($pro['quantity']))
                        $final_products[$key]['quantity'] = $pro['quantity'];
                    else
                        $final_products[$key]['quantity'] = 1000;
                    
                    if (empty($pro['subtract']) || $pro['subtract'] != 0)
                        $final_products[$key]['subtract'] = 1;
                    else
                        $final_products[$key]['subtract'] = 0;
                    
                    $final_products[$key]['option'] = '';
                    $final_products[$key]['product_option'] = ''; // Empty to set the same order that original array.
                    
                    /* Images */
                    $array_images = array();
                    $imagelist = array();
                    $sort_order = 0;
                    if (! empty($pro['images'])) {
                        $imagelist = explode(';', $pro['images']);
                        foreach ($imagelist as $row) {
                            $array_images[] = array(
                                'image' => 'catalog' . $row,
                                'sort_order' => $sort_order
                            );
                            $sort_order ++;
                            if (file_exists(DIR_IMAGE . 'original' . $row)) {
                                $image_dir = explode('/', $row);
                                
                                unset($image_dir[0]);
                                array_pop($image_dir);
                                $des = DIR_IMAGE . 'catalog';
                                foreach ($image_dir as $row_des) {
                                    $des .= '/' . $row_des;
                                    @mkdir($des, 0777);
                                }
                                copy(DIR_IMAGE . 'original' . $row, DIR_IMAGE . 'catalog' . $row);
                            }
                        }
                    }
                    if (! empty($array_images))
                        $final_products[$key]['product_image'] = $array_images;
                    /* END Images */
                    
                    if (empty($pro['points']))
                        $final_products[$key]['points'] = 0;
                    else
                        $final_products[$key]['points'] = $pro['points'];
                    
                } // End if product
                  
                // For options
                if (isset($pro['options']) && $pro['options']) {
                    foreach ($pro['options'] as $key_op => $row_op) {
                        $product_options = array(
                            'product_option_id' => '',
                            'name' => $row_op['option'],
                            'option_id' => $row_op['option_id'],
                            'type' => $row_op['option_type'],
                            'required' => 0,
                            'product_option_value' => array()
                        );
                        
                        if ($row_op['option_value_id'] == 0) {
                            $product_options['value'] = $row_op['option_value'];
                        } else {
                            $product_options['product_option_value'][$row_op['option_value_id']] = array(
                                'option_value_id' => $row_op['option_value_id'],
                                'product_option_value_id' => '',
                                'quantity' => $pro['quantity'],
                                'subtract' => 0,
                                'price' => 0,
                                'price_prefix' => '+',
                                'points' => 0,
                                'points_prefix' => '+',
                                'weight' => 0,
                                'weight_prefix' => '+',
                                'ob_sku' => '',
                                'ob_image' => ''
                            );
                        }
                        
                        $option_found = false;
                        
                        $final_products[$key]['product_option'][] = $product_options;
                    }
                }
                
                $count_products ++;
            } // END GROUPS
              
            // Gruop options by name
            $options = $final_products[$key]['product_option'];
            $final_options = array();
            foreach ($options as $key_option => &$entry) {
                $final_options[$entry['name']][$key_option] = $entry;
            }
            
            $temp = array();
            $count_options = 0;
            
            foreach ($final_options as $opt_name => $group_options) {
                $count_int = 0;
                foreach ($group_options as $index => $opt) {
                    if ($count_int == 0) {
                        $temp[$opt_name] = $opt;
                    } else {
                        foreach ($opt['product_option_value'] as $temp_3) {
                            $temp[$opt_name]['product_option_value'][$temp_3['option_value_id']] = $temp_3;
                        }
                    }
                    $count_int ++;
                }
                $count_options ++;
            }
            // END Gruop options by name
            
            // Add groups options to final products
            $count_options = 0;
            $final_products[$key]['product_option'] = "";
            
            foreach ($temp as $value) {
                $final_products[$key]['product_option'][$count_options] = $value;
                $count_options ++;
            }
            // END Add groups options to final products
        }
        return $final_products;
    }
    
    /**
     * 根据分类名获取分类ID
     * @param array $categories
     */
    public function get_category_id($categories)
    {
        $arr = array();
        $row = explode('>', $categories);
        $parent_id = 0;
        foreach ($row as $row1) {
            $sql = "select cd.* from `" . DB_PREFIX . "category_description` cd left join `" . DB_PREFIX . "category` c on c.category_id = cd.category_id 
                where cd.name = '" . htmlspecialchars($row1) . "' and parent_id = '" . $parent_id . "' and language_id = " . (int) $this->config->get('config_language_id') . ";";
            
            $query = $this->db->query($sql);
            $result = $query->row;
            if (! $result) {
                $parent_id = 0;
                break;
            }
            $parent_id = $result['category_id'];
            $arr[] = $parent_id;
        }
        return $arr;
    }

    public function clean($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset($data[$key]);
    
                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            $data = str_replace('"', '&quot;', $data);
        }
    
        return $data;
    }
    
    /**
     * 创建商品分类
     * @param array $categories
     * @param DB $database
     * @return array
     */
    public function create_categories($categories, $database)
    {
        $array_return = array(
            'error' => 0,
            'message' => ''
        );
        foreach ($categories as $k => $v) {
            $row = explode('>', $v);
            $category_id = 0;
            foreach ($row as $value){
                $temporal_sql = "select cd.* from `" . DB_PREFIX . "category_description` cd left join `" . DB_PREFIX . "category` c on c.category_id = cd.category_id
                    where cd.name = '" . $value . "' and parent_id = '" . $category_id . "' and language_id = " . (int) $this->config->get('config_language_id') . ";";
                $result = $database->query($temporal_sql);
        
                if (empty($result->row['category_id'])) {
                    $temporal_sql = "INSERT INTO " . DB_PREFIX . "category  (`category_id`, `image`, `parent_id`, `top`, `sort_order`, `status`, `date_added`, `date_modified`)
                        VALUES ('', '', {$category_id}, 0, 100, 1, '" . date('Y-m-d h:i:s') . "', '" . date('Y-m-d h:i:s') . "');";
                    $this->db->query($temporal_sql);
                    $category_id = $this->db->getLastId();
        
                    // Create description-category
                    $temporal_sql = "INSERT INTO " . DB_PREFIX . "category_description  (`category_id`, `language_id`, `name`, `description`, `meta_description`, `meta_keyword` )
                        VALUES (" . $category_id . ", " . (int) $this->config->get('config_language_id') . ", '" . $value . "', '', '', '');";
                    $this->db->query($temporal_sql);
        
                    // Create store-category
                    $temporal_sql = "INSERT INTO " . DB_PREFIX . "category_to_store  (`category_id`, `store_id`) VALUES (" . $category_id . ", 0);";
                    $this->db->query($temporal_sql);
        
                    // Create path-category
                    $temporal_sql = "INSERT INTO `" . DB_PREFIX . "category_path` ( category_id ,  path_id, level ) VALUES ( " . $category_id . ", " . $category_id . ", 0 );";
                    $this->db->query($temporal_sql);
                }else{
                    $category_id = $result->row['category_id'];
                }
            }
        }
    
        return $array_return;
    }
    
    /**
     * 创建 options
     * @param array $options
     * @param DB $database
     * @return array
     */
    public function create_options($options, $database)
    {
        $array_return = array(
            'error' => 0,
            'message' => ''
        );
    
        foreach ($options as $key => $value) {
    
            // CREATE OPTIONS
            $temporal_sql = "SELECT * FROM " . DB_PREFIX . "option op, " . DB_PREFIX . "option_description opd WHERE opd.name = '" . $value['option'] . "' AND op.option_id = opd.option_id AND op.type = '" . $value['option_type'] . "';";
            $result = $database->query($temporal_sql);
    
            // Create option?
            if (! isset($result->row['option_id'])) {
                // FIX ORDER OPTIONS! =)
                $temporal_sql = "SELECT * FROM `" . DB_PREFIX . "option` ORDER BY sort_order DESC";
                $results = $database->query($temporal_sql);
    
                $new_order = 0;
                if ($results->num_rows != 0)
                    $new_order = $results->rows[0]['sort_order'] + 1;
    
                // Insert option
                $temporal_sql = "INSERT INTO `" . DB_PREFIX . "option` VALUES ('', '" . $value['option_type'] . "', " . $new_order . ");";
                $database->query($temporal_sql);
                $option_id = $this->db->getLastId();
    
                // Insert option description
                $temporal_sql = "INSERT INTO `" . DB_PREFIX . "option_description` VALUES (" . $option_id . ", " . (int) $this->config->get('config_language_id') . ", '" . $value['option'] . "');\n";
                $result = $database->query($temporal_sql);
            } else {
                $option_id = $result->row['option_id'];
            }
            // END CREATE OPTIONS
    
            // CREATE OPTIONS VALUE
            foreach ($value['values'] as $key => $value_name) {
                // Create value option?
    
                $temporal_sql = "SELECT * FROM `" . DB_PREFIX . "option_value_description` WHERE name = '" . $value_name['name'] . "' AND option_id = " . $option_id . ";";
                $result = $database->query($temporal_sql);
    
                if (! isset($result->row['option_value_id'])) {
                    // Create option value
                    $temporal_sql = "INSERT INTO `" . DB_PREFIX . "option_value` VALUES ('', " . $option_id . ", 'no_image.jpg', 0);";
                    $database->query($temporal_sql);
    
                    $option_value_id = $this->db->getLastId();
    
                    // Create option value description
                    $temporal_sql = "INSERT INTO `" . DB_PREFIX . "option_value_description` VALUES (" . $option_value_id . ", " . (int) $this->config->get('config_language_id') . "," . $option_id . ", '" . $value_name['name'] . "');";
                    $database->query($temporal_sql);
                }
            }
            // END CREATE OPTIONS VALUE
        }
    
        return $array_return;
    }

}

// Error Handler
function error_handler_for_export($errno, $errstr, $errfile, $errline)
{
    global $config;
    global $log;

    switch ($errno) {
        case E_NOTICE:
        case E_USER_NOTICE:
            $errors = "Notice";
            break;
        case E_WARNING:
        case E_USER_WARNING:
            $errors = "Warning";
            break;
        case E_ERROR:
        case E_USER_ERROR:
            $errors = "Fatal Error";
            break;
        default:
            $errors = "Unknown";
            break;
    }

    if (($errors == 'Warning') || ($errors == 'Unknown')) {
        return true;
    }

    if ($config->get('config_error_display')) {
        echo '<b>' . $errors . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
    }

    if ($config->get('config_error_log')) {
        $log->write('PHP ' . $errors . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
    }

    return true;
}
function fatal_error_shutdown_handler_for_export()
{
    $last_error = error_get_last();
    if ($last_error['type'] === E_ERROR) {
        // fatal error
        error_handler_for_export(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
    }
}

