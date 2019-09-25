<?php


namespace app\index\controller;

use think\Controller;
class Threed extends Base
{
    public function index() {
    	//dump('asd');exit;
        //获取3d推荐位信息
        $threedAd = model('Ad')->getAdByStatusTypeLimit(1, 2, 12);
        //print_r($threedAd);die();
//        print_r($threedAd[0]);die();
        return $this->fetch('', [
            'threedAd' => $threedAd,
        ]);
    }
}