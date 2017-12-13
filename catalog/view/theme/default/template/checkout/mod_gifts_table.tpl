<?php require(DIR_TEMPLATE . '/default/template/checkout/mod_gifts_js.tpl'); ?>

<?php if( ! empty( $has_gifts ) ) { ?>
<div style="display: none" id="div-mod-gifts-table">
	<table id="table-gifts">
		<thead>
			<tr>
				<td colspan="5"><center id="gifts-header"><?php echo $text_gifts; ?></center></td>
			</tr>
		</thead>
		<tbody>
			<?php $index = 0; ?>
			<?php foreach ($products as $product) { ?>
				<?php if( empty( $product['mod_is_gift'] ) ) continue; ?>
				<?php if( $index == 0 ) { ?>
					<tr>
				<?php } ?>
				<td style="vertical-align: top">
					<?php if ($product['thumb']) { ?>
						<center>
							<a href="<?php echo $product['href']; ?>">
								<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" />
							</a>
							<br /><br />
						</center>
					<?php } ?>
					<center>
						<input 
							id="gift_id_<?php echo $product["mod_group_id"]; ?>_<?php echo $product["product_id"]; ?>"
							style="vertical-align: middle; margin:0; margin-right: 5px;"
							type="checkbox"
							data-gift-group-id="<?php echo $product["mod_group_id"]; ?>"
							name="gifts[]"
							value="<?php echo $product["mod_group_id"]; ?>,<?php echo $product["product_id"]; ?>"
							<?php if( ! empty( $product["mod_is_select"] ) ) { ?> checked="checked"<?php } ?>
						/>
						<label for="gift_id_<?php echo $product["mod_group_id"]; ?>_<?php echo $product["product_id"]; ?>"><?php echo $text_select_gift; ?></label>
					</center>
					
					<?php require(DIR_TEMPLATE . "/default/template/checkout/mod_gifts_options.tpl"); ?>
					<br />
					<center>
						<b>
							<a href="<?php echo $product["href"]; ?>"><?php echo addslashes( $product["name"] ); ?></a>
						</b>
					</center>
					
					<?php if (!$product['stock']) { ?>
						<span class="stock">***</span>
					<?php } ?>
					<div style="text-align:left;">
						<?php foreach ($product['option'] as $option) { ?>
							- <small><?php echo addslashes( $option["name"] ); ?>: <?php echo $option["value"]; ?></small><br />
						<?php } ?>
					</div>
					<?php if ($product['reward']) { ?>
						<small><?php echo $product['reward']; ?></small>
					<?php } ?>
				</td>
			<?php if( $index == 4 ) { ?>
				</tr>
			<?php } ?>
			<?php
				$index++;

				if( $index > 4 )
					$index = 0;
			?>
		<?php } ?>
		<?php if( $index != 0 ) { ?>
			</tr>
		<?php } ?>
        </tbody>
		<tfoot>
			<tr>
				<td colspan="5" style="text-align:right">
					<input type="submit" id="add_gift_to_cart" value="<?php echo $button_update; ?>" class="button" />
				</td>
			</tr>
		</tfoot>
	</table>
</div>

<script type="text/javascript">
	$('.cart-info:first').append( $('#div-mod-gifts-table').html() );
	$('#div-mod-gifts-table').remove();
	$('#add_gift_to_cart').click(function(){
		$(this).after('<input type="hidden" name="add_gift_to_cart" value="1" />');
	});
</script>
<?php } ?>