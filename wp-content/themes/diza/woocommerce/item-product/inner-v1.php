<?php 
global $product;


do_action( 'diza_woocommerce_before_product_block_grid' );

$flash_sales 	= isset($flash_sales) ? $flash_sales : false;
$end_date 		= isset($end_date) ? $end_date : '';

$countdown_title 		= isset($countdown_title) ? $countdown_title : '';

$countdown 		= isset($countdown) ? $countdown : false;
$class = array();
$class_flash_sale = diza_tbay_class_flash_sale($flash_sales);
array_push($class, $class_flash_sale);

$skin = diza_tbay_get_theme();
if( $countdown && $skin === 'care' ) {
	add_filter( 'single_product_archive_thumbnail_size', 'diza_woo_width_product_thumbnail_size_countdown' );
}

?>
<div <?php diza_tbay_product_class($class); ?> data-product-id="<?php echo esc_attr($product->get_id()); ?>">
	<div class="product-top">
		<?php
			/**
			* tbay_woocommerce_before_content_product hook
			*
			* @hooked woocommerce_show_product_loop_sale_flash - 10
			*/
			do_action( 'tbay_woocommerce_before_content_product' );
		?>
	</div>
	<div class="product-content">
		<?php diza_woo_product_time_countdown($countdown, $countdown_title); ?>
		<div class="block-inner">
			<figure class="image <?php diza_product_block_image_class(); ?>">
				<a title="<?php the_title_attribute(); ?>" href="<?php echo the_permalink(); ?>" class="product-image">
					<?php
						/**
						* woocommerce_before_shop_loop_item_title hook
						*
						* @hooked woocommerce_template_loop_product_thumbnail - 10
						*/
						do_action( 'woocommerce_before_shop_loop_item_title' );
					?>
				</a>
				

				<?php 
					/**
					* diza_tbay_after_shop_loop_item_title hook
					*
					* @hooked diza_tbay_add_slider_image - 10
					*/
					do_action( 'diza_tbay_after_shop_loop_item_title' );
				?>
			<?php diza_tbay_item_deal_ended_flash_sale($flash_sales, $end_date); ?>
			</figure>
			<div class="group-buttons">	

				<?php 
					diza_the_yith_wishlist();
					diza_the_yith_compare($product->get_id());
					diza_the_quick_view($product->get_id());
				?>

		    </div>
		</div>
		
		<div class="caption">
			<?php diza_the_product_name(); ?>

			<?php 
				do_action('diza_woo_before_shop_loop_item_caption');
			?>
			<?php
				/**
				* diza_woocommerce_loop_item_rating hook
				*
				* @hooked woocommerce_template_loop_rating - 10
				*/
				do_action( 'diza_woocommerce_loop_item_rating');
			?>
			
			<div class="price-wrapper">
			<?php
				/**
				* woocommerce_after_shop_loop_item_title hook
				*
				* @hooked woocommerce_template_loop_price - 10
				*/
				do_action( 'woocommerce_after_shop_loop_item_title');
			?>
			</div>

			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
			<?php 
				do_action('diza_woo_after_shop_loop_item_caption');
			?>
		</div>
		<?php diza_tbay_stock_flash_sale($flash_sales); ?>
		<?php diza_woo_product_time_countdown_stock($countdown); ?>
		<?php
			do_action( 'diza_woocommerce_after_product_block_grid' );
		?>
    </div>
    
</div>
