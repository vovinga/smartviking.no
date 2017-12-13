<?php
ini_set("memory_limit","256M");

	$export_pdf_order_list = "<html><head>";			
	$export_pdf_order_list .= "</head>";
	$export_pdf_order_list .= "<body>";
	$export_pdf_order_list .= "<style type='text/css'>
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
	$export_pdf_order_list .= "<table class='list_main'>";
	foreach ($results as $result) {		
	$export_pdf_order_list .= "<tr>";
	if ($filter_group == 'year') {				
	$export_pdf_order_list .= "<td colspan='2' align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_year')."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_year')."</td>";
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_quarter')."</td>";				
	} elseif ($filter_group == 'month') {
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_year')."</td>";
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_month')."</td>";
	} elseif ($filter_group == 'day') {
	$export_pdf_order_list .= "<td colspan='2' align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_date')."</td>";
	} elseif ($filter_group == 'order') {
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_order_order_id')."</td>";
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_order_date_added')."</td>";	
	} else {
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_date_start')."</td>";
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_date_end')."</td>";	
	}
	isset($_POST['sop20']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_orders')."</td>" : '';
	isset($_POST['sop21']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_customers')."</td>" : '';
	isset($_POST['sop22']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_products')."</td>" : '';
	isset($_POST['sop23']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_sub_total')."</td>" : '';
	isset($_POST['sop24']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_handling')."</td>" : '';
	isset($_POST['sop25']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_loworder')."</td>" : '';
	isset($_POST['sop27']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_shipping')."</td>" : '';	
	isset($_POST['sop26']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_reward')."</td>" : '';
	isset($_POST['sop28']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_coupon')."</td>" : '';
	isset($_POST['sop29']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_tax')."</td>" : '';
	isset($_POST['sop30']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_credit')."</td>" : '';
	isset($_POST['sop31']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_voucher')."</td>" : '';
	isset($_POST['sop33']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_total')."</td>" : '';
	isset($_POST['sop37']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_sales')."</td>" : '';	
	isset($_POST['sop34']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
	isset($_POST['sop32']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_commission')."</td>" : '';
	isset($_POST['sop391']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_payment_cost')."</td>" : '';
	isset($_POST['sop392']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_shipping_cost')."</td>" : '';
	isset($_POST['sop393']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_shipping_balance')."</td>" : '';
	isset($_POST['sop38']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_total_costs')."</td>" : '';	
	isset($_POST['sop35']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_net_profit')."</td>" : '';
	isset($_POST['sop36']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';
	$export_pdf_order_list .= "</tr>";
	$export_pdf_order_list .= "<tbody>";	
	$export_pdf_order_list .= "<tr>";
	if ($filter_group == 'year') {				
	$export_pdf_order_list .= "<td colspan='2' align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['year']."</td>";
	} elseif ($filter_group == 'quarter') {
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['year']."</td>";	
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".'Q' . $result['quarter']."</td>";						
	} elseif ($filter_group == 'month') {
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['year']."</td>";	
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['month']."</td>";	
	} elseif ($filter_group == 'day') {
	$export_pdf_order_list .= "<td colspan='2' align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";	
	} elseif ($filter_group == 'order') {
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".$result['order_id']."</td>";	
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";	
	} else {
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_start']))."</td>";
	$export_pdf_order_list .= "<td align='left' nowrap='nowrap' style='background-color:#F0F0F0;'>".date($this->language->get('date_format_short'), strtotime($result['date_end']))."</td>";
	}
	isset($_POST['sop20']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$result['orders']."</td>" : '';
	isset($_POST['sop21']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$result['customers']."</td>" : '';
	isset($_POST['sop22']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$result['products']."</td>" : '';
	isset($_POST['sop23']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='color:#090;'>".$this->currency->format($result['sub_total'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['sop24']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='color:#090;'>".$this->currency->format($result['handling'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['sop25']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='color:#090;'>".$this->currency->format($result['low_order_fee'], $this->config->get('config_currency'))."</td>" : '';
	if ($this->config->get('adv_profit_reports_formula_sop1')) {
	isset($_POST['sop27']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='color:#090;'>".$this->currency->format($result['shipping'], $this->config->get('config_currency'))."</td>" : '';	
	} else {
	isset($_POST['sop27']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$this->currency->format($result['shipping'], $this->config->get('config_currency'))."</td>" : '';
	}
	isset($_POST['sop26']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='color:#090;'>".$this->currency->format($result['reward'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['sop28']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='color:#090;'>".$this->currency->format($result['coupon'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['sop29']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$this->currency->format($result['tax'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['sop30']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='color:#090;'>".$this->currency->format($result['credit'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['sop31']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='color:#090;'>".$this->currency->format($result['voucher'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['sop33']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$this->currency->format($result['total'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['sop37']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#DCFFB9;'>".$this->currency->format($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping'] : 0), $this->config->get('config_currency'))."</td>" : '';	
	isset($_POST['sop34']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='color:#F00;'>".$this->currency->format('-' . ($result['prod_costs']), $this->config->get('config_currency'))."</td>" : '';	
	isset($_POST['sop32']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='color:#F00;'>".$this->currency->format('-' . ($result['commission']), $this->config->get('config_currency'))."</td>" : '';
	if ($this->config->get('adv_profit_reports_formula_sop3')) {
	isset($_POST['sop391']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='color:#F00;'>".$this->currency->format('-' . ($result['payment_cost']), $this->config->get('config_currency'))."</td>" : '';
	} else {
	isset($_POST['sop391']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$this->currency->format('-' . ($result['payment_cost']), $this->config->get('config_currency'))."</td>" : '';
	}	
	if ($this->config->get('adv_profit_reports_formula_sop2')) {
	isset($_POST['sop392']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='color:#F00;'>".$this->currency->format('-' . ($result['shipping_cost']), $this->config->get('config_currency'))."</td>" : '';
	} else {
	isset($_POST['sop392']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$this->currency->format('-' . ($result['shipping_cost']), $this->config->get('config_currency'))."</td>" : '';
	}		
	isset($_POST['sop393']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$this->currency->format($result['shipping']-$result['shipping_cost'], $this->config->get('config_currency'))."</td>" : '';
	isset($_POST['sop38']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#ffd7d7;'>".$this->currency->format('-' . ($result['prod_costs']+$result['commission']+($this->config->get('adv_profit_reports_formula_sop3') ? $result['payment_cost'] : 0)+($this->config->get('adv_profit_reports_formula_sop2') ? $result['shipping_cost'] : 0)), $this->config->get('config_currency'))."</td>" : '';	
	isset($_POST['sop35']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".$this->currency->format(($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping'] : 0))-($result['prod_costs']+$result['commission']+($this->config->get('adv_profit_reports_formula_sop3') ? $result['payment_cost'] : 0)+($this->config->get('adv_profit_reports_formula_sop2') ? $result['shipping_cost'] : 0)), $this->config->get('config_currency'))."</td>" : '';
	if (($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']) > 0) {
	isset($_POST['sop36']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".round(100 * ((($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping'] : 0))-($result['prod_costs']+$result['commission']+($this->config->get('adv_profit_reports_formula_sop3') ? $result['payment_cost'] : 0)+($this->config->get('adv_profit_reports_formula_sop2') ? $result['shipping_cost'] : 0))) / ($result['sub_total']+$result['handling']+$result['low_order_fee']+$result['reward']+$result['coupon']+$result['credit']+$result['voucher']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping'] : 0))), 2) . '%'."</td>" : '';
	} else {
	isset($_POST['sop36']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".'0%'."</td>" : '';
	}							
	$export_pdf_order_list .= "</tr>";	
	$export_pdf_order_list .= "<tr>";
	$count = isset($_POST['sop20'])+isset($_POST['sop21'])+isset($_POST['sop22'])+isset($_POST['sop23'])+isset($_POST['sop24'])+isset($_POST['sop25'])+isset($_POST['sop27'])+isset($_POST['sop26'])+isset($_POST['sop28'])+isset($_POST['sop29'])+isset($_POST['sop30'])+isset($_POST['sop31'])+isset($_POST['sop33'])+isset($_POST['sop37'])+isset($_POST['sop34'])+isset($_POST['sop32'])+isset($_POST['sop391'])+isset($_POST['sop392'])+isset($_POST['sop393'])+isset($_POST['sop38'])+isset($_POST['sop35'])+isset($_POST['sop36'])+2;
	$export_pdf_order_list .= "<td colspan='";
	$export_pdf_order_list .= $count;
	$export_pdf_order_list .="' align='center'>";
		$export_pdf_order_list .= "<table class='list_detail'>";
		$export_pdf_order_list .= "<tr>";
		isset($_POST['sop40']) ? $export_pdf_order_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_order_id')."</td>" : '';
		isset($_POST['sop41']) ? $export_pdf_order_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_date_added')."</td>" : '';
		isset($_POST['sop42']) ? $export_pdf_order_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_inv_no')."</td>" : '';
		isset($_POST['sop43']) ? $export_pdf_order_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_customer')."</td>" : '';
		isset($_POST['sop44']) ? $export_pdf_order_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_email')."</td>" : '';
		isset($_POST['sop45']) ? $export_pdf_order_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_customer_group')."</td>" : '';
		isset($_POST['sop46']) ? $export_pdf_order_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_shipping_method')."</td>" : '';
		isset($_POST['sop47']) ? $export_pdf_order_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_payment_method')."</td>" : '';
		isset($_POST['sop48']) ? $export_pdf_order_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_status')."</td>" : '';
		isset($_POST['sop49']) ? $export_pdf_order_list .= "<td align='left' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_store')."</td>" : '';
		isset($_POST['sop50']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_currency')."</td>" : '';
		isset($_POST['sop51']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_quantity')."</td>" : '';
		isset($_POST['sop52']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_sub_total')."</td>" : '';
		isset($_POST['sop54']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_shipping')."</td>" : '';
		isset($_POST['sop55']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_tax')."</td>" : '';
		isset($_POST['sop56']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_value')."</td>" : '';
		isset($_POST['sop53']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_sales')."</td>" : '';
		isset($_POST['sop57']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_costs')."</td>" : '';
		isset($_POST['sop58']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_order_profit')."</td>" : '';
		isset($_POST['sop59']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#F0F0F0; padding:0px 3px; font-size:9px; font-weight: bold;'>".$this->language->get('column_profit_margin')."</td>" : '';
		$export_pdf_order_list .= "</tr>";
		$export_pdf_order_list .= "<tbody>";
		$export_pdf_order_list .= "<tr>";
		isset($_POST['sop40']) ? $export_pdf_order_list .= "<td align='left' nowrap='nowrap'>".$result['order_ord_idc']."</td>" : '';
		isset($_POST['sop41']) ? $export_pdf_order_list .= "<td align='left' nowrap='nowrap'>".$result['order_order_date']."</td>" : '';
		isset($_POST['sop42']) ? $export_pdf_order_list .= "<td align='left' nowrap='nowrap'>".$result['order_inv_no']."</td>" : '';
		isset($_POST['sop43']) ? $export_pdf_order_list .= "<td align='left' nowrap='nowrap'>".$result['order_name']."</td>" : '';
		isset($_POST['sop44']) ? $export_pdf_order_list .= "<td align='left' nowrap='nowrap'>".$result['order_email']."</td>" : '';
		isset($_POST['sop45']) ? $export_pdf_order_list .= "<td align='left' nowrap='nowrap'>".$result['order_group']."</td>" : '';
		isset($_POST['sop46']) ? $export_pdf_order_list .= "<td align='left' nowrap='nowrap'>".$result['order_shipping_method']."</td>" : '';
		isset($_POST['sop47']) ? $export_pdf_order_list .= "<td align='left' nowrap='nowrap'>".strip_tags($result['order_payment_method'], '<br>')."</td>" : '';
		isset($_POST['sop48']) ? $export_pdf_order_list .= "<td align='left' nowrap='nowrap'>".$result['order_status']."</td>" : '';
		isset($_POST['sop49']) ? $export_pdf_order_list .= "<td align='left' nowrap='nowrap'>".$result['order_store']."</td>" : '';
		isset($_POST['sop50']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$result['order_currency']."</td>" : '';
		isset($_POST['sop51']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$result['order_products']."</td>" : '';
		isset($_POST['sop52']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$result['order_sub_total']."</td>" : '';
		isset($_POST['sop54']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$result['order_shipping']."</td>" : '';
		isset($_POST['sop55']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$result['order_tax']."</td>" : '';
		isset($_POST['sop56']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap'>".$result['order_value']."</td>" : '';
		isset($_POST['sop53']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#DCFFB9;'>".$result['order_sales']."</td>" : '';		
		isset($_POST['sop57']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#ffd7d7;'>-".$result['order_costs']."</td>" : '';
		isset($_POST['sop58']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".$result['order_profit']."</td>" : '';
		isset($_POST['sop59']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; font-weight:bold;'>".$result['order_profit_margin_percent'] . '%'."</td>" : '';
		$export_pdf_order_list .= "</tr>";					
		$export_pdf_order_list .= "</tbody></table>";
	$export_pdf_order_list .="</td>";
	$export_pdf_order_list .="</tr>";
	}	
	$export_pdf_order_list .="</tbody>";
	$export_pdf_order_list .="<tr>";
	$export_pdf_order_list .= "<td colspan='2' style='background-color:#E5E5E5;'></td>";
	isset($_POST['sop20']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_orders')."</td>" : '';
	isset($_POST['sop21']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_customers')."</td>" : '';
	isset($_POST['sop22']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_products')."</td>" : '';
	isset($_POST['sop23']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_sub_total')."</td>" : '';
	isset($_POST['sop24']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_handling')."</td>" : '';
	isset($_POST['sop25']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_loworder')."</td>" : '';
	isset($_POST['sop27']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_shipping')."</td>" : '';	
	isset($_POST['sop26']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_reward')."</td>" : '';
	isset($_POST['sop28']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_coupon')."</td>" : '';
	isset($_POST['sop29']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_tax')."</td>" : '';
	isset($_POST['sop30']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_credit')."</td>" : '';
	isset($_POST['sop31']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_voucher')."</td>" : '';
	isset($_POST['sop33']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_total')."</td>" : '';
	isset($_POST['sop37']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_sales')."</td>" : '';
	isset($_POST['sop34']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_prod_costs')."</td>" : '';
	isset($_POST['sop32']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_commission')."</td>" : '';
	isset($_POST['sop391']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_payment_cost')."</td>" : '';
	isset($_POST['sop392']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_shipping_cost')."</td>" : '';
	isset($_POST['sop393']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_shipping_balance')."</td>" : '';
	isset($_POST['sop38']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_total_costs')."</td>" : '';
	isset($_POST['sop35']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_net_profit')."</td>" : '';
	isset($_POST['sop36']) ? $export_pdf_order_list .= "<td align='right' style='background-color:#E5E5E5; padding:3px; font-weight:bold;'>".$this->language->get('column_profit_margin')."</td>" : '';	
	$export_pdf_order_list .="</tr>";
	$export_pdf_order_list .="<tbody><tr>";	
	$export_pdf_order_list .= "<td colspan='2' align='right' style='background-color:#E7EFEF;'><strong>".$this->language->get('text_filter_total')."</strong></td>";
	isset($_POST['sop20']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$result['orders_total']."</strong></td>" : '';
	isset($_POST['sop21']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$result['customers_total']."</strong></td>" : '';
	isset($_POST['sop22']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$result['products_total']."</strong></td>" : '';
	isset($_POST['sop23']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format($result['sub_total_total'], $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop24']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format($result['handling_total'], $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop25']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format($result['low_order_fee_total'], $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop27']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format($result['shipping_total'], $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop26']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format($result['reward_total'], $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop28']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format($result['coupon_total'], $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop29']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format($result['tax_total'], $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop30']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format($result['credit_total'], $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop31']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format($result['voucher_total'], $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop33']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format($result['total_total'], $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop37']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#DCFFB9; color:#003A88;'><strong>".$this->currency->format($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping_total'] : 0), $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop34']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format('-' . ($result['prod_costs_total']), $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop32']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format('-' . ($result['commission_total']), $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop391']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format('-' . ($result['pay_costs_total']), $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop392']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format('-' . ($result['ship_costs_total']), $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop393']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#E7EFEF; color:#003A88;'><strong>".$this->currency->format($result['shipping_total']-$result['ship_costs_total'], $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop38']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#ffd7d7; color:#003A88;'><strong>".$this->currency->format('-' . ($result['prod_costs_total']+$result['commission_total']+($this->config->get('adv_profit_reports_formula_sop3') ? $result['pay_costs_total'] : 0)+($this->config->get('adv_profit_reports_formula_sop2') ? $result['ship_costs_total'] : 0)), $this->config->get('config_currency'))."</strong></td>" : '';
	isset($_POST['sop35']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; color:#003A88;'><strong>".$this->currency->format(($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping_total'] : 0))-($result['prod_costs_total']+$result['commission_total']+($this->config->get('adv_profit_reports_formula_sop3') ? $result['pay_costs_total'] : 0)+($this->config->get('adv_profit_reports_formula_sop2') ? $result['ship_costs_total'] : 0)), $this->config->get('config_currency'))."</strong></td>" : '';
	if (($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']) > 0) {
	isset($_POST['sop36']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; color:#003A88;'><strong>".round(100 * ((($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping_total'] : 0))-($result['prod_costs_total']+$result['commission_total']+($this->config->get('adv_profit_reports_formula_sop3') ? $result['pay_costs_total'] : 0)+($this->config->get('adv_profit_reports_formula_sop2') ? $result['ship_costs_total'] : 0))) / ($result['sub_total_total']+$result['handling_total']+$result['low_order_fee_total']+$result['reward_total']+$result['coupon_total']+$result['credit_total']+$result['voucher_total']+($this->config->get('adv_profit_reports_formula_sop1') ? $result['shipping_total'] : 0))), 2) . '%'."</strong></td>" : '';
	} else {
	isset($_POST['sop36']) ? $export_pdf_order_list .= "<td align='right' nowrap='nowrap' style='background-color:#c4d9ee; color:#003A88;'><strong>".'0%'."</strong></td>" : '';	
	}
	$export_pdf_order_list .="</tr></tbody></table>";
	$export_pdf_order_list .="</body></html>";

ini_set('mbstring.substitute_character', "none"); 
$dompdf_pdf_order_list = mb_convert_encoding($export_pdf_order_list, 'ISO-8859-1', 'UTF-8'); 
$dompdf = new DOMPDF();
$dompdf->load_html($dompdf_pdf_order_list);
$dompdf->set_paper("a3", "landscape");
$dompdf->render();
$dompdf->stream("sale_profit_report_order_list_".date("Y-m-d",time()).".pdf");
?>