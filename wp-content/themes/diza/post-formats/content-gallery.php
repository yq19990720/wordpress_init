<?php
/**
 *
 * The default template for displaying content
 * @since 1.0
 * @version 1.2.0
 *
 */

$columns					= diza_tbay_blog_loop_columns('');
$date 						= diza_tbay_get_boolean_query_var('enable_date');
$author 					= diza_tbay_get_boolean_query_var('enable_author');
$categories 				= diza_tbay_get_boolean_query_var('enable_categories');
$cat_type 					= diza_tbay_categories_blog_type();
$short_descriptions 		= diza_tbay_get_boolean_query_var('enable_short_descriptions');
$read_more 					= diza_tbay_get_boolean_query_var('enable_readmore');
$comment					= diza_tbay_get_boolean_query_var('enable_comment');
$comment_text					= diza_tbay_get_boolean_query_var('enable_comment_text');

$image_position   			= apply_filters( 'diza_archive_image_position', 10,2 );

$class_main = $class_left = '';
if( $image_position == 'left' ) {
	$class_main = 'row';
	$class_left = ' col-md-6';
}

wp_enqueue_script( 'slick' );
wp_enqueue_script( 'diza-custom-slick' );

$galleries = diza_tbay_get_post_galleries();

$class_blog = ($columns > 1) ? 'post-grid' : 'post-list';
?>
<!-- /post-standard -->
<?php if ( ! is_single() ) : ?>
<div  class="<?php echo esc_attr( $class_blog ); ?> clearfix position-image-<?php echo esc_attr($class_main); ?>">
<?php endif; ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class($class_main); ?>>
<?php if ( is_single() ) : ?>
	<div class="entry-single">
	<?php echo diza_tbay_post_media( get_the_excerpt() ); ?>
<?php endif; ?>
		<?php
			if ( is_single() ) : ?>
				
	        	<div class="entry-header">
	        		<?php
		                if (get_the_title()) {
		                ?>
		                    <h1 class="entry-title">
		                       <?php the_title(); ?>
		                    </h1>
		                <?php
		            	}
		            ?>

				    <?php diza_post_meta(array(
						'date'     		=> 1,
						'author'   		=> 1,
						'comments' 		=> 1,
						'comments_text' => 1,
						'tags'     		=> 0,
						'cats'     		=> 1,
						'edit'     		=> 0,
					)); ?>
		            
				</div>
				<?php if( $galleries ): ?>
				<div id="post-slide-<?php the_ID(); ?>" class="owl-carousel-play" data-ride="carousel">
					<div class="owl-carousel slider-blog" data-carousel="owl" data-items="1" data-desktopslick="1" data-desktopsmallslick="1" data-tabletslick="1" data-landscapeslick="1" data-mobileslick="1" data-nav="true" data-pagination="false">
						<?php foreach ($galleries as $key => $_img) {
							echo '<img src="'. esc_url($_img) .'">';
						} ?>
					</div>
				</div>
				<?php elseif( has_post_thumbnail() ) : ?>
					<?php diza_tbay_post_thumbnail(); ?>
				<?php endif; ?>
				<div class="post-excerpt entry-content">
					 

					<?php the_content( esc_html__( 'Continue reading', 'diza' ) ); ?>

					<?php do_action('diza_tbay_post_bottom') ?>
					
				</div><!-- /entry-content -->

				<?php
					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'diza' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'diza' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					) );
				?>
		<?php endif; ?>
        
    <?php if ( ! is_single() ) : ?>
	
    	<?php
		 	if ( has_post_thumbnail() ) {
		  	?>
		  	<figure class="entry-thumb <?php echo esc_attr( $class_left ); ?> <?php echo  (!has_post_thumbnail() ? 'no-thumb' : ''); ?>">
				   <?php diza_tbay_post_thumbnail(); 
				   ?>
		  	</figure>
		  	<?php
		 	}
		?>
		<div class="entry-content <?php echo esc_attr( $class_left ); ?> <?php echo ( !has_post_thumbnail() ) ? 'no-thumb' : ''; ?>">

			<div class="entry-header">

				<?php diza_post_meta(array(
					'date'     => $date,
					'author'     => $author,
					'tags'     => 0,
					'cats'     => $categories,
					'comments' 		=> $comment,
					'comments_text' 		=> $comment_text,
					'edit'     => 0,
				)); ?>

				<?php diza_post_archive_the_title(); ?>

				<?php if( $short_descriptions ) : ?>
					<?php diza_post_archive_the_short_description(); ?>
				<?php endif; ?>

				<?php if( $read_more ) : ?>
					<?php diza_post_archive_the_read_more(); ?>
				<?php endif; ?>

		    </div>

		</div>

    <?php endif; ?>
    <?php if ( is_single() ) : ?>
</div>
<?php endif; ?>
</article>

<?php if ( ! is_single() ) : ?>
</div>
<?php endif; ?>