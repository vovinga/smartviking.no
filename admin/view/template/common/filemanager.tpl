<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="en">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/ui/themes/base/jquery.ui.all.css" />
<script type="text/javascript" src="view/javascript/jquery/ui/external/jquery.bgiframe-2.1.2.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jstree/jquery.tree.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ajaxupload.js"></script>
<script type="text/javascript" src="view/javascript/fileuploader_v4.js"></script>

<!-- Language settings: Checkout your admin/view/javascript/i18n/ folder for your languagte  -->
<!-- <script type="text/javascript" src="view/javascript/i18n/bg.js"></script> -->

<link rel="stylesheet" type="text/css" media="screen" href="view/stylesheet/fileuploader_v4.css">
<link rel="stylesheet" type="text/css" media="screen" href="view/stylesheet/fileuploader_v4_theme.css">

</head>
<body>
<div id="container">

</div>
<script type="text/javascript" charset="utf-8">
	$().ready(function() {
		var elf = $('#container').elfinder({
			url : 'index.php?route=common/filemanager/connector&token=<?php echo $token; ?>',  // connector URL (REQUIRED)
			lang : 'en', /* Setup your language here! */
			container: '<?php echo $field;?>',
			dirimage: '<?php echo HTTP_CATALOG."image/";?>', 
			getFileCallback: function (a) {
        b = a.replace('<?php echo HTTP_CATALOG."image/";?>','');		
        <?php if (HTTP_CATALOG."image/"<>'') {?>
        b = b.replace('<?php echo HTTP_CATALOG."image/";?>','');	   
        <?php } ?>
                b = replaceAll(b, '%20', ' ');
        		<?php if ($fckeditor) { ?>
        		window.opener.CKEDITOR.tools.callFunction(<?php echo $fckeditor; ?>, a);        		
        		self.close();	
        		<?php } else { ?>
        		
        		parent.$('#<?php echo $field; ?>').attr('value', b);
        		parent.$('#dialog').dialog('close');
        		
        		parent.$('#dialog').remove();	
        		<?php } ?>			   
			}
		}).elfinder('instance');
	});
	
function replaceAll(txt, replace, with_this) {
  return txt.replace(new RegExp(replace, 'g'),with_this);
}		
</script>
</body>
</html>