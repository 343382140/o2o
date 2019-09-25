<?php
namespace app\comapi\controller;
use think\Controller;
class Category extends Controller
{
    private $obj;
    public function _initialize()
    {
        $this->obj = model("Category");
    }
    // register,处理ajax抛送
    public function getCategorysByParentIdNoPager() {
        $id = input("post.id");
        if(!intval($id)) {
            $this->error("id不在合法范围");
        }
        //通过id获取二级城市(二级城市的parent_id)商家register
        $categorys = $this->obj->getCategorysByParentIdNoPager($id);
        if(!$categorys) {
            return show(0,'不存在二级分类');
        }
        return show(1, 'success', $categorys);
    }
}