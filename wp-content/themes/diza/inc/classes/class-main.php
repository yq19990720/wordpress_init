<?php

/**
 * Class diza_setup_theme'
 */
class diza_setup_theme {
    function __construct() {
        add_action( 'after_setup_theme', array( $this, 'setup' ), 10 );

        add_action('wp', 'diza_get_display_header_builder');

        add_action( 'wp_enqueue_scripts', array( $this, 'load_fonts_url' ), 10 );
        add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ), 100 );
        add_action('wp_footer', array( $this, 'footer_scripts' ), 20 );
        add_action( 'widgets_init', array( $this, 'widgets_init' ) );
        add_filter( 'frontpage_template', array( $this, 'front_page_template' ) );

        /**Remove fonts scripts**/
        add_action('wp_enqueue_scripts', array( $this, 'remove_fonts_redux_url' ), 1000 );

        add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_styles' ), 1000 );
        add_action( 'login_enqueue_scripts', array( $this, 'load_admin_login_styles' ), 1000 );


        add_action( 'after_switch_theme', array( $this, 'add_cpt_support'), 10 );
    }

    /**
     * Enqueue scripts and styles.
     */
    public function add_scripts() {
       
        $suffix = (diza_tbay_get_config('minified_js', false)) ? '.min' : DIZA_MIN_JS;


        // load bootstrap style 
        if( is_rtl() ){
            wp_enqueue_style( 'bootstrap', DIZA_STYLES . '/bootstrap.rtl.css', array(), '4.3.1' );
        }else{
            wp_enqueue_style( 'bootstrap', DIZA_STYLES . '/bootstrap.css', array(), '4.3.1' );
        }

        $skin = diza_tbay_get_theme();
        
        // Load our main stylesheet.
        if( is_rtl() ){
            $css_path =  DIZA_STYLES . '/template.rtl.css';
            $css_skin =  DIZA_STYLES_SKINS . '/'.$skin.'/type.rtl.css';
        }
        else{
            $css_path =  DIZA_STYLES . '/template.css';
            $css_skin =  DIZA_STYLES_SKINS . '/'.$skin.'/type.css';
        }

		$css_array = array();

        if( diza_is_elementor_activated() ) {
            array_push($css_array, 'elementor-frontend'); 
        } 
        wp_enqueue_style( 'diza-template', $css_path, $css_array, DIZA_THEME_VERSION );
        wp_enqueue_style( 'diza-skin', $css_skin, array(), DIZA_THEME_VERSION );
        
        wp_enqueue_style( 'diza-style', DIZA_THEME_DIR . '/style.css', array(), DIZA_THEME_VERSION );

        //load font awesome
        
        wp_enqueue_style( 'font-awesome', DIZA_STYLES . '/font-awesome.css', array(), '5.10.2' );

        //load font custom icon tbay
        wp_enqueue_style( 'diza-font-tbay-custom', DIZA_STYLES . '/font-tbay-custom.css', array(), '1.0.0' );

        //load simple-line-icons
        wp_enqueue_style( 'simple-line-icons', DIZA_STYLES . '/simple-line-icons.css', array(), '2.4.0' );

        //load material font icons
        wp_enqueue_style( 'material-design-iconic-font', DIZA_STYLES . '/material-design-iconic-font.css', array(), '2.2.0' );

        // load animate version 3.5.0
        wp_enqueue_style( 'animate', DIZA_STYLES . '/animate.css', array(), '3.5.0' );

        
        wp_enqueue_script( 'diza-skip-link-fix', DIZA_SCRIPTS . '/skip-link-fix' . $suffix . '.js', array(), DIZA_THEME_VERSION, true );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }


        /*mmenu menu*/ 
        wp_register_script( 'jquery-mmenu', DIZA_SCRIPTS . '/jquery.mmenu' . $suffix . '.js', array( 'underscore' ),'7.0.5', true );

        /*Treeview menu*/
        wp_enqueue_style( 'jquery-treeview',  DIZA_STYLES . '/jquery.treeview.css', array(), '1.0.0' );
        
        wp_register_script( 'popper', DIZA_SCRIPTS . '/popper' . $suffix . '.js', array(), '1.12.9', true );        

        if( class_exists('WeDevs_Dokan') ) { 
            wp_dequeue_script( 'dokan-tooltip' );  
        }
         
        wp_enqueue_script( 'bootstrap', DIZA_SCRIPTS . '/bootstrap' . $suffix . '.js', array('popper'), '4.3.1', true );          

        wp_register_script( 'js-cookie', DIZA_SCRIPTS . '/js.cookie' . $suffix . '.js', array(), '2.1.4', true );  
  
        /*slick jquery*/
        wp_register_script( 'slick', DIZA_SCRIPTS . '/slick' . $suffix . '.js', array(), '1.0.0', true );
        wp_register_script( 'diza-custom-slick', DIZA_SCRIPTS . '/custom-slick' . $suffix . '.js', array(), DIZA_THEME_VERSION, true ); 
  
        // Add js Sumoselect version 3.0.2
        wp_register_style('sumoselect', DIZA_STYLES . '/sumoselect.css', array(), '1.0.0', 'all');
        wp_register_script('jquery-sumoselect', DIZA_SCRIPTS . '/jquery.sumoselect' . $suffix . '.js', array( ), '3.0.2', TRUE);   

        wp_register_script( 'jquery-autocomplete', DIZA_SCRIPTS . '/jquery.autocomplete' . $suffix . '.js', array('diza-script' ), '1.0.0', true );     
        wp_enqueue_script('jquery-autocomplete'); 

        wp_register_style( 'magnific-popup', DIZA_STYLES . '/magnific-popup.css', array(), '1.0.0' );
        wp_enqueue_style('magnific-popup');

      
        wp_register_script( 'jquery-countdowntimer', DIZA_SCRIPTS . '/jquery.countdownTimer' . $suffix . '.js', array( ), '20150315', true );
 
        wp_enqueue_script('jquery-countdowntimer');  

        wp_enqueue_script( 'diza-script',  DIZA_SCRIPTS . '/functions' . $suffix . '.js', array('jquery-core', 'js-cookie'),  DIZA_THEME_VERSION,  true );


        wp_enqueue_script( 'detectmobilebrowser', DIZA_SCRIPTS . '/detectmobilebrowser' . $suffix . '.js', array(), '1.0.6', true );
       
        wp_enqueue_script( 'jquery-fastclick', DIZA_SCRIPTS . '/jquery.fastclick' . $suffix . '.js', array(), '1.0.6', true );

        if ( diza_tbay_get_config('header_js') != "" ) {
            wp_add_inline_script( 'diza-script', diza_tbay_get_config('header_js') );
        }
  
        $config = diza_localize_translate();

        wp_localize_script( 'diza-script', 'diza_settings', $config );
        
    }

    public function footer_scripts() {
        if ( diza_tbay_get_config('footer_js') != "" ) {
            $footer_js = diza_tbay_get_config('footer_js');
            echo trim($footer_js);
        }
    }

    public function remove_fonts_redux_url() {
        $show_typography  = diza_tbay_get_config('show_typography', false);
        if( !$show_typography ) {
            wp_dequeue_style( 'redux-google-fonts-diza_tbay_theme_options' );
        } 
    }

    public function load_admin_login_styles() {
        wp_enqueue_style( 'diza-login-admin', DIZA_STYLES . '/admin/login-admin.css', false, '1.0.0' );
    }
 
    public function load_admin_styles() {
        wp_enqueue_style( 'material-design-iconic-font', DIZA_STYLES . '/material-design-iconic-font.css', false, '2.2.0' ); 
        wp_enqueue_style( 'diza-custom-admin', DIZA_STYLES . '/admin/custom-admin.css', false, '1.0.0' );

        $suffix = (diza_tbay_get_config('minified_js', false)) ? '.min' : DIZA_MIN_JS;
        wp_enqueue_script( 'diza-admin', DIZA_SCRIPTS . '/admin/admin' . $suffix . '.js', array( ), DIZA_THEME_VERSION, true );
    }

    /**
     * Register widget area.
     *
     * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     */
    public function widgets_init() {
        register_sidebar( array(
            'name'          => esc_html__( 'Sidebar Default', 'diza' ),
            'id'            => 'sidebar-default',
            'description'   => esc_html__( 'Add widgets here to appear in your Sidebar.', 'diza' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
        

        /* Check WPML */
        if ( class_exists('SitePress') ) {
            register_sidebar( array(
                'name'          => esc_html__( 'WPML Sidebar', 'diza' ),
                'id'            => 'wpml-sidebar',
                'description'   => esc_html__( 'Add widgets here to appear.', 'diza' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            ) );
        }
        /* End check WPML */

        register_sidebar( array(
            'name'          => esc_html__( 'Footer', 'diza' ),
            'id'            => 'footer',
            'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'diza' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) ); 

    }

    public function add_cpt_support() {
        $cpt_support = ['tbay_megamenu', 'tbay_footer', 'tbay_header', 'post', 'page']; 
        update_option( 'elementor_cpt_support', $cpt_support);

        update_option( 'elementor_disable_color_schemes', 'yes'); 
        update_option( 'elementor_disable_typography_schemes', 'yes');
        update_option( 'elementor_container_width', '1200');
        update_option( 'elementor_viewport_lg', '1200');  
        update_option( 'elementor_space_between_widgets', '0');
        update_option( 'elementor_load_fa4_shim', 'yes');
    }

    public function edit_post_show_excerpt( $user_login, $user ) {
        update_user_meta( $user->ID, 'metaboxhidden_post', true );
    }
    

    /**
     * Use front-page.php when Front page displays is set to a static page.
     *
     * @param string $template front-page.php.
     *
     * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
     */
    public function front_page_template( $template ) {
        return is_home() ? '' : $template;
    }

    public function setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on diza, use a find and replace
         * to change 'diza' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'diza', DIZA_THEMEROOT . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        add_theme_support( "post-thumbnails" );

        add_image_size('diza_avatar_post_carousel', 100, 100, true);

        // This theme styles the visual editor with editor-style.css to match the theme style.
        $font_source = diza_tbay_get_config('show_typography', false);
        if( !$font_source ) {
            add_editor_style( array( 'css/editor-style.css', $this->fonts_url() ) );
        }

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );


        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ) );

        
        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support( 'post-formats', array(
            'aside', 'image', 'video', 'gallery', 'audio' 
        ) );

        $color_scheme  = diza_tbay_get_color_scheme();
        $default_color = trim( $color_scheme[0], '#' );

        // Setup the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'diza_custom_background_args', array(
            'default-color'      => $default_color,
            'default-attachment' => 'fixed',
        ) ) );

        add_action( 'wp_login', array( $this, 'edit_post_show_excerpt'), 10, 2 );


        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus( array(
            'primary'           => esc_html__( 'Primary Menu', 'diza' ),
            'mobile-menu'       => esc_html__( 'Mobile Menu','diza' ),
            'nav-category-menu'  => esc_html__( 'Nav Category Menu', 'diza' ),
            'track-order'  => esc_html__( 'Tracking Order Menu', 'diza' ),
        ) );

        update_option( 'page_template', 'elementor_header_footer'); 
    }

    public function load_fonts_url() {
        $protocol         = is_ssl() ? 'https:' : 'http:';
        $show_typography  = diza_tbay_get_config('show_typography', false);
        $font_source      = diza_tbay_get_config('font_source', "1");
        $font_google_code = diza_tbay_get_config('font_google_code');
        if( !$show_typography ) {
            wp_enqueue_style( 'diza-theme-fonts', $this->fonts_url(), array(), null );
        } else if ( $font_source == "2" && !empty($font_google_code) ) {
            wp_enqueue_style( 'diza-theme-fonts', $font_google_code, array(), null );
        }
    }

    public function fonts_url() {
        /**
         * Load Google Front
         */

        $fonts_url = '';

        /* Translators: If there are characters in your language that are not
        * supported by Montserrat, translate this to 'off'. Do not translate
        * into your own language.
        */
        $Nunito_Sans       = _x( 'on', 'Nunito Sans font: on or off', 'woocommerce' );
        $Roboto            = _x( 'on', 'Roboto font: on or off', 'woocommerce' );
     
        if ( 'off' !== $Nunito_Sans ||  'off' !== $Roboto) {
            $font_families = array(); 
     
            if ( 'off' !== $Nunito_Sans ) {
                $font_families[] = 'Nunito Sans:0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900';
            }           

            if ( 'off' !== $Roboto ) {
                $font_families[] = 'Roboto:0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900';
            }            
     
            $query_args = array(
                'family' => rawurlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
                'display' => urlencode( 'swap' ),
            ); 
            
            $protocol = is_ssl() ? 'https:' : 'http:';
            $fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
        }
     
        return esc_url_raw( $fonts_url );
    }
    
    public function instagram_image_only() {

        $output = TRUE;

        return $output;

    }

}

return new diza_setup_theme();