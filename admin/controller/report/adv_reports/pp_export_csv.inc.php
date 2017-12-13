<?php
	ini_set("memory_limit","256M");
	$results = $export_data['results'];
	if ($results) {

	$csv_delimiter = strtr($export_csv_delimiter, array(
		'comma'			=> ",",
		'semi'			=> ";",
		'tab'			=> "\t"
	));
	$csv_enclosed = '"';
	$csv_row = "\n";

	if ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') {	
	$export_csv = $csv_enclosed . $this->language->get('column_date_added') . $csv_enclosed;
	} else {
	if ($filter_group == 'year') {
	$export_csv = $csv_enclosed . $this->language->get('column_year') . $csv_enclosed;
	} elseif ($filter_group == 'quarter') {
	$export_csv = $csv_enclosed . $this->language->get('column_year') . $csv_enclosed;				
	$export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_quarter') . $csv_enclosed;			
	} elseif ($filter_group == 'month') {
	$export_csv = $csv_enclosed . $this->language->get('column_year') . $csv_enclosed;			
	$export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_month') . $csv_enclosed;	
	} elseif ($filter_group == 'day') {
	$export_csv = $csv_enclosed . $this->language->get('column_date') . $csv_enclosed;
	} elseif ($filter_group == 'order') {
	$export_csv = $csv_enclosed . $this->language->get('column_order_order_id') . $csv_enclosed;				
	$export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_order_date_added') . $csv_enclosed;	
	} else {
	$export_csv = $csv_enclosed . $this->language->get('column_date_start') . $csv_enclosed;					
	$export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_date_end') . $csv_enclosed;	
	}
	}
	if ($filter_report != 'manufacturers' && $filter_report != 'categories') {
	in_array('mv_id', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_id') . $csv_enclosed : '';
	in_array('mv_sku', $advpp_settings_mv_columns) ?  $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_sku') . $csv_enclosed : '';
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_pname') . $csv_enclosed : '';
	if ($filter_report == 'products_purchased_with_options') {
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_poption') . $csv_enclosed : '';
	}
	in_array('mv_model', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_model') . $csv_enclosed : '';
	in_array('mv_category', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_category') . $csv_enclosed : '';	
	in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_manufacturer') . $csv_enclosed : '';	
	in_array('mv_attribute', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_attribute') . $csv_enclosed : '';	
	in_array('mv_status', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_status') . $csv_enclosed : '';	
	in_array('mv_location', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_location') . $csv_enclosed : '';	
	in_array('mv_tax_class', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_tax_class') . $csv_enclosed : '';	
	in_array('mv_price', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_price') . $csv_enclosed : '';	
	in_array('mv_viewed', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_viewed') . $csv_enclosed : '';
	in_array('mv_stock_quantity', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_stock_quantity') . $csv_enclosed : '';
	} elseif ($filter_report == 'manufacturers') {
	in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_manufacturer') . $csv_enclosed : '';	
	} elseif ($filter_report == 'categories') {
	in_array('mv_category', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_category') . $csv_enclosed : '';	
	}		
	if ($filter_report != 'products_without_orders') {	
	in_array('mv_sold_quantity', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_sold_quantity') . $csv_enclosed : '';
	in_array('mv_sold_percent', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_sold_percent') . $csv_enclosed : '';
	in_array('mv_total_excl_vat', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_prod_total_excl_vat') . $csv_enclosed : '';
	in_array('mv_total_tax', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_total_tax') . $csv_enclosed : '';
	in_array('mv_total_incl_vat', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_prod_total_incl_vat') . $csv_enclosed : '';
	in_array('mv_app', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_app') . $csv_enclosed : '';
	in_array('mv_refunds', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_product_refunds') . $csv_enclosed : '';
	in_array('mv_reward_points', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $this->language->get('column_product_reward_points') . $csv_enclosed : '';
	}
	$export_csv .= $csv_row;

	foreach ($results as $result) {
	if ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') {
	$export_csv .= $csv_enclosed . $result['date_added'] . $csv_enclosed;
	} else {
	if ($filter_group == 'year') {				
	$export_csv .= $csv_enclosed . $result['year'] . $csv_enclosed;
	} elseif ($filter_group == 'quarter') {
	$export_csv .= $csv_enclosed . $result['year'] . $csv_enclosed;				
	$export_csv .= $csv_delimiter . $csv_enclosed . 'Q' . $result['quarter'] . $csv_enclosed;			
	} elseif ($filter_group == 'month') {
	$export_csv .= $csv_enclosed . $result['year'] . $csv_enclosed;			
	$export_csv .= $csv_delimiter . $csv_enclosed . $result['month'] . $csv_enclosed;	
	} elseif ($filter_group == 'day') {
	$export_csv .= $csv_enclosed . $result['date_start'] . $csv_enclosed;
	} elseif ($filter_group == 'order') {
	$export_csv .= $csv_enclosed . $result['order_id'] . $csv_enclosed;				
	$export_csv .= $csv_delimiter . $csv_enclosed . $result['date_start'] . $csv_enclosed;	
	} else {
	$export_csv .= $csv_enclosed . $result['date_start'] . $csv_enclosed;					
	$export_csv .= $csv_delimiter . $csv_enclosed . $result['date_end'] . $csv_enclosed;	
	}
	}
	if ($filter_report != 'manufacturers' && $filter_report != 'categories') {
	in_array('mv_id', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $result['product_id'] . $csv_enclosed : '';
	in_array('mv_sku', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $result['sku'] . $csv_enclosed : '';
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $result['name'] . $csv_enclosed : '';
	if ($filter_report == 'products_purchased_with_options') {
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $result['options'] . $csv_enclosed : '';
	}	
	in_array('mv_model', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $result['model'] . $csv_enclosed : '';
	in_array('mv_category', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . html_entity_decode($result['categories']) . $csv_enclosed : '';
	in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . html_entity_decode($result['manufacturers']) . $csv_enclosed : '';	
	in_array('mv_attribute', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . html_entity_decode(str_replace('<br>','; ',$result['attribute'])) . $csv_enclosed : '';	
	in_array('mv_status', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $result['status'] . $csv_enclosed : '';	
	in_array('mv_location', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $result['location'] . $csv_enclosed : '';	
	in_array('mv_tax_class', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $result['tax_class'] . $csv_enclosed : '';	
	in_array('mv_price', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . round($result['price_raw'], 2) . $csv_enclosed : '';
	in_array('mv_viewed', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $result['viewed'] . $csv_enclosed : '';
	in_array('mv_stock_quantity', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $result['stock_quantity'] . $csv_enclosed : '';
	} elseif ($filter_report == 'manufacturers') {
	in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . html_entity_decode($result['manufacturers']) . $csv_enclosed : '';	
	} elseif ($filter_report == 'categories') {
	in_array('mv_category', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . html_entity_decode($result['categories']) . $csv_enclosed : '';
	}				
	if ($filter_report != 'products_without_orders') {
	in_array('mv_sold_quantity', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $result['sold_quantity'] . $csv_enclosed : '';
	if (!is_null($result['sold_quantity'])) {
	in_array('mv_sold_percent', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . round(100 * ($result['sold_quantity'] / $result['sold_quantity_total']), 2) . '%' . $csv_enclosed : '';
	} else {
	in_array('mv_sold_percent', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . round((100), 2) . '%' . $csv_enclosed : '';
	}	
	in_array('mv_total_excl_vat', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . round($result['total_excl_vat_raw'], 2) . $csv_enclosed : '';
	in_array('mv_total_tax', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . round($result['total_tax_raw'], 2) . $csv_enclosed : '';
	in_array('mv_total_incl_vat', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . round($result['total_incl_vat_raw'], 2) . $csv_enclosed : '';
	in_array('mv_app', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . round($result['app_raw'], 2) . $csv_enclosed : '';
	in_array('mv_refunds', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . round($result['refunds_raw'], 2) . $csv_enclosed : '';	
	in_array('mv_reward_points', $advpp_settings_mv_columns) ? $export_csv .= $csv_delimiter . $csv_enclosed . $result['reward_points'] . $csv_enclosed : '';
	}
	$export_csv .= $csv_row;
	}

	$filename = "products_report_".date($this->config->get('advpp' . $this->user->getId() . '_hour_format') == '24' ? "Y-m-d_H-i-s" : "Y-m-d_h-i-s-A");
	header('Pragma: public');
	header('Expires: 0');
	header('Content-Description: File Transfer');
	header('Content-Type: text/csv; charset=utf-8');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');		
	header('Content-Disposition: attachment; filename='.$filename.".csv");
	print $export_csv;			
	exit;
	}
?>