<?php echo $header; ?>
<div id="content">
  <!-- START BREADCRUMB -->
  <?php require_once(DIR_APPLICATION.'view/template/module/facebooklogin/breadcrumb.php'); ?>
  <!-- END BREADCRUMB -->
  <!-- START FLASHMESSAGE -->
  <?php require_once(DIR_APPLICATION.'view/template/module/facebooklogin/flashmessage.php'); ?>
  <!-- END FLASHMESSAGE -->
  <div class="box">
  	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
    <div class="navbar">
      <div class="navbar-inner"><a class="brand"><i class="icon-pencil"></i><?php echo $heading_title; ?></a> 
      
      <ul class="nav nav-tabs">
			<?php foreach($tabs as $index => $tab): ?>
            <li<?php echo $index == 0 ? ' class="active"' : ''; ?>><a href="#tab_<?php echo $index; ?>" data-tofbke="tab"><?php echo $tab['name']; ?></a></li>
            <?php endforeach; ?>
        </ul>
      
      <div class="buttons"><button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> <?php echo $button_save; ?></button> <a href="<?php echo $cancel; ?>" class="btn btn-danger"><i class="icon-remove icon-white"></i> <?php echo $button_cancel; ?></a></div></div>
    </div>
    <div class="box-content">
        <div class="tab-content">
        	<?php foreach($tabs as $index => $tab): ?>
            <div class="row-fluid tab-pane <?php echo $index == 0 ? 'active' : ''; ?>" id="tab_<?php echo $index; ?>">
                <?php require_once($tab['file']); ?>
            </div>
			<?php endforeach; ?>
        </div>
    </div>
    <input type="hidden" name="FacebookLogin[Activated]" value="Yes" />
    <input type="hidden" class="selectedTab" name="selectedTab" value="<?php echo (empty($this->request->get['tab'])) ? 0 : $this->request->get['tab'] ?>" />
    <input type="hidden" class="selectedStore" name="selectedStore" value="<?php echo (empty($this->request->get['store'])) ? 0 : $this->request->get['store'] ?>" />
    </form>
  </div>
</div>
<script type="text/javascript">
var selectedTab = $('.selectedTab').val();
$('.navbar .nav-tabs li').eq(selectedTab).children('a').tab('show');
$('.htabs a').eq(selectedTab).trigger('click');

$('#tabs a').click(function() {
	$('.selectedStore').val($(this).index());
});

$('.navbar .nav-tabs li').click(function() {
	$('.selectedTab').val($(this).index());
});
</script>
<?php echo $footer; ?>