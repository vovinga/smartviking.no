<?php require_once 'view/template/module/mod_gifts_header.tpl'; ?>

<div class="buttons">
	<a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>
	<a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a>
</div>

<br />

<table class="list">
	<thead>
		<tr>
			<td width="1" style="text-align: center;">
				<input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" />
			</td>
			<td class="left"><?php echo $column_type; ?></td>
			<td class="right"><?php echo $column_status; ?></td>
			<td class="right"><?php echo $column_visible_on_list; ?></td>
			<td class="right"><?php echo $column_action; ?></td>
		</tr>
	</thead>
	<tbody>
		<?php if( $groups ) { ?>
			<?php foreach( $groups as $group ) { ?>
				<tr>
					<td style="text-align: center;">
						<input type="checkbox" name="selected[]" value="<?php echo $group['group_id']; ?>"<?php if( $group['selected'] ) { ?> checked="checked"<?php } ?> />
					</td>
					<td class="left">
						<?php echo $group['name']; ?> - 
						<?php if( ! empty( $group['amount'] ) ) { ?>
							<?php echo $group['amount']; ?> - 
						<?php } ?>
						<?php if( $group['type'] == 'first_order' ) { ?>
							<?php echo $type_first_order; ?>
						<?php } else if( $group['type'] == 'every_order' ) { ?>
							<?php echo $type_every_order; ?>
						<?php } ?>
					</td>
					<td class="right"><?php echo $group['status'] ? $text_enabled : $text_disabled; ?></td>
					<td class="right"><?php echo $group['visible_on_list'] ? $text_yes : $text_no; ?></td>
					<td class="right">
						<?php foreach( $group['action'] as $action ) { ?>
							[ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
						<?php } ?>
					</td>
				</tr>
            <?php } ?>
		<?php } else { ?>
			<tr>
				<td class="center" colspan="5"><?php echo $text_no_results; ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<div class="pagination"><?php echo $pagination; ?></div>

<?php require_once 'view/template/module/mod_gifts_footer.tpl'; ?>