<?php
/**
 * Templates Name: Elementor
 * Widget: Account
 */
$this->add_render_attribute('tbay-login', 'class', 'tbay-login');
$this->add_render_attribute('sub-menu', 'class', 'account-menu sub-menu');
$this->add_render_attribute('wrapper', 'class', ['header-icon']);

$settings = $this->get_settings_for_display();

extract($settings);

$catalog_mode = diza_catalog_mode_active();
if( $catalog_mode ) return;

$url_login = apply_filters('diza_woocommerce_my_account_url', "/my-account" );
?>
    <div <?php echo trim($this->get_render_attribute_string('wrapper')); ?>></div>

