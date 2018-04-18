<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/14
 * Time: 16:35
 */

class ModelCatalogGallery extends Model
{

        private function querysql($sql)
    {
        $dbs= unserialize($this->config->get('db_database_data'));
        foreach ($dbs as $key => $value) {
            if($key==0){
                $this->db->query($sql);
            }else{
                $d='db'.$key;
                $this->$d->query($sql);
            }
        }
        
    }
    public function getGalleryInfo($gallery_id){
        $query = $this->db->query("SELECT gallery_id, gallery_title, product_id, product_name, image, author, is_home, sort_order, status FROM " . DB_PREFIX . "gallery WHERE gallery_id = " . (int)$gallery_id);

        return $query->row;
    }

    public function getGalleryImage($gallery_id){
        $query = $this->db->query("SELECT image, sort_order FROM " . DB_PREFIX . "gallery_image WHERE gallery_id = " . (int)$gallery_id );

        return $query->rows;
    }

    public function getGallerys($data = array()) {

        $sql = "SELECT gallery_id, gallery_title, product_name, author, image, view FROM " . DB_PREFIX . "gallery WHERE status = '1'";

        if (!empty($data['filter_gallery_title'])) {
            $sql .= " AND gallery_title like '%" . $this->db->escape($data['filter_gallery_title']) . "%'";
        }

        if (isset($data['filter_product_name']) && !is_null($data['filter_product_name'])) {
            $sql .= " AND product_name = '" . $this->db->escape($data['filter_product_name']) . "'";
        }

        if (!empty($data['filter_author'])) {
            $sql .= " AND author like '%" . $this->db->escape($data['filter_author']) . "%'";
        }

        $sort_data = array(
            'gallery_title',
            'product_name'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY gallery_id";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalgallerys($data = array()){
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "gallery WHERE status = '1' ";

        if (isset($data['filter_gallery_title']) && !is_null($data['filter_gallery_title'])) {
            $sql .= " AND gallery_title like '%" . $this->db->escape($data['filter_gallery_title']) . "%'";
        }

        if (!empty($data['filter_product_name'])) {
            $sql .= " AND product_name = '" . $this->db->escape($data['filter_product_name']) . "'";
        }

        if (!empty($data['filter_author'])) {
            $sql .= " AND author = '" . $this->db->escape($data['filter_author']) . "'";
        }

        $query = $this->db->query($sql);

        if($query->row){
            $total = $query->row['total'];
        }
        else{
            $total = 0;
        }

        return $total;
    }

    public function addGallery($data = array()){

        $sql = "INSERT INTO " . DB_PREFIX . "gallery SET gallery_title = '" . $this->db->escape($data['gallery_title'])

            . "', image = '" . $data['image'] . "', product_id = " . (int)$data['product_id']

            . ", product_name = '" . $this->db->escape($data['product_name']) . "', is_home = " . (int)$data['is_home']

            . ", status = " . (int)$data['status'] . ", sort_order = " . (int)$data['sort_order'] . ", author = '" . $this->db->escape($data['author']) . "'";

        $this->querysql($sql);

        $gallery_id = $this->db->getLastId();

        if($data['gallery_image']){

            foreach ($data['gallery_image'] as $gallery_image) {
                $sql = "INSERT INTO " . DB_PREFIX ."gallery_image SET gallery_id = " . (int)$gallery_id . ", image = '" . $this->db->escape($gallery_image['image']) . "', sort_order = " . (int)$gallery_image['sort_order'];

                $this->querysql($sql);
            }
        }

        return $gallery_id;
    }

    public function editGallery($gallery_id, $data){

        $this->querysql("UPDATE " . DB_PREFIX . "gallery SET gallery_title = '" . $this->db->escape($data['gallery_title'])

            . "', product_id = " . (int)$data['product_id'] . ", product_name = '" . $this->db->escape($data['product_name'])

            . "', is_home = " . (int)$data['is_home'] . ", sort_order = " . (int)$data['sort_order']

            . ", status = " . (int)$data['status'] . ",author = '" . $this->db->escape($data['author']) . "'"

            . " WHERE gallery_id = " . (int)$gallery_id);

        if (isset($data['image'])) {
            $this->querysql("UPDATE " . DB_PREFIX . "gallery SET image = '" . $this->db->escape($data['image']) . "' WHERE gallery_id = " . (int)$gallery_id);
        }

        if (isset($data['gallery_image'])) {

            $this->querysql("DELETE FROM " . DB_PREFIX . "gallery_image WHERE gallery_id = " . $gallery_id);

            foreach ($data['gallery_image'] as $gallery_image) {
                $this->querysql("INSERT INTO " . DB_PREFIX ."gallery_image SET gallery_id = " . (int)$gallery_id . ", image = '" . $this->db->escape($gallery_image['image']) . "', sort_order = " . (int)$gallery_image['sort_order']);
            }
        }
    }

    public function deleteGallery($gallery_id) {
        $sql = "DELETE FROM " . DB_PREFIX . "gallery WHERE gallery_id = " .$gallery_id;

        $this->querysql($sql);

        $sql_info = "DELETE FROM " . DB_PREFIX . "gallery_image WHERE gallery_id = " . $gallery_id;

        $query = $this->querysql($sql_info);

        return true;
    }
}