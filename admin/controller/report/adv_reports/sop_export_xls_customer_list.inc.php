<?php
ini_set("memory_limit","256M");

	$export_xls_customer_list ="<html><head>";
	$export_xls_customer_list .="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	$export_xls_customer_list .="</head>";
	$export_xls_customer_list .="<body>";				
	$export_xls_customer_list .="<table border='1'>";
	foreach ($results as $result) {	
	$export_xls_customer_list .="<tr>";
	if ($filter_group == 'year') {				
	$export_xls_customer_list .= "<td colspan='2' align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_year')."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_xls_customer_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_year')."</td>";					
	$export_xls_customer_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_quarter')."</td>";				
	} elseif ($filter_group == 'month') {
	$export_xls_customer_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_year')."</td>";					
	$export_xls_customer_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_month')."</td>";
	} elseif ($filter_group == 'day') {
	$export_xls_customer_list .= "<td colspan='2' align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_date')."</td>";
	} elseif ($filter_group == 'order') {
	$export_xls_customer_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_order_order_id')."</td>";					
	$export_xls_customer_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_order_date_added')."</td>";	
	} else {
	$export_xls_customer_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_date_start')."</td>";				
	$export_xls_customer_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_date_end')."</td>";	
	}
	isset($_POST['sop20']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_orders')."</td>" : '';
	isset($_POST['sop21']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_customers')."</td>" : '';
	isset($_POST['sop22']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_products')."</td>" : '';
	isset($_POST['sop23']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_sub_total')."</td>" : '';
	isset($_POST['sop24']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_handling')."</td>" : '';
	isset($_POST['sop25']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_loworder')."</td>" : '';
	isset($_POST['sop27']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_shipping')."</td>" : '';	
	isset($_POST['sop26']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_reward')."</td>" : '';
	isset($_POST['sop28']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_coupon')."</td>" : '';
	isset($_POST['sop29']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_tax')."</td>" : '';
	isset($_POST['sop30']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_credit')."</td>" : '';
	isset($_POST['sop31']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_voucher')."</td>" : '';
	isset($_POST['sop33']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total')."</td>" : '';
	isset($_POST['sop37']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_sales')."</td>" : '';	
	isset($_POST['sop34']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
	isset($_POST['sop32']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_commission')."</td>" : '';
	isset($_POST['sop391']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_payment_cost')."</td>" : '';
	isset($_POST['sop392']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_shipping_cost')."</td>" : '';	
	isset($_POST['sop393']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_shipping_balance')."</td>" : '';
	isset($_POST['sop38']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total_costs')."</td>" : '';
	isset($_POST['sop35']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_net_profit')."</td>" : '';
	isset($_POST['sop36']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';					
	$export_xls_customer_list .="</tr>";	
	$export_xls_customer_list .="<tr>";
	if ($filter_group == 'year') {				
	$export_xls_customer_list .= "<td colspan='2' align='left' style='background-color:#F0F0F0;'>".$result['year']."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_xls_customer_list .= "<td align='left' style='background-color:#F0F0F0;'>".$result['year']."</td>";
	$export_xls_customer_list .= "<td align='left' style='background-color:#F0F0F0;'>".'Q' . $result['quarter']."</td>";						
	} elseif ($filter_group == 'month') {
	$export_xls_customer_list .= "<td align='left' style='background-color:#F0F0F0;'>".$result['year']."</td>";
	$export_xls_customer_list .= "<td align='left' style='background-color:#F0F0F0;'>".$result['month']."</td>";	
	} elseif ($filter_group == 'day') {
	$export_xls_customer_list .= "<td colspan='2' align='left' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	} elseif ($filter_group == 'order') {
	$export_xls_customer_list .= "<td align='left' style='background-color:#F0F0F0;'>".$result['order_id']."</td>";	
	$export_xls_customer_list .= "<td align='left' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";	
	} else {
	$export_xls_customer_list .= "<td align='left' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	$export_xls_customer_list .= "<td align='left' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_end']))."</td>";	
	}
	isset($_POST['sop20']) ? $export_xls_customer_list .= "<td align='right'>".$result['orders']."</td>" : '';
	isset($_POST['sop21']) ? $export_xls_customer_list .= "<td align='right'>".$result['customers']."</td>" : '';
	isset($_POST['sop22']) ? $export_xls_customer_list .= "<td align='right'>".$result['products']."</td>" : '';
	isset($_POST['sop23']) ? $export_xls_customer_list .= "<td align='right' style='color:#090; mso-number-format:#\,\#\#0\.00'>".number_format($result['sub_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop24']) ? $export_xls_customer_list .= "<td align='right' style='color:#090; mso-number-format:#\,\#\#0\.00'>".number_format($result['handling'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop25']) ? $export_xls_customer_list .= "<td align='right' style='color:#090; mso-number-format:#\,\#\#0\.00'>".number_format($result['low_order_fee'], 2, ',', ' ')."</td>" : '';
	if ($this->config->get('adv_profit_reports_formula_sop1')) {
	isset($_POST['sop27']) ? $export_xls_customer_list .= "<td align='right' style='color:#090; mso-number-format:#\,\#\#0\.00'>".number_format($result['shipping'], 2, ',', ' ')."</td>" : '';
	} else {
	isset($_POST['sop27']) ? $export_xls_customer_list .= "<td align='right' style='mso-number-format:#\,\#\#0\.00'>".number_format($result['shipping'], 2, ',', ' ')."</td>" : '';
	}
	isset($_POST['sop26']) ? $export_xls_customer_list .= "<td align='right' style='color:#090; mso-number-format:#\,\#\#0\.00'>".number_format($result['reward'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop28']) ? $export_xls_customer_list .= "<td align='right' style='color:#090; mso-number-format:#\,\#\#0\.00'>".number_format($result['coupon'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop29']) ? $export_xls_customer_list .= "<td align='right' style='mso-number-format:#\,\#\#0\.00'>".number_format($result['tax'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop30']) ? $export_xls_customer_list .= "<td align='right' style='color:#090; mso-number-format:#\,\#\#0\.00'>".number_format($result['credit'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop31']) ? $export_xls_customer_list .= "<td align='right' style='color:#090; mso-number-format:#\,\#\#0\.00'>".number_format($result['voucher'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop33']) ? $export_xls_customer_list .= "<td align='right' style='mso-number-format:#\,\#\#0\.00'>".number_format($result['total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop37']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#DCFFB9; mso-number-format:#\,\#\#0\.00'>".number_format(($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping'] : 0)), 2, ',', ' ')."</td>" : '';
	isset($_POST['sop34']) ? $export_xls_customer_list .= "<td align='right' style='color:#F00; mso-number-format:#\,\#\#0\.00'>".('-' . number_format($result['prod_costs'], 2, ',', ' '))."</td>" : '';
	isset($_POST['sop32']) ? $export_xls_customer_list .= "<td align='right' style='color:#F00; mso-number-format:#\,\#\#0\.00'>".number_format(-$result['commission'], 2, ',', ' ')."</td>" : '';
	if ($this->config->get('adv_profit_reports_formula_sop3')) {
	isset($_POST['sop391']) ? $export_xls_customer_list .= "<td align='right' style='color:#F00; mso-number-format:#\,\#\#0\.00'>".number_format(-$result['payment_cost'], 2, ',', ' ')."</td>" : '';
	} else {
	isset($_POST['sop391']) ? $export_xls_customer_list .= "<td align='right' style='mso-number-format:#\,\#\#0\.00'>".number_format(-$result['payment_cost'], 2, ',', ' ')."</td>" : '';
	}	
	if ($this->config->get('adv_profit_reports_formula_sop2')) {
	isset($_POST['sop392']) ? $export_xls_customer_list .= "<td align='right' style='color:#F00; mso-number-format:#\,\#\#0\.00'>".number_format(-$result['shipping_cost'], 2, ',', ' ')."</td>" : '';
	} else {
	isset($_POST['sop392']) ? $export_xls_customer_list .= "<td align='right' style='mso-number-format:#\,\#\#0\.00'>".number_format(-$result['shipping_cost'], 2, ',', ' ')."</td>" : '';
	}
	isset($_POST['sop393']) ? $export_xls_customer_list .= "<td align='right' style='mso-number-format:#\,\#\#0\.00'>".number_format(($result['shipping']-$result['shipping_cost']), 2, ',', ' ')."</td>" : '';	
	isset($_POST['sop38']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#ffd7d7; mso-number-format:#\,\#\#0\.00'>".('-' . number_format(($result['prod_costs']+$result['commission']+($this->config->get('adv_profit_reports_formula_sop3') ? $result['payment_cost'] : 0)+($this->config->get('adv_profit_reports_formula_sop2') ? $result['shipping_cost'] : 0)), 2, ',', ' '))."</td>" : '';
	isset($_POST['sop35']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#c4d9ee; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format((($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping'] : 0))-($result['prod_costs']+$result['commission']+($this->config->get('adv_profit_reports_formula_sop3') ? $result['payment_cost'] : 0)+($this->config->get('adv_profit_reports_formula_sop2') ? $result['shipping_cost'] : 0))), 2, ',', ' ')."</td>" : '';
	if (number_format(($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']), 2, ',', ' ') > 0) {				
	isset($_POST['sop36']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#c4d9ee; font-weight:bold;'>".round(100 * ((($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping'] : 0))-($result['prod_costs']+$result['commission']+($this->config->get('adv_profit_reports_formula_sop3') ? $result['payment_cost'] : 0)+($this->config->get('adv_profit_reports_formula_sop2') ? $result['shipping_cost'] : 0))) / ($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping'] : 0))), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['sop36']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#c4d9ee; font-weight:bold;'>".'0%'."</td>" : '';
	}						
	$export_xls_customer_list .="</tr>";
	$export_xls_customer_list .="<tr>";
	$export_xls_customer_list .= "<td colspan='2' style='mso-ignore: colspan'></td>";
	$count = isset($_POST['sop20'])+isset($_POST['sop21'])+isset($_POST['sop22'])+isset($_POST['sop23'])+isset($_POST['sop24'])+isset($_POST['sop25'])+isset($_POST['sop27'])+isset($_POST['sop26'])+isset($_POST['sop28'])+isset($_POST['sop29'])+isset($_POST['sop30'])+isset($_POST['sop31'])+isset($_POST['sop33'])+isset($_POST['sop37'])+isset($_POST['sop34'])+isset($_POST['sop32'])+isset($_POST['sop391'])+isset($_POST['sop392'])+isset($_POST['sop393'])+isset($_POST['sop38'])+isset($_POST['sop35'])+isset($_POST['sop36']);
	$export_xls_customer_list .= "<td colspan='";
	$export_xls_customer_list .= $count;
	$export_xls_customer_list .="' align='center'>";
		$export_xls_customer_list .="<table border='1'>";
		$export_xls_customer_list .="<tr>";
		isset($_POST['sop80']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_customer_order_id')."</td>" : '';
		isset($_POST['sop81']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_customer_date_added')."</td>" : '';
		isset($_POST['sop82']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_customer_inv_no')."</td>" : '';	
		isset($_POST['sop83']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_customer_cust_id')."</td>" : '';
		isset($_POST['sop84']) ? $export_xls_customer_list .= "<td colspan='2' align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_name'))."</td>" : '';
		isset($_POST['sop85']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_company'))."</td>" : '';				
		isset($_POST['sop86']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_address_1'))."</td>" : '';
		isset($_POST['sop87']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_address_2'))."</td>" : '';
		isset($_POST['sop88']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_city'))."</td>" : '';
		isset($_POST['sop89']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_zone'))."</td>" : '';
		isset($_POST['sop90']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_postcode'))."</td>" : '';
		isset($_POST['sop91']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_billing_country'))."</td>" : '';
		isset($_POST['sop92']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_customer_telephone')."</td>" : '';
		isset($_POST['sop93']) ? $export_xls_customer_list .= "<td colspan='2' align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_name'))."</td>" : '';		
		isset($_POST['sop94']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_company'))."</td>" : '';
		isset($_POST['sop95']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_address_1'))."</td>" : '';
		isset($_POST['sop96']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_address_2'))."</td>" : '';
		isset($_POST['sop97']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_city'))."</td>" : '';
		isset($_POST['sop98']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_zone'))."</td>" : '';
		isset($_POST['sop99']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_postcode'))."</td>" : '';
		isset($_POST['sop100']) ? $export_xls_customer_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".strip_tags($this->language->get('column_shipping_country'))."</td>" : '';				
		$export_xls_customer_list .="</tr>";
		$export_xls_customer_list .="<tr>";
		isset($_POST['sop80']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['customer_ord_idc']."</td>" : '';
		isset($_POST['sop81']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['customer_order_date']."</td>" : '';
		isset($_POST['sop82']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['customer_inv_no']."</td>" : '';	
		isset($_POST['sop83']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['customer_cust_idc']."</td>" : '';
		isset($_POST['sop84']) ? $export_xls_customer_list .= "<td colspan='2' align='left' style='mso-ignore: colspan'>".$result['billing_name']."</td>" : '';
		isset($_POST['sop85']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['billing_company']."</td>" : '';
		isset($_POST['sop86']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['billing_address_1']."</td>" : '';
		isset($_POST['sop87']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['billing_address_2']."</td>" : '';
		isset($_POST['sop88']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['billing_city']."</td>" : '';
		isset($_POST['sop89']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['billing_zone']."</td>" : '';
		isset($_POST['sop90']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['billing_postcode']."</td>" : '';
		isset($_POST['sop91']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['billing_country']."</td>" : '';
		isset($_POST['sop92']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['customer_telephone']."</td>" : '';
		isset($_POST['sop93']) ? $export_xls_customer_list .= "<td colspan='2' align='left' style='mso-ignore: colspan'>".$result['shipping_name']."</td>" : '';
		isset($_POST['sop94']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['shipping_company']."</td>" : '';
		isset($_POST['sop95']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['shipping_address_1']."</td>" : '';
		isset($_POST['sop96']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['shipping_address_2']."</td>" : '';
		isset($_POST['sop97']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['shipping_city']."</td>" : '';
		isset($_POST['sop98']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['shipping_zone']."</td>" : '';
		isset($_POST['sop99']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['shipping_postcode']."</td>" : '';
		isset($_POST['sop100']) ? $export_xls_customer_list .= "<td align='left' style='mso-ignore: colspan'>".$result['shipping_country']."</td>" : '';
		$export_xls_customer_list .="</tr>";					
		$export_xls_customer_list .="</table>";
	$export_xls_customer_list .="</td>";
	$export_xls_customer_list .="</tr>";					
	}
	$export_xls_customer_list .="<tr>";
	$export_xls_customer_list .= "<td colspan='2' style='background-color:#D8D8D8;'></td>";
	isset($_POST['sop20']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_orders')."</td>" : '';
	isset($_POST['sop21']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_customers')."</td>" : '';
	isset($_POST['sop22']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_products')."</td>" : '';
	isset($_POST['sop23']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_sub_total')."</td>" : '';
	isset($_POST['sop24']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_handling')."</td>" : '';
	isset($_POST['sop25']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_loworder')."</td>" : '';
	isset($_POST['sop27']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_shipping')."</td>" : '';	
	isset($_POST['sop26']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_reward')."</td>" : '';
	isset($_POST['sop28']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_coupon')."</td>" : '';
	isset($_POST['sop29']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_tax')."</td>" : '';
	isset($_POST['sop30']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_credit')."</td>" : '';
	isset($_POST['sop31']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_voucher')."</td>" : '';
	isset($_POST['sop33']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total')."</td>" : '';
	isset($_POST['sop37']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_sales')."</td>" : '';	
	isset($_POST['sop34']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
	isset($_POST['sop32']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_commission')."</td>" : '';
	isset($_POST['sop391']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_payment_cost')."</td>" : '';
	isset($_POST['sop392']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_shipping_cost')."</td>" : '';	
	isset($_POST['sop393']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_shipping_balance')."</td>" : '';
	isset($_POST['sop38']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total_costs')."</td>" : '';
	isset($_POST['sop35']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_net_profit')."</td>" : '';
	isset($_POST['sop36']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';					
	$export_xls_customer_list .="</tr>";		
	$export_xls_customer_list .="<tr>";
	$export_xls_customer_list .= "<td colspan='2' align='right' style='background-color:#E7EFEF; font-weight:bold;'>".$this->language->get('text_filter_total')."</td>";
	isset($_POST['sop20']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".$result['orders_total']."</td>" : '';
	isset($_POST['sop21']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".$result['customers_total']."</td>" : '';
	isset($_POST['sop22']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".$result['products_total']."</td>" : '';
	isset($_POST['sop23']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['sub_total_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop24']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['handling_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop25']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['low_order_fee_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop27']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['shipping_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop26']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['reward_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop28']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['coupon_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop29']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['tax_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop30']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['credit_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop31']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['voucher_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop33']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['total_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop37']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#DCFFB9; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format(($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping_total'] : 0)), 2, ',', ' ')."</td>" : '';
	isset($_POST['sop34']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".('-' . number_format($result['prod_costs_total'], 2, ',', ' '))."</td>" : '';
	isset($_POST['sop32']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format(-$result['commission_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop391']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format(-$result['pay_costs_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop392']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format(-$result['ship_costs_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['sop393']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format(($result['shipping_total']-$result['ship_costs_total']), 2, ',', ' ')."</td>" : '';
	isset($_POST['sop38']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#ffd7d7; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".('-' . number_format(($result['prod_costs_total']+$result['commission_total']+($this->config->get('adv_profit_reports_formula_sop3') ? $result['pay_costs_total'] : 0)+($this->config->get('adv_profit_reports_formula_sop2') ? $result['ship_costs_total'] : 0)), 2, ',', ' '))."</td>" : '';
	isset($_POST['sop35']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#c4d9ee; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format((($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping_total'] : 0))-($result['prod_costs_total']+$result['commission_total']+($this->config->get('adv_profit_reports_formula_sop3') ? $result['pay_costs_total'] : 0)+($this->config->get('adv_profit_reports_formula_sop2') ? $result['ship_costs_total'] : 0))), 2, ',', ' ')."</td>" : '';
	if (number_format(($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']), 2, ',', ' ') > 0) {
	isset($_POST['sop36']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".round(100 * ((($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping_total'] : 0))-($result['prod_costs_total']+$result['commission_total']+($this->config->get('adv_profit_reports_formula_sop3') ? $result['pay_costs_total'] : 0)+($this->config->get('adv_profit_reports_formula_sop2') ? $result['ship_costs_total'] : 0))) / ($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping_total'] : 0))), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['sop36']) ? $export_xls_customer_list .= "<td align='right' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".'0%'."</td>" : '';	
	}
	$export_xls_customer_list .="</tr></table>";
	$export_xls_customer_list .="</body></html>";

$filename = "sale_profit_report_customer_list_".date("Y-m-d",time());
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');			
header('Content-Type: application/vnd.ms-excel; charset=UTF-8; encoding=UTF-8');			
header('Content-Disposition: attachment; filename='.$filename.".xls");
header('Content-Transfer-Encoding: UTF-8');
print $export_xls_customer_list;			
exit;
?>