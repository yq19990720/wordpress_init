<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Diza_Elementor_Our_Team') ) {
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
class Diza_Elementor_Our_Team extends  Diza_Elementor_Carousel_Base{
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
        return 'tbay-our-team';
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
        return esc_html__( 'Diza Our Team', 'woocommerce' );
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
        return 'eicon-person';
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
                'label'     => __('Layout Type', 'diza'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'diza'), 
                    'carousel'  => esc_html__('Carousel', 'diza'), 
                ],
            ]
        );  
        
        
        $repeater = $this->register_our_team_repeater();

        $this->add_control(
            'our_team',
                [
                'label' => esc_html__( 'Our Team Items', 'diza' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $this->register_set_our_team_default(),
                'our_team_field' => '{{{ our_team_image }}}',
            ]
        );

        

        $this->end_controls_section();
        $this->style_our_team();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);

    }
    protected function style_our_team() {
        $this->start_controls_section(
            'section_style_our_team',
            [
                'label' => esc_html__( 'Style', 'diza' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'our_team_align',
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
                    '{{WRAPPER}} .info'  => 'text-align: {{VALUE}}',
                ]
            ]
        );  
        $this->add_responsive_control(
			'our_team_padding',
			[
				'label' => esc_html__( 'Padding "Name"', 'diza' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .name-team' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_control(
            'title_our_team_color',
            [
                'label' => esc_html__('Color Name','diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .name-team'    => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'job_our_team_color',
            [
                'label' => esc_html__('Color Job','diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .job'    => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function register_our_team_repeater() {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control (
            'our_team_name', 
            [
                'label' => esc_html__( 'Name', 'diza' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control (
            'our_team_job', 
            [
                'label' => esc_html__( 'Job', 'diza' ),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control (
            'our_team_image', 
            [
                'label' => esc_html__( 'Choose Image', 'diza' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control (
            'our_team_link_fb', 
            [
                'label' => esc_html__( 'FaceBook Link', 'diza' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'diza' ),
            ]
        );
        $repeater->add_control (
            'our_team_link_tw', 
            [
                'label' => esc_html__( 'Twitter Link', 'diza' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'diza' ),
            ]
        );
        $repeater->add_control (
            'our_team_link_gg', 
            [
                'label' => esc_html__( 'Goole Plus Link', 'diza' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'diza' ),
            ]
        );
        $repeater->add_control (
            'our_team_link_linkin', 
            [
                'label' => esc_html__( 'Linkin Link', 'diza' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'diza' ),
            ]
        );
        $repeater->add_control (
            'our_team_link_instaram', 
            [
                'label' => esc_html__( 'Instagram Link', 'diza' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'diza' ),
            ]
        );

        return $repeater;
    }

    private function register_set_our_team_default() {
        $defaults = [
            [
                'our_team_name' => esc_html__( 'Name 1', 'diza' ),
                'our_team_job' => esc_html__( 'Job 1', 'diza' ),
                'our_team_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'our_team_link_fb' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_tw' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_gg' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_linkin' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_instaram' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
            ],
            [
                'our_team_name' => esc_html__( 'Name 2', 'diza' ),
                'our_team_job' => esc_html__( 'Job 2', 'diza' ),
                'our_team_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'our_team_link_fb' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_tw' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_gg' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_linkin' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_instaram' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
            ],
            [
                'our_team_name' => esc_html__( 'Name 3', 'diza' ),
                'our_team_job' => esc_html__( 'Job 3', 'diza' ),
                'our_team_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'our_team_link_fb' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_tw' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_gg' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_linkin' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_instaram' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
            ],
            [
                'our_team_name' => esc_html__( 'Name 4', 'diza' ),
                'our_team_job' => esc_html__( 'Job 4', 'diza' ),
                'our_team_image' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'our_team_link_fb' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_tw' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_gg' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_linkin' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
                'our_team_link_instaram' =>  [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
            ],
        ];

        return $defaults;
    }

    protected function render_item($item) {
        extract($item);
        ?> 
        <div class="inner"> 
           <?php 

                $array_link = [
                    'fb' => 'icon-social-facebook',
                    'tw' => 'icon-social-twitter',
                    'gg' => 'icon-social-google',
                    'linkin' => 'icon-social-linkedin',
                    'instaram' => 'icon-social-instagram'
                ];
           ?>

            <div class="our-team-content">
                <?php echo trim($this->get_widget_field_img($item['our_team_image'])); ?>
                <ul class="social-link">
                    <?php 
                        foreach ($array_link as $key => $value) {
                            $link = $item['our_team_link_'.$key]['url'];
                            $attribute = '';

                            if( $item['our_team_link_'.$key]['is_external'] === 'on' ) {
                                $attribute .= ' target="_blank"';
                            }
        
                            if( $item['our_team_link_'.$key]['nofollow'] === 'on' ) {
                                $attribute .= ' rel="nofollow"';
                            }
                            ?>
                            <?php if(!empty($link) && isset($link) ) {
                                ?>
                                    <li>
                                        <a href="<?php echo esc_url($link); ?>">
                                            <i class="icons <?php echo esc_attr($value); ?>"></i>
                                        </a>
                                    </li>
                                <?php
                            } ?>
                        <?php
                        }
                    ?>
                </ul>
            </div>
            <div class="info">
                    <h3 class="name-team">
                        <?php echo trim($our_team_name) ?>
                    </h3>
                    <p class="job">
                        <?php echo trim($our_team_job) ?>
                    </p>    
                </div>
        </div>
        <?php
    }      


}
$widgets_manager->register_widget_type(new Diza_Elementor_Our_Team());
