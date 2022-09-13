<?php

/**
 * paypal相关配置
 */

define("PAYPALKEY", "k4qLdprhJUaT1XWytTrTb60s0UYWEgoZ");
define("PAYPALURL", "http://onezpay.com/pstandcard");
//define("PAYPALURL","http://api.palzpay.com/test1");

/**
 * stripe相关配置
 */
define("STRIPEKEY", "bEJXAZwabiGRR8yXVRDxTw6di489ACBH");
define("STRIPEURL", "http://onezpay.com/stripe");
//define("STRIPEURL","http://api.palzpay.com/test_stripe");

/**
 * 全局运用配置
 */
define("PRODUCT_URL", $_SERVER['REQUEST_URI']);
define("IMAGEURL", "wp-content/uploads/images");
define("MAX_LEN", 40);
/**
 * 邮箱配置
 */
//SMTP配置
define("SMTPHOST", "smtp.mailgun.org");
//SMTP Host

define("ENCRYPTION", "ssl");
//Encryption

define("SMTPPROT", "465");
//SMTP Port

define("SMTPUSERNAME", "poster@ipmoore.com");
//SMTP Username

define("SMTPPASSWORD", "af7e21bf5e334ebfde2981f844fc488c-2ac825a1-7382b24d");
//SMTP Password

define("SMTPNAME", get_host($_SERVER['SERVER_NAME']));
define('SELF_CONFIG_TABEL', 'wp_self_config');
/**
 * 测试邮箱配置
 */
/*define("SMTPHOST","smtp.exmail.qq.com");//SMTP Host

define("ENCRYPTION","ssl");//Encryption

define("SMTPPROT","465");//SMTP Port

define("SMTPUSERNAME","support@edatastore.io");//SMTP Username

define("SMTPPASSWORD","qqK11@@");//SMTP Password

define("SMTPNAME",get_host($_SERVER['SERVER_NAME']));*/

/**
 * template name
 */
define("TEMPLATE_NAME", 'diza_T2');
/**
 * session default time
 */
define("SESSION_TIME", 24 * 60 * 60);
/**
 * pay error
 */
define('PAY_ERROR', 'Sorry. your order does not meet our requirements. please re-purchase.');
define('PAY_TIME_OUT', 'The order has expired, please re-purchase!');
/**
 * order time
 */
define("ORDER_TIME", '+8 hour');
/**
 * rate time
 */
define("RATE_MYSQL_TIME", '+15 minutes');
/**
 * banner time
 */
define("BANNER_MYSQL_TIME", '+1 day');
