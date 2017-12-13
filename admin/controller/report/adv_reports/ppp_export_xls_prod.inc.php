<?php
ini_set("memory_limit","256M");
			
	$export_xls_prod ="<html><head>";
	$export_xls_prod .="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	$export_xls_prod .="</head>";
	$export_xls_prod .="<body>";					
	$export_xls_prod .="<table border='1'>";	
	$export_xls_prod .="<tr>";
	if ($filter_group == 'year') {				
	$export_xls_prod .= "<td colspan='2' align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_year')."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_year')."</td>";					
	$export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_quarter')."</td>";				
	} elseif ($filter_group == 'month') {
	$export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_year')."</td>";					
	$export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_month')."</td>";
	} elseif ($filter_group == 'day') {
	$export_xls_prod .= "<td colspan='2' align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_date')."</td>";
	} elseif ($filter_group == 'order') {
	$export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_order_prod_order_id')."</td>";					
	$export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_order_prod_date_added')."</td>";	
	} else {
	$export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_date_start')."</td>";				
	$export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_date_end')."</td>";
	}
	isset($_POST['ppp22']) ? $export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_name')."</td>" : '';
	isset($_POST['ppp21']) ? $export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_sku')."</td>" : '';	
	isset($_POST['ppp23']) ? $export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_model')."</td>" : '';
	isset($_POST['ppp24']) ? $export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_category')."</td>" : '';
	isset($_POST['ppp25']) ? $export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_manufacturer')."</td>" : '';
	isset($_POST['ppp34']) ? $export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_attribute')."</td>" : '';
	isset($_POST['ppp26']) ? $export_xls_prod .= "<td align='left' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_status')."</td>" : '';
	isset($_POST['ppp35']) ? $export_xls_prod .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_stock_quantity')."</td>" : '';
	isset($_POST['ppp27']) ? $export_xls_prod .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_sold_quantity')."</td>" : '';
	isset($_POST['ppp28']) ? $export_xls_prod .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_sold_percent')."</td>" : '';
	isset($_POST['ppp30']) ? $export_xls_prod .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_tax')."</td>" : '';
	isset($_POST['ppp29']) ? $export_xls_prod .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_total')."</td>" : '';
	isset($_POST['ppp31']) ? $export_xls_prod .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
	isset($_POST['ppp32']) ? $export_xls_prod .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_prod_profit')."</td>" : '';
	isset($_POST['ppp33']) ? $export_xls_prod .= "<td align='right' style='background-color:#D8D8D8; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';
	$export_xls_prod .="</tr>";
	foreach ($results as $result) {
		
	$this->load->model('catalog/product');
	$cat =  $this->model_catalog_product->getProductCategories($result['product_id']);
	$manu = $this->model_report_adv_product_profit->getProductManufacturers($result['manufacturer_id']);	
	$manufacturers = $this->model_report_adv_product_profit->getProductsManufacturers();
	$categories = $this->model_report_adv_product_profit->getProductsCategories(0); 
			
	$export_xls_prod .="<tr>";
	if ($filter_group == 'year') {				
	$export_xls_prod .= "<td colspan='2' align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".$result['year']."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_xls_prod .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".$result['year']."</td>";
	$export_xls_prod .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".'Q' . $result['quarter']."</td>";					
	} elseif ($filter_group == 'month') {
	$export_xls_prod .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".$result['year']."</td>";
	$export_xls_prod .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".$result['month']."</td>";
	} elseif ($filter_group == 'day') {
	$export_xls_prod .= "<td colspan='2' align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	} elseif ($filter_group == 'order') {
	$export_xls_prod .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".$result['order_id']."</td>";	
	$export_xls_prod .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";	
	} else {
	$export_xls_prod .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	$export_xls_prod .= "<td align='left' valign='top' style='background-color:#F0F0F0; mso-ignore: colspan'>".date($this->language->get('date_format_short'), strtotime($result['date_end']))."</td>";	
	}
	isset($_POST['ppp22']) ? $export_xls_prod .= "<td align='left' valign='top' style='color:#03C; font-weight:bold; mso-ignore: colspan'>".$result['name']."" : '';
	if ($filter_ogrouping) {
	if ($result['oovalue']) {			
	isset($_POST['ppp22']) ? $export_xls_prod .= "<table border='0' cellpadding='0' cellspacing='0'><tr>" : '';
	isset($_POST['ppp22']) ? $export_xls_prod .= "<td style='color:#03C;'>".$result['ooname'].":</td>" : '';
	isset($_POST['ppp22']) ? $export_xls_prod .= "<td style='color:#03C;'>".$result['oovalue']."</td>" : '';
	isset($_POST['ppp22']) ? $export_xls_prod .= "</tr></table>" : '';
	}
	}		
	isset($_POST['ppp22']) ? $export_xls_prod .= "</td>" : '';	
	isset($_POST['ppp21']) ? $export_xls_prod .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['sku']."</td>" : '';		
	isset($_POST['ppp23']) ? $export_xls_prod .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['model']."</td>" : '';
	isset($_POST['ppp24']) ? $export_xls_prod .= "<td align='left' valign='top' style='mso-ignore: colspan'>" : '';
		foreach ($categories as $category) {
			if (in_array($category['category_id'], $cat)) {
			isset($_POST['ppp24']) ? $export_xls_prod .= "".$category['name']."<br>" : '';
			}
		}
	isset($_POST['ppp24']) ? $export_xls_prod .= "</td>" : '';
	isset($_POST['ppp25']) ? $export_xls_prod .= "<td align='left' valign='top' style='mso-ignore: colspan'>" : '';
		foreach ($manufacturers as $manufacturer) {
			if (in_array($manufacturer['manufacturer_id'], $manu)) {
			isset($_POST['ppp25']) ? $export_xls_prod .= "".$manufacturer['name']."" : '';
			}
		}
	isset($_POST['ppp25']) ? $export_xls_prod .= "</td>" : '';
	isset($_POST['ppp34']) ? $export_xls_prod .= "<td align='left' valign='top' style='mso-ignore: colspan'>".$result['attribute']."</td>" : '';
	isset($_POST['ppp26']) ? $export_xls_prod .= "<td align='left' valign='top' style='mso-ignore: colspan'>".($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'))."</td>" : '';
	isset($_POST['ppp35']) ? $export_xls_prod .= "<td align='right' valign='top' style='mso-ignore: colspan'>" : '';	
	if ($result['stock_quantity'] <= 0) {
	isset($_POST['ppp35']) ? $export_xls_prod .= "<span style='color:#FF0000;'>".$result['stock_quantity']."</span>" : '';
	} elseif ($result['stock_quantity'] <= 5) {
	isset($_POST['ppp35']) ? $export_xls_prod .= "<span style='color:#FFA500;'>".$result['stock_quantity']."</span>" : '';
	} else {
	isset($_POST['ppp35']) ? $export_xls_prod .= "<span>".$result['stock_quantity']."</span>" : '';
	}
	if ($filter_ogrouping) {	
	if ($result['oovalue']) {	
	if ($result['stock_oquantity'] <= 0) {
	isset($_POST['ppp35']) ? $export_xls_prod .= "<br><span style='color:#FF0000;'>".$result['stock_oquantity']."</span>" : '';
	} elseif ($result['stock_oquantity'] <= 5) {
	isset($_POST['ppp35']) ? $export_xls_prod .= "<br><span style='color:#FFA500;'>".$result['stock_oquantity']."</span>" : '';
	} else {
	isset($_POST['ppp35']) ? $export_xls_prod .= "<br><span>".$result['stock_oquantity']."</span>" : '';
	}
	}
	}	
	isset($_POST['ppp35']) ? $export_xls_prod .= "</td>" : '';
	isset($_POST['ppp27']) ? $export_xls_prod .= "<td align='right' valign='top' style='background-color:#FFC; mso-ignore: colspan'>".$result['sold_quantity']."</td>" : '';
	if (!is_null($result['sold_quantity'])) {
	isset($_POST['ppp28']) ? $export_xls_prod .= "<td align='right' valign='top' style='background-color:#FFC; mso-ignore: colspan'>".round(100 * ($result['sold_quantity'] / $result['sold_quantity_total']), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['ppp28']) ? $export_xls_prod .= "<td align='right' valign='top' style='background-color:#FFC; mso-ignore: colspan'>".'0%'."</td>" : '';
	}										
	isset($_POST['ppp30']) ? $export_xls_prod .= "<td align='right' valign='top' style='mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['tax'], 2, ',', ' ')."</td>" : '';
	isset($_POST['ppp29']) ? $export_xls_prod .= "<td align='right' valign='top' style='background-color:#DCFFB9; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['prod_sales'], 2, ',', ' ')."</td>" : '';
	isset($_POST['ppp31']) ? $export_xls_prod .= "<td align='right' valign='top' style='background-color:#ffd7d7; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".('-' . number_format($result['prod_costs'], 2, ',', ' '))."</td>" : '';
	isset($_POST['ppp32']) ? $export_xls_prod .= "<td align='right' valign='top' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan; mso-number-format:#\,\#\#0\.00'>".number_format($result['prod_profit'], 2, ',', ' ')."</td>" : '';
	if (($result['prod_costs']+$result['prod_profit']) > 0) {				
	isset($_POST['ppp33']) ? $export_xls_prod .= "<td align='right' valign='top' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan'>".round(100 * ($result['prod_profit']) / ($result['prod_costs']+$result['prod_profit']), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['ppp33']) ? $export_xls_prod .= "<td align='right' valign='top' style='background-color:#c4d9ee; font-weight:bold; mso-ignore: colspan'>".'0%'."</td>" : '';
	}	
	$export_xls_prod .="</tr>";
	}
	$export_xls_prod .="<tr>";
	$export_xls_prod .= "<td colspan='2' align='right' style='background-color:#E7EFEF; font-weight:bold;'>".$this->language->get('text_filter_total')."</td>";
	isset($_POST['ppp22']) ? $export_xls_prod .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['ppp21']) ? $export_xls_prod .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['ppp23']) ? $export_xls_prod .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['ppp24']) ? $export_xls_prod .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['ppp25']) ? $export_xls_prod .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['ppp34']) ? $export_xls_prod .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['ppp26']) ? $export_xls_prod .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['ppp35']) ? $export_xls_prod .= "<td style='background-color:#CCCCCC;'></td>" : '';
	isset($_POST['ppp27']) ? $export_xls_prod .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".$result['sold_quantity_total']."</td>" : '';
	if (!is_null($result['sold_quantity'])) {
	isset($_POST['ppp28']) ? $export_xls_prod .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".'100%'."</td>" : '';
	} else {
	isset($_POST['ppp28']) ? $export_xls_prod .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".'0%'."</td>" : '';
	}	
	isset($_POST['ppp30']) ? $export_xls_prod .= "<td align='right' style='background-color:#E7EFEF; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['tax_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['ppp29']) ? $export_xls_prod .= "<td align='right' style='background-color:#DCFFB9; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['sales_total'], 2, ',', ' ')."</td>" : '';
	isset($_POST['ppp31']) ? $export_xls_prod .= "<td align='right' style='background-color:#ffd7d7; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".('-' . number_format($result['costs_total'], 2, ',', ' '))."</td>" : '';
	isset($_POST['ppp32']) ? $export_xls_prod .= "<td align='right' style='background-color:#c4d9ee; color:#003A88; font-weight:bold; mso-number-format:#\,\#\#0\.00'>".number_format($result['profit_total'], 2, ',', ' ')."</td>" : '';
	if (number_format(($result['costs_total']+$result['profit_total']), 2, ',', ' ') > 0) {
	isset($_POST['ppp33']) ? $export_xls_prod .= "<td align='right' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".round(100 * ($result['profit_total']) / ($result['costs_total']+$result['profit_total']), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['ppp33']) ? $export_xls_prod .= "<td align='right' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".'0%'."</td>" : '';	
	}
	$export_xls_prod .="</tr></table>";		
	$export_xls_prod .="</body></html>";

$filename = "product_profit_report_".date("Y-m-d",time());
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');			
header('Content-Type: application/vnd.ms-excel; charset=UTF-8; encoding=UTF-8');			
header('Content-Disposition: attachment; filename='.$filename.".xls");
header('Content-Transfer-Encoding: UTF-8');	
print $export_xls_prod;			
exit;	
?>