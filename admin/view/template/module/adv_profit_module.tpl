<?php echo $header; ?>
<div id="content">
<style type="text/css">
.styled-select {
	background-color: #F9F9F9;
 	border: 1px solid #BBB;
	padding: 2px;
    -moz-border-radius: 3px; 
    border-radius: 3px;
}
.styled-input {
	background-color: #F9F9F9;
	height: 17px;
	border: solid 1px #BBB;
    -moz-border-radius: 3px; 
    border-radius: 3px;	
}
.styled-textarea {
	background-color: #F9F9F9;
	border: solid 1px #BBB;
    -moz-border-radius: 3px; 
    border-radius: 3px;	
}

a.cbutton {
	text-decoration: none;
	color: #FFF;
	display: inline-block;
	padding: 5px 15px 5px 15px;
	-webkit-border-radius: 5px 5px 5px 5px;
	-moz-border-radius: 5px 5px 5px 5px;
	-khtml-border-radius: 5px 5px 5px 5px;
	border-radius: 5px 5px 5px 5px;
}
</style> 
  <?php if ($laccess) { ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>  
  <?php if ($warning) { ?>
  <div class="warning"><?php echo $warning; ?></div>
  <?php } ?>  
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?> 
  <?php if (empty($vqmod_available)) { ?>
  <div class="warning"><?php echo $error_vqmod; ?></div>
  <?php } ?>        
  <?php foreach ($sc_geo_zones as $sc_geo_zone) { ?>
  <?php if (${'error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_total'}) { ?>
  <div class="warning"><?php echo $error_shipping_cost_total; ?> [<?php echo $sc_geo_zone['name']; ?>]</div>
  <?php } ?>   
  <?php if (${'error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_rate'}) { ?>
  <div class="warning"><?php echo $error_shipping_cost_rate; ?> [<?php echo $sc_geo_zone['name']; ?>]</div>
  <?php } ?>
  <?php } ?>
  <?php if ($error_extra_cost) { ?>
  <div class="warning"><?php echo $error_extra_cost; ?></div>
  <?php } ?>  
  <?php } ?> 
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/adv_reports/adv_icon_big.png" width="22" height="22" alt="" /><?php echo $heading_title_main; ?></h1>
      <?php if (!empty($vqmod_available)) { ?>
      <div class="buttons"><?php if ($laccess) { ?><a onclick="$('#form').submit();" class="cbutton" style="background:#337ab7;"><span><?php echo $button_save; ?></span></a>&nbsp;<?php } ?><a onclick="location = '<?php echo $cancel; ?>';" class="cbutton" style="background:#999;"><span><?php echo $button_cancel; ?></span></a>&nbsp;<a href="http://www.opencartreports.com/documentation/prm/index.html" target="_blank" class="cbutton" style="background:#ec971f;"><span><?php echo $button_documentation; ?></span></a></div>
      <?php } ?>
    </div>
    <div class="content">
    <?php if (!empty($vqmod_available)) { ?>
    <div id="tabs" class="htabs"><?php if ($laccess) { ?><a href="#tab-product_cost"><?php echo $tab_product_cost; ?></a><a href="#tab-payment_cost"><?php echo $tab_payment_cost; ?></a><a href="#tab-shipping_cost"><?php echo $tab_shipping_cost; ?></a><a href="#tab-extra_cost"><?php echo $tab_extra_cost; ?></a><a href="#tab-settings"><?php echo $tab_settings; ?></a><?php } ?><a id="about" href="#tab-about"><?php echo $tab_about; ?></a></div> 
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">	
      	
        <?php if ($laccess) { ?>
      	<div id="tab-product_cost">
		<table class="form">
        <tr>
          <td class="left"><?php echo $entry_import_export; ?></td>
          <td class="left"><div style="padding-bottom:5px;"><?php echo $text_import_export_note; ?></div>
          <div><img src="view/image/adv_reports/1.png" width="16" height="16" align="absmiddle" style="padding-bottom:3px; padding-right:3px;" /> <strong><?php echo $entry_category; ?></strong>&nbsp;
            <select name="filter_category" id="filter_category" multiple="multiple">
              <?php foreach ($categories as $category) { ?>
              <?php if (isset($filter_category[$category['category_id']])) { ?>
              <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>&nbsp;
            <strong><?php echo $entry_manufacturer; ?></strong>&nbsp;
		    <select name="filter_manufacturer" id="filter_manufacturer" multiple="multiple">
              <?php foreach ($manufacturers as $manufacturer) { ?>
              <?php if (isset($filter_manufacturer[$manufacturer['manufacturer_id']])) { ?>
              <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option> 
              <?php } ?>
              <?php } ?>
            </select>&nbsp;
            <strong><?php echo $entry_prod_status; ?></strong>&nbsp;
            <select name="filter_status" id="filter_status" multiple="multiple">
                <?php if ($filter_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <?php } ?>
                <?php if (!is_null($filter_status) && !$filter_status) { ?>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } ?>
            </select></div>
            <div style="padding-top:7px;"><img src="view/image/adv_reports/2.png" width="16" height="16" align="absmiddle" style="padding-bottom:3px; padding-right:3px;" /> <?php echo $text_price_rounding; ?>
            <select name="filter_rounding" class="styled-select">
			  <?php if ($filter_rounding == 'RD10DW') { ?>
			  <option value="RD10DW" selected="selected">110.90 (round down to the whole number minus ten hundredths)</option>
			  <?php } else { ?>
			  <option value="RD10DW">110.90 (round down to the whole number minus ten hundredths)</option>
			  <?php } ?>  
			  <?php if ($filter_rounding == 'RD5DW') { ?>
			  <option value="RD5DW" selected="selected">110.95 (round down to the whole number minus five hundredths)</option>
			  <?php } else { ?>
			  <option value="RD5DW">110.95 (round down to the whole number minus five hundredths)</option>
			  <?php } ?>  
			  <?php if ($filter_rounding == 'RD1DW') { ?>
			  <option value="RD1DW" selected="selected">110.99 (round down to the whole number minus one hundredth)</option>
			  <?php } else { ?>
			  <option value="RD1DW">110.99 (round down to the whole number minus one hundredth)</option>
			  <?php } ?>  
			  <?php if ($filter_rounding == 'RD00DW') { ?>
			  <option value="RD00DW" selected="selected">111.00 (round down to the whole number)</option>
			  <?php } else { ?>
			  <option value="RD00DW">111.00 (round down to the whole number)</option>
			  <?php } ?>          
			  <?php if ($filter_rounding == 'RD0DW') { ?>
			  <option value="RD0DW" selected="selected">111.10 (round down to the nearest tenths place)</option>
			  <?php } else { ?>
			  <option value="RD0DW">111.10 (round down to the nearest tenths place)</option>
			  <?php } ?>            
			  <?php if ($filter_rounding == 'RD') { ?>
			  <option value="RD" selected="selected">111.11 (without rounding) - default</option>
			  <?php } else { ?>
			  <option value="RD">111.11 (without rounding - default)</option>
			  <?php } ?>
			  <?php if ($filter_rounding == 'RD0UP') { ?>
			  <option value="RD0UP" selected="selected">111.20 (round up to the nearest tenths place)</option>
			  <?php } else { ?>
			  <option value="RD0UP">111.20 (round up to the nearest tenths place)</option>
			  <?php } ?> 
			  <?php if ($filter_rounding == 'RD10UP') { ?>
			  <option value="RD10UP" selected="selected">111.90 (round up to the whole number minus ten hundredths)</option>
			  <?php } else { ?>
			  <option value="RD10UP">111.90 (round up to the whole number minus ten hundredths)</option>
			  <?php } ?>   
			  <?php if ($filter_rounding == 'RD5UP') { ?>
			  <option value="RD5UP" selected="selected">111.95 (round up to the whole number minus five hundredths)</option>
			  <?php } else { ?>
			  <option value="RD5UP">111.95 (round up to the whole number minus five hundredths)</option>
			  <?php } ?>   
			  <?php if ($filter_rounding == 'RD1UP') { ?>
			  <option value="RD1UP" selected="selected">111.99 (round up to the whole number minus one hundredth)</option>
			  <?php } else { ?>
			  <option value="RD1UP">111.99 (round up to the whole number minus one hundredth)</option>
			  <?php } ?>   
			  <?php if ($filter_rounding == 'RD00UP') { ?>
			  <option value="RD00UP" selected="selected">112.00 (round up to the whole number)</option>
			  <?php } else { ?>
			  <option value="RD00UP">112.00 (round up to the whole number)</option>
			  <?php } ?>                                                                        
            </select></div>           
			<div><img src="view/image/adv_reports/3.png" align="absmiddle" width="16" height="16" style="padding-bottom:3px; padding-right:3px;" /> <input onclick="exportExcel();" type="button" class="button" style="margin-bottom: 5px;" value="<?php echo $button_export; ?>" />&nbsp;<?php echo $text_export; ?></div>
            <div><img src="view/image/adv_reports/4.png" align="absmiddle" width="16" height="16" style="padding-bottom:3px; padding-right:3px;" /> <input type="file" name="upload" /></div>
            <div><img src="view/image/adv_reports/5.png" align="absmiddle" width="16" height="16" style="padding-bottom:3px; padding-right:3px;" /> <input onclick="$('#form').submit();" type="button" class="button" style="margin-top: 5px;" value="<?php echo $button_import; ?>" />&nbsp;<?php echo $text_import; ?></div></td>
        </tr>        
        <tr>
          <td class="left"><?php echo $entry_set_order_product_cost; ?></td>
          <td class="left"><?php echo $text_set_set_order_product_cost; ?>
          <a onclick="show_order_product_cost_confirm()" class="cbutton" style="background:#337ab7; margin-top:10px;  text-decoration:none;" /><?php echo $button_set_order_product_cost; ?></a></td>
        </tr>
        </table>
		</div>

		<div id="tab-payment_cost">
		<table class="form">
        <tr>
          <td class="left"><?php echo $entry_adv_payment_cost_status; ?></td>
          <td class="left"><select name="adv_payment_cost_status" class="styled-select">
              <?php if ($adv_payment_cost_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>       
     	</table>
	  <br/>
        <table width="100%" id="adv_payment_cost" class="list">
          <thead>
            <tr>
              <td width="18%" class="left"><?php echo $entry_adv_payment_cost_payment_type; ?></td>
              <td width="18%" class="left"><?php echo $entry_adv_payment_cost_total; ?></td>
              <td width="18%" class="left"><?php echo $entry_adv_payment_cost_percentage; ?></td>              
              <td width="18%" class="left"><?php echo $entry_adv_payment_cost_fixed_fee; ?></td>
			  <td width="18%" class="left"><?php echo $entry_adv_payment_cost_geo_zone; ?></td>
              <td></td>
            </tr>
          </thead>

          <?php if ($adv_payment_cost_types) { ?>
		   <?php $adv_payment_cost_types_row = 0; ?>
			<?php foreach ($adv_payment_cost_types as $adv_payment_cost_type) { ?>
			  <tbody id="adv_payment_cost_types_row<?php echo $adv_payment_cost_types_row; ?>">
				<tr>
				  <td width="18%" class="left">
					<select name="adv_payment_cost_type[<?php echo $adv_payment_cost_types_row; ?>][pc_paymentkey]" class="styled-select">
					  <?php foreach ($payment_types as $payment_type) { ?>
						  <?php  if ($payment_type['paymentkey'] == $adv_payment_cost_type['pc_paymentkey']) { ?>
							<option value="<?php echo $payment_type['paymentkey']; ?>" selected><?php echo $payment_type['name']; ?></option>
						  <?php } else { ?>
							<option value="<?php echo $payment_type['paymentkey']; ?>"><?php echo $payment_type['name']; ?></option>
						  <?php } ?>
					  <?php } ?>
					</select>
				  </td> 
				  <td width="18%" class="left">
				  <input type="text" name="adv_payment_cost_type[<?php echo $adv_payment_cost_types_row; ?>][pc_order_total]" value="<?php echo $adv_payment_cost_type['pc_order_total']; ?>" class="styled-input" />
				  </td>                  
				  <td width="18%" class="left">
				  <input type="text" name="adv_payment_cost_type[<?php echo $adv_payment_cost_types_row; ?>][pc_percentage]" value="<?php echo $adv_payment_cost_type['pc_percentage']; ?>" class="styled-input" />
				  </td>
				  <td width="18%" class="left">
				  <input type="text" name="adv_payment_cost_type[<?php echo $adv_payment_cost_types_row; ?>][pc_fixed]" value="<?php echo $adv_payment_cost_type['pc_fixed']; ?>" class="styled-input" />
				  </td>
				  <td width="18%" class="left">
				    <select name="adv_payment_cost_type[<?php echo $adv_payment_cost_types_row; ?>][pc_geozone]" class="styled-select">
					  <option value="0" <?php if($adv_payment_cost_type['pc_geozone'] == 0) { echo 'selected'; } ?>><?php echo $text_all_zones; ?></option>
					  <?php foreach ($pc_geo_zones as $pc_geo_zone) { ?>
						  <?php  if ($pc_geo_zone['geo_zone_id'] == $adv_payment_cost_type['pc_geozone']) { ?>
							<option value="<?php echo $pc_geo_zone['geo_zone_id']; ?>" selected><?php echo $pc_geo_zone['name']; ?></option>
						  <?php } else { ?>
							<option value="<?php echo $pc_geo_zone['geo_zone_id']; ?>"><?php echo $pc_geo_zone['name']; ?></option>
						  <?php } ?>
					  <?php } ?>
					</select>
				  </td>
				  <td class="left"><a onclick="$('#adv_payment_cost_types_row<?php echo $adv_payment_cost_types_row; ?>').remove();" class="cbutton" style="background:#d9534f; text-decoration:none;"><span><?php echo $button_remove_payment; ?></span></a></td>
				</tr>
			  </tbody>
            <?php $adv_payment_cost_types_row++; ?>
  		    <?php } ?>
          <?php } else { ?>
		     <?php $adv_payment_cost_types_row = 0; ?>
		  <?php } ?>
		  
		  <tfoot>
            <tr>
              <td colspan="5"></td>
              <td class="left"><a onclick="addPaymentType();" class="cbutton" style="background:#337ab7; text-decoration:none;"><span><?php echo $button_add_payment; ?></span></a></td>
            </tr>
          </tfoot>           
        </table>  
        <table class="form">
        	<tr>
          	  <td class="left"><?php echo $entry_set_order_payment_cost; ?></td>
          	  <td class="left"><?php echo $text_set_set_order_payment_cost; ?>
          	  <a onclick="show_order_payment_cost_confirm()" class="cbutton" style="background:#337ab7; margin-top:10px;  text-decoration:none;" /><?php echo $button_set_order_payment_cost; ?></a></td>
        	</tr>
        </table>            
		</div>
        
      	<div id="tab-shipping_cost">
      <div class="vtabs"><a href="#tab-general"><?php echo $tab_general; ?></a>
        <?php foreach ($sc_geo_zones as $sc_geo_zone) { ?>
        <a href="#tab-geo-zone<?php echo $sc_geo_zone['geo_zone_id']; ?>"><?php echo $sc_geo_zone['name']; ?></a>
        <?php } ?>
      </div>
        <div id="tab-general" class="vtabs-content">
		<table class="form">
            <tr>
              <td class="left"><?php echo $entry_adv_shipping_cost_status; ?></td>
              <td class="left"><select name="adv_shipping_cost_weight_status" class="styled-select">
                  <?php if ($adv_shipping_cost_weight_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>         
        </table>
		</div>   
        <?php foreach ($sc_geo_zones as $sc_geo_zone) { ?>
        <div id="tab-geo-zone<?php echo $sc_geo_zone['geo_zone_id']; ?>" class="vtabs-content">
          <table class="form">
        	<tr>
          	  <td class="left"><?php echo $entry_adv_shipping_cost_total; ?></td>
			  <td class="left"><input type="text" name="adv_shipping_cost_weight_<?php echo $sc_geo_zone['geo_zone_id']; ?>_total" value="<?php echo ${'adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_total'}; ?>" class="styled-input" />
          	  <br />
          	  <?php if (${'error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_total'}) { ?>
          	  <span class="error"><?php echo ${'error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_total'}; ?></span>
          	  <?php } ?></td>
            </tr>              
            <tr>
              <td class="left"><?php echo $entry_adv_shipping_cost_rate; ?></td>
              <td class="left"><textarea name="adv_shipping_cost_weight_<?php echo $sc_geo_zone['geo_zone_id']; ?>_rate" cols="40" rows="5" class="styled-textarea"><?php echo ${'adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate'}; ?></textarea>
          	  <br />
         	  <?php if (${'error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_rate'}) { ?>
         	  <span class="error"><?php echo ${'error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_rate'}; ?></span>
        	  <?php } ?></td>              
            </tr>        
            <tr>
              <td class="left"><?php echo $entry_status; ?></td>
              <td class="left"><select name="adv_shipping_cost_weight_<?php echo $sc_geo_zone['geo_zone_id']; ?>_status" class="styled-select">
                  <?php if (${'adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_status'}) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
          </table>
        </div>
        <?php } ?>
        <table class="form">
        	<tr>
          	  <td class="left"><?php echo $entry_set_order_shipping_cost; ?></td>
          	  <td class="left"><?php echo $text_set_set_order_shipping_cost; ?>
          	  <a onclick="show_order_shipping_cost_confirm()" class="cbutton" style="background:#337ab7; margin-top:10px;  text-decoration:none;" /><?php echo $button_set_order_shipping_cost; ?></a></td>
        	</tr>
        </table>           
        </div>

      	<div id="tab-extra_cost">
		<table class="form">
        <tr>
          <td class="left"><?php echo $entry_adv_extra_cost_status; ?></td>
          <td class="left"><select name="adv_extra_cost_status" class="styled-select">
                  <?php if ($adv_extra_cost_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                  </select></td>
        </tr>
        <tr>
          <td class="left"><?php echo $entry_adv_extra_cost; ?></td>
              <td class="left"><textarea name="adv_extra_cost" cols="40" rows="5" class="styled-textarea"><?php echo $adv_extra_cost; ?></textarea>
          	  <br />
         	  <?php if ($error_extra_cost) { ?>
         	  <span class="error"><?php echo $error_extra_cost; ?></span>
        	  <?php } ?></td> 
        </tr>
        <tr>
          <td class="left"><?php echo $entry_set_order_extra_cost; ?></td>
          <td class="left"><?php echo $text_set_set_order_extra_cost; ?>
          <a onclick="show_order_extra_cost_confirm()" class="cbutton" style="background:#337ab7; margin-top:10px;  text-decoration:none;" /><?php echo $button_set_order_extra_cost; ?></a></td>
        </tr>
        </table>
		</div>

		<div id="tab-settings">
		<table class="form">
			<tr>
            	<td class="left"><?php echo $text_sold_order_status; ?></td>
              	<td class="left"><select name="adv_sold_order_status" class="styled-select">
                	<option value=""><?php echo $text_all_statuses; ?></option>
              		<?php foreach ($order_statuses as $order_status) { ?>
              		<?php if ($order_status['order_status_id'] == $adv_sold_order_status) { ?>
              		<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              		<?php } else { ?>
              		<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              		<?php } ?>
             		<?php } ?>
            	</select></td>
            </tr> 
          </table> 
		<table class="form">
			<tr>
            	<td class="left"><?php echo $text_format_date; ?></td>
              	<td class="left"><select name="adv_date_format" class="styled-select">
					<?php if ($adv_date_format == 'DDMMYYYY') { ?>
					<option value="DDMMYYYY" selected="selected"><?php echo $text_format_date_eu; ?></option>
					<option value="MMDDYYYY"><?php echo $text_format_date_us; ?></option>
					<?php } else { ?>
					<option value="DDMMYYYY"><?php echo $text_format_date_eu; ?></option>
					<option value="MMDDYYYY" selected="selected"><?php echo $text_format_date_us; ?></option>
					<?php } ?>
				</select></td>
            </tr>   
			<tr>
            	<td class="left"><?php echo $text_format_hour; ?></td>
              	<td class="left"><select name="adv_hour_format" class="styled-select">
					<?php if ($adv_hour_format == '24') { ?>
					<option value="24" selected="selected"><?php echo $text_format_hour_24; ?></option>
					<option value="12"><?php echo $text_format_hour_12; ?></option>
					<?php } else { ?>
					<option value="24"><?php echo $text_format_hour_24; ?></option>
					<option value="12" selected="selected"><?php echo $text_format_hour_12; ?></option>
					<?php } ?>
				</select></td>
            </tr>  
          </table>           
        </div> 
     <?php } ?>
             
     <div id="tab-about">
     <div id="adv_profit_module"></div>
     <div align="center"><a href="http://www.opencartreports.com" target="_blank"><img class="img-responsive" src="view/image/adv_reports/adv_logo.png" /></a></div>  
     </div>
     
     <?php } ?>
      </form>
    </div>
  </div>
</div> 
<?php if ($adv_prm_version && $adv_prm_version['version'] != $adv_current_version) { ?>  
<script type="text/javascript"><!--
$('#about').append('<img id=\"warning\" src=\"view/image/warning.png\" width=\"15\" height=\"15\" align=\"absmiddle\" hspace=\"5\" border=\"0\" />');
$('#about').css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': 'red','text-decoration': 'blink'});
//--></script> 
<?php } ?>
<?php if ($laccess) { ?>
<script type="text/javascript"><!--
function exportExcel() {
	url = 'index.php?route=module/adv_profit_module&token=<?php echo $token; ?>';
			
	var filtercategory = [];
	$('#filter_category option:selected').each(function() {
		filtercategory.push($(this).val());
	});
	
	var filter_category = filtercategory.join('_');
	
	if (filter_category) {
		url += '&filter_category=' + encodeURIComponent(filter_category);
	}	

	var filtermanufacturer = [];
	$('#filter_manufacturer option:selected').each(function() {
		filtermanufacturer.push($(this).val());
	});
	
	var filter_manufacturer = filtermanufacturer.join('_');
	
	if (filter_manufacturer) {
		url += '&filter_manufacturer=' + encodeURIComponent(filter_manufacturer);
	}	

	var filterstatus = [];
	$('#filter_status option:selected').each(function() {
		filterstatus.push($(this).val());
	});
	
	var filter_status = filterstatus.join('_');
	
	if (filter_status) {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}		
	
	var filter_rounding = $('select[name=\'filter_rounding\']').val();

	if (filter_rounding) {
		url += '&filter_rounding=' + encodeURIComponent(filter_rounding);
	}		
	
		url += '&export=xls';
	
	location = url;
}

function show_order_product_cost_confirm() {
	var r = confirm("<?php echo $text_set_order_product_cost_confirm ;?>");
	if (r==true) {
		window.location = "<?php echo htmlspecialchars_decode($url_set_order_product_cost) ;?>";
	} else {
		//alert("You pressed Cancel!");
	}
}
function show_order_payment_cost_confirm() {
	var r = confirm("<?php echo $text_set_order_payment_cost_confirm ;?>");
	if (r==true) {
		window.location = "<?php echo htmlspecialchars_decode($url_set_order_payment_cost) ;?>";
	} else {
		//alert("You pressed Cancel!");
	}
}
function show_order_shipping_cost_confirm() {
	var r = confirm("<?php echo $text_set_order_shipping_cost_confirm ;?>");
	if (r==true) {
		window.location = "<?php echo htmlspecialchars_decode($url_set_order_shipping_cost) ;?>";
	} else {
		//alert("You pressed Cancel!");
	}
}
function show_order_extra_cost_confirm() {
	var r = confirm("<?php echo $text_set_order_extra_cost_confirm ;?>");
	if (r==true) {
		window.location = "<?php echo htmlspecialchars_decode($url_set_order_extra_cost) ;?>";
	} else {
		//alert("You pressed Cancel!");
	}
}
//--></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#filter_category").multiselect({ checkAllText: "<?php echo $text_select_all; ?>", uncheckAllText: "<?php echo $text_unselect_all; ?>", noneSelectedText: "<?php echo $text_all_categories; ?>", selectedText: "<?php echo $text_selected; ?>", minWidth: "250" }); 
	$("#filter_manufacturer").multiselect({ checkAllText: "<?php echo $text_select_all; ?>", uncheckAllText: "<?php echo $text_unselect_all; ?>", noneSelectedText: "<?php echo $text_all_manufacturers; ?>", selectedText: "<?php echo $text_selected; ?>", minWidth: "200" }); 
	$("#filter_status").multiselect({ checkAllText: "<?php echo $text_select_all; ?>", uncheckAllText: "<?php echo $text_unselect_all; ?>", noneSelectedText: "<?php echo $text_all_statuses; ?>", selectedText: "<?php echo $text_selected; ?>", minWidth: "200" }); 	
});
</script>
<script type="text/javascript"><!--
$('.htabs a').tabs();
$('.vtabs a').tabs();
//--></script> 
<script type="text/javascript"><!--
var adv_payment_cost_types_row = <?php echo $adv_payment_cost_types_row; ?>;

function addPaymentType() {
	html  = '<tbody id="adv_payment_cost_types_row' + adv_payment_cost_types_row + '">';
	html += '<tr>';
	html += '<td class="left"><select name="adv_payment_cost_type[' + adv_payment_cost_types_row + '][pc_paymentkey]" class="styled-select">';
	html += '<?php foreach ($payment_types as $payment_type) { ?><option value="<?php echo $payment_type["paymentkey"]; ?>"><?php echo $payment_type["name"]; ?></option><?php } ?>';
	html += '<td class="left"><input type="text" name="adv_payment_cost_type[' + adv_payment_cost_types_row + '][pc_order_total]" value="0.00" class="styled-input" /></td>';
	html += '<td class="left"><input type="text" name="adv_payment_cost_type[' + adv_payment_cost_types_row + '][pc_percentage]" value="0.00" class="styled-input" /></td>';
	html += '<td class="left"><input type="text" name="adv_payment_cost_type[' + adv_payment_cost_types_row + '][pc_fixed]" value="0.00" class="styled-input" /></td>';
	html += '<td class="left"><select name="adv_payment_cost_type[' + adv_payment_cost_types_row + '][pc_geozone]" class="styled-select">';
    html += '<option value="0" selected><?php echo $text_all_zones; ?></option>';
    html += '<?php foreach ($pc_geo_zones as $pc_geo_zone) { ?>';
    html += '<option value="<?php echo $pc_geo_zone["geo_zone_id"]; ?>"><?php echo $pc_geo_zone["name"]; ?></option>';
    html += '<?php } ?></select></td>';
	html += '<td class="left"><a onclick="$(\'#adv_payment_cost_types_row' + adv_payment_cost_types_row + '\').remove();" class="cbutton" style="background:#d9534f; text-decoration:none;"><span><?php echo $button_remove_payment; ?></span></a></td>';
	html += '</tr>';
	html += '</tbody>';

	$('#adv_payment_cost > tfoot').before(html);

	adv_payment_cost_types_row++;
}
//--></script>
<?php } ?>
<?php echo $footer; ?>