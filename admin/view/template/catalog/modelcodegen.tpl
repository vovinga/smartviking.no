<?php
// ------------------------------------------------------
// Product Model Code Generator for Opencart
// By P.K Solutions
// sales@p-k-solutions.co.uk
// ------------------------------------------------------
?>

<?php echo $header; ?>

<style>
table.form > tbody > tr > td:first-child {
	width: 1000px;
} 
</style>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<?php if ($error_warning) { ?>
		<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
<div class="box">
	<div class="heading">
		<h1><img src="view/image/module.png" alt="" /> <?php echo $module_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
	</div>
  <div class="content">      
      <form action="" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
      <thead>
      <tr bgcolor="#EBEBEB" bordercolor="#D1D1D1" height="30px" class="required" align="center">
      <td><?php echo $conditions; ?></td>
      </tr>
      </thead>
      <tbody>
      <tr>
      <td>
      <?php
      if ($condition1value == '1') {$selected11 = 'selected';} else {$selected11 = '';} 
      if ($condition1value == '2') {$selected12 = 'selected';} else {$selected12 = '';}              
      ?>     
            <label for="condition1"><?php echo $condition1; ?></label>
            <select name="condition1">
            <Option <?php echo $selected11; ?> value="1"><?php echo $conditionOption1; ?></Option>
            <Option <?php echo $selected12; ?> value="2"><?php echo $conditionOption2; ?></Option>       
            </select>
            <?php echo $condition1Text; ?>             
</td>
            </tr>          
            <tr>
            <td>
      <?php
      if ($condition2value == '1') {$selected21 = 'selected';} else {$selected21 = '';} 
      if ($condition2value == '2') {$selected22 = 'selected';} else {$selected22 = '';}             
      ?>                       
            <label for="condition2"><?php echo $condition2; ?></label>            
            <select name="condition2">
            <Option <?php echo $selected21; ?> value="1"><?php echo $conditionOption1; ?></Option>
            <Option <?php echo $selected22; ?> value="2"><?php echo $conditionOption2; ?></Option>
            </select>
            <?php echo $condition2Text; ?>         
            </td>
            </tr>       
             </tbody>           
            </table>
            <table class="form">
             <thead>
     		 <tr bgcolor="#EBEBEB" bordercolor="#D1D1D1" height="30px" class="required" align="center">
             <td><?php echo $userConditions; ?></td>
             </tr>
             </thead>
             <tbody>
             <tr>
             <td>
            <label for="conditionUser"><?php echo $conditionUser; ?></label>              
             <input name="conditionUser" type="text" maxlength="7" size="7" value="<?php echo $conditionUserValue; ?>"/>
            <?php echo $conditionUserText; ?>
             </td>
             </tr>
             </tbody>
             </table>
             <table class="form">
             <thead>
      		<tr bgcolor="#EBEBEB" bordercolor="#D1D1D1" height="30px" class="required" align="center">
             <td><?php echo $defaults; ?></td>
             </tr>
             </thead>
             <tbody>
             <tr>
             <td>
            <label for="sequential"><?php echo $sequential; ?></label>              
             <input name="sequential" type="text" maxlength="4" size="4" value="<?php echo $sequentialValue; ?>"/> 
            <?php echo $sequentialText; ?> 
             </td>          
             </tr>    
             <tr>
             <td>
     		 <?php
     		 if ($useHyphensValue == '0') {$selected0 = 'selected';} else {$selected0 = '';} 
      		 if ($useHyphensValue == '1') {$selected1 = 'selected';} else {$selected1 = '';}           
      		?>                 
            <label for="useHyphens"><?php echo $useHyphens; ?></label>            
            <select name="useHyphens">
            <Option <?php echo $selected1; ?> value="1"><?php echo $useHyphensYes; ?></Option>
            <Option <?php echo $selected0; ?> value="0"><?php echo $useHyphensNo; ?></Option>
            </select> 
            <?php echo $useHyphensText; ?>             
             </td>          
             </tr>  
             </tbody>     
             <thead>
      		<tr bgcolor="#EBEBEB" bordercolor="#D1D1D1" height="30px" class="required" align="center">
             <td><?php echo $setup; ?></td>
             </tr>
             </thead>
             <tbody>
             <tr>
             <td>
            <label for="updateAll"><?php echo $updateAll; ?></label> 
			<button type="button" onclick="updateAll(); return false;"><?php echo $updatebtn; ?></button>
            <span class="required"><?php echo $updateAllText; ?></span>
             </td>          
             </tr>     
             </tbody>                                   
		</table>    
    </form>     
	</div>    
		<br>
		<div style="text-align:center; color:#222222;">Product Model Code Generator v<?php echo $modelcodegen_version; ?> by <a target="_blank" href="http://www.p-k-solutions.co.uk">P.K Solutions</a></div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">
	function updateAll() {
		document.body.style.cursor = 'wait';
		var token="<?php echo $_SESSION['token'];?>";	
		var datastring = '&token=' + token;		
		$.ajax({		   
		type: 'get',
		url: 'index.php?route=catalog/modelcodegen/updateAll',
		dataType: 'json',	
        data: datastring,		
		success: function () {
		alert('<?php echo $updateSuccess; ?>');
		document.body.style.cursor = 'pointer';		
		}});		
	}
</script>
