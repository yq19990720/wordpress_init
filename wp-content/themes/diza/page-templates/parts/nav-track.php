<?php
$args = array(
    'theme_location'  => 'track-order',
    'fallback_cb'     => '',
    'menu_id'         => 'track-order',
    'walker'		  => new diza_Tbay_Nav_Menu()
);
wp_nav_menu($args);