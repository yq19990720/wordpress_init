<?php

if ( !function_exists('diza_section_sticky_header')) {
    function diza_section_sticky_header( $widget ) {
        if( get_post_type() !== 'tbay_header'  ) return;

        $widget->start_controls_section(
            'sticky_header',
            array(
                'label' => esc_html__( 'Sticky Header', 'diza' ),
                'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
            )
        );

        $widget->add_control(
            'enable_sticky_headers',
            array(
                'label'                 =>  esc_html__( 'Enable Sticky Headers', 'diza' ),
                'type'                  => \Elementor\Controls_Manager::SWITCHER,
                'default'               => '',
                'return_value'          => 'yes',
            )
        );

        $widget->end_controls_section(); 

    }

    add_action( 'elementor/element/section/section_layout/before_section_start', 'diza_section_sticky_header', 10, 2 );
}

