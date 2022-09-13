<?php 
/**
 * Templates Name: Elementor
 * Widget: Site Logo
 */

$settings['image']['url'] = $settings['image_logo']['url'];
$settings['image']['id'] = $settings['image_logo']['id'];

if ( empty( $settings['image']['url'] ) ) {
    return;
}


$has_caption = ! empty( $settings['caption'] );

$this->add_render_attribute( 'content', 'class', 'header-logo' );

if ( ! empty( $settings['shape'] ) ) {
    $this->add_render_attribute( 'wrapper', 'class', 'elementor-image-shape-' . $settings['shape'] );
}
 
$link = $this->get_link_url( $settings );

if ( $link ) {
    $this->add_render_attribute( 'link', [
        'href' => $link['url'],
    ] );
} ?>

<div <?php echo trim($this->get_render_attribute_string( 'wrapper' )); ?>>

    <div <?php echo trim($this->get_render_attribute_string( 'content' )); ?>>
        <?php if ( $link ) : ?>

             <a <?php echo trim($this->get_render_attribute_string( 'link' )); ?>>
                <?php echo  Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
            </a>
 
        <?php else: ?>
            <?php echo  Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
        <?php endif; ?>
    </div>

</div>