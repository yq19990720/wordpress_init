<?php

if(!class_exists('WooCommerce')) return;


if ( ! function_exists( 'diza_tbay_recently_viewed_set_cookie_meta' ) ) {
    function diza_tbay_recently_viewed_set_cookie_meta($products_list) {
        $user_id            = get_current_user_id();
        $meta_products_list = 'diza_recently_viewed_product_list';
        $cookie_name        = 'diza_recently_viewed_products_list';

        $duration = 5;
        $duration = time() + (86400 * $duration);

        // if user also exists add meta with products list
        if( $user_id ) {
            update_user_meta( $user_id, $meta_products_list, $products_list );
        } else {
            // set cookie
            setcookie($cookie_name, serialize( $products_list ), $duration, COOKIEPATH, COOKIE_DOMAIN, false, true);
        }
    }
}

if ( ! function_exists( 'diza_tbay_wc_track_user_get_cookie' ) ) {

    function diza_tbay_wc_track_user_get_cookie() {
        $user_id            = get_current_user_id();
        $cookie_name        = 'diza_recently_viewed_products_list';
        $meta_products_list = 'diza_recently_viewed_product_list';

        if( ! $user_id ) {
            $products_list = isset( $_COOKIE[$cookie_name] ) ? unserialize( $_COOKIE[ $cookie_name ] ) : array();
        }
        else {
            $meta = get_user_meta( $user_id, $meta_products_list, true );
            $products_list = ! empty( $meta ) ? $meta : array();
        }

        return $products_list;

    }

}

if ( ! function_exists( 'diza_tbay_wc_track_user_viewed_produts' ) ) {
    function diza_tbay_wc_track_user_viewed_produts() {
        global $post;

        $products_list      = diza_tbay_wc_track_user_get_cookie();

        if( is_null( $post ) || ! is_product() )
            return;


        $product_id = intval( $post->ID );

        // if product is in list, remove it
        if( ( $key = array_search( $product_id, $products_list ) ) !== false ) {
            unset( $products_list[$key] );
        }

        $timestamp = time();
        $products_list[$timestamp] = $product_id;

        // set cookie and save meta
        diza_tbay_recently_viewed_set_cookie_meta($products_list);
    }
    add_action( 'template_redirect', 'diza_tbay_wc_track_user_viewed_produts', 99 );
    add_action( 'init', 'diza_tbay_wc_track_user_viewed_produts', 99 ); 
}

if ( ! function_exists( 'diza_tbay_get_products_recently_viewed' ) ) {
    function diza_tbay_get_products_recently_viewed($number_post = 8) {
        $products_list      = diza_tbay_wc_track_user_get_cookie();

        if( empty( $products_list ) ) {
            return '';
        }

        $products_list_value    = array_reverse(array_values($products_list));

        if( $number_post  !== -1 && count($products_list_value) > $number_post ) {
            $products_list_value    = array_slice($products_list_value, 0 , $number_post); 
        }   

        $type = 'products';
 
        $atts['ids'] = implode(',', $products_list_value);

        $shortcode = new WC_Shortcode_Products($atts, $type);  

        $args = $shortcode->get_query_args();

        $args['orderby'] = 'post__in';

        return $args;
    }
}

/*The list product recently viewed*/
if ( ! function_exists( 'diza_tbay_wc_get_recently_viewed' ) ) {
    function diza_tbay_wc_get_recently_viewed() {
            $num_post           =   diza_tbay_get_config('max_products_recentview', 8);
            
            $args = diza_tbay_get_products_recently_viewed($num_post);
            $args = apply_filters( 'diza_list_recently_viewed_products_args', $args );


            $products = new WP_Query( $args );

            ob_start();

            ?>
                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                    <?php wc_get_template_part( 'content', 'recent-viewed' ); ?>

                <?php endwhile; // end of the loop. ?>

            <?php

            $content = ob_get_clean();

            wp_reset_postdata();

            return $content;
    }
}
