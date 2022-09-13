<?php 
global $product;

?>
<div class="product-block list" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
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
	<?php 
		/**
		* diza_woocommerce_before_shop_list_item hook
		*
		* @hooked diza_tbay_woocommerce_list_variable_swatches_pro - 5
		*/
		do_action( 'diza_woocommerce_before_shop_list_item' );
	?>

	<div class="product-content row">
		<div class="block-inner col-5 col-lg-3">
			<figure class="image <?php diza_product_block_image_class(); ?>">
				<a title="<?php the_title_attribute(); ?>" href="<?php echo the_permalink(); ?>" class="product-image">
					<?php
						/**
						* woocommerce_before_shop_loop_item_title hook
						*
						* @hooked woocommerce_show_product_loop_sale_flash - 10
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
					* @hooked diza_tbay_woocommerce_variable - 15
					*/
					do_action( 'diza_tbay_after_shop_loop_item_title' );
				?>
				<div class="group-buttons clearfix">	
					

					<?php 
						diza_the_yith_wishlist();
						diza_the_quick_view($product->get_id());
						diza_the_yith_compare($product->get_id());
					?>
		    	</div>
			</figure>
		</div>
		<div class="caption col-7 col-lg-9">
			<div class="caption-left">
				
				<?php diza_the_product_name(); ?>
				<?php 
					do_action('diza_woo_before_shop_list_caption');
				?>
				<?php
					/**
					* diza_woo_list_caption_left hook
					*
					* @hooked woocommerce_template_loop_rating - 5
					*/
					do_action( 'diza_woo_list_caption_left');
				?>
				<?php
					/**
					* diza_woo_list_caption_right hook
					*
					* @hooked woocommerce_template_loop_price - 5
					*/
					do_action( 'diza_woo_list_caption_right');
				?>
				<?php
				if (!empty(get_the_excerpt()) ) {
					?>
					<div class="woocommerce-product-details__short-description">
						<?php echo get_the_excerpt(); ?>
					</div>
					<?php
				}
				?>
				
	           	<?php
					do_action( 'diza_woo_list_after_short_description');
				?>
				<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	        </div>
		</div>
	</div>
	<?php 
		do_action( 'diza_woocommerce_after_shop_list_item' );
	?>
</div>


