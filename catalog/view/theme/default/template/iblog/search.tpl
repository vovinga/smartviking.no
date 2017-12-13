<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<h1><?php echo $heading_title; ?></h1>
	<b><?php echo $text_critea; ?></b>
	<div class="content">
		<p><?php echo $entry_search; ?>
			<?php if ($search) { ?>
			<input type="text" name="search" value="<?php echo $search; ?>" />
			<?php } else { ?>
			<input type="text" name="search" value="<?php echo $search; ?>" onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;" />
			<?php } ?>
		</p>
		<?php if ($description) { ?>
		<input type="checkbox" name="description" value="1" id="description" checked="checked" />
		<?php } else { ?>
		<input type="checkbox" name="description" value="1" id="description" />
		<?php } ?>
		<label for="description"><?php echo $entry_description; ?></label>
	</div>
	<div class="buttons">
		<div class="right"><input type="button" value="<?php echo $search_button; ?>" id="button-search" class="button" /></div>
	</div>
	<h2><?php echo $text_search; ?></h2>
	<?php if (isset($posts)) { ?>
	<div class="iblog-filter">
		<div class="limit"><b><?php echo $text_limit; ?></b>
			<select onchange="location = this.value;">
				<?php foreach ($limits as $limit) { ?>
				<?php if ($limit['value'] == $current_limit) { ?>
				<option value="<?php echo $limit['href']; ?>" selected="selected"><?php echo $limit['text']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $limit['href']; ?>"><?php echo $limit['text']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
		</div>
		<div class="sort"><b><?php echo $text_sort; ?></b>
			<select onchange="location = this.value;">
				<?php foreach ($sorts as $sort) { ?>
				<?php if ($sort['value'] == $current_sort . '-' . $current_order) { ?>
				<option value="<?php echo $sort['href']; ?>" selected="selected"><?php echo $sort['text']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $sort['href']; ?>"><?php echo $sort['text']; ?></option>
				<?php } ?>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="iblog-posts-list">
		<?php foreach ($posts as $post) { ?>
		<div>
			<?php if ($post['image']) { ?>
			<div class="image"><a href="<?php echo $post['href']; ?>"><img src="<?php echo $post['image']; ?>" title="<?php echo $post['title']; ?>" alt="<?php echo $post['title']; ?>" /></a></div>
			<?php } ?>
			<div class="right">
				<div class="name"><a href="<?php echo $post['href']; ?>"><?php echo $post['title']; ?></a></div>
				<div class="description"><?php echo $post['excerpt']; ?></div>
				<div class="iblog-button"><a href="<?php echo $post['href']; ?>" class="button"><?php echo $iblog_button; ?></a></div>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="iblog-pagination"><?php echo $pagination; ?></div>
	<?php } else { ?>
	<div class="content"><?php echo $text_empty; ?></div>
	<?php }?>
	<?php echo $content_bottom; ?>
</div>
<script type="text/javascript"><!--
	$('#content input[name=\'search\']').keydown(function(e) {
		if (e.keyCode == 13) {
			$('#button-search').trigger('click');
		}
	});

	$('#button-search').bind('click', function() {
		url = 'index.php?route=module/iblog/search';

		var search = $('#content input[name=\'search\']').attr('value');

		if (search) {
			url += '&search=' + encodeURIComponent(search);
		}

		var filter_description = $('#content input[name=\'description\']:checked').attr('value');

		if (filter_description) {
			url += '&description=true';
		}

		location = url;
	});
//--></script>
<?php if(!empty($data['CustomListingCSS'])): ?>
<style><?php echo htmlspecialchars_decode($data['CustomListingCSS']); ?></style>
<?php endif; ?>
<?php echo $footer; ?>