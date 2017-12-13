<?php
class ModelToolExcelexport extends Model {

  
	public function getLanguages(){
	  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language");
    return $query->rows;
	}
  
	public function getShopName(){
	  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `group` = 'config' AND `key` = 'config_title'");
    if($query->row){return $query->row['value'];}
    else{return '';}
	}
  
	public function getLanguageFolder($lang_id){
	  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "language WHERE language_id = '".(int)$lang_id."'");
    return $query->row['directory'];
	}
	
	public function getProductName($product_id,$language_id){
	  $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE product_id = '".(int)$product_id."' AND language_id = '".(int)$language_id."'");
    if($query->row AND $query->row['name'] != ''){return $query->row['name'];}
    else{return '-';}
	}
	
	public function getProductDescription($product_id,$language_id){
	  $query = $this->db->query("SELECT description FROM " . DB_PREFIX . "product_description WHERE product_id = '".(int)$product_id."' AND language_id = '".(int)$language_id."'");
    if($query->row AND $query->row['description'] != ''){return $query->row['description'];}
    else{return '-';}
	}
	
	public function getProductMetaDescription($product_id,$language_id){
	  $query = $this->db->query("SELECT meta_description FROM " . DB_PREFIX . "product_description WHERE product_id = '".(int)$product_id."' AND language_id = '".(int)$language_id."'");
    if($query->row AND $query->row['meta_description'] != ''){return $query->row['meta_description'];}
    else{return '-';}
	}
	
	public function getProductMetaKeyword($product_id,$language_id){
	  $query = $this->db->query("SELECT meta_keyword FROM " . DB_PREFIX . "product_description WHERE product_id = '".(int)$product_id."' AND language_id = '".(int)$language_id."'");
    if($query->row AND $query->row['meta_keyword'] != ''){return $query->row['meta_keyword'];}
    else{return '-';}
	}
	
	public function getProductLengthClass($length_class_id){
	  $query = $this->db->query("SELECT title FROM " . DB_PREFIX . "length_class_description WHERE length_class_id = '".(int)$length_class_id."'");
    if($query->row){return $query->row['title'];}
    else{return '-';}
	}
	
	public function getProductWeightClass($weight_class_id){
	  $query = $this->db->query("SELECT title FROM " . DB_PREFIX . "weight_class_description WHERE weight_class_id = '".(int)$weight_class_id."'");
    if($query->row){return $query->row['title'];}
    else{return '-';}
	}
	
	public function getProductStockStatus($stock_status_id){
	  $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "stock_status WHERE stock_status_id  = '".(int)$stock_status_id."'");
    if($query->row){return $query->row['name'];}
    else{return '-';}
	}
	
	public function getProductManufacturer($manufacturer_id){
    $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id  = '".(int)$manufacturer_id."'");
    if($query->row){return $query->row['name'];}
    else{return '-';}
	}
	
	public function getProductTaxClass($tax_class_id){
	  $query = $this->db->query("SELECT title FROM " . DB_PREFIX . "tax_class WHERE tax_class_id = '".(int)$tax_class_id."'");
    if($query->row){return $query->row['title'];}
    else{return '-';}
	}
	
	public function getDefaultCurrencySL(){
	  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE value = 1");
    return $query->row['symbol_left'];
	}
	
	public function getDefaultCurrencySR(){
	  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE value = 1");
    return $query->row['symbol_right'];
	}
	
	
	
	
	public function getProductCategory($product_id,$language_id){
	  $category_return = '';
	  $splitter        = ' > ';
	  
	  $query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id  = '".(int)$product_id."' ORDER by category_id ASC");
    foreach($query->rows AS $category_id){
      $qcat = $this->db->query("SELECT name FROM " . DB_PREFIX . "category_description WHERE category_id  = '".$category_id['category_id']."' AND language_id = '".(int)$language_id."'");
      $category_info = $qcat->row;
      
      if($category_return == ''){$category_return .= $category_info['name'];}
      else{$category_return .= $splitter.$category_info['name'];}
    }
    return $category_return;
  }
  
	public function getProductAtribute($product_id,$language_id){
	  $atribute_return = '';
	  $splitter        = '=';
	
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id  = '".(int)$product_id."'");
    foreach($query->rows as $atribute){
      $atribute_group = $this->db->query("SELECT name FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '".(int)$atribute['attribute_id']."' AND language_id = '".(int)$language_id."'");
      $atribute_return .= $atribute_group->row['name'].$splitter.$atribute['text'].';';
    }
  	return $atribute_return;
  }
  
	public function getProductOption($product_id,$language_id){
	  $atribute_return = '';
	  $splitter        = ':';
	
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id  = '".(int)$product_id."'");
    foreach($query->rows as $product_option){
    
      $option_description = $this->db->query("SELECT name FROM " . DB_PREFIX . "option_description WHERE option_id = '".(int)$product_option['option_id']."' AND language_id = '".(int)$language_id."'");
        
  	  $atributes = '';
      $query     = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_id  = '".(int)$product_id."'");
      foreach($query->rows as $product_option_value){
      
        $option_value_description = $this->db->query("SELECT name FROM " . DB_PREFIX . "option_value_description WHERE option_value_id  = '".(int)$product_option_value['option_value_id']."' AND language_id = '".(int)$language_id."'");
  
        if($atributes == ''){$prefix = '';}else{$prefix = ';';}
        $atributes .= $prefix.$option_value_description->row['name'].'('.$product_option_value['price_prefix'].$this->getDefaultCurrencySL().$product_option_value['price'].$this->getDefaultCurrencySR().')';
      } 
      
      $atribute_return .= $option_description->row['name'].'['.$atributes.'];';
      
    }
  	return $atribute_return;
  }
  
	public function getProductImages($product_id){
	
	  $images_return = '';
	  $splitter        = ';
';
	  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id  = '".(int)$product_id."'");
    $images_return .= $query->row['image'].$splitter;
    
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id  = '".(int)$product_id."'");
    foreach($query->rows as $image){
      $images_return .= $image['image'].$splitter;
    }
  	return $images_return;
  }


	public function exportExcel($data){
	  $get_data = array();
	
  	if(isset($data['download']['product_id'])){$get_data[] = 'product_id';}
  	if(isset($data['download']['model'])){$get_data[] = 'model';}
  	if(isset($data['download']['category'])){$get_data[] = 'category';}
  	if(isset($data['download']['name'])){$get_data[] = 'name';}
  	if(isset($data['download']['description'])){$get_data[] = 'description';}
  	if(isset($data['download']['manufacturer'])){$get_data[] = 'manufacturer';}
  	if(isset($data['download']['price'])){$get_data[] = 'price';}
  	if(isset($data['download']['tax_class'])){$get_data[] = 'tax_class';}
  	if(isset($data['download']['points'])){$get_data[] = 'points';}
  	if(isset($data['download']['quantity'])){$get_data[] = 'quantity';}
  	if(isset($data['download']['minimum'])){$get_data[] = 'minimum';}
  	if(isset($data['download']['stock_status'])){$get_data[] = 'stock_status';}
  	if(isset($data['download']['weight'])){$get_data[] = 'weight';}
  	if(isset($data['download']['weight_class'])){$get_data[] = 'weight_class';}
  	if(isset($data['download']['length'])){$get_data[] = 'length';}
  	if(isset($data['download']['length_class'])){$get_data[] = 'length_class';}
  	if(isset($data['download']['width'])){$get_data[] = 'width';}
  	if(isset($data['download']['height'])){$get_data[] = 'height';}
  	if(isset($data['download']['sku'])){$get_data[] = 'sku';}
	if(isset($data['download']['cost'])){$get_data[] = 'cost';}
  	if(isset($data['download']['upc'])){$get_data[] = 'upc';}
  	if(isset($data['download']['location'])){$get_data[] = 'location';}
  	if(isset($data['download']['images'])){$get_data[] = 'images';}
  	if(isset($data['download']['product_attribute'])){$get_data[] = 'product_attribute';}
  	if(isset($data['download']['product_option'])){$get_data[] = 'product_option';}
  	if(isset($data['download']['meta_description'])){$get_data[] = 'meta_description';}
  	if(isset($data['download']['meta_keyword'])){$get_data[] = 'meta_keyword';}
  	if(isset($data['download']['viewed'])){$get_data[] = 'viewed';}
  	if(isset($data['download']['date_available'])){$get_data[] = 'date_available';}
  	if(isset($data['download']['date_added'])){$get_data[] = 'date_added';}
  	if(isset($data['download']['date_modified'])){$get_data[] = 'date_modified';}
  	if(isset($data['download']['status'])){$get_data[] = 'status';}
  	if(isset($data['download']['sort_order'])){$get_data[] = 'sort_order';}
  	if(isset($data['download']['ean'])){$get_data[] = 'ean';}
  	if(isset($data['download']['jan'])){$get_data[] = 'jan';}
  	if(isset($data['download']['isbn'])){$get_data[] = 'isbn';}
  	if(isset($data['download']['mpn'])){$get_data[] = 'mpn';}
  	
  	
  	
  	
  	
  	
    $export = array();
    $i = 0;
	  $all_products = $this->db->query("SELECT * FROM " . DB_PREFIX . "product");
    foreach($all_products->rows as $product){
      foreach($get_data as $dat){
        if($dat != 'name' AND $dat != 'description' AND $dat != 'meta_description' AND 
           $dat != 'meta_keyword' AND $dat != 'product_attribute' AND $dat != 'product_option' AND 
           $dat != 'length_class' AND $dat != 'weight_class' AND $dat != 'stock_status' AND 
           $dat != 'manufacturer' AND $dat != 'category' AND $dat != 'images' AND 
           $dat != 'tax_class'){
           
           if($dat == 'price'){
             $export[$i][$dat] = $this->getDefaultCurrencySL().$product[$dat].$this->getDefaultCurrencySR();
           }else{
             
             if(isset($product[$dat])){$export[$i][$dat] = $product[$dat];}
             else{$export[$i][$dat] = "";}
           }
        }else{
          if($dat == 'name'){$export[$i][$dat] = $this->getProductName($product['product_id'],$data['language_id']);}
          if($dat == 'description'){$export[$i][$dat] = $this->getProductDescription($product['product_id'],$data['language_id']);}
          if($dat == 'meta_description'){$export[$i][$dat] = $this->getProductMetaDescription($product['product_id'],$data['language_id']);}
          if($dat == 'meta_keyword'){$export[$i][$dat] = $this->getProductMetaKeyword($product['product_id'],$data['language_id']);}
          if($dat == 'length_class'){$export[$i][$dat] = $this->getProductLengthClass($product['length_class_id']);}
          if($dat == 'weight_class'){$export[$i][$dat] = $this->getProductWeightClass($product['weight_class_id']);}
          if($dat == 'stock_status'){$export[$i][$dat] = $this->getProductStockStatus($product['stock_status_id']);}
          if($dat == 'manufacturer'){$export[$i][$dat] = $this->getProductManufacturer($product['manufacturer_id']);}
          if($dat == 'category'){$export[$i][$dat] = $this->getProductCategory($product['product_id'],$data['language_id']);}
          if($dat == 'tax_class'){$export[$i][$dat] = $this->getProductTaxClass($product['tax_class_id']);}
          if($dat == 'product_attribute'){$export[$i][$dat] = $this->getProductAtribute($product['product_id'],$data['language_id']);}
          if($dat == 'product_option'){$export[$i][$dat] = $this->getProductOption($product['product_id'],$data['language_id']);}
          if($dat == 'images'){$export[$i][$dat] = $this->getProductImages($product['product_id']);}
        }
      }
      $i++;
    }
    
    $return['cols'] = $get_data;
    $return['rows'] = $export;
    $return['language_id'] = $data['language_id'];
    
    
    if(count($return['cols'])){return $this->createExcel($return);}
    else{return false;}
    
    
	}

	public function createExcel($data){
	
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/London');
    require_once '../system/phpexcel/Classes/PHPExcel.php';
    
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("DEAWid, DEAWid@seznam.cz")
    							 ->setLastModifiedBy("DEAWid")
    							 ->setTitle("EXCEL BACKUP ".$this->getShopName()." FROM ".date("d-m-Y",time()))
    							 ->setSubject("EXCEL BACKUP ".$this->getShopName())
    							 ->setDescription("EXCEL BACKUP ".$this->getShopName()." FROM ".date("d-m-Y",time()))
    							 ->setKeywords("EXCEL BACKUP ".$this->getShopName()." FROM ".date("d-m-Y",time()))
    							 ->setCategory("EXCEL BACKUP ".$this->getShopName()." FROM ".date("d-m-Y",time()));
  
    if(!isset($_COOKIE['language'])){$language = 'english';}
    else{$language = $_COOKIE['language'];}
    require(DIR_LANGUAGE.$this->getLanguageFolder($data['language_id']).'/tool/excel_export.php');
  
    $i = 0;
  	foreach($data['cols'] as $col){
  	  $i++;
  	  $lang_title = $_['text_'.$col];
      $objPHPExcel->getActiveSheet()->setCellValue($this->IncToAbc($i).'1', $lang_title);
    }
    
    $objPHPExcel->getActiveSheet()->getStyle('A1:'.$this->IncToAbc($i).'1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A1:'.$this->IncToAbc($i).'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('A1:'.$this->IncToAbc($i).'1')->getFill()->getStartColor()->setARGB('FFA0A0A0');
    
    $row_num = 2;
    $i = 0;
    foreach($data['rows'] as $row){
        $col_num = 1;
    	  foreach($data['cols'] as $col){
    	    $coordinate = $this->IncToAbc($col_num).$row_num;
    	    $cell_value = htmlspecialchars_decode($row[$col]);
          //$objPHPExcel->getActiveSheet()->setCellValue($coordinate, $cell_value);
          $objPHPExcel->getActiveSheet()->setCellValueExplicit($coordinate, $cell_value, PHPExcel_Cell_DataType::TYPE_STRING);
          $col_num++;
        }
      $i++;
      $row_num++;
    }
  
    $objPHPExcel->setActiveSheetIndex(0);
  
    require_once '../system/phpexcel/Classes/PHPExcel/IOFactory.php';
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('../download/XLS-BACKUP-'.date("d-m-Y_H-i",time()).'.xls');
    //$objWriter->save(str_replace('.php', '.xls', __FILE__));
    
    return 'XLS-BACKUP-'.date("d-m-Y_H-i",time()).'.xls';
	}

	public function IncToAbc($num){
  	if($num == 1){return 'A';}
  	if($num == 2){return 'B';}
  	if($num == 3){return 'C';}
  	if($num == 4){return 'D';}
  	if($num == 5){return 'E';}
  	if($num == 6){return 'F';}
  	if($num == 7){return 'G';}
  	if($num == 8){return 'H';}
  	if($num == 9){return 'I';}
  	if($num == 10){return 'J';}
  	if($num == 11){return 'K';}
  	if($num == 12){return 'L';}
  	if($num == 13){return 'M';}
  	if($num == 14){return 'N';}
  	if($num == 15){return 'O';}
  	if($num == 16){return 'P';}
  	if($num == 17){return 'Q';}
  	if($num == 18){return 'R';}
  	if($num == 19){return 'S';}
  	if($num == 20){return 'T';}
  	if($num == 21){return 'U';}
  	if($num == 22){return 'V';}
  	if($num == 23){return 'W';}
  	if($num == 24){return 'X';}
  	if($num == 25){return 'Y';}
  	if($num == 26){return 'Z';}
  	if($num == 27){return 'AA';}
  	if($num == 28){return 'AB';}
  	if($num == 29){return 'AC';}
  	if($num == 30){return 'AD';}
  	if($num == 31){return 'AE';}
  	if($num == 32){return 'AF';}
  	if($num == 33){return 'AG';}
  	if($num == 34){return 'AH';}
  	if($num == 35){return 'AI';}
  	if($num == 36){return 'AJ';}
  	if($num == 37){return 'AK';}
  	if($num == 38){return 'AL';}
  	if($num == 39){return 'AM';}
  	if($num == 40){return 'AN';}
	}
}
?>