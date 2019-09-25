<?php
namespace app\index\controller;
use think\Controller;
class Index extends Base
{
   public function index() {
       $loginUser = session('User','','o2o')['username'];

       //获取首页广告位信息

       $bigAds = model('Ad')->getAdByStatusTypeLimit(1, 0, 4);
       $smallAds = model('Ad')->getAdByStatusTypeLimit(1, 1, 2);
//       print_r($bigAds);
//       print_r($smallAds);
//       die();
//print_r($this->city->id);exit();
       //商品分类推荐获取-美食  //$this->city->id暂时用31,因为其他的还没放数据
       $goods_meishi = model('Goods')->getGoodsByCategoryIdCityIdLimit(34, $this->city->id, 10);
//        print_r($goods_meishi);exit();

       // 获取该分类下的子分类(展示于index,如:美食----xx---xx--xx--全部>)
        $recom_child_categorys_meishi = model('Category')->getCategorysByParentIdLimit(34, 4);

       // 商品分类推荐获取-休闲//
       $goods_xiuxian = model('Goods')->getGoodsByCategoryIdCityIdLimit(31, $this->city->id, 10);
       $recom_child_categorys_xiuxian = model('Category')->getCategorysByParentIdLimit(31, 4);
       return $this->fetch('',[
           'title'=> '乐购网',
           'controller' => 'index',
           'bigAds' => $bigAds,
           'smallAds' => $smallAds,
           'goods_meishi'=>$goods_meishi,
           'recom_child_categorys_meishi'=>$recom_child_categorys_meishi,
           'goods_xiuxian' => $goods_xiuxian,
           'recom_child_categorys_xiuxian' => $recom_child_categorys_xiuxian,
       ]);
   }
   public function threed() {
       return $this->fetch();
   }
}
