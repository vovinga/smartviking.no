<?php echo $header; ?>

<div id="content">

	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	
	<?php if ($error_warning) { ?>
		<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	
	<div class="box">
	
		<div class="heading">
			<h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons">
				<a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
				<a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a>
			</div>
		</div>
		
		<div class="content">
		
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			
				<table class="form">
				
					<tr>
						<td><?php echo $entry_min_sum; ?></td>
						<td><input type="text" name="posten_mypack_min_sum" value="<?php echo $posten_mypack_min_sum; ?>" /></td>
					</tr>

					<tr>
						<td><?php echo $entry_max_sum; ?></td>
						<td><input type="text" name="posten_mypack_max_sum" value="<?php echo $posten_mypack_max_sum; ?>" /></td>
					</tr>
					
					<tr>
						<td><?php echo $entry_teir_1_cost; ?></td>
						<td><input type="text" name="posten_mypack_teir_1_cost" value="<?php echo $posten_mypack_teir_1_cost; ?>" /></td>
					</tr>
					
					<tr>
						<td><?php echo $entry_teir_2_cost; ?></td>
						<td><input type="text" name="posten_mypack_teir_2_cost" value="<?php echo $posten_mypack_teir_2_cost; ?>" /></td>
					</tr>

					<tr>
						<td><?php echo $entry_teir_3_cost; ?></td>
						<td><input type="text" name="posten_mypack_teir_3_cost" value="<?php echo $posten_mypack_teir_3_cost; ?>" /></td>
					</tr>
					
					<tr>
						<td><?php echo $entry_teir_4_cost; ?></td>
						<td><input type="text" name="posten_mypack_teir_4_cost" value="<?php echo $posten_mypack_teir_4_cost; ?>" /></td>
					</tr>
					
					<tr>
						<td><?php echo $entry_teir_5_cost; ?></td>
						<td><input type="text" name="posten_mypack_teir_5_cost" value="<?php echo $posten_mypack_teir_5_cost; ?>" /></td>
					</tr>					
					
					<tr>
						<td><?php echo $entry_tax_class; ?></td>
						<td>
							<select name="posten_mypack_tax_class_id">
								<option value="0"><?php echo $text_none; ?></option>
								
								<?php foreach ($tax_classes as $tax_class) { ?>
									<?php if ($tax_class['tax_class_id'] == $posten_mypack_tax_class_id) { ?>
										<option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
									<?php } ?>
								<?php } ?>
								
							</select>
						</td>
					</tr>
					
					<tr>
						<td><?php echo $entry_geo_zone; ?></td>
						<td>
							<select name="posten_mypack_geo_zone_id">
								<option value="0"><?php echo $text_all_zones; ?></option>
								
								<?php foreach ($geo_zones as $geo_zone) { ?>
									<?php if ($geo_zone['geo_zone_id'] == $posten_mypack_geo_zone_id) { ?>
										<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
									<?php } ?>
								<?php } ?>
								
							</select>
						</td>
					</tr>

					<tr>
						<td><?php echo $entry_customer_group; ?></td>
						<td>
							<select name="posten_mypack_customer_group_id">
								<option value="0"><?php echo $text_all_groups; ?></option>
								
								<?php foreach ($customer_groups as $customer_group) { ?>
									<?php if ($customer_group['customer_group_id'] == $posten_mypack_customer_group_id) { ?>
										<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
									<?php } ?>
								<?php } ?>
								
							</select>
						</td>
					</tr>
					
					<tr>
						<td><?php echo $entry_status; ?></td>
						<td>
							<select name="posten_mypack_status">
							
								<?php if ($posten_mypack_status) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
								
							</select>
						</td>
					</tr>
					
					<tr>
						<td><?php echo $entry_sort_order; ?></td>
						<td><input type="text" name="posten_mypack_sort_order" value="<?php echo $posten_mypack_sort_order; ?>" size="1" /></td>
        			</tr>
        			
        		</table>
        		
			</form>
			
		</div>
		
	</div>
	
</div>

<?php echo $footer; ?>