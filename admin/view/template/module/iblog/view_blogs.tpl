<table class="table table-bordered table-hover">
	<thead>
		<tr class="table-header">
			<th class="left" width="1">ID</th>
			<th class="left">Title</th>
			<th class="left">Excerpt</th>
			<th class="left">Author</th>
			<th class="left">Status</th>
			<th class="left" width="200">Publish Date</th>
			<th class="left" width="200">Actions</th>
		</tr>
	</thead>
	<?php if (!empty($posts)) { ?>
		<tbody>
		<?php foreach ($posts as $post) { ?>
			<tr>
				<td class="left"><?php echo $post['iblog_post_id']; ?></td>
				<td class="left"><?php echo $post['title']; ?></td>
				<td class="left"><?php echo $post['excerpt']; ?></td>
				<td class="left"><?php echo $post['author']; ?></td>
				<td class="left"><?php echo ($post['is_published'] == 1) ? 'Published' : 'Draft'; ?></td>
				<td class="left"><?php echo $post['created']; ?></td>
				<td class="center">
					<a href="<?php echo $this->url->link('module/'.$moduleNameSmall.'/newBlogPost', 'token='.$this->session->data['token'].'&store_id='.$this->request->get['store_id'].'&post_id='.$post['iblog_post_id'], 'SSL'); ?>" class="btn btn-xs btn-primary editPost"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
					<a data-url="<?php echo $this->url->link('module/'.$moduleNameSmall.'/removePost', 'token='.$this->session->data['token']); ?>" data-item-id="<?php echo $post['iblog_post_id']; ?>" class="btn btn-xs btn-danger remove_item"><i class="fa fa-times"></i>&nbsp;&nbsp;Remove</a>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	<?php } else { ?>
		<tr><td class="center" colspan="7"><h4>There are no blog posts yet.</h4></td></tr>
	<?php } ?>
	<?php if (!empty($pagination)) { ?>
	<tfoot><tr><td colspan="10"><div class="pagination"><?php echo $pagination; ?></div></td></tr></tfoot>
	<?php } ?>
</table>