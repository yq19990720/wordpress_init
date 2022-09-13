<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Diza_Elementor_Search_Form') ) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;


class Diza_Elementor_Search_Form extends Diza_Elementor_Widget_Base {

    protected $nav_menu_index = 1;

    public function get_name() {
        return 'tbay-search-form';
    }

    public function get_title() {
        return esc_html__('Diza Search Form', 'diza');
    }
    
    public function get_icon() {
        return 'eicon-search';
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Search Form', 'diza'),
            ]
        ); 
       
        $this->_register_form_search();
        $this->_register_button_search();
        $this->_register_category_search();

        $this->add_control(
            'advanced_show_result',
            [
                'label' => esc_html__('Show Result', 'diza'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'show_image_search',
            [
                'label'   => esc_html__('Show Image of Search Result', 'diza'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_price_search',
            [
                'label'              => esc_html__('Show Price of Search Result', 'diza'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
        $this->register_section_style_search_form();
    }

    protected function register_section_style_search_form() {
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Style Search Form', 'diza'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'search_form_line_height',
            [
                'label' => esc_html__('Line Height', 'diza'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .tbay-search,
                    {{WRAPPER}} .tbay-search-form .select-category,{{WRAPPER}} .tbay-search-form .button-search:not(.icon),
                    {{WRAPPER}} .tbay-search-form .select-category > select' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tbay-search-form .select-category,{{WRAPPER}} .tbay-search-form .button-search:not(.icon),
                    {{WRAPPER}} .tbay-preloader,{{WRAPPER}} .tbay-search-form .button-search:not(.icon) i,{{WRAPPER}} .tbay-search-form .SumoSelect' => 'line-height: {{SIZE}}{{UNIT}}'
                ],
            ]
        );
        $this->add_control(
            'search_form_width',
            [
                'label' => esc_html__('Width', 'diza'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 50,
                        'max' => 100,
                    ]
                ],
                'size_units' => [ 'px' ,'%'],
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .form-group .input-group,
                    {{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_control(
            'border_style_tbay_search_form',
            [
                'label' => esc_html__( 'Border Type', 'diza' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'None', 'diza' ),
                    'solid' => esc_html__( 'Solid', 'diza' ),
                    'double' => esc_html__( 'Double', 'diza' ),
                    'dotted' => esc_html__( 'Dotted', 'diza' ),
                    'dashed' => esc_html__( 'Dashed', 'diza' ),
                    'groove' => esc_html__( 'Groove', 'diza' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .form-group .input-group' => 'border-style: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'border_width_tbay_search_form',
            [
                'label' => esc_html__( 'Width', 'diza' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],

                'selectors'  => [
                    '{{WRAPPER}} .tbay-search-form .form-group .input-group' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .SumoSelect.open>.optWrapper,{{WRAPPER}} .autocomplete-suggestions' => 'margin-top: {{BOTTOM}}{{UNIT}};'
                ],
                'condition' => [
                    'border_style_tbay_search_form!' => '',
                ],
            ]
        );
        $this->add_control(
            'border_color_tbay_search_form',
            [
                'label' => esc_html__( 'Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .form-group .input-group' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'border_style_tbay_search_form!' => '',
                ],
            ]
        );
        
        $this->add_control(
            'border_radius_tbay_search_form',
            [
                'label'     => esc_html__('Border Radius Search Form', 'diza'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-search-form .form-group .input-group' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tbay-search-form .select-category.input-group-addon,{{WRAPPER}} .tbay-search-form .select-category .CaptionCont' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tbay-search-form .button-group,{{WRAPPER}} .tbay-search-form .button-search:not(.icon)' => 'border-radius: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0 ;',
                ],
            ]
        ); 

        $this->add_control(
            'advanced_categories_search_style',
            [
                'label' => esc_html__('Categories Search', 'diza'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'bg_category_search',
            [
                'label'     => esc_html__('Background', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .select-category.input-group-addon'    => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'color_category_search',
            [
                'label'     => esc_html__('Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .select-category>select'    => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'advanced_btn_search_style',
            [
                'label' => esc_html__('Button Search', 'diza'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->add_control(
            'padding_btn',
            [
                'label'     => esc_html__('Padding Button Search', 'diza'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-search-form .button-search:not(.icon)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );   
        $this->add_control(
            'bg_btn',
            [
                'label'     => esc_html__('Background Button', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .button-search:not(.icon),
                    {{WRAPPER}} .tbay-search-form .tbay-loading .button-group,
                    {{WRAPPER}} .tbay-search-form .button-group'    => 'background: {{VALUE}}',
                ],
            ]
        );   
        $this->add_control(
            'bg_btn_hover',
            [
                'label'     => esc_html__('Background Button Hover', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .button-search:not(.icon):hover'    => 'background: {{VALUE}}',
                ],
            ]
        );  
        $this->add_control(
            'color_icon_btn',
            [
                'label'     => esc_html__('Color Icon Button', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .button-search i,{{WRAPPER}} .tbay-search-form .button-group:before'    => 'color: {{VALUE}}',
                    '{{WRAPPER}} .button-search svg'    => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'color_icon_btn_hover',
            [
                'label'     => esc_html__('Color Icon Button Hover', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .button-search i:hover, {{WRAPPER}} .tbay-search-form .button-group:before'        => 'color: {{VALUE}}',
                    '{{WRAPPER}} .button-search svg:hover'      => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'color_text_btn',
            [
                'label'     => esc_html__('Color Text Button', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .button-search .text'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'color_text_btn_hover',
            [
                'label'     => esc_html__('Color Text Button Hover', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .button-search text:hover'    => 'color: {{VALUE}}',
                ],
            ]
        );
       
        $this->add_control(
            'advanced_input_search_style',
            [
                'label' => esc_html__('Input Search', 'diza'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->add_control(
            'bg_input',
            [
                'label'     => esc_html__('Background Input Search', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .tbay-search'    => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'color_input',
            [
                'label'     => esc_html__('Color Input Search', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-search-form .tbay-search'    => 'color: {{VALUE}}',
                    '{{WRAPPER}} .form-control::placeholder'    => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'input_search_padding',
            [
                'label'      => esc_html__( 'Padding', 'diza' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-search-form .tbay-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        
    }

    protected function _register_form_search() {
        $this->add_control(
            'advanced_type_search',
            [
                'label' => esc_html__('Form', 'diza'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'search_type',
            [
                'label'              => esc_html__('Search Result', 'diza'),
                'type'               => Controls_Manager::SELECT,
                'default' => 'product',
                'options' => [
                    'product'  => esc_html__('Product','diza'),
                    'post'  => esc_html__('Blog','diza')
                ]
            ]
        );

        
        $this->add_control(
            'autocomplete_search',
            [
                'label'              => esc_html__('Auto-complete Search', 'diza'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes', 
            ]
        );
        $this->add_control(
            'placeholder_text',
            [
                'label'              => esc_html__('Placeholder Text', 'diza'),
                'type'               => Controls_Manager::TEXT,
                'default'            => esc_html__('Search products...', 'diza'),
            ]
        );  
        $this->add_control(
            'vali_input_search',
            [
                'label'              => esc_html__('Text Validate Input Search', 'diza'),
                'type'               => Controls_Manager::TEXT,
                'default'            => esc_html__('Enter at least 2 characters', 'diza'),
            ]
        );
        $this->add_control(
            'min_characters_search',
            [
                'label'              => esc_html__('Search Min Characters', 'diza'),
                'type'               => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 6,
                        'step' => 1,
                    ],
                    
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
            ]
        );
        $this->add_control(
            'search_max_number_results',
            [
                'label'              => esc_html__('Max Number of Search Results', 'diza'),
                'type'               => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 2,
                        'max' => 10,
                        'step' => 1,
                    ],
                    
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
            ]
        );

    }

    protected function _register_button_search() {
        $this->add_control(
            'advanced_button_search',
            [
                'label' => esc_html__('Button Search', 'diza'),
                'type' => Controls_Manager::HEADING,
                'separator'    => 'before',
            ]
        );
        $this->add_control(
            'text_button_search',
            [
                'label'              => esc_html__('Button Search Text', 'diza'),
                'type'               => Controls_Manager::TEXT,
                'default' => '',
            ]
        );
        $this->add_control(
            'icon_button_search',
            [
                'label'              => esc_html__('Button Search Icon', 'diza'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'library' => 'tb-icon',
                    'value'   => 'tb-icon tb-icon-search'
                ],
            ]
        );
        $this->add_control(
            'icon_button_search_size',
            [
                'label' => esc_html__('Font Size Icon', 'diza'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .button-search i, {{WRAPPER}} .button-search svg' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
    }

    protected function _register_category_search() {
        $this->add_control(
            'advanced_categories_search',
            [
                'label'         => esc_html__('Categories Search', 'diza'),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        );
        $this->add_control(
            'enable_categories_search',
            [
                'label'              => esc_html__('Enable Search in Categories', 'diza'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );
        $this->add_control(
            'text_categories_search',
            [
                'label'              => esc_html__('Search in Categories Text', 'diza'),
                'type'               => Controls_Manager::TEXT,
                'default'            =>  esc_html__('All Categories', 'diza'),
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'count_categories_search',
            [
                'label'              => esc_html__('Show count in Categories', 'diza'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'enable_categories_search' => 'yes'
                ]
            ]
        );
    }
    public function get_script_depends() {
        return ['jquery-sumoselect'];
    }
    public function get_style_depends() {
        return ['sumoselect'];
    }
    

    public function render_search_form() {
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $_id = diza_tbay_random_key();
        $class_active_ajax = ( diza_switcher_to_boolean($autocomplete_search) ) ? 'diza-ajax-search' : '';

        $this->add_render_attribute(
            'search_form',
            [
                'class' => [
                    $class_active_ajax,
                    'searchform'
                ],
                'data-thumbnail' => diza_switcher_to_boolean($show_image_search),
                'data-appendto' => '.search-results-'.$_id,
                'data-price' => diza_switcher_to_boolean($show_price_search),
                'data-minChars' => $min_characters_search['size'],
                'data-post-type' => $search_type,
                'data-count' => $search_max_number_results['size'],
            ]
        );
        ?>
            <div class="tbay-search-form">
                <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" <?php echo trim($this->get_render_attribute_string( 'search_form' )); ?> >
                    <div class="form-group">
                        <div class="input-group">
                            <?php if ( $enable_categories_search === 'yes' ): ?>
                                <div class="select-category input-group-addon">
                                    <?php if ( class_exists( 'WooCommerce' ) && $search_type === 'product' ) :
                                        $args = array(
                                            'show_option_none'   => $text_categories_search,
                                            'show_count' => diza_switcher_to_boolean($count_categories_search),
                                            'hierarchical' => true,
                                            'id' => 'product-cat-'.$_id,
                                            'show_uncategorized' => 0
                                        );
                                    ?> 
                                    <?php wc_product_dropdown_categories( $args ); ?>
                                    
                                    <?php elseif ( $search_type === 'post' ):
                                        $args = array(
                                            'show_option_all' => $text_categories_search,
                                            'show_count' => diza_switcher_to_boolean($count_categories_search),
                                            'hierarchical' => true,
                                            'show_uncategorized' => 0,
                                            'name' => 'category',
                                            'id' => 'blog-cat-'.$_id,
                                            'class' => 'postform dropdown_product_cat',
                                        );
                                    ?>
                                        <?php wp_dropdown_categories( $args ); ?>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>
                                <input data-style="right" type="text" placeholder="<?php echo esc_attr($placeholder_text); ?>" name="s" required oninvalid="this.setCustomValidity('<?php echo esc_attr($vali_input_search) ?>')" oninput="setCustomValidity('')" class="tbay-search form-control input-sm"/>

                                <div class="search-results-wrapper">
                                    <div class="diza-search-results search-results-<?php echo esc_attr( $_id );?>" ></div>
                                </div>
                                <div class="button-group input-group-addon">
                                    <button type="submit" class="button-search btn btn-sm>">
                                        <?php $this->render_item_icon($icon_button_search) ?>
                                        <?php if(!empty($text_button_search) && isset($text_button_search) ) {
                                            ?>
                                                <span class="text"><?php echo trim($text_button_search); ?></span>
                                            <?php
                                        } ?>
                                    </button>
                                    <div class="tbay-preloader"></div>
                                </div>

                                <input type="hidden" name="post_type" value="<?php echo esc_attr($search_type); ?>" class="post_type" />
                        </div>
                        
                    </div>
                </form>
            </div>
        <?php
    }
}
$widgets_manager->register_widget_type(new Diza_Elementor_Search_Form());

