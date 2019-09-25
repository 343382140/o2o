<?php
namespace app\admin\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
//    public function map() {
//        //经纬度获取方法测试
////       print_r(\Map::getLngLat('北京天安门广场'));
////        die();
//        //百度地图静态图获取测试
//        return \Map::getStaticImage('北京天安门广场');
//    }
//    public function testEmail() {
//        \phpmailer\Email::send('935298247@qq.com','Test','邮件接口测试成功');
//        return "邮件发送成功";
////        return $this->fetch();
//    }
    public function test() {
        return "后台主页";
    }
}
