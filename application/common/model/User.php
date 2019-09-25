<?php


namespace app\common\model;
use think\Model;

class User extends Model
{
    public function add($data=[]){
        //如果提交的数据不是数组
        if (!is_array($data)) {
            exception('传递的数据不是数组');
        }

        $data['status'] = 1;
        return $this->data($data)->allowField(true)
            ->save();
    }


    /**
     * 根据用户名获取用户信息
     * @param  [type] $username [description]
     * @return [type]           [description]
     */
    public function getUserByUsername($username){
        if (!$username) {
            exception('用户名不合法');
        }

        $data=['username'=>$username];
        return $this->where($data)->find();
    }

    public function getUserById($data=[]){
        //$data['status']=1;
        $order=['id'=>'desc'];
        $result=$this->where($data)
                ->order($order)
                ->paginate(5);
                
        //echo $this->getLastSql();
        return $result;
    }

    public function updateById($data, $id) {
//        print_r($data);
//        print_r($id);
//        die();
        //save(数据, 条件 )
        $res = $this->allowField(true)->save($data, ['id'=>$id]);
//        print_r($this->getLastSql());exit();
        return $res;
    }

    public function getDelUserById($data=[]){
        $data['status']=-1;
        $order=['id'=>'desc'];
        $result=$this->where($data)
                ->order($order)
                ->paginate(2);
                
        //echo $this->getLastSql();
        return $result;
    }
}