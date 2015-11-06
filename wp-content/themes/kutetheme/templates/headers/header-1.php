<?php
/**
 * The template Header
 *
 *
 * @author 		KuteTheme
 * @package 	THEME/WooCommerce
 * @version     KuteTheme 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<!-- HEADER -->
<div id="header" class="header">
    <div class="top-header">
        <div class="container">
            <?php echo kt_get_hotline(); ?>
            <?php echo kt_get_wpml(); ?>
            
            <div class="support-link">
                <a href="<?php kt_service_link(); ?>"><?php esc_html_e( 'Services', 'kutetheme' ) ?></a>
                <a href="<?php kt_support_link(); ?>"><?php esc_html_e( 'Support', 'kutetheme' ) ?></a>
            </div>
            <?php echo kt_menu_my_account(); ?>
        </div>
    </div>
    <!--/.top-header -->
    <!-- MAIN HEADER -->
    <div class="container main-header">
        <div class="row">
            <div class="col-xs-12 col-sm-3 logo">
                <?php echo kt_get_logo(); ?>
            </div>
            <div class="header-search-box <?php echo kt_is_wc() ? 'col-xs-7 col-sm-7' : 'col-xs-9'; ?>">
                <?php kt_search_form();  ?>
            </div>
            <?php 
                if( kt_is_wc() ): 
                    do_action('kt_mini_cart');
                endif; 
             ?>
        </div>
    </div>
    <!-- END MANIN HEADER -->
    <div id="nav-top-menu" class="nav-top-menu">
        <div class="container">
            <?php do_action( 'kt_show_menu_option_1' ); ?>
            <!-- userinfo on top-->
            <div id="form-search-opntop">
            </div>
            <!-- userinfo on top-->
            <div id="user-info-opntop">
            </div>
            <?php if( kt_is_wc() ):  ?>
            <!-- CART ICON ON MMENU -->
            <div id="shopping-cart-box-ontop">
                <i class="fa fa-shopping-cart"></i>
                <div class="shopping-cart-box-ontop-content">
                
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
    <div class="container">
        <div class="divider main-bg"></div>
    </div>
</div>
<!-- end header -->