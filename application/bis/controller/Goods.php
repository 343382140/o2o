<?php
namespace app\bis\controller;

use think\Controller;

class Goods extends Check
{
    private $obj;
    // 调用model(代码优化)
    public function _initialize()
    {
        $this->obj = model('Goods');
    }

    public function index()
    {
        $data = input('get.');
        $sdata = [];
        $user_bis_id = $this->checkLogin()->bis_id;
        $city_id_to_name = [];
        $cate_id_to_name = [];
        $shop_id_to_name = [];
        if (!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time'])>strtotime($data['start_time'])){
            $sdata['create_time'] = [
                ['gt', strtotime($data['start_time'])],
                ['lt', strtotime($data['end_time'])],
            ];
        }
        if(!empty($data['start_time']) && !empty($data['end_time'])){
            if (strtotime($data['end_time'])< strtotime($data['start_time'])) {
                $this->error("日期范围有误,请检查后重新输入...");
            }
        }
        if (!empty($data['city_id'])) {
            //二级城市
            $sdata['child_city_id'] = $data['city_id'];
        }
        if (!empty($data['category_id'])) {
            //一级分类
            $sdata['category_id'] = $data['category_id'];
        }

        if (!empty($data['name'])) {
            $sdata['name'] = ['like', '%'.$data['name'].'%'];
        }
        $sdata['bis_id'] = $user_bis_id;
        //搜索商品数据
        $searchGoods = $this->obj->getSearchGoods($sdata);
        //id转换成name
        foreach ($searchGoods as $goods) {
            $shop_id_to_name[$goods['shop']] = model('bis')->get(['id'=>$goods['shop']])['name'];
        }
//        print_r($searchGoods);exit();
        //获取一级分类
        $categorys = model('Category')->getCategorysByParentIdNoPager(0);
        //id 转换为name
//        print_r($categorys);exit();
        foreach ($categorys as $category) {
            $cate_id_to_name[$category->id] = $category->name;
        }
//        print_r($cate_id_to_name[31]);exit();
//        print_r($cate_id_to_name);exit();
        //获取二级城市
        $citys = model('City')->getChildCitys();
        //id 转换为name
        foreach ($citys as $city) {
            $city_id_to_name[$city->id] = $city->name;
        }
//        print_r($city_id_to_name);exit();
//        print_r($categorys);
//        print_r($citys);
//        die();
        return $this->fetch('',[
            'categorys' => $categorys,
            'citys' => $citys,
            'searchGoods' => $searchGoods,
            //搜索后保留搜索条件
            'category_id' => empty($data['category_id']) ? '' : $data['category_id'],
            'city_id' => empty($data['city_id']) ? '' : $data['city_id'],
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'name' => empty($data['name']) ? '' : $data['name'],
            'cate_id_to_name' => $cate_id_to_name,
            'city_id_to_name' => $city_id_to_name,
            'shop_id_to_name' => $shop_id_to_name,

        ]);
    }
    //添加团购商品
    public function add() {
        //商户id
        $bisId = $this->checkLogin()->bis_id;
//        print_r($bisId);
//        exit();
        //账户id
        $id = $this->checkLogin()->id;
        //判断是否是执行增加操作(方式是否为提交,不是则只显示添加页面)
        if(request()->isPost()) {
            $data = input('post.');
//            print_r($data['start_time']);exit();
            //添加商品默认城市为对应商店所在城市。
            $city_id = model('Bis')->get(['id'=>$data['shop']])['city_id'];
//            print_r($city_id);
            $child_city_id = model('Bis')->get(['id'=>$data['shop']])['child_city_id'];
//            print_r($child_city_id);
//            die();
            $goods = [
                'bis_id' => $bisId,
                'bis_account_id' => $id,
                'name' => $data['name'],
                'city_id' => $city_id,
                'child_city_id' => $child_city_id,
                'category_id' => $data['category_id'],
                'child_category_id'=> $data['child_category_id'] ? $data['child_category_id'] :'',
                'image' => $data['image'],
                'shop' => $data['shop'],
                'start_time' => strtotime($data['start_time']),
                'end_time' => strtotime($data['end_time']),
                'total_count' => $data['total_count'],
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'coupons_begin_time' => strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'description' => $data['description'],
                'notes' => $data['notes'],

            ];
            $res = model('Goods')->add($goods);
            if ($res) {
                $this->success("新增团购商品成功!",url('Goods/index'));
            } else {
                $this->error("新增团购商品失败!");
            }

        } else {
            // 获取一级城市的数据
            $citys = model('City')->getCitysByParentIdNoPager();
            // 获取一级菜单的数据
            $categorys = model('Category')->getCategorysByParentIdNoPager();
            //获取当前用户下的所有商店信息
            $shops = model('Bis')->getShopsByBisIdNoPager($bisId);
//        print_r($shops);
//        exit();
            return $this->fetch('',[
                'citys' => $citys,
                'categorys' => $categorys,
                'shops' => $shops,
            ]);
        }
    }
    //删除的申请,需要考虑是否是当前用户的
    public function dellist() {
           //当前登录账户
         $user_bis_id = $this->checkLogin()->bis_id;
         $goodsData = model('Goods')->getGoodsByStatusAndUser(-1, $user_bis_id);
//        print_r($goodsData);
             $shop_id_to_name = [];
             // 将商店id转成名称
             foreach ($goodsData as $good) {
                 $shop_id_to_name[$good->shop] = model('bis')->get(['id'=>$good['shop']])['name'];
             }
//        print_r($shop_id_to_name);die();
             return $this->fetch('',[
                 'goodsData'=>$goodsData,
                 'shop_id_to_name'=>$shop_id_to_name,
             ]);
         }

    //团购申请详情
    public function detail() {
        //获取穿过来的当前行信息的ID
        $id = input('get.id');
        //获取当前行的商品信息
        $goodsData = model('Goods')->get($id);
//        print_r($goodsData);die();
        $bisId = $goodsData['bis_id'];
        //获取商家账户中bis_id与当前获取的门店的bis_id相等的账户信息
        $bisAccountData = model('BisAccount')->get(['bis_id' => $goodsData['bis_id']]);
        // 获取所有城市的数据
        $citys = model('City')->getAllCitys();
        // 获取商品所属门店所在的信息[城市],在view中与所有城市对比,相同显示
        $city_id = model('Bis')->get(['id'=>$goodsData['shop']])['city_id'];
        $child_city_id = model('Bis')->get(['id'=>$goodsData['shop']])['child_city_id'];
        // 获取所有菜单的数据
        $categorys = model('Category')->getAllCategorys();
//        print_r($categorys);
//        die();
        // 将当前商店id转成名称
        $shop_id_to_name = model('bis')->get(['id'=>$goodsData['shop']])['name'];
        return $this->fetch('',[
            'goodsData' => $goodsData,
            'shop_id_to_name' => $shop_id_to_name,
            'citys' => $citys,
            'city_id' => $city_id,
            'child_city_id' =>  $child_city_id,
            'categorys' => $categorys,
            'bisAccountData' => $bisAccountData,
        ]);
    }
    //修改商品信息,重新提交审核
    public function alter()
    {
        //获取当前登录商户bis_id
        $bisId = $this->checkLogin()->bis_id;
        //获取当前编辑的店的id
        $id = input('get.id');
        $status = input('get.status');
        //print_r($id);die();
        $data = input('post.');
//            print_r($data['start_time']);exit();
        //添加商品默认城市为对应商店所在城市。
        $city_id = model('Bis')->get(['id' => $data['shop']])['city_id'];
//            print_r($city_id);
        $child_city_id = model('Bis')->get(['id' => $data['shop']])['child_city_id'];
//            print_r($child_city_id);
//            die();
        $goods = [
            'status' => $status,
            'bis_id' => $bisId,
            'bis_account_id' => $id,
            'name' => $data['name'],
            'city_id' => $city_id,
            'child_city_id' => $child_city_id,
            'category_id' => $data['category_id'],
            'child_category_id' => $data['child_category_id'] ? $data['child_category_id'] : '',
            'image' => $data['image'],
            'shop' => $data['shop'],
            'start_time' => strtotime($data['start_time']),
            'end_time' => strtotime($data['end_time']),
            'total_count' => $data['total_count'],
            'origin_price' => $data['origin_price'],
            'current_price' => $data['current_price'],
            'coupons_begin_time' => strtotime($data['coupons_begin_time']),
            'coupons_end_time' => strtotime($data['coupons_end_time']),
            'description' => $data['description'],
            'notes' => $data['notes'],

        ];
        $res = model('Goods')->alterGoodsById($goods,$id);
        if ($res) {
            $this->success("已修改成功并提交审核!", url('Goods/index'));
        } else {
            $this->error("重新提交失败!");
        }
    }
    //商户删除申请(可修改的申请页)
    public function destroy($id) {
        $res = model('Goods')->destroyGoodsByGoodsId($id);
        if ($res) {
            $this->success("申请已经删除");
        }else{
            $this->error("申请删除失败");
        }
    }
    //更新状态
    public function status() {
        $data = input('get.');
        $res = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        if($res==1 ) {
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }
    }
}
