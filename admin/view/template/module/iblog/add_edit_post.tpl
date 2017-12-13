<form method="post" enctype="multipart/form-data" id="PostForm">
	<input type="hidden" name="store_id" value="<?php echo $this->request->get['store_id']; ?>" />
	<?php if (isset($post_id)) { ?>
	<input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
	<?php } ?>
	<div class="container-fluid tabbable">
		<div class="tab-navigation form-inline">
			<ul class="nav nav-tabs" role="tablist">
				<?php foreach ($languages as $language) { ?>
				<li><a href="#post_language_<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
				<?php } ?>
			</ul>	
		</div>
		<div class="tab-content">
			<?php foreach ($languages as $language) { ?>
			<div class="tab-pane" id="post_language_<?php echo $language['language_id']; ?>">
				<div class="row">
					<div class="col-md-2">
						<h5><span class="required">* </span><?php echo $entry_title; ?></h5>
						<span class="help"><i class="fa fa-info-circle"></i> This is the title of the blog post.</span>
					</div>
					<div class="col-md-5">
						<input type="text" name="post_description[<?php echo $language['language_id']; ?>][title]" size="100" value="<?php echo isset($post_description[$language['language_id']]) ? $post_description[$language['language_id']]['title'] : ''; ?>" class="form-control" />
					</div>
				</div>
				<hr />
				<div class="row">
					<div class="col-md-2">
						<h5><span class="required">* </span><?php echo $entry_excerpt; ?></h5>
						<span class="help"><i class="fa fa-info-circle"></i> This is the short description of the blog post.</span>
					</div>
					<div class="col-md-5">
						<textarea class="form-control" name="post_description[<?php echo $language['language_id']; ?>][excerpt]" id="excerpt<?php echo $language['language_id']; ?>"  cols="40" rows="5"><?php echo isset($post_description[$language['language_id']]) ? $post_description[$language['language_id']]['excerpt'] : ''; ?></textarea>
					</div>
				</div>
				<hr /> 
				<div class="row">
					<div class="col-md-2">
						<h5><span class="required">* </span><?php echo $entry_body; ?></h5>
						<span class="help"><i class="fa fa-info-circle"></i> Blog post body.</span>
					</div>
					<div class="col-md-10">
						<textarea name="post_description[<?php echo $language['language_id']; ?>][body]" id="blog_post_body<?php echo $language['language_id']; ?>"><?php echo isset($post_description[$language['language_id']]) ? $post_description[$language['language_id']]['body'] : ''; ?></textarea>
					</div>
				</div>
				<hr /> 
				<div class="row">
					<div class="col-md-2">
						<h5><?php echo $entry_meta_description; ?></h5>
						<span class="help"><i class="fa fa-info-circle"></i> Meta description.</span>
					</div>
					<div class="col-md-5">
						<textarea  class="form-control" name="post_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="4"><?php echo isset($post_description[$language['language_id']]) ? $post_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
					</div>
				</div>
				<hr /> 
				<div class="row">
					<div class="col-md-2">
						<h5><?php echo $entry_meta_keyword; ?></h5>
						<span class="help"><i class="fa fa-info-circle"></i> Meta keywords.</span>
					</div>
					<div class="col-md-5">
						<textarea  class="form-control" name="post_description[<?php echo $language['language_id']; ?>][meta_keyword]" cols="40" rows="4"><?php echo isset($post_description[$language['language_id']]) ? $post_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<hr />
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2">
				<h5>Category</h5>
			</div>
			<div class="col-md-5">
				<select class="form-control" name="category_id">
					<option value="0">None</option>
					<?php foreach ($category_options as $category_option) { ?>
					<option value="<?php echo $category_option['iblog_category_id']; ?>" <?php if (!empty($category_id) && $category_id == $category_option['iblog_category_id']) { ?>selected<?php } ?>><?php echo $category_option['title']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-2">
				<h5><?php echo $entry_slug; ?></h5>
				<span class="help"><i class="fa fa-info-circle"></i> SEO Title (slug).</span>
			</div>
			<div class="col-md-5">
				<input type="text" class="form-control" name="slug" value="<?php echo $slug; ?>" size="100" />
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-2">
				<h5><?php echo $entry_image; ?></h5>
				<span class="help"><i class="fa fa-info-circle"></i> Blog image.</span>
			</div>
			<div class="col-md-5">
				<div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
					<input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
					<a onclick="post_image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a>
				</div>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-2">
				<h5><?php echo $entry_author; ?></h5>
				<span class="help"><i class="fa fa-info-circle"></i> Author of the blog post.</span>
			</div>
			<div class="col-md-5">
				<select class="form-control" name="author_id">
					<?php foreach ($authors as $author) { ?>
					<?php if ($author['author_id'] == $author_id) { ?>
					<option value="<?php echo $author['author_id']; ?>" selected="selected"><?php echo $author['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $author['author_id']; ?>"><?php echo $author['name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-2">
				<h5><?php echo $entry_date_published; ?></h5>
				<span class="help"><i class="fa fa-info-circle"></i> Date Published.</span>
			</div>
			<div class="col-md-5">
				<input type="text" name="date_published" value="<?php echo $date_published; ?>" size="12" class="datetime form-control" />
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-2">
				<h5><?php echo $entry_status; ?></h5>
				<span class="help"><i class="fa fa-info-circle"></i> The status can be 'Published' or 'Draft'.</span>
			</div>
			<div class="col-md-5">
				<select name="is_published" class="form-control">
					<?php if ($is_published) { ?>
					<option value="1" selected="selected"><?php echo $text_published; ?></option>
					<option value="0"><?php echo $text_draft; ?></option>
					<?php } else { ?>
					<option value="1"><?php echo $text_published; ?></option>
					<option value="0" selected="selected"><?php echo $text_draft; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-2">
				<h5><?php echo $entry_featured; ?></h5>
				<span class="help"><i class="fa fa-info-circle"></i> Mark this if you want the blog post to be featured.</span>
			</div>
			<div class="col-md-5">
				<input type="checkbox" name="featured" value="1" <?php echo !empty($featured) ? 'checked="checked" ' : ''; ?>/>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	<?php foreach ($languages as $language) { ?>
	CKEDITOR.replace('blog_post_body<?php echo $language['language_id']; ?>', {
		filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
		filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
	});
	<?php } ?>

	function post_image_upload(field, thumb) {
		$('#dialog').remove();

		$('#PostForm').append('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

		$('#dialog').dialog({
			title: '<?php echo $text_image_manager; ?>',
			close: function (event, ui) {
				if ($('#' + field).attr('value')) {
					$.ajax({
						url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
						dataType: 'text',
						success: function(text) {
							$('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
						}
					});
				}
			},	
			bgiframe: false,
			width: 800,
			height: 400,
			resizable: false,
			modal: false
		});
	};

	$(document).ready(function() {
		$('.date').datepicker({dateFormat: 'yy-mm-dd'});

		$('.datetime').datetimepicker({
			dateFormat: 'yy-mm-dd',
			timeFormat: 'h:m'
		});

		$('.time').timepicker({timeFormat: 'h:m'});

	$('#PostForm a[data-toggle="tab"]').first().tab('show'); // Select first tab
});
</script>