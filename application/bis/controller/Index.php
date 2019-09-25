<?php
namespace app\bis\controller;
use think\Controller;
class Index extends Check
{
    public function index()
    {
        $loginUser = session('BisAccount','','bis')['username'];
//        print_r($loginUser);
//        exit();
        return $this->fetch('',[
            'loginUser'=>$loginUser,
        ]);
    }
}
