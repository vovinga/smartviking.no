<table id="module" class="table table-bordered">
  <thead>
    <tr>
      <td class="left"><?php echo $entry_layout_options; ?></td>
      <td class="left"><?php echo $entry_position_options; ?></td>
      <td></td>
    </tr>
  </thead>
  <?php $module_row = 0; ?>
  <?php foreach ($modules as $module) { ?>
  <tbody id="module-row<?php echo $module_row; ?>">
    <tr>
      <td class="left">
        <label class="module-row-label"><?php echo $entry_status; ?></label><select name="facebooklogin_module[<?php echo $module_row; ?>][status]">
          <?php if ($module['status']) { ?>
          <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
          <option value="0"><?php echo $text_disabled; ?></option>
          <?php } else { ?>
          <option value="1"><?php echo $text_enabled; ?></option>
          <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
          <?php } ?>
        </select><br />
        <label class="module-row-label"><?php echo $entry_layout; ?></label><select name="facebooklogin_module[<?php echo $module_row; ?>][layout_id]">
          <?php foreach ($layouts as $layout) { ?>
          <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select><br />
      	<label class="module-row-label"><?php echo $entry_sort_order; ?></label><input class="module-row-input-number" type="number" name="facebooklogin_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" />
      </td>
      <td class="left">
        <div class="buttonPositionOpenCart">
        <div class="leftBoxInput"><input <?php if ($module['position'] == 'content_top') echo 'checked="checked"'; ?> type="radio" style="width:auto" name="facebooklogin_module[<?php echo $module_row; ?>][position]" id="buttonPos<?php echo $module_row; ?>_1" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_<?php echo $module_row; ?>" value="content_top" /></div><div class="leftBoxTitle posTitleLabel"><label for="buttonPos<?php echo $module_row; ?>_1"><?php echo $text_content_top; ?></label></div>
        <div class="positionSampleBox"><label for="buttonPos<?php echo $module_row; ?>_1"><img src="view/image/facebooklogin/content_top.png" title="<?php echo $text_content_top; ?>" border="0" /></label></div>        
    </div>
    <div class="buttonPositionOpenCart">
        <div class="leftBoxInput"><input <?php if ($module['position'] == 'content_bottom') echo 'checked="checked"'; ?> type="radio" style="width:auto" name="facebooklogin_module[<?php echo $module_row; ?>][position]" id="buttonPos<?php echo $module_row; ?>_2" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_<?php echo $module_row; ?>" value="content_bottom" /></div><div class="leftBoxTitle posTitleLabel"><label for="buttonPos<?php echo $module_row; ?>_2"><?php echo $text_content_bottom; ?></label></div>
        <div class="positionSampleBox"><label for="buttonPos<?php echo $module_row; ?>_2"><img src="view/image/facebooklogin/content_bottom.png" title="<?php echo $text_content_bottom; ?>" border="0" /></label></div>        
    </div>
    <div class="buttonPositionOpenCart">
        <div class="leftBoxInput"><input <?php if ($module['position'] == 'column_left') echo 'checked="checked"'; ?> type="radio" style="width:auto" name="facebooklogin_module[<?php echo $module_row; ?>][position]" id="buttonPos<?php echo $module_row; ?>_3" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_<?php echo $module_row; ?>" value="column_left" /></div><div class="leftBoxTitle posTitleLabel"><label for="buttonPos<?php echo $module_row; ?>_3"><?php echo $text_column_left; ?></label></div>
        <div class="positionSampleBox"><label for="buttonPos<?php echo $module_row; ?>_3"><img src="view/image/facebooklogin/column_left.png" title="<?php echo $text_column_left; ?>" border="0" /></label></div>        
    </div>
    <div class="buttonPositionOpenCart last">
        <div class="leftBoxInput"><input <?php if ($module['position'] == 'column_right') echo 'checked="checked"'; ?> type="radio" style="width:auto" name="facebooklogin_module[<?php echo $module_row; ?>][position]" id="buttonPos<?php echo $module_row; ?>_4" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_<?php echo $module_row; ?>" value="column_right" /></div><div class="leftBoxTitle posTitleLabel"><label for="buttonPos<?php echo $module_row; ?>_4"><?php echo $text_column_right; ?></label></div>
        <div class="positionSampleBox"><label for="buttonPos<?php echo $module_row; ?>_4"><img src="view/image/facebooklogin/column_right.png" title="<?php echo $text_column_right; ?>" border="0" /></label></div>
    </div><br />
<div class="leftBoxInput">
	<input type="checkbox" style="width:auto" name="facebooklogin_module[<?php echo $module_row; ?>][position_use_selector]" <?php echo (isset($module['position_use_selector'])) ? 'checked="checked"' : ''; ?> id="buttonPosCheckbox_<?php echo $module_row; ?>"  data-textinput="#cssSelectorBox_<?php echo $module_row; ?>" />
</div>
<div class="leftBoxTitle"><label for="buttonPosCheckbox_<?php echo $module_row; ?>"><?php echo $text_load_in_selector; ?></label></div><input type="text" class="cssSelectorBox" id="cssSelectorBox_<?php echo $module_row; ?>" name="facebooklogin_module[<?php echo $module_row; ?>][position_selector]" value="<?php echo (!empty($module['position_selector'])) ? $module['position_selector'] : '#content .login-content, #checkout .checkout-content' ; ?>" /></td>
      <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="btn btn-danger"><?php echo $button_remove; ?></a></td>
    </tr>
  </tbody>
  <?php $module_row++; ?>
  <?php } ?>
  <tfoot>
    <tr>
      <td colspan="2"></td>
      <td class="left"><a onclick="addModule();" class="btn btn-success"><?php echo $button_add_module; ?></a></td>
    </tr>
  </tfoot>
</table>
<script type="text/javascript">
var tofbkeCSScheckbox = function() {
	$('input[type=checkbox][id^=buttonPosCheckbox]').each(function(index, element) {
		if ($(this).is(':checked')) {
			$($(this).attr('data-textinput')).removeAttr('disabled');
		} else {
			$($(this).attr('data-textinput')).attr('disabled','disabled');
		}
	});
}

var createBinds = function() {
	$('input[type=checkbox][id^=buttonPosCheckbox]').unbind('change').bind('change', function() {
		tofbkeCSScheckbox();
	});
	
	$('.buttonPositionOptionBox').unbind('change').bind('çhange', function() {
		$($(this).attr('data-checkbox')).removeAttr('checked');
		tofbkeCSScheckbox();
	});
};

tofbkeCSScheckbox();
createBinds();
</script>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
	html  = '<tbody style="display:none;" id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left">';
	html += '    <label class="module-row-label"><?php echo $entry_status; ?></label><select name="facebooklogin_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select><br />';
	html += '    <label class="module-row-label"><?php echo $entry_layout; ?></label><select name="facebooklogin_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select><br />';
	html += '    <label class="module-row-label"><?php echo $entry_sort_order; ?></label><input class="module-row-input-number" type="number" name="facebooklogin_module[' + module_row + '][sort_order]" value="0" />';
	html += '    </td>';
	html += '    <td class="left">';
	html += '<div class="buttonPositionOpenCart"><div class="leftBoxInput"><input checked="checked" type="radio" style="width:auto" name="facebooklogin_module[' + module_row + '][position]" id="buttonPos' + module_row + '_1" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_' + module_row + '" value="content_top" /></div><div class="leftBoxTitle posTitleLabel"><label for="buttonPos' + module_row + '_1"><?php echo $text_content_top; ?></label></div><div class="positionSampleBox"><label for="buttonPos' + module_row + '_1"><img src="view/image/facebooklogin/content_top.png" title="<?php echo $text_content_top; ?>" border="0" /></label></div></div>';
	html += '<div class="buttonPositionOpenCart"><div class="leftBoxInput"><input type="radio" style="width:auto" name="facebooklogin_module[' + module_row + '][position]" id="buttonPos' + module_row + '_2" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_' + module_row + '" value="content_bottom" /></div><div class="leftBoxTitle posTitleLabel"><label for="buttonPos' + module_row + '_2"><?php echo $text_content_bottom; ?></label></div><div class="positionSampleBox"><label for="buttonPos' + module_row + '_2"><img src="view/image/facebooklogin/content_bottom.png" title="<?php echo $text_content_bottom; ?>" border="0" /></label></div></div>';
	html += '<div class="buttonPositionOpenCart"><div class="leftBoxInput"><input type="radio" style="width:auto" name="facebooklogin_module[' + module_row + '][position]" id="buttonPos' + module_row + '_3" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_' + module_row + '" value="column_left" /></div><div class="leftBoxTitle posTitleLabel"><label for="buttonPos' + module_row + '_3"><?php echo $text_column_left; ?></label></div><div class="positionSampleBox"><label for="buttonPos' + module_row + '_3"><img src="view/image/facebooklogin/column_left.png" title="<?php echo $text_column_left; ?>" border="0" /></label></div></div>';
	html += '<div class="buttonPositionOpenCart last"><div class="leftBoxInput"><input type="radio" style="width:auto" name="facebooklogin_module[' + module_row + '][position]" id="buttonPos' + module_row + '_4" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_' + module_row + '" value="column_right" /></div><div class="leftBoxTitle posTitleLabel"><label for="buttonPos' + module_row + '_4"><?php echo $text_column_right; ?></label></div><div class="positionSampleBox"><label for="buttonPos' + module_row + '_4"><img src="view/image/facebooklogin/column_right.png" title="<?php echo $text_column_right; ?>" border="0" /></label></div></div>';
	html += '<br /><div class="leftBoxInput">	<input type="checkbox" style="width:auto" name="facebooklogin_module[' + module_row + '][position_use_selector]" id="buttonPosCheckbox_' + module_row + '" data-textinput="#cssSelectorBox_' + module_row + '" /></div><div class="leftBoxTitle"><label for="buttonPosCheckbox_' + module_row + '"><?php echo $text_load_in_selector; ?></label></div><input disabled="disabled" type="text" class="cssSelectorBox" id="cssSelectorBox_' + module_row + '" name="facebooklogin_module[' + module_row + '][position_selector]" value="<?php echo (!empty($module['position_selector'])) ? $module['position_selector'] : '#content .login-content, #checkout .checkout-content' ; ?>" />';
	html += '    </td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="btn btn-danger"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	$('#module-row' + module_row).fadeIn();
	
	createBinds();
	
	module_row++;
}
//--></script>