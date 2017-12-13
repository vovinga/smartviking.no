<?php
ini_set("memory_limit","256M");

	$export_pdf_manu_product_list = "<html><head>";			
	$export_pdf_manu_product_list .= "</head>";
	$export_pdf_manu_product_list .= "<body>";
	$export_pdf_manu_product_list .= "<style type='text/css'>
	.list_main {
		border-collapse: collapse;		
		width: 100%;		
		border-top: 1px solid #DDDDDD;
		border-left: 1px solid #DDDDDD;	
		font-family: Helvetica;
		font-size: 10px;
	}
	.list_main td {
		border-right: 1px solid #DDDDDD;
		border-bottom: 1px solid #DDDDDD;	
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

	.list_detail {
		border-collapse: collapse;		
		width: 100%;
		border-top: 1px solid #DDDDDD;
		border-left: 1px solid #DDDDDD;
		font-family: Helvetica;
		margin-top: 10px;
		margin-bottom: 10px;
	}
	.list_detail td {
		border-right: 1px solid #DDDDDD;
		border-bottom: 1px solid #DDDDDD;
	}
	.list_detail tbody td {
		padding: 0px 3px;
		font-size: 9px;	
	}
	.list_detail .left {
		text-align: left;
		padding: 3px;
	}
	.list_detail .right {
		text-align: right;
		padding: 3px;
	}
	.list_detail .center {
		text-align: center;
		padding: 3px;
	}
	</style>";
	$export_pdf_manu_product_list .= "<table class='list_main'>";
	foreach ($results as $result) {
	$export_pdf_manu_product_list .= "<tr>";
	if ($filter_group == 'year') {				
	$export_pdf_manu_product_list .= "<td colspan='2' align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_year')."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_year')."</td>";
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_quarter')."</td>";				
	} elseif ($filter_group == 'month') {
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_year')."</td>";
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_month')."</td>";
	} elseif ($filter_group == 'day') {
	$export_pdf_manu_product_list .= "<td colspan='2' align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_date')."</td>";
	} elseif ($filter_group == 'order') {
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_order_prod_order_id')."</td>";
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_order_prod_date_added')."</td>";	
	} else {
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_date_start')."</td>";
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_date_end')."</td>";	
	}
	isset($_POST['ppp25']) ? $export_pdf_manu_product_list .= "<td align='left' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_manufacturer')."</td>" : '';
	isset($_POST['ppp27']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_sold_quantity')."</td>" : '';
	isset($_POST['ppp28']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_sold_percent')."</td>" : '';
	isset($_POST['ppp30']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_tax')."</td>" : '';
	isset($_POST['ppp29']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_total')."</td>" : '';
	isset($_POST['ppp31']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
	isset($_POST['ppp32']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_prod_profit')."</td>" : '';
	isset($_POST['ppp33']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';			
	$export_pdf_manu_product_list .= "</tr>";
	$export_pdf_manu_product_list .= "<tbody>";
			
	$this->load->model('catalog/product');
	$manu = $this->model_report_adv_product_profit->getProductManufacturers($result['manufacturer_id']);	
	$manufacturers = $this->model_report_adv_product_profit->getProductsManufacturers();
			
	$export_pdf_manu_product_list .="<tr>";
	if ($filter_group == 'year') {				
	$export_pdf_manu_product_list .= "<td colspan='2' align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['year']."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['year']."</td>";	
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".'Q' . $result['quarter']."</td>";						
	} elseif ($filter_group == 'month') {
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['year']."</td>";	
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['month']."</td>";	
	} elseif ($filter_group == 'day') {
	$export_pdf_manu_product_list .= "<td colspan='2' align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	} elseif ($filter_group == 'order') {
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['order_id']."</td>";	
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";		
	} else {
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	$export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_end']))."</td>";
	}
	isset($_POST['ppp25']) ? $export_pdf_manu_product_list .= "<td align='left' style='color:#03C;'>" : '';
		foreach ($manufacturers as $manufacturer) {
			if (in_array($manufacturer['manufacturer_id'], $manu)) {
			isset($_POST['ppp25']) ? $export_pdf_manu_product_list .= "<strong>".$manufacturer['name']."</strong>" : '';
			}
		}
	isset($_POST['ppp25']) ? $export_pdf_manu_product_list .= "</td>" : '';
	isset($_POST['ppp27']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#FFC;'>".$result['sold_quantity']."</td>" : '';
	if (!is_null($result['sold_quantity'])) {
	isset($_POST['ppp28']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#FFC;'>".round(100 * ($result['sold_quantity'] / $result['sold_quantity_total']), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['ppp28']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#FFC;'>".'0%'."</td>" : '';
	}										
	isset($_POST['ppp30']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap'>".$this->currency->format($result['tax'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['ppp29']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#DCFFB9;'>".$this->currency->format($result['prod_sales'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['ppp31']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#ffd7d7;'>".$this->currency->format('-' . ($result['prod_costs']), $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['ppp32']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".$this->currency->format($result['prod_profit'], $this->config->get('config_currency'))."</td>" : '';
	if (($result['prod_costs']+$result['prod_profit']) > 0) {				
	isset($_POST['ppp33']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".round(100 * ($result['prod_profit']) / ($result['prod_costs']+$result['prod_profit']), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['ppp33']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".'0%'."</td>" : '';
	}			
	$export_pdf_manu_product_list .= "</tr>";	
	$export_pdf_manu_product_list .= "<tr>";
	$count = isset($_POST['ppp25'])+isset($_POST['ppp27'])+isset($_POST['ppp28'])+isset($_POST['ppp30'])+isset($_POST['ppp29'])+isset($_POST['ppp31'])+isset($_POST['ppp32'])+isset($_POST['ppp33'])+2;
	$export_pdf_manu_product_list .= "<td colspan='";
	$export_pdf_manu_product_list .= $count;
	$export_pdf_manu_product_list .="' align='center'>";
		$export_pdf_manu_product_list .= "<table class='list_detail'>";
		$export_pdf_manu_product_list .= "<tr>";
		isset($_POST['ppp60']) ? $export_pdf_manu_product_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_order_id')."</td>" : '';
		isset($_POST['ppp61']) ? $export_pdf_manu_product_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_date_added')."</td>" : '';
		isset($_POST['ppp62']) ? $export_pdf_manu_product_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_inv_no')."</td>" : '';
		isset($_POST['ppp63']) ? $export_pdf_manu_product_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_id')."</td>" : '';
		isset($_POST['ppp64']) ? $export_pdf_manu_product_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_sku')."</td>" : '';
		isset($_POST['ppp65']) ? $export_pdf_manu_product_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_model')."</td>" : '';
		isset($_POST['ppp66']) ? $export_pdf_manu_product_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_name')."</td>" : '';
		isset($_POST['ppp67']) ? $export_pdf_manu_product_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_option')."</td>" : '';
		isset($_POST['ppp77']) ? $export_pdf_manu_product_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_attributes')."</td>" : '';
		isset($_POST['ppp79']) ? $export_pdf_manu_product_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_category')."</td>" : '';
		isset($_POST['ppp69']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_currency')."</td>" : '';
		isset($_POST['ppp70']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_price')."</td>" : '';
		isset($_POST['ppp71']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_quantity')."</td>" : '';
		isset($_POST['ppp73']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_tax')."</td>" : '';
		isset($_POST['ppp72']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_total')."</td>" : '';
		isset($_POST['ppp74']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
		isset($_POST['ppp75']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_prod_profit')."</td>" : '';
		isset($_POST['ppp76']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_profit_margin')."</td>" : '';			
		$export_pdf_manu_product_list .="</tr>";
		$export_pdf_manu_product_list .="<tbody>";
		$export_pdf_manu_product_list .="<tr>";
		isset($_POST['ppp60']) ? $export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap'>".$result['product_ord_idc']."</td>" : '';
		isset($_POST['ppp61']) ? $export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap'>".$result['product_order_date']."</td>" : '';
		isset($_POST['ppp62']) ? $export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap'>".$result['product_inv_no']."</td>" : '';
		isset($_POST['ppp63']) ? $export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap'>".$result['product_pidc']."</td>" : '';
		isset($_POST['ppp64']) ? $export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap'>".$result['product_sku']."</td>" : '';
		isset($_POST['ppp65']) ? $export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap'>".$result['product_model']."</td>" : '';
		isset($_POST['ppp66']) ? $export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap'>".$result['product_name']."</td>" : '';
		isset($_POST['ppp67']) ? $export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap'>".$result['product_option']."</td>" : '';
		isset($_POST['ppp77']) ? $export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap'>".$result['product_attributes']."</td>" : '';
		isset($_POST['ppp79']) ? $export_pdf_manu_product_list .= "<td align='left' nowrap='nowrap'>".$result['product_category']."</td>" : '';
		isset($_POST['ppp69']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap'>".$result['product_currency']."</td>" : '';
		isset($_POST['ppp70']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap'>".$result['product_price']."</td>" : '';
		isset($_POST['ppp71']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap'>".$result['product_quantity']."</td>" : '';
		isset($_POST['ppp73']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap'>".$result['product_tax']."</td>" : '';
		isset($_POST['ppp72']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#DCFFB9;'>".$result['product_total']."</td>" : '';
		isset($_POST['ppp74']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#ffd7d7;'>-".$result['product_costs']."</td>" : '';
		isset($_POST['ppp75']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".$result['product_profit']."</td>" : '';
		isset($_POST['ppp76']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".$result['product_profit_margin_percent'] . '%'."</td>" : '';					
		$export_pdf_manu_product_list .= "</tr>";					
		$export_pdf_manu_product_list .= "</tbody></table>";
	$export_pdf_manu_product_list .="</td>";
	$export_pdf_manu_product_list .="</tr>";
	}	
	$export_pdf_manu_product_list .="</tbody>";
	$export_pdf_manu_product_list .="<tr>";	
	$export_pdf_manu_product_list .= "<td colspan='2' style='background-color:#E5E5E5;'></td>";
	isset($_POST['ppp25']) ? $export_pdf_manu_product_list .= "<td style='background-color:#DDDDDD;'></td>" : '';
	isset($_POST['ppp27']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_sold_quantity')."</td>" : '';
	isset($_POST['ppp28']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_sold_percent')."</td>" : '';
	isset($_POST['ppp30']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_tax')."</td>" : '';
	isset($_POST['ppp29']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_total')."</td>" : '';
	isset($_POST['ppp31']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
	isset($_POST['ppp32']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_prod_profit')."</td>" : '';
	isset($_POST['ppp33']) ? $export_pdf_manu_product_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';
	$export_pdf_manu_product_list .="</tr>";
	$export_pdf_manu_product_list .="<tbody><tr>";	
	$export_pdf_manu_product_list .= "<td colspan='2' align='right' style='background-color:#E7EFEF;'><strong>".$this->language->get('text_filter_total')."</strong></td>";
	isset($_POST['ppp25']) ? $export_pdf_manu_product_list .= "<td style='background-color:#DDDDDD;'></td>" : '';
	isset($_POST['ppp27']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".$result['sold_quantity_total']."</td>" : '';
	if (!is_null($result['sold_quantity'])) {
	isset($_POST['ppp28']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".'100%'."</td>" : '';
	} else {
	isset($_POST['ppp28']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".'0%'."</td>" : '';
	}	
	isset($_POST['ppp30']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88; font-weight:bold;'>".$this->currency->format($result['tax_total'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['ppp29']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#DCFFB9; color:#003A88; font-weight:bold;'>".$this->currency->format($result['sales_total'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['ppp31']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#ffd7d7; color:#003A88; font-weight:bold;'>".$this->currency->format('-' . ($result['costs_total']), $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['ppp32']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".$this->currency->format($result['profit_total'], $this->config->get('config_currency'))."</td>" : '';
	if (($result['costs_total']+$result['profit_total']) > 0) {
	isset($_POST['ppp33']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".round(100 * ($result['profit_total']) / ($result['costs_total']+$result['profit_total']), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['ppp33']) ? $export_pdf_manu_product_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; color:#003A88; font-weight:bold;'>".'0%'."</td>" : '';	
	}
	$export_pdf_manu_product_list .="</tr></tbody></table>";
	$export_pdf_manu_product_list .="</body></html>";

ini_set('mbstring.substitute_character', "none"); 
$dompdf_pdf_manu_product_list = mb_convert_encoding($export_pdf_manu_product_list, 'ISO-8859-1', 'UTF-8'); 
$dompdf = new DOMPDF();
$dompdf->load_html($dompdf_pdf_manu_product_list);
$dompdf->set_paper("a3", "landscape");
$dompdf->render();
$dompdf->stream("manufacturer_profit_report_product_list_".date("Y-m-d",time()).".pdf");
?>