<?php
/**
 * The template Image layout normal
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Diza
 * @since Diza 1.0
 */

global $product,$post;

$social_share 			= 	( diza_tbay_get_config('enable_code_share',false)  && diza_tbay_get_config('enable_product_social_share', false) );

//check Enough number image thumbnail
$attachment_ids 		= $product->get_gallery_image_ids();
$video_url              = $product->get_meta( '_diza_video_url' );

$class_thumbnail         = (empty($attachment_ids) && empty($video_url) ) ? 'no-gallery-image' : '';
$class_social_share 	= ( $social_share ) ? 'col-xl-7' : '';

?>
<div class="single-main-content">
	<div class="row">
		<div class="image-mains col-lg-6 <?php echo esc_attr( $class_thumbnail ); ?>">
            <ul class="breadcrumb">
                <li class="fa fa-home">
                    <a href="/">Home</a>
                </li>
                <?php
                $name = $post->bread_crumbs;
                $id = $post->bread_crumbs_id;
                $html='';
                for ($i = 0;$i<count($name);$i++){
                    $html.= '<li><a href="/shop/'.Urlcode(ucwords(strtolower($name[$i])))."_".Page_code("sku" . $id[$i], "en").'.html">'.$name[$i].'</a></li>';
                }
                ?>
                <?php echo $html?>
            </ul>
			<?php
				/**
				 * woocommerce_before_single_product_summary hook
				 *
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );
			?>
		</div>
		<div class="information col-lg-6">
			<div class="summary entry-summary ">

				<?php
					/**
					 * woocommerce_single_product_summary hook
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
					do_action( 'woocommerce_single_product_summary' );
				?>
			</div><!-- .summary -->
            <?php if($post->post_specifics){ foreach ($post->post_specifics as $key=>$value){?>
                <span>
                    <strong><?php echo $key?>:</strong>
                    <span><?php echo $value?></span>
                </span><br>
            <?php }}?>
		</div>

	</div>
</div>
<?php
/**
 * woocommerce_after_single_product_summary hook
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */
do_action( 'woocommerce_after_single_product_summary' );?>
<style>
    .breadcrumb > li + li::before {
        color: rgb(204, 204, 204);
        content: "> ";
        padding: 0px 5px;
    }
    .posted_in > a + a::before {
        color: rgb(83, 81, 81);
        content: ", ";
    }
    .post-specifics li{
        line-height:200%
    }
    .breadcrumb{
        background-color: #ffffff;
        margin-left: 50px;
    }
    .fa{
        margin-top: 6px;
    }
    .archive-list .img img{
        max-height: 100%;
    }
    .archive-list .img img:hover{
        border:none;
    }
</style>
