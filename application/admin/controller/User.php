<?php

namespace app\admin\controller;

use think\Controller;

class User extends Controller
{
    private $obj;
    // 调用model(代码优化)
    public function _initialize()
    {
        $this->obj = model('User');
    }
    
    public function index(){
    	$data=input('get.');
    	//print_r($data);exit;
    	$datas=[];
    	if (!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time']) >= strtotime($data['start_time'])) {
			$datas['create_time']=[
				['egt',strtotime($data['start_time'])],
				['elt',strtotime($data['end_time'])],
			];
		}
		if (!empty($data['name'])) {
			$datas['username']=['like','%'.$data['name'].'%'];
		}
		//print_r($datas);exit;
    	$users=$this->obj->getUserById($datas);
    	//dump($users);exit;
        return $this->fetch('',[
        	'users'=>$users,
        	'name'=>empty($data['name']) ? '' : $data['name'],
        	'start_time'=>empty($data['start_time']) ? '' : $data['start_time'],
        	'end_time'=>empty($data['end_time']) ? '' : $data['end_time'],
        ]);
	}
	
	public function bisuser(){
		$data=input('get.');
    	//print_r($data);exit;
    	$datas=[];
    	if (!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time']) >= strtotime($data['start_time'])) {
			$datas['create_time']=[
				['egt',strtotime($data['start_time'])],
				['elt',strtotime($data['end_time'])],
			];
		}
		if (!empty($data['name'])) {
			$datas['username']=['like','%'.$data['name'].'%'];
		}
		//print_r($datas);exit;
    	$users=model('BisAccount')->getNormalBisUserById($datas);
    	//dump($users);exit;
        return $this->fetch('',[
        	'users'=>$users,
        	'name'=>empty($data['name']) ? '' : $data['name'],
        	'start_time'=>empty($data['start_time']) ? '' : $data['start_time'],
        	'end_time'=>empty($data['end_time']) ? '' : $data['end_time'],
        ]);
	}

	public function member_add(){
		if (request()->isPost()) {
				//获取表单的值
			$data = input('post.');
			//基本信息校验数据
			//print_r($data);exit;
			// $validate = validate('Bis');
			// if (!$validate->scene('add')->check($data)) {
			// 	//$this->error($validate->getError());
			// }

			//判断提交的用户是否存在
			$accountResult=Model('User')->get(['username'=>$data['username']]);
			if ($accountResult) {
				$this->error('该用户已存在，请重新分配');
			}


			//账户相关信息校验
			//自动生成密码加严字符串
			$data['code'] = mt_rand(100,10000);
			$user=[
				'username'=>$data['username'],
				'code'=>$data['code'],
				'password'=>md5($data['password'].$data['code']),
				'mobile'=>$data['mobile'],
				'email'=>$data['email'],
			];

			$normalUser=model('User')->normalAdd($user);
			if ($normalUser) {
				$this->success('添加成功');
			}
		}
		
		return $this->fetch();
	}

	//获取编辑用户
    public function member_edit($id = 0) {
        if(intval($id) < 1) {
            $this->error("参数错误");
        }
        //获取当前编辑用户的信息
        $users = $this->obj->get($id);
        //查找view中category下的index模板
        return $this->fetch('',[
            'users' => $users,
        ]);
    }

    //更新用户
    public function member_update($id = 0){
		if (request()->isPost()) {
				//获取表单的值
			$data = input('post.');
			//基本信息校验数据
			//print_r($data);exit;
			// $validate = validate('Bis');
			// if (!$validate->scene('add')->check($data)) {
			// 	//$this->error($validate->getError());
			// }

			//判断提交的用户是否存在
			$accountResult=Model('User')->get(['username'=>$data['username']]);
			if ($accountResult) {
				$this->error('该用户已存在，请重新分配');
			}


			//账户相关信息校验
			//自动生成密码加严字符串
			//$data['code'] = mt_rand(100,10000);
			// dump($id);exit;
			// $id = $data->id;
			$user=[
				'username'=>$data['username'],
				//'code'=>$data['code'],
				//'password'=>md5($data['password']),
				'email'=>$data['email'],
			];

			$res = model('User')->updateById($user, $id);
			//$normalUser=model('User')->normalAdd($user);
			if ($res) {
				$this->success('修改成功');
			}else{
				$this->success('修改失败');
			}
		}
		
		return $this->fetch();
	}

	//获取编辑用户
    public function member_resetpwd($id = 0) {
        if(intval($id) < 1) {
            $this->error("参数错误");
        }
        //获取当前编辑用户的信息
        $users = $this->obj->get($id);
        //查找view中category下的index模板
        return $this->fetch('',[
            'users' => $users,
        ]);
    }

	//更新密码
    public function resetpassword($id = 0){
		if (request()->isPost()) {
				//获取表单的值
			$data = input('post.');
			//基本信息校验数据
			//print_r($data);exit;
			// $validate = validate('Bis');
			// if (!$validate->scene('add')->check($data)) {
			// 	//$this->error($validate->getError());
			// }

			//账户相关信息校验
			//自动生成密码加严字符串
			//$data['code'] = mt_rand(100,10000);
			// dump($id);exit;
			// $id = $data->id;
			$user=[
				//'code'=>$data['code'],
				'password'=>md5($data['password']),
			];

			$res = model('User')->updateById($user, $id);
			//$normalUser=model('User')->normalAdd($user);
			if ($res) {
				$this->success('修改成功');
			}else{
				$this->success('修改失败');
			}
		}
		
		return $this->fetch();
	}

	public function datadel($delId){

		//$res=model('BisAccount')->deleteId($delId);

		$result = UserModel::destroy($delId);
		if ($result) {
			return $this->success('删除成功');
		} else {
			return $this->error('删除的用户不存在');
		}
	    
	}

	public function datadelbis($delId){

		//$res=model('BisAccount')->deleteId($delId);

		$result = BisUserModel::destroy($delId);
		if ($result) {
			return $this->success('删除成功');
		} else {
			return $this->error('删除的用户不存在');
		}
	    
	}

	public function deluser(){
		$data=input('get.');
    	//print_r($data);exit;
    	$datas=[];
    	if (!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time']) >= strtotime($data['start_time'])) {
			$datas['create_time']=[
				['egt',strtotime($data['start_time'])],
				['elt',strtotime($data['end_time'])],
			];
		}
		if (!empty($data['name'])) {
			$datas['username']=['like','%'.$data['name'].'%'];
		}
		//print_r($datas);exit;
    	$users=$this->obj->getDelUserById($datas);
    	//dump($users);exit;
        return $this->fetch('',[
        	'users'=>$users,
        	'name'=>empty($data['name']) ? '' : $data['name'],
        	'start_time'=>empty($data['start_time']) ? '' : $data['start_time'],
        	'end_time'=>empty($data['end_time']) ? '' : $data['end_time'],
        ]);
	}

	//修改状态
	public function status(){
		//print_r(input('get.'));
		$data=input('get.');
		//校验
		/*$validate=validate('Bis');
		if(!$validate->scene('status')->check($data)){
			$this->error($validate->getError());
		}*/

		$res =$this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);
		if ($res) {
			//发送邮件
			//status 1 status 2 status -1
			//\phpmailer\Email::send($data['email'],$title,$content);
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
}
