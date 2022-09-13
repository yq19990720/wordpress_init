<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Diza_Elementor_Button') ) {
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
class Diza_Elementor_Button extends  Diza_Elementor_Widget_Base{
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
        return 'tbay-button';
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
        return esc_html__( 'Diza Button', 'woocommerce' );
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
        return 'eicon-button';
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
            'section_general',
            [
                'label' => esc_html__( 'Button', 'diza' ),
            ]
        );
        $this->add_control(
            'text_button',
            [
                'label' => esc_html__( 'Text Button', 'diza' ),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'link_button',
            [
                'label' => esc_html__( 'Link Button', 'diza' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'diza' )
            ]
        );
        $this->add_control(
            'add_icon',
            [
                'label' => esc_html__( 'Add Icon', 'diza' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );
        $this->add_control(
            'icon_button',
            [
                'label' => esc_html__( 'Choose Icon', 'diza' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'tb-icon tb-icon-arrow-right',
					'library' => 'tbay-custom',
                ],
                'condition' => [
                    'add_icon' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render_item() {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $link = $settings['link_button']['url'];
        $is_external        = $link_button['is_external'];
        $nofollow           = $link_button['nofollow'];
		
        $attribute = '';
        if( $is_external === 'on' ) {
            $attribute .= 'target="_blank"';
        }                

        if( $nofollow === 'on' ) {
            $attribute .= 'rel="nofollow"';
        }
        ?>
            <a href="<?php echo esc_url($link) ?>" <?php echo trim($attribute) ?> class="tbay-btn-theme btn-theme"><?php echo trim($text_button); ?>
                <?php $this->render_item_icon($icon_button); ?>
            </a>
        <?php
    }
}
$widgets_manager->register_widget_type(new Diza_Elementor_Button());
