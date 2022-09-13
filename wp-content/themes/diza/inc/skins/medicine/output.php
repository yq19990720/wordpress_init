<?php if ( ! defined('DIZA_THEME_DIR')) exit('No direct script access allowed');

$theme_primary = require_once( get_parent_theme_file_path( DIZA_INC . '/class-primary-color.php') );
$theme_second  = require_once( get_parent_theme_file_path( DIZA_INC . '/class-second-color.php') );


$main_color_skin 	= '.has-after:hover,button.btn-close:hover,.new-input + span:before,.new-input + label:before,.heading-tbay-title .title .title-child i,body .singular-shop div.product .tbay-wishlist a:hover,body .singular-shop div.product .tbay-compare a:hover,.product-block div.button-wishlist .yith-wcwl-wishlistexistsbrowse a i,.product-block div.button-wishlist .yith-wcwl-wishlistaddedbrowse a i';  
$main_bg_skin 		= '.has-after:after , .btn-theme,.new-input:checked + span:before,.new-input:checked + label:before,.heading-tbay-title .title .title-child i:after';
$main_border_skin 	= '.new-input:checked + span:before,.new-input:checked + label:before';

$main_font 						= $theme_primary['main_font']; 
$main_second_font 				= $theme_primary['main_second_font']; 
$main_color 					= $theme_primary['color']; 
$main_bg 						= $theme_primary['background'];
$main_border 					= $theme_primary['border'];
$main_top_border 				= $theme_primary['border-top-color'];
$main_right_border 				= $theme_primary['border-right-color'];
$main_bottom_border 			= $theme_primary['border-bottom-color'];
$main_left_border 				= $theme_primary['border-left-color'];

$main_second_color 				= $theme_second['color']; 
$main_second_bg 				= $theme_second['background'];
$main_second_border 			= $theme_second['border'];
$main_second_top_border 		= $theme_second['border-top-color'];
$main_second_right_border 		= $theme_second['border-right-color'];
$main_second_bottom_border 		= $theme_second['border-bottom-color'];
$main_second_left_border 		= $theme_second['border-left-color'];

// Table
$tablet_color_second 	 		= $theme_second['tablet_color'];
$tablet_background_second 		= $theme_second['tablet_background'];
$tablet_border_second 			= $theme_second['tablet_border'];
/*Mobile*/
$mobile_color_second			= $theme_second['mobile_color'];
$mobile_background_second 		= $theme_second['mobile_background'];
$mobile_border_second 			= $theme_second['mobile_border'];


if( !empty($main_color_skin) ) {
	$main_color 	= $main_color . ',' . $main_color_skin; 
}
if( !empty($main_bg_skin) ) {
	$main_bg 	= $main_bg. ',' .$main_bg_skin; 
}
if( !empty($main_border_skin) ) {
	$main_border 	= $main_border. ',' .$main_border_skin; 
}
if( !empty($main_border_top_skin) ) {
	$main_top_border 	= $main_top_border. ',' .$main_border_top_skin; 
}

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

$output = array();

/*CustomMain color*/
$output['main_color'] = array( 
	'color' => diza_texttrim($main_color),
	'background-color' => diza_texttrim($main_bg),
	'border-color' => diza_texttrim($main_border),
);
if( !empty($main_top_border) ) {

	$bordertop = array(
		'border-top-color' => diza_texttrim($main_top_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$bordertop);
}
if( !empty($main_right_border) ) {
	
	$borderright = array(
		'border-right-color' => diza_texttrim($main_right_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$borderright);
}
if( !empty($main_bottom_border) ) {
	
	$borderbottom = array(
		'border-bottom-color' => diza_texttrim($main_bottom_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$borderbottom);
}
if( !empty($main_left_border) ) {
	
	$borderleft = array(
		'border-left-color' => diza_texttrim($main_left_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$borderleft);
}

/*Custom Sencond color*/
$output['main_color_second'] = array( 
	'color' => diza_texttrim($main_second_color),
	'background-color' => diza_texttrim($main_second_bg),
	'border-color' => diza_texttrim($main_second_border),
);
if( !empty($main_second_top_border) ) {

	$border_second_top = array(
		'border-top-color' => diza_texttrim($main_second_top_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$border_second_top);
}
if( !empty($main_second_right_border) ) {
	
	$border_second_right = array(
		'border-right-color' => diza_texttrim($main_second_right_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$border_second_right);
}
if( !empty($main_second_bottom_border) ) {
	
	$border_second_bottom = array(
		'border-bottom-color' => diza_texttrim($main_second_bottom_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$border_second_bottom);
}
if( !empty($main_second_left_border) ) {
	
	$border_second_left = array(
		'border-left-color' => diza_texttrim($main_second_left_border),
	);

	$output['main_color'] = array_merge($output['main_color'],$border_second_left);
}

/*Tablet*/
$output['tablet_second'] = array( 
	'color' => diza_texttrim($tablet_color_second),
	'background-color' => diza_texttrim($tablet_background_second),
	'border-color' => diza_texttrim($tablet_border_second),
);

/** Mobile */
$output['mobile_second'] = array( 
	'color' => diza_texttrim($mobile_color_second),
	'background-color' => diza_texttrim($mobile_background_second),
	'border-color' => diza_texttrim($mobile_border_second),
);

/** End Color second */

/*Custom Fonts*/
$output['primary-font'] 	= $main_font;
$output['secondary-font'] 	= $main_second_font. ', .btn-theme';

/*Background hover*/
$output['background_hover']  	= $theme_primary['background_hover'];
/*Tablet*/
$output['tablet_color'] 	 	= $theme_primary['tablet_color'];
$output['tablet_background'] 	= $theme_primary['tablet_background'];
$output['tablet_border'] 		= $theme_primary['tablet_border'];
/*Mobile*/
$output['mobile_color'] 		= $theme_primary['mobile_color'];
$output['mobile_background'] 	= $theme_primary['mobile_background'];
$output['mobile_border'] 		= $theme_primary['mobile_border'];

/*Header Mobile*/
$output['header_mobile_bg'] = array( 
	'background-color' => diza_texttrim('.topbar-device-mobile')
);
$output['header_mobile_color'] = array( 
	'color' => diza_texttrim('.topbar-device-mobile i, .topbar-device-mobile.active-home-icon .topbar-title')
);

return apply_filters( 'diza_get_output', $output);
