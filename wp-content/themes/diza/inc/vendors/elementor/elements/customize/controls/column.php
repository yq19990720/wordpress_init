<?php

if ( !function_exists('diza_column_section_advanced')) {
    function diza_column_section_advanced( $widget ) {

        $widget->update_responsive_control(
            'padding',
            [  
                'label' => esc_html__( 'Padding', 'diza' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} > div.elementor-element-populated' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

    }

    add_action( 'elementor/element/column/section_advanced/before_section_end', 'diza_column_section_advanced', 10, 2 );
}

