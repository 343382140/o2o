<?php

namespace app\index\controller;
use think\Controller;
class Base extends Controller
{
    // 当前城市
    public $city = "";
    //当前登录用户
    public $account = "";
    public $categorys =[];
    public $defaultCity = "";
   public function _initialize()
   {
       //当前选择城市
       //获取一级城市数据 //getCitysByParentId(0)不可用,分页的原因获取不到全部
       $citys = model('City')->getCitysByParentIdNoPager(0);
//       print_r($citys);
//       exit();
       //获取当前选择的城市
       $this->getCity($citys);
//       print_r($this->city);
//       exit();

       //获取首页推荐分类
       $categorys = $this->getRecommendCategorys(0, 8);

       //传递数据到view
       $this->assign('citys', $citys);
       $this->assign('city', $this->city);
       $this->assign('categorys', $categorys);
       $this->assign('loginUser',$this->getLoginUser());
   }
   public function getCity($citys){
      foreach ($citys as $city) {
        $city = $city->toArray();
        if ($city['is_default']==1) {
          $defaultCity = $city['name'];
          break;//终止foreach
        }
      }
       // foreach ($citys as $city) {
       //     if ($city['is_default']) {
       //         $defaultCity = $city['name'];
       //         break;
       //     }
       // }
       //dump($city);exit;
       //默认城市
       $defaultCity = $defaultCity ? $defaultCity : '湛江';
       //若session中国已保存,则直接获取session中的值
       if (session('city', '', 'o2o') && !input('get.city')) {
           $city_name = session('city', '', 'o2o');
       } else {
           //当前选择城市 input(获取数据, 如果没有则默认值, 过滤空格。
           $city_name = input('get.city', $defaultCity, 'trim');
           session('city',  $city_name , 'o2o');
       }
       //dump($city_name);exit;
       $this->city = model('City')->where(['name'=>$city_name])->find();
   }
    //获取登录用户
    public function getLoginUser() {
        $account = session('user', '', 'o2o');
        return $account;
    }
    //获取首页推荐以及分类
    public function getRecommendCategorys($parent_id, $limit) {
        $parent_ids = [];
        $childCategorysArray = [];
        $recommendCategorys =[];
        //获取一级分类
        $categorys = model('Category')->getCategorysByParentIdLimit($parent_id, $limit);
//        print_r($categorys);exit();
        //获取一级分类的id,保存于数组中
        foreach ($categorys as $category) {
            $parent_ids[] = $category->id;
        }
//        print_r($parent_ids);exit();

        //获取一级分类对应的二级分类
        $childCategorys = model('Category')->getChildCategoryByParentId($parent_ids);

        foreach ($childCategorys as $childCategory) {
            $childCategorysArray[$childCategory->parent_id][]= [
                'id' => $childCategory->id,
                'name' => $childCategory->name,
            ];
        }
//        print_r($childCategorysArray);exit();

        foreach ($categorys as $category) {
//            $recommendCategorys 保存所有推荐分类的数据(包括一级二级)
            // $category->name 一级分类的名称
            //childCategorysArray 一级分类对应的二级分类
            $recommendCategorys[$category->id] = [$category->name, empty($childCategorysArray[$category->id]) ?[]:$childCategorysArray[$category->id]];
        }
//        print_r($recommendCategorys);exit();
        return $recommendCategorys;
    }
}
