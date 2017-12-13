<?php require_once 'view/template/module/mod_gifts_header.tpl'; ?>

<table class="form">
	<tr>
		<td><span class="required">*</span> <?php echo $entry_product; ?><span class="help"><?php echo $help_autocomplete; ?></span></td>
		<td>
			<input type="text" name="name" size="100" value="<?php echo isset($name) ? $name : ''; ?>" />
			<input type="hidden" name="product_id" value="<?php echo isset($product_id) ? $product_id : ''; ?>" />
			<?php if( ! empty( $_error_product ) ) { ?>
				<span class="error"><?php echo $_error_product; ?></span>
			<?php } ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $column_sort_order; ?>:</td>
		<td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
	</tr>
	<tr>
		<td><?php echo $column_status; ?>:</td>
		<td>
			<select name="status">
				<option value="1"<?php if( $status ) { ?> selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
				<option value="0"<?php if( ! $status ) { ?> selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
               </select>
		</td>
	</tr>
</table>

<div class="buttons">
	<a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
</div>

<script type="text/javascript">
	$('input[name="name"]').autocomplete({
		delay: 250,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						return {
							label: item.name + ' (' + item.price + ')',
							name: item.name,
							value: item.product_id,
							price: item.price
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			$('input[name="name"]').val(ui.item.name);
			$('input[name="product_id"]').val(ui.item.value);

			return false;
		},
		focus: function(event, ui) {
			return false;
		}
	});
</script> 

<?php require_once 'view/template/module/mod_gifts_footer.tpl'; ?>