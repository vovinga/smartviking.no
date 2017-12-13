<?php echo $header;?>
<div id="content" class="iBlog">
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		<?php } ?>
	</ul>
	<?php echo (empty($moduleData['LicensedOn'])) ? base64_decode('ICAgIDxkaXYgY2xhc3M9ImFsZXJ0IGFsZXJ0LWRhbmdlciBmYWRlIGluIj4NCiAgICAgICAgPGJ1dHRvbiB0eXBlPSJidXR0b24iIGNsYXNzPSJjbG9zZSIgZGF0YS1kaXNtaXNzPSJhbGVydCIgYXJpYS1oaWRkZW49InRydWUiPsOXPC9idXR0b24+DQogICAgICAgIDxoND5XYXJuaW5nISBVbmxpY2Vuc2VkIHZlcnNpb24gb2YgdGhlIG1vZHVsZSE8L2g0Pg0KICAgICAgICA8cD5Zb3UgYXJlIHJ1bm5pbmcgYW4gdW5saWNlbnNlZCB2ZXJzaW9uIG9mIHRoaXMgbW9kdWxlISBZb3UgbmVlZCB0byBlbnRlciB5b3VyIGxpY2Vuc2UgY29kZSB0byBlbnN1cmUgcHJvcGVyIGZ1bmN0aW9uaW5nLCBhY2Nlc3MgdG8gc3VwcG9ydCBhbmQgdXBkYXRlcy48L3A+PGRpdiBzdHlsZT0iaGVpZ2h0OjVweDsiPjwvZGl2Pg0KICAgICAgICA8YSBjbGFzcz0iYnRuIGJ0bi1kYW5nZXIiIGhyZWY9ImphdmFzY3JpcHQ6dm9pZCgwKSIgb25jbGljaz0iJCgnYVtocmVmPSNzdXBwb3J0XScpLnRyaWdnZXIoJ2NsaWNrJykiPkVudGVyIHlvdXIgbGljZW5zZSBjb2RlPC9hPg0KICAgIDwvZGl2Pg==') : '' ?>
	<?php if ($error_warning) { ?><div class="alert alert-danger" > <i class="icon-exclamation-sign"></i>&nbsp;<?php echo $error_warning; ?></div><?php } ?>
	<?php if (!empty($this->session->data['success'])) { ?>
	<div class="alert alert-success autoSlideUp"> <i class="fa fa-info"></i>&nbsp;<?php echo $this->session->data['success']; ?> </div>
	<script type="text/javascript">(function($) { $('.autoSlideUp').delay(3000).fadeOut(600, function(){ $(this).show().css({'visibility':'hidden'}); }).slideUp(600); })(jQuery);</script>
	<?php $this->session->data['success'] = null; } ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-file-text-o"></i>&nbsp;<span style="vertical-align:middle;font-weight:bold;"><?php echo $heading_title; ?></span></h3>
			<div class="storeSwitcherWidget">
				<div class="form-group">
					<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-pushpin"></span>&nbsp;<?php echo $store['name']; if($store['store_id'] == 0) echo " <strong>(".$text_default.")</strong>"; ?>&nbsp;<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
					<ul class="dropdown-menu" role="menu">
						<?php foreach ($stores  as $st) { ?>
						<li><a href="index.php?route=module/<?php echo $moduleNameSmall;?>&store_id=<?php echo $st['store_id'];?>&token=<?php echo $this->session->data['token']; ?>"><?php echo $st['name']; ?></a></li>
						<?php } ?> 
					</ul>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form"> 
				<input type="hidden" name="store_id" value="<?php echo $store['store_id']; ?>" />
				<div class="tabbable">
					<div class="tab-navigation form-inline">
						<ul class="nav nav-tabs mainMenuTabs" id="mainTabs" role="tablist">
							<li><a href="#control_panel" role="tab" data-toggle="tab"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Control Panel</a></li>
							<li id="blogs_tab"><a href="#blogs" role="tab" data-toggle="tab"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Blog Posts</a></li>
							<li id="categories_tab"><a href="#categories" role="tab" data-toggle="tab"><i class="fa fa-folder-open-o"></i>&nbsp;&nbsp;Blog Categories</a></li>
							<li id="frontend-dropdown" class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-columns"></i>&nbsp;&nbsp;iBlog Settings<span class="caret"></span>
								</a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#widget" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;Blog Widget</a></li>
									<li><a href="#listing" role="tab" data-toggle="tab"><i class="fa fa-indent"></i>&nbsp;&nbsp;Blog Listing</a></li>
									<li><a href="#posts" role="tab" data-toggle="tab"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;Post View</a></li>
								</ul>
							</li>
							<li><a href="#support" role="tab" data-toggle="tab"><i class="fa fa-external-link"></i>&nbsp;&nbsp;Support</a></li>
						</ul>
						<div class="tab-buttons">
							<button type="submit" class="btn btn-success save-changes"><i class="fa fa-check"></i>&nbsp;<?php echo $save_changes?></button>
							<a onclick="location = '<?php echo $cancel; ?>'" class="btn btn-warning"><i class="fa fa-times"></i>&nbsp;<?php echo $button_cancel?></a>
						</div> 
					</div><!-- /.tab-navigation --> 
					<div class="tab-content">
						<div id="control_panel" class="tab-pane"><?php require_once(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_controlpanel.php'); ?></div>
						<div id="blogs" class="tab-pane"><?php require_once(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_blogs.php'); ?></div>
						<div id="categories" class="tab-pane"><?php require_once(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_categories.php'); ?></div>
						<div id="widget" class="tab-pane"><?php require_once(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_widget.php'); ?></div>
						<div id="listing" class="tab-pane"><?php require_once(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_listing.php'); ?></div>
						<div id="posts" class="tab-pane"><?php require_once(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_posts.php'); ?></div>
						<div id="support" class="tab-pane"><?php require_once(DIR_APPLICATION.'view/template/module/'.$moduleNameSmall.'/tab_support.php'); ?></div>
					</div> <!-- /.tab-content --> 
				</div><!-- /.tabbable -->
			</form>
		</div> 
	</div>
</div>
<div class="modal" id="addPostModal" tabindex="-3" role="dialog" aria-labelledby="addPostModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="addPostModalLabel">Blog Post Details</h4>
			</div>
			<div class="modal-body" id="addPostModalBody"></div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Close</button>
				<button class="btn btn-primary" id="submitPost" type="submit" form="PostForm"><i class="fa fa-file-text-o"></i>&nbsp;Submit!</button>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="addCategoryModal" tabindex="-3" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="addCategoryModalLabel">Blog Category Details</h4>
			</div>
			<div class="modal-body" id="addCategoryModalBody"></div>
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i> Close</button>
				<button class="btn btn-primary" id="submitCategory" type="submit" form="CategoryForm"><i class="fa fa-file-text-o"></i>&nbsp;Submit!</button>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>

<script>
$(document).on('click', '#blogs .pagination .links a', function(e){
    e.preventDefault(); 
    $.ajax({ 
        url: this.href,
        type:'post',
        dataType:'html',
        success: function(data) { 
          $('#blogs').html(data);
        } 
      });
}); 

$(document).on('click', '#categories .pagination .links a', function(e){
    e.preventDefault(); 
    $.ajax({ 
        url: this.href,
        type:'post',
        dataType:'html',
        success: function(data) { 
          $('#categories').html(data);
        } 
      });
}); 
</script>