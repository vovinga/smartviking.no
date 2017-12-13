<?php

define('TA_LOCAL', 100);
define('TA_PREFETCH', 1000);

class ControllerCatalogProductExt extends Controller {
    protected $error = array();
    protected $alert = array(
        'error'     => array(),
        'warning'   => array(),
        'success'   => array(),
        'info'      => array()
    );

    public function __construct($registry) {
        parent::__construct($registry);
        $this->load->helper('aqe');

        if (!$this->config->get('aqe_installed') || !$this->config->get('aqe_status')) {
            $url = $this->urlParams();
            $this->redirect($this->url->link('catalog/product', $url, 'SSL'));
        }
    }

    public function index() {
        $this->getBase();
    }

    public function delete() {
        $this->action('delete');
    }

    public function copy() {
        $this->action('copy');
    }

    private function action($action) {
        $ajax_request = isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($ajax_request) {
            $this->language->load('catalog/product_ext');

            $this->load->model('catalog/product');

            if (isset($this->request->post['selected']) && $this->validateAction($action)) {
                foreach ((array)$this->request->post['selected'] as $product_id) {
                    switch ($action) {
                        case 'copy':
                            $this->model_catalog_product->copyProduct($product_id);
                            break;
                        case 'delete':
                            $this->model_catalog_product->deleteProduct($product_id);

                            if (defined('VERSION') && version_compare(VERSION, '1.5.6', '>=')) {
                                $this->openbay->deleteProduct($product_id);
                            }
                            break;
                    }
                }

                $response['success'] = true;
                $response['msg'] = sprintf($this->language->get('text_success_' . $action), count((array)$this->request->post['selected']));
            } else {
                $response = array_merge(array('error' => true), array('errors' => $this->error), array('alerts' => $this->alert));
            }

            $this->response->setOutput(json_enc($response, JSON_UNESCAPED_SLASHES));
            return;
        } else {
            $url = $this->urlParams();
            $this->redirect($this->url->link('catalog/product_ext', $url, 'SSL'));
        }
    }

    protected function getBase() {
        $this->language->load('catalog/product_ext');

        $this->load->model('catalog/product');
        $this->load->model('catalog/product_ext');

        $this->document->addStyle('view/stylesheet/aqe/css/custom.min.css');

        $this->document->addScript('view/javascript/aqe/custom.min.js');
        $this->document->addScript('view/javascript/jquery/superfish/js/superfish.js');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['code'] = $this->language->get('code');
        $this->data['text_settings'] = $this->language->get('text_settings');
        $this->data['text_search'] = $this->language->get('text_search');
        $this->data['text_items_per_page'] = $this->language->get('text_items_per_page');
        $this->data['text_choose_columns'] = $this->language->get('text_choose_columns');
        $this->data['text_other_settings'] = $this->language->get('text_other_settings');
        $this->data['text_all'] = $this->language->get('text_all');
        $this->data['text_custom'] = $this->language->get('text_custom');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_single_click'] = $this->language->get('text_single_click');
        $this->data['text_double_click'] = $this->language->get('text_double_click');
        $this->data['text_toggle_navigation'] = $this->language->get('text_toggle_navigation');
        $this->data['text_toggle_dropdown'] = $this->language->get('text_toggle_dropdown');
        $this->data['text_action'] = $this->language->get('text_action');
        $this->data['text_column'] = $this->language->get('text_column');
        $this->data['text_display'] = $this->language->get('text_display');
        $this->data['text_editable'] = $this->language->get('text_editable');
        $this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');
        $this->data['text_are_you_sure'] = $this->language->get('text_are_you_sure');
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_filter'] = $this->language->get('text_filter');
        $this->data['text_clear_filter'] = $this->language->get('text_clear_filter');
        $this->data['text_none'] = $this->language->get('text_none');
        $this->data['text_special_off'] = $this->language->get('text_special_off');
        $this->data['text_special_active'] = $this->language->get('text_special_active');
        $this->data['text_special_expired'] = $this->language->get('text_special_expired');
        $this->data['text_special_future'] = $this->language->get('text_special_future');
        $this->data['text_sort_ascending'] = $this->language->get('text_sort_ascending');
        $this->data['text_sort_descending'] = $this->language->get('text_sort_descending');
        $this->data['text_first_page'] = $this->language->get('text_first_page');
        $this->data['text_previous_page'] = $this->language->get('text_previous_page');
        $this->data['text_next_page'] = $this->language->get('text_next_page');
        $this->data['text_last_page'] = $this->language->get('text_last_page');
        $this->data['text_empty_table'] = $this->language->get('text_empty_table');
        $this->data['text_showing_info'] = $this->language->get('text_showing_info');
        $this->data['text_showing_info_empty'] = $this->language->get('text_showing_info_empty');
        $this->data['text_showing_info_filtered'] = $this->language->get('text_showing_info_filtered');
        $this->data['text_loading_records'] = $this->language->get('text_loading_records');
        $this->data['text_no_matching_records'] = $this->language->get('text_no_matching_records');
        $this->data['text_autocomplete'] = $this->language->get('text_autocomplete');
        $this->data['text_select'] = $this->language->get('text_select');
        $this->data['text_searching'] = $this->language->get('text_searching');
        $this->data['text_loading_more_results'] = $this->language->get('text_loading_more_results');
        $this->data['text_no_matches_found'] = $this->language->get('text_no_matches_found');
        $this->data['text_input_too_short'] = $this->language->get('text_input_too_short');
        $this->data['text_input_too_long'] = $this->language->get('text_input_too_long');
        $this->data['text_selection_too_big'] = $this->language->get('text_selection_too_big');
        $this->data['text_image_manager'] = $this->language->get('text_image_manager');
        $this->data['text_browse'] = $this->language->get('text_browse');
        $this->data['text_clear'] = $this->language->get('text_clear');
        $this->data['text_batch_edit'] = $this->language->get('text_batch_edit');
        $this->data['error_ajax_request'] = $this->language->get('error_ajax_request');

        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['button_copy'] = $this->language->get('button_copy');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_delete'] = $this->language->get('button_delete');
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_close'] = $this->language->get('button_close');

        $this->data['entry_products_per_page'] = $this->language->get('entry_products_per_page');
        $this->data['entry_alternate_row_colour'] = $this->language->get('entry_alternate_row_colour');
        $this->data['entry_row_hover_highlighting'] = $this->language->get('entry_row_hover_highlighting');
        $this->data['entry_highlight_status'] = $this->language->get('entry_highlight_status');
        $this->data['entry_quick_edit_on'] = $this->language->get('entry_quick_edit_on');
        $this->data['entry_list_view_image_size'] = $this->language->get('entry_list_view_image_size');
        $this->data['entry_filter_sub_category'] = $this->language->get('entry_filter_sub_category');
        $this->data['entry_columns'] = $this->language->get('entry_columns');
        $this->data['entry_actions'] = $this->language->get('entry_actions');

        $this->data['help_items_per_page'] = $this->language->get('help_items_per_page');
        $this->data['help_row_hover_highlighting'] = $this->language->get('help_row_hover_highlighting');
        $this->data['help_highlight_status'] = $this->language->get('help_highlight_status');
        $this->data['help_filter_sub_category'] = $this->language->get('help_filter_sub_category');

        $items_per_page = $this->config->get('aqe_items_per_page');
        $this->data['items_per_page'] = ($items_per_page) ? $items_per_page : $this->config->get('config_admin_limit');

        $this->data['aqe_alternate_row_colour'] = $this->config->get('aqe_alternate_row_colour');
        $this->data['aqe_row_hover_highlighting'] = $this->config->get('aqe_row_hover_highlighting');
        $this->data['aqe_highlight_status'] = $this->config->get('aqe_highlight_status');
        $this->data['aqe_quick_edit_on'] = $this->config->get('aqe_quick_edit_on');
        $this->data['aqe_list_view_image_width'] = $this->config->get('aqe_list_view_image_width');
        $this->data['aqe_list_view_image_height'] = $this->config->get('aqe_list_view_image_height');
        $this->data['aqe_filter_sub_category'] = $this->config->get('aqe_filter_sub_category');

        $url = $this->urlParams();

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'active'    => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('catalog/product_ext', 'token=' . $this->session->data['token'], 'SSL'),
            'active'    => true
        );

        $this->data['insert'] = $this->url->link('catalog/product/insert', $url, 'SSL');
        $this->data['copy'] = $this->url->link('catalog/product_ext/copy', $url, 'SSL');
        $this->data['delete'] = $this->url->link('catalog/product_ext/delete', $url, 'SSL');
        $this->data['source'] = html_entity_decode($this->url->link('catalog/product_ext/data', '', 'SSL'));
        $this->data['load'] = html_entity_decode($this->url->link('catalog/product_ext/load', 'token=' . $this->session->data['token'], 'SSL'));
        $this->data['settings'] = $this->url->link('catalog/product_ext/settings', $url, 'SSL');
        $this->data['update'] = html_entity_decode($this->url->link('catalog/product_ext/update', 'token=' . $this->session->data['token'], 'SSL'));
        $this->data['reload'] = html_entity_decode($this->url->link('catalog/product_ext/reload', 'token=' . $this->session->data['token'], 'SSL'));
        $this->data['filter'] = html_entity_decode($this->url->link('catalog/product_ext/filter', '', 'SSL'));

        $this->load->model('setting/store');

        $multistore = $this->model_setting_store->getTotalStores();

        $actions = $this->config->get('aqe_catalog_products_actions');

        if (defined('VERSION') && version_compare(VERSION, '1.5.6', '<')) {
            unset($actions['profiles']);
        }

        if (defined('VERSION') && version_compare(VERSION, '1.5.5', '<')) {
            unset($actions['filters']);
        }

        foreach ($actions as $action => $attr) {
            $actions[$action]['name'] = $this->language->get('action_' . $action);
        }
        uasort($actions, 'column_sort');
        $this->data['product_actions'] = $actions;

        $columns = $this->config->get('aqe_catalog_products');

        if (defined('VERSION') && version_compare(VERSION, '1.5.5', '<')) {
            unset($columns['filter']);
        }

        if (defined('VERSION') && version_compare(VERSION, '1.5.4', '<')) {
            unset($columns['ean']);
            unset($columns['jan']);
            unset($columns['isbn']);
            unset($columns['mpn']);
        }

        foreach ($columns as $column => $attr) {
            $columns[$column]['name'] = $this->language->get('column_' . $column);

            if ($column == 'view_in_store' && !$multistore) {
                unset($columns[$column]);
            }
        }

        uasort($columns, 'column_sort');
        $this->data['product_columns'] = $columns;

        $columns = array_filter($columns, 'column_display');
        $displayed_actions = array_keys(array_filter($actions, 'column_display'));

        if (in_array("descriptions", $displayed_actions)) {
            $this->document->addScript('view/javascript/ckeditor/ckeditor.js');
        }

        $displayed_columns = array_keys($columns);
        $related_columns = array_merge(array_map(function($v) { return $v['rel']; }, $columns), array_map(function($v) { return $v['rel']; }, $actions));
        $column_classes = array();
        $type_classes = array();

        $non_sortable = array();

        if (!is_array($columns)) {
            $displayed_columns = array('selector', 'image', 'name', 'model', 'price', 'quantity', 'status', 'action');
            $columns = array();
        } else {
            foreach($columns as $column => $attr) {
                if (empty($attr['sort'])) {
                    $non_sortable[] = 'col_' . $column;
                }

                if (!empty($attr['type']) && !in_array($attr['type'], $type_classes)) {
                    $type_classes[] = $attr['type'];
                }

                if (!empty($attr['align'])) {
                    if (!empty($attr['type']) && $attr['editable']) {
                        $column_classes[] = $attr['align'] . ' ' . $attr['type'];
                    } else {
                        $column_classes[] = $attr['align'];
                    }
                } else {
                    if (!empty($attr['type'])) {
                        $column_classes[] = $attr['type'];
                    } else {
                        $column_classes[] = null;
                    }
                }
            }
        }

        foreach($columns as $column => $attr) {
            $columns[$column]['name'] = $this->language->get('column_' . $column);
        }

        $this->data['multilingual_seo'] = $this->config->get('aqe_multilingual_seo');
        $this->data['columns'] = $displayed_columns;
        $this->data['actions'] = $displayed_actions;
        $this->data['related'] = $related_columns;
        $this->data['column_info'] = $columns;
        $this->data['non_sortable_columns'] = json_enc($non_sortable);
        $this->data['column_classes'] = $column_classes;
        $this->data['types'] = $type_classes;
        $this->data['typeahead'] = array();

        if (!$displayed_columns) {
            $this->alert['info']['select_columns'] = $this->language->get('text_select_columns');
        }

        foreach (array('name', 'model', 'sku', 'upc', 'ean', 'jan', 'isbn', 'mpn', 'location', 'seo') as $column) {
            if (in_array($column, $displayed_columns)) {
                $url = $this->urlParams();
                $this->data['typeahead'][$column] = array(
                    'remote' => html_entity_decode($this->url->link('catalog/product_ext/filter', 'type=' . $column . '&query=%QUERY' . $url, 'SSL'))
                );
            }
        }

        if (in_array('category', $displayed_columns)) {
            $this->data['categories'] = false;
            $total_categories = $this->cache->get('category.total');

            if (is_null($total_categories)) {
                $this->load->model('catalog/category');
                $total_categories = (int)$this->model_catalog_category->getTotalCategories();
                $this->cache->set('category.total', $total_categories);
            }

            if ($total_categories < TA_LOCAL) {
                $categories = $this->cache->get('category.all');

                if (is_null($categories)) {
                    $this->load->model('catalog/category');
                    $categories = $this->model_catalog_category->getCategories(array());
                    $this->cache->set('category.all', $categories);
                }

                $this->data['categories'] = $categories;
            } else if ($total_categories < TA_PREFETCH) {
                $url = $this->urlParams();
                $this->data['typeahead']['category'] = array(
                    'prefetch' => html_entity_decode($this->url->link('catalog/product_ext/filter', 'type=category' . $url, 'SSL'))
                );
            } else {
                $url = $this->urlParams();
                $this->data['typeahead']['category'] = array(
                    'remote' => html_entity_decode($this->url->link('catalog/product_ext/filter', 'type=category&query=%QUERY' . $url, 'SSL'))
                );
            }

            if ($total_categories < TA_LOCAL) {
                $cat_select = array();
                foreach ($this->data['categories'] as $cat) {
                    $cat_select[] = array('id' => (int)$cat['category_id'], 'text' => html_entity_decode($cat['name']));
                }
                $this->data['category_select'] = json_enc($cat_select);
            } else {
                $this->data['category_select'] = false;
            }
        }

        if (in_array('store', $displayed_columns)) {
            $stores = $this->cache->get('store.all');

            if (is_null($stores)) {
                $_stores = $this->model_setting_store->getStores(array());

                $stores = array(
                    '0' => array(
                        'store_id'  => 0,
                        'name'      => $this->config->get('config_name'),
                        'url'       => HTTP_CATALOG
                    )
                );

                foreach ($_stores as $store) {
                    $stores[$store['store_id']] = array(
                        'store_id'  => $store['store_id'],
                        'name'      => $store['name'],
                        'url'       => $store['url']
                    );
                }

                $this->cache->set('store.all', $stores);
            }

            $this->data['stores'] = $stores;

            $st_select = array();
            foreach ($stores as $st) {
                $st_select[] = array('id' => (int)$st['store_id'], 'text' => html_entity_decode($st['name']));
            }
            $this->data['store_select'] = json_enc($st_select);
        }

        if (in_array('manufacturer', $displayed_columns)) {
            $this->data['manufacturers'] = false;
            $total_manufacturers = $this->cache->get('manufacturer.total');

            if (is_null($total_manufacturers)) {
                $this->load->model('catalog/manufacturer');
                $total_manufacturers = (int)$this->model_catalog_manufacturer->getTotalManufacturers();
                $this->cache->set('manufacturer.total', $total_manufacturers);
            }

            if ($total_manufacturers < TA_LOCAL) {
                $manufacturers = $this->cache->get('manufacturer.all');

                if (is_null($manufacturers)) {
                    $this->load->model('catalog/manufacturer');
                    $manufacturers = $this->model_catalog_manufacturer->getManufacturers(array());
                    $this->cache->set('manufacturer.all', $manufacturers);
                }

                $this->data['manufacturers'] = $manufacturers;
            } else if ($total_manufacturers < TA_PREFETCH) {
                $url = $this->urlParams();
                $this->data['typeahead']['manufacturer'] = array(
                    'prefetch' => html_entity_decode($this->url->link('catalog/product_ext/filter', 'type=manufacturer' . $url, 'SSL'))
                );
            } else {
                $url = $this->urlParams();
                $this->data['typeahead']['manufacturer'] = array(
                    'remote' => html_entity_decode($this->url->link('catalog/product_ext/filter', 'type=manufacturer&query=%QUERY' . $url, 'SSL'))
                );
            }

            if ($total_manufacturers < TA_LOCAL) {
                $m_select = array();
                foreach ($this->data['manufacturers'] as $m) {
                    $m_select[] = array('value' => (int)$m['manufacturer_id'], 'text' => $m['name']);
                }
                $this->data['manufacturer_select'] = json_enc($m_select);
            } else {
                $this->data['manufacturer_select'] = false;
            }
        }

        if (in_array('download', $displayed_columns)) {
            $this->data['downloads'] = false;
            $total_downloads = $this->cache->get('downloads.total');

            if (is_null($total_downloads)) {
                $this->load->model('catalog/download');
                $total_downloads = (int)$this->model_catalog_download->getTotalDownloads();
                $this->cache->set('downloads.total', $total_downloads);
            }

            if ($total_downloads < TA_LOCAL) {
                $downloads = $this->cache->get('downloads.all');

                if (is_null($downloads)) {
                    $this->load->model('catalog/download');
                    $downloads = $this->model_catalog_download->getDownloads(array());
                    $this->cache->set('downloads.all', $downloads);
                }

                $this->data['downloads'] = $downloads;
            } else if ($total_downloads < TA_PREFETCH) {
                $url = $this->urlParams();
                $this->data['typeahead']['download'] = array(
                    'prefetch' => html_entity_decode($this->url->link('catalog/product_ext/filter', 'type=download' . $url, 'SSL'))
                );
            } else {
                $url = $this->urlParams();
                $this->data['typeahead']['download'] = array(
                    'remote' => html_entity_decode($this->url->link('catalog/product_ext/filter', 'type=download&query=%QUERY' . $url, 'SSL'))
                );
            }

            if ($total_downloads < TA_LOCAL) {
                $dl_select = array();
                foreach ($this->data['downloads'] as $dl) {
                    $dl_select[] = array('id' => (int)$dl['download_id'], 'text' => $dl['name']);
                }
                $this->data['download_select'] = json_enc($dl_select);
            } else {
                $this->data['download_select'] = false;
            }
        }

        if (in_array('filter', $displayed_columns)) {
            $this->data['filters'] = false;
            $total_filters = $this->cache->get('filters.total');

            if (is_null($total_filters)) {
                $this->load->model('catalog/filter');
                $total_filters = (int)$this->model_catalog_filter->getTotalFilters();
                $this->cache->set('filters.total', $total_filters);
            }

            if ($total_filters < TA_LOCAL) {
                $filters = $this->cache->get('filters.all');

                if (is_null($filters)) {
                    $this->load->model('catalog/filter');
                    $filters = $this->model_catalog_filter->getFiltersByGroup();
                    $this->cache->set('filters.all', $filters);
                }

                $this->data['filters'] = $filters;
            } else if ($total_filters < TA_PREFETCH) {
                $url = $this->urlParams();
                $this->data['typeahead']['filter'] = array(
                    'prefetch' => html_entity_decode($this->url->link('catalog/product_ext/filter', 'type=filter' . $url, 'SSL'))
                );
            } else {
                $url = $this->urlParams();
                $this->data['typeahead']['filter'] = array(
                    'remote' => html_entity_decode($this->url->link('catalog/product_ext/filter', 'type=filter&query=%QUERY' . $url, 'SSL'))
                );
            }

            if ($total_filters < TA_LOCAL) {
                $f_select = array();
                foreach ($this->data['filters'] as $fg) {
                    $group = array('text' => $fg['name'], 'children' => array());
                    foreach ($fg['filters'] as $f) {
                        $group['children'][] = array(
                            'id'    => (int)$f['filter_id'],
                            'text'  => strip_tags(html_entity_decode($fg['name'] . ' &gt; ' .$f['name']))
                        );
                    }
                    $f_select[] = $group;
                }
                $this->data['filter_select'] = json_enc($f_select);
            } else {
                $this->data['filter_select'] = false;
            }
        }

        if (in_array('tax_class', $displayed_columns)) {
            $tax_classes = $this->cache->get('tax_class.all');

            if (is_null($tax_classes)) {
                $this->load->model('localisation/tax_class');
                $tax_classes = $this->model_localisation_tax_class->getTaxClasses(array());
                $this->cache->set('tax_class.all', $tax_classes);
            }

            $this->data['tax_classes'] = $tax_classes;

            $tc_select = array();
            $tc_select[] = array('value' => 0, 'text' => $this->language->get('text_none'));
            foreach ($tax_classes as $tc) {
                $tc_select[] = array('value' => (int)$tc['tax_class_id'], 'text' => $tc['title']);
            }
            $this->data['tax_class_select'] = json_enc($tc_select);
        }

        if (in_array('stock_status', $displayed_columns)) {
            $stock_statuses = $this->cache->get('stock_status.all');

            if (is_null($stock_statuses)) {
                $this->load->model('localisation/stock_status');
                $stock_statuses = $this->model_localisation_stock_status->getStockStatuses(array());
                $this->cache->set('stock_status.all', $stock_statuses);
            }

            $this->data['stock_statuses'] = $stock_statuses;

            $ss_select = array();
            foreach ($stock_statuses as $ss) {
                $ss_select[] = array('value' => (int)$ss['stock_status_id'], 'text' => $ss['name']);
            }
            $this->data['stock_status_select'] = json_enc($ss_select);
        }

        if (in_array('length_class', $displayed_columns)) {
            $length_classes = $this->cache->get('length_class.all');

            if (is_null($length_classes)) {
                $this->load->model('localisation/length_class');
                $length_classes = $this->model_localisation_length_class->getLengthClasses(array());
                $this->cache->set('length_class.all', $length_classes);
            }

            $this->data['length_classes'] = $length_classes;

            $lc_select = array();
            foreach ($length_classes as $lc) {
                $lc_select[] = array('value' => (int)$lc['length_class_id'], 'text' => $lc['title']);
            }
            $this->data['length_class_select'] = json_enc($lc_select);
        }

        if (in_array('weight_class', $displayed_columns)) {
            $weight_classes = $this->cache->get('weight_class.all');

            if (is_null($weight_classes)) {
                $this->load->model('localisation/weight_class');
                $weight_classes = $this->model_localisation_weight_class->getWeightClasses(array());
                $this->cache->set('weight_class.all', $weight_classes);
            }

            $this->data['weight_classes'] = $weight_classes;

            $wc_select = array();
            foreach ($weight_classes as $wc) {
                $wc_select[] = array('value' => (int)$wc['weight_class_id'], 'text' => $wc['title']);
            }
            $this->data['weight_class_select'] = json_enc($wc_select);
        }

        if (in_array('image', $displayed_columns)) {
            $this->load->model('tool/image');

            $w = (int)$this->config->get('aqe_list_view_image_width');
            $h = (int)$this->config->get('aqe_list_view_image_height');

            $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', $w, $h);
            $this->data['list_view_image_width'] = $w;
            $this->data['list_view_image_height'] = $h;
        }

        if (isset($this->session->data['error'])) {
            $this->error = $this->session->data['error'];

            unset($this->session->data['error']);
        }

        if (isset($this->error['warning'])) {
            $this->alert['warning']['warning'] = $this->error['warning'];
        }

        if (isset($this->error['error'])) {
            $this->alert['error']['error'] = $this->error['error'];
        }

        if (isset($this->session->data['success'])) {
            $this->alert['success']['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        }

        $this->data['token'] = $this->session->data['token'];

        $this->data['alerts'] = $this->alert;

        $this->template = 'catalog/product_ext_list.tpl';

        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function settings() {
        $this->language->load('catalog/product_ext');

        $ajax_request = isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($ajax_request && $this->request->server['REQUEST_METHOD'] == 'POST') {
            $response = array();

            if ($this->validateSettings($this->request->post)) {
                $this->load->model('setting/setting');
                $response['values'] = array();

                $settings = $this->model_setting_setting->getSetting('admin_quick_edit');

                if (isset($this->request->post['aqe_items_per_page'])) {
                    $settings['aqe_items_per_page'] = $this->request->post['aqe_items_per_page'];
                    $response['values']['aqe_items_per_page'] = $this->request->post['aqe_items_per_page'];
                }

                if (isset($this->request->post['aqe_alternate_row_colour'])) {
                    if ($settings['aqe_alternate_row_colour'] !=  $this->request->post['aqe_alternate_row_colour']) {
                        $response['reload'] = true;
                    }
                    $settings['aqe_alternate_row_colour'] = $this->request->post['aqe_alternate_row_colour'];
                }

                if (isset($this->request->post['aqe_row_hover_highlighting'])) {
                    if ($settings['aqe_row_hover_highlighting'] !=  $this->request->post['aqe_row_hover_highlighting']) {
                        $response['reload'] = true;
                    }
                    $settings['aqe_row_hover_highlighting'] = $this->request->post['aqe_row_hover_highlighting'];
                }

                if (isset($this->request->post['aqe_highlight_status'])) {
                    if ($settings['aqe_highlight_status'] !=  $this->request->post['aqe_highlight_status']) {
                        $response['reload'] = true;
                    }
                    $settings['aqe_highlight_status'] = $this->request->post['aqe_highlight_status'];
                }

                if (isset($this->request->post['aqe_quick_edit_on'])) {
                    if ($settings['aqe_quick_edit_on'] !=  $this->request->post['aqe_quick_edit_on']) {
                        $response['reload'] = true;
                    }
                    $settings['aqe_quick_edit_on'] = $this->request->post['aqe_quick_edit_on'];
                }

                if (isset($this->request->post['aqe_list_view_image_width'])) {
                    if ($settings['aqe_list_view_image_width'] !=  $this->request->post['aqe_list_view_image_width']) {
                        $response['reload'] = true;
                    }
                    $settings['aqe_list_view_image_width'] = $this->request->post['aqe_list_view_image_width'];
                }

                if (isset($this->request->post['aqe_list_view_image_height'])) {
                    if ($settings['aqe_list_view_image_height'] !=  $this->request->post['aqe_list_view_image_height']) {
                        $response['reload'] = true;
                    }
                    $settings['aqe_list_view_image_height'] = $this->request->post['aqe_list_view_image_height'];
                }

                if (isset($this->request->post['aqe_filter_sub_category'])) {
                    if ($settings['aqe_filter_sub_category'] !=  $this->request->post['aqe_filter_sub_category']) {
                        $response['reload'] = true;
                    }
                    $settings['aqe_filter_sub_category'] = $this->request->post['aqe_filter_sub_category'];
                }

                // Loop through columns
                if (isset($this->request->post['index']['columns'])) {
                    foreach ($settings['aqe_catalog_products'] as $column => $attr) {
                        $display = (isset($this->request->post['display']['columns'][$column])) ? true : false;
                        if ($settings['aqe_catalog_products'][$column]['display'] != $display) {
                            $response['reload'] = true;
                        }
                        $settings['aqe_catalog_products'][$column]['display'] = $display;


                        if (isset($this->request->post['index']['columns'][$column])) {
                            if ($settings['aqe_catalog_products'][$column]['index'] != $this->request->post['index']['columns'][$column]) {
                                $response['reload'] = true;
                            }
                            $settings['aqe_catalog_products'][$column]['index'] = $this->request->post['index']['columns'][$column];
                        }
                    }
                }

                // Loop through actions
                if (isset($this->request->post['index']['actions'])) {
                    foreach ($settings['aqe_catalog_products_actions'] as $action => $attr) {
                        $display = (isset($this->request->post['display']['actions'][$action])) ? true : false;
                        if ($settings['aqe_catalog_products_actions'][$action]['display'] != $display) {
                            $response['reload'] = true;
                        }
                        $settings['aqe_catalog_products_actions'][$action]['display'] = $display;

                        if (isset($this->request->post['index']['actions'][$action])) {
                            if ($settings['aqe_catalog_products_actions'][$action]['index'] != $this->request->post['index']['actions'][$action]) {
                                $response['reload'] = true;
                            }
                            $settings['aqe_catalog_products_actions'][$action]['index'] = $this->request->post['index']['actions'][$action];
                        }
                    }
                }

                $this->model_setting_setting->editSetting('admin_quick_edit', $settings);

                $response['success'] = true;
                $response['msg'] = $this->language->get('text_setting_updated');

                if (!empty($response['reload'])) {
                    $this->session->data['success'] = $this->language->get('text_setting_updated');
                }
            } else {
                $response = array_merge(array('error' => true), array('errors' => $this->error), array('alerts' => $this->alert));
            }

            $this->response->setOutput(json_enc($response, JSON_UNESCAPED_SLASHES));
            return;
        }

        $this->redirect($this->url->link('catalog/product_ext', $this->urlParams(), 'SSL'));
    }

    public function data() {
        $ajax_request = isset($this->request->server['HTTP_X_REQUESTED_WITH']) && !empty($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($ajax_request) {
            $this->language->load('catalog/product_ext');
            $this->load->model('catalog/product_ext');

            $all_columns = $this->config->get('aqe_catalog_products');
            if (defined('VERSION') && version_compare(VERSION, '1.5.5', '<')) {
                unset($all_columns['filter']);
            }
            if (defined('VERSION') && version_compare(VERSION, '1.5.4', '<')) {
                unset($all_columns['ean']);
                unset($all_columns['jan']);
                unset($all_columns['isbn']);
                unset($all_columns['mpn']);
            }
            uasort($all_columns, 'column_sort');
            $columns = array_filter($all_columns, 'column_display');

            $actions = $this->config->get('aqe_catalog_products_actions');
            if (defined('VERSION') && version_compare(VERSION, '1.5.6', '<')) {
                unset($actions['profiles']);
            }
            if (defined('VERSION') && version_compare(VERSION, '1.5.5', '<')) {
                unset($actions['filters']);
            }
            uasort($actions, 'column_sort');
            $actions = array_filter($actions, 'column_display');

            $displayed_columns = array_keys($columns);

            $data = array(
                'search'    => '',
                'filter'    => array(),
                'sort'      => array(),
                'start'     => '',
                'limit'     => '',
                'columns'   => $displayed_columns
            );

            /*
             * Paging
             */
            if (isset($this->request->get['iDisplayStart'] ) && $this->request->get['iDisplayLength'] != '-1') {
                $data['start'] = (int)$this->request->get['iDisplayStart'];
                $data['limit'] = (int)$this->request->get['iDisplayLength'];
            }

            /*
             * Ordering
             */
            if (isset($this->request->get['iSortCol_0'])) {
                for ($i = 0; $i < (int)$this->request->get['iSortingCols']; $i++) {
                    if ($this->request->get['bSortable_' . (int)$this->request->get['iSortCol_' . $i]] == 'true' && $columns[$displayed_columns[(int)$this->request->get['iSortCol_' . $i]]]['sort']) {
                        $data['sort'][] = array('column' => $columns[$displayed_columns[(int)$this->request->get['iSortCol_' . $i]]]['sort'], 'order' => ($this->request->get['sSortDir_' . $i] === 'asc' ? 'ASC' : 'DESC'));
                    }
                }
            }

            /*
             * Filtering
             * NOTE this does not match the built-in DataTables filtering which does it
             * word by word on any field. It's possible to do here, but concerned about efficiency
             * on very large tables, and MySQL's regex functionality is very limited
             */
            if (isset($this->request->get['sSearch']) && $this->request->get['sSearch'] != '') {
                $data['search'] = $this->request->get['sSearch'];
            }

            /* Individual column filtering */
            for ($i = 0; $i < count($displayed_columns); $i++) {
                if (isset($this->request->get['bSearchable_' . $i]) && $this->request->get['bSearchable_' . $i] == 'true' && $this->request->get['sSearch_' . $i] != '') {
                    $data['filter'][$displayed_columns[$i]] = $this->request->get['sSearch_' . $i];
                }
            }

            if (isset($this->request->get['filter_special_price'])) {
                $data['filter']['special_price'] = $this->request->get['filter_special_price'];
            }

            if (in_array('image', $displayed_columns)) {
                $this->load->model('tool/image');
            }

            $results = $this->model_catalog_product_ext->getProducts($data);

            $iFilteredTotal = $this->model_catalog_product_ext->getFilteredTotalProducts();
            $iTotal = $this->model_catalog_product_ext->getTotalProducts();

            /*
             * Output
             */
            $output = array(
                'sEcho' => (int)$this->request->get['sEcho'],
                'iTotalRecords' => $iTotal,
                'iTotalDisplayRecords' => $iFilteredTotal,
                'aaData' => array()
            );

            if (in_array('view_in_store', $displayed_columns)) {
                $stores = $this->cache->get('store.all');

                if (is_null($stores)) {
                    $this->load->model('setting/store');
                    $_stores = $this->model_setting_store->getStores(array());

                    $stores = array(
                        '0' => array(
                            'store_id'  => 0,
                            'name'      => $this->config->get('config_name'),
                            'url'       => HTTP_CATALOG
                        )
                    );

                    foreach ($_stores as $store) {
                        $stores[$store['store_id']] = array(
                            'store_id'  => $store['store_id'],
                            'name'      => $store['name'],
                            'url'       => $store['url']
                        );
                    }

                    $this->cache->set('store.all', $stores);
                }
            } else {
                $stores = array();
            }

            foreach ($results as $result) {
                $product = array();

                for ($i = 0; $i < count($displayed_columns); $i++) {
                    switch ($displayed_columns[$i]) {
                        case 'selector':
                            $value = '';
                            break;
                        case 'download':
                        case 'filter':
                        case 'store':
                        case 'category':
                            $_ids = explode('_', $result[$displayed_columns[$i]]);
                            $_texts = explode('<br/>', $result[$displayed_columns[$i] . '_text']);
                            $data = array();
                            foreach ($_ids as $idx => $value) {
                                $data[] = array('id' => $value, 'text' => $_texts[$idx]);
                            }
                            $product[$displayed_columns[$i] . '_data'] = $data;
                            $value = $_ids;
                            break;
                        case 'image':
                            $w = (int)$this->config->get('aqe_list_view_image_width');
                            $h = (int)$this->config->get('aqe_list_view_image_height');

                            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                                $image = $this->model_tool_image->resize($result['image'], $w, $h);
                            } else {
                                $image = $this->model_tool_image->resize('no_image.jpg', $w, $h);
                            }

                            $value = $result['image'];
                            $product['image_thumb'] = $image;
                            $product['image_alt'] = html_entity_decode(isset($result['image_alt']) ? $result['image_alt'] : $result['name']);
                            $product['image_title'] = html_entity_decode(isset($result['image_title']) ? $result['image_title'] : $result['name']);
                            break;
                        case 'id':
                            $value = $result['product_id'];
                            break;
                        case 'subtract':
                        case 'shipping':
                            $value = (int)$result[$displayed_columns[$i]];
                            $product[$displayed_columns[$i] . '_text'] = $result[$displayed_columns[$i] . '_text'];
                            break;
                        case 'date_available':
                            $date = new DateTime($result[$displayed_columns[$i]]);
                            $value = $date->format('Y-m-d');
                            // $product['date_available_text'] = $date->format($this->language->get('date_format_short'));
                            $product['date_available_text'] = $date->format('Y-m-d');
                            break;
                        case 'date_added':
                        case 'date_modified':
                            $date = new DateTime($result[$displayed_columns[$i]]);
                            $value = $date->format('Y-m-d H:i:s');
                            // $product[$displayed_columns[$i] . '_text'] = $date->format($this->language->get('date_format_short') . ' ' . $this->language->get('time_format'));
                            $product[$displayed_columns[$i] . '_text'] = $date->format('Y-m-d H:i:s');
                            break;
                        case 'stock_status':
                        case 'tax_class':
                        case 'length_class':
                        case 'weight_class':
                        case 'manufacturer':
                            $value = (int)$result[$displayed_columns[$i] . '_id'];
                            $product[$displayed_columns[$i] . '_text'] = (is_null($result[$displayed_columns[$i] . '_text'])) ? '' : $result[$displayed_columns[$i] . '_text'];
                            break;
                        case 'quantity':
                            $value = (int)$result['quantity'];
                            break;
                        case 'status':
                            $value = (int)$result['status'];
                            $product['status_text'] = $result['status_text'];

                            if ($this->config->get('aqe_highlight_status')) {
                                $product['status_class'] = (int)$result['status'] ? 'success' : 'danger';
                            }
                            break;
                        case 'price':
                            $product['special'] = $result['special_price'];
                            $value = $result['price'];
                            break;
                        case 'view_in_store':
                            $product_stores = explode('_', $result['store_ids']);
                            $_stores = array();

                            foreach ($product_stores as $store) {
                                if (!in_array($store, array_keys($stores)))
                                    continue;

                                $_stores[] = array(
                                    'url' => $stores[$store]['url'] . 'index.php?route=product/product&product_id=' . $result['product_id'],
                                    'name' => $stores[$store]['name'],
                                );
                            }

                            $value = $_stores;
                            break;
                        case 'action':

                            $_buttons = array();

                            foreach ($actions as $action => $attr) {
                                switch ($action) {
                                    case 'edit':
                                        $_buttons[] = array(
                                            'type'  => $attr['type'],
                                            'action'=> $action,
                                            'title' => $this->language->get('action_' . $action),
                                            'url'   => html_entity_decode($this->url->link('catalog/product/update', '&product_id=' . $result['product_id'] . '&token=' . $this->session->data['token'], 'SSL')),
                                            'icon'  => 'pencil',
                                            'name'  => null,
                                            'rel'   => json_encode(array())
                                        );
                                        break;
                                    case 'view':
                                        $_buttons[] = array(
                                            'type'  => $attr['type'],
                                            'action'=> $action,
                                            'title' => $this->language->get('action_' . $action),
                                            'url'   => html_entity_decode(HTTP_CATALOG . 'index.php?route=product/product&product_id=' . $result['product_id']),
                                            'icon'  => 'eye',
                                            'name'  => null,
                                            'rel'   => json_encode(array())
                                        );
                                        break;
                                    default:
                                        $_buttons[] = array(
                                            'type'  => $attr['type'],
                                            'action'=> $action,
                                            'title' => $this->language->get('action_' . $action),
                                            'url'   => null,
                                            'icon'  => null,
                                            'name'  => $this->language->get('action_' . $attr['short']),
                                            'rel'   => json_encode($attr['rel'])
                                        );
                                        break;
                                }
                            }

                            $value = $_buttons;
                            break;
                        default:
                            $value = isset($result[$displayed_columns[$i]]) ? $result[$displayed_columns[$i]] : '';
                            break;
                    }

                    $product[$displayed_columns[$i]] = $value;
                }

                $product['id'] = $result['product_id'];
                $product['DT_RowId'] = 'p_' . $result['product_id'];

                $output['aaData'][] = $product;
            }

            $this->response->setOutput(json_enc($output));
        }
    }

    public function filter() {
        if ($this->request->server['REQUEST_METHOD'] == 'GET' && isset($this->request->get['type'])) {
            $resp = array();
            switch ($this->request->get['type']) {
                case 'product':
                    $this->load->model('catalog/product_ext');

                    $results = array();

                    if (isset($this->request->get['query'])) {
                        if (is_array($this->request->get['query']) && isset($this->request->get['multiple'])) {
                            $results = array();

                            foreach ((array)$this->request->get['query'] as $value) {
                                $result =  $this->model_catalog_product_ext->getProduct($value);
                                $results[] = $result;
                            }
                        } else {
                            $data = array(
                                'search'    => $this->request->get['query'],
                                'filter'    => array(),
                                'sort'      => array(),
                                'start'     => '',
                                'limit'     => '',
                                'columns'   => array('name')
                            );

                            $results = $this->model_catalog_product_ext->getProducts($data);
                        }
                    }

                    foreach ($results as $result) {
                        $result['name'] = html_entity_decode($result['name']);
                        $resp[] = array(
                            'value'     => $result['name'],
                            'tokens'    => explode(' ', $result['name']),
                            'id'        => $result['product_id'],
                            'model'     => $result['model']
                        );
                    }
                    break;
                case 'category':
                    $this->load->model('catalog/category');

                    if (isset($this->request->get['query'])) {
                        if (is_array($this->request->get['query']) && isset($this->request->get['multiple'])) {
                            $results = array();

                            foreach ((array)$this->request->get['query'] as $value) {
                                $result =  $this->model_catalog_category->getCategory($value);
                                $result['name'] = $result['path'] ? $result['path'] . ' &gt; ' . $result['name'] : $result['name'];
                                $results[] = $result;
                            }
                        } else {
                            $data = array(
                                'filter_name' => $this->request->get['query']
                            );

                            $results = $this->model_catalog_category->getCategories($data);

                            if (stripos($this->language->get('text_none'), $this->request->get['query']) !== false) {
                                $resp[] = array(
                                        'value'     => $this->language->get('text_none'),
                                        'tokens'    => explode(' ', trim(str_replace('---', '', $this->language->get('text_none')))),
                                        'id'        => '*',
                                        'path'      => '',
                                        'full_name' => $this->language->get('text_none')
                                    );
                            }
                        }
                    } else {
                        $results = $this->cache->get('category.all');

                        if (is_null($results)) {
                            $results = $this->model_catalog_category->getCategories(array());
                            $this->cache->set('category.all', $results);
                        }

                        $resp[] = array(
                                'value'     => $this->language->get('text_none'),
                                'tokens'    => array_merge(explode(' ', trim(str_replace('---', '', $this->language->get('text_none')))), (array)trim($this->language->get('text_none'))),
                                'id'        => '*',
                                'path'      => '',
                                'full_name' => $this->language->get('text_none')
                            );
                    }

                    foreach ($results as $result) {
                        $result['name'] = html_entity_decode($result['name']);
                        $parts = explode(' > ', $result['name']);
                        $last_part = array_pop($parts);

                        $resp[] = array(
                            'value'     => $last_part,
                            'tokens'    => explode(' ', str_replace(' > ', ' ', $result['name'])),
                            'id'        => $result['category_id'],
                            'path'      => $parts ? implode(' > ', $parts) . ' > ' : '',
                            'full_name' => $result['name']
                        );
                    }
                    break;
                case 'manufacturer':
                    $this->load->model('catalog/manufacturer');

                    if (isset($this->request->get['query'])) {
                        $data = array(
                            'filter_name' => $this->request->get['query']
                        );

                        $results = $this->model_catalog_manufacturer->getManufacturers($data);

                        if (stripos($this->language->get('text_none'), $this->request->get['query']) !== false) {
                            $resp[] = array(
                                    'value'     => $this->language->get('text_none'),
                                    'tokens'    => explode(' ', trim(str_replace('---', '', $this->language->get('text_none')))),
                                    'id'        => '*',
                                );
                        }
                    } else {
                        $results = $this->cache->get('manufacturer.all');

                        if (is_null($results)) {
                            $results = $this->model_catalog_manufacturer->getManufacturers(array());
                            $this->cache->set('manufacturer.all', $results);
                        }

                        $resp[] = array(
                                'value'     => $this->language->get('text_none'),
                                'tokens'    => array_merge(explode(' ', trim(str_replace('---', '', $this->language->get('text_none')))), (array)trim($this->language->get('text_none'))),
                                'id'        => '*',
                            );
                    }

                    foreach ($results as $result) {
                        $result['name'] = html_entity_decode($result['name']);
                        $resp[] = array(
                            'value'     => $result['name'],
                            'tokens'    => explode(' ', $result['name']),
                            'id'        => $result['manufacturer_id'],
                        );
                    }
                    break;
                case 'download':
                    $this->load->model('catalog/download');

                    if (isset($this->request->get['query'])) {
                        if (is_array($this->request->get['query']) && isset($this->request->get['multiple'])) {
                            $results = array();

                            foreach ((array)$this->request->get['query'] as $value) {
                                $result =  $this->model_catalog_download->getDownload($value);
                                $results[] = $result;
                            }
                        } else {
                            $data = array(
                                'filter_name' => $this->request->get['query']
                            );

                            $results = $this->model_catalog_download->getDownloads($data);

                            if (stripos($this->language->get('text_none'), $this->request->get['query']) !== false) {
                                $resp[] = array(
                                        'value'     => $this->language->get('text_none'),
                                        'tokens'    => explode(' ', trim(str_replace('---', '', $this->language->get('text_none')))),
                                        'id'        => '*',
                                    );
                            }
                        }
                    } else {
                        $results = $this->cache->get('downloads.all');

                        if (is_null($results)) {
                            $results = $this->model_catalog_download->getDownloads(array());
                            $this->cache->set('downloads.all', $results);
                        }

                        $resp[] = array(
                                'value'     => $this->language->get('text_none'),
                                'tokens'    => array_merge(explode(' ', trim(str_replace('---', '', $this->language->get('text_none')))), (array)trim($this->language->get('text_none'))),
                                'id'        => '*',
                            );
                    }

                    foreach ($results as $result) {
                        $result['name'] = html_entity_decode($result['name']);
                        $resp[] = array(
                            'value'     => $result['name'],
                            'tokens'    => explode(' ', $result['name']),
                            'id'        => $result['download_id'],
                        );
                    }
                    break;
                case 'filter':
                    $this->load->model('catalog/filter');

                    if (isset($this->request->get['query'])) {
                        if (is_array($this->request->get['query']) && isset($this->request->get['multiple'])) {
                            $results = array();

                            foreach ((array)$this->request->get['query'] as $value) {
                                $result =  $this->model_catalog_filter->getFilter($value);
                                $idx = null;
                                foreach ($results as $key => $value) {
                                    if ($value['filter_group_id'] == $result['filter_group_id']) {
                                        $idx = $key;
                                        break;
                                    }
                                }

                                if (is_null($idx)) {
                                    $idx = count($results);
                                    $results[$idx] = array(
                                        'filter_group_id'   => $result['filter_group_id'],
                                        'name'              => $result['group'],
                                        'filters'           => array()
                                    );
                                }

                                $results[$idx]['filters'][] = array(
                                    'filter_id' => $result['filter_id'],
                                    'name'      => $result['name'],
                                );
                            }
                        } else {
                            $data = array(
                                'filter_name' => $this->request->get['query']
                            );

                            $results = $this->model_catalog_filter->getFiltersByGroup($data);

                            if (stripos($this->language->get('text_none'), $this->request->get['query']) !== false) {
                                $resp[] = array(
                                        'value'     => $this->language->get('text_none'),
                                        'tokens'    => explode(' ', trim(str_replace('---', '', $this->language->get('text_none')))),
                                        'group'     => '',
                                        'id'        => '*',
                                        'full_name' => $this->language->get('text_none')
                                    );
                            }
                        }
                    } else {
                        $results = $this->cache->get('filters.all');

                        if (is_null($results)) {
                            $results = $this->model_catalog_filter->getFiltersByGroup();
                            $this->cache->set('filters.all', $results);
                        }

                        $resp[] = array(
                                'value'     => $this->language->get('text_none'),
                                'tokens'    => array_merge(explode(' ', trim(str_replace('---', '', $this->language->get('text_none')))), (array)trim($this->language->get('text_none'))),
                                'group'     => '',
                                'id'        => '*',
                                'full_name' => $this->language->get('text_none')
                            );
                    }

                    foreach ($results as $fg) {
                        foreach ($fg['filters'] as $f) {
                            $name = strip_tags(html_entity_decode($fg['name'] . ' > ' . $f['name']));
                            $resp[] = array(
                                'value'     => $f['name'],
                                'tokens'    => explode(' ', strip_tags(html_entity_decode($fg['name'] . ' ' .$f['name']))),
                                'group'     => $fg['name'] . ' > ',
                                'group_name'=> $fg['name'],
                                'id'        => $f['filter_id'],
                                'full_name' => $name
                            );
                        }
                    }
                    break;
                case 'attributes':
                    $this->load->model('catalog/attribute');

                    $results = array();
                    if (isset($this->request->get['query'])) {
                        if (is_array($this->request->get['query']) && isset($this->request->get['multiple'])) {
                            // TODO: if needed
                        } else {
                            $data = array(
                                'filter_name' => $this->request->get['query']
                            );

                            $results = $this->model_catalog_attribute->getAttributesByGroup($data);
                        }
                    } else {
                        // TODO: if needed
                    }

                    foreach ($results as $ag) {
                        foreach ($ag['attributes'] as $a) {
                            $name = strip_tags(html_entity_decode($ag['name'] . ' > ' . $a['name']));
                            $resp[] = array(
                                'value'     => $a['name'],
                                'tokens'    => explode(' ', strip_tags(html_entity_decode($ag['name'] . ' ' . $a['name']))),
                                'group'     => $ag['name'],
                                'group_name'=> $ag['name'],
                                'id'        => $a['attribute_id'],
                                'full_name' => $name
                            );
                        }
                    }
                    break;
                case 'name':
                case 'model':
                case 'sku':
                case 'upc':
                case 'ean':
                case 'jan':
                case 'isbn':
                case 'mpn':
                case 'location':
                case 'seo':
                    $results = array();

                    $this->load->model('catalog/product_ext');

                    if (isset($this->request->get['query'])) {
                        $results = $this->model_catalog_product_ext->filterKeywords($this->request->get['type'], $this->request->get['query']);
                    }

                    foreach ($results as $result) {
                        $result = html_entity_decode($result);
                        $resp[] = array(
                            'value'     => $result,
                            'tokens'    => explode(' ', $result),
                        );
                    }
                    break;
                case 'options':
                    $this->language->load('catalog/option');

                    $this->load->model('catalog/option');
                    $this->load->model('tool/image');

                    $results = array();

                    if (isset($this->request->get['query'])) {
                        if (is_array($this->request->get['query']) && isset($this->request->get['multiple'])) {
                            // TODO: if needed
                        } else {
                            $data = array(
                                'filter_name' => $this->request->get['query']
                            );

                            $results = $this->model_catalog_option->getOptions($data);
                        }
                    } else {
                        // TODO: if needed
                    }

                    foreach ($results as $option) {
                        $option_value_data = array();

                        if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                            $option_values = $this->model_catalog_option->getOptionValues($option['option_id']);

                            foreach ($option_values as $option_value) {
                                if ($option_value['image'] && file_exists(DIR_IMAGE . $option_value['image'])) {
                                    $image = $this->model_tool_image->resize($option_value['image'], 50, 50);
                                } else {
                                    $image = '';
                                }

                                $option_value_data[] = array(
                                    'option_value_id' => $option_value['option_value_id'],
                                    'name'            => html_entity_decode($option_value['name'], ENT_QUOTES, 'UTF-8'),
                                    'image'           => $image
                                );
                            }

                            $sort_order = array();

                            foreach ($option_value_data as $key => $value) {
                                $sort_order[$key] = $value['name'];
                            }

                            array_multisort($sort_order, SORT_ASC, $option_value_data);
                        }

                        $type = '';

                        if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
                            $type = $this->language->get('text_choose');
                        }

                        if ($option['type'] == 'text' || $option['type'] == 'textarea') {
                            $type = $this->language->get('text_input');
                        }

                        if ($option['type'] == 'file') {
                            $type = $this->language->get('text_file');
                        }

                        if ($option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
                            $type = $this->language->get('text_date');
                        }

                        $name = strip_tags(html_entity_decode($option['name'], ENT_QUOTES, 'UTF-8'));
                        $resp[] = array(
                            'value'         => $name,
                            'tokens'        => explode(' ', strip_tags($name)),
                            'category'      => $type,
                            'type'          => $option['type'],
                            'id'            => $option['option_id'],
                            'option_value'  => $option_value_data
                        );
                    }
                    break;
                default:
                    break;
            }
        }

        $this->response->setOutput(json_enc($resp, JSON_UNESCAPED_SLASHES));
    }

    public function load() {
        $this->language->load('catalog/product_ext');

        $json = array('success' => false);

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateLoadData($this->request->post)) {
            $languages = array();

            $this->load->model('localisation/language');
            $langs = $this->model_localisation_language->getLanguages();
            foreach($langs as $lang) {
                $languages[$lang['language_id']] = $lang;
            }

            $id = $this->request->post['id'];
            $column = $this->request->post['column'];

            $this->data['aqe_alternate_row_colour'] = $this->config->get('aqe_alternate_row_colour');
            $this->data['aqe_row_hover_highlighting'] = $this->config->get('aqe_row_hover_highlighting');

            $json['data'] = array();

            switch ($column) {
                case 'tag':
                    if (defined('VERSION') && version_compare(VERSION, '1.5.4', '<')) {
                        $this->load->model('catalog/product');
                        $result = $this->model_catalog_product->getProductTags($id);

                        foreach($languages as $language_id => $language) {
                            $json['data'][] = array(
                                'lang'  => $language_id,
                                'value' => isset($result[$language_id]) ? html_entity_decode(implode(", ", explode(",", $result[$language_id]))) : '',
                                'title' => $language['name'],
                                'image' => 'view/image/flags/' . $language['image']
                            );
                        }
                        $json['success'] = true;
                        break;
                    }
                case 'name':
                    $this->load->model('catalog/product');
                    $result = $this->model_catalog_product->getProductDescriptions($id);

                    foreach($languages as $language_id => $language) {
                        $json['data'][] = array(
                            'lang'  => $language_id,
                            'value' => isset($result[$language_id][$column]) ? html_entity_decode($result[$language_id][$column]) : '',
                            'title' => $language['name'],
                            'image' => 'view/image/flags/' . $language['image']
                        );
                    }
                    $json['success'] = true;
                    break;
                case 'seo':
                    $this->load->model('catalog/product_ext');
                    $result = $this->model_catalog_product_ext->getProductSeoKeywords($id);

                    foreach($languages as $language_id => $language) {
                        $json['data'][] = array(
                            'lang'  => $language_id,
                            'value' => isset($result[$language_id]) ? html_entity_decode($result[$language_id]) : '',
                            'title' => $language['name'],
                            'image' => 'view/image/flags/' . $language['image']
                        );
                    }
                    $json['success'] = true;
                    break;
                case 'attributes':
                    $this->data['languages'] = $languages;

                    $this->data['text_autocomplete'] = $this->language->get('text_autocomplete');
                    $this->data['entry_attribute'] = $this->language->get('entry_attribute');
                    $this->data['entry_text'] = $this->language->get('entry_text');
                    $this->data['button_add_attribute'] = $this->language->get('button_add_attribute');
                    $this->data['button_remove'] = $this->language->get('button_remove');

                    $this->data['product_id'] = $id;
                    $this->data['column'] = $column;
                    $this->data['product_attributes'] = array();

                    $this->load->model('catalog/product');
                    $this->load->model('catalog/attribute');

                    $product_attributes = $this->model_catalog_product->getProductAttributes($id);

                    foreach ($product_attributes as $product_attr) {
                        $attribute_info = $this->model_catalog_attribute->getAttribute($product_attr['attribute_id']);

                        if ($attribute_info) {
                            $product_attribute = array(
                                'attribute_id'  => $product_attr['attribute_id'],
                                'name'          => (defined('VERSION') && version_compare(VERSION, '1.5.5', '<')) ? (isset($product_attr['name']) ? $product_attr['name'] : '???') : $attribute_info['name'],
                                'values'        => array()
                            );

                            foreach ($product_attr['product_attribute_description'] as $language_id => $value) {
                                $product_attribute['values'][] = array(
                                    'value'         => $value['text'],
                                    'language_id'   => $language_id
                                );
                            }

                            $this->data['product_attributes'][] = $product_attribute;
                        }
                    }

                    $this->data['typeahead'] = html_entity_decode($this->url->link('catalog/product_ext/filter', 'type=attributes&query=%QUERY' . $this->urlParams(), 'SSL'));
					 $this->data['token'] = $this->session->data['token'];
                    $this->template = 'catalog/product_ext_qe_form.tpl';

                    $json['data'] = $this->render();
                    $json['title'] = $this->language->get('action_attributes');
                    $json['success'] = true;
                    break;
                case 'discounts':
                    $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
                    $this->data['entry_quantity'] = $this->language->get('entry_quantity');
                    $this->data['entry_priority'] = $this->language->get('entry_priority');
                    $this->data['entry_price'] = $this->language->get('entry_price');
                    $this->data['entry_date_start'] = $this->language->get('entry_date_start');
                    $this->data['entry_date_end'] = $this->language->get('entry_date_end');
                    $this->data['button_add_discount'] = $this->language->get('button_add_discount');
                    $this->data['button_remove'] = $this->language->get('button_remove');

                    $this->data['product_id'] = $id;
                    $this->data['column'] = $column;

                    $this->load->model('sale/customer_group');
                    $this->load->model('catalog/product');

                    $this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
                    $this->data['product_discounts'] = $this->model_catalog_product->getProductDiscounts($id);
					 $this->data['token'] = $this->session->data['token'];
                    $this->template = 'catalog/product_ext_qe_form.tpl';

                    $json['data'] = $this->render();
                    $json['title'] = $this->language->get('action_discounts');
                    $json['success'] = true;
                    break;
                case 'specials':
                    $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
                    $this->data['entry_priority'] = $this->language->get('entry_priority');
                    $this->data['entry_price'] = $this->language->get('entry_price');
                    $this->data['entry_date_start'] = $this->language->get('entry_date_start');
                    $this->data['entry_date_end'] = $this->language->get('entry_date_end');
                    $this->data['button_add_special'] = $this->language->get('button_add_special');
                    $this->data['button_remove'] = $this->language->get('button_remove');

                    $this->data['product_id'] = $id;
                    $this->data['column'] = $column;

                    $this->load->model('sale/customer_group');
                    $this->load->model('catalog/product');

                    $this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
                    $this->data['product_specials'] = $this->model_catalog_product->getProductSpecials($id);
					$this->data['token'] = $this->session->data['token'];
                    $this->template = 'catalog/product_ext_qe_form.tpl';

                    $json['data'] = $this->render();
                    $json['title'] = $this->language->get('action_specials');
                    $json['success'] = true;
                    break;
                case 'filters':
                    $this->data['text_select_filter'] = $this->language->get('text_select_filter');

                    $this->data['product_id'] = $id;
                    $this->data['column'] = $column;

                    $this->load->model('catalog/filter');
                    $this->load->model('catalog/product');

                    $results = $this->cache->get('filters.all');

                    if (is_null($results)) {
                        $results = $this->model_catalog_filter->getFiltersByGroup();
                        $this->cache->set('filters.all', $results);
                    }

                    $this->data['filters'] = $results;
                    $this->data['product_filters'] = $this->model_catalog_product->getProductFilters($id);
					 $this->data['token'] = $this->session->data['token'];
                    $this->template = 'catalog/product_ext_qe_form.tpl';

                    $json['data'] = $this->render();
                    $json['title'] = $this->language->get('action_filters');
                    $json['success'] = true;
                    break;
                case 'profiles':
                    $this->data['entry_profile'] = $this->language->get('entry_profile');
                    $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
                    $this->data['button_add_profile'] = $this->language->get('button_add_profile');
                    $this->data['button_remove'] = $this->language->get('button_remove');

                    $this->data['product_id'] = $id;
                    $this->data['column'] = $column;

                    $this->load->model('catalog/profile');
                    $this->load->model('catalog/product');
                    $this->load->model('sale/customer_group');

                    $this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();
                    $this->data['profiles'] = $this->model_catalog_profile->getProfiles();
                    $this->data['product_profiles'] = $this->model_catalog_product->getProfiles($id);
					 $this->data['token'] = $this->session->data['token'];
                    $this->template = 'catalog/product_ext_qe_form.tpl';

                    $json['data'] = $this->render();
                    $json['title'] = $this->language->get('action_profiles');
                    $json['success'] = true;
                    break;
                case 'related':
                    $this->data['text_autocomplete'] = $this->language->get('text_autocomplete');

                    $this->data['product_id'] = $id;
                    $this->data['column'] = $column;

                    $this->data['token'] = $this->session->data['token'];
                    $this->data['filter'] = html_entity_decode($this->url->link('catalog/product_ext/filter', '', 'SSL'));

                    $this->load->model('catalog/product');

                    $results = $this->model_catalog_product->getProductRelated($id);
                    $this->data['product_related'] = array();

                    foreach ($results as $product_id) {
                        $related_info = $this->model_catalog_product->getProduct($product_id);

                        if ($related_info) {
                            $this->data['product_related'][$product_id] = array(
                                'product_id' => $related_info['product_id'],
                                'name'       => html_entity_decode($related_info['name']),
                                'model'      => $related_info['model']
                            );
                        }
                    }
					 $this->data['token'] = $this->session->data['token'];
                    $this->template = 'catalog/product_ext_qe_form.tpl';

                    $json['data'] = $this->render();
                    $json['title'] = $this->language->get('action_related');
                    $json['success'] = true;
                    break;
                case 'descriptions':
                    $this->data['entry_description'] = $this->language->get('entry_description');
                    $this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
                    $this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');

                    $this->data['product_id'] = $id;
                    $this->data['column'] = $column;

                    $this->load->model('localisation/language');
                    $this->load->model('catalog/product');
			
                    $this->data['languages'] = $this->model_localisation_language->getLanguages();
                    $this->data['product_description'] = $this->model_catalog_product->getProductDescriptions($id);
					 $this->data['token'] = $this->session->data['token'];
                    $this->template = 'catalog/product_ext_qe_form.tpl';

                    $json['data'] = $this->render();
                    $json['title'] = $this->language->get('action_descriptions');
                    $json['success'] = true;
                    break;
                case 'images':
                    $additional_image_width = 100;
                    $additional_image_height = 100;

                    $this->data['text_browse'] = $this->language->get('text_browse');
                    $this->data['text_clear'] = $this->language->get('text_clear');
                    $this->data['button_add_image'] = $this->language->get('button_add_image');
                    $this->data['button_remove'] = $this->language->get('button_remove');
                    $this->data['entry_image'] = $this->language->get('entry_image');
                    $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

                    $this->data['product_id'] = $id;
                    $this->data['column'] = $column;

                    $this->load->model('catalog/product');
                    $this->load->model('tool/image');

                    $this->data['token'] = $this->session->data['token'];
                    $this->data['additional_image_width'] = $additional_image_width;
                    $this->data['additional_image_height'] = $additional_image_height;

                    $product_images = $this->model_catalog_product->getProductImages($id);
                    $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', $additional_image_width, $additional_image_height);
                    $this->data['product_images'] = array();

                    foreach ($product_images as $product_image) {
                        if ($product_image['image'] && file_exists(DIR_IMAGE . $product_image['image'])) {
                            $image = $product_image['image'];
                        } else {
                            $image = 'no_image.jpg';
                        }

                        $this->data['product_images'][] = array(
                            'image'      => $image,
                            'thumb'      => $this->model_tool_image->resize($image, $additional_image_width, $additional_image_height),
                            'sort_order' => $product_image['sort_order']
                        );
                    }

                    $this->template = 'catalog/product_ext_qe_form.tpl';

                    $json['data'] = $this->render();
                    $json['title'] = $this->language->get('action_images');
                    $json['success'] = true;
                    break;
                case 'options':
                    $this->data['text_yes'] = $this->language->get('text_yes');
                    $this->data['text_no'] = $this->language->get('text_no');
                    $this->data['text_plus'] = $this->language->get('text_plus');
                    $this->data['text_minus'] = $this->language->get('text_minus');
                    $this->data['text_autocomplete'] = $this->language->get('text_autocomplete');
                    $this->data['entry_required'] = $this->language->get('entry_required');
                    $this->data['entry_option_value'] = $this->language->get('entry_option_value');
                    $this->data['entry_quantity'] = $this->language->get('entry_quantity');
                    $this->data['entry_subtract'] = $this->language->get('entry_subtract');
                    $this->data['entry_price'] = $this->language->get('entry_price');
                    $this->data['entry_option_points'] = $this->language->get('entry_option_points');
                    $this->data['entry_weight'] = $this->language->get('entry_weight');
                    $this->data['button_add_option'] = $this->language->get('button_add_option');
                    $this->data['button_remove'] = $this->language->get('button_remove');

                    $this->data['product_id'] = $id;
                    $this->data['column'] = $column;

                    $this->load->model('catalog/product');
                    $this->load->model('catalog/option');

                    $product_options = $this->model_catalog_product->getProductOptions($id);
                    $this->data['product_options'] = array();

                    foreach ($product_options as $product_option) {
                        if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                            $product_option_value_data = array();

                            foreach ($product_option['product_option_value'] as $product_option_value) {
                                $product_option_value_data[] = array(
                                    'product_option_value_id' => $product_option_value['product_option_value_id'],
                                    'option_value_id'         => $product_option_value['option_value_id'],
                                    'quantity'                => $product_option_value['quantity'],
                                    'subtract'                => $product_option_value['subtract'],
                                    'price'                   => $product_option_value['price'],
                                    'price_prefix'            => $product_option_value['price_prefix'],
                                    'points'                  => $product_option_value['points'],
                                    'points_prefix'           => $product_option_value['points_prefix'],
                                    'weight'                  => $product_option_value['weight'],
                                    'weight_prefix'           => $product_option_value['weight_prefix']
                                );
                            }

                            $this->data['product_options'][] = array(
                                'product_option_id'    => $product_option['product_option_id'],
                                'option_id'            => $product_option['option_id'],
                                'name'                 => html_entity_decode($product_option['name']),
                                'type'                 => $product_option['type'],
                                'required'             => $product_option['required'],
                                'product_option_value' => $product_option_value_data
                            );
                        } else {
                            $this->data['product_options'][] = array(
                                'product_option_id'     => $product_option['product_option_id'],
                                'option_id'             => $product_option['option_id'],
                                'name'                  => html_entity_decode($product_option['name']),
                                'type'                  => $product_option['type'],
                                'required'              => $product_option['required'],
                                'product_option_value'  => $product_option['option_value']
                            );
                        }
                    }

                    $this->data['option_values'] = array();

                    foreach ($product_options as $product_option) {
                        if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                            if (!isset($this->data['option_values'][$product_option['option_id']])) {
                                $this->data['option_values'][$product_option['option_id']] = $this->model_catalog_option->getOptionValues($product_option['option_id']);
                            }
                        }
                    }

                    $this->data['typeahead'] = html_entity_decode($this->url->link('catalog/product_ext/filter', 'type=options&query=%QUERY' . $this->urlParams(), 'SSL'));
				    $this->data['token'] = $this->session->data['token'];
					 
                    $this->template = 'catalog/product_ext_qe_form.tpl';

                    $json['data'] = $this->render();
                    $json['title'] = $this->language->get('action_options');
                    $json['success'] = true;
                    break;
                default:
                    $json = array_merge($json, array('msg' => $this->language->get('error_load_data'), 'errors' => array(), 'alerts' => array()));
                    break;
            }
        } else {
            $json = array_merge($json, array('msg' => (isset($this->error['error']) ? $this->error['error'] : ''), 'errors' => $this->error, 'alerts' => $this->alert));
        }

        $this->response->setOutput(json_enc($json, JSON_UNESCAPED_SLASHES));
    }

    public function reload() {
        $this->language->load('catalog/product_ext');

        $json = array('success' => false);

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateReloadData($this->request->post)) {
            $json['values'] = array();

            foreach ($this->request->post['data'] as $column => $products) {
                foreach ($products as $id) {
                    switch ($column) {
                        case 'price':
                            $this->load->model('catalog/product');

                            $product = $this->model_catalog_product->getProduct($id);

                            $json['values'][$id][$column] = sprintf('%.4f',round((float)$product['price'], 4));

                            $special = false;
                            $product_specials = $this->model_catalog_product->getProductSpecials($id);

                            foreach ($product_specials  as $product_special) {
                                if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] < date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
                                    $special = $product_special['price'];
                                    break;
                                }
                            }

                            if ($special) {
                                $json['values'][$id]['special'] = sprintf('%.4f',round((float)$special, 4));
                            } else {
                                $json['values'][$id]['special'] = null;
                            }
                            break;
                        case 'filter':
                            $this->load->model('catalog/product');

                            $_filters = $this->cache->get('filters.all');

                            if (is_null($_filters)) {
                                $this->load->model('catalog/filter');
                                $_filters = $this->model_catalog_filter->getFiltersByGroup();
                                $this->cache->set('filters.all', $_filters);
                            }

                            $product_filters = $this->model_catalog_product->getProductFilters($id);

                            $filters = array();

                            foreach ($_filters as $fg) {
                                foreach ($fg['filters'] as $filter) {
                                    if (in_array($filter['filter_id'], (array)$product_filters))
                                        $filters[] = array('id' => (int)$filter['filter_id'], 'text' => strip_tags(html_entity_decode($fg['name'] . ' &gt; ' . $filter['name'], ENT_QUOTES, 'UTF-8')));
                                }
                            }
                            $json['values'][$id][$column] = $product_filters;
                            $json['values'][$id]['filter_data'] = $filters;
                            break;
                        default:
                            $json = array_merge($json, array('msg' => $this->language->get('error_load_data'), 'errors' => array(), 'alerts' => array()));
                            break;
                    }
                }
            }
            $json['success'] = 1;
        } else {
            $json = array_merge($json, array('msg' => (isset($this->error['error']) ? $this->error['error'] : ''), 'errors' => $this->error, 'alerts' => $this->alert));
        }

        $this->response->setOutput(json_enc($json, JSON_UNESCAPED_SLASHES));
    }

    public function update() {
        $this->language->load('catalog/product_ext');

        $this->load->model('catalog/product_ext');

        $json = array('success' => false);

        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateUpdateData($this->request->post)) {
            $id = (array)$this->request->post['id'];
            $column = $this->request->post['column'];
            $value = $this->request->post['value'];
            $lang_id = $this->config->get('config_language_id');

            if (isset($this->request->post['ids'])) {
                $id = array_unique(array_merge($id, (array)$this->request->post['ids']));
            }

            $results = array('done' => array(), 'failed' => array());

            foreach ($id as $_id) {
                if ($this->model_catalog_product_ext->quickEditProduct($_id, $column, $value, $this->request->post)) {
                    $results['done'][] = $_id;
                } else {
                    $results['failed'][] = $_id;
                }
            }

            if ($results['done']) {
                $json['success'] = true;

                if (count($results['done']) > 1) {
                    $json['msg'] = sprintf($this->language->get('text_success_update_count'), $this->language->get('column_' . $this->request->post['column']), count($results['done']));
                } else {
                    $json['msg'] = sprintf($this->language->get('text_success_update'), $this->language->get('column_' . $this->request->post['column']));
                }
                if (in_array($column, array('attributes', 'discounts', 'images', 'options', 'profiles', 'related', 'specials', 'descriptions'))) {
                } else if (in_array($column, array('sort_order', 'points', 'minimum', 'viewed', 'quantity'))) {
                    if ($column == 'quantity' && defined('VERSION') && version_compare(VERSION, '1.5.6', '>=')) {
                        $this->openbay->putStockUpdateBulk($id);
                    }
                    $json['value'] = (int)$value;
                } else if (in_array($column, array('subtract', 'shipping'))) {
                    $json['value'] = (int)$value;
                    $json['values']['*'][$column . '_text'] = ((int)$value) ? $this->language->get('text_yes') : $this->language->get('text_no');
                } else if ($column == 'status') {
                    $json['value'] = (int)$value;
                    $json['values']['*']['status_text'] = ((int)$value) ? $this->language->get('text_enabled') : $this->language->get('text_disabled');
                    if ($this->config->get('aqe_highlight_status')) {
                        $json['values']['*']['status_class'] = (int)$value ? 'success' : 'danger';
                    }
                } else if (in_array($column, array('weight', 'length', 'width', 'height'))) {
                    $json['value'] = sprintf('%.4f',round((float)$value, 4));
                } else if ($column == 'image') {
                    $this->load->model('tool/image');

                    $w = (int)$this->config->get('aqe_list_view_image_width');
                    $h = (int)$this->config->get('aqe_list_view_image_height');

                    if ($value && file_exists(DIR_IMAGE . $value)) {
                        $image = $this->model_tool_image->resize($value, $w, $h);
                    } else {
                        $image = $this->model_tool_image->resize('no_image.jpg', $w, $h);
                    }

                    $json['value'] = $value;
                    $json['values']['*']['image_thumb'] = $image;
                } else if ($column == 'date_available') {
                    $date = new DateTime($value);
                    $json['value'] = $value;
                    // $json[$column . '_text'] = $date->format($this->language->get('date_format_short'));
                    $json['values']['*'][$column . '_text'] = $date->format('Y-m-d');
                } else if (in_array($column, array('date_added', 'date_modified'))) {
                    $date = new DateTime($value);
                    $json['value'] = $value;
                    // $json[$column . '_text'] = $date->format($this->language->get('date_format_short') . ' ' . $this->language->get('time_format'));
                    $json['values']['*'][$column . '_text'] = $date->format('Y-m-d H:i:s');
                } else if ($column == 'tax_class') {
                    $this->load->model('localisation/tax_class');
                    $tax_class = $this->model_localisation_tax_class->getTaxClass((int)$value);
                    if ($tax_class) {
                        $json['value'] = (int)$tax_class['tax_class_id'];
                        $json['values']['*']['tax_class_text'] = $tax_class['title'];
                    } else {
                        $json['value'] = '';
                        $json['values']['*']['tax_class_text'] = '';
                    }
                } else if ($column == 'stock_status') {
                    $this->load->model('localisation/stock_status');
                    $stock_status = $this->model_localisation_stock_status->getStockStatus((int)$value);
                    if ($stock_status) {
                        $json['value'] = (int)$stock_status['stock_status_id'];
                        $json['values']['*']['stock_status_text'] = $stock_status['name'];
                    } else {
                        $json['value'] = '';
                        $json['values']['*']['stock_status_text'] = '';
                    }
                } else if ($column == 'length_class') {
                    $this->load->model('localisation/length_class');
                    $length_class = $this->model_localisation_length_class->getLengthClass((int)$value);
                    if ($length_class) {
                        $json['value'] = (int)$length_class['length_class_id'];
                        $json['values']['*']['length_class_text'] = $length_class['title'];
                    } else {
                        $json['value'] = '';
                        $json['values']['*']['length_class_text'] = '';
                    }
                } else if ($column == 'weight_class') {
                    $this->load->model('localisation/weight_class');
                    $weight_class = $this->model_localisation_weight_class->getWeightClass((int)$value);
                    if ($weight_class) {
                        $json['value'] = (int)$weight_class['weight_class_id'];
                        $json['values']['*']['weight_class_text'] = $weight_class['title'];
                    } else {
                        $json['value'] = '';
                        $json['values']['*']['weight_class_text'] = '';
                    }
                } else if ($column == 'manufacturer') {
                    $this->load->model('catalog/manufacturer');
                    $manufacturer = $this->model_catalog_manufacturer->getManufacturer((int)$value);
                    if ($manufacturer) {
                        $json['value'] = (int)$manufacturer['manufacturer_id'];
                        $json['values']['*']['manufacturer_text'] = $manufacturer['name'];
                    } else {
                        $json['value'] = 0;
                        $json['values']['*']['manufacturer_text'] = '';
                    }
                } else if (in_array($column, array('name', 'tag', 'seo'))) {
                    if ($column == 'tag' && defined('VERSION') && version_compare(VERSION, '1.5.4', '<')) {
                        $this->load->model('catalog/product');
                        $tags = $this->model_catalog_product->getProductTags($id[0]);
                        if (isset($tags[$lang_id])) {
                            $json['value'] = implode(", ", explode(",", $tags[$lang_id]));
                        } else {
                            $json['value'] = '';
                        }
                    } else {
                        if (is_array($value)) {
                            $json['value'] = '';
                            foreach ((array)$value as $v) {
                                if ($v['lang'] == $lang_id) {
                                    $json['value'] = $v['value'];
                                }
                            }
                        } else
                            $json['value'] = $value;
                    }
                } else if ($column == 'category') {
                    $_categories = $this->cache->get('category.all');

                    if (is_null($_categories)) {
                        $this->load->model('catalog/category');
                        $_categories = $this->model_catalog_category->getCategories(array());
                        $this->cache->set('category.all', $_categories);
                    }

                    $categories = array();

                    foreach ($_categories as $category) {
                        if (in_array($category['category_id'], (array)$value))
                            $categories[] = array('id' => (int)$category['category_id'], 'text' => $category['name']);
                    }
                    $json['value'] = $value;
                    $json['values']['*']['category_data'] = $categories;
                } else if ($column == 'store') {
                    $_stores = $this->cache->get('store.all');

                    if (is_null($_stores)) {
                        $__stores = $this->model_setting_store->getStores(array());

                        $_stores = array(
                            '0' => array(
                                'store_id'  => 0,
                                'name'      => $this->config->get('config_name'),
                                'url'       => HTTP_CATALOG
                            )
                        );

                        foreach ($__stores as $store) {
                            $_stores[$store['store_id']] = array(
                                'store_id'  => $store['store_id'],
                                'name'      => $store['name'],
                                'url'       => $store['url']
                            );
                        }

                        $this->cache->set('store.all', $_stores);
                    }

                    $stores = array();

                    foreach ($_stores as $store) {
                        if (in_array($store['store_id'], (array)$value))
                            $stores[] = array('id' => (int)$store['store_id'], 'text' => $store['name']);
                    }
                    $json['value'] = $value;
                    $json['values']['*']['store_data'] = $stores;
                } else if ($column == 'filter') {
                    $_filters = $this->cache->get('filters.all');

                    if (is_null($_filters)) {
                        $this->load->model('catalog/filter');
                        $_filters = $this->model_catalog_filter->getFiltersByGroup();
                        $this->cache->set('filters.all', $_filters);
                    }

                    $filters = array();

                    foreach ($_filters as $fg) {
                        foreach ($fg['filters'] as $filter) {
                            if (in_array($filter['filter_id'], (array)$value))
                                $filters[] = array('id' => (int)$filter['filter_id'], 'text' => strip_tags(html_entity_decode($fg['name'] . ' &gt; ' . $filter['name'], ENT_QUOTES, 'UTF-8')));
                        }
                    }
                    $json['value'] = $value;
                    $json['values']['*']['filter_data'] = $filters;
                } else if ($column == 'download') {
                    $_downloads = $this->cache->get('downloads.all');

                    if (is_null($_downloads)) {
                        $this->load->model('catalog/download');
                        $_downloads = $this->model_catalog_download->getDownloads(array());
                        $this->cache->set('downloads.all', $_downloads);
                    }

                    $downloads = array();

                    foreach ($_downloads as $download) {
                        if (in_array($download['download_id'], (array)$value))
                            $downloads[] = array('id' => (int)$download['download_id'], 'text' => $download['name']);
                    }
                    $json['value'] = $value;
                    $json['values']['*']['download_data'] = $downloads;
                } else if ($column == 'price') {
                    $this->load->model('catalog/product');

                    $json['value'] = sprintf('%.4f',round((float)$value, 4));

                    foreach ($id as $_id) {
                        $special = false;
                        $product_specials = $this->model_catalog_product->getProductSpecials($_id);
                        foreach ($product_specials  as $product_special) {
                            if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] < date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
                                $special = $product_special['price'];
                                break;
                            }
                        }
                        if ($special) {
                            $json['values'][$_id]['special'] = sprintf('%.4f',round((float)$special, 4));
                        }
                    }
                } else
                    $json['value'] = $value;
            } else
                $json['msg'] = $this->language->get('error_update');

            $json['results'] = $results;

            if ($results['failed']) {
                $this->load->model('catalog/product');

                $failed_products = array();

                foreach ($results['failed'] as $_id) {
                    $product = $this->model_catalog_product->getProduct($_id);
                    if ($product) {
                        $failed_products[] = $product['name'];
                    }
                }

                $json['alerts']['warning']['error_update'] = sprintf($this->language->get('text_error_update'), implode(', ', $failed_products));
            }
        } else {
            $json = array_merge($json, array('msg' => ((isset($this->error['error']) && !is_array($this->error['error'])) ? $this->error['error'] : ''), 'errors' => $this->error, 'alerts' => $this->alert));
        }

        $this->response->setOutput(json_enc($json, JSON_UNESCAPED_SLASHES));
    }

    protected function validateAction($action) {
        $errors = false;

        if (!$this->user->hasPermission('modify', 'catalog/product_ext')) {
            $errors = true;
            $this->alert['error']['permission'] = $this->language->get('error_permission');
        }

        return !$errors;
    }

    protected function validateLoadData($data) {
        $errors = false;

        if (!$this->user->hasPermission('modify', 'catalog/product_ext')) {
            $errors = true;
            $this->alert['error']['permission'] = $this->language->get('error_permission');
        }

        if (!isset($data['id']) || !isset($data['column'])) {
            $errors = true;
            $this->alert['error']['update'] = $this->language->get('error_update');
        }

        return !$errors;
    }

    protected function validateReloadData($data) {
        $errors = false;

        if (!$this->user->hasPermission('modify', 'catalog/product_ext')) {
            $errors = true;
            $this->alert['error']['permission'] = $this->language->get('error_permission');
        }

        if (!isset($data['data'])) {
            $errors = true;
            $this->alert['error']['update'] = $this->language->get('error_update');
        }

        return !$errors;
    }

    protected function validateUpdateData($data) {
        $errors = false;

        if (!$this->user->hasPermission('modify', 'catalog/product_ext')) {
            $errors = true;
            $this->alert['error']['permission'] = $this->language->get('error_permission');
        }

        if (!isset($data['id']) || !isset($data['column']) || !isset($data['value']) || !isset($data['old'])) {
            $errors = true;
            $this->alert['error']['update'] = $this->language->get('error_update');
        }

        $id = $data['id'];
        $column = $data['column'];
        $value = $data['value'];

        if ($column == 'model' && ((strlen(utf8_decode($value)) < 1) || (strlen(utf8_decode($value)) > 64))) {
            $errors = true;
            $this->error['error'] = $this->language->get('error_model');
        }

        if (in_array($column, array('name', 'tag'))) {
            foreach ((array)$value as $v) {
                if (!isset($v['value']) || !isset($v['lang'])) {
                    $errors = true;
                    $this->error['error'] = $this->language->get('error_update');
                } else {
                    if ($column == 'name' && (strlen(utf8_decode($v['value'])) < 1) || (strlen(utf8_decode($v['value'])) > 255)) {
                        $errors = true;
                        $this->error['value'][] = array('lang' => $v['lang'], 'text' => $this->language->get('error_name'));
                    }
                }
            }
        }

        if ($column == 'seo') {
            if (isset($data['ids'])) {
                $errors = true;
                $this->error['error'] = $this->language->get('error_batch_edit_seo');
            } else {
                $multilingual_seo = $this->config->get('aqe_multilingual_seo');

                if ($multilingual_seo) {
                    foreach ((array)$value as $v) {
                        if (!isset($v['value']) || !isset($v['lang'])) {
                            $errors = true;
                            $this->error['error'] = $this->language->get('error_update');
                        } else {
                            if ($this->model_catalog_product_ext->urlAliasExists($id, utf8_decode($v['value']), $v['lang'])) {
                                $errors = true;
                                $this->error['value'][] = array('lang' => $v['lang'], 'text' => $this->language->get('error_duplicate_seo_keyword'));
                            }
                        }
                    }
                } else {
                    if ($this->model_catalog_product_ext->urlAliasExists($id, utf8_decode($value))) {
                        $errors = true;
                        $this->error['error'] = $this->language->get('error_duplicate_seo_keyword');
                    }
                }
            }
        }

        if ($column == 'date_available') {
            if (!validate_date($value, 'Y-m-d')) {
                $errors = true;
                $this->error['error'] = $this->language->get('error_date');
            }
        }

        if ($column == 'date_added') {
            if (!validate_date($value, 'Y-m-d H:i:s')) {
                $errors = true;
                $this->error['error'] = $this->language->get('error_datetime');
            }
        }

        return !$errors;
    }

    protected function validateSettings($data) {
        $errors = false;

        if (!$this->user->hasPermission('modify', 'catalog/product_ext')) {
            $errors = true;
            $this->alert['error']['permission'] = $this->language->get('error_permission');
        }

        if (isset($data['aqe_items_per_page'])) {
            if (!is_numeric($data['aqe_items_per_page'])) {
                $errors = true;
                $this->error['aqe_items_per_page'] = $this->language->get('error_numeric');
            }
        }

        if (isset($data['aqe_list_view_image_width'])) {
            if (!is_numeric($data['aqe_list_view_image_width']) || (int)$data['aqe_list_view_image_width'] < 1) {
                $errors = true;
                $this->error['aqe_list_view_image_width'] = $this->language->get('error_image_size');
            }
        }

        if (isset($data['aqe_list_view_image_height'])) {
            if (!is_numeric($data['aqe_list_view_image_height']) || (int)$data['aqe_list_view_image_height'] < 1) {
                $errors = true;
                $this->error['aqe_list_view_image_height'] = $this->language->get('error_image_size');
            }
        }

        return !$errors;
    }

    protected function urlParams() {
        $url = '&token=' . $this->session->data['token'];

        return $url;
    }
}
?>
