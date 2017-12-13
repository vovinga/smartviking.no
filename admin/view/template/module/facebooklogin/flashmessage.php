 <?php if ($error_warning) { ?>
  <div class="alert alert-error"><i class="icon-exclamation-sign"></i> <?php echo $error_warning; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div>
  <?php } ?>
  <?php if ($success_message) { ?>
  <div class="alert alert-success"><i class="icon-exclamation-sign"></i> <?php echo $success_message; ?> <button type="button" class="close" data-dismiss="alert">&times;</button></div>
  <?php } ?>