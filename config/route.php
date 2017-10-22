<?php
use think\Route;

//需要验证路由
Route::rule([
    'taskAdd'=>'api/Task/add',
    'taskSelect'=>'api/Task/select',
    'taskUpdate'=>'api/Task/update',
    'taskDel'=>'api/Task/del',
    'taskSelectWait'=>'api/Task/selectWait',
    'taskInvite'=>'api/Task/invite',

    'taskSelectSend'=>'api/Task/selectSend',
    'taskDelete'=>'api/Task/del',

    'inviteSelect'=>'api/Task/inviteSelect',
    'inviteUpdate'=>'api/Task/inviteUpdate',

    'taskSelectDo'=>'api/Task/taskSelectDo',

    'taobaoAdd'=>'api/Taobao/add',
    'taobaoSelect'=>'api/Taobao/select',
    'taobaoDel'=>'api/Taobao/del',


],'','*',['after_behavior'=>'\app\common\behavior\Auth']);

//不需要验证路由
Route::rule([
    'login'  =>  'api/User/login',
    'imageCode'  =>  'api/User/imageCode',
    'register'  =>  'api/User/register',

]);

//错误路由
Route::miss(function(){
    return 'router error';
});

return [
];
