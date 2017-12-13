<?php
ini_set("memory_limit","256M");

	$export_xls_product_list ="<html><head>";
	$export_xls_product_list .="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	$export_xls_product_list .="</head>";
	$export_xls_product_list .="<body>";					
	$export_xls_product_list .="<table border='1'>";
	foreach ($results as $result) {	
	$export_xls_product_list .="<tr>";
	if ($filter_group == 'year') {				
	$export_xls_product_list .= "<td colspan='2' align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_year')."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_year')."</td>";					
	$export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_quarter')."</td>";				
	} elseif ($filter_group == 'month') {
	$export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_year')."</td>";					
	$export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_month')."</td>";
	} elseif ($filter_group == 'day') {
	$export_xls_product_list .= "<td colspan='2' align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_date')."</td>";
	} elseif ($filter_group == 'order') {
	$export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_order_order_id')."</td>";					
	$export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_order_date_added')."</td>";		
	} else {
	$export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_date_start')."</td>";				
	$export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_date_end')."</td>";	
	}
	isset($_POST['cop21']) ? $export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_customer')."</td>" : '';
	isset($_POST['cop20']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_id')."</td>" : '';
	isset($_POST['cop22']) ? $export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_email')."</td>" : '';
	isset($_POST['cop35']) ? $export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_telephone')."</td>" : '';		
	isset($_POST['cop34']) ? $export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_country')."</td>" : '';
	isset($_POST['cop23']) ? $export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_customer_group')."</td>" : '';
	isset($_POST['cop24']) ? $export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_status')."</td>" : '';
	isset($_POST['cop25']) ? $export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_ip')."</td>" : '';
	isset($_POST['cop26']) ? $export_xls_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_mostrecent')."</td>" : '';		
	isset($_POST['cop27']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_orders')."</td>" : '';
	isset($_POST['cop28']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_products')."</td>" : '';
	isset($_POST['cop30']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_value')."</td>" : '';	
	isset($_POST['cop29']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total_sales')."</td>" : '';	
	isset($_POST['cop31']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total_costs')."</td>" : '';
	isset($_POST['cop32']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total_profit')."</td>" : '';
	isset($_POST['cop33']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';							
	$export_xls_product_list .="</tr>";
	$export_xls_product_list .="<tr>";
	if ($filter_group == 'year') {				
	$export_xls_product_list .= "<td colspan='2' align='left' style='background-color:#F0F0F0;'>".$result['year']."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_xls_product_list .= "<td align='left' style='background-color:#F0F0F0;'>".$result['year']."</td>";
	$export_xls_product_list .= "<td align='left' style='background-color:#F0F0F0;'>".'Q' . $result['quarter']."</td>";						
	} elseif ($filter_group == 'month') {
	$export_xls_product_list .= "<td align='left' style='background-color:#F0F0F0;'>".$result['year']."</td>";
	$export_xls_product_list .= "<td align='left' style='background-color:#F0F0F0;'>".$result['month']."</td>";	
	} elseif ($filter_group == 'day') {
	$export_xls_product_list .= "<td colspan='2' align='left' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	} elseif ($filter_group == 'order') {
	$export_xls_product_list .= "<td align='left' style='background-color:#F0F0F0;'>".$result['order_id']."</td>";	
	$export_xls_product_list .= "<td align='left' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";		
	} else {
	$export_xls_product_list .= "<td align='left' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	$export_xls_product_list .= "<td align='left' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_end']))."</td>";	
	}
	isset($_POST['cop21']) ? $export_xls_product_list .= "<td align='left' style='color:#03C; font-weight:bold;'>".$result['cust_name']."</td>" : '';
	isset($_POST['cop20']) ? $export_xls_product_list .= "<td align='right'>".$result['customer_id']."</td>" : '';	
	isset($_POST['cop22']) ? $export_xls_product_list .= "<td align='left'>".$result['cust_email']."</td>" : '';
	isset($_POST['cop35']) ? $export_xls_product_list .= "<td align='left'>".$result['cust_telephone']."</td>" : '';	
	isset($_POST['cop34']) ? $export_xls_product_list .= "<td align='left'>".$result['cust_country']."</td>" : '';
	isset($_POST['cop23']) ? $export_xls_product_list .= "<td align='left'>" : '';
		if ($result['customer_id'] == 0) {
		isset($_POST['cop23']) ? $export_xls_product_list .= "".$result['cust_group_guest']."" : '';
		} else {
		isset($_POST['cop23']) ? $export_xls_product_list .= "".$result['cust_group_reg']."" : '';
		}
	isset($_POST['cop23']) ? $export_xls_product_list .= "</td>" : '';
	isset($_POST['cop24']) ? $export_xls_product_list .= "<td align='left'>" : '';
		if (!$result['customer_id'] == 0) {
		isset($_POST['cop23']) ? $export_xls_product_list .= "".($result['cust_status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'))."" : '';
		}
	isset($_POST['cop23']) ? $export_xls_product_list .= "</td>" : '';
	isset($_POST['cop26']) ? $export_xls_product_list .= "<td align='left'>".date($this->language->get('date_format_short'), strtotime($result['mostrecent']))."</td>" : '';		
	isset($_POST['cop27']) ? $export_xls_product_list .= "<td align='right'>".$result['orders']."</td>" : '';
	isset($_POST['cop27']) ? $export_xls_product_list .= "<td align='right'>".$result['orders']."</td>" : '';
	isset($_POST['cop28']) ? $export_xls_product_list .= "<td align='right'>".$result['products']."</td>" : '';
	isset($_POST['cop30']) ? $export_xls_product_list .= "<td align='right' style='mso-number-format:#\,\#\#0\.00'>".number_format($result['total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['cop29']) ? $export_xls_product_list .= "<td align='right' style='background-color:#DCFFB9; mso-number-format:#\,\#\#0\.00'>".number_format(($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']+($this->config->get('adv_profit_reports_formula_cop1') ? $result['shipping'] : 0)), 2, ',', ' ')."</td>" : '';
	isset($_POST['cop31']) ? $export_xls_product_list .= "<td align='right' style='background-color:#ffd7d7; mso-number-format:#\,\#\#0\.00'>".('-' . number_format(($result['prod_costs']+$result['commission']+($this->config->get('adv_profit_reports_formula_cop3') ? $result['payment_cost'] : 0)+($this->config->get('adv_profit_reports_formula_cop2') ? $result['shipping_cost'] : 0)), 2, ',', ' '))."</td>" : '';
	isset($_POST['cop32']) ? $export_xls_product_list .= "<td align='right' style='background-color:#c4d9ee; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format((($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']+($this->config->get('adv_profit_reports_formula_cop1') ? $result['shipping'] : 0))-($result['prod_costs']+$result['commission']+($this->config->get('adv_profit_reports_formula_cop3') ? $result['payment_cost'] : 0)+($this->config->get('adv_profit_reports_formula_cop2') ? $result['shipping_cost'] : 0))), 2, ',', ' ')."</td>" : '';
	if (number_format(($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']), 2, ',', ' ') > 0) {				
	isset($_POST['cop33']) ? $export_xls_product_list .= "<td align='right' style='background-color:#c4d9ee; font-weight:bold;'>".round(100 * ((($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']+($this->config->get('adv_profit_reports_formula_cop1') ? $result['shipping'] : 0))-($result['prod_costs']+$result['commission']+($this->config->get('adv_profit_reports_formula_cop3') ? $result['payment_cost'] : 0)+($this->config->get('adv_profit_reports_formula_cop2') ? $result['shipping_cost'] : 0))) / ($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']+($this->config->get('adv_profit_reports_formula_cop1') ? $result['shipping'] : 0))), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['cop33']) ? $export_xls_product_list .= "<td align='right' style='background-color:#c4d9ee; font-weight:bold;'>".'0%'."</td>" : '';
	}							
	$export_xls_product_list .="</tr>";
	$export_xls_product_list .="<tr>";
	$export_xls_product_list .= "<td colspan='2' style='mso-ignore: colspan'></td>";
	$count = isset($_POST['cop20'])+isset($_POST['cop21'])+isset($_POST['cop22'])+isset($_POST['cop35'])+isset($_POST['cop34'])+isset($_POST['cop23'])+isset($_POST['cop24'])+isset($_POST['cop25'])+isset($_POST['cop26'])+isset($_POST['cop27'])+isset($_POST['cop28'])+isset($_POST['cop30'])+isset($_POST['cop29'])+isset($_POST['cop31'])+isset($_POST['cop32'])+isset($_POST['cop33']);
	$export_xls_product_list .= "<td colspan='";
	$export_xls_product_list .= $count;
	$export_xls_product_list .="' align='center'>";
		$export_xls_product_list .="<table border='1'>";
		$export_xls_product_list .="<tr>";
		isset($_POST['cop60']) ? $export_xls_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_order_id')."</td>" : '';
		isset($_POST['cop61']) ? $export_xls_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_date_added')."</td>" : '';
		isset($_POST['cop62']) ? $export_xls_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_inv_no')."</td>" : '';
		isset($_POST['cop63']) ? $export_xls_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_id')."</td>" : '';
		isset($_POST['cop64']) ? $export_xls_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_sku')."</td>" : '';
		isset($_POST['cop65']) ? $export_xls_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_model')."</td>" : '';		
		isset($_POST['cop66']) ? $export_xls_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_name')."</td>" : '';
		isset($_POST['cop67']) ? $export_xls_product_list .= "<td colspan='2' align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_option')."</td>" : '';
		isset($_POST['cop77']) ? $export_xls_product_list .= "<td colspan='2' align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_attributes')."</td>" : '';		
		isset($_POST['cop68']) ? $export_xls_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_manu')."</td>" : '';
		isset($_POST['cop79']) ? $export_xls_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_category')."</td>" : '';
		isset($_POST['cop69']) ? $export_xls_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_currency')."</td>" : '';
		isset($_POST['cop70']) ? $export_xls_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_price')."</td>" : '';
		isset($_POST['cop71']) ? $export_xls_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_quantity')."</td>" : '';
		isset($_POST['cop73']) ? $export_xls_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_tax')."</td>" : '';
		isset($_POST['cop72']) ? $export_xls_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_total')."</td>" : '';
		isset($_POST['cop74']) ? $export_xls_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
		isset($_POST['cop75']) ? $export_xls_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_profit')."</td>" : '';
		isset($_POST['cop76']) ? $export_xls_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';
		$export_xls_product_list .="</tr>";
		$export_xls_product_list .="<tr>";
		isset($_POST['cop60']) ? $export_xls_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_ord_idc']."</td>" : '';
		isset($_POST['cop61']) ? $export_xls_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_order_date']."</td>" : '';
		isset($_POST['cop62']) ? $export_xls_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_inv_no']."</td>" : '';
		isset($_POST['cop63']) ? $export_xls_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_pidc']."</td>" : '';
		isset($_POST['cop64']) ? $export_xls_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_sku']."</td>" : '';
		isset($_POST['cop65']) ? $export_xls_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_model']."</td>" : '';		
		isset($_POST['cop66']) ? $export_xls_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_name']."</td>" : '';
		isset($_POST['cop67']) ? $export_xls_product_list .= "<td colspan='2' align='left' style='mso-ignore: colspan'>".$result['product_option']."</td>" : '';
		isset($_POST['cop77']) ? $export_xls_product_list .= "<td colspan='2' align='left' style='mso-ignore: colspan'>".$result['product_attributes']."</td>" : '';		
		isset($_POST['cop68']) ? $export_xls_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_manu']."</td>" : '';
		isset($_POST['cop79']) ? $export_xls_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_category']."</td>" : '';	
		isset($_POST['cop69']) ? $export_xls_product_list .= "<td align='right' style='mso-ignore: colspan'>".$result['product_currency']."</td>" : '';
		isset($_POST['cop70']) ? $export_xls_product_list .= "<td align='right' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".$result['product_price']."</td>" : '';
		isset($_POST['cop71']) ? $export_xls_product_list .= "<td align='right' style='mso-ignore: colspan'>".$result['product_quantity']."</td>" : '';
		isset($_POST['cop73']) ? $export_xls_product_list .= "<td align='right' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".$result['product_tax']."</td>" : '';
		isset($_POST['cop72']) ? $export_xls_product_list .= "<td align='right' style='background-color:#DCFFB9; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".$result['product_total']."</td>" : '';
		isset($_POST['cop74']) ? $export_xls_product_list .= "<td align='right' style='background-color:#ffd7d7; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>-".$result['product_costs']."</td>" : '';
		isset($_POST['cop75']) ? $export_xls_product_list .= "<td align='right' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".$result['product_profit']."</td>" : '';
		isset($_POST['cop76']) ? $export_xls_product_list .= "<td align='right' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan'>".$result['product_profit_margin_percent'] . '%'."</td>" : '';
		$export_xls_product_list .="</tr>";					
		$export_xls_product_list .="</table>";
	$export_xls_product_list .="</td>";
	$export_xls_product_list .="</tr>";					
	}
	$export_xls_product_list .="<tr>";
	$export_xls_product_list .= "<td colspan='2' style='background-color:#D8D8D8;'></td>";
	isset($_POST['cop21']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop20']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';	
	isset($_POST['cop22']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop35']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';	
	isset($_POST['cop34']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop23']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop24']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop25']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop26']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';		
	isset($_POST['cop27']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_orders')."</td>" : '';
	isset($_POST['cop28']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_products')."</td>" : '';
	isset($_POST['cop30']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_value')."</td>" : '';	
	isset($_POST['cop29']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total_sales')."</td>" : '';	
	isset($_POST['cop31']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total_costs')."</td>" : '';
	isset($_POST['cop32']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total_profit')."</td>" : '';
	isset($_POST['cop33']) ? $export_xls_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';				
	$export_xls_product_list .="</tr>";	
	$export_xls_product_list .="<tr>";
	$export_xls_product_list .= "<td colspan='2' align='right' style='background-color:#E7EFEF; font-weight:bold;'>".$this->language->get('text_filter_total')."</td>";
	isset($_POST['cop21']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop20']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop22']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop35']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';	
	isset($_POST['cop34']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop23']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop24']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop25']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['cop26']) ? $export_xls_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';	
	isset($_POST['cop27']) ? $export_xls_product_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".$result['orders_total']."</td>" : '';
	isset($_POST['cop28']) ? $export_xls_product_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".$result['products_total']."</td>" : '';
	isset($_POST['cop30']) ? $export_xls_product_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['value_total'], 2, ',', ' ')."</td>" : '';	
	isset($_POST['cop29']) ? $export_xls_product_list .= "<td align='right' style='background-color:#DCFFB9; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format(($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']+($this->config->get('adv_profit_reports_formula_cop1') ? $result['shipping_total'] : 0)), 2, ',', ' ')."</td>" : '';
	isset($_POST['cop31']) ? $export_xls_product_list .= "<td align='right' style='background-color:#ffd7d7; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".('-' . number_format(($result['prod_costs_total']+$result['commission_total']+($this->config->get('adv_profit_reports_formula_cop3') ? $result['pay_costs_total'] : 0)+($this->config->get('adv_profit_reports_formula_cop2') ? $result['ship_costs_total'] : 0)), 2, ',', ' '))."</td>" : '';
	isset($_POST['cop32']) ? $export_xls_product_list .= "<td align='right' style='background-color:#c4d9ee; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format((($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']+($this->config->get('adv_profit_reports_formula_cop1') ? $result['shipping_total'] : 0))-($result['prod_costs_total']+$result['commission_total']+($this->config->get('adv_profit_reports_formula_cop3') ? $result['pay_costs_total'] : 0)+($this->config->get('adv_profit_reports_formula_cop2') ? $result['ship_costs_total'] : 0))), 2, ',', ' ')."</td>" : '';
	if (number_format(($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']), 2, ',', ' ') > 0) {
	isset($_POST['cop33']) ? $export_xls_product_list .= "<td align='right' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".round(100 * ((($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']+($this->config->get('adv_profit_reports_formula_cop1') ? $result['shipping_total'] : 0))-($result['prod_costs_total']+$result['commission_total']+($this->config->get('adv_profit_reports_formula_cop3') ? $result['pay_costs_total'] : 0)+($this->config->get('adv_profit_reports_formula_cop2') ? $result['ship_costs_total'] : 0))) / ($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']+($this->config->get('adv_profit_reports_formula_cop1') ? $result['shipping_total'] : 0))), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['cop33']) ? $export_xls_product_list .= "<td align='right' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".'0%'."</td>" : '';	
	}
	$export_xls_product_list .="</tr></table>";	
	$export_xls_product_list .="</body></html>";

$filename = "customer_profit_report_product_list_".date("Y-m-d",time());
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');			
header('Content-Type: application/vnd.ms-excel; charset=UTF-8; encoding=UTF-8');			
header('Content-Disposition: attachment; filename='.$filename.".xls");
header('Content-Transfer-Encoding: UTF-8');
print $export_xls_product_list;			
exit;	
?>