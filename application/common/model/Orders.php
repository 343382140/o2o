<?php


namespace app\common\model;

use think\Model;
class Orders extends Model
{
    public function add($data) {
//        print_r($data);die();
       $this->save($data);
//        print_r($this->getLastSql());die();
//        print_r($this->id);die();
      return $this->id;
    }
    public function getOrders($bis_id) {
        $order = [
            'id' => 'desc',
        ];
        $data = [
            'bis_id' => $bis_id,
            'status' => ['neq',-1],
        ];
        return $this->where($data)->order($order)->select();
    }

    public function getDelOrders($bis_id) {
        $order = [
            'id' => 'desc',
        ];
        $data = [
            'bis_id' => $bis_id,
            'status' => -1,
        ];
        return $this->where($data)->order($order)->select();
    }
}