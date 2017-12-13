<div class="container-fluid">
	<div class="row">
		<div class="col-md-2">
			<h5><span class="required">* </span>Module status:</h5>
			<span class="help"><i class="fa fa-info-circle"></i> Enable or disable the module.</span>
		</div>
		<div class="col-md-3">
			<select id="Checker" name="<?php echo $moduleName; ?>[Enabled]" class="form-control">
				<option value="yes" <?php echo (!empty($moduleData['Enabled']) && $moduleData['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
				<option value="no"  <?php echo (empty($moduleData['Enabled']) || $moduleData['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
			</select>
		</div>
	</div>
	<br />
</div>