<a id="addNewCategory" href="<?php echo $this->url->link('module/' . $moduleNameSmall . '/newBlogCategory', 'token=' . $this->session->data['token'] . "&store_id=" . $this->request->get['store_id'], 'SSL'); ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add new blog category</a>
<hr />
<div id="CategoriesWrapper<?php echo $store['store_id']; ?>"></div>
<script type="text/javascript">
	(function($) {
		$(document).ready(function($) {
			$("#CategoriesWrapper<?php echo $store['store_id']; ?>").addClass('loading');
			
			$.ajax({
				url: "index.php?route=module/<?php echo $moduleNameSmall; ?>/getCategories&token=<?php echo $this->session->data['token']; ?>&page=1&store_id=<?php echo $store['store_id']; ?>",
				type: 'get',
				dataType: 'html',
				success: function(data) {		
					$("#CategoriesWrapper<?php echo $store['store_id']; ?>").html(data);
					$("#CategoriesWrapper<?php echo $store['store_id']; ?>").removeClass('loading');
				}
			});

			$(document).on('submit', '#CategoryForm', function(event) {
				event.preventDefault();

				<?php foreach ($languages as $language) { ?>
				if (typeof CKEDITOR.instances.body<?php echo $language['language_id']; ?> !== "undefined") {
					CKEDITOR.instances.body<?php echo $language['language_id']; ?>.updateElement();
				}
				<?php } ?>

				$.ajax({
					url: 'index.php?route=module/<?php echo $moduleNameSmall; ?>/updateCategory&token=<?php echo $this->session->data['token']; ?>',
					type: 'post',
					data: $('#CategoryForm').serialize(),
					success: function(response) {

						if ($("#category_id").length > 0) {
							alert('The blog category was updated successfully!');
						} else {
							alert('The blog category was added successfully!');
						}

						$('#addCategoryModal').modal('hide');

						location.reload();
					}
				});
			});
		});
	
	})(jQuery);
</script>