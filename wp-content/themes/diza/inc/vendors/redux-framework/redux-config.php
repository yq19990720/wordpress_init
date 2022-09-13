<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if( defined('TBAY_ELEMENTOR_ACTIVED') && !TBAY_ELEMENTOR_ACTIVED) return;

if (!class_exists('Diza_Redux_Framework_Config')) {

    class Diza_Redux_Framework_Config
    {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;
        public $output;
        public $default_color; 

        public function __construct()
        {
            if (!class_exists('ReduxFramework')) {
                return; 
            }  

            add_action('init', array($this, 'initSettings'), 10);
        }

        public function redux_output() 
        {
            $this->output = require_once( get_parent_theme_file_path( DIZA_INC . '/skins/'.diza_tbay_get_theme().'/output.php') );

            if( !isset($this->output['main_color_second']) ) {
                $this->output['main_color_second'] = '';
            }     
            
            
            if( !isset($this->output['tablet_second']) ) {
                $this->output['tablet_second'] = '';
            }    

            if( !isset($this->output['mobile_second']) ) {
                $this->output['mobile_second'] = '';
            }  

        }        

        public function redux_default_color() 
        {
            $this->default_color = diza_tbay_default_theme_primary_color();

            if( !isset($this->default_color['main_color_second']) ) {
                $this->default_color['main_color_second'] = '';
            }            
        }

        public function initSettings()
        {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            //Create output
            $this->redux_output();            

            //Create default color all skins
            $this->redux_default_color();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function setSections()
        {

            $output = $this->output;

            $default_color = $this->default_color;

            $sidebars = diza_sidebars_array();

            $columns = array( 
                '1' => esc_html__('1 Column', 'diza'),
                '2' => esc_html__('2 Columns', 'diza'),
                '3' => esc_html__('3 Columns', 'diza'),
                '4' => esc_html__('4 Columns', 'diza'),
                '5' => esc_html__('5 Columns', 'diza'),
                '6' => esc_html__('6 Columns', 'diza')
            );     

            $aspect_ratio = array( 
                '16_9' => '16:9',
                '4_3' => '4:3',
            );        

            $blog_image_size = array( 
                'thumbnail'         => esc_html__('Thumbnail', 'diza'),
                'medium'            => esc_html__('Medium', 'diza'),
                'large'             => esc_html__('Large', 'diza'),
                'full'              => esc_html__('Full', 'diza'),
            );      
          
            
            // General Settings Tab
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-settings',
                'title' => esc_html__('General', 'diza'),
                'fields' => array(
                    array(
                        'id'        => 'active_theme',
                        'type'      => 'image_select', 
                        'compiler'  => true,
                        'class'     => 'image-large active_skins',
                        'title'     => esc_html__('Activated Skin', 'diza'),
                        'options'   => diza_tbay_get_themes(),
                        'default'   => 'protective'
                    ), 
                    array(
                        'id'        => 'preload',
                        'type'      => 'switch',
                        'title'     => esc_html__('Preload Website', 'diza'),
                        'default'   => false
                    ),
                    array(
                        'id' => 'select_preloader',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Select Preloader', 'diza'),
                        'subtitle' => esc_html__('Choose a Preloader for your website.', 'diza'),
                        'required'  => array('preload','=',true),
                        'options' => array(
                            'loader1' => array(
                                'title' => esc_html__( 'Loader 1', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/preloader/loader1.png'
                            ),         
                            'loader2' => array(
                                'title' => esc_html__( 'Loader 2', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/preloader/loader2.png'
                            ),              
                            'loader3' => array(
                                'title' => esc_html__( 'Loader 3', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/preloader/loader3.png'
                            ),         
                            'loader4' => array(
                                'title' => esc_html__( 'Loader 4', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/preloader/loader4.png'
                            ),          
                            'loader5' => array(
                                'title' => esc_html__( 'Loader 5', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/preloader/loader5.png'
                            ),         
                            'loader6' => array(
                                'title' => esc_html__( 'Loader 6', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/preloader/loader6.png'
                            ),                        
                            'custom_image' => array(
                                'title' => esc_html__( 'Custom image', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/preloader/custom_image.png'
                            ),         
                        ),
                        'default' => 'loader1'
                    ),
                    array(
                        'id' => 'media-preloader',
                        'type' => 'media',
                        'required' => array('select_preloader','=', 'custom_image'),
                        'title' => esc_html__('Upload preloader image', 'diza'),
                        'subtitle' => esc_html__('Image File (.gif)', 'diza'),
                        'desc' =>   sprintf( wp_kses( __('You can download some the Gif images <a target="_blank" href="%1$s">here</a>.', 'diza' ),  array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://loading.io/' ), 
                    ),
                    array(
                        'id'            => 'config_media',
                        'type'          => 'switch',
                        'title'         => esc_html__('Enable Config Image Size', 'diza'),
                        'subtitle'      => esc_html__('Config image size in WooCommerce and Media Setting', 'diza'),
                        'default'       => false
                    ),
                )
            );
            // Header
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-view-web',
                'title' => esc_html__('Header', 'diza'),
                'fields' => array(
                    array(
                        'id' => 'header_type',
                        'type' => 'select',
                        'title' => esc_html__('Select Header Layout', 'diza'),
                        'options' => diza_tbay_get_header_layouts(),
                        'default' => 'header_default'
                    ),
                    array(
                        'id' => 'media-logo', 
                        'type' => 'media',
                        'title' => esc_html__('Upload Logo', 'diza'),
                        'required' => array('header_type','=','header_default'),
                        'subtitle' => esc_html__('Image File (.png or .gif)', 'diza'),
                    ),
                )
            );
            
            // Footer
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-border-bottom',
                'title' => esc_html__('Footer', 'diza'),
                'fields' => array(
                    array(
                        'id' => 'footer_type',
                        'type' => 'select',
                        'title' => esc_html__('Select Footer Layout', 'diza'),
                        'options' => diza_tbay_get_footer_layouts(),
 						'default' => 'footer_default'
                    ),
                    array(
                        'id' => 'copyright_text',
                        'type' => 'editor',
                        'title' => esc_html__('Copyright Text', 'diza'),
                        'default' => esc_html__('<p>Copyright  &#64; 2020 Diza Designed by ThemBay. All Rights Reserved.</p>', 'diza'),
                        'required' => array('footer_type','=','footer_default')
                    ),
                    array(
                        'id' => 'back_to_top',
                        'type' => 'switch',
                        'title' => esc_html__('Enable "Back to Top" Button', 'diza'),
                        'default' => true,
                    ),
                )
            );



            // Mobile
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-smartphone-iphone',
                'title' => esc_html__('Mobile', 'diza'),
            );

            // Mobile Header settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Header', 'diza'),
                'fields' => array(
                    array(
                        'id' => 'mobile-logo',
                        'type' => 'media',
                        'title' => esc_html__('Upload Logo', 'diza'),
                        'subtitle' => esc_html__('Image File (.png or .gif)', 'diza'),
                    ),
                    array(
                        'id'        => 'logo_img_width_mobile',
                        'type'      => 'slider',
                        'title'     => esc_html__('Logo maximum width (px)', 'diza'),
                        "default"   => 69,
                        "min"       => 50,
                        "step"      => 1,
                        "max"       => 600,
                    ),
                    array(
                        'id'             => 'logo_mobile_padding',
                        'type'           => 'spacing',
                        'mode'           => 'padding',
                        'units'          => array('px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Logo Padding', 'diza'),
                        'desc'           => esc_html__('Add more spacing around logo.', 'diza'),
                        'default'            => array(
                            'padding-top'     => '',
                            'padding-right'   => '',
                            'padding-bottom'  => '',
                            'padding-left'    => '',
                            'units'          => 'px',
                        ),
                    ),
                    array(
                        'id'        => 'always_display_logo',
                        'type'      => 'switch',
                        'title'     => esc_html__('Always Display Logo', 'diza'),
                        'subtitle'      => esc_html__('Logo displays on all pages (page title is disabled)', 'diza'),
                        'default'   => false
                    ),                    
                    array(
                        'id'        => 'menu_mobile_all_page',
                        'type'      => 'switch',
                        'title'     => esc_html__('Always Display Menu', 'diza'),
                        'subtitle'      => esc_html__('Menu displays on all pages (Button Back is disabled)', 'diza'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'hidden_header_el_pro_mobile',
                        'type'      => 'switch',
                        'title'     => esc_html__('Hide Header Elementor Pro', 'diza'),
                        'subtitle'  => esc_html__('Hide Header Elementor Pro on mobile', 'diza'),
                        'default'   => true
                    ),
                )
            );

             // Mobile Footer settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Footer', 'diza'),
                'fields' => array(                
                    array(
                        'id' => 'mobile_footer',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Desktop Footer', 'diza'),
                        'default' => false
                    ),   
                    array(
                        'id' => 'mobile_back_to_top',
                        'type' => 'switch',
                        'title' => esc_html__('Enable "Back to Top" Button', 'diza'),
                        'default' => false
                    ),                 
                    array(
                        'id' => 'mobile_footer_icon',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Mobile Footer', 'diza'),
                        'default' => true
                    ),
                    array(
                        'id'          => 'mobile_footer_slides',
                        'type'        => 'slides',
                        'title'       => esc_html__( 'Config List Menu Icon', 'diza' ),
                        'subtitle' => esc_html__( 'Enter icon name of fonts: ', 'diza' ) . '<a href="//fontawesome.com/icons?m=free/" target="_blank">Awesome</a> , <a href="//fonts.thembay.com/simple-line-icons//" target="_blank">Simple Line Icons</a>, <a href="//fonts.thembay.com/material-design-iconic/" target="_blank">Material Design Iconic</a></br></br><b>'. esc_html__( 'List default URLs:', 'diza' ) . '</b></br></br><span class="des-label">'. esc_html__('Home page:', 'diza') .'</span><b class="df-url">{{home}}</b></br><span class="des-label">'. esc_html__('Shop page:', 'diza') .'</span><b class="df-url">{{shop}}</b></br><span class="des-label">'. esc_html__('My account page:', 'diza') .'</span><b class="df-url">{{account}}</b></br><span class="des-label">'. esc_html__('Cart page:', 'diza') .'</span><b class="df-url">{{cart}}</b></br><span class="des-label">'. esc_html__('Checkout page:', 'diza') .'</span><b class="df-url">{{checkout}}</b></br><span class="des-label">'. esc_html__('Wishlist page:', 'diza') .'</span><b class="df-url">{{wishlist}}</b></br></br>'. esc_html__( 'Watch video tutorial: ', 'diza' ) . '<a href="//youtu.be/d7b6dIzV-YI/" target="_blank">here</a>',
                        'class' =>   'tbay-redux-slides',
                        'show' => array(
                            'title' => true,
                            'description' => true,
                            'url' => true,
                        ),
                        'content_title' => esc_html__( 'Menu', 'diza' ),
                        'required' => array('mobile_footer_icon','=', true),
                        'placeholder'   => array(
                            'title'      => esc_html__( 'Title', 'diza' ),
                            'description' => __( 'Enter icon name', 'diza' ),
                            'url'       => esc_html__( 'Link', 'diza' ),
                        ),
                    ),
                )
            );     

            // Mobile Search settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Search', 'diza'),
                'fields' => array( 
                    array(
                        'id'=>'mobile_search_type',
                        'type' => 'button_set',
                        'title' => esc_html__('Search Result', 'diza'),
                        'options' => array(
                            'post' => esc_html__('Post', 'diza'), 
                            'product' => esc_html__('Product', 'diza')
                        ),
                        'default' => 'product'
                    ),
                    array(
                        'id' => 'mobile_autocomplete_search',
                        'type' => 'switch',
                        'title' => esc_html__('Auto-complete Search?', 'diza'),
                        'default' => 1
                    ),
                    array(
                        'id'       => 'mobile_search_placeholder',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Placeholder', 'diza' ),
                        'default'  => esc_html__( 'Search for products...', 'diza' ),
                    ),   
                    array(
                        'id' => 'mobile_enable_search_category',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Search in Categories', 'diza'),
                        'default' => true
                    ), 
                    array(
                        'id' => 'mobile_show_search_product_image',
                        'type' => 'switch',
                        'title' => esc_html__('Show Image of Search Result', 'diza'),
                        'required' => array('mobile_autocomplete_search', '=', '1'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'mobile_show_search_product_price',
                        'type' => 'switch',
                        'title' => esc_html__('Show Price of Search Result', 'diza'),
                        'required' => array(array('mobile_autocomplete_search', '=', '1'), array('mobile_search_type', '=', 'product')),
                        'default' => true
                    ),  
                    array(
                        'id' => 'mobile_search_min_chars',
                        'type'  => 'slider',
                        'title' => esc_html__('Search Min Characters', 'diza'),
                        'default' => 2,
                        'min'   => 1,
                        'step'  => 1,
                        'max'   => 6,
                    ), 
                    array(
                        'id' => 'mobile_search_max_number_results',
                        'type'  => 'slider',
                        'title' => esc_html__('Number of Search Results', 'diza'),
                        'desc'  => esc_html__( 'Max number of results show in Mobile', 'diza' ),
                        'default' => 5,
                        'min'   => 2,
                        'step'  => 1,
                        'max'   => 20,
                    ), 
                )
            );


            // Menu mobile settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Menu Mobile', 'diza'),
                'fields' => array(
                    array(
                        'id' => 'enable_menu_mobile_effects',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Effects', 'diza'),
                        'default' => false
                    ),                    
                    array(
                        'id' => 'menu_mobile_effects_panels',
                        'type' => 'select', 
                        'title' => esc_html__('Panels Effect', 'diza'),
                        'required' => array('enable_menu_mobile_effects','=', true),
                        'options' => array( 
                            'fx-panels-none'            => esc_html__('No effect', 'diza'),
                            'fx-panels-slide-0'         => esc_html__('Slide 0', 'diza'),
                            'no-effect'                 => esc_html__('Slide 30', 'diza'),
                            'fx-panels-slide-100'       => esc_html__('Slide 100', 'diza'),
                            'fx-panels-slide-up'        => esc_html__('Slide uo', 'diza'),
                            'fx-panels-zoom'            => esc_html__('Zoom', 'diza'),
                        ),
                        'default' => 'no-effect'
                    ),                    
                    array(
                        'id' => 'menu_mobile_effects_listitems',
                        'type' => 'select', 
                        'title' => esc_html__('List Items Effect', 'diza'),
                        'required' => array('enable_menu_mobile_effects','=', true),
                        'options' => array( 
                            'no-effect'                          => esc_html__('No effect', 'diza'),
                            'fx-listitems-drop'         => esc_html__('Drop', 'diza'),
                            'fx-listitems-fade'         => esc_html__('Fade', 'diza'),
                            'fx-listitems-slide'        => esc_html__('slide', 'diza'),
                        ),
                        'default' => 'fx-listitems-fade'
                    ),
                    array(
                        'id'       => 'menu_mobile_title',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Menu Title Text', 'diza' ),
                        'default'  => esc_html__( 'Menu', 'diza' ),
                    ),                                                      
                    array(
                        'id' => 'enable_menu_third', 
                        'type' => 'switch',
                        'title' => esc_html__('Enable Bottom Menu', 'diza'),
                        'default' => true
                    ),  
                    array(
                        'id'       => 'menu_mobile_third_select',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__( 'Select Bottom Menu', 'diza' ),
                        'required' => array('enable_menu_third','=', true),
                        'desc'     => esc_html__( 'Select the menu you want to display.', 'diza' ),
                        'default' => 129
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'enable_menu_mobile_counters',
                        'type' => 'switch',
                        'title' => esc_html__('Main Menu Item Counter', 'diza'),
                        'default' => false
                    ),                     
                    array(
                        'id' => 'enable_menu_social',
                        'type' => 'switch',
                        'title' => esc_html__('Menu Social', 'diza'),
                        'default' => false
                    ), 
                    array(
                        'id'          => 'menu_social_slides',
                        'type'        => 'slides',
                        'title'       => esc_html__( 'Config Icon', 'diza' ),
                        'desc'        => esc_html__( 'This social will store all slides values into a multidimensional array to use into a foreach loop.', 'diza' ),
                        'class' => 'remove-upload-slides',
                        'show' => array(
                            'title' => true,
                            'description' => false,
                            'url' => true,
                        ),
                        'required' => array('enable_menu_social','=', true),
                        'placeholder'   => array(
                            'title'      => esc_html__( 'Enter icon name', 'diza' ),
                            'url'       => esc_html__( 'Link icon', 'diza' ),
                        ),
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id'       => 'menu_mobile_one_select',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__( 'Main Menu (Tab 01)', 'diza' ),
                        'subtitle' => '<em>'.esc_html__('Tab 1 menu option', 'diza').'</em>',
                        'desc'     => esc_html__( 'Select the menu you want to display.', 'diza' ),
                        'default' => 69
                    ),
                    array(
                        'id'       => 'menu_mobile_tab_one',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Tab 01 Title', 'diza' ),
                        'required' => array('enable_menu_second','=', true),
                        'default'  => esc_html__( 'Menu', 'diza' ),
                    ),
                    array(
                        'id'       => 'menu_mobile_tab_one_icon',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Tab 01 Icon', 'diza' ),
                        'required' => array('enable_menu_second','=', true),
                        'desc'       => esc_html__( 'Enter icon name of fonts: ', 'diza' ) . '<a href="//fontawesome.com/v4.7.0/" target="_blank">Awesome</a> , <a href="//fonts.thembay.com/simple-line-icons//" target="_blank">simplelineicons</a>, <a href="//fonts.thembay.com/linearicons/" target="_blank">linearicons</a>',
                        'default'  => 'fa fa-bars',
                    ), 
                    array(
                        'id' => 'enable_menu_second',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Tab 02', 'diza'),
                        'default' => false
                    ),    
                    array(
                        'id'       => 'menu_mobile_tab_scond',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Tab 02 Title', 'diza' ),
                        'required' => array('enable_menu_second','=', true),
                        'default'  => esc_html__( 'Categories', 'diza' ),
                    ), 
                    array(
                        'id'       => 'menu_mobile_second_select',
                        'type'     => 'select',
                        'data'     => 'menus',
                        'title'    => esc_html__( 'Tab 02 Menu Option', 'diza' ),
                        'required' => array('enable_menu_second','=', true),
                        'desc'     => esc_html__( 'Select the menu you want to display.', 'diza' ),
                        'default' => 54
                    ),
                    array(
                        'id'       => 'menu_mobile_tab_second_icon',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Tab 02 Icon', 'diza' ),
                        'required' => array('enable_menu_second','=', true),
                        'desc'       => esc_html__( 'Enter icon name of fonts: ', 'diza' ) . '<a href="//fontawesome.com/v4.7.0/" target="_blank">Awesome</a> , <a href="//fonts.thembay.com/simple-line-icons//" target="_blank">simplelineicons</a>, <a href="//fonts.thembay.com/linearicons/" target="_blank">linearicons</a>',
                        'default'  => 'icons icon-grid',
                    ), 
                )
            );
        

            // Mobile Woocommerce settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Mobile WooCommerce', 'diza'),
                'fields' => array(                
                    array(
                        'id' => 'mobile_product_number',
                        'type' => 'image_select',
                        'title' => esc_html__('Product Column in Shop page', 'diza'),
                        'options' => array(
                            'one' => array(
                                'title' => esc_html__( 'One Column', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/mobile/one_column.jpg'
                            ),                            
                            'two' => array(
                                'title' => esc_html__( 'Two Columns', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/mobile/two_columns.jpg'
                            ),
                        ),
                        'default' => 'two'
                    ),  
					array(
                        'id' => 'enable_add_cart_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show "Add to Cart" Button', 'diza'),
                        'subtitle' => esc_html__('On Home and page Shop', 'diza'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_wishlist_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show "Wishlist" Button', 'diza'),
                        'subtitle' => esc_html__('Enable or disable in Home and Shop page', 'diza'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_one_name_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show Full Product Name', 'diza'),
                        'subtitle' => esc_html__('Enable or disable in Home and Shop page', 'diza'),
                        'default' => false
                    ),
					array(
                        'id' => 'enable_quantity_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show Quantity', 'diza'),
                        'subtitle' => esc_html__('On Page Single Product', 'diza'),
                        'default' => false
                    ),  
                    array(
                        'id' => 'mobile_form_cart_style',
                        'type' => 'select',   
                        'title' => esc_html__('Add To Cart Form Type', 'diza'),
                        'subtitle' => esc_html__('On Page Single Product', 'diza'),
                        'options' => array(
                            'default' => esc_html__('Default', 'diza'),
                            'popup' => esc_html__('Popup', 'diza') 
                        ),
                        'default' => 'default'
                    ),                    
                    array(
                        'id' => 'enable_tabs_mobile',
                        'type' => 'switch',
                        'title' => esc_html__('Show Sidebar Tabs', 'diza'),
                        'subtitle' => esc_html__('On Page Single Product', 'diza'),
                        'default' => true
                    ),
                )
            );

            // Style
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-format-color-text',
                'title' => esc_html__('Style', 'diza'),
            ); 

            // Style
            $this->sections[] = array(
                'title' => esc_html__('Main', 'diza'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => 'boby_bg',
                        'type'     => 'background',
                        'output'   => array( 'body' ),
                        'title'    => esc_html__( 'Body Background', 'diza' ),
                        'subtitle' => esc_html__( 'Body background with image, color, etc.', 'diza' ),
                    ),
                    array(
                        'id'            => 'body_box_shadow',
                        'type'          => 'switch',
                        'title'         => esc_html__('Enable Body "box-shadow"', 'diza'),
                        'subtitle'      => esc_html__('Add a shadow box to the body', 'diza'),
                        'required'      => array('active_theme','=', 'medicine'),
                        'default'       => false
                    ),
                    array(
                        'id'        => 'container_max_width',
                        'type'      => 'slider',
                        'title'     => esc_html__('Max width container (px)', 'diza'),
                        'required'  => array('body_box_shadow','=', true),
                        "default"   => 1320,
                        "min"       => 992,
                        "step"      => 1,
                        "max"       => 1920,
                    ),
                    array(
                        'id'             => 'container_margin',
                        'type'           => 'spacing',
                        'mode'           => 'margin',
                        'units'          => array('px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Container Margin', 'diza'),
                        'required'      => array('body_box_shadow','=', true),
                        'default'            => array(
                            'margin-top'     => 0,
                            'margin-right'   => 0,
                            'margin-bottom'  => 0,
                            'margin-left'    => 0,
                            'units'          => 'px',
                        ),
                    ),
                    array (
                        'title' => esc_html__('Theme Main Color', 'diza'),
                        'id' => 'main_color',
                        'type' => 'color',
                        'transparent' => false,
                        'default' => $default_color['main_color'],
                        'output' => $output['main_color'],
                    ),                    
                    array (
                        'title' => esc_html__('Theme Main Color Second', 'diza'),
                        'subtitle' => '<em>'.esc_html__('The main color second of the site.', 'diza').'</em>',
                        'id' => 'main_color_second',
                        'type' => 'color', 
                        'transparent' => false,
                        'required' => array('active_theme','=',array('protective')),
                        'default' => $default_color['main_color_second'],
                        'output' => $output['main_color_second'],
                    ),
                )
            );

            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Typography', 'diza'),
                'fields' => array(
                    array(
                        'id' => 'show_typography',
                        'type' => 'switch',
                        'title' => esc_html__('Edit Typography', 'diza'),
                        'default' => false
                    ),
                    array(
                        'title'    => esc_html__('Font Source', 'diza'),
                        'id'       => 'font_source',
                        'type'     => 'radio',
                        'required' => array('show_typography','=', true),
                        'options'  => array(
                            '1' => 'Standard + Google Webfonts',
                            '2' => 'Google Custom',
                            '3' => 'Custom Fonts'
                        ),
                        'default' => '1'
                    ),
                    array(
                        'id'=>'font_google_code',
                        'type' => 'text',
                        'title' => esc_html__('Google Link', 'diza'), 
                        'subtitle' => '<em>'.esc_html__('Paste the provided Google Code', 'diza').'</em>',
                        'default' => '',
                        'desc' => esc_html__('e.g.: https://fonts.googleapis.com/css?family=Open+Sans', 'diza'),
                        'required' => array('font_source','=','2')
                    ),

                    array (
                        'id' => 'main_custom_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;">'. sprintf(
                                                                    '%1$s <a href="%2$s">%3$s</a>',
                                                                    esc_html__( 'Video guide custom font in ', 'diza' ),
                                                                    esc_url( 'https://www.youtube.com/watch?v=ljXAxueAQUc' ),
                                                                    esc_html__( 'here', 'diza' )
                                ) .'</h3>',
                        'required' => array('font_source','=','3')
                    ),

                    array (
                        'id' => 'main_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '.esc_html__('Main Font', 'diza').'</h3>',
                        'required' => array('show_typography','=', true),
                    ),                    

                    // Standard + Google Webfonts
                    array (
                        'title' => esc_html__('Font Face', 'diza'),
                        'id' => 'main_font',
                        'type' => 'typography',
                        'line-height' => false,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => false,
                        'all_styles'=> true,
                        'font-size' => false,
                        'color' => false,
                        'output' => $output['primary-font'],
                        'default' => array (
                            'font-family' => '',
                            'subsets' => '',
                        ),
                        'required' => array( 
                            array('font_source','=','1'), 
                            array('show_typography','=', true) 
                        )
                    ),
                    
                    // Google Custom                        
                    array (
                        'title' => esc_html__('Google Font Face', 'diza'),
                        'subtitle' => '<em>'.esc_html__('Enter your Google Font Name for the theme\'s Main Typography', 'diza').'</em>',
                        'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'diza'),
                        'id' => 'main_google_font_face',
                        'type' => 'text',
                        'default' => '',
                        'required' => array('font_source','=','2')
                    ),                    

                    // main Custom fonts                      
                    array (
                        'title' => esc_html__('Main custom Font Face', 'diza'),
                        'subtitle' => '<em>'.esc_html__('Enter your Custom Font Name for the theme\'s Main Typography', 'diza').'</em>',
                        'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'diza'),
                        'id' => 'main_custom_font_face',
                        'type' => 'text',
                        'default' => '',
                        'required' => array('font_source','=','3')
                    ),

                    array (
                        'id' => 'secondary_font_info',
                        'icon' => true,
                        'type' => 'info',
                        'raw' => '<h3 style="margin: 0;"> '. esc_html__(' Secondary Font', 'diza').'</h3>',
                        'required' => array('show_typography','=', true),
                    ),
                    
                    // Standard + Google Webfonts
                    array (
                        'title' => esc_html__('Font Face', 'diza'),
                        'id' => 'secondary_font',
                        'type' => 'typography',
                        'line-height' => false,
                        'text-align' => false,
                        'font-style' => false,
                        'font-weight' => false,
                        'all_styles'=> true,
                        'font-size' => false,
                        'output' => $output['secondary-font'],
                        'color' => false,
                        'required' => array( 
                            array('font_source','=','1'), 
                            array('show_typography','=', true) 
                        )
                        
                    ),
                    
                    // Google Custom                        
                    array (
                        'title' => esc_html__('Google Font Face', 'diza'),
                        'subtitle' => '<em>'. esc_html__('Enter your Google Font Name for the theme\'s Secondary Typography', 'diza').'</em>',
                        'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'diza'),
                        'id' => 'secondary_google_font_face',
                        'type' => 'text',
                        'default' => '',
                        'required' => array('font_source','=','2')
                    ),                    

                    // Main Custom fonts                        
                    array (
                        'title' => esc_html__('Main Custom Font Face', 'diza'),
                        'subtitle' => '<em>'. esc_html__('Enter your Custom Font Name for the theme\'s Secondary Typography', 'diza').'</em>',
                        'desc' => esc_html__('e.g.: &#39;Open Sans&#39;, sans-serif', 'diza'),
                        'id' => 'secondary_custom_font_face',
                        'type' => 'text',
                        'default' => '',
                        'required' => array('font_source','=','3')
                    ),
                )
            );

            // Style
            $this->sections[] = array(
                'title' => esc_html__('Header Mobile', 'diza'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'       => 'header_mobile_bg',
                        'type'     => 'background',
                        'output' => $output['header_mobile_bg'],
                        'title'    => esc_html__( 'Header Mobile Background', 'diza' ),
                    ),
                    array (
                        'title' => esc_html__('Header Color', 'diza'),
                        'id' => 'header_mobile_color',
                        'type' => 'color',
                        'transparent' => false,
                        'output' => $output['header_mobile_color'],
                    ),                    
                )
            );


            // WooCommerce
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-shopping-cart',
                'title' => esc_html__('WooCommerce', 'diza'),
                'fields' => array(       
                    array(
                        'title'    => esc_html__('Label Sale Format', 'diza'),
                        'id'       => 'sale_tags',
                        'type'     => 'radio',
                        'options'  => array( 
                            'Sale!' => esc_html__('Sale!' ,'diza'),
                            'Save {percent-diff}%' => esc_html__('Save {percent-diff}% (e.g "Save 50%")' ,'diza'),
                            'Save {symbol}{price-diff}' => esc_html__('Save {symbol}{price-diff} (e.g "Save $50")' ,'diza'),
                            'custom' => esc_html__('Custom Format (e.g -50%, -$50)' ,'diza')
                        ),
                        'default' => 'custom'
                    ),
                    array(
                        'id'        => 'sale_tag_custom',
                        'type'      => 'text',
                        'title'     => esc_html__( 'Custom Format', 'diza' ),
                        'desc'      => esc_html__('{price-diff} inserts the dollar amount off.', 'diza'). '</br>'.
                                       esc_html__('{percent-diff} inserts the percent reduction (rounded).', 'diza'). '</br>'.
                                       esc_html__('{symbol} inserts the Default currency symbol.', 'diza'), 
                        'required'  => array('sale_tags','=', 'custom'),
                        'default'   => '-{percent-diff}%'
                    ), 
                    array(
                        'id' => 'enable_label_featured',
                        'type' => 'switch',
                        'title' => esc_html__('Enable "Featured" Label', 'diza'),
                        'default' => true
                    ),   
                    array(
                        'id'        => 'custom_label_featured',
                        'type'      => 'text',
                        'title'     => esc_html__( '"Featured Label" Custom Text', 'diza' ),
                        'required'  => array('enable_label_featured','=', true),
                        'default'   => esc_html__('Featured', 'diza')
                    ),
                    
                    array(
                        'id' => 'enable_brand',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Brand Name', 'diza'),
                        'subtitle' => esc_html__('Enable/Disable brand name on HomePage and Shop Page', 'diza'),
                        'default' => false
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),            
                    array(
                        'id' => 'product_display_image_mode',
                        'type' => 'image_select',
                        'title' => esc_html__('Product Image Display Mode', 'diza'),
                        'options' => array(
                            'one' => array(
                                'title' => esc_html__( 'Single Image', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/image_mode/single-image.png'
                            ),                                  
                            'two' => array(
                                'title' => esc_html__( 'Double Images (Hover)', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/image_mode/display-hover.gif'
                            ),                                                                         
                            'slider' => array(
                                'title' => esc_html__( 'Images (carousel)', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/image_mode/display-carousel.gif'
                            ),                                                      
                        ),
                        'default' => 'slider'
                    ),
                    array(
                        'id' => 'enable_quickview',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Quick View', 'diza'),
                        'default' => 1
                    ),                    
                    array(
                        'id' => 'enable_woocommerce_catalog_mode',
                        'type' => 'switch',
                        'title' => esc_html__('Show WooCommerce Catalog Mode', 'diza'),
                        'default' => false
                    ),                     
                    array(
                        'id' => 'ajax_update_quantity',
                        'type' => 'switch',
                        'title' => esc_html__('Quantity Ajax Auto-update', 'diza'),
                        'subtitle' => esc_html__('Enable/Disable quantity ajax auto-update on page Cart', 'diza'),
                        'default' => true
                    ),   
					array(
                        'id' => 'enable_variation_swatch',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Product Variation Swatch', 'diza'),
                        'subtitle' => esc_html__('Enable/Disable Product Variation Swatch on HomePage and Shop page', 'diza'),
                        'default' => true
                    ), 
                    array(
                        'id' => 'variation_swatch',
                        'type' => 'select',
                        'title' => esc_html__('Product Attribute', 'diza'),
                        'options' => diza_tbay_get_variation_swatchs(),
                        'default' => ''
                    ),  					                
                )
            );

            // woocommerce Breadcrumb settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Mini Cart', 'diza'),
                'fields' => array(
                     array(
                        'id' => 'woo_mini_cart_position',
                        'type' => 'select', 
                        'title' => esc_html__('Mini-Cart Position', 'diza'),
                        'options' => array( 
                            'left'       => esc_html__('Left', 'diza'),
                            'right'      => esc_html__('Right', 'diza'),
                            'popup'      => esc_html__('Popup', 'diza'),
                            'no-popup'   => esc_html__('None Popup', 'diza')
                        ),
                        'default' => 'popup'
                    ), 
                )
            ); 

            // woocommerce Breadcrumb settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Breadcrumb', 'diza'),
                'fields' => array(
                    array(
                        'id' => 'show_product_breadcrumb',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Breadcrumb', 'diza'),
                        'default' => true
                    ),
                    array(
                        'id' => 'product_breadcrumb_layout',
                        'type' => 'image_select',
                        'class'     => 'image-two',
                        'compiler' => true,
                        'title' => esc_html__('Breadcrumb Layout', 'diza'),
                        'required' => array('show_product_breadcrumb','=',1),
                        'options' => array(                          
                            'image' => array(
                                'title' => esc_html__( 'Background Image', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/breadcrumbs/image.jpg'
                            ),
                            'color' => array(
                                'title' => esc_html__( 'Background color', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/breadcrumbs/color.jpg'
                            ),
                            'text'=> array(
                                'title' => esc_html__( 'Text Only', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/breadcrumbs/text_only.jpg'
                            ),
                        ),
                        'default' => 'color'
                    ),
                    array (
                        'title' => esc_html__('Breadcrumb Background Color', 'diza'),
                        'subtitle' => '<em>'.esc_html__('The Breadcrumb background color of the site.', 'diza').'</em>',
                        'id' => 'woo_breadcrumb_color',
                        'required' => array('product_breadcrumb_layout','=',array('default','color')),
                        'type' => 'color',
                        'default' => '#f4f9fc',
                        'transparent' => false,
                    ),
                    array( 
                        'id' => 'woo_breadcrumb_image',
                        'type' => 'media',
                        'title' => esc_html__('Breadcrumb Background', 'diza'),
                        'subtitle' => esc_html__('Upload a .jpg or .png image that will be your Breadcrumb.', 'diza'),
                        'required' => array('product_breadcrumb_layout','=','image'),
                        'default'  => array( 
                            'url'=> DIZA_IMAGES .'/breadcrumbs-woo.jpg'
                        ),
                    ),
                    array(
                        'id' => 'enable_previous_page_woo',
                        'type' => 'switch',
                        'title' => esc_html__('Previous page', 'diza'),
                        'default' => true
                    ), 
                )
            ); 

            // WooCommerce Archive settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Shop', 'diza'),
                'fields' => array(       
                    array(
                        'id' => 'product_archive_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Shop Layout', 'diza'),
                        'options' => array(
                            'shop-left' => array(
                                'title' => esc_html__( 'Left Sidebar', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/product_archives/shop_left_sidebar.jpg'
                            ),                                  
                            'shop-right' => array(
                                'title' => esc_html__( 'Right Sidebar', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/product_archives/shop_right_sidebar.jpg'
                            ),                                                                         
                            'full-width' => array(
                                'title' => esc_html__( 'No Sidebar', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/product_archives/shop_no_sidebar.jpg'
                            ),                                                      
                        ),
                        'default' => 'shop-left'
                    ),
                    array(
                        'id' => 'product_archive_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Archive Sidebar', 'diza'),
                        'options' => $sidebars,
                        'default' => 'product-archive'
                    ),
                    array(
                        'id' => 'show_product_top_archive',
                        'type' => 'switch',
                        'title' => esc_html__('Show sidebar Top Archive product', 'diza'),
                        'default' => false
                    ),   
                    array(
                        'id' => 'enable_display_mode',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Products Display Mode', 'diza'),
                        'subtitle' => esc_html__('Enable/Disable Display Mode', 'diza'),
                        'default' => true
                    ),   
                    array(
                        'id' => 'product_display_mode',
                        'type' => 'button_set',
                        'title' => esc_html__('Products Display Mode', 'diza'),
                        'required' => array('enable_display_mode','=',1),
                        'options' => array(
                            'grid' => esc_html__('Grid', 'diza'), 
                            'list' => esc_html__('List', 'diza')
                        ),
                        'default' => 'grid'
                    ),                                
                    array(
                        'id' => 'title_product_archives',
                        'type' => 'switch',
                        'title' => esc_html__('Show Title of Categories', 'diza'),
                        'default' => false 
                    ),                       
                    array(
                        'id' => 'pro_des_image_product_archives',
                        'type' => 'switch',
                        'title' => esc_html__('Show Description, Image of Categories', 'diza'),
                        'default' => true
                    ),
                    array(
                        'id' => 'number_products_per_page',
                        'type' => 'slider',
                        'title' => esc_html__('Number of Products Per Page', 'diza'),
                        'default' => 12,
                        'min' => 1,
                        'step' => 1,
                        'max' => 100,
                    ),
                    array(
                        'id' => 'product_columns',
                        'type' => 'select',
                        'title' => esc_html__('Product Columns', 'diza'),
                        'options' => $columns,
                        'default' => 4
                    ),
                    array(
                        'id' => 'product_pagination_style',
                        'type' => 'select',
                        'title' => esc_html__('Product Pagination Style', 'diza'),
                        'options' => array( 
                            'number' => esc_html__('Pagination Number', 'diza'),
                            'loadmore'  => esc_html__('Load More Button', 'diza'),  
                        ),
                        'default' => 'number' 
                    ),
                    array(
                        'id' => 'product_type_fillter',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Shop by Product Type', 'diza'),
                        'default' => 0
                    ),                     
                    array(
                        'id' => 'product_per_page_fillter',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Number of Product', 'diza'),
                        'default' => 0
                    ),                       
                    array(
                        'id' => 'product_category_fillter',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Shop by Categories', 'diza'),
                        'default' => 0
                    ),                    
                )
            );
            // Product Page
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Single Product', 'diza'),
                'fields' => array(
                    array(
                        'id' => 'product_single_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Select Single Product Layout', 'diza'),
                        'options' => array(
                            'vertical' => array(
                                'title' => esc_html__('Image Vertical', 'diza'),
                                'img' => DIZA_ASSETS_IMAGES . '/product_single/verical_thumbnail.jpg'
                            ),                             
                            'horizontal' => array(
                                'title' => esc_html__('Image Horizontal', 'diza'),
                                'img' => DIZA_ASSETS_IMAGES . '/product_single/horizontal_thumbnail.jpg'
                            ),                                                                                  
                            'left-main' => array(
                                'title' => esc_html__('Left - Main Sidebar', 'diza'),
                                'img' => DIZA_ASSETS_IMAGES . '/product_single/left_main_sidebar.jpg'
                            ),
                            'main-right' => array(
                                'title' => esc_html__('Main - Right Sidebar', 'diza'),
                                'img' => DIZA_ASSETS_IMAGES . '/product_single/main_right_sidebar.jpg'
                            ),
                        ),
                        'default' => 'horizontal'
                    ),                   
                    array(
                        'id' => 'product_single_sidebar',
                        'type' => 'select',
                        'required' => array('product_single_layout','=',array('left-main','main-right')),
                        'title' => esc_html__('Single Product Sidebar', 'diza'),
                        'options' => $sidebars,
                        'default' => 'product-single'
                    ),
                )
            );


            // Product Page
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Single Product Advanced Options', 'diza'),
                'fields' => array(
                    array(
                        'id' => 'enable_total_sales',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Total Sales', 'diza'),
                        'default' => true
                    ),                     
                    array(
                        'id' => 'enable_buy_now',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Buy Now', 'diza'),
                        'default' => false
                    ),
                    array(
                        'title' => esc_html__('Background', 'diza'),
                        'subtitle' => esc_html__('Background button Buy Now', 'diza'),
                        'id' => 'bg_buy_now', 
                        'required' => array('enable_buy_now','=',true),
                        'type' => 'color',
                        'transparent' => false,
                        'default' => '#075cc9',
                    ),      
                    array( 
                        'id' => 'redirect_buy_now',
                        'required' => array('enable_buy_now','=',true),
                        'type' => 'button_set',
                        'title' => esc_html__('Redirect to page after Buy Now', 'diza'),
                        'options' => array( 
                                'cart'          => 'Page Cart',
                                'checkout'      => 'Page CheckOut',
                        ),
                        'default' => 'cart'
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),   
                    array(
                        'id' => 'style_single_tabs_style',
                        'type' => 'button_set',
                        'title' => esc_html__('Tab Mode', 'diza'),
                        'options' => array(
                                'fulltext'          => 'Full Text',
                                'tabs'          => 'Tabs',
                                'accordion'        => 'Accordion',
                        ),
                        'default' => 'fulltext'
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                    array(
                        'id' => 'enable_size_guide',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Size Guide', 'diza'),
                        'default' => 1
                    ),
                    array(
                        'id'       => 'size_guide_title',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Size Guide Title', 'diza' ),
                        'required' => array('enable_size_guide','=', true),
                        'default'  => esc_html__( 'Size chart', 'diza' ),
                    ),    
                    array(
                        'id'       => 'size_guide_icon',
                        'type'     => 'text',
                        'title'    => esc_html__( 'Size Guide Icon', 'diza' ),
                        'required' => array('enable_size_guide','=', true),
                        'desc'       => esc_html__( 'Enter icon name of fonts: ', 'diza' ) . '<a href="//fontawesome.com/v4.7.0/" target="_blank">Awesome</a> , <a href="//fonts.thembay.com/simple-line-icons//" target="_blank">simplelineicons</a>, <a href="//fonts.thembay.com/linearicons/" target="_blank">linearicons</a>',
                        'default'  => 'tb-icon tb-icon-chevron-right',
                    ),                
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),
                   array(
                        'id' => 'show_product_nav',
                        'type' => 'switch', 
                        'title' => esc_html__('Enable Product Navigator', 'diza'),
                        'default' => true
                    ),        
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),    
                    array(
                        'id' => 'enable_sticky_menu_bar',
                        'type' => 'switch',
                        'title' => esc_html__('Sticky Menu Bar', 'diza'),
                        'subtitle' => esc_html__('Enable/disable Sticky Menu Bar', 'diza'),
                        'default' => false
                    ),
                    array(
                        'id' => 'enable_zoom_image',
                        'type' => 'switch',
                        'title' => esc_html__('Zoom inner image', 'diza'),
                        'subtitle' => esc_html__('Enable/disable Zoom inner Image', 'diza'),
                        'default' => false
                    ),    
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide', 
                        'type' => 'divide'
                    ),                 
                    array(
                        'id' => 'video_aspect_ratio',
                        'type' => 'select',
                        'title' => esc_html__('Featured Video Aspect Ratio', 'diza'),
                        'subtitle' => esc_html__('Choose the aspect ratio for your video', 'diza'),
                        'options' => $aspect_ratio,
                        'default' => '16_9'
                    ),     
                    array(
                        'id'      => 'video_position',
                        'title'    => esc_html__( 'Featured Video Position', 'diza' ),
                        'type'    => 'select',
                        'default' => 'last',
                        'options' => array(
                            'last' => esc_html__( 'The last product gallery', 'diza' ),
                            'first' => esc_html__( 'The first product gallery', 'diza' ),
                        ),
                    ),  
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),              
                    array(
                        'id' => 'enable_product_social_share',
                        'type' => 'switch',
                        'title' => esc_html__('Social Share', 'diza'),
                        'subtitle' => esc_html__('Enable/disable Social Share', 'diza'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_product_review_tab',
                        'type' => 'switch',
                        'title' => esc_html__('Product Review Tab', 'diza'),
                        'subtitle' => esc_html__('Enable/disable Review Tab', 'diza'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_product_releated',
                        'type' => 'switch',
                        'title' => esc_html__('Products Releated', 'diza'),
                        'subtitle' => esc_html__('Enable/disable Products Releated', 'diza'),
                        'default' => true
                    ),
                    array(
                        'id' => 'enable_product_upsells',
                        'type' => 'switch',
                        'title' => esc_html__('Products upsells', 'diza'),
                        'subtitle' => esc_html__('Enable/disable Products upsells', 'diza'),
                        'default' => true
                    ),                    
                    array(
                        'id' => 'enable_product_countdown',
                        'type' => 'switch',
                        'title' => esc_html__('Products Countdown', 'diza'),
                        'subtitle' => esc_html__('Enable/disable Products Countdown', 'diza'),
                        'default' => true
                    ),
                    array(
                        'id' => 'number_product_thumbnail',
                        'type'  => 'slider',
                        'title' => esc_html__('Number Images Thumbnail to show', 'diza'),
                        'default' => 4,
                        'min'   => 2,
                        'step'  => 1,
                        'max'   => 5,
                    ),  
                    array(
                        'id' => 'number_product_releated',
                        'type' => 'slider',
                        'title' => esc_html__('Number of related products to show', 'diza'),
                        'default' => 8,
                        'min' => 1,
                        'step' => 1,
                        'max' => 20,
                    ),                    
                    array(
                        'id' => 'releated_product_columns',
                        'type' => 'select',
                        'title' => esc_html__('Releated Products Columns', 'diza'),
                        'options' => $columns,
                        'default' => 4
                    ),
                    array(
                        'id'       => 'html_before_add_to_cart_btn',
                        'type'     => 'textarea',
                        'title'    => esc_html__( 'HTML before Add To Cart button (Global)', 'diza' ),
                        'desc'     => esc_html__( 'Enter HTML and shortcodes that will show before Add to cart selections.', 'diza' ),
                    ),
                    array(
                        'id'       => 'html_after_add_to_cart_btn',
                        'type'     => 'textarea',
                        'title'    => esc_html__( 'HTML after Add To Cart button (Global)', 'diza' ),
                        'desc'     => esc_html__( 'Enter HTML and shortcodes that will show after Add to cart button.', 'diza' ),
                    ),
                )

            );
          
            // woocommerce Menu Account settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Account', 'diza'),
                'fields' => array(
                    array(
                        'id' => 'show_confirm_password',
                        'type' => 'switch',
                        'title' => esc_html__('Show Confirm Password', 'diza'),
                        'default' => true
                    ), 
                    array(
                        'id' => 'show_woocommerce_password_strength',
                        'type' => 'switch',
                        'title' => esc_html__('Show Password Strength Meter', 'diza'),
                        'default' => true
                    ),  
                )
            );

            // Blog settings
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-border-color',
                'title' => esc_html__('Blog', 'diza'),
                'fields' => array(
                    array(
                        'id' => 'show_blog_breadcrumb',
                        'type' => 'switch',
                        'title' => esc_html__('Breadcrumb', 'diza'),
                        'default' => 1
                    ),
                    array(
                        'id' => 'blog_breadcrumb_layout',
                        'type' => 'image_select',
                        'class'     => 'image-two',
                        'compiler' => true,
                        'title' => esc_html__('Select Breadcrumb Blog Layout', 'diza'),
                        'required' => array('show_blog_breadcrumb','=',1),
                        'options' => array(                        
                            'image' => array(
                                'title' => esc_html__( 'Background Image', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/breadcrumbs/image.jpg'
                            ),
                            'color' => array(
                                'title' => esc_html__( 'Background color', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/breadcrumbs/color.jpg'
                            ),
                            'text'=> array(
                                'title' => esc_html__( 'Text Only', 'diza' ),
                                'img'   => DIZA_ASSETS_IMAGES . '/breadcrumbs/text_only.jpg'
                            ),
                        ),
                        'default' => 'color'
                    ),
                    array (
                        'title' => esc_html__('Breadcrumb Background Color', 'diza'),
                        'id' => 'blog_breadcrumb_color',
                        'type' => 'color',
                        'default' => '#fafafa',
                        'transparent' => false,
                        'required' => array('blog_breadcrumb_layout','=',array('default','color')),
                    ),
                    array(
                        'id' => 'blog_breadcrumb_image',
                        'type' => 'media',
                        'title' => esc_html__('Breadcrumb Background Image', 'diza'),
                        'subtitle' => esc_html__('Image File (.png or .jpg)', 'diza'),
                        'default'  => array(
                            'url'=> DIZA_IMAGES .'/breadcrumbs-blog.jpg'
                        ),
                        'required' => array('blog_breadcrumb_layout','=','image'),
                    ),
                    array(
                        'id' => 'enable_previous_page_post',
                        'type' => 'switch',
                        'title' => esc_html__('Previous page', 'diza'),
                        'subtitle' => esc_html__('Enable Previous Page Button', 'diza'),
                        'default' => true
                    ), 
                )
            );

            // Archive Blogs settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Blog Article', 'diza'),
                'fields' => array(
                    array(
                        'id' => 'blog_archive_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Blog Layout', 'diza'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__( 'Articles', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/blog_archives/blog_no_sidebar.jpg'
                            ),
                            'left-main' => array(
                                'title' => esc_html__( 'Articles - Left Sidebar', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/blog_archives/blog_left_sidebar.jpg'
                            ),
                            'main-right' => array(
                                'title' => esc_html__( 'Articles - Right Sidebar', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/blog_archives/blog_right_sidebar.jpg'
                            ),                   
                        ),
                        'default' => 'main-right'
                    ),
                    array(
                        'id' => 'blog_archive_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Blog Archive Sidebar', 'diza'),
                        'options' => $sidebars,
                        'default' => 'blog-archive-sidebar',
                        'required' => array('blog_archive_layout','!=','main'),
                    ),
                    array(
                        'id' => 'blog_columns',
                        'type' => 'select',
                        'title' => esc_html__('Post Column', 'diza'),
                        'options' => $columns,
                        'default' => '2'
                    ),
                    array(
                        'id'   => 'opt-divide',
                        'class' => 'big-divide',
                        'type' => 'divide'
                    ),   
                    array(
                        'id' => 'image_position',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Post Image Position', 'diza'),
                        'options' => array(
                            'top' => array(
                                'title' => esc_html__( 'Top', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/blog_archives/image_top.jpg'
                            ),
                            'left' => array(
                                'title' => esc_html__( 'Left', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/blog_archives/image_left.jpg'
                            ),                  
                        ),
                        'default' => 'top'
                    ),                 
                    array(
                        'id' => 'blog_image_sizes',
                        'type' => 'select',
                        'title' => esc_html__('Post Image Size', 'diza'),
                        'options' => $blog_image_size,
                        'default' => 'full'
                    ),                 
                    array(
                        'id' => 'enable_date',
                        'type' => 'switch',
                        'title' => esc_html__('Date', 'diza'),
                        'default' => true
                    ),                    
                    array(
                        'id' => 'enable_author',
                        'type' => 'switch',
                        'title' => esc_html__('Author', 'diza'),
                        'default' => false
                    ),                        
                    array(
                        'id' => 'enable_categories',
                        'type' => 'switch',
                        'title' => esc_html__('Categories', 'diza'),
                        'default' => true
                    ),                                            
                    array(
                        'id' => 'enable_comment',
                        'type' => 'switch',
                        'title' => esc_html__('Comment', 'diza'),
                        'default' => true
                    ),                    
                    array(
                        'id' => 'enable_comment_text',
                        'type' => 'switch',
                        'title' => esc_html__('Comment Text', 'diza'),
                        'required' => array('enable_comment', '=', true),
                        'default' => false
                    ),                    
                    array(
                        'id' => 'enable_short_descriptions',
                        'type' => 'switch',
                        'title' => esc_html__('Short descriptions', 'diza'),
                        'default' => false
                    ),                    
                    array(
                        'id' => 'enable_readmore',
                        'type' => 'switch',
                        'title' => esc_html__('Read More', 'diza'),
                        'default' => false
                    ),
                    array(
                        'id' => 'text_readmore',
                        'type' => 'text',
                        'title' => esc_html__('Button "Read more" Custom Text', 'diza'),
                        'required' => array('enable_readmore', '=', true),
                        'default' => 'Continue Reading',
                    ),
                )
            );

            // Single Blogs settings
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Blog Post', 'diza'),
                'fields' => array(
                    
                    array(
                        'id' => 'blog_single_layout',
                        'type' => 'image_select',
                        'compiler' => true,
                        'title' => esc_html__('Blog Single Layout', 'diza'),
                        'options' => array(
                            'main' => array(
                                'title' => esc_html__( 'Main Only', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/single _post/main.jpg'
                            ),
                            'left-main' => array(
                                'title' => esc_html__( 'Left - Main Sidebar', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/single _post/left_sidebar.jpg'
                            ),
                            'main-right' => array(
                                'title' => esc_html__( 'Main - Right Sidebar', 'diza' ),
                                'img' => DIZA_ASSETS_IMAGES . '/single _post/right_sidebar.jpg'
                            ),
                        ),
                        'default' => 'main-right'
                    ),
                    array(
                        'id' => 'blog_single_sidebar',
                        'type' => 'select',
                        'title' => esc_html__('Single Blog Sidebar', 'diza'),
                        'options'   => $sidebars,
                        'default'   => 'blog-single-sidebar',
                        'required' => array('blog_single_layout','!=','main'),
                    ),
                    array(
                        'id' => 'show_blog_social_share',
                        'type' => 'switch',
                        'title' => esc_html__('Show Social Share', 'diza'),
                        'default' => 1
                    ),

                )
            );

            // Social Media
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-share',
                'title' => esc_html__('Social Share', 'diza'),
                'fields' => array(
                    array(
                        'id' => 'enable_code_share',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Code Share', 'diza'),
                        'default' => true
                    ),
                    array(
                        'id'       => 'select_share_type',
                        'type'     => 'button_set',
                        'title'    => esc_html__( 'Please select a sharing type', 'diza' ),
                        'required'  => array('enable_code_share','=', true),
                        'options'  => array(
                            'custom' => 'TB Share',
                            'addthis' => 'Add This',
                        ),
                        'default'  => 'addthis'
                    ),
                    array(
                        'id'        =>'code_share',
                        'type'      => 'textarea',
                        'required'  => array('select_share_type','=', 'addthis'),
                        'title'     => esc_html__('"Addthis" Your Code', 'diza'), 
                        'desc'      => esc_html__('You get your code share in https://www.addthis.com', 'diza'),
                        'validate'  => 'html_custom',
                        'default'   => '<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59f2a47d2f1aaba2"></script>'
                    ),
                    array(
                        'id'       => 'sortable_sharing',
                        'type'     => 'sortable',
                        'mode'     => 'checkbox',
                        'title'    => esc_html__( 'Sortable Sharing', 'diza' ),
                        'required'  => array('select_share_type','=', 'custom'),
                        'options'  => array(
                            'facebook'      => 'Facebook',
                            'twitter'       => 'Twitter',
                            'linkedin'      => 'Linkedin',
                            'pinterest'     => 'Pinterest',
                            'whatsapp'      => 'Whatsapp',
                            'email'         => 'Email',
                        ),
                        'default'   => array(
                            'facebook'  => true,
                            'twitter'   => true,
                            'linkedin'  => true,
                            'pinterest' => false,
                            'whatsapp'  => false,
                            'email'     => true,
                        )
                    ),
                )
            );

            // Performance
            $this->sections[] = array(
                'icon' => 'el-icon-cog',
                'title' => esc_html__('Performance', 'diza'),
            );   
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Performance', 'diza'),
                'fields' => array(
                    array (
                        'id'       => 'minified_js',
                        'type'     => 'switch',
                        'title'    => esc_html__('Include minified JS', 'diza'),
                        'subtitle' => esc_html__('Minified version of functions.js and device.js file will be loaded', 'diza'),
                        'default' => true
                    ),
                )
            );

            // Custom Code
            $this->sections[] = array(
                'icon' => 'zmdi zmdi-code-setting',
                'title' => esc_html__('Custom CSS/JS', 'diza'),
            );            

            // Css Custom Code
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Custom CSS', 'diza'),
                'fields' => array(
                    array (
                        'title' => esc_html__('Global Custom CSS', 'diza'),
                        'id' => 'custom_css',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom CSS for desktop', 'diza'),
                        'id' => 'css_desktop',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom CSS for tablet', 'diza'),
                        'id' => 'css_tablet',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom CSS for mobile landscape', 'diza'),
                        'id' => 'css_wide_mobile',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                    array (
                        'title' => esc_html__('Custom CSS for mobile', 'diza'),
                        'id' => 'css_mobile',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                    ),
                )
            );

            // Js Custom Code
            $this->sections[] = array(
                'subsection' => true,
                'title' => esc_html__('Custom Js', 'diza'),
                'fields' => array(
                    array (
                        'title' => esc_html__('Header JavaScript Code', 'diza'),
                        'subtitle' => '<em>'.esc_html__('Paste your custom JS code here. The code will be added to the header of your site.', 'diza').'<em>',
                        'id' => 'header_js',
                        'type' => 'ace_editor',
                        'mode' => 'javascript',
                    ),
                    
                    array (
                        'title' => esc_html__('Footer JavaScript Code', 'diza'),
                        'subtitle' => '<em>'.esc_html__('Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.', 'diza').'<em>',
                        'id' => 'footer_js',
                        'type' => 'ace_editor',
                        'mode' => 'javascript',
                    ),
                )
            );



            $this->sections[] = array(
                'title' => esc_html__('Import / Export', 'diza'),
                'desc' => esc_html__('Import and Export your Redux Framework settings from file, text or URL.', 'diza'),
                'icon' => 'zmdi zmdi-download',
                'fields' => array(
                    array(
                        'id' => 'opt-import-export',
                        'type' => 'import_export',
                        'title' => 'Import Export',
                        'subtitle' => 'Save and restore your Redux options',
                        'full_width' => false,
                    ),
                ),
            );

            $this->sections[] = array(
                'type' => 'divide',
            );
        }
		
		
		
		
        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
		 
		 /**
     * Custom function for the callback validation referenced above
     * */
		
		 
        public function setArguments()
        {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'diza_tbay_theme_options',
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'),
                // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'),
                // Version that appears at the top of your panel
                'menu_type' => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true,
                // Show the sections below the admin menu item or not
                'menu_title' => esc_html__('Diza Options', 'diza'),
                'page_title' => esc_html__('Diza Options', 'diza'),

                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography' => false,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar' => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon' => 'diza-admin-icon',
                // Choose an icon for the admin bar menu
                'admin_bar_priority' => 50,
                // Choose an priority for the admin bar menu
                'global_variable' => 'diza_options',
                // Set a different name for your global variable other than the opt_name
                'dev_mode' => false,
				'forced_dev_mode_off' => false,
                // Show the time the page took to load, etc
                'update_notice' => true,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer' => true,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority' => 61,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions' => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon' => DIZA_ASSETS_IMAGES . '/admin/theme-admin-icon-small.png', 
                // Specify a custom URL to an icon
                'last_tab' => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options',
                // Page slug used to denote the panel
                'save_defaults' => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show' => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info' => false,
                // REMOVE

                // HINTS
                'hints' => array(
                    'icon' => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color' => 'lightgray',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light',
                        'shadow' => true,
                        'rounded' => false,
                        'style' => '',
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'mouseover',
                        ),
                        'hide' => array(
                            'effect' => 'slide',
                            'duration' => '500',
                            'event' => 'click mouseleave',
                        ),
                    ),
                )
            );
            
            $this->args['intro_text'] = '';

            // Add content after the form.
            $this->args['footer_text'] = '';
            return $this->args;
			
			if ( ! function_exists( 'redux_validate_callback_function' ) ) {
				function redux_validate_callback_function( $field, $value, $existing_value ) {
					$error   = false;
					$warning = false;

					//do your validation
					if ( $value == 1 ) {
						$error = true;
						$value = $existing_value;
					} elseif ( $value == 2 ) {
						$warning = true;
						$value   = $existing_value;
					}

					$return['value'] = $value;

					if ( $error == true ) {
						$field['msg']    = 'your custom error message';
						$return['error'] = $field;
					}

					if ( $warning == true ) {
						$field['msg']      = 'your custom warning message';
						$return['warning'] = $field;
					}

					return $return;
				}
			}
			
        }
    }

    global $reduxConfig;
    $reduxConfig = new Diza_Redux_Framework_Config();
	
}