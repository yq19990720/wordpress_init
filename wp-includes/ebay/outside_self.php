<?php
class outsideself{

public static function index(){
    global $wpdb;
    //获取X-Sign-Key
        $header = apache_request_headers();
        if(!isset($header['X-Sign-Key']) || empty($header['X-Sign-Key'])){
            header('HTTP/1.1 400 Bad Request');exit();
        }else{
            $x_sign_key = $header['X-Sign-Key'];
        }
    //创建数据表
    outsideself::creat_self_config();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //post请求
        $post_arr = trim(file_get_contents('php://input'));
        $res = json_decode($post_arr, true);
        if ($res == null) {
            header('HTTP/1.1 400 Bad Request');exit();
        }
        if (isset($res['sign']) && !empty($res['sign'])) {
            $post_sign = $res['sign'];
            unset($res['sign']);
        }
        //校验签名
        if (check_sign($res, $post_sign,$x_sign_key) == false) {
            header('HTTP/1.1 400 Bad Request');exit();
        }
        //存储数据
        $self_config = $wpdb->get_results("select * from ".SELF_CONFIG_TABEL." limit 1");
        //提取self_config转换为数组
        $self_arr = json_decode($self_config[0]->self_config,true);
        //遍历参数得到key和value
        if($res && $self_arr){//防止出现空指针异常
            foreach ($res as $key => $value){
                //空则删除对应数组中的数据,否则key=>value
                if(!$res[$key]){
                    unset($self_arr[$key]);
                }
                $self_arr[$key] = $res[$key];
            }
            //更新数据转义
            $self_json = addslashes(json_encode($self_arr));
        }
        //插入数据转义
        if($post_arr){
            $post_arr = addslashes($post_arr);
        }
        $date = date('Y-m-d H:i:s');
        if (count($self_arr) <= 0) {
            $save_data = $wpdb->query("INSERT INTO ".SELF_CONFIG_TABEL." (self_config, create_time)VALUES ('{$post_arr}', '{$date}')");
        } else {
            $save_data = $wpdb->query(" UPDATE ".SELF_CONFIG_TABEL." SET self_config='{$self_json}',update_time='{$date}'  WHERE id = {$self_config[0]->id}");
        }
        if ($save_data) {
            session::clear("self_config");//清除在session中的数据

            header('Content-Type: application/json');//设置响应头
            outsideself::json(200,"success",$date);
        } else {
            header('HTTP/1.1 400 Bad Request');exit();
        }

    } else {
        $post_sign = $_GET['sign'];

        if (check_sign([], $post_sign,$x_sign_key) == false) {
            header('HTTP/1.1 400 Bad Request');exit();
        }

        //非post请求
        $self_config = $wpdb->get_results("select self_config from ".SELF_CONFIG_TABEL." limit 1");
        header('Content-Type: application/json');
        outsideself::json("200","success",json_decode($self_config[0]->self_config, true));
    }
}

//mailgun信息存入数据库
 public static function creat_self_config(){
     global $wpdb;
     $sql = "CREATE TABLE  IF NOT EXISTS ".SELF_CONFIG_TABEL." (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `self_config` text,
              `create_time` datetime NULL DEFAULT NULL, 
              `update_time` datetime NULL DEFAULT NULL,
              PRIMARY KEY (`id`)
            )ENGINE=MyISAM DEFAULT CHARSET=utf8mb4; ";
     $wpdb->query($sql);
    }
//封装返回json
public static function json($code, $message = '', $data = []){
        $result = [
            "code" => $code,
            "message" => $message,
            "data" => $data
        ];
        echo json_encode($result);
        exit;
    }
}
