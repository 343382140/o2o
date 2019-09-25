<?php
namespace app\common\model;

use think\Model;

class Category extends Model
{
    //增加生活服务分类
    public function add($data) {
        $data['status'] = 1;
        //可在配置文件中直接配置是否自动写入时间戳字段
//        $data['create_time'] = time();
        $res = $this->save($data);
//        print_r($this->getLastSql());exit();
        return $res;
    }
    //根据parent_id获取服务分类,默认一级分类(需要分页的首页、子分类页)
    public function getCategorysByParentId($parent_id = 0) {
        $data = [
            'status' => 1,
            'parent_id' => $parent_id,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->paginate(12);
    }
    //查询所有分类,包括二级(用于admin/bis/detail.html)
    public function getAllCategorys() {
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
    //register页获取二级分类,由于不用分页,貌似上边的getCategorysByParentId没得共用。
    public function getCategorysByParentIdNoPager($parent_id = 0) {
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


    // 通过状态获取分类数据(获取删除分类)
    public function getCategorysByStatus($status=-1) {
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
    // 通过id彻底删除
    public function destroyCategory ($id) {
        $data = [
            'id' => $id,
        ];
        $res = $this->where($data)->delete();
        return $res;
    }


    // 首页相关   // 首页相关   // 首页相关   // 首页相关   // 首页相关

    // 获取一级分类
    public function getCategorysByParentIdLimit($parent_id = 0, $limit=0) {
        $data = [
            'status' => 1,
            'parent_id' => $parent_id,
        ];
        $order = [
            'listorder' => 'desc',
            'id' => 'desc',
        ];
        if($limit) {
            return $this->where($data)
                ->order($order)
                ->limit($limit)
                ->select();
        }
        return $this->where($data)
            ->order($order)
            ->select();
    }
    //获取一级分类下面的所有二级分类
    public function getChildCategoryByParentId($parent_ids) {
        $data = [
            'parent_id' => ['in', implode(',', $parent_ids)],
            'status' => 1,
        ];
        $order = [
            'id' => 'desc',
            'listorder' => 'desc',
        ];
        $res = $this->where($data)
            ->order($order)
            ->select();
        return $res;
    }
}