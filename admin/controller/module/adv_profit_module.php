<?php
static $config = NULL;
static $log = NULL;

// Error Handler
function error_handler_for_export($errno, $errstr, $errfile, $errline) {
	global $config;
	global $log;
	
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$errors = "Notice";
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$errors = "Warning";
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$errors = "Fatal Error";
			break;
		default:
			$errors = "Unknown";
			break;
	}
		
	if (($errors=='Warning') || ($errors=='Unknown')) {
		return true;
	}

	if ($config->get('config_error_display')) {
		echo '<b>' . $errors . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}
	
	if ($config->get('config_error_log')) {
		$log->write('PHP ' . $errors . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	return true;
}

function fatal_error_shutdown_handler_for_export() {
	$last_error = error_get_last();
	if ($last_error['type'] === E_ERROR) {
		// fatal error
		error_handler_for_export(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
	}
}

class ControllerModuleAdvProfitModule extends Controller {
	private $error = array(); 

	public function index() {
		$query = $this->db->query("DESC `" . DB_PREFIX . "order_product` base_price");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `base_price` decimal(15,4) NOT NULL DEFAULT '0.0000';");
				$query_price = $this->db->query("SELECT order_product_id, price FROM `" . DB_PREFIX . "order_product`");
				foreach ($query_price->rows as $base_price) {	
					$this->db->query("UPDATE `" . DB_PREFIX . "order_product` SET base_price = '" . (float)$base_price['price'] . "' WHERE order_product_id = '" . (int)$base_price['order_product_id'] . "' AND base_price = '0.0000'");
				}
			}
			
		$query = $this->db->query("DESC " . DB_PREFIX . "product quantity_based_option");
			if ($query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` DROP `quantity_based_option`;");
			}

		$query = $this->db->query("DESC `" . DB_PREFIX . "product` cost_average");
			if ($query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` CHANGE `cost_average` `costing_method` int(1);");
			}

		$query = $this->db->query("DESC `" . DB_PREFIX . "product_option_value` cost_average");
			if ($query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option_value` CHANGE `cost_average` `costing_method` int(1);");
			}
			
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_cost_price_stock_history'");
			if ($query->num_rows) {
				$this->db->query("RENAME TABLE " . DB_PREFIX . "product_cost_price_stock_history TO product_stock_history;");
			}
			
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_option_cost_price_stock_history'");
			if ($query->num_rows) {
				$this->db->query("RENAME TABLE " . DB_PREFIX . "product_option_cost_price_stock_history TO product_option_stock_history;");
			}

		$query = $this->db->query("DESC " . DB_PREFIX . "product_stock_history comment");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_stock_history` ADD `comment` text NOT NULL AFTER `price`;");
			}

		$query = $this->db->query("DESC " . DB_PREFIX . "product_option_stock_history comment");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option_stock_history` ADD `comment` text NOT NULL AFTER `price`;");
			}

		$query = $this->db->query("DESC `" . DB_PREFIX . "product_stock_history` product_cost_price_stock_history_id");
			if ($query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_stock_history` CHANGE `product_cost_price_stock_history_id` `product_stock_history_id` int(11) NOT NULL AUTO_INCREMENT;");
			}

		$query = $this->db->query("DESC `" . DB_PREFIX . "product_stock_history` cost_average");
			if ($query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_stock_history` CHANGE `cost_average` `costing_method` int(1);");
			}

		$query = $this->db->query("DESC `" . DB_PREFIX . "product_option_stock_history` product_option_cost_price_stock_history_id");
			if ($query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option_stock_history` CHANGE `product_option_cost_price_stock_history_id` `product_option_stock_history_id` int(11) NOT NULL AUTO_INCREMENT;");
			}

		$query = $this->db->query("DESC `" . DB_PREFIX . "product_option_stock_history` cost_average");
			if ($query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option_stock_history` CHANGE `cost_average` `costing_method` int(1);");
			}
			
		$this->load->language('module/adv_profit_module');
		
		$this->document->setTitle($this->language->get('heading_title_main'));

	    $this->document->addScript('view/javascript/multiselect/jquery.multiselect.js');
	    $this->document->addStyle('view/javascript/multiselect/jquery.multiselect.css');

		$this->load->model('report/adv_profit_module');		
		
		if (isset($this->request->get['filter_category'])) {
			$this->data['filter_category'] = explode('_', $this->request->get['filter_category']);
		} else {
			$this->data['filter_category'] = '0';
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$this->data['filter_manufacturer'] = explode('_', $this->request->get['filter_manufacturer']);
		} else {
			$this->data['filter_manufacturer'] = '0';
		}	

		if (isset($this->request->get['filter_status'])) {
			$this->data['filter_status'] = explode('_', $this->request->get['filter_status']);
		} else {
			$this->data['filter_status'] = NULL;
		}	

		if (isset($this->request->get['filter_rounding'])) {
			$this->data['filter_rounding'] = $this->request->get['filter_rounding'];
		} else {
			$this->data['filter_rounding'] = 'RD';
		}
		
		if (isset($this->request->get['export'])) {
			$export = $this->request->get['export'] ;
		} else {
			$export = '';
		}
		
		if ($this->config->get('adv_profit_module') == '0' or $this->config->get('adv_profit_module') == '1') {
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if ((isset($this->request->files['upload'])) && (is_uploaded_file($this->request->files['upload']['tmp_name']))) {
				$file = $this->request->files['upload']['tmp_name'];
				if ($this->model_report_adv_profit_module->upload($file)) {
					$this->session->data['success'] = $this->language->get('text_upload_success');
					$this->redirect($this->url->link('module/adv_profit_module', 'token=' . $this->session->data['token'], 'SSL'));
				} else {
					$this->session->data['warning'] = $this->language->get('error_upload');
					$this->redirect($this->url->link('module/adv_profit_module', 'token=' . $this->session->data['token'], 'SSL'));
 				}
			}	
			
			if (isset($this->request->post['adv_payment_cost_type'])) {
				$this->request->post['adv_payment_cost_type'] = serialize($this->request->post['adv_payment_cost_type']);
			}
			
			$this->model_setting_setting->editSetting('adv_profit_module_config', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		}

		$this->data['heading_title_main'] = $this->language->get('heading_title_main');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		
		$this->data['tab_product_cost'] = $this->language->get('tab_product_cost');
		$this->data['tab_payment_cost'] = $this->language->get('tab_payment_cost');		
		$this->data['tab_shipping_cost'] = $this->language->get('tab_shipping_cost');
		$this->data['tab_extra_cost'] = $this->language->get('tab_extra_cost');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_settings'] = $this->language->get('tab_settings');	
		$this->data['tab_about'] = $this->language->get('tab_about');

		$this->data['text_import_export_note'] = $this->language->get('text_import_export_note');
		$this->data['text_price_rounding'] = $this->language->get('text_price_rounding');	
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_selected'] = $this->language->get('text_selected');		
		$this->data['text_all_categories'] = $this->language->get('text_all_categories');
		$this->data['text_all_manufacturers'] = $this->language->get('text_all_manufacturers');
		$this->data['text_all_statuses'] = $this->language->get('text_all_statuses');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_export'] = $this->language->get('text_export');		
		$this->data['text_import'] = $this->language->get('text_import');		
		$this->data['text_set_order_product_cost_confirm'] = $this->language->get('text_set_order_product_cost_confirm');
		$this->data['text_set_order_payment_cost_confirm'] = $this->language->get('text_set_order_payment_cost_confirm');
		$this->data['text_set_order_shipping_cost_confirm'] = $this->language->get('text_set_order_shipping_cost_confirm');
		$this->data['text_set_order_extra_cost_confirm'] = $this->language->get('text_set_order_extra_cost_confirm');
		$this->data['text_set_set_order_product_cost'] = $this->language->get('text_set_set_order_product_cost');
		$this->data['text_set_set_order_payment_cost'] = $this->language->get('text_set_set_order_payment_cost');
		$this->data['text_set_set_order_shipping_cost'] = $this->language->get('text_set_set_order_shipping_cost');
		$this->data['text_set_set_order_extra_cost'] = $this->language->get('text_set_set_order_extra_cost');
		$this->data['text_sold_order_status'] = $this->language->get('text_sold_order_status');
		$this->data['text_format_date'] = $this->language->get('text_format_date');
		$this->data['text_format_date_eu'] = $this->language->get('text_format_date_eu');
		$this->data['text_format_date_us'] = $this->language->get('text_format_date_us');
		$this->data['text_format_hour'] = $this->language->get('text_format_hour');
		$this->data['text_format_hour_24'] = $this->language->get('text_format_hour_24');
		$this->data['text_format_hour_12'] = $this->language->get('text_format_hour_12');			
		$this->data['text_help_request'] = $this->language->get('text_help_request');
		$this->data['text_asking_help'] = $this->language->get('text_asking_help');		
		$this->data['text_terms'] = $this->language->get('text_terms');	
		
		$this->data['error_permission'] = $this->language->get('error_permission');			
		
		$this->data['entry_import_export'] = $this->language->get('entry_import_export');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');	
		$this->data['entry_prod_status'] = $this->language->get('entry_prod_status');
		$this->data['entry_set_order_product_cost'] = $this->language->get('entry_set_order_product_cost');	
		$this->data['entry_set_order_payment_cost'] = $this->language->get('entry_set_order_payment_cost');	
		$this->data['entry_set_order_shipping_cost'] = $this->language->get('entry_set_order_shipping_cost');
		$this->data['entry_set_order_extra_cost'] = $this->language->get('entry_set_order_extra_cost');	
		
		$this->data['entry_adv_payment_cost_status'] = $this->language->get('entry_adv_payment_cost_status');		
		$this->data['entry_adv_payment_cost_total'] = $this->language->get('entry_adv_payment_cost_total');
		$this->data['entry_adv_payment_cost_payment_type'] = $this->language->get('entry_adv_payment_cost_payment_type');
		$this->data['entry_adv_payment_cost_percentage'] = $this->language->get('entry_adv_payment_cost_percentage');
		$this->data['entry_adv_payment_cost_fixed_fee'] = $this->language->get('entry_adv_payment_cost_fixed_fee');
		$this->data['entry_adv_payment_cost_geo_zone'] = $this->language->get('entry_adv_payment_cost_geo_zone');
		
		$this->data['entry_adv_shipping_cost_status'] = $this->language->get('entry_adv_shipping_cost_status');
		$this->data['entry_adv_shipping_cost_total'] = $this->language->get('entry_adv_shipping_cost_total');
		$this->data['entry_adv_shipping_cost_rate'] = $this->language->get('entry_adv_shipping_cost_rate');
		$this->data['entry_status'] = $this->language->get('entry_status');
		
		$this->data['entry_adv_extra_cost_status'] = $this->language->get('entry_adv_extra_cost_status');
		$this->data['entry_adv_extra_cost'] = $this->language->get('entry_adv_extra_cost');
		
		$this->data['adv_prm_version'] = '';
		$this->data['laccess'] = '';

		$this->data['button_documentation'] = $this->language->get('button_documentation');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_export'] = $this->language->get('button_export');
		$this->data['button_import'] = $this->language->get('button_import');		
		$this->data['button_set_order_product_cost'] = $this->language->get('button_set_order_product_cost');
		$this->data['button_set_order_payment_cost'] = $this->language->get('button_set_order_payment_cost');
		$this->data['button_set_order_shipping_cost'] = $this->language->get('button_set_order_shipping_cost');
		$this->data['button_set_order_extra_cost'] = $this->language->get('button_set_order_extra_cost');
		$this->data['button_add_payment'] = $this->language->get('button_add_payment');
		$this->data['button_remove_payment'] = $this->language->get('button_remove_payment');
		
		$this->data['column_prod_id'] = $this->language->get('column_prod_id');
		$this->data['column_option_id'] = $this->language->get('column_option_id');		
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_option'] = $this->language->get('column_option');
		$this->data['column_sku'] = $this->language->get('column_sku');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_subtract'] = $this->language->get('column_subtract');
		$this->data['column_stock_quantity'] = $this->language->get('column_stock_quantity');		
		$this->data['column_restock_quantity'] = $this->language->get('column_restock_quantity');
		$this->data['column_new_quantity'] = $this->language->get('column_new_quantity');
		$this->data['column_costing_method'] = $this->language->get('column_costing_method');		
		$this->data['column_cost'] = $this->language->get('column_cost');
		$this->data['column_restock_cost'] = $this->language->get('column_restock_cost');
		$this->data['column_new_cost'] = $this->language->get('column_new_cost');
		$this->data['column_price'] = $this->language->get('column_price');	
		$this->data['column_cost_multiplier'] = $this->language->get('column_cost_multiplier');	
		$this->data['column_price_multiplier'] = $this->language->get('column_price_multiplier');
		$this->data['column_set_price'] = $this->language->get('column_set_price');		
		$this->data['column_new_price'] = $this->language->get('column_new_price');
		$this->data['column_profit'] = $this->language->get('column_profit');
		$this->data['column_comment'] = $this->language->get('column_comment');
		
		$this->data['token'] = $this->session->data['token'];

		$this->load->model('catalog/category');		
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		$this->load->model('catalog/manufacturer');
		$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
		
		$this->data['url_set_order_product_cost'] = $this->url->link('module/adv_profit_module/SetOrderProductCost', 'token=' . $this->session->data['token']);
		$this->data['url_set_order_payment_cost'] = $this->url->link('module/adv_profit_module/SetOrderPaymentCost', 'token=' . $this->session->data['token']);
		$this->data['url_set_order_shipping_cost'] = $this->url->link('module/adv_profit_module/SetOrderShippingCost', 'token=' . $this->session->data['token']);
		$this->data['url_set_order_extra_cost'] = $this->url->link('module/adv_profit_module/SetOrderExtraCost', 'token=' . $this->session->data['token']);

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);			
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['warning'])) {
			$this->data['warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);			
		} else {
			$this->data['warning'] = '';
		}
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['error_vqmod'] = $this->language->get('error_vqmod');
        $this->data['vqmod_available'] = $this->VQModAvailable();
		
  		$this->data['breadcrumbs'] = array();
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false

   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/adv_profit_module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('module/adv_profit_module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
	  if ($export != 'xls'){
		$this->data['payments'] = array();
		
		$this->load->model('setting/extension');

		if (isset($this->request->post['adv_payment_cost_status'])) {
			$this->data['adv_payment_cost_status'] = $this->request->post['adv_payment_cost_status'];
		} else {
			$this->data['adv_payment_cost_status'] = $this->config->get('adv_payment_cost_status');
		}
		
		$selected_payment_types = unserialize($this->config->get('adv_payment_cost_type'));
		
		if (isset($this->request->post['adv_payment_cost_type'])) {
			$this->data['adv_payment_cost_types'] = $this->request->post['adv_payment_cost_type'];
		} elseif (isset($selected_payment_types)) {
			$this->data['adv_payment_cost_types'] = $selected_payment_types;
		} else { 	
			$this->data['adv_payment_cost_types'] = array();
		}
		
		$this->load->model('localisation/geo_zone');
		$this->data['pc_geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		$payment_types = $this->model_setting_extension->getInstalled('payment');

		foreach ($payment_types as $key => $code) {
			$this->load->language('payment/' . $code);
				$this->data['payment_types'][] = array(
				'name'       => $this->language->get('heading_title'),
				'paymentkey' => $code
				);
		}

		if (isset($this->request->post['adv_shipping_cost_weight_status'])) {
			$this->data['adv_shipping_cost_weight_status'] = $this->request->post['adv_shipping_cost_weight_status'];
		} else {
			$this->data['adv_shipping_cost_weight_status'] = $this->config->get('adv_shipping_cost_weight_status');
		}
		
		$sc_geo_zones = $this->model_localisation_geo_zone->getGeoZones();
		$this->data['sc_geo_zones'] = $sc_geo_zones;
		
		foreach ($sc_geo_zones as $sc_geo_zone) {
			if (isset($this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total']) && $this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total'] != '') {
				$this->data['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total'] = $this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total'];
			} elseif (isset($this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total']) && $this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total'] == '') {
				$this->data['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total'] = '';				
			} else {
				$this->data['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total'] = $this->config->get('adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total');
			}	

			if (isset($this->error['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total'])) {
				$this->data['error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_total'] = $this->error['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total'];
			} else {
				$this->data['error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_total'] = '';
			}	
			
			if (isset($this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate'])) {
				$this->data['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate'] = $this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate'];
			} else {
				$this->data['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate'] = $this->config->get('adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate');
			}		

			if (isset($this->error['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate'])) {
				$this->data['error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_rate'] = $this->error['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate'];
			} else {
				$this->data['error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_rate'] = '';
			}	
		
			if (isset($this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_status'])) {
				$this->data['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_status'] = $this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_status'];
			} else {
				$this->data['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_status'] = $this->config->get('adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_status');
			}
			
		}

		if (isset($this->request->post['adv_extra_cost_status'])) {
			$this->data['adv_extra_cost_status'] = $this->request->post['adv_extra_cost_status'];
		} else {
			$this->data['adv_extra_cost_status'] = $this->config->get('adv_extra_cost_status');
		}

		if (isset($this->request->post['adv_extra_cost'])) {
			$this->data['adv_extra_cost'] = $this->request->post['adv_extra_cost'];
		} else {
			$this->data['adv_extra_cost'] = $this->config->get('adv_extra_cost');
		}	

		if (isset($this->error['adv_extra_cost'])) {
			$this->data['error_extra_cost'] = $this->error['adv_extra_cost'];
		} else {
			$this->data['error_extra_cost'] = '';
		}

		$this->data['order_statuses'] = $this->model_report_adv_profit_module->getOrderStatuses(); 	
		
		if (isset($this->request->post['adv_sold_order_status'])) {
			$this->data['adv_sold_order_status'] = $this->request->post['adv_sold_order_status'];
		} else {
			$this->data['adv_sold_order_status'] = $this->config->get('adv_sold_order_status');
		}
		
		if (isset($this->request->post['adv_date_format'])) {
			$this->data['adv_date_format'] = $this->request->post['adv_date_format'];
		} else {
			$this->data['adv_date_format'] = $this->config->get('adv_date_format');
		}

		if (isset($this->request->post['adv_hour_format'])) {
			$this->data['adv_hour_format'] = $this->request->post['adv_hour_format'];
		} else {
			$this->data['adv_hour_format'] = $this->config->get('adv_hour_format');
		}
		
		$this->template = 'module/adv_profit_module.tpl';

		$this->children = array(
			'common/header',
			'common/footer',
		);	
		
		$this->response->setOutput($this->render());
		
	  } elseif ($export == 'xls') {	  
		$this->model_report_adv_profit_module->createXLS($this->data['filter_category'], $this->data['filter_manufacturer'], $this->data['filter_status'], $this->data['filter_rounding']);
	  }
	}
	
	private function validate() {
		$this->data['error_numeric_value'] = $this->language->get('error_numeric_value');
		$this->data['error_shipping_cost_total'] = $this->language->get('error_shipping_cost_total');
		$this->data['error_shipping_cost_rate'] = $this->language->get('error_shipping_cost_rate');
		$this->data['error_extra_cost'] = $this->language->get('error_extra_cost');
		
		if (!$this->user->hasPermission('modify', 'module/adv_profit_module')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$this->load->model('localisation/geo_zone');
		$sc_geo_zones = $this->model_localisation_geo_zone->getGeoZones();
		
		foreach ($sc_geo_zones as $sc_geo_zone) {
    		if (isset($this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total']) && (!preg_match('/^[0-9.]*$/', $this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total']))) {
      			$this->error['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total'] = $this->language->get('error_numeric_value');
    		}

    		if (isset($this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total']) && ($this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_status'] == '1') && (!preg_match('/^[0-9.]/', $this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total']))) {
      			$this->error['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total'] = $this->language->get('error_numeric_value');
    		}
		
    		if (isset($this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate']) && (!preg_match('/^[0-9,.:]*$/', $this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate']))) {
      			$this->error['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate'] = $this->language->get('error_shipping_cost_rate');
    		}
			
    		if (isset($this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate']) && ($this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_status'] == '1') && (!preg_match('/^[0-9,.:]/', $this->request->post['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate']))) {
      			$this->error['adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate'] = $this->language->get('error_shipping_cost_rate');
    		}			
		}

    	if (isset($this->request->post['adv_extra_cost']) && (!preg_match('/^[0-9,.:]*$/', $this->request->post['adv_extra_cost']))) {
      		$this->error['adv_extra_cost'] = $this->language->get('error_extra_cost');
    	}
			
    	if (isset($this->request->post['adv_extra_cost']) && ($this->request->post['adv_extra_cost_status'] == '1') && (!preg_match('/^[0-9,.:]/', $this->request->post['adv_extra_cost']))) {
      		$this->error['adv_extra_cost'] = $this->language->get('error_extra_cost');
    	}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	public function install(){
		// Insert DB columns
		$query = $this->db->query("DESC `" . DB_PREFIX . "product` cost_additional");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD `cost_additional` decimal(15,4) NOT NULL DEFAULT '0.0000' AFTER `price`;");
			}

		$query = $this->db->query("DESC `" . DB_PREFIX . "product` cost_percentage");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD `cost_percentage` decimal(15,2) NOT NULL DEFAULT '0.00' AFTER `price`;");
			}

		$query = $this->db->query("DESC `" . DB_PREFIX . "product` cost_amount");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD `cost_amount` decimal(15,4) NOT NULL DEFAULT '0.0000' AFTER `price`;");
			}
			
		$query = $this->db->query("DESC `" . DB_PREFIX . "product` costing_method");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD `costing_method` int(1) NOT NULL AFTER `price`;");
			}
			
		$query = $this->db->query("DESC `" . DB_PREFIX . "product` cost");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD `cost` decimal(15,4) NOT NULL DEFAULT '0.0000' AFTER `price`;");
			}

		$query = $this->db->query("DESC `" . DB_PREFIX . "product_option_value` cost_prefix");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option_value` ADD `cost_prefix` varchar(1) COLLATE utf8_bin NOT NULL AFTER `price`;");
			}	

		$query = $this->db->query("DESC `" . DB_PREFIX . "product_option_value` cost_amount");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option_value` ADD `cost_amount` decimal(15,4) NOT NULL DEFAULT '0.0000' AFTER `price`;");
			}
			
		$query = $this->db->query("DESC `" . DB_PREFIX . "product_option_value` costing_method");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option_value` ADD `costing_method` int(1) NOT NULL AFTER `price`;");
			}
			
		$query = $this->db->query("DESC `" . DB_PREFIX . "product_option_value` cost");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option_value` ADD `cost` decimal(15,4) NOT NULL DEFAULT '0.0000' AFTER `price`;");
			}	

		$query = $this->db->query("DESC `" . DB_PREFIX . "order_product` base_price");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `base_price` decimal(15,4) NOT NULL DEFAULT '0.0000';");
				$query_price = $this->db->query("SELECT order_product_id, price FROM `" . DB_PREFIX . "order_product`");
				foreach ($query_price->rows as $base_price) {	
					$this->db->query("UPDATE `" . DB_PREFIX . "order_product` SET base_price = '" . (float)$base_price['price'] . "' WHERE order_product_id = '" . (int)$base_price['order_product_id'] . "' AND base_price = '0.0000'");
				}
			}
			
		$query = $this->db->query("DESC `" . DB_PREFIX . "order_product` cost");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD `cost` decimal(15,4) NOT NULL DEFAULT '0.0000';");
			}
			
		$query = $this->db->query("DESC `" . DB_PREFIX . "order` shipping_cost");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `shipping_cost` decimal(15,4) NOT NULL DEFAULT '0.0000' AFTER `shipping_method`;");
			}

		$query = $this->db->query("DESC `" . DB_PREFIX . "order` payment_cost");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `payment_cost` decimal(15,4) NOT NULL DEFAULT '0.0000' AFTER `payment_method`;");
			}	

		$query = $this->db->query("DESC `" . DB_PREFIX . "order` extra_cost");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD `extra_cost` decimal(15,4) NOT NULL DEFAULT '0.0000' AFTER `total`;");
			}
			
		$query = $this->db->query("DESC `" . DB_PREFIX . "return` cost");
			if (!$query->num_rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "return` ADD `cost` decimal(15,4) NOT NULL DEFAULT '0.0000' AFTER `comment`;");
			}
			
        $query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_stock_history'");
        	if (!$query->num_rows) {
            	$this->db->query("
                	CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_stock_history` (
					  `product_stock_history_id` int(11) NOT NULL AUTO_INCREMENT,
					  `product_id` int(11) NOT NULL,
					  `restock_quantity` int(4) NOT NULL DEFAULT '0',
					  `stock_quantity` int(4) NOT NULL DEFAULT '0',
					  `costing_method` int(1) NOT NULL,
					  `restock_cost` decimal(15,4) NOT NULL DEFAULT '0.0000',
					  `cost` decimal(15,4) NOT NULL DEFAULT '0.0000',
					  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
					  `comment` text NOT NULL DEFAULT '',
					  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  PRIMARY KEY (`product_stock_history_id`), 
					  INDEX `product_id` (`product_id`) 
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;
            	");
			} 

        $query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "product_option_stock_history'");
        	if (!$query->num_rows) {
            	$this->db->query("
                	CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_option_stock_history` (
					  `product_option_stock_history_id` int(11) NOT NULL AUTO_INCREMENT,
					  `product_option_id` int(11) NOT NULL,
					  `product_id` int(11) NOT NULL,
					  `option_id` int(11) NOT NULL,
					  `option_value_id` int(11) NOT NULL,
					  `restock_quantity` int(4) NOT NULL DEFAULT '0',
					  `stock_quantity` int(4) NOT NULL DEFAULT '0',
					  `costing_method` int(1) NOT NULL,
					  `restock_cost` decimal(15,4) NOT NULL DEFAULT '0.0000',
					  `cost` decimal(15,4) NOT NULL DEFAULT '0.0000',
					  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
					  `comment` text NOT NULL DEFAULT '',
					  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					  PRIMARY KEY (`product_option_stock_history_id`), 
					  INDEX `product_id` (`product_id`) 
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;
            	");
			} 
				
		// Optimize all tables
		//$alltables = mysql_query("SHOW TABLES");
		//while ($table = mysql_fetch_assoc($alltables)) {
		//	foreach ($table as $db => $tablename) {
		//		mysql_query("OPTIMIZE TABLE `" . $tablename . "`")
		//		or die(mysql_error());
		//	}
		//}
		
		// Add indexes
		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "order_product` WHERE Key_name != 'PRIMARY';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD INDEX (product_id,total,cost,price,base_price,tax,quantity);");
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_product` ADD INDEX (order_id);");
			}	
			
		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "order_total` WHERE Key_name != 'PRIMARY' AND Key_name != 'idx_orders_total_orders_id';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_total` ADD INDEX (order_id,value,code);");
			}	
			
		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "order_option` WHERE Key_name != 'PRIMARY';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_option` ADD INDEX (order_product_id,type,name,product_option_value_id);");
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_option` ADD INDEX (order_id);");
			}
			
		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "order_history` WHERE Key_name != 'PRIMARY';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_history` ADD INDEX (order_status_id);");
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order_history` ADD INDEX (order_id);");
			}
			
		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "order` WHERE Key_name != 'PRIMARY';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "order` ADD INDEX (customer_id,date_added,total,email,firstname,lastname,payment_company);");
			}

		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "product` WHERE Key_name != 'PRIMARY';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product` ADD INDEX (product_id,model,sku,manufacturer_id,sort_order,status);");
			}	

		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "category` WHERE Key_name != 'PRIMARY';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "category` ADD INDEX (category_id,parent_id);");
			}	

		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "option` WHERE Key_name != 'PRIMARY';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "option` ADD INDEX (sort_order);");
			}
			
		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "option_description` WHERE Key_name != 'PRIMARY';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "option_description` ADD INDEX (name);");
			}	

		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "option_value` WHERE Key_name != 'PRIMARY';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "option_value` ADD INDEX (option_id,sort_order);");
			}

		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "option_value_description` WHERE Key_name != 'PRIMARY';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "option_value_description` ADD INDEX (option_id,name);");
			}

		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "product_option` WHERE Key_name != 'PRIMARY';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option` ADD INDEX (product_id,option_id);");
			}

		$query = $this->db->query("SHOW KEYS FROM `" . DB_PREFIX . "product_option_value` WHERE Key_name != 'PRIMARY';");
			if (!$query->rows) {
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option_value` ADD INDEX (product_id,option_id,option_value_id,quantity,price,cost);");
				$this->db->query("ALTER TABLE `" . DB_PREFIX . "product_option_value` ADD INDEX (product_option_id);");
			}
		
		$query = $this->db->query("SELECT product_option_value_id, cost, cost_amount FROM " . DB_PREFIX . "product_option_value ");
		foreach ($query->rows as $result) {
			if ($result['cost_amount'] == 0) {
				$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET cost_amount = '" . (float)$result['cost'] . "' WHERE product_option_value_id = '" . (int)$result['product_option_value_id'] . "'");
			}
		}

		$phistory = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_stock_history ");
		if (!$phistory->rows) {
			$query = $this->db->query("SELECT product_id, quantity, cost, price FROM " . DB_PREFIX . "product ");
			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_stock_history SET product_id = '" . (int)$result['product_id'] . "', restock_quantity = '0', stock_quantity = '" . (int)$result['quantity'] . "', costing_method = '0', restock_cost = '0.0000', cost = '" . (float)$result['cost'] . "', price = '" . (float)$result['price'] . "', comment = 'Initial Stock', date_added = NOW()");
			}
		}

		$ohistory = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_stock_history ");
		if (!$ohistory->rows) {
			$query = $this->db->query("SELECT product_option_id, product_id, option_id, option_value_id, quantity, cost, price FROM " . DB_PREFIX . "product_option_value ");
			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_stock_history SET product_option_id = '" . (int)$result['product_option_id'] . "', product_id = '" . (int)$result['product_id'] . "', option_id = '" . (int)$result['option_id'] . "', option_value_id = '" . (int)$result['option_value_id'] . "', restock_quantity = '0', stock_quantity = '" . (int)$result['quantity'] . "', costing_method = '0', restock_cost = '0.0000', cost = '" . (float)$result['cost'] . "', price = '" . (float)$result['price'] . "', comment = 'Initial Stock', date_added = NOW()");
			}
		}
		
		$this->load->model('user/user_group');
		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'module/adv_profit_module');
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'module/adv_profit_module');		
	}
	
	public function uninstall(){
		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting('adv_profit_module');
		$this->model_setting_setting->deleteSetting('adv_profit_module_config');
		
		$this->load->model('setting/extension');
		$this->model_setting_extension->uninstall('module', 'adv_profit_module');
	}
	
	public function SetOrderProductCost() {
		if (!$this->user->hasPermission('modify', 'module/adv_profit_module')) {
			$this->load->language('module/adv_profit_module');			
			$this->session->data['warning'] = $this->language->get('error_permission');
			$this->redirect($this->url->link('module/adv_profit_module', 'token=' . $this->session->data['token'], 'SSL'));			
		} else {
			$query_product_cost = $this->db->query("SELECT product_id, cost FROM `" . DB_PREFIX . "product` WHERE status = 1");
			foreach ($query_product_cost->rows as $result_product_cost) {
				$this->db->query("UPDATE `" . DB_PREFIX . "order_product` op SET op.cost = '" . (float)$result_product_cost['cost'] . "' + IFNULL((SELECT SUM(IF(pov.cost_prefix = '+',pov.cost,-pov.cost)) FROM `" . DB_PREFIX . "order_option` oo, `" . DB_PREFIX . "product_option_value` pov WHERE op.product_id = '" . (int)$result_product_cost['product_id'] . "' AND op.order_product_id = oo.order_product_id AND oo.product_option_id = pov.product_option_id AND oo.product_option_value_id = pov.product_option_value_id),0) WHERE op.product_id = '" . (int)$result_product_cost['product_id'] . "' AND op.cost = '0.0000' OR op.cost IS NULL");
			}
			$this->load->language('module/adv_profit_module');
			$this->session->data['success'] = $this->language->get('text_set_order_product_cost_success');	
			$this->redirect($this->url->link('module/adv_profit_module', 'token=' . $this->session->data['token'], 'SSL'));
		}	
	}

	public function SetOrderPaymentCost() {
		if (!$this->user->hasPermission('modify', 'module/adv_profit_module')) {
			$this->load->language('module/adv_profit_module');			
			$this->session->data['warning'] = $this->language->get('error_permission');
			$this->redirect($this->url->link('module/adv_profit_module', 'token=' . $this->session->data['token'], 'SSL'));			
		} else {
			$query_payment_cost = $this->db->query("SELECT order_id, payment_code, total, payment_country_id, payment_zone_id FROM `" . DB_PREFIX . "order` WHERE order_status_id > 0 AND payment_cost = '0.0000'");
			foreach ($query_payment_cost->rows as $result_payment_cost) {
				
			  if ($this->config->get('adv_payment_cost_status') && $this->config->get('adv_payment_cost_type') && $result_payment_cost['payment_code']) {
				$getPaymentTypes = unserialize($this->config->get('adv_payment_cost_type'));
				if ($getPaymentTypes) {
				  foreach ($getPaymentTypes as $payment_type) {
					if ($result_payment_cost['payment_code'] == $payment_type['pc_paymentkey']) {	
						
						if ($result_payment_cost['total'] > $payment_type['pc_order_total']) {
								$country_id	= $result_payment_cost['payment_country_id'];
								$zone_id 	= $result_payment_cost['payment_zone_id'];

							$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$payment_type['pc_geozone'] . "' AND country_id = '" . (int)$country_id . "' AND (zone_id = '" . (int)$zone_id . "' OR zone_id = '0')");
						
							if (!$payment_type['pc_geozone']) {
								$pc_status = true;
							} elseif ($query->num_rows) {
								$pc_status = true;
							} else {
								$pc_status = false;
							}		
			
							if (($result_payment_cost['total'] > $payment_type['pc_order_total']) && ($pc_status) && ($result_payment_cost['total'] > 0)) {
								$payment_cost = ($payment_type['pc_percentage']*$result_payment_cost['total'])/100 + $payment_type['pc_fixed'];
								$this->db->query("UPDATE `" . DB_PREFIX . "order` SET payment_cost = '" . $payment_cost . "' WHERE order_id = '" . (int)$result_payment_cost['order_id'] . "'");								
							}
							
						}
						
					}
				  }
				}
			  }
			
			}
			$this->load->language('module/adv_profit_module');
			$this->session->data['success'] = $this->language->get('text_set_order_payment_cost_success');	
			$this->redirect($this->url->link('module/adv_profit_module', 'token=' . $this->session->data['token'], 'SSL'));
		}	
	}

	public function SetOrderShippingCost() {
		if (!$this->user->hasPermission('modify', 'module/adv_profit_module')) {
			$this->load->language('module/adv_profit_module');			
			$this->session->data['warning'] = $this->language->get('error_permission');
			$this->redirect($this->url->link('module/adv_profit_module', 'token=' . $this->session->data['token'], 'SSL'));			
		} else {
			$query_shipping_cost = $this->db->query("SELECT order_id, shipping_country_id, shipping_zone_id, total FROM `" . DB_PREFIX . "order` WHERE order_status_id > 0 AND shipping_cost = '0.0000'");
			foreach ($query_shipping_cost->rows as $result_shipping_cost) {
				
				$country_id	= $result_shipping_cost['shipping_country_id'];
				$zone_id 	= $result_shipping_cost['shipping_zone_id'];				
				$query_geo_zone = $this->db->query("SELECT geo_zone_id FROM " . DB_PREFIX . "zone_to_geo_zone WHERE country_id = '" . (int)$country_id . "' AND (zone_id = '" . (int)$zone_id . "' OR zone_id = '0')");

				if ($query_geo_zone->rows) {	
					foreach ($query_geo_zone->rows as $result_geo_zone) {
						if (($this->config->get('adv_shipping_cost_weight_status') == '1') && ($this->config->get('adv_shipping_cost_weight_' . $result_geo_zone['geo_zone_id'] . '_status') == '1') && ($this->config->get('adv_shipping_cost_weight_' . $result_geo_zone['geo_zone_id'] . '_rate') != '')) {
				
							if (($result_shipping_cost['total'] >= $this->config->get('adv_shipping_cost_weight_' . $result_geo_zone['geo_zone_id'] . '_total'))) {
								$weight = 0;
								
								$products_query = $this->db->query("SELECT p.product_id, p.shipping, p.weight, p.weight_class_id, op.order_product_id, op.product_id, op.order_id, op.quantity FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "order_product` op WHERE op.order_id = '" . (int)$result_shipping_cost['order_id'] . "' AND op.product_id = p.product_id AND p.shipping = '1'");

								if ($products_query->num_rows) {
									foreach ($products_query->rows as $result_product) {
										$option_weight = 0;
										
										$options_query = $this->db->query("SELECT oo.product_option_id, oo.product_option_value_id, oo.order_product_id, oo.order_id FROM `" . DB_PREFIX . "order_option` oo WHERE oo.order_id = '" . (int)$result_product['order_id'] . "' AND oo.order_product_id = '" . (int)$result_product['order_product_id'] . "'");
										
										foreach ($options_query->rows as $result_option) {
											$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, o.type FROM `" . DB_PREFIX . "product_option` po, `" . DB_PREFIX . "option` o WHERE po.product_option_id = '" . (int)$result_option['product_option_id'] . "' AND po.product_id = '" . (int)$result_product['product_id'] . "' AND po.option_id = o.option_id");
								
											if ($option_query->num_rows) {
												$option_value_query = $this->db->query("SELECT pov.option_value_id, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov WHERE pov.product_option_value_id = '" . (int)$result_option['product_option_value_id'] . "' AND pov.product_option_id = '" . (int)$result_option['product_option_id'] . "'");								

													if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
														if ($option_value_query->num_rows) {
															if ($option_value_query->row['weight_prefix'] == '+') {
																$option_weight += $option_value_query->row['weight'];
															} elseif ($option_value_query->row['weight_prefix'] == '-') {
																$option_weight -= $option_value_query->row['weight'];
															}							
														}
													
													} elseif ($option_query->row['type'] == 'checkbox') {
														if ($option_value_query->num_rows) {
															if ($option_value_query->row['weight_prefix'] == '+') {
																$option_weight += $option_value_query->row['weight'];
															} elseif ($option_value_query->row['weight_prefix'] == '-') {
																$option_weight -= $option_value_query->row['weight'];
															}							
														}
													
													} elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
													
														$option_weight += 0;					
													}
											}
										}
										
										$weight += $this->weight->convert(($result_product['weight'] + $option_weight) * $result_product['quantity'], (int)$result_product['weight_class_id'], $this->config->get('config_weight_class_id'));										
									}
								}
								
								$rates = explode(',', $this->config->get('adv_shipping_cost_weight_' . $result_geo_zone['geo_zone_id'] . '_rate'));
				
								foreach ($rates as $rate) {
								$adv_shipping_cost_data = explode(':', $rate);
				
									if ($adv_shipping_cost_data[0] >= $weight) {
										if (isset($adv_shipping_cost_data[1])) {
											$shipping_cost = $adv_shipping_cost_data[1];
											$this->db->query("UPDATE `" . DB_PREFIX . "order` SET shipping_cost = '" . $shipping_cost . "' WHERE order_id = '" . (int)$result_shipping_cost['order_id'] . "'");
										}
										break;
									}
								}
							
							}
						
						}				
					}
				}
			}
			$this->load->language('module/adv_profit_module');
			$this->session->data['success'] = $this->language->get('text_set_order_shipping_cost_success');	
			$this->redirect($this->url->link('module/adv_profit_module', 'token=' . $this->session->data['token'], 'SSL'));
		}	
	}

	public function SetOrderExtraCost() {
		if (!$this->user->hasPermission('modify', 'module/adv_profit_module')) {
			$this->load->language('module/adv_profit_module');			
			$this->session->data['warning'] = $this->language->get('error_permission');
			$this->redirect($this->url->link('module/adv_profit_module', 'token=' . $this->session->data['token'], 'SSL'));			
		} else {
			$query_extra_cost = $this->db->query("SELECT order_id, total FROM `" . DB_PREFIX . "order` WHERE order_status_id > 0 AND extra_cost = '0.0000'");
			foreach ($query_extra_cost->rows as $result_extra_cost) {
				if (($this->config->get('adv_extra_cost_status') == '1') && ($this->config->get('adv_extra_cost') != '')) {
					$rates = explode(',', $this->config->get('adv_extra_cost'));
				
					foreach ($rates as $rate) {
						$adv_extra_cost_data = explode(':', $rate);
				
						if ($adv_extra_cost_data[0] >= $result_extra_cost['total']) {
							if (isset($adv_extra_cost_data[1])) {
								$extra_cost = $adv_extra_cost_data[1];
								$this->db->query("UPDATE `" . DB_PREFIX . "order` SET extra_cost = '" . $extra_cost . "' WHERE order_id = '" . (int)$result_extra_cost['order_id'] . "'");
							}
							break;
						}
						
					}
						
				}				
			}
			$this->load->language('module/adv_profit_module');
			$this->session->data['success'] = $this->language->get('text_set_order_extra_cost_success');	
			$this->redirect($this->url->link('module/adv_profit_module', 'token=' . $this->session->data['token'], 'SSL'));
		}	
	}
	
	private function VQModAvailable() {
		if (class_exists('VQModObject')) {
			return true;
		}
		return false;
	}	
}
?>