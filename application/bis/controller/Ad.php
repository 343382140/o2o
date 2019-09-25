<?php
namespace app\bis\controller;

use think\Controller;

class Ad extends Check
{
    private $obj;
    // 调用model(代码优化)
    public function _initialize()
    {
        $this->obj = model('Ad');
    }
    //首页(列表页)
    public function index() {
        //获取的就是当前登录商家的广告位,没必要显示商家名,因此转换代码注释
//        $bis_id_to_name = [];
//        获取当前登录用户的bis_id
        $bis_id = $this->checkLogin()->bis_id;
        $ads = $this->obj->getAdByStatusAndBisId(1,$bis_id);
//        print_r($ads);die();
//        print_r($res[0]['bis_id']);
//        die();
//        foreach ($ads as $ad){
//            $bis_id_to_name[$ad['bis_id']] = model('BisAccount')->get(['bis_id'=>$ad['bis_id']])['username'];
//        }
        return $this->fetch('',[
            'ad'=>$ads,
//            'bis_id_to_name' => $bis_id_to_name,
        ]);
    }
    public function add() {
        //判断是否为post方式,如果是,则为入库操作
        if (request()->isPost()) {
            //推荐位入库逻辑
            $data = input('post.');
            //填写时没有商户id,从session获取
            $data['bis_id'] = $this->checkLogin()->bis_id;
//            print_r($data);exit();
            $res = $this->obj->add($data);
            if ($res) {
                $this->success("广告位申请已提交");
            }else{
                $this->error("广告位申请提交失败");
            }
        } else{
            //加载add页面
            $adType = config('ad.ad_type');
            return $this->fetch('',[
                'adType' => $adType,
            ]);
        }
    }
    //获取删除的(status-1)广告位,bis-ad-dellist
    public function dellist() {
        //获取的就是当前登录商家的广告位,没必要显示商家名,因此转换代码注释
//        $bis_id_to_name = [];
//        print_r($res[0]['bis_id']);
//        die();
        $bis_id = $this->checkLogin()->bis_id;
        $ads = $this->obj->getAdByStatusAndBisId(-1,$bis_id);
//        foreach ($ads as $ad){
//            $bis_id_to_name[$ad['bis_id']] = model('BisAccount')->get(['bis_id'=>$ad['bis_id']])['username'];
//        }
        return $this->fetch('',[
            'ad'=>$ads,
//            'bis_id_to_name' => $bis_id_to_name,
        ]);
    }
    //可修改的广告申请详情
    public function detail() {
        $data = input('get.');
//        print_r($data);exit();
        $adData = $this->obj->get($data['id']);
        $adType = config('ad.ad_type');
        return $this->fetch('',[
            'adData' => $adData,
            'adType' => $adType,
        ]);
    }
    //修改广告申请后的action
    public function alter() {
        $id = input('get.')['id'];
//        print_r($id);exit();
        $data = input('post.');
//        print_r($data);exit();
        $data['status']=0;
        $res = model('Ad')->alterAdById($data, $id);
        if ($res) {
            $this->success("重新提交广告申请成功",url('ad/index'));
        }else {
            $this->error("重新提交广告申请失败");
        }
    }
    //商户删除广告申请(可重新申请的广告位页)
    public function destroy($id) {
        $res = model('Ad')->destroyAdById($id);
        if ($res) {
            $this->success("申请已经删除");
        }else{
            $this->error("申请删除失败");
        }
    }
}
