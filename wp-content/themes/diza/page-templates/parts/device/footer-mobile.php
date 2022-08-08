<?php   global $woocommerce; 

    if( diza_catalog_mode_active() || !defined('DIZA_WOOCOMMERCE_ACTIVED') || is_product() || is_cart() || is_checkout() ) return;

?>

<?php
    /**
     * diza_before_topbar_mobile hook
     */
    do_action( 'diza_before_footer_mobile' );
?>
<div class="footer-device-mobile d-xl-none clearfix">

    <?php
        /**
        * diza_before_footer_mobile hook
        */
        do_action( 'diza_before_footer_mobile' );

        /**
        * Hook: diza_footer_mobile_content.
        *
        * @hooked diza_the_custom_list_menu_icon - 10
        */

        do_action( 'diza_footer_mobile_content' );

        /**
        * diza_after_footer_mobile hook
        */
        do_action( 'diza_after_footer_mobile' );
    ?>

</div>