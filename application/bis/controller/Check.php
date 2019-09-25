<?php
namespace app\bis\controller;
use think\Controller;
class Check extends Controller
{
    //用于各个管理功能的登录判断
    public function _initialize()
    {
        $res = $this->checkLogin();
        if ($res) {
            return true;
        }else {
            return $this->redirect(url('login/index'));
        }
    }
    public function checkLogin() {
        $account = session('BisAccount', '', 'bis');
        return $account;
    }
}
