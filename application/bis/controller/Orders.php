<?php
namespace app\bis\controller;

use think\Controller;

class Orders extends Check
{
    private $obj;
    // 调用model(代码优化)
    public function _initialize()
    {
        $this->obj = model('Orders');
    }
    public function index() {
        $shop_id_to_name = [];
        $good_id_to_name = [];
        $user_id_to_name = [];
        $bis_id = $this->checkLogin()['bis_id'];
        $orders = model('Orders')->getOrders($bis_id);
//        print_r($orders);die();
        foreach ($orders as $order) {
            $shop_id_to_name[$order['id']] = model('Bis')->get(['bis_id'=>$bis_id])['name'];
            $good_id_to_name[$order['id']] = model('Goods')->get(['id'=>$order['goods_id']])['name'];
            $user_id_to_name[$order['id']] = model('User')->get(['id'=>$order['user_id']])['username'];
        }
//        print_r($shop_id_to_name);die();
//        print_r($good_id_to_name);die();
        return $this->fetch('', [
            'orders' => $orders,
            'shop_id_to_name' => $shop_id_to_name,
            'good_id_to_name' => $good_id_to_name,
            'user_id_to_name' => $user_id_to_name,
        ]);
    }
    public function getDelorders() {
        $shop_id_to_name = [];
        $good_id_to_name = [];
        $user_id_to_name = [];
        $bis_id = $this->checkLogin()['bis_id'];
        $orders = model('Orders')->getDelOrders($bis_id);
//        print_r($orders);die();
        foreach ($orders as $order) {
            $shop_id_to_name[$order['id']] = model('Bis')->get(['bis_id'=>$bis_id])['name'];
            $good_id_to_name[$order['id']] = model('Goods')->get(['id'=>$order['goods_id']])['name'];
            $user_id_to_name[$order['id']] = model('User')->get(['id'=>$order['user_id']])['username'];
        }
//        print_r($shop_id_to_name);die();
//        print_r($good_id_to_name);die();
        return $this->fetch('', [
            'orders' => $orders,
            'shop_id_to_name' => $shop_id_to_name,
            'good_id_to_name' => $good_id_to_name,
            'user_id_to_name' => $user_id_to_name,
        ]);
    }
    public function coupons() {
        $bis_id = $this->checkLogin()['bis_id'];
        $shop_id_to_name = [];
        $good_id_to_name = [];
        $couponsBeginTime = [];
        $couponsEndTime = [];
        $data = input('get.');
        if(!empty($data['status'])) {
//            print_r($data['status']);
            $sdata['status'] = $data['status']-1;
        }
        if (!empty($data['coupons_number'])) {
            $sdata['coupons_number'] = $data['coupons_number'];
        }
        if (!empty($data['coupons_pass'])) {
            $sdata['coupons_pass'] = $data['coupons_pass'];
        }
        //当前商户管理员所管商家的消费券
        $sdata['bis_id'] = $bis_id;
        $coupons = model('Coupons')->where($sdata)->select();
//        print_r($orders);die();
        foreach ($coupons as $coupon) {
            $shop_id_to_name[$coupon['id']] = model('Bis')->get(['bis_id'=>$bis_id])['name'];
            $good_id_to_name[$coupon['id']] = model('Goods')->get(['id'=>$coupon['goods_id']])['name'];
            $couponsBeginTime[$coupon['id']] = model('Goods')->get(['id'=>$coupon['goods_id']])['coupons_begin_time'];
            $couponsEndTime[$coupon['id']] = model('Goods')->get(['id'=>$coupon['goods_id']])['coupons_end_time'];
        }
//        print_r($data);

//        print_r($coupons);
        return $this->fetch('', [
            'coupons'=> $coupons,
            'shop_id_to_name' => $shop_id_to_name,
            'good_id_to_name' => $good_id_to_name,
            'couponsBeginTime' =>$couponsBeginTime,
            'couponsEndTime' => $couponsEndTime,
        ]);
    }
    public function couponsStatus() {
        $status = input('post.status');
        $id = input('post.id');
//          print_r($id);print_r($status);die();
        $res = model('Coupons')->save(['status'=>$status],['id'=>$id]);
        if ($res) {
            $this->success("消费券已经通过验证,变为已使用状态");
        } else {
            $this->error("消费券状态修改失败");
        }
    }
    public function destroyCoupons ($id) {
//        print_r($id);die();
        $res = model('Coupons')->where(['id'=>$id])->delete();
        if ($res) {
            $this->success("消费券删除成功");
        } else {
            $this->error("消费券删除失败");
        }
    }
    //修改状态
    public function status(){
        //print_r(input('get.'));
        $data=input('get.');
        //校验
        /*$validate=validate('Bis');
        if(!$validate->scene('status')->check($data)){
            $this->error($validate->getError());
        }*/

        $res =$this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        if ($res) {
            //发送邮件
            //status 1 status 2 status -1
            //\phpmailer\Email::send($data['email'],$title,$content);
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
}
