<?php
namespace app\comapi\controller;
use think\Controller;
class City extends Controller
{
    private $obj;
    public function _initialize()
    {
        $this->obj = model("City");
    }
    // register,处理ajax抛送,register页
    public function getCitysByParentIdNoPager() {
        $id = input("post.id");
//        print_r($id);exit();
        if(!$id) {
            $this->error("id不在合法范围");
        }
        //通过id获取二级城市(二级城市的parent_id)
        $citys = $this->obj->getCitysByParentIdNoPager($id);
        if(!$citys) {
            return show(0,'不存在子城市','');
        }
        return show(1, 'success', $citys);
    }
}