<?php

namespace app\index\controller;
use think\Controller;
class Order extends Base
{
    public function comfirm() {
        //判断是否登录
        if (!$this->getLoginUser()) {
            $goodsId = input('get.id',0,'intval');
            $this->error("请先登录再来购买",url('index/user/login',['goodsId'=>$goodsId]));
        }
        //获取传过来的商品id
        $id = input('get.id', 0, 'intval');
        $count = input('get.count', 1, 'intval');
//        print_r($id);print_r($count);exit();
        //搜索对应商品
        $goods = model('Goods')->get($id);
       $goods = $goods->toArray();
//        print_r($goods->toArray());exit();
        return $this->fetch('',[
            'title' => '订单确认',
            'controller' => 'pay',
            'goods' => $goods,
            'count' => $count,
        ]);
    }
    public function index() {
        $user_id = $this->getLoginUser()->id;
//        print_r($user_id);die();
        $goodid = input('get.id');
        $buy_count = input('get.count');
//        print_r($buy_count);die();
        $total_price = input('get.total_price');
        $good =  model('Goods')->get($goodid);
        $nowCount = $good->total_count - $buy_count;
        $hasBuy = $good->buy_count + $buy_count;
        //入库。。
        model('Goods')->save(['total_count'=>$nowCount],['id'=>$goodid]);
        model('Goods')->save(['buy_count'=>$hasBuy],['id'=>$goodid]);
        $good = $good->toArray();
//        print_r($good);die();
        $data = [
            'user_id' => $user_id,
            'shop' =>  $good['shop'],
            'goods_id' => $good['id'],
            'buy_count' => $buy_count,
            'price' => $good['current_price'],
            'total_price' => $total_price,
            'bis_id' => $good['bis_id'],
        ];
//        print_r($data);die();
        //添加成功返回值设置成了订单id
        $orderId = model('Orders')->add($data);
        $data['order_id'] = 'xq8167486'.$orderId;
        //保存订单号
        $res = model('Orders')->save(['order_id'=>$data['order_id']],['id'=>$orderId]);
        if ($orderId && $res) {
          return  $this->success('订单提交成功,支付页面加载中...',url('order/pay',['id'=>$orderId]));
        } else {
          return $this->error('订单提交失败,请重新提交',url('order/comfirm'));
        }
    }
    public function pay() {
        $orderId = input('get.id');
        $order = model('Orders')->get($orderId);
//        print_r($order);die();
        $goods = model('Goods')->get($order['goods_id']);
        return $this->fetch('',[
            'title' => '乐购网-支付',
            'controller' => 'pay',
            'order' => $order,
            'goods' => $goods,
        ]);
    }
    public function succeed() {
        // 订单id
        $id = input('get.id');
//        修改支付状态
        model('Orders')->save(['status'=>1],['id'=>$id]);
        $order = model('Orders')->get($id);
        //决定消费券数量
        $count = $order['buy_count'];
//        print_r($count);die();
        //产生随机消费券号
        //① 消费券相关。(之前不是成功支付状态,所以不设消费券,现在成功了再加)
        $chars = 'abcdefghijkmnopqrstuvwxyzABCDEFGHIJKMNPQRSTUVWXYZ23456789';
        $i = 0;
        //根据购买数量产生消费券消费券
        for ($i; $i < $count; $i++) {
            $coupon = '';
            $couponPass = '';
            for ($j = 0; $j < 10; $j++) {
                $coupon .= $chars[mt_rand(0, strlen($chars) - 1)];
            }
            for ($j = 0; $j < 5; $j++) {
                $couponPass .= mt_rand(0, 9);
                //$couponPass .= random_int(0, 9);
            }
            //组装批量插入数据
            $couponsData[$i] = [
                'coupons_number' => $coupon,
                'coupons_pass' => $couponPass,
                'user_id' => $order['user_id'],
                'goods_id' => $order['goods_id'],
                'order_id' => $id,
                'shop_id' => $order['shop'],
                'bis_id' => $order['bis_id'],
            ];
        }

       $res = model('Coupons')->saveAll($couponsData);
        if ($res){

            //②商家管理员账户加资金
            $order = model('Orders')->get($id);
            $bis_id = $order['bis_id'];
            $totalPrice = $order['total_price'];
            //获取对应商家管理员原资金
            $bisAccountMoney = model('Bis_Account')->get(['bis_id'=>$bis_id])['money'];
//            print_r($bisAccountMoney);die();
            //商家管理员如今的资金
            $nowMoney = $totalPrice + $bisAccountMoney;
            //入库。。
            $res = model('Bis_Account')->save(['money'=>$nowMoney],['bis_id'=>$bis_id]);

            if (!$res) {
                $this->error('商家管理员资金存储出错');
            }

            //③邮件发送前处理
            //获取当前用户的邮箱、订单相关信息,发送消费券信息。
            $email = $this->getLoginUser()->email;
            //获取商品信息
            $goodId = model('Orders')->get($id)['goods_id'];
            //获取商家信息
            $shopID = model('Orders')->get($id)['shop'];
            //商品名、商店名
            $goodName = model('Goods')->get(['id'=>$goodId])['name'];
            $shopName = model('Bis')->get(['id'=>$shopID])['name'];
            $address = model('Bis')->get(['id'=>$shopID])['address'];
            //获取消费券有效时间
            $couponsBeginTime = model('Goods')->get(['id'=>$goodId])['coupons_begin_time'];
            $couponsEndTime = model('Goods')->get(['id'=>$goodId])['coupons_end_time'];
            //将时间戳转换成日期形式
            $couponsBeginTime = date("Y-m-d H:i:s",$couponsBeginTime);
            $couponsEndTime = date("Y-m-d H:i:s",$couponsEndTime);
//            print_r($couponsBeginTime);print_r($couponsEndTime);exit();

//            print_r($goodName);print_r($shopName);exit();
//          print_r($email);exit();
            $coreData = '';
            //获取属于当前订单的消费券信息
           $sendCoupons = model('Coupons')->where(['order_id'=>$order['id']])->select();
//            print_r($sendCoupons);die();
//            拼接核心发送字符串
            foreach ($sendCoupons as $sendCoupon) {
                $coreData .= "<div>消费券号:'".$sendCoupon["coupons_number"]."'使用码:'".$sendCoupon['coupons_pass']."'</div>";
            }
            //发送邮件,邮件内容包括-商家名称、商品名称、消费券名称、消费券密码、消费券有效期。
           $res = \phpmailer\Email::send($email,"o2o.com消费券信息通知", "
           您的消费信息为:<br/>
           团购名称:'".$goodName."',数量:'".$count."'<br/>
           总价值:'".$totalPrice."'元<br/>
           购买商店:'".$shopName."'<br/>
           消费券有'".$count."'张,信息分别为:
           $coreData
           使用地址:'".$address."'<br/>
           请在'".$couponsBeginTime."'至'".$couponsEndTime."'期间兑换服务<br/>过期无效!谢谢支持!");
            if (!$res) {
                $this->error("邮件发送相关设计出错");
            }

            return $this->success('支付成功,消费券信息已发到您的邮箱,请注意查收...',url('index/index'));
        }
        else {
            $this->error("消费券相关设计产生问题");
        }
  }
}












