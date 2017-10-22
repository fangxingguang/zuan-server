<?php
//JWT授权验证
namespace app\common\service;

use Firebase\JWT\JWT;
use think\Request;

class Auth
{
    public $jwtKey = 'jwtKey'; //密钥 保证token不被修改伪造

    //验证请求
    function check($token){
        //验证token
        $uid = $this->getUid($token);
        if(empty($uid)){
            return 'token错误';
        }
        Request::instance()->route(['uid'=>$uid]);
        return true;
    }

    //生成token
    function getToken($uid){
        $token = array(
            "iat" => time(),
            "nbf" => time(),
            "exp" => time()+3600*2,
            "uid" => $uid
        );
        $jwt = JWT::encode($token, $this->jwtKey);
        return $jwt;
    }

    //验证token
    function getUid($token){
        try{
            $decoded = JWT::decode($token, $this->jwtKey, array('HS256'));
            $decoded_array = (array) $decoded;
            return $decoded_array['uid'];
        }catch(\Exception $e){
            return false;
        }
    }

}