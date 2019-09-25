<?php
namespace app\admin\controller;
use think\Controller;

class Bis extends Controller
{
    private $obj;
    // 调用model(代码优化)
    public function _initialize()
    {
        $this->obj = model('Bis');
    }
    //正常的商户
    public function index() {
        $res = $this->obj->getBisByStatus(1);
        return $this->fetch('', [
            'bis'=>$res,
        ]);
    }
    //删除的商户
    public function dellist() {
        $res = $this->obj->getBisByStatus(-1);
        return $this->fetch('', [
            'bis'=>$res,
        ]);
    }

    // 入驻申请列表
    public function apply() {
        $res = $this->obj->getBisByStatus();
//        print_r($res);
//        die();
        return $this->fetch('',[
                'bis'=>$res,
        ]);
    }
    //彻底删除商户信息
    public function destroy(){
        $id = input('get.id');
        $res = $this->obj->destroyBis($id);
        //修改商店下所有商品的状态。
        //获取当前商户的id
        $shopId = $this->obj->get(['id'=>$id])['id'];
        //查看当前商户下是否有商品
        $haveGoods = model('Goods')->get(['shop'=> $shopId]);
//        print_r($haveGoods);die();
        if ($haveGoods){
            //通过商品所属的shop删除对应信息
            model('Goods')->destroyGoodsByShopId($shopId);
        }
        if ($res) {
            $this->success('该商户已经彻底从数据库中删除!','bis/index');
        }
    }

    //入驻申请详细信息
    public function detail() {
        //获取穿过来的当前行信息的ID
        $id = input('get.id');
//        print_r($id);die();
        //根据id获取商家信息以及商家账户信息
        $bisData = model('bis')->get($id);
//        print_r($bisData);
        //获取商家账户中bis_id与当前获取的门店的bis_id相等的账户信息
        $bisAccountData = model('Bis_Account')->get(['bis_id' => $bisData['bis_id']]);
//        print_r($bisAccountData);
//        die();
        // 获取所有城市的数据
        $citys = model('City')->getAllCitys();
//        print_r($citys);
//        die();
        // 获取所有菜单的数据
        $categorys = model('Category')->getAllCategorys();
//        print_r($categorys);
//        die();
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys,
            'bisData' => $bisData,
            'bisAccountData' => $bisAccountData,
        ]);
    }

    // 修改分类状态(发布状态(正常、待审、删除))
    public function status() {
        $data = input('get.');
//        print_r($data);die();
        //校验数据,tp5 validate验证机制(暂未校验)
//        $validate = validate('Bis');
//        if(!$validate->scene('status')->check($data)) {
//            $this->error($validate->getError());
//        }
        //修改
        //save([修改项],[条件]);修改商店status
        $res = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);

        //修改商店下所有商品的状态。
        $resId = $this->obj->get(['id'=>$data['id']])['id'];
        $haveGoods = model('Goods')->get(['shop'=> $resId]);
//        print_r($haveGoods);die();
        if ($haveGoods){
            model('Goods')->save(['status'=>$data['status']],['shop' => $data['id']]);
        }
//        print_r("res->".$res);
//        die();
        //获取账户的email
        $email = $this->obj->get($data['id'])['email'];
//        print_r($email);
//        die();
        if($res) {
//            printf(url());
            if($data['status'] == 1){
                \phpmailer\Email::send($email,"o2o入驻申请结果", "您在本平台的入驻申请已经通过审核!");
            }else {
                \phpmailer\Email::send($email,"o2o入驻申请结果", "您在本平台的入驻申请没有通过审核!请重新申请");
            }
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }
    }
}
