<?php 
/****  AUTHOR  ****/
/*
/* Thorleif Jacobsen
/* TJWeb - www.tjweb.no
/* Support: thorleif.oc@tjweb.no
/* Questions: thorleif.oc@tjweb.no
/*
/****  AUTHOR  ****/
?>
<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background: url('view/image/shipping/bring.png') no-repeat; background-position: 5px 5px;"> 
      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      &nbsp; &nbsp; &nbsp;<?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content" style="height: auto; height: 1250px">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="bring_status">
              <?php if ($bring_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_identificator; ?></div></td>
          <td><input type="text" value="<?php echo $bring_identificator; ?>" name="bring_identificator" style="width: 250px;" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_bring_products; ?></div></td>
          <td>
          	<select multiple="1" style="height:100px;" name="bring_products[]">
<?php if(!is_array($bring_products)) { $bring_products = explode(",", $bring_products); } ?>
<?php foreach($bring_products_data as $k=>$v) { ?>
              <option <?php if(in_array($k, $bring_products)) echo 'selected="selected"'; ?> value="<?php echo $k; ?>"><?php echo $v; ?></option>
<?php } ?>
          	</select>
          </td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_from_postalnumber; ?></div></td>
          <td><input type="text" value="<?php echo $bring_from_postalnumber; ?>" name="bring_from_postalnumber" style="width: 30px;" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_priceadjust; ?></div></td>
          <td><input type="text" value="<?php echo $bring_priceadjust; ?>" name="bring_priceadjust" style="width: 30px;" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_use_volume; ?></div></td>
          <td><input type="checkbox" <?php if($bring_use_volume) echo 'checked="checked"'; ?>" name="bring_use_volume" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_ship_at_postaloffice; ?></div></td>
          <td><input type="checkbox" <?php if($bring_ship_at_postaloffice) echo 'checked="checked"'; ?>" name="bring_ship_at_postaloffice" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_geo_zone; ?></td>
          <td><select name="bring_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $bring_geo_zone_id) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
            <td><?php echo $entry_tax; ?></td>
            <td><select name="bring_tax_class_id">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($tax_classes as $tax_class) { ?>
                <?php if ($tax_class['tax_class_id'] == $bring_tax_class_id) { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="bring_sort_order" value="<?php echo $bring_sort_order; ?>" size="1" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_choose_grams; ?></td>
          <td><select name="bring_weight_class_id">
              <?php foreach ($weight_classes as $weight_class) { ?>
              <?php if ($weight_class['weight_class_id'] == $bring_weight_class_id) { ?>
              <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>
              <?php } ?>
              <?php } ?>
              </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_choose_centimeter; ?></td>
          <td><select name="bring_length_class_id">
              <?php foreach ($length_classes as $length_class) { ?>
              <?php if ($length_class['length_class_id'] == $bring_length_class_id) { ?>
              <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>
              <?php } ?>
              <?php } ?>
              </select></td>
        </tr>
      </table>
      
      <table class="form">
        <tr>
          <td><?php echo $entry_free_shipping; ?></td>
          <td><input type="text" name="product" value="" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><div class="scrollbox" id="bring_fs_products_data">
              <?php $class = 'odd'; ?>
              <?php foreach ($bring_fs_products_data as $product) { ?>
              <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
              <div id="bring_fs_products_data<?php echo $product['product_id']; ?>" class="<?php echo $class; ?>"><?php echo $product['name']; ?> <img src="view/image/delete.png" />
                <input type="hidden" value="<?php echo $product['product_id']; ?>" />
              </div>
              <?php } ?>
            </div>
            <input type="hidden" name="bring_fs_products" value="<?php echo $bring_fs_products; ?>" /></td>
        </tr>
      </table>
      
    </form>
  </div>
</div>
<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>',
			type: 'POST',
			dataType: 'json',
			data: 'filter_name=' +  encodeURIComponent(request.term),
			success: function(data) {		
				response($.map(data, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
		
	}, 
	select: function(event, ui) {
		$('#bring_fs_products_data' + ui.item.value).remove();
		
		$('#bring_fs_products_data').append('<div id="bring_fs_products_data' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" value="' + ui.item.value + '" /></div>');

		$('#bring_fs_products_data div:odd').attr('class', 'odd');
		$('#bring_fs_products_data div:even').attr('class', 'even');
		
		data = $.map($('#bring_fs_products_data input'), function(element){
			return $(element).attr('value');
		});
						
		$('input[name=\'bring_fs_products\']').attr('value', data.join());
					
		return false;
	}
});

$('#bring_fs_products_data div img').live('click', function() {
	$(this).parent().remove();
	
	$('#bring_fs_products_data div:odd').attr('class', 'odd');
	$('#bring_fs_products_data div:even').attr('class', 'even');

	data = $.map($('#bring_fs_products_data input'), function(element){
		return $(element).attr('value');
	});
					
	$('input[name=\'bring_fs_products\']').attr('value', data.join());	
});
//--></script>
<?php echo $footer; ?>