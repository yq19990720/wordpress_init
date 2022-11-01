<?php

/**
 * 格式化参数格式化成url参数
 * @param $values  参与签名的键值对
 * @return string
 */
function to_url_params($values)
{
    $buff = "";
    foreach ($values as $k => $v) {
        if ($k != "sign" && $v != "" && !is_array($v)) {
            $buff .= $k . "=" . $v . "&";
        }
    }
    return $buff;
}

/**
 * 生成签名
 * @param $values 参与签名的键值对
 * @param $x_sign_key x-sign-key
 * @return string
 */
function make_sign($values, $x_sign_key)
{

    //签名步骤一：按字典序排序参数
    ksort($values);
    $string = to_url_params($values);
//签名步骤二：在string后加入KEY
    $string = $string . "key=" . get_host($_SERVER['SERVER_NAME']) . $x_sign_key;
//签名步骤三：MD5加密或者HMAC-SHA256
    $string = md5($string);
//签名步骤四：所有字符转为大写
    $result = strtoupper($string);
    return $result;
}


/**
 * 校验签名
 * @param $values 参与签名的键值对
 * @param $old_sign 传入的签名
 * @param $x_sign_key x-sign-key
 * @return bool
 */
function check_sign($values, $old_sign, $x_sign_key)
{
    $sign = make_sign($values, $x_sign_key);
    if ($old_sign == $sign) {
    //签名正确
        return true;
    } else {
        return false;
    }
}
