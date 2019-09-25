<?php

namespace app\admin\controller;
use think\Controller;
use think\Url;
use think\Validate;

class City extends Controller
{
    private $obj;
    // 调用model(代码优化)
    public function _initialize()
    {
        $this->obj = model('City');
    }

    public function index()
    {
        $parentId = input('get.parent_id', 0, 'intval');
        // 根据parentId 获取分类,默认parentId为0,即获取一级分类
        $citys = $this->obj->getCitysByParentId($parentId);
//        print_r($citys);exit();
        //查找view中City下的index模板
        return $this->fetch('',[
            'citys' => $citys,
        ]);
    }
    // 添加城市页面以及城市获取
    public function add() {
        //获取一级城市
        $citys = $this->obj->getCitysByParentIdNoPager();
        //查找view中category下的add模板并传递categorys的值
        return $this->fetch('',[
            'citys' => $citys,
        ]);
    }
    //新增城市
    public function saveCity() {
        if(!request()->isPost()) {
            $this->error("请求失败");
        }
        $data = input('post.');
        //tp5 验证机制
        //判断是否是编辑功能提交过来的数据,若是,则更新对应id的信息即可
        if(!empty($data['id'])) {
            return $this->update($data);
        }
        //把$data提交到model层
        $res = $this->obj->add($data);
        if($res) {
            $this->success("新增分类成功");
        } else {
            $this->error("新增分类失败");
        }
    }
    //编辑分类
    //编辑分类
    public function edit($id = 0) {
        if(intval($id) < 1) {
            $this->error("参数错误");
        }
        //获取当前编辑的城市的信息
        $city = $this->obj->get($id);
        //获取一级城市
        $citys = $this->obj->getCitysByParentIdNoPager();
        //查找view中category下的index模板
        return $this->fetch('',[
            'citys' => $citys,
            'city' => $city,
        ]);
    }
    //更新城市信息
    public function update($data) {
//        print_r($data);//Array ( [id] => 17 [name] => 霞山 [parent_id] => 14 )
//        exit();
        //save(data, 条件)
        $res = $this->obj->save($data, ['id'=> $data['id']]);
        if($res) {
            $this->success("更新成功");
        } else {
            $this->error("更新失败");
        }
    }
    //城市删除
    public function status() {
        $data = input('get.');
//        print_r($data);die();
        //校验数据,tp5 validate验证机制
        //修改
        $res = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        if($res) {
//            printf(url());
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }
    }
    //城市排序
    public function listorder($id, $listorder) {
            $res = $this->obj->save(['listorder'=>$listorder], ['id'=>$id]);
            if($res) {
                $this->result($_SERVER['HTTP_REFERER'], 1, 'success');
            }else {
                $this->result($_SERVER['HTTP_REFERER'], 0, '更新失败');
            }
    }

    public function delcitys()
    {
        //$parentId=input('get.parent_id', 0 ,'intval');
        $citys=$this->obj->getDelFirstCitysByParentId();
        //dump($citys);exit;
        return $this->fetch('',['citys'=>$citys,]);
    }
}








