<?php
namespace app\api\controller;

use think\captcha\Captcha;
use think\Controller;
use app\common\service\Auth;

class Taobao extends Base
{

    public function add(){
        $params = $this->valid([
            'type' => 'require',
            'name' => 'require',
            'pwd' => 'max:64'
        ]);
        $uid = input('uid');
        $model = model('Taobao');
        $where['name'] = $params['name'];
        $taobao = $model->where($where)->find();
        if($taobao){
            $this->err('不可重复添加！');
        }
        $data['uid'] = $uid;
        $data['type'] = $params['type'];
        $data['name'] = $params['name'];
        if(isset($params['pwd'])){
            $data['pwd'] = $params['pwd'];
        }
        $taobao = $model::create($data);
        $this->suc($taobao);
    }

    public function del(){
        $params = $this->valid([
            'id' => 'require|number'
        ]);
        $params['uid'] = input('uid');
        $model = model('Taobao');
        $res = $model::destroy($params);
        if($res){
            $this->suc();
        }
        $this->err('操作失败！');
    }

    public function select(){
        $uid = input('uid');
        $model = model('Taobao');
        $result['seller'] = $model->field('id,name')->where(['uid'=>$uid,'type'=>'seller'])->select();
        $result['buyer'] = $model->field('id,name')->where(['uid'=>$uid,'type'=>'buyer'])->select();
        $this->suc($result);
    }

}
