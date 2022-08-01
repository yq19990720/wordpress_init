<?php
use Spatie\SchemaOrg\LocalBusiness;
use Spatie\SchemaOrg\Schema;
class ebay_api
{
            public function setConfig()
    {
        global $Config;
        $Config['cache'] = 'cache';
        $Config['WebUrl'] = $_SERVER['HTTP_HOST'];
        $Config['api_header'] = array(
            'x-app-id: ' . App_id,
            'x-api-key: ' . Api_key,
            'Content-Type: application/json',
            'X-Forwarded-For:'.getIP()
        );
        $Config['url'] = '';
        $Config['api_url'] = Api_url;
        if (strpos($Config['WebUrl'], "www.") === false) {
            $Config['WebUrl'] = "www." . $Config['WebUrl'];
        }
    }

    //封装公共请求部分
    public function get($url, $arr, $type = '')
    {
        global $Config;
        $ApiUrl  = $Config['api_url'] . $url;
        $jsonStr = json_encode($arr);
        $header  = $Config['api_header'];
        if($type){
            $ApiUrl = $url;
            $jsonStr = json_encode($arr);
            $header = array(
                'Content-Type: application/json'
            );
        }
        $data    = _GetBody($ApiUrl, $jsonStr, $header);
        return json_decode($data);
    }

    //获取分类列表
    public function ProductCategoryList($update=null)
    {
        global $Category_list;
        //缓存列表
        $data = get_mysql_options('banner',BANNER_MYSQL_TIME);//过期时间一天
        $Category_list = $data->data;
        if($data && !$update && !$data->request){
            if(empty($data->data)){
                return array();
            }
            return res_banner($data->data);
        }
        $res = $this->get(
            "/get_banner",
            array(
                'src'   => Api_Src,
                'extra' => Api_Extra,
            )
        );
        if (empty($res->data)) {
            return array();
        }
        $res->status == 200 ? set_mysql_options($res,'banner') : set_mysql_options('','banner');
        if($update){
            return date('Y-m-d H:i:s');
        }
        return res_banner($res->data);
    }

    //获取产品列表
    public function ProductList($data, $page_num, $page_size,$search=null)
    {
        global $ebay_list;
        if(!$search){
            $data = str_replace("sku", "", Page_code($data));
            verify_product_id($data,"banner");
        }
        $page_num  = (int)$page_num;
        $page_size = (int)$page_size;
        if($search){
            $res = $this->get(
                "/get_list",
                array(
                    'src'   => Api_Src,
                    'extra' => Api_Extra,
                    "search_word"   =>$data,
                    "page_size"     => $page_size,
                    "page_num"      => $page_num
                )
            );
        }else{
            $res = $this->get(
                "/get_list",
                array(
                    'src'           => Api_Src,
                    'extra'         => Api_Extra,
                    "category_id"   => $data,
                    "page_size"     => $page_size,
                    "page_num"      => $page_num
                )
            );

        }
        if(empty($res->data->items)){
            return array();
        }
        if ($res->status == 200) {
            foreach ($res->data->items as $value) {
                $price = get_rate_price($value->currency_id,determine_locale_currency(),floor($value->current_price * 0.5 * 100)/100);
                $ID = Page_code("sku" . $value->item_id, "en");
                $title = UrlCode(ucwords(strtolower($value->title)));
                $posts[] = (object)array(
                    "ID"                => $value->item_id,
                    "post_content"      => "",
                    'element_title'     => $value->title,
                    "featured"          => product_hot($value->title)? array("featured", "rated-5"):array(),
                    "post_title"        => htmlSpecial($value->title),
                    "rating_counts"     => product_rating($value->title),
                    "average_rating"    => product_rating($value->title),
                    "usd_price"         => get_rate_price($value->currency_id,determine_locale_currency(),floor($value->current_price * 0.5 * 100)/100,'USD'),
                    "post_status"       => "publish",
                    "price"             => $price,
                    "regular_price"     => "",
                    "sale_price"        => $price,
                    "description_price"  => floor($value->current_price * 0.5 * 100)/100,
                    "comment_status"    => "open",
                    "ping_status"       => "closed",
                    "currency_id"       => $value->currency_id,
                    "post_name"         => $title . "_" . $ID.".html",
                    "post_url"          => $title . "_" . $ID.".html",
                    "image_id"          =>  $value->album,
                    "post_type"         => "product",
                    "filter"            => "raw",
                    "pageNum"           => $res->data->page_num,
                    "reqPageSize"       => count($res->data->items),
                );
            }
        }
        $ebay_list = $posts;
        return $posts;
    }

    //获取产品详情
    public function ProductDetails($item_id, $recommend,$type=null)
    {
        global $jsonld;
        if(!$type){
            $item_id = str_replace("sku", "", Page_code($item_id));
            verify_product_id($item_id,"product");
        }
        $res = $this->get(
            "/get_detail",
            array(
                'src'   => Api_Src,
                'extra' => Api_Extra,
                "item_id"   => $item_id,
                "recommend" => $recommend,
            )
        );
        $data = $res->data;
        if(empty($data)){
            return array();
        }

        if ($res->status == 200) {
            $price = get_rate_price($data->currency_id,determine_locale_currency(),floor($data->current_price * 0.5 * 100)/100);
            $ProductDetails[] = (object)array(
                'ID'                  => $data->item_id,
                "featured"            => array(
                    "featured",
                    "rated-5"
                ),
                'post_title'         =>htmlSpecial($data->title),
                'element_title'      =>$data->title,
                'post_url'           =>Urlcode(ucwords(strtolower($data->title))). "_" . Page_code("sku" . $data->item_id, "en").".html",
                'post_type'          =>"product",
                "usd_price"         => get_rate_price($data->currency_id,determine_locale_currency(),floor($data->current_price * 0.5 * 100)/100,'USD'),
                "rating_counts"      =>product_rating($data->title),
                "average_rating"     =>product_rating($data->title),
                "description_price"  => floor($data->current_price * 0.5 * 100)/100,
                'post_name'          =>$data->category_name,
                'post_specifics'     =>$data->specifics,
                'post_content'       =>$data->description,
                'post_hit_count'     =>$data->hit_count,
                'image_id'           =>$data->pictures[0],
                "purchasable"        =>true,
                'category_name'        =>end($data->category_name_path_vec),
                "price"              =>$price,
                "total_sales"        =>$data->current_price * 0.5 - 10,
                "tax_status"         =>"taxable",
                "stock_quantity"     =>$data->quantity >= 10 ?$data->quantity : 100,
                "stock_status"       =>"instock",
                "backorders"         =>"no",
                "low_stock_amount"   =>"",
                "manage_stock"       =>true,
                "sold_individually"  =>false,
                "regular_price"      =>"",
                "sale_price"         =>$price,
                'pictures'           =>$data->pictures,
                "currency_id"        =>$data->currency_id,
                'bread_crumbs'       =>$data->category_name_path_vec,
                'bread_crumbs_id'    =>$data->category_id_path_vec,
                "recommends"         => recommend($res->recommends)
            );
        }
        $jsonld = jsonld($data);
        return $ProductDetails;
    }

    //获取二级分类
    public function ProductSubList($category_id){
        $category_id = str_replace("sku", "", Page_code($category_id));
        verify_product_id($category_id,"banner");
        $res  =$this->get(
            "/get_sub",
            array(
                'src'           =>Api_Src,
                'extra'         =>Api_Extra,
                "category_id"   =>$category_id,
            )
        );
        if($res->data){
            foreach ($res->data as $value){
                $Sub[] = (object)array(
                    "term_id"               =>$value->category_id,
                    "name"                  =>$value->category_name,
                    "slug"                  =>Urlcode(ucwords(strtolower($value->category_name))). "_" . Page_code("sku" . $value->category_id, "en"),
                    "term_group"            =>0,
                    "term_taxonomy_id"      =>89,
                    "taxonomy"              =>"product_cat",
                    "description"           =>"",
                    "parent"                =>0,
                    "count"                 =>9,
                    "filter"                =>"raw"
                );
            }
        }
        return $Sub;
    }

    //get exchange rate
    public function get_rate(){
        $rates = get_mysql_options('rate',RATE_MYSQL_TIME);
        if(!$rates || $rates->request){//汇率不存在，或者返回信息中携带请求对象则再次请求汇率接口
            //获取接口汇率缓存
            $res = $this->get("/get_rate", array());
            $res->status == 200 ? set_mysql_options($res,'rate') : set_mysql_options('','rate');
        }
        return $res ? $res : $rates;
    }

    //通过接口获取国家地区信息
    public function get_language_currency(){
        $res = $this->get($_SERVER['HTTP_HOST']."/api/country",array(),'get');
        $result = array();
        if($res->status == 200){
            $result['country_code'] = $res->data->registered_country->iso_code;
            $result['area'] = $res->data->country->iso_code;
        }
        return $result;
    }

    //router
    public static function router(){
        $post_sign = $_GET['sign'];

        switch ($_SERVER["REQUEST_URI"]){
            case "/healthcheck":
                header('HTTP/1.1 204');exit();
                break;
            case "/_self_config":
                outsideself::index();
                break;
            case "/_self_config?sign=".$post_sign:
                outsideself::index();
            default:
        }
    }
}

/**
 * @param string $currency_code ISO3 货币代码(例如:USD)
 * @param string $payment_way 支付方式
 * @param string $price 价格
 * @return float
 */
function get_currency_price($currency_code='',$payment_way='',$price=''){
    //货币代码
    $code = CURRENCY_CODE[$currency_code]['code'];//define定义的常量用key=>value的取法只适用版本7+，7一下的不支持需赋值给变量后取出
    //校验货币代码是否存在
    if(!CURRENCY_CODE[$currency_code]){
        throw new Exception( sprintf( __("No corresponding ".$currency_code." payment currency!") ) ) ;
    }
    //付款方式
    $payment = CURRENCY_CODE[$currency_code][$payment_way];
    switch ($payment_way){
        case "stripe":
            $price = get_stripe_payment($payment,$code,$price,$currency_code);
            break;
        case "paypalloli":
            $price = get_paypal_payment($payment,$currency_code,$price);
            break;
        default:
            return "No ".$payment_way." payment method";
    }
    return (float)$price;
}

function get_paypal_payment($payment,$currency_code,$price){
    /**
     * PayPal包含两个条件
     * 1、是否支持小数点支付
     * 2、是否支持该货币付款
     */
    $is_decimal = $payment['is_decimal'];//是否支持小数点支付
    $is_cur_not_sup = $payment['is_cur_not_sup'];//是否支持该货币付款
    //不支持则返回false
    if(!$is_cur_not_sup){
        throw new Exception( sprintf( __("This payment method does not support ".$currency_code." payment in this currency") ) ) ;
    }
    //不支持小数->四舍五入
    if(!$is_decimal){
        //该处只适用于加上邮费后的总价
        $price = round($price);
    }
    return $price;
}

function get_stripe_payment($payment,$code,$price,$currency_code){
    /**
     * Stripe包含两个条件
     * 1、是否是零位十进制
     * 2、付款最低限制，无则是false
     */
    $is_zero_decimal = $payment['is_zero_decimal']; //是否是零位十进制
    if(!$is_zero_decimal || $currency_code == 'JPY' || $currency_code == 'HUF'){
        $price = round($price);
    }
    return $price;
}

/**
 * 获取汇率
 * @param String $currency_code 货币代码
 * @param int $price 产品价格
 * @param String $product_currency_code 产品货币代码
 * @param String $type 调用类型
 * @return float
 */
function get_rate_price($product_currency_code, $currency_code, $price,$type=''){
    global $rates;//获取数据库缓存
    if($rates->status == 200){
        switch ($type){
            case 'USD':
                $price = $price / $rates->data->rates->$product_currency_code;
                break;
            case 'RATE':
                $price =  $rates->data->rates->$product_currency_code;
                break;
            default:
                $price = $price * $rates->data->rates->$product_currency_code * $rates->data->rates->$currency_code;
        }
    }
    return $price;
}

/**
 * 获取self配置
 * @return array
 */
function get_self_config(){
    global $wpdb;
    $self_config = $wpdb->get_results("select self_config from ".SELF_CONFIG_TABEL." limit 1");
    //提取self_config转换为数组
    return json_decode($self_config[0]->self_config,true);
}

/**
 * 根据语言获取不同的价格展示
 * @param string $language
 * @param string $currency_code
 * @param string $currency_symbol
 * @param string $price
 * @return bool|string
 */
function standard_price($language='',$currency_code='',$currency_symbol='',$price=''){
    if(empty($price)){
        return false;
    }
    $price = str_replace($currency_symbol,"",$price);
    $price = str_replace(",","",$price);
    $price = str_replace("&nbsp;","",$price);
    switch ($language){
        case 'en_US':
            $standard_price = "$currency_symbol".number_format($price,2,'.',',');
            break;
        case 'fr_FR':
            $standard_price = number_format($price,2,',',' ')."$currency_symbol";
            break;
        case 'de_DE':
        case 'it_IT':
        case 'es_ES':
            $standard_price = number_format($price,2,',','.')."$currency_symbol";
            break;
        case 'nl_NL_formal':
            $standard_price = "$currency_symbol" . number_format($price,2,',','.');
            break;
        default:
            return false;

    }
    return $standard_price;
}


/**
 * 订单时间校验类
 * @param $order
 * @return boolean
 */
function order_time_verify($order){
    $format = 'Y-m-d H:i:s';
    $date = $order->get_date_created()->date($format);
    $tomorrow = strtotime(date($format, strtotime("$date ".ORDER_TIME)));
    $now_date = strtotime(date($format));
    if($now_date>=$tomorrow && $order->get_status()=="pending"){
       return true;
    }
    return false;
}
/**
 * 处理产品数量负数以及0的问题
 * @param $data
 * @return bool
 * @return boolean
 */
function negative_product_handle($data){
    //Check if it is a negative number, if it is a negative number, replace it with a positive number
    if(!is_string($data)){
        if($data < 0){
            $data = $data * -1;
        }else if (is_float($data)){
            return false;
        }
        return $data == 0 ?  1 : $data;
    }else{
        return false;
    }
}

/**
 * 搜索校验长度大于40则返回422,否则返回true
 * @param $verify_param
 * @return boolean
 * @return 422
 */
function verify_search_param($verify_param){
    //将参数转换为string类型并计算长度
    $search_len = strlen((String)$verify_param);
    if($search_len == 0 ||$search_len > MAX_LEN){
        header('HTTP/1.1 422 Unprocessable Entity');exit();
    }
    return true;
}

/**
 * 二次封装session
 */
function sql_session($key,$value=null){
    session_start();
    $key = $key.TEMPLATE_NAME;
    $data = Session::get($key);
    if($value){
        Session::set($key, $value);
        $data = Session::get($key);
    }
    return $data;
}

/**
 * 校验产品请求ID包括分类ID和产品ID
 * @param $verify_id $type
 * @param $type
 * @return boolean
 */
function verify_product_id($verify_id,$type=null) {
    //参数不为空并且是整数
    if(!empty($verify_id) && ctype_digit((string)$verify_id)){
        //判断校验类型
        $id_len = strlen((string)$verify_id);
        switch ($type){
            case "banner" :
                //是否超出范围 大于等于1 小于等于8
                if($id_len >= 1 &&  8 >= $id_len){
                    return true;
                }
                break;
            case "product":
                //是否超出范围 大于等于9 小于等于15
                if($id_len >= 9 &&  15 >= $id_len){
                    return true;
                }
                break;
            default:
                header('HTTP/1.1 400 Bad Request');exit();
        }
    }else{
        //校验不通过直接返回状态代码400
        header('HTTP/1.1 400 Bad Request');exit();
    }
}

/** 查询购物车id加上校验判断
 * @param $verify_id $type
 * @return boolean
 */
function verify_product_id_data_store_cart($verify_id) {
    //参数不为空并且是整数
    if(!empty($verify_id) && ctype_digit((string)$verify_id)){
        //判断校验类型
        $id_len = strlen((string)$verify_id);
        //是否超出范围 大于等于9 小于等于15
        if($id_len >= 9 &&  15 >= $id_len){
            return true;
        }
    }else{
        return false;
    }
}

/**
 * 返回商品的评级
 * 商品名长度对3取余,结果作为星级的扣分部分
 * @param $product_name
 * @return int
 */
function product_rating($product_name): int
{
    return 5 - strlen(trim($product_name)) % 3;
}

/**
 * 返回是否是热卖产品
 * 商品名长度对2取余,结果作为热卖显示
 */
function product_hot($product_name) : int{
    return strlen(trim($product_name)) % 2;
}

/**
 * 返回产品折扣
 */
/**
 * 根据优惠规则返回优惠后的价格
 * @param $price
 * @return float|int
 */
 function getPriceByRule($price){

    if ($price >= 500){
        $price *= (8 / 10);
    }else if ($price >= 400){

        $price *= (9 / 10);
    }else if ($price >= 300){

        $price -= 30;
    }else if($price >= 200){

        $price -= 20;
    }else if ($price >= 100){

        $price -= 10;
    }
    return $price;
}
//处理轮播图排列组合
function getCombination($num, $n){
    if($num){
        $combinations = 1;
        for ($i=0;$i<$n;$i++){
            $combinations *= $num - $i;
        }
        for ($i=0;$i<$n;$i++){
            $combinations /= $n - $i;
        }
        $host = substr(md5(get_host($_SERVER['SERVER_NAME'])),-11,-1);
        $value = hexdec($host);
        $key1 = $value % $combinations;
        $half = intval($combinations / 2);
        if($key1>$half) {
            $key2 = $key1 - $half;
        }else{
            $key2 = $key1 + $half ;
        }
        $value1 = "/".IMAGEURL."/".($key1 % $num + 1).".jpg";
        $value2 = "/".IMAGEURL."/".($key2 % $num + 1).".jpg";
        return array($value1,$value2);
    }
}

//读取文件中的文件数
function getImages(){
    if(is_dir(IMAGEURL)){
        $info = opendir(IMAGEURL);
        $arr = [];
        while (($file = readdir($info)) !== false) {
            if(strstr($file,"jpg")){
                array_push($arr,$file);
            }
        }
        closedir($info);
    }
    if($arr)return count($arr);
}

//处理推荐商品映射
function recommend($key)
{
    if(empty($key)){
        return null;
    }
    foreach ($key as $value) {
        $ID = Page_code("sku" . $value->item_id, "en");
        $Url = UrlCode(ucwords(strtolower($value->title)));
        $data[] = (object)array(
            "post_title" => htmlSpecial($value->title),
            'ID' => $value->item_id,
            "comment_status" => "open",
            "ping_status" => "closed",
            "post_status" => "publish",
            "featured" => product_hot($value->title)? array("featured", "rated-5"):array(),
            "rating_counts" => product_rating($value->title),
            "average_rating" => product_rating($value->title),
            'usd_price' => get_rate_price($value->currency_id,determine_locale_currency(),floor($value->current_price * 0.5 * 100)/100,'USD'),
            "post_type" => "product",
            "post_name" => $Url . "_" . $ID.".html",
            'image' =>  $value->album,
            "price" => floor($value->current_price * 0.5 * 100)/100,
            "regular_price" => "",
            "sale_price" =>  floor($value->current_price * 0.5 * 100)/100,
        );
    }
    return $data;
}

//数据库缓存查询
function get_mysql_options($like,$expire){
    global $wpdb;
    $get_data= $wpdb->get_results("SELECT option_value,autoload FROM ".$wpdb->options." WHERE 1=1 AND option_name LIKE '$like'");
    $data_value = json_decode($get_data[0]->option_value);
    $date = $get_data[0]->autoload;
    $now_date = strtotime(date('Y-m-d H:i:s'));
    $tomorrow = $data_value->response ? strtotime("$date +1 minute") : strtotime("$date ".$expire);
    if($now_date>=$tomorrow && $data_value->response){
        $data_value->request = true;
        return $data_value;
    }
    return $now_date>=$tomorrow ? null : $data_value;
}

//获取keywords要素
function get_keywords(){
    global $ebay_product_detail,$ebay_list;
    $url = explode("/",PRODUCT_URL)[1];
    $title = $ebay_list[1]->element_title;
    if($url == 'shop'){
        $keywords = $title.','.LIST_PAGE_META_1;
    }else if($url == 'detail'){
        $sublist = $ebay_product_detail[0]->bread_crumbs;
        $count = count($sublist);
        if($count > 1){
            $sub = $sublist[count($sublist)-2];
        }
        $Category_name = $ebay_product_detail[0]->category_name.','.LIST_PAGE_META_0;
        $product_title = $ebay_product_detail[0]->element_title.','.LIST_PAGE_META_1;
        $count == 1? $Category_on_name = LIST_PAGE_META_2: $Category_on_name = $sub .','.LIST_PAGE_META_2;
        $keywords = $Category_name .','. $product_title .',' . $Category_on_name ;
    }else if($_GET['s']){
        $keywords = $title.','.LIST_PAGE_META_1;
    }else{
        $keywords = HOME_PAGE_META_KEYWORDS;
    }
    return htmlSpecial(Three_element_code($keywords));
}

//获取description要素
function get_description(){
    global $ebay_product_detail,$ebay_list;
    $url = explode("/",PRODUCT_URL)[1];
    $title = $ebay_list[1]->element_title;
    $title_three = $ebay_list[2]->element_title;
    $price = $ebay_list[1]->description_price;
    $currency_list_symbol = CURRENCY_CODE[$ebay_list[1]->currency_id]['code'];
    if($url == 'shop'){
        $Category_name = explode("/",explode("_",PRODUCT_URL)[0])[2];
        $description =  $currency_list_symbol.$price.','.$title.','.$Category_name.','.$title_three.','.LIST_PAGE_META_2;
    }else if($url == 'detail'){
        $description =  CURRENCY_CODE[$ebay_product_detail[0]->currency_id]['code'].$ebay_product_detail[0]->description_price.','.substr(htmlspecialchars(preg_replace('/<\/?[^>]+>/', '', htmlspecialchars_decode($ebay_product_detail[0]->post_content))), 0, 200);
    }else if($_GET['s']){
        $description = $currency_list_symbol.$price.','.$title.','.$title_three.','.LIST_PAGE_META_2;
    }else{
        $description = HOME_PAGE_META_DESCRIPTION;
    }
    return htmlSpecial($description);
}

/**
 * 获取三要素中title所需信息
 * @return array
 */
function get_bloginfo_data(){
    global $ebay_list;
    $type = explode("/",PRODUCT_URL)[1];
    $Category_name = explode("/",explode("_",PRODUCT_URL)[0])[2];
    $search_title = $_GET['s'];
    if($search_title){
        $Category_name = $search_title;
    }
    $title = $Category_name.','.$ebay_list[1]->element_title .','. LIST_PAGE_META_0;
    $data = array(
      'type' => $type,
      'title'=> $title
    );
    return $data;
}

//三要素匹配规则
function Three_element_code($content){
    return trim(preg_replace("{,+}", ",", preg_replace('/(?:(?!,)[\p{P}\p{S}[:space:]]+)/u', ' ', $content)));
}


/**
 * 获取顶级域名
 */
function get_host($domain){
    $len = strlen("www.");
    if(substr($domain, 0, $len) === "www."){
        return str_replace("www.","",$domain);
    }
    return $domain;
}


function set_mysql_options($data,$like){
    global $wpdb;
    //查询该条数据是否存在，存在更新不存在插入
    $get_data = $wpdb->get_results("SELECT option_value,autoload FROM ".$wpdb->options." WHERE 1=1 AND option_name LIKE '$like'");
    $data_value = json_decode($get_data[0]->option_value);
    $data_value->response = true;//如果接口未正常响应则添加response属性设置为true
    $data_value = json_encode($data_value);
    $options_value = json_encode($data);
    $time = date('Y-m-d H:i:s');
    if($get_data){//update
        //在数据不存在时为了保证站点的正常运行只对存入时间进行更新
        $data ? $wpdb->query("UPDATE ".$wpdb->options." SET option_value='{$options_value}',autoload='{$time}' WHERE option_name = '{$like}'") :
            $wpdb->query("UPDATE ".$wpdb->options." SET option_value='{$data_value}', autoload='{$time}' WHERE option_name = '{$like}'");
    }else{
        $wpdb->insert("wp_options", array("option_name"=>$like, "option_value"=>$options_value, "autoload"=>$time));//insert
    }
}

function res_banner($data){
    $Init = InitialClassification($data);
    $More = MoreInformation($data);
    $language = language();
    $currency = currency();
    foreach ($Init as $value) {
        array_push($More, $value);
    }
    foreach ($language as $value){
        array_push($More, $value);
    }
    foreach ($currency as $value){
        array_push($More, $value);
    }
    return $More;

}

//构造一级分类映射
function InitialClassification($data)
{
    $arr = (object)array_slice($data, 0, 4);
    $menu_order = 1;
    foreach ($arr as $value) {
        $slice[] = (object)array(
            "ID"                => $value->category_id,
            "Items_id"          => Urlcode(ucwords(strtolower($value->category_name))) . "_" . Page_code("sku" . $value->category_id, "en"),
            "home_id"           => Page_code("sku" . $value->category_id, "en"),
            "url_type"          => "ebay",
            'menu_item_parent'  => "",
            "id_type"           => "home",
            "post_title"        => $value->category_name,
            "post_type"         => "nav_menu_item",
            "post_status"       => "publish",
            "comment_status"    => "closed",
            "ping_status"       => "closed",
            "menu_order"        => $menu_order++,
            "filter"            => "raw",
            "object"            => "page",
            "object_id"         => $value->category_id,
            "type"              => "post_type"
        );
    }
    if(count($data)>=5){
        $data = (object)array(
            "ID"         => 666,
            "menu_order" => $menu_order,
            "post_title" => "Categories",
            "post_type"  => "nav_menu_item",
            "classes"    => array(
                "menu-item-has-children",
            ),
        );
        array_push($slice, $data);
    }
    $language = (object)array(
        "ID"            => 777,
        "menu_order"    => 201,
        "post_title"    => get_language_result()[determine_locale()],
        "language_title"=> get_language_result()[determine_locale()],
        "country_image" => get_language_result()['lang_image_url'],
        "post_type"     => "nav_menu_item",
        "classes"       => array(
            "menu-item-has-children",
        ),
    );
    $currency = (object)array(
        "ID"            => 778,
        "menu_order"    => 200,
        "post_title"    => determine_locale_currency(),
        "currency_title"=> determine_locale_currency(),
        "post_type"     => "nav_menu_item",
        "classes"       => array(
            "menu-item-has-children",
        ),
    );
    array_push($slice, $language);
    array_push($slice, $currency);
    return $slice;
}

function Home_product_url(){
    global $ebay_product_category_list;
    $data = [];
    foreach ($ebay_product_category_list as $value){
        if($value->id_type){
            array_push($data,$value);
        }
    }
    return $data;
}

function Other(){
    $arr = ["Login","Checkout","Cart"];
    $url = ["/my-account","/checkout","/cart"];
    $id = ["10","9","8"];
    $menu_order = 1;
    foreach ($arr as $value){
        $accounts[] = (object)array(
            "ID"                    =>$id[array_search($value,$arr)],
            "Items_id"              =>$url[array_search($value,$arr)],
            "post_title"            =>__($value,"woocommerce"),
            "post_type"             =>"nav_menu_item",
            "url_type"              =>"other",
            "post_status"           =>"publish",
            "menu_item_parent"      =>"555",
            "comment_status"        =>"closed",
            "menu_order"            =>$menu_order++,
            "ping_status"           =>"closed",
            "filter"                =>"raw",
            "object"                =>"page",
            "object_id"             =>$id[array_search($value,$arr)],
            "type"                  =>"post_type"
        );
    }
    return $accounts;
}

function get_language_result(){
    $country_name = ["Deutsch","Español","Français","Italiano","Nederlands","English"];
    $language_name = get_available_languages();
    array_push($language_name,"en_US");
    foreach ($country_name as $value){
        $name =  $language_name[array_search($value,$country_name)];
        $arr[$name] = array(
            $name=>$value,
            "lang_image_url"  =>'/wp-content/uploads/language/'.$name.'.png',
        );
    }
    return $arr[determine_locale()];
}

function language(){
    $country_name = ["Deutsch","Español","Français","Italiano","Nederlands","English"];
    $language_name = get_available_languages();
    array_push($language_name,"en_US");
    foreach ($country_name as $value){
        $index = array_search($value,$country_name);
        $name =  $language_name[array_search($value,$country_name)];
        $url = explode("_",$name)[0];
        $language[] = (object)array(
            "ID"                    =>$index,
            "language_url"          =>"/?lang=".$url,
            "language_code"         =>$url,
            "post_title"            =>$value,
            'alt'                   =>$name,
            "post_type"             =>"nav_menu_item",
            "url_type"              =>"language",
            "post_status"           =>"publish",
            "menu_item_parent"      =>777,
            "comment_status"        =>"closed",
            "lang_image_url"        =>'/wp-content/uploads/language/'.$name.'.png',
            "menu_order"            =>$index,
            "ping_status"           =>"closed",
            "filter"                =>"raw",
            "object"                =>"page",
            "object_id"             =>$index,
            "type"                  =>"post_type"
        );
    }
    return $language;
}

function currency(){
    $n = 0;
    foreach (CURRENCY_CODE as $code => $value){
        $symbol = $value['code'];
        $currency[] = (object)array(
            "ID"                    =>$n++,
            "currency_url"          =>"javascript:void(0);",
            "post_title"            =>$code." ".$symbol,
            "post_type"             =>"nav_menu_item",
            "url_type"              =>"currency",
            "currency_code"         =>$code,
            "post_status"           =>"publish",
            "menu_item_parent"      => 778,
            "comment_status"        =>"closed",
            "menu_order"            =>$n++,
            "ping_status"           =>"closed",
            "filter"                =>"raw",
            "object"                =>"page",
            "object_id"             =>$n++,
            "type"                  =>"post_type"
        );
    }
    return $currency;
}

//处理分类下拉选映射
function MoreInformation($data)
{
    $More = (object)array_slice($data, 4);
    $menu_order = 1;
    foreach ($More as $value) {
        $slice[] = (object)array(
            "ID"                    => $value->category_id,
            "Items_id"              => Urlcode(ucwords(strtolower($value->category_name))). "_" . Page_code("sku" . $value->category_id, "en"),
            "home_id"               => Page_code("sku" . $value->category_id, "en"),
            "post_title"            => $value->category_name,
            "post_type"             => "nav_menu_item",
            "url_type"              => "ebay",
            "post_status"           => "publish",
            "menu_item_parent"      => 666,
            "comment_status"        => "closed",
            "menu_order"            => $menu_order++,
            "ping_status"           => "closed",
            "filter"                => "raw",
            "object"                => "page",
            "object_id"             => $value->category_id,
            "type"                  => "post_type"
        );
    }
    return $slice;
}

//处理特殊字段转义
function htmlSpecial($value){
    return htmlspecialchars($value,ENT_QUOTES);
}

function  Page_code($s, $type = null)
{
    global $Config;
    $k = $Config['WebUrl'];
    $k = "$k";
    for ($i = 0; $i < strlen($k); $i++) {
        if ($type == "en") {
            $d = base_convert($k{$i}, 36, 10);
        } else {
            $d = 36 - base_convert($k{$i}, 36, 10);
        }
        $t = '';
        for ($j = 0; $j < strlen($s); $j++)
            $t .= base_convert((base_convert($s{$j}, 36, 10) + $d) % 36, 10, 36);
        $s = $t;
    }
    return $t;
}

function UrlCode($url)
{
    if (strpos($url, ' ') !== false) {
        $url = preg_replace('/[\p{P}\p{S}[:space:]]+/u', ' ', $url);
        $url = str_replace("  ", " ", $url);
        $url = str_replace("  ", " ", $url);
        $url = trim($url);
        $url = str_replace(" ", "-", $url);
        $url = str_replace("_", "-", $url);
    } elseif (strpos($url, '-') !== false) {
        $url = ucwords(str_replace("-", " ", $url));
    }
    return $url;
}

function _GetBody($requestUrl, $data = null, $header = null)
{
    $_POST['ebapi'] = $requestUrl;//暂时用
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_URL, $requestUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_REFERER, referer());
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $retValue = curl_exec($ch);
    curl_close($ch);
    return $retValue;
}

//获取客户端ip地址
function getIP()
{
    static $realip;
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $realip = getenv("HTTP_CLIENT_IP");
        } else {
            $realip = getenv("REMOTE_ADDR");
        }
    }
    return $realip;
}

function referer(){
    $ServerName = $_SERVER['SERVER_NAME'];
    $HttpReferer = $_SERVER["HTTP_REFERER"];
    if(empty($HttpReferer)){
        return $ServerName . "+";
    }
    return $ServerName . "+" .$HttpReferer;
}

function calculateRating($quantity, $sold, $hit_count)
{
    $target = 5.0;
    $min_percent = 0.8;
    $max_percent = 0.95;

    if ($quantity < 2) {
        $quantity = 2;
    }
    if ($sold < 2) {
        $sold = 2;
    }
    if ($hit_count < 2) {
        $hit_count = 2;
    }
    $t = log10($hit_count * $sold / $quantity) / log10($hit_count);
    if ($t <= 1) {
        $v = $t * $target;
    } else {
        $v = 1 / $t * $target;
    }

    $min_value = $target * $min_percent;
    if ($v < $min_value) {
        while ($v < $min_value) {
            $v += ($target - $min_value) / 20;
        }
    }
    $max_value = $target * $max_percent;
    if ($v > $max_value) {
        while ($v > $max_value) {
            $v -= ($target - $max_value) / 20;
        }
    }
    return $v;
}

function jsonld($product_info)
{

    if($product_info){//满足产品信息的情况下
    //结构化数据
    $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';

    $exif_data = [];
    if (isset($product_info->specifics)) {

        foreach ($product_info->specifics as $k => $v) {

            if (empty($product_info->condition) && $k == "Condition") {

                $product_info->Condition = $v;
            }

            if (empty($product_info->weight) && $k == "Weight") {

                $product_info->weight = $v;
            }

            if (empty($product_info->height) && $k == "Height") {

                $product_info->height = $v;
            }


            if (empty($product_info->Width) && $k == "Width") {

                $product_info->weight = $v;
            }


            if (empty($product_info->color) && $k == "Color") {

                $product_info->color = $v;
            }

            if (empty($product_info->mpn) && $k == "MPN") {

                $product_info->mpn = $v;
            }

            if (empty($product_info->brand) && $k == "Brand") {

                $product_info->brand = $v;
            }

            if (empty($product_info->depth) && $k == "Depth") {

                $product_info->depth = $v;
            }


            if (empty($product_info->material) && $k == "Material") {

                $product_info->material = $v;
            }


            array_push($exif_data, [
                "@type" => "PropertyValue",
                "name"  => $k,
                "value" => $v
            ]);
        }
    }
    $image_data = [];
    if (isset($product_info->pictures)) {

        foreach ($product_info->pictures as $k => $v) {

            $image_data[] = $http_type . $_SERVER['SERVER_NAME'] . $v;
        }
    }

    $start_str = strrpos($_SERVER ['REQUEST_URI'], '/');
    $end_str = strrpos($_SERVER ['REQUEST_URI'], '.');
    $sku = substr($_SERVER ['REQUEST_URI'], $start_str + 1, $end_str - $start_str - 1);

    $rating_value = calculateRating($product_info->quantity, $product_info->sold, $product_info->hit_count);

    $price_valid_until = date("Y-m-d", strtotime("next year"));

    $price =  floor($product_info->current_price * 0.5  * 100)/100 < 0.01 ? 0.01 : floor($product_info->current_price * 0.5  * 100)/100;//价格不能少于0.01，默认给出0.01

    $priceCurrency = $product_info->currency_id ? $product_info->currency_id : determine_locale_currency();//无价格货币则采用默认的价格货币

    $product_description = htmlspecialchars($product_info->description,ENT_QUOTES);//产品描述

    $name = strip_tags($product_info->title);//产品标题

    $description = empty(str_replace(" ","",$product_description)) ? $name : $product_description;//为空则填充标题

    $localBusiness = Schema::Product()
        ->name($name)
        ->image($image_data)
        ->sku(urldecode($sku))
        ->mpn($product_info->mpn)
        ->color($product_info->color)
        ->width($product_info->width)
        ->weight($product_info->weight)
        ->height($product_info->height)
        ->category($product_info->category_name)
        ->brand($product_info->brand)
        ->description($description)
        ->itemCondition($product_info->Condition)
        ->countryOfOrigin($product_info->country)
        ->depth($product_info->depth)
        ->material($product_info->material)
        ->review(
            [
                "@type"        => "Review",
                "reviewRating" => [
                    "@type"       => "Rating",
                    "ratingValue" => $rating_value,
                    "bestRating"  => "5"
                ],
                "author"       => [
                    "@type" => "Person",
                    "name"  => "Fred Benson"
                ]
            ]
        )
        ->aggregateRating(
            [
                "@type"       => "AggregateRating",
                "ratingValue" => $rating_value,
                "reviewCount" => $product_info->hit_count <= 0 ? 1 : $product_info->hit_count //当评论数为0或者负数是则为1
            ]
        )
        ->offers([
            "@type"              => "Offer",
            "url"                => $http_type . $_SERVER['SERVER_NAME'] . urldecode($_SERVER ['REQUEST_URI']),
            "price"              => $price,
            "priceValidUntil"    => $price_valid_until,
            "priceSpecification" => [
                "price"                 => $price,
                "priceCurrency"         => $priceCurrency,
                "valueAddedTaxIncluded" => "false"
            ],
            "priceCurrency"      => $priceCurrency,
            "availability"       => "http://schema.org/InStock",
            "seller"             => [
                "@type" => "Organization",
                "name"  => null,
                "url"   => $http_type . $_SERVER['SERVER_NAME']
            ]
        ])->additionalProperty($exif_data);
    }
    return $localBusiness;
}

$EbApi = new ebay_api();
$Config = array();
$EbApi->setConfig();




