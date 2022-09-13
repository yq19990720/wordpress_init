<?php

class Diza_Merlin_Config {

	private $config = [];

	public function __construct() {
		$this->init();
		add_action( 'merlin_import_files', [ $this, 'import_files' ] );
		add_action( 'merlin_after_all_import', [ $this, 'after_import_setup' ], 10, 1 );
		add_filter( 'merlin_generate_child_functions_php', [ $this, 'render_child_functions_php' ], 10 ,2 );
		add_filter( 'merlin_generate_child_style_css', [ $this, 'render_child_style_css' ], 10 ,5 );

		remove_action( 'init', 'tbay_import_init', 50 );
	}

	private function init() {
		$wizard = new Merlin(
			$config = array(
				'directory'          => 'inc/merlin',
				// Location / directory where Merlin WP is placed in your theme.
				'merlin_url'         => 'tbay_import',
				// The shopify_seo page slug where Merlin WP loads.
				'parent_slug'        => 'themes.php',
				// The shopify_seo parent page slug for the admin menu item.
				'capability'         => 'manage_options',
				// The capability required for this menu to be displayed to the user.
				'dev_mode'           => true,
				// Enable development mode for testing.
				'plugins_step'       => false,
				'license_step'       => false,
				// EDD license activation step.
				'license_required'   => false,
				// Require the license activation step.
				'license_help_url'   => '',
				// URL for the 'license-tooltip'.
				'edd_remote_api_url' => '',
				// EDD_Theme_Updater_Admin remote_api_url.
				'edd_item_name'      => '',
				// EDD_Theme_Updater_Admin item_name.
				'edd_theme_slug'     => '',
				// EDD_Theme_Updater_Admin item_slug.
			),
			$strings = array(
				'admin-menu'          => esc_html__( 'Theme Setup', 'diza' ),

				/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
				'title%s%s%s%s'       => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'diza' ),
				'return-to-dashboard' => esc_html__( 'Return to the dashboard', 'diza' ),
				'ignore'              => esc_html__( 'Disable this wizard', 'diza' ),

				'btn-skip'                 => esc_html__( 'Skip', 'diza' ),
				'btn-next'                 => esc_html__( 'Next', 'diza' ),
				'btn-start'                => esc_html__( 'Start', 'diza' ),
				'btn-no'                   => esc_html__( 'Cancel', 'diza' ),
				'btn-plugins-install'      => esc_html__( 'Install', 'diza' ),
				'btn-child-install'        => esc_html__( 'Install', 'diza' ),
				'btn-content-install'      => esc_html__( 'Install', 'diza' ),
				'btn-import'               => esc_html__( 'Import', 'diza' ),
				'btn-license-activate'     => esc_html__( 'Activate', 'diza' ),
				'btn-license-skip'         => esc_html__( 'Later', 'diza' ),

				/* translators: Theme Name */
				'license-header%s'         => esc_html__( 'Activate %s', 'diza' ),
				/* translators: Theme Name */
				'license-header-success%s' => esc_html__( '%s is Activated', 'diza' ),
				/* translators: Theme Name */
				'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'diza' ),
				'license-label'            => esc_html__( 'License key', 'diza' ),
				'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'diza' ),
				'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'diza' ),
				'license-tooltip'          => esc_html__( 'Need help?', 'diza' ),

				/* translators: Theme Name */
				'welcome-header%s'         => esc_html__( 'Welcome to %s', 'diza' ),
				'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'diza' ),
				'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'diza' ),
				'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'diza' ),

				'child-header'         => esc_html__( 'Install Child Theme', 'diza' ),
				'child-header-success' => esc_html__( 'You\'re good to go!', 'diza' ),
				'child'                => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'diza' ),
				'child-success%s'      => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'diza' ),
				'child-action-link'    => esc_html__( 'Learn about child themes', 'diza' ),
				'child-json-success%s' => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'diza' ),
				'child-json-already%s' => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'diza' ),

				'plugins-header'         => esc_html__( 'Install Plugins', 'diza' ),
				'plugins-header-success' => esc_html__( 'You\'re up to speed!', 'diza' ),
				'plugins'                => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'diza' ),
				'plugins-success%s'      => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'diza' ),
				'plugins-action-link'    => esc_html__( 'Advanced', 'diza' ),

				'import-header'      => esc_html__( 'Import Content', 'diza' ),
				'import'             => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'diza' ),
				'import-action-link' => esc_html__( 'Advanced', 'diza' ),

				'ready-header'      => esc_html__( 'All done. Have fun!', 'diza' ),

				/* translators: Theme Author */
				'ready%s'           => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'diza' ),
				'ready-action-link' => esc_html__( 'Extras', 'diza' ),
				'ready-big-button'  => esc_html__( 'View your website', 'diza' ),
				'ready-link-1'      => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://tickets.thembay.com/', esc_html__( 'Ticket System', 'diza' ) ),
				'ready-link-2'      => sprintf( '<a href="%1$s">%2$s</a>', 'https://docs.thembay.com/diza/', esc_html__( 'Documentation', 'diza' ) ),
				'ready-link-3'      => sprintf( '<a href="%1$s">%2$s</a>', 'https://www.youtube.com/c/thembay/', esc_html__( 'Video Tutorials', 'diza' ) ),
				'ready-link-4'      => sprintf( '<a href="%1$s">%2$s</a>', 'https://forums.thembay.com/', esc_html__( 'Forums', 'diza' ) ),
			)
		);
	}

	public function render_child_functions_php( $output, $slug ) {
    $slug_no_hyphens = strtolower( preg_replace( '#[^a-zA-Z]#', '', $slug ) );
    $output = "<?php
	/**
	 * @version    1.0
	 * @package    {$slug_no_hyphens}
	 * @author     Thembay Team <support@thembay.com>
	 * @copyright  Copyright (C) 2019 Thembay.com. All Rights Reserved.
	 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
	 *
	 * Websites: https://thembay.com
	 */
  function {$slug_no_hyphens}_child_enqueue_styles() {
    wp_enqueue_style( '{$slug}-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( '{$slug}-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( '{$slug}-style' ),
        wp_get_theme()->get('Version')
    );
  }

	add_action(  'wp_enqueue_scripts', '{$slug_no_hyphens}_child_enqueue_styles', 10000 );\n
	";

    // Let's remove the tabs so that it displays nicely.
    $output = trim( preg_replace( '/\t+/', '', $output ) );

    // Filterable return.
    return $output;
  }

  public function render_child_style_css( $output, $slug, $parent, $author, $version ) {
		$render_output = "/**
* Theme Name: {$parent} Child
* Description: This is a child theme for {$parent}
* Author: Thembay
* Author URI: https://thembay.com/
* Version: {$version}
* Template: {$slug}
*/\n

/*  [ Add your custom css below ]
- - - - - - - - - - - - - - - - - - - - */";

		return $render_output;
	}

	public function after_import_setup( $selected_import ) {
		$_imports = $this->import_files();
		$selected_import = $_imports[ $selected_import ];
		$check_oneclick  = get_option( 'diza_check_oneclick', [] );

		// setup Home page
		$home = get_page_by_path( $selected_import['home'] );
		if ( $home ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $home->ID );
		}

		if ( count( $check_oneclick ) <= 0 ) {
			$this->setup_mailchimp();
		}

		if ( ! isset( $check_oneclick[ $selected_import['home'] ] ) || apply_filters( 'diza_reset_import_rev_sliders', false ) ) {
			$check_oneclick[ $selected_import['home'] ] = true;
			$this->import_revslider( $selected_import['rev_sliders'] );
			update_option( 'diza_check_oneclick', $check_oneclick );
		}

		$this->setup_options_after_import();
		$this->set_demo_menus();

	}

	private function import_revslider( $revsliders ) {
		if ( class_exists( 'RevSliderAdmin' ) ) {
			require_once ABSPATH . '/shopify_seo/includes/class-wp-filesystem-base.php';
			require_once ABSPATH . '/shopify_seo/includes/class-wp-filesystem-direct.php';
			$my_filesystem = new WP_Filesystem_Direct( array() );

			$revslider = new RevSlider();
			foreach ( $revsliders as $slider ) {
				$pathSlider = trailingslashit( ( wp_upload_dir() )['path'] ) . basename( $slider );
				if ( $this->download_revslider( $my_filesystem, $slider, $pathSlider ) ) {
					$_FILES['import_file']['error']    = UPLOAD_ERR_OK;
					$_FILES['import_file']['tmp_name'] = $pathSlider;
					$revslider->importSliderFromPost( true, 'none' );
				}

			}
		}
	}

	/**
	 * @param $filesystem WP_Filesystem_Direct
	 *
	 * @return bool
	 */
	private function download_revslider( $filesystem, $slider, $pathSlider ) {
		return $filesystem->copy( $slider, $pathSlider, true );
	}

	private function setup_mailchimp() {
		$mailchimp = get_page_by_title( 'Newsletter', OBJECT, 'mc4wp-form' );
		if ( $mailchimp ) {
			update_option( 'mc4wp_default_form_id', $mailchimp->ID );
		}
  	}

	public function setup_options_after_import() {
		$cpt_support = ['tbay_megamenu', 'tbay_footer', 'tbay_header', 'post', 'page'];
		update_option( 'elementor_cpt_support', $cpt_support);
		update_option( 'elementor_disable_color_schemes', 'yes');
		update_option( 'elementor_disable_typography_schemes', 'yes');
		update_option( 'elementor_container_width', '1200');
		update_option( 'elementor_viewport_lg', '1200');
		update_option( 'elementor_space_between_widgets', '0');
		update_option( 'elementor_load_fa4_shim', 'yes');

		$this->update_option_woocommerce();

		$this->update_option_yith_wcwl();
		$this->update_option_yith_compare();
		$this->update_option_yith_brands();
		$this->update_option_woof();

	}

	private function update_option_woocommerce() {
		if( !class_exists( 'WooCommerce' ) ) return;

		$shop 		= get_page_by_path( 'shop' );
		$cart 		= get_page_by_path( 'cart' );
		$checkout 	= get_page_by_path( 'checkout' );
		$myaccount 	= get_page_by_path( 'my-account' );
		$terms 		= get_page_by_path( 'terms-of-use' );
		if ( $shop ) {
			update_option( 'woocommerce_shop_page_id', $shop->ID );
		}

		if ( $cart ) {
			update_option( 'woocommerce_cart_page_id', $cart->ID );
		}

		if ( $checkout ) {
			update_option( 'woocommerce_checkout_page_id', $checkout->ID );
		}

		if ( $myaccount ) {
			update_option( 'woocommerce_myaccount_page_id', $myaccount->ID );
		}

		if ( $terms ) {
			update_option( 'woocommerce_terms_page_id', $terms->ID );
		}
	}

	private function update_option_yith_wcwl() {
		if( !class_exists( 'YITH_WCWL' ) ) return;

		/**YITH Wishlist**/
		update_option( 'yith_wcwl_add_to_wishlist_icon', 'none');
		update_option( 'yith_wcwl_button_position', 'shortcode' );
		update_option( 'yith_wcwl_price_show', 'yes' );
		update_option( 'yith_wcwl_stock_show', 'yes' );
		update_option( 'yith_wcwl_add_to_cart_show', 'yes' );
		update_option( 'yith_wcwl_show_remove', 'no' );
		update_option( 'yith_wcwl_repeat_remove_button', 'yes' );
		update_option( 'yith_wcwl_enable_share', 'no' );
		update_option( 'yith_wcwl_wishlist_title', '' );
	}

	private function update_option_yith_compare() {
		if( !class_exists( 'YITH_Woocompare' ) ) return;

		/**YITH Compare**/
		update_option( 'yith_woocompare_compare_button_in_products_list', 'no' );
		update_option( 'yith_woocompare_compare_button_in_product_page', 'no' );
	}

	private function update_option_yith_brands() {
		if( !class_exists( 'YITH_WCBR' ) ) return;

		/**YITH Brands**/
		update_option( 'yith_wcbr_single_product_brands_content', 'name' );
	}

	private function update_option_woof() {
		if( !class_exists( 'WOOF' ) ) return;

		/**WOOF**/
		$settings = get_option('woof_settings');

		/**Price**/
		$settings['by_price']['show'] = '1';
		$settings['by_price']['title_text'] = esc_html__('Price', 'diza');

		/**Categories**/
		$settings['tax']['product_cat'] = '1';
		$settings['show_title_label']['product_cat'] = '1';
		$settings['custom_tax_label']['product_cat'] = esc_html__('Categories', 'diza');

		/**Size**/
		$settings['tax']['pa_size'] = '1';
		$settings['show_title_label']['pa_size'] = '1';
		$settings['custom_tax_label']['pa_size'] = esc_html__('Product Size', 'diza');

		/**Color**/
		$settings['tax']['pa_color'] = '1';
		$settings['show_title_label']['pa_color'] = '1';
		$settings['custom_tax_label']['pa_color'] = esc_html__('Product Color', 'diza');

		/**Tag**/
		$settings['tax']['product_tag'] = '1';
		$settings['show_title_label']['product_tag'] = '1';
		$settings['custom_tax_label']['product_tag'] = esc_html__('Product Tags', 'diza');

		/**Brand**/
		if( class_exists( 'YITH_WCBR' ) ) {
			$settings['tax']['yith_product_brand'] = '1';
			$settings['show_title_label']['yith_product_brand'] = '1';
			$settings['custom_tax_label']['yith_product_brand'] = esc_html__('Brands', 'diza');
		}

		update_option('woof_settings', $settings);
	}

	public function set_demo_menus() {
		$main_menu       	= get_term_by( 'name', 'Main Menu', 'nav_menu' );

		set_theme_mod(
			'nav_menu_locations',
			array(
				'primary'  		=> $main_menu->term_id,
				'mobile-menu' 	=> $main_menu->term_id,
			)
		);
	}

	public function import_files(){
		return array(
			array(
				'import_file_name'           => 'Protective Suit',
				'home'                       => 'home',
				'import_file_url'          	 => "https://demosamples.thembay.com/diza/protective-suit/data.xml",
				'import_widget_file_url'     => "https://demosamples.thembay.com/diza/protective-suit/widgets.wie",
				'import_redux'         => array(
					array(
						'file_url'   => "https://demosamples.thembay.com/diza/protective-suit/home/redux_options.json",
						'option_name' => 'diza_tbay_theme_options',
					),
				),
				'rev_sliders'                => array(
					"https://demosamples.thembay.com/diza/protective-suit/revslider/slider-protective-suit.zip",
				),
				'import_preview_image_url'   => "https://demosamples.thembay.com/diza/protective-suit/home/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'diza' ),
				'preview_url'                => 'https://elementor.thembay.com/diza/',
			),
			array(
				'import_file_name'           => 'Medicine',
				'home'                       => 'home',
				'import_file_url'          	 => "https://demosamples.thembay.com/diza/medicine/data.xml",
				'import_widget_file_url'     => "https://demosamples.thembay.com/diza/medicine/widgets.wie",
				'import_redux'         => array(
					array(
						'file_url'   => "https://demosamples.thembay.com/diza/medicine/home/redux_options.json",
						'option_name' => 'diza_tbay_theme_options',
					),
				),
				'rev_sliders'                => array(
					"https://demosamples.thembay.com/diza/medicine/revslider/slider-medicine.zip",
				),
				'import_preview_image_url'   => "https://demosamples.thembay.com/diza/medicine/home/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'diza' ),
				'preview_url'                => 'https://elementor.thembay.com/diza_medicine/',
			),
			array(
				'import_file_name'           => 'Care',
				'home'                       => 'home',
				'import_file_url'          	 => "https://demosamples.thembay.com/diza/care/data.xml",
				'import_widget_file_url'     => "https://demosamples.thembay.com/diza/care/widgets.wie",
				'import_redux'         => array(
					array(
						'file_url'   => "https://demosamples.thembay.com/diza/care/home/redux_options.json",
						'option_name' => 'diza_tbay_theme_options',
					),
				),
				'rev_sliders'                => array(
					"https://demosamples.thembay.com/diza/care/revslider/slider-care.zip",
				),
				'import_preview_image_url'   => "https://demosamples.thembay.com/diza/care/home/screenshot.jpg",
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'diza' ),
				'preview_url'                => 'https://elementor.thembay.com/diza_care/',
			),
		);
	}
}

return new Diza_Merlin_Config();
