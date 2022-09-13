<?php 

if ( !function_exists('diza_tbay_private_size_image_setup') ) {
	function diza_tbay_private_size_image_setup() {
		if( diza_tbay_get_global_config('config_media',false) ) return;

		// Post Thumbnails Size
		set_post_thumbnail_size(370	, 220, true); // Unlimited height, soft crop
		update_option('thumbnail_size_w', 444);
		update_option('thumbnail_size_h', 533);						

		update_option('medium_size_w', 570);
		update_option('medium_size_h', 339);

		update_option('large_size_w', 770);
		update_option('large_size_h', 458);

	}
	add_action( 'after_setup_theme', 'diza_tbay_private_size_image_setup' );
}
