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

class ControllerReportAdvProducts extends Controller { 
	private $error = array();
	
	public function index() {
		$this->load->language('report/adv_products');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE code = 'adv_reports_products'");
		if (empty($query->num_rows)) {	
			$this->session->data['success'] = $this->language->get('error_installed');
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));		
		}
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('report/adv_products');

	    $this->document->addScript('view/javascript/multiselect/jquery.multiselect.js');
	    $this->document->addStyle('view/javascript/multiselect/jquery.multiselect.css');
		
		if (isset($this->request->get['filter_date_start'])) {
			$this->session->data['filter_date_start'] = $filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$this->session->data['filter_date_start'] = $filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$this->session->data['filter_date_end'] = $filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$this->session->data['filter_date_end'] = $filter_date_end = '';
		}

		$this->data['ranges'] = array();
		
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_custom'),
			'value' => 'custom',
			'style' => 'color:#666',
		);			
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_today'),
			'value' => 'today',
			'style' => 'color:#090',
		);
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_yesterday'),
			'value' => 'yesterday',
			'style' => 'color:#090',
		);
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_week'),
			'value' => 'week',
			'style' => 'color:#090',
		);
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_month'),
			'value' => 'month',
			'style' => 'color:#090',
		);					
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_quarter'),
			'value' => 'quarter',
			'style' => 'color:#090',
		);
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_year'),
			'value' => 'year',
			'style' => 'color:#090',
		);
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_current_week'),
			'value' => 'current_week',
			'style' => 'color:#06C',
		);
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_current_month'),
			'value' => 'current_month',
			'style' => 'color:#06C',
		);	
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_current_quarter'),
			'value' => 'current_quarter',
			'style' => 'color:#06C',
		);			
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_current_year'),
			'value' => 'current_year',
			'style' => 'color:#06C',
		);			
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_last_week'),
			'value' => 'last_week',
			'style' => 'color:#F90',
		);
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_last_month'),
			'value' => 'last_month',
			'style' => 'color:#F90',
		);	
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_last_quarter'),
			'value' => 'last_quarter',
			'style' => 'color:#F90',
		);			
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_last_year'),
			'value' => 'last_year',
			'style' => 'color:#F90',
		);			
		$this->data['ranges'][] = array(
			'text'  => $this->language->get('stat_all_time'),
			'value' => 'all_time',
			'style' => 'color:#F00',
		);
		
		if (isset($this->request->get['filter_range'])) {
			$this->session->data['filter_range'] = $filter_range = $this->request->get['filter_range'];
		} else {
			$this->session->data['filter_range'] = $filter_range = 'current_year'; //show Current Year in Statistical Range by default
		}

		$this->data['report'] = array();

		$this->data['report'][] = array(
			'text'		=> $this->language->get('text_all_products'). ' ' .$this->language->get('text_with_without_orders'),
			'value'		=> 'all_products_with_without_orders'
		);	
		$this->data['report'][] = array(
			'text'  	=> $this->language->get('text_products_purchased'). ' ' .$this->language->get('text_without_options'),
			'value' 	=> 'products_purchased_without_options'
		);	
		$this->data['report'][] = array(
			'text'  	=> $this->language->get('text_products_purchased'). ' ' .$this->language->get('text_with_options'),
			'value' 	=> 'products_purchased_with_options'
		);
		$this->data['report'][] = array(
			'text'  	=> $this->language->get('text_products'). ' ' .$this->language->get('text_without_orders'),
			'value' 	=> 'products_without_orders'
		);				
		$this->data['report'][] = array(
			'text'  	=> $this->language->get('text_new_products_purchased'). ' ' .$this->language->get('text_new_products'),
			'value' 	=> 'new_products_purchased'
		);	
		$this->data['report'][] = array(
			'text'  	=> $this->language->get('text_old_products_purchased'). ' ' .$this->language->get('text_old_products'),
			'value' 	=> 'old_products_purchased'
		);			
		$this->data['report'][] = array(
			'text'  	=> $this->language->get('text_manufacturers'),
			'value' 	=> 'manufacturers',
			'subtext'	=> '',			
		);		
		$this->data['report'][] = array(
			'text'  	=> $this->language->get('text_categories'),
			'value' 	=> 'categories',
			'subtext'	=> '',			
		);	
		
		if (isset($this->request->get['filter_report'])) {
			$this->session->data['filter_report'] = $filter_report = $this->request->get['filter_report'];
		} else {
			$this->session->data['filter_report'] = $filter_report = 'products_purchased_without_options'; //show Products Purchased withou options in Report By default
		}

		$this->data['details'] = array();

		$this->data['details'][] = array(
			'text'  => $this->language->get('text_no_details'),
			'value' => 'no_details',
		);
		$this->data['details'][] = array(
			'text'  => $this->language->get('text_basic_details'),
			'value' => 'basic_details',
		);
		$this->data['details'][] = array(
			'text'  => $this->language->get('text_all_details'),
			'value' => 'all_details',
		);
		
		if (isset($this->request->get['filter_details'])) {
			$this->session->data['filter_details'] = $filter_details = $this->request->get['filter_details'];
		} else {
			$this->session->data['filter_details'] = $filter_details = 'no_details';
		}	
		
		$this->data['group'] = array();

		$this->data['group'][] = array(
			'text'  => $this->language->get('text_no_group'),
			'value' => 'no_group',
		);
		$this->data['group'][] = array(
			'text'  => $this->language->get('text_year'),
			'value' => 'year',
		);
		$this->data['group'][] = array(
			'text'  => $this->language->get('text_quarter'),
			'value' => 'quarter',
		);
		$this->data['group'][] = array(
			'text'  => $this->language->get('text_month'),
			'value' => 'month',
		);
		$this->data['group'][] = array(
			'text'  => $this->language->get('text_week'),
			'value' => 'week',
		);
		$this->data['group'][] = array(
			'text'  => $this->language->get('text_day'),
			'value' => 'day',
		);
		$this->data['group'][] = array(
			'text'  => $this->language->get('text_order'),
			'value' => 'order',
		);
		
		if (isset($this->request->get['filter_group'])) {
			$this->session->data['filter_group'] = $filter_group = $this->request->get['filter_group'];
		} else {
			$this->session->data['filter_group'] = $filter_group = 'no_group';
		}		

		if ($this->config->get('advpp' . $this->user->getId() . '_settings_mv_columns')) {
			$advpp_settings_mv_columns = $this->config->get('advpp' . $this->user->getId() . '_settings_mv_columns');
		} else {
			$advpp_settings_mv_columns = array();
		}
		$this->data['sort'] = array();

		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_date'),
			'value' => 'date',
		);
		if ($filter_report != 'manufacturers' && $filter_report != 'categories') {
		if (!$advpp_settings_mv_columns or (in_array('mv_id', $advpp_settings_mv_columns))) {
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_id'),
			'value' => 'id',
		);
		}	
		if (in_array('mv_sku', $advpp_settings_mv_columns)) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_sku'),
			'value' => 'sku',
		);
		}
		if (!$advpp_settings_mv_columns or (in_array('mv_name', $advpp_settings_mv_columns))) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_prod_name'),
			'value' => 'name',
		);
		}
		if (!$advpp_settings_mv_columns or (in_array('mv_model', $advpp_settings_mv_columns))) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_model'),
			'value' => 'model',
		);
		}
		}
		if ($filter_report != 'manufacturers') {
		if (in_array('mv_category', $advpp_settings_mv_columns)) {	
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_category'),
			'value' => 'category',
		);
		}
		}
		if ($filter_report != 'categories') {
		if (in_array('mv_manufacturer', $advpp_settings_mv_columns)) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_manufacturer'),
			'value' => 'manufacturer',
		);
		}
		}
		if ($filter_report != 'manufacturers' && $filter_report != 'categories') {
		if (in_array('mv_attribute', $advpp_settings_mv_columns)) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_attribute'),
			'value' => 'attribute',
		);
		}
		if (!$advpp_settings_mv_columns or (in_array('mv_status', $advpp_settings_mv_columns))) {			
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_status'),
			'value' => 'status',
		);
		}
		if (in_array('mv_location', $advpp_settings_mv_columns)) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_location'),
			'value' => 'location',
		);
		}
		if (in_array('mv_tax_class', $advpp_settings_mv_columns)) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_tax_class'),
			'value' => 'tax_class',
		);
		}
		if (in_array('mv_price', $advpp_settings_mv_columns)) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_price'),
			'value' => 'price',
		);
		}
		if (in_array('mv_viewed', $advpp_settings_mv_columns)) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_viewed'),
			'value' => 'viewed',
		);
		}		
		if (!$advpp_settings_mv_columns or (in_array('mv_stock_quantity', $advpp_settings_mv_columns))) {			
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_stock_quantity'),
			'value' => 'stock_quantity',
		);
		}
		}
		if ($filter_report != 'products_without_orders') {
		if (!$advpp_settings_mv_columns or (in_array('mv_sold_quantity', $advpp_settings_mv_columns))) {			
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_sold_quantity'),
			'value' => 'sold_quantity',
		);
		}
		if (!$advpp_settings_mv_columns or (in_array('mv_total_excl_vat', $advpp_settings_mv_columns))) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_prod_total_excl_vat'),
			'value' => 'total_excl_vat',
		);
		}
		if (!$advpp_settings_mv_columns or (in_array('mv_total_tax', $advpp_settings_mv_columns))) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_total_tax'),
			'value' => 'total_tax',
		);
		}
		if (!$advpp_settings_mv_columns or (in_array('mv_total_incl_vat', $advpp_settings_mv_columns))) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_prod_total_incl_vat'),
			'value' => 'total_incl_vat',
		);
		}
		if (!$advpp_settings_mv_columns or (in_array('mv_app', $advpp_settings_mv_columns))) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_app'),
			'value' => 'app',
		);
		}
		if (!$advpp_settings_mv_columns or (in_array('mv_refunds', $advpp_settings_mv_columns))) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_product_refunds'),
			'value' => 'refunds',
		);
		}
		if (!$advpp_settings_mv_columns or (in_array('mv_reward_points', $advpp_settings_mv_columns))) {		
		$this->data['sort'][] = array(
			'text'  => $this->language->get('column_product_reward_points'),
			'value' => 'reward_points',
		);
		}
		}
		
		if (isset($this->request->get['filter_sort'])) {
			$this->session->data['filter_sort'] = $filter_sort = $this->request->get['filter_sort'];
		} else {
			if ($filter_report == 'products_without_orders') {
				$this->session->data['filter_sort'] = $filter_sort = 'id';
			} else {
				$this->session->data['filter_sort'] = $filter_sort = 'sold_quantity';
			}
		}	

		$this->data['limit'] = array();

		$this->data['limit'][] = array(
			'text'  => '10',
			'value' => '10',
		);
		$this->data['limit'][] = array(
			'text'  => '25',
			'value' => '25',
		);
		$this->data['limit'][] = array(
			'text'  => '50',
			'value' => '50',
		);
		$this->data['limit'][] = array(
			'text'  => '100',
			'value' => '100',
		);
		$this->data['limit'][] = array(
			'text'  => $this->language->get('text_all'),
			'value' => '999999',
		);
		
		if (isset($this->request->get['filter_limit'])) {
			$this->session->data['filter_limit'] = $filter_limit = $this->request->get['filter_limit'];
		} else {
			$this->session->data['filter_limit'] = $filter_limit = 25;
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
 	
		if (isset($this->request->get['filter_status_date_start'])) {
			$this->session->data['filter_status_date_start'] = $filter_status_date_start = $this->request->get['filter_status_date_start'];
		} else {
			$this->session->data['filter_status_date_start'] = $filter_status_date_start = '';
		}

		if (isset($this->request->get['filter_status_date_end'])) {
			$this->session->data['filter_status_date_end'] = $filter_status_date_end = $this->request->get['filter_status_date_end'];
		} else {
			$this->session->data['filter_status_date_end'] = $filter_status_date_end = '';
		}

		$this->data['order_statuses'] = $this->model_report_adv_products->getOrderStatuses(); 	
		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = explode(',', $this->request->get['filter_order_status_id']);
			$this->session->data['filter_order_status_id'] = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = array();
			$this->session->data['filter_order_status_id'] = '';
		}

		if (isset($this->request->get['filter_order_id_from'])) {
			if (is_numeric(trim($this->request->get['filter_order_id_from']))) {
				$this->session->data['filter_order_id_from'] = $filter_order_id_from = trim($this->request->get['filter_order_id_from']);
			} else {
				$this->session->data['filter_order_id_from'] = $filter_order_id_from = '';
			}
		} else {
			$this->session->data['filter_order_id_from'] = $filter_order_id_from = '';
		}
		
		if (isset($this->request->get['filter_order_id_to'])) {
			if (is_numeric(trim($this->request->get['filter_order_id_to']))) {
				$this->session->data['filter_order_id_to'] = $filter_order_id_to = trim($this->request->get['filter_order_id_to']);
			} else {
				$this->session->data['filter_order_id_to'] = $filter_order_id_to = '';
			}
		} else {
			$this->session->data['filter_order_id_to'] = $filter_order_id_to = '';
		}

		$this->data['stores'] = $this->model_report_adv_products->getOrderStores();
		if (isset($this->request->get['filter_store_id'])) {
			$filter_store_id = explode(',', $this->request->get['filter_store_id']);
			$this->session->data['filter_store_id'] = $this->request->get['filter_store_id'];
		} else {
			$filter_store_id = array();
			$this->session->data['filter_store_id'] = '';
		}

		$this->data['currencies'] = $this->model_report_adv_products->getOrderCurrencies();
		if (isset($this->request->get['filter_currency'])) {
			$filter_currency = explode(',', $this->request->get['filter_currency']);
			$this->session->data['filter_currency'] = $this->request->get['filter_currency'];
		} else {
			$filter_currency = array();
			$this->session->data['filter_currency'] = '';
		}

		$this->data['taxes'] = $this->model_report_adv_products->getOrderTaxes();	
		if (isset($this->request->get['filter_taxes'])) {
			$filter_taxes = explode(',', $this->request->get['filter_taxes']);
			$this->session->data['filter_taxes'] = $this->request->get['filter_taxes'];
		} else {
			$filter_taxes = array();
			$this->session->data['filter_taxes'] = '';
		}

		$this->data['tax_classes'] = $this->model_report_adv_products->getOrderTaxClasses();
		if (isset($this->request->get['filter_tax_classes'])) {
			$filter_tax_classes = explode(',', $this->request->get['filter_tax_classes']);
			$this->session->data['filter_tax_classes'] = $this->request->get['filter_tax_classes'];
		} else {
			$filter_tax_classes = array();
			$this->session->data['filter_tax_classes'] = '';
		}

		$this->data['geo_zones'] = $this->model_report_adv_products->getOrderGeoZones();
		if (isset($this->request->get['filter_geo_zones'])) {
			$filter_geo_zones = explode(',', $this->request->get['filter_geo_zones']);
			$this->session->data['filter_geo_zones'] = $this->request->get['filter_geo_zones'];
		} else {
			$filter_geo_zones = array();
			$this->session->data['filter_geo_zones'] = '';
		}

		$this->data['customer_groups'] = $this->model_report_adv_products->getOrderCustomerGroups();	
		if (isset($this->request->get['filter_customer_group_id'])) {
			$filter_customer_group_id = explode(',', $this->request->get['filter_customer_group_id']);
			$this->session->data['filter_customer_group_id'] = $this->request->get['filter_customer_group_id'];
		} else {
			$filter_customer_group_id = array();
			$this->session->data['filter_customer_group_id'] = '';
		}
		
		if (isset($this->request->get['filter_customer_name'])) {
			$this->session->data['filter_customer_name'] = $filter_customer_name = $this->request->get['filter_customer_name'];
		} else {
			$this->session->data['filter_customer_name'] = $filter_customer_name = '';
		}

		if (isset($this->request->get['filter_customer_email'])) {
			$this->session->data['filter_customer_email'] = $filter_customer_email = $this->request->get['filter_customer_email'];
		} else {
			$this->session->data['filter_customer_email'] = $filter_customer_email = '';
		}

		if (isset($this->request->get['filter_customer_telephone'])) {
			$this->session->data['filter_customer_telephone'] = $filter_customer_telephone = $this->request->get['filter_customer_telephone'];
		} else {
			$this->session->data['filter_customer_telephone'] = $filter_customer_telephone = '';
		}

		if (isset($this->request->get['filter_ip'])) {
			$this->session->data['filter_ip'] = $filter_ip = $this->request->get['filter_ip'];
		} else {
			$this->session->data['filter_ip'] = $filter_ip = '';
		}
		
		if (isset($this->request->get['filter_payment_company'])) {
			$this->session->data['filter_payment_company'] = $filter_payment_company = $this->request->get['filter_payment_company'];
		} else {
			$this->session->data['filter_payment_company'] = $filter_payment_company = '';
		}
		
		if (isset($this->request->get['filter_payment_address'])) {
			$this->session->data['filter_payment_address'] = $filter_payment_address = $this->request->get['filter_payment_address'];
		} else {
			$this->session->data['filter_payment_address'] = $filter_payment_address = '';
		}

		if (isset($this->request->get['filter_payment_city'])) {
			$this->session->data['filter_payment_city'] = $filter_payment_city = $this->request->get['filter_payment_city'];
		} else {
			$this->session->data['filter_payment_city'] = $filter_payment_city = '';
		}
		
		if (isset($this->request->get['filter_payment_zone'])) {
			$this->session->data['filter_payment_zone'] = $filter_payment_zone = $this->request->get['filter_payment_zone'];
		} else {
			$this->session->data['filter_payment_zone'] = $filter_payment_zone = '';
		}
		
		if (isset($this->request->get['filter_payment_postcode'])) {
			$this->session->data['filter_payment_postcode'] = $filter_payment_postcode = $this->request->get['filter_payment_postcode'];
		} else {
			$this->session->data['filter_payment_postcode'] = $filter_payment_postcode = '';
		}

		if (isset($this->request->get['filter_payment_country'])) {
			$this->session->data['filter_payment_country'] = $filter_payment_country = $this->request->get['filter_payment_country'];
		} else {
			$this->session->data['filter_payment_country'] = $filter_payment_country = '';
		}

		$this->data['payment_methods'] = $this->model_report_adv_products->getOrderPaymentMethods();	
		if (isset($this->request->get['filter_payment_method'])) {
			$filter_payment_method = explode(',', $this->request->get['filter_payment_method']);
			$this->session->data['filter_payment_method'] = $this->request->get['filter_payment_method'];
		} else {
			$filter_payment_method = array();
			$this->session->data['filter_payment_method'] = '';
		}
		
		if (isset($this->request->get['filter_shipping_company'])) {
			$this->session->data['filter_shipping_company'] = $filter_shipping_company = $this->request->get['filter_shipping_company'];
		} else {
			$this->session->data['filter_shipping_company'] = $filter_shipping_company = '';
		}
		
		if (isset($this->request->get['filter_shipping_address'])) {
			$this->session->data['filter_shipping_address'] = $filter_shipping_address = $this->request->get['filter_shipping_address'];
		} else {
			$this->session->data['filter_shipping_address'] = $filter_shipping_address = '';
		}

		if (isset($this->request->get['filter_shipping_city'])) {
			$this->session->data['filter_shipping_city'] = $filter_shipping_city = $this->request->get['filter_shipping_city'];
		} else {
			$this->session->data['filter_shipping_city'] = $filter_shipping_city = '';
		}
		
		if (isset($this->request->get['filter_shipping_zone'])) {
			$this->session->data['filter_shipping_zone'] = $filter_shipping_zone = $this->request->get['filter_shipping_zone'];
		} else {
			$this->session->data['filter_shipping_zone'] = $filter_shipping_zone = '';
		}
		
		if (isset($this->request->get['filter_shipping_postcode'])) {
			$this->session->data['filter_shipping_postcode'] = $filter_shipping_postcode = $this->request->get['filter_shipping_postcode'];
		} else {
			$this->session->data['filter_shipping_postcode'] = $filter_shipping_postcode = '';
		}

		if (isset($this->request->get['filter_shipping_country'])) {
			$this->session->data['filter_shipping_country'] = $filter_shipping_country = $this->request->get['filter_shipping_country'];
		} else {
			$this->session->data['filter_shipping_country'] = $filter_shipping_country = '';
		}

		$this->data['shipping_methods'] = $this->model_report_adv_products->getOrderShippingMethods();	
		if (isset($this->request->get['filter_shipping_method'])) {
			$filter_shipping_method = explode(',', $this->request->get['filter_shipping_method']);
			$this->session->data['filter_shipping_method'] = $this->request->get['filter_shipping_method'];
		} else {
			$filter_shipping_method = array();
			$this->session->data['filter_shipping_method'] = '';
		}

		$this->data['categories'] = $this->model_report_adv_products->getProductsCategories(0);
		if (isset($this->request->get['filter_category'])) {
			$filter_category = explode(',', $this->request->get['filter_category']);
			$this->session->data['filter_category'] = $this->request->get['filter_category'];
		} else {
			$filter_category = array();
			$this->session->data['filter_category'] = '';
		}
		
		$this->data['manufacturers'] = $this->model_report_adv_products->getProductsManufacturers(); 
		if (isset($this->request->get['filter_manufacturer'])) {
			$filter_manufacturer = explode(',', $this->request->get['filter_manufacturer']);
			$this->session->data['filter_manufacturer'] = $this->request->get['filter_manufacturer'];
		} else {
			$filter_manufacturer = array();
			$this->session->data['filter_manufacturer'] = '';
		}
		
		if (isset($this->request->get['filter_sku'])) {
			$this->session->data['filter_sku'] = $filter_sku = $this->request->get['filter_sku'];
		} else {
			$this->session->data['filter_sku'] = $filter_sku = '';
		}

		if (isset($this->request->get['filter_product_name'])) {
			$this->session->data['filter_product_name'] = $filter_product_name = $this->request->get['filter_product_name'];
		} else {
			$this->session->data['filter_product_name'] = $filter_product_name = '';
		}
		
		if (isset($this->request->get['filter_model'])) {
			$this->session->data['filter_model'] = $filter_model = $this->request->get['filter_model'];
		} else {
			$this->session->data['filter_model'] = $filter_model = '';
		}

		$this->data['order_options'] = $this->model_report_adv_products->getProductOptions();
		if (isset($this->request->get['filter_option'])) {
			$filter_option = explode(',', $this->request->get['filter_option']);
			$this->session->data['filter_option'] = $this->request->get['filter_option'];
		} else {
			$filter_option = array();
			$this->session->data['filter_option'] = '';
		}

		$this->data['attributes'] = $this->model_report_adv_products->getProductAttributes();
		if (isset($this->request->get['filter_attribute'])) {
			$filter_attribute = explode(',', $this->request->get['filter_attribute']);
			$this->session->data['filter_attribute'] = $this->request->get['filter_attribute'];
		} else {
			$filter_attribute = array();
			$this->session->data['filter_attribute'] = '';
		}

		$this->data['product_statuses'] = $this->model_report_adv_products->getProductStatuses();	
		if (isset($this->request->get['filter_product_status'])) {
			$filter_product_status = explode(',', $this->request->get['filter_product_status']);
			$this->session->data['filter_product_status'] = $this->request->get['filter_product_status'];
		} else {
			$filter_product_status = array();
			$this->session->data['filter_product_status'] = '';
		}
		
		$this->data['locations'] = $this->model_report_adv_products->getProductLocations();
		if (isset($this->request->get['filter_location'])) {
			$filter_location = explode(',', $this->request->get['filter_location']);
			$this->session->data['filter_location'] = $this->request->get['filter_location'];
		} else {
			$filter_location = array();
			$this->session->data['filter_location'] = '';
		}

		$this->data['affiliate_names'] = $this->model_report_adv_products->getOrderAffiliates();
		if (isset($this->request->get['filter_affiliate_name'])) {
			$filter_affiliate_name = explode(',', $this->request->get['filter_affiliate_name']);
			$this->session->data['filter_affiliate_name'] = $this->request->get['filter_affiliate_name'];
		} else {
			$filter_affiliate_name = array();
			$this->session->data['filter_affiliate_name'] = '';
		}

		$this->data['affiliate_emails'] = $this->model_report_adv_products->getOrderAffiliates();
		if (isset($this->request->get['filter_affiliate_email'])) {
			$filter_affiliate_email = explode(',', $this->request->get['filter_affiliate_email']);
			$this->session->data['filter_affiliate_email'] = $this->request->get['filter_affiliate_email'];
		} else {
			$filter_affiliate_email = array();
			$this->session->data['filter_affiliate_email'] = '';
		}

		$this->data['coupon_names'] = $this->model_report_adv_products->getOrderCouponNames();
		if (isset($this->request->get['filter_coupon_name'])) {
			$filter_coupon_name = explode(',', $this->request->get['filter_coupon_name']);
			$this->session->data['filter_coupon_name'] = $this->request->get['filter_coupon_name'];
		} else {
			$filter_coupon_name = array();
			$this->session->data['filter_coupon_name'] = '';
		}

		if (isset($this->request->get['filter_coupon_code'])) {
			$this->session->data['filter_coupon_code'] = $filter_coupon_code = $this->request->get['filter_coupon_code'];
		} else {
			$this->session->data['filter_coupon_code'] = $filter_coupon_code = '';
		}

		if (isset($this->request->get['filter_voucher_code'])) {
			$this->session->data['filter_voucher_code'] = $filter_voucher_code = $this->request->get['filter_voucher_code'];
		} else {
			$this->session->data['filter_voucher_code'] = $filter_voucher_code = '';
		}
		
		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_range'])) {
			$url .= '&filter_range=' . $this->request->get['filter_range'];
		}

		if (isset($this->request->get['filter_report'])) {
			$url .= '&filter_report=' . $this->request->get['filter_report'];
		}

		if (isset($this->request->get['filter_group'])) {
			$url .= '&filter_group=' . $this->request->get['filter_group'];
		}
		
		if (isset($this->request->get['filter_sort'])) {
			$url .= '&filter_sort=' . $this->request->get['filter_sort'];
		}
		
		if (isset($this->request->get['filter_details'])) {
			$url .= '&filter_details=' . $this->request->get['filter_details'];
		}
		
		if (isset($this->request->get['filter_limit'])) {
			$url .= '&filter_limit=' . $this->request->get['filter_limit'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['filter_status_date_start'])) {
			$url .= '&filter_status_date_start=' . $this->request->get['filter_status_date_start'];
		}
		
		if (isset($this->request->get['filter_status_date_end'])) {
			$url .= '&filter_status_date_end=' . $this->request->get['filter_status_date_end'];
		}
		
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_order_id_from'])) {
			$url .= '&filter_order_id_from=' . $this->request->get['filter_order_id_from'];
		}
		
		if (isset($this->request->get['filter_order_id_to'])) {
			$url .= '&filter_order_id_to=' . $this->request->get['filter_order_id_to'];
		}
		
		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
		}
		
		if (isset($this->request->get['filter_currency'])) {
			$url .= '&filter_currency=' . $this->request->get['filter_currency'];
		}
		
		if (isset($this->request->get['filter_taxes'])) {
			$url .= '&filter_taxes=' . $this->request->get['filter_taxes'];
		}
		
		if (isset($this->request->get['filter_tax_classes'])) {
			$url .= '&filter_tax_classes=' . $this->request->get['filter_tax_classes'];
		}
		
		if (isset($this->request->get['filter_geo_zones'])) {
			$url .= '&filter_geo_zones=' . $this->request->get['filter_geo_zones'];
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
		
		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
		}		

		if (isset($this->request->get['filter_customer_email'])) {
			$url .= '&filter_customer_email=' . urlencode(html_entity_decode($this->request->get['filter_customer_email'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_customer_telephone'])) {
			$url .= '&filter_customer_telephone=' . urlencode(html_entity_decode($this->request->get['filter_customer_telephone'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . urlencode(html_entity_decode($this->request->get['filter_ip'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_company'])) {
			$url .= '&filter_payment_company=' . urlencode(html_entity_decode($this->request->get['filter_payment_company'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_address'])) {
			$url .= '&filter_payment_address=' . urlencode(html_entity_decode($this->request->get['filter_payment_address'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_city'])) {
			$url .= '&filter_payment_city=' . urlencode(html_entity_decode($this->request->get['filter_payment_city'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_zone'])) {
			$url .= '&filter_payment_zone=' . urlencode(html_entity_decode($this->request->get['filter_payment_zone'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_postcode'])) {
			$url .= '&filter_payment_postcode=' . urlencode(html_entity_decode($this->request->get['filter_payment_postcode'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_country'])) {
			$url .= '&filter_payment_country=' . urlencode(html_entity_decode($this->request->get['filter_payment_country'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_method'])) {
			$url .= '&filter_payment_method=' . $this->request->get['filter_payment_method'];
		}	
		
		if (isset($this->request->get['filter_shipping_company'])) {
			$url .= '&filter_shipping_company=' . urlencode(html_entity_decode($this->request->get['filter_shipping_company'], ENT_QUOTES, 'UTF-8'));
		}	

		if (isset($this->request->get['filter_shipping_address'])) {
			$url .= '&filter_shipping_address=' . urlencode(html_entity_decode($this->request->get['filter_shipping_address'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_shipping_city'])) {
			$url .= '&filter_shipping_city=' . urlencode(html_entity_decode($this->request->get['filter_shipping_city'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_shipping_zone'])) {
			$url .= '&filter_shipping_zone=' . urlencode(html_entity_decode($this->request->get['filter_shipping_zone'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_shipping_postcode'])) {
			$url .= '&filter_shipping_postcode=' . urlencode(html_entity_decode($this->request->get['filter_shipping_postcode'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_shipping_country'])) {
			$url .= '&filter_shipping_country=' . urlencode(html_entity_decode($this->request->get['filter_shipping_country'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_shipping_method'])) {
			$url .= '&filter_shipping_method=' . $this->request->get['filter_shipping_method'];
		}	
		
		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}	
		
		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}	
		
		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_product_name'])) {
			$url .= '&filter_product_name=' . urlencode(html_entity_decode($this->request->get['filter_product_name'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_option'])) {
			$url .= '&filter_option=' . $this->request->get['filter_option'];
		}	
		
		if (isset($this->request->get['filter_attribute'])) {
			$url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
		}			

		if (isset($this->request->get['filter_product_status'])) {
			$url .= '&filter_product_status=' . $this->request->get['filter_product_status'];
		}
		
		if (isset($this->request->get['filter_location'])) {
			$url .= '&filter_location=' . $this->request->get['filter_location'];
		}	
		
		if (isset($this->request->get['filter_affiliate_name'])) {
			$url .= '&filter_affiliate_name=' . $this->request->get['filter_affiliate_name'];
		}	
		
		if (isset($this->request->get['filter_affiliate_email'])) {
			$url .= '&filter_affiliate_email=' . $this->request->get['filter_affiliate_email'];
		}	
		
		if (isset($this->request->get['filter_coupon_name'])) {
			$url .= '&filter_coupon_name=' . $this->request->get['filter_coupon_name'];
		}	
		
		if (isset($this->request->get['filter_coupon_code'])) {
			$url .= '&filter_coupon_code=' . urlencode(html_entity_decode($this->request->get['filter_coupon_code'], ENT_QUOTES, 'UTF-8'));
		}	

		
		if (isset($this->request->get['filter_voucher_code'])) {
			$url .= '&filter_voucher_code=' . urlencode(html_entity_decode($this->request->get['filter_voucher_code'], ENT_QUOTES, 'UTF-8'));
		}	
		
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/adv_products', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

		if ($this->config->get('advpp' . $this->user->getId() . '_date_format')) {
			$this->data['advpp' . $this->user->getId() . '_date_format'] = $this->config->get('advpp' . $this->user->getId() . '_date_format');
			$this->data['advpp_date_format'] = $this->data['advpp' . $this->user->getId() . '_date_format'];
		} else {
			$this->data['advpp' . $this->user->getId() . '_date_format'] = 'DDMMYYYY';
			$this->data['advpp_date_format'] = $this->data['advpp' . $this->user->getId() . '_date_format'];
		}

		if ($this->config->get('advpp' . $this->user->getId() . '_hour_format')) {
			$this->data['advpp' . $this->user->getId() . '_hour_format'] = $this->config->get('advpp' . $this->user->getId() . '_hour_format');
			$this->data['advpp_hour_format'] = $this->data['advpp' . $this->user->getId() . '_hour_format'];
		} else {
			$this->data['advpp' . $this->user->getId() . '_hour_format'] = '24';
			$this->data['advpp_hour_format'] = $this->data['advpp' . $this->user->getId() . '_hour_format'];
		}
		
		if ($this->config->get('advpp' . $this->user->getId() . '_week_days')) {
			$this->data['advpp' . $this->user->getId() . '_week_days'] = $this->config->get('advpp' . $this->user->getId() . '_week_days');
			$this->data['advpp_week_days'] = $this->data['advpp' . $this->user->getId() . '_week_days'];
		} else {
			$this->data['advpp' . $this->user->getId() . '_week_days'] = 'mon_sun';
			$this->data['advpp_week_days'] = $this->data['advpp' . $this->user->getId() . '_week_days'];
		}
				
		$this->data['auth'] = FALSE;
		$this->data['products'] = array();
		
		$filter_data = array(
			'filter_date_start'	     		=> $filter_date_start, 
			'filter_date_end'	     		=> $filter_date_end,
			'filter_range'           		=> $filter_range,
			'filter_report'           		=> $filter_report,
			'filter_group'           		=> $filter_group,
			'filter_status_date_start'		=> $filter_status_date_start, 
			'filter_status_date_end'		=> $filter_status_date_end, 			
			'filter_order_status_id'		=> $filter_order_status_id,
			'filter_order_id_from'			=> $filter_order_id_from,
			'filter_order_id_to'			=> $filter_order_id_to,			
			'filter_store_id'				=> $filter_store_id,
			'filter_currency'				=> $filter_currency,
			'filter_taxes'					=> $filter_taxes,
			'filter_tax_classes'			=> $filter_tax_classes,
			'filter_geo_zones'				=> $filter_geo_zones,			
			'filter_customer_group_id'		=> $filter_customer_group_id,
			'filter_customer_name'	 	 	=> $filter_customer_name,			
			'filter_customer_email'			=> $filter_customer_email,
			'filter_customer_telephone'		=> $filter_customer_telephone,
			'filter_ip' 	 				=> $filter_ip,			
			'filter_payment_company'		=> $filter_payment_company,
			'filter_payment_address'		=> $filter_payment_address,
			'filter_payment_city'			=> $filter_payment_city,
			'filter_payment_zone'			=> $filter_payment_zone,			
			'filter_payment_postcode'		=> $filter_payment_postcode,
			'filter_payment_country'		=> $filter_payment_country,
			'filter_payment_method'  		=> $filter_payment_method,
			'filter_shipping_company'		=> $filter_shipping_company,
			'filter_shipping_address'		=> $filter_shipping_address,
			'filter_shipping_city'			=> $filter_shipping_city,
			'filter_shipping_zone'			=> $filter_shipping_zone,			
			'filter_shipping_postcode'		=> $filter_shipping_postcode,
			'filter_shipping_country'		=> $filter_shipping_country,
			'filter_shipping_method'  		=> $filter_shipping_method,
			'filter_category'				=> $filter_category,
			'filter_manufacturer'			=> $filter_manufacturer,
			'filter_sku' 	 				=> $filter_sku,
			'filter_product_name'			=> $filter_product_name,
			'filter_model' 	 				=> $filter_model,
			'filter_option'  				=> $filter_option,
			'filter_attribute' 	 		 	=> $filter_attribute,
			'filter_product_status'   		=> $filter_product_status,			
			'filter_location'  				=> $filter_location,
			'filter_affiliate_name'			=> $filter_affiliate_name,
			'filter_affiliate_email'		=> $filter_affiliate_email,
			'filter_coupon_name'			=> $filter_coupon_name,
			'filter_coupon_code'			=> $filter_coupon_code,
			'filter_voucher_code'			=> $filter_voucher_code,			
			'filter_sort'  					=> $filter_sort,
			'filter_details'  				=> $filter_details,
			'filter_limit'  				=> $filter_limit,			
			'start'                  		=> ($page - 1) * $filter_limit
		);
				
		$results = $this->model_report_adv_products->getProducts($filter_data);
		$totals = $this->model_report_adv_products->getProductsTotal($filter_data);

		$counter = 0;
		foreach ($totals as $total) {
			$counter += count($total['counter']);
		}
		$total = $counter;
		
		$this->load->model('tool/image');
			
		foreach ($results as $result) {
			
		if ($filter_details != 'all_details') {

			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
			
			$this->load->model('catalog/product');
			$category = $this->model_catalog_product->getProductCategories($result['product_id']);
			$manufacturer = $this->model_report_adv_products->getProductManufacturers($result['manufacturer_id']);

			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);
			
			if ($product_specials) {
				foreach ($product_specials  as $product_special) {
					if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
						$price = $product_special['price'];
						break;
					}
				}
			} else {
				$price = $result['prod_price'];	
			}
			
			if ($filter_report != 'products_without_orders') {

			$sold_quantity_total = 0;
			$total_excl_vat_total = 0;
			$total_tax_total = 0;
			$total_incl_vat_total = 0;
			$refunds_total = 0;
			$reward_points_total = 0;
	
			foreach ($results as $totals) {				
    			$sold_quantity_total += $totals['sold_quantity'];
				$total_excl_vat_total += $totals['total_excl_vat'];
				$total_tax_total += $totals['total_tax'];
				$total_incl_vat_total += $totals['total_incl_vat'];
				$refunds_total += $totals['refunds'];
				$reward_points_total += $totals['reward_points'];
			}

			if ($sold_quantity_total != 0) {
				$sold_percent = round(100 * ($result['sold_quantity'] / $sold_quantity_total), 2) . '%';
				$sold_percent_total = '100%';		
			} else {
				$sold_percent = 0;
				$sold_percent_total = 0;
			}			
			}
			
		  	if ($filter_report == 'all_products_with_without_orders') {

			$products[] = array(
				'date_added'   						=> date($this->data['advpp_date_format'] == 'DDMMYYYY' ? 'd/m/Y' : 'm/d/Y', strtotime($result['date_added'])),				
				'product_id' 						=> $result['id'],
				'image'      						=> $image,
				'sku'    							=> $result['sku'],
				'name'     							=> $result['name'],				
				'model'    							=> $result['model'],
				'category'  						=> $category,
				'categories'  						=> $result['categories'],
				'manufacturer'  					=> $manufacturer,
				'manufacturers'  					=> $result['manufacturer'],
				'attribute'  						=> $result['attribute'],			
				'status'     						=> ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'location'     						=> $result['location'],
				'tax_class'     					=> $result['tax_class'],
				'price'      						=> $this->currency->format($price, $this->config->get('config_currency')),
				'price_raw'      					=> $price,
				'viewed'     						=> $result['viewed'],
				'stock_quantity'     				=> $result['stock_quantity'],			
				'sold_quantity' 					=> $result['sold_quantity'] ? $result['sold_quantity'] : 0,
				'sold_percent' 						=> $sold_percent,
				'total_excl_vat'    				=> $this->currency->format($result['total_excl_vat'], $this->config->get('config_currency')),
				'total_excl_vat_raw'      			=> $result['total_excl_vat'],
				'total_tax'    						=> $this->currency->format($result['total_tax'], $this->config->get('config_currency')),
				'total_tax_raw'      				=> $result['total_tax'],
				'total_incl_vat'    				=> $this->currency->format($result['total_incl_vat'], $this->config->get('config_currency')),
				'total_incl_vat_raw'      			=> $result['total_incl_vat'],
				'app'      							=> $this->currency->format(($result['total_excl_vat'] ? $result['total_excl_vat'] / $result['sold_quantity'] : 0), $this->config->get('config_currency')),
				'app_raw'    			  			=> $result['total_excl_vat'] ? $result['total_excl_vat'] / $result['sold_quantity'] : 0,
				'refunds'      						=> $this->currency->format($result['refunds'], $this->config->get('config_currency')),
				'refunds_raw'      					=> $result['refunds'],
				'reward_points'      				=> $result['reward_points'] ? $result['reward_points'] : 0,
				'sold_quantity_total' 				=> $sold_quantity_total,
				'sold_percent_total' 				=> $sold_percent_total,
				'total_excl_vat_total' 				=> $this->currency->format($total_excl_vat_total, $this->config->get('config_currency')),
				'total_excl_vat_total_raw'     	 	=> $total_excl_vat_total,
				'total_tax_total' 					=> $this->currency->format($total_tax_total, $this->config->get('config_currency')),
				'total_tax_total_raw'     	 		=> $total_tax_total,
				'total_incl_vat_total' 				=> $this->currency->format($total_incl_vat_total, $this->config->get('config_currency')),
				'total_incl_vat_total_raw'     	 	=> $total_incl_vat_total,
				'app_total' 						=> $total_excl_vat_total ? $this->currency->format($total_excl_vat_total / $sold_quantity_total, $this->config->get('config_currency')) : 0,
				'refunds_total' 					=> $this->currency->format($refunds_total, $this->config->get('config_currency')),
				'reward_points_total'     			=> $reward_points_total ? $reward_points_total : 0,
				'href' 								=> $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], 'SSL')
			);
			
		  	} else if ($filter_report == 'products_without_orders') {
			
			$products[] = array(
				'date_added'   						=> date($this->data['advpp_date_format'] == 'DDMMYYYY' ? 'd/m/Y' : 'm/d/Y', strtotime($result['date_added'])),	
				'product_id'   	  					=> $result['id'],
				'image'      						=> $image,
				'sku'    							=> $result['sku'],
				'name'     							=> $result['name'],	
				'model'    							=> $result['model'],
				'category'  						=> $category,
				'categories'  						=> $result['categories'],
				'manufacturer'  					=> $manufacturer,
				'manufacturers'  					=> $result['manufacturer'],
				'attribute'  						=> $result['attribute'],			
				'status'     						=> ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'location'     						=> $result['location'],
				'tax_class'     					=> $result['tax_class'],
				'price'      						=> $this->currency->format($price, $this->config->get('config_currency')),
				'price_raw'      					=> $price,
				'viewed'     						=> $result['viewed'],				
				'stock_quantity'     				=> $result['quantity'],
				'href' 								=> $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], 'SSL')
			);
			
		  	} else {

			if ($filter_report == 'products_purchased_with_options') {
				
			$option_data = array();
			$options = $this->model_report_adv_products->getOrderOptions($result['order_product_id']);

			foreach ($options as $option) {
				if ($option['type'] != 'textarea' or $option['type'] != 'file' or $option['type'] != 'date' or $option['type'] != 'datetime' or $option['type'] != 'time') {
					$option_data[] = array(
						'name'  => $option['name'],
						'value' => $option['value'],
						'type'  => $option['type']
					);
				}
			}
			
			} else {
			
			$option_data = '';
			
			}
			
			$products[] = array(
				'year'		       					=> $result['year'],
				'quarter'		       				=> 'Q' . $result['quarter'],	
				'year_quarter'		       			=> 'Q' . $result['quarter']. ' ' . $result['year'],
				'month'		       					=> $result['month'],
				'year_month'		       			=> substr($result['month'],0,3) . ' ' . $result['year'],			
				'date_start' 						=> date($this->data['advpp_date_format'] == 'DDMMYYYY' ? 'd/m/Y' : 'm/d/Y', strtotime($result['date_start'])),
				'date_end'   						=> date($this->data['advpp_date_format'] == 'DDMMYYYY' ? 'd/m/Y' : 'm/d/Y', strtotime($result['date_end'])),
				'order_id'   						=> $result['order_id'],	
				'product_id' 						=> $result['product_id'],						
				'order_product_id'     				=> $result['order_product_id'],	
				'image'      						=> $image,
				'sku'    							=> $result['sku'],
				'name'     							=> $result['name'],	
				'options'     						=> $result['options'],	
				'option'   		   					=> $option_data,					
				'model'    							=> $result['model'],
				'category'  						=> $category,
				'categories'  						=> $result['categories'],
				'manufacturer'  					=> $manufacturer,
				'manufacturers'  					=> $result['manufacturer'],
				'attribute'  						=> $result['attribute'],			
				'status'     						=> ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'location'     						=> $result['location'],
				'tax_class'     					=> $result['tax_class'],
				'price'      						=> $this->currency->format($price, $this->config->get('config_currency')),
				'price_raw'      					=> $price,
				'viewed'     						=> $result['viewed'],
				'stock_quantity'     				=> $result['stock_quantity'],
				'stock_oquantity'     				=> $result['stock_oquantity'],				
				'sold_quantity' 					=> $result['sold_quantity'],
				'sold_percent' 						=> $sold_percent,
				'total_excl_vat'    				=> $this->currency->format($result['total_excl_vat'], $this->config->get('config_currency')),
				'total_excl_vat_raw'      			=> $result['total_excl_vat'],
				'total_tax'    						=> $this->currency->format($result['total_tax'], $this->config->get('config_currency')),
				'total_tax_raw'      				=> $result['total_tax'],
				'total_incl_vat'    				=> $this->currency->format($result['total_incl_vat'], $this->config->get('config_currency')),
				'total_incl_vat_raw'      			=> $result['total_incl_vat'],
				'app'      							=> $this->currency->format(($result['total_excl_vat'] ? $result['total_excl_vat'] / $result['sold_quantity'] : 0), $this->config->get('config_currency')),
				'app_raw'    			  			=> $result['total_excl_vat'] ? $result['total_excl_vat'] / $result['sold_quantity'] : 0,
				'refunds'      						=> $this->currency->format($result['refunds'], $this->config->get('config_currency')),
				'refunds_raw'      					=> $result['refunds'],
				'reward_points'      				=> $result['reward_points'] ? $result['reward_points'] : 0,
				'gname'    							=> preg_replace('~\(.*?\)~', '', $result['name']),
				'gcategories'  						=> html_entity_decode($result['categories']),
				'gmanufacturer'    					=> html_entity_decode($result['manufacturer']),
				'gsold'    							=> $result['sold_quantity'],
				'gtotal'      						=> round($result['total_excl_vat'], 2),					
				'order_prod_ord_id'     			=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_ord_id'] : '',
				'order_prod_ord_id_link'     		=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_ord_id_link'] : '',
				'order_prod_ord_date'    			=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_ord_date'] : '',
				'order_prod_inv_no'     			=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_inv_no'] : '',
				'order_prod_name'   				=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_name'] : '',
				'order_prod_email'   				=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_email'] : '',
				'order_prod_group'   				=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_group'] : '',
				'order_prod_shipping_method' 		=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? strip_tags($result['order_prod_shipping_method'], '<br>') : '',
				'order_prod_payment_method'  		=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? strip_tags($result['order_prod_payment_method'], '<br>') : '',
				'order_prod_status'  				=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_status'] : '',
				'order_prod_store'      			=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_store'] : '',	
				'order_prod_currency' 				=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_currency'] : '',
				'order_prod_price' 					=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_price'] : '',
				'order_prod_quantity' 				=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_quantity'] : '',
				'order_prod_total_excl_vat'  		=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_total_excl_vat'] : '',				
				'order_prod_tax'  					=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_tax'] : '',				
				'order_prod_total_incl_vat'  		=> ($filter_report != 'manufacturers' && $filter_report != 'categories') && $filter_details == 'basic_details' ? $result['order_prod_total_incl_vat'] : '',
				'product_ord_id'  					=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_ord_id'] : '',
				'product_ord_id_link'  				=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_ord_id_link'] : '',
				'product_ord_date'    				=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_ord_date'] : '',
				'product_inv_no'     				=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_inv_no'] : '',
				'product_prod_id'  					=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_prod_id'] : '',
				'product_prod_id_link'  			=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_prod_id_link'] : '',
				'product_sku'  						=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_sku'] : '',
				'product_model'  					=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_model'] : '',				
				'product_name'  					=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_name'] : '',
				'product_option'  					=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_option'] : '',
				'product_attributes'  				=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_attributes'] : '',				
				'product_manu'  					=> $filter_report == 'categories' && $filter_details == 'basic_details' ? $result['product_manu'] : '',
				'product_category'  				=> $filter_report == 'manufacturers' && $filter_details == 'basic_details' ? $result['product_category'] : '',				
				'product_currency'  				=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_currency'] : '',
				'product_price'  					=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_price'] : '',
				'product_quantity'  				=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_quantity'] : '',
				'product_total_excl_vat'  			=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_total_excl_vat'] : '',				
				'product_tax'  						=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_tax'] : '',				
				'product_total_incl_vat'  			=> ($filter_report == 'manufacturers' || $filter_report == 'categories') && $filter_details == 'basic_details' ? $result['product_total_incl_vat'] : '',
				'customer_ord_id' 					=> $filter_details == 'basic_details' ? $result['customer_ord_id'] : '',
				'customer_ord_id_link' 				=> $filter_details == 'basic_details' ? $result['customer_ord_id_link'] : '',
				'customer_ord_date' 				=> $filter_details == 'basic_details' ? $result['customer_ord_date'] : '',
				'customer_cust_id' 					=> $filter_details == 'basic_details' ? $result['customer_cust_id'] : '',
				'customer_cust_id_link' 			=> $filter_details == 'basic_details' ? $result['customer_cust_id_link'] : '',
				'billing_name' 						=> $filter_details == 'basic_details' ? $result['billing_name'] : '',
				'billing_company' 					=> $filter_details == 'basic_details' ? $result['billing_company'] : '',
				'billing_address_1' 				=> $filter_details == 'basic_details' ? $result['billing_address_1'] : '',
				'billing_address_2' 				=> $filter_details == 'basic_details' ? $result['billing_address_2'] : '',
				'billing_city' 						=> $filter_details == 'basic_details' ? $result['billing_city'] : '',
				'billing_zone' 						=> $filter_details == 'basic_details' ? $result['billing_zone'] : '',
				'billing_postcode' 					=> $filter_details == 'basic_details' ? $result['billing_postcode'] : '',
				'billing_country' 					=> $filter_details == 'basic_details' ? $result['billing_country'] : '',
				'customer_telephone' 				=> $filter_details == 'basic_details' ? $result['customer_telephone'] : '',
				'shipping_name' 					=> $filter_details == 'basic_details' ? $result['shipping_name'] : '',
				'shipping_company' 					=> $filter_details == 'basic_details' ? $result['shipping_company'] : '',
				'shipping_address_1' 				=> $filter_details == 'basic_details' ? $result['shipping_address_1'] : '',
				'shipping_address_2' 				=> $filter_details == 'basic_details' ? $result['shipping_address_2'] : '',
				'shipping_city' 					=> $filter_details == 'basic_details' ? $result['shipping_city'] : '',
				'shipping_zone' 					=> $filter_details == 'basic_details' ? $result['shipping_zone'] : '',
				'shipping_postcode' 				=> $filter_details == 'basic_details' ? $result['shipping_postcode'] : '',
				'shipping_country' 					=> $filter_details == 'basic_details' ? $result['shipping_country'] : '',				
				'sold_quantity_total' 				=> $sold_quantity_total,
				'sold_percent_total' 				=> $sold_percent_total,
				'total_excl_vat_total' 				=> $this->currency->format($total_excl_vat_total, $this->config->get('config_currency')),
				'total_excl_vat_total_raw'     	 	=> $total_excl_vat_total,
				'total_tax_total' 					=> $this->currency->format($total_tax_total, $this->config->get('config_currency')),
				'total_tax_total_raw'     	 		=> $total_tax_total,
				'total_incl_vat_total' 				=> $this->currency->format($total_incl_vat_total, $this->config->get('config_currency')),
				'total_incl_vat_total_raw'     	 	=> $total_incl_vat_total,
				'app_total' 						=> $total_excl_vat_total ? $this->currency->format($total_excl_vat_total / $sold_quantity_total, $this->config->get('config_currency')) : 0,
				'refunds_total' 					=> $this->currency->format($refunds_total, $this->config->get('config_currency')),
				'reward_points_total'     			=> $reward_points_total ? $reward_points_total : 0,
				'href' 								=> $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], 'SSL')
			);
			
		  }
			  
		} else {
			
			$products[] = array(
				'order_id'   					=> $result['order_id'],	
				'order_id_link'     			=> $result['order_id_link'], 
				'date_added'    				=> date($this->data['advpp_date_format'] == 'DDMMYYYY' ? 'd/m/Y' : 'm/d/Y', strtotime($result['date_added'])),
				'invoice'     					=> $result['invoice_prefix'] . $result['invoice_no'],
				'name'   						=> $result['firstname'] . ' ' . $result['lastname'],
				'email'   						=> $result['email'],
				'cust_group'   					=> $result['cust_group'],
				'product_id'  					=> $result['product_id'],	
				'product_id_link'  				=> $result['product_id_link'],	
				'product_sku'  					=> $result['product_sku'],
				'product_model'  				=> $result['product_model'],				
				'product_name'  				=> $result['product_name'],	
				'product_option'  				=> $result['product_option'],					
				'product_attributes'  			=> $result['product_attributes'],
				'product_manu'  				=> $result['product_manu'],
				'product_category'  			=> $result['product_category'],
				'currency_code' 				=> $result['currency_code'],
				'product_price'        			=> $this->currency->format($result['product_price'], $this->config->get('config_currency')),
				'product_price_raw'  			=> $result['product_price'],
				'product_quantity'  			=> $result['product_quantity'],
				'product_total_excl_vat'  		=> $this->currency->format($result['product_total_excl_vat'], $this->config->get('config_currency')),
				'product_total_excl_vat_raw'  	=> $result['product_total_excl_vat'],
				'product_tax'  					=> $this->currency->format($result['product_tax'], $this->config->get('config_currency')),
				'product_tax_raw'  				=> $result['product_tax'],
				'product_total_incl_vat'  		=> $this->currency->format($result['product_total_incl_vat'], $this->config->get('config_currency')),
				'product_total_incl_vat_raw'  	=> $result['product_total_incl_vat'],
				'product_qty_refund'  			=> $result['product_qty_refund'],
				'product_refund'  				=> $this->currency->format($result['product_refund'], $this->config->get('config_currency')),
				'product_refund_raw'  			=> $result['product_refund'],
				'product_reward_points'      	=> $result['product_reward_points'] ? $result['product_reward_points'] : 0,
				'order_sub_total'  				=> $this->currency->format($result['order_sub_total'], $this->config->get('config_currency')),
				'order_sub_total_raw'  			=> $result['order_sub_total'],
				'order_handling'  				=> $this->currency->format($result['order_handling'], $this->config->get('config_currency')),
				'order_handling_raw'  			=> $result['order_handling'],
				'order_low_order_fee'  			=> $this->currency->format($result['order_low_order_fee'], $this->config->get('config_currency')),
				'order_low_order_fee_raw'		=> $result['order_low_order_fee'],
				'order_shipping'  				=> $this->currency->format($result['order_shipping'], $this->config->get('config_currency')),
				'order_shipping_raw'  			=> $result['order_shipping'],
				'order_reward'  				=> $this->currency->format($result['order_reward'], $this->config->get('config_currency')),
				'order_reward_raw'  			=> $result['order_reward'],
				'order_earned_points'      		=> $result['order_earned_points'] ? $result['order_earned_points'] : 0,
				'order_used_points'      		=> $result['order_used_points'] ? $result['order_used_points'] : 0,				
				'order_coupon'  				=> $this->currency->format($result['order_coupon'], $this->config->get('config_currency')),
				'order_coupon_raw'  			=> $result['order_coupon'],
				'order_coupon_code'  			=> $result['order_coupon_code'],
				'order_tax'  					=> $this->currency->format($result['order_tax'], $this->config->get('config_currency')),
				'order_tax_raw'  				=> $result['order_tax'],
				'order_credit'  				=> $this->currency->format($result['order_credit'], $this->config->get('config_currency')),
				'order_credit_raw'  			=> $result['order_credit'],
				'order_voucher'  				=> $this->currency->format($result['order_voucher'], $this->config->get('config_currency')),
				'order_voucher_raw'  			=> $result['order_voucher'],
				'order_voucher_code'  			=> $result['order_voucher_code'],
				'order_commission'   			=> $this->currency->format('-' . ($result['order_commission']), $this->config->get('config_currency')),
				'order_commission_raw'   		=> $result['order_commission'],				
				'order_value'  					=> $this->currency->format($result['order_value'], $this->config->get('config_currency')),
				'order_value_raw'  				=> $result['order_value'],
				'order_refund'      			=> $this->currency->format($result['order_refund'], $this->config->get('config_currency')),
				'order_refund_raw'      		=> $result['order_refund'],
				'shipping_method' 				=> preg_replace('~\(.*?\)~', '', $result['shipping_method']),
				'payment_method'  				=> preg_replace('~\(.*?\)~', '', $result['payment_method']),
				'order_status'  				=> $result['order_status'],
				'store_name'      				=> $result['store_name'],	
				'customer_id' 					=> $result['customer_id'],	
				'customer_id_link' 				=> $result['customer_id_link'],	
				'payment_firstname' 			=> $result['payment_firstname'],
				'payment_lastname' 				=> $result['payment_lastname'],
				'payment_company' 				=> $result['payment_company'],
				'payment_address_1' 			=> $result['payment_address_1'],
				'payment_address_2' 			=> $result['payment_address_2'],
				'payment_city' 					=> $result['payment_city'],
				'payment_zone' 					=> $result['payment_zone'],
				'payment_zone_id' 				=> $result['payment_zone_id'],
				'payment_zone_code' 			=> $result['payment_zone_code'],
				'payment_postcode' 				=> $result['payment_postcode'],	
				'payment_country' 				=> $result['payment_country'],
				'payment_country_id' 			=> $result['payment_country_id'],
				'payment_country_code' 			=> $result['payment_country_code'],
				'telephone' 					=> $result['telephone'],
				'shipping_firstname' 			=> $result['shipping_firstname'],
				'shipping_lastname' 			=> $result['shipping_lastname'],
				'shipping_company' 				=> $result['shipping_company'],
				'shipping_address_1' 			=> $result['shipping_address_1'],
				'shipping_address_2' 			=> $result['shipping_address_2'],
				'shipping_city' 				=> $result['shipping_city'],
				'shipping_zone' 				=> $result['shipping_zone'],
				'shipping_zone_id' 				=> $result['shipping_zone_id'],
				'shipping_zone_code' 			=> $result['shipping_zone_code'],
				'shipping_postcode' 			=> $result['shipping_postcode'],	
				'shipping_country' 				=> $result['shipping_country'],
				'shipping_country_id' 			=> $result['shipping_country_id'],
				'shipping_country_code' 		=> $result['shipping_country_code'],
				'order_weight' 					=> $result['order_weight'] . $result['weight_class'],
				'order_comment' 				=> $result['comment']
			);
			
			}
			
		}

		$this->data['adv_ext_name'] = $this->language->get('adv_ext_name');
		$this->data['adv_ext_short_name'] = $this->language->get('adv_ext_short_name');
		$this->data['adv_ext_version'] = $this->language->get('adv_ext_version');	
		$this->data['adv_ext_url'] = 'http://www.opencart.com/index.php?route=extension/extension/info&extension_id=3688';
		
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_products_purchased'] = $this->language->get('text_products_purchased');
		$this->data['text_manufacturers'] = $this->language->get('text_manufacturers');
		$this->data['text_categories'] = $this->language->get('text_categories');
		$this->data['text_no_details'] = $this->language->get('text_no_details');
		$this->data['text_basic_details'] = $this->language->get('text_basic_details');
		$this->data['text_all_details'] = $this->language->get('text_all_details');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');		
		$this->data['text_all'] = $this->language->get('text_all');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_all_status'] = $this->language->get('text_all_status');		
		$this->data['text_all_stores'] = $this->language->get('text_all_stores');
		$this->data['text_all_currencies'] = $this->language->get('text_all_currencies');
		$this->data['text_all_taxes'] = $this->language->get('text_all_taxes');	
		$this->data['text_all_tax_classes'] = $this->language->get('text_all_tax_classes');			
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');			
		$this->data['text_all_groups'] = $this->language->get('text_all_groups');
		$this->data['text_all_payment_methods'] = $this->language->get('text_all_payment_methods');	
		$this->data['text_all_shipping_methods'] = $this->language->get('text_all_shipping_methods');
		$this->data['text_all_categories'] = $this->language->get('text_all_categories');
		$this->data['text_all_manufacturers'] = $this->language->get('text_all_manufacturers');		
		$this->data['text_all_options'] = $this->language->get('text_all_options');
		$this->data['text_all_attributes'] = $this->language->get('text_all_attributes');
		$this->data['text_all_locations'] = $this->language->get('text_all_locations');	
		$this->data['text_all_affiliate_names'] = $this->language->get('text_all_affiliate_names');
		$this->data['text_all_affiliate_emails'] = $this->language->get('text_all_affiliate_emails');
		$this->data['text_all_coupon_names'] = $this->language->get('text_all_coupon_names');
		$this->data['text_selected'] = $this->language->get('text_selected');		
		$this->data['text_detail'] = $this->language->get('text_detail');			
		$this->data['text_filter_total'] = $this->language->get('text_filter_total');
		$this->data['text_export_options'] = $this->language->get('text_export_options');
		$this->data['text_report_type'] = $this->language->get('text_report_type');
		$this->data['text_export_type'] = $this->language->get('text_export_type');
		$this->data['text_export_logo_criteria'] = $this->language->get('text_export_logo_criteria');
		$this->data['text_export_csv_delimiter'] = $this->language->get('text_export_csv_delimiter');	
		$this->data['text_export_no_details'] = $this->language->get('text_export_no_details');
		$this->data['text_export_all_details'] = $this->language->get('text_export_all_details');			
		$this->data['text_export_basic_details'] = $this->language->get('text_export_basic_details');
		$this->data['text_local_settings'] = $this->language->get('text_local_settings');
		$this->data['text_filtering_options'] = $this->language->get('text_filtering_options');
		$this->data['text_column_settings'] = $this->language->get('text_column_settings');
		$this->data['text_mv_columns'] = $this->language->get('text_mv_columns');		
		$this->data['text_bd_columns'] = $this->language->get('text_bd_columns');	
		$this->data['text_all_columns'] = $this->language->get('text_all_columns');		
		$this->data['text_export_note'] = $this->language->get('text_export_note');
		$this->data['text_format_date'] = $this->language->get('text_format_date');
		$this->data['text_format_date_eu'] = $this->language->get('text_format_date_eu');
		$this->data['text_format_date_us'] = $this->language->get('text_format_date_us');
		$this->data['text_format_hour'] = $this->language->get('text_format_hour');
		$this->data['text_format_hour_24'] = $this->language->get('text_format_hour_24');
		$this->data['text_format_hour_12'] = $this->language->get('text_format_hour_12');		
		$this->data['text_format_week'] = $this->language->get('text_format_week');
		$this->data['text_format_week_mon_sun'] = $this->language->get('text_format_week_mon_sun');
		$this->data['text_format_week_sun_sat'] = $this->language->get('text_format_week_sun_sat');
		$this->data['text_export_notice1'] = $this->language->get('text_export_notice1');
		$this->data['text_export_notice2'] = $this->language->get('text_export_notice2');		
		$this->data['text_export_limit'] = $this->language->get('text_export_limit');
		$this->data['text_pagin_page'] = $this->language->get('text_pagin_page');
		$this->data['text_pagin_of'] = $this->language->get('text_pagin_of');
		$this->data['text_pagin_results'] = $this->language->get('text_pagin_results');	
		$this->data['text_loading'] = $this->language->get('text_loading');
		$this->data['text_report_date'] = $this->language->get('text_report_date');
		$this->data['text_report_criteria'] = $this->language->get('text_report_criteria');
		$this->data['text_email'] = $this->language->get('text_email');
		$this->data['text_telephone'] = $this->language->get('text_telephone');

		$this->data['column_date'] = $this->language->get('column_date');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_date_end'] = $this->language->get('column_date_end');
		$this->data['column_id'] = $this->language->get('column_id');
		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_sku'] = $this->language->get('column_sku');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_pname'] = $this->language->get('column_pname');
		$this->data['column_poption'] = $this->language->get('column_poption');
		$this->data['column_model'] = $this->language->get('column_model');	
		$this->data['column_category'] = $this->language->get('column_category');		
		$this->data['column_manufacturer'] = $this->language->get('column_manufacturer');
		$this->data['column_attribute'] = $this->language->get('column_attribute');	
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_location'] = $this->language->get('column_location');
		$this->data['column_tax_class'] = $this->language->get('column_tax_class');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_viewed'] = $this->language->get('column_viewed');
		$this->data['column_stock_quantity'] = $this->language->get('column_stock_quantity');		
		$this->data['column_sold_quantity'] = $this->language->get('column_sold_quantity');
		$this->data['column_sold_percent'] = $this->language->get('column_sold_percent');
		$this->data['column_total_excl_vat'] = $this->language->get('column_total_excl_vat');			
		$this->data['column_total_tax'] = $this->language->get('column_total_tax');
		$this->data['column_total_incl_vat'] = $this->language->get('column_total_incl_vat');	
		$this->data['column_app'] = $this->language->get('column_app');
		$this->data['column_product_refunds'] = $this->language->get('column_product_refunds');
		$this->data['column_product_reward_points'] = $this->language->get('column_product_reward_points');	
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['column_sub_total'] = $this->language->get('column_sub_total');
		$this->data['column_handling'] = $this->language->get('column_handling');	
		$this->data['column_loworder'] = $this->language->get('column_loworder');
		$this->data['column_shipping'] = $this->language->get('column_shipping');
		$this->data['column_reward'] = $this->language->get('column_reward');
		$this->data['column_earned_reward_points'] = $this->language->get('column_earned_reward_points');
		$this->data['column_used_reward_points'] = $this->language->get('column_used_reward_points');		
		$this->data['column_coupon'] = $this->language->get('column_coupon');
		$this->data['column_coupon_code'] = $this->language->get('column_coupon_code');
		$this->data['column_taxes'] = $this->language->get('column_taxes');		
		$this->data['column_credit'] = $this->language->get('column_credit');	
		$this->data['column_voucher'] = $this->language->get('column_voucher');	
		$this->data['column_voucher_code'] = $this->language->get('column_voucher_code');	
		$this->data['column_commission'] = $this->language->get('column_commission');	
		$this->data['column_order_date_added'] = $this->language->get('column_order_date_added');
		$this->data['column_order_order_id'] = $this->language->get('column_order_order_id');
		$this->data['column_order_inv_no'] = $this->language->get('column_order_inv_no');
		$this->data['column_order_customer'] = $this->language->get('column_order_customer');
		$this->data['column_order_email'] = $this->language->get('column_order_email');		
		$this->data['column_order_customer_group'] = $this->language->get('column_order_customer_group');		
		$this->data['column_order_shipping_method'] = $this->language->get('column_order_shipping_method');
		$this->data['column_order_payment_method'] = $this->language->get('column_order_payment_method');		
		$this->data['column_order_status'] = $this->language->get('column_order_status');
		$this->data['column_order_store'] = $this->language->get('column_order_store');
		$this->data['column_order_currency'] = $this->language->get('column_order_currency');		
		$this->data['column_order_quantity'] = $this->language->get('column_order_quantity');	
		$this->data['column_order_sub_total'] = $this->language->get('column_order_sub_total');	
		$this->data['column_order_shipping'] = $this->language->get('column_order_shipping');
		$this->data['column_order_tax'] = $this->language->get('column_order_tax');			
		$this->data['column_order_value'] = $this->language->get('column_order_value');
		$this->data['column_order_refund'] = $this->language->get('column_order_refund');	
		$this->data['column_order_commission'] = $this->language->get('column_order_commission');	
		$this->data['column_prod_order_id'] = $this->language->get('column_prod_order_id');		
		$this->data['column_prod_date_added'] = $this->language->get('column_prod_date_added');
		$this->data['column_prod_inv_no'] = $this->language->get('column_prod_inv_no');
		$this->data['column_prod_id'] = $this->language->get('column_prod_id');
		$this->data['column_prod_sku'] = $this->language->get('column_prod_sku');		
		$this->data['column_prod_model'] = $this->language->get('column_prod_model');		
		$this->data['column_prod_name'] = $this->language->get('column_prod_name');	
		$this->data['column_prod_option'] = $this->language->get('column_prod_option');	
		$this->data['column_prod_attributes'] = $this->language->get('column_prod_attributes');			
		$this->data['column_prod_manu'] = $this->language->get('column_prod_manu');
		$this->data['column_prod_category'] = $this->language->get('column_prod_category');		
		$this->data['column_prod_currency'] = $this->language->get('column_prod_currency');
		$this->data['column_prod_price'] = $this->language->get('column_prod_price');
		$this->data['column_prod_quantity'] = $this->language->get('column_prod_quantity');
		$this->data['column_prod_total_excl_vat'] = $this->language->get('column_prod_total_excl_vat');
		$this->data['column_prod_tax'] = $this->language->get('column_prod_tax');
		$this->data['column_prod_total_incl_vat'] = $this->language->get('column_prod_total_incl_vat');
		$this->data['column_prod_qty_refunded'] = $this->language->get('column_prod_qty_refunded');
		$this->data['column_prod_refunded'] = $this->language->get('column_prod_refunded');
		$this->data['column_prod_reward_points'] = $this->language->get('column_prod_reward_points');
		$this->data['column_customer_order_id'] = $this->language->get('column_customer_order_id');
		$this->data['column_customer_date_added'] = $this->language->get('column_customer_date_added');		
		$this->data['column_customer_cust_id'] = $this->language->get('column_customer_cust_id');
		$this->data['column_billing_name'] = $this->language->get('column_billing_name');
		$this->data['column_billing_first_name'] = $this->language->get('column_billing_first_name');
		$this->data['column_billing_last_name'] = $this->language->get('column_billing_last_name');
		$this->data['column_billing_company'] = $this->language->get('column_billing_company');
		$this->data['column_billing_address_1'] = $this->language->get('column_billing_address_1');
		$this->data['column_billing_address_2'] = $this->language->get('column_billing_address_2');
		$this->data['column_billing_city'] = $this->language->get('column_billing_city');
		$this->data['column_billing_zone'] = $this->language->get('column_billing_zone');
		$this->data['column_billing_zone_id'] = $this->language->get('column_billing_zone_id');
		$this->data['column_billing_zone_code'] = $this->language->get('column_billing_zone_code');
		$this->data['column_billing_postcode'] = $this->language->get('column_billing_postcode');		
		$this->data['column_billing_country'] = $this->language->get('column_billing_country');
		$this->data['column_billing_country_id'] = $this->language->get('column_billing_country_id');
		$this->data['column_billing_country_code'] = $this->language->get('column_billing_country_code');
		$this->data['column_customer_telephone'] = $this->language->get('column_customer_telephone');
		$this->data['column_shipping_name'] = $this->language->get('column_shipping_name');
		$this->data['column_shipping_first_name'] = $this->language->get('column_shipping_first_name');
		$this->data['column_shipping_last_name'] = $this->language->get('column_shipping_last_name');
		$this->data['column_shipping_company'] = $this->language->get('column_shipping_company');
		$this->data['column_shipping_address_1'] = $this->language->get('column_shipping_address_1');
		$this->data['column_shipping_address_2'] = $this->language->get('column_shipping_address_2');
		$this->data['column_shipping_city'] = $this->language->get('column_shipping_city');
		$this->data['column_shipping_zone'] = $this->language->get('column_shipping_zone');
		$this->data['column_shipping_zone_id'] = $this->language->get('column_shipping_zone_id');
		$this->data['column_shipping_zone_code'] = $this->language->get('column_shipping_zone_code');
		$this->data['column_shipping_postcode'] = $this->language->get('column_shipping_postcode');		
		$this->data['column_shipping_country'] = $this->language->get('column_shipping_country');
		$this->data['column_shipping_country_id'] = $this->language->get('column_shipping_country_id');
		$this->data['column_shipping_country_code'] = $this->language->get('column_shipping_country_code');
		$this->data['column_order_weight'] = $this->language->get('column_order_weight');
		$this->data['column_order_comment'] = $this->language->get('column_order_comment');	

		$this->data['column_year'] = $this->language->get('column_year');		
		$this->data['column_quarter'] = $this->language->get('column_quarter');
		$this->data['column_month'] = $this->language->get('column_month');
		
		$this->data['column_gtotal'] = $this->language->get('column_gtotal');		

		$this->data['entry_order_created'] = $this->language->get('entry_order_created');
		$this->data['entry_product_added'] = $this->language->get('entry_product_added');
		$this->data['entry_status_changed'] = $this->language->get('entry_status_changed');	
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_range'] = $this->language->get('entry_range');	
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_order_id'] = $this->language->get('entry_order_id');
		$this->data['entry_order_id_from'] = $this->language->get('entry_order_id_from');
		$this->data['entry_order_id_to'] = $this->language->get('entry_order_id_to');		
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_currency'] = $this->language->get('entry_currency');	
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_tax_classes'] = $this->language->get('entry_tax_classes');		
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');		
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_customer_name'] = $this->language->get('entry_customer_name');		
		$this->data['entry_customer_email'] = $this->language->get('entry_customer_email'); 
		$this->data['entry_customer_telephone'] = $this->language->get('entry_customer_telephone');
		$this->data['entry_ip'] = $this->language->get('entry_ip');
		$this->data['entry_payment_company'] = $this->language->get('entry_payment_company');
		$this->data['entry_payment_address'] = $this->language->get('entry_payment_address');
		$this->data['entry_payment_city'] = $this->language->get('entry_payment_city');
		$this->data['entry_payment_zone'] = $this->language->get('entry_payment_zone');		
		$this->data['entry_payment_postcode'] = $this->language->get('entry_payment_postcode');
		$this->data['entry_payment_country'] = $this->language->get('entry_payment_country');		
		$this->data['entry_payment_method'] = $this->language->get('entry_payment_method');
		$this->data['entry_shipping_company'] = $this->language->get('entry_shipping_company');
		$this->data['entry_shipping_address'] = $this->language->get('entry_shipping_address');
		$this->data['entry_shipping_city'] = $this->language->get('entry_shipping_city');
		$this->data['entry_shipping_zone'] = $this->language->get('entry_shipping_zone');		
		$this->data['entry_shipping_postcode'] = $this->language->get('entry_shipping_postcode');
		$this->data['entry_shipping_country'] = $this->language->get('entry_shipping_country');
		$this->data['entry_shipping_method'] = $this->language->get('entry_shipping_method');		
		$this->data['entry_category'] = $this->language->get('entry_category'); 
		$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$this->data['entry_sku'] = $this->language->get('entry_sku');
		$this->data['entry_product'] = $this->language->get('entry_product');
		$this->data['entry_model'] = $this->language->get('entry_model');
		$this->data['entry_option'] = $this->language->get('entry_option');
		$this->data['entry_attributes'] = $this->language->get('entry_attributes');
		$this->data['entry_product_status'] = $this->language->get('entry_product_status');			
		$this->data['entry_location'] = $this->language->get('entry_location');
		$this->data['entry_affiliate_name'] = $this->language->get('entry_affiliate_name');
		$this->data['entry_affiliate_email'] = $this->language->get('entry_affiliate_email');
		$this->data['entry_coupon_name'] = $this->language->get('entry_coupon_name');
		$this->data['entry_coupon_code'] = $this->language->get('entry_coupon_code');
		$this->data['entry_voucher_code'] = $this->language->get('entry_voucher_code');	
		
		$this->data['entry_report'] = $this->language->get('entry_report');
		$this->data['entry_group'] = $this->language->get('entry_group');		
		$this->data['entry_sort_by'] = $this->language->get('entry_sort_by');
		$this->data['entry_show_details'] = $this->language->get('entry_show_details');	
		$this->data['entry_limit'] = $this->language->get('entry_limit');		

		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_chart'] = $this->language->get('button_chart');		
		$this->data['button_export'] = $this->language->get('button_export');
		$this->data['button_settings'] = $this->language->get('button_settings');
		$this->data['button_documentation'] = $this->language->get('button_documentation');
		$this->data['button_close'] = $this->language->get('button_close');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_toggle'] = $this->language->get('button_toggle');
		
		$this->data['error_no_data'] = $this->language->get('error_no_data');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_version'] = $this->language->get('heading_version');	
		
		$this->data['token'] = $this->session->data['token'];

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_range'])) {
			$url .= '&filter_range=' . $this->request->get['filter_range'];
		}

		if (isset($this->request->get['filter_report'])) {
			$url .= '&filter_report=' . $this->request->get['filter_report'];
		}

		if (isset($this->request->get['filter_group'])) {
			$url .= '&filter_group=' . $this->request->get['filter_group'];
		}
		
		if (isset($this->request->get['filter_sort'])) {
			$url .= '&filter_sort=' . $this->request->get['filter_sort'];
		}
		
		if (isset($this->request->get['filter_details'])) {
			$url .= '&filter_details=' . $this->request->get['filter_details'];
		}
		
		if (isset($this->request->get['filter_limit'])) {
			$url .= '&filter_limit=' . $this->request->get['filter_limit'];
		}

		if (isset($this->request->get['filter_status_date_start'])) {
			$url .= '&filter_status_date_start=' . $this->request->get['filter_status_date_start'];
		}
		
		if (isset($this->request->get['filter_status_date_end'])) {
			$url .= '&filter_status_date_end=' . $this->request->get['filter_status_date_end'];
		}
		
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_order_id_from'])) {
			$url .= '&filter_order_id_from=' . $this->request->get['filter_order_id_from'];
		}
		
		if (isset($this->request->get['filter_order_id_to'])) {
			$url .= '&filter_order_id_to=' . $this->request->get['filter_order_id_to'];
		}
		
		if (isset($this->request->get['filter_store_id'])) {
			$url .= '&filter_store_id=' . $this->request->get['filter_store_id'];
		}
		
		if (isset($this->request->get['filter_currency'])) {
			$url .= '&filter_currency=' . $this->request->get['filter_currency'];
		}
		
		if (isset($this->request->get['filter_taxes'])) {
			$url .= '&filter_taxes=' . $this->request->get['filter_taxes'];
		}
		
		if (isset($this->request->get['filter_tax_classes'])) {
			$url .= '&filter_tax_classes=' . $this->request->get['filter_tax_classes'];
		}
		
		if (isset($this->request->get['filter_geo_zones'])) {
			$url .= '&filter_geo_zones=' . $this->request->get['filter_geo_zones'];
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
		
		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
		}		

		if (isset($this->request->get['filter_customer_email'])) {
			$url .= '&filter_customer_email=' . urlencode(html_entity_decode($this->request->get['filter_customer_email'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_customer_telephone'])) {
			$url .= '&filter_customer_telephone=' . urlencode(html_entity_decode($this->request->get['filter_customer_telephone'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . urlencode(html_entity_decode($this->request->get['filter_ip'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_company'])) {
			$url .= '&filter_payment_company=' . urlencode(html_entity_decode($this->request->get['filter_payment_company'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_address'])) {
			$url .= '&filter_payment_address=' . urlencode(html_entity_decode($this->request->get['filter_payment_address'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_city'])) {
			$url .= '&filter_payment_city=' . urlencode(html_entity_decode($this->request->get['filter_payment_city'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_zone'])) {
			$url .= '&filter_payment_zone=' . urlencode(html_entity_decode($this->request->get['filter_payment_zone'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_postcode'])) {
			$url .= '&filter_payment_postcode=' . urlencode(html_entity_decode($this->request->get['filter_payment_postcode'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_country'])) {
			$url .= '&filter_payment_country=' . urlencode(html_entity_decode($this->request->get['filter_payment_country'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_payment_method'])) {
			$url .= '&filter_payment_method=' . $this->request->get['filter_payment_method'];
		}	
		
		if (isset($this->request->get['filter_shipping_company'])) {
			$url .= '&filter_shipping_company=' . urlencode(html_entity_decode($this->request->get['filter_shipping_company'], ENT_QUOTES, 'UTF-8'));
		}	

		if (isset($this->request->get['filter_shipping_address'])) {
			$url .= '&filter_shipping_address=' . urlencode(html_entity_decode($this->request->get['filter_shipping_address'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_shipping_city'])) {
			$url .= '&filter_shipping_city=' . urlencode(html_entity_decode($this->request->get['filter_shipping_city'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_shipping_zone'])) {
			$url .= '&filter_shipping_zone=' . urlencode(html_entity_decode($this->request->get['filter_shipping_zone'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_shipping_postcode'])) {
			$url .= '&filter_shipping_postcode=' . urlencode(html_entity_decode($this->request->get['filter_shipping_postcode'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_shipping_country'])) {
			$url .= '&filter_shipping_country=' . urlencode(html_entity_decode($this->request->get['filter_shipping_country'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_shipping_method'])) {
			$url .= '&filter_shipping_method=' . $this->request->get['filter_shipping_method'];
		}	
		
		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}	
		
		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}	
		
		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_product_name'])) {
			$url .= '&filter_product_name=' . urlencode(html_entity_decode($this->request->get['filter_product_name'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_option'])) {
			$url .= '&filter_option=' . $this->request->get['filter_option'];
		}	
		
		if (isset($this->request->get['filter_attribute'])) {
			$url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
		}			

		if (isset($this->request->get['filter_product_status'])) {
			$url .= '&filter_product_status=' . $this->request->get['filter_product_status'];
		}
		
		if (isset($this->request->get['filter_location'])) {
			$url .= '&filter_location=' . $this->request->get['filter_location'];
		}	
		
		if (isset($this->request->get['filter_affiliate_name'])) {
			$url .= '&filter_affiliate_name=' . $this->request->get['filter_affiliate_name'];
		}	
		
		if (isset($this->request->get['filter_affiliate_email'])) {
			$url .= '&filter_affiliate_email=' . $this->request->get['filter_affiliate_email'];
		}	
		
		if (isset($this->request->get['filter_coupon_name'])) {
			$url .= '&filter_coupon_name=' . $this->request->get['filter_coupon_name'];
		}	
		
		if (isset($this->request->get['filter_coupon_code'])) {
			$url .= '&filter_coupon_code=' . urlencode(html_entity_decode($this->request->get['filter_coupon_code'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_voucher_code'])) {
			$url .= '&filter_voucher_code=' . urlencode(html_entity_decode($this->request->get['filter_voucher_code'], ENT_QUOTES, 'UTF-8'));
		}

		unset($this->session->data['products_data']);
		$total > 0 ? $this->session->data['products_data'] = $this->data['products'] = $products : '';
		$this->data['user'] = $this->user->getId();

		$this->data['report_types'][] = array(
			'name'			=> $this->language->get('text_export_no_details'),
			'type'			=> 'export_no_details'
		);
		$this->data['report_types'][] = array(
			'name'			=> $this->language->get('text_export_basic_details'),
			'type'			=> 'export_basic_details'
		);
		$this->data['report_types'][] = array(
			'name'			=> $this->language->get('text_export_all_details'),
			'type'			=> 'export_all_details'
		);

		if (isset($this->session->data['report_type'])) {
			$this->data['report_type'] = $this->session->data['report_type'];
		} else {
			$this->data['report_type'] = 'export_no_details';
		}

		$this->data['export_types'][] = array(
			'name'			=> $this->language->get('text_export_xlsx'),
			'type'			=> 'export_xlsx'
		);
		$this->data['export_types'][] = array(
			'name'			=> $this->language->get('text_export_xls'),
			'type'			=> 'export_xls'
		);
		$this->data['export_types'][] = array(
			'name'			=> $this->language->get('text_export_csv'),
			'type'			=> 'export_csv'
		);		
		$this->data['export_types'][] = array(
			'name'			=> $this->language->get('text_export_pdf'),
			'type'			=> 'export_pdf'
		);
		$this->data['export_types'][] = array(
			'name'			=> $this->language->get('text_export_html'),
			'type'			=> 'export_html'
		);
		
		if (isset($this->session->data['export_type'])) {
			$this->data['export_type'] = $this->session->data['export_type'];
		} else {
			$this->data['export_type'] = '';
		}
		
		if (isset($this->session->data['export_logo_criteria'])) {
			$this->data['export_logo_criteria'] = $this->session->data['export_logo_criteria'];
		} else {
			$this->data['export_logo_criteria'] = 0;
		}

		$this->data['export_csv_delimiters'][] = array(
			'name'			=> $this->language->get('text_csv_delimiter_comma'),
			'type'			=> 'comma'
		);
		$this->data['export_csv_delimiters'][] = array(
			'name'			=> $this->language->get('text_csv_delimiter_semi'),
			'type'			=> 'semi'
		);
		$this->data['export_csv_delimiters'][] = array(
			'name'			=> $this->language->get('text_csv_delimiter_tab'),
			'type'			=> 'tab'
		);
		
		if (isset($this->session->data['export_csv_delimiter'])) {
			$this->data['export_csv_delimiter'] = $this->session->data['export_csv_delimiter'];
		} else {
			$this->data['export_csv_delimiter'] = 'comma';
		}
		
		$this->data['filters'] = array(
			'store'					=> substr($this->language->get('entry_store'),0,-1),			
			'currency'				=> substr($this->language->get('entry_currency'),0,-1),			
			'tax'					=> substr($this->language->get('entry_tax'),0,-1),			
			'tax_class'				=> substr($this->language->get('entry_tax_classes'),0,-1),
			'geo_zone'				=> substr($this->language->get('entry_geo_zone'),0,-1),
			'customer_group'		=> substr($this->language->get('entry_customer_group'),0,-1),
			'customer_name'			=> substr($this->language->get('entry_customer_name'),0,-1),
			'customer_email'		=> substr($this->language->get('entry_customer_email'),0,-1),
			'customer_telephone'	=> substr($this->language->get('entry_customer_telephone'),0,-1),
			'ip'					=> substr($this->language->get('entry_ip'),0,-1),
			'payment_company'		=> substr($this->language->get('entry_payment_company'),0,-1),			
			'payment_address'		=> substr($this->language->get('entry_payment_address'),0,-1),	
			'payment_city'			=> substr($this->language->get('entry_payment_city'),0,-1),	
			'payment_zone'			=> substr($this->language->get('entry_payment_zone'),0,-1),	
			'payment_postcode'		=> substr($this->language->get('entry_payment_postcode'),0,-1),	
			'payment_country'		=> substr($this->language->get('entry_payment_country'),0,-1),
			'payment_method'		=> substr($this->language->get('entry_payment_method'),0,-1),
			'shipping_company'		=> substr($this->language->get('entry_shipping_company'),0,-1),
			'shipping_address'		=> substr($this->language->get('entry_shipping_address'),0,-1),
			'shipping_city'			=> substr($this->language->get('entry_shipping_city'),0,-1),
			'shipping_zone'			=> substr($this->language->get('entry_shipping_zone'),0,-1),
			'shipping_postcode'		=> substr($this->language->get('entry_shipping_postcode'),0,-1),
			'shipping_country'		=> substr($this->language->get('entry_shipping_country'),0,-1),
			'shipping_method'		=> substr($this->language->get('entry_shipping_method'),0,-1),
			'category'				=> substr($this->language->get('entry_category'),0,-1),
			'manufacturer'			=> substr($this->language->get('entry_manufacturer'),0,-1),
			'sku'					=> substr($this->language->get('entry_sku'),0,-1),
			'product'				=> substr($this->language->get('entry_product'),0,-1),
			'model'					=> substr($this->language->get('entry_model'),0,-1),
			'option'				=> substr($this->language->get('entry_option'),0,-1),
			'attribute'				=> substr($this->language->get('entry_attributes'),0,-1),
			'product_status'		=> substr($this->language->get('entry_product_status'),0,-1),
			'location'				=> substr($this->language->get('entry_location'),0,-1),
			'affiliate_name'		=> substr($this->language->get('entry_affiliate_name'),0,-1),
			'affiliate_email'		=> substr($this->language->get('entry_affiliate_email'),0,-1),
			'coupon_name'			=> substr($this->language->get('entry_coupon_name'),0,-1),
			'coupon_code'			=> substr($this->language->get('entry_coupon_code'),0,-1),
			'voucher_code'			=> substr($this->language->get('entry_voucher_code'),0,-1)
		);

		if ($this->config->get('advpp' . $this->user->getId() . '_settings_filters')) {
			$this->data['advpp' . $this->user->getId() . '_settings_filters'] = $this->config->get('advpp' . $this->user->getId() . '_settings_filters');
			$this->data['advpp_settings_filters'] = $this->data['advpp' . $this->user->getId() . '_settings_filters'];
		} else {
			$this->data['advpp' . $this->user->getId() . '_settings_filters'] = array_keys($this->data['filters']);
			$this->data['advpp_settings_filters'] = $this->data['advpp' . $this->user->getId() . '_settings_filters'];
		}
		
		$this->data['mv_columns'] = array(
			'mv_id'					=> $this->language->get('column_id'),
			'mv_image'				=> $this->language->get('column_image'),
			'mv_sku'				=> $this->language->get('column_sku'),
			'mv_name'				=> $this->language->get('column_name'),
			'mv_model'				=> $this->language->get('column_model'),	
			'mv_category'			=> $this->language->get('column_category'),
			'mv_manufacturer'		=> $this->language->get('column_manufacturer'),
			'mv_attribute'			=> $this->language->get('column_attribute'),
			'mv_status'				=> $this->language->get('column_status'),	
			'mv_location'			=> $this->language->get('column_location'),	
			'mv_tax_class'			=> $this->language->get('column_tax_class'),	
			'mv_price'				=> $this->language->get('column_price'),
			'mv_viewed'				=> $this->language->get('column_viewed'),
			'mv_stock_quantity'		=> $this->language->get('column_stock_quantity'),
			'mv_sold_quantity'		=> $this->language->get('column_sold_quantity'),
			'mv_sold_percent'		=> $this->language->get('column_sold_percent'),
			'mv_total_excl_vat'		=> $this->language->get('column_total_excl_vat'),
			'mv_total_tax'			=> $this->language->get('column_total_tax'),
			'mv_total_incl_vat'		=> $this->language->get('column_total_incl_vat'),
			'mv_app'				=> $this->language->get('column_app'),
			'mv_refunds'			=> $this->language->get('column_product_refunds'),
			'mv_reward_points'		=> $this->language->get('column_product_reward_points')
		);
				
		if ($this->config->get('advpp' . $this->user->getId() . '_settings_mv_columns')) {
			$this->data['advpp' . $this->user->getId() . '_settings_mv_columns'] = $this->config->get('advpp' . $this->user->getId() . '_settings_mv_columns');
			$this->data['advpp_settings_mv_columns'] = $this->data['advpp' . $this->user->getId() . '_settings_mv_columns'];
		} else {
			$this->data['advpp' . $this->user->getId() . '_settings_mv_columns'] = array('mv_id','mv_image','mv_name','mv_model','mv_category','mv_manufacturer','mv_status','mv_stock_quantity','mv_sold_quantity','mv_sold_percent','mv_total_excl_vat','mv_total_tax','mv_total_incl_vat','mv_app','mv_refunds');
			$this->data['advpp_settings_mv_columns'] = $this->data['advpp' . $this->user->getId() . '_settings_mv_columns'];
		}	
		
		$this->data['ol_columns'] = array(
			'ol_order_order_id'			=> $this->language->get('column_order_order_id'),			
			'ol_order_date_added'		=> $this->language->get('column_order_date_added'),			
			'ol_order_inv_no'			=> $this->language->get('column_order_inv_no'),			
			'ol_order_customer'			=> $this->language->get('column_order_customer'),
			'ol_order_email'			=> $this->language->get('column_order_email'),
			'ol_order_customer_group'	=> $this->language->get('column_order_customer_group'),
			'ol_order_shipping_method'	=> $this->language->get('column_order_shipping_method'),
			'ol_order_payment_method'	=> $this->language->get('column_order_payment_method'),
			'ol_order_status'			=> $this->language->get('column_order_status'),
			'ol_order_store'			=> $this->language->get('column_order_store'),
			'ol_order_currency'			=> $this->language->get('column_order_currency'),
			'ol_prod_price'				=> $this->language->get('column_prod_price'),
			'ol_prod_quantity'			=> $this->language->get('column_prod_quantity'),	
			'ol_prod_total_excl_vat'	=> $this->language->get('column_prod_total_excl_vat'),	
			'ol_prod_tax'				=> $this->language->get('column_prod_tax'),	
			'ol_prod_total_incl_vat'	=> $this->language->get('column_prod_total_incl_vat')
		);

		if ($this->config->get('advpp' . $this->user->getId() . '_settings_ol_columns')) {
			$this->data['advpp' . $this->user->getId() . '_settings_ol_columns'] = $this->config->get('advpp' . $this->user->getId() . '_settings_ol_columns');
			$this->data['advpp_settings_ol_columns'] = $this->data['advpp' . $this->user->getId() . '_settings_ol_columns'];
		} else {
			$this->data['advpp' . $this->user->getId() . '_settings_ol_columns'] = array_keys($this->data['ol_columns']);
			$this->data['advpp_settings_ol_columns'] = $this->data['advpp' . $this->user->getId() . '_settings_ol_columns'];
		}
		
		$this->data['pl_columns'] = array(
			'pl_prod_order_id'			=> $this->language->get('column_prod_order_id'),			
			'pl_prod_date_added'		=> $this->language->get('column_prod_date_added'),										
			'pl_prod_inv_no'			=> $this->language->get('column_prod_inv_no'),
			'pl_prod_id'				=> $this->language->get('column_prod_id'),
			'pl_prod_sku'				=> $this->language->get('column_prod_sku'),
			'pl_prod_model'				=> $this->language->get('column_prod_model'),
			'pl_prod_name'				=> $this->language->get('column_prod_name'),
			'pl_prod_option'			=> $this->language->get('column_prod_option'),
			'pl_prod_attributes'		=> $this->language->get('column_prod_attributes'),
			'pl_prod_manu'				=> $this->language->get('column_prod_manu'),
			'pl_prod_category'			=> $this->language->get('column_prod_category'),			
			'pl_prod_currency'			=> $this->language->get('column_prod_currency'),	
			'pl_prod_price'				=> $this->language->get('column_prod_price'),	
			'pl_prod_quantity'			=> $this->language->get('column_prod_quantity'),	
			'pl_prod_total_excl_vat'	=> $this->language->get('column_prod_total_excl_vat'),	
			'pl_prod_tax'				=> $this->language->get('column_prod_tax'),	
			'pl_prod_total_incl_vat'	=> $this->language->get('column_prod_total_incl_vat')
		);

		if ($this->config->get('advpp' . $this->user->getId() . '_settings_pl_columns')) {
			$this->data['advpp' . $this->user->getId() . '_settings_pl_columns'] = $this->config->get('advpp' . $this->user->getId() . '_settings_pl_columns');
			$this->data['advpp_settings_pl_columns'] = $this->data['advpp' . $this->user->getId() . '_settings_pl_columns'];
		} else {
			$this->data['advpp' . $this->user->getId() . '_settings_pl_columns'] = array('pl_prod_order_id','pl_prod_date_added','pl_prod_inv_no','pl_prod_id','pl_prod_sku','pl_prod_model','pl_prod_name','pl_prod_option','pl_prod_manu','pl_prod_category','pl_prod_currency','pl_prod_price','pl_prod_quantity','pl_prod_total_excl_vat','pl_prod_tax','pl_prod_total_incl_vat');
			$this->data['advpp_settings_pl_columns'] = $this->data['advpp' . $this->user->getId() . '_settings_pl_columns'];
		}
		
		$this->data['cl_columns'] = array(
			'cl_customer_order_id'		=> $this->language->get('column_customer_order_id'),			
			'cl_customer_date_added'	=> $this->language->get('column_customer_date_added'),										
			'cl_customer_cust_id'		=> $this->language->get('column_customer_cust_id'),
			'cl_billing_name'			=> strip_tags($this->language->get('column_billing_name')),
			'cl_billing_company'		=> strip_tags($this->language->get('column_billing_company')),
			'cl_billing_address_1'		=> strip_tags($this->language->get('column_billing_address_1')),
			'cl_billing_address_2'		=> strip_tags($this->language->get('column_billing_address_2')),
			'cl_billing_city'			=> strip_tags($this->language->get('column_billing_city')),
			'cl_billing_zone'			=> strip_tags($this->language->get('column_billing_zone')),
			'cl_billing_postcode'		=> strip_tags($this->language->get('column_billing_postcode')),			
			'cl_billing_country'		=> strip_tags($this->language->get('column_billing_country')),
			'cl_customer_telephone'		=> $this->language->get('column_customer_telephone'),
			'cl_shipping_name'			=> strip_tags($this->language->get('column_shipping_name')),	
			'cl_shipping_company'		=> strip_tags($this->language->get('column_shipping_company')),	
			'cl_shipping_address_1'		=> strip_tags($this->language->get('column_shipping_address_1')),	
			'cl_shipping_address_2'		=> strip_tags($this->language->get('column_shipping_address_2')),
			'cl_shipping_city'			=> strip_tags($this->language->get('column_shipping_city')),
			'cl_shipping_zone'			=> strip_tags($this->language->get('column_shipping_zone')),
			'cl_shipping_postcode'		=> strip_tags($this->language->get('column_shipping_postcode')),
			'cl_shipping_country'		=> strip_tags($this->language->get('column_shipping_country'))
		);

		if ($this->config->get('advpp' . $this->user->getId() . '_settings_cl_columns')) {
			$this->data['advpp' . $this->user->getId() . '_settings_cl_columns'] = $this->config->get('advpp' . $this->user->getId() . '_settings_cl_columns');
			$this->data['advpp_settings_cl_columns'] = $this->data['advpp' . $this->user->getId() . '_settings_cl_columns'];
		} else {
			$this->data['advpp' . $this->user->getId() . '_settings_cl_columns'] = array('cl_customer_order_id','cl_customer_date_added','cl_customer_cust_id','cl_billing_name','cl_billing_company','cl_billing_address_1','cl_billing_city','cl_billing_zone','cl_billing_postcode','cl_billing_country','cl_customer_telephone','cl_shipping_name','cl_shipping_company','cl_shipping_address_1','cl_shipping_city','cl_shipping_zone','cl_shipping_postcode','cl_shipping_country');
			$this->data['advpp_settings_cl_columns'] = $this->data['advpp' . $this->user->getId() . '_settings_cl_columns'];
		}
		
		$this->data['all_columns'] = array(
			'all_order_inv_no'			=> $this->language->get('column_order_inv_no'),			
			'all_order_customer_name'	=> $this->language->get('column_order_customer'),			
			'all_order_email'			=> $this->language->get('column_order_email'),			
			'all_order_customer_group'	=> $this->language->get('column_order_customer_group'),
			'all_prod_id'				=> $this->language->get('column_prod_id'),
			'all_prod_sku'				=> $this->language->get('column_prod_sku'),
			'all_prod_model'			=> $this->language->get('column_prod_model'),
			'all_prod_name'				=> $this->language->get('column_prod_name'),
			'all_prod_option'			=> $this->language->get('column_prod_option'),
			'all_prod_attributes'		=> $this->language->get('column_prod_attributes'),
			'all_prod_manu'				=> $this->language->get('column_prod_manu'),
			'all_prod_category'			=> $this->language->get('column_prod_category'),
			'all_prod_currency'			=> $this->language->get('column_prod_currency'),
			'all_prod_price'			=> $this->language->get('column_prod_price'),
			'all_prod_quantity'			=> $this->language->get('column_prod_quantity'),
			'all_prod_total_excl_vat'	=> $this->language->get('column_prod_total_excl_vat'),
			'all_prod_tax'				=> $this->language->get('column_prod_tax'),
			'all_prod_total_incl_vat'	=> $this->language->get('column_prod_total_incl_vat'),
			'all_prod_qty_refund'		=> $this->language->get('column_prod_qty_refunded'),
			'all_prod_refund'			=> $this->language->get('column_prod_refunded'),
			'all_prod_reward_points'	=> $this->language->get('column_prod_reward_points'),
			'all_sub_total'				=> $this->language->get('column_sub_total'),
			'all_handling'				=> $this->language->get('column_handling'),
			'all_loworder'				=> $this->language->get('column_loworder'),
			'all_shipping'				=> $this->language->get('column_shipping'),
			'all_reward'				=> $this->language->get('column_reward'),
			'all_reward_points'			=> $this->language->get('column_reward_points'),			
			'all_coupon'				=> $this->language->get('column_coupon'),
			'all_coupon_code'			=> $this->language->get('column_coupon_code'),
			'all_order_tax'				=> $this->language->get('column_order_tax'),
			'all_credit'				=> $this->language->get('column_credit'),
			'all_voucher'				=> $this->language->get('column_voucher'),
			'all_voucher_code'			=> $this->language->get('column_voucher_code'),
			'all_order_commission'		=> $this->language->get('column_commission'),			
			'all_order_value'			=> $this->language->get('column_order_value'),
			'all_refund'				=> $this->language->get('column_order_refund'),
			'all_order_shipping_method'	=> $this->language->get('column_order_shipping_method'),
			'all_order_payment_method'	=> $this->language->get('column_order_payment_method'),
			'all_order_status'			=> $this->language->get('column_order_status'),
			'all_order_store'			=> $this->language->get('column_order_store'),
			'all_customer_cust_id'		=> $this->language->get('column_customer_cust_id'),
			'all_billing_first_name'	=> strip_tags($this->language->get('column_billing_first_name')),
			'all_billing_last_name'		=> strip_tags($this->language->get('column_billing_last_name')),
			'all_billing_company'		=> strip_tags($this->language->get('column_billing_company')),
			'all_billing_address_1'		=> strip_tags($this->language->get('column_billing_address_1')),
			'all_billing_address_2'		=> strip_tags($this->language->get('column_billing_address_2')),
			'all_billing_city'			=> strip_tags($this->language->get('column_billing_city')),
			'all_billing_zone'			=> strip_tags($this->language->get('column_billing_zone')),
			'all_billing_zone_id'		=> strip_tags($this->language->get('column_billing_zone_id')),
			'all_billing_zone_code'		=> strip_tags($this->language->get('column_billing_zone_code')),
			'all_billing_postcode'		=> strip_tags($this->language->get('column_billing_postcode')),			
			'all_billing_country'		=> strip_tags($this->language->get('column_billing_country')),
			'all_billing_country_id'	=> strip_tags($this->language->get('column_billing_country_id')),
			'all_billing_country_code'	=> strip_tags($this->language->get('column_billing_country_code')),
			'all_customer_telephone'	=> $this->language->get('column_customer_telephone'),
			'all_shipping_first_name'	=> strip_tags($this->language->get('column_shipping_first_name')),
			'all_shipping_last_name'	=> strip_tags($this->language->get('column_shipping_last_name')),
			'all_shipping_company'		=> strip_tags($this->language->get('column_shipping_company')),	
			'all_shipping_address_1'	=> strip_tags($this->language->get('column_shipping_address_1')),	
			'all_shipping_address_2'	=> strip_tags($this->language->get('column_shipping_address_2')),
			'all_shipping_city'			=> strip_tags($this->language->get('column_shipping_city')),
			'all_shipping_zone'			=> strip_tags($this->language->get('column_shipping_zone')),
			'all_shipping_zone_id'		=> strip_tags($this->language->get('column_shipping_zone_id')),
			'all_shipping_zone_code'	=> strip_tags($this->language->get('column_shipping_zone_code')),
			'all_shipping_postcode'		=> strip_tags($this->language->get('column_shipping_postcode')),
			'all_shipping_country'		=> strip_tags($this->language->get('column_shipping_country')),
			'all_shipping_country_id'	=> strip_tags($this->language->get('column_shipping_country_id')),
			'all_shipping_country_code'	=> strip_tags($this->language->get('column_shipping_country_code')),
			'all_order_weight'			=> $this->language->get('column_order_weight'),
			'all_order_comment'			=> $this->language->get('column_order_comment')
		);

		if ($this->config->get('advpp' . $this->user->getId() . '_settings_all_columns')) {
			$this->data['advpp' . $this->user->getId() . '_settings_all_columns'] = $this->config->get('advpp' . $this->user->getId() . '_settings_all_columns');
			$this->data['advpp_settings_all_columns'] = $this->data['advpp' . $this->user->getId() . '_settings_all_columns'];
		} else {
			$this->data['advpp' . $this->user->getId() . '_settings_all_columns'] = array_keys($this->data['all_columns']);
			$this->data['advpp_settings_all_columns'] = $this->data['advpp' . $this->user->getId() . '_settings_all_columns'];
		}

		$user = 'advpp' . $this->user->getId();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE store_id = '0' AND `group` = '" . $user . "'");
		$this->data['initialise'] = '';
		 if (!$query->rows) {
			$this->data['text_initialise_use'] = $this->language->get('text_initialise_use');			 
			$this->data['initialise'] = $query;
			$settings_data = array(
				'advpp' . $this->user->getId() . '_settings_filters' 		=> array_keys($this->data['filters']),
				'advpp' . $this->user->getId() . '_settings_mv_columns' 	=> array('mv_id','mv_image','mv_name','mv_model','mv_category','mv_manufacturer','mv_status','mv_stock_quantity','mv_sold_quantity','mv_sold_percent','mv_total_excl_vat','mv_total_tax','mv_total_incl_vat','mv_app','mv_refunds'),	
				'advpp' . $this->user->getId() . '_settings_ol_columns' 	=> array_keys($this->data['ol_columns']),
				'advpp' . $this->user->getId() . '_settings_pl_columns' 	=> array('pl_prod_order_id','pl_prod_date_added','pl_prod_inv_no','pl_prod_id','pl_prod_sku','pl_prod_model','pl_prod_name','pl_prod_option','pl_prod_manu','pl_prod_currency','pl_prod_price','pl_prod_quantity','pl_prod_total_excl_vat','pl_prod_tax','pl_prod_total_incl_vat'),
				'advpp' . $this->user->getId() . '_settings_cl_columns' 	=> array('cl_customer_order_id','cl_customer_date_added','cl_customer_cust_id','cl_billing_name','cl_billing_company','cl_billing_address_1','cl_billing_city','cl_billing_zone','cl_billing_postcode','cl_billing_country','cl_customer_telephone','cl_shipping_name','cl_shipping_company','cl_shipping_address_1','cl_shipping_city','cl_shipping_zone','cl_shipping_postcode','cl_shipping_country'),
				'advpp' . $this->user->getId() . '_settings_all_columns' 	=> array_keys($this->data['all_columns'])
			);
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting($user, $settings_data);
		}
		
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $filter_limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/adv_products', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;
		$this->data['filter_range'] = $filter_range;
		$this->data['filter_report'] = $filter_report;
		$this->data['filter_group'] = $filter_group;		
		$this->data['filter_sort'] = $filter_sort;	
		$this->data['filter_details'] = $filter_details;
		$this->data['filter_limit'] = $filter_limit;		
		$this->data['filter_status_date_start'] = $filter_status_date_start;
		$this->data['filter_status_date_end'] = $filter_status_date_end;
		$this->data['filter_order_status_id'] = $filter_order_status_id;		
		$this->data['filter_order_id_from'] = $filter_order_id_from;
		$this->data['filter_order_id_to'] = $filter_order_id_to;
		$this->data['filter_store_id'] = $filter_store_id;
		$this->data['filter_currency'] = $filter_currency;
		$this->data['filter_taxes'] = $filter_taxes;
		$this->data['filter_tax_classes'] = $filter_tax_classes;		
		$this->data['filter_geo_zones'] = $filter_geo_zones;
		$this->data['filter_customer_group_id'] = $filter_customer_group_id;
		$this->data['filter_customer_name'] = $filter_customer_name; 
		$this->data['filter_customer_email'] = $filter_customer_email; 		
		$this->data['filter_customer_telephone'] = $filter_customer_telephone;
		$this->data['filter_ip'] = $filter_ip;
		$this->data['filter_payment_company'] = $filter_payment_company; 
		$this->data['filter_payment_address'] = $filter_payment_address; 
		$this->data['filter_payment_city'] = $filter_payment_city; 
		$this->data['filter_payment_postcode'] = $filter_payment_postcode; 
		$this->data['filter_payment_zone'] = $filter_payment_zone; 
		$this->data['filter_payment_country'] = $filter_payment_country; 
		$this->data['filter_payment_method'] = $filter_payment_method; 		
		$this->data['filter_shipping_company'] = $filter_shipping_company; 
		$this->data['filter_shipping_address'] = $filter_shipping_address; 
		$this->data['filter_shipping_city'] = $filter_shipping_city; 
		$this->data['filter_shipping_postcode'] = $filter_shipping_postcode; 
		$this->data['filter_shipping_zone'] = $filter_shipping_zone; 
		$this->data['filter_shipping_country'] = $filter_shipping_country; 
		$this->data['filter_shipping_method'] = $filter_shipping_method; 
		$this->data['filter_manufacturer'] = $filter_manufacturer; 
		$this->data['filter_category'] = $filter_category; 
		$this->data['filter_sku'] = $filter_sku; 
		$this->data['filter_product_name'] = $filter_product_name; 
		$this->data['filter_model'] = $filter_model; 
		$this->data['filter_option'] = $filter_option;
		$this->data['filter_attribute'] = $filter_attribute;
		$this->data['filter_product_status'] = $filter_product_status;		
		$this->data['filter_location'] = $filter_location;
		$this->data['filter_affiliate_name'] = $filter_affiliate_name; 
		$this->data['filter_affiliate_email'] = $filter_affiliate_email; 
		$this->data['filter_coupon_name'] = $filter_coupon_name; 
		$this->data['filter_coupon_code'] = $filter_coupon_code; 
		$this->data['filter_voucher_code'] = $filter_voucher_code;
		
		$this->data['url'] = $this->url->link('report/adv_products', 'token=' . $this->session->data['token'] . $url . '&page='. $page, 'SSL');
				
		$this->template = 'report/adv_products.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		$this->response->setOutput($this->render());	
	}

	public function customer_autocomplete() {
		$json = array();

		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->get['filter_customer_name']) or isset($this->request->get['filter_customer_email']) or isset($this->request->get['filter_customer_telephone']) or isset($this->request->get['filter_ip']) or isset($this->request->get['filter_payment_company']) or isset($this->request->get['filter_payment_address']) or isset($this->request->get['filter_payment_city']) or isset($this->request->get['filter_payment_zone']) or isset($this->request->get['filter_payment_postcode']) or isset($this->request->get['filter_payment_country']) or isset($this->request->get['filter_shipping_company']) or isset($this->request->get['filter_shipping_address']) or isset($this->request->get['filter_shipping_city']) or isset($this->request->get['filter_shipping_zone']) or isset($this->request->get['filter_shipping_postcode']) or isset($this->request->get['filter_shipping_country'])) {
			
		$this->load->model('report/adv_products');
		
		if (isset($this->request->get['filter_customer_name'])) {
			$filter_customer_name = $this->request->get['filter_customer_name'];
		} else {
			$filter_customer_name = '';
		}

		if (isset($this->request->get['filter_customer_email'])) {
			$filter_customer_email = $this->request->get['filter_customer_email'];
		} else {
			$filter_customer_email = '';
		}	

		if (isset($this->request->get['filter_customer_telephone'])) {
			$filter_customer_telephone = $this->request->get['filter_customer_telephone'];
		} else {
			$filter_customer_telephone = '';
		}

		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = '';
		}
		
		if (isset($this->request->get['filter_payment_company'])) {
			$filter_payment_company = $this->request->get['filter_payment_company'];
		} else {
			$filter_payment_company = '';
		}
		
		if (isset($this->request->get['filter_payment_address'])) {
			$filter_payment_address = $this->request->get['filter_payment_address'];
		} else {
			$filter_payment_address = '';
		}

		if (isset($this->request->get['filter_payment_city'])) {
			$filter_payment_city = $this->request->get['filter_payment_city'];
		} else {
			$filter_payment_city = '';
		}
		
		if (isset($this->request->get['filter_payment_zone'])) {
			$filter_payment_zone = $this->request->get['filter_payment_zone'];
		} else {
			$filter_payment_zone = '';
		}
		
		if (isset($this->request->get['filter_payment_postcode'])) {
			$filter_payment_postcode = $this->request->get['filter_payment_postcode'];
		} else {
			$filter_payment_postcode = '';
		}

		if (isset($this->request->get['filter_payment_country'])) {
			$filter_payment_country = $this->request->get['filter_payment_country'];
		} else {
			$filter_payment_country = '';
		}
		
		if (isset($this->request->get['filter_shipping_company'])) {
			$filter_shipping_company = $this->request->get['filter_shipping_company'];
		} else {
			$filter_shipping_company = '';
		}
		
		if (isset($this->request->get['filter_shipping_address'])) {
			$filter_shipping_address = $this->request->get['filter_shipping_address'];
		} else {
			$filter_shipping_address = '';
		}

		if (isset($this->request->get['filter_shipping_city'])) {
			$filter_shipping_city = $this->request->get['filter_shipping_city'];
		} else {
			$filter_shipping_city = '';
		}
		
		if (isset($this->request->get['filter_shipping_zone'])) {
			$filter_shipping_zone = $this->request->get['filter_shipping_zone'];
		} else {
			$filter_shipping_zone = '';
		}
		
		if (isset($this->request->get['filter_shipping_postcode'])) {
			$filter_shipping_postcode = $this->request->get['filter_shipping_postcode'];
		} else {
			$filter_shipping_postcode = '';
		}

		if (isset($this->request->get['filter_shipping_country'])) {
			$filter_shipping_country = $this->request->get['filter_shipping_country'];
		} else {
			$filter_shipping_country = '';
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = 10;
		}
		
		$filter_data = array(		
			'filter_customer_name' 	 		=> $filter_customer_name,
			'filter_customer_email' 	 	=> $filter_customer_email,			
			'filter_customer_telephone' 	=> $filter_customer_telephone,
			'filter_ip' 					=> $filter_ip,			
			'filter_payment_company' 		=> $filter_payment_company,
			'filter_payment_address' 		=> $filter_payment_address,
			'filter_payment_city' 			=> $filter_payment_city,
			'filter_payment_zone' 			=> $filter_payment_zone,			
			'filter_payment_postcode' 		=> $filter_payment_postcode,
			'filter_payment_country' 		=> $filter_payment_country,			
			'filter_shipping_company' 		=> $filter_shipping_company,
			'filter_shipping_address' 		=> $filter_shipping_address,
			'filter_shipping_city' 			=> $filter_shipping_city,
			'filter_shipping_zone' 			=> $filter_shipping_zone,			
			'filter_shipping_postcode' 		=> $filter_shipping_postcode,
			'filter_shipping_country' 		=> $filter_shipping_country,
			'start'        					=> 0,
			'limit'        					=> $limit
		);
						
		$results = $this->model_report_adv_products->getCustomerAutocomplete($filter_data);
			
			foreach ($results as $result) {
				$json[] = array(
					'customer_id'     		=> $result['customer_id'],				
					'cust_name'     		=> html_entity_decode($result['cust_name'], ENT_QUOTES, 'UTF-8'),
					'cust_email'     		=> $result['cust_email'],
					'cust_telephone'     	=> $result['cust_telephone'],	
					'cust_ip'     			=> $result['cust_ip'],
					'payment_company'     	=> html_entity_decode($result['payment_company'], ENT_QUOTES, 'UTF-8'),	
					'payment_address'     	=> html_entity_decode($result['payment_address'], ENT_QUOTES, 'UTF-8'),	
					'payment_city'     		=> html_entity_decode($result['payment_city'], ENT_QUOTES, 'UTF-8'),	
					'payment_zone'     		=> html_entity_decode($result['payment_zone'], ENT_QUOTES, 'UTF-8'),						
					'payment_postcode'     	=> $result['payment_postcode'],
					'payment_country'     	=> html_entity_decode($result['payment_country'], ENT_QUOTES, 'UTF-8'),					
					'shipping_company'     	=> html_entity_decode($result['shipping_company'], ENT_QUOTES, 'UTF-8'),	
					'shipping_address'     	=> html_entity_decode($result['shipping_address'], ENT_QUOTES, 'UTF-8'),
					'shipping_city'     	=> html_entity_decode($result['shipping_city'], ENT_QUOTES, 'UTF-8'),
					'shipping_zone'     	=> html_entity_decode($result['shipping_zone'], ENT_QUOTES, 'UTF-8'),					
					'shipping_postcode'     => $result['shipping_postcode'],
					'shipping_country'     	=> html_entity_decode($result['shipping_country'], ENT_QUOTES, 'UTF-8')				
				);
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}	
	
	public function product_autocomplete() {
		$json = array();

		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->get['filter_sku']) or isset($this->request->get['filter_product_name']) or isset($this->request->get['filter_model'])) {
		
		$this->load->model('report/adv_products');
					
		if (isset($this->request->get['filter_sku'])) {
			$filter_sku = $this->request->get['filter_sku'];
		} else {
			$filter_sku = '';
		}

		if (isset($this->request->get['filter_product_name'])) {
			$filter_product_name = $this->request->get['filter_product_name'];
		} else {
			$filter_product_name = '';
		}
		
		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = '';
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = 10;
		}
		
		$filter_data = array(				
			'filter_sku' 	 				=> $filter_sku,
			'filter_product_name' 	 		=> $filter_product_name,
			'filter_model' 	 				=> $filter_model,
			'start'        					=> 0,
			'limit'        					=> $limit	
		);
						
		$results = $this->model_report_adv_products->getProductAutocomplete($filter_data);
			
			foreach ($results as $result) {
				$json[] = array(
					'product_id'     		=> $result['product_id'],
					'prod_sku'     			=> html_entity_decode($result['prod_sku'], ENT_QUOTES, 'UTF-8'),					
					'prod_name'     		=> html_entity_decode($result['prod_name'], ENT_QUOTES, 'UTF-8'),
					'prod_model'     		=> html_entity_decode($result['prod_model'], ENT_QUOTES, 'UTF-8')				
				);
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}

	public function coupon_autocomplete() {
		$json = array();

		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->get['filter_coupon_code'])) {
			
		$this->load->model('report/adv_products');

		if (isset($this->request->get['filter_coupon_code'])) {
			$filter_coupon_code = $this->request->get['filter_coupon_code'];
		} else {
			$filter_coupon_code = '';
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = 10;
		}
		
		$filter_data = array(		
			'filter_coupon_code' 	 		=> $filter_coupon_code,
			'start'        					=> 0,
			'limit'        					=> $limit			
		);
						
		$results = $this->model_report_adv_products->getCouponAutocomplete($filter_data);
			
			foreach ($results as $result) {
				$json[] = array(
					'coupon_id'     		=> $result['coupon_id'],
					'coupon_code'     		=> html_entity_decode($result['coupon_code'], ENT_QUOTES, 'UTF-8')
				);
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}

	public function voucher_autocomplete() {
		$json = array();

		$this->data['token'] = $this->session->data['token'];
		
		if (isset($this->request->get['filter_voucher_code'])) {
			
		$this->load->model('report/adv_products');

		if (isset($this->request->get['filter_voucher_code'])) {
			$filter_voucher_code = $this->request->get['filter_voucher_code'];
		} else {
			$filter_voucher_code = '';
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = 10;
		}
		
		$filter_data = array(		
			'filter_voucher_code' 	 		=> $filter_voucher_code,
			'start'        					=> 0,
			'limit'        					=> $limit
		);
						
		$results = $this->model_report_adv_products->getVoucherAutocomplete($filter_data);
			
			foreach ($results as $result) {
				$json[] = array(
					'voucher_id'     		=> $result['voucher_id'],
					'voucher_code'     		=> html_entity_decode($result['voucher_code'], ENT_QUOTES, 'UTF-8')
				);
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}

	public function settings($filter_data = array()) {
		$json = array();
		
		$this->load->model('setting/setting');
		$this->load->language('report/adv_products');
		
		if (!$json) {
			if (!$this->user->hasPermission('modify', 'report/adv_products')) {
				$json['error'] = $this->language->get('error_permission');
			} else {			
				$user = 'advpp' . $this->user->getId();
				$this->model_setting_setting->editSetting($user, $this->request->post);
				$json['success'] = $this->language->get('text_success_settings');
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function export($filter_data = array()) {
		$this->load->language('report/adv_products');

		$export_data = array(
			'results'		=> $this->session->data['products_data']
		);

		if ($this->config->get('advpp' . $this->user->getId() . '_settings_mv_columns')) {
			$advpp_settings_mv_columns = $this->config->get('advpp' . $this->user->getId() . '_settings_mv_columns');
		} else {
			$advpp_settings_mv_columns = array();
		}	

		if ($this->config->get('advpp' . $this->user->getId() . '_settings_ol_columns')) {
			$advpp_settings_ol_columns = $this->config->get('advpp' . $this->user->getId() . '_settings_ol_columns');
		} else {
			$advpp_settings_ol_columns = array();
		}
		
		if ($this->config->get('advpp' . $this->user->getId() . '_settings_pl_columns')) {
			$advpp_settings_pl_columns = $this->config->get('advpp' . $this->user->getId() . '_settings_pl_columns');
		} else {
			$advpp_settings_pl_columns = array();
		}
		
		if ($this->config->get('advpp' . $this->user->getId() . '_settings_cl_columns')) {
			$advpp_settings_cl_columns = $this->config->get('advpp' . $this->user->getId() . '_settings_cl_columns');
		} else {
			$advpp_settings_cl_columns = array();
		}
		
		if ($this->config->get('advpp' . $this->user->getId() . '_settings_all_columns')) {
			$advpp_settings_all_columns = $this->config->get('advpp' . $this->user->getId() . '_settings_all_columns');
		} else {
			$advpp_settings_all_columns = array();
		}
		
		$this->session->data['report_type'] = $report_type = $this->request->get['report_type'];		
		$this->session->data['export_type'] = $export_type = $this->request->get['export_type'];
		$this->session->data['export_logo_criteria'] = $export_logo_criteria = $this->request->get['export_logo_criteria'];
		$this->session->data['export_csv_delimiter'] = $export_csv_delimiter = $this->request->get['export_csv_delimiter'];
			
		$filter_report = $this->session->data['filter_report'];
		$filter_details = $this->session->data['filter_details'];
		$filter_group = $this->session->data['filter_group'];
		$filter_sort = $this->session->data['filter_sort'];
		$filter_limit = $this->session->data['filter_limit'];
		
		$filter_range = $this->session->data['filter_range'];
		$filter_date_start = $this->session->data['filter_date_start'];
		$filter_date_end = $this->session->data['filter_date_end'];
		$filter_order_status_id = $this->session->data['filter_order_status_id'];
		$filter_status_date_start = $this->session->data['filter_status_date_start'];
		$filter_status_date_end = $this->session->data['filter_status_date_end'];
		$filter_order_id_from = $this->session->data['filter_order_id_from'];
		$filter_order_id_to = $this->session->data['filter_order_id_to'];
		
		$filter_store_id = $this->session->data['filter_store_id'];
		$filter_currency = $this->session->data['filter_currency'];
		$filter_taxes = $this->session->data['filter_taxes'];
		$filter_tax_classes = $this->session->data['filter_tax_classes'];
		$filter_geo_zones = $this->session->data['filter_geo_zones'];
		$filter_customer_group_id = $this->session->data['filter_customer_group_id'];
		$filter_customer_name = $this->session->data['filter_customer_name'];
		$filter_customer_email = $this->session->data['filter_customer_email'];
		$filter_customer_telephone = $this->session->data['filter_customer_telephone'];
		$filter_ip = $this->session->data['filter_ip'];
		$filter_payment_company = $this->session->data['filter_payment_company'];
		$filter_payment_address = $this->session->data['filter_payment_address'];
		$filter_payment_city = $this->session->data['filter_payment_city'];
		$filter_payment_zone = $this->session->data['filter_payment_zone'];
		$filter_payment_postcode = $this->session->data['filter_payment_postcode'];
		$filter_payment_country = $this->session->data['filter_payment_country'];
		$filter_payment_method = $this->session->data['filter_payment_method'];
		$filter_shipping_company = $this->session->data['filter_shipping_company'];
		$filter_shipping_address = $this->session->data['filter_shipping_address'];
		$filter_shipping_city = $this->session->data['filter_shipping_city'];
		$filter_shipping_zone = $this->session->data['filter_shipping_zone'];
		$filter_shipping_postcode = $this->session->data['filter_shipping_postcode'];
		$filter_shipping_country = $this->session->data['filter_shipping_country'];
		$filter_shipping_method = $this->session->data['filter_shipping_method'];
		$filter_category = $this->session->data['filter_category'];
		$filter_manufacturer = $this->session->data['filter_manufacturer'];
		$filter_sku = $this->session->data['filter_sku'];
		$filter_product_name = $this->session->data['filter_product_name'];
		$filter_model = $this->session->data['filter_model'];
		$filter_option = $this->session->data['filter_option'];
		$filter_attribute = $this->session->data['filter_attribute'];
		$filter_product_status = $this->session->data['filter_product_status'];		
		$filter_location = $this->session->data['filter_location'];
		$filter_affiliate_name = $this->session->data['filter_affiliate_name'];
		$filter_affiliate_email = $this->session->data['filter_affiliate_email'];
		$filter_coupon_name = $this->session->data['filter_coupon_name'];
		$filter_coupon_code = $this->session->data['filter_coupon_code'];
		$filter_voucher_code = $this->session->data['filter_voucher_code'];
		
		$logo = str_replace('\\', '/', DIR_IMAGE . $this->config->get('config_logo'));
		
		unset($this->session->data['error_export_type']);
		
		if ($report_type == 'export_no_details' && $export_type == 'export_xls') {
			$cwd = getcwd();			
			chdir(DIR_SYSTEM . 'library/pear');
			require_once('Spreadsheet/Excel/Writer.php');
			chdir($cwd);			
			include(DIR_APPLICATION . 'controller/report/adv_reports/pp_export_xls.inc.php');
			exit();
		} elseif ($report_type == 'export_no_details' && $export_type == 'export_xlsx') {
			require_once(DIR_SYSTEM . 'library/PHPExcel/Classes/PHPExcel.php');
			require_once(DIR_SYSTEM . 'library/PHPExcel/Classes/PHPExcel/IOFactory.php');			
			include(DIR_APPLICATION . 'controller/report/adv_reports/pp_export_xlsx.inc.php');
			exit();			
		} elseif ($report_type == 'export_no_details' && $export_type == 'export_csv') {
			include(DIR_APPLICATION . 'controller/report/adv_reports/pp_export_csv.inc.php');
			exit();
		} elseif ($report_type == 'export_no_details' && $export_type == 'export_pdf') {
			require_once(DIR_SYSTEM . 'library/dompdf/dompdf_config.inc.php');
			include(DIR_APPLICATION . 'controller/report/adv_reports/pp_export_pdf.inc.php');
			exit();
		} elseif ($report_type == 'export_no_details' && $export_type == 'export_html') {
			include(DIR_APPLICATION . 'controller/report/adv_reports/pp_export_html.inc.php');
			exit();	
		} elseif ($report_type == 'export_all_details' && $export_type == 'export_xls') {
			$cwd = getcwd();			
			chdir(DIR_SYSTEM . 'library/pear');
			require_once('Spreadsheet/Excel/Writer.php');
			chdir($cwd);			
			include(DIR_APPLICATION . 'controller/report/adv_reports/pp_export_xls_all_details.inc.php');
			exit();
		} elseif ($report_type == 'export_basic_details' && $export_type == 'export_pdf') {
			require_once(DIR_SYSTEM . 'library/dompdf/dompdf_config.inc.php');
			include(DIR_APPLICATION . 'controller/report/adv_reports/pp_export_pdf_basic_details.inc.php');	
			exit();
		} elseif ($report_type == 'export_basic_details' && $export_type == 'export_html') {
			include(DIR_APPLICATION . 'controller/report/adv_reports/pp_export_html_basic_details.inc.php');
			exit();				
		} elseif ($report_type == 'export_all_details' && $export_type == 'export_xlsx') {
			require_once(DIR_SYSTEM . 'library/PHPExcel/Classes/PHPExcel.php');
			require_once(DIR_SYSTEM . 'library/PHPExcel/Classes/PHPExcel/IOFactory.php');			
			include(DIR_APPLICATION . 'controller/report/adv_reports/pp_export_xlsx_all_details.inc.php');
			exit();			
		} elseif ($report_type == 'export_all_details' && $export_type == 'export_csv') {
			include(DIR_APPLICATION . 'controller/report/adv_reports/pp_export_csv_all_details.inc.php');
			exit();
		} elseif ($report_type == 'export_all_details' && $export_type == 'export_pdf') {
			require_once(DIR_SYSTEM . 'library/dompdf/dompdf_config.inc.php');
			include(DIR_APPLICATION . 'controller/report/adv_reports/pp_export_pdf_all_details.inc.php');	
			exit();
		} elseif ($report_type == 'export_all_details' && $export_type == 'export_html') {
			include(DIR_APPLICATION . 'controller/report/adv_reports/pp_export_html_all_details.inc.php');
			exit();			
		} else {
			exit();
		}
	}
	
	public function export_validate () {
		$json = array();
		
		$this->load->language('report/adv_products');
				
		if (empty($this->session->data['products_data'])) {
			$json['error'] = $this->language->get('error_no_data');
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	protected function clearSpreadsheetCache() {
		$files = glob(DIR_CACHE . 'Spreadsheet_Excel_Writer' . '*');
		
		if ($files) {
			foreach ($files as $file) {
				if (file_exists($file)) {
					@unlink($file);
					clearstatcache();
				}
			}
		}
	}
}
?>