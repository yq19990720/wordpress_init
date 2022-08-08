<?php

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Diza 1.0
 */
define( 'DIZA_THEME_VERSION', '1.0' );

/**
 * ------------------------------------------------------------------------------------------------
 * Define constants.
 * ------------------------------------------------------------------------------------------------
 */
define( 'DIZA_THEME_DIR', 		get_template_directory_uri() );
define( 'DIZA_THEMEROOT', 		get_template_directory() );
define( 'DIZA_IMAGES', 			DIZA_THEME_DIR . '/images' );
define( 'DIZA_SCRIPTS', 		DIZA_THEME_DIR . '/js' );

define( 'DIZA_SCRIPTS_SKINS', 	DIZA_SCRIPTS . '/skins' );
define( 'DIZA_STYLES', 			DIZA_THEME_DIR . '/css' );
define( 'DIZA_STYLES_SKINS', 	DIZA_STYLES . '/skins' );

define( 'DIZA_INC', 				     'inc' );
define( 'DIZA_MERLIN', 				DIZA_INC . '/merlin' );
define( 'DIZA_CLASSES', 			     DIZA_INC . '/classes' );
define( 'DIZA_VENDORS', 			     DIZA_INC . '/vendors' );
define( 'DIZA_ELEMENTOR', 		         DIZA_THEMEROOT . '/inc/vendors/elementor' );
define( 'DIZA_ELEMENTOR_TEMPLATES',     DIZA_THEMEROOT . '/elementor_templates' );
define( 'DIZA_PAGE_TEMPLATES',          DIZA_THEMEROOT . '/page-templates' );
define( 'DIZA_WIDGETS', 			     DIZA_INC . '/widgets' );

define( 'DIZA_ASSETS', 			         DIZA_THEME_DIR . '/inc/assets' );
define( 'DIZA_ASSETS_IMAGES', 	         DIZA_ASSETS    . '/images' );

define( 'DIZA_MIN_JS', 	'' );

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

function diza_tbay_get_config($name, $default = '') {
	global $diza_options;
    if ( isset($diza_options[$name]) ) {
        return $diza_options[$name];
    }
    return $default;
}

function diza_tbay_get_global_config($name, $default = '') {
	$options = get_option( 'diza_tbay_theme_options', array() );
	if ( isset($options[$name]) ) {
        return $options[$name];
    }
    return $default;
}
