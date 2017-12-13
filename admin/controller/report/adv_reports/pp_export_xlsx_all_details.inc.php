<?php
	ini_set("memory_limit","256M");
	$results = $export_data['results'];
	if ($results) {

	$this->objPHPExcel = new PHPExcel();
	$this->objPHPExcel->getActiveSheet()->setTitle('ADV Products Report');
	$this->objPHPExcel->getProperties()->setCreator("ADV Reports & Statistics")
								 	   ->setLastModifiedBy("ADV Reports & Statistics")
									   ->setTitle("ADV Products Report")
									   ->setSubject("ADV Products Report")
									   ->setDescription("ADV Products Report with All Details")
									   ->setKeywords("office 2007 excel")
									   ->setCategory("www.opencartreports.com");	
	$this->objPHPExcel->setActiveSheetIndex(0);
	$export_logo_criteria ? $this->mainCounter = 2 : $this->mainCounter = 1;
	if ($export_logo_criteria ? $this->mainCounter = 2 : $this->mainCounter = 1) {
		 $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $this->mainCounter, $this->language->get('column_order_order_id'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('A' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $this->mainCounter, $this->language->get('column_order_date_added'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('B' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);	
		  
		 $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $this->mainCounter, $this->language->get('column_order_inv_no'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('C' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $this->mainCounter, $this->language->get('column_order_customer'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('D' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $this->mainCounter, $this->language->get('column_order_email'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('E' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $this->mainCounter, $this->language->get('column_order_customer_group'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('F' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $this->mainCounter, $this->language->get('column_prod_id'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('G' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $this->mainCounter, $this->language->get('column_prod_sku'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('H' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $this->mainCounter, $this->language->get('column_prod_model'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('I' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $this->mainCounter, $this->language->get('column_prod_name'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('J' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $this->mainCounter, $this->language->get('column_prod_option'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('K' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('L' . $this->mainCounter, $this->language->get('column_prod_attributes'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('L' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('M' . $this->mainCounter, $this->language->get('column_prod_manu'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('M' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('N' . $this->mainCounter, $this->language->get('column_prod_category'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('N' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('O' . $this->mainCounter, $this->language->get('column_prod_currency'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('O' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('P' . $this->mainCounter, $this->language->get('column_prod_price'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('P' . $this->mainCounter)->getFont()->setBold(true);	
		 $this->objPHPExcel->getActiveSheet()->getStyle('P' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $this->mainCounter, $this->language->get('column_prod_quantity'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('Q' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('Q' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);

		 $this->objPHPExcel->getActiveSheet()->setCellValue('R' . $this->mainCounter, $this->language->get('column_prod_total_excl_vat'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('R' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('R' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('S' . $this->mainCounter, $this->language->get('column_prod_tax'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('S' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('S' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);

		 $this->objPHPExcel->getActiveSheet()->setCellValue('T' . $this->mainCounter, $this->language->get('column_prod_total_incl_vat'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('T' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('T' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);

		 $this->objPHPExcel->getActiveSheet()->setCellValue('U' . $this->mainCounter, $this->language->get('column_prod_qty_refunded'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('U' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('U' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('V' . $this->mainCounter, $this->language->get('column_prod_refunded'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('V' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('V' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);

		 $this->objPHPExcel->getActiveSheet()->setCellValue('W' . $this->mainCounter, $this->language->get('column_prod_reward_points'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('W' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('W' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);	 
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('X' . $this->mainCounter, $this->language->get('column_sub_total'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('X' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('X' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('Y' . $this->mainCounter, $this->language->get('column_handling'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('Y' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('Y' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('Z' . $this->mainCounter, $this->language->get('column_loworder'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('Z' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('Z' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AA' . $this->mainCounter, $this->language->get('column_shipping'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AA' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('AA' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AB' . $this->mainCounter, $this->language->get('column_reward'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AB' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('AB' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);	

		 $this->objPHPExcel->getActiveSheet()->setCellValue('AC' . $this->mainCounter, $this->language->get('column_earned_reward_points'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AC' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('AC' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AD' . $this->mainCounter, $this->language->get('column_used_reward_points'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AD' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('AD' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AE' . $this->mainCounter, $this->language->get('column_coupon'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AE' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('AE' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AF' . $this->mainCounter, $this->language->get('column_coupon_code'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AF' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AG' . $this->mainCounter, $this->language->get('column_order_tax'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AG' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('AG' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AH' . $this->mainCounter, $this->language->get('column_credit'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AH' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('AH' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AI' . $this->mainCounter, $this->language->get('column_voucher'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AI' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('AI' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AJ' . $this->mainCounter, $this->language->get('column_voucher_code'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AJ' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);	

		 $this->objPHPExcel->getActiveSheet()->setCellValue('AK' . $this->mainCounter, $this->language->get('column_commission'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AK' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('AK' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AL' . $this->mainCounter, $this->language->get('column_order_value'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AL' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('AL' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AM' . $this->mainCounter, $this->language->get('column_order_refund'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AM' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('AM' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);			 

		 $this->objPHPExcel->getActiveSheet()->setCellValue('AN' . $this->mainCounter, $this->language->get('column_order_shipping_method'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AN' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AO' . $this->mainCounter, $this->language->get('column_order_payment_method'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AO' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AP' . $this->mainCounter, $this->language->get('column_order_status'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AP' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AQ' . $this->mainCounter, $this->language->get('column_order_store'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AQ' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AR' . $this->mainCounter, $this->language->get('column_customer_cust_id'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AR' . $this->mainCounter)->getFont()->setBold(true);	
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setAutoSize(true);	

		 $this->objPHPExcel->getActiveSheet()->setCellValue('AS' . $this->mainCounter, strip_tags($this->language->get('column_billing_first_name')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AS' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AT' . $this->mainCounter, strip_tags($this->language->get('column_billing_last_name')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AT' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true);	

		 $this->objPHPExcel->getActiveSheet()->setCellValue('AU' . $this->mainCounter, strip_tags($this->language->get('column_billing_company')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AU' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AV' . $this->mainCounter, strip_tags($this->language->get('column_billing_address_1')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AV' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AW' . $this->mainCounter, strip_tags($this->language->get('column_billing_address_2')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AW' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AX' . $this->mainCounter, strip_tags($this->language->get('column_billing_city')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AX' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('AY' . $this->mainCounter, strip_tags($this->language->get('column_billing_zone')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AY' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true);	

		 $this->objPHPExcel->getActiveSheet()->setCellValue('AZ' . $this->mainCounter, strip_tags($this->language->get('column_billing_zone_id')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('AZ' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setAutoSize(true);	

		 $this->objPHPExcel->getActiveSheet()->setCellValue('BA' . $this->mainCounter, strip_tags($this->language->get('column_billing_zone_code')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BA' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BB' . $this->mainCounter, strip_tags($this->language->get('column_billing_postcode')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BB' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BC' . $this->mainCounter, strip_tags($this->language->get('column_billing_country')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BC' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setAutoSize(true);	

		 $this->objPHPExcel->getActiveSheet()->setCellValue('BD' . $this->mainCounter, strip_tags($this->language->get('column_billing_country_id')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BD' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BE' . $this->mainCounter, strip_tags($this->language->get('column_billing_country_code')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BE' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BF' . $this->mainCounter, $this->language->get('column_customer_telephone'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BF' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BG' . $this->mainCounter, strip_tags($this->language->get('column_shipping_first_name')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BG' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BG')->setAutoSize(true);	

		 $this->objPHPExcel->getActiveSheet()->setCellValue('BH' . $this->mainCounter, strip_tags($this->language->get('column_shipping_last_name')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BH' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BH')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BI' . $this->mainCounter, strip_tags($this->language->get('column_shipping_company')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BI' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BI')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BJ' . $this->mainCounter, strip_tags($this->language->get('column_shipping_address_1')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BJ' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BJ')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BK' . $this->mainCounter, strip_tags($this->language->get('column_shipping_address_2')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BK' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BK')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BL' . $this->mainCounter, strip_tags($this->language->get('column_shipping_city')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BL' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BL')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BM' . $this->mainCounter, strip_tags($this->language->get('column_shipping_zone')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BM' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BM')->setAutoSize(true);	

		 $this->objPHPExcel->getActiveSheet()->setCellValue('BN' . $this->mainCounter, strip_tags($this->language->get('column_shipping_zone_id')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BN' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BN')->setAutoSize(true);

		 $this->objPHPExcel->getActiveSheet()->setCellValue('BO' . $this->mainCounter, strip_tags($this->language->get('column_shipping_zone_code')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BO' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BO')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BP' . $this->mainCounter, strip_tags($this->language->get('column_shipping_postcode')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BP' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BP')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BQ' . $this->mainCounter, strip_tags($this->language->get('column_shipping_country')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BQ' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BQ')->setAutoSize(true);	

		 $this->objPHPExcel->getActiveSheet()->setCellValue('BR' . $this->mainCounter, strip_tags($this->language->get('column_shipping_country_id')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BR' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BR')->setAutoSize(true);

		 $this->objPHPExcel->getActiveSheet()->setCellValue('BS' . $this->mainCounter, strip_tags($this->language->get('column_shipping_country_code')));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BS' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BS')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BT' . $this->mainCounter, $this->language->get('column_order_weight'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BT' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getStyle('BT' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BT')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('BU' . $this->mainCounter, $this->language->get('column_order_comment'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('BU' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('BU')->setAutoSize(true);			 
		 
		 if ($export_logo_criteria) {
			$this->objPHPExcel->getActiveSheet()->insertNewRowBefore(1,1);
			$this->objPHPExcel->getActiveSheet()->insertNewRowBefore(1,1);
			$this->objPHPExcel->getActiveSheet()->insertNewRowBefore(1,1);
			$lastCell = $this->objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$lastRow = $this->objPHPExcel->getActiveSheet()->getHighestDataRow();
			
			$this->objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
			$this->objPHPExcel->getActiveSheet()->mergeCells('A1:' . $lastCell . '1');
			$this->objPHPExcel->getActiveSheet()->setCellValue('A1', $this->language->get('text_report_date').": ".date($this->config->get('advpp' . $this->user->getId() . '_hour_format') == '24' ? "Y-m-d H:i:s" : "Y-m-d h:i:s A"));
			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
			$this->objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->objPHPExcel->getActiveSheet()->getStyle('A1:' . $lastCell . '1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$this->objPHPExcel->getActiveSheet()->getStyle('A1:' . $lastCell . '1')->getFill()->getStartColor()->setRGB('DBE5F1');
				
			//Add logo to header
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName($this->config->get('config_name'));
			$objDrawing->setDescription($this->config->get('config_name'));
			$objDrawing->setPath($logo);
			$objDrawing->setCoordinates('A2');
			$objDrawing->setHeight(50);
			$objDrawing->setOffsetX(2);
			$objDrawing->setOffsetY(2);
			$objDrawing->setResizeProportional(false);
			$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());
			
			$this->objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(50);
			$this->objPHPExcel->getActiveSheet()->mergeCells('A2:' . $lastCell . '2');
			$this->objPHPExcel->getActiveSheet()->setCellValue('A2', $this->language->get('heading_title'));
			$this->objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(24);
			$this->objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$this->objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->objPHPExcel->getActiveSheet()->getStyle('A2:' . $lastCell . $lastRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->objPHPExcel->getActiveSheet()->getStyle('A2:' . $lastCell . '2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$this->objPHPExcel->getActiveSheet()->getStyle('A2:' . $lastCell . '2')->getFill()->getStartColor()->setRGB('DBE5F1');
			
			$this->objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(30);
			$this->objPHPExcel->getActiveSheet()->mergeCells('A3:' . $lastCell . '3');
			$this->objPHPExcel->getActiveSheet()->setCellValue('A3', $this->config->get('config_name').", ".$this->config->get('config_address').", ".$this->language->get('text_email')."".$this->config->get('config_email').", ".$this->language->get('text_telephone')."".$this->config->get('config_telephone'));
			$this->objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14);
			$this->objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->objPHPExcel->getActiveSheet()->getStyle('A3:' . $lastCell . $lastRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->objPHPExcel->getActiveSheet()->getStyle('A3:' . $lastCell . '3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$this->objPHPExcel->getActiveSheet()->getStyle('A3:' . $lastCell . '3')->getFill()->getStartColor()->setRGB('DBE5F1');
			
			$this->objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(40);
			$this->objPHPExcel->getActiveSheet()->mergeCells('A4:B4');
			$this->objPHPExcel->getActiveSheet()->setCellValue('A4', $this->language->get('text_report_criteria'));
			$this->objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setSize(10);
			$this->objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
			$this->objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$this->objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
			$this->objPHPExcel->getActiveSheet()->getStyle('A4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$this->objPHPExcel->getActiveSheet()->getStyle('A4')->getFill()->getStartColor()->setRGB('DBE5F1');				
			$this->objPHPExcel->getActiveSheet()->mergeCells('C4:' . $lastCell . '4');
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
			$filter_criteria .= "\r";
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
			$filter_criteria .= "\r";
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
			$this->objPHPExcel->getActiveSheet()->setCellValue('C4', $filter_criteria);
			$this->objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setWrapText(true);
			$this->objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setSize(10);
			$this->objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$this->objPHPExcel->getActiveSheet()->getStyle('C4:' . $lastCell . '4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$this->objPHPExcel->getActiveSheet()->getStyle('C4:' . $lastCell . '4')->getFill()->getStartColor()->setRGB('DBE5F1');			
		 }	
		 
		$freeze = ($export_logo_criteria ? 'C6' : 'C2');
		$this->objPHPExcel->getActiveSheet()->freezePane($freeze);
	}
	
	$counter = ($export_logo_criteria ? $this->mainCounter+4 : $this->mainCounter+1);
		
		foreach ($results as $result) {
		
		$this->objPHPExcel->getActiveSheet()->getStyle('A' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);	
		$this->objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $result['order_id']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $result['date_added']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $result['invoice']);
		 
		$this->objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $result['name']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $result['email']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, html_entity_decode($result['cust_group'], ENT_COMPAT, 'UTF-8'));
		
		$this->objPHPExcel->getActiveSheet()->getStyle('G' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);	
		$this->objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, $result['product_id']);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('H' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$this->objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, $result['product_sku']);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('I' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);		
		$this->objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, $result['product_model']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, html_entity_decode($result['product_name'], ENT_COMPAT, 'UTF-8'));
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('K' . $counter, html_entity_decode($result['product_option'], ENT_COMPAT, 'UTF-8'));

		$this->objPHPExcel->getActiveSheet()->setCellValue('L' . $counter, html_entity_decode($result['product_attributes'], ENT_COMPAT, 'UTF-8'));
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('M' . $counter, html_entity_decode($result['product_manu'], ENT_COMPAT, 'UTF-8'));
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('N' . $counter, html_entity_decode($result['product_category'], ENT_COMPAT, 'UTF-8'));		

		$this->objPHPExcel->getActiveSheet()->setCellValue('O' . $counter, $result['currency_code']);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('P' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('P' . $counter, $result['product_price_raw']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $counter, $result['product_quantity']);

		$this->objPHPExcel->getActiveSheet()->getStyle('R' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('R' . $counter, $result['product_total_excl_vat_raw']);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('S' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('S' . $counter, $result['product_tax_raw']);

		$this->objPHPExcel->getActiveSheet()->getStyle('T' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('T' . $counter, $result['product_total_incl_vat_raw']);

		$this->objPHPExcel->getActiveSheet()->setCellValue('U' . $counter, $result['product_qty_refund']);

		$this->objPHPExcel->getActiveSheet()->getStyle('V' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('V' . $counter, $result['product_refund_raw'] != NULL ? $result['product_refund_raw'] : '0.00');

		$this->objPHPExcel->getActiveSheet()->setCellValue('W' . $counter, $result['product_reward_points']);

		$this->objPHPExcel->getActiveSheet()->getStyle('X' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('X' . $counter, $result['order_sub_total_raw']);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('Y' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('Y' . $counter, $result['order_handling_raw'] != NULL ? $result['order_handling_raw'] : '0.00');
		
		$this->objPHPExcel->getActiveSheet()->getStyle('Z' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('Z' . $counter, $result['order_low_order_fee_raw'] != NULL ? $result['order_low_order_fee_raw'] : '0.00');
		
		$this->objPHPExcel->getActiveSheet()->getStyle('AA' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AA' . $counter, $result['order_shipping_raw'] != NULL ? $result['order_shipping_raw'] : '0.00');
		
		$this->objPHPExcel->getActiveSheet()->getStyle('AB' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AB' . $counter, $result['order_reward_raw'] != NULL ? $result['order_reward_raw'] : '0.00');
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AC' . $counter, $result['order_earned_points']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AD' . $counter, $result['order_used_points']);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('AE' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AE' . $counter, $result['order_coupon_raw'] != NULL ? $result['order_coupon_raw'] : '0.00');

		$this->objPHPExcel->getActiveSheet()->setCellValue('AF' . $counter, $result['order_coupon_code']);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('AG' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AG' . $counter, $result['order_tax_raw'] != NULL ? $result['order_tax_raw'] : '0.00');
		
		$this->objPHPExcel->getActiveSheet()->getStyle('AH' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AH' . $counter, $result['order_credit_raw'] != NULL ? $result['order_credit_raw'] : '0.00');
		
		$this->objPHPExcel->getActiveSheet()->getStyle('AI' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AI' . $counter, $result['order_voucher_raw'] != NULL ? $result['order_voucher_raw'] : '0.00');

		$this->objPHPExcel->getActiveSheet()->setCellValue('AJ' . $counter, $result['order_voucher_code']);

		$this->objPHPExcel->getActiveSheet()->getStyle('AK' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AK' . $counter, -$result['order_commission_raw']);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('AL' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AL' . $counter, $result['order_value_raw']);

		$this->objPHPExcel->getActiveSheet()->getStyle('AM' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('AM' . $counter, $result['order_refund_raw'] != NULL ? $result['order_refund_raw'] : '0.00');

		$this->objPHPExcel->getActiveSheet()->setCellValue('AN' . $counter, $result['shipping_method']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AO' . $counter, $result['payment_method']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AP' . $counter, $result['order_status']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AQ' . $counter, html_entity_decode($result['store_name'], ENT_COMPAT, 'UTF-8'));
		
		$this->objPHPExcel->getActiveSheet()->getStyle('AR' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);	
		$this->objPHPExcel->getActiveSheet()->setCellValue('AR' . $counter, $result['customer_id']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AS' . $counter, $result['payment_firstname']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AT' . $counter, $result['payment_lastname']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AU' . $counter, $result['payment_company']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AV' . $counter, $result['payment_address_1']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AW' . $counter, $result['payment_address_2']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AX' . $counter, $result['payment_city']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('AY' . $counter, $result['payment_zone']);

		$this->objPHPExcel->getActiveSheet()->getStyle('AZ' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$this->objPHPExcel->getActiveSheet()->setCellValue('AZ' . $counter, $result['payment_zone_id']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BA' . $counter, $result['payment_zone_code']);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('BB' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BB' . $counter, $result['payment_postcode']);

		$this->objPHPExcel->getActiveSheet()->setCellValue('BC' . $counter, $result['payment_country']);

		$this->objPHPExcel->getActiveSheet()->getStyle('BD' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$this->objPHPExcel->getActiveSheet()->setCellValue('BD' . $counter, $result['payment_country_id']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BE' . $counter, $result['payment_country_code']);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('BF' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BF' . $counter, $result['telephone']);

		$this->objPHPExcel->getActiveSheet()->setCellValue('BG' . $counter, $result['shipping_firstname']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BH' . $counter, $result['shipping_lastname']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BI' . $counter, $result['shipping_company']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BJ' . $counter, $result['shipping_address_1']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BK' . $counter, $result['shipping_address_2']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BL' . $counter, $result['shipping_city']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BM' . $counter, $result['shipping_zone']);

		$this->objPHPExcel->getActiveSheet()->getStyle('BN' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$this->objPHPExcel->getActiveSheet()->setCellValue('BN' . $counter, $result['shipping_zone_id']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BO' . $counter, $result['shipping_zone_code']);
		
		$this->objPHPExcel->getActiveSheet()->getStyle('BP' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);			
		$this->objPHPExcel->getActiveSheet()->setCellValue('BP' . $counter, $result['shipping_postcode']);

		$this->objPHPExcel->getActiveSheet()->setCellValue('BQ' . $counter, $result['shipping_country']);

		$this->objPHPExcel->getActiveSheet()->getStyle('BR' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$this->objPHPExcel->getActiveSheet()->setCellValue('BR' . $counter, $result['shipping_country_id']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BS' . $counter, $result['shipping_country_code']);

		$this->objPHPExcel->getActiveSheet()->getStyle('BT' . $counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->objPHPExcel->getActiveSheet()->setCellValue('BT' . $counter, $result['order_weight']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('BU' . $counter, html_entity_decode($result['order_comment'], ENT_COMPAT, 'UTF-8'));
		
		$counter++;
		$this->mainCounter++;
	}

	$lastRow = $this->objPHPExcel->getActiveSheet()->getHighestRow();


	if (!in_array('all_order_comment', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BU');
	}

	if (!in_array('all_order_weight', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BT');
	}
	
	if (!in_array('all_shipping_country_code', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BS');
	}

	if (!in_array('all_shipping_country_id', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BR');
	}
	
	if (!in_array('all_shipping_country', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BQ');
	}
	
	if (!in_array('all_shipping_postcode', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BP');
	}
	
	if (!in_array('all_shipping_zone_code', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BO');
	}


	if (!in_array('all_shipping_zone_id', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BN');
	}
	
	if (!in_array('all_shipping_zone', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BM');
	}
	
	if (!in_array('all_shipping_city', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BL');
	}
	
	if (!in_array('all_shipping_address_2', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BK');
	}

	if (!in_array('all_shipping_address_1', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BJ');
	}
	
	if (!in_array('all_shipping_company', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BI');	
	}
	
	if (!in_array('all_shipping_last_name', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BH');
	}

	if (!in_array('all_shipping_first_name', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BG');
	}
	
	if (!in_array('all_customer_telephone', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BF');
	}
	
	if (!in_array('all_billing_country_code', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BE');	
	}

	if (!in_array('all_billing_country_id', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BD');	
	}
	
	if (!in_array('all_billing_country', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BC');	
	}
	
	if (!in_array('all_billing_postcode', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BB');
	}
	
	if (!in_array('all_billing_zone_code', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('BA');	
	}

	if (!in_array('all_billing_zone_id', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AZ');	
	}

	if (!in_array('all_billing_zone', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AY');	
	}
	
	if (!in_array('all_billing_city', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AX');
	}
	
	if (!in_array('all_billing_address_2', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AW');
	}
	
	if (!in_array('all_billing_address_1', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AV');	
	}
	
	if (!in_array('all_billing_company', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AU');	
	}
	
	if (!in_array('all_billing_last_name', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AT');	
	}

	if (!in_array('all_billing_first_name', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AS');	
	}
	
	if (!in_array('all_customer_cust_id', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AR');	
	}
	
	if (!in_array('all_order_store', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AQ');	
	}	

	if (!in_array('all_order_status', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AP');	
	}
	
	if (!in_array('all_order_payment_method', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AO');	
	}

	if (!in_array('all_order_shipping_method', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AN');	
	}

	if (!in_array('all_refund', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AM');	
	}
	
	if (!in_array('all_order_value', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AL');	
	}

	if (!in_array('all_order_commission', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AK');	
	}
	
	if (!in_array('all_voucher_code', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AJ');	
	}
	
	if (!in_array('all_voucher', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AI');	
	}
	
	if (!in_array('all_credit', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AH');	
	}
	
	if (!in_array('all_order_tax', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AG');	
	}
	
	if (!in_array('all_coupon_code', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AF');	
	}
	
	if (!in_array('all_coupon', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AE');	
	}

	if (!in_array('all_reward_points', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AD');	
	}
	
	if (!in_array('all_reward_points', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AC');	
	}
	
	if (!in_array('all_reward', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AB');	
	}
	
	if (!in_array('all_shipping', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('AA');	
	}
	
	if (!in_array('all_loworder', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('Z');	
	}
	
	if (!in_array('all_handling', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('Y');	
	}
	
	if (!in_array('all_sub_total', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('X');	
	}
	
	if (!in_array('all_prod_reward_points', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('W');	
	}

	if (!in_array('all_prod_refund', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('V');	
	}
	
	if (!in_array('all_prod_qty_refund', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('U');	
	}

	if (!in_array('all_prod_total_incl_vat', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('T');	
	}

	if (!in_array('all_prod_tax', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('S');	
	}
	
	if (!in_array('all_prod_total_excl_vat', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('R');	
	}
	
	if (!in_array('all_prod_quantity', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('Q');	
	}
	
	if (!in_array('all_prod_price', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('P');	
	}
	
	if (!in_array('all_prod_currency', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('O');	
	}
	
	if (!in_array('all_prod_category', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('N');	
	}
	
	if (!in_array('all_prod_manu', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('M');	
	}
	
	if (!in_array('all_prod_attributes', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('L');	
	}
	
	if (!in_array('all_prod_option', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('K');	
	}
	
	if (!in_array('all_prod_name', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('J');	
	}
	
	if (!in_array('all_prod_model', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('I');	
	}
	
	if (!in_array('all_prod_sku', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('H');	
	}
	
	if (!in_array('all_prod_id', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('G');	
	}
	
	if (!in_array('all_order_customer_group', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('F');	
	}
	
	if (!in_array('all_order_email', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('E');	
	}
	
	if (!in_array('all_order_customer_name', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('D');	
	}
	
	if (!in_array('all_order_inv_no', $advpp_settings_all_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('C');	
	}

	if (!in_array('all_order_comment', $advpp_settings_all_columns)) {
		$lastCellA = $this->objPHPExcel->getActiveSheet()->getHighestDataColumn();	
		$lastCellB = $this->objPHPExcel->getActiveSheet()->getHighestDataRow();
		$this->objPHPExcel->getActiveSheet()->getCellCacheController()->deleteCacheData($lastCellA . $lastCellB);
	}
	
	$filename = "products_report_all_details_".date($this->config->get('advpp' . $this->user->getId() . '_hour_format') == '24' ? "Y-m-d_H-i-s" : "Y-m-d_h-i-s-A");
	header('Expires: 0');
	header('Cache-control: private');
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8; encoding=UTF-8');
	header('Content-Disposition: attachment;filename='.$filename.".xlsx");
	header('Content-Transfer-Encoding: UTF-8');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit();
	}
?>