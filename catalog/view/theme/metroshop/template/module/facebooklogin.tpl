<!-- START FacebookLogin -->
<style type="text/css">
	<?php echo htmlspecialchars_decode($data['FacebookLogin']['CustomCSS']); ?>
</style>
<div class="box" id="facebookLoginBox"></div>
<script type="text/html" class="facebookLoginHTML">
	<?php if ($data['FacebookLogin']['WrapIntoWidget'] == 'Yes') { ?>
		<div class="box box-fblogin">
		  <div class="box-heading"><?php echo $data['FacebookLogin']['WrapperTitle']; ?></div>
		  <div class="box-content">
			<div class="facebookButton"><a href="javascript:void(0)" class="facebookLoginAnchor <?php echo $data['FacebookLogin']['ButtonDesign']; ?>"><span></span><?php echo $data['FacebookLogin']['ButtonLabel']; ?></a></div>
		  </div>
		</div>
	<?php } else { ?>
		<div class="facebookButton"><a href="javascript:void(0)" class="facebookLoginAnchor <?php echo $data['FacebookLogin']['ButtonDesign']; ?>"><span></span><?php echo $data['FacebookLogin']['ButtonLabel']; ?></a></div>
	<?php } ?>
</script>
<script language="javascript" type="text/javascript"> <!-- 
<?php if (!empty($data['FacebookLoginConfig']['position_use_selector'])) { ?>
    var posSelector = '<?php echo $data['FacebookLoginConfig']['position_selector']; ?>';
    var positionFBButton = function() {
		<?php if ($data['FacebookLogin']['WrapIntoWidget'] == 'Yes') { ?>
			var sourceSelector = '.facebookLoginHTML:first';
		<?php } else { ?>
			var sourceSelector = '.facebookLoginHTML:first .box-content';
		<?php } ?>
		
        if (posSelector) {
            $(posSelector).prepend($('.facebookLoginHTML:first').html());	
        } else {
            $('#content').prepend($('.facebookLoginHTML:first').html());	
        }	
    }
    
    $(document).ready(function() {
        if ($(posSelector).find('.facebookLoginAnchor').length == 0) {
            positionFBButton();
        }
    });
    $(document).ajaxComplete(function() {
        var tries = 0;
        var tryAppendButton = setInterval(function() {
            tries++;
            if ($(posSelector).find('.facebookLoginAnchor').length == 0) {
                positionFBButton();
            }
            if (tries > 20 || $(posSelector).find('.facebookLoginAnchor').length > 0) {
                clearInterval(tryAppendButton);	
            }
        },300);
    });
<?php } else { ?>
	$('#facebookLoginBox').after($('.facebookLoginHTML:first').html());
<?php } ?>

$('#facebookLoginBox').remove();

$.ajax({
	url: '<?php echo $url_login; ?>',
	success: function(data) {
		$('.facebookLoginAnchor').live('click', function() {
			newwindow = window.open(data, 'name', 'height=320,width=550,scrollbars=yes');
			if (window.focus) newwindow.focus();
			return false;
		});
	}
});

 --> 
</script>
<!-- END FacebookLogin -->