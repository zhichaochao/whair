<?php
class ModelToolImportProduct extends Model {

	public function getOptionValueId($name='',$value=''){
		if($name=='' && $value=='' ){
			return false;
		}

		$sql = "select ovd.option_value_id from ".DB_PREFIX."option_value_description ovd left join ".DB_PREFIX."option_description od on ovd.option_id = od.option_id where ovd.name = '".htmlspecialchars($value)."' and od.name='".$name."'";

		$query=$this->db->query($sql);

		return $query->row;
	}
	
	public function getOptionValueDescriptionName($option_value_id=''){
	    if($option_value_id=='' ){
	        return false;
	    }
	    $sql = "select name from ".DB_PREFIX."option_value_description where option_value_id='$option_value_id'";
	    $query=$this->db->query($sql);
	    return isset($query->row['name'])?$query->row['name']:'';
	}

	public function getProductID($model = ''){
		if(empty($model)){
			return false;
		}

		$sql = "select product_id from ".DB_PREFIX."product where model = '".$model."'";
		$query=$this->db->query($sql);

		return $query->row;
	}

	public function getCategoryID($name = ''){
		if(empty($name)){
			return false;
		}

		$sql ="select category_id from ".DB_PREFIX."category_description where name='".$name."'";

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function deleteImage($product_id=0){
		if($product_id==0){
			return false;
		}

		$sql =" delete from  ".DB_PREFIX."product_image where product_id = '".$product_id."'";

		return $this->db->query($sql);

	}

	public function deleteSpicail($product_id=0){
		if($product_id==0){
			return false;
		}

		$sql =" delete from  ".DB_PREFIX."product_special where product_id = '".$product_id."'";

		return $this->db->query($sql);

	}

	public function deleteOption($product_id=0){
		if($product_id==0){
			return false;
		}

		$sql =" delete from  ".DB_PREFIX."product_option where product_id = '".$product_id."'";
		$this->db->query($sql);

		$sql =" delete from  ".DB_PREFIX."product_option_value where product_id = '".$product_id."'";


		return $this->db->query($sql);

	}

	public function getProductOptionID($product_id=0,$option_id=0){
		if($product_id==0||$option_id==0){
			return ;
		}

		$sql = " select product_option_id from ".DB_PREFIX."product_option where product_id = '".$product_id."' and option_id = '".$option_id."' ";

		$query = $this->db->query($sql);

		return $query->row;
	}

	//option为text类型时使用
	public function getOptionDes($name = ''){
		if(empty($name)){
			return false;
		}

		$sql =" select od.option_id,od.name,o.type from ".DB_PREFIX."option_description od left join ".DB_PREFIX."option o on o.option_id = od.option_id  where od.name = '".$name."'";

		$query = $this->db->query($sql);

		return $query->row;

	}

    //option为radio,select类型时使用(需要先设置值)
	public function getOptionDesValue($name = '',$value=''){
		if(empty($name)){
			return false;
		}

		//$sql =" select od.option_id,od.name,o.type from ".DB_PREFIX."option_description od left join ".DB_PREFIX."option o on o.option_id = od.option_id  ";

		$sql = " select od.option_id,od.name as `option`,o.type,ovd.name as name,ovd.option_value_id from ".DB_PREFIX."option_description od left join ".DB_PREFIX."option o on o.option_id = od.option_id  left join ".DB_PREFIX."option_value_description ovd on ovd.option_id = o.option_id where od.name = '".$name."' and ovd.name = '".$value."'";

		$query = $this->db->query($sql);

		return $query->row;

	}

	public function getOptionValueList($name=""){
		$data = array();
		if(empty($name)){
			return $data;
		}

		$sql = "select ovd.name from ".DB_PREFIX."option_value_description ovd left join ".DB_PREFIX."option_description od on od.option_id = ovd.option_id where od.name = '".$name."'";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function insertOptionValueID($name="",$value=""){
		if($name=='' && $value=='' ){
			return false;
		}

		$sql = "select option_id from ".DB_PREFIX."option_description where name='".$name."'";
		$query = $this->db->query($sql);

		$option=$query->row;
		if(!$option){
			return false;
		}

		$option_id = $option['option_id'];

		$sql  = " INSERT INTO  ".DB_PREFIX."option_value(option_id,image,sort_order) value('".$option_id."','',0)";
		$this->db->query($sql);
		$option_value_id = $this->db->getLastId();
		$sql = " INSERT INTO ".DB_PREFIX."option_value_description(option_value_id,language_id,option_id,name) value('".$option_value_id."','1','".$option_id."','".$this->db->escape($value)."')";
		$this->db->query($sql);
		return $option_value_id;
	}

	public function getFilterID($filter=''){
		$data = array();
		if(empty($filter)){
			return $data;
		}

		$sql = "select filter_id from ".DB_PREFIX."filter_description where name in('".$filter."')";
		$query = $this->db->query($sql);
		return $query->rows;

	}

}
?>