<?php
class ControllerCatalogCustomershare extends Controller {
	private $error = array();

    public function index() {
        $this->load->language('catalog/product');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/customer_share');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $data = [];
            $data = $this->request->post;
//            var_dump($data['product_image']);die;

            $this->load->model('tool/image');
            if (!isset($data['product_image'])) {
                $data['product_image'] = array();
            }else{
                foreach ($data['product_image'] as $result) {
                    if (is_file(DIR_IMAGE . $result['image'])) {
                        $image = $this->model_tool_image->resize($data['image'], 40, 40);
                        $image = $this->model_tool_image->resize($data['image'], 200, 200);
                        $image = $this->model_tool_image->resize($data['image'], 700, 700);
                    }
                }

            }
            if (is_file(DIR_IMAGE . $data['image'])) {
                $image = $this->model_tool_image->resize($data['image'], 228, 228);
                $image = $this->model_tool_image->resize($data['image'], 700, 700);
                $image = $this->model_tool_image->resize($data['image'], 200, 200);
                $image = $this->model_tool_image->resize($data['image'], 47, 47);
                $image = $this->model_tool_image->resize($data['image'], 90, 90);
            }


            //获取路由参数
            $doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
            $done="editShareImage:ID=".$data['product_id'];
            //调用父类Controller的方法将操作记录添加入库
            $this->addUserDone($doneUrl,$done);

            $this->session->data['success'] = $this->language->get('text_success');


            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
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

            $this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('catalog/product');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/customer_share');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $data = [];
            $data = $this->request->post;
            $result = $this->model_catalog_customer_share->addShareImage($data);
//            var_dump($data);die;

            $this->load->model('tool/image');
            if (!isset($data['product_image'])) {
                $data['product_image'] = array();
            }else{
                foreach ($data['product_image'] as $result) {
                    if (is_file(DIR_IMAGE . $result['image'])) {
                        $image = $this->model_tool_image->resize($data['image'], 40, 40);
                        $image = $this->model_tool_image->resize($data['image'], 200, 200);
                        $image = $this->model_tool_image->resize($data['image'], 700, 700);
                    }
                }

            }
            if (is_file(DIR_IMAGE . $data['image'])) {
                $image = $this->model_tool_image->resize($data['image'], 228, 228);
                $image = $this->model_tool_image->resize($data['image'], 700, 700);
                $image = $this->model_tool_image->resize($data['image'], 200, 200);
                $image = $this->model_tool_image->resize($data['image'], 47, 47);
                $image = $this->model_tool_image->resize($data['image'], 90, 90);
            }


            //获取路由参数
            $doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
            $done="editProduct:ID=".$data['product_id'];
            //调用父类Controller的方法将操作记录添加入库
            $this->addUserDone($doneUrl,$done);

            $this->session->data['success'] = $this->language->get('text_success');


            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }
            $this->getForm();
        }

    }

    protected function getForm() {
        $data['heading_title'] = '商品用户图管理';

        $data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : '编辑商品用户图';
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_plus'] = $this->language->get('text_plus');
        $data['text_minus'] = $this->language->get('text_minus');
        $data['text_default'] = $this->language->get('text_default');
        $data['text_option'] = $this->language->get('text_option');
        $data['text_option_value'] = $this->language->get('text_option_value');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_percent'] = $this->language->get('text_percent');
        $data['text_amount'] = $this->language->get('text_amount');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_description'] = $this->language->get('entry_description');
        $data['entry_m_description'] = $this->language->get('entry_m_description');  //M端产品描述
        $data['entry_meta_title'] = $this->language->get('entry_meta_title');
        $data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
        $data['entry_keyword'] = $this->language->get('entry_keyword');
        $data['entry_model'] = $this->language->get('entry_model');
        $data['entry_minimum'] = $this->language->get('entry_minimum');
        $data['entry_shipping'] = $this->language->get('entry_shipping');
        $data['entry_date_available'] = $this->language->get('entry_date_available');
        $data['entry_quantity'] = $this->language->get('entry_quantity');
        $data['entry_stock_status'] = $this->language->get('entry_stock_status');
        $data['entry_price'] = $this->language->get('entry_price');
        $data['entry_tax_class'] = $this->language->get('entry_tax_class');
        $data['entry_points'] = $this->language->get('entry_points');
        $data['entry_option_points'] = $this->language->get('entry_option_points');
        $data['entry_subtract'] = $this->language->get('entry_subtract');
        $data['entry_weight_class'] = $this->language->get('entry_weight_class');
        $data['entry_weight'] = $this->language->get('entry_weight');
        $data['entry_dimension'] = $this->language->get('entry_dimension');
        $data['entry_length_class'] = $this->language->get('entry_length_class');
        $data['entry_length'] = $this->language->get('entry_length');
        $data['entry_width'] = $this->language->get('entry_width');
        $data['entry_height'] = $this->language->get('entry_height');
        $data['entry_image'] = $this->language->get('entry_image');
        $data['entry_additional_image'] = $this->language->get('entry_additional_image');
        $data['entry_store'] = $this->language->get('entry_store');
        $data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
        $data['entry_download'] = $this->language->get('entry_download');
        $data['entry_category'] = $this->language->get('entry_category');
        $data['entry_filter'] = $this->language->get('entry_filter');
        $data['entry_related'] = $this->language->get('entry_related');
        $data['entry_attribute'] = $this->language->get('entry_attribute');
        $data['entry_text'] = $this->language->get('entry_text');
        $data['entry_option'] = $this->language->get('entry_option');
        $data['entry_option_value'] = $this->language->get('entry_option_value');
        $data['entry_required'] = $this->language->get('entry_required');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_is_home'] = $this->language->get('entry_is_home');
        $data['entry_free_postage'] = $this->language->get('entry_free_postage');
        $data['entry_date_start'] = $this->language->get('entry_date_start');
        $data['entry_date_end'] = $this->language->get('entry_date_end');
        $data['entry_priority'] = $this->language->get('entry_priority');
        $data['entry_tag'] = $this->language->get('entry_tag');
        $data['entry_customer_group'] = $this->language->get('entry_customer_group');
        $data['entry_reward'] = $this->language->get('entry_reward');
        $data['entry_layout'] = $this->language->get('entry_layout');
        $data['entry_percent'] = $this->language->get('entry_percent');
        $data['entry_sync_percent'] = $this->language->get('entry_sync_percent');

        $data['help_points'] = $this->language->get('help_points');
        $data['help_category'] = $this->language->get('help_category');
        $data['help_tag'] = $this->language->get('help_tag');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_image_add'] = $this->language->get('button_image_add');
        $data['button_remove'] = $this->language->get('button_remove');

        $data['tab_data'] = $this->language->get('tab_data');
        $data['tab_image'] = $this->language->get('tab_image');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
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

        if (isset($this->request->get['filter_name'])) {
            $data['filter_name'] = $this->request->get['filter_name'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => '商品用户图管理',
            'href' => $this->url->link('catalog/customershare', 'token=' . $this->session->data['token'], true)
        );

//        $data['action'] = $this->url->link('catalog/customershare/edit', 'token=' . $this->session->data['token'], true);

        $data['cancel'] = $this->url->link('catalog/customershare', 'token=' . $this->session->data['token'], true);

        if (isset($this->request->get['product_id'])) {
            $product_info = $this->model_catalog_customer_share->getProductShare($this->request->get['product_id']);
            $data['product_id'] = $this->request->get['product_id'];
        }

        $data['token'] = $this->session->data['token'];

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();
//        $data['languages'] = $this->model_localisation_language->getLanguages(array('store'=>'hotbeautyhairmall'),$this->config->get("config_language_id"));//此处config_language_id取前台数据,但是取的数据为3,有bug,只能写死
//		$data['languages'] = $this->model_localisation_language->getLanguages(array('store'=>'hotbeautyhairmall'),1);
        $data['language_default_id'] = $this->config->get('config_language_id');

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($product_info)) {
            $data['status'] = $product_info['status'];
        } else {
            $data['status'] = true;
        }

        //是否首页显示
        if (isset($this->request->post['is_home'])) {
            $data['is_home'] = $this->request->post['is_home'];
        } elseif (!empty($product_info)) {
            $data['is_home'] = $product_info['is_home'];
        } else {
            $data['is_home'] = true;
        }

        // Categories
//        $this->load->model('catalog/category');
//
//        if (isset($this->request->post['product_category'])) {
//            $categories = $this->request->post['product_category'];
//        } elseif (isset($this->request->get['product_id'])) {
//            $categories = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
//        } else {
//            $categories = array();
//        }
//
//        $data['product_categories'] = array();
//
//        foreach ($categories as $category_id) {
//            $category_info = $this->model_catalog_category->getCategory($category_id);
//
//            if ($category_info) {
//                $data['product_categories'][] = array(
//                    'category_id' => $category_info['category_id'],
//                    'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
//                );
//            }
//        }

        // product_image and image
        $this->load->model('tool/image');
        $data['image'] = '';
        $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        $data['product_images'] = array();
        if(isset($this->request->post['product_id'])){
            $images = $this->getProductImage($this->request->post['product_id']);
            $data['product_images'] = $images['product_images'];
            $data['image'] = $images['image'];
            $data['thumb'] = $images['thumb'];
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/customershare_form', $data));
    }

    public function getProductImage($product_id=''){
        $this->load->model('catalog/customer_share');
        $product_info = $this->model_catalog_customer_share->getProductShare($this->request->get['product_id'])[0];
//        var_dump($product_info);
        if (isset($this->request->post['image'])) {
            $data['image'] = $this->request->post['image'];
        } else {
            $data['image'] = $product_info['image'];
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($product_info) && is_file(DIR_IMAGE . $product_info['image'])) {
            $data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        if (isset($this->request->post['product_image'])) {
            $product_images = $this->request->post['product_image'];
        } elseif (isset($this->request->get['product_id'])) {
//            var_dump($this->request->get['product_id']);
            $product_images = $this->model_catalog_customer_share->getProductImages($this->request->get['product_id']);
        } elseif ($product_id){
            $product_images = $this->model_catalog_customer_share->getProductImages($product_id);
        } else{
            $product_images = array();
        }

        $data['product_images'] = array();
        foreach ($product_images as $product_image) {
            if (is_file(DIR_IMAGE . $product_image['image'])) {
                $image = $product_image['image'];
                $thumb = $product_image['image'];
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }

            $data['product_images'][] = array(
                'image'      => $image,
                'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
                'sort_order' => $product_image['sort_order']
            );
        }
        if($product_id) return $data;
        else $this->response->setOutput(json_encode($data));
    }

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/customershare')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/customershare')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('setting/store');

		foreach ($this->request->post['selected'] as $profile_id) {
			if ($this->config->get('config_account_id') == $profile_id) {
				$this->error['warning'] = $this->language->get('error_account');
			}

			if ($this->config->get('config_checkout_id') == $profile_id) {
				$this->error['warning'] = $this->language->get('error_checkout');
			}

			if ($this->config->get('config_affiliate_id') == $profile_id) {
				$this->error['warning'] = $this->language->get('error_affiliate');
			}

			if ($this->config->get('config_return_id') == $profile_id) {
				$this->error['warning'] = $this->language->get('error_return');
			}

			$store_total = $this->model_setting_store->getTotalStoresByProfileId($profile_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
			}
		}

		return !$this->error;
	}
}