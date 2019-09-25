<?php
namespace app\admin\controller;
use think\Controller;

class Goods extends Controller
{
    private $obj;
    // 调用model(代码优化)
    public function _initialize()
    {
        $this->obj = model('Goods');
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = input('get.');
//        print_r($data);exit();
        $sdata = [];
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
        //获取删除时,传入status =-1;直接通过url传值
        if (!empty($data['status'])) {
            $sdata['status'] = $data['status'];
//            print_r($sdata['status']);exit();
        }else{
            $sdata['status'] = 1;
        }

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
        foreach ($categorys as $category) {
            $cate_id_to_name[$category->id] = $category->name;
        }

//        print_r($cate_id_to_name);exit();
        //获取二级城市
        $citys = model('City')->getChildCitys();
        //id 转换为name
        foreach ($citys as $city) {
            $city_id_to_name[$city->id] = $city->name;
        }

//        print_r($city_id_to_name);exit();
//        print_r($shop_id_to_name);exit();
//        print_r($categorys);
//        print_r($citys);
//        die();
        return $this->fetch('',[
            'categorys' => $categorys,
            'citys' => $citys,
            'searchGoods' => $searchGoods,
            'cate_id_to_name' => $cate_id_to_name,
            'city_id_to_name' => $city_id_to_name,
            'shop_id_to_name' => $shop_id_to_name,
            //搜索后保留搜索条件
            'category_id' => empty($data['category_id']) ? '' : $data['category_id'],
            'city_id' => empty($data['city_id']) ? '' : $data['city_id'],
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'name' => empty($data['name']) ? '' : $data['name'],

     ]);
    }
    // 团购发布申请
    // 入驻申请列表
    public function apply() {
        $goodsData = $this->obj->getGoodsByStatus();
//        print_r($res);
//        die();
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
    //审核团购申请
    public function status() {
        $data = input('get.');
        $res = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        if($res==1 ) {
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }
    }
    //团购申请详情
    public function detail() {
        //获取穿过来的当前行信息的ID
        $id = input('get.id');
        //获取当前行的商品信息
        $goodsData = $this->obj->get($id);
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
    //直接删除申请(商品申请页)
    public function destroy($id) {
        $res = model('Goods')->destroyGoodsByGoodsId($id);
        if ($res) {
            $this->success("彻底删除成功");
        }else{
            $this->error("彻底删除失败");
        }

    }
    //获取删除的商品
        public function dellist() {
            $shop_id_to_name = [];
            $goods = $this->obj->getGoodsByStatus(-1);
            foreach ($goods as $good) {
                $shop_id_to_name[$good['shop']] = model('bis')->get(['id'=>$good['shop']])['name'];
            }
//        print_r($searchGoods);exit();
            //获取一级分类
            $categorys = model('Category')->getCategorysByParentId(0);
            //id 转换为name
            foreach ($categorys as $category) {
                $cate_id_to_name[$category->id] = $category->name;
            }
//        print_r($cate_id_to_name[14]);exit();
//        print_r($cate_id_to_name);exit();
            //获取二级城市
            $citys = model('City')->getChildCitys();
            //id 转换为name
            foreach ($citys as $city) {
                $city_id_to_name[$city->id] = $city->name;
            }
            return $this->fetch('', [
                'categorys' => $categorys,
                'citys' => $citys,
                'goods' => $goods,
                'cate_id_to_name' => $cate_id_to_name,
                'city_id_to_name' => $city_id_to_name,
                'shop_id_to_name' => $shop_id_to_name,
            ]);
        }
}
