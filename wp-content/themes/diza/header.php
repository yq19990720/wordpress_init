<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Diza
 * @since Diza 1.0
 */
?><!DOCTYPE html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
        <?php global $jsonld; if($jsonld) echo $jsonld."\n" ?>
    <meta name="keywords" content="<?php print get_keywords()?>">
    <meta name="description" content="<?php echo get_description()?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="wrapper-container" class="<?php echo apply_filters( 'diza_class_wrapper_container', 'wrapper-container' ); ?>">

	<?php
		/**
		* diza_before_theme_header hook
		*
		* @hooked diza_tbay_offcanvas_smart_menu - 10
		* @hooked diza_tbay_the_topbar_mobile - 20
		* @hooked diza_tbay_custom_form_login - 30
		* @hooked diza_tbay_footer_mobile - 40
		*/
		do_action('diza_before_theme_header');
	?>

	<?php get_template_part( 'page-templates/header' ); ?>

	<?php
		/**
		* diza_after_theme_header hook
		*/
		do_action('diza_after_theme_header');
	?>

	<div id="tbay-main-content">
