<a id="addNewPost" href="<?php echo $this->url->link('module/' . $moduleNameSmall . '/newBlogPost', 'token=' . $this->session->data['token'] . "&store_id=" . $this->request->get['store_id'], 'SSL'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add new blog post</a>
<a href="<?php echo $catalog_url; ?>index.php?route=feed/iblog" target="_blank" class="btn btn-default"><i class="fa fa-rss"></i>&nbsp;&nbsp;Posts RSS Feed</a>
<hr />
<div id="PostsWrapper<?php echo $store['store_id']; ?>"></div>
<script type="text/javascript">
	(function($) {
		$(document).ready(function($) {
			$("#PostsWrapper<?php echo $store['store_id']; ?>").addClass('loading');

			$.ajax({
				url: "index.php?route=module/<?php echo $moduleNameSmall; ?>/getPosts&token=<?php echo $this->session->data['token']; ?>&page=1&store_id=<?php echo $store['store_id']; ?>",
				type: 'get',
				dataType: 'html',
				success: function(data) {		
					$("#PostsWrapper<?php echo $store['store_id']; ?>").html(data);
					$("#PostsWrapper<?php echo $store['store_id']; ?>").removeClass('loading');
				}
			});

			$(document).on('submit', '#PostForm', function(event) {
				event.preventDefault();

				<?php foreach ($languages as $language) { ?>
				if (typeof CKEDITOR.instances.body<?php echo $language['language_id']; ?> !== "undefined") {
					CKEDITOR.instances.body<?php echo $language['language_id']; ?>.updateElement();
				}
				<?php } ?>

				$.ajax({
					url: 'index.php?route=module/<?php echo $moduleNameSmall; ?>/updatePost&token=<?php echo $this->session->data['token']; ?>',
					type: 'post',
					data: $('#PostForm').serialize(),
					success: function(response) {

						if ($("#post_id").length > 0) {
							alert('The blog post was updated successfully!');
						} else {
							alert('The blog post was added successfully!');
						}

						$('#addPostModal').modal('hide');

						location.reload();
					}
				});
			});
		});
	})(jQuery);
</script>