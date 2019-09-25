<?php
namespace app\common\model;

use think\Model;

class Goods extends Model
{
    //商户账户信息
    public function add($data) {
        $this->save($data);
        return $this->id;
    }
    // 查询搜索数据(用于admin/Goods/index)
    public function getSearchGoods($data = []) {
//        $data['status'] = 1;
        $order = [
            'id' =>'desc'
        ];
        $res = $this->where($data)
            ->order($order)
            ->paginate(7);//这个模块用分页出错,原因不明,解决不了,暂不分页。
//       echo $this->getLastSql();
//        exit();
        return $res;
    }
    // 通过状态获取商品(默认获取待审核商品)
    public function getGoodsByStatus($status = 0) {
        $data = [
            'status' => $status,
        ];
        $order = [
            'id' => 'desc',
        ];
        $res = $this->where($data)
            ->order($order)
            ->paginate(4);
        return $res;
    }
    //通过shop(bis_id)彻底删除(删店时用)
    public function destroyGoodsByShopId($id) {
        $data = [
            'shop'=>$id,
        ];
        return $this->where($data)->delete();
    }
    //通过商品自身id删除商品
    public function destroyGoodsByGoodsId($id) {
        $data=[
            'id' => $id,
        ];
        return $this->where($data)->delete();
    }
    //通过当前用户、状态获取商品,可修改申请页(bis/goods/dellist)
    public function getGoodsByStatusAndUser($status,$user_bis_id) {
        $data = [
            'status' => $status,
            'bis_id' => $user_bis_id,
        ];
        $order = [
            'id' => 'desc',
        ];
        $res = $this->where($data)
            ->order($order)
            ->paginate(5);
        return $res;
    }
    // 通过商品id修改商品信息
    public function alterGoodsById($goods, $id) {
        $res = $this->save($goods, ['id'=>$id]);
        return $res;
    }


    //Index首页-推荐商品
    public function getGoodsByCategoryIdCityIdLimit($category_id, $city_id, $limit){
        $data = [
            'category_id' => $category_id,
            'city_id' => $city_id,
            'status' => 1,
        ];
        $order = [
            'id' => 'desc',
        ];
        $res = $this->where($data)
                ->order($order);
        if ($limit) {
           $res = $res ->limit($limit);
        }
        return $res->select();
    }

    //lists页,按所有条件获取商品
    public function getGoodsByConditions($data=[], $orderType='') {
//        print_r($data);print_r($orderType);exit();
        if (!empty($orderType)) {
            if ($orderType == 'order_by_sales') {
                //一下写法可换成 $order['but_count'] = 'desc';
                $order = [
                    'buy_count' => 'desc',
                ];
            }
            if ($orderType == 'order_by_price') {
                $order = [
                    'current_price' => 'desc',
                ];
            }
            if ($orderType == 'order_by_time') {
                $order = [
                    'create_time' => 'desc',
                ];
            }
        }
        $order['id'] = 'desc';

        $res = $this->where($data)
            ->order($order)
//            ->select();
            ->paginate(10);
        return $res;
    }
}











