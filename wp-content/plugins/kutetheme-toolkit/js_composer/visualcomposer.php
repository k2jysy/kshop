<?php
/**
 * @author  AngelsIT
 * @package KUTE TOOLKIT
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once KUTETHEME_PLUGIN_PATH . '/js_composer/custom-fields.php';
require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/service.php';
require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/brand.php';
require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/blog.php';
if ( kt_check_active_plugin( 'woocommerce/woocommerce.php' ) ) {
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/tab-category.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/tab-product.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/lastest_deals_sidebar.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/categories.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/lastest_deals.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/list_product.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/popular-cat.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/hot-deal-tab.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/hot-deal.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/box_product.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/featured_products.php';
}