<?php

class WC_Gateway_Stripeloli extends WC_Payment_Gateway
{
    // const PAYLOLI_REDIRECT_URL = 'http://api.palzpay.com/test1/app/order/create?appkey=k4qLdprhJUaT1XWytTrTb60s0UYWEgoZ&nounce=2&signature=2&timestamp=2';
    static $fields = array(
        'username',
        'token',
        'client_ip',
        'invoice_id',
        'order_no',
        'currency',
        'subject',
        'body',
        'amount',
        'cancel_uri',
        'productsids',
        'success_uri',
        'return_uri',
        'notify_url',
        'custom',
        'first_name',
        'last_name',
        'address',
        'country',
        'zone',
        'city',
        'email',
        'zip_code',
        'telephone',
    );

    public function __construct()
    {

        $this->id = 'stripe';
        $this->icon = "/" . WPCON . '/plugins/stripe/images/stripe_checkout.png'; //'Paypal checkout';
        $this->has_fields = false;

        $this->method_title = 'Stripe LoLi';
        $this->method_description = 'Stripe LoLiPay';

        // Load the settings.
        $this->init_form_fields();
        $this->init_settings();

        $this->title = $this->get_option('title');
        $this->description = $this->get_option('title');

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
    }

    public function init_form_fields()
    {
        $this->form_fields = array(
            'enabled' => array(
                'title' => '开启',
                'type' => 'checkbox',
                'label' => '是否开启此支付接口',
                'default' => 'yes',
            ),
            'title' => array(
                'title' => '前台支付页面显示的支付名称',
                'type' => 'text',
                'description' => '',
                'default' => esc_html__('Checkout with CreditCard ', 'woocommerce'),
                'desc_tip' => true,
            ),
            'countrys' => array(
                'title' => '不允许支付的国家',
                'type' => 'textarea',
                'description' => '请用逗号隔开,如：US,CA,AU,GB',
                'default' => 'All',
                'desc_tip' => true,
                'placeholder' => __('Required', 'woocommerce'),
            ),
            'loli_stripe_appkey' => array(
                'title' => 'appkey',
                'type' => 'text',
                'description' => '',
                'default' => 'k4qLdprhJUaT1XWytTrTb60s0UYWEgoZ',
                'value' => STRIPEURL,
                'desc_tip' => true,
                'placeholder' => __('Required', 'woocommerce')
            ),
            'loli_stripe_url' => array(
                'title' => '接口地址',
                'type' => 'text',
                'description' => '',
                'default' => '',
                'value' => STRIPEURL,
                'desc_tip' => true,
                'placeholder' => __('Required', 'woocommerce')
            ),

        );
    }

    /**
     * Process the payment and return the result.
     *
     * @param int $order_id Order ID.
     * @return array
     */
    public function process_payment($order_id)
    {
        $order = wc_get_order($order_id);

        $order->update_status('pending');
        return array(
            'result' => 'success',
            'redirect' => $this->get_return_url($order),
        );
    }

    function checkout_form($order_id)
    {
        $order = wc_get_order($order_id);
        $product = get_post($order_id);
        if ($order->total > 0) {
            // verify Whether and status the time has expired
            $result = order_time_verify($order);
            if ($result || $order->get_status() == "timed out") {
                if ($order->get_status() != "timed out") {
                    $order->update_status('wc-timed-out', "Order Time out!", true);
                }
                echo PAY_TIME_OUT;
                exit();
            }
            $billing_address = $order->get_address();
            $invoice_id = array(
                'order_id' => $order_id,
                'order_key' => $_GET['key'],
            );
            $custom = json_encode($invoice_id);
            $products = $order->get_items();
            $order_products = array();
            if ($products) {
                foreach ($products as $item) {
                    if (!$item->get_name() || !$item->get_quantity()) {
                        echo PAY_ERROR;
                        exit();
                    }
                    $pid = $item->get_id();
                    if (strlen($pid) > 0) {
                        $productsid[] = $pid;
                    }
                    //获取产品信息
                    $order_products[] = array(
                        "final_price" => floatval($item->get_total()),
                        "id" => maybe_unserialize($product->post_content)[$item->get_name()],
                        "model" => "",
                        "name" => $item->get_name(),
                        "price" => floatval($item->get_total()) / floatval($item->get_quantity()),//便于计算转换为float，此处可携带任何类型B站已做兼容
                        "qty" => $item->get_quantity(),
                        "tax" => 0
                    );
                }
            } else {
                echo PAY_ERROR;
                exit();
            }

            $fetch_url = explode("//", STRIPEURL)[1];

            $url = STRIPEURL . '/app/order/create?appkey=' . STRIPEKEY . '&nounce=2&signature=2&timestamp=2';

            $data = array(
                "order_id" => $order_id,
                "paypal" => array(
                    "H_PhoneNumber" => $billing_address['phone'],
                    "address1" => $billing_address['address_1'] . $billing_address['address_2'],
                    "amount" => $order->get_total() * 100,
                    "bn" => "",
                    "business" => $this->get_option('loli_paypal_appkey'),
                    "cancel_return" => $order->get_cancel_order_url_raw(),
                    "charset" => "UTF-8",
                    "city" => $billing_address['city'],
                    "cmd" => "",
                    "country" => WC()->countries->get_shipping_countries()[$billing_address['country']],
                    "country_code" => $billing_address['country'],
                    "currency_code" => $order->get_currency(),
                    "custom" => $custom,
                    "email" => $billing_address['email'],
                    "first_name" => ucfirst(strtolower($billing_address['first_name'])),
                    "item_name" => "none",
                    "last_name" => ucfirst(strtolower($billing_address['last_name'])),
                    "lc" => array_search(determine_locale(), get_woocommerce_lc()),
                    "mrb" => "",
                    "notify_url" => WC()->api_request_url('WC_Gateway_Paypalloli') . '&dh_rt=ipn',
                    "page_style" => "",
                    "pal" => "",
                    //这个是否为success的url？
                    "redirect_cmd" => $this->get_return_url($order) . '&dh_rt=real_time',
                    "return" => $this->get_return_url($order) . '&dh_rt=real_time',
                    "rm" => "",
                    "shipping" => "",
                    "shopping_url" => "",
                    "state" => $billing_address['state'],
                    "sub_total" => $order->get_total(),
                    "tax" => "",
                    "tax_cart" => "",
                    "zip" => $billing_address['postcode'],
                ),
                "products" => $order_products
            );
            $result = $this->curl_submit($url, json_encode($data));

            if (empty($result)) {
                //报错
                echo("Server internal error please contact administrator!");
                exit;
            } else {
                //   跳转
                $result_array = json_decode($result, true);
                if ($result_array["code"] == '0' && $result_array["message"] == 'success') {
                    $this->submit_data($result_array, $fetch_url, $order_id);
                } else {
                    //报错误
                }
                return false;
            }
        }
    }

    function submit_data($data, $fetch_url, $id)
    {
        $buttonArray = array();
        $form_action_url = $data["data"]["redirect_url"] . "/q_stripe/index.php";
        $order_id = $data["data"]["order_id"];
        $merchant_name = $data["data"]["merchant_name"];
        $domain = "http://" . $_SERVER['HTTP_HOST'];
        WC()->session->set("clear_cart_id", $id);
        $return_url = $domain . PRODUCT_URL;
        $cancel_url = $domain . "/checkout";
        $notify_url = $domain . PRODUCT_URL;
        $process_button_string = "\n" . implode("\n", $buttonArray) . "\n";
        echo '<form method="post" action="' . $form_action_url . '" id="stripe_confirmation">';
        echo '<input type="hidden" name="action" value="q_stripe">';
        echo '<input type="hidden" name="order_id" value="' . $order_id . '">';
        echo '<input type="hidden" name="merchant_name" value="' . $merchant_name . '">';
        echo '<input type="hidden" name="fetch_url" value="' . $fetch_url . '">';
        //echo '<input type="hidden" name="callback_url" value="'.$callback_url.'">';
        echo '<input type="hidden" name="return_url" value="' . $return_url . '">';
        echo '<input type="hidden" name="cancel_url" value="' . $cancel_url . '">';
        echo '<input type="hidden" name="notify_url" value="' . $notify_url . '">';
        echo '</form>';
        echo '<script type="text/javascript">document.getElementById("stripe_confirmation").submit();</script>';
    }

    function curl_submit($url, $data)
    {

        global $messageStack;

        $hosts = $_SERVER['SERVER_NAME'];
        if (strrpos($hosts, "www") === false) {
            $wwwhosts = "www." . $hosts;
        } else {
            $wwwhosts = $hosts;
        }

        $url2 = "http://api.palzpay.com/test1/app/order/create?appkey=k4qLdprhJUaT1XWytTrTb60s0UYWEgoZ&nounce=123&signature=123&timestamp=123";
        $headers = array('Content-Type:application/json', 'accept:*/*', "Origin:$wwwhosts");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode != "200") {
            # $messageStack->add_session('checkout_payment', ' Http Code:' . $httpCode, 'error');
            echo("Payment Failed!Please retry");
            exit;
        }
        return $response;
    }


    function response_hash($data)
    {
        $hash_src = '';
        $hash_key = array('failure_code', 'invoice_id', 'order_no');
        foreach ($hash_key as $key) {
            $hash_src .= $data[$key];
        }
        // 密钥放最前面
        //
        $hash_src = $hash_src . $this->get_option('secret_key');
        // sha256 算法
        $hash = hash('sha256', $hash_src);
        return strtoupper($hash);
    }

    function response($data)
    {
        if ($data['token'] != $this->response_hash($data)) {
            return 'failed';
        }
        if ($data['failure_code'] == 'processing') { // 成功
            return 'processing';
        } elseif ($data['failure_code'] == 'cancelled') {
            return 'cancelled';
        } elseif ($data['failure_code'] == 'refunded') {
            return 'refunded';
        } elseif ($data['failure_code'] == 'failed') {
            return 'failed';
        } elseif ($data['failure_code'] == 'onhold') {
            return 'onhold';
        }
    }
}
