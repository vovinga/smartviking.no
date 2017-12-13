<?php
ini_set("memory_limit","256M");
			
	$export_xls_cat_product_list ="<html><head>";
	$export_xls_cat_product_list .="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	$export_xls_cat_product_list .="</head>";
	$export_xls_cat_product_list .="<body>";					
	$export_xls_cat_product_list .="<table border='1'>";
	foreach ($results as $result) {		
	$export_xls_cat_product_list .="<tr>";
	if ($filter_group == 'year') {				
	$export_xls_cat_product_list .= "<td colspan='2' align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_year')."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_xls_cat_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_year')."</td>";					
	$export_xls_cat_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_quarter')."</td>";				
	} elseif ($filter_group == 'month') {
	$export_xls_cat_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_year')."</td>";					
	$export_xls_cat_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_month')."</td>";
	} elseif ($filter_group == 'day') {
	$export_xls_cat_product_list .= "<td colspan='2' align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_date')."</td>";
	} elseif ($filter_group == 'order') {
	$export_xls_cat_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_order_prod_order_id')."</td>";					
	$export_xls_cat_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_order_prod_date_added')."</td>";	
	} else {
	$export_xls_cat_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_date_start')."</td>";				
	$export_xls_cat_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_date_end')."</td>";
	}
	isset($_POST['ppp24']) ? $export_xls_cat_product_list .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_category')."</td>" : '';
	isset($_POST['ppp27']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_sold_quantity')."</td>" : '';
	isset($_POST['ppp28']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_sold_percent')."</td>" : '';
	isset($_POST['ppp30']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_tax')."</td>" : '';
	isset($_POST['ppp29']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total')."</td>" : '';
	isset($_POST['ppp31']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
	isset($_POST['ppp32']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_prod_profit')."</td>" : '';
	isset($_POST['ppp33']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';
	$export_xls_cat_product_list .="</tr>";

	$this->load->model('catalog/product');
	$cat =  $this->model_catalog_product->getProductCategories($result['product_id']);
	$categories = $this->model_report_adv_product_profit->getProductsCategories(0);
		
	$export_xls_cat_product_list .="<tr>";
	if ($filter_group == 'year') {				
	$export_xls_cat_product_list .= "<td colspan='2' align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".$result['year']."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_xls_cat_product_list .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".$result['year']."</td>";
	$export_xls_cat_product_list .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".'Q' . $result['quarter']."</td>";					
	} elseif ($filter_group == 'month') {
	$export_xls_cat_product_list .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".$result['year']."</td>";
	$export_xls_cat_product_list .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".$result['month']."</td>";
	} elseif ($filter_group == 'day') {
	$export_xls_cat_product_list .= "<td colspan='2' align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	} elseif ($filter_group == 'order') {
	$export_xls_cat_product_list .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".$result['order_id']."</td>";	
	$export_xls_cat_product_list .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";	
	} else {
	$export_xls_cat_product_list .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	$export_xls_cat_product_list .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".date($this->language->get('date_format_short'), strtotime($result['date_end']))."</td>";	
	}
	isset($_POST['ppp24']) ? $export_xls_cat_product_list .= "<td align='left' valign='top' style='color:#03C; mso-ignore: colspan'>" : '';
		foreach ($categories as $category) {
			if (in_array($category['category_id'], $cat)) {
			isset($_POST['ppp24']) ? $export_xls_cat_product_list .= "<strong>".$category['name']."</strong><br>" : '';
			}
		}
	isset($_POST['ppp24']) ? $export_xls_cat_product_list .= "</td>" : '';
	isset($_POST['ppp27']) ? $export_xls_cat_product_list .= "<td align='right' valign='top' style='background-color:#FFC; mso-ignore: colspan'>".$result['sold_quantity']."</td>" : '';
	if (!is_null($result['sold_quantity'])) {
	isset($_POST['ppp28']) ? $export_xls_cat_product_list .= "<td align='right' valign='top' style='background-color:#FFC; mso-ignore: colspan'>".round(100 * ($result['sold_quantity'] / $result['sold_quantity_total']), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['ppp28']) ? $export_xls_cat_product_list .= "<td align='right' valign='top' style='background-color:#FFC; mso-ignore: colspan'>".'0%'."</td>" : '';
	}										
	isset($_POST['ppp30']) ? $export_xls_cat_product_list .= "<td align='right' valign='top' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['tax'], 2, ',', ' ')."</td>" : '';
	isset($_POST['ppp29']) ? $export_xls_cat_product_list .= "<td align='right' valign='top' style='background-color:#DCFFB9; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['prod_sales'], 2, ',', ' ')."</td>" : '';
	isset($_POST['ppp31']) ? $export_xls_cat_product_list .= "<td align='right' valign='top' style='background-color:#ffd7d7; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".('-' . number_format($result['prod_costs'], 2, ',', ' '))."</td>" : '';
	isset($_POST['ppp32']) ? $export_xls_cat_product_list .= "<td align='right' valign='top' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['prod_profit'], 2, ',', ' ')."</td>" : '';
	if (($result['prod_costs']+$result['prod_profit']) > 0) {				
	isset($_POST['ppp33']) ? $export_xls_cat_product_list .= "<td align='right' valign='top' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan'>".round(100 * ($result['prod_profit']) / ($result['prod_costs']+$result['prod_profit']), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['ppp33']) ? $export_xls_cat_product_list .= "<td align='right' valign='top' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan'>".'0%'."</td>" : '';
	}	
	$export_xls_cat_product_list .="</tr>";
	$export_xls_cat_product_list .="<tr>";
	$export_xls_cat_product_list .= "<td colspan='2' style='mso-ignore: colspan'></td>";
	$count = isset($_POST['ppp24'])+isset($_POST['ppp27'])+isset($_POST['ppp28'])+isset($_POST['ppp30'])+isset($_POST['ppp29'])+isset($_POST['ppp31'])+isset($_POST['ppp32'])+isset($_POST['ppp33']);
	$export_xls_cat_product_list .= "<td colspan='";
	$export_xls_cat_product_list .= $count;
	$export_xls_cat_product_list .="' align='center'>";					
		$export_xls_cat_product_list .="<table border='1'>";
		$export_xls_cat_product_list .="<tr>";
		isset($_POST['ppp60']) ? $export_xls_cat_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_order_id')."</td>" : '';
		isset($_POST['ppp61']) ? $export_xls_cat_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_date_added')."</td>" : '';
		isset($_POST['ppp62']) ? $export_xls_cat_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_inv_no')."</td>" : '';
		isset($_POST['ppp63']) ? $export_xls_cat_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_id')."</td>" : '';
		isset($_POST['ppp64']) ? $export_xls_cat_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_sku')."</td>" : '';
		isset($_POST['ppp65']) ? $export_xls_cat_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_model')."</td>" : '';
		isset($_POST['ppp66']) ? $export_xls_cat_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_name')."</td>" : '';
		isset($_POST['ppp67']) ? $export_xls_cat_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_option')."</td>" : '';
		isset($_POST['ppp77']) ? $export_xls_cat_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_attributes')."</td>" : '';
		isset($_POST['ppp68']) ? $export_xls_cat_product_list .= "<td align='left' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_manu')."</td>" : '';
		isset($_POST['ppp69']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_currency')."</td>" : '';
		isset($_POST['ppp70']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_price')."</td>" : '';
		isset($_POST['ppp71']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_quantity')."</td>" : '';
		isset($_POST['ppp73']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_tax')."</td>" : '';
		isset($_POST['ppp72']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_total')."</td>" : '';
		isset($_POST['ppp74']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
		isset($_POST['ppp75']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_prod_profit')."</td>" : '';
		isset($_POST['ppp76']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#EFEFEF; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';
		$export_xls_cat_product_list .="</tr>";
		$export_xls_cat_product_list .="<tr>";
		isset($_POST['ppp60']) ? $export_xls_cat_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_ord_idc']."</td>" : '';
		isset($_POST['ppp61']) ? $export_xls_cat_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_order_date']."</td>" : '';
		isset($_POST['ppp62']) ? $export_xls_cat_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_inv_no']."</td>" : '';
		isset($_POST['ppp63']) ? $export_xls_cat_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_pidc']."</td>" : '';
		isset($_POST['ppp64']) ? $export_xls_cat_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_sku']."</td>" : '';
		isset($_POST['ppp65']) ? $export_xls_cat_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_model']."</td>" : '';
		isset($_POST['ppp66']) ? $export_xls_cat_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_name']."</td>" : '';
		isset($_POST['ppp67']) ? $export_xls_cat_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_option']."</td>" : '';
		isset($_POST['ppp77']) ? $export_xls_cat_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_attributes']."</td>" : '';
		isset($_POST['ppp68']) ? $export_xls_cat_product_list .= "<td align='left' style='mso-ignore: colspan'>".$result['product_manu']."</td>" : '';
		isset($_POST['ppp69']) ? $export_xls_cat_product_list .= "<td align='right' style='mso-ignore: colspan'>".$result['product_currency']."</td>" : '';
		isset($_POST['ppp70']) ? $export_xls_cat_product_list .= "<td align='right' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".$result['product_price']."</td>" : '';
		isset($_POST['ppp71']) ? $export_xls_cat_product_list .= "<td align='right' style='mso-ignore: colspan'>".$result['product_quantity']."</td>" : '';
		isset($_POST['ppp73']) ? $export_xls_cat_product_list .= "<td align='right' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".$result['product_tax']."</td>" : '';
		isset($_POST['ppp72']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#DCFFB9; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".$result['product_total']."</td>" : '';
		isset($_POST['ppp74']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#ffd7d7; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>-".$result['product_costs']."</td>" : '';
		isset($_POST['ppp75']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".$result['product_profit']."</td>" : '';
		isset($_POST['ppp76']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan'>".$result['product_profit_margin_percent'] . '%'."</td>" : '';
		$export_xls_cat_product_list .="</tr>";					
		$export_xls_cat_product_list .="</table>";
	$export_xls_cat_product_list .="</td>";
	$export_xls_cat_product_list .="</tr>";					
	}
	$export_xls_cat_product_list .="<tr>";
	$export_xls_cat_product_list .= "<td colspan='2' style='background-color:#D8D8D8;'></td>";
	isset($_POST['ppp24']) ? $export_xls_cat_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['ppp27']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_sold_quantity')."</td>" : '';
	isset($_POST['ppp28']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_sold_percent')."</td>" : '';
	isset($_POST['ppp30']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_tax')."</td>" : '';
	isset($_POST['ppp29']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total')."</td>" : '';
	isset($_POST['ppp31']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
	isset($_POST['ppp32']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_prod_profit')."</td>" : '';
	isset($_POST['ppp33']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';				
	$export_xls_cat_product_list .="</tr>";	
	$export_xls_cat_product_list .="<tr>";
	$export_xls_cat_product_list .= "<td colspan='2' align='right' style='background-color:#E7EFEF; font-weight:bold;'>".$this->language->get('text_filter_total')."</td>";
	isset($_POST['ppp24']) ? $export_xls_cat_product_list .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['ppp27']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".$result['sold_quantity_total']."</td>" : '';
	if (!is_null($result['sold_quantity'])) {
	isset($_POST['ppp28']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".'100%'."</td>" : '';
	} else {
	isset($_POST['ppp28']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".'0%'."</td>" : '';
	}	
	isset($_POST['ppp30']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['tax_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['ppp29']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#DCFFB9; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['sales_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['ppp31']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#ffd7d7; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".('-' . number_format($result['costs_total'], 2, ',', ' '))."</td>" : '';
	isset($_POST['ppp32']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#c4d9ee; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['profit_total'], 2, ',', ' ')."</td>" : '';
	if (number_format(($result['costs_total']+$result['profit_total']), 2, ',', ' ') > 0) {
	isset($_POST['ppp33']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".round(100 * ($result['profit_total']) / ($result['costs_total']+$result['profit_total']), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['ppp33']) ? $export_xls_cat_product_list .= "<td align='right' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".'0%'."</td>" : '';	
	}
	$export_xls_cat_product_list .="</tr></table>";	
	$export_xls_cat_product_list .="</body></html>";

$filename = "category_profit_report_product_list_".date("Y-m-d",time());
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');			
header('Content-Type: application/vnd.ms-excel; charset=UTF-8; encoding=UTF-8');			
header('Content-Disposition: attachment; filename='.$filename.".xls");
header('Content-Transfer-Encoding: UTF-8');
print $export_xls_cat_product_list;			
exit;
?>