<?php
$type = '';
extract( $args );
extract( $instance );

$output = '';

if ($nav_menu) {
	$term = get_term_by( 'slug', $nav_menu, 'nav_menu' );
}

$el_class = ' treeview-menu';

$output = '<div class="tbay_custom_menu wpb_content_element' . esc_attr( $el_class ) . '">';
$output .= '<div class="widget">';

if( isset($title) && !empty($title) ) {
	$output .= '<h2 class="widgettitle">'. $title .'</h2>';
}

global $wp_widget_factory;
// to avoid unwanted warnings let's check before using widget
if ( !empty($term) ) {

	$_id = diza_tbay_random_key();

    $args = array(
        'menu' 			  => $nav_menu,
        'container_class' => 'menu-category-menu-container',
        'menu_class' => 'menu treeview nav',
        'fallback_cb' => '',
		'before'          => '',
		'after'           => '',
		'echo'			  => false,
        'menu_id' => $nav_menu.'-'.$_id,
    );

    if( class_exists("Diza_Tbay_Custom_Nav_Menu") ){

        $args['walker'] = new Diza_Tbay_Custom_Nav_Menu();
    }

	$output .= wp_nav_menu($args);

	$output .= '</div>';
	$output .= '</div>';

     echo trim($output);

} else {
    esc_html_e( 'Not found in custom menu', 'woocommerce' );
}

