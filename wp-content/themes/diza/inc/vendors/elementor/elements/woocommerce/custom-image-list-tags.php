<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Diza_Elementor_Custom_Image_List_Tags') ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;


class Diza_Elementor_Custom_Image_List_Tags extends Diza_Elementor_Carousel_Base {

    public function get_name() {
        return 'tbay-custom-image-list-tags';
    }

    public function get_title() {
        return esc_html__( 'Diza Custom Image List Tags', 'woocommerce' );
    }

    public function get_script_depends() {
        return [ 'diza-custom-slick', 'slick' ];
    }

    public function get_categories() {
        return [ 'diza-elements', 'woocommerce-elements'];
    }

    public function get_icon() {
        return 'eicon-tags';
    }

    public function get_keywords() {
        return [ 'woocommerce-elements', 'custom-image-list-tags' ];
    }

    protected function register_controls() {
        $this->register_controls_heading();

        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__( 'General', 'diza' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
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

        $repeater = $this->register_list_tags_repeater();

        $this->add_control(
            'tags', 
            [
                'label' => esc_html__( 'List Tags', 'diza' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        ); 

        $this->register_button(); 
        $this->end_controls_section();

        $this->register_design_content_controls(); 

        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
    }

    protected function register_list_tags_repeater() {
        $tag_slug = $this->get_woocommerce_tags();

        $repeater = new \Elementor\Repeater();

        if ( is_array($tag_slug) && count($tag_slug) ) {
            $tag_default = array_rand($tag_slug);
            $repeater->add_control(
                'tag_slug',
                [
                    'label'     => esc_html__('Tag', 'diza'),
                    'type'      => Controls_Manager::SELECT,
                    'options'   => $tag_slug,
                    'default'   => $tag_default
                ]
            );
        } else {
            $repeater->add_control(
                'tag_slug',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no tags in your site.</strong><br>Go to the <a href="%s" target="_blank">Tags screen</a> to create one.', 'diza'), admin_url('edit-tags.php?taxonomy=product_tag&post_type=product')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }

        $repeater->add_control(
            'tag_style',
            [
                'label' => esc_html__('Choose Style', 'diza'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'images' => [
                        'title' => esc_html__('Image', 'diza'),
                        'icon' => 'fa fa-image',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'diza'),
                        'icon' => 'fa fa-info',
                    ],
                ],
                'default' => 'images',
            ]
        ); 

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'diza' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition'   => [
                    'tag_style' => 'images',
                ]
            ]
        );         

        $repeater->add_control(
            'icon',
            [
                'label'       => esc_html__('Icon Button', 'diza'),
                'type'        => Controls_Manager::ICONS,
                'label_block' => true,
                'default'     => [
                    'value'   => 'fas fa-info',
                    'library' => 'fa-solid',
                ],
                'condition'   => [
                    'tag_style'   => 'icon',
                ]
            ]
        );         

        $repeater->add_control(
            'tag_add_link',
            [
                'label' => esc_html__( 'Add Custom Link', 'diza' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        ); 

        $repeater->add_control(
            'tag_custom_link',
            [
                'label'         => esc_html__('Link to', 'diza'),
                'type'          => Controls_Manager::URL,
                'placeholder'   => esc_html__( 'https://your-link.com', 'diza' ),
                'condition'     => [
                    'tag_add_link'  => 'yes',
                ]
            ]
        ); 

        return $repeater;
    }

    protected function register_button() {
        $this->add_control(
            'show_all',
            [
                'label'     => esc_html__('Button Show All', 'diza'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no',
                'separator' => 'before',
            ]
        );  
        $this->add_control(
            'text_button',
            [
                'label'     => esc_html__('Text Button', 'diza'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        );  
        $this->add_control(
            'icon_button',
            [
                'label'     => esc_html__('Icon Button', 'diza'),
                'type'      => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'tb-icon tb-icon-arrow-right',
                    'library' => 'tbay-custom',
                ],
                'condition' => [
                    'show_all' => 'yes'
                ]
            ]
        ); 
        $this->add_control(
            'show_count',
            [
                'label'     => esc_html__('Show Count', 'diza'),
                'description' => esc_html__('Display the product number of the tags', 'diza'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        ); 
    }
    protected function register_design_content_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'diza' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'size',
            [
                'label' => esc_html__( 'Font Size Icon', 'diza' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tag-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'align_content',
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
                    '{{WRAPPER}} .item' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
    public function render_item( $item ) {
        extract($item); 
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $layout = 'v1';

        $tag   = get_term_by( 'slug', $tag_slug, 'product_tag' );

        if( !$tag ) return;

        $tag_name       = $tag->name;
        $tag_count      = diza_get_product_count_of_tags($tag);
        $count_item     = $show_count;

        /*Array tab*/
        $tab = [];
        $tab['images'] = $image['id'];
        $tab['shop_now'] = '';
        $tab['shop_now_text'] = '';
        $iconClass = '';


        if( $tag_style === 'icon' ) {
            $iconClass = $icon['value'];
            $tab['images'] = '';
        }

        if( $tag_add_link === 'yes' ) {
            $tag_link       =   $tag_custom_link['url'];
        } else {
            $tag_link       =   get_term_link($tag_slug, 'product_tag');
        }
        
        ?> 
    
        <?php wc_get_template( 'item-tag/tag-custom-'.$layout.'.php', array('tab'=> $tab,  'tag_link' => $tag_link, 'tag_name' => $tag_name ,'tag_count' => $tag_count ,'count_item' => $count_item , 'iconClass'=> $iconClass ) ); ?>

        <?php

    }
    public function render_item_button() {
        $settings = $this->get_settings_for_display();
        extract( $settings );
        if( $show_all === 'yes' ) {

            $url =  get_permalink(wc_get_page_id('shop'));
            if(isset($text_button) && !empty($text_button)) {?>
                <a href="<?php echo esc_url($url)?>" class="show-all"><?php echo trim($text_button) ?>
                    <?php 
                        $this->render_item_icon($icon_button);
                    ?>
                    
                </a>
                <?php
            }
        }
    }

}
$widgets_manager->register_widget_type(new Diza_Elementor_Custom_Image_List_Tags());