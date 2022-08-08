<?php

/*
Plugin Name: WooCommerce stripe支付系统跳转接口
Plugin URI: http://google.com/
Description: WooCommerce stripe支付系统跳转接口
Version: 1.0.0
Author: google
Text Domain: google
Author URI: http://google.com/
*/
add_action('plugins_loaded', 'init_stripeloli_gateway', 0);
add_action('woocommerce_thankyou_stripe', 'woocommerce_thankyou_stripe');

function init_stripeloli_gateway()
{
    require_once('class-wc-gateway-stripeloli.php');
    // Add the gateway to WooCommerce
    function add_stripeloli_gateway($methods)
    {
        return array_merge($methods, array('WC_Gateway_Stripeloli'));
    }
    add_filter('woocommerce_payment_gateways', 'add_stripeloli_gateway');
    add_filter('wp_loaded', 'woocommerce_stripeloli_callback');
    add_action('woocommerce_api_wc_gateway_stripeloli', 'woocommerce_stripeloli_callback');
}
function woocommerce_thankyou_stripe($order_id)
{
    $order = wc_get_order($order_id);
    if ($order->has_status('pending') || $order->has_status('failed')) {
        require_once('class-wc-gateway-stripeloli.php');
        $stripeloli = new WC_Gateway_Stripeloli();
        echo $stripeloli->checkout_form($order_id);
    }
}

function woocommerce_stripeloli_callback()
{
    $request_data = file_get_contents("php://input");
    $data =  json_decode($request_data, true);
    $order_id = $data['order_no'];
    $order = wc_get_order($order_id);
    $result = $data['payment_status'];

    if ($result == 'Completed') {
        $comment = 'Order payment successful!';
        $order->update_status('completed', $comment, true);
    } elseif ($result == 'failed') {
        $comment = 'Order payment Fail!';
        $order->update_status("failed", $comment, true);
    } elseif ($result == 'cancelled') {
        $comment = 'Order payment cancelled!';
        $order->update_status("cancelled", $comment, true);
    } elseif ($result == 'refunded') {
        $comment = 'Order payment refunded!';
        $order->update_status("refunded", $comment, true);
    } elseif ($result == 'onhold') {
        $comment = 'Order payment is on hold!';
        $order->update_status('on-hold', $comment, true);
    }
}
