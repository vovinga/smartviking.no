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

		$workbook->setCustomColor(27, 255, 255, 204);
		$soldColumnFormat =& $workbook->addFormat(array('Align' => 'right', 'FgColor' => '27', 'bordercolor' => 'silver'));
		$soldColumnFormat->setBorder(1);
		$percentFormat =& $workbook->addFormat(array('Align' => 'right', 'FgColor' => '27', 'bordercolor' => 'silver'));
		$percentFormat->setBorder(1);	
		$percentFormat->setNumFormat('0.00%');
				
		$boxFormatText =& $workbook->addFormat(array('bold' => 1));
		$boxFormatNumber =& $workbook->addFormat(array('Align' => 'right', 'bold' => 1));
		
		// sending HTTP headers
		$workbook->send('products_report_'.date($this->config->get('advpp' . $this->user->getId() . '_hour_format') == '24' ? "Y-m-d_H-i-s" : "Y-m-d_h-i-s-A").'.xls');
		$worksheet =& $workbook->addWorksheet('ADV Products Report');
		$worksheet->setInputEncoding('UTF-8');
		$worksheet->setZoom(90);

		// Set the column widths
		$j = 0;
		if ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') {		
		$worksheet->setColumn($j,$j++,13); // A		
		} else {
		if ($filter_group == 'year') {			
		$worksheet->setMerge(0, 1, 0, 1);
		$worksheet->setColumn($j,$j++,10); // A,B
		} elseif ($filter_group == 'quarter') {
		$worksheet->setColumn($j,$j++,10); // A
		$worksheet->setColumn($j,$j++,10); // B			
		} elseif ($filter_group == 'month') {
		$worksheet->setColumn($j,$j++,10); // A
		$worksheet->setColumn($j,$j++,13); // B
		} elseif ($filter_group == 'day') {
		$worksheet->setMerge(0, 1, 0, 1);
		$worksheet->setColumn($j,$j++,13); // A,B
		} elseif ($filter_group == 'order') {
		$worksheet->setColumn($j,$j++,10); // A
		$worksheet->setColumn($j,$j++,13); // B
		} else {
		$worksheet->setColumn($j,$j++,13); // A
		$worksheet->setColumn($j,$j++,13); // B
		}
		}		
		if ($filter_report != 'manufacturers' && $filter_report != 'categories') {
		in_array('mv_id', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,8) : ''; // C
		in_array('mv_sku', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // D
		in_array('mv_name', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,25) : ''; // E
		if ($filter_report == 'products_purchased_with_options') {
		in_array('mv_name', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // F
		}
		in_array('mv_model', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // G
		in_array('mv_category', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // H
		in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // I
		in_array('mv_attribute', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // J
		in_array('mv_status', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,10) : ''; // K
		in_array('mv_location', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // L
		in_array('mv_tax_class', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,20) : ''; // M
		in_array('mv_price', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,13) : ''; // N
		in_array('mv_viewed', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,10) : ''; // O
		in_array('mv_stock_quantity', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,10) : ''; // P
		} elseif ($filter_report == 'manufacturers') {
		in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,20) : '';
		} elseif ($filter_report == 'categories') {
		in_array('mv_category', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,20) : '';
		}
		if ($filter_report != 'products_without_orders') {		
		in_array('mv_sold_quantity', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,10) : ''; // Q
		in_array('mv_sold_percent', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,10) : ''; // R
		in_array('mv_total_excl_vat', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // S
		in_array('mv_total_tax', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // T
		in_array('mv_total_incl_vat', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // U
		in_array('mv_app', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,18) : ''; // V
		in_array('mv_refunds', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // W
		in_array('mv_reward_points', $advpp_settings_mv_columns) ? $worksheet->setColumn($j,$j++,15) : ''; // X
		}

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
		if ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') {	
		$worksheet->writeString($i, $j++, $this->language->get('column_date_added'), $boxFormatText); // A
		} else {
		if ($filter_group == 'year') {	
		$worksheet->writeString($i, $j++, $this->language->get('column_year'), $boxFormatText); // A,B
		} elseif ($filter_group == 'quarter') {
		$worksheet->writeString($i, $j++, $this->language->get('column_year'), $boxFormatText); // A
		$worksheet->writeString($i, $j++, $this->language->get('column_quarter'), $boxFormatText); // B		
		} elseif ($filter_group == 'month') {
		$worksheet->writeString($i, $j++, $this->language->get('column_year'), $boxFormatText); // A
		$worksheet->writeString($i, $j++, $this->language->get('column_month'), $boxFormatText); // B
		} elseif ($filter_group == 'day') {
		$worksheet->writeString($i, $j++, $this->language->get('column_date'), $boxFormatText); // A,B
		} elseif ($filter_group == 'order') {
		$worksheet->writeString($i, $j++, $this->language->get('column_order_order_id'), $boxFormatText); // A
		$worksheet->writeString($i, $j++, $this->language->get('column_order_date_added'), $boxFormatText); // B
		} else {
		$worksheet->writeString($i, $j++, $this->language->get('column_date_start'), $boxFormatText); // A
		$worksheet->writeString($i, $j++, $this->language->get('column_date_end'), $boxFormatText); // B
		}
		}
		if ($filter_report != 'manufacturers' && $filter_report != 'categories') {
		in_array('mv_id', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_id'), $boxFormatNumber) : ''; // C
		in_array('mv_sku', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_sku'), $boxFormatText) : ''; // D
		in_array('mv_name', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_pname'), $boxFormatText) : ''; // E
		if ($filter_report == 'products_purchased_with_options') {
		in_array('mv_name', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_poption'), $boxFormatText) : ''; // F
		}
		in_array('mv_model', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_model'), $boxFormatText) : ''; // G
		in_array('mv_category', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_category'), $boxFormatText) : ''; // H
		in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_manufacturer'), $boxFormatText) : ''; // I
		in_array('mv_attribute', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_attribute'), $boxFormatText) : ''; // J
		in_array('mv_status', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_status'), $boxFormatText) : ''; // K
		in_array('mv_location', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_location'), $boxFormatText) : ''; // L
		in_array('mv_tax_class', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_tax_class'), $boxFormatText) : ''; // M
		in_array('mv_price', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_price'), $boxFormatNumber) : ''; // N
		in_array('mv_viewed', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_viewed'), $boxFormatNumber) : ''; // O
		in_array('mv_stock_quantity', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_stock_quantity'), $boxFormatNumber) : ''; // P
		} elseif ($filter_report == 'manufacturers') {
		in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_manufacturer'), $boxFormatText) : '';
		} elseif ($filter_report == 'categories') {
		in_array('mv_category', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_category'), $boxFormatText) : '';
		}		
		if ($filter_report != 'products_without_orders') {		
		in_array('mv_sold_quantity', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_sold_quantity'), $boxFormatNumber) : ''; // Q
		in_array('mv_sold_percent', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_sold_percent'), $boxFormatNumber) : ''; // R
		in_array('mv_total_excl_vat', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_total_excl_vat'), $boxFormatNumber) : ''; // S
		in_array('mv_total_tax', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_total_tax'), $boxFormatNumber) : ''; // T
		in_array('mv_total_incl_vat', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_prod_total_incl_vat'), $boxFormatNumber) : ''; // U
		in_array('mv_app', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_app'), $boxFormatNumber) : ''; // V
		in_array('mv_refunds', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_product_refunds'), $boxFormatNumber) : ''; // W
		in_array('mv_reward_points', $advpp_settings_mv_columns) ? $worksheet->writeString($i, $j++, $this->language->get('column_product_reward_points'), $boxFormatNumber) : ''; // X
		}
		
		// The actual orders data
		$i += 1;
		$j = 0;
		
			foreach ($results as $result) {
			$excelRow = $i+1;
				if ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') {
				$worksheet->write($i, $j++, $result['date_added'], $textFormat); // A
				} else {
				if ($filter_group == 'year') {	
				$worksheet->write($i, $j++, $result['year'], $textFormat); // A,B
				} elseif ($filter_group == 'quarter') {
				$worksheet->write($i, $j++, $result['year'], $textFormat); // A
				$worksheet->write($i, $j++, 'Q' . $result['quarter'], $textFormat); // B				
				} elseif ($filter_group == 'month') {
				$worksheet->write($i, $j++, $result['year'], $textFormat); // A
				$worksheet->write($i, $j++, $result['month'], $textFormat); // B
				} elseif ($filter_group == 'day') {
				$worksheet->write($i, $j++, $result['date_start'], $textFormat); // A,B
				} elseif ($filter_group == 'order') {
				$worksheet->write($i, $j++, $result['order_id'], $textFormat); // A
				$worksheet->write($i, $j++, $result['date_start'], $textFormat); // B
				} else {
				$worksheet->write($i, $j++, $result['date_start'], $textFormat); // A
				$worksheet->write($i, $j++, $result['date_end'], $textFormat); // B	
				}
				}
				if ($filter_report != 'manufacturers' && $filter_report != 'categories') {
				in_array('mv_id', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['product_id']) : ''; // C
				in_array('mv_sku', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['sku'], $textFormat) : ''; // D
				in_array('mv_name', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['name'])) : ''; // E
				if ($filter_report == 'products_purchased_with_options') {
				in_array('mv_name', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['options'])) : ''; // F
				}
				in_array('mv_model', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['model']) : ''; // G
				in_array('mv_category', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['categories'])) : ''; // H
				in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['manufacturers'])) : ''; // I
				in_array('mv_attribute', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, html_entity_decode(str_replace('<br>','; ',$result['attribute']))) : ''; // J
				in_array('mv_status', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['status']) : ''; // K
				in_array('mv_location', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['location']) : ''; // L
				in_array('mv_tax_class', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['tax_class']) : ''; // M
				in_array('mv_price', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['price_raw']) : ''; // N				
				in_array('mv_viewed', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['viewed']) : ''; // O
				in_array('mv_stock_quantity', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['stock_quantity']) : ''; // P
				} elseif ($filter_report == 'manufacturers') {
				in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['manufacturers'])) : '';
				} elseif ($filter_report == 'categories') {
				in_array('mv_category', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, html_entity_decode($result['categories'])) : '';
				}				
				if ($filter_report != 'products_without_orders') {
				in_array('mv_sold_quantity', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['sold_quantity'], $soldColumnFormat) : ''; // Q
				if (!is_null($result['sold_quantity'])) {
				in_array('mv_sold_percent', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, round(100 * ($result['sold_quantity'] / $result['sold_quantity_total']), 2) / 100, $percentFormat) : ''; // R
				} else {
				in_array('mv_sold_percent', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, 0 / 100, $percentFormat) : ''; // R
				}				
				in_array('mv_total_excl_vat', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['total_excl_vat_raw'] != NULL ? $result['total_excl_vat_raw'] : '0.00', $priceFormat) : ''; // S
				in_array('mv_total_tax', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['total_tax_raw'] != NULL ? $result['total_tax_raw'] : '0.00', $priceFormat) : ''; // T
				in_array('mv_total_incl_vat', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['total_incl_vat_raw'] != NULL ? $result['total_incl_vat_raw'] : '0.00', $priceFormat) : ''; // U
				in_array('mv_app', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['app_raw'], $priceFormat) : ''; // V
				in_array('mv_refunds', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['refunds_raw'] != NULL ? $result['refunds_raw'] : '0.00', $priceFormat) : ''; // W
				in_array('mv_reward_points', $advpp_settings_mv_columns) ? $worksheet->write($i, $j++, $result['reward_points']) : ''; // X
				}

				$i += 1;
				$j = 0;
			}

		$freeze = ($export_logo_criteria ? array(5, 0, 5, 0) : array(1, 0, 1, 0));
		$worksheet->freezePanes($freeze);
		
		// Let's send the file		
		$workbook->close();
		
		// Clear the spreadsheet caches
		$this->clearSpreadsheetCache();
		exit;
	}		
?>