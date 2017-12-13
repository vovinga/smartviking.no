<?php
// Heading
$_['heading_title']							= 'ADV Profit Reports';

//Tab
$_['tab_database']							= 'Database';
$_['tab_payment_cost']						= 'Payment Costs';
$_['tab_shipping_cost']						= 'Shipping Costs';
$_['tab_about']            					= 'About';

// Text
$_['text_module']							= 'Modules';
$_['text_asking_help']						= 'Read before requesting for support';
$_['text_help_request']						= 'Requesting for support';
$_['text_terms']							= 'Terms & Conditions';
$_['text_success']							= 'Success: You have modified module ADV Profit Reports!';
$_['text_set_order_product_cost_confirm'] 	= 'Are you sure you want set actual PRODUCT COSTS to ALL orders?';
$_['text_set_order_product_cost_success']	= 'Actual Product Costs was successfully set!';
$_['text_set_set_order_product_cost'] 		= '<span class="help">Make a backup before you use this option! (Admin -> System -> Backup / Restore)<br />Use this button to set the product costs in received orders at first use of ADV Profit extension.<br />All product costs in orders before installing ADV Profit extension will be modified and set to actual product costs.<br /><span style="color:#F00;">You need to enter all your <b>product costs</b> and <b>product option costs</b> in the product form page for use this option.</span></span>';

// Entry
$_['entry_set_order_product_cost'] 			= 'Set Product Costs to All Orders:';

$_['entry_adv_payment_cost_status']     	= 'Payment Costs Status:<br/><span class="help">Enable or disable payment costs option</span>';
$_['entry_adv_payment_cost_total']  		= 'Order Total:<br/><span class="help">Checkout Order Total amount needed before the payment costs will be added.</span>';
$_['entry_adv_payment_cost_payment_type'] 	= 'Payment Methods:<br/><span class="help">Choose the payment method</span>';
$_['entry_adv_payment_cost_percentage'] 	= 'Percentage:<br/><span class="help">Percentage to be charged<br />(Example: 3.4)</span>';
$_['entry_adv_payment_cost_fixed_fee']  	= 'Fixed Fee:<br/><span class="help">Fixed Fee to be charged<br />(Example: 0.50)</span>';
$_['entry_adv_payment_cost_geo_zone'] 		= 'Geo Zone:<br/><span class="help">Don\'t use identical Geo Zone for same payment method!';

$_['entry_adv_shipping_cost_status']     	= 'Shipping Costs Status:<br/><span class="help">Enable or disable shipping costs option (Weight Based Shipping method)</span>';
$_['entry_adv_shipping_cost_total']  		= 'Order Total:<br/><span class="help">Checkout Order Total amount needed before the shipping costs will be added.</span>';
$_['entry_adv_shipping_cost_rate']       	= 'Shipping Costs Rates:<br /><span class="help">Example: 5:10.00,7:12.00 Weight:Cost,Weight:Cost, etc..</span>';
$_['entry_status']     						= 'Status:';

// Button
$_['button_set_rder_product_cost'] 			= 'SET ACTUAL PRODUCT COSTS TO ALL ORDERS';
$_['button_add_payment'] 					= 'Add Payment';
$_['button_remove_payment'] 				= 'Remove';

// Error
$_['error_permission']    					= 'Warning: You do not have permission to modify module ADV Profit Reports!';
$_['error_cost_required_data'] 				= '<b>Warning:</b> Required Data has not been entered or check correct character field. Check for field errors!';
$_['error_vqmod']           				= 'vQmod does not seem to be installed. <a href="http://code.google.com/p/vqmod/" target="_blank">Get vQmod!</a>';
$_['error_numeric_value']           		= 'Please set correct numeric value!</a>';
$_['error_payment_cost_percentage']         = 'Please set correct numeric value!</a>';
$_['error_payment_cost_total']           	= 'Please set correct numeric value for Payment Costs - Order Total!</a>';
$_['error_shipping_cost_total']          	= 'Please set correct numeric value for Shipping Costs - Order Total!</a>';
$_['error_shipping_cost_rate']           	= 'Please set correct Shipping Costs Rate!</a>';

$_['adv_cop_text_ext_name']					= 'Extension name:';
$_['adv_cop_ext_name']						= 'ADV Customer Orders Report + Profit Reporting';
$_['adv_cop_text_ext_version']				= 'Extension version:';
$_['adv_cop_ext_version']					= '3.0';
$_['adv_cop_ext_type']						= 'vQmod';
$_['adv_cop_text_ext_compatibility']		= 'Extension compatibility:';
$_['adv_cop_ext_compatibility']				= 'OpenCart v1.5.3.x, v1.5.4.x, v1.5.5.x';
$_['adv_cop_text_ext_url']					= 'Extension URL:';
$_['adv_cop_text_ext_support']				= 'Extension support:';
$_['adv_cop_ext_support']					= 'opencart.reports@gmail.com';
$_['adv_cop_ext_subject']      				= '%s support needed';
$_['adv_cop_text_ext_legal']				= 'Extension legal notice:';
$_['adv_cop_text_copyright']				= 'ADV Reports & Statistics &copy; 2011-2013';
            

$_['adv_ppp_text_ext_name']					= 'Extension name:';
$_['adv_ppp_ext_name']						= 'ADV Products Purchased Report + Profit Reporting';
$_['adv_ppp_text_ext_version']				= 'Extension version:';
$_['adv_ppp_ext_version']					= '3.0';
$_['adv_ppp_ext_type']						= 'vQmod';
$_['adv_ppp_text_ext_compatibility']		= 'Extension compatibility:';
$_['adv_ppp_ext_compatibility']				= 'OpenCart v1.5.3.x, v1.5.4.x, v1.5.5.x';
$_['adv_ppp_text_ext_url']					= 'Extension URL:';
$_['adv_ppp_text_ext_support']				= 'Extension support:';
$_['adv_ppp_ext_support']					= 'opencart.reports@gmail.com';
$_['adv_ppp_ext_subject']      				= '%s support needed';
$_['adv_ppp_text_ext_legal']				= 'Extension legal notice:';
$_['adv_ppp_text_copyright']				= 'ADV Reports & Statistics &copy; 2011-2013';
            

$_['adv_sop_text_ext_name']					= 'Extension name:';
$_['adv_sop_ext_name']						= 'ADV Sales Report + Profit Reporting';
$_['adv_sop_text_ext_version']				= 'Extension version:';
$_['adv_sop_ext_version']					= '3.0';
$_['adv_sop_ext_type']						= 'vQmod';
$_['adv_sop_text_ext_compatibility']		= 'Extension compatibility:';
$_['adv_sop_ext_compatibility']				= 'OpenCart v1.5.3.x, v1.5.4.x, v1.5.5.x';
$_['adv_sop_text_ext_url']					= 'Extension URL:';
$_['adv_sop_text_ext_support']				= 'Extension support:';
$_['adv_sop_ext_support']					= 'opencart.reports@gmail.com';
$_['adv_sop_ext_subject']      				= '%s support needed';
$_['adv_sop_text_ext_legal']				= 'Extension legal notice:';
$_['adv_sop_text_copyright']				= 'ADV Reports & Statistics &copy; 2011-2013';
            
?>