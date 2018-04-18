<?php
class ModelCatalogReviewImage extends Model {

	function upload( $filename ) {
		global $config;
		global $log;
		$config = $this->config;
		$log = $this->log;

		$database =& $this->db;
		ini_set("memory_limit","512M");
		ini_set("max_execution_time",180);

		chdir( '../system/PHPExcel' );
		require_once( 'Classes/PHPExcel.php' );
		chdir( '../../admin' );
		$inputFileType = PHPExcel_IOFactory::identify($filename);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$reader = $objReader->load($filename);

		$data = $reader->getSheet(0);

       $highestRow = $data->getHighestRow(); // 取得总行数
       $highestColumn = $data->getHighestColumn(); // 取得总列数
		for($j=2;$j<=$highestRow;$j++)
        {
			$str = '';
			for($k='A';$k<=$highestColumn;$k++)
		    {
			  $str .= iconv('utf-8','gbk',$reader->getActiveSheet()->getCell("$k$j")->getValue()).'\\';//读 取单元格
			}
			//explode:函 数把字符串分割为数组。
            $review_data =explode("\\",$str);

			if($review_data&&!empty($review_data[0])){
				$sql = "select * from ".DB_PREFIX."product where model = '".$review_data[0]."' ";
				$query = $this->db->query($sql);

				if($query->num_rows){

					$this->db->query("INSERT INTO " . DB_PREFIX . "review SET  author = '" . $this->db->escape($review_data[1]) . "', product_id = '" . (int)$query->row['product_id'] . "', text = '" . $this->db->escape(strip_tags($review_data[2])) . "', rating = '" . (int)$review_data[3] . "',  status = '" . (int)$review_data[4] . "', date_added = NOW()");

					$review_id = $this->db->getLastId();

					if(!empty($review_data[5])){
						$image_data = explode(';',$review_data[5]);
						foreach($image_data as $row){
							$this->db->query("INSERT INTO " . DB_PREFIX . "review_img SET review_id = '".$review_id."',path='".$row."', createTime='".time()."'");
						}
					}
				}

			}

		}
	}


}