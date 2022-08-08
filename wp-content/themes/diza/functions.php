<?php
/**
 * diza functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Diza
 * @since Diza 1.0
 */


require get_theme_file_path('inc/function-global.php');

/*Start Class Main*/
require get_theme_file_path('inc/classes/class-main.php');

/*
 Include Required Plugins
*/
require get_theme_file_path('inc/function-plugins.php');


require_once( get_parent_theme_file_path( DIZA_INC . '/classes/class-tgm-plugin-activation.php') );

/**Include Merlin Import Demo**/
require_once( get_parent_theme_file_path( DIZA_MERLIN . '/vendor/autoload.php') );
require_once( get_parent_theme_file_path( DIZA_MERLIN . '/class-merlin.php') );
require_once( get_parent_theme_file_path( DIZA_INC . '/merlin-config.php') );

require_once( get_parent_theme_file_path( DIZA_INC . '/functions-helper.php') );
require_once( get_parent_theme_file_path( DIZA_INC . '/functions-frontend.php') );
require_once( get_parent_theme_file_path( DIZA_INC . '/functions-mobile.php') );

require_once( get_parent_theme_file_path( DIZA_INC . '/skins/'.diza_tbay_get_theme().'/functions.php') );

/**
 * Customizer
 *
 */
require_once( get_parent_theme_file_path( DIZA_INC . '/customizer/custom-header.php') );
require_once( get_parent_theme_file_path( DIZA_INC . '/skins/'.diza_tbay_get_theme() . '/customizer.php') );
require_once( get_parent_theme_file_path( DIZA_INC . '/customizer/custom-styles.php') );
/**
 * Classess file
 *
 */

/**
 * Implement the Custom Styles feature.
 *
 */


require_once( get_parent_theme_file_path( DIZA_CLASSES . '/megamenu.php') );
require_once( get_parent_theme_file_path( DIZA_CLASSES . '/custommenu.php') );
require_once( get_parent_theme_file_path( DIZA_CLASSES . '/mmenu.php') );

/**
 * Custom template tags for this theme.
 *
 */

require_once( get_parent_theme_file_path( DIZA_INC . '/template-tags.php') );
require_once( get_parent_theme_file_path( DIZA_INC . '/template-hooks.php') );

if ( diza_is_cmb2() ) {
	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/cmb2/page.php') );
	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/cmb2/post.php') );
}

if ( class_exists( 'WooCommerce' ) ) {
	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/woocommerce/wc-admin.php') );

	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/woocommerce/classes/class-wc.php') );

	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/woocommerce/wc-template-functions.php') );
	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/woocommerce/wc-template-hooks.php') );


	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/woocommerce/wc-recently-viewed.php') );
	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/woocommerce/wc-ajax-auth.php') );

	/*compatible*/
	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/woocommerce/compatible/wc-germanized.php') );
}


if( defined('TBAY_ELEMENTOR_ACTIVED') ) {
	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/custom_menu.php') );
	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/list-categories.php') );
	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/popular_posts.php') );

	if ( function_exists( 'mc4wp_show_form' ) ) {
		require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/popup_newsletter.php') );
	}

	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/posts.php') );
	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/recent_comment.php') );
	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/recent_post.php') );
	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/single_image.php') );
	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/banner_image.php') );
	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/socials.php') );
	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/top_rate.php') );
	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/video.php') );
	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/woo-carousel.php') );
	require_once( get_parent_theme_file_path( DIZA_WIDGETS . '/yith-brand-image.php') );

	/*Redux FrameWork*/
	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/redux-framework/class-redux.php') );
	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/redux-framework/redux-config.php') );
}

if( diza_is_elementor_activated() ) {
	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/elementor/class-elementor.php') );
	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/elementor/class-elementor-pro.php') );
	require_once( get_parent_theme_file_path( DIZA_VENDORS . '/elementor/icons/icons.php') );
}

//首页轮播图url
$image_url = getCombination(getImages(),2);

$category_id = null;

$detail_url = null;

$list_search = null;

$list_page = null;

$subarr = null;

//全局产品详情
$ebay_product_detail = null;

//全局结构化数据
$jsonld = null;

$price = null;

$product_total = null;

$fragment_price = null;

$fragment_total = null;

$setting_map = [];

//设置手动更新一级分类
add_action( 'rest_api_init', function () {
    register_rest_route( 'update', '/banner', array(
        'methods' => 'GET',
        'callback' => 'update_banner',
    ) );
} );

function update_banner(){
    global $EbApi;
    $date = $EbApi->ProductCategoryList("update");
    return new WP_REST_Response(
        array(
            'status' => 200,
            'response' => "More detailed success!",
            'date' => $date
        )
    );
}
add_action('seo_router',function (){
    ebay_api::router();
});
do_action('seo_router');
//禁止WordPress自带sitemap
add_filter( 'wp_sitemaps_enabled', '__return_false' );

global $EbApi;
//全局一级分类
$ebay_product_category_list = $EbApi->ProductCategoryList();
//全局汇率
$rates = $EbApi->get_rate();
//单个货币汇率
$rate = get_rate_price(determine_locale_currency(),"","","RATE");
//全局self配置
$self = get_self_config();

//初始化动态数据使用的js文件
function my_custom_scripts() {
    wp_enqueue_script( 'my-js-seo_ajax', get_stylesheet_directory_uri() . '/js/ebay/seo_ajax.js', array( 'jquery' ), false, false);
    wp_enqueue_script( 'my-js-math', 'https://unpkg.com/mathjs@7.0.1/dist/math.min.js', array( 'jquery' ), false, false);
    wp_enqueue_script( 'my-js-language-currency', get_stylesheet_directory_uri() . '/js/ebay/language-currency.js', array( 'jquery' ), false, false);
}
add_action('wp_enqueue_scripts','my_custom_scripts');

