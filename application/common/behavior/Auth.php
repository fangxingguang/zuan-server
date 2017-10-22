<?php
/**
 * Created by PhpStorm.
 * User: fangxingguang
 * Date: 2017/7/12
 * Time: 11:56
 */
namespace app\common\behavior;

use app\common\traits\Response;
use think\Request;

class Auth
{
    use Response;
    public function run(&$params)
    {
        $token = Request::instance()->header('Authorization');
        if(!$token){
            $token = input('token');
        }
        $auth = new \app\common\service\Auth();
        $result = $auth->check($token);
        if($result!==true){
            $this->err($result);
        }
        return true;
    }
}