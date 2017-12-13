<section class="iblog-section">
	<?php if (!empty($featured)) { ?>
		<div class="box iblog-featured">
			<div class="box-heading"><a href="<?php echo $featured['href']; ?>"><?php echo $featured['title']; ?></a></div>
			<div class="iblog-box-content">
				<?php if (!empty($featured['image'])) : ?>
					<a href="<?php echo $featured['href']; ?>"><img src="<?php echo $featured['image']; ?>" class="iblog-featured-image" alt="<?php echo $featured['title']; ?>" /></a>
				<?php endif; ?>
				<div class="iblog-featured-description">
					<?php echo $featured['excerpt']; ?>
				</div>
				<div class="iblog-button">
					<a href="<?php echo $featured['href']; ?>" class="button"><?php echo $iblog_button; ?></a>
				</div>
			</div>
		</div>
	<?php } ?>

	<?php if (!empty($categories)) { ?>
		<div class="box iblog-categories">
			<div class="box-heading"><?php echo $categories_title; ?></a></div>
			<div class="box-content">
				<?php if (!empty($categories)) { ?>
					<ul class="box-nav">
						<?php foreach ($categories as $category) { ?>
							<li>
								<a href="<?php echo $category['href']; ?>"<?php echo ($category['category_id'] == $category_id) ? ' class="active"' : ''; ?>><?php echo $category['title']; ?></a>
								<?php if (!empty($category['children'])) { ?>
								<ul class="box-nav">
									<?php foreach ($category['children'] as $child) { ?>
										<li>
											<a href="<?php echo $child['href']; ?>"<?php echo ($child['category_id'] == $category_id) ? ' class="active"' : ''; ?>><?php echo $child['title']; ?></a>
										</li>
									<?php } ?>
								</ul>
								<?php } ?>
							</li>
						<?php } ?>
					</ul>
				<?php } else { ?>
						<div class="iblog-nocategories"><?php echo $no_categories; ?></div>
				<?php } ?>
			</div>
		</div>
	<?php } ?>

	<div class="box iblog-panel">
		<div class="box-heading"><?php echo $heading_title; ?></div>
		<div class="box-content">
			<?php if (!empty($posts)) { ?>
				<ul class="box-nav">
					<?php foreach ($posts as $post) { ?>
						<li>
							<a href="<?php echo $post['href']; ?>"<?php echo ($post['post_id'] == $post_id) ? ' class="active"' : ''; ?>><?php echo $post['title']; ?></a>
						</li>
					<?php } ?>
				</ul>
			<?php } else { ?>
					<div class="iblog-noposts"><?php echo $no_posts; ?></div>
			<?php } ?>
		</div>
	</div>

	<?php if(!empty($data['CustomPanelCSS'])): ?>
		<style>
			<?php echo htmlspecialchars_decode($data['CustomPanelCSS']); ?>
		</style>
	<?php endif; ?>
</section>