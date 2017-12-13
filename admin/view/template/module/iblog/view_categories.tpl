<table class="table table-bordered table-hover">
	<thead>
		<tr class="table-header">
			<th class="left" width="1">ID</th>
			<th class="left">Title</th>
			<th class="left" width="200">Publish Date</th>
			<th class="left" width="200">Actions</th>
		</tr>
	</thead>
	<?php if (!empty($categories)) { ?>
		<tbody>
		<?php foreach ($categories as $category) { ?>
			<tr>
				<td class="left"><?php echo $category['iblog_category_id']; ?></td>
				<td class="left"><?php echo $category['title']; ?></td>
				<td class="left"><?php echo $category['created']; ?></td>
				<td class="center">
					<a href="<?php echo $this->url->link('module/' . $moduleNameSmall.'/newBlogCategory', 'token=' . $this->session->data['token'].'&store_id=' . $this->request->get['store_id'].'&category_id=' . $category['iblog_category_id'], 'SSL'); ?>" class="btn btn-xs btn-primary editCategory"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
					<a data-url="<?php echo $this->url->link('module/' . $moduleNameSmall.'/removeCategory', 'token=' . $this->session->data['token']); ?>" data-item-id="<?php echo $category['iblog_category_id']; ?>" class="btn btn-xs btn-danger remove_item"><i class="fa fa-times"></i>&nbsp;&nbsp;Remove</a>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	<?php } else { ?>
		<tr><td class="center" colspan="7"><h4>There are no blog categories yet.</h4></td></tr>
	<?php } ?>
	<?php if (!empty($pagination)) { ?>
	<tfoot><tr><td colspan="5"><div class="pagination"><?php echo $pagination; ?></div></td></tr></tfoot>
	<?php } ?>
</table>