<?php
global $post;
wp_enqueue_script( 'slick' );
wp_enqueue_script( 'diza-custom-slick' );

$type = apply_filters( 'diza_woo_config_product_layout', 10,2 );
$inner = 'inner-'.$type;
$product_item = isset($product_item) ? $product_item : $inner;

$columns = isset($columns) ? $columns : 4;
$rows_count = isset($rows) ? $rows : 1;

$auto_type = $loop_type = $autospeed_type = '';


$screen_desktop          	=      isset($screen_desktop) ? $screen_desktop : 4;
$screen_desktopsmall     	=      isset($screen_desktopsmall) ? $screen_desktopsmall : 3;
$screen_tablet           	=      isset($screen_tablet) ? $screen_tablet : 3;
$screen_landscape_mobile    =      isset($screen_landscape_mobile) ? $screen_landscape_mobile : 2;
$screen_mobile           	=      isset($screen_mobile) ? $screen_mobile : 1;

$disable_mobile          =      isset($disable_mobile) ? $disable_mobile : '';

$data_carousel = diza_tbay_data_carousel($rows, $nav_type, $pagi_type, $loop_type, $auto_type, $autospeed_type, $disable_mobile);
$responsive_carousel  = diza_tbay_check_data_responsive_carousel($columns, $screen_desktop, $screen_desktopsmall, $screen_tablet, $screen_landscape_mobile, $screen_mobile);
?>
<div class="owl-carousel products related rows-1 <?php diza_slick_carousel_product_block_image_class(); ?>" <?php echo trim($responsive_carousel); ?>  <?php echo trim($data_carousel); ?> >
    <?php foreach ( $post->recommends as $value ) : ?>

		<div class="item">
            <div class="products-grid product">
				<?php
                $post_object = get_post( $value );

                setup_postdata( $GLOBALS['post'] =& $post_object );

                wc_get_template_part( 'item-product/'.$product_item ); ?>
            </div>
		</div>

    <?php endforeach; ?>
</div>
<?php wp_reset_postdata(); ?>
