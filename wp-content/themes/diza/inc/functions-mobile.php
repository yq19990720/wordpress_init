<?php if ( ! defined('DIZA_THEME_DIR')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Mobile Menu
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_tbay_get_button_mobile_menu' ) ) {
	function diza_tbay_get_button_mobile_menu() {

		$output 	= '';
		$output 	.= '<a href="#tbay-mobile-menu-navbar" class="btn btn-sm">';
		$output  .= '<i class="tb-icon tb-icon-menu"></i>';
		$output  .= '</a>';

		$output 	.= '<a href="#page" class="btn btn-sm">';
		$output  .= '<i class="tb-icon tb-icon-cross"></i>';
		$output  .= '</a>';


		return apply_filters( 'diza_tbay_get_button_mobile_menu', '<div class="active-mobile">'. $output . '</div>', 10 );

	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Mobile Menu
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'diza_the_button_mobile_menu' ) ) {
	function diza_the_button_mobile_menu() {
		wp_enqueue_script( 'jquery-mmenu' );
		$ouput = diza_tbay_get_button_mobile_menu();

		echo trim($ouput);
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Logo Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_tbay_get_logo_mobile' ) ) {
	function diza_tbay_get_logo_mobile() {
		$mobilelogo 			= diza_tbay_get_config('mobile-logo');

		$output 	= '<div class="mobile-logo">';
			if( isset($mobilelogo['url']) && !empty($mobilelogo['url']) ) {
				$url    	= $mobilelogo['url'];
				$output 	.= '<a href="'. esc_url( home_url( '/' ) ) .'">';

				if( isset($mobilelogo['width']) && !empty($mobilelogo['width']) ) {
					$output 		.= '<img src="'. esc_url( $url ) .'" width="'. esc_attr($mobilelogo['width']) .'" height="'. esc_attr($mobilelogo['height']) .'" alt="'. get_bloginfo( 'name' ) .'">';
				} else {
					$output 		.= '<img src="'. esc_url( $url ) .'" alt="'. get_bloginfo( 'name' ) .'">';
				}


				$output 		.= '</a>';

			} else {
				$output 		.= '<div class="logo-theme">';
					$output 	.= '<a href="'. esc_url( home_url( '/' ) ) .'">';
					$output 	.= '<img src="'. esc_url_raw("/wp-content/uploads/logo/unnamed.gif") .'" alt="'. get_bloginfo( 'name' ) .'">';
					$output 	.= '</a>';
				$output 		.= '</div>';
			}
		$output 	.= '</div>';

		return apply_filters( 'diza_tbay_get_logo_mobile', $output, 10 );

	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Logo Mobile Menu
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'diza_the_logo_mobile' ) ) {
	function diza_the_logo_mobile() {
		$ouput = diza_tbay_get_logo_mobile();
		echo trim($ouput);
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Mini cart mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_the_icon_mini_cart_mobile' ) ) {
	function diza_the_icon_mini_cart_mobile() {
		global $woocommerce;
		$icon = diza_tbay_get_config('woo_mini_cart_icon', 'tb-icon tb-icon-shopping-cart');
		$_id 	= diza_tbay_random_key();
		if( !defined('DIZA_WOOCOMMERCE_ACTIVED') || diza_catalog_mode_active() ) return;
		?>

        <div class="device-mini_cart top-cart tbay-element-mini-cart">
        	<?php diza_tbay_get_page_templates_parts('offcanvas-cart','right'); ?>
            <div class="tbay-topcart">
				<div id="cart-<?php echo esc_attr($_id); ?>" class="cart-dropdown dropdown">
					<a class="dropdown-toggle mini-cart v2 dropdown-min" data-offcanvas="offcanvas-right" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0" href="#">
                        <?php if(!is_user_logged_in()){?>
                            <script>
                                jQuery(document).ready(function($) {
                                    products = get_seo_localstorage("product")
                                    var total = get_total(products);
                                    var html = '<i class="tb-icon tb-icon-shopping-cart"></i><span class="mini-cart-items">'+total+'</span><span>Cart</span>'
                                    $('.dropdown-min').html(html)
                                })
                            </script>
                        <?php }else{?>
                        <?php }?>
					</a>
					<div class="dropdown-menu"></div>
				</div>
			</div>
		</div>

		<?php
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Mini cart header mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_the_icon_mini_cart_header_mobile' ) ) {
	function diza_the_icon_mini_cart_header_mobile() {
		if( !diza_catalog_mode_active() && defined('DIZA_WOOCOMMERCE_ACTIVED') ) {
			diza_the_icon_mini_cart_mobile();
		}
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * The search header mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_the_search_header_mobile' ) ) {
	add_action('diza_top_header_mobile', 'diza_the_search_header_mobile', 5);
	function diza_the_search_header_mobile() {
		?>
			<div class="search-device">
				<a id="search-icon" class="search-icon" href="javascript:;"><?php echo apply_filters( 'diza_get_icon_search_mobile', '<i class="tb-icon tb-icon-magnifier"></i>', 2 ); ?></a>
				<?php diza_tbay_get_page_templates_parts('device/productsearchform', 'mobileheader');  ?>
			</div>

		<?php
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Mini cart mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_the_mini_cart_header_mobile' ) ) {
	function diza_the_mini_cart_header_mobile() {
		diza_tbay_get_page_templates_parts('offcanvas-cart','right');
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Top right header mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_top_header_mobile' ) ) {
	function diza_top_header_mobile() { ?>
		<div class="top-right-mobile">
			<?php
				/**
				* Hook: diza_top_header_mobile.
				*
				* @hooked diza_the_mini_cart_header_mobile - 5
				* @hooked diza_the_search_header_mobile - 10
				*/
				do_action( 'diza_top_header_mobile' );
			?>
		</div>
	<?php }
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Back on Header Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_tbay_get_back_mobile' ) ) {
	function diza_tbay_get_back_mobile() {

		$output 	= '<div class="topbar-mobile-history">';
		$output 	.= '<a href="javascript:history.back()">';
		$output  	.= apply_filters( 'diza_get_mobile_history_icon', '<i class="tb-icon tb-icon-chevron-left"></i>', 2 );
		$output  	.= '</a>';
		$output  	.= '</div>';

		return apply_filters( 'diza_tbay_get_back_mobile', $output , 10 );

	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The icon Back On Header Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'diza_the_back_mobile' ) ) {
	function diza_the_back_mobile() {
		$ouput = diza_tbay_get_back_mobile();

		echo trim($ouput);
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Title Page Header Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_tbay_get_title_page_mobile' ) ) {
	function diza_tbay_get_title_page_mobile() {
		$output = '';

		if( class_exists('WooCommerce') && !is_product_category() ) {
			$output 	.= '<div class="topbar-title">';
			$output  	.= apply_filters( 'diza_get_filter_title_mobile', 10,2 );
			$output  	.= '</div>';
		} else {
			$output  	.= apply_filters( 'diza_get_filter_title_mobile', 10,2 );
		}


		return apply_filters( 'diza_tbay_get_title_page_mobile', $output , 10 );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The icon Back On Header Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'diza_the_title_page_mobile' ) ) {
	function diza_the_title_page_mobile() {
		$ouput = diza_tbay_get_title_page_mobile();
		echo trim($ouput);
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Home Page On Header Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_tbay_get_icon_home_page_mobile' ) ) {
	function diza_tbay_get_icon_home_page_mobile() {
		$output 	= '<div class="topbar-icon-home">';
		$output 	.= '<a href="'. esc_url( home_url( '/' ) ) .'">';
		$output  	.= apply_filters( 'diza_get_mobile_home_icon', '<i class="tb-icon tb-icon-home3"></i>', 2 );
		$output  	.= '</a>';
		$output  	.= '</div>';

		return apply_filters( 'diza_tbay_get_icon_home_page_mobile', $output , 10 );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Home Page On Header Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'diza_the_icon_home_page_mobile' ) ) {
	function diza_the_icon_home_page_mobile() {

		$ouput = diza_tbay_get_icon_home_page_mobile();
		echo trim($ouput);

	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * The Hook Config Header Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'diza_the_hook_header_mobile_all_page' ) ) {
	function diza_the_hook_header_mobile_all_page() {
		$always_display_logo 			= diza_tbay_get_config('always_display_logo', false);

		if( $always_display_logo || diza_tbay_is_home_page() ) return;

		remove_action( 'diza_header_mobile_content', 'diza_the_logo_mobile', 15 );
		add_action( 'diza_header_mobile_content', 'diza_the_title_page_mobile', 15 );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Hook Menu Mobile All page Header Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'diza_the_hook_header_mobile_menu_all_page' ) ) {
	function diza_the_hook_header_mobile_menu_all_page() {
		$menu_mobile_all_page 	= diza_tbay_get_config('menu_mobile_all_page', false);

		if( $menu_mobile_all_page || diza_tbay_is_home_page() )  return;
		remove_action( 'diza_header_mobile_content', 'diza_the_button_mobile_menu', 5 );
		add_action( 'diza_header_mobile_content', 'diza_the_back_mobile', 5 );
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Home Page On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_tbay_get_icon_home_footer_mobile' ) ) {
	function diza_tbay_get_icon_home_footer_mobile() {

		$active = (is_front_page()) ? 'active' : '';

		$output	 = '<div class="device-home '. $active .' ">';
		$output  .= '<a href="'. esc_url( home_url( '/' ) ) .'" >';
		$output  .= apply_filters( 'diza_get_mobile_home_icon', '<i class="tb-icon tb-icon-home3"></i>', 2 );
		$output  .= '<span>'. esc_html__('Home','diza'). '</span>';
		$output  .='</a>';
		$output  .='</div>';

		return apply_filters( 'diza_tbay_get_icon_home_footer_mobile', $output , 10 );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Home Page On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'diza_the_icon_home_footer_mobile' ) ) {
	function diza_the_icon_home_footer_mobile() {
		$ouput = diza_tbay_get_icon_home_footer_mobile();

		echo trim($ouput);
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Wishlist On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_tbay_get_icon_wishlist_footer_mobile' ) ) {
	function diza_tbay_get_icon_wishlist_footer_mobile() {
		$output = '';

		if( !class_exists( 'YITH_WCWL' ) ) return $output;

		$wishlist_url 	= YITH_WCWL()->get_wishlist_url();
		$wishlist_count = YITH_WCWL()->count_products();

		$output	 .= '<div class="device-wishlist">';
		$output  .= '<a class="text-skin wishlist-icon" href="'. esc_url($wishlist_url) .'" >';
		$output  .= apply_filters( 'diza_get_mobile_wishlist_icon', '<i class="tb-icon tb-icon-heart"></i>', 2 );
		$output  .= '<span class="count count_wishlist">'. esc_html($wishlist_count) .'</span>';
		$output  .= '<span>'. esc_html__('Wishlist','diza'). '</span>';
		$output  .='</a>';
		$output  .='</div>';

		return apply_filters( 'diza_tbay_get_icon_wishlist_footer_mobile', $output , 10 );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Wishlist On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'diza_the_icon_wishlist_footer_mobile' ) ) {
	function diza_the_icon_wishlist_footer_mobile() {
		$ouput = diza_tbay_get_icon_wishlist_footer_mobile();

		echo trim($ouput);
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Get Icon Account On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'diza_tbay_get_icon_account_footer_mobile' ) ) {
	function diza_tbay_get_icon_account_footer_mobile() {
		$output = '';

		if ( diza_catalog_mode_active() || !defined('DIZA_WOOCOMMERCE_ACTIVED') ) return $output;

		$icon_text 	= apply_filters( 'diza_get_mobile_user_icon', '<i class="tb-icon tb-icon-user"></i>', 2 );
		$icon_text .= '<span>'.esc_html__('Account','diza').'</span>';

		$active 	= ( is_account_page() ) ? 'active' : '';

		$output	 .= '<div class="device-account '. esc_attr( $active ) .'">';
		if (is_user_logged_in() ) {
			$output .= '<a class="logged-in" href="'. esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) .'"  title="'. esc_attr__('Login','diza') .'">';
		}
		else {
			$output .= '<a class="popup-login" href="javascript:void(0);"  title="'. esc_attr__('Login','diza') .'">';
		}
		$output .= $icon_text;
		$output .= '</a>';

		$output  .='</div>';

		return apply_filters( 'diza_tbay_get_icon_account_footer_mobile', $output , 10 );
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * The Icon Account On Footer Mobile
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'diza_the_icon_account_footer_mobile' ) ) {
	function diza_the_icon_account_footer_mobile() {
		$ouput = diza_tbay_get_icon_account_footer_mobile();

		echo trim($ouput);
	}
}


if ( ! function_exists( 'diza_the_custom_list_menu_icon' ) ) {
	function diza_the_custom_list_menu_icon( ) {
		$slides = diza_tbay_get_config('mobile_footer_slides');

		if( !diza_tbay_get_config('mobile_footer_icon', true) || empty($slides) ) return;

		$list_menu_icon = '';
		foreach ($slides as $key => $value) {
			$list_menu_icon .= diza_get_list_menu_icon($value);
		}

		if ( !empty($list_menu_icon) ) {
			printf( '<div class="list-menu-icon">%s</div>', apply_filters('diza_list_menu_icon', $list_menu_icon) );
		}

	}

	add_action('diza_footer_mobile_content', 'diza_the_custom_list_menu_icon', 10);
}

if ( ! function_exists( 'diza_get_list_menu_icon' ) ) {
	function diza_get_list_menu_icon($value) {
		$title 	= ( isset($value['title']) ) ? $value['title'] : '';
		$link 	= ( isset($value['url']) ) ? $value['url'] : '';
		$icon 	= ( isset($value['description']) ) ? $value['description'] : '';
		$thumb 	= ( isset($value['thumb']) ) ? $value['thumb'] : '';

		$matches = array();
		preg_match_all('/{{(.*?)}}/', $link, $matches);

		if( isset($matches[1][0]) && !is_null($matches[1][0]) ) {

			$url_wishlist = $url_account = '';

			if( !diza_catalog_mode_active() && defined('DIZA_WOOCOMMERCE_ACTIVED') ) {
				$url_account 	= apply_filters( 'wpml_woo_myaccount_url', "/my-account");
				$url_cart 		= apply_filters( 'wpml_woo_cart_url', wc_get_cart_url() );
				$url_checkout 	= apply_filters( 'wpml_woo_checkout_url', wc_get_checkout_url() );
				$url_shop 		= apply_filters( 'wpml_woo_shop_url', get_permalink( wc_get_page_id( 'shop' ) ) );
				if( class_exists( 'YITH_WCWL' ) ) {
					$url_wishlist = apply_filters( 'wpml_woo_wishlist_url', YITH_WCWL()->get_wishlist_url() );
				}
			}

			switch ($matches[1][0]) {
				case 'home':
					$link = apply_filters( 'wpml_home_url', site_url() );
					break;

				case 'wishlist':
					$link = $url_wishlist;
					break;

				case 'shop':
					$link = $url_shop;
					break;

				case 'account':
					$link = $url_account;
					break;

				case 'cart':
					$link = $url_cart;
					break;

				case 'checkout':
					$link = $url_checkout;
					break;

				default:
					break;
			}

			if( empty($link) ) return;

		}



		if( empty($title) && empty($icon)&& empty($thumb) )  return;

		global $wp;
		$current_url = home_url(add_query_arg(array(),$wp->request));

		$class 	= ( $current_url == rtrim($link, "/") ) ? 'active' : '';
		$output = '<div class="menu-icon">';

		if( !empty($link) ) $output .= '<a title="'. esc_attr($title) .'" class="'. esc_attr($class) .'" href="'. esc_url($link) .'">';

			if( !empty($thumb) ) {
				$output .= '<img src="'. esc_url($thumb) .'">';
			} elseif( !empty($icon) ) {
				$output .= '<i class="'. esc_attr($icon) .'"></i>';
			}

			if( !empty($title) ) $output .= '<span class="diza-'.trim($title).'">'. trim($title) .'</span>';

		if( !empty($link) ) $output .= '</a>';

		$output .= '</div>';

		return $output;
	}
}
