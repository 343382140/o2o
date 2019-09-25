<?php

namespace app\index\controller;
use think\Controller;
class Detail extends Base
{
    public function index() {
        $id = input('get.id');
//        print_r($id);die();
        $goods = model('Goods')->get($id);
        $title = $goods['name'];
//        print_r($goods);die();
        $category_id = $goods['category_id'];
//        print_r($category_id);die();

        //获取当前商品所属一级分类
        $categoryName = model('Category')->get($category_id)['name'];
//        print_r($categoryName);exit();
        //获取商家名称
        $shop_id = $goods['shop'];
        $shopName = model('Bis')->get($shop_id)['name'];
//        print_r($shopName);die();
        //经纬度获取(获取商品对应商家经纬度)
        $x_point = model('Bis')->get($shop_id)['xpoint'];
        $y_point = model('Bis')->get($shop_id)['ypoint'];
        //地理位置名称
        $shopAddress = model('Bis')->get($shop_id)['address'];
        $shopDescription = model('Bis')->get($shop_id)['description'];
        $shopImg = model('Bis')->get($shop_id)['logo'];
//        print_r($x_y_point);
        return $this->fetch('',[
            'controller'=>'detail',
            'title' => $title,
            'goods' => $goods,
            'categoryName' => $categoryName,
            'shopName' => $shopName,
            'x_point' => $x_point,
            'y_point' => $y_point,
            'shopDescription' => $shopDescription,
            'shopImg'=>$shopImg,
            'shopAddress' => $shopAddress,
        ]);
    }
}
