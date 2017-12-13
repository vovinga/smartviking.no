<?php echo $header; ?>

<div id="content">
	<div class="breadcrumb">
		<?php foreach( $breadcrumbs as $breadcrumb ) { ?>
			<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	
	<?php if( ! empty( $_error_warning ) ) { ?>
		<div class="warning"><?php echo $_error_warning; ?></div>
	<?php } ?>
	
	<?php if( ! empty( $_success ) ) { ?>
		<div class="success"><?php echo $_success; ?></div>
	<?php } ?>
	
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons">
				<a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a>
			</div>
		</div>
		
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<div id="tabs" class="htabs">
					<a<?php if( $tab_active == 'gifts' ) { ?> class="selected"<?php } ?> href="<?php echo $tab_gifts_link; ?>" style="display: block;"><?php echo $tab_gifts; ?></a>
					<a<?php if( $tab_active == 'groups' ) { ?> class="selected"<?php } ?> href="<?php echo $tab_groups_link; ?>" style="display: block;"><?php echo $tab_groups; ?></a>
					<a<?php if( $tab_active == 'settings' ) { ?> class="selected"<?php } ?> href="<?php echo $tab_settings_link; ?>" style="display: block;"><?php echo $tab_settings; ?></a>
					<a<?php if( $tab_active == 'about' ) { ?> class="selected"<?php } ?> href="<?php echo $tab_about_link; ?>" style="display: block;"><?php echo $tab_about; ?></a>
				</div>