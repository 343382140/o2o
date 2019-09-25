<?php
namespace app\bis\controller;
use think\Controller;
class Login extends Controller
{
    public function index() {
        // 判断方式是否为提交方式,如果为提交,则处理登录逻辑,否则只是转到登录页面
        if(request()->isPost()) {
            //获取输入数据
            $data = input('post.');
//            print_r($data);
//            die();
             //判断数据库是否存在输入用户
            $res = model('BisAccount')->get(['username'=>$data['username']]);
//            print_r($res);exit();
            if($res && $res['status']==1) {
                if(md5($data['password']) != $res['password']) {
                    $this->error("密码错误");
                }
                //更新最后登录时间
                model('BisAccount')->updateById(['update_time'=>time()],$res['id']);
                //将登录用户保存到session(名称, 值, 作用域)
                session('BisAccount', $res, 'bis');
               return $this->success("登录成功!正在跳转...", url('index/index'));
            } else{
                $this->error("用户不存在,或未通过审核!");
            }
        }else{
            //判断是否已经登录
            $account = session('BisAccount','','bis');
//            print_r($account);exit();
            if($account) {
                $this->redirect(url('index/index'));
            }
            return $this->fetch();
        }
    }
    public function logout() {
        //清楚session(置空, 作用域)
        session(null, 'bis');
        //重定向
        $this->redirect(url('login/index'));
    }
}