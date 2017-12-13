<?php
//-----------------------------------------------------
// Sitemap Generator for Opencart v1.5.6   				
// Created by villagedefrance                          		
// contact@villagedefrance.net      						
//-----------------------------------------------------
?>

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
	<?php if ($success) { ?>
		<div class="success"><?php echo $success; ?></div>
	<?php } ?>
	<div class="box">
	<div class="heading">
		<h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
		<div class="buttons">
			<a onclick="$('#generate_sitemap').submit();" class="button"><?php echo $button_generate; ?></a>
			<a onclick="location = '<?php echo $refresh; ?>';" class="button"><?php echo $button_refresh; ?></a>
			<a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
		</div>
	</div>
	<div class="content">
		<form action="<?php echo $generate_sitemap; ?>" method="post" enctype="multipart/form-data" id="generate_sitemap">
		<?php if ($output != '') { ?>
		<h2><?php echo $text_output; ?></h2>
		<div style="background:#F7F7F7; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
			<table width="100%">
				<tr>
					<td><?php echo $output; ?></td>
				</tr>
			</table>
		</div>
		<?php } ?>
		<?php if (!$sitemapcategories || !$sitemapproducts || !$sitemapmanufacturers || !$sitemappages) { ?>
		<div style="background:#F7F7F7; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
			<table width="100%">
				<tr>
					<td><?php echo $text_create; ?></td>
				</tr>
			</table>
		</div>
		<?php } ?>
		<h2><?php echo $text_sitemaps; ?></h2>
		<div style="background:#F7F7F7; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
			<table width="100%" cellpadding="5px">
				<tr>
					<th align="left"><b><?php echo $text_head_sitemap; ?></b></th>
					<th align="left"><b><?php echo $text_head_filename; ?></b></th>
					<th align="left"><b><?php echo $text_head_filesize; ?></b></th>
					<th align="left"><b><?php echo $text_head_filedate; ?></b></th>
					<th align="left"><b><?php echo $text_head_filecheck; ?></b></th>
				</tr>
			<?php if ($sitemapcategories) { ?>
				<tr>
					<td><?php echo $text_cat; ?></td>
					<td><?php echo $text_namecat; ?></td>
					<td><?php echo $text_sizecat; ?></td>
					<td><?php echo $text_datecat; ?></td>
					<td><a onclick="window.open('<?php echo $checkcat; ?>');" title="" class="button"><?php echo $button_check; ?></a></td>
				</tr>
			<?php } else { ?>
				<tr>
					<td colspan="5"><img src="view/image/warning.png" alt="" /> &nbsp; <?php echo $text_nocat; ?></td>
				</tr>
			<?php } ?>
			<?php if ($sitemapproducts) { ?>
				<tr>
					<td><?php echo $text_pro; ?></td>
					<td><?php echo $text_namepro; ?></td>
					<td><?php echo $text_sizepro; ?></td>
					<td><?php echo $text_datepro; ?></td>
					<td><a onclick="window.open('<?php echo $checkpro; ?>');" title="" class="button"><?php echo $button_check; ?></a></td>
				</tr>
			<?php } else { ?>
				<tr>
					<td colspan="5"><img src="view/image/warning.png" alt="" /> &nbsp; <?php echo $text_nopro; ?></td>
				</tr>
			<?php } ?>
			<?php if ($sitemapmanufacturers) { ?>
				<tr>
					<td><?php echo $text_man; ?></td>
					<td><?php echo $text_nameman; ?></td>
					<td><?php echo $text_sizeman; ?></td>
					<td><?php echo $text_dateman; ?></td>
					<td><a onclick="window.open('<?php echo $checkman; ?>');" title="" class="button"><?php echo $button_check; ?></a></td>
				</tr>
			<?php } else { ?>
				<tr>
					<td colspan="5"><img src="view/image/warning.png" alt="" /> &nbsp; <?php echo $text_noman; ?></td>
				</tr>
			<?php } ?>
			<?php if ($sitemappages) { ?>
				<tr>
					<td><?php echo $text_pag; ?></td>
					<td><?php echo $text_namepag; ?></td>
					<td><?php echo $text_sizepag; ?></td>
					<td><?php echo $text_datepag; ?></td>
					<td><a onclick="window.open('<?php echo $checkpag; ?>');" title="" class="button"><?php echo $button_check; ?></a></td>
				</tr>
			<?php } else { ?>
				<tr>
					<td colspan="5"><img src="view/image/warning.png" alt="" /> &nbsp; <?php echo $text_nopag; ?></td>
				</tr>
			<?php } ?>
			</table>
		</div>
		<?php if ($sitemapcategories || $sitemapproducts || $sitemapmanufacturers || $sitemappages) { ?>
		<h2><?php echo $text_submit; ?></h2>
		<div style="background:#F7F7F7; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
			<table width="100%">
				<tr>
					<td>
					<a onclick="window.open('<?php echo $googleweb; ?>');" title="Google Webmaster Tools"><img src="view/image/sitemaps/google-web.gif" alt="Google" /></a> &nbsp;
					<a onclick="window.open('<?php echo $bingweb; ?>');" title="Bing Webmaster Tools"><img src="view/image/sitemaps/bing-web.gif" alt="Bing" /></a> &nbsp;
					<a onclick="window.open('<?php echo $yandexweb; ?>');" title="Yandex Webmaster Tools"><img src="view/image/sitemaps/yandex-web.gif" alt="Yandex" /></a> &nbsp;
					<a onclick="window.open('<?php echo $baiduweb; ?>');" title="Baidu Webmaster Tools"><img src="view/image/sitemaps/baidu-web.gif" alt="Baidu" /></a> &nbsp;
					</td>
				</tr>
				<tr style="background:#FFF;">
					<td style="padding:10px;"><?php echo $text_publish; ?></td>
				</tr>
			</table>
		</div>
		<?php } ?>
		
		<div class="versioncheck">
			<table class="form">
				<tr>
					<td></td>
					<td colspan="2"><?php echo $module_name; ?><b><?php echo $module_current_name; ?></b></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2"><?php echo $module_list; ?>
					<?php foreach ($compatibles as $compatible) { ?>
						<?php if($store_base_version == $compatible['opencart']) { ?>
							<b><?php echo $compatible['title']; ?></b>
						<?php } else { ?>
							<?php echo $compatible['title']; ?>
						<?php } ?>
					<?php } ?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2"><?php echo $store_version; ?>
					&nbsp;&nbsp;&nbsp;
					<?php foreach ($compatibles as $compatible) { ?>
						<?php if($store_base_version == $compatible['opencart']) { ?>
							<img src="view/image/success.png" alt="" />
						<?php } ?>
					<?php } ?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2"><?php echo $text_template; ?>
						<?php foreach ($templates as $template) { ?>
							<?php if ($template == $config_template) { ?>
								<b><?php echo $template; ?></b>
							<?php } ?>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2"><span style='color: #FF8800;'><b><?php echo $text_status; ?></b></span></td>
				</tr>
			<?php if($version && $revision) { ?>
				<tr>
					<td></td>
					<td><?php echo $module_current_version; ?></td>
					<td><?php echo $version; ?></td>
				</tr>
				<tr>
					<td></td>
					<td><?php echo $module_current_revision; ?></td>
					<td><?php echo $revision; ?></td>
				</tr>
			<?php } else { ?>
				<tr>
					<td></td>
					<td colspan="2"><?php echo $text_no_file; ?></td>
				</tr>
			<?php } ?>
			<?php if($ver_update || $rev_update) { ?>
				<tr>
					<td></td>
					<td colspan="2"><span style='color: #FF8800;'><b><?php echo $text_update; ?></b></span></td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2">
					<?php echo $text_getupdate; ?>
					<br /><br />
					<a onclick="window.open('https://villagedefrance.net/index.php?route=account/login');" title="Villagedefrance"><img src="view/image/villagedefrance-30.png" alt="Villagedefrance" /></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a onclick="window.open('https://www.opencart.com/index.php?route=account/login');" title="Opencart"><img src="view/image/opencart-30.png" alt="Opencart" /></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a onclick="window.open('http://opencart-france.fr/index.php?route=account/login');" title="Opencart France"><img src="view/image/opencart-france-30.png" alt="Opencart France" /></a>
					<br />
					</td>
				</tr>
			<?php } ?>
				<tr>
					<td></td>
					<td colspan="2">
						<a onclick="window.open('http://villagedefrance.net/index.php?route=information/contact');" title="Contact Support" class="button"><?php echo $button_support; ?></a>
					</td>
				</tr>
			</table>
			</div>
		
			<table class="form">
				<tr>
					<td><a onclick="window.open('http://www.villagedefrance.net');" title="villagedefrance"><img src="view/image/villagedefrance.png" alt="" /></a></td>
				</tr>
			</table>
		
		</form>
	</div>
	</div>
</div>

<script type="text/javascript"><!--
$(document).ready(function(){	
	$('.versioncheck').hide().before('<a href="#" id="<?php echo 'versioncheck'; ?>" class="button" style="margin-bottom:10px;"><span><?php echo $button_showhide; ?></span></a>');
	$('a#<?php echo 'versioncheck'; ?>').click(function() {
		$('.versioncheck').slideToggle(1000);
		return false;
	});
});
//--></script>

<?php echo $footer; ?>