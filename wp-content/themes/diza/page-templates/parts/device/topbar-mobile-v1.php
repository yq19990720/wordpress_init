<?php   
	$class_top_bar 	=  '';

	$always_display_logo 			= diza_tbay_get_config('always_display_logo', false);
	if( !$always_display_logo && !diza_catalog_mode_active() && defined('DIZA_WOOCOMMERCE_ACTIVED') && (is_product() || is_cart() || is_checkout()) ) {
		$class_top_bar .= ' active-home-icon';
	}
?>
<div class="topbar-device-mobile d-xl-none clearfix <?php echo esc_attr( $class_top_bar ); ?>">

	<?php
		/**
		* diza_before_header_mobile hook
		*/
		do_action( 'diza_before_header_mobile' );

		/**
		* Hook: diza_header_mobile_content.
		*
		* @hooked diza_the_button_mobile_menu - 5
		* @hooked diza_the_logo_mobile - 10
		* @hooked diza_the_title_page_mobile - 10
		* @hooked diza_top_header_mobile - 15
		*/

		do_action( 'diza_header_mobile_content' );

		/**
		* diza_after_header_mobile hook
		*/
		do_action( 'diza_after_header_mobile' );
	?>
</div>