<?php
namespace app\common\model;

use think\Model;

class City extends Model {
    //通过城市parent_id 获取城市名称,默认parentId=0,即获取一级城市(适合需要用到分页的页面)
    public function getCitysByParentId($parendId = 0) {
        $data = [
            'status' => 1,
            'parent_id' => $parendId,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->paginate(4);
    }
    //获取所有城市信息(用于admin/bis/detail.html)
    public function getAllCitys() {
        $data = [
            'status' => 1,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }
    //获取二级城市(用于后台管理中团购列表页)
    public function getChildCitys() {
        $data = [
            'status' => 1,
            'parent_id' => ['gt',0],
        ];
        $order =[
            'id' => 'desc',
        ];
        return $this->where($data)
                ->order($order)
                ->select();
    }
    //register页获取二级分类,由于不用分页,貌似上边的getCategorysByParentId没得共用。
    public function getCitysByParentIdNoPager($parent_id=0) {
        $data = [
            'status' => 1,
            'parent_id' => $parent_id,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }
    //增加城市
    public function add($data) {
//        print_r($data);
//        exit();
        $data['status'] = 1;
        $res = $this->save($data);
//        echo $this->getLastSql();
        return $res;
    }

    public function getDelFirstCitysByParentId(){
        $data =[
            'status'=>-1,
        ];
        $order =[
            'listorder' =>'desc',
            'id'=>'desc',
        ];

        $result=$this->where($data)
            ->order($order)
            ->paginate(5);

        //echo $this->getLastSql();
        return $result;
    }
}