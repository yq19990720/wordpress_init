<?php
if (!defined('ABSPATH') || function_exists('Diza_Elementor_Widget_Base') ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Core\Files\Assets\Svg\Svg_Handler;

abstract class Diza_Elementor_Widget_Base extends Elementor\Widget_Base {
	public function get_name_template() {
        return str_replace('tbay-', '', $this->get_name());
    }

    public function get_categories() {
        return [ 'diza-elements' ];
    }

    public function get_name() {
        return 'diza-base';
    }

    /**
	 * Get view template
	 *
	 * @param string $tpl_name
	 */
	protected function get_view_template( $tpl_slug, $tpl_name, $settings = [] ) {
		$located   = '';
		$templates = [];
		

		if ( ! $settings ) {
			$settings = $this->get_settings_for_display();
		} 

		if ( !empty($tpl_name) ) {
			$tpl_name  = trim( str_replace( '.php', '', $tpl_name ), DIRECTORY_SEPARATOR );
			$templates[] = 'elementor_templates/' . $tpl_slug . '-' . $tpl_name . '.php';
			$templates[] = 'elementor_templates/' . $tpl_slug . '/' . $tpl_name . '.php';
		}

		$templates[] = 'elementor_templates/' . $tpl_slug . '.php';
 
		foreach ( $templates as $template ) {
			if ( file_exists( DIZA_THEMEROOT . '/' . $template ) ) {
				$located = DIZA_THEMEROOT . '/' . $template;
				break;
			} else {
				$located = false;
			}
        }

		if ( $located ) {
			include $located;
		} else {
			echo sprintf( __( 'Failed to load template with slug "%s" and name "%s".', 'diza' ), $tpl_slug, $tpl_name );
		}
	}

	protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', 'tbay-element tbay-element-'. $this->get_name_template() );

        $this->get_view_template($this->get_name_template(), '', $settings);
	}
	
    protected function register_controls_heading($condition = array()) {

        $this->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__( 'Heading', 'diza' ),
                'condition' => $condition,
            ]
        );

        $this->register_section_heading_alignment();

        $this->add_control(
            'heading_title',
            [
                'label' => esc_html__('Title', 'diza'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'heading_title_tag',
            [
                'label' => esc_html__( 'Title HTML Tag', 'diza' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
            ]
        );

        $this->register_section_sub_title();

        $this->register_section_heading_icon();


        $this->end_controls_section();

        $this->register_section_styles_title($condition);
        
        $this->register_section_styles_sub_title($condition);
        $this->register_section_styles_icon($condition);
        $this->register_section_styles_icon_medicine($condition);
        $this->register_section_styles_content($condition);
    }

    private function register_section_heading_alignment() {
        $skin = diza_tbay_get_theme();

        if( $skin === 'medicine' ) return;

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Alignment', 'diza'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'diza'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'diza'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'diza'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );
    }
    private function register_section_sub_title() {

        $skin = diza_tbay_get_theme();

        if( $skin === 'medicine' ) return;

        $this->add_control(
            'heading_subtitle',
            [
                'label' => esc_html__('Sub Title', 'diza'),
                'type' => Controls_Manager::TEXT,
            ]
        );

    }

    private function register_section_heading_icon() {

        $skin = diza_tbay_get_theme();

        if( $skin === 'care' ) return;

        if( $skin === 'protective' ) {
            $default = [
                'value' => 'tb-icon tb-icon-subheading',
                'library' => 'tbay-custom',    
            ];
        } else {
            $default = [
                'value' => 'tb-icon tb-icon-plus-sub',
                'library' => 'tbay-custom',    
            ];
        }

        $this->add_control(
            'heading_icon',
            [
                'label' => esc_html__( 'Choose Icon', 'diza' ),
                'type' => Controls_Manager::ICONS,
                'default' => $default,
            ]
        );

    }

    private function register_section_styles_content($condition) {
        $this->start_controls_section(
            'section_style_heading_content',
            [
                'label' => esc_html__( 'Heading Content', 'diza' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );

        $this->add_responsive_control(
            'heading_style_margin',
            [
                'label' => esc_html__( 'Margin', 'diza' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ], 
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );        

        $this->add_responsive_control(
            'heading_style_padding',
            [
                'label' => esc_html__( 'Padding', 'diza' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ], 
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 

        $this->add_control(
            'heading_style_bg',
            [
                'label' => esc_html__( 'Background', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
    private function register_section_styles_title($condition) {
        $this->start_controls_section(
            'section_style_heading_title',
            [
                'label' => esc_html__( 'Heading Title', 'diza' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_title_typography',
                'selector' => '{{WRAPPER}} .heading-tbay-title .title',
            ]
        );

        $this->start_controls_tabs( 'heading_title_tabs' );

        $this->start_controls_tab(
            'heading_title_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'diza' ),
            ]
        );

        $this->add_control(
            'heading_title_color',
            [
                'label' => esc_html__( 'Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .title' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_title_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'diza' ),
            ]
        );

        $this->add_control(
            'heading_title_color_hover',
            [
                'label' => esc_html__( 'Hover Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'heading_title_bottom_space',
            [
                'label' => esc_html__( 'Spacing', 'diza' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }     

    private function register_section_styles_sub_title($condition) {
        $skin = diza_tbay_get_theme();

        if( $skin === 'medicine' ) return;

        $this->start_controls_section(
            'section_style_heading_subtitle',
            [
                'label' => esc_html__( 'Heading Sub Title', 'diza' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_subtitle_typography',
                'selector' => '{{WRAPPER}} .heading-tbay-title .subtitle',
            ]
        );

        $this->start_controls_tabs( 'heading_subtitle_tabs' );

        $this->start_controls_tab(
            'heading_subtitle_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'diza' ),
            ]
        );

        $this->add_control(
            'heading_subtitle_color',
            [
                'label' => esc_html__( 'Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .subtitle' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_subtitle_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'diza' ),
            ]
        );

        $this->add_control(
            'heading_subtitle_color_hover',
            [
                'label' => esc_html__( 'Hover Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'heading_title!' => ''
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'heading_subtitle_bottom_space',
            [
                'label' => esc_html__( 'Spacing', 'diza' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }     

    private function register_section_styles_icon($condition) {

        $skin = diza_tbay_get_theme();

        if( $skin === 'medicine' ) return;

        $this->start_controls_section(
            'section_style_heading_icon',
            [
                'label' => esc_html__( 'Heading Icon', 'diza' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );
        
        $this->add_responsive_control(
            'heading_icon_size',
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
					'size' => 46,
				],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_icon_line_height',
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
                    '{{WRAPPER}} .heading-tbay-title i' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_icon_margin',
            [
                'label' => esc_html__( 'Margin', 'diza' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ], 
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );    

        $this->start_controls_tabs( 'heading_icon_tabs' );

        $this->start_controls_tab(
            'heading_icon_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'diza' ),
            ]
        );

        $this->add_control(
            'heading_icon_color',
            [
                'label' => esc_html__( 'Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title i' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_icon_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'diza' ),
            ]
        );

        $this->add_control(
            'heading_icon_color_hover',
            [
                'label' => esc_html__( 'Hover Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'heading_title!' => ''
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }     

    private function register_section_styles_icon_medicine($condition) {

        $skin = diza_tbay_get_theme();

        if( $skin !== 'medicine' ) return;

        $this->start_controls_section(
            'section_style_heading_icon',
            [
                'label' => esc_html__( 'Heading Icon', 'diza' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            ]
        );
        $this->add_responsive_control(
            'heading_icon_size',
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
					'size' => 16,
				],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_icon_line_height',
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
                    '{{WRAPPER}} .heading-tbay-title i' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_icon_padding',
            [
                'label' => esc_html__( 'Padding', 'diza' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ], 
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '16',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        ); 

        $this->start_controls_tabs( 'heading_icon_tabs' );

        $this->start_controls_tab(
            'heading_icon_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'diza' ),
            ]
        );

        $this->add_control(
            'heading_icon_color',
            [
                'label' => esc_html__( 'Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .heading-tbay-title i:after' => 'background: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'heading_icon_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'diza' ),
            ]
        );

        $this->add_control(
            'heading_icon_color_hover',
            [
                'label' => esc_html__( 'Hover Color', 'diza' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'heading_title!' => ''
                ],
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .heading-tbay-title i' => 'color: {{VALUE}};',
                    '{{WRAPPER}}:hover .heading-tbay-title i:after' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->add_control(
            'heading_after_icon',
            [
                'label' => esc_html__( 'After Icon', 'diza' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'width_after_icon',
            [
                'label' => esc_html__( 'Width', 'diza' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
                'selectors' => [
                    '{{WRAPPER}} .heading-tbay-title .title .title-child i:after' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }    

    protected function get_available_pages() {
        $pages = get_pages();

        $options = [];

        foreach ($pages as $page) {
            $options[$page->ID] = $page->post_title;
        }

        return $options;
    }

    protected function get_available_on_sale_products() {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1
        );

        $product_ids_on_sale    = wc_get_product_ids_on_sale();
        $product_ids_on_sale[]  = 0;
        $args['post__in'] = $product_ids_on_sale;
        $loop = new WP_Query( $args );

        $options = []; 
        if ( $loop->have_posts() ): while ( $loop->have_posts() ): $loop->the_post();

            global $product;

            $options[$product->get_id()] = $product->get_title();


        endwhile; endif; wp_reset_postdata();

        return $options;
    }
    protected function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ($menus as $menu) {
            $options[$menu->slug] = $menu->name;
        }

        return $options;
    }
	
	public function render_element_heading() {
        
        $skin = diza_tbay_get_theme();


        switch ($skin) {
            case 'protective':
                $this->render_element_heading_skin_protective();
                break;
            case "medicine":
                $this->render_element_heading_skin_medicine();
                break;
            case "care":
                $this->render_element_heading_skin_care();
                break;
        }
    }

    private function render_element_heading_skin_protective() {
        $heading_title = $heading_title_tag = $heading_subtitle = '';
        $settings = $this->get_settings_for_display();
        extract( $settings );

		if( !empty($heading_subtitle) || !empty($heading_title) ) : ?>
            <<?php echo trim($heading_title_tag); ?> class="heading-tbay-title">

                <?php $this->render_item_icon($heading_icon); ?>

				<?php if( !empty($heading_title) ) : ?>
					<span class="<?php $title = str_replace(" ","",$heading_title); echo $title?>"></span>
				<?php endif; ?>	    	
				<?php if( !empty($heading_subtitle) ) : ?>
					<span class="<?php $subtitle= str_replace(" ","",$heading_subtitle); echo $subtitle?>"></span>
				<?php endif; ?>
			</<?php echo trim($heading_title_tag); ?>>
		<?php endif;
    }

    private function render_element_heading_skin_medicine() {
        $heading_title = $heading_title_tag = '';
        $settings = $this->get_settings_for_display();
        extract( $settings );

		if( !empty($heading_title) ) : ?>
            <<?php echo trim($heading_title_tag); ?> class="heading-tbay-title">

				<?php if( !empty($heading_title) ) : ?>
					<span class="title">
                        <span class="title-child">
                            <?php echo trim($heading_title); ?>
                            <?php $this->render_item_icon($heading_icon); ?>
                        </span>
                    </span>
				<?php endif; ?>	    	
			</<?php echo trim($heading_title_tag); ?>>
		<?php endif;
    }

    private function render_element_heading_skin_care() {
        $heading_title = $heading_title_tag = $heading_subtitle = '';
        $settings = $this->get_settings_for_display();
        extract( $settings );

		if( !empty($heading_subtitle) || !empty($heading_title) ) : ?>
            <<?php echo trim($heading_title_tag); ?> class="heading-tbay-title">

                <?php if( !empty($heading_subtitle) ) : ?>
					<span class="subtitle"><?php echo trim($heading_subtitle); ?></span>
				<?php endif; ?>

				<?php if( !empty($heading_title) ) : ?>
					<span class="title"><?php echo trim($heading_title); ?></span>
				<?php endif; ?>	    	

			</<?php echo trim($heading_title_tag); ?>>
		<?php endif;
    }
    
    protected function get_template_product_grid() {
        return apply_filters( 'diza_get_template_product_grid', 'v1' );
    }      

    protected function get_template_product_vertical() {
        return apply_filters( 'diza_get_template_product_vertical', 'vertical-v1' );
    }    

    protected function get_template_product() {
        return apply_filters( 'diza_get_template_product', 'v1' );
    }

    protected function get_product_type() {
        $type = [
            'newest' => esc_html__('Newest Products', 'diza'),
            'on_sale' => esc_html__('On Sale Products', 'diza'),
            'best_selling' => esc_html__('Best Selling', 'diza'),
            'top_rated' => esc_html__('Top Rated', 'diza'),
            'featured' => esc_html__('Featured Product', 'diza'),
            'random_product' => esc_html__('Random Product', 'diza'),
        ];

        return apply_filters( 'diza_woocommerce_product_type', $type);
    }

    protected function get_title_product_type($key) {
        $array = $this->get_product_type();

        return $array[$key];
    }

    protected function get_attribute_query_product_type($args, $product_type) {
        global $woocommerce;

        switch ($product_type) {
            case 'best_selling':
                $args['meta_key']   = 'total_sales';
                $args['order']          = 'desc';
                $args['orderby']    = 'meta_value_num';
                $args['ignore_sticky_posts']   = 1;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                break;

            case 'featured':
                $args['ignore_sticky_posts']    = 1;
                $args['meta_query']             = array();
                $args['meta_query'][]           = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][]           = $woocommerce->query->visibility_meta_query();
                $args['tax_query'][]              = array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN'
                    )
                );
                break;

            case 'top_rated':
                $args['meta_key']       = '_wc_average_rating';
                $args['orderby']        = 'meta_value_num';
                $args['order']          = 'desc';
                break;

            case 'newest':
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;

            case 'random_product':
                $args['orderby']    = 'rand';
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                break;

            case 'deals':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                $args['meta_query'] = array();
                $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                $args['meta_query'][] =  array(
                    'relation' => 'AND',
                    array(
                        'relation' => 'OR',
                        array(
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                        array(
                            'key'           => '_min_variation_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                    ),            
                    array(
                        'key'           => '_sale_price_dates_to',
                        'value'         => time(),
                        'compare'       => '>',
                        'type'          => 'numeric'
                    ),
                );
                break;  

            case 'on_sale':
                $product_ids_on_sale    = wc_get_product_ids_on_sale();
                $product_ids_on_sale[]  = 0;
                $args['post__in'] = $product_ids_on_sale;
                break;
        }

        return $args;
    }

    protected function get_query_products($categories = array(), $cat_operator = '', $product_type = 'newest', $limit = '', $orderby = '', $order = '') {
        $atts = [
            'limit' => $limit,
            'orderby' => $orderby,
            'order' => $order
        ];
        
        if (!empty($categories)) {
            
            if( !is_array( $categories ) )  { 
                $atts['category'] = $categories;
            } else {
                $atts['category'] = implode(', ', $categories);
                $atts['cat_operator'] = $cat_operator; 
            }
            
        }
        
        $type = 'products';

        $shortcode = new WC_Shortcode_Products($atts, $type);
        $args = $shortcode->get_query_args();
        
        $args = $this->get_attribute_query_product_type($args, $product_type);
        return new WP_Query($args); 
    }

    protected function get_product_categories($number = '') {
        $args = array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        );
        if ($number === 0) {
            return;
        }
        if( !empty($number) && $number !== -1 ) {
            $args['number'] = $number;
        }
       

        $category = get_terms($args);
        $results = array();
        if (!is_wp_error($category)) {
            foreach ($category as $category) {
                $results[$this->transliterate($category->slug)] = $category->name.' ('.$category->count.') ';
            }
        }
        return $results;
    }

    protected function transliterate( $title ) {
        $prev_locale = setlocale( LC_CTYPE, 0 );
        setlocale( LC_ALL, 'C.UTF-8' );
    
        $title = urldecode( $title );
    
        if ( function_exists( 'iconv' ) && defined( 'ICONV_IMPL' ) && @strcasecmp( ICONV_IMPL, 'unknown' ) !== 0 ) {
            $title = iconv( 'UTF-8', 'UTF-8//TRANSLIT//IGNORE', $title );
        }
    
        setlocale( LC_ALL, $prev_locale );
    
        return $title;
	}

    protected function get_cat_operator() {
        $operator = [
            'AND' => esc_html__('AND', 'diza'),
            'IN' => esc_html__('IN', 'diza'),
            'NOT IN' => esc_html__('NOT IN', 'diza'),
        ];

        return apply_filters( 'diza_woocommerce_cat_operator', $operator);
    }

    protected function get_woo_order_by() { 
        $oder_by = [
            'date' => esc_html__('Date', 'diza'),
            'title' => esc_html__('Title', 'diza'),
            'id' => esc_html__('ID', 'diza'),
            'price' => esc_html__('Price', 'diza'),
            'popularity' => esc_html__('Popularity', 'diza'),
            'rating' => esc_html__('Rating', 'diza'),
            'rand' => esc_html__('Random', 'diza'),
            'menu_order' => esc_html__('Menu Order', 'diza'),
        ];

        return apply_filters( 'diza_woocommerce_oder_by', $oder_by);
    }

    protected function get_woo_order() {
        $order = [
            'asc' => esc_html__('ASC', 'diza'), 
            'desc' => esc_html__('DESC', 'diza'),
        ];

        return apply_filters( 'diza_woocommerce_order', $order);
    }

    protected function register_woocommerce_order() {
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'diza'),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => $this->get_woo_order_by(),
                'conditions' => [
					'relation' => 'AND',
					'terms' => [
						[
							'name' => 'product_type',
							'operator' => '!==',
							'value' => 'top_rated',
						],
						[
							'name' => 'product_type',
							'operator' => '!==',
							'value' => 'random_product',
						],
						[
							'name' => 'product_type',
							'operator' => '!==',
							'value' => 'best_selling',
						],
					],
				],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'diza'),
                'type' => Controls_Manager::SELECT,
                'default' => 'asc',
                'options' => $this->get_woo_order(),
                'conditions' => [
					'relation' => 'AND',
					'terms' => [
						[
							'name' => 'product_type',
							'operator' => '!==',
							'value' => 'top_rated',
						],
						[
							'name' => 'product_type',
							'operator' => '!==',
							'value' => 'random_product',
						],
						[
							'name' => 'product_type',
							'operator' => '!==',
							'value' => 'best_selling',
						],
					],
				],
            ]
        );
    }

    protected function register_woocommerce_categories_operator() {
        $categories = $this->get_product_categories();

        $this->add_control(
            'categories', 
            [
                'label' => esc_html__('Categories', 'diza'),
                'type' => Controls_Manager::SELECT2, 
                'default'   => array_keys($categories)[0],
                'options'   => $categories,   
                'label_block' => true,
                'multiple' => true,
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label' => esc_html__('Category Operator', 'diza'),
                'type' => Controls_Manager::SELECT,
                'default' => 'IN',
                'options' => $this->get_cat_operator(),
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );
    }

    protected function get_woocommerce_tags() {
        $tags = array();
        
        $args = array(
            'order' => 'ASC',
        );

        $product_tags = get_terms( 'product_tag', $args );

        foreach ( $product_tags as $key => $tag ) {

            $tags[$tag->slug] = $tag->name . ' (' .$tag->count .')';

        }

        return $tags;
    }

    protected function settings_carousel($settings) {
        $this->add_render_attribute('row', 'class', 'owl-carousel'); 
        $this->add_render_attribute('row', 'data-carousel', 'owl');

        $this->add_render_attribute('row', 'data-items', $settings['column']);
        $this->add_render_attribute('row', 'data-desktopslick', $settings['col_desktop']);
        $this->add_render_attribute('row', 'data-desktopsmallslick', $settings['col_desktopsmall']);
        $this->add_render_attribute('row', 'data-tabletslick', $settings['column_tablet']);
        $this->add_render_attribute('row', 'data-landscapeslick', $settings['col_landscape']);
        $this->add_render_attribute('row', 'data-mobileslick', $settings['column_mobile']);
        $this->add_render_attribute('row', 'data-rows', $settings['rows']);

        $this->add_render_attribute('row', 'data-nav', $settings['navigation'] === 'yes' ? true : false);  
        $this->add_render_attribute('row', 'data-pagination', $settings['pagination'] === 'yes' ? true : false);  
        $this->add_render_attribute('row', 'data-loop', $settings['loop'] === 'yes' ? true : false);  

        if( !empty($settings['autospeed']) ) {
            $this->add_render_attribute('row', 'data-autospeed', $settings['autospeed']  );  
        }
  
        $this->add_render_attribute('row', 'data-auto', $settings['auto'] === 'yes' ? true : false);  
        $this->add_render_attribute('row', 'data-unslick', $settings['disable_mobile'] === 'yes' ? true : false);  
    } 

    protected function settings_responsive($settings) { 

        /*Add class reponsive grid*/
        $this->add_render_attribute(
            'row',
            [
                'class' => [ 'row', 'grid' ],
                'data-xlgdesktop' =>  $settings['column'],
                'data-desktop' =>  $settings['col_desktop'],
                'data-desktopsmall' =>  $settings['col_desktopsmall'],
            ]
        );

        if (!empty($settings['column_tablet'])) {
            $this->add_render_attribute('row', 'data-tablet', $settings['column_tablet']);
        }
        
        $this->add_render_attribute('row', 'data-landscape', $settings['col_landscape']);
        if (!empty($settings['column_mobile'])) {
            $this->add_render_attribute('row', 'data-mobile', $settings['column_mobile']);
        }
    } 

    public function settings_layout() {
        $settings = $this->get_settings_for_display();
        extract( $settings );

        if( !isset($layout_type) ) return;

        $this->add_render_attribute('row', 'class', $this->get_name_template());

        if( isset($rows) && !empty($rows) ) {
            $this->add_render_attribute( 'row', 'class', 'rows-'. $rows);
        }

        if($layout_type === 'carousel') { 
            $this->settings_carousel($settings);    
        }else{
            $this->settings_responsive($settings);
        }
    }
    
    protected function get_widget_field_img( $image ) {
        $image_id   = $image['id'];
        $img  = '';

        if( !empty($image_id) ) {
            $img = wp_get_attachment_image($image_id, 'full');    
        } else if( !empty($image['url']) ) {
            $img = '<img src="'. $image['url'] .'">';
        }

        return $img;
    }

    protected function render_item_icon($selected_icon) {
        $settings = $this->get_settings_for_display();

        if ( ! isset( $selected_icon['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
            // add old default
            $selected_icon['icon'] = 'fa fa-star';
        }
        $has_icon = ! empty( $selected_icon['icon'] );

        if ( $has_icon ) {
            $this->add_render_attribute( 'i', 'class', $selected_icon['icon'] );
            $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
        }
        
        if ( ! $has_icon && ! empty( $selected_icon['value'] ) ) {
            $has_icon = true;
        }
        
        if( ! empty( $selected_icon['value'] ) ) {
            $this->add_render_attribute( 'i', 'class', $selected_icon['value'] );
            $this->add_render_attribute( 'i', 'aria-hidden', 'true' ); 
        }

        $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
        $is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

        Icons_Manager::enqueue_shim();

        if( !$has_icon ) return;  

        if ( $is_new || $migrated ) :
            Icons_Manager::render_icon( $selected_icon, [ 'aria-hidden' => 'true' ] );
        else : ?>
            <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
        <?php endif;
    }
    
    protected function get_item_icon_svg($selected_icon) {
        if ( ! isset( $selected_icon['value']['id'] ) ) {
            return '';
        }

        return Svg_Handler::get_inline_svg( $selected_icon['value']['id'] );
    }
}

