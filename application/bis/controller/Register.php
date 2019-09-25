<?php
namespace app\bis\controller;
use think\Controller;
class Register extends Controller
{
    public function index() {
        // 获取一级城市的数据
        $citys = model('City')->getCitysByParentIdNoPager();
        // 获取一级菜单的数据
        $categorys = model('Category')->getCategorysByParentIdNoPager();
        return $this->fetch('',[
            'citys' => $citys,
            'categorys' => $categorys,
        ]);
    }
    //商户入驻申请
    public function add() {
        if(!request()->isPost()) {
            $this->error('请求错误');
        }
        //获取表单的值
        $data = input('post.');
//        print_r($data);
//        die();

        //tps5校验机制
        $validate = validate('Bis');
        if(!$validate->scene('add')->check($data)) {
//            $this->error($validate->getError());
        }
        // 总店相关信息校验
        // 商户相关信息校验

        // 判断账户信息是否存在
        $accountResult = model('BisAccount')->get(['username'=>$data['username']]);
        if($accountResult) {
            $this->error('该用户已存在');
            die();
        }

        //获取经纬度
        $lnglat = \Map::getLngLat($data['address']);
//        print_r($lnglat);
//        print_r($lnglat['status']);
//        die();
        if(empty($lnglat) || $lnglat['status'] !=0 || $lnglat['result']['precise'] !=1) {
            $this->error('无法获取数据，或者匹配的地址不精确');
        }
        // 商户基本信息入库
        $bisData = [
            'name' => $data['name'],
            'city_id' => $data['city_id'],
            'child_city_id' => $data['child_city_id'] ? $data['child_city_id'] : '',
            'logo' => $data['logo'],
            'licence_logo' => $data['licence_logo'],
            'description' => empty($data['description']) ? '' : $data['description'],
            'contractor' =>  $data['contractor'],
            'tel' =>  $data['tel'],
            'email' =>  $data['email'],
            'address' => $data['address'],
            'open_time' => $data['open_time'],
            'category_id' => $data['category_id'],
            'child_category_id' => $data['child_category_id'] ? $data['child_category_id'] :'',
            'xpoint' => empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
            'ypoint' => empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
        ];
//        print_r(model('Bis'));
//        die();
        $bisId = model('Bis')->add($bisData);
//        print_r($bisId);die();
//        $bisId = Model('Bis')->get('id',['cityid'=>$bisData['city_id']]);
        //初次申请,bisId = id;
        // 写入bisId
        model('Bis')->firstAdd_bisId($bisId);
        $accounData = [
            'bis_id' => $bisId,
            'username' => $data['username'],
            'password' => md5($data['password']),
        ];

        // 商户账户相关的信息检验
        // 商户账户信息入库
        $accountId = model('BisAccount')->add($accounData);
        if(!$accountId) {
            $this->error('申请失败');
            die();
        }

        // 发送邮件
        $url = request()->domain().url('bis/register/waiting', ['id'=>$bisId]);
        $title = "o2o入驻申请通知";
        $content = "您提交的入驻申请需等待平台方审核，请<a href='".$url."' target='_blank'>点击此链接</a> 查看审核状态";
        \phpmailer\Email::send($data['email'],$title, $content);
        $this->success("申请成功,申请进度请留意邮件...",url('bis/login/index'));
    }
    public function waiting($id) {
        if(empty($id)) {
            $this->error('error');
        }
        $detail = model('Bis')->get($id);

        return $this->fetch('',[
            'detail' => $detail,
        ]);
    }
}