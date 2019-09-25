<?php

namespace app\index\controller;
use think\Controller;
class User extends Base
{
    // 测试->若再次设置初始化函数会出错,应为Base里设置了加载城市和用户的初始化函数,
    //此处如果再次初始化,则会重写该函数,导致数据的丢失。
    public function login() {
        //判断是否为提交方式
        if (request()->isPost()) {
            $data = input('post.');
//            print_r($data);
            $validate = validate('Login');
            if(!$validate->scene('Login')->check($data)) {
                $this->error($validate->getError());
            }
            //tp5自带验证码校验方法
//             $verifyResult = captcha_check($data['verify_code']);
// //            print_r($verifyResult);exit();
//             if (!$verifyResult) {
//                 $this->error('验证码输入有误');
//             }
            $data['password'] = md5($data['password']);
            $user = model('User')->getUserByUserName($data['username']);
//            print_r($user['password']);die();
            if ($user) {
                if($user['password'] == $data['password']) {
                    //更新最后登录时间
                  $res = model('User')->updateById(['update_time'=>time()],$user['id']);
//                    print_r($res);exit();
                    session('user', $user, 'o2o');

                    //判断是否是浏览商品后跳转过来的登录页,我设置了浏览的商品id(goodsId)
                    if(!empty($data['goodsId'])) {
                        $goodsId = $data['goodsId'];
                        return $this->success("登录成功", url('detail/index',['id'=>$goodsId]));
                    }
                    return $this->success("登录成功", url('index/index'));
                } else {
                   $this->error("密码不正确");
                }
            } else {
                $this->error("用户名不存在");
            }

        } else {
            //判断是否已经登录
            $account = session('User','','o2o');
//            print_r($account);exit();
            if($account) {
                $this->redirect(url('index/index'));
            }
            return $this->fetch('',[
                'controller'=> 'login',
                'title'=> '乐购网-登录',
            ]);
        }
    }
    public function register() {
        //判断是否为提交方式
        if (request()->isPost()) {
            $data = input('post.');
//            print_r($data);
            $validate = validate('Register');
            if(!$validate->scene('register')->check($data)) {
                $this->error($validate->getError());
            }
            if($data['password'] != $data['re_password']) {
                $this->error('两次输入的密码不一致');
            }
            //tp5自带验证码校验方法
            $verifyResult = captcha_check($data['verify_code']);
            if (!$verifyResult) {
                $this->error('验证码输入有误');
            }
            $data['password'] = md5($data['password']);
            $res = model('User')->add($data);
            if ($res) {
                $this->success("注册成功,正在跳转至登录页面...",url('user/login'));
            } else {
                $this->error("注册失败");
            }

        } else {
            return $this->fetch('',[
                'controller'=> 'register',
                'title'=> '乐购网-会员注册'
            ]);
        }
    }

    public function logout() {
        //清楚session(置空, 作用域)
        session(null, 'o2o');
        //重定向
        $this->redirect(url('index/index'));
    }
}
