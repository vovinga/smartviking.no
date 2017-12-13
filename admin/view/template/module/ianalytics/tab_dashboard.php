<?php 
$searchvar = 'search';
if (defined('VERSION') && (VERSION == '1.5.4' || VERSION == '1.5.4.1' || VERSION == '1.5.3' || VERSION == '1.5.3.1' || VERSION == '1.5.2' || VERSION == '1.5.2.1' || VERSION == '1.5.1' || VERSION == '1.5.1.3' || VERSION == '1.5.0')) {
	$searchvar = 'filter_name';
}
?>
<table class="form" style="width:100%;">
  <tr>
  	<td><h3>Dashboard</h3></td>
    <td><?php require('element_filter.php'); ?></td>
  </tr>
  <tr>
    <td colspan="2">Most Opened Products</td>
  </tr>
  <tr>
    <td valign="top" style="width:25%;border-bottom:none;">
    	<div class="openRateChart pieable" data-num="<?php echo $iAnalyticsMostOpenedProductsPie?>" style="position: relative; "></div>
	</td>
  	<td valign="top" style="width:75%;border-bottom:none;">
    	<table class="iSimpleTable" style="width:30%; display:table; float:left; margin-right: 10px;">
            <?php $k = (isset($iAnalyticsMostOpenedProducts[0])) ? $iAnalyticsMostOpenedProducts[0] : ''; ?>
            <tr><td style="width:80%"><?php echo $k[0]?></td><td style="width:20%"><?php echo $k[1]?></td></tr>
			<?php for ($inc = 2; $inc <= 21; $inc++) : ?>
            	<?php $k = (isset($iAnalyticsMostOpenedProducts[$inc - 1])) ? $iAnalyticsMostOpenedProducts[$inc - 1] : ''; ?>
                <tr><td style="width:80%"><?php echo (isset($k[0])) ? $k[0] : ''; ?></td><td style="width:20%"><?php echo (isset($k[1])) ? $k[1] : ''; ?></td></tr>
            <?php endfor; ?>
        </table>
        <table class="iSimpleTable" style="width:30%; display:table; float:left; margin-right: 10px;">
            <?php $k = $iAnalyticsMostOpenedProducts[0]; ?>
            <tr><td style="width:80%"><?php echo $k[0]?></td><td style="width:20%"><?php echo $k[1]?></td></tr>
			<?php for ($inc = 22; $inc <= 41; $inc++) : ?>
            	<?php $k = (isset($iAnalyticsMostOpenedProducts[$inc - 1])) ? $iAnalyticsMostOpenedProducts[$inc - 1] : ''; ?>
                <tr><td style="width:80%"><?php echo (isset($k[0])) ? $k[0] : ''; ?></td><td style="width:20%"><?php echo (isset($k[1])) ? $k[1] : ''; ?></td></tr>
            <?php endfor; ?>
        </table>
        <table class="iSimpleTable" style="width:30%; display:table; float: left; margin-right: 10px;">
            <?php $k = $iAnalyticsMostOpenedProducts[0]; ?>
            <tr><td style="width:80%"><?php echo $k[0]?></td><td style="width:20%"><?php echo $k[1]?></td></tr>
			<?php for ($inc = 42; $inc <= 61; $inc++) : ?>
            	<?php $k = (isset($iAnalyticsMostOpenedProducts[$inc - 1])) ? $iAnalyticsMostOpenedProducts[$inc - 1] : ''; ?>
                <tr><td style="width:80%"><?php echo (isset($k[0])) ? $k[0] : ''; ?></td><td style="width:20%"><?php echo (isset($k[1])) ? $k[1] : ''; ?></td></tr>
            <?php endfor; ?>
        </table> 
    </td>
  </tr>
</table>