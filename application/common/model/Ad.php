<?php


namespace app\common\model;
use think\Model;

class Ad extends Model
{
    public function add($data) {
       $res = $this->save($data);
        return $res;
    }
    //通过status获取广告位,默认status为0
    public function getAdByStatus($status = 0) {
        $data = [
            'status' => $status,
        ];
        $order = [
            'id' => 'desc'
        ];
        $res = $this->where($data)
            ->order($order)
            ->paginate(6);
        return $res;
    }
    //直接删除
    public function destroyAdById($id) {
       return $this->where(['id'=>$id])->delete();
    }
    //修改广告申请
    public function alterAdById($data, $id){
       $res = $this->save($data, ['id'=>$id]);
        return $res;
    }

    //bis-广告位首页
    public function getAdByStatusAndBisId($status, $bis_id) {
        $data = [
            'status' => $status,
            'bis_id' => $bis_id,
        ];
        $order = [
            'id' => 'desc',
        ];
        $res = $this->where($data)
            ->order($order)
            ->paginate(5);
        return $res;
    }

    //index-根据状态、类型获取广告
    public function getAdByStatusTypeLimit($status, $type, $limit) {
        //dd('ad');
        $data = [
            'status' => $status,
            'type' => $type,
        ];
        // $order = [
        //     'create_time' => 'desc',
        // ];
        $res = $this->where($data)
            ->limit($limit)
            //->order($order)
            ->select();
        return $res;
    }
}