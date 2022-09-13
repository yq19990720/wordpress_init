<?php

/*
Plugin Name: WooCommerce paypal支付系统跳转接口
Plugin URI: http://google.com/
Description: WooCommerce paypal支付系统跳转接口
Version: 1.0.0
Author: google
Text Domain: google
Author URI: http://google.com/
*/
add_action('plugins_loaded', 'init_paypalloli_gateway', 0);
add_action('woocommerce_thankyou_paypalloli', 'woocommerce_thankyou_paypalloli');

function init_paypalloli_gateway()
{
    require_once('class-wc-gateway-paypalloli.php');
    // Add the gateway to WooCommerce
    function add_paypalloli_gateway($methods)
    {
        return array_merge($methods, array('WC_Gateway_Paypalloli'));
    }
    add_filter('woocommerce_payment_gateways', 'add_paypalloli_gateway');
    add_filter('wp_loaded', 'woocommerce_paypalloli_callback');
    add_action('woocommerce_api_wc_gateway_paypalloli', 'woocommerce_paypalloli_callback');
}
function woocommerce_thankyou_paypalloli($order_id)
{
    $order = wc_get_order($order_id);
    if ($order->has_status('pending') || $order->has_status('failed')) {
        require_once('class-wc-gateway-paypalloli.php');
        $paypalloli = new WC_Gateway_Paypalloli();
        echo $paypalloli->checkout_form($order_id);
    }
}

function woocommerce_paypalloli_callback()
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
