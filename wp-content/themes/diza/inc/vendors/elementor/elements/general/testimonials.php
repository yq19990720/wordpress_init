<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Diza_Elementor_Testimonials') ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Diza_Elementor_Testimonials extends  Diza_Elementor_Carousel_Base{
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
        return 'tbay-testimonials';
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
        return esc_html__( 'Diza Testimonials', 'woocommerce' );
    }

    public function get_script_depends() {
        return [ 'diza-custom-slick', 'slick' ];
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
        return 'eicon-testimonial';
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
        $this->register_controls_heading();

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'General', 'diza' ),
            ]
        );
 
        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'diza'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'diza'), 
                    'carousel'  => esc_html__('Carousel', 'diza'), 
                ],
            ]
        );   
        $this->add_control(
            'testimonials_align',
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
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item .testimonials-body'  => 'text-align: {{VALUE}} !important',
                ]
            ]
        );  
        $this->add_responsive_control(
			'testimonial_padding',
			[
				'label' => esc_html__( 'Padding "Name"', 'diza' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $repeater = $this->register_testimonials_repeater();

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__( 'Testimonials Items', 'diza' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $this->register_set_testimonial_default(),
                'testimonials_field' => '{{{ testimonials_image }}}',
            ]
        );    

        $this->end_controls_section();

        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);

    }

    private function register_testimonials_repeater() {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control (
            'testimonial_image', 
            [
                'label' => esc_html__( 'Choose Image', 'diza' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control (
            'testimonial_name', 
            [
                'label' => esc_html__( 'Name', 'diza' ),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control (
            'testimonial_job', 
            [
                'label' => esc_html__( 'Job', 'diza' ),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control (
            'testimonial_excerpt', 
            [
                'label' => esc_html__( 'Excerpt', 'diza' ),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        return $repeater;
    }

    private function register_set_testimonial_default() {
        $defaults = [
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'testimonial_name' => esc_html__( 'Name 1', 'diza' ),
                'testimonial_job' => esc_html__( 'Job 1', 'diza' ),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'diza'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'testimonial_name' => esc_html__( 'Name 2', 'diza' ),
                'testimonial_job' => esc_html__( 'Job 2', 'diza' ),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'diza'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'testimonial_name' => esc_html__( 'Name 3', 'diza' ),
                'testimonial_job' => esc_html__( 'Job 3', 'diza' ),
                'testimonial_excerpt' => esc_html__('Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque', 'diza'),
            ],
            [
                'testimonial_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'testimonial_name' => esc_html__( 'Name 4', 'diza' ),
                'testimonial_job' => esc_html__( 'Job 4', 'diza' ),
                'testimonial_excerpt' => 'Lorem ipsum dolor sit amet, in mel unum delicatissimi conclusionemque',
            ],
        ];

        return $defaults;
    }

    protected function render_item( $item ) {
        ?> 
        <div class="testimonials-body"> 
                <?php $this->render_item_excerpt( $item ); ?>
                
                <?php echo trim($this->get_widget_field_img($item['testimonial_image'])); ?>

                <div class="testimonial-meta">
                    <?php 
                        $this->render_item_name( $item );
                        $this->render_item_job( $item );
                    ?>
                </div>

                
                <?php
                ?>
                <?php
            ?>
        </div>
        <?php
    }    
    

    private function render_item_name( $item ) {
        $testimonial_name  = $item['testimonial_name'];
        if(isset($testimonial_name) && !empty($testimonial_name)) {
            ?>
                <span class="name"><?php echo trim($testimonial_name) ?></span>
            <?php
        }
    }
    private function render_item_job( $item ) {
        $testimonial_job  = $item['testimonial_job'];

        if(isset($testimonial_job) && !empty($testimonial_job)) {
            ?>
                <span class="job"><?php echo trim($testimonial_job) ?></span>
            <?php
        }
    }
    private function render_item_excerpt( $item ) {
        $testimonial_excerpt  = $item['testimonial_excerpt'];

        if(isset($testimonial_excerpt) && !empty($testimonial_excerpt)) {
            ?>
                <span class="excerpt"><?php echo trim($testimonial_excerpt) ?></span>
            <?php
        }
    }

}
$widgets_manager->register_widget_type(new Diza_Elementor_Testimonials());
