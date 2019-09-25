<?php
namespace app\bis\controller;
use think\Controller;
class Shop extends Check
{
    //商家门店列表页
    public function index(){
        //从session中获取当前登录商家的bis_id select xxx from bis where bis_id = $bis_id;
       $bis_id = session('BisAccount', '', 'bis')->bis_id;
//        print_r($bis_id);die();
        $res = model('Bis')->getShopsByBisId($bis_id);
//        print_r($res);die();
       return $this->fetch('',[
           'shops' => $res,
       ]);
    }
    public function add() {
        if (request()->isPost()) {
            //新增门店操作
            $data = input('post.');
//            print_r($data);
//            exit();
            $bisId = $this->checkLogin()->bis_id;
//            print_r($bisId);
//            exit();
            //获取经纬度
            $lnglat = \Map::getLngLat($data['address']);

//        print_r($lnglat);
//        print_r($lnglat['status']);
//        die();
            if(empty($lnglat)) {
                $this->error('无法获取数据，或者匹配的地址不精确');
            }
            $shopData = [
                'bis_id' =>$bisId,
                'name' => $data['name'],
                'licence_logo' =>$data['licence_logo'],
                'email' => $data['email'],
                'city_id' => $data['city_id'],
                'child_city_id' => $data['child_city_id'] ? $data['child_city_id'] : '',
                'logo' => $data['logo'],
                'description' => empty($data['description']) ? '' : $data['description'],
                'contractor' =>  $data['contractor'],
                'tel' =>  $data['tel'],
                'address' => $data['address'],
                'open_time' => $data['open_time'],
                'category_id' => $data['category_id'],
                'child_category_id' => $data['child_category_id'] ? $data['child_category_id'] :'',
                'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
                'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
            ];
//            print_r($shopData);
//            exit();
//        print_r(model('Bis'));
//        die();
            $result = model('Bis')->add($shopData);
//        print_r($bisId);die();
            if($result) {
                $this->success("新增申请提交成功",url('shop/index'));
            }else {
                $this->error("新增申请提交失败");
            }


        }else {
            // 获取一级城市的数据
            $citys = model('City')->getCitysByParentIdNoPager();
            // 获取一级菜单的数据
            $categorys = model('Category')->getCategorysByParentIdNoPager();
            return $this->fetch('',[
                'citys' => $citys,
                'categorys' => $categorys,
            ]);
        }
    }

    //门店详细信息
    public function detail() {
        //获取穿过来的当前行信息的ID
        $id = input('get.id');
        //根据id获取商家信息以及商家账户信息
        $shopData = model('Bis')->get($id);
//        print_r($bisData);
        $bisAccountData = model('BisAccount')->get(['bis_id' => $id]);
//        print_r($bisAccountData);
//        die();
        // 获取所有城市的数据
        $citys = model('City')->getAllCitys();
//        print_r($citys);
//        die();
        // 获取所有菜单的数据
        $categorys = model('Category')->getAllCategorys();
//        print_r($categorys);
//        die();
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys,
            'shopData' => $shopData,
            'bisAccountData' => $bisAccountData,
        ]);
    }
    public function alter() {
        //获取当前编辑的店的id
        $id = input('get.id');
        //print_r($id);die();
        $data = input('post.');
        //修改后,店状态需要重新审核
        $shopStatus = 0;
//        print_r($data);die();
        $shopData = [
            'status' => $shopStatus,
            'name' => $data['name'],
            'licence_logo' =>$data['licence_logo'],
            'email' => $data['email'],
            'city_id' => $data['city_id'],
            'child_city_id' => $data['child_city_id'] ? $data['child_city_id'] : '',
            'logo' => $data['logo'],
            'description' => empty($data['description']) ? '' : $data['description'],
            'contractor' =>  $data['contractor'],
            'tel' =>  $data['tel'],
            'address' => $data['address'],
            'open_time' => $data['open_time'],
            'category_id' => $data['category_id'],
            'child_category_id' => $data['child_category_id'] ? $data['child_category_id'] :'',
        ];
//        print_r($shopData);exit();
        $res = model('Bis')->alterShopDataById($shopData, $id);
        if ($res) {
            $this->success("信息修改成功",url('shop/index'));
        }else {
            $this->error("修改失败",url('shop/detail'));
        }
    }
    public function status() {
            $data = input('get.');
            //修改
            //save([修改项],[条件]);
            $res = model('Bis')->save(['status'=>$data['status']],['id'=>$data['id']]);
            if ($res) {
                $this->success("状态更新成功");
            }else{
                $this->error("状态更新失败");
            }
    }
    //彻底删除商店信息
    public function destroy(){
        $id = input('get.id');
        $res = model('Bis')->destroyBis($id);
        if ($res) {
            $this->success('该门店及门店下所有商品已经彻底删除!','shop/index');
        }
    }
    //删除的门店,需要考虑以及删除的是否是当前用户的
    public function dellist() {
        //当前用户的商户id
        $user_bis_id = session('BisAccount', '', 'bis')->bis_id;
        $res = model('Bis')->getBisByStatusAndUser(-1,$user_bis_id);
        return $this->fetch('', [
            'bis'=>$res,
        ]);
    }
}
