<?php

class ModelShippingPostenMyPack extends Controller {

	private $error = array(); 
	private $name = NULL;
	
	function getQuote($address) {  

		// SET NAME
		$this->name = basename(__FILE__, '.php');

		// LOAD LANGUAGE
		$this->language->load('shipping/' . $this->name);

		// SQL TO GET WEIGHT VALUE
		
		$sql = "SELECT value FROM " . DB_PREFIX . "weight_class WHERE weight_class_id = '" . (int)$this->config->get('config_weight_class_id') . "'";

		// GET VALUE FROM QUERY
		$weight_value = $this->db->query($sql)->row['value'];

		// IF NO VALUE, SET TO DEFAULT
		if (!$weight_value) { $weight_value = 1; }
		
		// SQL TO GET GEO ZONE
		$sql = "SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone 
		WHERE geo_zone_id = '" . (int)$this->config->get($this->name . '_geo_zone_id') . "' 
		AND country_id    = '" . (int)$address['country_id'] . "' 
		AND (zone_id      = '" . (int)$address['zone_id'] . "' 
		OR zone_id        = '0')";
		
		// GET DATA FROM QUERY
		$query = $this->db->query($sql);
		
	
	// CHECK IF GEO ZONE IS OK
		if (!$this->config->get($this->name . '_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}
		
	
	// CHECK IF CUSTOMER GROUP IS OK
		if (!$this->config->get($this->name . '_customer_group_id')) {
			$status = true;
		} elseif ($this->config->get($this->name . '_customer_group_id')==$this->customer->getCustomerGroupId()) {
			$status = true;
		} else {
			$status = false;
		}
		
		
		
		// SETTINGS
		$method_data 	= array();
		
		$cost 			= NULL;
		$weight 		= $this->cart->getWeight();
		$sub_total 		= $this->cart->getSubTotal();

		
		$min_sum		= $this->config->get($this->name . '_min_sum');
		
		$max_sum		= $this->config->get($this->name . '_max_sum');

		
		
		// CHECK IF SUM IS MORE THEN MIN SUM
		
		if (($min_sum>0)AND($min_sum>$sub_total)) 	{ $status = false; }
		
		
		
		// CHECK IF SUM IS LESS THEN MAX SUM
		
		if (($max_sum>0)AND($max_sum<$sub_total)) 	{ $status = false; }

		
		
		// CHECK IF WEIGHT IS LOWER THEN MAX
		
		if ($weight>(20.00 * $weight_value)) 		{ $status = false; }

		
		
		// IF OK, GO ON
		if ($status) {
		
			if     (($weight<=(20.00 * $weight_value)) AND ($weight>(15.00 * $weight_value))) 	{ $cost = $this->config->get($this->name . '_teir_5_cost'); }
			elseif (($weight<=(15.00 * $weight_value)) AND ($weight>(10.00 * $weight_value)))	{ $cost = $this->config->get($this->name . '_teir_4_cost'); }
			elseif (($weight<=(10.00 * $weight_value)) AND ($weight>(5.00  * $weight_value)))	{ $cost = $this->config->get($this->name . '_teir_3_cost'); }
			elseif (($weight<=(5.00  * $weight_value)) AND ($weight>(3.00  * $weight_value)))	{ $cost = $this->config->get($this->name . '_teir_2_cost'); }
			elseif (($weight<=(3.00  * $weight_value)) AND ($weight>0))							{ $cost = $this->config->get($this->name . '_teir_1_cost'); }
			else 																				{ $cost = NULL; }
			
			$quote_data = array();
			
			if ((float)$cost) {
	
      			$quote_data[$this->name] = array(
        			'code'         => $this->name . '.' . $this->name,
        			'title'        => $this->language->get('text_title'),
        			'cost'         => (float)$cost,
        			'tax_class_id' => $this->config->get($this->name . '_tax_class_id'),
					'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get($this->name . '_tax_class_id'), $this->config->get('config_tax')))
      			);

      			$method_data = array(
        			'code'       => $this->name,
        			'title'      => $this->language->get('text_title'),
        			'quote'      => $quote_data,
					'sort_order' => $this->config->get($this->name . '_sort_order'),
        			'error'      => false
      			);
			}
		}
	
		return $method_data;
	}
}

?>