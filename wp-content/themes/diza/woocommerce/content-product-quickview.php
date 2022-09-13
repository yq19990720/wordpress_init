<div id="tbay-quick-view-modal" class="singular-shop">
    <div id="product-<?php the_ID(); ?>" <?php post_class('product '); ?>>
    	<div id="tbay-quick-view-content" class="woocommerce single-product no-gutters">
            <div class="image-mains product col-12 col-md-6">
                <?php
                   diza_product_quickview_image();
                ?>
            </div>
            <div class="summary entry-summary col-12 col-md-6">
                <div class="information">
                    <?php
                        /**
                         * Hook: woocommerce_single_product_summary.
                         *
                         * @hooked woocommerce_template_single_title - 5
                        * @hooked woocommerce_template_single_rating - 10
                        * @hooked woocommerce_template_single_price - 10
                        * @hooked woocommerce_template_single_excerpt - 20
                        * @hooked woocommerce_template_single_add_to_cart - 30
                        * @hooked woocommerce_template_single_meta - 40
                        * @hooked WC_Structured_Data::generate_product_data() - 60
                        */
                        do_action( 'woocommerce_single_product_summary' );
                    ?>
                </div>
            </div>
    	</div>
    </div>
</div>

