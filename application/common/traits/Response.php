<?php
namespace app\common\traits;

trait Response
{
    use \traits\controller\Jump;

    //成功返回
    protected function suc($data='',$code=200){
        $this->result($data,$code);
    }

    //失败返回
    protected function err($msg,$code=400){
        $this->result('',$code,$msg);
    }

}