<?php
/*
 *	location: admin/model
 */

class ModelDQuickcheckoutOrder extends Model {

	public function isCartEmpty() {
		return (( !$this->cart->hasProducts() && empty($this->session->data['vouchers']) ) 
			|| !$this->cart->hasStock()) ? true : false;
	}

	public function showPrice(){
		return (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) ? true : false;
	}

	public function showConfirm(){

		$result = (( !$this->cart->hasProducts() && empty($this->session->data['vouchers']) ) 
			|| (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) ? false : true;

		if ($this->cart->getTotal() < $this->session->data['d_quickcheckout']['general']['min_order']['value']) {
        	$result = false;
        } 

        if ($this->cart->countProducts() < $this->session->data['d_quickcheckout']['general']['min_quantity']['value']) {
        	$result = false;
        }

        return $result;
	}

	public function addOrder($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET 
			store_id = '" . (int)$data['store_id'] . "', 
			store_name = '" . $this->db->escape($data['store_name']) . "', 
			store_url = '" . $this->db->escape($data['store_url']) . "', 
			total = '" . (float)$data['total'] . "', 
			payment_country_id = '" . (int)$data['payment_country_id'] . "',  
			payment_zone_id = '" . (int)$data['payment_zone_id'] . "', 
			affiliate_id = '" . (int)$data['affiliate_id'] . "', 
			commission = '" . (float)$data['commission'] . "', 
			language_id = '" . (int)$data['language_id'] . "', 
			currency_id = '" . (int)$data['currency_id'] . "', 
			currency_code = '" . $this->db->escape($data['currency_code']) . "', 
			currency_value = '" . (float)$data['currency_value'] . "', 
			ip = '" . $this->db->escape($data['ip']) . "', 
			forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "', 
			user_agent = '" . $this->db->escape($data['user_agent']) . "', 
			accept_language = '" . $this->db->escape($data['accept_language']) . "', 
			date_added = NOW(), 
			date_modified = NOW()");
			$order_id = $this->db->getLastId();
			return $order_id;
	}

	public function updateOrder($order_id,$data) {
		//$this->event->trigger('pre.order.add', $data);
//  var_dump($order_id);
		$query = "UPDATE `" . DB_PREFIX . "order` SET 
			invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', 
			store_id = '" . (int)$data['store_id'] . "', 
			store_name = '" . $this->db->escape($data['store_name']) . "', 
			store_url = '" . $this->db->escape($data['store_url']) . "', 
			customer_id = '" . (int)$data['customer_id'] . "', 
			customer_group_id = '" . (int)$data['customer_group_id'] . "', 
			firstname = '" . $this->db->escape($data['firstname']) . "', 
			lastname = '" . $this->db->escape($data['lastname']) . "', 
			email = '" . $this->db->escape($data['email']) . "', 
			telephone = '" . $this->db->escape($data['telephone']) . "', 
			fax = '" . $this->db->escape($data['fax']) . "', 

			payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', 
			payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', 
			payment_company = '" . $this->db->escape($data['payment_company']) . "', 
			payment_company_id = '" . $this->db->escape($data['payment_company_id']) . "', 
			payment_tax_id = '" . $this->db->escape($data['payment_tax_id']) . "', 
			
			payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', 
			payment_address_2 = '" . $this->db->escape($data['payment_address_2']) . "', 
			payment_city = '" . $this->db->escape($data['payment_city']) . "', 
			payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', 
			payment_country = '" . $this->db->escape($data['payment_country']) . "', 
			payment_country_id = '" . (int)$data['payment_country_id'] . "', 
			payment_zone = '" . $this->db->escape($data['payment_zone']) . "', 
			payment_zone_id = '" . (int)$data['payment_zone_id'] . "', 
			payment_address_format = '" . $this->db->escape($data['payment_address_format']) . "', 

			payment_method = '" . $this->db->escape($data['payment_method']) . "', 
			payment_code = '" . $this->db->escape($data['payment_code']) . "', 
			shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', 
			shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', 
			shipping_company = '" . $this->db->escape($data['shipping_company']) . "', 
			shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', 
			shipping_address_2 = '" . $this->db->escape($data['shipping_address_2']) . "', 
			shipping_city = '" . $this->db->escape($data['shipping_city']) . "', 
			shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', 
			shipping_country = '" . $this->db->escape($data['shipping_country']) . "', 
			shipping_country_id = '" . (int)$data['shipping_country_id'] . "', 
			shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', 
			shipping_zone_id = '" . (int)$data['shipping_zone_id'] . "', 
			shipping_address_format = '" . $this->db->escape($data['shipping_address_format']) . "', 

			shipping_method = '" . $this->db->escape($data['shipping_method']) . "', 
			shipping_code = '" . $this->db->escape($data['shipping_code']) . "', 
			comment = '" . $this->db->escape($data['comment']) . "', 
			total = '" . (float)$data['total'] . "', 
			affiliate_id = '" . (int)$data['affiliate_id'] . "', 
			commission = '" . (float)$data['commission'] . "',"; 

 

 

		$query = $query. " language_id = '" . (int)$data['language_id'] . "', 
			currency_id = '" . (int)$data['currency_id'] . "', 
			currency_code = '" . $this->db->escape($data['currency_code']) . "', 
			currency_value = '" . (float)$data['currency_value'] . "', 
			ip = '" . $this->db->escape($data['ip']) . "', 
			forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "', 
			user_agent = '" . $this->db->escape($data['user_agent']) . "', 
			accept_language = '" . $this->db->escape($data['accept_language']) . "', 
			date_added = NOW(), 
			date_modified = NOW()
			WHERE order_id = '" . (int)$order_id . "'";

		$this->db->query($query);

		$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'"); 
  
  $this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "'");
 
  $this->db->query("DELETE FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "'");

		// Products
		foreach ($data['products'] as $product) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "'");

			$order_product_id = $this->db->getLastId();

			foreach ($product['option'] as $option) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
			}
   
   foreach ($product['download'] as $download) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_download SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', name = '" . $this->db->escape($download['name']) . "', filename = '" . $this->db->escape($download['filename']) . "', mask = '" . $this->db->escape($download['mask']) . "', remaining = '" . (int)($download['remaining'] * $product['quantity']) . "'");
			}
   
		}

		// Gift Voucher
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'"); 
		
		// Vouchers
		foreach ($data['vouchers'] as $voucher) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_voucher SET order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($voucher['description']) . "', code = '" . $this->db->escape($voucher['code']) . "', from_name = '" . $this->db->escape($voucher['from_name']) . "', from_email = '" . $this->db->escape($voucher['from_email']) . "', to_name = '" . $this->db->escape($voucher['to_name']) . "', to_email = '" . $this->db->escape($voucher['to_email']) . "', voucher_theme_id = '" . (int)$voucher['voucher_theme_id'] . "', message = '" . $this->db->escape($voucher['message']) . "', amount = '" . (float)$voucher['amount'] . "'");

			$order_voucher_id = $this->db->getLastId();

			$voucher_id = $this->addVoucher($order_id, $voucher);

			$this->db->query("UPDATE " . DB_PREFIX . "order_voucher SET voucher_id = '" . (int)$voucher_id . "' WHERE order_voucher_id = '" . (int)$order_voucher_id . "'");
		}

		// Totals	
	 	$this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "'");
		foreach ($data['totals'] as $total) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', text = '" . $this->db->escape($total['text']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
		}

//		$this->event->trigger('post.order.add', $order_id);	
   //     var_dump($order_id);
		return $order_id;
	}

	public function getTotals(&$total_data, &$total, &$taxes){
		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();

		$this->load->model('setting/extension');

		$sort_order = array();

		$results = $this->model_setting_extension->getExtensions('total');

		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
		}

		array_multisort($sort_order, SORT_ASC, $results);

		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('total/' . $result['code']);

				$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
			}
		}

		foreach ($total_data as $key => $total) {
			$total_data[$key]['text'] = $this->currency->format($total['value']);
		}

		return $total_data;
	}
	
	public function getCartTotal($total){
		$this->load->language('checkout/cart');
		return sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total['value']));
    }   

    public function addVoucher($order_id, $voucher){

		if(VERSION >= '2.1.0.1'){
			$this->load->model('total/voucher');
			return $this->model_total_voucher->addVoucher($order_id, $voucher);
		}else{
			$this->load->model('checkout/voucher');
			return $this->model_checkout_voucher->addVoucher($order_id, $voucher);
		}
		
	}

}