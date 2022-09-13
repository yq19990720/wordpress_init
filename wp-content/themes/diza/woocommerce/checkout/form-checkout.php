<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if (! defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);
// If checkout registration is disabled and not logged in, the user cannot checkout.
if (! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', esc_html__('You must be logged in to checkout.', 'diza')));
    return;
}

$class_checkout = 'checkout woocommerce-checkout row';
if (class_exists('WooCommerce_Germanized')) {
    $class_checkout .= ' wc-germanized';
}
?>
<?php if (!is_user_logged_in()) {
    ?>
    <!-- 如果localstorage无数据重定向到cart页 -->
    <script>
            products = get_seo_localstorage('product');
            if(!products){
                window.location.href = "/cart";
            }
    </script>
    <?php
}?>
<form name="checkout" method="post" class="<?php echo esc_attr($class_checkout); ?>" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

    <?php if ($checkout->get_checkout_fields()) :
        ?>
    <div class="billing-wrapper col-12 col-lg-6 col-xl-6">
        <?php do_action('woocommerce_checkout_before_customer_details'); ?>

        <div class="col2-set" id="customer_details">
           <div class="col-1">

                <?php do_action('woocommerce_checkout_billing'); ?>
           </div>

            <div class="col-2">
                <?php do_action('woocommerce_checkout_shipping'); ?>
           </div>
     </div>

        <?php do_action('woocommerce_checkout_after_customer_details'); ?>

    </div>
        <?php
    endif; ?>
 <div class="d-none d-xl-block col-xl-1"></div>
 <div class="review-wrapper col-12 col-lg-6 col-xl-5">
      <div class="order-review">
            <h3 id="order_review_heading"><?php esc_html_e('Your order', 'woocommerce'); ?></h3>
            <?php do_action('woocommerce_checkout_before_order_review'); ?>
            <div id="order_review" class="woocommerce-checkout-review-order checkout-max">
                <?php if (is_user_logged_in()) {
                    ?>
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                    <?php
                } else {
                    ?>
                    <script>
                        jQuery(document).ready(function($) {
                            products = get_seo_localstorage('product');
                            var rate = "<?php echo get_rate_price(determine_locale_currency(), "", "", "RATE")?>";
                            var Subtotal = get_price(products,rate);
                            var usd_subtotal = get_price(products,1)
                            var Freight = decimal(12.00 * rate);
                            var usd_freight = 12.00;
                            if (Subtotal > 39.99 * rate) {
                                Freight = 0.00;
                            }
                            if (usd_subtotal > 39.99) {
                                usd_freight = 0.00;
                            }
                            var Total = Subtotal;
                            var usd_total = usd_subtotal;
                            if (Subtotal < 39.99 * rate) {
                                Total = decimal(Math.floor(math.add(Subtotal,Freight) * 100)/100);
                                usd_total = decimal(Math.floor(math.add(usd_subtotal,usd_freight) * 100) / 100)
                            }
                            var html = '<table class="shop_table woocommerce-checkout-review-order-table">' +
                                '<thead><tr><th class="product-name">'+"<?php echo esc_html__("Product", 'woocommerce')?>"+'</th><th class="product-total">'+"<?php echo esc_html__("Subtotal", 'woocommerce')?>"+'</th></tr></thead>' +
                                '<tbody>'
                            $.each(products, function (i, item) {
                                html+= '<tr class="cart_item">' +
                                    '<td class="product-name">' +
                                    '<img src="' + item.image + '" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt>' + item.name + '' +
                                    '<strong class="product-quantity">&times;&nbsp;' + item.quantity + '</strong>' +
                                    '</td>' +
                                    '<td class="product-total">' +
                                    '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price="'+item.price+'">'+"<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>"+decimal(item.price * rate)+'</span></bdi></span>' +
                                    '</td>' +
                                    '</tr>'
                            })
                            html+= '</tbody>' +
                                '<tfoot>' +
                                '<tr class="cart-subtotal"><th>'+"<?php echo esc_html__("Subtotal", 'woocommerce')?>"+'</th><td  data-title="Subtotal"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price="'+usd_subtotal+'">'+"<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>"+Subtotal+'</span></bdi></span></td></tr>' +
                                '<tr class="cart-subtotal"><th>'+"<?php echo esc_html__("Freight", 'woocommerce')?>"+'</th><td  data-title="Freight"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price="'+usd_freight+'">'+"<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>"+Freight+'</span></bdi></span></td></tr>' +
                                '<tr class="order-total"><th>'+"<?php echo esc_html__("Total", 'woocommerce')?>"+'</th><td  data-title="Total"><strong><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price="'+usd_total+'">'+"<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>"+Total+'</span></bdi></span></strong></td></tr>' +
                                '</tfoot>' +
                                '</table>' +
                                '</div>' +
                                '</div>';
                            $('.checkout-max').html(html)
                        });
                    </script>
                    <?php
                }?>
          </div>
            <?php if (!class_exists('WooCommerce_Germanized')) :
                ?>
                <div class="order-payment">
                    <h3 id="order_payment_heading"><?php esc_html_e('Payment method', 'woocommerce'); ?></h3>
                    <?php do_action('woocommerce_checkout_after_order_review'); ?>
                </div>
                <?php
            endif; ?>
     </div>
 </div>
</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
