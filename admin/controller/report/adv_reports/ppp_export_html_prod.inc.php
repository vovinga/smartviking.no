<?php
ini_set("memory_limit","256M");
	
	$export_html_prod ="<html><head>";
	$export_html_prod .="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	$export_html_prod .="</head>";
	$export_html_prod .="<body>";
	$export_html_prod .="<style type='text/css'>
	.list_main {
		border-collapse: collapse;
		width: 100%;
		border-top: 1px solid #DDDDDD;
		border-left: 1px solid #DDDDDD;	
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	.list_main td {
		border-right: 1px solid #DDDDDD;
		border-bottom: 1px solid #DDDDDD;	
	}
	.list_main thead td {
		background-color: #E5E5E5;
		padding: 3px;
		font-weight: bold;
	}
	.list_main tbody a {
		text-decoration: none;
	}
	.list_main tbody td {
		vertical-align: middle;
		padding: 3px;
	}
	.list_main .left {
		text-align: left;
		padding: 7px;
	}
	.list_main .right {
		text-align: right;
		padding: 7px;
	}
	.list_main .center {
		text-align: center;
		padding: 3px;
	}
	</style>";
	$export_html_prod .="<table class='list_main'>";
	$export_html_prod .="<thead>";
	$export_html_prod .="<tr>";
	if ($filter_group == 'year') {				
	$export_html_prod .= "<td colspan='2' align='left' nowrap='nowrap'>".$this->language->get('column_year')."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_html_prod .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_year')."</td>";
	$export_html_prod .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_quarter')."</td>";				
	} elseif ($filter_group == 'month') {
	$export_html_prod .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_year')."</td>";
	$export_html_prod .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_month')."</td>";
	} elseif ($filter_group == 'day') {
	$export_html_prod .= "<td colspan='2' align='left' nowrap='nowrap'>".$this->language->get('column_date')."</td>";
	} elseif ($filter_group == 'order') {
	$export_html_prod .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_order_prod_order_id')."</td>";
	$export_html_prod .= "<td align='left' nowrap='nowrap'>".$this->language->get('column_order_prod_date_added')."</td>";
	} else {
	$export_html_prod .= "<td align='left' width='80' nowrap='nowrap'>".$this->language->get('column_date_start')."</td>";
	$export_html_prod .= "<td align='left' width='80' nowrap='nowrap'>".$this->language->get('column_date_end')."</td>";	
	}
	isset($_POST['ppp21']) ? $export_html_prod .= "<td align='left'>".$this->language->get('column_sku')."</td>" : '';
	isset($_POST['ppp22']) ? $export_html_prod .= "<td align='left'>".$this->language->get('column_name')."</td>" : '';
	isset($_POST['ppp23']) ? $export_html_prod .= "<td align='left'>".$this->language->get('column_model')."</td>" : '';
	isset($_POST['ppp24']) ? $export_html_prod .= "<td align='left'>".$this->language->get('column_category')."</td>" : '';
	isset($_POST['ppp25']) ? $export_html_prod .= "<td align='left'>".$this->language->get('column_manufacturer')."</td>" : '';
	isset($_POST['ppp34']) ? $export_html_prod .= "<td align='left'>".$this->language->get('column_attribute')."</td>" : '';
	isset($_POST['ppp26']) ? $export_html_prod .= "<td align='left'>".$this->language->get('column_status')."</td>" : '';
	isset($_POST['ppp35']) ? $export_html_prod .= "<td align='right'>".$this->language->get('column_stock_quantity')."</td>" : '';
	isset($_POST['ppp27']) ? $export_html_prod .= "<td align='right'>".$this->language->get('column_sold_quantity')."</td>" : '';
	isset($_POST['ppp28']) ? $export_html_prod .= "<td align='right'>".$this->language->get('column_sold_percent')."</td>" : '';
	isset($_POST['ppp30']) ? $export_html_prod .= "<td align='right'>".$this->language->get('column_tax')."</td>" : '';
	isset($_POST['ppp29']) ? $export_html_prod .= "<td align='right'>".$this->language->get('column_total')."</td>" : '';
	isset($_POST['ppp31']) ? $export_html_prod .= "<td align='right'>".$this->language->get('column_prod_costs')."</td>" : '';
	isset($_POST['ppp32']) ? $export_html_prod .= "<td align='right'>".$this->language->get('column_prod_profit')."</td>" : '';
	isset($_POST['ppp33']) ? $export_html_prod .= "<td align='right'>".$this->language->get('column_profit_margin')."</td>" : '';
	$export_html_prod .="</tr>";
	$export_html_prod .="</thead><tbody>";
	foreach ($results as $result) {
		
	$this->load->model('catalog/product');
	$cat =  $this->model_catalog_product->getProductCategories($result['product_id']);
	$manu = $this->model_report_adv_product_profit->getProductManufacturers($result['manufacturer_id']);	
	$manufacturers = $this->model_report_adv_product_profit->getProductsManufacturers();
	$categories = $this->model_report_adv_product_profit->getProductsCategories(0); 
	
	$export_html_prod .="<tr>";
	if ($filter_group == 'year') {				
	$export_html_prod .= "<td colspan='2' align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['year']."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_html_prod .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['year']."</td>";	
	$export_html_prod .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".'Q' . $result['quarter']."</td>";						
	} elseif ($filter_group == 'month') {
	$export_html_prod .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['year']."</td>";	
	$export_html_prod .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['month']."</td>";	
	} elseif ($filter_group == 'day') {
	$export_html_prod .= "<td colspan='2' align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	} elseif ($filter_group == 'order') {
	$export_html_prod .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['order_id']."</td>";	
	$export_html_prod .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	} else {
	$export_html_prod .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	$export_html_prod .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_end']))."</td>";
	}
	isset($_POST['ppp21']) ? $export_html_prod .= "<td align='left'>".$result['sku']."</td>" : '';
	isset($_POST['ppp22']) ? $export_html_prod .= "<td align='left' style='color:#03C;'><strong>".$result['name']."</strong>" : '';
	if ($filter_ogrouping) {
	if ($result['oovalue']) {
	isset($_POST['ppp22']) ? $export_html_prod .= "<table cellpadding='0' cellspacing='0' border='0' style='border:none;'><tr>" : '';
	isset($_POST['ppp22']) ? $export_html_prod .= "<td style='font-family:Arial, Helvetica; font-size:11px; color:#03C; border:none;' nowrap='nowrap'>".$result['ooname'].":</td>" : '';
	isset($_POST['ppp22']) ? $export_html_prod .= "<td style='font-family:Arial, Helvetica; font-size:11px; color:#03C; border:none;' nowrap='nowrap'>".$result['oovalue']."</td>" : '';
	isset($_POST['ppp22']) ? $export_html_prod .= "</tr></table>" : '';
	}
	}		
	isset($_POST['ppp22']) ? $export_html_prod .= "</td>" : '';
	isset($_POST['ppp23']) ? $export_html_prod .= "<td align='left'>".$result['model']."</td>" : '';
	isset($_POST['ppp24']) ? $export_html_prod .= "<td align='left'>" : '';
		foreach ($categories as $category) {
			if (in_array($category['category_id'], $cat)) {
			isset($_POST['ppp24']) ? $export_html_prod .= "".$category['name']."<br>" : '';
			}
		}
	isset($_POST['ppp24']) ? $export_html_prod .= "</td>" : '';
	isset($_POST['ppp25']) ? $export_html_prod .= "<td align='left'>" : '';
		foreach ($manufacturers as $manufacturer) {
			if (in_array($manufacturer['manufacturer_id'], $manu)) {
			isset($_POST['ppp25']) ? $export_html_prod .= "".$manufacturer['name']."" : '';
			}
		}
	isset($_POST['ppp25']) ? $export_html_prod .= "</td>" : '';
	isset($_POST['ppp34']) ? $export_html_prod .= "<td align='left'>".$result['attribute']."</td>" : '';
	isset($_POST['ppp26']) ? $export_html_prod .= "<td align='left'>".($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'))."</td>" : '';
	isset($_POST['ppp35']) ? $export_html_prod .= "<td align='right' nowrap='nowrap'>" : '';	
	if ($result['stock_quantity'] <= 0) {
	isset($_POST['ppp35']) ? $export_html_prod .= "<span style='color:#FF0000;'>".$result['stock_quantity']."</span>" : '';
	} elseif ($result['stock_quantity'] <= 5) {
	isset($_POST['ppp35']) ? $export_html_prod .= "<span style='color:#FFA500;'>".$result['stock_quantity']."</span>" : '';
	} else {
	isset($_POST['ppp35']) ? $export_html_prod .= "<span>".$result['stock_quantity']."</span>" : '';
	}
	if ($filter_ogrouping) {	
	if ($result['oovalue']) {	
	if ($result['stock_oquantity'] <= 0) {
	isset($_POST['ppp35']) ? $export_html_prod .= "<br><span style='color:#FF0000; font-size:11px;'>".$result['stock_oquantity']."</span>" : '';
	} elseif ($result['stock_oquantity'] <= 5) {
	isset($_POST['ppp35']) ? $export_html_prod .= "<br><span style='color:#FFA500; font-size:11px;'>".$result['stock_oquantity']."</span>" : '';
	} else {
	isset($_POST['ppp35']) ? $export_html_prod .= "<br><span style='font-size:11px;'>".$result['stock_oquantity']."</span>" : '';
	}
	}
	}	
	isset($_POST['ppp35']) ? $export_html_prod .= "</td>" : '';
	isset($_POST['ppp27']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#FFC;'>".$result['sold_quantity']."</td>" : '';
	if (!is_null($result['sold_quantity'])) {
	isset($_POST['ppp28']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#FFC;'>".round(100 * ($result['sold_quantity'] / $result['sold_quantity_total']), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['ppp28']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#FFC;'>".'0%'."</td>" : '';
	}										
	isset($_POST['ppp30']) ? $export_html_prod .= "<td align='right' nowrap='nowrap'>".$this->currency->format($result['tax'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['ppp29']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#DCFFB9;'>".$this->currency->format($result['prod_sales'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['ppp31']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#ffd7d7;'>".$this->currency->format('-' . ($result['prod_costs']), $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['ppp32']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".$this->currency->format($result['prod_profit'], $this->config->get('config_currency'))."</td>" : '';
	if (($result['prod_costs']+$result['prod_profit']) > 0) {				
	isset($_POST['ppp33']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".round(100 * ($result['prod_profit']) / ($result['prod_costs']+$result['prod_profit']), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['ppp33']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".'0%'."</td>" : '';
	}
	$export_html_prod .="</tr>";
	}
	$export_html_prod .="</tbody><tbody><tr>";
	$export_html_prod .= "<td colspan='2' align='right' style='background-color:#E7EFEF;'><strong>".$this->language->get('text_filter_total')."</strong></td>";
	isset($_POST['ppp21']) ? $export_html_prod .= "<td style='background-color:#DDDDDD;'></td>" : '';
	isset($_POST['ppp22']) ? $export_html_prod .= "<td style='background-color:#DDDDDD;'></td>" : '';	
	isset($_POST['ppp23']) ? $export_html_prod .= "<td style='background-color:#DDDDDD;'></td>" : '';
	isset($_POST['ppp24']) ? $export_html_prod .= "<td style='background-color:#DDDDDD;'></td>" : '';
	isset($_POST['ppp25']) ? $export_html_prod .= "<td style='background-color:#DDDDDD;'></td>" : '';
	isset($_POST['ppp34']) ? $export_html_prod .= "<td style='background-color:#DDDDDD;'></td>" : '';
	isset($_POST['ppp26']) ? $export_html_prod .= "<td style='background-color:#DDDDDD;'></td>" : '';
	isset($_POST['ppp35']) ? $export_html_prod .= "<td style='background-color:#DDDDDD;'></td>" : '';
	isset($_POST['ppp27']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".$result['sold_quantity_total']."</td>" : '';
	if (!is_null($result['sold_quantity'])) {
	isset($_POST['ppp28']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".'100%'."</td>" : '';
	} else {
	isset($_POST['ppp28']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".'0%'."</td>" : '';
	}	
	isset($_POST['ppp30']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".$this->currency->format($result['tax_total'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['ppp29']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#DCFFB9; color:#003A88; font-weight:bold;'>".$this->currency->format($result['sales_total'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['ppp31']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#ffd7d7; color:#003A88; font-weight:bold;'>".$this->currency->format('-' . ($result['costs_total']), $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['ppp32']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".$this->currency->format($result['profit_total'], $this->config->get('config_currency'))."</td>" : '';
	if (($result['costs_total']+$result['profit_total']) > 0) {
	isset($_POST['ppp33']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".round(100 * ($result['profit_total']) / ($result['costs_total']+$result['profit_total']), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['ppp33']) ? $export_html_prod .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".'0%'."</td>" : '';	
	}
	$export_html_prod .="</tr></tbody></table>";	
	$export_html_prod .="</body></html>";

$filename = "product_profit_report_".date("Y-m-d",time());
header('Expires: 0');
header('Cache-control: private');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Content-Description: File Transfer');			
header('Content-Disposition: attachment; filename='.$filename.".html");
print $export_html_prod;			
exit;
?>