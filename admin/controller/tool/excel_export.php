<?php 
class ControllerToolExcelExport extends Controller { 
	private $error = array();
	
	public function index() {
		$this->load->language('tool/excel_export');
		$this->load->model('tool/excel_export');
		
		if(isset($_GET['alert']) AND $_GET['alert'] == 'success'){
      $this->data['success_alert'] = $this->language->get('text_success');
    }else{$this->data['success_alert'] = '';}
		
		if(isset($_GET['alert']) AND $_GET['alert'] == 'warning'){
      $this->data['warning'] = $this->language->get('text_error_warning');
    }else{$this->data['warning'] = '';}
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		// echo '<pre>';
		// print_r($this->request->post);die();
      $xml = $this->model_tool_excel_export->exportExcel($this->request->post);
      if($xml){
        $this->redirect($this->url->link('tool/excel_export', 'token=' . $this->session->data['token'].'&alert=success&download='.$xml, 'SSL'));
      }else{
        $this->redirect($this->url->link('tool/excel_export', 'token=' . $this->session->data['token'].'&alert=warning', 'SSL'));
      }
    }
    
    
		if(isset($_GET['download'])){$this->redirect('../download/'.$_GET['download']);}
		
		
		$this->document->setTitle($this->language->get('heading_title'));
		$this->data['heading_title']                  = $this->language->get('heading_title');
		$this->data['text_download_excel']            = $this->language->get('text_download_excel');
		$this->data['text_product_id']                = $this->language->get('text_product_id');
		$this->data['text_model']                     = $this->language->get('text_model');
		$this->data['text_sku']                       = $this->language->get('text_sku');
		$this->data['text_cost']                       = $this->language->get('text_cost');
		$this->data['text_upc']                       = $this->language->get('text_upc');
		$this->data['text_location']                  = $this->language->get('text_location');
		$this->data['text_quantity']                  = $this->language->get('text_quantity');
		$this->data['text_stock_status']              = $this->language->get('text_stock_status');
		$this->data['text_manufacturer']              = $this->language->get('text_manufacturer');
		$this->data['text_price']                     = $this->language->get('text_price');
		$this->data['text_points']                    = $this->language->get('text_points');
		$this->data['text_tax_class']                 = $this->language->get('text_tax_class');
		$this->data['text_weight']                    = $this->language->get('text_weight');
		$this->data['text_weight_class']              = $this->language->get('text_weight_class');
		$this->data['text_length']                    = $this->language->get('text_length');
		$this->data['text_length_class']              = $this->language->get('text_length_class');
		$this->data['text_width']                     = $this->language->get('text_width');
		$this->data['text_height']                    = $this->language->get('text_height');
		$this->data['text_minimum']                   = $this->language->get('text_minimum');
		$this->data['text_sort_order']                = $this->language->get('text_sort_order');
		$this->data['text_status']                    = $this->language->get('text_status');
		$this->data['text_date_available']            = $this->language->get('text_date_available');
		$this->data['text_date_added']                = $this->language->get('text_date_added');
		$this->data['text_date_modified']             = $this->language->get('text_date_modified');
		$this->data['text_viewed']                    = $this->language->get('text_viewed');
		$this->data['text_name']                      = $this->language->get('text_name');
		$this->data['text_description']               = $this->language->get('text_description');
		$this->data['text_meta_description']          = $this->language->get('text_meta_description');
		$this->data['text_meta_keyword']              = $this->language->get('text_meta_keyword');
		$this->data['text_images']                    = $this->language->get('text_images');
		$this->data['text_product_attribute']         = $this->language->get('text_product_attribute');
		$this->data['text_product_option']            = $this->language->get('text_product_option');
		$this->data['text_category']                  = $this->language->get('text_category');
		$this->data['text_export']                    = $this->language->get('text_export');
		$this->data['text_checked']                   = $this->language->get('text_checked');
		$this->data['text_check_main_data']           = $this->language->get('text_check_main_data');
		$this->data['text_check_all']                 = $this->language->get('text_check_all');
		$this->data['text_check_none']                = $this->language->get('text_check_none');
		$this->data['text_select_language']           = $this->language->get('text_select_language');
		$this->data['text_check_all_important_data']  = $this->language->get('text_check_all_important_data');
		$this->data['text_ean']                       = $this->language->get('text_ean');
		$this->data['text_jan']                       = $this->language->get('text_jan');
		$this->data['text_isbn']                      = $this->language->get('text_isbn');
		$this->data['text_mpn']                       = $this->language->get('text_mpn');
		
		

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		
		
		
		
		$this->data['breadcrumbs'] = array();
 		$this->data['breadcrumbs'][] = array(
   		'text'      => $this->language->get('text_home'),
    	'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),     		
  		'separator' => false
 		);
 		$this->data['breadcrumbs'][] = array(
   		'text'      => $this->language->get('heading_title'),
	    'href'      => $this->url->link('tool/excel_export', 'token=' . $this->session->data['token'], 'SSL'),
  		'separator' => ' :: '
 		);
	
		
		
		$this->data['languages'] = $this->model_tool_excel_export->getLanguages();
				
				
				
				
				
				
				
				
				
				
				
				
		$this->template = 'tool/excel_export.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	public function backup() {
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
//hmm
	}
	

}
}
?>