<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>  
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?> 
  <?php if (empty($vqmod_available)) { ?>
  <div class="warning"><?php echo $error_vqmod; ?></div>
  <?php } ?>   
  <?php if ($error_adv_payment_cost_total) { ?>
  <div class="warning"><?php echo $error_payment_cost_total; ?></div>
  <?php } ?>   
  <?php if ($error_adv_shipping_cost_total) { ?>
  <div class="warning"><?php echo $error_shipping_cost_total; ?></div>
  <?php } ?>     
  <?php foreach ($sc_geo_zones as $sc_geo_zone) { ?>
  <?php if (${'error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_rate'}) { ?>
  <div class="warning"><?php echo $error_shipping_cost_rate; ?> [<?php echo $sc_geo_zone['name']; ?>]</div>
  <?php } ?>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <?php if (!empty($vqmod_available)) { ?>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
      <?php } ?>
    </div>
    <div class="content">
    <?php if (!empty($vqmod_available)) { ?>
    <div id="tabs" class="htabs"><a href="#tab-database"><?php echo $tab_database; ?></a><a href="#tab_payment_cost"><?php echo $tab_payment_cost; ?></a><a href="#tab_shipping_cost"><?php echo $tab_shipping_cost; ?></a><a id="about" href="#tab-about"><?php echo $tab_about; ?></a></div> 
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">	
      	
      	<div id="tab-database">
		<table class="form">
        <tr>
          <td><?php echo $entry_set_order_product_cost; ?></td>
          <td><?php echo $text_set_set_order_product_cost; ?>
          <input onclick="show_order_product_cost_confirm()" type="button" class="button" style="border: 2px solid #000000; margin-top:10px;" value="<?php echo $button_set_rder_product_cost; ?>" /></td>
        </tr>
        </table>
		</div>
        
		<div id="tab_payment_cost">
		<table class="form">
        <tr>
          <td><?php echo $entry_adv_payment_cost_status; ?></td>
          <td><select name="adv_payment_cost_status">
              <?php if ($adv_payment_cost_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_adv_payment_cost_total; ?></td>
          <td><input type="text" name="adv_payment_cost_total" value="<?php echo $adv_payment_cost_total; ?>" />
          <br />
          <?php if ($error_adv_payment_cost_total) { ?>
          <span class="error"><?php echo $error_numeric_value; ?></span>
          <?php } ?></td>
        </tr>         
     	</table>
	  <br/>
        <table id="adv_payment_cost" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_adv_payment_cost_payment_type; ?></td>
              <td class="left"><?php echo $entry_adv_payment_cost_percentage; ?></td>
              <td class="left"><?php echo $entry_adv_payment_cost_fixed_fee; ?></td>
			  <td class="left"><?php echo $entry_adv_payment_cost_geo_zone; ?></td>
              <td></td>
            </tr>
          </thead>

          <?php if ($adv_payment_cost_types) { ?>
		   <?php $adv_payment_cost_types_row = 0; ?>
			<?php foreach ($adv_payment_cost_types as $adv_payment_cost_type) { ?>
			  <tbody id="adv_payment_cost_types_row<?php echo $adv_payment_cost_types_row; ?>">
				<tr>
				  <td class="left">
					<select name="adv_payment_cost_type[<?php echo $adv_payment_cost_types_row; ?>][pc_paymentkey]">
					  <?php foreach ($payment_types as $payment_type) { ?>
						  <?php  if ($payment_type['paymentkey'] == $adv_payment_cost_type['pc_paymentkey']) { ?>
							<option value="<?php echo $payment_type['paymentkey']; ?>" selected><?php echo $payment_type['name']; ?></option>
						  <?php } else { ?>
							<option value="<?php echo $payment_type['paymentkey']; ?>"><?php echo $payment_type['name']; ?></option>
						  <?php } ?>
					  <?php } ?>
					</select>
				  </td> 
				  <td class="left">
				  <input type="text" name="adv_payment_cost_type[<?php echo $adv_payment_cost_types_row; ?>][pc_percentage]" value="<?php echo $adv_payment_cost_type['pc_percentage']; ?>" />
				  </td>
				  <td class="left">
				  <input type="text" name="adv_payment_cost_type[<?php echo $adv_payment_cost_types_row; ?>][pc_fixed]" value="<?php echo $adv_payment_cost_type['pc_fixed']; ?>" />
				  </td>
				  <td class="left">
				    <select name="adv_payment_cost_type[<?php echo $adv_payment_cost_types_row; ?>][pc_geozone]">
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
				  <td class="left"><a onclick="$('#adv_payment_cost_types_row<?php echo $adv_payment_cost_types_row; ?>').remove();" class="button"><span><?php echo $button_remove_payment; ?></span></a></td>
				</tr>
			  </tbody>
            <?php $adv_payment_cost_types_row++; ?>
  		    <?php } ?>
          <?php } else { ?>
		     <?php $adv_payment_cost_types_row = 0; ?>
		  <?php } ?>
		  
		  <tfoot>
            <tr>
              <td colspan="4"></td>
              <td class="left"><a onclick="addPaymentType();" class="button"><span><?php echo $button_add_payment; ?></span></a></td>
            </tr>
          </tfoot>
        </table>        
		</div>
        
      	<div id="tab_shipping_cost">
      <div class="vtabs"><a href="#tab-general"><?php echo $tab_general; ?></a>
        <?php foreach ($sc_geo_zones as $sc_geo_zone) { ?>
        <a href="#tab-geo-zone<?php echo $sc_geo_zone['geo_zone_id']; ?>"><?php echo $sc_geo_zone['name']; ?></a>
        <?php } ?>
      </div>
        <div id="tab-general" class="vtabs-content">
		<table class="form">
            <tr>
              <td><?php echo $entry_adv_shipping_cost_status; ?></td>
              <td><select name="adv_shipping_cost_weight_status">
                  <?php if ($adv_shipping_cost_weight_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
        <tr>
          <td><?php echo $entry_adv_shipping_cost_total; ?></td>
          <td><input type="text" name="adv_shipping_cost_total" value="<?php echo $adv_shipping_cost_total; ?>" />
          <br />
          <?php if ($error_adv_shipping_cost_total) { ?>
          <span class="error"><?php echo $error_numeric_value; ?></span>
          <?php } ?></td>
        </tr>              
        </table>
		</div>   
        <?php foreach ($sc_geo_zones as $sc_geo_zone) { ?>
        <div id="tab-geo-zone<?php echo $sc_geo_zone['geo_zone_id']; ?>" class="vtabs-content">
          <table class="form">
            <tr>
              <td><?php echo $entry_adv_shipping_cost_rate; ?></td>
              <td><textarea name="adv_shipping_cost_weight_<?php echo $sc_geo_zone['geo_zone_id']; ?>_rate" cols="40" rows="5"><?php echo ${'adv_shipping_cost_weight_' . $sc_geo_zone['geo_zone_id'] . '_rate'}; ?></textarea>
          	  <br />
         	  <?php if (${'error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_rate'}) { ?>
         	  <span class="error"><?php echo ${'error_shipping_cost_' . $sc_geo_zone['geo_zone_id'] . '_rate'}; ?></span>
        	  <?php } ?></td>              
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="adv_shipping_cost_weight_<?php echo $sc_geo_zone['geo_zone_id']; ?>_status">
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
        </div>
        
     <div id="tab-about">
     <div id="adv_sale_profit"></div>
     <div id="adv_product_profit"></div>
     <div id="adv_customer_profit"></div>
     <div align="center"><img src="view/image/adv_reports/adv_logo.jpg" /></div>
     </div>
     
     <?php } ?>
      </form>
    </div>
  </div>
</div> 
<?php if ($adv_sop_ext_version && $adv_sop_version && $adv_sop_version['version'] != $adv_sop_current_version) { ?>  
<script type="text/javascript"><!--
$('#about').append('<img id=\"warning\" src=\"view/image/warning.png\" width=\"15\" height=\"15\" align=\"absmiddle\" hspace=\"5\" border=\"0\" />');  $('#about').css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': 'red','text-decoration': 'blink'});
//--></script> 
<?php } elseif ($adv_ppp_ext_version && $adv_ppp_version && $adv_ppp_version['version'] != $adv_ppp_current_version) { ?>  
<script type="text/javascript"><!--
$('#about').append('<img id=\"warning\" src=\"view/image/warning.png\" width=\"15\" height=\"15\" align=\"absmiddle\" hspace=\"5\" border=\"0\" />');  $('#about').css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': 'red','text-decoration': 'blink'});
//--></script> 
<?php } elseif ($adv_cop_ext_version && $adv_cop_version && $adv_cop_version['version'] != $adv_cop_current_version) { ?>  
<script type="text/javascript"><!--
$('#about').append('<img id=\"warning\" src=\"view/image/warning.png\" width=\"15\" height=\"15\" align=\"absmiddle\" hspace=\"5\" border=\"0\" />');  $('#about').css({'background-color': '#FFD1D1','border': '1px solid #F8ACAC','color': 'red','text-decoration': 'blink'});
//--></script> 
<?php } ?>
<script type="text/javascript"><!--
function show_order_product_cost_confirm() {
	var r = confirm("<?php echo $text_set_order_product_cost_confirm ;?>");
	if (r==true) {
		window.location = "<?php echo htmlspecialchars_decode($url_set_order_product_cost) ;?>";
	} else {
		//alert("You pressed Cancel!");
	}
}
//--></script>
<script type="text/javascript"><!--
$('.htabs a').tabs();
$('.vtabs a').tabs();
//--></script> 
<script type="text/javascript"><!--
var adv_payment_cost_types_row = <?php echo $adv_payment_cost_types_row; ?>;

function addPaymentType() {
	html  = '<tbody id="adv_payment_cost_types_row' + adv_payment_cost_types_row + '">';
	html += '<tr>';
	html += '<td class="left"><select name="adv_payment_cost_type[' + adv_payment_cost_types_row + '][pc_paymentkey]"><?php foreach ($payment_types as $payment_type) { ?>';
	html += '<option value="<?php echo $payment_type["paymentkey"]; ?>"><?php echo $payment_type["name"]; ?></option><?php } ?>';
	html += '<td class="left"><input type="text" name="adv_payment_cost_type[' + adv_payment_cost_types_row + '][pc_percentage]" value="0.00" /></td>';
	html += '<td class="left"><input type="text" name="adv_payment_cost_type[' + adv_payment_cost_types_row + '][pc_fixed]" value="0.00" /></td>';
	html += '<td class="left"><select name="adv_payment_cost_type[' + adv_payment_cost_types_row + '][pc_geozone]">';
    html += '<option value="0" selected><?php echo $text_all_zones; ?></option>';
    html += '<?php foreach ($pc_geo_zones as $pc_geo_zone) { ?>';
    html += '<option value="<?php echo $pc_geo_zone["geo_zone_id"]; ?>"><?php echo $pc_geo_zone["name"]; ?></option>';
    html += '<?php } ?></select></td>';
	html += '<td class="left"><a onclick="$(\'#adv_payment_cost_types_row' + adv_payment_cost_types_row + '\').remove();" class="button"><span><?php echo $button_remove_payment; ?></span></a></td>';
	html += '</tr>';
	html += '</tbody>';

	$('#adv_payment_cost > tfoot').before(html);

	adv_payment_cost_types_row++;
}
//--></script>
<?php echo $footer; ?>