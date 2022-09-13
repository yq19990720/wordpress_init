<?php
if( !defined('TBAY_ELEMENTOR_ACTIVED') ) return;

class Tbay_Widget_Yith_Brand_Images extends Tbay_Widget {
    public function __construct() {
        parent::__construct(
            'diza_product_brand',
            esc_html__('Diza Product Brand Images', 'diza'),
            array( 'description' => esc_html__( 'Show YITH product brand images(Only applicable to product single pages)', 'diza' ), )
        );
        $this->widgetName = 'diza_product_brand';
    }
 
    public function getTemplate() {
        $this->template = 'product-brand-image.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {


    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();

        return $instance;

    }
}