<div class="container-fluid" id="panel_positions">
	<div class="row">
		<div class="col-xs-3">
			<h5>Listing URL:</h5>
			<span class="help"><i class="fa fa-info-circle"></i>&nbsp;This is the URL of the page.</span>
		</div>
		<div class="col-xs-9" style="margin-top: 8px;">
			<a href="<?php echo $catalog_url . "index.php?route=module/iblog/listing"; ?>" target="_blank"><?php echo $catalog_url . "index.php?route=module/iblog/listing"; ?></a>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-xs-3">
			<h5>Add link to the listing in the main menu:</h5>
			<span class="help"><i class="fa fa-info-circle"></i>&nbsp;It may require some additional work to make it work on a highly customized themes.</span>
		</div>
		<div class="col-xs-5">
			<select id="LinkChecker" name="<?php echo $moduleName; ?>[MainLinkEnabled]" class="form-control">
				<option value="yes" <?php echo (!empty($moduleData['MainLinkEnabled']) && $moduleData['MainLinkEnabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
				<option value="no"  <?php echo (empty($moduleData['MainLinkEnabled']) || $moduleData['MainLinkEnabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
			</select>
		</div>
	</div>
	<div id="MainLinkOptions">
		<hr />
		<div class="row">
			<div class="col-xs-3">
				<h5>Menu Link Title:</h5>
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Specify the link title.</span>
			</div>
			<div class="col-xs-5">
				<?php foreach ($languages as $language) { ?>
				<div class="input-group">
					<span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
					<input type="text" class="form-control" name="<?php echo $moduleName; ?>[LinkTitle][<?php echo $language['language_id']; ?>]" value="<?php if(isset($moduleData['LinkTitle'][$language['language_id']])) { echo $moduleData['LinkTitle'][$language['language_id']]; } else { echo "iBlog"; }?>" />
				</div>
				<br />
				<?php } ?>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-xs-3">
				<h5>Menu Link Sort Order:</h5>
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Specify the sort order for the link.</span>
			</div>
			<div class="col-xs-5">
				<input type="number" class="form-control" name="<?php echo $moduleName; ?>[LinkSortOrder]" value="<?php if(isset($moduleData['LinkSortOrder'])) { echo $moduleData['LinkSortOrder']; } else { echo "7"; }?>" />
			</div>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-xs-3">
			<h5>SEO Options:</h5>
			<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Here you will find SEO options which (if used correctly) will boost your SEO rankings</span>
		</div>
		<div class="col-xs-5">
			<ul class="nav nav-tabs" id="langtabs" role="tablist">
				<?php foreach ($languages as $language) { ?>
				<li><a href="#lang-<?php echo $language['language_id']; ?>" role="tab" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/></a></li>
				<?php } ?>
			</ul>
			<br />
			<div class="tab-content">
				<?php foreach ($languages as $language) { ?>
				<div class="tab-pane" id="lang-<?php echo $language['language_id']; ?>">
					Page Title:<br />
					<input name="<?php echo $moduleName; ?>[PageTitle][<?php echo $language['language_id']; ?>]" class="form-control" type="text" value="<?php echo (isset($moduleData['PageTitle'][$language['language_id']])) ? $moduleData['PageTitle'][$language['language_id']] : 'iBlog'; ?>" />
					<br />
					Meta Description:<br />
					<textarea name="<?php echo $moduleName; ?>[MetaDescription][<?php echo $language['language_id']; ?>]" class="form-control" rows="4"><?php echo (isset($moduleData['MetaDescription'][$language['language_id']])) ? $moduleData['MetaDescription'][$language['language_id']] : 'This is an example description'; ?></textarea>
					<br />
					Meta Keywords:<br />
					<input name="<?php echo $moduleName; ?>[MetaKeywords][<?php echo $language['language_id']; ?>]" class="form-control" type="text" value="<?php echo (isset($moduleData['MetaKeywords'][$language['language_id']])) ? $moduleData['MetaKeywords'][$language['language_id']] : 'iblog, module, isenselabs, opencart extensions'; ?>" />
					<br/>
					SEO Slug:<br />
					<input name="<?php echo $moduleName; ?>[SeoURL][<?php echo $language['language_id']; ?>]" class="form-control" type="text" value="<?php echo (isset($moduleData['SeoURL'][$language['language_id']])) ? $moduleData['SeoURL'][$language['language_id']] : 'iblog'; ?>" />
					<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Type only the slug that you want to use for SEO URL. For example, you want the blog listing to be accessible from <em><?php echo $catalog_url . "<strong>iblog</strong>"; ?></em>, type only <strong>iblog</strong> in the field above.</span>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-xs-3">
			<h5>Listing image dimensions:</h5>
			<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Specify the main image dimensions.</span>
		</div>
		<div class="col-xs-5">
			<div class="input-group">
				<span class="input-group-addon">Width:&nbsp;</span>
				<input type="text" class="form-control" name="<?php echo $moduleName; ?>[ListingImageWidth]" value="<?php if(isset($moduleData['ListingImageWidth'])) { echo $moduleData['ListingImageWidth']; } else { echo "140"; }?>" />
				<span class="input-group-addon">px</span>
			</div><br />
			<div class="input-group">
				<span class="input-group-addon">Height:</span>
				<input type="text" class="form-control" name="<?php echo $moduleName; ?>[ListingImageHeight]" value="<?php if(isset($moduleData['ListingImageHeight'])) { echo $moduleData['ListingImageHeight']; } else { echo "140"; }?>" />
				<span class="input-group-addon">px</span>
			</div>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-xs-3">
			<h5>Custom CSS:</h5>
			<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Paste your custom CSS for the blog listing here.</span>
		</div>
		<div class="col-xs-5">
			<div class="form-group">
				<textarea class="form-control" name="<?php echo $moduleName; ?>[CustomListingCSS]" placeholder="Enter your custom CSS for the blog listing here." rows="4"><?php if(isset($moduleData['CustomListingCSS'])) { echo $moduleData['CustomListingCSS']; } else { echo ""; }?></textarea>
			</div>
		</div>
	</div>
</div>