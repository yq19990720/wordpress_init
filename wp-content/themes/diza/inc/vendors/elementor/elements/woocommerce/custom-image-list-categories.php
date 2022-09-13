<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Diza_Elementor_Custom_Image_List_Categories') ) {
    exit; // Exit if accessed directly.
}

use Elementor\Core\Schemes;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Diza_Elementor_Custom_Image_List_Categories extends  Diza_Elementor_Carousel_Base{
    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'tbay-custom-image-list-categories';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Diza Custom Image List Categories', 'woocommerce' );
    }

    public function get_categories() {
        return [ 'diza-elements', 'woocommerce-elements'];
    }
    
    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-product-categories';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    public function get_script_depends()
    {
        return ['slick', 'diza-custom-slick'];
    }

    public function get_keywords() {
        return [ 'woocommerce-elements', 'custom-image-list-categories' ];
    }

    protected function register_controls() {
        $this->register_controls_heading();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'Custom Image List Categories', 'diza' ),
            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'diza'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $repeater = $this->register_list_category_repeater();

        $this->add_control(
            'list_category',
            [
                'label' => esc_html__( 'List Categories Items', 'diza' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );
        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'diza'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'diza'), 
                    'carousel'  => esc_html__('Carousel', 'diza'), 
                ],
            ]
        );  

        $this->add_control(
            'type_style',
            [
                'label' => esc_html__( 'Style', 'diza' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'style-1', 
            ]
        );

        $this->add_responsive_control(
            'spacing_content',
            [
                'label' => esc_html__('Spacing Content','diza'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [
                    'top' => '40',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .custom-image-list-categories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cat_list_align_1',
            [
                'label' => esc_html__('Align','diza'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left','diza'),
                        'icon' => 'fas fa-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center','diza'),
                        'icon' => 'fas fa-align-center'
                    ],
                    'right' => [
                        'title' => esc_html__('Right','diza'),
                        'icon' => 'fas fa-align-right'
                    ],   
                ],
                'condition' => [
                    'type_style' => 'style-1'
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .item-cat' => 'text-align: {{VALUE}} !important',
                    '{{WRAPPER}} .content' => 'text-align: {{VALUE}} !important',
                ]
            ]
        );
        $this->add_control(
            'cat_list_align_2',
            [
                'label' => esc_html__('Align','diza'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left','diza'),
                        'icon' => 'fas fa-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__('Center','diza'),
                        'icon' => 'fas fa-align-center'
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right','diza'),
                        'icon' => 'fas fa-align-right'
                    ],   
                ],
                'condition' => [
                    'type_style' => 'style-2'
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-cat' => 'justify-content: {{VALUE}} !important',
                ]
            ]
        );

        $this->add_control(
            'display_count_category',
            [
                'label'     => esc_html__('Show Count Category', 'diza'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
            ]
        );  

        $this->add_control(
            'show_all',
            [
                'label'     => esc_html__('Display Show All', 'diza'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => '',
            ]
        );  
        $this->add_control(
            'text_show_all',
            [
                'label'     => esc_html__('Text Show All', 'diza'),
                'type'      => Controls_Manager::TEXT,
                'default'   => 'See all categories',
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );  
        $this->add_control(
            'icon_show_all',
            [
                'label'     => esc_html__('Icon Show All', 'diza'),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'library' => 'tbay-custom',
                    'value'   => 'tb-icon tb-icon-chevron-right'
                ],

                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );  

        $this->end_controls_section();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);

        $this->register_section_styles_custom_image_list_categories();
    }

    private function register_list_category_repeater() {
        $categories = $this->get_product_categories();

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'category',
            [
                'label' => esc_html__( 'Choose category', 'diza' ),
                'type' => Controls_Manager::SELECT,
                'default'   => array_keys($categories)[0],
                'options'   => $categories,
            ]
        );

        $repeater->add_control(
            'type',
            [
                'label' => esc_html__('Type Custom','diza'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'image' => [
                        'title' => esc_html__('Image', 'diza'),
                        'icon' => 'fa fa-image',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'diza'),
                        'icon' => 'fa fa-info',
                    ],
                ],
                'default'  =>'image'
            ]
        );

        $repeater->add_control(
            'type_icon',
            [
                'label' => esc_html__( 'Choose Icon', 'diza' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'icon-question', 
                    'library' => 'simple-line-icons',
                ],
                'condition' => [
                    'type' => 'icon' 
                ]
            ]
        );

        $repeater->add_control(
            'type_image',
            [
                'label' => esc_html__( 'Choose Image', 'diza' ),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'type' => 'image'
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'display_custom',
            [
                'label' => esc_html__( 'Show Custom Link', 'diza' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );

        $repeater->add_control(
            'custom_link',
            [
                'label' => esc_html__('Custom Link','diza'),
                'type' => Controls_Manager::URL,
                'condition' => [
                    'display_custom' => 'yes'
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'diza' ),
            ]
        );

        return $repeater;
    }

    private function register_section_styles_custom_image_list_categories() {
        $this->start_controls_section(
            'section_style_custom_image_list_categories',
            [
                'label' => esc_html__( 'Categories Item ', 'diza' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->resgiter_heading_style_content();
        $this->resgiter_heading_style_icon();
        $this->resgiter_heading_style_title();

        $this->end_controls_section();
    }

    private function resgiter_heading_style_content() {
        $this->add_control(
            'heading_style_custom_image_list_categories_content',
            [
                'label' => esc_html__( 'Content Item', 'diza' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs( 'list_categories_content_tabs' );

        $this->start_controls_tab(
            'list_categories_content_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'diza' ),
            ]
        );

        $this->add_control(
            'list_categories_content_bg',
            [
                'label' => esc_html__( 'Background', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cat-icon,
                    {{WRAPPER}} .cat-image' => 'background: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_categories_content_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'diza' ),
            ]
        );

        $this->add_control(
            'list_categories_content_color_hover',
            [
                'label' => esc_html__( 'Hover Background', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-icon:hover .cat-icon,
                    {{WRAPPER}} .item-icon:hover .cat-image' => 'background: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_input',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .cat-icon, {{WRAPPER}} .cat-image',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'list_categories_content_radius',
            [
                'label' => esc_html__( 'Border Radius', 'diza' ),
                'type' => Controls_Manager::DIMENSIONS, 
                'size_units' => [ 'px', '%' ],
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .cat-icon,
                    {{WRAPPER}} .cat-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        
        $this->add_responsive_control(
            'list_categories_content_padding',
            [
                'label'      => esc_html__( 'Padding', 'diza' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .cat-icon,
                    {{WRAPPER}} .cat-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'list_categories_content_margin',
            [
                'label'      => esc_html__( 'Margin', 'diza' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .cat-icon,
                    {{WRAPPER}} .cat-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .custom-image-list-categories' => 'margin: -{{TOP}}{{UNIT}} -{{RIGHT}}{{UNIT}} -{{BOTTOM}}{{UNIT}} -{{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

    private function resgiter_heading_style_icon() {
        $this->add_control(
            'heading_style_custom_image_list_categories_icon',
            [
                'label' => esc_html__( 'Icon', 'diza' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'list_categories_icon_size',
            [
                'label' => esc_html__('Font Size', 'diza'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 300,
                    ],
                ],
				'default' => [
					'unit' => 'px',
					'size' => 75,
				],
                'selectors' => [
                    '{{WRAPPER}} .cat-icon > i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .cat-icon > svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'list_categories_icon_line_height',
            [
                'label' => esc_html__('Line Height', 'diza'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .cat-icon > i' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_categories_icon_padding',
            [
                'label' => esc_html__( 'Padding', 'diza' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ], 
                'selectors' => [
                    '{{WRAPPER}} .cat-icon > i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; display: inline-block;',
                ],
            ]
        );    

        $this->start_controls_tabs( 'list_categories_icon_tabs' );

        $this->start_controls_tab(
            'list_categories_icon_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'diza' ),
            ]
        );

        $this->add_control(
            'list_categories_icon_color',
            [
                'label' => esc_html__( 'Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cat-icon > i' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_categories_icon_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'diza' ),
            ]
        );

        $this->add_control(
            'list_categories_icon_color_hover',
            [
                'label' => esc_html__( 'Hover Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-icon:hover .cat-icon > i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
    }

    private function resgiter_heading_style_title() {
        $this->add_control(
            'heading_style_custom_image_list_categories_title',
            [
                'label' => esc_html__( 'Title', 'diza' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'scheme'   => Schemes\Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .cat-name',
            ]
        );

        $this->add_responsive_control(
            'list_categories_title_margin',
            [
                'label' => esc_html__( 'Margin', 'diza' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ], 
                'selectors' => [
                    '{{WRAPPER}} .cat-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );    

        $this->start_controls_tabs( 'list_categories_title_tabs' );

        $this->start_controls_tab(
            'list_categories_title_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'diza' ),
            ]
        );

        $this->add_control(
            'list_categories_title_color',
            [
                'label' => esc_html__( 'Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .cat-name' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'list_categories_title_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'diza' ),
            ]
        );

        $this->add_control(
            'list_categories_title_color_hover',
            [
                'label' => esc_html__( 'Hover Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-cat:hover .cat-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

    }

    public function render_item_content($item, $attribute, $display_count_category) {
        extract( $item);
        $obj_cat = get_term_by('slug', $category, 'product_cat');

        if( !is_object ( $obj_cat ) ) return;

        $name   = $obj_cat->name;
        $count  = $obj_cat->count;
        if(!empty($custom_link['url']) && isset($custom_link) && $display_custom ==='yes' ) {
            $url_category       = $custom_link['url'];
            $is_external        = $custom_link['is_external'];
            $nofollow           = $custom_link['nofollow'];
            if( $is_external === 'on' ) {
                $attribute .= ' target="_blank"';
            }                

            if( $nofollow === 'on' ) {
                $attribute .= ' rel="nofollow"';
            }
        }
        else {
            $url_category =  get_term_link($category, 'product_cat');
        }
        
        ?>  
            <?php $this->render_item_type($type,$url_category,$type_icon,$type_image); ?>
            <div class="content">
                <a href="<?php echo esc_url($url_category)?>" class="cat-name" <?php echo trim($attribute); ?>><?php echo trim($name) ?></a>
                <?php if($display_count_category === 'yes') {
                    ?><span class="count-item"><?php echo trim($count).' '.esc_html__('items', 'diza'); ?></span><?php
                } ?>
                
            </div>
        <?php
    }

    public function render_item_image($type_image) {
        $image_id  = $type_image['id']; 

        echo wp_get_attachment_image($image_id, 'full');
    }
    public function render_item_type($type,$url_category,$type_icon,$type_image) {
        if($type === 'icon') {
            ?>
                <a href="<?php echo esc_url($url_category)?>" class='cat-icon'>
                    <?php $this->render_item_icon($type_icon); ?>
                </a>
            <?php
        }elseif($type ==='image') {
            ?>
                <a href="<?php echo esc_url($url_category)?>" class='cat-image'>
                    <?php $this->render_item_image($type_image); ?>
                </a>
            <?php
        }
    }

    

}
$widgets_manager->register_widget_type(new Diza_Elementor_Custom_Image_List_Categories());
