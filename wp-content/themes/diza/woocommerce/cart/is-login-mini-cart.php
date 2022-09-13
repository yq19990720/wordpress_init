<?php

/**
 * 未登录时获取的购物车数据
 */

global $woocommerce;
$_id = diza_tbay_random_key();
?>

<?php do_action('woocommerce_before_mini_cart'); ?>
<script>
    jQuery(document).ready(function($) {
        var res  = get_seo_localstorage('product')
        var rate = "<?php echo get_rate_price(determine_locale_currency(), "", "", "RATE")?>";
        var price = get_price(res,rate);
        var usd_price = get_price(res,1);
        if(res){
            var html = '<dev class="mini_cart_content"><div class="mini_cart_inner"><div class="mcart-border"><ul class="cart_list product_list_widget ">'
            $.each(res,function (i,item) {
                html+= '<li id="mcitem-'+item.cart_id+'"><div class="product-image"><a class="image"><img width="1" height="1" src="'+item.image+'" class="attachment-woocommerce_gallery_thumbnail size-woocommerce_gallery_thumbnail" alt></a></div>' +
                    '<div class="product-details"><a class="product-name" href="/detail/'+item.slug+'"><span>'+item.name+'</span></a><div class="group"><span class="quantity"><span class="woocommerce-Price-amount amount">'+item.quantity+' x <bdi><span class="woocommerce-Price-currencySymbol" usd_price='+item.price+'>'+standard_price("<?php echo determine_locale()?>","<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>"+item.price * rate,"<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>","<?php echo determine_locale_currency()?>")+'</bdi></span></span></div>' +
                    '<a href="javascript:void(0);" class="remove remove_from_cart_button" aria-label="Remove this item" data-product_id="'+item.cart_id+'"><i class="tb-icon tb-icon-trash"></i></a></div>' +
                    '</li>'
            });
            html+= '</ul>'+'<div class="group-button"><p class="total"><strong>'+"<?php esc_html_e('Subtotal', 'woocommerce'); ?>"+':</strong><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol" usd_price='+usd_price+'>'+standard_price("<?php echo determine_locale()?>","<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>"+price,"<?php echo get_woocommerce_currency_symbol(determine_locale_currency())?>","<?php echo determine_locale_currency()?>")+'</span></bdi></span></p><p class="buttons"><a href="/cart" class="button view-cart">'+"<?php esc_html_e('View Cart', 'woocommerce'); ?>"+'</a><a href="/checkout" class="button checkout">'+"<?php esc_html_e('Checkout', 'woocommerce'); ?>"+'</a></p></div>' +
                '</div></div></dev>'
        }else{
            var html = '<dev class="mini_cart_content"><div class="mini_cart_inner"><div class="mcart-border"><ul class="cart_empty">' +
                '<li><span>'+"<?php esc_html_e('Your cart is empty!', 'woocommerce'); ?>"+'</span></li><li class="total"><a class="button wc-continue" href="/shop">'+"<?php esc_html_e('Continue Shopping', 'woocommerce'); ?>"+'<i class="tb-icon tb-icon-chevron-right"></i></a></li>'+
                '</ul><div class="clearfix"></div></div></div></dev>'
        }
        $('.widget_shopping_cart_content').html(html)
    })
</script>
<?php do_action('woocommerce_after_mini_cart'); ?>
