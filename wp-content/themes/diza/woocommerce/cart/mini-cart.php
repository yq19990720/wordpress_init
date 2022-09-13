<?php

/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 5.2.0
 */

global $woocommerce,$rate;
$_id = diza_tbay_random_key();
?>

<?php do_action('woocommerce_before_mini_cart'); ?>
<div class="mini_cart_content">
  <div class="mini_cart_inner">
      <div class="mcart-border">
            <?php if (sizeof(WC()->cart->get_cart()) > 0) :
                ?>
                <ul class="cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
                    <?php
                    do_action('woocommerce_before_mini_cart_contents');
                    $price = WC()->cart->get_woocommerce_cart_total();
                    $subtotal = get_woocommerce_currency_symbol(determine_locale_currency()) . number_format($price  * $rate, 2);
                    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                        $_product     = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id   = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                            $product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                            $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_gallery_thumbnail'), $cart_item, $cart_item_key);
                            $product_price     = '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price=' . $_product->price . '>' . standard_price(determine_locale(), determine_locale_currency(), get_woocommerce_currency_symbol(determine_locale_currency()), number_format($_product->price * $rate, 2)) . '</span></bdi></span>';
                            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);

                            ?>
                            <li id="mcitem-<?php echo esc_attr($_id);?>-<?php echo esc_attr($cart_item_key); ?>">
                             <div class="product-image">
                                    <?php if (! $_product->is_visible()) :
                                        ?>
                                        <?php echo str_replace(array( 'http:', 'https:' ), '', $thumbnail); ?>
                                        <?php
                                    else :
                                        ?>
                                        <a class="image" href="<?php echo esc_url("/detail/" . $_product->slug); ?>">
                                            <?php echo str_replace(array( 'http:', 'https:' ), '', $thumbnail); ?>
                                       </a>
                                            <?php
                                    endif; ?>
                               </div>
                             <div class="product-details">

                                    <a class="product-name" href="<?php  echo esc_url("/detail/" . $_product->slug); ?>"><span><?php echo wp_kses_post($product_name); ?></span></a>

                                    <div class="group">
                                        <?php echo wc_get_formatted_cart_item_data($cart_item); ?>
                                     <span class="quantity">
                                            <?php echo apply_filters('woocommerce_widget_cart_item_quantity', sprintf('%s', $cart_item['quantity']), $cart_item, $cart_item_key); ?>x
                                      </span>
                                        <?php echo apply_filters('woocommerce_widget_cart_item_quantity', sprintf('%s', $product_price), $cart_item, $cart_item_key); ?>
                                   </div>
                                    <?php echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                        '<a href="javascript:void(0);" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-product_sku="%s" data-cart_item_key="%s"><i class="tb-icon tb-icon-trash"></i></a>',
                                        esc_attr__('Remove this item', 'woocommerce'),
                                        esc_attr(Page_code("sku" .  $product_id, "en")),
                                        esc_attr($_product->get_sku()),
                                        esc_attr($cart_item_key)
                                    ), $cart_item_key);
                                    ?>
                             </div>
                         </li>
                                    <?php
                        }
                    }

                    do_action('woocommerce_mini_cart_contents');
                    ?>
               </ul><!-- end product list -->
                <?php
            else : ?>
                <?php if (is_user_logged_in()) {?>
                    <ul class="cart_empty <?php echo esc_attr($args['list_class']); ?>">
                        <li><span><?php echo esc_html__('Your cart is empty', 'woocommerce') ?></span></li>
                        <li class="total"><a class="button wc-continue" href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>"><?php esc_html_e('Continue Shopping', 'woocommerce') ?><i class="tb-icon tb-icon-chevron-right"></i></a></li>
                    </ul>
                <?php }?>
            <?php endif; ?>

            <?php  if (sizeof(WC()->cart->get_cart()) > 0) : ?>
               <div class="group-button">

                    <p class="total">
                        <?php
                        /**
                         * Woocommerce_widget_shopping_cart_total hook.
                         *
                         * @hooked woocommerce_widget_shopping_cart_subtotal - 10
                         */
                        do_action('woocommerce_widget_shopping_cart_total');
                        ?>
                   </p>

                    <?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>

                  <p class="buttons">
                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="button view-cart"><?php esc_html_e('View Cart', 'woocommerce'); ?></a>
                        <a href="<?php echo esc_url(wc_get_checkout_url());?>" class="button checkout"><?php esc_html_e('Checkout', 'woocommerce'); ?></a>
                   </p>
               </div>
            <?php endif; ?>
         <div class="clearfix"></div>
       </div>
 </div>
</div>
<?php do_action('woocommerce_after_mini_cart'); ?>
