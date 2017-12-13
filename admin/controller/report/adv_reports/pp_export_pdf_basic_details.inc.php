<?php
	ini_set("memory_limit","256M");
	$results = $export_data['results'];
	if ($results) {

	$export_pdf_basic_details = "<html><head>";			
	$export_pdf_basic_details .= "</head>";
	$export_pdf_basic_details .= "<body>";
	$export_pdf_basic_details .= "<style type='text/css'>
	.list_criteria {
		border-collapse: collapse;
		width: 100%;	
		border-top: 1px solid #DBE5F1;
		border-left: 1px solid #DBE5F1;	
		padding: 3px;		
		font-family: dejavu sans condensed;
		font-size: 12px;
		background: url('$logo') 5px 18px no-repeat #DBE5F1;
		background-size: 268px 50px;
	}
	.list_criteria td {
		border-right: 1px solid #DBE5F1;
		border-bottom: 1px solid #DBE5F1;	
	}
	
	.list_main {
		width: 100%;
		font-family: dejavu sans condensed;
		margin-bottom: 5px;
	}
	.list_main thead td {
		border: 1px solid #DDDDDD;			
		background-color: #F0F0F0;
		padding: 0px 3px;
		font-size: 11px;
		font-weight: bold;
	}	
	.list_main tbody a {
		text-decoration: none;
	}
	.list_main tbody td {
		border: 1px solid #DDDDDD;
		padding: 3px;
		font-size: 11px;	
	}

	.list_detail {
		width: 100%;
		font-family: dejavu sans condensed;			
	}
	.list_detail thead td {
		border: 1px solid #DDDDDD;		
		background-color: #f5f5f5;
		padding: 0px 3px;
		font-size: 9px;
		font-weight: bold;
	}	
	.list_detail tbody td {
		border: 1px solid #DDDDDD;
		padding: 0px 3px;
		font-size: 9px;	
	}
	
	.total {
		background-color: #E7EFEF;
		color: #003A88;
		font-weight: bold;
	}
	</style>";	
	if ($export_logo_criteria) {
	$export_pdf_basic_details .="<table class='list_criteria'>";
	$export_pdf_basic_details .="<tr>";
	$export_pdf_basic_details .= "<td colspan='3' align='center'>".$this->language->get('text_report_date').": ".date($this->config->get('advpp' . $this->user->getId() . '_hour_format') == '24' ? "Y-m-d H:i:s" : "Y-m-d h:i:s A")."</td><td></td>";
	$export_pdf_basic_details .="<tr>";
	$export_pdf_basic_details .= "<td colspan='3' align='center' style='height:50px; font-size:24; font-weight:bold;'>".$this->language->get('heading_title')."</td><td width='1%' align='left' valign='top' nowrap='nowrap'><b>".$this->config->get('config_name')."</b> <br>".$this->config->get('config_address')." <br>".$this->language->get('text_email')."".$this->config->get('config_email')." <br>".$this->language->get('text_telephone')."".$this->config->get('config_telephone')." </td>";
	$export_pdf_basic_details .="<tr>";
	$export_pdf_basic_details .= "<td align='right' valign='top' style='height:50px; width:150px; font-weight:bold;'>".$this->language->get('text_report_criteria')." </td>";	
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
			$filter_criteria .= "<br />";
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
			$filter_criteria .= "<br />";
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
	$export_pdf_basic_details .= "<td colspan='2' align='left' valign='top'>".$filter_criteria."</td><td></td>";
	$export_pdf_basic_details .="<tr>";
	$export_pdf_basic_details .="</table>";
	}		
	foreach ($results as $result) {		
	$export_pdf_basic_details .= "<div style='border:1px solid #999; padding: 3px; margin-bottom:10px; width:100%;'>";
	$export_pdf_basic_details .= "<table cellspacing='0' cellpadding='0' class='list_main'>";	
	$export_pdf_basic_details .="<thead><tr>";	
	if ($filter_group == 'year') {				
	$export_pdf_basic_details .= "<td colspan='2' align='left' nowrap='nowrap'>".$this->language->get('column_year')."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_year')."</td>";
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_quarter')."</td>";				
	} elseif ($filter_group == 'month') {
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_year')."</td>";
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_month')."</td>";
	} elseif ($filter_group == 'day') {
	$export_pdf_basic_details .= "<td colspan='2' align='left' nowrap='nowrap'>".$this->language->get('column_date')."</td>";
	} elseif ($filter_group == 'order') {
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_order_order_id')."</td>";
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_order_date_added')."</td>";	
	} else {
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_date_start')."</td>";
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_date_end')."</td>";	
	}
	if ($filter_report != 'manufacturers' && $filter_report != 'categories') {
	in_array('mv_id', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_id')."</td>" : '';
	in_array('mv_sku', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_sku')."</td>" : '';
	if ($filter_report == 'products_purchased_with_options') {
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_name')."</td>" : '';
	} else {
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_prod_name')."</td>" : '';
	}	
	in_array('mv_model', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_model')."</td>" : '';
	in_array('mv_category', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_category')."</td>" : '';
	in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_manufacturer')."</td>" : '';
	in_array('mv_attribute', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_attribute')."</td>" : '';
	in_array('mv_status', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_status')."</td>" : '';
	in_array('mv_location', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_location')."</td>" : '';
	in_array('mv_tax_class', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_tax_class')."</td>" : '';
	in_array('mv_price', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_price')."</td>" : '';
	in_array('mv_viewed', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_viewed')."</td>" : '';
	in_array('mv_stock_quantity', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_stock_quantity')."</td>" : '';
	} elseif ($filter_report == 'manufacturers') {
	in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_manufacturer')."</td>" : '';	
	} elseif ($filter_report == 'categories') {
	in_array('mv_category', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_category')."</td>" : '';
	}
	in_array('mv_sold_quantity', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_sold_quantity')."</td>" : '';
	in_array('mv_sold_percent', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_sold_percent')."</td>" : '';
	in_array('mv_total_excl_vat', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' style='width:60px;'>".$this->language->get('column_prod_total_excl_vat')."</td>" : '';
	in_array('mv_total_tax', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_total_tax')."</td>" : '';
	in_array('mv_total_incl_vat', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' style='width:60px;'>".$this->language->get('column_prod_total_incl_vat')."</td>" : '';
	in_array('mv_app', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' style='width:80px;'>".$this->language->get('column_app')."</td>" : '';
	in_array('mv_refunds', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_product_refunds')."</td>" : '';
	in_array('mv_reward_points', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_product_reward_points')."</td>" : '';
	$export_pdf_basic_details .= "</tr></thead>";
	$export_pdf_basic_details .= "<tbody><tr>";
	if ($filter_group == 'year') {				
	$export_pdf_basic_details .= "<td colspan='2' align='left' nowrap='nowrap' style='background-color:#F9F9F9;'>".$result['year']."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap' style='background-color:#F9F9F9;'>".$result['year']."</td>";	
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap' style='background-color:#F9F9F9;'>".$result['quarter']."</td>";						
	} elseif ($filter_group == 'month') {
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap' style='background-color:#F9F9F9;'>".$result['year']."</td>";	
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap' style='background-color:#F9F9F9;'>".$result['month']."</td>";	
	} elseif ($filter_group == 'day') {
	$export_pdf_basic_details .= "<td colspan='2' align='left' nowrap='nowrap' style='background-color:#F9F9F9;'>".$result['date_start']."</td>";
	} elseif ($filter_group == 'order') {
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap' style='background-color:#F9F9F9;'>".$result['order_id']."</td>";	
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap' style='background-color:#F9F9F9;'>".$result['date_start']."</td>";
	} else {
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap' style='background-color:#F9F9F9;'>".$result['date_start']."</td>";
	$export_pdf_basic_details .= "<td align='left' nowrap='nowrap' style='background-color:#F9F9F9;'>".$result['date_end']."</td>";
	}
	if ($filter_report != 'manufacturers' && $filter_report != 'categories') {
	in_array('mv_id', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$result['product_id']."</td>" : '';
	in_array('mv_sku', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$result['sku']."</td>" : '';
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left' style='color:#03C;'><strong>".$result['name']."</strong>" : '';
	if ($filter_report == 'products_purchased_with_options') {
		$this->load->model('report/adv_products_profit');
			$options = $this->model_report_adv_products_profit->getOrderOptions($result['order_product_id']);
			foreach ($options as $option) {
				if ($option['type'] != 'textarea' or $option['type'] != 'file' or $option['type'] != 'date' or $option['type'] != 'datetime' or $option['type'] != 'time') {
					$option_data[] = array(
						'name'  => $option['name'],
						'value' => $option['value'],
						'type'  => $option['type']
					);
				}
			}		
	if ($result['option']) {
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<div style='display:table; margin-left:3px;'>" : '';			
	foreach ($result['option'] as $option) {
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<div style='display:table-row; white-space:nowrap;'>" : '';		
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<div style='display:table-cell; white-space:nowrap; font-size:11px; color:#03C;'>".$option['name'].":</div>" : '';		
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<div style='display:table-cell; white-space:nowrap; font-size:11px; color:#03C; padding-left:5px;'>".$option['value']."</div>" : '';
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "</div>" : '';
	}
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "</div>" : '';
	in_array('mv_name', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "</td>" : '';
	}
	}	
	in_array('mv_model', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$result['model']."</td>" : '';	
	in_array('mv_category', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$result['categories']."</td>" : '';
	in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$result['manufacturers']."</td>" : '';
	in_array('mv_attribute', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$result['attribute']."</td>" : '';
	in_array('mv_status', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$result['status']."</td>" : '';
	in_array('mv_location', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$result['location']."</td>" : '';
	in_array('mv_tax_class', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left'>".$result['tax_class']."</td>" : '';
	in_array('mv_price', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap' style='background-color:#f1f9e9;'>".$result['price']."</td>" : '';
	in_array('mv_viewed', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$result['viewed']."</td>" : '';
	in_array('mv_stock_quantity', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$result['stock_quantity']."</td>" : '';
	} elseif ($filter_report == 'manufacturers') {
	in_array('mv_manufacturer', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left' style='color:#03C;'><strong>".$result['manufacturers']."</strong></td>" : '';
	} elseif ($filter_report == 'categories') {
	in_array('mv_category', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='left' style='color:#03C;'><strong>".$result['categories']."</strong></td>" : '';
	}				
	in_array('mv_sold_quantity', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap' style='background-color:#FFC;'>".$result['sold_quantity']."</td>" : '';
	if (!is_null($result['sold_quantity'])) {
	in_array('mv_sold_percent', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap' style='background-color:#FFC;'>".round(100 * ($result['sold_quantity'] / $result['sold_quantity_total']), 2) . '%'."</td>" : '';
	} else {
	in_array('mv_sold_percent', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap' style='background-color:#FFC;'>".'0%'."</td>" : '';
	}	
	in_array('mv_total_excl_vat', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['total_excl_vat']."</td>" : '';
	in_array('mv_total_tax', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['total_tax']."</td>" : '';
	in_array('mv_total_incl_vat', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['total_incl_vat']."</td>" : '';
	in_array('mv_app', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['app']."</td>" : '';
	in_array('mv_refunds', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['refunds']."</td>" : '';
	in_array('mv_reward_points', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$result['reward_points']."</td>" : '';
	$export_pdf_basic_details .= "</tr></tbody></table>";
	if ($filter_report == 'products_purchased_without_options' or $filter_report == 'products_purchased_with_options' or $filter_report == 'new_products_purchased' or $filter_report == 'old_products_purchased') {
	$export_pdf_basic_details .="<table cellspacing='0' cellpadding='0' cellspacing='0' cellpadding='0' class='list_detail'>";
	$export_pdf_basic_details .="<thead><tr>";
		in_array('ol_order_order_id', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_order_order_id')."</td>" : '';
		in_array('ol_order_date_added', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_order_date_added')."</td>" : '';
		in_array('ol_order_inv_no', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_order_inv_no')."</td>" : '';
		in_array('ol_order_customer', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_order_customer')."</td>" : '';
		in_array('ol_order_email', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_order_email')."</td>" : '';
		in_array('ol_order_customer_group', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_order_customer_group')."</td>" : '';
		in_array('ol_order_shipping_method', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_order_shipping_method')."</td>" : '';
		in_array('ol_order_payment_method', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_order_payment_method')."</td>" : '';
		in_array('ol_order_status', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_order_status')."</td>" : '';
		in_array('ol_order_store', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_order_store')."</td>" : '';
		in_array('ol_order_currency', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_order_currency')."</td>" : '';
		in_array('ol_prod_price', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_prod_price')."</td>" : '';
		in_array('ol_prod_quantity', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_prod_quantity')."</td>" : '';
		in_array('ol_prod_total_excl_vat', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_prod_total_excl_vat')."</td>" : '';
		in_array('ol_prod_tax', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_prod_tax')."</td>" : '';
		in_array('ol_prod_total_incl_vat', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_prod_total_incl_vat')."</td>" : '';
		$export_pdf_basic_details .="</tr></thead>";
		$export_pdf_basic_details .="<tbody><tr>";
		in_array('ol_order_order_id', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap' style='background-color:#FFC;'>".$result['order_prod_ord_id']."</td>" : '';
		in_array('ol_order_date_added', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['order_prod_ord_date']."</td>" : '';
		in_array('ol_order_inv_no', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['order_prod_inv_no']."</td>" : '';
		in_array('ol_order_customer', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['order_prod_name']."</td>" : '';
		in_array('ol_order_email', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['order_prod_email']."</td>" : '';
		in_array('ol_order_customer_group', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['order_prod_group']."</td>" : '';
		in_array('ol_order_shipping_method', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['order_prod_shipping_method']."</td>" : '';
		in_array('ol_order_payment_method', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['order_prod_payment_method']."</td>" : '';
		in_array('ol_order_status', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['order_prod_status']."</td>" : '';
		in_array('ol_order_store', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['order_prod_store']."</td>" : '';
		in_array('ol_order_currency', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['order_prod_currency']."</td>" : '';
		in_array('ol_prod_price', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['order_prod_price']."</td>" : '';
		in_array('ol_prod_quantity', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['order_prod_quantity']."</td>" : '';
		in_array('ol_prod_total_excl_vat', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['order_prod_total_excl_vat']."</td>" : '';
		in_array('ol_prod_tax', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['order_prod_tax']."</td>" : '';
		in_array('ol_prod_total_incl_vat', $advpp_settings_ol_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['order_prod_total_incl_vat']."</td>" : '';
		$export_pdf_basic_details .= "</tr></tbody></table>";
	}
		
	if ($filter_report == 'manufacturers' or $filter_report == 'categories') {
	$export_pdf_basic_details .="<table cellspacing='0' cellpadding='0' cellspacing='0' cellpadding='0' class='list_detail' style='margin-top:5px; margin-bottom:5px;'>";
	$export_pdf_basic_details .="<thead><tr>";
		in_array('pl_prod_order_id', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_prod_order_id')."</td>" : '';
		in_array('pl_prod_date_added', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_prod_date_added')."</td>" : '';
		in_array('pl_prod_inv_no', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_prod_inv_no')."</td>" : '';
		in_array('pl_prod_id', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_prod_id')."</td>" : '';
		in_array('pl_prod_sku', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_prod_sku')."</td>" : '';
		in_array('pl_prod_model', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_prod_model')."</td>" : '';		
		in_array('pl_prod_name', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_prod_name')."</td>" : '';
		in_array('pl_prod_option', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_prod_option')."</td>" : '';
		in_array('pl_prod_attributes', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_prod_attributes')."</td>" : '';
		if ($filter_report == 'categories') {
		in_array('pl_prod_manu', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_prod_manu')."</td>" : '';
		}
		if ($filter_report == 'manufacturers') {
		in_array('pl_prod_category', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_prod_category')."</td>" : '';
		}
		in_array('pl_prod_currency', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_prod_currency')."</td>" : '';
		in_array('pl_prod_price', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_prod_price')."</td>" : '';
		in_array('pl_prod_quantity', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_prod_quantity')."</td>" : '';
		in_array('pl_prod_total_excl_vat', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_prod_total_excl_vat')."</td>" : '';		
		in_array('pl_prod_tax', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_prod_tax')."</td>" : '';		
		in_array('pl_prod_total_incl_vat', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_prod_total_incl_vat')."</td>" : '';
		$export_pdf_basic_details .="</tr></thead>";
		$export_pdf_basic_details .="<tbody><tr>";
		in_array('pl_prod_order_id', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap' style='background-color:#FFC;'>".$result['product_ord_id']."</td>" : '';
		in_array('pl_prod_date_added', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['product_ord_date']."</td>" : '';
		in_array('pl_prod_inv_no', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['product_inv_no']."</td>" : '';
		in_array('pl_prod_id', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['product_prod_id']."</td>" : '';
		in_array('pl_prod_sku', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['product_sku']."</td>" : '';
		in_array('pl_prod_model', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['product_model']."</td>" : '';		
		in_array('pl_prod_name', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['product_name']."</td>" : '';
		in_array('pl_prod_option', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['product_option']."</td>" : '';
		in_array('pl_prod_attributes', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['product_attributes']."</td>" : '';	
		if ($filter_report == 'categories') {
		in_array('pl_prod_manu', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['product_manu']."</td>" : '';
		}
		if ($filter_report == 'manufacturers') {
		in_array('pl_prod_category', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['product_category']."</td>" : '';	
		}	
		in_array('pl_prod_currency', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['product_currency']."</td>" : '';
		in_array('pl_prod_price', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['product_price']."</td>" : '';
		in_array('pl_prod_quantity', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['product_quantity']."</td>" : '';
		in_array('pl_prod_total_excl_vat', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['product_total_excl_vat']."</td>" : '';		
		in_array('pl_prod_tax', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['product_tax']."</td>" : '';
		in_array('pl_prod_total_incl_vat', $advpp_settings_pl_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap'>".$result['product_total_incl_vat']."</td>" : '';
		$export_pdf_basic_details .= "</tr></tbody></table>";
	}
		
	$export_pdf_basic_details .="<table cellspacing='0' cellpadding='0' cellspacing='0' cellpadding='0' class='list_detail' style='margin-top:5px;'>";
	$export_pdf_basic_details .="<thead><tr>";
		in_array('cl_customer_order_id', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_customer_order_id')."</td>" : '';
		in_array('cl_customer_date_added', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_customer_date_added')."</td>" : '';
		in_array('cl_customer_cust_id', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_customer_cust_id')."</td>" : '';
		in_array('cl_billing_name', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_billing_name')."</td>" : '';
		in_array('cl_billing_company', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_billing_company')."</td>" : '';
		in_array('cl_billing_address_1', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_billing_address_1')."</td>" : '';
		in_array('cl_billing_address_2', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_billing_address_2')."</td>" : '';
		in_array('cl_billing_city', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_billing_city')."</td>" : '';
		in_array('cl_billing_zone', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_billing_zone')."</td>" : '';
		in_array('cl_billing_postcode', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_billing_postcode')."</td>" : '';
		in_array('cl_billing_country', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_billing_country')."</td>" : '';
		in_array('cl_customer_telephone', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_customer_telephone')."</td>" : '';
		in_array('cl_shipping_name', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_shipping_name')."</td>" : '';
		in_array('cl_shipping_company', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_shipping_company')."</td>" : '';
		in_array('cl_shipping_address_1', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_shipping_address_1')."</td>" : '';
		in_array('cl_shipping_address_2', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_shipping_address_2')."</td>" : '';
		in_array('cl_shipping_city', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_shipping_city')."</td>" : '';
		in_array('cl_shipping_zone', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_shipping_zone')."</td>" : '';
		in_array('cl_shipping_postcode', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_shipping_postcode')."</td>" : '';
		in_array('cl_shipping_country', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left'>".$this->language->get('column_shipping_country')."</td>" : '';
		$export_pdf_basic_details .="</tr></thead>";
		$export_pdf_basic_details .="<tbody><tr>";
		in_array('cl_customer_order_id', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap' style='background-color:#FFC;'>".$result['customer_ord_id']."</td>" : '';
		in_array('cl_customer_date_added', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['customer_ord_date']."</td>" : '';
		in_array('cl_customer_cust_id', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['customer_cust_id']."</td>" : '';
		in_array('cl_billing_name', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['billing_name']."</td>" : '';
		in_array('cl_billing_company', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['billing_company']."</td>" : '';
		in_array('cl_billing_address_1', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['billing_address_1']."</td>" : '';
		in_array('cl_billing_address_2', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['billing_address_2']."</td>" : '';
		in_array('cl_billing_city', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['billing_city']."</td>" : '';
		in_array('cl_billing_zone', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['billing_zone']."</td>" : '';
		in_array('cl_billing_postcode', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['billing_postcode']."</td>" : '';
		in_array('cl_billing_country', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['billing_country']."</td>" : '';
		in_array('cl_customer_telephone', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['customer_telephone']."</td>" : '';
		in_array('cl_shipping_name', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['shipping_name']."</td>" : '';
		in_array('cl_shipping_company', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['shipping_company']."</td>" : '';
		in_array('cl_shipping_address_1', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['shipping_address_1']."</td>" : '';
		in_array('cl_shipping_address_2', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['shipping_address_2']."</td>" : '';
		in_array('cl_shipping_city', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['shipping_city']."</td>" : '';
		in_array('cl_shipping_zone', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['shipping_zone']."</td>" : '';
		in_array('cl_shipping_postcode', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['shipping_postcode']."</td>" : '';
		in_array('cl_shipping_country', $advpp_settings_cl_columns) ? $export_pdf_basic_details .= "<td align='left' nowrap='nowrap'>".$result['shipping_country']."</td>" : '';
		$export_pdf_basic_details .= "</tr></tbody></table>";		
		$export_pdf_basic_details .="</div>";			
	}	
	$export_pdf_basic_details .="<table cellspacing='0' cellpadding='0' class='list_main'>";
	$export_pdf_basic_details .="<thead><tr>";
	$export_pdf_basic_details .= "<td></td>";
	in_array('mv_sold_quantity', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_sold_quantity')."</td>" : '';
	in_array('mv_sold_percent', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_sold_percent')."</td>" : '';
	in_array('mv_total_excl_vat', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' style='min-width:65px;'>".$this->language->get('column_prod_total_excl_vat')."</td>" : '';
	in_array('mv_total_tax', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_total_tax')."</td>" : '';
	in_array('mv_total_incl_vat', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' style='min-width:65px;'>".$this->language->get('column_prod_total_incl_vat')."</td>" : '';
	in_array('mv_app', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' style='min-width:75px;'>".$this->language->get('column_app')."</td>" : '';
	in_array('mv_refunds', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_product_refunds')."</td>" : '';
	in_array('mv_reward_points', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right'>".$this->language->get('column_product_reward_points')."</td>" : '';
	$export_pdf_basic_details .="</tr></thead>";
	$export_pdf_basic_details .="<tbody><tr>";
	$export_pdf_basic_details .= "<td align='right' style='background-color:#E5E5E5; font-weight:bold;'>".$this->language->get('text_filter_total')."</td>";
	in_array('mv_sold_quantity', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap' class='total'>".$result['sold_quantity_total']."</td>" : '';
	in_array('mv_sold_percent', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap' class='total'>".$result['sold_percent_total']."</td>" : '';
	in_array('mv_total_excl_vat', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap' class='total'>".$result['total_excl_vat_total']."</td>" : '';
	in_array('mv_total_tax', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap' class='total'>".$result['total_tax_total']."</td>" : '';
	in_array('mv_total_incl_vat', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap' class='total'>".$result['total_incl_vat_total']."</td>" : '';
	in_array('mv_app', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap' class='total'>".$result['app_total']."</td>" : '';	
	in_array('mv_refunds', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap' class='total'>".$result['refunds_total']."</td>" : '';	
	in_array('mv_reward_points', $advpp_settings_mv_columns) ? $export_pdf_basic_details .= "<td align='right' nowrap='nowrap' class='total'>".$result['reward_points_total']."</td>" : '';
	$export_pdf_basic_details .="</tr></tbody></table>";
	$export_pdf_basic_details .="</body></html>";

	ini_set('mbstring.substitute_character', "none"); 
	$dompdf_pdf_basic_details = mb_convert_encoding($export_pdf_basic_details, 'ISO-8859-1', 'UTF-8'); 
	$dompdf = new DOMPDF();
	$dompdf->load_html($dompdf_pdf_basic_details);
	$dompdf->set_paper("a3", "landscape");
	$dompdf->render();
	$dompdf->stream("products_report_basic_details_".date($this->config->get('advpp' . $this->user->getId() . '_hour_format') == '24' ? "Y-m-d_H-i-s" : "Y-m-d_h-i-s-A").".pdf");
	}
?>