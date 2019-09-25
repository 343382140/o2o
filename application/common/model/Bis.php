<?php
namespace app\common\model;

use think\Model;

class Bis extends Model
{
    //商户基本信息
    public function add($data) {
//        $data['status'] = 0;//数据库中已设置默认值为0
//        print_r($this->status); 假如不指定status的值,此处出错,因为传过来没有status,仅在
        //数据库中设置了默认0;
//        print_r($data);
//        die();
          $this->save($data);
//        print_r($this);
//        die();
//        print_r($this->address);
//        die();
        return $this->id;
    }

    // 通过状态获取商家数据
    public function getBisByStatus($status=0) {
        $order = [
            'id' => 'desc',
        ];
        $data = [
            'status' => $status,
        ];
        $result = $this->where($data)
            ->order($order)
            ->paginate(6);
        return $result;
    }
    //通过id彻底删除
    public function destroyBis($id) {
        $data = [
            'id'=>$id,
        ];
        return $this->where($data)->delete();
    }
//    根据商家id获取门店
    public function getBisByBisId($id) {
        $data = [
            'bis_id' => $id,
            'status' => 1,
        ];
        $order = [
            'id' => 'desc',
        ];
        $res = $this->where($data)
                    ->order($order)
                    ->select();
        return $res;
    }
    //刚注册用户时添加的商店,bis_id似乎这样添加才行。
    public function firstAdd_bisId($id) {
        //([修改项], [条件])
        $res = $this->save(['bis_id'=>$id], ['id'=>$id]);
//        print_r($this->getLastSql());
//        die();
        return $res;
    }
    //根据当前登录账户的bis_id获取该账户下的商店
    public function getShopsByBisId($id) {
        $data = [
            'bis_id' => $id,
        ];
        $order = [
            'id' => 'desc',
        ];
        $res = $this->where($data)
            ->order($order)
            ->paginate(2);
        return $res;
    }

    //根据商店id修改商店信息
    public function alterShopDataById($data,$id) {
        $res = $this->save($data, ['id' => $id]);
        return $res;
    }
    // 获取删除的门店的信息,商户专用
    public function getBisByStatusAndUser($status,$user_bis_id)
    {
        $data = [
            'status' => $status,
            'bis_id' => $user_bis_id,
        ];
       $res = $this->where($data)
            ->paginate(5);
        return $res;
    }

    public function getShopsByBisIdNoPager($id) {
        $data = [
            'bis_id' => $id,
        ];
        $order = [
            'id' => 'desc',
        ];
        $res = $this->where($data)
            ->order($order)
            ->select();
        return $res;
    }
}