<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$args['attributes']['data-product_id'] =  Page_code("sku" . $args['attributes']['data-product_id'], "en");
$args['class'] = "button product_type_simple add_to_cart_button ajax_add_to_cart add_to_cart_max";
$url = explode("detail/", get_permalink( $post ))[1];
echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<div class="add-cart" title="%s" ><a data-price="%s" data-slug="%s" data-title="%s" data-image="%s" data-ajax="true" data-quantity="%s" class="%s" %s><span class="diza-cart"></span></a></div>',
		esc_attr( $product->add_to_cart_text() ),
        esc_attr($product->get_usd_price()),
        esc_attr($url),
        esc_attr($product->get_title()),
        esc_attr($product->image_id),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'add_to_cart_button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
	),
$product );
?>
