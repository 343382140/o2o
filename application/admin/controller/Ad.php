<?php


namespace app\admin\controller;

use think\Controller;
class Ad extends Controller
{
    private $obj;
    public function _initialize()
    {
        $this->obj = model('Ad');
    }

    public function index() {
        $bis_id_to_name = [];
        $ads = $this->obj->getAdByStatus(1);
//        print_r($res[0]['bis_id']);
//        die();
        foreach ($ads as $ad){
            $bis_id_to_name[$ad['bis_id']] = model('BisAccount')->get(['bis_id'=>$ad['bis_id']])['username'];
        }
        return $this->fetch('',[
            'ad'=>$ads,
            'bis_id_to_name' => $bis_id_to_name,
        ]);
    }
    public function add(){
        if (request()->isPost()) {
            //入库
            $data=input('post.');
            //数据需要做严格校验 validate 自行完成
            
            $id=$this->obj->add($data);
            if ($id) {
               $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            //获取推荐位类别
            $adType=config('ad.ad_type');
            return $this->fetch('',[
                    'adType' => $adType,
            ]);
        }
    }
    // 广告位申请审核
    public function apply() {
        $bis_id_to_name = [];
        $ads = $this->obj->getAdByStatus();
//        print_r($res[0]['bis_id']);
//        die();
        foreach ($ads as $ad){
            $bis_id_to_name[$ad['bis_id']] = model('BisAccount')->get(['bis_id'=>$ad['bis_id']])['username'];
        }
        return $this->fetch('',[
            'ad'=>$ads,
            'bis_id_to_name' => $bis_id_to_name,
        ]);
    }
    // 修改广告状态(发布状态(正常、待审、删除))
    public function status() {
        $data = input('get.');
        $res = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
        if($res) {
            $this->success('状态更新成功');
        }else {
            $this->error('状态更新失败');
        }
    }
    //获取删除的(status-1)广告位,bis-ad-dellist
    public function dellist() {
        $bis_id_to_name = [];
        $ads = $this->obj->getAdByStatus(-1);
//        print_r($res[0]['bis_id']);
//        die();
        foreach ($ads as $ad){
            $bis_id_to_name[$ad['bis_id']] = model('BisAccount')->get(['bis_id'=>$ad['bis_id']])['username'];
        }
        return $this->fetch('',[
            'ad'=>$ads,
            'bis_id_to_name' => $bis_id_to_name,
        ]);
    }
    //商户删除广告申请(可重新申请的广告位页)
    public function destroy($id) {
        $res = model('Ad')->destroyAdById($id);
        if ($res) {
            $this->success("申请已经删除");
        }else{
            $this->error("申请删除失败");
        }
    }
}