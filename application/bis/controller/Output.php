<?php

namespace app\bis\controller;

use think\Controller;

class Output extends Check
{
    private $obj;
    // 调用model(代码优化)
    public function _initialize()
    {
        $this->obj = model('Output');
    }
    public function index() {
        $bis_id = $this->checkLogin()['id'];
        $bisAdmin = model('BisAccount')->get($bis_id);
        //print_r($bisAdmin);exit;
        return $this->fetch('',[
            'bisAdmin' => $bisAdmin,
        ]);
    }
    public function shenqing() {
        $data = input('post.');
//        print_r($data);
        //提现数据入库
        $res = model('Output')->allowField(true)->save($data);
        // 商家管理员资金减少
        $nowMoney = $data['total_money'] - $data['output_money'];
        //资金减少数据操作
        $res1 = model('Bis_Account')->save(['money'=>$nowMoney],['bis_id'=>$data['bis_id']]);
        if ($res && $res1) {
            $this->success("申请提现成功,审核通过后资金将直接打入您的账户");
        }
    }
    public function lists() {

        $outputLists = model('Output')->where(['bis_id'=>$this->checkLogin()['bis_id']])->select();
//        print_r($outputLists);die();
        $adminName = $this->checkLogin()['username'];
        return $this->fetch('',[
            "outputLists" => $outputLists,
            'adminName' => $adminName,
        ]);
    }
    public function edit() {
        $bis_id = $this->checkLogin()['id'];
        $bisAdmin = model('BisAccount')->get($bis_id);
        return $this->fetch('',[
            'bisAdmin' => $bisAdmin,
        ]);
    }
}
