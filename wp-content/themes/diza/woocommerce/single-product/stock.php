<?php
/**
 * Single Product stock.
 *
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<p class="stock <?php echo esc_attr( $class ); ?> " ><?php echo wp_kses_post( $availability ); ?><span class="diza-stock" style="margin: 10px 0;font-size: 15px;color: #21ab0b;font-weight: normal"></span></p>
