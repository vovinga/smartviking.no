<table class="form">
  <tr>
    <td><span class="required">*</span> <?php echo $entry_code; ?></td>
    <td>
        <select name="EasyNewsletterSubscription[Enabled]" class="EasyNewsletterSubscriptionEnabled">
            <option value="yes" <?php echo ($data['EasyNewsletterSubscription']['Enabled'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
           <option value="no" <?php echo ($data['EasyNewsletterSubscription']['Enabled'] == 'no') ? 'selected=selected' : '' ?>>Disabled</option>
        </select>
   </td>
  </tr>
    <tr>
    <td>Form Fields<span class="help">Choose which fields to be filled by the customers</span></td>
    <td>
        <select name="EasyNewsletterSubscription[FormFields]" class="EasyNewsletterSubscriptionFormFields">
            <option value="name_email" <?php echo ($data['EasyNewsletterSubscription']['FormFields'] == 'name_email') ? 'selected=selected' : '' ?>>Name and Email</option>
           <option value="email" <?php echo ($data['EasyNewsletterSubscription']['FormFields'] == 'email') ? 'selected=selected' : '' ?>>Only Email</option>
        </select>
   </td>
  </tr>
      <tr>
    <td>Wrap in widget</td>
    <td>
        <select name="EasyNewsletterSubscription[WrapInWidget]" class="EasyNewsletterSubscriptionWrapInWidget">
            <option value="yes" <?php echo ($data['EasyNewsletterSubscription']['WrapInWidget'] == 'yes') ? 'selected=selected' : '' ?>>Enabled</option>
           <option value="no" <?php echo ($data['EasyNewsletterSubscription']['WrapInWidget'] == 'no') ? 'selected=selected' : '' ?>>Disabled</option>
        </select>
   </td>
  </tr>
   <tr>
<td>Custom Text<span class="help">Accepts basic HTML tags</span></td>
<td>
   <?php foreach ($languages as $language) { ?>
    <img src="view/image/flags/<?php echo $language['image']; ?>" style="float:left;position:absolute;margin-left:-20px;" title="<?php echo $language['name']; ?>" />
<textarea id="description_<?php echo $language['code']; ?>" name="EasyNewsletterSubscription[CustomText][<?php echo $language['code']; ?>]" style="width:300px;height:80px;"  class="EasyNewsletterSubscriptionCustomText"><?php echo (isset($data['EasyNewsletterSubscription']['CustomText'][$language['code']])) ? $data['EasyNewsletterSubscription']['CustomText'][$language['code']] : 'Want to keep up to date with all our latest products?<br /><br />Enter your email below to get added to our mailing list.' ?></textarea>
 <?php } ?>
</td>
</tr>
  <tr>
<td>Custom CSS</td>
<td>
<textarea name="EasyNewsletterSubscription[CustomCSS]" class="EasyNewsletterSubscriptionCustomCSS"><?php echo (isset($data['EasyNewsletterSubscription']['CustomCSS'])) ? $data['EasyNewsletterSubscription']['CustomCSS'] : '' ?></textarea>
</td>
</tr>
  <tr class="EasyNewsletterSubscriptionActiveTR">
     <td colspan="2">
  <table id="module" class="table table-bordered table-hover" width="100%" >
  <thead>
    <tr class="table-header">
      <td class="left"><strong><?php echo $entry_layout_options; ?></strong></td>
      <td class="left"><strong><?php echo $entry_position_options; ?></strong></td>
      <td><strong>Actons:</strong></td>
    </tr>
  </thead>
  <?php $module_row = 0; ?>
  <?php foreach ($modules as $module) { ?>
  <tbody id="module-row<?php echo $module_row; ?>">
    <tr>
      <td class="left">
        <label class="module-row-label"><?php echo $entry_status; ?> <select class="span2" name="easynewslettersubscription_module[<?php echo $module_row; ?>][status]">
          <?php if ($module['status']) { ?>
          <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
          <option value="0"><?php echo $text_disabled; ?></option>
          <?php } else { ?>
          <option value="1"><?php echo $text_enabled; ?></option>
          <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
          <?php } ?>
        </select></label><br />
        <label class="module-row-label"><?php echo $entry_layout; ?> <select class="span2" name="easynewslettersubscription_module[<?php echo $module_row; ?>][layout_id]">
          <?php foreach ($layouts as $layout) { ?>
          <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select></label><br />
<label class="module-row-label"><?php echo $entry_sort_order; ?> <input class="span1" class="module-row-input-number" type="number" name="easynewslettersubscription_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" /></label>      </td>
      <td class="left">
        <div class="buttonPositionOpenCart" style="float:left; padding-right:10px;">
        <div class="leftBoxInput" style="text-align:center;"><input <?php if ($module['position'] == 'content_top') echo 'checked="checked"'; ?> type="radio" style="width:auto" name="easynewslettersubscription_module[<?php echo $module_row; ?>][position]" id="buttonPos<?php echo $module_row; ?>_1" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_<?php echo $module_row; ?>" value="content_top" /></div><div class="leftBoxTitle posTitleLabel" style="text-align:center;"><label for="buttonPos1"><?php echo $text_content_top; ?></label></div>
        <div class="positionSampleBox"><label for="buttonPos<?php echo $module_row; ?>_1"><img class="img-polaroid" src="view/image/easynewslettersubscription/content_top.png" title="<?php echo $text_content_top; ?>" border="0" /></label></div>        
    </div>
        <div class="buttonPositionOpenCart" style="float:left; padding-right:10px;">
        <div class="leftBoxInput" style="text-align:center;"><input <?php if ($module['position'] == 'content_bottom') echo 'checked="checked"'; ?> type="radio" style="width:auto" name="easynewslettersubscription_module[<?php echo $module_row; ?>][position]" id="buttonPos<?php echo $module_row; ?>_2" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_<?php echo $module_row; ?>" value="content_bottom" /></div><div class="leftBoxTitle posTitleLabel" style="text-align:center;"><label for="buttonPos2"><?php echo $text_content_bottom; ?></label></div>
        <div class="positionSampleBox"><label for="buttonPos<?php echo $module_row; ?>_2"><img class="img-polaroid" src="view/image/easynewslettersubscription/content_bottom.png" title="<?php echo $text_content_bottom; ?>" border="0" /></label></div>        
    </div>
        <div class="buttonPositionOpenCart" style="float:left; padding-right:10px;">
        <div class="leftBoxInput" style="text-align:center;"><input <?php if ($module['position'] == 'column_left') echo 'checked="checked"'; ?> type="radio" style="width:auto" name="easynewslettersubscription_module[<?php echo $module_row; ?>][position]" id="buttonPos<?php echo $module_row; ?>_3" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_<?php echo $module_row; ?>" value="column_left" /></div><div class="leftBoxTitle posTitleLabel" style="text-align:center;"><label for="buttonPos3"><?php echo $text_column_left; ?></label></div>
        <div class="positionSampleBox"><label for="buttonPos<?php echo $module_row; ?>_3"><img class="img-polaroid" src="view/image/easynewslettersubscription/column_left.png" title="<?php echo $text_column_left; ?>" border="0" /></label></div>        
    </div>
        <div class="buttonPositionOpenCart last" style="float:left; padding-right:10px;">
        <div class="leftBoxInput" style="text-align:center;"><input <?php if ($module['position'] == 'column_right') echo 'checked="checked"'; ?> type="radio" style="width:auto" name="easynewslettersubscription_module[<?php echo $module_row; ?>][position]" id="buttonPos<?php echo $module_row; ?>_4" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_<?php echo $module_row; ?>" value="column_right" /></div><div class="leftBoxTitle posTitleLabel" style="text-align:center;"><label for="buttonPos4"><?php echo $text_column_right; ?></label></div>
        <div class="positionSampleBox"><label for="buttonPos<?php echo $module_row; ?>_4"><img class="img-polaroid" src="view/image/easynewslettersubscription/column_right.png" title="<?php echo $text_column_right; ?>" border="0" /></label></div>
    </div></td>
	<td class="left" style="vertical-align:middle;"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="btn btn-small btn-danger" style="text-decoration:none;"><i class="icon-remove"></i> <?php echo $button_remove; ?></a></td>    </tr>
  </tbody>
  <?php $module_row++; ?>
  <?php } ?>
  <tfoot>
    <tr>
      <td colspan="2"></td>
      <td class="left"><a onclick="addModule();" class="btn btn-small btn-primary"><i class="icon-plus"></i> <?php echo $button_add_module; ?></a></td>
    </tr>
  </tfoot>
</table>
<script type="text/javascript">
var toggleCSScheckbox = function() {
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
		toggleCSScheckbox();
	});
	
	$('.buttonPositionOptionBox').unbind('change').bind('çhange', function() {
		$($(this).attr('data-checkbox')).removeAttr('checked');
		toggleCSScheckbox();
	});
};
toggleCSScheckbox();
createBinds();
</script>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;
function addModule() {
	html  = '<tbody style="display:none;" id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left">';
	html += '    <label class="module-row-label"><?php echo $entry_status; ?> <select class="span2" name="easynewslettersubscription_module[' + module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></label><br />';
	html += '    <label class="module-row-label"><?php echo $entry_layout; ?> <select class="span2" name="easynewslettersubscription_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></label><br />';
	html += '    <label class="module-row-label"><?php echo $entry_sort_order; ?> <input class="span1" class="module-row-input-number" type="number" name="easynewslettersubscription_module[' + module_row + '][sort_order]" value="0" /></label>';
	html += '    </td>';
	html += '    <td class="left">';
	html += '<div class="buttonPositionOpenCart" style="float:left; padding-right:10px;"><div class="leftBoxInput" style="text-align:center;"><input checked="checked" type="radio" style="width:auto" name="easynewslettersubscription_module[' + module_row + '][position]" id="buttonPos' + module_row + '_1" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_' + module_row + '" value="content_top" /></div><div class="leftBoxTitle posTitleLabel" style="text-align:center;"><label for="buttonPos1"><?php echo $text_content_top; ?></label></div><div class="positionSampleBox"><label for="buttonPos' + module_row + '_1"><img class="img-polaroid" src="view/image/easynewslettersubscription/content_top.png" title="<?php echo $text_content_top; ?>" border="0" /></label></div></div>';
	html += '<div class="buttonPositionOpenCart" style="float:left; padding-right:10px;"><div class="leftBoxInput" style="text-align:center;"><input type="radio" style="width:auto" name="easynewslettersubscription_module[' + module_row + '][position]" id="buttonPos' + module_row + '_2" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_' + module_row + '" value="content_bottom" /></div><div class="leftBoxTitle posTitleLabel" style="text-align:center;"><label for="buttonPos2"><?php echo $text_content_bottom; ?></label></div><div class="positionSampleBox"><label for="buttonPos' + module_row + '_2"><img class="img-polaroid" src="view/image/easynewslettersubscription/content_bottom.png" title="<?php echo $text_content_bottom; ?>" border="0" /></label></div></div>';
	html += '<div class="buttonPositionOpenCart" style="float:left; padding-right:10px;"><div class="leftBoxInput" style="text-align:center;"><input type="radio" style="width:auto" name="easynewslettersubscription_module[' + module_row + '][position]" id="buttonPos' + module_row + '_3" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_' + module_row + '" value="column_left" /></div><div class="leftBoxTitle posTitleLabel" style="text-align:center;"><label for="buttonPos3"><?php echo $text_column_left; ?></label></div><div class="positionSampleBox"><label for="buttonPos' + module_row + '_3"><img class="img-polaroid" src="view/image/easynewslettersubscription/column_left.png" title="<?php echo $text_column_left; ?>" border="0" /></label></div></div>';
	html += '<div class="buttonPositionOpenCart last" style="float:left; padding-right:10px;"><div class="leftBoxInput" style="text-align:center;"><input type="radio" style="width:auto" name="easynewslettersubscription_module[' + module_row + '][position]" id="buttonPos' + module_row + '_4" class="buttonPositionOptionBox" data-checkbox="#buttonPosCheckbox_' + module_row + '" value="column_right" /></div><div class="leftBoxTitle posTitleLabel" style="text-align:center;"><label for="buttonPos4"><?php echo $text_column_right; ?></label></div><div class="positionSampleBox"><label for="buttonPos' + module_row + '_4"><img class="img-polaroid" src="view/image/easynewslettersubscription/column_right.png" title="<?php echo $text_column_right; ?>" border="0" /></label></div></div>';
	html += '    </td>';
	html += '    <td class="left" style="vertical-align:middle;"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="btn btn-small btn-danger" style="text-decoration:none;"><i class="icon-remove"></i> <?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#module tfoot').before(html);
	$('#module-row' + module_row).fadeIn();
	
	createBinds();
	
	module_row++;
}
//--></script>
     </td>
  </tr>
</table>
<script>
$('.EasyNewsletterSubscriptionLayout input[type=checkbox]').change(function() {
    if ($(this).is(':checked')) { 
        $('.EasyNewsletterSubscriptionItemStatusField', $(this).parent()).val(1);
    } else {
        $('.EasyNewsletterSubscriptionItemStatusField', $(this).parent()).val(0);
    }
});
$('.EasyNewsletterSubscriptionEnabled').change(function() {
    toggleEasyNewsletterSubscriptionActive(true);
});
var toggleEasyNewsletterSubscriptionActive = function(animated) {
   if ($('.EasyNewsletterSubscriptionEnabled').val() == 'yes') {
        if (animated) 
            $('.EasyNewsletterSubscriptionActiveTR').fadeIn();
        else 
            $('.EasyNewsletterSubscriptionActiveTR').show();
    } else {
        if (animated) 
            $('.EasyNewsletterSubscriptionActiveTR').fadeOut();
        else 
            $('.EasyNewsletterSubscriptionActiveTR').hide();
    }
}
toggleEasyNewsletterSubscriptionActive(false);
</script>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description_<?php echo $language['code']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script> 