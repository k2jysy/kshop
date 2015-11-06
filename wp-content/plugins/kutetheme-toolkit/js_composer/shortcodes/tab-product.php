<?php
/**
 * @author  AngelsIT
 * @package KUTE TOOLKIT
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class WPBakeryShortCode_Tab_Producs extends WPBakeryShortCode {

    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'tab_producs', $atts ) : $atts;
        $atts = shortcode_atts( array(
            'taxonomy'       => '',
            'per_page'       => 12,
            'columns'        => 4,
            'border_heading' => '',
            'css_animation'  => '',
            'el_class'       => '',
            'css'            => '',   
            
            //Carousel            
            'autoplay'       => 'false', 
            'navigation'     => 'false',
            'margin'         => 30,
            'slidespeed'     => 200,
            'css'            => '',
            'el_class'       => '',
            'nav'            => 'true',
            'loop'           => 'false',
            //Default
            'use_responsive' => 1,
            'items_destop'   => 3,
            'items_tablet'   => 2,
            'items_mobile'   => 1,
            
        ), $atts );
        extract($atts);

        global $woocommerce_loop;
        
        $elementClass = array(
            'base'             => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'popular-tabs ', $this->settings['base'], $atts ),
            'extra'            => $this->getExtraClass( $el_class ),
            'css_animation'    => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $elementClass = apply_filters( 'kt_product_tab_class_container', $elementClass );
        
        $tabs = array(
            'best-sellers' => __( 'Best Sellers', 'kutetheme' ),
            'on-sales'     => __( 'On Sales', 'kutetheme' ),
            'new-arrivals' => __( 'New Products', 'kutetheme' )
        );
        
        $meta_query = WC()->query->get_meta_query();
        $args = array(
			'post_type'				=> 'product',
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' 		=> $per_page,
			'meta_query' 			=> $meta_query,
            'suppress_filter'       => true,
		);
        
        if( $taxonomy ){
            $args['tax_query'] = 
                array(
            		array(
            			'taxonomy' => 'product_cat',
            			'field' => 'id',
            			'terms' => explode( ",", $taxonomy )
            	)
            );
        }
        $uniqeID = uniqid();
        ob_start();
        ?>
        <div class="<?php echo esc_attr( $elementClass ); ?> container-tab">
            <ul class="nav-tab">
                <?php $i = 0; ?>
                <?php foreach( $tabs as $k => $v ): ?>
                    <li <?php echo ( $i == 0 ) ? 'class="active"': '' ?> >
                        <a data-toggle="tab" href="#tab-<?php echo esc_attr( $k ) . $uniqeID  ?>"><?php echo esc_html( $v ); ?></a>
                    </li>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </ul>
            <div class="tab-container">
                <?php $i = 0; ?>
                <?php foreach( $tabs as $k => $v ): ?>
                    <?php 
                    $newargs = $args;
                    
                    if( $k == 'best-sellers' ){
                        $newargs['meta_key'] = 'total_sales';
                        $newargs['orderby']  = 'meta_value_num';
                    }elseif( $k == 'on-sales' ){
                        $product_ids_on_sale = wc_get_product_ids_on_sale();
                        
                        $newargs['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
                        
                        $newargs['orderby']  = 'date';
                        $newargs['order'] 	 = 'DESC';
                    }else{
                        $newargs['orderby']  = 'date';
                        $newargs['order'] 	 = 'DESC';
                    }
                     
                    $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $newargs, $atts ) );
                    
                    if ( $products->have_posts() ) :
                    
                    $data_carousel = array(
                        "autoplay"           => $autoplay,
                        "navigation"         => $navigation,
                        "margin"             => $margin,
                        "slidespeed"         => $slidespeed,
                        "theme"              => 'style-navigation-bottom',
                        "autoheight"         => 'false',
                        'nav'                => 'true',
                        'dots'               => 'false',
                        'loop'               => $loop,
                        'autoplayTimeout'    => 1000,
                        'autoplayHoverPause' => 'true'
                    );
                    if( $use_responsive){
                        $arr = array(
                            '0' => array(
                                "items" => $items_mobile
                            ), 
                            '768' => array(
                                "items" => $items_tablet
                            ), 
                            '992' => array(
                                "items" => $items_destop
                            )
                        );
                        $data_responsive = json_encode($arr);
                        $data_carousel["responsive"] = $data_responsive;
                    }else{
                        $data_carousel['items'] =  3;
                    }
                    //add_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size' ) );
                    ?>
                    <div id="tab-<?php echo esc_attr( $k ) . $uniqeID  ?>" class="tab-panel <?php echo ( $i == 0 ) ? 'active': '' ?>">
                        <ul class="product-list owl-carousel" <?php echo _data_carousel( $data_carousel ); ?>>
                            <?php while( $products->have_posts() ): $products->the_post(); ?>
                                <?php wc_get_template_part( 'content', 'product-tab' ); ?>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    <?php 
                    //remove_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size' ) );
                    endif; 
                    ?>
                    <?php 
                        wp_reset_query();
                        wp_reset_postdata();
                        $i++; 
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}



vc_map( array(
    "name"        => __( "Tab Products", 'kutetheme'),
    "base"        => "tab_producs",
    "category"    => __('Kute Theme', 'kutetheme' ),
    "description" => __( 'Show product in tab best sellers, on sales, new products on option 1', 'js_composer' ),
    "params"      => array(
        array(
            "type"        => "kt_taxonomy",
            "taxonomy"    => "product_cat",
            "class"       => "",
            "heading"     => __("Category", 'kutetheme'),
            "param_name"  => "taxonomy",
            "value"       => '',
            'parent'      => '',
            'multiple'    => true,
            'hide_empty'  => false,
            'placeholder' => __('Choose categoy', 'kutetheme'),
            "description" => __("Note: If you want to narrow output, select category(s) above. Only selected categories will be displayed.", 'kutetheme')
        ),
        array(
            'type'        => 'textfield',
            'heading'     => __( 'Per page', 'js_composer' ),
            'value'       => 12,
            'param_name'  => 'per_page',
            'description' => __( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' ),
            'admin_label' => false,
		),
        array(
            'type'        => 'textfield',
            'heading'     => __( 'Columns', 'js_composer' ),
            'value'       => 4,
            'param_name'  => 'columns',
            'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
            'admin_label' => false,
		),
        
        array(
            'type'        => 'dropdown',
            'heading'     => __( 'CSS Animation', 'js_composer' ),
            'param_name'  => 'css_animation',
            'admin_label' => false,
            'value'       => array(
                __( 'No', 'js_composer' )                 => '',
                __( 'Top to bottom', 'js_composer' )      => 'top-to-bottom',
                __( 'Bottom to top', 'js_composer' )      => 'bottom-to-top',
                __( 'Left to right', 'js_composer' )      => 'left-to-right',
                __( 'Right to left', 'js_composer' )      => 'right-to-left',
                __( 'Appear from center', 'js_composer' ) => "appear"
        	),
        	'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
        ),
        array(
            "type"        => "textfield",
            "heading"     => __( "Extra class name", "js_composer" ),
            "param_name"  => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
            'admin_label' => false,
        ),
        
        // Carousel
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 'true',
                __( 'No', 'js_composer' )  => 'false'
            ),
            'std'         => 'false',
            'heading'     => __( 'AutoPlay', 'kutetheme' ),
            'param_name'  => 'autoplay',
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false
		),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 'true',
                __( 'No', 'js_composer' )  => 'false'
            ),
            'std'         => 'false',
            'heading'     => __( 'Navigation', 'kutetheme' ),
            'param_name'  => 'navigation',
            'description' => __( "Show buton 'next' and 'prev' buttons.", 'kutetheme' ),
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
		),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 'true',
                __( 'No', 'js_composer' )  => 'false'
            ),
            'std'         => 'false',
            'heading'     => __( 'Loop', 'kutetheme' ),
            'param_name'  => 'loop',
            'description' => __( "Inifnity loop. Duplicate last and first items to get loop illusion.", 'kutetheme' ),
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
		),
        array(
            "type"        => "kt_number",
            "heading"     => __("Slide Speed", 'kutetheme'),
            "param_name"  => "slidespeed",
            "value"       => "200",
            "suffix"      => __("milliseconds", 'kutetheme'),
            "description" => __('Slide speed in milliseconds', 'kutetheme'),
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
            "type"        => "kt_number",
            "heading"     => __("Margin", 'kutetheme'),
            "param_name"  => "margin",
            "value"       => "30",
            "suffix"      => __("px", 'kutetheme'),
            "description" => __('Distance( or space) between 2 item', 'kutetheme'),
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 1,
                __( 'No', 'js_composer' )  => 0
            ),
            'std'         => 1,
            'heading'     => __( 'Use Carousel Responsive', 'kutetheme' ),
            'param_name'  => 'use_responsive',
            'description' => __( "Try changing your browser width to see what happens with Items and Navigations", 'kutetheme' ),
            'group'       => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
		),
        array(
            "type"        => "kt_number",
            "heading"     => __("The items on destop (Screen resolution of device >= 992px )", 'kutetheme'),
            "param_name"  => "items_destop",
            "value"       => "3",
            "suffix"      => __("item", 'kutetheme'),
            "description" => __('The number of items on destop', 'kutetheme'),
            'group'       => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
            "type"        => "kt_number",
            "heading"     => __("The items on tablet (Screen resolution of device >=768px and < 992px )", 'kutetheme'),
            "param_name"  => "items_tablet",
            "value"       => "2",
            "suffix"      => __("item", 'kutetheme'),
            "description" => __('The number of items on destop', 'kutetheme'),
            'group'       => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
            "type"        => "kt_number",
            "heading"     => __("The items on mobile (Screen resolution of device < 768px)", 'kutetheme'),
            "param_name"  => "items_mobile",
            "value"       => "1",
            "suffix"      => __("item", 'kutetheme'),
            "description" => __('The numbers of item on destop', 'kutetheme'),
            'group'       => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
            'type'           => 'css_editor',
            'heading'        => __( 'Css', 'js_composer' ),
            'param_name'     => 'css',
            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group'          => __( 'Design options', 'js_composer' ),
            'admin_label'    => false,
		),
    ),
));