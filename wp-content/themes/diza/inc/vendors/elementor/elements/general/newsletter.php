<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Diza_Elementor_Newsletter') ) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;


class Diza_Elementor_Newsletter extends Diza_Elementor_Widget_Base {
    /**
     * Get widget name.
     *
     * Retrieve icon box widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'tbay-newsletter';
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
        return esc_html__( 'Diza newsletter', 'woocommerce' );
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
        return 'eicon-mail';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__( 'General', 'diza' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'form_style',
            [
                'label'        => esc_html__( 'Form Style Block', 'diza' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Off', 'diza' ),
                'label_on'  => esc_html__( 'On', 'diza' ),
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter .mc4wp-form-fields' => 'display: flex; flex-direction: column;',
                ],
            ] 
        );  

        $this->add_control(
            'heading_input',
            [
                'label' => esc_html__( 'Input', 'diza' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );     


        $this->add_responsive_control(
            'width_input',
            [
                'label'      => esc_html__( 'Input Width', 'diza' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'default' => [
                    'size' => 80,
                    'unit' => '%'
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-element-newsletter input[type="email"]' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 

        $this->add_control(
            'text_hide',
            [
                'label'        => esc_html__( 'Hide Text', 'diza' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_off'    => esc_html__( 'Off', 'diza' ),
                'label_on'     => esc_html__( 'On', 'diza' ),
                'default'      => '',
                'return_value' => 'none',
                'selectors'    => [
                    '{{WRAPPER}} .tbay-element-newsletter span' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'heading_button',
            [
                'label' => esc_html__( 'Button', 'diza' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'icon_hide',
            [
                'label'        => esc_html__( 'Hide Icon', 'diza' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_off'    => esc_html__( 'Off', 'diza' ),
                'label_on'     => esc_html__( 'On', 'diza' ),
                'default'      => '',
                'return_value' => 'none',
                'selectors'    => [
                    '{{WRAPPER}} .tbay-element-newsletter i' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label'      => esc_html__( 'Margin Icon', 'diza' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-element-newsletter i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'setting_align',
            [
                'label'     => esc_html__( 'Alignment', 'diza' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'diza' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__( 'Center', 'diza' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__( 'Right', 'diza' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => '',
                'condition' => [
                    'form_style' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter .mc4wp-form-fields' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'width_button',
            [
                'label'      => esc_html__( 'Buton width', 'diza' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //INPUT
        $this->start_controls_section(
            'mailchip_style_input',
            [
                'label' => esc_html__( 'Input', 'diza' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_background',
            [
                'label'     => esc_html__( 'Background Color', 'diza' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter input[type="email"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label'     => esc_html__( 'Color', 'diza' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter input[type="email"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'placeholder_color',
            [
                'label'     => esc_html__( 'Placeholder Color', 'diza' ),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tbay-element-newsletter ::-moz-placeholder'          => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tbay-element-newsletter ::-ms-input-placeholder'     => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align_input',
            [
                'label'     => esc_html__( 'Alignment', 'diza' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'diza' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'diza' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'diza' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter input[type="email"]' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(

            Group_Control_Border::get_type(),
            [
                'name'        => 'border_input',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tbay-element-newsletter input[type="email"]',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'diza' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-element-newsletter input[type="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label'      => esc_html__( 'Padding', 'diza' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-element-newsletter input[type="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'input_margin',
            [
                'label'      => esc_html__( 'Margin', 'diza' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-element-newsletter input[type="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Button
        $this->start_controls_section(
            'mailchip_style_button',
            [
                'label' => esc_html__( 'Button', 'diza' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'scheme'   => Schemes\Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]',
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__( 'Normal', 'diza' ),
            ]
        );

        $this->add_control(
            'button_bacground',
            [
                'label'     => esc_html__( 'Background Color', 'diza' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => esc_html__( 'Color', 'diza' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__( 'Hover', 'diza' ),
            ]
        );

        $this->add_control(
            'button_bacground_hover',
            [
                'label'     => esc_html__( 'Background Color', 'diza' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label'     => esc_html__( 'Color', 'diza' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_hover',
            [
                'label'     => esc_html__( 'Border Color', 'diza' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_focus',
            [
                'label' => esc_html__( 'Focus', 'diza' ),
            ]
        );

        $this->add_control(
            'button_bacground_focus',
            [
                'label'     => esc_html__( 'Background Color', 'diza' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]:forcus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color_focus',
            [
                'label'     => esc_html__( 'Button Color', 'diza' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_focus',
            [
                'label'     => esc_html__( 'Border Color', 'diza' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_button',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'diza' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => esc_html__( 'Padding', 'diza' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_margin',
            [
                'label'      => esc_html__( 'Margin', 'diza' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .tbay-element-newsletter button[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
}
$widgets_manager->register_widget_type(new Diza_Elementor_Newsletter());