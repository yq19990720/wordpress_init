<?php if ( ! defined('DIZA_THEME_DIR')) exit('No direct script access allowed');
/**
 * Diza woocommerce Template Hooks
 *
 * Action/filter hooks used for Diza woocommerce functions/templates.
 *
 */


/**
 * Diza Header Mobile Content.
 *
 * @see diza_the_button_mobile_menu()
 * @see diza_the_logo_mobile()
 * @see diza_top_header_mobile()
 */
add_action( 'diza_header_mobile_content', 'diza_the_button_mobile_menu', 5 );
add_action( 'diza_header_mobile_content', 'diza_the_icon_home_page_mobile', 10 );
add_action( 'diza_header_mobile_content', 'diza_the_logo_mobile', 15 );
add_action( 'diza_header_mobile_content', 'diza_the_icon_mini_cart_header_mobile', 20 );
add_action( 'diza_header_mobile_content', 'diza_top_header_mobile', 25 );


/**
 * Diza Header Mobile before content
 *
 * @see diza_the_hook_header_mobile_all_page
 */
add_action( 'diza_before_header_mobile', 'diza_the_hook_header_mobile_all_page', 5 );
add_action( 'diza_before_header_mobile', 'diza_the_hook_header_mobile_menu_all_page', 10 );