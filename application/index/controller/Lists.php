<?php


namespace app\index\controller;
use think\Controller;

class Lists extends Base
{
    public function index() {
        // 获取一级分类
        $categorys = model('Category')->getCategorysByParentIdNoPager();
//        print_r($categorys);exit();
        $firstCategorys = [];
        // 保存所有一级分类的id,用于校验提交过来的id是一级还是二级分类
        foreach ($categorys as $category) {
            $firstCategorys[] = $category->id;
        }
        //传过来的id
        $id = input('id', 0, 'intval');
//        print_r($id);exit();
        //判断是否是一级分类
        $data = [];
        if (in_array($id, $firstCategorys)) {
            $categoryParentId = $id;
//            print_r($id); exit();
            //一级分类查询条件
            $data['category_id'] = $id;
        } elseif ($id) {//是二级分类
            //获取二级分类
            $child_category = model('Category')->get($id);
            $categoryParentId = $child_category->parent_id;
//            print_r($categoryParentId);
            //二级分类查询条件
            $data['child_category_id'] = $id;
        } else {
            $categoryParentId = 0;
        }
        //获取请求的一级分类下的所有二级分类供显示。
        $child_categorys = [];
        // 如果选择全部,则$categoryParentId为空,因此,二级分类为空
        if($categoryParentId) {
            $child_categorys = model('Category')->getCategorysByParentIdNoPager($categoryParentId);
//            print_r($child_categorys);
//            exit();
        }
        //排序处理
        //print_r($this->city->id);exit();
        $orderType = input('orderType','');
//        print_r($orderType);exit();
        $data['city_id']=$this->city->id;
        $goods = model('Goods')->getGoodsByConditions($data, $orderType);
//        print_r($goods);exit();
        return $this->fetch('',[
            'title' => '全部团购',
            'controller' => 'lists',
            'categorys' => $categorys,//所有一级分类
            'child_categorys' => $child_categorys,//选中一级分类下的二级分类
            'id' => $id,//传过来的id
            'categoryParentId' => $categoryParentId,//传过来的上级分类id
            'orderType' => $orderType,
            'goods'=> $goods,
        ]);
    }
}