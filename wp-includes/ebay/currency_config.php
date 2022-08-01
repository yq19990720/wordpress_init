<?php
define('CURRENCY_CODE', array(
"AUD" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "0.5"),"code"=>"$"),
"CAD" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "0.5"),"code"=>"$"),
"CHF" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "0.50 CHF"),"code"=>"CHF"),
"CZK" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "15.00Kč"),"code"=>"Kč"),
"DKK" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "2.50-kr."),"code"=>"-kr."),
"EUR" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "0.5"),"code"=>"€"),
"GBP" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "£0.30"),"code"=>"£"),
"HKD" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "4.0"),"code"=>"HK$"),
"HUF" => array("paypalloli" => array("is_decimal" => false, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "175.00 Ft"),"code"=>"Ft"),
"JPY" => array("paypalloli" => array("is_decimal" => false, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "50.0"),"code"=>"¥"),
"NOK" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "3.00-kr."),"code"=>"-kr."),
"NZD" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "0.5"),"code"=>"$"),
"PLN" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "2.00 zł"),"code"=>"zł"),
"RUB" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"₽"),
"SEK" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "3.00-kr."),"code"=>"-kr."),
"SGD" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "0.5"),"code"=>"$"),
"USD" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "0.5"),"code"=>"$"),
"AED" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => "2.00 د.إ"),"code"=>"د.إ"),
"SAR" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"ريال"),
"MXN" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "10.0"),"code"=>"$"),
"COP" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"$"),
"ARS" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"$"),
"PEN" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"S/"),
"CLP" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => false,"min_payment" => false),"code"=>"$"),
"ILS" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"₪"),
"PHP" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"₱"),
"THB" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"฿"),
"TWD" => array("paypalloli" => array("is_decimal" => false, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"NT$"),
"MYR" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "RM 2"),"code"=>"RM"),
"BRL" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "R$0.50"),"code"=>"R$"),
"KRW" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => false,"min_payment" => false),"code"=>"₩"),
"EGP" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"£"),
"IDR" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"Rp"),
"INR" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => true),"stripe" => array("is_zero_decimal" => true,"min_payment" => "₹0.50"),"code"=>"₹"),
"MAD" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"د.م."),
"PKR" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"₨"),
"RON" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => "lei2.00"),"code"=>"lei"),
"TRY" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"₺"),
"UAH" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"₴"),
"UYU" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"\$U"),
"VND" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => false,"min_payment" => false),"code"=>"₫"),
"ZAR" => array("paypalloli" => array("is_decimal" => true, "is_cur_not_sup" => false),"stripe" => array("is_zero_decimal" => true,"min_payment" => false),"code"=>"R"),
));