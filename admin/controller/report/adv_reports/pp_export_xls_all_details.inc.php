<?php
	ini_set("memory_limit","256M");
	$results = $export_data['results'];
	if ($results) {
		// we use our own error handler
		global $config;
		global $log;
		$config = $this->config;
		$log = $this->log;
		set_error_handler('error_handler_for_export',E_ALL);
		register_shutdown_function('fatal_error_shutdown_handler_for_export');
		
		// Creating a workbook
		$workbook = new Spreadsheet_Excel_Writer();
		$workbook->setTempDir(DIR_CACHE);
		$workbook->setVersion(8); // Use Excel97/2000 BIFF8 Format

		// Formating a workbook
		if ($export_logo_criteria) {
		$workbook->setCustomColor(43, 219, 229, 241);
		$criteriaDateFormat =& $workbook->addFormat(array('Align' => 'center', 'FgColor' => '43'));	
		$criteriaTitleFormat =& $workbook->addFormat(array('Align' => 'center', 'FgColor' => '43', 'bold' => 1));
		$criteriaTitleFormat->setSize(24);
		$criteriaTitleFormat->setVAlign('vcenter');
		$criteriaFilterFormat1 =& $workbook->addFormat(array('Align' => 'right', 'FgColor' => '43', 'bold' => 1));
		$criteriaFilterFormat1->setVAlign('top');
		$criteriaFilterFormat2 =& $workbook->addFormat(array('Align' => 'left', 'FgColor' => '43'));
		$criteriaFilterFormat2->setVAlign('top');
		$criteriaFilterFormat2->setTextWrap();
		$criteriaAddressFormat =& $workbook->addFormat(array('Align' => 'center', 'FgColor' => '43'));
		$criteriaAddressFormat->setSize(14);
		$criteriaAddressFormat->setVAlign('vcenter');
		$criteriaAddressFormat->setTextWrap();		
		}
		
		$textFormat =& $workbook->addFormat(array('Align' => 'left', 'NumFormat' => "@"));
		
		$numberFormat =& $workbook->addFormat(array('Align' => 'left'));	

		$priceFormat =& $workbook->addFormat(array('Align' => 'right'));
		$priceFormat->setNumFormat('0.00');

		$boxFormatText =& $workbook->addFormat(array('bold' => 1));
		$boxFormatNumber =& $workbook->addFormat(array('Align' => 'right', 'bold' => 1));
		
		// sending HTTP headers
		$workbook->send('products_report_all_details_'.date($this->config->get('advpp' . $this->user->getId() . '_hour_format') == '24' ? "Y-m-d_H-i-s" : "Y-m-d_h-i-s-A").'.xls');
		$worksheet =& $workbook->addWorksheet('ADV Products Report');
		$worksheet->setInputEncoding('UTF-8');
		$worksheet->setZoom(90);

		// Set the column widths
		$j = 0;
		$worksheet->setColumn($j,$j++,10); // A
		$worksheet->setColumn($j,$j++,13); // B
		in_array('all_order_inv_no', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // C
		in_array('all_order_customer_name', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // D
		in_array('all_order_email', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // E
		in_array('all_order_customer_group', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // F
		in_array('all_prod_id', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,10) : ''; // G
		in_array('all_prod_sku', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // H
		in_array('all_prod_model', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // I
		in_array('all_prod_name', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,25) : ''; // J
		in_array('all_prod_option', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // K
		in_array('all_prod_attributes', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // L
		in_array('all_prod_manu', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // M
		in_array('all_prod_category', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // N
		in_array('all_prod_currency', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,10) : ''; // O
		in_array('all_prod_price', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // P
		in_array('all_prod_quantity', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // Q
		in_array('all_prod_total_excl_vat', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // R
		in_array('all_prod_tax', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // S	
		in_array('all_prod_total_incl_vat', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // T
		in_array('all_prod_qty_refund', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // U
		in_array('all_prod_refund', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // V
		in_array('all_prod_reward_points', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,14) : ''; // W
		in_array('all_sub_total', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // X
		in_array('all_handling', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // Y
		in_array('all_loworder', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,14) : ''; // Z
		in_array('all_shipping', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // AA
		in_array('all_reward', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // AB
		in_array('all_reward_points', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // AC
		in_array('all_reward_points', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,19) : ''; // AD		
		in_array('all_coupon', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // AE
		in_array('all_coupon_code', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // AF
		in_array('all_order_tax', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // AG
		in_array('all_credit', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // AH
		in_array('all_voucher', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // AI
		in_array('all_voucher_code', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // AJ
		in_array('all_order_commission', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // AK
		in_array('all_order_value', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // AL
		in_array('all_refund', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // AM
		in_array('all_order_shipping_method', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,18) : ''; // AN
		in_array('all_order_payment_method', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,18) : ''; // AO
		in_array('all_order_status', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // AP
		in_array('all_order_store', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,18) : ''; // AQ
		in_array('all_customer_cust_id', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,11) : ''; // AR
		in_array('all_billing_first_name', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,16) : ''; // AS
		in_array('all_billing_last_name', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,16) : ''; // AT
		in_array('all_billing_company', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // AU
		in_array('all_billing_address_1', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // AV
		in_array('all_billing_address_2', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // AW
		in_array('all_billing_city', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // AX
		in_array('all_billing_zone', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // AY
		in_array('all_billing_zone_id', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // AZ
		in_array('all_billing_zone_code', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // BA
		in_array('all_billing_postcode', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,17) : ''; // BB
		in_array('all_billing_country', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // BC
		in_array('all_billing_country_id', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,18) : ''; // BD
		in_array('all_billing_country_code', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,18) : ''; // BE
		in_array('all_customer_telephone', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // BF
		in_array('all_shipping_first_name', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,18) : ''; // BG
		in_array('all_shipping_last_name', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,18) : ''; // BH
		in_array('all_shipping_company', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // BI
		in_array('all_shipping_address_1', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // BJ
		in_array('all_shipping_address_2', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // BK
		in_array('all_shipping_city', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // BL
		in_array('all_shipping_zone', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // BM
		in_array('all_shipping_zone_id', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // BN
		in_array('all_shipping_zone_code', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,16) : ''; // BO
		in_array('all_shipping_postcode', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,17) : ''; // BP
		in_array('all_shipping_country', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // BQ
		in_array('all_shipping_country_id', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // BR
		in_array('all_shipping_country_code', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // BS
		in_array('all_order_weight', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // BT
		in_array('all_order_comment', $advpp_settings_all_columns) ? $worksheet->setColumn($j,$j++,18) : ''; // BU
		
		if ($export_logo_criteria) {
		$worksheet->setMerge(0, 0, 0, $j-1);
		$worksheet->writeString(0, 0, $this->language->get('text_report_date').": ".date($this->config->get('advpp' . $this->user->getId() . '_hour_format') == '24' ? "Y-m-d H:i:s" : "Y-m-d h:i:s A"), $criteriaDateFormat);
		$worksheet->setRow(1, 50);		
		$worksheet->setMerge(1, 0, 1, $j-1);
		$worksheet->writeString(1, 0, $this->language->get('heading_title'), $criteriaTitleFormat);
		$worksheet->setRow(2, 30);
		$worksheet->setMerge(2, 0, 2, $j-1);
		$worksheet->writeString(2, 0, $this->config->get('config_name').", ".$this->config->get('config_address').", ".$this->language->get('text_email')."".$this->config->get('config_email').", ".$this->language->get('text_telephone')."".$this->config->get('config_telephone'), $criteriaAddressFormat);		
		$worksheet->setRow(3, 40);		
		$worksheet->setMerge(3, 0, 3, 1);
		$worksheet->writeString(3, 0, $this->language->get('text_report_criteria'), $criteriaFilterFormat1);		
		$worksheet->setMerge(3, 2, 3, $j-1);
			$filter_criteria = "";
			if ($filter_report) {	
				if ($filter_report == 'text_all_products') {
					$filter_report_name = $this->language->get('text_all_products')." ".$this->language->get('text_with_without_orders');
				} elseif ($filter_report == 'products_without_orders') {
					$filter_report_name = $this->language->get('text_products')." ".$this->language->get('text_without_orders');
				} elseif ($filter_report == 'products_purchased_without_options') {
					$filter_report_name = $this->language->get('text_products_purchased')." ".$this->language->get('text_without_options');
				} elseif ($filter_report == 'products_purchased_with_options') {
					$filter_report_name = $this->language->get('text_products_purchased')." ".$this->language->get('text_with_options');
				} elseif ($filter_report == 'new_products_purchased') {
					$filter_report_name = $this->language->get('text_new_products_purchased');
				} elseif ($filter_report == 'old_products_purchased') {
					$filter_report_name = $this->language->get('text_old_products_purchased');
				} elseif ($filter_report == 'manufacturers') {
					$filter_report_name = $this->language->get('text_manufacturers');
				} elseif ($filter_report == 'categories') {
					$filter_report_name = $this->language->get('text_categories');					
				}
				$filter_criteria .= $this->language->get('entry_report')." ".$filter_report_name."; ";
			}
			if ($filter_details) {
				if ($filter_details == 'no_details') {
					$filter_details_name = $this->language->get('text_no_details');
				} elseif ($filter_details == 'basic_details') {
					$filter_details_name = $this->language->get('text_basic_details');
				} elseif ($filter_details == 'all_details') {
					$filter_details_name = $this->language->get('text_all_details');				
				}				
				$filter_criteria .= $this->language->get('entry_show_details')." ".$filter_details_name."; ";
			}
			if ($filter_group) {	
				if ($filter_group == 'no_group') {
					$filter_group_name = $this->language->get('text_no_group');
				} elseif ($filter_group == 'year') {
					$filter_group_name = $this->language->get('text_year');
				} elseif ($filter_group == 'quarter') {
					$filter_group_name = $this->language->get('text_quarter');	
				} elseif ($filter_group == 'month') {
					$filter_group_name = $this->language->get('text_month');
				} elseif ($filter_group == 'week') {
					$filter_group_name = $this->language->get('text_week');
				} elseif ($filter_group == 'day') {
					$filter_group_name = $this->language->get('text_day');
				} elseif ($filter_group == 'order') {
					$filter_group_name = $this->language->get('text_order');					
				}				
				$filter_criteria .= $this->language->get('entry_group')." ".$filter_group_name."; ";
			}
			if ($filter_sort) {	
				if ($filter_sort == 'date') {
					$filter_sort_name = $this->language->get('column_date');
				} elseif ($filter_sort == 'id') {
					$filter_sort_name = $this->language->get('column_id');
				} elseif ($filter_sort == 'sku') {
					$filter_sort_name = $this->language->get('column_sku');	
				} elseif ($filter_sort == 'name') {
					$filter_sort_name = $this->language->get('column_prod_name');
				} elseif ($filter_sort == 'model') {
					$filter_sort_name = $this->language->get('column_model');
				} elseif ($filter_sort == 'category') {
					$filter_sort_name = $this->language->get('column_category');
				} elseif ($filter_sort == 'manufacturer') {
					$filter_sort_name = $this->language->get('column_manufacturer');	
				} elseif ($filter_sort == 'attribute') {
					$filter_sort_name = $this->language->get('column_attribute');
				} elseif ($filter_sort == 'status') {
					$filter_sort_name = $this->language->get('column_status');	
				} elseif ($filter_sort == 'location') {
					$filter_sort_name = $this->language->get('column_location');
				} elseif ($filter_sort == 'tax_class') {
					$filter_sort_name = $this->language->get('column_tax_class');
				} elseif ($filter_sort == 'price') {
					$filter_sort_name = $this->language->get('column_price');
				} elseif ($filter_sort == 'viewed') {
					$filter_sort_name = $this->language->get('column_viewed');
				} elseif ($filter_sort == 'stock_quantity') {
					$filter_sort_name = $this->language->get('column_stock_quantity');
				} elseif ($filter_sort == 'sold_quantity') {
					$filter_sort_name = $this->language->get('column_sold_quantity');
				} elseif ($filter_sort == 'total_excl_vat') {
					$filter_sort_name = $this->language->get('column_prod_total_excl_vat');	
				} elseif ($filter_sort == 'total_tax') {
					$filter_sort_name = $this->language->get('column_total_tax');
				} elseif ($filter_sort == 'total_incl_vat') {
					$filter_sort_name = $this->language->get('column_prod_total_incl_vat');	
				} elseif ($filter_sort == 'app') {
					$filter_sort_name = $this->language->get('column_app');
				} elseif ($filter_sort == 'refunds') {
					$filter_sort_name = $this->language->get('column_product_refunds');
				} elseif ($filter_sort == 'reward_points') {
					$filter_sort_name = $this->language->get('column_product_reward_points');				
				}				
				$filter_criteria .= $this->language->get('entry_sort_by')." ".$filter_sort_name."; ";
			}
			if ($filter_limit) {	
				$filter_criteria .= $this->language->get('entry_limit')." ".$filter_limit."; ";
			}	
			$filter_criteria .= "\n";
			if ($filter_range) {	
				if ($filter_range == 'custom') {
					$filter_range_name = $this->language->get('stat_custom');
				} elseif ($filter_range == 'today') {
					$filter_range_name = $this->language->get('stat_today');
				} elseif ($filter_range == 'yesterday') {
					$filter_range_name = $this->language->get('stat_yesterday');	
				} elseif ($filter_range == 'week') {
					$filter_range_name = $this->language->get('stat_week');
				} elseif ($filter_range == 'month') {
					$filter_range_name = $this->language->get('stat_month');
				} elseif ($filter_range == 'quarter') {
					$filter_range_name = $this->language->get('stat_quarter');
				} elseif ($filter_range == 'year') {
					$filter_range_name = $this->language->get('stat_year');	
				} elseif ($filter_range == 'current_week') {
					$filter_range_name = $this->language->get('stat_current_week');
				} elseif ($filter_range == 'current_month') {
					$filter_range_name = $this->language->get('stat_current_month');	
				} elseif ($filter_range == 'current_quarter') {
					$filter_range_name = $this->language->get('stat_current_quarter');
				} elseif ($filter_range == 'current_year') {
					$filter_range_name = $this->language->get('stat_current_year');
				} elseif ($filter_range == 'last_week') {
					$filter_range_name = $this->language->get('stat_last_week');
				} elseif ($filter_range == 'last_month') {
					$filter_range_name = $this->language->get('stat_last_month');	
				} elseif ($filter_range == 'last_quarter') {
					$filter_range_name = $this->language->get('stat_last_quarter');
				} elseif ($filter_range == 'last_year') {
					$filter_range_name = $this->language->get('stat_last_year');
				} elseif ($filter_range == 'all_time') {
					$filter_range_name = $this->language->get('stat_all_time');					
				}				
				$filter_criteria .= $this->language->get('entry_range')." ".$filter_range_name;
				if ($filter_date_start) {	
					$filter_criteria .= " [".$this->language->get('entry_date_start')." ".$filter_date_start;
				}
				if ($filter_date_end) {	
					$filter_criteria .= ", ".$this->language->get('entry_date_end')." ".$filter_date_end."]";
				}
				$filter_criteria .= "; ";
			}
			if ($filter_order_status_id) {	
				$filter_criteria .= $this->language->get('entry_status')." ".$filter_order_status_id;
				if ($filter_status_date_start) {	
					$filter_criteria .= " [".$this->language->get('entry_date_start')." ".$filter_status_date_start;
				}
				if ($filter_status_date_end) {	
					$filter_criteria .= ", ".$this->language->get('entry_date_end')." ".$filter_status_date_end."]";
				}
				$filter_criteria .= "; ";				
			}
			if ($filter_order_id_from) {
				$filter_criteria .= $this->language->get('entry_order_id').": ".$filter_order_id_from."-".$filter_order_id_to."; ";
			}
			$filter_criteria .= "\n";
			if ($filter_store_id) {	
				$filter_criteria .= $this->language->get('entry_store')." ".$filter_store_id."; ";
			}
			if ($filter_currency) {	
				$filter_criteria .= $this->language->get('entry_currency')." ".$filter_currency."; ";
			}
			if ($filter_taxes) {	
				$filter_criteria .= $this->language->get('entry_tax')." ".$filter_taxes."; ";
			}
			if ($filter_tax_classes) {	
				$filter_criteria .= $this->language->get('entry_tax_classes')." ".$filter_tax_classes."; ";
			}
			if ($filter_geo_zones) {	
				$filter_criteria .= $this->language->get('entry_geo_zone')." ".$filter_geo_zones."; ";
			}
			if ($filter_customer_group_id) {	
				$filter_criteria .= $this->language->get('entry_customer_group')." ".$filter_customer_group_id."; ";
			}		
			if ($filter_customer_name) {	
				$filter_criteria .= $this->language->get('entry_customer_name')." ".$filter_customer_name."; ";
			}
			if ($filter_customer_email) {	
				$filter_criteria .= $this->language->get('entry_customer_email')." ".$filter_customer_email."; ";
			}
			if ($filter_customer_telephone) {	
				$filter_criteria .= $this->language->get('entry_customer_telephone')." ".$filter_customer_telephone."; ";
			}
			if ($filter_ip) {	
				$filter_criteria .= $this->language->get('entry_ip')." ".$filter_ip."; ";
			}
			if ($filter_payment_company) {	
				$filter_criteria .= $this->language->get('entry_payment_company')." ".$filter_payment_company."; ";
			}
			if ($filter_payment_address) {	
				$filter_criteria .= $this->language->get('entry_payment_address')." ".$filter_payment_address."; ";
			}
			if ($filter_payment_city) {	
				$filter_criteria .= $this->language->get('entry_payment_city')." ".$filter_payment_city."; ";
			}
			if ($filter_payment_zone) {	
				$filter_criteria .= $this->language->get('entry_payment_zone')." ".$filter_payment_zone."; ";
			}
			if ($filter_payment_postcode) {	
				$filter_criteria .= $this->language->get('entry_payment_postcode')." ".$filter_payment_postcode."; ";
			}
			if ($filter_payment_country) {	
				$filter_criteria .= $this->language->get('entry_payment_country')." ".$filter_payment_country."; ";
			}
			if ($filter_payment_method) {	
				$filter_criteria .= $this->language->get('entry_payment_method')." ".$filter_payment_method."; ";
			}
			if ($filter_shipping_company) {	
				$filter_criteria .= $this->language->get('entry_shipping_company')." ".$filter_shipping_company."; ";
			}
			if ($filter_shipping_address) {	
				$filter_criteria .= $this->language->get('entry_shipping_address')." ".$filter_shipping_address."; ";
			}
			if ($filter_shipping_city) {	
				$filter_criteria .= $this->language->get('entry_shipping_city')." ".$filter_shipping_city."; ";
			}
			if ($filter_shipping_zone) {	
				$filter_criteria .= $this->language->get('entry_shipping_zone')." ".$filter_shipping_zone."; ";
			}
			if ($filter_shipping_postcode) {	
				$filter_criteria .= $this->language->get('entry_shipping_postcode')." ".$filter_shipping_postcode."; ";
			}
			if ($filter_shipping_country) {	
				$filter_criteria .= $this->language->get('entry_shipping_country')." ".$filter_shipping_country."; ";
			}
			if ($filter_shipping_method) {	
				$filter_criteria .= $this->language->get('entry_shipping_method')." ".$filter_shipping_method."; ";
			}
			if ($filter_category) {	
				$filter_criteria .= $this->language->get('entry_category')." ".$filter_category."; ";
			}
			if ($filter_manufacturer) {	
				$filter_criteria .= $this->language->get('entry_manufacturer')." ".$filter_manufacturer."; ";
			}
			if ($filter_sku) {	
				$filter_criteria .= $this->language->get('entry_sku')." ".$filter_sku."; ";
			}
			if ($filter_product_name) {	
				$filter_criteria .= $this->language->get('entry_product')." ".$filter_product_name."; ";
			}
			if ($filter_model) {	
				$filter_criteria .= $this->language->get('entry_model')." ".$filter_model."; ";
			}
			if ($filter_option) {	
				$filter_criteria .= $this->language->get('entry_option')." ".$filter_option."; ";
			}	
			if ($filter_attribute) {	
				$filter_criteria .= $this->language->get('entry_attributes')." ".$filter_attribute."; ";
			}		
			if ($filter_product_status) {	
				$filter_criteria .= $this->language->get('entry_product_status')." ".$filter_product_status."; ";
			}				
			if ($filter_location) {	
				$filter_criteria .= $this->language->get('entry_location')." ".$filter_location."; ";
			}		
			if ($filter_affiliate_name) {	
				$filter_criteria .= $this->language->get('entry_affiliate_name')." ".$filter_affiliate_name."; ";
			}		
			if ($filter_affiliate_email) {	
				$filter_criteria .= $this->language->get('entry_affiliate_email')." ".$filter_affiliate_email."; ";
			}		
			if ($filter_coupon_name) {	
				$filter_criteria .= $this->language->get('entry_coupon_name')." ".$filter_coupon_name."; ";
			}		
			if ($filter_coupon_code) {	
				$filter_criteria .= $this->language->get('entry_coupon_code')." ".$filter_coupon_code."; ";
			}	
			if ($filter_voucher_code) {	
				$filter_criteria .= $this->language->get('entry_voucher_code')." ".$filter_voucher_code."; ";
			}	
		$worksheet->writeString(3, 2, $filter_criteria, $criteriaFilterFormat2);			
		}
		
		// The order headings row
		$export_logo_criteria ? $i = 4 : $i = 0;
		$j = 0;	
		$worksheet->writeString($i, $j++, $this->language->get('column_order_order_id'), $boxFormatText); // A
		$worksheet->writeString($i, $j++, $this->language->get('column_order_date_added'), $boxFormatText); // B
		in_array('all_order_inv_no', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_inv_no'), $boxFormatText) : ''; // C
		in_array('all_order_customer_name', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_customer'), $boxFormatText) : ''; // D
		in_array('all_order_email', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_email'), $boxFormatText) : ''; // E
		in_array('all_order_customer_group', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_customer_group'), $boxFormatText) : ''; // F
		in_array('all_prod_id', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_id'), $boxFormatText) : ''; // G
		in_array('all_prod_sku', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_sku'), $boxFormatText) : ''; // H
		in_array('all_prod_model', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_model'), $boxFormatText) : ''; // I
		in_array('all_prod_name', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_name'), $boxFormatText) : ''; // J
		in_array('all_prod_option', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_option'), $boxFormatText) : ''; // K
		in_array('all_prod_attributes', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_attributes'), $boxFormatText) : ''; // L
		in_array('all_prod_manu', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_manu'), $boxFormatText) : ''; // M
		in_array('all_prod_category', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_category'), $boxFormatText) : ''; // N
		in_array('all_prod_currency', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_currency'), $boxFormatText) : ''; // O
		in_array('all_prod_price', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_price'), $boxFormatNumber) : ''; // P
		in_array('all_prod_quantity', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_quantity'), $boxFormatNumber) : ''; // Q
		in_array('all_prod_total_excl_vat', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_total_excl_vat'), $boxFormatNumber) : ''; // R		
		in_array('all_prod_tax', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_tax'), $boxFormatNumber) : ''; // S
		in_array('all_prod_total_incl_vat', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_total_incl_vat'), $boxFormatNumber) : ''; // T
		in_array('all_prod_qty_refund', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_qty_refunded'), $boxFormatNumber) : ''; // U
		in_array('all_prod_refund', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_refunded'), $boxFormatNumber) : ''; // V
		in_array('all_prod_reward_points', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_reward_points'), $boxFormatNumber) : ''; // W
		in_array('all_sub_total', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_sub_total'), $boxFormatNumber) : ''; // X
		in_array('all_handling', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_handling'), $boxFormatNumber) : ''; // Y
		in_array('all_loworder', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_loworder'), $boxFormatNumber) : ''; // Z
		in_array('all_shipping', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_shipping'), $boxFormatNumber) : ''; // AA
		in_array('all_reward', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_reward'), $boxFormatNumber) : ''; // AB
		in_array('all_reward_points', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_earned_reward_points'), $boxFormatNumber) : ''; // AC
		in_array('all_reward_points', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_used_reward_points'), $boxFormatNumber) : ''; // AD
		in_array('all_coupon', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_coupon'), $boxFormatNumber) : ''; // AE
		in_array('all_coupon_code', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_coupon_code'), $boxFormatText) : ''; // AF
		in_array('all_order_tax', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_tax'), $boxFormatNumber) : ''; // AG
		in_array('all_credit', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_credit'), $boxFormatNumber) : ''; // AH
		in_array('all_voucher', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_voucher'), $boxFormatNumber) : ''; // AI
		in_array('all_voucher_code', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_voucher_code'), $boxFormatText) : ''; // AJ
		in_array('all_order_commission', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_commission'), $boxFormatNumber) : ''; // AK
		in_array('all_order_value', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_value'), $boxFormatNumber) : ''; // AL
		in_array('all_refund', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_refund'), $boxFormatNumber) : ''; // AM
		in_array('all_order_shipping_method', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_shipping_method'), $boxFormatText) : ''; // AN
		in_array('all_order_payment_method', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_payment_method'), $boxFormatText) : ''; // AO
		in_array('all_order_status', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_status'), $boxFormatText) : ''; // AP
		in_array('all_order_store', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_store'), $boxFormatText) : ''; // AQ
		in_array('all_customer_cust_id', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_customer_cust_id'), $boxFormatText) : ''; // AR
		in_array('all_billing_first_name', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_first_name')), $boxFormatText) : ''; // AS
		in_array('all_billing_last_name', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_last_name')), $boxFormatText) : ''; // AT
		in_array('all_billing_company', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_company')), $boxFormatText) : ''; // AU
		in_array('all_billing_address_1', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_address_1')), $boxFormatText) : ''; // AV
		in_array('all_billing_address_2', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_address_2')), $boxFormatText) : ''; // AW
		in_array('all_billing_city', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_city')), $boxFormatText) : ''; // AX
		in_array('all_billing_zone', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_zone')), $boxFormatText) : ''; // AY
		in_array('all_billing_zone_id', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_zone_id')), $boxFormatText) : ''; // AZ
		in_array('all_billing_zone_code', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_zone_code')), $boxFormatText) : ''; // BA
		in_array('all_billing_postcode', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_postcode')), $boxFormatText) : ''; // BB
		in_array('all_billing_country', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_country')), $boxFormatText) : ''; // BC
		in_array('all_billing_country_id', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_country_id')), $boxFormatText) : ''; // BD
		in_array('all_billing_country_code', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_billing_country_code')), $boxFormatText) : ''; // BE
		in_array('all_customer_telephone', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_customer_telephone'), $boxFormatText) : ''; // BF
		in_array('all_shipping_first_name', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_first_name')), $boxFormatText) : ''; // BG
		in_array('all_shipping_last_name', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_last_name')), $boxFormatText) : ''; // BH
		in_array('all_shipping_company', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_company')), $boxFormatText) : ''; // BI
		in_array('all_shipping_address_1', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_address_1')), $boxFormatText) : ''; // BJ
		in_array('all_shipping_address_2', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_address_2')), $boxFormatText) : ''; // BK
		in_array('all_shipping_city', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_city')), $boxFormatText) : ''; // BL
		in_array('all_shipping_zone', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_zone')), $boxFormatText) : ''; // BM
		in_array('all_shipping_zone_id', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_zone_id')), $boxFormatText) : ''; // BN
		in_array('all_shipping_zone_code', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_zone_code')), $boxFormatText) : ''; // BO
		in_array('all_shipping_postcode', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_postcode')), $boxFormatText) : ''; // BP
		in_array('all_shipping_country', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_country')), $boxFormatText) : ''; // BQ
		in_array('all_shipping_country_id', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_country_id')), $boxFormatText) : ''; // BR
		in_array('all_shipping_country_code', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, strip_tags($this->language->get('column_shipping_country_code')), $boxFormatText) : ''; // BS
		in_array('all_order_weight', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_weight'), $boxFormatNumber) : ''; // BT
		in_array('all_order_comment', $advpp_settings_all_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_order_comment'), $boxFormatText) : ''; // BU

		// The actual orders data
		$i += 1;
		$j = 0;
		
			foreach ($results as $result) {
			$excelRow = $i+1;			
				$worksheet->write($i, $j++, $result['order_id'], $numberFormat); // A
				$worksheet->write($i, $j++, $result['date_added'], $textFormat); // B
				in_array('all_order_inv_no', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['invoice'], $textFormat) : ''; // C
				in_array('all_order_customer_name', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['name'], $textFormat) : ''; // D
				in_array('all_order_email', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['email'], $textFormat) : ''; // E
				in_array('all_order_customer_group', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['cust_group'], ENT_COMPAT, 'UTF-8'), $textFormat) : ''; // F
				in_array('all_prod_id', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['product_id'], $numberFormat) : ''; // G
				in_array('all_prod_sku', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['product_sku'], $textFormat) : ''; // H
				in_array('all_prod_model', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['product_model'], $textFormat) : ''; // I
				in_array('all_prod_name', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['product_name'], ENT_COMPAT, 'UTF-8'), $textFormat) : ''; // J
				in_array('all_prod_option', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['product_option'], ENT_COMPAT, 'UTF-8'), $textFormat) : ''; // K
				in_array('all_prod_attributes', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['product_attributes'], ENT_COMPAT, 'UTF-8'), $textFormat) : ''; // L
				in_array('all_prod_manu', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['product_manu'], ENT_COMPAT, 'UTF-8'), $textFormat) : ''; // M
				in_array('all_prod_category', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['product_category'], ENT_COMPAT, 'UTF-8'), $textFormat) : ''; // N
				in_array('all_prod_currency', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['currency_code'], $textFormat) : ''; // O
				in_array('all_prod_price', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['product_price_raw'], $priceFormat) : ''; // P
				in_array('all_prod_quantity', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['product_quantity']) : ''; // Q
				in_array('all_prod_total_excl_vat', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['product_total_excl_vat_raw'], $priceFormat) : ''; // R
				in_array('all_prod_tax', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['product_tax_raw'], $priceFormat) : ''; // S
				in_array('all_prod_total_incl_vat', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['product_total_incl_vat_raw'], $priceFormat) : ''; // T
				in_array('all_prod_qty_refund', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['product_qty_refund']) : ''; // U
				in_array('all_prod_refund', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['product_refund_raw'] != NULL ? $result['product_refund_raw'] : '0.00', $priceFormat) : ''; // V
				in_array('all_prod_reward_points', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['product_reward_points']) : ''; // W
				in_array('all_sub_total', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_sub_total_raw'], $priceFormat) : ''; // X
				in_array('all_handling', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_handling_raw'] != NULL ? $result['order_handling_raw'] : '0.00', $priceFormat) : ''; // Y
				in_array('all_loworder', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_low_order_fee_raw'] != NULL ? $result['order_low_order_fee_raw'] : '0.00', $priceFormat) : ''; // Z
				in_array('all_shipping', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_shipping_raw'] != NULL ? $result['order_shipping_raw'] : '0.00', $priceFormat) : ''; // AA
				in_array('all_reward', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_reward_raw'] != NULL ? $result['order_reward_raw'] : '0.00', $priceFormat) : ''; // AB
				in_array('all_reward_points', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_earned_points']) : ''; // AC
				in_array('all_reward_points', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_used_points']) : ''; // AD	
				in_array('all_coupon', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_coupon_raw'] != NULL ? $result['order_coupon_raw'] : '0.00', $priceFormat) : ''; // AE
				in_array('all_coupon_code', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_coupon_code'], $textFormat) : ''; // AF
				in_array('all_order_tax', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_tax_raw'] != NULL ? $result['order_tax_raw'] : '0.00', $priceFormat) : ''; // AG
				in_array('all_credit', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_credit_raw'] != NULL ? $result['order_credit_raw'] : '0.00', $priceFormat) : ''; // AH
				in_array('all_voucher', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_voucher_raw'] != NULL ? $result['order_voucher_raw'] : '0.00', $priceFormat) : ''; // AI
				in_array('all_voucher_code', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_voucher_code'], $textFormat) : ''; // AJ
				in_array('all_order_commission', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, -$result['order_commission_raw'], $priceFormat) : ''; // AK
				in_array('all_order_value', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_value_raw'], $priceFormat) : ''; // AL
				in_array('all_refund', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_refund_raw'] != NULL ? $result['order_refund_raw'] : '0.00', $priceFormat) : ''; // AM
				in_array('all_order_shipping_method', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_method'], $textFormat) : ''; // AN
				in_array('all_order_payment_method', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_method'], $textFormat) : ''; // AO
				in_array('all_order_status', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_status'], $textFormat) : ''; // AP
				in_array('all_order_store', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['store_name'], ENT_COMPAT, 'UTF-8'), $textFormat) : ''; // AQ
				in_array('all_customer_cust_id', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['customer_id'], $numberFormat) : ''; // AR
				in_array('all_billing_first_name', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_firstname'], $textFormat) : ''; // AS
				in_array('all_billing_last_name', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_lastname'], $textFormat) : ''; // AT
				in_array('all_billing_company', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_company'], $textFormat) : ''; // AU
				in_array('all_billing_address_1', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_address_1'], $textFormat) : ''; // AV
				in_array('all_billing_address_2', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_address_2'], $textFormat) : ''; // AW
				in_array('all_billing_city', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_city'], $textFormat) : ''; // AX
				in_array('all_billing_zone', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_zone'], $textFormat) : ''; // AY
				in_array('all_billing_zone_id', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_zone_id'], $textFormat) : ''; // AZ
				in_array('all_billing_zone_code', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_zone_code'], $textFormat) : ''; // BA
				in_array('all_billing_postcode', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_postcode'], $textFormat) : ''; // BB
				in_array('all_billing_country', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_country'], $textFormat) : ''; // BC
				in_array('all_billing_country_id', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_country_id'], $textFormat) : ''; // BD
				in_array('all_billing_country_code', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['payment_country_code'], $textFormat) : ''; // BE
				in_array('all_customer_telephone', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['telephone'], $textFormat) : ''; // BF
				in_array('all_shipping_first_name', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_firstname'], $textFormat) : ''; // BG
				in_array('all_shipping_last_name', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_lastname'], $textFormat) : ''; // BH
				in_array('all_shipping_company', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_company'], $textFormat) : ''; // BI
				in_array('all_shipping_address_1', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_address_1'], $textFormat) : ''; // BJ
				in_array('all_shipping_address_2', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_address_2'], $textFormat) : ''; // BK
				in_array('all_shipping_city', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_city'], $textFormat) : ''; // BL
				in_array('all_shipping_zone', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_zone'], $textFormat) : ''; // BM
				in_array('all_shipping_zone_id', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_zone_id'], $textFormat) : ''; // BN
				in_array('all_shipping_zone_code', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_zone_code'], $textFormat) : ''; // BO
				in_array('all_shipping_postcode', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_postcode'], $textFormat) : ''; // BP
				in_array('all_shipping_country', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_country'], $textFormat) : ''; // BQ
				in_array('all_shipping_country_id', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_country_id'], $textFormat) : ''; // BR
				in_array('all_shipping_country_code', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['shipping_country_code'], $textFormat) : ''; // BS
				in_array('all_order_weight', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, $result['order_weight'], $priceFormat) : ''; // BT
				in_array('all_order_comment', $advpp_settings_all_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['order_comment'], ENT_COMPAT, 'UTF-8'), $textFormat) : ''; // BU

				$i += 1;
				$j = 0;
			}
		
		$freeze = ($export_logo_criteria ? array(5, 2, 5, 2) : array(1, 2, 1, 2));
		$worksheet->freezePanes($freeze);
		
		// Let's send the file		
		$workbook->close();
		
		// Clear the spreadsheet caches
		$this->clearSpreadsheetCache();
		exit;
	}
?>