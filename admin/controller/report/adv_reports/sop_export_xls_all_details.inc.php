<?php
ini_set("memory_limit","256M");

	$export_xls_all_details ="<html><head>";
	$export_xls_all_details .="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	$export_xls_all_details .="</head>";
	$export_xls_all_details .="<body>";				
	$export_xls_all_details .="<table border='1'>";
	$export_xls_all_details .="<tr>";
	$export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_order_id')."</td>";
	$export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_date_added')."</td>";
	$export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_inv_no')."</td>";
	isset($_POST['sop1001']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_customer')."</td>" : '';
	isset($_POST['sop1002']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_email')."</td>" : '';	
	isset($_POST['sop1003']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_customer_group')."</td>" : '';	
	isset($_POST['sop1004']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_id')."</td>" : '';
	isset($_POST['sop1005']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_sku')."</td>" : '';
	isset($_POST['sop1006']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_model')."</td>" : '';
	isset($_POST['sop1007']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_name')."</td>" : '';
	isset($_POST['sop1008']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_option')."</td>" : '';
	isset($_POST['sop1009']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_attributes')."</td>" : '';
	isset($_POST['sop1010']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_manu')."</td>" : '';
	isset($_POST['sop1011']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_category')."</td>" : '';	
	isset($_POST['sop1012']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_currency')."</td>" : '';
	isset($_POST['sop1013']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_price')."</td>" : '';
	isset($_POST['sop1014']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_quantity')."</td>" : '';
	isset($_POST['sop1015']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_tax')."</td>" : '';
	isset($_POST['sop1016']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_total')."</td>" : '';	
	isset($_POST['sop1017']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
	isset($_POST['sop1018']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_profit')."</td>" : '';
	isset($_POST['sop1019']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_profit')." [%]</td>" : '';	
	isset($_POST['sop1020']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_sub_total')."</td>" : '';
	isset($_POST['sop1021']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_handling')."</td>" : '';
	isset($_POST['sop1022']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_loworder')."</td>" : '';	
	isset($_POST['sop1023']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_shipping')."</td>" : '';
	isset($_POST['sop1024']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_reward')."</td>" : '';
	isset($_POST['sop1025']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_coupon')."</td>" : '';	
	isset($_POST['sop1026']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_coupon_code')."</td>" : '';	
	isset($_POST['sop1027']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_tax')."</td>" : '';
	isset($_POST['sop1028']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_credit')."</td>" : '';
	isset($_POST['sop1029']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_voucher')."</td>" : '';
	isset($_POST['sop1030']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_voucher_code')."</td>" : '';		
	isset($_POST['sop1031']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_value')."</td>" : '';
	isset($_POST['sop1032']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_sales')."</td>" : '';
	isset($_POST['sop1033']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
	isset($_POST['sop1034']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_commission')."</td>" : '';
	isset($_POST['sop1035']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_payment_cost')."</td>" : '';
	isset($_POST['sop1036']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_shipping_cost')."</td>" : '';	
	isset($_POST['sop1037']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_costs')."</td>" : '';
	isset($_POST['sop1038']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_profit')."</td>" : '';
	isset($_POST['sop1039']) ? $export_xls_all_details .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_profit')." [%]</td>" : '';	
	isset($_POST['sop1040']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_shipping_method')."</td>" : '';
	isset($_POST['sop1041']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_payment_method')."</td>" : '';
	isset($_POST['sop1042']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_status')."</td>" : '';
	isset($_POST['sop1043']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_order_store')."</td>" : '';
	isset($_POST['sop1044']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_customer_cust_id')."</td>" : '';	
	isset($_POST['sop1045']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_name'))."</td>" : '';
	isset($_POST['sop1046']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_company'))."</td>" : '';				
	isset($_POST['sop1047']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_address_1'))."</td>" : '';
	isset($_POST['sop1048']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_address_2'))."</td>" : '';
	isset($_POST['sop1049']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_city'))."</td>" : '';
	isset($_POST['sop1050']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_zone'))."</td>" : '';
	isset($_POST['sop1051']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_postcode'))."</td>" : '';
	isset($_POST['sop1052']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_country'))."</td>" : '';
	isset($_POST['sop1053']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_customer_telephone')."</td>" : '';
	isset($_POST['sop1054']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_name'))."</td>" : '';
	isset($_POST['sop1055']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_company'))."</td>" : '';
	isset($_POST['sop1056']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_address_1'))."</td>" : '';
	isset($_POST['sop1057']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_address_2'))."</td>" : '';
	isset($_POST['sop1058']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_city'))."</td>" : '';
	isset($_POST['sop1059']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_zone'))."</td>" : '';
	isset($_POST['sop1060']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_postcode'))."</td>" : '';
	isset($_POST['sop1061']) ? $export_xls_all_details .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_country'))."</td>" : '';
	$export_xls_all_details .="</tr>";
	foreach ($results as $result) {	
	if ($result['product_pidc']) {
	$export_xls_all_details .="<tr>";
	$export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['order_ord_idc']."</td>";
	$export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['order_order_date']."</td>";
	$export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['order_inv_no']."</td>";
	isset($_POST['sop1001']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['order_name']."</td>" : '';
	isset($_POST['sop1002']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['order_email']."</td>" : '';	
	isset($_POST['sop1003']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['order_group']."</td>" : '';	
	isset($_POST['sop1004']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['product_pidc']."</td>" : '';
	isset($_POST['sop1005']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['product_sku']."</td>" : '';
	isset($_POST['sop1006']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['product_model']."</td>" : '';	
	isset($_POST['sop1007']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['product_name']."</td>" : '';
	isset($_POST['sop1008']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['product_option']."</td>" : '';
	isset($_POST['sop1009']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['product_attributes']."</td>" : '';
	isset($_POST['sop1010']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['product_manu']."</td>" : '';
	isset($_POST['sop1011']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['product_category']."</td>" : '';	
	isset($_POST['sop1012']) ? $export_xls_all_details .= "<td align='right' valign='top' style='mso-ignore: colspan'>".$result['product_currency']."</td>" : '';
	isset($_POST['sop1013']) ? $export_xls_all_details .= "<td align='right' valign='top' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".$result['product_price']."</td>" : '';
	isset($_POST['sop1014']) ? $export_xls_all_details .= "<td align='right' valign='top' style='mso-ignore: colspan'>".$result['product_quantity']."</td>" : '';
	isset($_POST['sop1015']) ? $export_xls_all_details .= "<td align='right' valign='top' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".$result['product_tax']."</td>" : '';		
	isset($_POST['sop1016']) ? $export_xls_all_details .= "<td align='right' valign='top' style='background-color:#DCFFB9; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".$result['product_total']."</td>" : '';
	isset($_POST['sop1017']) ? $export_xls_all_details .= "<td align='right' valign='top' style='background-color:#ffd7d7; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>-".$result['product_costs']."</td>" : '';
	isset($_POST['sop1018']) ? $export_xls_all_details .= "<td align='right' valign='top' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".$result['product_profit']."</td>" : '';
	isset($_POST['sop1019']) ? $export_xls_all_details .= "<td align='right' valign='top' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan'>".$result['product_profit_margin_percent']."%</td>" : '';	
	isset($_POST['sop1020']) ? $export_xls_all_details .= "<td align='right' valign='top' style='color:#090; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_sub_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop1021']) ? $export_xls_all_details .= "<td align='right' valign='top' style='color:#090; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_handling'], 2, ',', ' ')."</td>" : '';	
	isset($_POST['sop1022']) ? $export_xls_all_details .= "<td align='right' valign='top' style='color:#090; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_low_order_fee'], 2, ',', ' ')."</td>" : '';	
	if ($this->config->get('adv_profit_reports_formula_sop1')) {
	isset($_POST['sop1023']) ? $export_xls_all_details .= "<td align='right' valign='top' style='color:#090; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_shipping'], 2, ',', ' ')."</td>" : '';
	} else {
	isset($_POST['sop1023']) ? $export_xls_all_details .= "<td align='right' valign='top' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_shipping'], 2, ',', ' ')."</td>" : '';
	}	
	isset($_POST['sop1024']) ? $export_xls_all_details .= "<td align='right' valign='top' style='color:#090; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_reward'], 2, ',', ' ')."</td>" : '';	
	isset($_POST['sop1025']) ? $export_xls_all_details .= "<td align='right' valign='top' style='color:#090; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_coupon'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop1026']) ? $export_xls_all_details .= "<td align='right' valign='top' style='mso-ignore: colspan'>".$result['order_coupon_code']."</td>" : '';
	isset($_POST['sop1027']) ? $export_xls_all_details .= "<td align='right' valign='top' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_tax'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop1028']) ? $export_xls_all_details .= "<td align='right' valign='top' style='color:#090; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_credit'], 2, ',', ' ')."</td>" : '';	
	isset($_POST['sop1029']) ? $export_xls_all_details .= "<td align='right' valign='top' style='color:#090; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_voucher'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop1030']) ? $export_xls_all_details .= "<td align='right' valign='top' style='mso-ignore: colspan'>".$result['order_voucher_code']."</td>" : '';	
	isset($_POST['sop1031']) ? $export_xls_all_details .= "<td align='right' valign='top' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_value'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop1032']) ? $export_xls_all_details .= "<td align='right' valign='top' style='background-color:#DCFFB9; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_sales'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop1033']) ? $export_xls_all_details .= "<td align='right' valign='top' style='color:#F00; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>-".number_format($result['order_product_costs'], 2, ',', ' ')."</td>" : '';	
	isset($_POST['sop1034']) ? $export_xls_all_details .= "<td align='right' valign='top' style='color:#F00; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>-".number_format($result['order_commission'], 2, ',', ' ')."</td>" : '';	
	if ($this->config->get('adv_profit_reports_formula_sop3')) {
	isset($_POST['sop1035']) ? $export_xls_all_details .= "<td align='right' valign='top' style='color:#F00; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>-".number_format($result['order_payment_cost'], 2, ',', ' ')."</td>" : '';
	} else {
	isset($_POST['sop1035']) ? $export_xls_all_details .= "<td align='right' valign='top' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>-".number_format($result['order_payment_cost'], 2, ',', ' ')."</td>" : '';
	}	
	if ($this->config->get('adv_profit_reports_formula_sop2')) {
	isset($_POST['sop1036']) ? $export_xls_all_details .= "<td align='right' valign='top' style='color:#F00; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>-".number_format($result['order_shipping_cost'], 2, ',', ' ')."</td>" : '';
	} else {
	isset($_POST['sop1036']) ? $export_xls_all_details .= "<td align='right' valign='top' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>-".number_format($result['order_shipping_cost'], 2, ',', ' ')."</td>" : '';
	}	
	isset($_POST['sop1037']) ? $export_xls_all_details .= "<td align='right' valign='top' style='background-color:#ffd7d7; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>-".number_format($result['order_costs'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop1038']) ? $export_xls_all_details .= "<td align='right' valign='top' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['order_profit'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop1039']) ? $export_xls_all_details .= "<td align='right' valign='top' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan;'>".$result['order_profit_margin_percent']."%</td>" : '';	
	isset($_POST['sop1040']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['order_shipping_method']."</td>" : '';
	isset($_POST['sop1041']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".strip_tags($result['order_payment_method'], '<br>')."</td>" : '';
	isset($_POST['sop1042']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['order_status']."</td>" : '';
	isset($_POST['sop1043']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['order_store']."</td>" : '';
	isset($_POST['sop1044']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['customer_cust_idc']."</td>" : '';	
	isset($_POST['sop1045']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['billing_name']."</td>" : '';
	isset($_POST['sop1046']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['billing_company']."</td>" : '';
	isset($_POST['sop1047']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['billing_address_1']."</td>" : '';
	isset($_POST['sop1048']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['billing_address_2']."</td>" : '';
	isset($_POST['sop1049']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['billing_city']."</td>" : '';
	isset($_POST['sop1050']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['billing_zone']."</td>" : '';
	isset($_POST['sop1051']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['billing_postcode']."</td>" : '';
	isset($_POST['sop1052']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['billing_country']."</td>" : '';
	isset($_POST['sop1053']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['customer_telephone']."</td>" : '';
	isset($_POST['sop1054']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['shipping_name']."</td>" : '';
	isset($_POST['sop1055']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['shipping_company']."</td>" : '';
	isset($_POST['sop1056']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['shipping_address_1']."</td>" : '';
	isset($_POST['sop1057']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['shipping_address_2']."</td>" : '';
	isset($_POST['sop1058']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['shipping_city']."</td>" : '';
	isset($_POST['sop1059']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['shipping_zone']."</td>" : '';
	isset($_POST['sop1060']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['shipping_postcode']."</td>" : '';
	isset($_POST['sop1061']) ? $export_xls_all_details .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['shipping_country']."</td>" : '';
	$export_xls_all_details .="</tr>";	
	}
	}
	$export_xls_all_details .="</table>";
	$export_xls_all_details .="</body></html>";

$filename = "sale_profit_report_all_details_".date("Y-m-d",time());
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');			
header('Content-Type: application/vnd.ms-excel; charset=UTF-8; encoding=UTF-8');			
header('Content-Disposition: attachment; filename='.$filename.".xls");
header('Content-Transfer-Encoding: UTF-8');
print $export_xls_all_details;			
exit;
?>