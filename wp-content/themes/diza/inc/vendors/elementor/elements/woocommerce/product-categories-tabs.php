<?php

if ( ! defined( 'ABSPATH' ) || function_exists('Diza_Elementor_Product_Categories_Tabs') ) {
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
class Diza_Elementor_Product_Categories_Tabs extends  Diza_Elementor_Carousel_Base{
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
        return 'tbay-product-categories-tabs';
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
        return esc_html__( 'Diza Product Categories Tabs', 'woocommerce' );
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
        return 'eicon-product-tabs';
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
        return [ 'woocommerce-elements', 'product-categories' ];
    }

    protected function register_controls() {
        $this->register_controls_heading();
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'Product Categories', 'diza' ),
            ]
        );        

        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Number of products', 'diza'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__( 'Number of products to show ( -1 = all )', 'diza' ),
                'default' => 6,
                'min'  => -1,
            ]
        );

        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'diza'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->register_woocommerce_order();
        $this->add_control(
            'product_type',
            [   
                'label'   => esc_html__('Product Type','diza'),
                'type'     => Controls_Manager::SELECT,
                'options' => $this->get_product_type(),
                'default' => 'newest'
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

        $categories = $this->get_product_categories();
        $this->add_control(
            'categories',
            [
                'label'     => esc_html__('Categories', 'diza'),
                'type'      => Controls_Manager::SELECT2,
                'default'   => [array_keys($categories)[0]],
                'label_block' => true,
                'options'   => $categories,   
                'multiple' => true,
            ]
        );  
        $this->add_control(
            'product_style',
            [
                'label' => __('Product Style', 'diza'),
                'type' => Controls_Manager::SELECT,
                'default' => 'v1',
                'options' => $this->get_template_product(),
                'prefix_class' => 'elementor-product-'
            ]
        );

        $this->register_button();
        $this->end_controls_section();
        $this->add_control_responsive();
        $this->add_control_carousel(['layout_type' => 'carousel']);
        $this->register_style_heading();
    }
    protected function register_style_heading() {
        $this->start_controls_section(
            'section_style_heading_categories_tab',
            [
                'label' => esc_html__('Heading Product Categories Tabs', 'diza'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'heading_categories_tab_align',
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .heading-product-category-tabs' => 'text-align: {{VALUE}};',
                ],
            ]
        );
     

        $this->add_control(
            'heading_categories_tab_background',
            [
                'label'     => esc_html__('Background', 'diza'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .heading-product-category-tabs'    => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_categories_tab_padding',
            [
                'label'      => esc_html__( 'Padding', 'diza' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .heading-product-category-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

    }
    protected function register_button() {
        $this->add_control(
            'show_more',
            [
                'label'     => esc_html__('Display Show More', 'diza'),
                'type'      => Controls_Manager::SWITCHER,
                'default' => 'no'
            ]
        );  
        $this->add_control(
            'text_button',
            [
                'label'     => esc_html__('Text Button', 'diza'),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'show_more' => 'yes'
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
                    'show_more' => 'yes'
                ]
            ]
        );  
    }
   

    public function get_template_product() {
        return apply_filters( 'diza_get_template_product', 'v1' );
    }
    public function render_product_tab($categories,$_id,$settings) {
        extract($settings);
        ?>
        
        <div class="heading-product-category-tabs">
            <?php
                if(!empty($title_cat_tab) || !empty($sub_title_cat_tab) ) {
                    ?>
                    <h3 class="heading-tbay-title">
                        <?php if( !empty($title_cat_tab) ) : ?>
                            <span class="title"><?php echo trim($title_cat_tab); ?></span>
                        <?php endif; ?>	    	
                        <?php if( !empty($sub_title_cat_tab) ) : ?>
                            <span class="subtitle"><?php echo trim($sub_title_cat_tab); ?></span>
                        <?php endif; ?>
                    </h3>
                    <?php
                }
            ?>

            <ul class="tabs-list nav nav-tabs">
                <?php 
                    $__count=0;
                ?>

                <?php foreach ($categories as $key) { ?>
                        <?php 
                            $active = ($__count==0)? 'active':''; 
                            
                            $category = get_term_by( 'slug', $key, 'product_cat' );
                            $title = $category->name;

                        ?>
                        <li>
                            <a class="<?php echo esc_attr( $active ); ?>" href="#<?php echo esc_attr($key.'-'.$_id); ?>" data-toggle="tab" data-title="<?php echo esc_attr($title);?>"><?php echo trim($title);?></a>
                        </li>
                    <?php $__count++; ?>
                <?php } ?>
            </ul>
            
        </div>
        

       <?php
    }
    public function render_product_tabs_content($categories, $_id) {
        ?>
            <div class="content-product-category-tab">
                <div class="tbay-addon-content tab-content woocommerce">
                 <?php 
                 $__count=0;
                 foreach ($categories as $key ) {
                     $tab_active = ($__count == 0) ? ' show active' : '';
                         $this->render_content_tab($key, $tab_active, $_id);
                     $__count++;
                 }
                 ?>
                </div>
            </div>
        <?php
 
    }
    private function  render_content_tab($key, $tab_active, $_id) {
        $settings = $this->get_settings_for_display();
        $cat_operator = $product_type = $limit = $orderby = $order = '';
        extract( $settings );
        
        /** Get Query Products */
        $loop = $this->get_query_products($key,  $cat_operator, $product_type, $limit, $orderby, $order);

        if( $layout_type === 'carousel' ) $this->add_render_attribute('row', 'class', ['rows-'.$rows]);
        $this->add_render_attribute('row', 'class', ['products']);

        $attr_row = $this->get_render_attribute_string('row');
        ?>
        <div class="tab-pane fade <?php echo esc_attr( $tab_active ); ?>" id="<?php echo esc_attr($key).'-'.$_id; ?>">
        
        <?php wc_get_template( 'layout-products/layout-products.php' , array( 'loop' => $loop, 'product_style' => $product_style, 'attr_row' => $attr_row) ); ?>
        </div>
        <?php
        
    }
    
    public function render_item_button() {
        $settings = $this->get_settings_for_display();
        extract( $settings );
        $url_category =  get_permalink(wc_get_page_id('shop'));
        if(isset($text_button) && !empty($text_button)) {?>
            <div class="readmore-wrapper"><a href="<?php echo esc_url($url_category)?>" class="btn show-all"><?php echo trim($text_button) ?>
                <?php 
                    $this->render_item_icon($icon_button);
                ?>
            </a></div>
            <?php
        }
        
    }

}
$widgets_manager->register_widget_type(new Diza_Elementor_Product_Categories_Tabs());
