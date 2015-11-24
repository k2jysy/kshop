<?php
/*
Plugin Name: 商品双币显示
Plugin URI: www.i-dev.cc
Description: 这个插件用于解决海淘代购过程中商品双币种显示，管理员还可以自己设定汇率。
Author: 思远工作室
Version: 1.0
Author URI: www.i-dev.cc
*/


add_action('admin_notices', 'brijesh_additional_currency_admin_notices');
function brijesh_additional_currency_admin_notices() {

    if (!is_plugin_active('woocommerce/woocommerce.php')) {

        echo '<div id="notice" class="error"><p>';
        echo '<b>' . __('Woocommerce Additional Currency', 'woocommerce-display-additional-currency') . '</b> ' . __('add-on requires', 'woocommerce-display-additional-currency') . ' ' . '<a href="http://www.woothemes.com/woocommerce/" target="_new">' . __('WooCommerce', 'woocommerce-display-additional-currency') . '</a>' . ' ' . __('plugin. Please install and activate it.', 'woocommerce-display-additional-currency');
        echo '</p></div>', "\n";

    }
}	// End brijesh_additional_currency_admin_notices()

// create custom plugin settings menu
add_action('admin_menu', 'woo_display_additional_currency');


function woo_display_additional_currency() {

	//create new top-level menu
	add_menu_page('汇率调整', '汇率调整', 'administrator', __FILE__, 'brijesh_currency_settings_page',plugins_url('/images/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'brijesh_additional_currency', 'brijesh_currency_symbol' );
	register_setting( 'brijesh_additional_currency', 'brijesh_exchange_rate' );
	
}

function brijesh_currency_settings_page() {
?>
<div class="wrap">
<h2>多币种价格显示</h2>
思远工作室

<form method="post" action="options.php">
    <?php settings_fields( 'brijesh_additional_currency' ); ?>
    <?php do_settings_sections( 'brijesh_additional_currency' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">货币符号</th>
        <td><input type="text" name="brijesh_currency_symbol" value="<?php echo esc_attr( get_option('brijesh_currency_symbol') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">汇率</th>
        <td><input type="text" name="brijesh_exchange_rate" value="<?php echo esc_attr( get_option('brijesh_exchange_rate') ); ?>" /></td>
        </tr>
        
        
    </table>
    
    <?php submit_button(); ?>
	

</form>


</div>
<?php
}
add_filter( 'woocommerce_get_price_html', 'custom_price_html', 100, 2 );


function custom_price_html( $price, $product ){

	$exchangerate = (float)get_option('brijesh_exchange_rate');

    $_new_price = $product->price * $exchangerate;
	$_new_price = number_format((float)$_new_price, 2, '.', '');
    $price = $price . '<br>'.get_option('brijesh_currency_symbol') ." " . $_new_price;

    

    return apply_filters( 'woocommerce_get_price', $price );
}
?>