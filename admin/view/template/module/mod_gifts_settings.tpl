<?php require_once 'view/template/module/mod_gifts_header.tpl'; ?>

<div id="tabs-form" class="htabs">
	<a href="#tabs-form-general"><?php echo $tab_list_of_gifts; ?></a>
	<a href="#tabs-form-basket"><?php echo $tab_basket; ?></a>
	<a href="#tabs-form-layout"><?php echo $tab_layout; ?></a>
</div>

<div id="tabs-form-general">
	<div style="text-align: right; padding-bottom: 10px;">
		URL: <a href="<?php echo HTTP_CATALOG; ?>index.php?route=module/mod_gifts/items" target="_blank"><?php echo HTTP_CATALOG; ?>index.php?route=module/mod_gifts/items</a>
	</div>
	
	<div id="tabs-languages" class="htabs">
		<?php foreach( $languages as $language ) { ?>
			<a href="#tabs-language<?php echo $language['language_id']; ?>">
				<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?>
			</a>
		<?php } ?>
	</div>
	
	<?php foreach( $languages as $language ) { ?>
		<div id="tabs-language<?php echo $language['language_id']; ?>">
			<table class="form">
				<tr>
					<td><?php echo $column_description; ?>:</td>
					<td>
						<textarea name="mod_gifts_description[<?php echo $language['language_id']; ?>]" id="mod_gifts_description<?php echo $language['language_id']; ?>" ><?php echo isset( $mod_gifts_description[$language['language_id']] ) ? $mod_gifts_description[$language['language_id']] : ''; ?></textarea>
					</td>
				</tr>
			</table>
		</div>
	<?php } ?>
</div>

<div id="tabs-form-basket">
	<table class="form">
		<tr>
			<td>
				<?php echo $entry_select_first_gift; ?>:
				<span class="help"><?php echo $text_select_first_gift; ?></span>
			</td>
			<td>
				<select name="mod_gifts_settings[select_first_gift]">
					<option <?php echo empty( $settings['select_first_gift'] ) ? 'selected="selected"' : ''; ?> value="0"><?php echo $text_no; ?></option>
					<option <?php echo ! empty( $settings['select_first_gift'] ) ? 'selected="selected"' : ''; ?> value="1"><?php echo $text_yes; ?></option>
				</select>
			</td>
		</tr>
	</table>
</div>

<div id="tabs-form-layout">
	<table class="form">
		<tr>
			<td><span class="required">*</span> <?php echo $entry_image_size; ?><span class="help"><?php echo $help_image_size; ?></span></td>
			<td>
				<input type="text" size="2" value="<?php echo $mod_gifts_image_width; ?>" name="mod_gifts_image_width" /> x <input type="text" size="2" value="<?php echo $mod_gifts_image_height; ?>" name="mod_gifts_image_height" />
				<?php if( ! empty( $_image_size_layout ) ) { ?>
					<span class="error"><?php echo $_image_size_layout; ?></span>
				<?php } ?>
			</td>
		</tr>
	</table>
	
	<table id="module" class="list">
		<thead>
			<tr>
				<td class="left"><?php echo $entry_limit; ?></td>
				<td class="left"><?php echo $entry_image; ?></td>
				<td class="left"><?php echo $entry_layout; ?></td>
				<td class="left"><?php echo $entry_position; ?></td>
				<td class="left"><?php echo $column_status; ?></td>
				<td class="right"><?php echo $column_sort_order; ?></td>
				<td></td>
			</tr>
		</thead>
		
		<?php $module_row = 0; ?>
		
		<?php foreach( $modules as $module ) { ?>
			<tbody id="module-row<?php echo $module_row; ?>">
				<tr>
					<td class="left">
						<input type="text" name="mod_gifts_module[<?php echo $module_row; ?>][limit]" value="<?php echo $module['limit']; ?>" size="1" />
					</td>
					<td class="left">
						<input type="text" name="mod_gifts_module[<?php echo $module_row; ?>][image_width]" value="<?php echo $module['image_width']; ?>" size="3" />
						<input type="text" name="mod_gifts_module[<?php echo $module_row; ?>][image_height]" value="<?php echo $module['image_height']; ?>" size="3" />
						
						<?php if (isset($_error_image_size[$module_row])) { ?>
							<span class="error"><?php echo $_error_image_size[$module_row]; ?></span>
						<?php } ?>
					</td>
					<td class="left">
						<select name="mod_gifts_module[<?php echo $module_row; ?>][layout_id]">
							<?php foreach ($layouts as $layout) { ?>
								<option value="<?php echo $layout['layout_id']; ?>"<?php if ($layout['layout_id'] == $module['layout_id']) { ?> selected="selected"<?php } ?>><?php echo $layout['name']; ?></option>
							<?php } ?>
						</select>
					</td>
					<td class="left">
						<select name="mod_gifts_module[<?php echo $module_row; ?>][position]">
							<option value="content_top"<?php if ($module['position'] == 'content_top') { ?> selected="selected"<?php } ?>><?php echo $text_content_top; ?></option>
							<option value="content_bottom"<?php if ($module['position'] == 'content_bottom') { ?> selected="selected"<?php } ?>><?php echo $text_content_bottom; ?></option>
							<option value="column_left"<?php if ($module['position'] == 'column_left') { ?> selected="selected"<?php } ?>><?php echo $text_column_left; ?></option>
							<option value="column_right"<?php if ($module['position'] == 'column_right') { ?> selected="selected"<?php } ?>><?php echo $text_column_right; ?></option>
						</select>
					</td>
					<td class="left">
						<select name="mod_gifts_module[<?php echo $module_row; ?>][status]">
							<option value="1"<?php if( $module['status'] ) { ?> selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
							<option value="0"<?php if(! $module['status'] ) { ?> selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
						</select>
					</td>
					<td class="right">
						<input type="text" name="mod_gifts_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" />
					</td>
					<td class="left">
						<a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a>
					</td>
				</tr>
			</tbody>
			
			<?php $module_row++; ?>
		<?php } ?>
	
		<tfoot>
			<tr>
				<td colspan="6"></td>
				<td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
			</tr>
		</tfoot>
	</table>
</div>

<div class="buttons">
	<a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
</div>

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript">
	<?php foreach( $languages as $language ) { ?>
		CKEDITOR.replace('mod_gifts_description<?php echo $language['language_id']; ?>', {
			filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
			filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
		});
	<?php } ?>
		
	$('#tabs-form a').tabs();
	$('#tabs-languages a').tabs(); 
	
	var module_row = <?php echo $module_row; ?>;

	function addModule() {	
		html  = '<tbody id="module-row' + module_row + '">';
		html += '  <tr>';
		html += '    <td class="left"><input type="text" name="mod_gifts_module[' + module_row + '][limit]" value="5" size="1" /></td>';
		html += '    <td class="left"><input type="text" name="mod_gifts_module[' + module_row + '][image_width]" value="80" size="3" /> <input type="text" name="mod_gifts_module[' + module_row + '][image_height]" value="80" size="3" /></td>';	
		html += '    <td class="left"><select name="mod_gifts_module[' + module_row + '][layout_id]">';
		<?php foreach ($layouts as $layout) { ?>
			html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
		<?php } ?>
		html += '    </select></td>';
		html += '    <td class="left"><select name="mod_gifts_module[' + module_row + '][position]">';
		html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
		html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
		html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
		html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
		html += '    </select></td>';
		html += '    <td class="left"><select name="mod_gifts_module[' + module_row + '][status]">';
		html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
		html += '      <option value="0"><?php echo $text_disabled; ?></option>';
		html += '    </select></td>';
		html += '    <td class="right"><input type="text" name="mod_gifts_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
		html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
		html += '  </tr>';
		html += '</tbody>';

		$('#module tfoot').before(html);

		module_row++;
	}
</script> 

<?php require_once 'view/template/module/mod_gifts_footer.tpl'; ?>