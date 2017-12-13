<?php
class ControllerShippingBring extends Controller { 
	private $error = array();
	
	public function index() {  
		$this->load->language('shipping/bring');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('localisation/weight_class');
		$this->load->model('localisation/length_class');
		$this->load->model('setting/setting');
				 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bring', $this->request->post);		
			$this->session->data['success'] = $this->language->get('text_success');				
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['entry_identificator'] = $this->language->get('entry_identificator');
		$this->data['entry_bring_products'] = $this->language->get('entry_bring_products');
		$this->data['entry_from_postalnumber'] = $this->language->get('entry_from_postalnumber');
		$this->data['entry_priceadjust'] = $this->language->get('entry_priceadjust');
		$this->data['entry_use_volume'] = $this->language->get('entry_use_volume');
		$this->data['entry_ship_at_postaloffice'] = $this->language->get('entry_ship_at_postaloffice');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_choose_grams'] = $this->language->get('entry_choose_grams');
		$this->data['entry_choose_centimeter'] = $this->language->get('entry_choose_centimeter');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_free_shipping'] = $this->language->get('entry_free_shipping');

		$this->data['bring_products_data'] = $this->language->get('bring_products_data');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
		$this->data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

 		if (isset($this->error['warning'])) { $this->data['error_warning'] = $this->error['warning']; } 
 		else { $this->data['error_warning'] = ''; }

    // Breadcrumbs
    $this->document->breadcrumbs = array();
   	$this->document->breadcrumbs[] = array(
     		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
     		'text'      => $this->language->get('text_home'),
    		'separator' => FALSE
   	);

   	$this->document->breadcrumbs[] = array(
     		'href'      => HTTPS_SERVER . 'index.php?route=extension/shipping&token=' . $this->session->data['token'],
     		'text'      => $this->language->get('text_shipping'),
    		'separator' => ' :: '
   	);
		
   	$this->document->breadcrumbs[] = array(
     		'href'      => HTTPS_SERVER . 'index.php?route=shipping/bring&token=' . $this->session->data['token'],
     		'text'      => $this->language->get('heading_title'),
    		'separator' => ' :: '
   	);
		
		// Buttons
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=shipping/bring&token=' . $this->session->data['token'];
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/shipping&token=' . $this->session->data['token']; 

		// Geo zones
		$this->load->model('localisation/geo_zone');
		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();
		$this->data['geo_zones'] = $geo_zones;
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');

		// Tax Classes
		$this->load->model('localisation/tax_class');
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		// Free shipping products
		$this->load->model('catalog/product');
				
		if (isset($this->request->post['bring_fs_products'])) {
			$products = explode(',', $this->request->post['bring_fs_products']);
		} else {		
			$products = explode(',', $this->config->get('bring_fs_products'));
		}
		
		$this->data['bring_fs_products'] = $products;
		$this->data['bring_fs_products_data'] = array();
		
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_info) {
				$this->data['bring_fs_products_data'][] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				);
			}
		}	
			
		
    // Additional data
		$this->data['bring_status'] = isset($this->request->post['bring_status']) ? $this->request->post['bring_status'] : $this->config->get('bring_status');
		$this->data['bring_identificator'] = isset($this->request->post['bring_identificator']) ? $this->request->post['bring_identificator'] : $this->config->get('bring_identificator');
		$this->data['bring_from_postalnumber'] = isset($this->request->post['bring_from_postalnumber']) ? $this->request->post['bring_from_postalnumber'] : $this->config->get('bring_from_postalnumber');
		$this->data['bring_priceadjust'] = isset($this->request->post['bring_priceadjust']) ? $this->request->post['bring_priceadjust'] : $this->config->get('bring_priceadjust');
		$this->data['bring_sort_order'] = isset($this->request->post['bring_sort_order']) ? $this->request->post['bring_sort_order'] : $this->config->get('bring_sort_order');
		$this->data['bring_products'] = isset($this->request->post['bring_products']) ? $this->request->post['bring_products'] : $this->config->get('bring_products');
		$this->data['bring_use_volume'] = isset($this->request->post['bring_use_volume']) ? $this->request->post['bring_use_volume'] : $this->config->get('bring_use_volume');
		$this->data['bring_ship_at_postaloffice'] = isset($this->request->post['bring_ship_at_postaloffice']) ? $this->request->post['bring_ship_at_postaloffice'] : $this->config->get('bring_ship_at_postaloffice');
		$this->data['bring_geo_zone_id'] = isset($this->request->post['bring_geo_zone_id']) ? $this->request->post['bring_geo_zone_id'] : $this->config->get('bring_geo_zone_id');
		$this->data['bring_weight_class_id'] = isset($this->request->post['bring_weight_class_id']) ? $this->request->post['bring_weight_class_id'] : $this->config->get('bring_weight_class_id');
		$this->data['bring_length_class_id'] = isset($this->request->post['bring_length_class_id']) ? $this->request->post['bring_length_class_id'] : $this->config->get('bring_length_class_id');
		$this->data['bring_tax_class_id'] = isset($this->request->post['bring_tax_class_id']) ? $this->request->post['bring_tax_class_id'] : $this->config->get('bring_tax_class_id');
		


		$this->template = 'shipping/bring.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
		
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/bring')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		else if ($this->request->post['bring_identificator'] == "") {
			$this->error['warning'] = $this->language->get('error_identificator');
		}
		else if ($this->request->post['bring_from_postalnumber'] == "") {
			$this->error['warning'] = $this->language->get('error_from_postalnumber');
		}
		else if (!isset($this->request->post['bring_products'])) {
			$this->error['warning'] = $this->language->get('error_products');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>