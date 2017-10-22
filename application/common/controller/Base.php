<?php
namespace app\common\controller;

use app\common\traits\Response;
use think\Controller;

class Base
{
    use Response;

    //参数验证
    protected function valid($rules){
        $data = [];
        $rules = rulesToArr($rules);
        foreach ($rules as $key => $rule) {
            $default = null;
            if(isset($rule['default'])){
                $default = $rule['default'];
                unset($rules[$key]['default']);
            }
            $value = input($key,$default);
            if($value!==null){
                $data[$key] = $value;
            }
        }
        $validate = new \app\common\service\Validate($rules);
        $result = $validate->check($data);
        if(!$result){
            $this->err($validate->getError());
        }
        return $data;
    }


}