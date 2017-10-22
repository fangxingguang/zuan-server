<?php
/**
 * Created by PhpStorm.
 * User: fangxingguang
 * Date: 2017/7/12
 * Time: 11:56
 */
namespace app\common\behavior;
//开启跨域
class Cors
{
    public function run(&$params)
    {
        // 行为逻辑
        if(isset($_SERVER['HTTP_ORIGIN'])){
            header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Allow-Methods: *');
            header("Access-Control-Allow-Headers: Authorization ,Origin, X-Requested-With, Content-Type, Accept");
            header('Access-Control-Max-Age: 3600');//缓存OPTIONS请求
            if(strtoupper($_SERVER['REQUEST_METHOD'])== 'OPTIONS'){
                exit;
            }
        }
    }
}