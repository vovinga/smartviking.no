<?php echo $header; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div itemscope itemprop="blogPost" itemType="http://schema.org/BlogPosting" id="content">
	<?php echo $content_top; ?>
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<div>
		<div class="iblog-post-title">
			<h1 itemprop="headline"><?php echo $heading_title; ?></h1>
		</div>
		<div class="iblog-post-info">
			<?php if ($thumb && !empty($data['MainImageEnabled']) && ($data['MainImageEnabled']=='yes')) { ?>
			<div class="iblog-post-image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img itemprop="image" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a></div>
			<?php } ?>
			<div>
				<div class="iblog-author-info">
					<?php if (!empty($data['AddThisEnabled']) && ($data['AddThisEnabled']=='yes')) {?>
					<div class="iblog-share-links">
						<a href="http://www.addthis.com/bookmark.php?v=250" class="addthis_button"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125"  height="16" border="0" alt="Share" /></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js"></script>
					</div>
					<?php } ?>
					<div class="iblog-author-data">
						<strong><?php echo $text_author; ?></strong><span itemprop="author"><span itemscope itemtype="http://schema.org/Person"><span itemprop="name"><?php echo $author; ?></span></span></span> | <strong><?php echo $text_date_created; ?></strong> <?php echo $date_created; ?> <meta itemprop="datePublished" content="<?php echo $date_created; ?>"/>
					</div>
				</div>
				<div class="iblog-post-description" itemprop="articleBody">
					<?php echo $body; ?>
				</div>
				<div class="iblog-post-keywords">
					<span class="iblog-keywords-string"><?php echo $iblog_keywords; ?></span> <span itemprop="keywords"><?php echo $keywords; ?></span>
				</div>
				<?php if (!empty($data['DisqusEnabled']) && ($data['DisqusEnabled']=='yes')) {?>
				<hr />
				<div class="iblog-post-comments">
					<script type="text/javascript">	
						var disqus_shortname = '<?php echo !empty($data['DisqusShortName']) ? $data['DisqusShortName'] : ''; ?>';
						
						(function() {
							var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        					dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
							(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
						})();
					</script>
					<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
					<div id="disqus_thread"></div>
				</div>
				<?php } ?>
			</div>
			<?php echo $content_bottom; ?> 
		</div>
	</div>
</div>
<script type="text/javascript"><!--
(function($) {
	$(document).ready(function($) {
		$('.colorbox').colorbox({
			overlayClose: true,
			opacity: 0.5,
			rel: "colorbox"
		});		
	});
})(jQuery);
//--></script> 
<?php if(!empty($data['CustomPostCSS'])): ?>
<style><?php echo htmlspecialchars_decode($data['CustomPostCSS']); ?></style>
<?php endif; ?>
<?php echo $footer; ?>