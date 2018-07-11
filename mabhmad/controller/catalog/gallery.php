<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/6
 * Time: 16:13
 */

class ControllerCatalogGallery extends Controller
{

    private $error = array();

    public function index(){
        $this->load->language('catalog/gallery');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/gallery');

        $this->load->model('tool/image');

        $this->getList();
    }

    public function add() { 
        //var_dump($this->request->post);exit();
        $this->load->language('catalog/gallery');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/gallery');
     
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {


            $this->model_catalog_gallery->addGallery($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            $this->response->redirect($this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('catalog/gallery');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/gallery');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $this->model_catalog_gallery->editGallery($this->request->get['gallery_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            $this->response->redirect($this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('catalog/gallery');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/gallery');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $gallery_id) {
                $this->model_catalog_gallery->deleteGallery($gallery_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_gallery_title'])) {
                $url .= '&filter_gallery_title=' . urlencode(html_entity_decode($this->request->get['filter_gallery_title'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_product_name'])) {
                $url .= '&filter_product_name=' . $this->request->get['filter_product_name'];
            }

            if (isset($this->request->get['filter_author'])) {
                $url .= '&filter_author=' . $this->request->get['filter_author'];
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

            $this->response->redirect($this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getList();
    }

    protected function getList() {

        $this->load->model('catalog/gallery');

        if (isset($this->request->get['filter_gallery_title'])) {
            $filter_gallery_title = $this->request->get['filter_gallery_title'];
        } else {
            $filter_gallery_title = null;
        }

        if (isset($this->request->get['filter_author'])) {
            $filter_author = $this->request->get['filter_author'];
        } else {
            $filter_author = null;
        }

        if (isset($this->request->get['filter_product_name'])) {
            $filter_product_name = $this->request->get['filter_product_name'];
        } else {
            $filter_product_name = null;
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'id';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_gallery_title'])) {
            $url .= '&filter_gallery_title=' . urlencode(html_entity_decode($this->request->get['filter_gallery_title'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_author'])) {
            $url .= '&filter_author=' . $this->request->get['filter_author'];
        }

        if (isset($this->request->get['filter_product_name'])) {
            $url .= '&filter_product_name=' . $this->request->get['filter_product_name'];
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
            'href' => $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url, true)
        );

        $data['add'] = $this->url->link('catalog/gallery/add', 'token=' . $this->session->data['token'] . $url, true);
        $data['delete'] = $this->url->link('catalog/gallery/delete', 'token=' . $this->session->data['token'] . $url, true);

        $data['galleries'] = array();

        $filter_data = array(
            'filter_gallery_title'    => $filter_gallery_title,
            'filter_product_name'     => $filter_product_name,
            'filter_author'           => $filter_author,
            'sort'                    => $sort,
            'order'                   => $order,
            'start'                   => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit'                   => $this->config->get('config_limit_admin')
        );

        $gallery_total = $this->model_catalog_gallery->getTotalgallerys($filter_data);

        $results = $this->model_catalog_gallery->getGallerys($filter_data);
       // var_dump($results);exit();
        foreach ($results as $result) {
            $data['galleries'][] = array(
                'gallery_id'        => $result['gallery_id'],
                'product_id'        => $result['product_id'],
                'product_name'      => $result['product_name'],
                'gallery_title'     => $result['gallery_title'],
                'view'              => $result['view'],
                'author'            => $result['author'],
                'image'             => $this->model_tool_image->resize($result['image'], 50, 50),
                'edit'              => $this->url->link('catalog/gallery/edit', 'token=' . $this->session->data['token'] . '&gallery_id=' . $result['gallery_id'] . $url, true)
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['column_gallery_title'] = $this->language->get('column_gallery_title');
        $data['column_product_name'] = $this->language->get('column_product_name');
        $data['column_thumbnail'] = $this->language->get('column_image');
        $data['column_action'] = $this->language->get('column_action');
        $data['column_author'] = $this->language->get('column_author');
        $data['column_view'] = $this->language->get('column_view');

        $data['entry_gallery_title'] = $this->language->get('entry_gallery_title');
        $data['entry_product_name'] = $this->language->get('entry_product_name');
        $data['entry_author'] = $this->language->get('entry_author');

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

        if (isset($this->request->get['filter_gallery_title'])) {
            $url .= '&filter_gallery_title=' . urlencode(html_entity_decode($this->request->get['filter_gallery_title'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_product_name'])) {
            $url .= '&filter_product_name=' . $this->request->get['filter_product_name'];
        }

        if (isset($this->request->get['filter_author'])) {
            $url .= '&filter_author=' . $this->request->get['filter_author'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_gallery_title'] = $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . '&sort=gallery_title' . $url, true);
        $data['sort_product_name'] = $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . '&sort=product_name' . $url, true);

        $url = '';

        if (isset($this->request->get['filter_gallery_title'])) {
            $url .= '&filter_gallery_title=' . urlencode(html_entity_decode($this->request->get['filter_gallery_title'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_product_name'])) {
            $url .= '&filter_product_name=' . $this->request->get['filter_product_name'];
        }

        if (isset($this->request->get['filter_author'])) {
            $url .= '&filter_author=' . $this->request->get['filter_author'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $gallery_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($gallery_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($gallery_total - $this->config->get('config_limit_admin'))) ? $gallery_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $gallery_total, ceil($gallery_total / $this->config->get('config_limit_admin')));

        $data['filter_gallery_title'] = $filter_gallery_title;
        $data['filter_product_name']  = $filter_product_name;
        $data['filter_author'] = $filter_author;

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/gallery_list', $data));
    }

    protected function getForm() {

        $this->load->model('tool/image');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['gallery_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_default'] = $this->language->get('text_default');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_none'] = $this->language->get('text_none');

        $data['entry_product_name'] = $this->language->get('entry_product_name');
        $data['entry_gallery_title'] = $this->language->get('entry_gallery_title');
        $data['entry_image'] = $this->language->get('entry_gallery_image');
        $data['entry_select_product'] = $this->language->get('entry_select_product');
        $data['entry_author'] = $this->language->get('entry_author');
        $data['entry_is_home'] = $this->language->get('entry_is_home');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_additional_image'] = $this->language->get('entry_additional_image');
        $data['entry_related'] = $this->language->get('entry_related');
        $data['entry_video'] = $this->language->get('entry_video');

        $data['help_related'] = $this->language->get('help_related');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['tab_general'] = $this->language->get('tab_general');
        $data['tab_data'] = $this->language->get('tab_data');
        $data['tab_image'] = $this->language->get('tab_image');
      // $data['edit_video'] = $this->url->link('catalog/gallery/editVideo');
        $data['edit_video'] = $this->url->link('catalog/gallery/editVideo').'&token=' . $this->session->data['token'];
        $data['edit_video_url'] = '&token=' . $this->session->data['token'] ;
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['gallery_title'])) {
            $data['error_gallery_title'] = $this->error['gallery_title'];
        } else {
            $data['error_gallery_title'] = array();
        }

        if (isset($this->error['gallery_image'])) {
            $data['error_gallery_image'] = $this->error['gallery_image'];
        } else {
            $data['error_gallery_image'] = array();
        }

        if (!empty($this->error['product_name'])) {
            $data['error_product_name'] = $this->error['product_name'];
        } else {
            $data['error_product_name'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'], true)
        );

        if (!isset($this->request->get['gallery_id'])) {
            $data['action'] = $this->url->link('catalog/gallery/add', 'token=' . $this->session->data['token'], true);
        } else {
            $data['action'] = $this->url->link('catalog/gallery/edit', 'token=' . $this->session->data['token'] . '&gallery_id=' . $this->request->get['gallery_id'], true);
        }

        $data['cancel'] = $this->url->link('catalog/gallery', 'token=' . $this->session->data['token'], true);

        if (!empty($this->request->get['gallery_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {

            $gallery_info = $this->model_catalog_gallery->getGalleryInfo($this->request->get['gallery_id']);
            // print_r($gallery_info);exit;

        }
        //视频
       // if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
       //      $product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
       //      $data['edit_video_url'] = '&token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url;
       //  }else{
       //      $data['edit_video_url']='';
       //  }
        //$data['token'] = $this->session->data['token'];
        //
         $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

        //视频end
        
        //gallery_image
        if(isset($this->request->post['gallery_image'])){
            $gallery_images = $this->request->post['gallery_image'];
        }
        elseif(isset($this->request->get['gallery_id'])){
            $gallery_images = $this->model_catalog_gallery->getGalleryImage($this->request->get['gallery_id']);
        }
        else{
            $gallery_images = array();
        }

        $data['gallery_images'] = array();

        foreach ($gallery_images as $gallery_image) {
            if (is_file(DIR_IMAGE . $gallery_image['image'])) {
                $image = $thumb = $gallery_image['image'];
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }

            $data['gallery_images'][] = array(
                'image'      => $image,
                'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
                'sort_order' => $gallery_image['sort_order']
            );
        }

        //link_product
        if(isset($this->request->post['product_id']) && !empty($this->request->post['product_id'])){
            $data['product_name'] = $this->request->post['product_name'];
            $data['product_id'] = $this->request->post['product_id'];
        }
        elseif(isset($this->request->get['gallery_id'])){

            $data['product_name'] = $gallery_info['product_name'];
            $data['product_id'] = $gallery_info['product_id'];
        }
        else{
            $data['product_name'] = '';
            $data['product_id'] = '';
        }

        //gallery_title
        if(isset($this->request->post['gallery_title'])){
            $data['gallery_title'] = $this->request->post['gallery_title'];
        }
        elseif(isset($this->request->get['gallery_id'])){
            $data['gallery_title'] = $gallery_info['gallery_title'];
        }
        else{
            $data['gallery_title'] = '';
        }

        //image
        if(isset($this->request->post['image'])){
            $data['image'] = $this->request->post['image'];
        }
        elseif(isset($this->request->get['gallery_id'])){
            $data['image'] = $gallery_info['image'];
        }
        else{
            $data['image'] = 'no_image.png';
        }

        $data['thumb'] = $this->model_tool_image->resize($data['image'], 100, 100);

        //author
        if(isset($this->request->post['author'])){
            $data['author'] = $this->request->post['author'];
        }
        elseif(isset($this->request->get['gallery_id'])){
            $data['author'] = $gallery_info['author'];
        }
        else{
            $data['author'] = '';
        }

        //is_home
        if(isset($this->request->post['is_home'])){
            $data['is_home'] = $this->request->post['is_home'];
        }
        elseif(isset($this->request->get['gallery_id'])){
            $data['is_home'] = $gallery_info['is_home'];
        }
        else{
            $data['is_home'] = 1;
        }

        //status
        if(isset($this->request->post['status'])){
            $data['status'] = $this->request->post['status'];
        }
        elseif(isset($this->request->get['gallery_id'])){
            $data['status'] = $gallery_info['status'];
        }
        else{
            $data['status'] = 1;
        }

        //sort_order
        if(isset($this->request->post['sort_order'])){
            $data['sort_order'] = $this->request->post['sort_order'];
        }
        elseif(isset($this->request->get['gallery_id'])){
            $data['sort_order'] = $gallery_info['sort_order'];
        }
        else{
            $data['sort_order'] = 10;
        }

        if(isset($this->request->post['video'])){
            $data['video'] =$http_type . $_SERVER['HTTP_HOST'].'/image/'. $this->request->post['video'];
        }
        elseif(isset($this->request->get['gallery_id'])){
            $data['video'] =$http_type . $_SERVER['HTTP_HOST'].'/image/'. $gallery_info['video'];
        }
        else{
            $data['video'] = '';
        }

        $data['token'] = $this->session->data['token'];

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        $this->load->model('setting/store');

        $data['stores'] = $this->model_setting_store->getStores();

        $this->load->model('design/layout');

        $data['layouts'] = $this->model_design_layout->getLayouts();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/gallery_form', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/gallery')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (empty($this->request->post['gallery_title'])) {
            $this->error['gallery_title'] = $this->language->get('error_gallery_title');
        }

        if (empty($this->request->post['product_id'])){
            $this->error['product_name'] = $this->language->get('error_product_name');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'catalog/gallery')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
    // 新增
    //  视频开始
    public function deleteVideo(){
        $this->load->language('catalog/product');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/product');
       // var_dump($this->request->get['product_id']);
      
        if(isset($this->request->get['product_id'])){
              unlink('/image/'.$this->request->get['video']); 
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
                    }elseif(isset($this->request->get['hairclub'])){
                         $previewName = 'hairclub/pre_'.rand(1000,9000).'.'.$ext;
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
                        $data['previewSrc'] = '/image/'.$previewSrc;
                    }

//                }
                }
            }
            $this->response->setOutput(json_encode($data));
        }
    }
    // 新增 视频end
}