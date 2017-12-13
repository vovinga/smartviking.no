<?php 
/****  AUTHOR  ****/
/*
/* Thorleif Jacobsen
/* TJWeb - www.tjweb.no
/* Support: thorleif.oc@tjweb.no
/* Questions: thorleif.oc@tjweb.no
/*
/****  AUTHOR  ****/

class ModelShippingBring extends Model {    
  public function getQuote($address) {
    $this->load->language('shipping/bring');
   
   	$products = $this->cart->getProducts();
   	$fs_products = explode(",",$this->config->get('bring_fs_products'));
   	
   	// Defining variables
   	$volume = 0;
   	$weight = 0;
   	$freeshipping = false;
   	$lengthClass = $this->config->get('bring_length_class_id');

   	// Run trough all products and add the total weight
   	foreach($products as $product) {
   		// Set freeshipping to true and remove weight on this product.

   	  if(in_array($product['product_id'],$fs_products)) { 
   	    $freeshipping = true;
   	  }
   	  else {  	
   		  $class = $product['length_class_id'];
   		  $l = $this->length->convert($product['length'], $class, $lengthClass);
   		  $w = $this->length->convert($product['width'], $class, $lengthClass);
   		  $h = $this->length->convert($product['height'], $class, $lengthClass);
   		  $volume_dm3 = ($l*$w*$h) / 1000 * $product['quantity'];
   		  $volume += $volume_dm3;
   		
   	    // Add weight
        $weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('bring_weight_class_id'));
      }
   	}
   	
   	// If products in cart which dont have free shipping 
   	// then calculate without the free shipping item
   	if(($weight > 0) && $freeshipping) { $freeshipping = false; }
    
    // Generate the URL for bring
    $url = "http://fraktguide.bring.no/fraktguide/products/all.json";
    $url .= "?weightInGrams=".$weight;
    $url .= "&identificator=".urlencode($this->config->get('bring_identificator'));
    $url .= "&from=".urlencode($this->config->get('bring_from_postalnumber'));
    $url .= "&to=".urlencode($address['postcode']);
    $url .= "&date=".date("Y-m-d");
    if($this->config->get('bring_use_volume')) $url .= "&volume=".($volume>0?$volume:1);
    if($this->config->get('bring_ship_at_postaloffice')) $url .= "&postingAtPostoffice=true";
    if($this->config->get('bring_priceadjust') != "") $url .= "&priceAdjustment=".$this->config->get('bring_priceadjust');
    $selectedProducts = $this->config->get('bring_products');
    foreach($selectedProducts as $v) { $url .= "&product=".urlencode($v); }
        
    // Add all products to the cart
    
    // Pre define variables
    $data         = $this->bLoadUrl($url);
    $quote_data   = array();
    $products     = array();

    // ERROR: Postal code wrong
    if(preg_match("/Given to postal code \(.*?\) is not in use for NORWAY/mis", $data)){
		  $error = $this->language->get('text_error_postalnumber');
    }
    // ERROR: Weight is zero?
    else if(preg_match("/Weight or volume must be set to positive integers/mis", $data)) {
		  $error = $this->language->get('text_error_weight');
    }
    // ERROR: Too much weight and spit packages not enabled
    else if($weight > 35000) {
      $error = $this->language->get("text_error_overweight");
    }
    // If nothings wrong, continue on!
    else {
      $json = json_decode($data);
      if(is_array($json->Product)) {
        foreach($json->Product as $key=>$product) { 
          $products[] = $product;
        }
      }
      else { $products[] = $json->Product; }
            
      foreach($products as $product) {
        if(!isset($product->GuiInformation)) continue;
      	$expectedDelivery = $product->ExpectedDelivery->FormattedExpectedDeliveryDate;
      	$productName      = $product->GuiInformation->ProductName;
        $descriptionText  = $product->GuiInformation->DescriptionText;
        $AmountWithoutVAT    = $product->Price->PackagePriceWithoutAdditionalServices->AmountWithoutVAT;
        
        $price = $AmountWithoutVAT;
        $price = ceil(floatVal($this->tax->calculate($price, $this->config->get('bring_tax_class_id'), $this->config->get('config_tax'))));
        $price = $this->currency->format($price);
        
        $quote_data[$product->ProductId] = array(
          'code'         => 'bring.'.$product->ProductId,
          'title'        => $productName."<div style='font-size: 9px; color: #000;' class='bring_hidden'>".$descriptionText."</div>",
          'cost'         => $AmountWithoutVAT,
          'tax_class_id' => $this->config->get('bring_tax_class_id'),
          'text'         => str_replace(" ","&nbsp;",$price)
        );    
      }
      
      if($freeshipping) {
        $quote_data = array();
        $quote_data['freeshipping'] = array(
          'code'         => 'bring.freeshipping',
          'title'        => $this->language->get('text_free_shipping'),
          'cost'         => 0,
          'tax_class_id' => $this->config->get('bring_tax_class_id'),
          'text'         => $this->currency->format(0)
        );    
      }
    }

    return $this->returnMethod($quote_data, isset($error) ? $error : false);
  }
  
  private function returnMethod($quote_data, $error) {
    $method_data = array(
      'code'       => 'bring',
      'title'      => $this->language->get('text_title'),
      'quote'      => $quote_data,
      'sort_order' => $this->config->get('bring_sort_order'),
      'error'      => isset($error) ? $error : false
    ); 
    return $method_data;
  }
    
  private function bLoadUrl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
  }
}
?>