<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined('ABSPATH') || exit;

remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_after_cart_contents', 'woocommerce_cross_sell_display');

do_action('woocommerce_before_cart'); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post" id="product_table">
    <?php do_action('woocommerce_before_cart_table'); ?>
    <div class="row">
        <div class="col-lg-8 tb-cart-form">
            <div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents cart_max">
                <?php  if (is_user_logged_in()) {?>
                <div class="cart_item head">
                    <span class="product-info"><?php esc_html_e('Product', 'woocommerce'); ?></span>
                    <span class="product-price"><?php esc_html_e('Price', 'woocommerce'); ?></span>
                    <span class="product-quantity"><?php esc_html_e('Qty', 'woocommerce'); ?></span>
                    <span class="product-subtotal"><?php esc_html_e('Total', 'woocommerce'); ?></span>
                    <span class="product-remove">&nbsp;</span>
                </div>
                    <?php do_action('woocommerce_before_cart_contents'); ?>
                    <?php
                    global $rate;
                    $price = WC()->cart->get_woocommerce_cart_total();
                    $mini_subtotal = get_woocommerce_currency_symbol(determine_locale_currency()) . number_format($price  * $rate, 2);
                    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                        $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                            ?>
                            <div class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                            <span class="product-info" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                <?php
                                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                                if (! $product_permalink) {
                                    echo trim($thumbnail);
                                } else {
                                    printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
                                }
                                ?>
                                <span class="product-name">
                                    <?php
                                    if (! $product_permalink) {
                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name', esc_html($_product->get_name()), $cart_item, $cart_item_key) . '&nbsp;');
                                    } else {
                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url("/detail/" . $_product->slug), esc_html($_product->get_name())), $cart_item, $cart_item_key));
                                    }

                                    do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);
                                    // Meta data.
                                    echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                    // Backorder notification.
                                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                    }
                                    ?>
                                </span>

                            </span>

                                <span class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                            <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price="<?php echo $_product->price ?>"><?php echo get_woocommerce_currency_symbol(determine_locale_currency()) . number_format($_product->price * $rate, 2)?></span></bdi></span>
                        </span>

                                <span class="product-quantity" data-title="<?php esc_attr_e('Qty', 'woocommerce'); ?>">
                            <?php
                            if ($_product->is_sold_individually()) {
                                $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                            } else {
                                $product_quantity = woocommerce_quantity_input(array(
                                    'input_name'    => "cart[{$cart_item_key}][qty]",
                                    'input_value'   => $cart_item['quantity'],
                                    'max_value'     => $_product->get_max_purchase_quantity(),
                                    'min_value'     => '0',
                                    'product_name'  => $_product->get_name(),
                                ), $_product, false);
                            }

                            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                            ?>
                        </span>

                                <span class="product-subtotal price" data-title="<?php esc_attr_e('Total', 'woocommerce'); ?>">
                                    <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price="<?php echo $_product->price * $cart_item['quantity']?>"><?php echo get_woocommerce_currency_symbol(determine_locale_currency()) . number_format($_product->price * $rate * $cart_item['quantity'], 2)?></span></bdi></span>
                        </span>
                                <span class="product-remove">
                            <?php
                            // @codingStandardsIgnoreLine
                            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="tb-icon tb-icon-trash"></i></a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                esc_attr__('Remove this item', 'woocommerce'),
                                esc_attr(Page_code("sku" .  $product_id, "en")),
                                esc_attr($_product->get_sku())
                            ), $cart_item_key);
                            ?>
                        </span>
                        </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="cart-bottom clearfix" class="actions">
                        <?php if (wc_get_page_id('shop') > 0) : ?>
                            <div class="continue-to-shop pull-left hidden-xs">
                                <a href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
                                    <i class="tb-icon tb-icon-arrow-left"></i><?php esc_html_e('Continue Shopping', 'woocommerce') ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="update-cart pull-right">
                            <i class="tb-icon tb-icon-redo2"></i>
                            <input type="submit" class="btn btn-default update" name="update_cart" value="<?php esc_attr_e('Update Cart', 'woocommerce'); ?>" />
                        </div>

                        <?php do_action('woocommerce_cart_actions'); ?>

                        <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>

                    </div>
                    <?php
                } else {
                    ?>
                    <script>
                        jQuery(document).ready(function($) {
                            products =  get_seo_localstorage('product')
                            var rate = "<?php echo get_rate_price(determine_locale_currency(), "", "", "RATE")?>";
                            if(products !== null){
                                var html = '<div class="cart_item head">' +
                                    '<span class="product-info">'+"<?php echo esc_html__("Product", 'woocommerce')?>"+'</span>'+
                                    '<span class="product-price">'+"<?php echo esc_html__("Price", 'woocommerce')?>"+'</span>'+
                                    '<span class="product-quantity">'+"<?php echo esc_html__("Qty", 'woocommerce')?>"+'</span>'+
                                    '<span class="product-subtotal">'+"<?php echo esc_html__("Total", 'woocommerce')?>"+'</span>'+
                                    '<span class="product-remove">&nbsp;</span>' +
                                    '</div>'
                                $.each(products,function (i,item) {
                                    var total = decimal(Math.floor((item.price*item.quantity)*100)/100)
                                    html+= '<div class="cart_item"><span class="product-info" data-title="Product"><a href="/detail/'+item.slug+'"><img src="'+item.image+'" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt></a><span class="product-name"><a href="/detail/'+item.slug+'">'+item.name+'</a></span></span>' +
                                        '<span class="product-price" data-title="Price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price="'+item.price+'">'+"<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>"+decimal(item.price * rate)+'</span></bdi></span></span>' +
                                        '<span class="product-quantity" data-title="Qty"><div class="quantity"><span class="box"><button class="minus" type="button" value="&nbsp;"><i class="tb-icon tb-icon-minus"></i></button>' +
                                        '<input type="number" id="'+'" class="input-text qty text" oninput="value=value.replaceAll(\'-\', \'\')"  step="1" min="0" name="'+item.product_id+'" value="'+item.quantity+'" title="Qty" size="4" inputmode="numeric">' +
                                        '<button class="plus" type="button" value="&nbsp;"><i class="tb-icon tb-icon-plus"></i></button>' +
                                        '</span></div></span>' +
                                        '<span class="product-subtotal price" data-title="Total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price="'+total+'">'+"<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>"+decimal(total * rate)+'</span></bdi></span></span>' +
                                        '<span class="product-remove"><a href="/cart" class="remove remove_from_cart_button" aria-label="Remove this item" data-product_id="'+item.product_id+'"><i class="tb-icon tb-icon-trash"></i></a></span></div>'
                                })
                                $('.cart_max').html(html)
                                var clearfix = '<div class="continue-to-shop pull-left hidden-xs"><a href="/shop"><i class="tb-icon tb-icon-arrow-left"></i>'+"<?php echo esc_html__("Continue Shopping", 'woocommerce')?>"+'</a></div>' +
                                    '<div class="update-cart pull-right"><i class="tb-icon tb-icon-redo2"></i><input type="submit" class="btn btn-default update"  value="'+"<?php echo esc_html__("Update Cart", 'woocommerce')?>"+'"></div>'
                                $('.clearfix-max').html(clearfix)
                            }else{
                                var html = '<p class="cart-empty woocommerce-info">'+"<?php echo esc_html__("Your cart is currently empty.", 'woocommerce')?>"+'</p><p class="cart-empty woocommerce-info">'+"<?php echo esc_html__("Checkout is not available whilst your cart is empty.", 'woocommerce')?>"+'</p>'+
                                    '<p class="return-to-shop"><a class="button wc-backward" href="/shop">'+"<?php echo esc_html__("Return to shop", 'woocommerce')?>"+'</a></p>';
                                $('.woocommerce-notices-wrapper').html(html)
                            }
                        })
                    </script>
                    <?php
                }
                ?>
            </div>
            <?php if (!is_user_logged_in()) {
                ?><div class="cart-bottom clearfix clearfix-max"></div><?php
            }?>
            <?php if (wc_coupons_enabled()) {
                ?>
           <div class="coupon">
                <label for="coupon_code"><?php esc_html_e('Coupon apply', 'woocommerce'); ?></label>
                <div class="box"><input type="text" name="coupon_code" id="coupon_code" value="" class="text" placeholder="<?php esc_attr_e('Enter coupon code here...', 'woocommerce'); ?>" /><input type="submit" class="btn btn-default" name="apply_coupon" value="<?php esc_attr_e('Apply', 'woocommerce'); ?>" /></div>
                <?php do_action('woocommerce_cart_coupon'); ?>
         </div>
                <?php
            } ?>
            <?php do_action('woocommerce_cart_contents'); ?>
     </div>
     <div class="col-lg-4 tb-cart-total">
            <?php do_action('woocommerce_before_cart_collaterals'); ?>
            <div class="cart-collaterals">
                <?php
                if (is_user_logged_in()) {
/**
                     * Cart collaterals hook.
                     *
                     * @hooked woocommerce_cross_sell_display
                     * @hooked woocommerce_cart_totals - 10
                     */
                    do_action('woocommerce_cart_collaterals');
                } else {
                    ?>
                    <script>
                        jQuery(document).ready(function($) {
                            products =  get_seo_localstorage('product');
                            var rate = "<?php echo get_rate_price(determine_locale_currency(), "", "", "RATE")?>";
                            var Subtotal = get_price(products,rate);
                            var usd_subtotal = get_price(products,1)
                            var Freight = decimal(12.00 * rate);
                            var usd_freight = 12.00;
                            if(Subtotal>39.99 * rate){
                                Freight = 0.00;
                            }
                            if(usd_subtotal > 39.99){
                                usd_freight = 0.00;
                            }
                            var Total = Subtotal;
                            var usd_total = usd_subtotal;
                            if(Subtotal<39.99 * rate){
                                Total = decimal(Math.floor(math.add(Subtotal,Freight) * 100) / 100)
                                usd_total = decimal(Math.floor(math.add(usd_subtotal,usd_freight) * 100) / 100)
                            }
                            if(products !== null){
                                var html = '<div class="cart_totals">' +
                                    '<h2>'+"<?php echo esc_html__("Cart totals", 'woocommerce')?>"+'</h2>' +
                                    '<table cellspacing="0" class="shop_table shop_table_responsive">' +
                                    '<tbody>' +
                                    '<tr class="cart-subtotal"><th>'+"<?php echo esc_html__("Subtotal", 'woocommerce')?>"+'</th><td  data-title="Subtotal"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price="'+usd_subtotal+'">'+"<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>"+Subtotal+'</span></bdi></span></td></tr>' +
                                    '<tr class="cart-subtotal"><th>'+"<?php echo esc_html__("Freight", 'woocommerce')?>"+'</th><td  data-title="Freight"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price="'+usd_freight+'">'+"<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>"+Freight+'</span></bdi></span></td></tr>' +
                                    '<tr class="order-total"><th>'+"<?php echo esc_html__("Total", 'woocommerce')?>"+'</th><td  data-title="Total"><strong><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price="'+usd_total+'">'+"<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>"+Total+'</span></bdi></span></strong></td></tr>' +
                                    '</tbody>' +
                                    '</table>' +
                                    '<div class="wc-proceed-to-checkout"><a href="/checkout" class="checkout-button button alt">'+"<?php echo esc_html__("Proceed to checkout", 'woocommerce')?>"+'</a></div>' +
                                    '</div>';
                                $('.cart-collaterals').html(html)
                            }
                        })
                    </script>
                    <?php
                }
                ?>
            </div>


       </div>
 </div>

    <?php do_action('woocommerce_after_cart_contents'); ?>

    <?php do_action('woocommerce_after_cart_table'); ?>

</form>

<?php do_action('woocommerce_after_cart'); ?>
