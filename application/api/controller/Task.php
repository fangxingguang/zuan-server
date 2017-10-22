<?php
namespace app\api\controller;

use think\Controller;
use think\Db;

class Task extends Base
{

    //发布任务
    public function add(){
        $params = $this->valid([
            'type' => 'require|in:1,2',
            'buyer' => 'require',
            'seller' => 'require',
            'url' => 'require',
            'name' => 'require',
            'image' => 'url',
            'price' => 'require',
            'qq' => 'require',
            'search_key' => 'max:255',
            'rank' => 'max:255',
            'comment' => 'max:255',
            'time' => 'max:255',
            'remark' => 'require',
            'condition' => 'max:255',
        ]);
        $params['uid'] = input('uid');
        $model = model('Task');
        $task = $model::create($params);
        if($task){
            $this->suc($task);
        }
        $this->err('操作失败');
    }

    //查询任务
    public function select(){
        $params = $this->valid([
            'type' => 'number|default:1',
            'price' => 'float'
        ]);
        $model = model('Task');
        $where['type'] = $params['type'];
        if(isset($params['price'])){
            $where['price'] = ['between',[$params['price']-1,$params['price']+1]];
        }
        $where['status'] = 0;
        $list = $model->where($where)->order('create_time','desc')->paginate();
        $this->suc($list);
    }

    //更新任务进度
    public function update(){
        $params = $this->valid([
            'id' => 'require|number',
            'step' => 'number',
        ]);
        $model = model('Task');
        $params['uid'] = input('uid');
        $task = $model::update($params);
        if($task){
            $this->suc($task);
        }
        $this->err('操作失败！');
    }

    //删除任务
    public function del(){
        $params = $this->valid([
            'id' => 'require|number'
        ]);
        $params['uid'] = input('uid');
        $model = model('Task');
        $res = $model::destroy($params);
        if($res){
            $this->suc();
        }
        $this->err('操作失败！');
    }

    //查询我发布的任务
    public function selectWait(){
        $params = $this->valid([
            'type' => 'number|default:1'
        ]);
        $model = model('Task');
        $where['uid'] = input('uid');
        $where['type'] = $params['type'];
        $where['status'] = 0;
        $list = $model->where($where)->order('create_time','desc')->select();
        $this->suc($list);
    }

    //邀请互刷
    public function invite(){
        $params = $this->valid([
            'my_task_id' => 'require|number',
            'other_task_id' => 'require|number'
        ]);
        $uid = input('uid');
        $taskModel = model('Task');
        $myWhere['id'] = $params['my_task_id'];
        $myWhere['uid'] = $uid;
        $myWhere['status'] = 0;
        $myTask = $taskModel::get($myWhere);
        if(empty($myTask)){
            $this->err('我的任务不可用！');
        }
        $otherWhere['id'] = $params['other_task_id'];
        $otherWhere['status'] = 0;
        $otherTask = $taskModel::get($otherWhere);
        if(empty($otherTask)){
            $this->err('对方任务不可用！');
        }
        if($myTask['uid'] == $otherTask['uid']){
            $this->err('不能互拍自己的任务！');
        }
        $inviteModel = model('TaskInvite');
        $inviteWhere['my_task_id'] = $params['my_task_id'];
        $inviteWhere['other_task_id'] = $params['other_task_id'];
        $inviteWhere['status'] = ['in','0,1'];
        $invite = $inviteModel::get($inviteWhere);
        if($invite){
            $this->err('不能重复邀请！');
        }
        $invite = $inviteModel::create($params);
        if($invite){
            $this->suc($invite);
        }
        $this->err('操作失败！');
    }

    //我发布的
    public function selectSend(){
        $params = $this->valid([
            'type' => 'number|default:1',
            'key' => 'in:name',
            'value' => 'alphaNum'
        ]);
        $model = model('Task');
        $where['uid'] = input('uid');
        $where['type'] = $params['type'];
        if(isset($params['key'])){
            $where['name'] = ['like','%'.$params['value'].'%'];
        }
        $list = $model->where($where)->order('create_time','desc')->paginate();
        $this->suc($list);
    }

    //邀请记录
    public function inviteSelect(){
        $params = $this->valid([
            'task_id'=>'require',
        ]);
        $model = model('TaskInvite');
        $taskModel = model('Task');
        //我发起的
        $where['my_task_id'] = $params['task_id'];
        $where['status'] = 0;
        $myInviteList = $model->where($where)->select();
        $otherTaskId = $myInviteList->column('other_task_id');
        $taskList = $taskModel->where('id','in',$otherTaskId)->select();
        $result['sendList'] = listMerge($myInviteList,$taskList,'other_task_id','id','task');
        //我收到的
        $where2['other_task_id'] = $params['task_id'];
        $where2['status'] = 0;
        $myInviteList = $model->where($where2)->select();
        $otherTaskId =$myInviteList->column('my_task_id');
        $taskList = $taskModel->where('id','in',$otherTaskId)->select();
        $result['receiveList'] = listMerge($myInviteList,$taskList,'my_task_id','id','task');
        $this->suc($result);
    }

    //变更邀请状态
    public function inviteUpdate(){
        $params = $this->valid([
            'id'=>'require',
            'status'=>'require',
        ]);
        $model = model('TaskInvite');
        $taskModel = model('Task');
        $uid = input('uid');

        $invite = $model->where('id',$params['id'])->find();
        if(!$invite){
            $this->err('邀请不存在！');
        }
        $where['uid'] = $uid;
        $where['id'] = ['in',[$invite['my_task_id'],$invite['other_task_id']]];
        $task = $taskModel->where($where)->find();
        if(empty($task)){
            $this->err('非法操作！');
        }
        if($invite['status']!=0){
            $this->err('状态已变更，无法操作！');
        }
        $result = $model->where('id',$params['id'])->update(['status'=>$params['status']]);
        if($result){
            if($params['status'] == 1){
                $updateData['status'] = 1;
                $updateData['other_task_id'] = $invite['other_task_id'];
                $updateData['start_time'] = date('Y-m-d H:i:s');
                $taskModel->where('id',$invite['my_task_id'])->update($updateData);

                $updateData['other_task_id'] = $invite['my_task_id'];
                $taskModel->where('id',$invite['other_task_id'])->update($updateData);
            }
            $this->suc('操作成功！');
        }
        $this->err('操作失败！');
    }

    //我的互刷任务
    public function taskSelectDo(){
        $params = $this->valid([
            'type' => 'number|default:1',
            'start_time'=>'date',
            'end_time'=>'date',
            'key'=>'in:my_seller,my_buyer,other_seller,other_buyer,name',
            'value'=>'chsDash'
        ]);
        $uid = input('uid');

        $where['a.uid'] = $uid;
        $where['a.status'] = 1;
        $where['a.type'] = $params['type'];
        if(!empty($params['start_time'])){
            $where['a.start_time'] = ['between',[$params['start_time'],$params['end_time']]];
        }
        if(!empty($params['value'])){
            switch($params['key']){
                case 'my_seller':$key = 'a.seller';break;
                case 'my_buyer':$key = 'a.buyer';break;
                case 'other_seller':$key = 'b.seller';break;
                case 'other_buyer':$key = 'b.buyer';break;
                case 'name':$key = 'a.name';break;
            }
            $where[$key] = ['like','%'.$params['value'].'%'];
        }
        $myTask = Db::table('task a')->field('a.*')->field(true,false,'task','b','other_task_')->join('task b','a.other_task_id = b.id')->where($where)->order('create_time','desc')->paginate();
        $total = $myTask->total();
        $resultArr = $myTask->toArray();
        $list = $resultArr['data'];
        $result['data'] = $list;
        $result['total'] = $total;
        $this->suc($result);
    }

}
