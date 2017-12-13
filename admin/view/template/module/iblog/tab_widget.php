<div class="container-fluid" id="panel_positions">
	<div class="row">
		<div class="col-xs-12">
			<h5>Panel positions:</h5>
			<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Choose where do you want the wigdet to be displayed.</span>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-xs-12">
			<table id="module" class="table table-bordered table-hover info">
				<thead>
					<tr class="table-header">
						<td class="left" width="33%"><strong>Layout Options:</strong></td>
						<td class="left" width="33%"><strong>Widget Options:</strong></td>
						<td class="left" width="33%"><strong>Position Options:</strong></td>
						<td class="left" width="1"><strong>Actions:</strong></td>
					</tr>
				</thead>
				<?php $module_row = 0; ?>
				<?php foreach ($modules as $module) { ?>
				<tbody id="module-row<?php echo $module_row; ?>">
					<tr>
						<td class="left">
							<div class="form-group">
								<label><?php echo $entry_status; ?></label>
								<select name="<?php echo $moduleData_module; ?>[<?php echo $module_row; ?>][status]" class="form-control">
									<?php if ($module['status']) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label><?php echo $entry_layout; ?></label>
								<select name="<?php echo $moduleData_module; ?>[<?php echo $module_row; ?>][layout_id]" class="form-control">
									<?php foreach ($layouts as $layout) { ?>
									<?php if ($layout['layout_id'] == $module['layout_id']) { ?>
									<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label><?php echo $entry_sort_order; ?></label>
								<input class="form-control" type="number" name="<?php echo $moduleData_module; ?>[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" />
							</div>
						</td>
						<td class="left">
							<div class="form-group">
								<label>Display Categories</label><br />
								<select name="<?php echo $moduleData_module; ?>[<?php echo $module_row; ?>][CategoriesEnabled]" class="form-control">
									<?php if ($module['CategoriesEnabled']) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group">
								<label>Display Featured Posts:</label><br />
								<select name="<?php echo $moduleData_module; ?>[<?php echo $module_row; ?>][FeaturedEnabled]" class="form-control">
									<?php if ($module['FeaturedEnabled']) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group">
								<label>Featured image dimensions:</label><br />
								<div class="input-group">
									<span class="input-group-addon">Width:&nbsp;</span>
									<input type="text" class="form-control" name="<?php echo $moduleData_module; ?>[<?php echo $module_row; ?>][FeaturedImageWidth]" value="<?php echo (isset($module['FeaturedImageWidth'])) ? $module['FeaturedImageWidth'] : "130"; ?>" />
									<span class="input-group-addon">px</span>
								</div><br />
								<div class="input-group">
									<span class="input-group-addon">Height:</span>
									<input type="text" class="form-control" name="<?php echo $moduleData_module; ?>[<?php echo $module_row; ?>][FeaturedImageHeight]" value="<?php echo (isset($module['FeaturedImageHeight'])) ? $module['FeaturedImageHeight'] : "130"; ?>" />
									<span class="input-group-addon">px</span>
								</div>
							</div>
						</td>
						<td class="left">
							<div class="widgetPositionOpenCart">
								<div class="radio">
									<label for="buttonPos<?php echo $module_row; ?>_1">
										<input <?php if ($module['position'] == 'content_top') echo 'checked="checked"'; ?> type="radio" style="width:auto" name="<?php echo $moduleData_module; ?>[<?php echo $module_row; ?>][position]" id="buttonPos<?php echo $module_row; ?>_1" class="widgetPositionOptionBox" data-checkbox="#buttonPosCheckbox_<?php echo $module_row; ?>" value="content_top" />
										<?php echo $text_content_top; ?>
									</label>
								</div>
								<div class="positionSampleBox">
									<label for="buttonPos<?php echo $module_row; ?>_1"><img class="img-thumbnail" src="view/image/<?php echo $moduleNameSmall; ?>/content_top.png" title="<?php echo $text_content_top; ?>" border="0" /></label>
								</div>        
							</div>
							<div class="widgetPositionOpenCart">
								<div class="radio">
									<label for="buttonPos<?php echo $module_row; ?>_2">
										<input <?php if ($module['position'] == 'content_bottom') echo 'checked="checked"'; ?> type="radio" style="width:auto" name="<?php echo $moduleData_module; ?>[<?php echo $module_row; ?>][position]" id="buttonPos<?php echo $module_row; ?>_2" class="widgetPositionOptionBox" data-checkbox="#buttonPosCheckbox_<?php echo $module_row; ?>" value="content_bottom" />
										<?php echo $text_content_bottom; ?>
									</label>
								</div>
								<div class="positionSampleBox ">
									<label for="buttonPos<?php echo $module_row; ?>_2"><img class="img-thumbnail" src="view/image/<?php echo $moduleNameSmall; ?>/content_bottom.png" title="<?php echo $text_content_bottom; ?>" border="0" /></label>
								</div>
							</div>
							<div class="widgetPositionOpenCart">
								<div class="radio">
									<label for="buttonPos<?php echo $module_row; ?>_3">
										<input <?php if ($module['position'] == 'column_left') echo 'checked="checked"'; ?> type="radio" style="width:auto" name="<?php echo $moduleData_module; ?>[<?php echo $module_row; ?>][position]" id="buttonPos<?php echo $module_row; ?>_3" class="widgetPositionOptionBox" data-checkbox="#buttonPosCheckbox_<?php echo $module_row; ?>" value="column_left" />
										<?php echo $text_column_left; ?>
									</label>
								</div>
								<div class="positionSampleBox">
									<label for="buttonPos<?php echo $module_row; ?>_3"><img class="img-thumbnail" src="view/image/<?php echo $moduleNameSmall; ?>/column_left.png" title="<?php echo $text_column_left; ?>" border="0" /></label>
								</div>
							</div>
							<div class="widgetPositionOpenCart last">
								<div class="radio">
									<label for="buttonPos<?php echo $module_row; ?>_4">
										<input <?php if ($module['position'] == 'column_right') echo 'checked="checked"'; ?> type="radio" style="width:auto" name="<?php echo $moduleData_module; ?>[<?php echo $module_row; ?>][position]" id="buttonPos<?php echo $module_row; ?>_4" class="widgetPositionOptionBox" data-checkbox="#buttonPosCheckbox_<?php echo $module_row; ?>" value="column_right" />
										<?php echo $text_column_right; ?>
									</label>
								</div>
								<div class="positionSampleBox">
									<label for="buttonPos<?php echo $module_row; ?>_4"><img class="img-thumbnail" src="view/image/<?php echo $moduleNameSmall; ?>/column_right.png" title="<?php echo $text_column_right; ?>" border="0" /></label>
								</div>
							</div>
						</td>
						<td class="left" style="vertical-align:bottom;"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-times"></i>&nbsp;Remove</a></td>
					</tr>
				</tbody>
				<?php $module_row++; ?>
				<?php } ?>
				<tfoot>
					<tr>
						<td colspan="3"></td>
						<td class="left"><a onclick="addModule();" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Add New</a></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-xs-3">
			<h5>Custom CSS:</h5>
			<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Paste your custom CSS for the panel here.</span>
		</div>
		<div class="col-xs-3">
			<div class="form-group">
				<textarea class="form-control" name="<?php echo $moduleName; ?>[CustomPanelCSS]" placeholder="Enter your custom CSS for the panel here." rows="4"><?php if (isset($moduleData['CustomPanelCSS'])) { echo $moduleData['CustomPanelCSS']; } else { echo ""; }?></textarea>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript"><!--
	var module_row = <?php echo $module_row; ?>;

	function addModule() {
		html  = '<tbody style="display:none;" id="module-row' + module_row + '">';
		html += '<tr>';

		// Layout Options 
		html += '<td class="left">';
			html += '<div class="form-group">';
			html += '	<label><?php echo $entry_status; ?></label>';
			html += '	<select name="<?php echo $moduleData_module; ?>[' + module_row + '][status]" class="form-control">';
			html += '		<option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
			html += '		<option value="0"><?php echo $text_disabled; ?></option>';
			html += '	</select>';
			html += '</div> ';
		
			html += '<div class="form-group">';
			html += '	<label><?php echo $entry_layout; ?></label>'
			html += '	<select name="<?php echo $moduleData_module; ?>[' + module_row + '][layout_id]" class="form-control">';
				<?php foreach ($layouts as $layout) { ?>
				html += '<option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
				<?php } ?>
			html += '    </select>';
			html += '</div>';

			html += '<div class="form-group"><label><?php echo $entry_sort_order; ?></label> <input class="form-control" type="number" name="<?php echo $moduleData_module; ?>['+ module_row + '][sort_order]" value="0" /></div>';
		html += '</td>';

		// Widget Options
		html += '<td class="left">';
		html += '<div class="form-group">';
			html += '<label>Display Categories</label><br />';
			html += '<select name="<?php echo $moduleData_module; ?>[' + module_row + '][CategoriesEnabled]" class="form-control">';
				html += '<option value="1"><?php echo $text_enabled; ?></option>';
				html += '<option value="0" selected="selected"><?php echo $text_disabled; ?></option>';
			html += '</select>';
		html += '</div>';

		html += '<div class="form-group">';
			html += '<label>Display Featured Posts:</label><br />';
			html += '<select name="<?php echo $moduleData_module; ?>[' + module_row + '][FeaturedEnabled]" class="form-control">';
				html += '<option value="1"><?php echo $text_enabled; ?></option>';
				html += '<option value="0" selected="selected"><?php echo $text_disabled; ?></option>';
			html += '</select>';
		html += '</div>';

		html += '<div class="form-group">';
			html += '<label>Featured image dimensions:</label><br />';
			html += '<div class="input-group">';
				html += '<span class="input-group-addon">Width:&nbsp;</span>';
				html += '<input type="text" class="form-control" name="<?php echo $moduleData_module; ?>[' + module_row + '][FeaturedImageWidth]" value="130" />';
				html += '<span class="input-group-addon">px</span>';
			html += '</div><br />';
			html += '<div class="input-group">';
				html += '<span class="input-group-addon">Height:</span>';
				html += '<input type="text" class="form-control" name="<?php echo $moduleData_module; ?>[' + module_row + '][FeaturedImageHeight]" value="130" />';
				html += '<span class="input-group-addon">px</span>';
			html += '</div>';
		html += '</div>';
		html += '</td>';

		// Position Options
		html += '<td class="left">';
			
			html += '<div class="widgetPositionOpenCart"><div class="radio"><label for="buttonPos' + module_row + '_1"><input checked="checked" type="radio" style="width:auto" name="<?php echo $moduleData_module; ?>[' + module_row + '][position]" id="buttonPos' + module_row + '_1" class="widgetPositionOptionBox" data-checkbox="#buttonPosCheckbox_' + module_row + '" value="content_top" /><?php echo $text_content_top; ?></label></div><div class="positionSampleBox"><label for="buttonPos' + module_row + '_1"><img class="img-thumbnail" src="view/image/<?php echo $moduleNameSmall; ?>/content_top.png" title="<?php echo $text_content_top; ?>" border="0" /></label></div></div>'
			html += '<div class="widgetPositionOpenCart"><div class="radio"><label for="buttonPos' + module_row + '_2"><input type="radio" style="width:auto" name="<?php echo $moduleData_module; ?>[' + module_row + '][position]" id="buttonPos' + module_row + '_2" class="widgetPositionOptionBox" data-checkbox="#buttonPosCheckbox_' + module_row + '" value="content_bottom" /><?php echo $text_content_bottom; ?></label></div><div class="positionSampleBox"><label for="buttonPos' + module_row + '_2"><img class="img-thumbnail" src="view/image/<?php echo $moduleNameSmall; ?>/content_bottom.png" title="<?php echo $text_content_bottom; ?>" border="0" /></label></div></div>'
			html += '<div class="widgetPositionOpenCart"><div class="radio"><label for="buttonPos' + module_row + '_3"><input type="radio" style="width:auto" name="<?php echo $moduleData_module; ?>[' + module_row + '][position]" id="buttonPos' + module_row + '_3" class="widgetPositionOptionBox" data-checkbox="#buttonPosCheckbox_' + module_row + '" value="column_left" /><?php echo $text_column_left; ?></label></div><div class="positionSampleBox"><label for="buttonPos' + module_row + '_3"><img class="img-thumbnail" src="view/image/<?php echo $moduleNameSmall; ?>/column_left.png" title="<?php echo $text_column_left; ?>" border="0" /></label></div></div>'
			html += '<div class="widgetPositionOpenCart last"><div class="radio"><label for="buttonPos' + module_row + '_4"><input type="radio" style="width:auto" name="<?php echo $moduleData_module; ?>[' + module_row + '][position]" id="buttonPos' + module_row + '_4" class="widgetPositionOptionBox" data-checkbox="#buttonPosCheckbox_' + module_row + '" value="column_right" /><?php echo $text_column_right; ?></label></div><div class="positionSampleBox"><label for="buttonPos' + module_row + '_4"><img class="img-thumbnail" src="view/image/<?php echo $moduleNameSmall; ?>/column_right.png" title="<?php echo $text_column_right; ?>" border="0" /></label></div></div>';

		html += '</td>';
		html += '<td class="left" style="vertical-align:bottom;"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="btn btn-danger"><i class="fa fa-times"></i>&nbsp;<?php echo $button_remove; ?></a></td>';
		html += '</tr>';
		html += '</tbody>';
		
		$('#module tfoot').before(html);
		$('#module-row' + module_row).fadeIn();
		
		module_row++;
	}
//--></script>