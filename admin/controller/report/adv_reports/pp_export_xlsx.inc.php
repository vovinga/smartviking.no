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
									   ->setDescription("ADV Products Report with No Details")
									   ->setKeywords("office 2007 excel")
									   ->setCategory("www.opencartreports.com");
	$this->objPHPExcel->setActiveSheetIndex(0);
	$export_logo_criteria ? $this->mainCounter = 2 : $this->mainCounter = 1;
	if ($export_logo_criteria ? $this->mainCounter = 2 : $this->mainCounter = 1) {
		 if ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') {
		 $this->objPHPExcel->getActiveSheet()->mergeCells('A' . $this->mainCounter.":".'B' . $this->mainCounter);	 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $this->mainCounter, $this->language->get('column_date_added'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('A' . $this->mainCounter)->getFont()->setBold(true);		
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);	
		 } else {
		 if ($filter_group == 'year') {
		 $this->objPHPExcel->getActiveSheet()->mergeCells('A' . $this->mainCounter.":".'B' . $this->mainCounter);	 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $this->mainCounter, $this->language->get('column_year'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('A' . $this->mainCounter)->getFont()->setBold(true);		
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);		 
		 } elseif ($filter_group == 'quarter') {
		 $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $this->mainCounter, $this->language->get('column_year'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('A' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $this->mainCounter, $this->language->get('column_quarter'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('B' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);		 
		 } elseif ($filter_group == 'month') {
		 $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $this->mainCounter, $this->language->get('column_year'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('A' . $this->mainCounter)->getFont()->setBold(true);	
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $this->mainCounter, $this->language->get('column_month'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('B' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);		 
		 } elseif ($filter_group == 'day') {
		 $this->objPHPExcel->getActiveSheet()->mergeCells('A' . $this->mainCounter.":".'B' . $this->mainCounter);
		 $this->objPHPExcel->getActiveSheet()->getStyle('A' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $this->mainCounter, $this->language->get('column_date'));
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);		 
		 } elseif ($filter_group == 'order') {
		 $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $this->mainCounter, $this->language->get('column_order_order_id'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('A' . $this->mainCounter)->getFont()->setBold(true);	 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $this->mainCounter, $this->language->get('column_order_date_added'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('B' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);		 
		 } else {
		 $this->objPHPExcel->getActiveSheet()->setCellValue('A' . $this->mainCounter, $this->language->get('column_date_start'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('A' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('B' . $this->mainCounter, $this->language->get('column_date_end'));	
		 $this->objPHPExcel->getActiveSheet()->getStyle('B' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);		 
		 }
		 }
		 
		 if ($filter_report != 'products_purchased_with_options' && $filter_report != 'manufacturers' && $filter_report != 'categories') {
			 
		 $this->objPHPExcel->getActiveSheet()->getStyle('C' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $this->mainCounter, $this->language->get('column_id'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('C' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $this->mainCounter, $this->language->get('column_sku'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('D' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);	
		  
		 $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $this->mainCounter, $this->language->get('column_pname'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('E' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $this->mainCounter, $this->language->get('column_model'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('F' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $this->mainCounter, $this->language->get('column_category'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('G' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $this->mainCounter, $this->language->get('column_manufacturer'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('H' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

		 $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $this->mainCounter, $this->language->get('column_attribute'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('I' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

		 $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $this->mainCounter, $this->language->get('column_status'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('J' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $this->mainCounter, $this->language->get('column_location'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('K' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('L' . $this->mainCounter, $this->language->get('column_tax_class'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('L' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('M' . $this->mainCounter, $this->language->get('column_price'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('M' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('M' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('N' . $this->mainCounter, $this->language->get('column_viewed'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('N' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('N' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('O' . $this->mainCounter, $this->language->get('column_stock_quantity'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('O' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('O' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

		 if ($filter_report != 'products_without_orders') {
		 $this->objPHPExcel->getActiveSheet()->setCellValue('P' . $this->mainCounter, $this->language->get('column_sold_quantity'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('P' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('P' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $this->mainCounter, $this->language->get('column_sold_percent'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('Q' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('Q' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('R' . $this->mainCounter, $this->language->get('column_prod_total_excl_vat'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('R' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('R' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('S' . $this->mainCounter, $this->language->get('column_total_tax'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('S' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('S' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('T' . $this->mainCounter, $this->language->get('column_prod_total_incl_vat'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('T' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('T' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('U' . $this->mainCounter, $this->language->get('column_app'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('U' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('U' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('V' . $this->mainCounter, $this->language->get('column_product_refunds'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('V' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('V' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('W' . $this->mainCounter, $this->language->get('column_product_reward_points'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('W' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('W' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
		 }
		 
		 } elseif ($filter_report == 'products_purchased_with_options') {
			 
		 $this->objPHPExcel->getActiveSheet()->getStyle('C' . $this->mainCounter)->getFont()->setBold(true);		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $this->mainCounter, $this->language->get('column_id'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('C' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $this->mainCounter, $this->language->get('column_sku'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('D' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);	
		  
		 $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $this->mainCounter, $this->language->get('column_pname'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('E' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);	

		 $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $this->mainCounter, $this->language->get('column_poption'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('F' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);	
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $this->mainCounter, $this->language->get('column_model'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('G' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $this->mainCounter, $this->language->get('column_category'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('H' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $this->mainCounter, $this->language->get('column_manufacturer'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('I' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

		 $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $this->mainCounter, $this->language->get('column_attribute'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('J' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

		 $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $this->mainCounter, $this->language->get('column_status'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('K' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('L' . $this->mainCounter, $this->language->get('column_location'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('L' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('M' . $this->mainCounter, $this->language->get('column_tax_class'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('M' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('N' . $this->mainCounter, $this->language->get('column_price'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('N' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('N' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('O' . $this->mainCounter, $this->language->get('column_viewed'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('O' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('O' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('P' . $this->mainCounter, $this->language->get('column_stock_quantity'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('P' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('P' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

		 $this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $this->mainCounter, $this->language->get('column_sold_quantity'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('Q' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('Q' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('R' . $this->mainCounter, $this->language->get('column_sold_percent'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('R' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('R' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('S' . $this->mainCounter, $this->language->get('column_prod_total_excl_vat'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('S' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('S' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('T' . $this->mainCounter, $this->language->get('column_total_tax'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('T' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('T' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('U' . $this->mainCounter, $this->language->get('column_prod_total_incl_vat'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('U' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('U' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('V' . $this->mainCounter, $this->language->get('column_app'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('V' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('V' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('W' . $this->mainCounter, $this->language->get('column_product_refunds'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('W' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('W' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('X' . $this->mainCounter, $this->language->get('column_product_reward_points'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('X' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('X' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);

		 } elseif ($filter_report == 'manufacturers' or $filter_report == 'categories') {
			 
		 if ($filter_report == 'manufacturers') {
		 $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $this->mainCounter, $this->language->get('column_manufacturer'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('C' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		 } elseif ($filter_report == 'categories') {
		 $this->objPHPExcel->getActiveSheet()->setCellValue('C' . $this->mainCounter, $this->language->get('column_category'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('C' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		 }	
		 $this->objPHPExcel->getActiveSheet()->setCellValue('D' . $this->mainCounter, $this->language->get('column_sold_quantity'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('D' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('D' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('E' . $this->mainCounter, $this->language->get('column_sold_percent'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('E' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('E' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('F' . $this->mainCounter, $this->language->get('column_prod_total_excl_vat'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('F' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('F' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('G' . $this->mainCounter, $this->language->get('column_total_tax'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('G' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('G' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('H' . $this->mainCounter, $this->language->get('column_prod_total_incl_vat'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('H' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('H' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('I' . $this->mainCounter, $this->language->get('column_app'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('I' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('I' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('J' . $this->mainCounter, $this->language->get('column_product_refunds'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('J' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('J' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		 
		 $this->objPHPExcel->getActiveSheet()->setCellValue('K' . $this->mainCounter, $this->language->get('column_product_reward_points'));
		 $this->objPHPExcel->getActiveSheet()->getStyle('K' . $this->mainCounter)->getFont()->setBold(true);
		 $this->objPHPExcel->getActiveSheet()->getStyle('K' . $this->mainCounter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		 
		 $this->objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		 }

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
		 
		$freeze = ($export_logo_criteria ? 'A6' : 'A2');
		$this->objPHPExcel->getActiveSheet()->freezePane($freeze);
	}
	
	$counter = ($export_logo_criteria ? $this->mainCounter+4 : $this->mainCounter+1);
		
	foreach ($results as $result) {			
		if ($filter_report == 'all_products_with_without_orders' or $filter_report == 'products_without_orders') {
		$this->objPHPExcel->getActiveSheet()->mergeCells('A' . $counter.":".'B' . $counter);
		$this->objPHPExcel->getActiveSheet()->getStyle('A' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);		
		$this->objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $result['date_added']);
		} else {			
		if ($filter_group == 'year') {
		$this->objPHPExcel->getActiveSheet()->mergeCells('A' . $counter.":".'B' . $counter);
		$this->objPHPExcel->getActiveSheet()->getStyle('A' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);		
		$this->objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $result['year']);
		} elseif ($filter_group == 'quarter') {
		$this->objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $result['year']);
		$this->objPHPExcel->getActiveSheet()->getStyle('A' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);		
		$this->objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $result['quarter']);			
		} elseif ($filter_group == 'month') {
		$this->objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $result['year']);
		$this->objPHPExcel->getActiveSheet()->getStyle('A' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);		
		$this->objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $result['month']);
		} elseif ($filter_group == 'day') {
		$this->objPHPExcel->getActiveSheet()->mergeCells('A' . $counter.":".'B' . $counter);
		$this->objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $result['date_start']);
		} elseif ($filter_group == 'order') {
		$this->objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $result['order_id']);
		$this->objPHPExcel->getActiveSheet()->getStyle('A' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);			
		$this->objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $result['date_start']);
		} else {
		$this->objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $result['date_start']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $result['date_end']);				 
		}
		}

		if ($filter_report != 'products_purchased_with_options' && $filter_report != 'manufacturers' && $filter_report != 'categories') {
			
		$this->objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $result['product_id']);

		$this->objPHPExcel->getActiveSheet()->getStyle('D' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$this->objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $result['sku']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, html_entity_decode($result['name']));

		$this->objPHPExcel->getActiveSheet()->getStyle('F' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$this->objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, $result['model']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, html_entity_decode($result['categories']));
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, html_entity_decode($result['manufacturers']));
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, html_entity_decode(str_replace('<br>','; ',$result['attribute'])));
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, $result['status']);
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('K' . $counter, $result['location']);
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('L' . $counter, $result['tax_class']);

		$this->objPHPExcel->getActiveSheet()->getStyle('M' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('M' . $counter, $result['price_raw']);
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('N' . $counter, $result['viewed']);
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('O' . $counter, $result['stock_quantity']);

		if ($filter_report != 'products_without_orders') {
		$this->objPHPExcel->getActiveSheet()->setCellValue('P' . $counter, $result['sold_quantity']);

		if (!is_null($result['sold_quantity'])) {
		$this->objPHPExcel->getActiveSheet()->getStyle('Q' . $counter)->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));		
		$this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $counter, round(100 * ($result['sold_quantity'] / $result['sold_quantity_total']), 2)/100);	
		} else {
		$this->objPHPExcel->getActiveSheet()->getStyle('Q' . $counter)->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));			
		$this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $counter, '0');
		}	

		$this->objPHPExcel->getActiveSheet()->getStyle('R' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('R' . $counter, $result['total_excl_vat_raw'] != NULL ? $result['total_excl_vat_raw'] : '0.00');

		$this->objPHPExcel->getActiveSheet()->getStyle('S' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('S' . $counter, $result['total_tax_raw'] != NULL ? $result['total_tax_raw'] : '0.00');

		$this->objPHPExcel->getActiveSheet()->getStyle('T' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('T' . $counter, $result['total_incl_vat_raw'] != NULL ? $result['total_incl_vat_raw'] : '0.00');

		$this->objPHPExcel->getActiveSheet()->getStyle('U' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('U' . $counter, $result['app_raw'] != NULL ? $result['app_raw'] : '0.00');

		$this->objPHPExcel->getActiveSheet()->getStyle('V' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('V' . $counter, $result['refunds_raw'] != NULL ? $result['refunds_raw'] : '0.00');
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('W' . $counter, $result['reward_points']);
		}
		
		} elseif ($filter_report == 'products_purchased_with_options') {

		$this->objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $result['product_id']);

		$this->objPHPExcel->getActiveSheet()->getStyle('D' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$this->objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $result['sku']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, html_entity_decode($result['name']));
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, html_entity_decode($result['options']));

		$this->objPHPExcel->getActiveSheet()->getStyle('G' . $counter)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$this->objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, $result['model']);
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, html_entity_decode($result['categories']));
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, html_entity_decode($result['manufacturers']));
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, html_entity_decode(str_replace('<br>','; ',$result['attribute'])));
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('K' . $counter, $result['status']);
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('L' . $counter, $result['location']);
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('M' . $counter, $result['tax_class']);

		$this->objPHPExcel->getActiveSheet()->getStyle('N' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('N' . $counter, $result['price_raw']);
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('O' . $counter, $result['viewed']);
				
		$this->objPHPExcel->getActiveSheet()->setCellValue('P' . $counter, $result['stock_quantity']);

		$this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $counter, $result['sold_quantity']);

		if (!is_null($result['sold_quantity'])) {
		$this->objPHPExcel->getActiveSheet()->getStyle('R' . $counter)->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));		
		$this->objPHPExcel->getActiveSheet()->setCellValue('R' . $counter, round(100 * ($result['sold_quantity'] / $result['sold_quantity_total']), 2)/100);	
		} else {
		$this->objPHPExcel->getActiveSheet()->getStyle('R' . $counter)->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));			
		$this->objPHPExcel->getActiveSheet()->setCellValue('R' . $counter, '0');
		}	

		$this->objPHPExcel->getActiveSheet()->getStyle('S' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('S' . $counter, $result['total_excl_vat_raw']);

		$this->objPHPExcel->getActiveSheet()->getStyle('T' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('T' . $counter, $result['total_tax_raw']);

		$this->objPHPExcel->getActiveSheet()->getStyle('U' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('U' . $counter, $result['total_incl_vat_raw']);

		$this->objPHPExcel->getActiveSheet()->getStyle('V' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('V' . $counter, $result['app_raw']);

		$this->objPHPExcel->getActiveSheet()->getStyle('W' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('W' . $counter, $result['refunds_raw'] != NULL ? $result['refunds_raw'] : '0.00');
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('X' . $counter, $result['reward_points']);
		
		} elseif ($filter_report == 'manufacturers' or $filter_report == 'categories') {
		
		if ($filter_report == 'manufacturers') {
		$this->objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, html_entity_decode($result['manufacturers']));
		} elseif ($filter_report == 'categories') {
		$this->objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, html_entity_decode($result['categories']));
		}	

		$this->objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $result['sold_quantity']);

		if (!is_null($result['sold_quantity'])) {
		$this->objPHPExcel->getActiveSheet()->getStyle('E' . $counter)->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));		
		$this->objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, round(100 * ($result['sold_quantity'] / $result['sold_quantity_total']), 2)/100);	
		} else {
		$this->objPHPExcel->getActiveSheet()->getStyle('E' . $counter)->getNumberFormat()->applyFromArray(array('code' => PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00));			
		$this->objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, '0');
		}	

		$this->objPHPExcel->getActiveSheet()->getStyle('F' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, $result['total_excl_vat_raw']);

		$this->objPHPExcel->getActiveSheet()->getStyle('G' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, $result['total_tax_raw']);

		$this->objPHPExcel->getActiveSheet()->getStyle('H' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, $result['total_incl_vat_raw']);

		$this->objPHPExcel->getActiveSheet()->getStyle('I' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, $result['app_raw']);

		$this->objPHPExcel->getActiveSheet()->getStyle('J' . $counter)->getNumberFormat()->setFormatCode('0.00');
		$this->objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, $result['refunds_raw'] != NULL ? $result['refunds_raw'] : '0.00');
		
		$this->objPHPExcel->getActiveSheet()->setCellValue('K' . $counter, $result['reward_points']);
		}
		
		$counter++;
		$this->mainCounter++;
	}
	
	if ($filter_report != 'products_purchased_with_options' && $filter_report != 'manufacturers' && $filter_report != 'categories') {
	
	if ($filter_report != 'products_without_orders') {
	if (!in_array('mv_reward_points', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('W');	
	}
	
	if (!in_array('mv_refunds', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('V');	
	}
	
	if (!in_array('mv_app', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('U');	
	}
	
	if (!in_array('mv_total_incl_vat', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('T');	
	}
	
	if (!in_array('mv_total_tax', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('S');	
	}
	
	if (!in_array('mv_total_excl_vat', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('R');	
	}
	
	if (!in_array('mv_sold_percent', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('Q');	
	}
	
	if (!in_array('mv_sold_quantity', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('P');	
	}
	}
	
	if (!in_array('mv_stock_quantity', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('O');	
	}
	
	if (!in_array('mv_viewed', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('N');	
	}
	
	if (!in_array('mv_price', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('M');	
	}
	
	if (!in_array('mv_tax_class', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('L');	
	}
	
	if (!in_array('mv_location', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('K');	
	}
	
	if (!in_array('mv_status', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('J');	
	}
	
	if (!in_array('mv_attribute', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('I');	
	}
	
	if (!in_array('mv_manufacturer', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('H');	
	}
	
	if (!in_array('mv_category', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('G');	
	}
	
	if (!in_array('mv_model', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('F');	
	}
	
	if (!in_array('mv_name', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('E');	
	}
	
	if (!in_array('mv_sku', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('D');	
	}
	
	if (!in_array('mv_id', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('C');	
	}
	
	} elseif ($filter_report == 'products_purchased_with_options') {

	if (!in_array('mv_reward_points', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('X');	
	}
	
	if (!in_array('mv_refunds', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('W');	
	}
	
	if (!in_array('mv_app', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('V');	
	}
	
	if (!in_array('mv_total_incl_vat', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('U');	
	}
	
	if (!in_array('mv_total_tax', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('T');	
	}
	
	if (!in_array('mv_total_excl_vat', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('S');	
	}
	
	if (!in_array('mv_sold_percent', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('R');	
	}
	
	if (!in_array('mv_sold_quantity', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('Q');	
	}
	
	if (!in_array('mv_stock_quantity', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('P');	
	}
	
	if (!in_array('mv_viewed', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('O');	
	}
	
	if (!in_array('mv_price', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('N');	
	}
	
	if (!in_array('mv_tax_class', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('M');	
	}
	
	if (!in_array('mv_location', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('L');	
	}
	
	if (!in_array('mv_status', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('K');	
	}
	
	if (!in_array('mv_attribute', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('J');	
	}
	
	if (!in_array('mv_manufacturer', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('I');	
	}
	
	if (!in_array('mv_category', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('H');	
	}
	
	if (!in_array('mv_model', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('G');	
	}

	if (!in_array('mv_name', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('F');	
	}
	
	if (!in_array('mv_name', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('E');	
	}
	
	if (!in_array('mv_sku', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('D');	
	}
	
	if (!in_array('mv_id', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('C');	
	}

	} elseif ($filter_report == 'manufacturers' or $filter_report == 'categories') {

	if (!in_array('mv_reward_points', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('K');	
	}
	
	if (!in_array('mv_refunds', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('J');	
	}
	
	if (!in_array('mv_app', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('I');	
	}
	
	if (!in_array('mv_total_incl_vat', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('H');	
	}
	
	if (!in_array('mv_total_tax', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('G');	
	}
	
	if (!in_array('mv_total_excl_vat', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('F');	
	}
	
	if (!in_array('mv_sold_percent', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('E');	
	}
	
	if (!in_array('mv_sold_quantity', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('D');	
	}
	
	if ($filter_report == 'manufacturers') {
	if (!in_array('mv_manufacturer', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('C');
	}
	} elseif ($filter_report == 'categories') {
	if (!in_array('mv_category', $advpp_settings_mv_columns)) {
		$this->objPHPExcel->getActiveSheet()->removeColumn('C');
	}
	}
	}
	
	if ($filter_report != 'products_without_orders') {
	if (!in_array('mv_reward_points', $advpp_settings_mv_columns)) {
		$lastCellA = $this->objPHPExcel->getActiveSheet()->getHighestDataColumn();	
		$lastCellB = $this->objPHPExcel->getActiveSheet()->getHighestDataRow();
		$this->objPHPExcel->getActiveSheet()->getCellCacheController()->deleteCacheData($lastCellA . $lastCellB);
	}
	} else {
	if (!in_array('mv_stock_quantity', $advpp_settings_mv_columns)) {
		$lastCellA = $this->objPHPExcel->getActiveSheet()->getHighestDataColumn();	
		$lastCellB = $this->objPHPExcel->getActiveSheet()->getHighestDataRow();
		$this->objPHPExcel->getActiveSheet()->getCellCacheController()->deleteCacheData($lastCellA . $lastCellB);
	}
	}
	
	$filename = "products_report_".date($this->config->get('advpp' . $this->user->getId() . '_hour_format') == '24' ? "Y-m-d_H-i-s" : "Y-m-d_h-i-s-A");
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