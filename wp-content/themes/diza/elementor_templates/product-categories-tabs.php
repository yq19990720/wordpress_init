<?php 
/**
 * Templates Name: Elementor
 * Widget: Product Categories Tabs
 */

extract( $settings );

if( empty($categories) ) return;

$this->settings_layout();

$_id = diza_tbay_random_key();
?>

<div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>>
    <?php 
        $this->render_element_heading(); 
        $this->render_product_tab($categories,$_id,$settings);
        $this->render_product_tabs_content($categories, $_id,$settings);
        $this->render_item_button();
    ?>
</div>