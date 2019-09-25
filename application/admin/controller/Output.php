<?php

namespace app\admin\controller;

use think\Controller;

class Output extends Controller
{
    private $obj;
    // 调用model(代码优化)
    public function _initialize()
    {
        $this->obj = model('Output');
    }
    public function index() {
        //获取提现数据
        $bis_id_to_name = [];
        $bis_card_number = [];
        $orderLists = model('Output')->where(['status'=>0])->select();
//        print_r($orderLists);
        foreach ( $orderLists as $list) {
            $bis_id_to_name[$list['id']] = model('Bis_Account')->get(['bis_id'=>$list['bis_id']])['username'];
            $bis_card_number[$list['id']] = model('Bis_Account')->get(['bis_id'=>$list['bis_id']])['card_number'];
        }
//        print_r($bis_id_to_name);die();
        return $this->fetch('', [
            'orderLists' => $orderLists,
            'bis_id_to_name' => $bis_id_to_name,
            'bis_card_number' => $bis_card_number,
        ]);
    }
    public function status($id) {
//        print_r($id);
        $res = model('Output')->save(['status'=>1],['id'=>$id]);
        if ($res) {
            $this->success("处理成功");
        } else {
            $this->error("处理失败");
        }
    }
    public function history() {
        //获取提现数据
        $bis_id_to_name = [];
        $bis_card_number = [];
        $orderLists = model('Output')->where(['status'=>1])->select();
//        print_r($orderLists);
        foreach ( $orderLists as $list) {
            $bis_id_to_name[$list['id']] = model('Bis_Account')->get(['bis_id'=>$list['bis_id']])['username'];
            $bis_card_number[$list['id']] = model('Bis_Account')->get(['bis_id'=>$list['bis_id']])['card_number'];
        }
//        print_r($bis_id_to_name);die();
        return $this->fetch('', [
            'orderLists' => $orderLists,
            'bis_id_to_name' => $bis_id_to_name,
            'bis_card_number' => $bis_card_number,
        ]);
    }
    public function destroy($id)
    {
//        print_r($id);die();
        $res = model('Output')->destroyOutputHistory($id);
        if ($res) {
            $this->success("彻底删除成功");
        } else {
            $this->error("彻底删除失败");
        }
    }
}
