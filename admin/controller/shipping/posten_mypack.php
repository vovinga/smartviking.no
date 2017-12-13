<?php

class ControllerShippingPostenMypack extends Controller {

	private $error = array(); 
	private $name = NULL;
	
	public function index() {  

		// SET NAME
		$this->name = basename(__FILE__, '.php');
	
		// LOAD LANGUAGE
		$this->language->load('shipping/' . $this->name);

		// SET META TITLE
		$this->document->setTitle($this->language->get('heading_title'));
		
		// LOAD SETTINGS
		$this->load->model('setting/setting');
		
		// IF POST IS OK
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
			// SAVE SETTINGS
			$this->model_setting_setting->editSetting($this->name, $this->request->post);		
			
			// SET SUCCESS MSG
			$this->session->data['success'] = $this->language->get('text_success');
			
			// SEND USER TO MODULE LIST
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		// SET TITLE
		$this->data['heading_title'] 			= $this->language->get('heading_title');

		// SET SELECT
		$this->data['text_enabled'] 			= $this->language->get('text_enabled');
		$this->data['text_disabled'] 			= $this->language->get('text_disabled');
		$this->data['text_all_zones'] 			= $this->language->get('text_all_zones');
		$this->data['text_all_groups'] 			= $this->language->get('text_all_groups');
		$this->data['text_none'] 				= $this->language->get('text_none');
		
		// SET DEFAULTS
		$this->data['entry_tax_class'] 			= $this->language->get('entry_tax_class');
		$this->data['entry_geo_zone'] 			= $this->language->get('entry_geo_zone');
		$this->data['entry_status'] 			= $this->language->get('entry_status');
		$this->data['entry_sort_order'] 		= $this->language->get('entry_sort_order');
		
		$this->data['entry_customer_group']		= $this->language->get('entry_customer_group');

		$this->data['entry_min_sum'] 				= $this->language->get('entry_min_sum');
		$this->data['entry_max_sum'] 				= $this->language->get('entry_max_sum');

		$this->data['entry_teir_1_cost'] 				= $this->language->get('entry_teir_1_cost');
		$this->data['entry_teir_2_cost'] 				= $this->language->get('entry_teir_2_cost');
		$this->data['entry_teir_3_cost'] 				= $this->language->get('entry_teir_3_cost');
		$this->data['entry_teir_4_cost'] 				= $this->language->get('entry_teir_4_cost');
		$this->data['entry_teir_5_cost'] 				= $this->language->get('entry_teir_5_cost');
		
		$this->data['button_save'] 				= $this->language->get('button_save');
		$this->data['button_cancel'] 			= $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) 	{ $this->data['error_warning'] = $this->error['warning']; } 
		else 									{ $this->data['error_warning'] = ''; }

		// BREADCRUMBS
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/' . $this->name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		// ACTIONS
		$this->data['action'] = $this->url->link('shipping/' . $this->name, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		// TAX CLASSES
		$this->load->model('localisation/tax_class');
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		// GEO ZONES
		$this->load->model('localisation/geo_zone');
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		// CUSTOMER GROUPS
		$this->load->model('sale/customer_group');
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
		
		// MIN SUM
		if (isset($this->request->post[$this->name . '_min_sum'])) 					{ $this->data[$this->name . '_min_sum'] = (float)$this->request->post[$this->name . '_min_sum']; } 
		else 																		{ $this->data[$this->name . '_min_sum'] = (float)$this->config->get($this->name . '_min_sum'); }

		// MAX SUM
		if (isset($this->request->post[$this->name . '_max_sum'])) 					{ $this->data[$this->name . '_max_sum'] = (float)$this->request->post[$this->name . '_max_sum']; } 
		else 																		{ $this->data[$this->name . '_max_sum'] = (float)$this->config->get($this->name . '_max_sum'); }
		
		// TEIR 1 COST
		if (isset($this->request->post[$this->name . '_teir_1_cost'])) 				{ $this->data[$this->name . '_teir_1_cost'] = (float)$this->request->post[$this->name . '_teir_1_cost']; } 
		else 																		{ $this->data[$this->name . '_teir_1_cost'] = (float)$this->config->get($this->name . '_teir_1_cost'); }
		
		// TEIR 2 COST
		if (isset($this->request->post[$this->name . '_teir_2_cost'])) 				{ $this->data[$this->name . '_teir_2_cost'] = (float)$this->request->post[$this->name . '_teir_2_cost']; } 
		else 																		{ $this->data[$this->name . '_teir_2_cost'] = (float)$this->config->get($this->name . '_teir_2_cost'); }
		
		// TEIR 3 COST
		if (isset($this->request->post[$this->name . '_teir_3_cost'])) 				{ $this->data[$this->name . '_teir_3_cost'] = (float)$this->request->post[$this->name . '_teir_3_cost']; } 
		else 																		{ $this->data[$this->name . '_teir_3_cost'] = (float)$this->config->get($this->name . '_teir_3_cost'); }
		
		// TEIR 4 COST
		if (isset($this->request->post[$this->name . '_teir_4_cost'])) 				{ $this->data[$this->name . '_teir_4_cost'] = (float)$this->request->post[$this->name . '_teir_4_cost']; } 
		else 																		{ $this->data[$this->name . '_teir_4_cost'] = (float)$this->config->get($this->name . '_teir_4_cost'); }

		// TEIR 5 COST
		if (isset($this->request->post[$this->name . '_teir_5_cost'])) 				{ $this->data[$this->name . '_teir_5_cost'] = (float)$this->request->post[$this->name . '_teir_5_cost']; } 
		else 																		{ $this->data[$this->name . '_teir_5_cost'] = (float)$this->config->get($this->name . '_teir_5_cost'); }


		// TAX CLASS
		if (isset($this->request->post[$this->name . '_tax_class_id'])) 			{ $this->data[$this->name . '_tax_class_id'] = $this->request->post[$this->name . '_tax_class_id']; } 
		else 																		{ $this->data[$this->name . '_tax_class_id'] = $this->config->get($this->name . '_tax_class_id'); }

		// GEO ZONE
		if (isset($this->request->post[$this->name . '_geo_zone_id'])) 				{ $this->data[$this->name . '_geo_zone_id'] = $this->request->post[$this->name . '_geo_zone_id']; } 
		else 																		{ $this->data[$this->name . '_geo_zone_id'] = $this->config->get($this->name . '_geo_zone_id'); }
		
		// CUSTOMER GROUP
		if (isset($this->request->post[$this->name . '_customer_group_id'])) 		{ $this->data[$this->name . '_customer_group_id'] = $this->request->post[$this->name . '_customer_group_id'];	} 
		else 																		{ $this->data[$this->name . '_customer_group_id'] = $this->config->get($this->name . '_customer_group_id'); }
		
		// STATUS
		if (isset($this->request->post[$this->name . '_status'])) 					{ $this->data[$this->name . '_status'] = $this->request->post[$this->name . '_status']; } 
		else 																		{ $this->data[$this->name . '_status'] = $this->config->get($this->name . '_status'); }	
	
		// SORT
		if (isset($this->request->post[$this->name . '_sort_order'])) 				{ $this->data[$this->name . '_sort_order'] = $this->request->post[$this->name . '_sort_order']; } 
		else 																		{ $this->data[$this->name . '_sort_order'] = $this->config->get($this->name . '_sort_order'); }				

		// TEMPLATE
		$this->template = 'shipping/' . $this->name . '.tpl';
		
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		// OUTPUT
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
	
		if (!$this->user->hasPermission('modify', 'shipping/' . $this->name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) 	{ return true; } 
		else 				{ return false; }	
		
	}
	
}
?>