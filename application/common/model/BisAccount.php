<?php
namespace app\common\model;

use think\Model;

class BisAccount extends Model
{
    //商户账户信息
    public function add($data) {
//        $data['status'] = 0;//数据库中已设置默认值为0
        //可在配置文件中直接配置是否自动写入时间戳字段
//        $data['create_time'] = time();
        $this->save($data);
        print_r($this->getLastSql());
        die();
//        return $this->id;
    }
    public function updateById($data, $id) {
       return $this->allowField(true)->save($data, ['id'=>$id]);
    }

    public function getNormalBisUserById($data=[],$bisId=''){
        if ($bisId) {
            $data['bis_id']=$bisId;
        }else{
            //$data['is_main']=1;
        }
        $order=['id'=>'desc'];
        $result=$this->where($data)
                ->order($order)
                ->paginate(5);
                
        //echo $this->getLastSql();
        return $result;
    }
}