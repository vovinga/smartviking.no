<?php echo $header; ?>

<?php echo $column_left; ?>

<?php echo $column_right; ?>

<div id="content">
	<?php echo $content_top; ?>
	
	<div class="breadcrumb">
		<?php foreach( $breadcrumbs as $breadcrumb ) { ?>
			<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	
	<h1><?php echo $heading_title; ?></h1>
	
	<?php if( ! empty( $mod_gifts_description ) ) { ?>
		<?php echo $mod_gifts_description; ?>
	<?php } ?>
	
	<div class="product-list gifts-list">
		<?php foreach( $groups as $group ) { ?>
			<div class="box">
			<div class="box-heading">
				<span><?php echo sprintf( $spend_over, $group['amount'], $group['items'] ); ?></span>
			</div>
				<div class="box-content">
			<div class="product-grid">
				<?php foreach( $group['gifts'] as $gift ) { ?>
					<div>
						<?php if ($gift['thumb']) { ?>
							<div>
								<a<?php if( $gift['href'] ) { ?> href="<?php echo $gift['href']; ?>"<?php } ?>>
									<img src="<?php echo $gift['thumb']; ?>" title="<?php echo $gift['name']; ?>" alt="<?php echo $gift['name']; ?>" />
								</a>
							</div>
						<?php } ?>

						<div class="name">
							<a<?php if( $gift['href'] ) { ?> href="<?php echo $gift['href']; ?>"<?php } ?>><?php echo $gift['name']; ?></a>
						</div>
					</div>
				<?php } ?>
			</div>
					</div>
			</div>
		<?php } ?>
	</div>
	
	<?php echo $content_bottom; ?>
</div>

<?php echo $footer; ?>