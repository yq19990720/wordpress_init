<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Diza
 * @since Diza 1.0
 */
/*

*Template Name: 404 Page
*/
get_header();

?>

<section id="main-container" class=" container inner">
	<div id="main-content" class="main-page page-404">

		<section class="error-404">
			<div class="row">
				<div class="col-md-6 col-xl-4 content-404">
					<h1 class="heading-404"><?php esc_html_e( 'Oops!', 'woocommerce' ); ?></h1>
					<h1><?php esc_html_e( 'that link is broken', 'woocommerce' ); ?></h1>
					<div class="page-content">
						<p class="sub-title"><?php esc_html_e( 'Page does not exist or some other error occured. Go to our Home page or go back to Previous page', 'diza') ?> </p>
						<a class="backtohome" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('home page', 'diza'); ?></a>
					</div>
				</div>
				<div class="col-md-6 col-xl-8 text-center">
					<?php
						$link = DIZA_IMAGES . '/img-404.png';
						?><img src="<?php echo esc_url($link); ?>" alt="<?php esc_attr_e('Banner 404', 'diza'); ?>" class="img-fluid" /><?php
					?>
				</div>
			</div>

		</section><!-- .error-404 -->
	</div>
</section>

<?php get_footer(); ?>
