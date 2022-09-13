<?php

// Remove default breadcrumb
add_filter( 'woocommerce_breadcrumb_defaults', 'diza_tbay_woocommerce_breadcrumb_defaults' );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'diza_woo_template_main_before', 'woocommerce_breadcrumb', 20 ); 


remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

/**
 * Product Rating
 *
 * @see diza_woocommerce_loop_item_rating()
 */

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
add_action( 'diza_woocommerce_loop_item_rating', 'woocommerce_template_loop_rating', 10 );

//Change postition label sale
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

// Remove Default Sidebars
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 ); 



/**
 * Product Add to cart.
 *
 * @see woocommerce_template_single_add_to_cart()
 * @see woocommerce_simple_add_to_cart()
 * @see woocommerce_grouped_add_to_cart()
 * @see woocommerce_variable_add_to_cart()
 * @see woocommerce_external_add_to_cart()
 * @see woocommerce_single_variation()
 * @see woocommerce_single_variation_add_to_cart_button()
 */
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
add_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
add_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
add_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );



remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

/**
 * Product Vertical
 *
 * @see woocommerce_after_shop_loop_item_vertical_title()
 */

add_action( 'woocommerce_after_shop_loop_item_vertical_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_after_shop_loop_item_vertical_title', 'woocommerce_template_loop_rating', 15 );


/**
 * Product List
 *
 */

add_action( 'diza_woo_list_caption_left', 'woocommerce_template_loop_rating', 5 );
add_action( 'diza_woo_list_caption_right', 'woocommerce_template_loop_price', 5 );

// share box
if ( !function_exists('diza_tbay_woocommerce_share_box') ) {
    function diza_tbay_woocommerce_share_box() {

        if( wp_is_mobile() ) return;

        if ( diza_tbay_get_config('enable_code_share',false)  && diza_tbay_get_config('enable_product_social_share', false) ) {
            ?>
              <div class="tbay-woo-share">
                <div class="addthis_inline_share_toolbox"></div>
              </div>
            <?php
        }
    }
    add_filter( 'woocommerce_single_product_summary', 'diza_tbay_woocommerce_share_box', 50 );
}