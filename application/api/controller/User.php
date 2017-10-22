<?php
namespace app\api\controller;

use think\captcha\Captcha;
use think\Controller;
use app\common\service\Auth;

class User extends Base
{

    public function login(){
        $params = $this->valid([
            'name' => 'require',
            'pwd' => 'require',
            'code' => 'alphaNum',
        ]);
        $User = model('User');
        $where['name'] = $params['name'];
        $where['pwd'] = md5($params['pwd']);
        $user = $User::field('id,name,amount,point')->where($where)->find();
        if($user){
            $auth = new Auth();
            $token = $auth->getToken($user['id']);
            $user['token'] = $token;
            $this->suc($user);
        }
        $this->err('用户名或密码错误');
    }

    public function imageCode(){
        $config =    [
            'fontSize'=>'16',
            'useNoise'=>false,
            'length'=>4,
            'fontttf'=>'5.ttf'
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    public function register(){
        $params = $this->valid([
            'name' => 'require',
            'pwd' => 'require',
            'code'=>'require'
        ]);
        if(!captcha_check($params['code'])){
            $this->err('验证码错误！');
        };
        $User = model('User');
        $user = $User::where('name',$params['name'])->find();
        if($user){
            $this->err('该用户名已被注册！');
        }
        $data['name'] = $params['name'];
        $data['pwd'] = md5($params['pwd']);
        $user = $User::create($data);
        $this->suc($user);
    }

    public function getUserInfo(){
        $uid = input('uid');
        $userModel = model('User');
        $user = $userModel::get(['id'=>$uid]);
        $this->suc($user);
    }

}
