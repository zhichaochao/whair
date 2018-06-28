<?php
class ControllerCatalogProduct extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product->addProduct($this->request->post);

			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$done="addProduct:".$this->request->post['product_description'][1]['name'];
			//调用父类Controller的方法将操作记录添加入库
            $this->addUserDone($doneUrl,$done);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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

		$this->load->model('catalog/product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $data = [];
            $data = $this->request->post;
//            var_dump($data['product_image']);die;

            if (!isset($data['product_special'])) {
				$data['product_special'] = array();
			}
			if (!isset($data['product_attribute'])) {
				$data['product_attribute'] = array();
			}
			if (!isset($data['product_option'])) {
				$data['product_option'] = array();
			}
			if (!isset($data['product_discount'])) {
				$data['product_discount'] = array();
			}

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


//			不用再保存视频
			if(isset($data['files'])) unset($data['files']);

			$this->model_catalog_product->editProduct($this->request->get['product_id'], $data);

			//获取路由参数 
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$done="editProduct:ID=".$this->request->get['product_id']; 
			//调用父类Controller的方法将操作记录添加入库
            $this->addUserDone($doneUrl,$done);

			$this->session->data['success'] = $this->language->get('text_success');


			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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

	public function deleteVideo(){
        $this->load->language('catalog/product');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/product');
       // var_dump($this->request->get['product_id']);
      
        if(isset($this->request->get['product_id'])){
        	  unlink('../image/'.$this->request->get['video']); 
        $this->model_catalog_product->deleteVideo($this->request->get['product_id']);
    	}else{
    		  unlink($this->request->get['video']);
    	}
        $this->response->setOutput(json_encode('1'));
    }

	public function editVideo(){
//        $files = [];
//        $files = $this->request->post;
//        $file = $files['files'];
//        $this->response->setOutput(json_encode([1,2]));die;


        $this->load->language('catalog/product');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/product');

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
//            var_dump($_FILES['files']);

            $file = $_FILES['files'];
//            move_uploaded_file($file['tmp_name'],'upload/preview/'.$file['name']);
//formData传过来的参数param1和param2
//            $param1 = $files['param1'];
//            $param2 = $files['param2'];
//ajax返回数组
            $data = array('sta'=>TRUE,'msg'=>'上传成功！');
//检查是否为图片
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);

            $arrExt = array('3gp','rmvb','flv','wmv','avi','mkv','mp4','mp3','wav');
            if(!in_array($ext,$arrExt)) {
                $data['sta'] = FALSE;
                $data['msg'] = '不支持此类型文件的上传！';
            }else{
                $previewPath = DIR_IMAGE.'video/';
                $arr = explode('/',$previewPath);
                $dirAll = '';
                $result = FALSE;
                if(count($arr) > 0) {
                    foreach($arr as $key=>$value) {
                        $tmp = trim($value);
                        if($tmp != '') {
                            $dirAll .= $tmp.'/';
                            if(!file_exists($dirAll)) {
                                mkdir($dirAll,0777,true);
                            }
                        }
                    }
                }

                if($file['error'] == 0) {
//                if(isset($param1) && isset($param2)) {
                    //需要用到$param1和$param2的一些其他操作...

                    //文件上传到预览目录
                    if(isset($this->request->get['product_id'])){
                    $previewName = 'pre_'.$this->request->get['product_id'].'.'.$ext;
	                }else{
	                	 $previewName = 'home/pre_'.rand(1000,9000).'.'.$ext;
	                }
                    $previewSrc = 'video/'.$previewName;
                    if(!move_uploaded_file($file['tmp_name'],DIR_IMAGE.$previewSrc)) {
                        $data['sta'] = FALSE;
                        $data['msg'] = '上传失败！';
                    } else {
                    	if(isset($this->request->get['product_id'])){
                        $this->model_catalog_product->editVideo($this->request->get['product_id'],$previewSrc);
                    	}
                        $data['previewSrc'] = '../image/'.$previewSrc;
                    }

//                }
                }
            }
            $this->response->setOutput(json_encode($data));
        }
    }

	public function delete() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$result['name'][]=$this->model_catalog_product->getProduct($product_id);
				$this->model_catalog_product->deleteProduct($product_id);
			}

			//获取路由参数
			$doneUrl=isset($this->request->get['route']) ? $this->request->get['route'] : "";
			$name='';
            foreach($result['name'] as $value){
            	$name.='ID='.$value['product_id'].',name='.$value['name'].';';
            }
			$done="deleteProduct:".substr($name, 0, -1);
			//调用父类Controller的方法将操作记录添加入库
            $this->addUserDone($doneUrl,$done);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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

		$this->getList();
	}

	public function copy() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->copyProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}
		
		if(isset($this->request->get['filter_free_postage'])){
			$filter_free_postage = $this->request->get['filter_free_postage'];
		}else{
			$filter_free_postage = null;
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_relation_product'])) {
			$filter_relation_product = $this->request->get['filter_relation_product'];
		} else {
			$filter_relation_product = null;
		}

		if (isset($this->request->get['filter_image'])) {
			$filter_image = $this->request->get['filter_image'];
		} else {
			$filter_image = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.product_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if(isset($this->request->get['filter_free_postage'])){
			$url .= '&filter_free_postage=' . $this->request->get['filter_free_postage'];
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_relation_product'])) {
			$url .= '&filter_relation_product=' . $this->request->get['filter_relation_product'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['importSpecial'] = $this->url->link('catalog/product', 'act=importSpecial&token=' . $this->session->data['token'] . $url, true);
		$data['export'] = $this->url->link('catalog/product', 'act=export&token=' . $this->session->data['token'] . $url, true);
		$data['add'] = $this->url->link('catalog/product/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['copy'] = $this->url->link('catalog/product/copy', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/product/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['products'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_free_postage' => $filter_free_postage,
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'filter_relation_product'   => $filter_relation_product,
			'filter_image'    => $filter_image,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);
		if(isset($this->request->get['act'])){
		    if($this->request->get['act'] == 'importSpecial'){
		        $this->_importSpecial();//导入商品Special（特价）信息
		        return ;
		    }elseif($this->request->get['act'] == 'export'){
		        $this->_export($filter_data);//导出商品信息
		        return ;
		    }
		}

		$this->load->model('tool/image');

		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

		$results = $this->model_catalog_product->getProducts($filter_data);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$special = false;
			$percent = false;

			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);

			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
					$special = $product_special['price'];   //折后价格
					$percent = $product_special['percent'];  //商品折扣,若两者都存在优先使用商品折扣进行计算				
					
					break;
				}
			}

			$this->load->model('catalog/url_alias');
			$keyword = $this->model_catalog_url_alias->getKeyword($result['product_id']);
			
			$data['products'][] = array(
				'product_id' => $result['product_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'href'       => HTTP_CATALOG . $keyword,
				'model'      => $result['model'],
				'price'      => $result['price'],
				'special'    => $percent ? ($result['price'] * ($percent/100)) : $special,
				'free_postage' => $result['free_postage'],
				'quantity'   => $result['quantity'],
				'relation_product'   => $result['relation_product'],
				'status'     => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_free_postage'] = $this->language->get('entry_free_postage');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_free_postage'] = $this->language->get('entry_free_postage');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_relation_product'] = 'Relation Product';

		$data['button_copy'] = $this->language->get('button_copy');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

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

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_relation_product'])) {
			$url .= '&filter_relation_product=' . $this->request->get['filter_relation_product'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
		$data['sort_model'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, true);
		$data['sort_price'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, true);
		$data['sort_quantity'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, true);
		$data['sort_relation_product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.relation_product' . $url, true);
		$data['sort_status'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_relation_product'])) {
			$url .= '&filter_relation_product=' . $this->request->get['filter_relation_product'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_relation_product'] = $filter_relation_product;
		$data['filter_status'] = $filter_status;
		$data['filter_image'] = $filter_image;
		$data['filter_free_postage'] = $filter_free_postage;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/product_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
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
		$data['entry_is_main'] = $this->language->get('entry_is_main');
		$data['entry_is_new'] = $this->language->get('entry_is_new');
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
		$data['entry_video'] = $this->language->get('entry_video');
        $data['entry_video_link'] = $this->language->get('entry_video_link');
		//新增的产品属性
		$data['entry_relation_product'] = 'Relation Product';
		$data['entry_color'] = 'Color';
		$data['entry_length'] = 'Length';
		$data['entry_material'] = $this->language->get('entry_material');
		//新增的产品属性,end

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_minimum'] = $this->language->get('help_minimum');
		$data['help_manufacturer'] = $this->language->get('help_manufacturer');
		$data['help_stock_status'] = $this->language->get('help_stock_status');
		$data['help_points'] = $this->language->get('help_points');
		$data['help_category'] = $this->language->get('help_category');
		$data['help_filter'] = $this->language->get('help_filter');
		$data['help_download'] = $this->language->get('help_download');
		$data['help_related'] = $this->language->get('help_related');
		$data['help_tag'] = $this->language->get('help_tag');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_attribute_add'] = $this->language->get('button_attribute_add');
		$data['button_option_add'] = $this->language->get('button_option_add');
		$data['button_option_value_add'] = $this->language->get('button_option_value_add');
		$data['button_discount_add'] = $this->language->get('button_discount_add');
		$data['button_special_add'] = $this->language->get('button_special_add');
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_attribute'] = $this->language->get('tab_attribute');
		$data['tab_option'] = $this->language->get('tab_option');
		$data['tab_discount'] = $this->language->get('tab_discount');
		$data['tab_special'] = $this->language->get('tab_special');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_links'] = $this->language->get('tab_links');
		$data['tab_reward'] = $this->language->get('tab_reward');
		$data['tab_design'] = $this->language->get('tab_design');
		$data['tab_openbay'] = $this->language->get('tab_openbay');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['model'])) {
			$data['error_model'] = $this->error['model'];
		} else {
			$data['error_model'] = '';
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}
		
		if (isset($this->error['special'])) {
			$data['error_special'] = $this->error['special'];
		} else {
			$data['error_special'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['product_id'])) {
			$data['action'] = $this->url->link('catalog/product/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, true);
		}

        $data['edit_video'] = $this->url->link('catalog/product/editVideo');
		$data['edit_video_url'] = '&token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url;

		$data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
//        $data['languages'] = $this->model_localisation_language->getLanguages(array('store'=>'hotbeautyhairmall'),$this->config->get("config_language_id"));//此处config_language_id取前台数据,但是取的数据为3,有bug,只能写死
//		$data['languages'] = $this->model_localisation_language->getLanguages(array('store'=>'hotbeautyhairmall'),1);
        $data['language_default_id'] = $this->config->get('config_language_id');
        
		if (isset($this->request->post['product_description'])) {
			$data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_description'] = $this->model_catalog_product->getProductDescriptions($this->request->get['product_id']);
		} else {
			$data['product_description'] = array();
		}
		if (isset($this->request->post['model'])) {
			$data['model'] = $this->request->post['model'];
		} elseif (!empty($product_info)) {
			$data['model'] = $product_info['model'];
		} else {
			$data['model'] = '';
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['product_store'])) {
			$data['product_store'] = $this->request->post['product_store'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_store'] = $this->model_catalog_product->getProductStores($this->request->get['product_id']);
		} else {
			$data['product_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($product_info)) {
			$data['keyword'] = $product_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['shipping'])) {
			$data['shipping'] = $this->request->post['shipping'];
		} elseif (!empty($product_info)) {
			$data['shipping'] = $product_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}

		if (isset($this->request->post['price'])) {
			$data['price'] = $this->request->post['price'];
		} elseif (!empty($product_info)) {
			$data['price'] = $product_info['price'];
		} else {
			$data['price'] = '';
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['tax_class_id'])) {
			$data['tax_class_id'] = $this->request->post['tax_class_id'];
		} elseif (!empty($product_info)) {
			$data['tax_class_id'] = $product_info['tax_class_id'];
		} else {
			$data['tax_class_id'] = 0;
		}

        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        if (isset($this->request->post['video'])) {
            $data['video'] = $this->request->post['video'];
            $data['video_url'] = $http_type . $_SERVER['HTTP_HOST'] . '/image/' . $this->request->post['video'];
        } elseif (!empty($product_info)) {
            $data['video'] = $product_info['video'];
            $data['video_url'] = $http_type . $_SERVER['HTTP_HOST'].'/image/'. $product_info['video'];
        } else {
            $data['video'] = '';
            $data['video_url'] = '';
        }

        if (isset($this->request->post['video_link'])) {
            $data['video_link'] = $this->request->post['video_link'];
        } elseif (!empty($product_info)) {
            $data['video_link'] = $product_info['video_link'];
        } else {
            $data['video_link'] = '';
        }

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($product_info)) {
			$data['date_available'] = ($product_info['date_available'] != '0000-00-00') ? $product_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($product_info)) {
			$data['quantity'] = $product_info['quantity'];
		} else {
			$data['quantity'] = 1;
		}

		if (isset($this->request->post['minimum'])) {
			$data['minimum'] = $this->request->post['minimum'];
		} elseif (!empty($product_info)) {
			$data['minimum'] = $product_info['minimum'];
		} else {
			$data['minimum'] = 1;
		}

		if (isset($this->request->post['subtract'])) {
			$data['subtract'] = $this->request->post['subtract'];
		} elseif (!empty($product_info)) {
			$data['subtract'] = $product_info['subtract'];
		} else {
			$data['subtract'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($product_info)) {
			$data['sort_order'] = $product_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['stock_status_id'])) {
			$data['stock_status_id'] = $this->request->post['stock_status_id'];
		} elseif (!empty($product_info)) {
			$data['stock_status_id'] = $product_info['stock_status_id'];
		} else {
			$data['stock_status_id'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($product_info)) {
			$data['status'] = $product_info['status'];
		} else {
			$data['status'] = true;
		}

        //是否主产品  dyl add
		if (isset($this->request->post['is_main'])) {
			$data['is_main'] = $this->request->post['is_main'];
		} elseif (!empty($product_info)) {
			$data['is_main'] = $product_info['is_main'];
		} else {
			$data['is_main'] = true;
		}

		//是否新品  dyl add
		if (isset($this->request->post['is_new'])) {
			$data['is_new'] = $this->request->post['is_new'];
		} elseif (!empty($product_info)) {
			$data['is_new'] = $product_info['is_new'];
		} else {
			$data['is_new'] = true;
		}

        //是否首页显示
        if (isset($this->request->post['is_home'])) {
            $data['is_home'] = $this->request->post['is_home'];
        } elseif (!empty($product_info)) {
            $data['is_home'] = $product_info['is_home'];
        } else {
            $data['is_home'] = true;
        }

		//是否包邮  add by yufeng
		if(isset($this->request->post['free_postage'])){
			$data['free_postage'] = $this->request->post['free_postage'];
		}elseif(!empty($product_info)){
			$data['free_postage'] = $product_info['free_postage'];
		}else{
			$data['free_postage'] = false;
		}

		if (isset($this->request->post['weight'])) {
			$data['weight'] = $this->request->post['weight'];
		} elseif (!empty($product_info)) {
			$data['weight'] = $product_info['weight'];
		} else {
			$data['weight'] = '';
		}

		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['weight_class_id'])) {
			$data['weight_class_id'] = $this->request->post['weight_class_id'];
		} elseif (!empty($product_info)) {
			$data['weight_class_id'] = $product_info['weight_class_id'];
		} else {
			$data['weight_class_id'] = $this->config->get('config_weight_class_id');
		}

		if (isset($this->request->post['length'])) {
			$data['length'] = $this->request->post['length'];
		} elseif (!empty($product_info)) {
			$data['length'] = $product_info['length'];
		} else {
			$data['length'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($product_info)) {
			$data['width'] = $product_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($product_info)) {
			$data['height'] = $product_info['height'];
		} else {
			$data['height'] = '';
		}

		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (isset($this->request->post['length_class_id'])) {
			$data['length_class_id'] = $this->request->post['length_class_id'];
		} elseif (!empty($product_info)) {
			$data['length_class_id'] = $product_info['length_class_id'];
		} else {
			$data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($product_info)) {
			$data['manufacturer_id'] = $product_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($product_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		// Categories
		$this->load->model('catalog/category');

		if (isset($this->request->post['product_category'])) {
			$categories = $this->request->post['product_category'];
		} elseif (isset($this->request->get['product_id'])) {
			$categories = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		} else {
			$categories = array();
		}

		$data['product_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['product_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Filters
		$this->load->model('catalog/filter');

		if (isset($this->request->post['product_filter'])) {
			$filters = $this->request->post['product_filter'];
		} elseif (isset($this->request->get['product_id'])) {
			$filters = $this->model_catalog_product->getProductFilters($this->request->get['product_id']);
		} else {
			$filters = array();
		}

		$data['product_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['product_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		// Attributes
		$this->load->model('catalog/attribute');

		if (isset($this->request->post['product_attribute'])) {
			$product_attributes = $this->request->post['product_attribute'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_attributes = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
		} else {
			$product_attributes = array();
		}

		$data['product_attributes'] = array();

		foreach ($product_attributes as $product_attribute) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($product_attribute['attribute_id']);

			if ($attribute_info) {
				$data['product_attributes'][] = array(
					'attribute_id'                  => $product_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'product_attribute_description' => $product_attribute['product_attribute_description']
				);
			}
		}

		// Options
		$this->load->model('catalog/option');

		if (isset($this->request->post['product_option'])) {
			$product_options = $this->request->post['product_option'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);
		} else {
			$product_options = array();
		}

		$data['product_options'] = array();

		foreach ($product_options as $product_option) {
			$product_option_value_data = array();

			if (isset($product_option['product_option_value'])) {
				foreach ($product_option['product_option_value'] as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']
					);
				}
			}

			$data['product_options'][] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => isset($product_option['value']) ? $product_option['value'] : '',
				'option_value_id'      => isset($product_option['option_value_id']) ? $product_option['option_value_id'] : 0,
				'required'             => $product_option['required']
			);
		}

		$data['option_values'] = array();

		foreach ($data['product_options'] as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($data['option_values'][$product_option['option_id']])) {
					$data['option_values'][$product_option['option_id']] = $this->model_catalog_option->getOptionValues($product_option['option_id']);
				}
			}
		}

		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		if (isset($this->request->post['product_discount'])) {
			$product_discounts = $this->request->post['product_discount'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
		} else {
			$product_discounts = array();
		}

		$data['product_discounts'] = array();

		foreach ($product_discounts as $product_discount) {
			$data['product_discounts'][] = array(
			    'product_discount_id'   => $product_discount['product_discount_id'],
				'customer_group_id'     => $product_discount['customer_group_id'],
				'quantity'              => $product_discount['quantity'],
				'priority'              => $product_discount['priority'],
				'price'                 => $product_discount['price'],
				'date_start'            => ($product_discount['date_start'] != '0000-00-00') ? $product_discount['date_start'] : '',
				'date_end'              => ($product_discount['date_end'] != '0000-00-00') ? $product_discount['date_end'] : ''
			);
		}

		if (isset($this->request->post['product_special'])) {
			$product_specials = $this->request->post['product_special'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_specials = $this->model_catalog_product->getProductSpecials($this->request->get['product_id']);
		} else {
			$product_specials = array();
		}

		$data['product_specials'] = array();

		//是否同步同类商品（product_relation、color_id相同的一类产品）的折扣
		if (isset($this->request->post['sync_percent'])) {
			$data['sync_percent'] = $this->request->post['sync_percent'];
		} else {
			$data['sync_percent'] = 0;
		}
		
		foreach ($product_specials as $product_special) {
			$data['product_specials'][] = array(
			    'product_special_id'=> $product_special['product_special_id'],
				'customer_group_id' => $product_special['customer_group_id'],
				'priority'          => $product_special['priority'],
				'price'             => $product_special['price'],
				'percent'           => $product_special['percent'],
				'date_start'        => ($product_special['date_start'] != '0000-00-00') ? $product_special['date_start'] : '',
				'date_end'          => ($product_special['date_end'] != '0000-00-00') ? $product_special['date_end'] :  ''
			);
		}

		// Image
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($product_info)) {
			$data['image'] = $product_info['image'];
		} else {
			$data['image'] = '';
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

		// Images
		if (isset($this->request->post['product_image'])) {
			$product_images = $this->request->post['product_image'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_images = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
		} else {
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

		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['product_id'])) {
			$products = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
		} else {
			$products = array();
		}

		$data['product_relateds'] = array();

		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);

			if ($related_info) {
				$data['product_relateds'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['points'])) {
			$data['points'] = $this->request->post['points'];
		} elseif (!empty($product_info)) {
			$data['points'] = $product_info['points'];
		} else {
			$data['points'] = '';
		}

		if (isset($this->request->post['product_reward'])) {
			$data['product_reward'] = $this->request->post['product_reward'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_reward'] = $this->model_catalog_product->getProductRewards($this->request->get['product_id']);
		} else {
			$data['product_reward'] = array();
		}

		if (isset($this->request->post['product_layout'])) {
			$data['product_layout'] = $this->request->post['product_layout'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_layout'] = $this->model_catalog_product->getProductLayouts($this->request->get['product_id']);
		} else {
			$data['product_layout'] = array();
		}

		//新增的产品数据
		//relation_product(关联产品的model)
		if (isset($this->request->post['relation_product'])) {
			$data['relation_product'] = $this->request->post['relation_product'];
		} else if (!empty($product_info)) {
			$data['relation_product'] = $product_info['relation_product'];
		}else{
			$data['relation_product'] = '';
		}

		//color(产品的颜色)
		if (isset($this->request->post['color_id'])) {
			$data['color_id'] = $this->request->post['color_id'];
		} else if (!empty($product_info)) {
			$data['color_id'] = $product_info['color_id'];
		}else{
			$data['color_id'] = 0;
		}
		$data['colors'] = $this->model_catalog_product->getOption('Color');

		//length(产品的长度)
		if (isset($this->request->post['length_id'])) {
		    $data['length_id'] = $this->request->post['length_id'];
		} else if (!empty($product_info)) {
		    $data['length_id'] = $product_info['length_id'];
		}else{
		    $data['length_id'] = 0;
		}
		$data['lengths'] = $this->model_catalog_product->getOption('Length');
		//新增的产品数据,end

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/product_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['product_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}

		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}

		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['product_id']) && $url_alias_info['query'] != 'product_id=' . $this->request->get['product_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['product_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}
		
		//验证Special面板同类商品是否可以同步折扣信息
		$this->load->model('catalog/product');
		if ($this->request->post['sync_percent'] == 1) {
			$num = $this->model_catalog_product->syncValidate($this->request->post['product_special']);
			if (!empty($num)) {
				$line = implode(',', $num);
				$this->error['special'] = sprintf($this->language->get('error_special'), $line);
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);

				/*
				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);

					if ($option_info) {
						$product_option_value_data = array();

						foreach ($product_option['product_option_value'] as $product_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);

							if ($option_value_info) {
								$product_option_value_data[] = array(
									'product_option_value_id' => $product_option_value['product_option_value_id'],
									'option_value_id'         => $product_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $product_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'product_option_id'    => $product_option['product_option_id'],
							'product_option_value' => $product_option_value_data,
							'option_id'            => $product_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $product_option['value'],
							'option_value_id'      => $product_option['option_value_id'],
							'required'             => $product_option['required']
						);
					}
				}
                */
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
//					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	/**
	 * 导入商品Special（特价）信息
	 * @author Poly
	 */
	private function _importSpecial() 
	{
	    if(isset($this->request->get['act2']) && $this->request->get['act2'] == 'tpl')//下载模板
	        Common::downloadFile('tpl_import_product_special.xlsx');
	    
	    if(!empty($this->request->files)){
	        $res = Common::uploadExcelToArray();
	        
	        if(!empty($res['errors'])){
	            $data['msg'] = $res['errors'];
	        }else{
	            $importData = array();
				$i = 0;
	            foreach ($res['data'] as $k=>$v){//格式化导入数据
	                if(count($v) < 7) {
	                    $data['msg'][] = '第'.($k+1).'行，内容格式错误!'; continue;
	                }
	                $row = array();
	                if(!$v[0]) continue;

	                $row0['model'] = trim($v[0]);
	                $row0['price'] = floatval($v[7]);
	                $row0['quantity'] = intval($v[8]);
	                $row0['relation_product'] = trim($v[9]);
	                $row0['is_main'] = trim($v[10]);
	                $row0['is_new'] = trim($v[11]);


	                $row['model'] = trim($v[0]);
	                $row['customer_group'] = trim($v[25]);
//	                $row['priority'] = intval($v[2]);
	                $row['price'] = floatval($v[27]);
	                $row['percent'] = floatval($v[26]);
	                $row['date_start'] = trim($v[28]);
	                $row['date_end'] = trim($v[29]);
	    
	                $product = Base::getRow('product', $row['model'], 'model');
	                if(!$product){
						$row0['product_id'] = 0;
						$row['product_id'] = 0;
	                    $data['msg'][] = '第'.($k+1).'行，商品Model '.$row['model'].' 不存在!';
	                }else{
                        $row0['product_id'] = $product['product_id'];
                        $row['product_id'] = $product['product_id'];
	                }
	                $customerGroup = Base::getRow('customer_group_description', $row['customer_group'], 'name', 1);
	                if(!$customerGroup){
	                    $data['msg'][] = '第'.($k+1).'行，客户分组 '.$row['customer_group'].' 不存在!';
	                    continue;
	                }else{
	                    $row['customer_group_id'] = $customerGroup['customer_group_id'];
	                }
	                $productSpecials = $this->model_catalog_product->getProductSpecials($row['product_id']);
	                if($productSpecials){
	                    foreach ($productSpecials as $special){
							if ($special['customer_group_id'] == $row['customer_group_id']) {
								$row['product_special_id'] = $special['product_special_id'];
								$i++;
							}
	                    }
	                } else {
						$row['product_special_id'] = '';
					}
	                $importData0[] = $row0;
	                $importData[] = $row;
	            }
	            if(empty($data['msg'])){//无错误信息，保存采购单
                    $attributes0 = array('product_id', 'model', 'price', 'quantity', 'relation_product', 'is_main','is_new');
	                $attributes = array('product_special_id', 'product_id', 'customer_group_id', 'priority', 'price', 'percent', 'date_start', 'date_end');
	                $num0= Common::saveData('product',$attributes0,$importData0,2000,false,'REPLACE INTO');
					$num = Common::saveData('product_special', $attributes, $importData, 2000, false, 'REPLACE INTO');
	                if($num > 0 && $num0>0){
						$num = $num-$i;
	                    $info = '商品信息导入成功，成功导入'.$num.'条记录！';
	                    $data['info'] = $info;
	                }else{
	                    $data['msg'][] = '商品信息导入失败!';
	                }
	            }
	        }
	    }
	    
	    $data['title'] = '导入商品信息';
	    $data['tplUrl'] = $this->url->link('catalog/product', 'act=importSpecial&act2=tpl&token=' . $this->session->data['token'], true);
	    
	    $data['breadcrumbs'] = array();
	    $data['breadcrumbs'][] = array(
	        'text' => $this->language->get('text_home'),
	        'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
	    );
	    $data['breadcrumbs'][] = array(
	        'text' => $this->language->get('heading_title'),
	        'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'], true)
	    );
	    
	    $data['header'] = $this->load->controller('common/header');
	    $data['column_left'] = $this->load->controller('common/column_left');
	    $data['footer'] = $this->load->controller('common/footer');
	    
	    $this->response->setOutput($this->load->view('common/import', $data));
    }
    
    /**
     * 导出商品，按照导入格式
     * @author Poly
     */
    private function _export($filter_data)
    {
        require_once DIR_SYSTEM.'common/SimpleExcel.php';
    
        $this->load->model('tool/import_product');
        $header = array(
            'model' => '*Model',
            'name' => '*Name',
            'description' => '*Description',
            'm_description' => '*M_Description',
            'meta_title' => 'Meta title',
            'meta_keyword' => 'Meta keywords',
            'meta_description' => 'Meta description',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'relation_product' => 'Relation product',
            'is_main' => 'Is Main',
            'is_new' => 'Is New',
            'free_postage' => 'Free Postage',
            'color' => 'Color',
            'length' => 'Length',
            'weight' => 'Weight',
            'category' => 'Category',
            'main_image' => 'Main image',
            'images' => 'Images',
            'Application' => 'Application',
            'Feature' => 'Feature',
            'Grade' => 'Grade',
            'Material' => 'Material',
            'Volume' => 'Volume',
            'Texture' => 'Texture',
            'Customer_Group' => 'Customer Group',
            'Percent' => 'Percent',
            'Specialprice' => 'Specialprice',
            'Datestart' => 'Datestart',
            'Dateend' => 'Dateend',
        );
        unset($filter_data['order'],$filter_data['start'],$filter_data['limit']);
        $filter_data['sort'] = 'p.relation_product';
        $res = $this->model_catalog_product->getProducts($filter_data);
//        var_dump(count($res));die;
        $data = array();
        foreach ($res as $v){
            $v['color'] = '';
            $v['length'] = '';
            $v['category'] = '';
            $v['percent'] = '';
            $v['main_image'] = '';
            $v['images'] = '';
            $v['Application'] = '';
            $v['Feature'] = '';
            $v['Grade'] = '';
            $v['Material'] = '';
            $v['Volume'] = '';
            $v['Texture'] = '';
            $v['Customer_Group'] = '';
            $v['Percent'] = '';
            $v['Specialprice'] = '';
            $v['Datestart'] = '';
            $v['Dateend'] = '';

            $opName = $this->model_tool_import_product->getOptionValueDescriptionName($v['color_id']);
            if($opName) $v['color'] = $opName;
            $opName = $this->model_tool_import_product->getOptionValueDescriptionName($v['length_id']);
            if($opName) $v['length'] = $opName;
            $cats = $this->model_catalog_product->getProductCategoryNames($v['product_id']);
            if($cats){
                $v['category'] = implode('>', $cats);
            }
            $imgs = $this->model_catalog_product->getProductImages($v['product_id']);
            if($imgs){
                foreach ($imgs as $ki=>$vi) $imgs[$ki] = str_replace('catalog', '', $vi['image']);
                $v['main_image'] = $imgs[0];
                $v['images'] = implode(';', $imgs);
            }
            //额外商品属性
            $productOptions = $this->model_catalog_product->getProductOptions($v['product_id']);
            if($productOptions){

                foreach ($productOptions as $vo){
                    $v[$vo['name']] = $vo['value'];
                }
            }
//            $data[$v['category'].' '.$v['relation_product'].' '.$v['color'].' '.intval($v['length'])] = $v;

            $productSpecials = $this->model_catalog_product->getProductSpecials($v['product_id']);
            if($productSpecials){
//                var_dump();die;
//                foreach ($productSpecials[0] as $vo){
                $this->load->model('customer/customer_group');
                $groupcustomer = $this->model_customer_customer_group->getCustomerGroup($productSpecials[0]['customer_group_id']);
//                var_dump($groupcustomer);die;
                $v['Customer_Group'] = $groupcustomer['name'];
                $v['Percent'] = $productSpecials[0]['percent'];
                $v['Specialprice'] = $productSpecials[0]['price'];
                $v['Datestart'] = $productSpecials[0]['date_start'];
                $v['Dateend'] = $productSpecials[0]['date_end'];
//                }
            }
            $data[$v['category'].' '.$v['relation_product'].' '.$v['color'].' '.intval($v['length']).' '.$v['Customer_Group'].' '.$v['percent'].' '.$v['Specialprice'].' '.$v['Datestart'].' '.$v['Dateend']] = $v;
        }
        ksort($data);
        $excel = new SimpleExcel();
        $excel->header = $header;
        $excel->name = 'product'.date('Y-m-d');
        $excel->data = $data;
        $excel->fill = array('key'=>'is_main', 'val'=>1);
        $excel->toString();
    }
}
