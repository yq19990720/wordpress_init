<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Diza_Elementor_Compare') ) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;

class Diza_Elementor_Compare extends Diza_Elementor_Widget_Base {
    public function get_name() {
        return 'tbay-compare';
    }

    public function get_title() {
        return esc_html__('Diza Compare', 'diza');
    }

    public function get_icon() {
        return 'eicon-sync';
    }

    protected function get_html_wrapper_class() {
		return 'w-auto elementor-widget-' . $this->get_name();
	}

    protected function register_controls() {

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'diza'),
            ]
        );

        $this->add_control(
            'icon_compare',
            [
                'label'              => esc_html__('Icon', 'diza'),
                'type'               => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'tb-icon tb-icon-sync',
					'library' => 'tbay-custom',
                ],                
            ]
        );
        $this->add_control(
            'icon_compare_size',
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
					'{{WRAPPER}} .element-btn-compare i, {{WRAPPER}} .element-btn-compare svg' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_control(
            'show_title_compare',
            [
                'label'              => esc_html__('Display Title', 'diza'),
                'type'               => Controls_Manager::SWITCHER,
                'default' => 'no'        
            ]
        );
        $this->add_control(
            'title_compare',
            [
                'label'              => esc_html__('Title', 'diza'),
                'type'               => Controls_Manager::TEXT,
                'default' => esc_html__('My Compare', 'diza'),
                'condition' => [
                    'show_title_compare' => 'yes'
                ]        
            ]
        );
    
        $this->end_controls_section();
        $this->register_section_style_icon();
        $this->register_section_style_text();
    }

    private function register_section_style_icon() {

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Style Icon', 'diza'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs('tabs_style_icon');

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => esc_html__('Normal', 'diza'),
            ]
        );
        $this->add_control(
            'color_icon',
            [
                'label'     => esc_html__('Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-btn-compare i'        => 'color: {{VALUE}}',
                    '{{WRAPPER}} .element-btn-compare svg'      => 'fill: {{VALUE}}',
                ],
            ]
        );   
        $this->add_control(
            'bg_icon',
            [
                'label'     => esc_html__('Background Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-btn-compare i, {{WRAPPER}} .element-btn-compare svg'    => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => esc_html__('Hover', 'diza'),
            ]
        );
        $this->add_control(
            'hover_color_icon',
            [
                'label'     => esc_html__('Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-btn-compare i:hover'      => 'color: {{VALUE}}',
                    '{{WRAPPER}} .element-btn-compare svg:hover'    => 'fill: {{VALUE}}',
                ],
            ]
        );   
        $this->add_control(
            'hover_bg_icon',
            [
                'label'     => esc_html__('Background Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .element-btn-compare i:hover, {{WRAPPER}} .element-btn-compare svg:hover'    => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    private function register_section_style_text() {

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Style Text', 'diza'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs('tabs_style_text');

        $this->start_controls_tab(
            'tab_text_normal',
            [
                'label' => esc_html__('Normal', 'diza'),
            ]
        );
        $this->add_control(
            'color_text',
            [
                'label'     => esc_html__('Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title-compare'    => 'color: {{VALUE}}',
                ],
            ]
        );   

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_text_hover',
            [
                'label' => esc_html__('Hover', 'diza'),
            ]
        );
        $this->add_control(
            'hover_color_text',
            [
                'label'     => esc_html__('Color', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .title-compare:hover' => 'color: {{VALUE}}',
                ],
            ]
        );   
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    

    public function render_item_compare() {
        $settings = $this->get_settings();
        extract( $settings );
        if( !class_exists('YITH_Woocompare') ) return;

        global $yith_woocompare;

        $url_compare = 'javascript:void(0)';
        if( $yith_woocompare->is_frontend() ) {
            $url_compare = $yith_woocompare->obj->view_table_url();
        } 

        $this->add_render_attribute(
            'compare',
            [
                'class' => [ 'compare', 'added', 'element-btn-compare', 'button' ],
                'rel'   => 'nofollow',
                'href'  => $url_compare,
            ]
        );

        ?>
        <div class="element-yith-compare product">
            <a <?php echo trim($this->get_render_attribute_string( 'compare' )); ?>>
                <?php $this->render_item_icon($icon_compare); ?>
                <?php $this->render_item_title(); ?>
            </a>
        </div>
        <?php
    }

    private function render_item_title() {
        $settings = $this->get_settings();
        extract( $settings );

        if( $show_title_compare !== 'yes' || !isset($title_compare) || empty($title_compare) ) return;
        ?>
        <span class="title-compare"><?php echo trim($title_compare) ?></span>
        <?php
    }
}
$widgets_manager->register_widget_type(new Diza_Elementor_Compare());

