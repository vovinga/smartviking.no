<?php require_once 'view/template/module/mod_gifts_header.tpl'; ?>

<div id="tabs-form" class="htabs">
	<a href="#tabs-form-general"><?php echo $tab_general; ?></a>
	<a href="#tabs-form-data"><?php echo $tab_data; ?></a>
</div>

<div id="tabs-form-general">
	<table class="form">
		<tr>
			<td><span class="required">*</span> <?php echo $column_type; ?>:</td>
			<td>
				<select name="type">
					<option value="first_order"<?php if( $type == 'first_order' ) { ?> selected="selected"<?php } ?>><?php echo $type_first_order; ?></option>
					<option value="every_order"<?php if( $type == 'every_order' ) { ?> selected="selected"<?php } ?>><?php echo $type_every_order; ?></option>
                </select>
			</td>
		</tr>
		<tr>
			<td><span class="required">*</span> <?php echo $column_amount; ?>:</td>
			<td>
				<input type="text" name="amount" value="<?php echo $amount; ?>" />
				
				<?php if( ! empty( $_error_amount ) ) { ?>
					<span class="error"><?php echo $_error_amount; ?></span>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<td><span class="required">*</span> <?php echo $column_items; ?>:</td>
			<td>
				<input type="text" name="items" value="<?php echo $items; ?>" />
				<span class="help">-1 = unlimited</span>
			</td>
		</tr>
		<tr>
			<td><span class="required">*</span> <?php echo $column_status; ?>:</td>
			<td>
				<select name="status">
					<option value="1"<?php if( $status ) { ?> selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
					<option value="0"<?php if( ! $status ) { ?> selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
                </select>
			</td>
		</tr>
		<tr>
			<td><span class="required">*</span> <?php echo $column_visible_on_list; ?>:</td>
			<td>
				<select name="visible_on_list">
					<option value="1"<?php if( $visible_on_list ) { ?> selected="selected"<?php } ?>><?php echo $text_yes; ?></option>
					<option value="0"<?php if( ! $visible_on_list ) { ?> selected="selected"<?php } ?>><?php echo $text_no; ?></option>
                </select>
				<span class="help">
					Display on the list of gifts <a href="<?php echo HTTP_CATALOG; ?>index.php?route=module/mod_gifts/items" target="_blank"><?php echo HTTP_CATALOG; ?>index.php?route=module/mod_gifts/items</a>
				</span>
			</td>
		</tr>
		<tr>
			<td><span class="required">*</span> <?php echo $entry_gifts; ?></td>
			<td>
				<div class="scrollbox" style="width:700px; height: 300px;">
					<?php $class = 'odd'; ?>
					
					<?php foreach( $gifts as $gift ) { ?>
						<?php $class = ( $class == 'even' ? 'odd' : 'even' ); ?>
						
						<div class="<?php echo $class; ?>">
							<img src="<?php echo $gift['image']; ?>" style="float:none; vertical-align: middle; margin-right: 5px;" />
							<input style="vertical-align: middle" type="checkbox" name="group_item[]" value="<?php echo $gift['gift_id']; ?>"<?php if( in_array( $gift['gift_id'], $group_items ) ) { ?> checked="checked"<?php } ?> />
							<?php echo $gift['name']; ?> (<?php echo $currency->format( $gift['price'] ); ?>)
						</div>
					<?php } ?>
                </div>
				
				<?php if( ! empty( $_error_group_item ) ) { ?>
					<span class="error"><?php echo $_error_group_item; ?></span>
				<?php } ?>
			</td>
		</tr>
	</table>
</div>

<div id="tabs-form-data">
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
					<td><?php echo $column_name; ?>:</td>
					<td>
						<input type="text" size="100" name="group_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset( $group_description[$language['language_id']] ) ? $group_description[$language['language_id']]['name'] : ''; ?>" />
						<span class="help">
							<?php echo $text_guide_name; ?>
						</span>
					</td>
				</tr>
				<tr>
					<td><?php echo $column_notification; ?>:</td>
					<td>
						<input type="text" size="200" name="group_description[<?php echo $language['language_id']; ?>][notification]" value="<?php echo isset( $group_description[$language['language_id']] ) ? $group_description[$language['language_id']]['notification'] : ( empty( $this->request->get['group_id'] ) ? $text_default_message : '' ); ?>" />
						<span class="help">
							<?php echo $text_guide_message; ?> "<?php echo $text_default_message; ?>"<br />
							<?php echo $text_available_params; ?>
						</span>
					</td>
				</tr>
			</table>
		</div>
	<?php } ?>
</div>

<div class="buttons">
	<a onclick="$('#form').submit(); return false;" class="button"><?php echo $button_save; ?></a>
</div>
<script type="text/javascript">
	$('#tabs-form a').tabs();
	$('#tabs-languages a').tabs();
</script> 

<?php require_once 'view/template/module/mod_gifts_footer.tpl'; ?>