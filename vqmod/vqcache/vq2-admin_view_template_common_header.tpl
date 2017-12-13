<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />

			<!-- start - ipl extension - dbassa -->
			
			<link rel="stylesheet" type="text/css" href="view/stylesheet/dbassa_intelligent_product_labels.css" />
			<link rel="stylesheet" type="text/css" href="view/stylesheet/dbassa_intelligent_product_labels_preview.css" />
			<link rel="stylesheet" type="text/css" href="view/stylesheet/jquery.validity.css" />

			<!-- end - ipl extension - dbassa -->
			
<link rel="stylesheet" type="text/css" href="view/stylesheet/tableedit.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="view/javascript/tableedit.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script type="text/javascript" src="view/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="view/javascript/jquery/superfish/js/superfish.js"></script>
<script type="text/javascript" src="view/javascript/common.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<script type="text/javascript">
//-----------------------------------------
// Confirm Actions (delete, uninstall)
//-----------------------------------------
$(document).ready(function(){
    // Confirm Delete
    $('#form').submit(function(){
        if ($(this).attr('action').indexOf('delete',1) != -1) {
            if (!confirm('<?php echo $text_confirm; ?>')) {
                return false;
            }
        }
    });
    // Confirm Uninstall
    $('a').click(function(){

			// Confirm Remove
			if ($(this).attr('href') != null && $(this).attr('href').indexOf('remove', 1) != -1) {
				if (!confirm('<?php echo $text_confirm_remove; ?>')) {
					return false;
				}
			}
			
        if ($(this).attr('href') != null && $(this).attr('href').indexOf('uninstall', 1) != -1) {
            if (!confirm('<?php echo $text_confirm; ?>')) {
                return false;
            }
        }
    });
        });
    </script>

			<!-- start - ipl extension - dbassa -->
			
			<script type="text/javascript" src="view/javascript/jscolor/jscolor.js"></script>
			<script type="text/javascript" src="view/javascript/validity/jquery.validity.min.js"></script>

			<!-- end - ipl extension - dbassa -->
			
</head>
<body>
<div id="container">
    <div id="header">
  <div class="div1">
    <div class="div2"><img src="view/image/logo.png" title="<?php echo $heading_title; ?>" onclick="location = '<?php echo $home; ?>'" /></div>
    <?php if ($logged) { ?>
    <div class="div3"><img src="view/image/lock.png" alt="" style="position: relative; top: 3px;" />&nbsp;<?php echo $logged; ?></div>
    <?php } ?>
  </div>
  <?php if ($logged) { ?>
  <div id="menu">
    <ul class="left" style="display: none;">
      <li id="dashboard"><a href="<?php echo $home; ?>" class="top"><?php echo $text_dashboard; ?></a></li>
      <li id="catalog"><a class="top"><?php echo $text_catalog; ?></a>
        <ul>
          <li><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></li>
          <li><a href="<?php echo $product; ?>"><?php echo $text_product; ?></a></li>
<li><a class="parent">SEO</a>
			<ul>			
			<li><a href="<?php echo $seopack; ?>"><?php echo $text_seopack; ?></a></li>
			<li><a href="<?php echo $seoimages; ?>"><?php echo $text_seoimages; ?></a></li>
			<li><a href="<?php echo $clickfix; ?>"><?php echo $text_clickfix; ?></a></li>
			<li>
				<?php if (file_exists(DIR_APPLICATION.'controller/catalog/autolinks.php')) { ?>
				<a href="<?php echo $autolinks; ?>"><?php echo $text_autolinks; ?></a>
				<?php } else { ?>
				<a onclick="alert('Auto Internal Links is not installed!\nYou can purchase Auto Internal Links from\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=5650\nor you can purchase the whole Opencart SEO Pack PRO:\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6182');" class="button"><?php echo $text_autolinks; ?></a>
				<?php } ?>
			</li>
			<li>
				<?php if (file_exists(DIR_APPLICATION.'controller/catalog/canonicals.php')) { ?>
				<a href="<?php echo $canonicals; ?>"><?php echo $text_canonicals; ?></a>
				<?php } else { ?>
				<a onclick="alert('Canonical Links is not installed!\nYou can purchase Opencart SEO Pack PRO from:\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6182');" class="button"><?php echo $text_canonicals; ?></a>
				<?php } ?>
			</li>
			<li>
				<?php if (file_exists(DIR_APPLICATION.'controller/catalog/mlseo.php')) { ?>
				<a href="<?php echo $mlseo; ?>"><?php echo $text_mlseo; ?></a>
				<?php } else { ?>
				<a onclick="alert('Multi-Language SEO is not installed!\nYou can purchase Opencart SEO Pack PRO from:\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6182');" class="button"><?php echo $text_mlseo; ?></a>
				<?php } ?>
			</li>
			<li>
				<?php if (file_exists(DIR_APPLICATION.'controller/catalog/richsnippets.php')) { ?>
				<a href="<?php echo $richsnippets; ?>"><?php echo $text_richsnippets; ?></a>
				<?php } else { ?>
				<a onclick="alert('Rich Snippets is not installed!\nYou can purchase Opencart SEO Pack PRO from:\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6182');" class="button"><?php echo $text_richsnippets; ?></a>
				<?php } ?>
			</li>
			<li>
				<?php if (file_exists(DIR_APPLICATION.'controller/catalog/seopagination.php')) { ?>
				<a href="<?php echo $seopagination; ?>"><?php echo $text_seopagination; ?></a>
				<?php } else { ?>
				<a onclick="alert('SEO Pagination is not installed!\nYou can purchase Opencart SEO Pack PRO from:\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6182');" class="button"><?php echo $text_seopagination; ?></a>
				<?php } ?>
			</li>
			<li>
				<?php if (file_exists(DIR_APPLICATION.'controller/catalog/redirect.php')) { ?>
				<a href="<?php echo $redirect; ?>"><?php echo $text_redirect; ?></a>
				<?php } else { ?>
				<a onclick="alert('SEO Redirector is not installed!\nYou can purchase Opencart SEO Pack PRO from:\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6182');" class="button"><?php echo $text_redirect; ?></a>
				<?php } ?>
			</li>
			<li>
				<?php if (file_exists(DIR_APPLICATION.'controller/catalog/seoreplacer.php')) { ?>
				<a href="<?php echo $seoreplacer; ?>"><?php echo $text_seoreplacer; ?></a>
				<?php } else { ?>
				<a onclick="alert('Extended SEO is not installed!\nYou can purchase Opencart SEO Pack PRO from:\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6182');" class="button"><?php echo $text_seoreplacer; ?></a>
				<?php } ?>
			</li>
			<li>
				<?php if (file_exists(DIR_APPLICATION.'controller/catalog/extendedseo.php')) { ?>
				<a href="<?php echo $extendedseo; ?>"><?php echo $text_extendedseo; ?></a>
				<?php } else { ?>
				<a onclick="alert('Extended SEO is not installed!\nYou can purchase Opencart SEO Pack PRO from:\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6182');" class="button"><?php echo $text_extendedseo; ?></a>
				<?php } ?>
			</li>
			<li>
				<?php if (file_exists(DIR_APPLICATION.'controller/catalog/seoeditor.php')) { ?>
				<a href="<?php echo $seoeditor; ?>"><?php echo $text_seoeditor; ?></a>
				<?php } else { ?>
				<a onclick="alert('Advanced SEO Editor is not installed!\nYou can purchase Advanced SEO Editor from\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6183\nor you can purchase the whole Opencart SEO Pack PRO:\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6182');" class="button"><?php echo $text_seoeditor; ?></a>
				<?php } ?>
			</li>
<li><a class="parent">SEO Reports</a>
			<ul>
			<li>
				<?php if (file_exists(DIR_APPLICATION.'controller/catalog/bot_report.php')) { ?>
				<a href="<?php echo $bot_report; ?>"><?php echo $text_bot_report; ?></a>
				<?php } else { ?>
				<a onclick="alert('Bots Report is not installed!\nYou can purchase Opencart SEO Pack PRO from:\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6182');" class="button"><?php echo $text_bot_report; ?></a>
				<?php } ?>
			</li>
			<li>
				<?php if (file_exists(DIR_APPLICATION.'controller/catalog/not_found_report.php')) { ?>
				<a href="<?php echo $not_found_report; ?>"><?php echo $text_not_found_report; ?></a>
				<?php } else { ?>
				<a onclick="alert('404s Report is not installed!\nYou can purchase Opencart SEO Pack PRO from:\n http://www.opencart.com/index.php?route=extension/extension/info&extension_id=6182');" class="button"><?php echo $text_not_found_report; ?></a>
				<?php } ?>
			</li>
			<li><a href="<?php echo $seoreport; ?>"><?php echo $text_seoreport; ?></a></li>
			</ul>
			</li>
			<li><a href="<?php echo $about; ?>"><?php echo $text_about; ?></a></li>
			</ul>
			</li>
          <li><a href="<?php echo $filter; ?>"><?php echo $text_filter; ?></a></li>
          <li><a href="<?php echo $profile; ?>"><?php echo $text_profile; ?></a></li>
          <li><a class="parent"><?php echo $text_attribute; ?></a>
            <ul>
              <li><a href="<?php echo $attribute; ?>"><?php echo $text_attribute; ?></a></li>
              <li><a href="<?php echo $attribute_group; ?>"><?php echo $text_attribute_group; ?></a></li>
            </ul>
          </li>
          <li><a href="<?php echo $option; ?>"><?php echo $text_option; ?></a></li>
          <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
          <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
          <li><a href="<?php echo $review; ?>"><?php echo $text_review; ?></a></li>
          <li><a href="<?php echo $information; ?>"><?php echo $text_information; ?></a></li>

			<li><a href="<?php echo $modelcodegen; ?>"><?php echo $module_title; ?></a></li>
            
        </ul>
      </li>
      <li id="extension"><a class="top"><?php echo $text_extension; ?></a>
        <ul>
          <li><a href="<?php echo $module; ?>"><?php echo $text_module; ?></a></li>
          <li><a href="<?php echo $shipping; ?>"><?php echo $text_shipping; ?></a></li>
          <li><a href="<?php echo $payment; ?>"><?php echo $text_payment; ?></a></li>
          <li><a href="<?php echo $total; ?>"><?php echo $text_total; ?></a></li>
          <li><a href="<?php echo $feed; ?>"><?php echo $text_feed; ?></a></li>
          <li><a href="<?php echo $vqmod_manager; ?>"><?php echo $text_vqmod_manager; ?></a></li>
            <li><a class="parent"><?php echo $text_openbay_extension; ?></a>
                <ul>
                    <li><a href="<?php echo $openbay_link_extension; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
                    <li><a href="<?php echo $openbay_link_orders; ?>"><?php echo $text_openbay_orders; ?></a></li>
                    <li><a href="<?php echo $openbay_link_items; ?>"><?php echo $text_openbay_items; ?></a></li>

                    <?php if($openbay_markets['ebay'] == 1){ ?>
                    <li><a class="parent" href="<?php echo $openbay_link_ebay; ?>"><?php echo $text_openbay_ebay; ?></a>
                        <ul>
                            <li><a href="<?php echo $openbay_link_ebay_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
                            <li><a href="<?php echo $openbay_link_ebay_links; ?>"><?php echo $text_openbay_links; ?></a></li>
                            <li><a href="<?php echo $openbay_link_ebay_orderimport; ?>"><?php echo $text_openbay_order_import; ?></a></li>
                       </ul>
                    </li>
                    <?php } ?>

                    <?php if($openbay_markets['amazon'] == 1){ ?>
                    <li><a class="parent" href="<?php echo $openbay_link_amazon; ?>"><?php echo $text_openbay_amazon; ?></a>
                        <ul>
                            <li><a href="<?php echo $openbay_link_amazon_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
                            <li><a href="<?php echo $openbay_link_amazon_links; ?>"><?php echo $text_openbay_links; ?></a></li>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php if($openbay_markets['amazonus'] == 1){ ?>
                    <li><a class="parent" href="<?php echo $openbay_link_amazonus; ?>"><?php echo $text_openbay_amazonus; ?></a>
                        <ul>
                            <li><a href="<?php echo $openbay_link_amazonus_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
                            <li><a href="<?php echo $openbay_link_amazonus_links; ?>"><?php echo $text_openbay_links; ?></a></li>
                        </ul>
                    </li>
                    <?php } ?>

                    <?php if($openbay_markets['play'] == 1){ ?>
                    <li><a class="parent" href="<?php echo $openbay_link_play; ?>"><?php echo $text_openbay_play; ?></a>
                        <ul>
                            <li><a href="<?php echo $openbay_link_play_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
                            <li><a href="<?php echo $openbay_link_play_report_price; ?>"><?php echo $text_openbay_report_price; ?></a></li>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
      </li>
      <li id="sale"><a class="top"><?php echo $text_sale; ?></a>
        <ul>
          <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
          <li><a href="<?php echo $recurring_profile; ?>"><?php echo $text_recurring_profile; ?></a></li>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a class="parent"><?php echo $text_customer; ?></a>
            <ul>
              <li><a href="<?php echo $customer; ?>"><?php echo $text_customer; ?></a></li>
              <li><a href="<?php echo $customer_group; ?>"><?php echo $text_customer_group; ?></a></li>
              <li><a href="<?php echo $customer_ban_ip; ?>"><?php echo $text_customer_ban_ip; ?></a></li>
            </ul>
          </li>
          <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
          <li><a href="<?php echo $coupon; ?>"><?php echo $text_coupon; ?></a></li>
          <li><a class="parent"><?php echo $text_voucher; ?></a>
            <ul>
              <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
              <li><a href="<?php echo $voucher_theme; ?>"><?php echo $text_voucher_theme; ?></a></li>
            </ul>
          </li>
          <!-- PAYPAL MANAGE NAVIGATION LINK -->
          <?php if ($pp_express_status) { ?>
           <li><a class="parent" href="<?php echo $paypal_express; ?>"><?php echo $text_paypal_express; ?></a>
             <ul>
               <li><a href="<?php echo $paypal_express_search; ?>"><?php echo $text_paypal_express_search; ?></a></li>
             </ul>
           </li>
          <?php } ?>
          <!-- PAYPAL MANAGE NAVIGATION LINK END -->
          <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
        </ul>
      </li>
      <li id="system"><a class="top"><?php echo $text_system; ?></a>
        <ul>
          <li><a href="<?php echo $setting; ?>"><?php echo $text_setting; ?></a></li>
          <li><a class="parent"><?php echo $text_design; ?></a>
            <ul>
              <li><a href="<?php echo $layout; ?>"><?php echo $text_layout; ?></a></li>
              <li><a href="<?php echo $banner; ?>"><?php echo $text_banner; ?></a></li>
            </ul>
          </li>
          <li><a class="parent"><?php echo $text_users; ?></a>
            <ul>
              <li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
              <li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
            </ul>
          </li>
          <li><a class="parent"><?php echo $text_localisation; ?></a>
            <ul>
              <li><a href="<?php echo $language; ?>"><?php echo $text_language; ?></a></li>
              <li><a href="<?php echo $currency; ?>"><?php echo $text_currency; ?></a></li>
              <li><a href="<?php echo $stock_status; ?>"><?php echo $text_stock_status; ?></a></li>
              <li><a href="<?php echo $order_status; ?>"><?php echo $text_order_status; ?></a></li>
              <li><a class="parent"><?php echo $text_return; ?></a>
                <ul>
                  <li><a href="<?php echo $return_status; ?>"><?php echo $text_return_status; ?></a></li>
                  <li><a href="<?php echo $return_action; ?>"><?php echo $text_return_action; ?></a></li>
                  <li><a href="<?php echo $return_reason; ?>"><?php echo $text_return_reason; ?></a></li>
                </ul>
              </li>
              <li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li>
              <li><a href="<?php echo $zone; ?>"><?php echo $text_zone; ?></a></li>
              <li><a href="<?php echo $geo_zone; ?>"><?php echo $text_geo_zone; ?></a></li>
              <li><a class="parent"><?php echo $text_tax; ?></a>
                <ul>
                  <li><a href="<?php echo $tax_class; ?>"><?php echo $text_tax_class; ?></a></li>
                  <li><a href="<?php echo $tax_rate; ?>"><?php echo $text_tax_rate; ?></a></li>
                </ul>
              </li>
              <li><a href="<?php echo $length_class; ?>"><?php echo $text_length_class; ?></a></li>
              <li><a href="<?php echo $weight_class; ?>"><?php echo $text_weight_class; ?></a></li>
            </ul>
          </li>
          <li><a href="<?php echo $error_log; ?>"><?php echo $text_error_log; ?></a></li>
          <li><a href="<?php echo $backup; ?>"><?php echo $text_backup; ?></a></li>

<li><a href="<?php echo $excel_export; ?>"><?php echo $text_excel_export; ?></a></li> 
      
        </ul>
      </li>

                <?php if(isset($text_ne)) { ?>
                <li id="ne"><a class="top"><?php echo $text_ne; ?></a>
                    <ul>
                        <li><a href="<?php echo $ne_email; ?>"><?php echo $text_ne_email; ?></a></li>
                        <li><a href="<?php echo $ne_draft; ?>"><?php echo $text_ne_draft; ?></a></li>
                        <li><a href="<?php echo $ne_marketing; ?>"><?php echo $text_ne_marketing; ?></a></li>
                        <li><a href="<?php echo $ne_subscribers; ?>"><?php echo $text_ne_subscribers; ?></a></li>
                        <li><a href="<?php echo $ne_stats; ?>"><?php echo $text_ne_stats; ?></a></li>
                        <li><a href="<?php echo $ne_robot; ?>"><?php echo $text_ne_robot; ?></a></li>
                        <li><a href="<?php echo $ne_template; ?>"><?php echo $text_ne_template; ?></a></li>
                        <li><a href="<?php echo $ne_subscribe_box; ?>"><?php echo $text_ne_subscribe_box; ?></a></li>
                        <li><a href="<?php echo $ne_blacklist; ?>"><?php echo $text_ne_blacklist; ?></a></li>
                        <li style="width:97%;"><hr/></li>
                        <li><a class="parent"><?php echo $text_ne_support; ?></a>
                            <ul>
                                <li><a href="https://www.codersroom.com/support/register.php" target="_blank"><?php echo $text_ne_support_register; ?></a></li>
                                <li><a href="https://www.codersroom.com/support/clientarea.php" target="_blank"><?php echo $text_ne_support_login; ?></a></li>
                                <li><a href="https://www.codersroom.com/support/" target="_blank"><?php echo $text_ne_support_dashboard; ?></a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo $ne_update_check; ?>"><?php echo $text_ne_update_check; ?></a></li>
                    </ul>
                </li>
                <?php } ?>
                
      <li id="reports"><a class="top"><?php echo $text_reports; ?></a>
        <ul>
          <li><a class="parent"><?php echo $text_sale; ?></a>
            <ul>
              
<li><a href="<?php echo $report_adv_sale_profit; ?>"><?php echo $text_report_adv_sale_profit; ?></a></li>
            
              <li><a href="<?php echo $report_sale_tax; ?>"><?php echo $text_report_sale_tax; ?></a></li>
              <li><a href="<?php echo $report_sale_shipping; ?>"><?php echo $text_report_sale_shipping; ?></a></li>
              <li><a href="<?php echo $report_sale_return; ?>"><?php echo $text_report_sale_return; ?></a></li>
              <li><a href="<?php echo $report_sale_coupon; ?>"><?php echo $text_report_sale_coupon; ?></a></li>
            </ul>
          </li>
          <li><a class="parent"><?php echo $text_product; ?></a>
            <ul>

<li><a href="<?php echo $report_adv_products; ?>"><?php echo $text_report_adv_products; ?></a></li> 
            
              
<li style="border-top:1px dashed #888;"><a href="<?php echo $report_product_viewed; ?>"><?php echo $text_report_product_viewed; ?></a></li>
            
              
<li><a href="<?php echo $report_adv_product_profit; ?>"><?php echo $text_report_adv_product_profit; ?></a></li>
            
            </ul>
          </li>
          <li><a class="parent"><?php echo $text_customer; ?></a>
            <ul>
              <li><a href="<?php echo $report_customer_online; ?>"><?php echo $text_report_customer_online; ?></a></li>
              
<li><a href="<?php echo $report_adv_customer_profit; ?>"><?php echo $text_report_adv_customer_profit; ?></a></li>
            
              <li><a href="<?php echo $report_customer_reward; ?>"><?php echo $text_report_customer_reward; ?></a></li>
              <li><a href="<?php echo $report_customer_credit; ?>"><?php echo $text_report_customer_credit; ?></a></li>
            </ul>
          </li>
          <li><a class="parent"><?php echo $text_affiliate; ?></a>
            <ul>
              <li><a href="<?php echo $report_affiliate_commission; ?>"><?php echo $text_report_affiliate_commission; ?></a></li>
            </ul>
          </li>
        </ul>
      </li>

	<?php if ($this->user->hasPermission('access', 'tool/nitro')) { ?>
        <li id="nitro"><a class="top topnitro">Nitro</a>
          <ul>
            <li><a href="index.php?route=tool/nitro&token=<?php echo $_GET['token']; ?>">Settings</a></li>
            <li><a class="parent">Clear Cache</a>
		          <ul>
                <li style="border-bottom:1px dashed #888;"><a href="javascript:void(0)" onclick="document.location='index.php?route=tool/nitro/clearnitrocaches&token=<?php echo $_GET['token']; ?>'">Clear Nitro Cache</a></li>
                <li><a href="javascript:void(0)" onclick="document.location='index.php?route=tool/nitro/clearpagecache&token=<?php echo $_GET['token']; ?>'">Clear Page Cache</a></li>
                <li><a href="javascript:void(0)" onclick="document.location='index.php?route=tool/nitro/cleardbcache&token=<?php echo $_GET['token']; ?>'">Clear Database Cache</a></li>
                <li><a href="javascript:void(0)" onclick="document.location='index.php?route=tool/nitro/clearsystemcache&token=<?php echo $_GET['token']; ?>'">Clear System Cache</a></li>
                <li><a href="javascript:void(0)" onclick="document.location='index.php?route=tool/nitro/clearimagecache&token=<?php echo $_GET['token']; ?>'">Clear Image Cache</a></li>
                <li><a href="javascript:void(0)" onclick="document.location='index.php?route=tool/nitro/clearcsscache&token=<?php echo $_GET['token']; ?>'">Clear CSS Cache</a></li>
                <li><a href="javascript:void(0)" onclick="document.location='index.php?route=tool/nitro/clearjscache&token=<?php echo $_GET['token']; ?>'">Clear JavaScript Cache</a></li>
                <li><a href="javascript:void(0)" onclick="document.location='index.php?route=tool/nitro/clearvqmodcache&token=<?php echo $_GET['token']; ?>'">Clear vQmod Cache</a></li>
                <li style="border-top:1px dashed #888;"><a href="javascript:void(0)" onclick="document.location='index.php?route=tool/nitro/clearallcaches&token=<?php echo $_GET['token']; ?>'">Clear All Caches</a></li>
              </ul>
		        </li>
          </ul>
        </li>
	<?php } ?>
			

				<?php $this->load->model('module/iblog'); if ($this->model_module_iblog->is_installed()) { ?>
				<li><a class="top" href="<?php echo $this->url->link('module/iblog', 'token='.$this->request->get['token'], 'SSL'); ?>">iBlog</a></li>
				<?php } ?>
			
      <li id="help"><a class="top"><?php echo $text_help; ?></a>
        <ul>
          <li><a href="http://www.opencart.com" target="_blank"><?php echo $text_opencart; ?></a></li>
          <li><a href="http://www.opencart.com/index.php?route=documentation/introduction" target="_blank"><?php echo $text_documentation; ?></a></li>
          <li><a href="http://forum.opencart.com" target="_blank"><?php echo $text_support; ?></a></li>
        </ul>
      </li>
    </ul>
    <ul class="right" style="display: none;">
      <li id="store"><a href="<?php echo $store; ?>" target="_blank" class="top"><?php echo $text_front; ?></a>
        <ul>
          <?php foreach ($stores as $stores) { ?>
          <li><a href="<?php echo $stores['href']; ?>" target="_blank"><?php echo $stores['name']; ?></a></li>
          <?php } ?>
        </ul>
      </li>
      <li><a class="top" href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
    </ul>
  </div>
  <?php } ?>
</div>
