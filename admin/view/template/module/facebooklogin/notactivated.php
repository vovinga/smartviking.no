<?php $iModuleNotActivated = empty($data['FacebookLogin']['Activated']); ?>
<?php if ($iModuleNotActivated==true){ ?>
<style type="text/css"> .iModuleContent .box .content { display:none } </style>
<script type="text/javascript"> $('.submitButton').html('Activate'); </script>
<div class="notActivatedContent">
	<h1>Facebook Login is not activated.</h1>
	<a href="javascript:void(0)" onclick="$('#form').attr('action',$('#form').attr('action')+'&activate=true'); $('#form').submit();" class="iModuleActivateButton">Activate Facebook Login</a>
</div>
<?php } ?>