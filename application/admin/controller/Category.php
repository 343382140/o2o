<?php
namespace app\admin\controller;
use think\Controller;
use think\Url;
use think\Validate;

class Category extends Controller
{
    private $obj;
    // 调用model(代码优化)
    public function _initialize()
    {
        $this->obj = model('Category');
    }

    public function index()
    {
        $parentId = input('get.parent_id', 0, 'intval');
        // 根据parentId 获取分类,默认parentId为0,即获取一级分类
        $categorys = $this->obj->getCategorysByParentId($parentId);
        //查找view中category下的index模板
        return $this->fetch('',[
            'categorys' => $categorys,
        ]);
    }
    public function add() {
        $categorys = $this->obj->getCategorysByParentIdNoPager();
        //查找view中category下的add模板并传递categorys的值
        return $this->fetch('',[
            'categorys' => $categorys,
        ]);
    }
    public function saveCategory() {
        //原生
//        print_r($_POST);
        //tp5
//        print_r(input('post.'));
        //tp5
//        print_r(request()->post());
        // 判断是否为post
        if(!request()->isPost()) {
            $this->error("请求失败");
        }
        //数据校验,tp5 validate验证机制
        $data = input('post.');
//        print_r($data);die();
        $validate = validate('Category');
        if(!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
        }
        //判断是否是编辑功能提交过来的数据
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
    public function edit($id = 0) {
        if(intval($id) < 1) {
            $this->error("参数错误");
        }
        //获取当前编辑城市的信息
        $category = $this->obj->get($id);
        //获取所有一级分类
        $categorys = $this->obj->getCategorysByParentIdNoPager(0);
        //查找view中category下的index模板
        return $this->fetch('',[
            'categorys' => $categorys,
            'category' => $category,
        ]);
    }

    public function update($data) {
        $res = $this->obj->save($data, ['id'=>intval($data['id'])]);
        if($res) {
            $this->success("更新成功");
        } else {
          $this->error("更新失败");
        }
    }
    // 排序
    public function listorder($id, $listorder) {
        $res = $this->obj->save(['listorder'=>$listorder], ['id'=>$id]);
        if($res) {
            $this->result($_SERVER['HTTP_REFERER'], 1, 'success');
        }else {
            $this->result($_SERVER['HTTP_REFERER'], 0, '更新失败');
        }
    }
    // 修改分类状态(发布状态(正常、待审、删除))
    public function status() {
        $data = input('get.');
//        print_r($data);die();
        //校验数据,tp5 validate验证机制
        $validate = validate('Category');
        if(!$validate->scene('status')->check($data)) {
            $this->error($validate->getError());
        }
        //修改
        $res = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        if($res) {
//            printf(url());
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }
    }
    // 获取删除分类列表
    public function dellist() {
        $res = $this->obj->getCategorysByStatus(-1);
        return $this->fetch('', [
            'categorys' =>$res,
        ]);
    }
    //彻底删除分类
    public function destroy(){
        $id = input('get.id');
        $res = $this->obj->destroyCategory($id);
        if ($res) {
            $this->success('该分类已彻底从数据库中删除!','category/dellist');
        }
    }

}
