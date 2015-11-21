<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once THEME_DIR. 'inc/hooks/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'kt_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
if( ! function_exists( 'kt_register_required_plugins' ) ):
    function kt_register_required_plugins() {
    	/*
    	 * Array of plugin arrays. Required keys are name and slug.
    	 * If the source is NOT from the .org repo, then source is also required.
    	 */
    	$plugins = array(
    		// This is an example of how to include a plugin pre-packaged with a theme
    		array(
    			'name'     				=> 'Kutetheme toolkit', // The plugin name
    			'slug'     				=> 'kutetheme-toolkit', // The plugin slug (typically the folder name)
    			'source'   				=> get_stylesheet_directory() . '/recommend-plugins/kutetheme-toolkit.zip', // The plugin source
    			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
    			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
    			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
    			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
    			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
    		),
    		array(
    			'name'     				=> 'Revolution Slider', // The plugin name
    			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
    			'source'   				=> get_stylesheet_directory() . '/recommend-plugins/revslider.zip', // The plugin source
    			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
    			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
    			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
    			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
    			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
    		),
            array(
    			'name'     				=> 'WPBakery Visual Composer', // The plugin name
    			'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
    			'source'   				=> get_stylesheet_directory() . '/recommend-plugins/js_composer.zip', // The plugin source
    			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
    			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
    			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
    			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
    			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
    		),
      //       array(
    		// 	'name'     				=> 'Variation Swatches and Photos', // The plugin name
    		// 	'slug'     				=> 'woocommerce-variation-swatches-and-photos', // The plugin slug (typically the folder name)
    		// 	'source'   				=> get_stylesheet_directory() . '/recommend-plugins/woocommerce-variation-swatches-and-photos.zip', // The plugin source
    		// 	'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
    		// 	'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
    		// 	'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
    		// 	'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
    		// 	'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
    		// ),
    		array(
                'name'      => 'WooCommerce',
                'slug'      => 'woocommerce',
                'required'  => false,
            ),    		
            array(
                'name' => 'YITH WooCommerce Wishlist', // The plugin name
                'slug' => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
                'required' => false, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name' => 'YITH WooCommerce Ajax Product Filter', // The plugin name
                'slug' => 'yith-woocommerce-ajax-navigation', // The plugin slug (typically the folder name)
                'required' => false, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name' => 'YITH WooCommerce Quick View', // The plugin name
                'slug' => 'yith-woocommerce-quick-view', // The plugin slug (typically the folder name)
                'required' => false, // If false, the plugin is only 'recommended' instead of required
            ),
    	);
    
    	/*
    	 * Array of configuration settings. Amend each line as needed.
    	 *
    	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
    	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
    	 * sending in a pull-request with .po file(s) with the translations.
    	 *
    	 * Only uncomment the strings in the config array if you want to customize the strings.
    	 */
    	$config = array(
    		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
    		'default_path' => '',                      // Default absolute path to bundled plugins.
    		'menu'         => 'tgmpa-install-plugins', // Menu slug.
    		'parent_slug'  => 'themes.php',            // Parent menu slug.
    		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
    		'has_notices'  => true,                    // Show admin notices or not.
    		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
    		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
    		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
    		'message'      => '',                      // Message to output right before the plugins table.
    	);
    
    	tgmpa( $plugins, $config );
    }
endif;

if( ! function_exists( 'kt_init_session_start' ) ){
    function kt_init_session_start(){
        if(!session_id()) {
            session_start();
        }
    }
}

add_action('init', 'kt_init_session_start', 1);

if( ! function_exists( 'kt_custom_inline_style' ) ){
    function kt_custom_inline_style(){
        $color_scheme_css = kt_get_inline_css();
        wp_add_inline_style( 'kutetheme-style', $color_scheme_css );
    }
}
add_action( 'wp_enqueue_scripts', 'kt_custom_inline_style' );

if( ! function_exists( 'kt_custom_js' ) ){
    function kt_custom_js(){
        $js = kt_get_customize_js();
        if( $js ) :
        ?>
        <script type="text/javascript" id="custom-js">
    		<?php echo esc_textarea( $js ) ; ?>
    	</script>
        <?php
        endif;
    }
}
add_action( 'wp_footer', 'kt_custom_js' );

if( ! function_exists( 'kt_setting_vertical_menu' ) ){
    function kt_setting_vertical_menu(){
        wp_nav_menu( array(
            'menu'              => 'vertical',
            'theme_location'    => 'vertical',
            'depth'             => 0,
            'container'         => '',
            'container_class'   => '',
            'container_id'      => '',
            'menu_class'        => 'navigation  vertical-menu-list',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'walker'            => new wp_bootstrap_navwalker())
        );
    }
}
if( ! function_exists( 'kt_setting_mega_menu' ) ){
    function kt_setting_mega_menu(){
        wp_nav_menu( array(
            'menu'              => 'primary',
            'theme_location'    => 'primary',
            'depth'             => 0,
            'container'         => '',
            'container_class'   => '',
            'container_id'      => '',
            'menu_class'        => 'navigation navigation-main-menu',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'walker'            => new wp_bootstrap_navwalker())
        );
    }
}
if( ! function_exists( 'kt_show_menu_option_1' ) ){
    function kt_show_menu_option_1(){ 
        global $kt_enable_vertical_menu;
        $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
        $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
        ?>
        <div class="top-main-menu style1">
            <?php if( $kt_enable_vertical_menu == 'enable' ): ?>
            <div id="box-vertical-megamenus" class="vertical-wapper">
                <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' ); else echo esc_attr( 'show_content' );?>">
                    <h4 class="title">
                        <span class="title-menu"><?php esc_html_e( 'Categories', 'kutetheme' ) ?></span>
                        <span class="btn-open-mobile home-page"><i class="fa fa-bars"></i></span>
                    </h4>
                    <div class="vertical-menu-content">
                        <?php kt_setting_vertical_menu(); ?>
                        <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="main-menu main-menu-wapper">
                <?php kt_setting_mega_menu(); ?>
                <a href="#" class="mobile-navigation"><?php _e('Main menu','kutetheme');?><i class="fa fa-bars"></i></a>
            </div>
        </div>
        <?php
    }
}
add_action( 'kt_show_menu_option_1', 'kt_show_menu_option_1' );

if( ! function_exists( 'kt_show_menu_option_2' ) ){
    function kt_show_menu_option_2(){
        global $kt_enable_vertical_menu;
        $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
        $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
        ?>
        <div class="top-main-menu style2">
            <?php if( $kt_enable_vertical_menu == 'enable' ): ?>
            <div id="box-vertical-megamenus" class="vertical-wapper">
                <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                    <h4 class="title">
                        <span class="title-menu"><?php esc_html_e( 'Categories', 'kutetheme' ) ?></span>
                        <span class="btn-open-mobile home-page"><i class="fa fa-bars"></i></span>
                    </h4>
                    <div class="vertical-menu-content">
                        <?php kt_setting_vertical_menu(); ?>
                        <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="main-menu main-menu-wapper">
                <?php kt_setting_mega_menu(); ?>
                <a href="#" class="mobile-navigation"><?php _e('Main menu','kutetheme');?><i class="fa fa-bars"></i></a>
            </div>
        </div>
    <?php 
    }
}
add_action( 'kt_show_menu_option_2', 'kt_show_menu_option_2' );

if( ! function_exists( 'kt_show_menu_option_3' ) ){
    function kt_show_menu_option_3(){
        global $kt_enable_vertical_menu;
        $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
        $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
        ?>
        <div class="top-main-menu style3">
            <?php if( $kt_enable_vertical_menu == 'enable' ): ?>
            <div id="box-vertical-megamenus" class="vertical-wapper">
                <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                    <h4 class="title">
                        <span class="title-menu"><?php esc_html_e( 'Categories', 'kutetheme' ) ?></span>
                        <span class="btn-open-mobile home-page"><i class="fa fa-bars"></i></span>
                    </h4>
                    <div class="vertical-menu-content">
                        <?php kt_setting_vertical_menu(); ?>
                        <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="main-menu main-menu-wapper">
                <?php kt_setting_mega_menu(); ?>
                <a href="#" class="mobile-navigation"><?php _e('Main menu','kutetheme');?><i class="fa fa-bars"></i></a>
            </div>
        </div>
    <?php }
}
add_action( 'kt_show_menu_option_3', 'kt_show_menu_option_3' );

if( ! function_exists( 'kt_show_vertical_menu_option_4' ) ){
    function kt_show_vertical_menu_option_4(){
        global $kt_enable_vertical_menu;
        $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
        $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
    ?>
    <div class="top-main-menu style4">
        <?php if( $kt_enable_vertical_menu == 'enable' ): ?>
        <div id="box-vertical-megamenus" class="vertical-wapper">
            <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                <h4 class="title">
                    <span class="title-menu"><?php esc_html_e( 'Categories', 'kutetheme' ) ?></span>
                    <span class="btn-open-mobile home-page"><i class="fa fa-bars"></i></span>
                </h4>
                <div class="vertical-menu-content">
                    <?php kt_setting_vertical_menu(); ?>
                    <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="main-menu main-menu-wapper">
            <div class="formsearch-option4">
                <?php kt_search_form();  ?>
            </div>
        </div>
    </div>
    <?php 
    }
}
add_action( 'kt_show_vertical_menu_option_4', 'kt_show_vertical_menu_option_4' );

if( ! function_exists( 'kt_show_menu_option_5' ) ){
    function kt_show_menu_option_5(){
        global $kt_enable_vertical_menu;
        $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
        $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
        ?>
        <div class="top-main-menu style5">
            <?php if( $kt_enable_vertical_menu == 'enable' ): ?>
            <div id="box-vertical-megamenus" class="vertical-wapper">
                <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                    <h4 class="title">
                        <span class="title-menu"><?php esc_html_e( 'Categories', 'kutetheme' ) ?></span>
                        <span class="btn-open-mobile home-page"><i class="fa fa-bars"></i></span>
                    </h4>
                    <div class="vertical-menu-content">
                        <?php kt_setting_vertical_menu(); ?>
                        <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="main-menu main-menu-wapper">
                <?php kt_setting_mega_menu(); ?>
                <a href="#" class="mobile-navigation"><?php _e('Main menu','kutetheme');?><i class="fa fa-bars"></i></a>
            </div>
        </div>
     <?php }
}
add_action( 'kt_show_menu_option_5', 'kt_show_menu_option_5' );


if( ! function_exists( 'kt_show_menu_option_6' ) ){
    function kt_show_menu_option_6(){
        global $kt_enable_vertical_menu;
        $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
        $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
        ?>
        <div class="top-main-menu style6">
            <?php if( $kt_enable_vertical_menu == 'enable' ): ?>
            <div id="box-vertical-megamenus" class="vertical-wapper">
                <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                    <h4 class="title">
                        <span class="title-menu"><?php esc_html_e( 'Categories', 'kutetheme' ) ?></span>
                        <span class="btn-open-mobile home-page"><i class="fa fa-bars"></i></span>
                    </h4>
                    <div class="vertical-menu-content">
                        <?php kt_setting_vertical_menu(); ?>
                        <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="main-menu main-menu-wapper">
                <?php kt_setting_mega_menu(); ?>
                <a href="#" class="mobile-navigation"><?php _e('Main menu','kutetheme');?><i class="fa fa-bars"></i></a>
            </div>
        </div>
     <?php }
}
add_action( 'kt_show_menu_option_6', 'kt_show_menu_option_6' );


if( ! function_exists( 'kt_show_vertical_menu_option_7' ) ){
    function kt_show_vertical_menu_option_7(){ 
    global $kt_enable_vertical_menu;
    $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
    $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
    ?>
    <div class="top-main-menu style7">
        <?php if( $kt_enable_vertical_menu == 'enable' ): ?>
        <div id="box-vertical-megamenus" class="vertical-wapper">
            <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                <h4 class="title">
                    <span class="title-menu"><?php esc_html_e( 'Categories', 'kutetheme' ) ?></span>
                    <span class="btn-open-mobile home-page"><i class="fa fa-bars"></i></span>
                </h4>
                <div class="vertical-menu-content">
                    <?php kt_setting_vertical_menu(); ?>
                    <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="main-menu main-menu-wapper">
            <div class="formsearch-option4">
                <?php kt_search_form();  ?>
            </div>
        </div>
    </div>
    <?php
    }
}
add_action( 'kt_show_menu_option_7', 'kt_show_vertical_menu_option_7' );



function kt_themne_color(){
    $kt_used_header = kt_option('kt_used_header',1);
    $main_color = kt_option('main_color','#ff3366');
    $bg_color = kt_option('bg_color','#fff');
    $price_color = kt_option('price_color','#ff3366');
    $rgba_main_color = vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.5)', kt_hex2rgb( $main_color ) );
    /* Main color */
    $css = <<<CSS
    html body{
        background-color: {$bg_color};
    }
    body a:hover,
    body a:focus,
    body a:active,
    body.woocommerce .summary .yith-wcwl-add-to-wishlist .show a:hover,
    body.woocommerce .summary .compare:hover,
    body.woocommerce .woocommerce-breadcrumb a:hover,
    body .blog-list .blog-list-wapper ul li .readmore a,
    body .count-down-time2 .box-count,
    body .trending .trending-product li .product-price,
    body .hot-deals-box .hot-deals-tab .hot-deals-tab-box .nav-tab li.active>a{
        color: {$main_color}
    }
    body .main-header .header-search-box .form-inline .btn-search,
    body .main-header .shopping-cart-box a.cart-link:after,
    body .cart-block .cart-block-content .cart-buttons a.btn-check-out,
    body .main-bg,
    body .box-vertical-megamenus .vertical-menu-list>li:hover,
    body .megamenu .widget .widgettitle:before,
    body .megamenu .widget .widgettitle:before,
    body .owl-controls .owl-prev:hover, 
    body .owl-controls .owl-next:hover,
    body .product-list li .quick-view a:hover,
    body .product-list li .quick-view a:hover,
    body .scroll_top:hover,
    body .cate-box .cate-link:hover,
    body #footer2.footer3 .mailchimp-wrapper .mailchimp-form .mailchimp-submit,
    body.woocommerce div.product form.cart .button,
    body.woocommerce .summary .yith-wcwl-add-to-wishlist .show a:hover:before,
    body.woocommerce .summary .compare:hover:before,
    body.woocommerce #respond input#submit:hover, 
    body.woocommerce a.button:hover, 
    body.woocommerce button.button:hover, 
    body.woocommerce input.button:hover,
    body .display-product-option li.selected span, 
    body .display-product-option li:hover span,
    body .nav-links a:hover, 
    body .nav-links .current,
    body .product-list.list .add-to-cart,
    body.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content,
    body .owl-controls .owl-dots .owl-dot.active,
    body .products-block .link-all,
    body .widget_kt_on_sale .product-list li .add-to-cart,
    body .woocommerce #respond input#submit.alt, 
    body .woocommerce a.button.alt, 
    body .woocommerce button.button.alt, 
    body .woocommerce input.button.alt,
    body .woocommerce #respond input#submit:hover, 
    body .woocommerce a.button:hover, 
    body .woocommerce button.button:hover, 
    body .woocommerce input.button:hover,
    body .woocommerce #respond input#submit.alt:hover, 
    body .woocommerce a.button.alt:hover, 
    body .woocommerce button.button.alt:hover, 
    body .woocommerce input.button.alt:hover,
    body .ui-selectmenu-menu .ui-state-hover, 
    body .ui-selectmenu-menu .ui-widget-content .ui-selectmenu-menu .ui-state-hover, 
    body .ui-selectmenu-menu .ui-widget-header, 
    body .ui-selectmenu-menu .ui-state-hover, 
    body .ui-selectmenu-menu .ui-state-focus, 
    body .ui-selectmenu-menu .ui-widget-content .ui-state-focus, 
    body .ui-selectmenu-menu .ui-widget-header .ui-state-focus,
    body .trending .trending-title,
    body .hot-deals-box .hot-deals-tab .hot-deals-title,
    body .block-popular-cat .more,
    body .block-popular-cat .sub-categories>ul>li>a:before,
    body .hot-deals-box .hot-deals-tab .box-count-down .box-count:before,
    body .products .group-tool-button a:hover, 
    body .products .group-tool-button a.compare:hover,
    body .option7 .products .group-tool-button a:hover, 
    body .option7 .products .group-tool-button a.compare:hover, 
    body .option7 .products .search:hover,
    body .woocommerce div.product form.cart .button{
        background-color: {$main_color};
    }

    body .box-vertical-megamenus .vertical-menu-content,
    body .popular-tabs .nav-tab li:hover, 
    body .popular-tabs .nav-tab li.active,
    body .latest-deals .latest-deal-content,
    body .brand-showcase .brand-showcase-title,
    body .group-title span,
    body #footer2.footer3,
    body .view-product-list .page-title span,
    body .page-heading span.page-heading-title,
    body .count-down-time2 .box-count,
    body  .option3 .main-header .header-search-box .form-inline{
        border-color: {$main_color};
    }
    body .product-list li .add-to-cart:hover{
        background-color: {$rgba_main_color}
    }
    body .product-list li .content_price,
    body.woocommerce div.product p.price,
    body.woocommerce div.product span.price,
    body .cart-block .cart-block-content .product-info .p-right .p-rice,
    .woocommerce div.product p.price, 
    .woocommerce div.product span.price,
    body .vertical-menu-list .mega-product .price{
        color: {$price_color}
    }
CSS;
    /* Vertical menu */
    $vm_bg_color = kt_option('vm_bg_color','#fff');
    $vm_text_color = kt_option('vm_text_color','#666');
    $vm_bg_hover_color = kt_option('vm_bg_hover_color','#ff3366');
    $vm_text_hover_color = kt_option('vm_text_hover_color','#fff');
    $css .= <<<CSS
    body .box-vertical-megamenus .vertical-menu-content{
        background-color: {$vm_bg_color};
    }
    body .box-vertical-megamenus .all-category span:hover{
        border-color: {$vm_bg_hover_color};
        color: {$vm_text_hover_color};
    }
    body .box-vertical-megamenus .vertical-menu-list>li:hover,
    body .box-vertical-megamenus .all-category span:hover{
        background-color: {$vm_bg_hover_color};
    }
    body .box-vertical-megamenus .vertical-menu-list>li>a{
        color: {$vm_text_color};
    }
    body .box-vertical-megamenus .vertical-menu-list>li:hover>a,
    body .box-vertical-megamenus .vertical-menu-list>li:hover>a:before{
        color: {$vm_text_hover_color}
    }
CSS;
    /* Header color */
    if( $kt_used_header == 1 ){
        $h1_topbar_bg = kt_option('h1_topbar_bg','#f6f6f6');
        $h1_mega_menu_bg = kt_option('h1_mega_menu_bg','#eee');
        $h1_box_category_bg = kt_option('h1_box_category_bg','#000');
        $h1_mege_menu_text_color = kt_option('h1_mege_menu_text_color','#000');
        $h1_mege_menu_text_hover_color = kt_option('h1_mege_menu_text_hover_color','#fff');
        $h1_item_mege_menu_bg_hover_color = kt_option('h1_item_mege_menu_bg_hover_color','#ff3366');
        $h1_topbar_text_color = kt_option('h1_topbar_text_color','#666');
        $h1_box_category_text_color = kt_option('h1_box_category_text_color','#fff');
        $h1_topbar_text_hover_color = kt_option('h1_topbar_text_hover_color','#ff3366');
        $h1_mega_menu_border = kt_option('h1_mega_menu_border','#cacaca');
        $css .= <<<CSS
        .header.style1 .top-header{
            background-color: {$h1_topbar_bg};
            color:{$h1_topbar_text_color};
        }
        .header.style1 .top-bar-menu>li>a{
            color: {$h1_topbar_text_color};
        }
        .header.style1 .top-bar-menu>li>a:hover{
            color: {$h1_topbar_text_hover_color};
        }
        .header.style1 .box-vertical-megamenus .title{
            background-color: {$h1_box_category_bg};
            color:{$h1_box_category_text_color};
        }
        .header.style1 .top-main-menu .main-menu-wapper{
            background-color: {$h1_mega_menu_bg};
        }
        .header.style1 .navigation-main-menu>li:hover>a, 
        .header.style1 .navigation-main-menu>li.active>a{
            color: {$h1_mege_menu_text_hover_color};
            border-color: transparent;
        }
        .header.style1 .navigation-main-menu>li:hover, 
        .header.style1 .navigation-main-menu>li.active{
            background-color: {$h1_item_mege_menu_bg_hover_color};
        }
        .header.style1 .navigation-main-menu>li>a{
            color: {$h1_mege_menu_text_color};
        }
        .header.style1 .navigation-main-menu>li>a{
            border-color: {$h1_mega_menu_border};
        }
        .header.style1 .nav-top-menu.nav-ontop{
            background-color: {$h1_mega_menu_bg};
        }
        
CSS;
    }
    /* HEADER STYLE 2*/
    if( $kt_used_header == 2){
        $h2_topbar_bg = kt_option('h2_topbar_bg','#f6f6f6');
        $h2_mega_menu_bg = kt_option('h2_mega_menu_bg','#958457');
        $h2_box_category_bg = kt_option('h2_box_category_bg','#4c311d');
        $h2_topbar_text_color = kt_option('h2_topbar_text_color','#666');
        $h2_mege_menu_text_color = kt_option('h2_mege_menu_text_color','#fff');
        $h2_box_category_text_color = kt_option('h2_box_category_text_color','#fff');
        $h2_topbar_text_hover_color = kt_option('h2_topbar_text_hover_color','#4c311d');
        $h2_mege_menu_text_hover_color = kt_option('h2_mege_menu_text_hover_color','#fff');
        $h2_item_mege_menu_bg_hover_color = kt_option('h2_item_mege_menu_bg_hover_color','#ab9d77');
    $css .= <<<CSS
    .header.style2 .top-header{
        background-color: {$h2_topbar_bg};
        color:{$h2_topbar_text_color};
    }
    .header.style2 .top-bar-menu>li>a{
        color:{$h2_topbar_text_color};
    }
    .header.style2 .top-bar-menu>li>a:hover{
        color:{$h2_topbar_text_hover_color};
    }
    .header.style2 .box-vertical-megamenus .title{
        background-color: {$h2_box_category_bg};
        color:{$h2_box_category_text_color};
    }
    body .top-main-menu.style2 .main-menu-wapper{
        background-color: {$h2_mega_menu_bg};
    }
    .header.style2 .top-main-menu.style2 .navigation-main-menu>li:hover, 
    .header.style2 .top-main-menu.style2 .navigation-main-menu>li.active{
        background-color: {$h2_item_mege_menu_bg_hover_color};
    }
    .header.style2 .top-main-menu.style2 .navigation-main-menu>li>a{
        color: {$h2_mege_menu_text_color};
    }
    .header.style2 .navigation-main-menu>li:hover>a, 
    .header.style2 .navigation-main-menu>li.active>a{
        color: {$h2_mege_menu_text_hover_color};
    }
    .header.style2 .nav-top-menu.nav-ontop{
        background-color: {$h2_mega_menu_bg};
    }

CSS;
    }
    if( $kt_used_header == 3 ){
        $h3_topbar_bg = kt_option('h3_topbar_bg','#f6f6f6');
        $h3_box_category_bg = kt_option('h3_box_category_bg','#0088cc');
        $h3_mega_menu_bg_ontop = kt_option('h3_mega_menu_bg_ontop','#0088cc');
        $h3_topbar_text_color = kt_option('h3_topbar_text_color','#666');
        $h3_mege_menu_text_color_ontop = kt_option('h3_mege_menu_text_color_ontop','#fff');
        $h3_box_category_text_color = kt_option('h3_box_category_text_color','#fff');
        $h3_topbar_text_hover_color = kt_option('h3_topbar_text_hover_color','#0088cc');
        $h3_mege_menu_text_hover_color = kt_option('h3_mege_menu_text_hover_color','#0088cc');
        $h3_mege_menu_hover_text_color_ontop = kt_option('h3_mege_menu_hover_text_color_ontop','#fff');
        $h3_item_mege_menu_bg_hover_color = kt_option('h3_item_mege_menu_bg_hover_color','#31a5df');

        $css .= <<<CSS
        .header.option3 .top-header{
            background-color: {$h3_topbar_bg};
            color:{$h3_topbar_text_color};
        }
        .header.option3 .top-bar-menu>li>a{
            color:{$h3_topbar_text_color};
        }
        .header.option3 .top-bar-menu>li>a:hover{
            color:{$h3_topbar_text_hover_color};
        }
        .header.option3 .box-vertical-megamenus .title{
            background-color: {$h3_box_category_bg};
            color:{$h3_box_category_text_color};
        }
        .header.option3 .nav-ontop{
            background-color: {$h3_mega_menu_bg_ontop};
        }
        .header.option3 .nav-top-menu.nav-ontop .top-main-menu.style3 .navigation-main-menu>li>a{
            color: {$h3_mege_menu_text_color_ontop};
        }
CSS;
    }
    if( $kt_used_header == 4 ){
        $h4_topbar_bg = kt_option('h4_topbar_bg','#f6f6f6');
        $h4_box_category_bg = kt_option('h4_box_category_bg','#0088cc');
        $h4_topbar_text_color = kt_option('h4_topbar_text_color','#666');
        $h4_mege_menu_text_color = kt_option('h4_mege_menu_text_color','#333');
        $h4_box_category_text_color = kt_option('h4_box_category_text_color','#fff');
        $h4_topbar_text_hover_color = kt_option('h4_topbar_text_hover_color','#0088cc');
        $h4_mege_menu_text_hover_color = kt_option('h4_mege_menu_text_hover_color','#0088cc');
        $css .=<<<CSS
        .header.option4 .top-header{
            background-color: {$h4_topbar_bg};
            color:{$h4_topbar_text_color};
        }
        .header.option4 .top-bar-menu>li>a{
            color:{$h4_topbar_text_color};
        }
        .header.option4 .top-bar-menu>li>a:hover{
            color:{$h4_topbar_text_hover_color};
        }
        .header.option4 .box-vertical-megamenus .title{
            background-color: {$h4_box_category_bg};
            color:{$h4_box_category_text_color};
        }
CSS;
    }
    if( $kt_used_header == 5 ){
        $h5_topbar_bg = kt_option('h5_topbar_bg','#f6f6f6');
        $h5_mega_menu_bg = kt_option('h5_mega_menu_bg','#eee');
        $h5_nav_mega_menu_bg = kt_option('h5_nav_mega_menu_bg','#f96d10');
        $h5_box_category_bg = kt_option('h5_box_category_bg','#e80000');
        $h5_topbar_text_color = kt_option('h5_topbar_text_color','#666');
        $h5_mege_menu_text_color = kt_option('h5_mege_menu_text_color','#fff');
        $h5_box_category_text_color = kt_option('h5_box_category_text_color','#fff');
        $h5_topbar_text_hover_color = kt_option('h5_topbar_text_hover_color','#f96d10');
        $h5_mege_menu_text_hover_color = kt_option('h5_mege_menu_text_hover_color','#fff');
        $h5_item_mege_menu_bg_hover_color = kt_option('h5_item_mege_menu_bg_hover_color','#e80000');
        $css .= <<<CSS
        .header.option5 .top-header{
            background-color: {$h5_topbar_bg};
            color:{$h5_topbar_text_color};
        }
        .header.option5 .top-bar-menu>li>a{
            color:{$h5_topbar_text_color};
        }
        .header.option5 .top-bar-menu>li>a:hover{
            color:{$h5_topbar_text_hover_color};
        }
        .header.option5 .box-vertical-megamenus .title{
            background-color: {$h5_box_category_bg};
            color:{$h5_box_category_text_color};
        }
        .header.option5 .top-main-menu .main-menu-wapper{
            background-color: {$h5_nav_mega_menu_bg};
        }
        .header.option5  .nav-top-menu{
            background-color: {$h5_mega_menu_bg};
        }
        .header.option5 .top-main-menu.style5 .navigation-main-menu>li:hover, 
        .header.option5 .top-main-menu.style5 .navigation-main-menu>li.active{
             background-color: {$h5_item_mege_menu_bg_hover_color};
        }
        .header.option5 .top-main-menu.style5 .navigation-main-menu>li>a{
            color: {$h5_mege_menu_text_color};
        }
        .header.option5 .top-main-menu.style5 .navigation-main-menu>li:hover>a, 
        .header.option5 .top-main-menu.style5 .navigation-main-menu>li.active>a{
            color: {$h5_mege_menu_text_hover_color};
        }
        .option5.header .nav-top-menu.nav-ontop{
            background-color: {$h5_nav_mega_menu_bg};
        }
CSS;
    }
    if( $kt_used_header == 6 ){
        $h6_topbar_bg = kt_option('h6_topbar_bg','#007176');
        $h6_mega_menu_bg = kt_option('h6_mega_menu_bg','#008a90');
        $h6_nav_mega_menu_bg = kt_option('h6_nav_mega_menu_bg','#007176');
        $h6_box_category_bg = kt_option('h6_box_category_bg','#000');
        $h6_search_box_bg = kt_option('h6_search_box_bg','#00abb3');
        $h6_topbar_text_color = kt_option('h6_topbar_text_color','#fff');
        $h6_mege_menu_text_color = kt_option('h6_mege_menu_text_color','#fff');
        $h6_box_category_text_color = kt_option('h6_box_category_text_color','#fff');
        $h6_topbar_text_hover_color = kt_option('h6_topbar_text_hover_color','#ccc');
        $h6_mege_menu_text_hover_color = kt_option('h6_mege_menu_text_hover_color','#fff');
        $h6_item_mege_menu_bg_hover_color = kt_option('h6_item_mege_menu_bg_hover_color','#00abb3');
        $h6_header_bg = kt_option('h6_header_bg','#008a90');
        $css .= <<<CSS
        .header.option6 .top-header{
            background-color: {$h6_topbar_bg};
            color:{$h6_topbar_text_color};
        }
        .header.option6 .top-bar-menu>li>a{
            color:{$h6_topbar_text_color};
        }
        .header.option6 .top-bar-menu>li>a:hover{
            color:{$h6_topbar_text_hover_color};
        }
        .header.option6 .box-vertical-megamenus .title{
            background-color: {$h6_box_category_bg};
            color:{$h6_box_category_text_color};
        }
        .header.option6 .top-main-menu .main-menu-wapper{
            background-color: {$h6_nav_mega_menu_bg};
        }
        .header.option6 .top-main-menu.style6 .navigation-main-menu>li:hover, 
        .header.option6 .top-main-menu.style6 .navigation-main-menu>li.active{
             background-color: {$h6_item_mege_menu_bg_hover_color};
        }
        .header.option6 .top-main-menu.style6 .navigation-main-menu>li>a{
            color: {$h6_mege_menu_text_color};
        }
        .header.option6 .top-main-menu.style6 .navigation-main-menu>li:hover>a, 
        .header.option6 .top-main-menu.style6 .navigation-main-menu>li.active>a{
            color: {$h6_mege_menu_text_hover_color};
        }
        body .option6.header{
            background-color: {$h6_header_bg};
        }
        .option6.header .main-header .header-search-box .form-inline,
        .option6.header .main-header .header-search-box .form-inline .form-category{
            background-color: {$h6_search_box_bg};
        }
        .option6.header .nav-top-menu.nav-ontop{
            background-color: {$h6_nav_mega_menu_bg};
        }
CSS;
    }
    if( $kt_used_header == 7 ){
        $h7_topbar_bg = kt_option('h7_topbar_bg','#cd2600');
        $h7_mega_menu_bg = kt_option('h7_mega_menu_bg','#e62e04');
        $h7_box_category_bg = kt_option('h7_box_category_bg','#434343');
        $h7_button_box_category_bg = kt_option('h7_button_box_category_bg','#2a2a2a');
        $h7_topbar_text_color = kt_option('h7_topbar_text_color','#fff');
        $h7_mege_menu_text_color = kt_option('h7_mege_menu_text_color','#fff');
        $h7_box_category_text_color = kt_option('h7_box_category_text_color','#fff');
        $h7_topbar_text_hover_color = kt_option('h7_topbar_text_hover_color','#ccc');
        $h7_mege_menu_text_hover_color = kt_option('h7_mege_menu_text_hover_color','#fff');
        $h7_item_mege_menu_bg_hover_color = kt_option('h7_item_mege_menu_bg_hover_color','#f04923');
        $h7_header_bg = kt_option('h7_header_bg','#e62e04');
        $css .= <<<CSS
        .header.style7 .top-header{
            background-color: {$h7_topbar_bg};
            color:{$h7_topbar_text_color};
        }
        .header.style7 .top-bar-menu>li>a{
            color:{$h7_topbar_text_color};
        }
        .header.style7 .top-bar-menu>li>a:hover{
            color:{$h7_topbar_text_hover_color};
        }
        .header.style7 .box-vertical-megamenus .title{
            background-color: {$h7_box_category_bg};
            color:{$h7_box_category_text_color};
        }
        body .header.style7 .main-header{
            background-color: {$h7_header_bg};
        }
        body .main-menu-style7.main-menu-wapper{
            background-color: {$h7_mega_menu_bg};
        }
        body .main-menu-style7 .navigation-main-menu>li>a{
            color: {$h7_mege_menu_text_color};
        }
        body .main-menu-style7 .navigation-main-menu>li:hover, 
        body .main-menu-style7 .navigation-main-menu>li.active{
            background-color: {$h7_item_mege_menu_bg_hover_color};
        }
        body .main-menu-style7 .navigation-main-menu>li:hover>a,
        body .main-menu-style7 .navigation-main-menu>li.active>a{
            color: {$h7_mege_menu_text_hover_color};
        }
        body .option7 .box-vertical-megamenus .title .btn-open-mobile{
            background-color: {$h7_button_box_category_bg};
        }

CSS;
    }
    ?>
    <style id="kt-theme-color" type="text/css">
        <?php echo apply_filters( 'kt_customize_css', $css );?>
    </style>
    <?php
}
add_action( 'wp_enqueue_scripts', 'kt_themne_color',100 );
    

